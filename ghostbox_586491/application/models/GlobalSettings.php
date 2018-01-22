<?php

class Application_Model_GlobalSettings
{

    protected $_settingsid = null;
    protected $_settingsname = null;
    protected $_settingsvalue = null;
    protected $_settingsdisplayname = null;

    public function setSettingsId($settingsid) {
        $settingsid = (int) $settingsid;
        if ( !is_null($settingsid) ) {
            $this->_settingsid = $settingsid;
        }
    }

    public function getSettingsId() {
        return $this->_settingsid;
    }

    public function setSettingsName($settingsname) {
        if ( is_string($settingsname) ) {
            $this->_settingsname =$settingsname;
        }
    }

    public function getSettingsName() {
        return $this->_settingsname;
    }

    public function setSettingsValue($settingsvalue){
        if( is_string($settingsvalue) ) {
            $this->_settingsvalue = $settingsvalue;
        }
    }

    public function getSettingsValue() {
        return $this->_settingsvalue;
    }

    public function setSettingsDisplayName($settingsdisplayname) {
        if ( is_string($settingsdisplayname) ) {
            $this->_settingsdisplayname = $settingsdisplayname;
        }
    }

    public function getSettingsDisplayName() {
        return $this->_settingsdisplayname;
    }

}

