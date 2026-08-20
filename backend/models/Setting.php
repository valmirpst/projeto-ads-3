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

    public function updateSettings(array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE settings SET
                site_name        = :site_name,
                site_description = :site_description,
                contact_email    = :contact_email,
                phone            = :phone,
                instagram        = :instagram,
                facebook         = :facebook,
                linkedin         = :linkedin
            WHERE id = 1
        ");

        return $stmt->execute([
            ':site_name'        => $data['site_name'],
            ':site_description' => $data['site_description'] ?? null,
            ':contact_email'    => $data['contact_email']    ?? null,
            ':phone'            => $data['phone']            ?? null,
            ':instagram'        => $data['instagram']        ?? null,
            ':facebook'         => $data['facebook']         ?? null,
            ':linkedin'         => $data['linkedin']         ?? null,
        ]);
    }
}
