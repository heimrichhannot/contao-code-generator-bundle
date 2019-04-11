<?php

/**
 * Backend modules
 */
$GLOBALS['BE_MOD']['system']['code_config'] = [
    'tables'   => ['tl_code_config'],
    'generate' => ['huh.code_generator.data_container.code_config_container', 'generateBackendModule'],
];

/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_code_config'] = 'HeimrichHannot\CodeGeneratorBundle\Model\ConfigModel';