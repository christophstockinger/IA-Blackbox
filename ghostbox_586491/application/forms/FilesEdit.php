<?php

class Application_Form_FilesEdit extends Zend_Form
{

    protected $_filedata = null;
    protected $_savecloud = null;

    public function __construct($savecloud, $filedata)
    {
        $this->_savecloud = $savecloud;
        $this->_filedata = $filedata;
        parent::__construct();
    }

    public function init()
    {
        $value = "";

        $this->setMethod('post');
        $this->setAttrib('class', 'col-12 col-sm-12 files-upload-form');
        $this->setAttrib('enctype', 'multipart/form-data');

        // Fileanzeigename
        $filedisplayname = new Zend_Form_Element_Text('filedisplayname');
        $filedisplayname->setLabel('Dateiname *');
        $filedisplayname->setRequired(true);
        $filedisplayname->setAttribs(array('class' => 'input', 'placeholder' => 'Dateiname'));
        $filedisplayname->setValue($this->_filedata->getFileDisplayname());

        // Tags
        $tags = new Zend_Form_Element_Textarea('tags');
        $tags->setLabel('Deine Tags *');
        $tags->setRequired(true);
        $tags->setAttribs(array('class' => 'textarea'));
        $savedtags = explode (";", $this->_filedata->getFiletags() );
        foreach ($savedtags as $tag) {
            $value .= $tag . " ";
        }
        $tags->setValue($value);


        // Save Local
        $saveLocal = new Zend_Form_Element_Checkbox('savelocal');
        $saveLocal->setLabel('In der Blackbox speichern?');
        if ($this->_filedata->getSavelocal() == 1) {
            $saveLocal->setAttribs(array('checked' => 'checked'));
        }

        // Save Cloud
        if ($this->_savecloud) {
            $saveCloud = new Zend_Form_Element_Checkbox('savecloud');
            $saveCloud->setLabel('In der Dropbox speichern?');
            if ($this->_filedata->getSavecloud() == 1) {
                $saveCloud->setAttribs(array('checked' => 'checked'));
            }
        }

        // Public
        $public = new Zend_Form_Element_Checkbox('public');
        $public->setLabel('Datei öffentlich zur Verfügung stellen?');
        if ($this->_filedata->getPublic() == 1) {
            $public->setAttribs(array('checked' => 'checked'));
        }

        // Submit Button
        $submitbutton = new Zend_Form_Element_Button('speichern');
        $submitbutton->setAttribs(array('type' => 'submit', 'class' => 'button'));
        $submitbutton->setValue('speichern');

        if ($this->_savecloud) {
            $this->addElements(array($filedisplayname, $tags, $saveLocal, $saveCloud, $public, $submitbutton));
        } else {
            $this->addElements(array($filedisplayname, $tags, $saveLocal, $public, $submitbutton));
        }

    }


}

