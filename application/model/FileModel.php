<?php


namespace application\model;

class FileModel extends Model
{
    public function findAll($userId)
    {
        $query = "SELECT * FROM `files` WHERE `user_id` = ? ; ";
        $result = $this->query($query, [$userId])->fetchAll();
        $this->closeConnection();
        return $result;
    }

    public function findOne($id, $userId)
    {
        $db = new Model();
        $file = $db->select("SELECT * FROM `files` WHERE `file_id`=? and user_id = ?  ;", [$id, $userId])->fetchAll();
        return $file[0];
    }

    public function uploadFile($file)
    {
        $db = new Model();
        $db->insert('files', ['name', 'content_length', 'content_type', 'path', 'user_id'], [$file['name'], $file['contentLength'] / 1024, $file['contentType'], $file['path'], $file['userID']]);
        return true;
    }

    public function delete($tableName, $id)
    {
        echo "yesss";
        $db = new Model();
        $result = $db->delete('files', $id);
        var_dump($result);
        return $result;
    }
}