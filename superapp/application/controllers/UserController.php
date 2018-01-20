<?php

class UserController extends Zend_Controller_Action
{

    protected $_thisUser = null;
    protected $_globalSettings = null;

    public function init()
    {
        /* Initialize action controller here */

        // check auth and get user
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

        // Globale Einstellungen bekommen
        $mapper = new Application_Model_Mappers_GlobalSettings();
        $this->_globalSettings = $mapper->fetchList();

    }

    public function indexAction()
    {
        // check auth
        if (!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));

        $this->view->user = $this->_thisUser;
    }

    public function listAction()
    {
        // action body

        // if already logged in otherwise redirect to start page
        if (!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));

        // create mapper for model user
        $mapper = new Application_Model_Mappers_RawUser();

        // get all user from table RAW_USER via mapper
        $rows = $mapper->fetchList();

        // pass the results to the view
        $this->view->users = $rows;

        // now you can work with the array 'users' in
        // the view SUPERAPP\application\views\scripts\user\list.phtml
        // (and in all other views :-))
    }

    public function viewAction()
    {
        // action body

        // if already logged in otherwise redirect to start page
        if (!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));

        // create mapper for model user
        $mapper = new Application_Model_Mappers_RawUserSettings();

        // get id from querystring
        $id = $this->getRequest()->getParam('id');

        // if id is not avaliable redirect to user list
        if (!$id) $this->redirect($this->getHelper('url')->url(array('controller' => 'user', 'action' => 'list', null), 'default', true));

        // get data from database via mapper
        $row = $mapper->fetchSingleById($id);

        if (!$row) {
            return $this->_redirect($this->getHelper('url')->url(array('controller' => 'user', 'action' => 'list', null), 'default', true));
        }

        // pass the results to the view
        $this->view->user = $row;

        // now you can work with the array 'user' in
        // the view SUPERAPP\application\views\scripts\user\view.phtml
        // (and in all other views :-))
    }

    public function createAction()
    {
        // action body

        // if is NOT logged in - then he can registrate
        // and create a new user
        // otherwise he is logged in: then redirect to user dashboard or wherever you want
        if ($this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));

        $data = $this->getRequest()->getPost();

        // if (($data['firstname'] == "") || ($data['lastname'] == "") || ($data['email'] == "") || ($data['password'] == "")) {
        //     $this->_redirect($this->getHelper('url')->url(array('controller' => 'user', 'action' => 'create', null), 'default', true));
        // }

        if (!empty($data) && !is_null($data['registrieren'])) {

            $mapper = new Application_Model_Mappers_RawUser();
            $allusers = $mapper->fetchList();// List alle User aus
            $lastUserid = 0;
            foreach ($allusers as $user) {
                $userid = $user->getId();;
                if ($userid > $lastUserid) {
                    $lastUserid = $userid;
                }
            }

            $row = $mapper->create($data); // Speichert neuen User


            // Check ob User erstellt wurde
            if ($row == ($lastUserid + 1)) {
                // TODO Ordner anlegen und Raw_User_Settings anlegen!!!!
                // lokalen Speicherordner erstellen
                $foldername = $row . "-" . $data['user_lastname'] . "-" . $data['user_firstname'];
                $foldernamehash = md5($foldername);
                $folderpath = "data/$foldernamehash";
                mkdir($folderpath);
                // Create User-Settings
                // Get Global Settings
                $globalSettings = $this->_globalSettings;

                // DataArray mit UserSettings
                $userSettingsData = array();
                $userSettingsData['userid'] = $row; // User ID
                $userSettingsData['savelocationlocal'] = $foldernamehash; // lokale Speicherung - Ordner wird oben erzeugt
                $userSettingsData['savecloud'] = 0;
                $userSettingsData['savelocationcloud'] = ""; // Cloud Speicherort
                $userSettingsData['usernamecloud'] = ""; // Cloud Benutzername
                $userSettingsData['passwordcloud'] = ""; // Cloud Passwort
                foreach ($globalSettings as $globalSetting) {
                    $key = $globalSetting->getSettingsName();
                    $key = strtolower($key);
                    $key = str_replace("_", "", $key);
                    $value = $globalSetting->getSettingsValue();
                    $userSettingsData[$key] = $value; // Max Storage , Max File Upload und Allowed FileFormats
                }

                if (!empty($userSettingsData) && isset($userSettingsData['userid'])) {
                    $mapper = new Application_Model_Mappers_RawUserSettings();
                    $userSettingsRow = $mapper->create($userSettingsData);

                    if ($userSettingsRow == $row) {
                        $this->_redirect($this->getHelper('url')->url(array('controller' => 'user', 'action' => 'login', null), 'default', true));
                    } else {
                        $mapper = new Application_Model_Mappers_RawUser();
                        $mapper->deleteUserRegistration($row);

                        $this->view->errormessage = "Bei der Registrierung ist ein Problem aufgetreten! Bitte versuche es erneut.";
                    }
                }

            } else {
                $this->view->errormessage = "Die E-Mail-Adresse ist bereits in der Blackbox gespeichert. Bitte melde dich an.";
            }


        }


        $form = new Application_Form_UserCreate();
        $this->view->form = $form;

    }

    public function updateAction()
    {
        // action body


        // when user is logged in
        // then he allowd to update himself
        if (!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));

        // generate new edit form for user settings
        $form = new Application_Form_UserUpdate($this->_thisUser);
        $this->view->form = $form;

        // Formularinhalte holen
        $data = $this->getRequest()->getPost();

        if (!empty($data) && !is_null($data['speichern'])) {
            // get userid from request data
            $userid = (int)$data['user_id'];


            // set data in database via mapper
            $mapper = new Application_Model_Mappers_RawUser();
            // when userid has a value
            if ($userid) {
                $row = $mapper->update($userid, $data);

                if ($row == $userid) {
                    $this->_redirect($this->getHelper('url')->url(array('controller' => 'user', 'action' => 'index', null), 'default', true));
                }
            }
        }
    }

    public function deleteAction()
    {
        // action body

        // only when user is logged in
        // otherwise redirect him to the start page
        if (!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));

        // create mapper for model user
        $mapper = new Application_Model_Mappers_RawUser();

        // get id from querystring
        $id = $this->_thisUser->getId();


        // when user not found in database then return to user list
        if (!$id) {
            return $this->_redirect($this->getHelper('url')->url(array('controller' => 'user', 'action' => 'index', null), 'default', true));
        }

        // then delete user
        $mapper->delete($id);
        Zend_Session::destroy();

    }

    public function loginAction()
    {
        // action body

        // only when logged out = user is NOT logged in
        // see above: init()
        // if already logged in then redirect to dashboard or wherever you want
        //if($this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'list', null), 'default', true));

        //Zend_Debug::dump($this->_thisUser);

        // create mapper for model user
        $mapper = new Application_Model_Mappers_RawUser();

        // get formular data
        $data = $this->getRequest()->getPost();

        // check, if formular has data AND has been submitted
        if (!empty($data) && !is_null($data['user_submit'])) {
            // get email from request data
            $email = $data['user_email'];

            // get data from database via mapper
            // when email has a value
            if ($email) {
                //$row = $mapper->fetchSingleByEmail($email);
            }

            $user = null;
            $auth = Zend_Auth::getInstance();
            $user = New Application_Model_DbTable_RawUser();
            $authAdapter = new Zend_Auth_Adapter_DbTable($user->getAdapter(), 'RAW_USER');
            $authAdapter->setIdentityColumn('EMAIL')
                ->setCredentialColumn('PASSWORD');
            $authAdapter->setIdentity($data['user_email'])
                ->setCredential($data['user_password']);
            $result = $auth->authenticate($authAdapter);
            if ($result->isValid()) {

                $storage = new Zend_Auth_Storage_Session();
                $storage->write($authAdapter->getResultRowObject());

                // if you want to set a logindate in the table RAW_USER
                // then configure the mapper-function login()
                // and uncomment the following line
                /*
                $data = $storage->read();
                $email = $data->EMAIL;
                $user = $mapper->fetchSingleByEmail($email);
                $mapper->login($user->getId());
                */

                // and return to dashboard or wherever you want
                return $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index'), 'default', true));

            } else {
                // wrong login data
                // do whatever is necessary
            }


        }


        // --> if you reach this point, no formular has been shown
        // or submitted - so do it now

        // create new formular for deletion
        $form = new Application_Form_UserLogin();

        // pass the results to the view
        $this->view->form = $form;

        // now you can work with the array variable 'form'
        // ('form' contains the complete HTML-code of the formular which is
        // set in the file SUPERAPP\application\forms\UserLogin.php)
        // in the view SUPERAPP\application\views\scripts\user\login.phtml
        // (and in all other views :-))
    }

    public function logoutAction()
    {
        // action body

        // only when logged in!!!
        //if(!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));

        // clear auth instance
        if (!Zend_Auth::getInstance()->clearIdentity()) {
            // create message or do nothing
        }

        // destroy session
        if (!Zend_Session::destroy()) {
            // create message or do nothing;
        }

        // redirect to start page
        $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));
    }

    public function dashboardAction()
    {
        // action body
        if (Zend_Auth::getInstance()->hasIdentity()) {
            echo "eingeloggt!";
        } else {
            $this->_redirect($this->getHelper('url')->url(array('controller' => 'user', 'action' => 'login', null), 'default', true));
        }

    }


}

















