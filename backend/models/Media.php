<?php

require_once __DIR__ . '/Model.php';

class Media extends Model
{
    public function create(string $fileName, string $filePath, string $fileType): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO media (file_name, file_path, file_type)
            VALUES (:file_name, :file_path, :file_type)
        ");

        $stmt->execute([
            ':file_name' => $fileName,
            ':file_path' => $filePath,
            ':file_type' => $fileType,
        ]);

        return (int)$this->db->lastInsertId();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM media WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
}
