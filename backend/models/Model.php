<?php

require_once __DIR__ . '/../core/database.php';

abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = getDbConnection();
    }
}
