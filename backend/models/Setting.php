<?php

require_once __DIR__ . '/Model.php';

class Setting extends Model
{
    public function getSettings(): ?array
    {
        $stmt = $this->db->query("SELECT * FROM settings ORDER BY id ASC LIMIT 1");
        $result = $stmt->fetch();

        return $result ?: null;
    }
}
