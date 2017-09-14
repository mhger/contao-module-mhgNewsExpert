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

namespace mhgNewsExpert;

/**
 * Class ModuleNewsList
 */
class ModuleNewsList extends \NewsCategories\ModuleNewsList {

    /**
     * Compile the module
     */
    protected function compile() {
        $offset = intval($this->skipFirst);
        $limit = null;

        // Maximum number of items
        if ($this->numberOfItems > 0) {
            $limit = $this->numberOfItems;
        }

        // Handle featured news
        if ($this->news_featured == 'featured') {
            $blnFeatured = true;
        } elseif ($this->news_featured == 'unfeatured') {
            $blnFeatured = false;
        } else {
            $blnFeatured = null;
        }

        $this->Template->articles = array();
        $this->Template->empty = $GLOBALS['TL_LANG']['MSC']['emptyList'];

        // Get the total number of items
        $intTotal = \NewsModel::countPublishedByPids($this->news_archives, $blnFeatured);

        if ($intTotal < 1) {
            if (version_compare(VERSION . '.' . BUILD, '3.3.0', '<')) {
                $this->Template = new \FrontendTemplate('mod_newsarchive_empty');
                $this->Template->empty = $GLOBALS['TL_LANG']['MSC']['emptyList'];
            }
            return;
        }

        $total = $intTotal - $offset;

        // Split the results
        if ($this->perPage > 0 && (!isset($limit) || $this->numberOfItems > $this->perPage)) {
            // Adjust the overall limit
            if (isset($limit)) {
                $total = min($limit, $total);
            }

            // Get the current page
            $id = 'page_n' . $this->id;
            $page = \Input::get($id) ? : 1;

            // Do not index or cache the page if the page number is outside the range
            if ($page < 1 || $page > max(ceil($total / $this->perPage), 1)) {
                global $objPage;
                $objPage->noSearch = 1;
                $objPage->cache = 0;

                // Send a 404 header
                header('HTTP/1.1 404 Not Found');
                return;
            }

            // Set limit and offset
            $limit = $this->perPage;
            $offset += (max($page, 1) - 1) * $this->perPage;
            $skip = intval($this->skipFirst);

            // Overall limit
            if ($offset + $limit > $total + $skip) {
                $limit = $total + $skip - $offset;
            }

            // Add the pagination menu
            if (version_compare(VERSION . '.' . BUILD, '3.3.0', '>=')) {
                $objPagination = new \Pagination($total, $this->perPage, \Config::get('maxPaginationLinks'), $id);
            } elseif (version_compare(VERSION . '.' . BUILD, '3.1.0', '>=')) {
                $objPagination = new \Pagination($total, $this->perPage, $GLOBALS['TL_CONFIG']['maxPaginationLinks'], $id);
            } else {
                $objPagination = new \Pagination($total, $this->perPage, 7, $id);
            }
            $this->Template->pagination = $objPagination->generate("\n  ");
        }

        switch ($this->newsSorting) {
            case 'dateAsc':
                $arrOptions['order'] = "tl_news.date ASC";
                break;
            case 'headlineAsc':
                $arrOptions['order'] = "tl_news.headline ASC";
                break;
            case 'headlineDesc':
                $arrOptions['order'] = "tl_news.headline DESC";
                break;
            default:
                $arrOptions['order'] = "tl_news.date DESC";
        }

        // Get the items
        if (isset($limit)) {
            $objArticles = \NewsModel::findPublishedByPids($this->news_archives, $blnFeatured, $limit, $offset, $arrOptions);
        } else {
            $objArticles = \NewsModel::findPublishedByPids($this->news_archives, $blnFeatured, 0, $offset, $arrOptions);
        }

        //Add the articles
        if ($objArticles !== null) {
            $this->Template->articles = $this->parseArticles($objArticles);
        }

        if (version_compare(VERSION . '.' . BUILD, '3.3.0', '<') && $objArticles === null) {
            $this->Template = new \FrontendTemplate('mod_newsarchive_empty');
            $this->Template->empty = $GLOBALS['TL_LANG']['MSC']['emptyList'];
        }

        $this->Template->archives = $this->news_archives;
    }

}
