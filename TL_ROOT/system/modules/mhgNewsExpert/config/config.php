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
 * Hooks
 */
$GLOBALS['TL_HOOKS']['getFrontendModule'][] = array('mhg\NewsExpert', 'getFrontendModule');
$GLOBALS['TL_HOOKS']['getContentElement'][] = array('mhg\NewsExpert', 'getContentElement');
$GLOBALS['TL_HOOKS']['newsListFetchItems'][] = array('mhg\NewsExpert', 'newsListFetchItems');
$GLOBALS['TL_HOOKS']['parseArticles'][] = array('mhg\NewsExpert', 'parseArticles');

/**
 * Sorting options for product listings
 */
$GLOBALS['TL_MHG']['newsSorting'] = array(
    'dateDesc' => 'tl_news.date DESC, tl_news.time DESC',
    'dateAsc' => 'tl_news.date ASC, tl_news.time ASC',
    'headlineAsc' => 'tl_news.headline ASC',
    'headlineDesc' => 'tl_news.headline DESC',
    'random' => 'RAND()'
);
