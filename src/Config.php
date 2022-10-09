<?php

namespace App;

use Dotenv\Dotenv;

class Config {
    private static $instance;

    private $dotenv;

    public function __construct()
    {

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        if (is_null($this->dotenv)) {
            $this->dotenv = Dotenv::createImmutable(__DIR__."/../");
            $this->dotenv->load();
        }
    }

    public function init()
    {
        if(is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function get($key) {
        $this->init();
        return $_ENV[$key];
    }
}