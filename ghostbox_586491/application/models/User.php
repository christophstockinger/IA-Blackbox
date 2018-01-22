<?php

class Application_Model_User{
	protected $_id = null;
    protected $_firstname = null;
    protected $_lastname = null;
    protected $_email = null;
    protected $_password = null;
    protected $_createdate = null;
    protected $_updatedate = null;
    protected $_deletedate = null;
    
    public function setId($id){
        $id = (int) $id;
        if ($id != 0){
            $this->_id = $id;
        } 
    }
    
    public function getId(){
        return $this->_id;
    }
    
    public function setFirstname($value){
        if (is_string($value)){
            $this->_firstname = $value;
        } 
    }
    
    public function getFirstname(){
        return $this->_firstname;
    }
	
	public function setLastname($value){
        if (is_string($value)){
            $this->_lastname = $value;
        } 
    }
    
    public function getLastname(){
        return $this->_lastname;
    }
	
	public function setEmail($value){
        if (is_string($value)){
            $this->_email = $value;
        } 
    }
    
    public function getEmail(){
        return $this->_email;
    }
	
	public function setPassword($value){
        if (is_string($value)){
            $this->_password = $value;
        } 
    }
	
	public function getPassword(){
        return $this->_password;
    }
    
	public function setCreatedate($value){
        if (is_string($value)){
            $this->_createdate = $value;
        } 
    }
    
    public function getCreatedate(){
        return $this->_createdate;
    }
	
	public function setUpdatedate($value){
        if (is_string($value)){
            $this->_updatedate = $value;
        } 
    }
    
    public function getUpdatedate(){
        return $this->_updatedate;
    }
	
	public function setDeletedate($value){
        if (is_string($value)){
            $this->_deletedate = $value;
        } 
    }
    
    public function getDeletedate(){
        return $this->_deletedate;
    }    
    
    public function toArray(){
        $data = array(
            'user_id'			=> $this->getId(),
            'user_firstname'	=> $this->getFirstname(),
            'user_lastname'		=> $this->getLastname(),
            'user_email'		=> $this->getEmail(),
            'user_password'		=> $this->getPassword(),
            'user_createdate'	=> $this->getCreatedate(),
            'user_updatedate'	=> $this->getUpdatedate(),
            'user_deletedate'	=> $this->getDeletedate(),
        );
        
        return $data;
    }
}