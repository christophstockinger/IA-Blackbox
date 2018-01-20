<?php

class Application_Model_Mappers_GlobalSettings
{
    protected $_dbTable = null;

    public function getTable()
    {
        if (!isset($this->_dbTable)) {
            $this->_dbTable = new Application_Model_DbTable_GlobalSettings();
        }
        return $this->_dbTable;
    }

    public function getModel(Zend_Db_Table_Row $row)
    {
        $model = new Application_Model_GlobalSettings();
        $model->setSettingsId((int)$row->SETTINGSID);
        $model->setSettingsName($row->SETTINGS_NAME);
        $model->setSettingsValue($row->SETTINGS_VALUE);
        $model->setSettingsDisplayName($row->SETTINGS_DISPLAY_NAME);

        return $model;
    }

    public function fetchSingleById($id)
    {

        $select = $this->getTable()->select();
        $select->where("ID = " . (int)$id);


        $row = $this->getTable()->fetchRow($select);

        if (is_null($row)) {
            return false;
        }

        $model = $this->getModel($row);

        return $model;
    }

    public function fetchSingleByName($settingsname)
    {

        $select = $this->getTable()->select();
        $select->where("SETTINGS_NAME = '" . $settingsname . "'");

        $row = $this->getTable()->fetchRow($select);

        if (is_null($row)) {
            return false;
        }

        $model = $this->getModel($row);

        return $model;
    }

    public function fetchList()
    {
        $select = $this->getTable()->select();

        $rows = $this->getTable()->fetchAll($select);

        if (is_null($rows)) {
            return false;
        }

        $list = array();
        foreach ($rows as $row) {
            $list[] = $this->getModel($row);
        }

        return $list;

    }

    public function update($settingsname, $settingsvalue)
    {

        $inputArray = array('SETTINGS_VALUE' => $settingsvalue);

        $row = $this->getTable()->update($inputArray, "SETTINGS_NAME = '" . $settingsname . "'");
        return $row;
    }
}