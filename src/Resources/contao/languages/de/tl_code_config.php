<?php

$lang = &$GLOBALS['TL_LANG']['tl_code_config'];

/**
 * Fields
 */
$lang['title']                   = ['Titel', 'Geben Sie hier bitte den Titel ein.'];
$lang['tstamp']                  = ['Änderungsdatum', ''];
$lang['length']                  = ['Codelänge', 'Bitte geben Sie hier die Code-Länge ein.'];
$lang['preventAmbiguous'][0]     = 'Mehrdeutige Zeichen verhindern';
$lang['preventAmbiguous'][1]     =
    'Wählen Sie diese Option, um mehrdeutige Zeichen zu verhindern (enthalten sind u.a. y, z, o, i und l sowie deren große Varianten).';
$lang['preventDoubleCodes']      = ['Doppelte Codes verhindern', 'Wählen Sie diese Option, um doppelt auftretende Codes zu verhindern.'];
$lang['doubleCodeTable'][0]      = 'Doppelte Codes anhand einer Datenbanktabelle finden';
$lang['doubleCodeTable'][1]      =
    'Wählen Sie hier eine Datenbanktabelle aus, müssen Sie anschließend ein Feld dieser Tabelle wählen. Beim Erzeugen der Codes wird darauf geachtet, dass der erzeugte Code noch in keinem Datenbankeintrag vorkommt.';
$lang['doubleCodeTableField'][0] = 'Datenbankfeld';
$lang['doubleCodeTableField'][1] = 'Wählen Sie hier das Datenbankfeld aus, in dem nach potentiellen Code-Duplikaten gesucht werden soll.';
$lang['alphabets']               = ['Alphabete', 'Bitte wählen Sie die Alphabete aus, die als Grundlage dienen sollen.'];
$lang['rules'][0]                = 'Regeln';
$lang['rules'][1]                =
    'Bitte geben Sie die Regeln an, die für die Codes gelten sollen. WICHTIG: Für eine solche Bedingung muss das entsprechende Alphabet aktiv sein.';
$lang['allowedSpecialChars'][0]  = 'Erlaubte Sonderzeichen';
$lang['allowedSpecialChars'][1]  = 'Bitte geben Sie eine kommagetrennte Liste der erlaubten Sonderzeichen ein.';

/**
 * Legends
 */
$lang['general_legend'] = 'Allgemeine Einstellungen';
$lang['config_legend']  = 'Konfiguration';

/**
 * References
 */
$lang['reference'] = [
    'oldValue'  => 'Alter Wert',
    'newValue'  => 'Neuer Wert',
    'alphabets' => [
        \HeimrichHannot\UtilsBundle\Security\CodeUtil::CAPITAL_LETTERS => 'Großbuchstaben',
        \HeimrichHannot\UtilsBundle\Security\CodeUtil::SMALL_LETTERS   => 'Kleinbuchstaben',
        \HeimrichHannot\UtilsBundle\Security\CodeUtil::NUMBERS         => 'Zahlen',
        \HeimrichHannot\UtilsBundle\Security\CodeUtil::SPECIAL_CHARS   => 'Sonderzeichen',
    ],
    'rules'     => [
        \HeimrichHannot\UtilsBundle\Security\CodeUtil::CAPITAL_LETTERS => 'Mindestens einen Grossbuchstaben',
        \HeimrichHannot\UtilsBundle\Security\CodeUtil::SMALL_LETTERS   => 'Mindestens einen Kleinbuchstaben',
        \HeimrichHannot\UtilsBundle\Security\CodeUtil::NUMBERS         => 'Mindestens eine Zahl',
        \HeimrichHannot\UtilsBundle\Security\CodeUtil::SPECIAL_CHARS   => 'Mindestens ein Sonderzeichen',
    ]
];

/**
 * Buttons
 */
$lang['new']      = ['Neue Code-Konfiguration', 'Code-Konfiguration erstellen'];
$lang['edit']     = ['Code-Konfiguration bearbeiten', 'Code-Konfiguration ID %s bearbeiten'];
$lang['copy']     = ['Code-Konfiguration duplizieren', 'Code-Konfiguration ID %s duplizieren'];
$lang['delete']   = ['Code-Konfiguration löschen', 'Code-Konfiguration ID %s löschen'];
$lang['show']     = ['Code-Konfiguration Details', 'Code-Konfiguration-Details ID %s anzeigen'];
$lang['generate'] = ['Codes generieren', 'Codes der Konfiguration ID %s generieren'];
