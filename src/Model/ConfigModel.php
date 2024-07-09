<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\CodeGeneratorBundle\Model;

use Contao\Model;

/**
 * @property int    $id
 * @property string $tstamp
 * @property bool $preventAmbiguous
 * @property int $length
 * @property bool $preventDoubleCodes
 * @property array|string $alphabets
 * @property array|string $rules
 * @property string $allowedSpecialChars
 * @property string $doubleCodeTable
 * @property string $doubleCodeTableField
 * @property string $prefix
 * @property string $suffix
 */
class ConfigModel extends Model
{
    protected static $strTable = 'tl_code_config';
}
