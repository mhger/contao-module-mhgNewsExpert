<?php
/**
 * Contao 3 Extension [mhgNewsExpert]
 *
 * Copyright (c) 2018 Medienhaus Gersöne UG (haftungsbeschränkt) | Pierre Gersöne
 *
 * @package     mhgNewsExpert
 * @author      Pierre Gersöne <mail@medienhaus-gersoene.de>
 * @link        https://www.medienhaus-gersoene.de Medienhaus Gersöne - Agentur für Neue Medien: Web, Design & Marketing
 * @license     LGPL-3.0+
 */
$GLOBALS['TL_LANG']['tl_module']['redirects_legend'] = 'Weiterleitungen';
$GLOBALS['TL_LANG']['tl_module']['redirect404'] = array('Weiterleitung: Fehlerhafte ID/Alias', 'Auf die interne Fehler 404 Seite weiterleiten, wenn eine ungültige ID bzw. Alias aufgerufen wurde.');
$GLOBALS['TL_LANG']['tl_module']['redirectEmpty'] = array('Weiterleitung: Keine ID/Alias angegeben', 'Auf eine andere Seite weiterleiten, wenn keine ID bzw. Alias angegeben wurde.');
$GLOBALS['TL_LANG']['tl_module']['newsSorting'] = array('Sortierreihenfolge', 'Legen Sie hier die Sortierreihenfolge der Nachrichtenn fest.');
$GLOBALS['TL_LANG']['tl_module']['newsSortingOptions'] = array(
    'dateAsc' => 'Datum aufsteigend',
    'dateDesc' => 'Datum absteigend',
    'headlineAsc' => 'Titel aufsteigend (A-Z)',
    'headlineDesc' => 'Titel absteigend (Z-A)',
    'random' => 'Zufällige Sortierung',
);