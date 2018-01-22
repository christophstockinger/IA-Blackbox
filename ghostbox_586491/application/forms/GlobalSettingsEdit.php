<?php

class Application_Form_GlobalSettingsEdit extends Zend_Form
{

    protected $_globalMaxStorage = null;
    protected $_globalFileUpload = null;

    public function __construct($globalMaxStorage, $globalFileUpload)
    {
        $this->_globalMaxStorage = $globalMaxStorage;
        $this->_globalFileUpload = $globalFileUpload;
        parent::__construct();
    }

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */

        $this->setMethod('post');
        $this->setAttrib('class', 'col-12 col-sm-12 settings-form');

        // Maximaler Gesamtspeicher
        $maxStorage = new Zend_Form_Element_Text('maxstorage');
        $maxStorage->setLabel('globaler maximaler Gesamtspeicher in MB (für jeden Nutzer)');
        $maxStorage->setAttrib('class', 'input');
        $maxStorage->setAttrib('placeholder', 'Globaler maximaler Gesamtspeicher in MB');
        $maxStorage->setValue( $this->_globalMaxStorage );

        // Maximaler Datei-Upload
        $maxDataUpload = new Zend_Form_Element_Text('maxfileupload');
        $maxDataUpload->setLabel('Globaler maximaler Datei-Upload in MB (für jeden Nutzer)');
        $maxDataUpload->setAttrib('class', 'input');
        $maxDataUpload->setAttrib('placeholder', 'Globaler maximaler Datei-Upload in MB' );
        $maxDataUpload->setValue( $this->_globalFileUpload );

        // Submit Button
        $submitbutton = new Zend_Form_Element_Button('speichern');
        $submitbutton->setValue('speichern');
        $submitbutton->setAttrib('type', 'submit');
        $submitbutton->setAttrib('class', 'button');

        $this->addElements(array($maxStorage, $maxDataUpload, $submitbutton));

    }


}

