<?php
require_once __DIR__ . '/BaseModel.php';

class ReviewModel extends BaseModel {
    protected $table = 'reviews';

    public function getReviewsForGame(int $gameId): array {
        $stmt = $this->db->prepare("SELECT r.*, u.username FROM {$this->table} r LEFT JOIN users u ON u.id = r.user_id WHERE r.game_id = ? ORDER BY r.created_at DESC");
        $stmt->bind_param('i', $gameId);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function addReview(int $gameId, int $userId, float $rating, string $comment = null): bool {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (game_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('iids', $gameId, $userId, $rating, $comment);
        return $stmt->execute();
    }

    public function getUserVote(int $gameId, int $userId): ?array {
        // Check if user has already voted on this game
        $stmt = $this->db->prepare("SELECT id, rating FROM {$this->table} WHERE game_id = ? AND user_id = ? AND comment IS NULL LIMIT 1");
        $stmt->bind_param('ii', $gameId, $userId);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_assoc();
    }

    public function addThumb(int $gameId, int $userId, bool $isUp): bool {
        // Check if user already voted
        $existingVote = $this->getUserVote($gameId, $userId);
        
        if ($existingVote) {
            // Update existing vote
            $newValue = $isUp ? 1.0 : 0.0;
            $stmt = $this->db->prepare("UPDATE {$this->table} SET rating = ? WHERE id = ?");
            $stmt->bind_param('di', $newValue, $existingVote['id']);
            return $stmt->execute();
        } else {
            // Create new vote
            $value = $isUp ? 1.0 : 0.0;
            $stmt = $this->db->prepare("INSERT INTO {$this->table} (game_id, user_id, rating, comment) VALUES (?, ?, ?, NULL)");
            $stmt->bind_param('iid', $gameId, $userId, $value);
            return $stmt->execute();
        }
    }

    public function getAggregates(int $gameId): array {
        // pos = count where rating >= 0.5, neg = count where rating < 0.5
        $stmt = $this->db->prepare("SELECT 
            SUM(CASE WHEN rating >= 0.5 THEN 1 ELSE 0 END) AS pos,
            SUM(CASE WHEN rating < 0.5 THEN 1 ELSE 0 END) AS neg,
            AVG(rating) AS avg_rating,
            COUNT(*) AS total
          FROM {$this->table} WHERE game_id = ?");
        $stmt->bind_param('i', $gameId);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        $pos = (int)($res['pos'] ?? 0);
        $neg = (int)($res['neg'] ?? 0);
        $avg = (float)($res['avg_rating'] ?? 0);
        $total = (int)($res['total'] ?? 0);
        // Overall 0-10 derived from percentage positive if thumbs exist, else from avg*10 for star-like reviews
        $overall = 0.0;
        if ($total > 0) {
            if ($pos + $neg > 0) {
                $overall = round(($pos / max(1, $pos + $neg)) * 10, 1);
            } else {
                $overall = round($avg * 10, 1);
            }
        }
        return [
            'positive' => $pos,
            'negative' => $neg,
            'average' => $avg,
            'overall10' => $overall,
            'total' => $total,
        ];
    }
}
?>
