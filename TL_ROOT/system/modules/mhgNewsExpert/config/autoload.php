<?php
/**
 * mhg Contao 3 Extension
 *
 * @package     mhgNewsExpert
 * @link        http://www.medienhaus-gersoene.de
 * @license     propitary
 * @copyright   Copyright (c) 2015 Medienhaus Gersöne UG
 * @author      Pierre Gersöne <mail@medienhaus-gersoene.de>
 */
/**
 * Register the namespaces
 */
ClassLoader::addNamespaces( array
    (
    'mhg',
) );
/**
 * Register the classes
 */
ClassLoader::addClasses( array
    (
    // Modules
    'mhg\ModuleNewsList' => 'system/modules/mhgNewsExpert/modules/ModuleNewsList.php',
    'mhg\ModuleNewsReader' => 'system/modules/mhgNewsExpert/modules/ModuleNewsReader.php',
) );
