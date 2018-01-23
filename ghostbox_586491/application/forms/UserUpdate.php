<?php

class Application_Form_UserUpdate extends Zend_Form
{
    protected $_user;

    public function __construct($user)
    {
        $this->_user = $user;
        parent::__construct();
    }

    public function init()
    {
        $this->setMethod('POST');
        $this->setAttrib('class', 'col-12 col-sm-12 settings-form');


        // hidden field for userid
        $userid = new Zend_Form_Element_Hidden('user_id');
        $userid->setRequired(true);
        $userid->setAttribs(array('class' => 'input', 'placeholder' => 'Userid'));
        $userid->setValue($this->_user->getId());


        // field for firstname
        // field for save location cloud
        $firstname = new Zend_Form_Element_Text('user_firstname');
        $firstname->setLabel('Dein Vorname');
        $firstname->setRequired(true);
        $firstname->setAttribs(array('class' => 'input', 'placeholder' => 'Dein Vorname', 'required' => ''));
        $firstname->setValue($this->_user->getFirstname());

        // field for lastname
        $lastname = new Zend_Form_Element_Text('user_lastname');
        $lastname->setLabel('Dein Nachname');
        $lastname->setRequired(true);
        $lastname->setAttribs(array('class' => 'input', 'placeholder' => 'Dein Nachname', 'required' => ''));
        $lastname->setValue($this->_user->getLastname());

        // field for Passwort
        $password = new Zend_Form_Element_Text('user_password');
        $password->setLabel('Dein Passwort');
        $password->setRequired(true);
        $password->setAttribs(array('class' => 'input password', 'placeholder' => 'Dein Passwort', 'required' => ''));
        $password->setValue($this->_user->getPassword());

        // save Button
        // Submit Button
        $submitbutton = new Zend_Form_Element_Button('speichern');
        $submitbutton->setAttribs(array('type' => 'submit', 'class' => 'button'));
        $submitbutton->setValue('speichern');

        $this->addElements(array($userid, $firstname, $lastname, $password, $submitbutton));

    }

}

