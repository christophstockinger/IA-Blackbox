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
        $model->setFiletags($row->FILETAGS);
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
                'FILETAGS' => $data['tags'],
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

    public function fetchFilesByTag($tags)
    {
        try {
            $results = array();

            foreach ($tags as $tag) {
                $select = $this->getTable()->select();
                $select->where("(FILETAGS LIKE '%" . $tag . "%' OR FILEFORMAT LIKE '%" . $tag . "%' OR FILEDISPLAYNAME LIKE '%" . $tag . "%') AND _DELETEDATE IS NULL");

                $rows = $this->getTable()->fetchAll($select);

                foreach ($rows as $row) {
                    $model = $this->getModel($row);


                    $results[] = $model;
                }
            }

            return $results;
        } catch (Exception $e) {
            return null;
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

    public function update($fileid, $data )
    {
        try {
            $inputArray = array(
                'FILEDISPLAYNAME' => $data['filedisplayname'],
                'FILETAGS' => $data['tags'],
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
            $inputData = array(
                '_DELETEDATE' => date('Y-m-d H:i:s'),
            );

            $row = $this->getTable()->find($fileid)->current();
            $row->setFromArray($inputData);
            $row->save();

            return $row->FILEID;
        } catch (Exception $er) {
            return 0;
        }
    }


}

