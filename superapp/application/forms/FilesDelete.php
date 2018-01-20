<?php

class Application_Form_FilesDelete extends Zend_Form
{
    protected $_fileid = null;

    public function __construct($fileid)
    {
        $this->_fileid = $fileid;
        parent::__construct();
    }


    public function init()
    {

        $this->setMethod('post');
        $this->setAttrib('class', 'col-12 col-sm-12 files-upload-form');

        // FileId
        $fileid = new Zend_Form_Element_Hidden('fileid');
        $fileid->setValue($this->_fileid);
        //$fileid->setAttribs();

        // Button
        $deletebutton = new Zend_Form_Element_Button('löschen');
        $deletebutton->setAttribs(array('type' => 'submit', 'class' => 'button'));
        $deletebutton->setValue('löschen');


        $this->addElements( array( $fileid, $deletebutton ) );

    }


}

