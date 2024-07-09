<?php

use HeimrichHannot\CodeGeneratorBundle\DataContainer\CodeConfigContainer;

$lang = &$GLOBALS['TL_LANG']['tl_code_config'];

/**
 * Fields
 */
$lang['title'] = ['Titel', 'Geben Sie hier bitte den Titel ein.'];
$lang['tstamp'] = ['Änderungsdatum', ''];
$lang['length'] = ['Codelänge', 'Bitte geben Sie hier die Code-Länge ein.'];
$lang['preventAmbiguous'][0] = 'Mehrdeutige Zeichen verhindern';
$lang['preventAmbiguous'][1] =
    'Wählen Sie diese Option, um mehrdeutige Zeichen zu verhindern (enthalten sind u.a. y, z, o, i und l sowie deren große Varianten).';
$lang['preventDoubleCodes'] = ['Doppelte Codes verhindern', 'Wählen Sie diese Option, um doppelt auftretende Codes zu verhindern.'];
$lang['doubleCodeTable'][0] = 'Doppelte Codes anhand einer Datenbanktabelle finden';
$lang['doubleCodeTable'][1] =
    'Wählen Sie hier eine Datenbanktabelle aus, müssen Sie anschließend ein Feld dieser Tabelle wählen. Beim Erzeugen der Codes wird darauf geachtet, dass der erzeugte Code noch in keinem Datenbankeintrag vorkommt.';
$lang['doubleCodeTableField'][0] = 'Datenbankfeld';
$lang['doubleCodeTableField'][1] = 'Wählen Sie hier das Datenbankfeld aus, in dem nach potentiellen Code-Duplikaten gesucht werden soll.';
$lang['alphabets'] = ['Alphabete', 'Bitte wählen Sie die Alphabete aus, die als Grundlage dienen sollen.'];
$lang['rules'][0] = 'Regeln';
$lang['rules'][1] =
    'Bitte geben Sie die Regeln an, die für die Codes gelten sollen. WICHTIG: Für eine solche Bedingung muss das entsprechende Alphabet aktiv sein.';
$lang['allowedSpecialChars'][0] = 'Erlaubte Sonderzeichen';
$lang['allowedSpecialChars'][1] = 'Bitte geben Sie eine kommagetrennte Liste der erlaubten Sonderzeichen ein.';
$lang['prefix'][0] = 'Präfix';
$lang['prefix'][1] = 'Geben Sie hier ein Präfix ein, das vor den Code gesetzt wird. Die Länge des Präfixes wird nicht zur Codelänge hinzugezählt.';
$lang['suffix'][0] = 'Suffix';
$lang['suffix'][1] = 'Geben Sie hier ein Suffix ein, das nach den Code gesetzt wird. Die Länge des Suffixes wird nicht zur Codelänge hinzugezählt.';

/**
 * Legends
 */
$lang['general_legend'] = 'Allgemeine Einstellungen';
$lang['config_legend'] = 'Konfiguration';

/**
 * References
 */
$lang['reference'] = [
    'oldValue' => 'Alter Wert',
    'newValue' => 'Neuer Wert',
    'alphabets' => [
        CodeConfigContainer::CAPITAL_LETTERS => 'Großbuchstaben',
        CodeConfigContainer::SMALL_LETTERS => 'Kleinbuchstaben',
        CodeConfigContainer::NUMBERS => 'Zahlen',
        CodeConfigContainer::SPECIAL_CHARS => 'Sonderzeichen',
    ],
    'rules' => [
        CodeConfigContainer::CAPITAL_LETTERS => 'Mindestens einen Grossbuchstaben',
        CodeConfigContainer::SMALL_LETTERS => 'Mindestens einen Kleinbuchstaben',
        CodeConfigContainer::NUMBERS => 'Mindestens eine Zahl',
        CodeConfigContainer::SPECIAL_CHARS => 'Mindestens ein Sonderzeichen',
    ]
];

/**
 * Buttons
 */
$lang['new'] = ['Neue Code-Konfiguration', 'Code-Konfiguration erstellen'];
$lang['edit'] = ['Code-Konfiguration bearbeiten', 'Code-Konfiguration ID %s bearbeiten'];
$lang['copy'] = ['Code-Konfiguration duplizieren', 'Code-Konfiguration ID %s duplizieren'];
$lang['delete'] = ['Code-Konfiguration löschen', 'Code-Konfiguration ID %s löschen'];
$lang['show'] = ['Code-Konfiguration Details', 'Code-Konfiguration-Details ID %s anzeigen'];
$lang['generate'] = ['Codes generieren', 'Codes der Konfiguration ID %s generieren'];
