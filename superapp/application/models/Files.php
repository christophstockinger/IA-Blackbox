<?php

class Application_Model_Files
{
    protected $_fileid = null;
    protected $_filename = null;
    protected $_fileformat = null;
    protected $_filedisplayname = null;
    protected $_filesize = null;
    protected $_savelocal = null;
    protected $_savecloud = null;
    protected $_userid = null;
    protected $_createdate = null;
    protected $_deletedate = null;
    protected $_public = null;


    public function setFileid($fileid)
    {
        $fileid = (int)$fileid;
        if (!is_null($fileid)) {
            $this->_fileid = $fileid;
        }
    }

    public function getFileid()
    {
        return $this->_fileid;
    }

    public function setFilename($filename)
    {
        if (is_string($filename)) {
            $this->_filename = $filename;
        }
    }

    public function getFilename()
    {
        return $this->_filename;
    }

    public function setFileformat($fileformat)
    {
        if (is_string($fileformat)) {
            $this->_fileformat = $fileformat;
        }
    }

    public function getFiledisplayname() {
        return $this->_filedisplayname;
    }

    public function setFiledisplayname($filedisplayname) {
        if (is_string($filedisplayname)) {
            $this->_filedisplayname = $filedisplayname;
        }
    }

    public function getFileformat()
    {
        return $this->_fileformat;
    }


    public function setFilesize($filesize)
    {
        $filesize = (int)$filesize;
        if (!is_null($filesize)) {
            $this->_filesize = $filesize;
        }
    }

    public function getFilesize()
    {
        return $this->_filesize;
    }

    public function setSavelocal($savelocal)
    {
        $savelocal = (int)$savelocal;
        if (!is_null($savelocal)) {
            $this->_savelocal = $savelocal;
        }
    }

    public function getSavelocal()
    {
        return $this->_savelocal;
    }

    public function setSavecloud($savecloud)
    {
        $savecloud = (int)$savecloud;
        if (!is_null($savecloud)) {
            $this->_savecloud = $savecloud;
        }
    }

    public function getSavecloud()
    {
        return $this->_savecloud;
    }

    public function setUserid($userid)
    {
        $userid = (int)$userid;
        if (is_int($userid)) {
            $this->_userid = $userid;
        }
    }

    public function getUserid()
    {
        return $this->_userid;
    }

    public function setCreatedate($createdate)
    {
        if (is_string($createdate)) {
            $this->_createdate = $createdate;
        }
    }

    public function getCreatedate()
    {
        return $this->_createdate;
    }

    public function setDeletedate($deletedate)
    {
        if (is_string($deletedate)) {
            $this->_deletedate = $deletedate;
        }
    }

    public function getDeletedate()
    {
        return $this->_deletedate;
    }

    public function setPublic($public)
    {
        $public = (int)$public;
        if (!is_null($public)) {
            $this->_public = $public;
        }
    }

    public function getPublic()
    {
        return $this->_public;
    }

    public function toArray()
    {
        $data = array(
            'fileid' => $this->getFileid(),
            'filename' => $this->getFilename(),
            'filedisplayname' => $this->getFiledisplayname(),
            'fileformat' => $this->getFileformat(),
            'filesize' => $this->getFilesize(),
            'savelocal' => $this->getSavelocal(),
            'savecloud' => $this->getSavecloud(),
            'userid' => $this->getUserid(),
            'createdate' => $this->getCreatedate(),
            'deletedate' => $this->getDeletedate(),
            'public' => $this->getPublic(),
        );

        return $data;
    }

}

