<?php

require_once __DIR__ . '/Model.php';

class Setting extends Model
{
    public function getSettings(): ?array
    {
        $stmt = $this->db->query("
            SELECT s.*, 
                   ml.file_path as logo_path, 
                   mf.file_path as favicon_path 
            FROM settings s 
            LEFT JOIN media ml ON s.logo_media_id = ml.id
            LEFT JOIN media mf ON s.favicon_media_id = mf.id
            ORDER BY s.id ASC LIMIT 1
        ");
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
                linkedin         = :linkedin,
                logo_media_id    = :logo_media_id,
                favicon_media_id = :favicon_media_id
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
            ':logo_media_id'    => !empty($data['logo_media_id']) ? $data['logo_media_id'] : null,
            ':favicon_media_id' => !empty($data['favicon_media_id']) ? $data['favicon_media_id'] : null,
        ]);
    }
}
