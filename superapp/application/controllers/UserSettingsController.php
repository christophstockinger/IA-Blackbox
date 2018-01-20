<?php

class UserSettingsController extends Zend_Controller_Action
{

    protected $_thisUser = null;
    protected $_thisUserSettings = null;
    protected $_maxFileUpload = null;
    protected $_maxStorage = null;
    protected $_allFileformats = null;

    public function init()
    {
        /* Initialize action controller here */

        // check auth and get user
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $mapper = new Application_Model_Mappers_RawUser();
            $this->_thisUser = $mapper->fetchSingleById(Zend_Auth::getInstance()->getStorage()->read()->ID);
            $this->view->thisUser = $this->_thisUser;
        }

        // check auth and get user settings
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $mapper = new Application_Model_Mappers_RawUserSettings();
            $this->_thisUserSettings = $mapper->fetchSingleByUserId(Zend_Auth::getInstance()->getStorage()->read()->ID);
            $this->view->thisUserSettingers = $this->_thisUserSettings;
        }

        // Maximale Größen aus DB
        $mapper = new Application_Model_Mappers_GlobalSettings();
        $this->_maxStorage = $mapper->fetchSingleByName('MAX_STORAGE')->getSettingsValue();
        $this->_maxFileUpload = $mapper->fetchSingleByName('MAX_FILE_UPLOAD')->getSettingsValue();

        // Alle erlaubten Dateiformate
        $mapper = new Application_Model_Mappers_GlobalFileformats();
        $this->_allFileformats = $mapper->fetchList();

    }

    public function indexAction()
    {
        // action body
        // check auth
        if (!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));

        // Check for new or not supported Fileformats --> return message for view
        $userFileformatsCount = count($this->_thisUserSettings->getAllowedFileFormats());
        $allowedFileformatsCount = count($this->_allFileformats);
        if($allowedFileformatsCount > $userFileformatsCount) {
            $this->view->fileformatMessage = "<span>Es gibt neue erlaubte Dateiformate.</span> <a href='" . $this->getHelper('url')->url(array('controller' => 'user-settings', 'action' => 'edit')) . "'>eigene Dateiformate bearbeiten</a>";
        }

        if($allowedFileformatsCount < $userFileformatsCount) {
            $this->view->fileformatMessage = "<span>Es gibt nicht mehr unterstütze Dateiformate.</span> <a href='" . $this->getHelper('url')->url(array('controller' => 'user-settings', 'action' => 'edit')) . "'>eigene Dateiformate bearbeiten</a>";
        }

        // handover user and user settings to view
        $this->view->usersettings = $this->_thisUserSettings;


    }


    public function editAction()
    {
        // action body
        if (!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));

        // Formularinhalte vom Absenden holen
        $data = $this->getRequest()->getPost();

        if (!empty($data) && !is_null($data['speichern'])) {
            // User-ID
            $userid = (int)$data['userid'];

            // Hinzufügen eines neuen Key für die allowed Fileformats
            $data['allowedfileformats'] = "";
            $i = 0; // Laufvariable
            // Auslesen der FileFormate
            foreach ($this->_allFileformats as $fileformat) {
                $fileformat = $fileformat->getFileformat();
                $dataFileformat = $data[$fileformat];

                if ($dataFileformat == 1) {
                    if ($data['allowedfileformats'] == "") {
                        $data['allowedfileformats'] .= $fileformat;
                    } else {
                        $data['allowedfileformats'] .= ";" . $fileformat;
                    }
                }

                $i++;
            }

            // Max-File-Upload
            $maxfileupload = (int)$data['maxfileupload'];
            // Max Storage
            $maxstorage = (int)$data['maxstorage'];

            // Check ob maximale Grenzen eingehalten wurden
            if (($maxfileupload <= $this->_maxFileUpload) && ($maxstorage <= $this->_maxStorage)) {
                // Wenn beides erfüllt wird Datenbank geupdatet!

                // set data in database via mapper
                $mapper = new Application_Model_Mappers_RawUserSettings();


                if ($userid) {
                    $row = $mapper->update($userid, $data);

                    if ($row == $userid) {
                        $this->_redirect($this->getHelper('url')->url(array('controller' => 'user-settings', 'action' => 'index', null), 'default', true));
                    }
                }
            }
        }

        // Form erstellen und an View übergeben
        $form = new Application_Form_UserSettingsEdit($this->_thisUserSettings);
        $this->view->form = $form;

        // Übergabe der maximalen Grenzen an den View
        $this->view->maxfileupload = $this->_maxFileUpload;
        $this->view->maxstorage = $this->_maxStorage;

    }


}



