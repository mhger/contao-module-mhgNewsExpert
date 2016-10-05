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
namespace mhg;

/**
 * Class ModuleNewsReader 
 */
class ModuleNewsReader extends \Contao\ModuleNewsReader {

    /**
     * generate to module
     * Display a wildcard in the back end
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

        $objPage->title = strip_tags(strip_insert_tags($objArticle->headline));

        // add the news keywords
        if (!empty($objArticle->meta_keywords)) {
            $GLOBALS['TL_KEYWORDS'] = $objArticle->meta_keywords;
        }
    }

}
