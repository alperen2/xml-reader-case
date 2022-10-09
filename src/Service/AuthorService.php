<?php
namespace App\Service;

use App\Database;

Class AuthorService {
    
    private Database $db;

    public function __construct(Database $database)
    {
        $this->setDb($database);
    }

    public function insert($name)
    {
        $q = $this->getDb()->conn->prepare("INSERT INTO authors (name) VALUES (:name)");
        $q->execute(["name" => $name]);

        return $this->getDb()->conn->lastInsertId();
    }


    public function get($authorName)
    {
        $q = $this->getDb()->conn->prepare("SELECT id FROM authors WHERE name = :name");
        $q->execute(["name" => $authorName]);
        return $q->fetch(\PDO::FETCH_ASSOC);
    }

    public function getOrInsert($authorName)
    {
        if ($author = $this->get($authorName)) {
            return $author['id'];
        } 

        return $this->insert($authorName);
    }

    public function search($authorName)
    {
        $q = $this->getDb()->conn->prepare("SELECT a.name AS author, b.name AS book FROM authors AS a LEFT JOIN books as b ON b.author = a.id WHERE a.name ILIKE :name");
        $q->execute(["name" => '%'. $authorName .'%']);
        return $q->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getDb()
    {
        return $this->db;
    }

    public function setDb($db)
    {
        $this->db = $db;

        return $this;
    }
}