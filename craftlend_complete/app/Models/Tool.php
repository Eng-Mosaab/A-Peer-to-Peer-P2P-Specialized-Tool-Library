<?php
namespace App\Models;
use App\Core\Model;

class Tool extends Model {
    public function all(?string $search = null, ?string $status = null): array {
        $sql = 'SELECT tools.*, categories.name AS category_name, users.name AS lender_name FROM tools JOIN categories ON categories.id = tools.category_id JOIN users ON users.id = tools.lender_id WHERE 1=1';
        $params = [];
        if ($search) {
            $sql .= ' AND (tools.name LIKE ? OR tools.description LIKE ? OR categories.name LIKE ? OR users.name LIKE ?)';
            $params[] = "%{$search}%"; $params[] = "%{$search}%"; $params[] = "%{$search}%"; $params[] = "%{$search}%";
        }
        if ($status) { $sql .= ' AND tools.status = ?'; $params[] = $status; }
        $sql .= ' ORDER BY tools.id DESC';
        $stmt = $this->db->prepare($sql); $stmt->execute($params); return $stmt->fetchAll();
    }
    public function find(int $id): ?array {
        $stmt = $this->db->prepare('SELECT tools.*, categories.name AS category_name, users.name AS lender_name FROM tools JOIN categories ON categories.id = tools.category_id JOIN users ON users.id = tools.lender_id WHERE tools.id=?');
        $stmt->execute([$id]); return $stmt->fetch() ?: null;
    }
    public function create(array $d): bool {
        $stmt = $this->db->prepare('INSERT INTO tools (lender_id,category_id,name,description,tool_condition,status,daily_rate,deposit_amount,location,availability_notes,image_path,document_path,created_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,NOW())');
        return $stmt->execute([$d['lender_id'],$d['category_id'],$d['name'],$d['description'],$d['tool_condition'],$d['status'],$d['daily_rate'],$d['deposit_amount'],$d['location'],$d['availability_notes'],$d['image_path'],$d['document_path']]);
    }
    public function update(int $id, array $d): bool {
        $stmt = $this->db->prepare('UPDATE tools SET category_id=?, name=?, description=?, tool_condition=?, status=?, daily_rate=?, deposit_amount=?, location=?, availability_notes=?, image_path=?, document_path=? WHERE id=?');
        return $stmt->execute([$d['category_id'],$d['name'],$d['description'],$d['tool_condition'],$d['status'],$d['daily_rate'],$d['deposit_amount'],$d['location'],$d['availability_notes'],$d['image_path'],$d['document_path'],$id]);
    }
    public function delete(int $id): bool { return $this->db->prepare('DELETE FROM tools WHERE id=?')->execute([$id]); }
    public function countAll(): int { return (int)$this->db->query('SELECT COUNT(*) FROM tools')->fetchColumn(); }
}
