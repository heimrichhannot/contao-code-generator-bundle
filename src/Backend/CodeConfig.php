<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

namespace HeimrichHannot\CodeGeneratorBundle\Backend;

use Contao\Database;
use Contao\DataContainer;
use Contao\Input;
use Contao\StringUtil;
use Contao\System;
use HeimrichHannot\UtilsBundle\Security\CodeUtil;

class CodeConfig
{
    public function generateBackendModule()
    {
        $codeUtil = System::getContainer()->get('huh.utils.code');
        $manager  = System::getContainer()->get('huh.code_generator.manager.code_config_manager');

        if (($count = Input::get('count')) && ($codeConfig = $manager->findByPk(Input::get('id'))) !== null)
        {
            $alphabets = StringUtil::deserialize($codeConfig->alphabets, true);
            $rules     = StringUtil::deserialize($codeConfig->rules, true);
            $codes     = [];

            for ($i = 0; $i < $count; $i++)
            {
                $code = $codeUtil->generate(
                    $codeConfig->length,
                    $codeConfig->preventAmbiguous,
                    $alphabets,
                    $rules,
                    $codeConfig->allowedSpecialChars
                );

                if ($codeConfig->preventDoubleCodes)
                {
                    $found = false;

                    if ($codeConfig->doubleCodeTable && $codeConfig->doubleCodeTableField)
                    {
                        $found = $this->findCodeInTable($code, $codeConfig->doubleCodeTable, $codeConfig->doubleCodeTableField);
                    }

                    while (in_array($code, $codes) || $found)
                    {
                        $code = $codeUtil->generate(
                            $codeConfig->length,
                            $codeConfig->preventAmbiguous,
                            $alphabets,
                            $rules,
                            $codeConfig->allowedSpecialChars
                        );

                        $found = false;

                        if ($codeConfig->doubleCodeTable && $codeConfig->doubleCodeTableField)
                        {
                            $found = static::findCodeInTable($code, $codeConfig->doubleCodeTable, $codeConfig->doubleCodeTableField);
                        }
                    }
                }

                $codes[] = $code;
            }

            System::getContainer()->get('huh.utils.file')->sendTextAsFileToBrowser(
                implode("\n", $codes),
                'codes_' . date('Y-m-d-H-i') . '.txt'
            );
        }
    }

    public function findCodeInTable(string $code, string $table, string $field)
    {
        return Database::getInstance()->prepare("SELECT $field FROM $table WHERE $field=?")->execute($code)->numRows > 0;
    }

    public function getRulesAsOptions(DataContainer $dc)
    {
        $ruleOptions = [];
        $manager     = System::getContainer()->get('huh.code_generator.manager.code_config_manager');

        if (($codeConfig = $manager->findByPk($dc->id)) !== null)
        {
            $alphabets = StringUtil::deserialize($codeConfig->alphabets, true);
            $types     = [
                CodeUtil::CAPITAL_LETTERS,
                CodeUtil::SMALL_LETTERS,
                CodeUtil::NUMBERS,
                CodeUtil::SPECIAL_CHARS
            ];

            foreach ($types as $type)
            {
                if (in_array($type, $alphabets))
                {
                    $ruleOptions[] = $type;
                }
            }
        }

        return $ruleOptions;
    }

    public function modifyPalette()
    {
        $codeConfig = System::getContainer()->get('huh.code_generator.manager.code_config_manager')->findByPk(Input::get('id'));
        $dca        = &$GLOBALS['TL_DCA']['tl_code_config'];
        $alphabets  = StringUtil::deserialize($codeConfig->alphabets, true);

        if (!in_array(CodeUtil::SPECIAL_CHARS, $alphabets))
        {
            $dca['palettes']['default'] = str_replace('allowedSpecialChars', '', $dca['palettes']['default']);
        }

        if (!$codeConfig->doubleCodeTable)
        {
            $dca['subpalettes']['preventDoubleCodes'] = str_replace('doubleCodeTableField', '', $dca['subpalettes']['preventDoubleCodes']);
        }
    }

    public function getGenerateButton(array $row, string $key, string $label, string $title)
    {
        $href = sprintf('contao/main.php?do=code_config&%s&id=%s&rt=%s', $key, $row['id'], \RequestToken::get());

        return sprintf(
            "<a href=\"%s\" title=\"%s\" onclick=\"count=prompt('%s', '');"
            . "if (count) {self.location.href='/%s&count=' + count;} return false;\"><img src=\"%s\"></a>",
            $href,
            $title,
            $GLOBALS['TL_LANG']['MSC']['codeGenerator']['codesPrompt'],
            $href,
            'bundles/heimrichhannotcontaocodegenerator/img/generate.png'
        );
    }

    public function getDoubleTableFields(DataContainer $dc): array
    {
        if (null === ($codeConfig = System::getContainer()->get('huh.code_generator.manager.code_config_manager')->findByPk($dc->id))
            || !$codeConfig->doubleCodeTable
        )
        {
            return [];
        }

        return \Contao\System::getContainer()->get('huh.utils.choice.field')->getCachedChoices(
            [
                'dataContainer' => $codeConfig->doubleCodeTable
            ]
        );
    }
}