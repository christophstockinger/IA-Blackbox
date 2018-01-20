<?php

class Application_Form_GlobalFileformatsCreate extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */

        $this->setMethod('POST');
        $this->setAttrib('class', 'col-12 col-sm-12 settings-form');

        // Name des Dateiformats
        $fileformatname = new Zend_Form_Element_Text('fileformat');
        $fileformatname->setLabel('Dateiformat *');
        $fileformatname->setRequired(true);
        $fileformatname->setAttrib('placeholder', 'Dateiformat');
        $fileformatname->setAttrib('class', 'input');


        // Auswahlmöglichkeit der Kategorie
        $formatcategorie = new Zend_Form_Element_Select('formatcategorie');
        $formatcategorie->setLabel('Datei-Format-Kategorie *');
        $formatcategorie->setRequired(true);
        $formatcategorie->setAttrib('class', 'select');
        $formatcategorie->addMultiOptions(array('null'=>'Bitte Kategorie auswählen', 'Grafikformat' => 'Grafikformat', 'Dokumentformat' => 'Dokumentformat', 'Archivierungsformat' => 'Archivierungsformat'));

        // Submit Button
        $submitbutton = new Zend_Form_Element_Button('anlegen');
        $submitbutton->setValue('anlegen');
        $submitbutton->setAttrib('type', 'submit');
        $submitbutton->setAttrib('class', 'button');


        $this->addElements(array($fileformatname, $formatcategorie, $submitbutton));

    }


}

