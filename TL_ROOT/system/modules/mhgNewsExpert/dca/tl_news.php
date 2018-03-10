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
 * alter DCA palettes
 */
mhg\Dca::alterPalettes('tl_news', 'author;', 'author;{legend_meta},meta_title,meta_description,meta_keywords;');
mhg\Dca::alterPalettes('tl_news', ',featured', '');
mhg\Dca::alterPalettes('tl_news', ',published', ',published,featured');

/**
 * alter DCA fields
 */
mhg\Dca::alterFieldEval('tl_news', 'published', 'tl_class', 'w50');

/**
 * add DCA fields
 */
mhg\Dca::addField('tl_news', 'meta_title', array(
    'label' => &$GLOBALS['TL_LANG']['tl_news']['meta_title'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => array('mandatory' => false, 'decodeEntities' => true, 'maxlength' => 255, 'tl_class' => 'long'),
    'sql' => "varchar(255) NOT NULL default ''"
));

mhg\Dca::addField('tl_news', 'meta_description', array(
    'label' => &$GLOBALS['TL_LANG']['tl_news']['meta_description'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'textarea',
    'eval' => array('style' => 'height:60px', 'decodeEntities' => true, 'tl_class' => 'clr'),
    'sql' => "text NULL"
));

mhg\Dca::addField('tl_news', 'meta_keywords', array(
    'label' => &$GLOBALS['TL_LANG']['tl_news']['meta_keywords'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => array('mandatory' => false, 'decodeEntities' => true, 'tl_class' => 'long',),
    'sql' => "varchar(255) NOT NULL default ''"
));
