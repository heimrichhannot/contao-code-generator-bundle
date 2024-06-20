<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\CodeGeneratorBundle\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\Database;
use Contao\DataContainer;
use Contao\RequestToken;
use Contao\StringUtil;
use HeimrichHannot\CodeGeneratorBundle\Code\Generator;
use HeimrichHannot\CodeGeneratorBundle\Model\ConfigModel;
use HeimrichHannot\UtilsBundle\Security\CodeUtil;
use HeimrichHannot\UtilsBundle\Util\Utils;
use Symfony\Component\HttpFoundation\RequestStack;

class CodeConfigContainer
{
    public const CAPITAL_LETTERS = 'capitalLetters';
    public const SMALL_LETTERS = 'smallLetters';
    public const NUMBERS = 'numbers';
    public const SPECIAL_CHARS = 'specialChars';

    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly Utils $utils,
        private readonly Generator $generator
    )
    {
    }

    #[AsCallback(table: 'tl_code_config', target: 'config.onload')]
    public function onConfigLoadCallback(DataContainer $dc = null): void
    {
        if (!$dc || !$dc->id || !($codeConfig = ConfigModel::findByPk($dc->id))) {
            return;
        }

        $dca = &$GLOBALS['TL_DCA']['tl_code_config'];
        $alphabets = StringUtil::deserialize($codeConfig->alphabets, true);

        if (!\in_array(CodeUtil::SPECIAL_CHARS, $alphabets)) {
            $dca['palettes']['default'] = str_replace('allowedSpecialChars', '', $dca['palettes']['default']);
        }

        if (!$codeConfig->doubleCodeTable) {
            $dca['subpalettes']['preventDoubleCodes'] = str_replace('doubleCodeTableField', '', $dca['subpalettes']['preventDoubleCodes']);
        }
    }

    #[AsCallback(table: 'tl_code_config', target: 'fields.doubleCodeTable.options')]
    public function onDoubleCodeTableOptionsCallback(DataContainer $dc = null): array
    {
        return Database::getInstance()->listTables();
    }

    #[AsCallback(table: 'tl_code_config', target: 'fields.doubleCodeTableField.options')]
    public function onFieldsDoubleCodeTableFieldOptionsCallback(DataContainer $dc = null): array
    {
        if (!$dc
            || !$dc->id
            || null === ($codeConfig = ConfigModel::findByPk($dc->id))
            || !$codeConfig->doubleCodeTable
        ) {
            return [];
        }

        $fields = $this->utils->dca()->getDcaFields($codeConfig->doubleCodeTable);
        $options = [];
        foreach ($fields as $field) {
            $label = $GLOBALS['TL_DCA'][$codeConfig->doubleCodeTable]['fields'][$field]['label'][0] ?? null;

            $options[$field] = $field . ($label
                    ? ' <span style="display: inline; color:#999; padding-left:3px">[' . $label . ']</span>'
                    : ''
                );;
        }

        return $options;
    }

    public function generateBackendModule()
    {
        $request = $this->requestStack->getCurrentRequest();
        if (!$request || !$request->query->has('count') || !$request->query->has('id')) {
            return;
        }

        $count = intval($request->query->get('count'));
        $config = ConfigModel::findByPk(intval($request->query->get('id')));

        if (!$config) {
            return;
        }

        $codes = $this->generator->generateMultipleFromConfig($config, $count);

        if (empty($codes)) {
            return;
        }

        $this->sendTextAsFileToBrowser(
            implode("\n", $codes),
            'codes_'.date('Y-m-d-H-i').'.txt'
        );
    }

    public function getRulesAsOptions(DataContainer $dc)
    {
        $ruleOptions = [];

        if (null !== ($codeConfig = ConfigModel::findByPk($dc->id))) {
            $alphabets = StringUtil::deserialize($codeConfig->alphabets, true);
            $types = [
                CodeUtil::CAPITAL_LETTERS,
                CodeUtil::SMALL_LETTERS,
                CodeUtil::NUMBERS,
                CodeUtil::SPECIAL_CHARS,
            ];

            foreach ($types as $type) {
                if (\in_array($type, $alphabets)) {
                    $ruleOptions[] = $type;
                }
            }
        }

        return $ruleOptions;
    }

    public function getGenerateButton(array $row, string $key, string $label, string $title)
    {
        $href = sprintf('contao?do=code_config&%s&id=%s&rt=%s', $key, $row['id'], RequestToken::get());

        return sprintf(
            "<a href=\"%s\" title=\"%s\" onclick=\"count=prompt('%s', '');"
            ."if (count) {self.location.href='/%s&count=' + count;} return false;\"><img src=\"%s\"></a>",
            $href,
            $title,
            $GLOBALS['TL_LANG']['MSC']['codeGenerator']['codesPrompt'],
            $href,
            'bundles/contaocodegenerator/img/generate.png'
        );
    }

    private function sendTextAsFileToBrowser(string $content, string $fileName): never
    {
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        header('Content-Type: text/plain');
        header('Connection: close');
        echo $content;

        exit();
    }
}
