<?php

$GLOBALS['TL_DCA']['tl_code_config'] = [
    'config'      => [
        'dataContainer'     => 'Table',
        'enableVersioning'  => true,
        'onload_callback'   => [
            ['huh.code_generator.data_container.code_config_container', 'modifyPalette']
        ],
        'onsubmit_callback' => [
            ['huh.utils.dca', 'setDateAdded'],
        ],
        'oncopy_callback'   => [
            ['huh.utils.dca', 'setDateAddedOnCopy'],
        ],
        'sql'               => [
            'keys' => [
                'id' => 'primary'
            ]
        ]
    ],
    'list'        => [
        'label'             => [
            'fields' => ['title'],
            'format' => '%s'
        ],
        'sorting'           => [
            'mode'         => 2,
            'fields'       => ['title'],
            'headerFields' => ['title'],
            'panelLayout'  => 'filter;search,limit'
        ],
        'global_operations' => [
            'all' => [
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();"'
            ],
        ],
        'operations'        => [
            'edit'     => [
                'label' => &$GLOBALS['TL_LANG']['tl_code_config']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.gif'
            ],
            'copy'     => [
                'label' => &$GLOBALS['TL_LANG']['tl_code_config']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif'
            ],
            'delete'   => [
                'label'      => &$GLOBALS['TL_LANG']['tl_code_config']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm']
                                . '\'))return false;Backend.getScrollOffset()"'
            ],
            'show'     => [
                'label' => &$GLOBALS['TL_LANG']['tl_code_config']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif'
            ],
            'generate' => [
                'label'           => &$GLOBALS['TL_LANG']['tl_code_config']['generate'],
                'href'            => 'key=generate',
                'button_callback' => ['huh.code_generator.data_container.code_config_container', 'getGenerateButton']
            ]
        ]
    ],
    'palettes'    => [
        '__selector__' => ['preventDoubleCodes'],
        'default'      => '{general_legend},title;{config_legend},length,preventAmbiguous,preventDoubleCodes,alphabets,rules,allowedSpecialChars;'
    ],
    'subpalettes' => [
        'preventDoubleCodes' => 'doubleCodeTable,doubleCodeTableField',
        'published'          => 'start,stop'
    ],
    'fields'      => [
        'id'                   => [
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ],
        'tstamp'               => [
            'label' => &$GLOBALS['TL_LANG']['tl_code_config']['tstamp'],
            'sql'   => "int(10) unsigned NOT NULL default '0'"
        ],
        'dateAdded'            => [
            'label'   => &$GLOBALS['TL_LANG']['MSC']['dateAdded'],
            'sorting' => true,
            'flag'    => 6,
            'eval'    => ['rgxp' => 'datim', 'doNotCopy' => true],
            'sql'     => "int(10) unsigned NOT NULL default '0'"
        ],
        'title'                => [
            'label'     => &$GLOBALS['TL_LANG']['tl_code_config']['title'],
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'flag'      => 1,
            'inputType' => 'text',
            'eval'      => ['mandatory' => true, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''"
        ],
        'preventAmbiguous'     => [
            'label'     => &$GLOBALS['TL_LANG']['tl_code_config']['preventAmbiguous'],
            'exclude'   => true,
            'inputType' => 'checkbox',
            'default'   => true,
            'eval'      => ['tl_class' => 'w50 clr'],
            'sql'       => "char(1) NOT NULL default ''"
        ],
        'length'               => [
            'label'     => &$GLOBALS['TL_LANG']['tl_code_config']['length'],
            'exclude'   => true,
            'inputType' => 'text',
            'default'   => 8,
            'eval'      => ['rgxp' => 'digit', 'tl_class' => 'w50'],
            'sql'       => "int(64) unsigned NOT NULL default '0'"
        ],
        'preventDoubleCodes'   => [
            'label'     => &$GLOBALS['TL_LANG']['tl_code_config']['preventDoubleCodes'],
            'exclude'   => true,
            'inputType' => 'checkbox',
            'default'   => true,
            'eval'      => ['submitOnChange' => true, 'tl_class' => 'w50'],
            'sql'       => "char(1) NOT NULL default ''"
        ],
        'doubleCodeTable'      => [
            'label'            => &$GLOBALS['TL_LANG']['tl_code_config']['doubleCodeTable'],
            'exclude'          => true,
            'inputType'        => 'select',
            'options_callback' => ['huh.utils.choice.data_container', 'getCachedChoices'],
            'eval'             => [
                'chosen'             => true,
                'submitOnChange'     => true,
                'includeBlankOption' => true,
                'tl_class'           => 'w50'
            ],
            'sql'              => "varchar(255) NOT NULL default ''"
        ],
        'doubleCodeTableField' => [
            'label'            => &$GLOBALS['TL_LANG']['tl_code_config']['doubleCodeTableField'],
            'exclude'          => true,
            'inputType'        => 'select',
            'options_callback' => ['huh.code_generator.data_container.code_config_container', 'getDoubleTableFields'],
            'eval'             => [
                'chosen'             => true,
                'mandatory'          => true,
                'includeBlankOption' => true,
                'tl_class'           => 'w50'
            ],
            'sql'              => "varchar(255) NOT NULL default ''"
        ],
        'alphabets'            => [
            'label'     => &$GLOBALS['TL_LANG']['tl_code_config']['alphabets'],
            'exclude'   => true,
            'inputType' => 'checkbox',
            'options'   => [
                \HeimrichHannot\UtilsBundle\Security\CodeUtil::CAPITAL_LETTERS,
                \HeimrichHannot\UtilsBundle\Security\CodeUtil::SMALL_LETTERS,
                \HeimrichHannot\UtilsBundle\Security\CodeUtil::NUMBERS,
                \HeimrichHannot\UtilsBundle\Security\CodeUtil::SPECIAL_CHARS
            ],
            'reference' => &$GLOBALS['TL_LANG']['tl_code_config']['reference']['alphabets'],
            'eval'      => ['mandatory' => true, 'multiple' => true, 'tl_class' => 'w50 clr', 'submitOnChange' => true],
            'sql'       => "blob NULL"
        ],
        'rules'                => [
            'label'            => &$GLOBALS['TL_LANG']['tl_code_config']['rules'],
            'exclude'          => true,
            'inputType'        => 'checkbox',
            'options_callback' => ['huh.code_generator.data_container.code_config_container', 'getRulesAsOptions'],
            'reference'        => &$GLOBALS['TL_LANG']['tl_code_config']['reference']['rules'],
            'eval'             => ['multiple' => true, 'tl_class' => 'w50'],
            'sql'              => "blob NULL"
        ],
        'allowedSpecialChars'  => [
            'label'     => &$GLOBALS['TL_LANG']['tl_code_config']['allowedSpecialChars'],
            'exclude'   => true,
            'inputType' => 'text',
            'default'   => '[=<>()#/]',
            'eval'      => ['tl_class' => 'w50 clr'],
            'sql'       => "varchar(255) NOT NULL default ''"
        ]
    ]
];