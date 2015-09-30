<?php
if( !in_array( 'news', Config::getInstance()->getActiveModules() ) )
    {
    return;
    }


/**
 * Alternate pallettes
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'redirectEmpty';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['redirectEmpty'] = 'jumpTo';
/**
 * newsreader
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['newsreader'] = str_replace(
    ';{template_legend', ';{redirects_legend},redirect404,redirectEmpty;{template_legend', $GLOBALS['TL_DCA']['tl_module']['palettes']['newsreader']
);
/**
 * newslist
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['newslist'] = str_replace( ',skipFirst', ',skipFirst,newsSorting', $GLOBALS['TL_DCA']['tl_module']['palettes']['newslist'] );

/**
 * Add additional fields
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['redirect404'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_module']['redirect404'],
    'exclude' => true,
    'filter' => true,
    'inputType' => 'checkbox',
    'sql' => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['redirectEmpty'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_module']['redirectEmpty'],
    'exclude' => true,
    'filter' => true,
    'inputType' => 'checkbox',
    'eval' => array( 'submitOnChange' => true ),
    'sql' => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newsSorting'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_module']['newsSorting'],
    'default' => 'dateDesc',
    'exclude' => true,
    'inputType' => 'select',
    'options' => array( 'dateDesc', 'dateAsc', 'headlineAsc', 'headlineDesc' ),
    'reference' => &$GLOBALS['TL_LANG']['tl_module']['newsSorting'],
    'eval' => array( 'tl_class' => 'w50' ),
    'sql' => "varchar(32) NOT NULL default ''"
);