<?php

class Application_Model_Mappers_RawUserSettings
{
    protected $_dbTable = null;

    public function getTable()
    {
        if (!isset($this->_dbTable)) {
            $this->_dbTable = new Application_Model_DbTable_RawUserSettings();
        }
        return $this->_dbTable;
    }


    public function getModel(Zend_Db_Table_Row $row)
    {
        $model = new Application_Model_UserSettings();
        $model->setUserId($row->USERID);
        $model->setSaveLocationLocal($row->SAVELOCATION_LOCAL);
        $model->setSaveCloud($row->SAVE_CLOUD);
        $model->setSaveLocationCloud($row->SAVELOCATION_CLOUD);
        $model->setUsernameCloud($row->USERNAME_CLOUD);
        $model->setPasswordCloud($row->PASSWORD_CLOUD);
        $model->setMaxFileUpload($row->MAX_FILE_UPLOAD);
        $model->setMaxStorage($row->MAX_STORAGE);
        $model->setAllowedFileFormats($row->ALLOWED_FILEFORMATS);

        return $model;
    }

    public function fetchSingleByUserId($userid)
    {

        $select = $this->getTable()->select();
        $select->where("USERID = " . (int)$userid . "");

        $row = $this->getTable()->fetchRow($select);

        if (is_null($row)) {
            return false;
        }

        $model = $this->getModel($row);

        return $model;
    }

    public function update($userid, array $data)
    {
        $inputData = array(
            // 'SAVELOCATION_LOCAL'	=> $data['savelocationlocal'],
            'SAVE_CLOUD' => (((int)$data['savecloud'] == 0) ? 0 : 1),
            'SAVELOCATION_CLOUD' => $data['savelocationcloud'],
            'USERNAME_CLOUD' => $data['usernamecloud'],
            'PASSWORD_CLOUD' => $data['passwordcloud'],
            'MAX_FILE_UPLOAD' => (int)$data['maxfileupload'],
            'MAX_STORAGE' => (int)$data['maxstorage'],
            'ALLOWED_FILEFORMATS' => $data['allowedfileformats']
        );

        $row = $this->getTable()->find($userid)->current();
        $row->setFromArray($inputData);
        $save = $row->save();
        return $save;
    }

    public function create(array $data)
    {
        $inputData = array(
            'USERID' => $data['userid'],
            'SAVELOCATION_LOCAL' => $data['savelocationlocal'],
            'SAVE_CLOUD' => (((int)$data['savecloud'] == 0) ? 0 : 1),
            'SAVELOCATION_CLOUD' => $data['savelocationcloud'],
            'USERNAME_CLOUD' => $data['usernamecloud'],
            'PASSWORD_CLOUD' => $data['passwordcloud'],
            'MAX_FILE_UPLOAD' => (int)$data['maxfileupload'],
            'MAX_STORAGE' => (int)$data['maxstorage'],
            'ALLOWED_FILEFORMATS' => $data['allowedfileformats']
        );
        $row = $this->getTable()->createRow($inputData);
        $row->save();

        return $row->USERID;

    }

}