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
 * Register the classes
 */
ClassLoader::addClasses(array(
    // 
    'mhg\ModuleNewsList' => 'system/modules/mhgNewsExpert/modules/ModuleNewsList.php',
    'mhg\ModuleNewsReader' => 'system/modules/mhgNewsExpert/modules/ModuleNewsReader.php',
));
