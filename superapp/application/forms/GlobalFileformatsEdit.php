<?php

class Application_Form_GlobalFileformatsEdit extends Zend_Form
{

    protected $_fileformat;

    public function __construct($fileformat)
    {
        $this->_fileformat = $fileformat;
        parent::__construct();
    }

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */

        $this->setMethod('post');
        $this->setAttrib('class', 'col-12 col-sm-12 settings-form');

        $formatid = new Zend_Form_Element_Hidden('formatid');
        $formatid->setRequired(true);
        $formatid->setValue($this->_fileformat->getFormatid());

        // Name des Dateiformats
        $fileformatname = new Zend_Form_Element_Text('fileformat');
        $fileformatname->setLabel('Dateiformat *');
        $fileformatname->setRequired(true);
        $fileformatname->setAttrib('placeholder', 'Dateiformat');
        $fileformatname->setAttrib('class', 'input');
        $fileformatname->setValue($this->_fileformat->getFileformat());


        // Auswahlmöglichkeit der Kategorie
        $formatcategorie = new Zend_Form_Element_Select('formatcategorie');
        $formatcategorie->setLabel('Datei-Format-Kategorie *');
        $formatcategorie->setRequired(true);
        $formatcategorie->setAttrib('class', 'select');

        $formatcategorie->setValue($this->_fileformat->getFormatCategorie());
        $formatcategorie->addMultiOptions(array('null' => 'Bitte Kategorie auswählen', 'Grafikformat' => 'Grafikformat', 'Dokumentformat' => 'Dokumentformat', 'Archivierungsformat' => 'Archivierungsformat'));

        // Submit Button
        $submitbutton = new Zend_Form_Element_Button('speichern');
        $submitbutton->setValue('speichern');
        $submitbutton->setAttrib('type', 'submit');
        $submitbutton->setAttrib('class', 'button');

        $this->addElements(array($formatid, $fileformatname, $formatcategorie, $submitbutton));
    }


}

