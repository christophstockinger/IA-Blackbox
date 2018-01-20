<?php

class GlobalFileformatsController extends Zend_Controller_Action
{

    protected $_allFileformats = null;
    protected $_globalAllowedFileformats = null;

    public function init()
    {
        /* Initialize action controller here */

        // check auth and get user
        if(Zend_Auth::getInstance()->hasIdentity()){
            $mapper = new Application_Model_Mappers_RawUser();
            $this->_thisUser = $mapper->fetchSingleById(Zend_Auth::getInstance()->getStorage()->read()->ID);
            $this->view->thisUser = $this->_thisUser;
        }

        // auslesender aktuellen erlaubten Dateiformate
        $mapper = new Application_Model_Mappers_GlobalSettings();
        $this->_globalAllowedFileformats = $mapper->fetchSingleByName('ALLOWED_FILEFORMATS');


    }

    public function indexAction()
    {
        // action body
        if (!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));

        $mapper = new Application_Model_Mappers_GlobalFileformats();
        $this->_allFileformats = $mapper->fetchList();
        $this->view->fileformats = $this->_allFileformats;

    }

    public function createAction()
    {
        // action body
        if(!$this->_thisUser) $this->$this->redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index',null), 'default', true ));

        // Formular-Parameter bekommen
        $data = $this->getRequest()->getPost();

        // Check ob Formular-Parameter vorhanden sind
        if ( !is_null($data) && isset($data['anlegen'])) {
            $mapper = new Application_Model_Mappers_GlobalFileformats();
            $row = $mapper->create($data);

            if ( !is_null($row) ) {
                // Hinzufügen zu den globalen erlaubten Dateiformate
                $fileformats = $this->_globalAllowedFileformats->getSettingsValue();
                $fileformats.= ";" . $data['fileformat'];

                // DB updaten
                $mapper2  = new Application_Model_Mappers_GlobalSettings();
                $row2  = $mapper2->update('ALLOWED_FILEFORMATS', $fileformats);

                if ($row2 == 1) {
                    $this->redirect($this->getHelper('url')->url(array('controller' => 'global-fileformats', 'action' => 'index', null), 'default', true ));
                }
            } else {
                $this->view->error = "Beim Speichern des Dateiformates ist leider ein Fehler unterlaufen. Bitte versuchen Sie es erneut!";
            }
        }

        // Form erstellen
        $form = new Application_Form_GlobalFileformatsCreate();
        $this->view->form = $form;

    }

    public function editAction()
    {
        // action body
        if(!$this->_thisUser) $this->$this->redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index',null), 'default', true ));

        // Formular Parameter bekommen
        $data = $this->getRequest()->getPost();


        // Check ob Formular-Parameter vorhanden sind
        if ( !is_null($data) && isset($data['speichern'])) {
            $formatid = $data['formatid'];

            $mapper = new Application_Model_Mappers_GlobalFileformats();
            $save = (int) $mapper->update($formatid, $data);

            if ( $save == 1 ) {
                $this->redirect($this->getHelper('url')->url(array('controller' => 'global-fileformats', 'action' => 'index', null), 'default', true ));
            } else {
                $this->view->error = "Beim Speichern des Dateiformates ist leider ein Fehler unterlaufen. Bitte versuchen Sie es erneut!";
            }
        }

        // Formatid Parameter abfragen
        $formatid = (int) $this->getRequest()->getParam('formatid');

        // DB-Select-Query um Values der ID zu erhalten
        $mapper = new Application_Model_Mappers_GlobalFileformats();
        $fileformat = $mapper->fetchSingleById($formatid);

        // Form erstellen
        $form = new Application_Form_GlobalFileformatsEdit($fileformat);
        $this->view->form = $form;




    }

    public function deleteAction()
    {
        // action body
        if(!$this->_thisUser) $this->$this->redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index',null), 'default', true ));

        // zu löschende Formatid als Parameter
        $formatid = $this->getRequest()->getParam('formatid');

        // Check ob Formatid gesetzt ist
        if( isset($formatid) ) {
            $formatid = (int) $formatid;

            // Dateiformat auslesen
            $mapper = new Application_Model_Mappers_GlobalFileformats();
            $fileformat = $mapper->fetchSingleById($formatid)->getFileformat();

            // Aktuelle globale erlaubte Dateiformate
            $allowedfileformats = explode(";", $this->_globalAllowedFileformats->getSettingsValue() );

            // Löschen des zu löschen Dateiformats und Zusammenbau der neuen erlaubten Dateiformate
            $i = 0; // Laufvariable
            foreach ($allowedfileformats as $allowedfileformat) {
                if ($allowedfileformat != $fileformat) {
                    if ($i == 0) {
                        $newallowedfileformats = $allowedfileformat;
                    } else {
                        $newallowedfileformats .= ";" . $allowedfileformat;
                    }
                }
                $i++;
            }

            // DB updaten
            $mapper2 = new Application_Model_Mappers_GlobalSettings();
            $row2 = $mapper2->update('ALLOWED_FILEFORMATS', $newallowedfileformats);

            if ($row2 == 1) {
                // erst wenn geupdatet, wird Dateiformat endgültig gelöscht
                // löschen durchführen
                $delete = $mapper->delete($formatid);
            }


            if ($delete == 1) {
                $this->view->alert = "Du hast das Dateiformat erfolgreich gelöscht.";
            } else {
                $this->view->alert = "Beim Löschen ist leider etwas schief gegangen!";
            }
        } else {
            $this->view->alert = "Du hast kein Dateiformat ausgewählt, dass gelöscht werden soll.";
        }
    }


}







