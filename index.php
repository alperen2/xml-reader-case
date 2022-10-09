<?php
require_once "./vendor/autoload.php";

use App\Config;
use App\Database;        
use App\Service\AuthorService;

$config = new Config();
$db = new Database($config);
$authorService = new AuthorService($db);



$result = [];
if (isset($_GET['author'])) {
    $result = $authorService->search($_GET['author']);
}

include "./search.php";

