<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\CodeGeneratorBundle\Manager;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\StringUtil;
use Contao\System;
use HeimrichHannot\CodeGeneratorBundle\Model\ConfigModel;
use HeimrichHannot\ListBundle\Model\ListConfigElementModel;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CodeGeneratorManager
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var ConfigModel
     */
    protected $codeConfigModelAdapter;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->codeConfigModelAdapter = $this->container->get('contao.framework')->getAdapter(ConfigModel::class);
    }

    public function getCodesByConfig(int $codeConfig, int $count = 1): array
    {
        $codeUtil = $this->container->get('huh.utils.code');

        if (null === ($codeConfig = $this->codeConfigModelAdapter->findByPk($codeConfig)))
        {
            return [];
        }

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
                    $found = $this->codeExistsInTable($code, $codeConfig->doubleCodeTable, $codeConfig->doubleCodeTableField);
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
                        $found = $this->codeExistsInTable($code, $codeConfig->doubleCodeTable, $codeConfig->doubleCodeTableField);
                    }
                }
            }

            $codes[] = $code;
        }

        return $codes;
    }

    public function codeExistsInTable(string $code, string $table, string $field)
    {
        return null !== $this->container->get('huh.utils.model')->findModelInstancesBy($table, ["$table.$field=?"], [$code]);
    }
}