<?php
namespace App\Service;

use App\Database;

class FileService {

    private Database $db;

    public function __construct(Database $database)
    {
        $this->setDb($database);
    }

    public function get($file): array|bool
    {
        $q = $this->getDb()->conn->prepare("SELECT * FROM files WHERE path = :path");
        $q->execute(["path" => $file->getPathName()]);
        return $q->fetch(\PDO::FETCH_ASSOC);
    }

    public function insert($file): void
    {
        $q = $this->getDb()->conn->prepare("INSERT INTO files (path, last_changing_time) VALUES (:path, :last_changing_time)");

        $q->execute([
            "path" => $file->getPathName(),
            "last_changing_time" => $file->getCTime()
        ]);
    }

    public function updateChangingTime($file): void
    {
        $q = $this->getDb()->conn->prepare("UPDATE files SET last_changing_time = :last_changing_time WHERE id = :id ");
        $q->execute(["last_changing_time" => $file->getCTime(), "id" => $file['id']]);
    }

    /**
     * @param $fileInfo
     * @return bool
     */
    public function isFileUpdated($fileInfo): bool
    {
        $file = $this->get($fileInfo);
        return $file['last_changing_time'] != $fileInfo->getCTime();
    }
    
    /**
     * @return Database
     */ 
    public function getDb(): Database
    {
        return $this->db;
    }

    /**
     * @param Database $db
     * @return self
     */ 
    public function setDb($db): self
    {
        $this->db = $db;
        return $this;
    }
}