<?php

require_once __DIR__."/vendor/autoload.php";

use App\Config;
use App\Database;        
use App\Service\FileService;
use App\Service\AuthorService;
use App\Service\BookService;

$config = new Config();
$db = new Database($config);
$fileService = new FileService($db);
$authorService = new AuthorService($db);
$bookService = new BookService($db);

function scanFiles($path, FileService $fileService, AuthorService $authorService, BookService $bookService)
{
    foreach (new DirectoryIterator($path) as $fileInfo) {
        if($fileInfo->isDot()) continue;

        if ($fileInfo->isDir()) {
            scanFiles($fileInfo->getPathName(), $fileService, $authorService, $bookService);
        }

        if($fileInfo->getExtension() == "xml") {
            $books = simplexml_load_file($fileInfo->getPathName());

            if ($fileService->get($fileInfo)) {
                if(!$fileService->isFileUpdated($fileInfo)) {
                    continue;
                } else {
                    $fileService->updateChangingTime($fileInfo);
                }
            } else {
                $fileService->insert($fileInfo);
            }

            foreach($books as $book) {
                $authorId = $authorService->getOrInsert($book->author);
                $bookService->getOrInsert($book->name, $authorId);
            }
        }
    }
}

scanFiles(__DIR__."/files", $fileService, $authorService, $bookService);

