<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\CodeGeneratorBundle\DataContainer;

use Contao\DataContainer;
use Contao\Input;
use Contao\StringUtil;
use Contao\System;
use HeimrichHannot\CodeGeneratorBundle\Model\ConfigModel;
use HeimrichHannot\Request\Request;
use HeimrichHannot\UtilsBundle\Security\CodeUtil;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CodeConfigContainer
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var ConfigModel
     */
    protected $codeConfigModelAdapter;

    /**
     * @var Request
     */
    protected $request;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->codeConfigModelAdapter = $this->container->get('contao.framework')->getAdapter(ConfigModel::class);
        $this->request = $this->container->get('huh.request');
    }

    public function generateBackendModule()
    {
        if (!($count = $this->request->getGet('count')) || !($id = $this->request->getGet('id'))) {
            return;
        }

        $codes = System::getContainer()->get('huh.code_generator.manager.code_generator_manager')->getCodesByConfig($id, $count);

        if (empty($codes)) {
            return;
        }

        System::getContainer()->get('huh.utils.file')->sendTextAsFileToBrowser(
            implode("\n", $codes),
            'codes_'.date('Y-m-d-H-i').'.txt'
        );
    }

    public function getRulesAsOptions(DataContainer $dc)
    {
        $ruleOptions = [];

        if (null !== ($codeConfig = $this->codeConfigModelAdapter->findByPk($dc->id))) {
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

    public function modifyPalette()
    {
        $codeConfig = $this->codeConfigModelAdapter->findByPk(Input::get('id'));
        $dca = &$GLOBALS['TL_DCA']['tl_code_config'];
        $alphabets = StringUtil::deserialize($codeConfig->alphabets, true);

        if (!\in_array(CodeUtil::SPECIAL_CHARS, $alphabets)) {
            $dca['palettes']['default'] = str_replace('allowedSpecialChars', '', $dca['palettes']['default']);
        }

        if (!$codeConfig->doubleCodeTable) {
            $dca['subpalettes']['preventDoubleCodes'] = str_replace('doubleCodeTableField', '', $dca['subpalettes']['preventDoubleCodes']);
        }
    }

    public function getGenerateButton(array $row, string $key, string $label, string $title)
    {
        $href = sprintf('contao/main.php?do=code_config&%s&id=%s&rt=%s', $key, $row['id'], \RequestToken::get());

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

    public function getDoubleTableFields(DataContainer $dc): array
    {
        if (null === ($codeConfig = $this->codeConfigModelAdapter->findByPk($dc->id))
            || !$codeConfig->doubleCodeTable
        ) {
            return [];
        }

        return \Contao\System::getContainer()->get('huh.utils.choice.field')->getCachedChoices(
            [
                'dataContainer' => $codeConfig->doubleCodeTable,
            ]
        );
    }
}
