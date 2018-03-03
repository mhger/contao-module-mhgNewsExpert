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
 * add meta title and keywords and move featured around
 */
$search = array(
    'author;',
    ',featured',
    ',published'
);

/**
 * replace in the default palette
 */
$replace = array('author;{legend_meta},meta_title,meta_description,meta_keywords;', '', ',featured,published');
$GLOBALS['TL_DCA']['tl_news']['palettes']['default'] = str_replace($search, $replace, $GLOBALS['TL_DCA']['tl_news']['palettes']['default']);

/**
 * add fields to tl_news
 */
$GLOBALS['TL_DCA']['tl_news']['fields']['published']['eval']['tl_class'] = 'w50';
$GLOBALS['TL_DCA']['tl_news']['fields']['meta_title'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_news']['meta_title'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => array('mandatory' => false, 'decodeEntities' => true, 'maxlength' => 255, 'tl_class' => 'long'),
    'sql' => "varchar(255) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_news']['fields']['meta_description'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_news']['meta_description'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'textarea',
    'eval' => array('style' => 'height:60px', 'decodeEntities' => true, 'tl_class' => 'clr'),
    'sql' => "text NULL"
);
$GLOBALS['TL_DCA']['tl_news']['fields']['meta_keywords'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_news']['meta_keywords'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => array('mandatory' => false, 'decodeEntities' => true, 'tl_class' => 'long',),
    'sql' => "varchar(255) NOT NULL default ''"
);
