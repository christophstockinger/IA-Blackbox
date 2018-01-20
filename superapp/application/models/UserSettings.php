<?php

class Application_Model_UserSettings
{

    protected $_userid = null;
    protected $_savelocationlocal = null;
    protected $_savecloud = null;
    protected $_savelocationcloud = null;
    protected $_usernamecloud = null;
    protected $_passwordcloud = null;
    protected $_maxfileupload = null;
    protected $_maxstorage = null;
    protected $_allowedfileformats = null;

    public function setUserId($userid)
    {
        $userid = (int)$userid;
        if ($userid != 0) {
            $this->_userid = $userid;
        }
    }

    public function getUserId()
    {
        return $this->_userid;
    }

    public function setSaveLocationLocal($savelocationlocal)
    {
        if (is_string($savelocationlocal)) {
            $this->_savelocationlocal = $savelocationlocal;
        }
    }

    public function getSaveLocationLocal()
    {
        return $this->_savelocationlocal;
    }

    public function setSaveCloud($savecloud)
    {
        $savecloud = (int)$savecloud;
        switch ($savecloud) {
            case 0:
                $this->_savecloud = false;
                break;
            case 1:
                $this->_savecloud = true;
                break;
        }
    }

    public function getSaveCloud()
    {
        return $this->_savecloud;
    }

    public function setSaveLocationCloud($savelocationcloud)
    {
        if (is_string($savelocationcloud)) {
            $this->_savelocationcloud = $savelocationcloud;
        }
    }

    public function getSaveLocationCloud()
    {
        return $this->_savelocationcloud;
    }

    public function setUsernameCloud($usernamecloud)
    {
        if (is_string($usernamecloud)) {
            $this->_usernamecloud = $usernamecloud;
        }
    }

    public function getUsernameCloud()
    {
        return $this->_usernamecloud;
    }

    public function setPasswordCloud($passwordcloud)
    {
        if (is_string($passwordcloud)) {
            $this->_passwordcloud = $passwordcloud;
        }
    }

    public function getPasswordCloud()
    {
        return $this->_passwordcloud;
    }

    public function setMaxFileUpload($maxfileupload)
    {
        $maxfileupload = (int)$maxfileupload;
        if ($maxfileupload >= 0) {
            $this->_maxfileupload = $maxfileupload;
        }
    }

    public function getMaxFileUpload()
    {
        return $this->_maxfileupload;
    }

    public function setMaxStorage($maxstorage)
    {
        $maxstorage = (int)$maxstorage;
        if ($maxstorage >= 0) {
            $this->_maxstorage = $maxstorage;
        }
    }

    public function getMaxStorage()
    {
        return $this->_maxstorage;
    }

    public function setAllowedFileFormats($allowedfileformats)
    {
        if (is_string($allowedfileformats)) {
            $this->_allowedfileformats = $allowedfileformats;
        }
    }

    public function getAllowedFileFormats()
    {
        return explode(";", $this->_allowedfileformats);

    }

    public function toArray()
    {
        $data = array(
            'userid' => $this->getUserId(),
            'savelocationlocal' => $this->getSaveLocationLocal(),
            'savecloud' => $this->getSaveCloud(),
            'savelocationcloud' => $this->getSaveLocationCloud(),
            'usernamecloud' => $this->getUsernameCloud(),
            'passwordcloud' => $this->getPasswordCloud(),
            'maxfileupload' => $this->getMaxFileUpload(),
            'maxstorage' => $this->getMaxStorage(),
            'allowedfileformats' => $this->getAllowedFileFormats()
        );

        return $data;
    }


}

