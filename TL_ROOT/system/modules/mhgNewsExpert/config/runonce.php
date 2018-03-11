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
 * Class mhgNewsExpertRunonceJob
 */
class NewsExpertRunonceJob extends \Controller {

    /**
     * @param   void
     * @return  void 
     */
    public function __construct() {
        parent::__construct();
        $this->import('Database');
    }

    /**
     * Mitigate database fields from previous versions.
     * - meta_title
     * - meta_description
     * - meta_keywords
     * 
     * @param   void
     * @return  void 
     */
    public function run() {
        if (!version_compare(VERSION, '3.2', '>')) {
            return;
        }

        $strTable = 'tl_news';

        // get out if news module is not installed / active
        if (!$this->Database->tableExists($strTable)) {
            return;
        }

        $this->loadDataContainer($strTable);
        $arrFields = &$GLOBALS['TL_DCA'][$strTable]['fields'];

        // meta_title > title
        if ($this->Database->fieldExists('meta_title', $strTable)) {
            if (isset($arrFields['title']['sql']) && !$this->Database->fieldExists('title', $strTable)) {
                $this->Database->execute("ALTER TABLE $strTable ADD title " . $arrFields['title']['sql']);
            }

            $this->Database->execute("UPDATE $strTable SET title=meta_title WHERE title=''");

            if (!isset($arrFields['meta_title']['sql'])) {
                $this->Database->execute("ALTER TABLE $strTable DROP meta_title");
            }
        }

        // meta_description > description
        if ($this->Database->fieldExists('meta_description', $strTable)) {
            if (isset($arrFields['description']['sql']) && !$this->Database->fieldExists('description', $strTable)) {
                $this->Database->execute("ALTER TABLE $strTable ADD description " . $arrFields['description']['sql']);
            }

            $this->Database->execute("UPDATE $strTable SET description=meta_description WHERE description IS NULL");

            if (!isset($arrFields['meta_description']['sql'])) {
                $this->Database->execute("ALTER TABLE $strTable DROP meta_description");
            }
        }

        // meta_keywords > keywords
        if ($this->Database->fieldExists('meta_keywords', $strTable)) {
            if (isset($arrFields['keywords']['sql']) && !$this->Database->fieldExists('keywords', $strTable)) {
                $this->Database->execute("ALTER TABLE $strTable ADD keywords " . $arrFields['keywords']['sql']);
            }

            $this->Database->execute("UPDATE $strTable SET keywords=meta_keywords WHERE keywords=''");

            if (!isset($arrFields['meta_keywords']['sql'])) {
                $this->Database->execute("ALTER TABLE $strTable DROP meta_keywords");
            }
        }
    }
}

// execute class
$objRunonceJob = new NewsExpertRunonceJob();
$objRunonceJob->run();
