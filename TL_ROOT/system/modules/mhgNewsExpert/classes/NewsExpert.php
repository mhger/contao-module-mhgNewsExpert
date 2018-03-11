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
     * 
     * @param   array $arrArchives
     * @param   boolean $blnFeatured
     * @param   integer $limit
     * @param   integer $offset
     * @param   type $objModule Instance of \ModuleNewsList
     * @return  object  Instance of \Model\Collection
     */
    public function newsListFetchItems($arrArchives, $blnFeatured, $limit, $offset, $objModule) {
        // sort news
        if (isset($GLOBALS['TL_MHG']['newsSorting'][$objModule->newsSorting])) {
            $arrOptions = array('order' => $GLOBALS['TL_MHG']['newsSorting'][$objModule->newsSorting]);
        } else {
            // use first sorting option if no valid sorting option is given
            $arrTemp = $GLOBALS['TL_MHG']['newsSorting']['dateDesc'];
            $arrOptions = array('order' => array_shift($arrTemp));
        }

        // Get the items
        if (isset($limit)) {
            $objModel = \NewsModel::findPublishedByPids($arrArchives, $blnFeatured, $limit, $offset, $arrOptions);
        } else {
            $objModel = \NewsModel::findPublishedByPids($arrArchives, $blnFeatured, 0, $offset, $arrOptions);
        }

        return $objModel;
    }
}
