<?php

class Application_Model_GlobalFileformats
{
    protected $_formatid;
    protected $_fileformat;
    protected $_formatCategorie;

    public function setFormatid($formatid)
    {
        $formatid = (int) $formatid;
        if ( !is_null($formatid) ) {
            $this->_formatid = $formatid;
        }
    }

    public function getFormatid()
    {
        return $this->_formatid;
    }

    public function setFileformat($fileformat)
    {
        if ( is_string($fileformat) ) {
            $this->_fileformat = $fileformat;
        }
    }

    public function getFileformat()
    {
        return $this->_fileformat;
    }

    public function setFormatCategorie($formatCategorie)
    {
        if ( is_string($formatCategorie) ) {
            $this->_formatCategorie = $formatCategorie;
        }
    }

    public function getFormatCategorie()
    {
        return $this->_formatCategorie;
    }


}

