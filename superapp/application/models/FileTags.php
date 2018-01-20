<?php

class Application_Model_FileTags
{

    protected $_fileid = null;
    protected $_tag  = null;

    public function setFileid($fileid) {
        $fileid = (int) $fileid;
        if (!is_null($fileid)) {
            $this->_fileid = $fileid;
        }
    }

    public function getFileid() {
        return $this->_fileid;
    }

    public function setTag($tag) {
        if (is_string($tag)) {
            $this->_tag = $tag;
        }
    }

    public function getTag() {
        return $this->_tag;
    }

}

