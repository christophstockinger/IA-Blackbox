<?php

class Application_Model_Mappers_GlobalFileformats
{
    protected $_dbTable = null;

    public function getTable()
    {
        if (!isset($this->_dbTable)) {
            $this->_dbTable = new Application_Model_DbTable_GlobalFileformats();
        }
        return $this->_dbTable;
    }

    public function getModel(Zend_Db_Table_Row $row)
    {
        $model = new Application_Model_GlobalFileformats();
        $model->setFormatid($row->FORMATID);
        $model->setFileformat($row->FILEFORMAT);
        $model->setFormatCategorie($row->FORMAT_CATEGORIE);

        return $model;
    }

    public function fetchSingleById($formatid) {

        $select= $this->getTable()->select();
        $select->where("FORMATID = " . (int) $formatid );


        $row = $this->getTable()->fetchRow($select);

        if ( is_null($row) ) {
            return false;
        }

        $model = $this->getModel($row);

        return $model;
    }

    public function fetchSingleByFileformat($fileformat) {

        $select = $this->getTable()->select();
        $select->where("FILEFORMAT = '" . $fileformat . "'");

        $row = $this->getTable()->fetchRow($select);

        if ( is_null($row) ) {
            return false;
        }

        $model = $this->getModel($row);

        return $model;
    }

    public function fetchList () {
        $select = $this->getTable()->select();

        $rows = $this->getTable()->fetchAll($select);

        if ( is_null($rows) ) {
            return false;
        }

        $list = array();
        foreach($rows as $row) {
            $list[] = $this->getModel($row);
        }



        return $list;

    }

    public  function create(array $data) {
        $inputData = array(
            'FILEFORMAT'		=> $data['fileformat'],
            'FORMAT_CATEGORIE'		=> $data['formatcategorie'],
        );

        $row = $this->getTable()->createRow($inputData);

        $row->save();

        return $row->FORMATID;
    }

    public function update($formatid, array $data) {

        $inputData = array(
            'FILEFORMAT'		=> $data['fileformat'],
            'FORMAT_CATEGORIE'		=> $data['formatcategorie'],
        );

        $row = $this->getTable()->update($inputData, 'FORMATID = ' . (int) $formatid);
        return $row;
    }

    public function delete($formatid) {
        $formatid = (int) $formatid;
        $id = $this->getTable()->delete("FORMATID = " . $formatid);
        return $id;
    }
}