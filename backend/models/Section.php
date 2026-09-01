<?php

require_once __DIR__ . '/Model.php';

class Section extends Model
{
    public function getAllActive(): array
    {
        $stmt = $this->db->query("SELECT * FROM sections WHERE enabled = TRUE ORDER BY position ASC");
        return $stmt->fetchAll();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM sections ORDER BY position ASC");
        return $stmt->fetchAll();
    }

    public function getById(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM sections WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create(array $data): bool
    {
        $maxPos = (int) $this->db->query("SELECT COALESCE(MAX(position), 0) FROM sections")->fetchColumn();
        $data['position'] = $maxPos + 1;

        $stmt = $this->db->prepare("INSERT INTO sections (type, position, enabled, config) VALUES (:type, :position, :enabled, :config)");
        return $stmt->execute([
            'type' => $data['type'],
            'position' => $data['position'],
            'enabled' => $data['enabled'] ? 1 : 0,
            'config' => json_encode($data['config'])
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("UPDATE sections SET type = :type, enabled = :enabled, config = :config WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'type' => $data['type'],
            'enabled' => $data['enabled'] ? 1 : 0,
            'config' => json_encode($data['config'])
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM sections WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function moveUp(int $id): bool
    {
        $atual = $this->getById($id);
        if (!$atual) return false;

        $stmt = $this->db->prepare("
            SELECT id, position
            FROM sections
            WHERE position < :position
            ORDER BY position DESC
            LIMIT 1
        ");
        $stmt->execute(['position' => $atual['position']]);
        $target = $stmt->fetch();

        return $this->trocarPosicoes($atual, $target);
    }

    public function moveDown(int $id): bool
    {
        $atual = $this->getById($id);
        if (!$atual) return false;

        $stmt = $this->db->prepare("
            SELECT id, position
            FROM sections
            WHERE position > :position
            ORDER BY position ASC
            LIMIT 1
        ");
        $stmt->execute(['position' => $atual['position']]);
        $target = $stmt->fetch();

        return $this->trocarPosicoes($atual, $target);
    }

    private function trocarPosicoes(mixed $atual, mixed $target): bool
    {
        if ($target && $atual) {
            $this->db->prepare("UPDATE sections SET position = :nova_posicao WHERE id = :id")
                ->execute(['nova_posicao' => $atual['position'], 'id' => $target['id']]);

            $this->db->prepare("UPDATE sections SET position = :nova_posicao WHERE id = :id")
                ->execute(['nova_posicao' => $target['position'], 'id' => $atual['id']]);
            return true;
        }
        return false;
    }
}
