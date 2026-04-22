<?php
namespace App\Models;
use App\Core\Model;

class Notification extends Model {
    public function forUser(int $userId): array {
        $stmt = $this->db->prepare('SELECT * FROM notifications WHERE user_id=? ORDER BY id DESC');
        $stmt->execute([$userId]); return $stmt->fetchAll();
    }
    public function all(): array {
        return $this->db->query('SELECT notifications.*, users.name AS user_name FROM notifications JOIN users ON users.id=notifications.user_id ORDER BY notifications.id DESC')->fetchAll();
    }
    public function create(int $userId, string $title, string $message): bool {
        $stmt = $this->db->prepare('INSERT INTO notifications (user_id,title,message,is_read,created_at) VALUES (?,?,?,0,NOW())');
        return $stmt->execute([$userId,$title,$message]);
    }
    public function createForRole(int $roleId, string $title, string $message): bool {
        $users = $this->db->prepare('SELECT id FROM users WHERE role_id=?'); $users->execute([$roleId]);
        $ok = true; foreach ($users->fetchAll() as $u) { $ok = $this->create((int)$u['id'],$title,$message) && $ok; } return $ok;
    }
    public function markRead(int $id, int $userId): bool { return $this->db->prepare('UPDATE notifications SET is_read=1 WHERE id=? AND user_id=?')->execute([$id,$userId]); }
    public function unreadCount(int $userId): int { $stmt=$this->db->prepare('SELECT COUNT(*) FROM notifications WHERE user_id=? AND is_read=0'); $stmt->execute([$userId]); return (int)$stmt->fetchColumn(); }
}
