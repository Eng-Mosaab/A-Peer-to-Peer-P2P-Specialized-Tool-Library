<?php
namespace App\Models;
use App\Core\Model;

class MaintenanceRequest extends Model {
    public function all(): array {
        return $this->db->query('SELECT maintenance_requests.*, tools.name AS tool_name, users.name AS created_by_name FROM maintenance_requests JOIN tools ON tools.id = maintenance_requests.tool_id JOIN users ON users.id = maintenance_requests.created_by ORDER BY maintenance_requests.id DESC')->fetchAll();
    }
    public function create(array $d): bool {
        $stmt = $this->db->prepare('INSERT INTO maintenance_requests (tool_id,created_by,title,description,priority,status,evidence_path,created_at) VALUES (?,?,?,?,?,?,?,NOW())');
        return $stmt->execute([$d['tool_id'],$d['created_by'],$d['title'],$d['description'],$d['priority'],$d['status'],$d['evidence_path']]);
    }
    public function update(int $id, array $d): bool {
        $stmt = $this->db->prepare('UPDATE maintenance_requests SET title=?, description=?, priority=?, status=?, evidence_path=? WHERE id=?');
        return $stmt->execute([$d['title'],$d['description'],$d['priority'],$d['status'],$d['evidence_path'],$id]);
    }
    public function find(int $id): ?array {
        $stmt = $this->db->prepare('SELECT * FROM maintenance_requests WHERE id=?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }
    public function countOpen(): int {
        return (int)$this->db->query("SELECT COUNT(*) FROM maintenance_requests WHERE status != 'Closed'")->fetchColumn();
    }
}
