<?php

class Application_Model_Mappers_RawFiles
{
    protected $_dbTable = null;

    public function getTable()
    {
        if (!isset($this->_dbTable)) {
            $this->_dbTable = new Application_Model_DbTable_RawFiles();
        }
        return $this->_dbTable;
    }

    public function getModel(Zend_Db_Table_Row $row)
    {
        $model = new Application_Model_Files();
        $model->setFileid((int)$row->FILEID);
        $model->setFilename($row->FILENAME);
        $model->setFileformat($row->FILEFORMAT);
        $model->setFiledisplayname($row->FILEDISPLAYNAME);
        $model->setFilesize($row->FILESIZE);
        $model->setSavelocal($row->SAVE_LOCAL);
        $model->setSavecloud($row->SAVE_CLOUD);
        $model->setUserid($row->USERID);
        $model->setCreatedate($row->_CREATEDATE);
        $model->setDeletedate($row->_DELETEDATE);
        $model->setPublic($row->PUBLIC);

        return $model;
    }

    public function create(array $data)
    {
        try {
            $inputData = array(
                'FILENAME' => $data['namehash'],
                'FILEFORMAT' => $data['fileformat'],
                'FILEDISPLAYNAME' => $data['filedisplayname'],
                'FILESIZE' => $data['size'],
                'SAVE_LOCAL' => (int)$data['savelocal'],
                'SAVE_CLOUD' => (int)$data['savecloud'],
                'USERID' => $data['userid'],
                '_CREATEDATE' => date('Y-m-d H:i:s'),
                'PUBLIC' => (int)$data['public']
            );

            $row = $this->getTable()->createRow($inputData);
            $row->save();

            return $row->FILEID;
        } catch (Exception $er) {
            return 0;
        }
    }

    public function fetchFilesByUserid($userid)
    {
        $select = $this->getTable()->select();
        $select->where("USERID = " . (int)$userid);

        $rows = $this->getTable()->fetchAll($select);

        if (is_null($rows)) {
            return false;
        }

        $list = array();

        foreach ($rows as $row) {
            $model = $this->getModel($row);

            $list[] = $model;
        }


        return $list;
    }

    public function fetchFilesBySearchTag($tags)
    {
        try {
            $results = array();

            foreach ($tags as $tag) {
                if ($tag != "") {

                    $select = $this->getTable()->select();
                    $select->where("FILEDISPLAYNAME LIKE '%$tag%' OR FILEFORMAT LIKE '%$tag%'");

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

    public function fetchFileByFileid($fileid)
    {
        try {
            $select = $this->getTable()->select();
            $select->where("FILEID = " . (int)$fileid);

            $row = $this->getTable()->fetchRow($select);

            if (is_null($row)) {
                // return false;
            }

            $model = $this->getModel($row);


            return $model;
        } catch (Exception $e) {
            return false;
        }
    }

    public function update($data, $fileid) {
        try {
            $inputArray = array(
                'FILEDISPLAYNAME' => $data['filedisplayname'],
                'SAVE_LOCAL' => (int)$data['savelocal'],
                'PUBLIC' => (int)$data['public'],
            );

            if (isset($data['savecloud'])) {
                $inputArray['SAVE_CLOUD'] = (int)$data['savecloud'];
            }

            $row = $this->getTable()->update($inputArray, "FILEID = " . (int)$fileid);
            return $row;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function delete($fileid)
    {
        try {
            $fileid = (int)$fileid;

            $this->getTable()->delete("FILEID = " . $fileid);
            $return = true;


            return $return;
        } catch (Exception $er) {
            return false;
        }
    }


}

