<?php
function getDbConnection(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        try {
            $dsn     = 'mysql:host=127.0.0.1;dbname=cms_db;charset=utf8mb4';
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];
            $pdo = new PDO($dsn, 'root', '', $options);
        } catch (PDOException $e) {
            http_response_code(500);
            exit('Database connection failed.');
        }
    }

    return $pdo;
}
