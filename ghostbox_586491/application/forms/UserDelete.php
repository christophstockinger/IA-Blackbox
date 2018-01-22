<?php

class Application_Form_UserDelete extends Zend_Form{

    public function init(){
        /* Form Elements & Other Definitions Here ... */
		$this->setMethod('POST');
		// $this->setAttrib('class', 'form-');
        
        $this->addElement('Text', 'user_id', array(
            'required'       => true,
            'label'          => 'label_user_delete_id',
			'placeholder'    => 'id',
            'class'          => 'hidden',
            'filters'        => array('StringTrim'),
        ));
                
        $this->addElement('Submit', 'user_submit', array(
            'label'         => 'Benutzer Löschen',
			'class'         => 'btn btn-danger',
        ));
		
		// remove decorators
		foreach($this->getElements() as $elem) {
			$elem->setDecorators(array(
			    array('ViewHelper'),
				array('Errors')
			));
		}
        	
       /*  $this->getElement('user_nickname')->getDecorator('Description')
            ->setOption('placement', 'prepend');
        $this->getElement('user_password')->getDecorator('Description')
            ->setOption('placement', 'prepend'); */
    }
}