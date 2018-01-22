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
        //if (!$this->_thisUser) $this->_redirect($this->getHelper('url')->url(array('controller' => 'index', 'action' => 'index', null), 'default', true));
        $form = new Application_Form_FilesSearch();
        $this->view->form = $form;


    }

}



