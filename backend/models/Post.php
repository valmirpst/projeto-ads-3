<?php

require_once __DIR__ . '/Model.php';

class Post extends Model
{
    public function getPublished(): array
    {
        $stmt = $this->db->query("SELECT * FROM posts WHERE status = 'published' ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM posts ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function getBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE slug = :slug");
        $stmt->execute([':slug' => $slug]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO posts (title, slug, content, cover_image, status)
            VALUES (:title, :slug, :content, :cover_image, :status)
        ");

        return $stmt->execute([
            ':title' => $data['title'],
            ':slug' => $data['slug'],
            ':content' => $data['content'],
            ':cover_image' => $data['cover_image'] ?? null,
            ':status' => $data['status'] ?? 'draft'
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE posts 
            SET title = :title, slug = :slug, content = :content, cover_image = :cover_image, status = :status
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $id,
            ':title' => $data['title'],
            ':slug' => $data['slug'],
            ':content' => $data['content'],
            ':cover_image' => $data['cover_image'] ?? null,
            ':status' => $data['status'] ?? 'draft'
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM posts WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
