<?php
if( !defined( 'TL_ROOT' ) ) die( 'You can not access this file directly!' );

/**
 * mx|byte Contao 3 Extension
 *
 * Copyright (c) 2013 mxbyte|Pierre Gersöne
 *
 * @package     newsExpert
 * @link        http://mxbyte.com
 * @license     propitary licence
 */
// add meta title and keywords and move featured around
$search = array(
    'author;',
    ',featured',
    ',published'
);

$replace = array(
    'author;{legend_meta},meta_title, meta_keywords;',
    '',
    ',featured,published'
);
// replace in the default palette
$GLOBALS['TL_DCA']['tl_news']['palettes']['default'] = str_replace( $search, $replace, $GLOBALS['TL_DCA']['tl_news']['palettes']['default'] );

// define and alter fields
$GLOBALS['TL_DCA']['tl_news']['fields']['published']['eval']['tl_class'] = 'w50';
$GLOBALS['TL_DCA']['tl_news']['fields']['meta_title'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_news']['meta_title'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => array( 'mandatory' => false, 'decodeEntities' => true, 'maxlength' => 255, 'tl_class' => 'long' ),
    'sql' => "varchar(255) NOT NULL default ''"
);


$GLOBALS['TL_DCA']['tl_news']['fields']['meta_keywords'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_news']['meta_keywords'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => array( 'mandatory' => false, 'decodeEntities' => true, 'tl_class' => 'long', ),
    'sql' => "varchar(255) NOT NULL default ''"
);