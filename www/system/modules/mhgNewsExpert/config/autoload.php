<?php
/**
 * Contao 3 Extension [mhgNewsExpert]
 *
 * Copyright (c) 2016 Medienhaus Gersöne UG | Pierre Gersöne
 *
 * @package     mhgNewsExpert
 * @link        http://www.medienhaus-gersoene.de
 * @license     propitary licence
 */

/**
 * Add namespace
 */
ClassLoader::addNamespace('mhg');

/**
 * Register the classes
 */
ClassLoader::addClasses( array (
    'mhg\ModuleNewsList' => 'system/modules/mhgNewsExpert/modules/ModuleNewsList.php',
    'mhg\ModuleNewsReader' => 'system/modules/mhgNewsExpert/modules/ModuleNewsReader.php',
));