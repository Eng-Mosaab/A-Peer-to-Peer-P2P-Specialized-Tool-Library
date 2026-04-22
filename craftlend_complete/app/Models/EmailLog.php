<?php
namespace App\Models;
use App\Core\Model;

class EmailLog extends Model {
    public function create(array $d): bool {
        $stmt = $this->db->prepare('INSERT INTO email_logs (recipient_email,subject,message,created_at) VALUES (?,?,?,NOW())');
        return $stmt->execute([$d['recipient_email'],$d['subject'],$d['message']]);
    }
    public function all(): array { return $this->db->query('SELECT * FROM email_logs ORDER BY id DESC')->fetchAll(); }
}
