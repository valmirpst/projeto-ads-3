<?php

require_once __DIR__ . '/Model.php';

class Section extends Model
{
    public function getAllOrdered(): array
    {
        $stmt = $this->db->query("SELECT * FROM sections WHERE enabled = TRUE ORDER BY position ASC");
        return $stmt->fetchAll();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM sections ORDER BY position ASC");
        return $stmt->fetchAll();
    }
}
