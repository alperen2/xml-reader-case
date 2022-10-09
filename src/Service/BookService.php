<?php

namespace App\Service;

use App\Database;

class BookService {
    private Database $db;

    public function __construct(Database $database)
    {
        $this->setDb($database);
    }

    public function get($bookName, $authorId)
    {
        $q = $this->getDb()->conn->prepare("SELECT id FROM books WHERE name = :name AND author = :author");
        $q->execute(["name" => $bookName, "author" => $authorId]);
        return $q->fetch(\PDO::FETCH_ASSOC);
    }

    public function insert($bookName, $authorId)
    {
        $q = $this->getDb()->conn->prepare("INSERT INTO books (name, author) VALUES (:name, :author)");
        $q->execute(["name" => $bookName, "author" => $authorId]);
    }

    public function getOrInsert($bookName, $authorId)
    {
        if ($book = $this->get($bookName, $authorId)) {
            return $book['id'];
        } 

        return $this->insert($bookName, $authorId);
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