<?php

class FilesController extends Zend_Controller_Action
{

    protected $_thisUser = null;

    protected $_thisUserSettings = null;

    public function init()
    {
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
    }

    public function indexAction()
    {
        // check auth

        // get data
        $data = $this->getRequest()->getPost();

        if (!empty($data) && isset($data['suchen'])) {
            // New Mapper
            $filemapper = new Application_Model_Mappers_RawFiles();

            // Explode Tags
            $tags = explode(" ", $data['search']);

            $mapper = new Application_Model_Mappers_RawFiles();
            $results = $mapper->fetchFilesByTag($tags);

            $resultdata = array();

            if ($results == null) {
               $resultdata = 0;
            } else {

                if (!$this->_thisUser) {
                    // Keine User angemeldet
                    // nur public Dateien
                    foreach ($results as $result) {
                        $result = $result->toArray();
                        $locationmapper = new Application_Model_Mappers_RawUserSettings();
                        $result['location'] = $locationmapper->fetchSingleByUserId($result['userid'])->getSaveLocationLocal();
                        if ($result['public'] == 1) {
                            $resultdata[] = $result;
                        }
                    }
                } else {
                    // User angemeldet
                    // nur seine Dateien
                    foreach ($results as $result) {
                        $result = $result->toArray();
                        $locationmapper = new Application_Model_Mappers_RawUserSettings();
                        $result['location'] = $locationmapper->fetchSingleByUserId($result['userid'])->getSaveLocationLocal();
                        if ($result['userid'] == $this->_thisUser->getId()) {
                            $resultdata[] = $result;
                        }
                    }
                }



            }

            $this->view->resultdata = $resultdata;
        }


        $form = new Application_Form_FilesSearch();
        $this->view->form = $form;
        $this->view->user = $this->_thisUser;
    }

    public function createAction()
    {
        // check auth
        if (!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));


        // Get data
        $data = $this->getRequest()->getPost();
        // Get Filedata
        $file = new Zend_File_Transfer();
        // Übergabe von Filedata an data
        foreach ($file->getFileInfo()['file'] as $key => $filedata) {
            $data[$key] = $filedata;
        }
        $data['namehash'] = base64_encode($data['name']);
        //$file->receive();
        // Get Userid
        $data['userid'] = $this->_thisUser->getId();
        // Get and edit Fileformat
        $data['fileformat'] = strtoupper(pathinfo($data['name'], PATHINFO_EXTENSION));

        // Check ob data gesetzt ist
        if (!empty($data) && isset($data['hochladen'])) {

            // Mapper erstellen
            $mapper = new Application_Model_Mappers_RawFiles();

            /*
             * Fileformat Check
             */
            $fileformat = $data['fileformat'];
            $userFileformats = $this->_thisUserSettings->getAllowedFileFormats();

            if (in_array($fileformat, $userFileformats)) {

                /*
                 * Filesize Check
                 */
                $filesize = $data['size'];
                $maxUserFilesize = ($this->_thisUserSettings->getMaxFileUpload()) * 1024;

                if ($filesize <= $maxUserFilesize) {

                    /*
                     * Storage Check
                     */
                    // Berechnung der aktuellen Storage-Größe
                    $storage = $mapper->fetchFilesByUserid($data['userid']);
                    $storagesize = 0;
                    if (!$storage) {
                        $storagesize = 0;
                    } else {
                        if (is_array($storage)) {
                            foreach ($storage as $storagefile) {
                                $storagesize += $storagefile->getFilesize();
                            }
                        }
                    }

                    $maxStoragesize = ($this->_thisUserSettings->getMaxStorage()) * 1024;

                    if (($storagesize + $filesize) <= $maxStoragesize) {

                        /*
                         * Tags Check
                         */
                        if ($data['tags'] != "") {

                            $data['tags'] = str_replace(" ", ";", $data['tags']);

                            if ($data['tags'] == false) {
                                // Fehlermeldung beim Exploden der Tags
                                $this->view->errormessage = "Bei der Verarbeitung der Tags ist ein Fehler aufgetreten. Bitte versuche es nochmal.";
                            } else {


                                // Get hochgeloadene Tmp-Datei
                                $tmpName = $data['tmp_name'];
                                // Save-Path für lokale Speicherung
                                $localFilepath = "data/" . $this->_thisUserSettings->getSaveLocationLocal() . "/" . $data['namehash'];


                                // Save-Location Checks / Search
                                if (($data['savelocal'] == 1) && ($data['savecloud'] == 1)) {

                                    /*
                                     * lokale und cloud Speicherung ausgewählt
                                     */

                                    // DB Write
                                    $fileid = $mapper->create($data);

                                    if ($fileid != 0) {
                                        // lokale Speicherung
                                        move_uploaded_file($tmpName, $localFilepath);
                                        // TODO API anfragen
                                        $this->redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index'), 'default', true));
                                    } else {
                                        // Fehlermeldung für DB-Write-Fehler
                                        $this->view->errormessage = "Bei der Speicherung der Datei ist ein Fehler unterlaufen!";
                                    }
                                } else if ($data['savelocal'] == 1) {

                                    /*
                                     * nur lokale Speicherung ausgewählt
                                     */

                                    // DB Write
                                    $fileid = $mapper->create($data);

                                    if ($fileid != 0) {
                                        // lokale Speicherung
                                        move_uploaded_file($tmpName, "$localFilepath");
                                        $this->redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index'), 'default', true));
                                    } else {
                                        // Fehlermeldung für DB-Write-Fehler
                                        $this->view->errormessage = "Bei der Speicherung der Datei ist ein Fehler unterlaufen!";
                                    }
                                } else if ($data['savecloud'] == 1) {

                                    /*
                                     * nur cloud Speicherung ausgewählt
                                     */

                                    // DB Write
                                    $fileid = $mapper->create($data);

                                    if ($fileid != 0) {
                                        // TODO API anfragen
                                        $this->redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index'), 'default', true));
                                    } else {
                                        // Fehlermeldung für DB-Write-Fehler
                                        $this->view->errormessage = "Bei der Speicherung der Datei ist ein Fehler unterlaufen!";
                                    }
                                } else {
                                    // Fehlermeldung für nicht ausgewählte Speichermöglichkeit
                                    $this->view->errormessage = "Deine Datei konnte aufgrund fehlender Speicherort-Information nicht gespeichert werden.";
                                }
                            }
                        } else {
                            // Fehlermeldung für nicht vorhandene Tags
                            $this->view->errormessage = "Bitte vergebe Tags für deine Datei!";
                        }
                    } else {
                        // Fehlermeldung für die Überschreitung des Storage
                        $this->view->errormessage = "Durch den Datei-Upload überschreitest du deine Gesamtspeichergröße.";
                    }
                } else {
                    // Fehlermledung für die Überschreitung der Upload-Grenze
                    $this->view->errormessage = "Deine Datei ist leider zu groß.";
                }
            } else {
                // Fehlermeldung für falsches Dateiformat
                $this->view->errormessage = "Deine Datei entspricht leider nicht einem der erlaubten Dateiformate.";
            }
        }


        $form = new Application_Form_FilesCreate($this->_thisUserSettings->getSaveCloud());
        $this->view->form = $form;

    }

    public function editAction()
    {
        // check auth
        if (!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));

        // FileId from Param
        $fileid = $this->getRequest()->getParam('fileid');



        // get data
        $data = $this->getRequest()->getPost();

        if (!empty($data) && isset($data['speichern'])) {
            $mapper = new Application_Model_Mappers_RawFiles();
            $data['tags'] = str_replace(" ", ";", $data['tags']);

            $row = $mapper->update($fileid, $data);
            // Check ob Filedaten geändert wurden
            if ($row != 0) {
                // Ja
                    $this->redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index'), 'default', true));
            } else {
                // Nein
                    $this->view->errormessage = "Beim Speichern ist ein Fehler unterlaufen.";
            }

        }

        // get Filedata
        $filemapper = new Application_Model_Mappers_RawFiles();
        $filedata = $filemapper->fetchFileByFileid((int)$fileid);

        // Form create
        $form = new Application_Form_FilesEdit($this->_thisUserSettings->getSaveCloud(), $filedata);
        $this->view->form = $form;

        $this->view->fileid = $fileid;
    }

    public function deleteAction()
    {
        // check auth
        if (!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));

        $fileid = $this->getRequest()->getParam('fileid');


        $form = new Application_Form_FilesDelete($fileid);

        $data = $this->getRequest()->getPost();

        if (!empty($data) && isset($data['löschen'])) {
            $mapper = new Application_Model_Mappers_RawFiles();
            $filedelete = $mapper->delete( (int)$fileid );

            if ($filedelete) {
                $this->view->message = "Die Datei wurde erfolgreich gelöscht.";
            } else {
                $this->view->form = $form;
            }
        }

        $this->view->form = $form;

    }


}







