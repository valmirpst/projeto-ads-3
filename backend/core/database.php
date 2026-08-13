<?php
function getDbConnection(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn     = 'mysql:host=127.0.0.1;dbname=cms_db;charset=utf8mb4';
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $pdo = new PDO($dsn, 'root', '', $options);
    }

    return $pdo;
}
