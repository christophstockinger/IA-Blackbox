<?php

class Application_Form_UserCreate extends Zend_Form
{

    public function init()
    {
        $this->setMethod('POST');
        $this->setAttrib('class', 'col-12 col-sm-12 settings-form');


        // field for firstname
        // field for save location cloud
        $firstname = new Zend_Form_Element_Text('user_firstname');
        $firstname->setLabel('Dein Vorname *');
        $firstname->setRequired(true);
        $firstname->setAttribs(array('class' => 'input', 'placeholder' => 'Dein Vorname', 'required' => ''));

        // field for lastname
        $lastname = new Zend_Form_Element_Text('user_lastname');
        $lastname->setLabel('Dein Nachname *');
        $lastname->setRequired(true);
        $lastname->setAttribs(array('class' => 'input', 'placeholder' => 'Dein Nachname', 'required' => ''));

        // field for email
        $email = new Zend_Form_Element_Text('user_email');
        $email->setLabel('Deine E-Mail-Adresse *');
        $email->setRequired(true);
        $email->setAttribs(array('class' => 'input', 'placeholder' => 'Deine E-Mail-Adresse', 'required' => ''));

        // field for Passwort
        $password = new Zend_Form_Element_Text('user_password');
        $password->setLabel('Dein Passwort *');
        $password->setRequired(true);
        $password->setAttribs(array('class' => 'input password', 'placeholder' => 'Dein Passwort', 'required' => ''));

        // Submit Button
        $submitbutton = new Zend_Form_Element_Button('registrieren');
        $submitbutton->setAttribs(array('type' => 'submit', 'class' => 'button'));
        $submitbutton->setValue('registrieren');

        $this->addElements( array( $firstname, $lastname, $email, $password, $submitbutton ) );
    }


}

