<?php

class Application_Form_FilesCreate extends Zend_Form
{
    protected $_savecloud = null;

    public function __construct($savecloud)
    {
        $this->_savecloud = $savecloud;
        parent::__construct();
    }

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */

        $this->setMethod('post');
        $this->setAttrib('class', 'col-12 col-sm-12 files-upload-form');
        $this->setAttrib('enctype', 'multipart/form-data');

        // File
        $file = new Zend_Form_Element_File('file');
        //$file->setLabel('Dein Nachname *');
        $file->setRequired(true);
        $file->setAttribs(array('class' => 'input', 'placeholder' => 'Dein Nachname'));

        // Fileanzeigename
        $filedisplayname = new Zend_Form_Element_Text('filedisplayname');
        $filedisplayname->setLabel('Dateiname *');
        $filedisplayname->setRequired(true);
        $filedisplayname->setAttribs(array('class' => 'input', 'placeholder' => 'Dateiname'));

        // Tags
        $tags = new Zend_Form_Element_Textarea('tags');
        $tags->setLabel('Deine Tags *');
        $tags->setRequired(true);
        $tags->setAttribs(array('class' => 'textarea', 'placeholder' => 'Deine Tags'));


        // Save Local
        $saveLocal = new Zend_Form_Element_Checkbox('savelocal');
        $saveLocal->setLabel('In der Blackbox speichern?');

        // Save Cloud
        if ($this->_savecloud) {
            $saveCloud = new Zend_Form_Element_Checkbox('savecloud');
            $saveCloud->setLabel('In der Dropbox speichern?');
        }

        // Public
        $public = new Zend_Form_Element_Checkbox('public');
        $public->setLabel('Datei öffentlich zur Verfügung stellen?');

        // Submit Button
        $submitbutton = new Zend_Form_Element_Button('hochladen');
        $submitbutton->setAttribs(array('type' => 'submit', 'class' => 'button'));
        $submitbutton->setValue('hochladen');

        if ($this->_savecloud) {
            $this->addElements( array( $file, $filedisplayname, $tags, $saveLocal, $saveCloud, $public, $submitbutton ) );
        } else {
            $this->addElements( array( $file, $filedisplayname, $tags, $saveLocal, $public, $submitbutton ) );
        }


    }


}

