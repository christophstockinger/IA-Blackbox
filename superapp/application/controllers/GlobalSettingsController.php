<?php

class GlobalSettingsController extends Zend_Controller_Action
{

    protected $_thisUser = null;
    protected $_allSettings = null;

    public function init()
    {
        /* Initialize action controller here */

        // check auth and get user
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $mapper = new Application_Model_Mappers_RawUser();
            $this->_thisUser = $mapper->fetchSingleById(Zend_Auth::getInstance()->getStorage()->read()->ID);
            $this->view->thisUser = $this->_thisUser;
        }

        // Einstellungen Globla in Klasse speichern
        $mapper = new Application_Model_Mappers_GlobalSettings();
        $this->_allSettings = $mapper->fetchList();
    }

    public function indexAction()
    {
        // action body
        // check auth
        if (!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));

        // An View übergeben
        $this->view->globalsettings = $this->_allSettings;

    }

    public function editAction()
    {
        // action body
        if (!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));


        // Formular-Parameter holen
        $data = $this->getRequest()->getPost();

        if ( !is_null($data) && isset($data['speichern']) ) {

            $rowadd = 0; // Addition aller geänderten Spalten

            $mapper = new Application_Model_Mappers_GlobalSettings();
            foreach ($data as $settingsname => $settingsvalue) {
                switch ($settingsname) {
                    case 'maxstorage':
                        $settingsname = "MAX_STORAGE";
                        break;
                    case 'maxfileupload':
                        $settingsname = "MAX_FILE_UPLOAD";
                        break;
                }

                $row = $mapper->update($settingsname, $settingsvalue);
                $rowadd += $row;
            }


            if ($rowadd <= count($data) ) {
                $this->_redirect($this->getHelper('url')->url(array('controller' => 'global-settings', 'action' => 'index')));
            } else {
                $this->view->error = "Beim Speichern ist wohl etwas schief gelaufen. Bitte versuche es erneut.";
            }
        }

        // Aufsplitten der zur übergebenen Values an die Form
        foreach ($this->_allSettings as $setting) {
            switch ( $setting->getSettingsName() ) {
                case "MAX_STORAGE":
                    $maxStorage = $setting->getSettingsValue();
                    break;
                case "MAX_FILE_UPLOAD":
                    $maxFileUpload = $setting->getSettingsValue();
                    break;
            }
        }

        $form = new Application_Form_GlobalSettingsEdit($maxStorage, $maxFileUpload);
        $this->view->form = $form;


    }


}



