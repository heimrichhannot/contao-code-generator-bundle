<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\CodeGeneratorBundle\Manager;

use Contao\StringUtil;
use HeimrichHannot\CodeGeneratorBundle\Code\Generator;
use HeimrichHannot\CodeGeneratorBundle\Model\ConfigModel;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @deprecated Use Generator instead
 */
class CodeGeneratorManager
{
    public function __construct(
        private readonly Generator $generator
    )
    {
    }

    /**
     * @deprecated Use Generator instead
     */
    public function getCodesByConfig(int $codeConfig, int $count = 1): array
    {
        if (null === ($codeConfig = ConfigModel::findByPk($codeConfig))) {
            return [];
        }

        return $this->generator->generateMultipleFromConfig($codeConfig, $count);
    }

    /**
     * @deprecated No replacement
     */
    public function codeExistsInTable(string $code, string $table, string $field)
    {
        return null !== ConfigModel::findBy(["$table.$field=?"], [$code]);
    }
}
