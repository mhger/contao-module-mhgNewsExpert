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

namespace mhg;


/**
 * class mhg\mhgNewsExpert
 */
class NewsExpert {

    /**
     * @var array
     */
    protected static $arrNewsReader = array();

    /**
     * 
     * @param   array $arrArchives
     * @param   boolean $blnFeatured
     * @param   integer $limit
     * @param   integer $offset
     * @param   type $objModule Instance of \ModuleNewsList
     * @return  object  Instance of \Model\Collection
     */
    public static function newsListFetchItems($arrArchives, $blnFeatured, $limit, $offset, $objModule) {
        $limit = $limit > 0 ? $limit : 0;

        // sort news
        if (isset($GLOBALS['TL_MHG']['newsSorting'][$objModule->newsSorting])) {
            $arrOptions = array('order' => $GLOBALS['TL_MHG']['newsSorting'][$objModule->newsSorting]);
        } else {
            // use first sorting option if no valid sorting option is given
            $arrTemp = $GLOBALS['TL_MHG']['newsSorting'];
            $arrOptions = array('order' => array_shift($arrTemp));
        }

        // get the news model
        $objModel = \NewsModel::findPublishedByPids($arrArchives, $blnFeatured, $limit, $offset, $arrOptions);

        return $objModel;
    }

    /**
     * Hook. Called on parsing news articles for list, reader etc.
     * 
     * @param   object $objTemplate
     * @param   array $arrRow
     * @param   object $objModule
     * @return  void
     */
    public static function parseArticles($objTemplate, $arrRow, $objModule) {
        if ($objModule->type !== 'newsreader') {
            return;
        }

        // buffer the data temporarly
        static::$arrNewsReader[$objModule->id] = array(
            'headline' => $arrRow['headline'],
            'title' => $arrRow['title'],
            'description' => $arrRow['description'],
            'keywords' => $arrRow['keywords']
        );
    }

    /**
     * 
     * @param   object $objModule
     * @param   string $strBuffer
     * @return  string
     */
    public static function getFrontendModule($objModule, $strBuffer) {
        if ($objModule->type === 'newsreader') {
            return self::generateNewsReader($objModule, $strBuffer);
        }

        return $strBuffer;
    }

    /**
     * 
     * @param   object $objElement
     * @param   string $strBuffer
     * @return  string
     */
    public static function getContentElement($objElement, $strBuffer) {
        if ($objElement->type === 'module') {
            if (isset(static::$arrNewsReader[$objElement->module]) || empty($strBuffer)) {
                $objModul = \ModuleModel::findByPk($objElement->module);
                if ($objModul !== null && $objModul->type === 'newsreader') {
                    return self::generateNewsReader($objModul, $strBuffer);
                }
            }
        }

        return $strBuffer;
    }

    /**
     * 
     * @param   object $objModule The module model.
     * @param   string $strBuffer
     * @return  string
     */
    protected static function generateNewsReader($objModule, $strBuffer) {
        // redirect empty        
        if (empty($strBuffer) && $objModule->redirectEmpty && $objModule->jumpTo) {
            if (null !== ($objTarget = $objModule->getRelated('jumpTo'))) {
                \Controller::redirect(\Controller::generateFrontendUrl($objTarget->row()));
            }
        }

        if (!isset(static::$arrNewsReader[$objModule->id])) {
            return $strBuffer;
        }

        // add/overwrite meta data
        global $objPage;

        $objArticle = (object) static::$arrNewsReader[$objModule->id];

        // overwrite the page title
        if (!empty($objArticle->title)) {
            // @see \Frontend::prepareMetaDescription
            $objPage->pageTitle = strip_tags(strip_insert_tags($objArticle->title));
        }

        // overwrite the page description
        if (!empty($objArticle->description)) {
            // @see \Frontend::prepareMetaDescription
            $objPage->description = strip_tags(strip_insert_tags($objArticle->description));
        }

        $objPage->title = strip_tags(strip_insert_tags($objArticle->headline));

        // add the news keywords
        if (!empty($objArticle->keywords)) {
            $GLOBALS['TL_KEYWORDS'] = $objArticle->keywords;
        }

        return $strBuffer;
    }
}
