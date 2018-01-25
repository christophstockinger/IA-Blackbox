<?php

class IndexController extends Zend_Controller_Action
{

    protected $_thisUser = null;

    public function init()
    {
        /* Initialize action controller here */

        // check auth and get user
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $mapper = new Application_Model_Mappers_RawUser();
            $this->_thisUser = $mapper->fetchSingleById(Zend_Auth::getInstance()->getStorage()->read()->ID);
            $this->view->thisUser = $this->_thisUser;
        }


    }

    public function indexAction()
    {
        // Ausgabe der Suchform
        $form = new Application_Form_FilesSearch();
        $this->view->form = $form;


    }

}



