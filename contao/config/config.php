<?php

/**
 * Backend modules
 */

use HeimrichHannot\CodeGeneratorBundle\DataContainer\CodeConfigContainer;

$GLOBALS['BE_MOD']['system']['code_config'] = [
    'tables'   => ['tl_code_config'],
    'generate' => [CodeConfigContainer::class, 'generateBackendModule'],
];

/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_code_config'] = 'HeimrichHannot\CodeGeneratorBundle\Model\ConfigModel';