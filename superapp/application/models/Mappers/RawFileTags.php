<?php

class Application_Model_Mappers_RawFileTags
{
    protected $_dbTable = null;

    public function getTable()
    {
        if (!isset($this->_dbTable)) {
            $this->_dbTable = new Application_Model_DbTable_RawFileTags();
        }
        return $this->_dbTable;
    }

    public function getModel(Zend_Db_Table_Row $row)
    {
        $model = new Application_Model_FileTags();
        $model->setFileid((int)$row->FILEID);
        $model->setTag($row->TAG);

        return $model;
    }

    public function create($tags, $fileid)
    {
        try {
            $return = false;

            foreach ($tags as $tag) {
                if ($tag != "") {
                    $inputarray = array(
                        'FILEID' => (int)$fileid,
                        'TAG' => $tag
                    );

                    $row = $this->getTable()->createRow($inputarray);
                    $row->save();
                    $return = true;
                }
            }

            return $return;
        } catch (Exception $er) {
            return false;
        }
    }

    public function fetchAllByTag($tags)
    {
        try {
            $results = array();

            foreach ($tags as $tag) {
                if ($tag != "") {

                    $select = $this->getTable()->select();
                    $select->where("TAG LIKE '%$tag%'");

                    $rows = $this->getTable()->fetchAll($select);

                    foreach ($rows as $row) {
                        $model = $this->getModel($row);

                        $results[] = $model;
                    }
                }

            }
            return $results;
        } catch (Exception $e) {
            return false;
        }
    }

    public function fetchAllByFileid($fileid)
    {
        try {
            $results = array();

            $select = $this->getTable()->select();
            $select->where("FILEID = " . (int)$fileid);

            $rows = $this->getTable()->fetchAll($select);

            foreach ($rows as $row) {
                $model = $this->getModel($row);

                $results[] = $model;
            }

            return $results;

        } catch (Exception $e) {
            return false;
        }
    }

    public function delete($fileid)
    {
        try {
            $return = false;
            $fileid = (int)$fileid;


            $this->getTable()->delete("FILEID = " . $fileid);
            $return = true;

            return $return;
        } catch (Exception $er) {
            return false;
        }
    }
}