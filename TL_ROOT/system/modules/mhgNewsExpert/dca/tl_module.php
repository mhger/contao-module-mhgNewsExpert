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
/**
 * alter DCA pallettes and subpalettes
 */
mhg\Dca::alterPalette('tl_module', ',news_archives', ',news_archives,redirectEmpty', 'newsreader');
mhg\Dca::alterPalette('tl_module', ',skipFirst', ',skipFirst,newsSorting', 'newslist');
mhg\Dca::addSubpalette('tl_module', 'redirectEmpty', 'jumpTo');

/**
 * Add additional fields to tl_module
 */
mhg\Dca::addField('tl_module', 'redirectEmpty', array(
    'label' => &$GLOBALS['TL_LANG']['tl_module']['redirectEmpty'],
    'exclude' => true,
    'filter' => true,
    'inputType' => 'checkbox',
    'eval' => array('submitOnChange' => true),
    'sql' => "char(1) NOT NULL default ''"
));

mhg\Dca::addField('tl_module', 'newsSorting', array(
    'label' => &$GLOBALS['TL_LANG']['tl_module']['newsSorting'],
    'default' => 'dateDesc',
    'exclude' => true,
    'inputType' => 'select',
    'options' => array_keys($GLOBALS['TL_MHG']['newsSorting']),
    'reference' => &$GLOBALS['TL_LANG']['tl_module']['newsSortingOptions'],
    'eval' => array('tl_class' => 'w50'),
    'sql' => "varchar(32) NOT NULL default ''"
));
