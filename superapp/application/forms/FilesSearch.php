<?php

class Application_Form_FilesSearch extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");
        $this->setAttrib("class", "col-12 col-sm-12 search-form");
        $this->setAction("/files/");

        $search = new Zend_Form_Element_Text('search');
        $search->setRequired(true);
        $search->setAttribs(array('class' => 'input', 'placeholder' => 'Suche nach Tags'));

        $button = new Zend_Form_Element_Button('suchen');
        $button->setAttribs(array('type' => 'submit', 'class' => 'button'));
        $button->setValue('registrieren');

        $this->addElements(array($search, $button));
    }


}

