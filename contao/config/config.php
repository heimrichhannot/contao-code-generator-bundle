<?php

/**
 * Backend modules
 */

use HeimrichHannot\CodeGeneratorBundle\DataContainer\CodeConfigContainer;
use HeimrichHannot\CodeGeneratorBundle\Model\ConfigModel;

$GLOBALS['BE_MOD']['system']['code_config'] = [
    'tables'   => ['tl_code_config'],
    'generate' => [CodeConfigContainer::class, 'generateBackendModule'],
];

/**
 * Models
 */
$GLOBALS['TL_MODELS'][ConfigModel::getTable()] = ConfigModel::class;