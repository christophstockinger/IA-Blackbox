<?php

class Application_Form_UserSettingsEdit extends Zend_Form
{

    protected $_userSettings = null;

    public function __construct($usersettings)
    {
        $this->_userSettings = $usersettings;
        parent::__construct();


    }

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('class', 'col-12 col-sm-12 settings-form');

        // hidden field for userid
        $userid = new Zend_Form_Element_Hidden('userid');
        $userid->setRequired(true);
        $userid->setAttribs(array('class' => 'input', 'placeholder' => 'Userid'));
        $userid->setValue($this->_userSettings->getUserId());

        // checkbox for save in cloud
        $savecloud = new Zend_Form_Element_Checkbox('savecloud');
        $savecloud->setLabel('In der Dropbox speichern?');
        $savecloud->setAttribs(array('id' => 'savecloud', 'checked' => $this->_userSettings->getSaveCloud()));

        // field for save location cloud
        $savelocationcloud = new Zend_Form_Element_Text('savelocationcloud');
        $savelocationcloud->setLabel('Speicherort in der Cloud');
        $savelocationcloud->setAttribs(array('id' => 'savelocationcloud', 'class' => 'input', 'placeholder' => 'Dein Speicherort in der Dropbox'));
        $savelocationcloud->setValue( $this->_userSettings->getSaveLocationCloud() );

        // field for save username cloud
        $usernamecloud = new Zend_Form_Element_Text('usernamecloud');
        $usernamecloud->setLabel('Dropbox Benutzername');
        $usernamecloud->setAttribs(array('id' => 'usernamecloud', 'class' => 'input half', 'placeholder' => 'Dein Dropbox Benutzername'));
        $usernamecloud->setValue( $this->_userSettings->getUsernameCloud() );

        // field for save password cloud
        $passwordcloud = new Zend_Form_Element_Text('passwordcloud');
        $passwordcloud->setLabel('Dropbox Passwort');
        $passwordcloud->setAttribs(array('id' => 'passwordcloud', 'class' => 'input half password', 'placeholder' => 'Dein Dropbox Passwort'));
        $passwordcloud->setValue( $this->_userSettings->getPasswordCloud() );

        // field for max file upload
        $maxfileupload = new Zend_Form_Element_Text('maxfileupload');
        $maxfileupload->setLabel('Deine maximale Datei-Upload-Grenze in MB');
        $maxfileupload->setAttribs(array('class' => 'input', 'placeholder' => 'Deine Obergrenze für einen File-Upload (MB)'));
        $maxfileupload->setValue( $this->_userSettings->getMaxFileUpload() );

        // field for max storage
        $maxstorage = new Zend_Form_Element_Text('maxstorage');
        $maxstorage->setLabel('Dein maximaler Gesamtspeicher in MB');
        $maxstorage->setAttribs(array('class' => 'input', 'placeholder' => 'Dein maximaler Gesamtspeicher (MB)'));
        $maxstorage->setValue( $this->_userSettings->getMaxStorage() );

        // Submit Button
        $submitbutton = new Zend_Form_Element_Button('speichern');
        $submitbutton->setAttribs(array('type' => 'submit', 'class' => 'button'));
        $submitbutton->setValue( 'speichern' );

        $this->addElements( array($userid, $savecloud, $savelocationcloud, $usernamecloud, $passwordcloud, $maxfileupload, $maxstorage, $submitbutton ));
    }
}
