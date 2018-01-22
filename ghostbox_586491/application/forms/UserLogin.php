<?php

class Application_Form_UserLogin extends Zend_Form{

    public function init(){
        $this->setMethod('POST');
        $this->setAttrib('class', 'col-12 col-sm-12 col-md-6 settings-form loginform');


        // field for email
        $email = new Zend_Form_Element_Text('user_email');
        $email->setRequired(true);
        $email->setAttribs(array('class' => 'input', 'placeholder' => 'Deine E-Mail-Adresse'));

        // field for passwort
        // field for Passwort
        $password = new Zend_Form_Element_Text('user_password');
        $password->setRequired(true);
        $password->setAttribs(array('class' => 'input password', 'placeholder' => 'Dein Passwort'));

        // Submit Button
        $submitbutton = new Zend_Form_Element_Button('user_submit');
        $submitbutton->setAttribs(array('type' => 'submit', 'class' => 'button'));
        $submitbutton->setValue('anmelden');
        $submitbutton->setLabel('anmelden');

        $this->addElements( array( $email, $password, $submitbutton ) );

    }
}