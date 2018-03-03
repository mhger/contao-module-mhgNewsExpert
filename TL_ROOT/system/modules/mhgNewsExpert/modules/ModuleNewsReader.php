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
 * Class ModuleNewsReader 
 */
class ModuleNewsReader extends \Contao\ModuleNewsReader {

    /**
     * generate the module
     * Display a wildcard in the back end
     * 
     * @return string
     */
    public function generate() {
        $return = parent::generate();

        if (empty($return) && $this->redirectEmpty) {
            // Redirect to the jumpTo page
            if ($this->jumpTo && ($objTarget = $this->objModel->getRelated('jumpTo')) !== null) {
                $strRedirect = $this->generateFrontendUrl($objTarget->row());
                $this->redirect($strRedirect);
            }
        }

        return $return;
    }

    /**
     * compile the module
     */
    protected function compile() {
        global $objPage;

        // execute the default behavior first
        parent::compile();

        // Get the news item
        $objArticle = \NewsModel::findPublishedByParentAndIdOrAlias(\Input::get('items'), $this->news_archives);

        // item not found display a propper 404 page
        if ($this->redirect404 && $objArticle === NULL) {
            $objErrorPage = new \PageError404();
            $objErrorPage->generate($objPage->alias . '/' . \Input::get('items'));
            return;
        }

        $strBase = \Environment::get('base');
        $strLink = $strBase . \Environment::get('request');
        $tagEnd = $objPage->outputFormat == 'xhtml' ? ' />' : '>';

        // add a canonical link
        // @todo: add option to enable this
        $GLOBALS['TL_HEAD'][] = '<link rel="canonical" href="' . $strLink . '"' . $tagEnd;

        // add preview image
        if ($objArticle->addImage) {
            $objPage->previewSRC = $objArticle->singleSRC;
        }

        // overwrite the page title
        if (!empty($objArticle->meta_title)) {
            $objPage->pageTitle = strip_tags(strip_insert_tags($objArticle->meta_title));
        }

        // overwrite the page title
        if (!empty($objArticle->meta_description)) {
            $objPage->description = strip_tags(strip_insert_tags($objArticle->meta_description));
        }

        $objPage->title = strip_tags(strip_insert_tags($objArticle->headline));

        // add the news keywords
        if (!empty($objArticle->meta_keywords)) {
            $GLOBALS['TL_KEYWORDS'] = $objArticle->meta_keywords;
        }
    }
}