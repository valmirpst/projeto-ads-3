<?php

require_once __DIR__ . '/Model.php';

class Visit extends Model
{
    public function logVisit(string $sessionId, string $pageUrl)
    {
        $stmt = $this->db->prepare("
            INSERT INTO visits (session_id, page_url)
            VALUES (:session_id, :page_url)
        ");
        return $stmt->execute([
            ':session_id' => $sessionId,
            ':page_url' => $pageUrl
        ]);
    }

    public function getRecentVisits(int $days = 30): array
    {
        $stmt = $this->db->prepare("
            SELECT session_id, page_url, created_at
            FROM visits
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL :days DAY)
            ORDER BY created_at DESC
        ");
        // Não entendi direto, mas é preciso forçar o binding como inteiro pq está no INTERVAL
        $stmt->bindValue(':days', (int)$days, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
