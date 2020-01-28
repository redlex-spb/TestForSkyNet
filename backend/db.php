<?php
require_once 'db_cfg.php';

class Db {

    private $connect = null;

    public function __construct()
    {
        $this->connect  = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->connect -> connect_errno) {
            throw new Exception("Failed to connect to MySQL: " . $this->connect -> connect_error);
        }

    }

    public function getConnect()
    {
        return $this->connect;
    }

    public function closeConnect($conn)
    {
        $conn -> close();
    }

}
