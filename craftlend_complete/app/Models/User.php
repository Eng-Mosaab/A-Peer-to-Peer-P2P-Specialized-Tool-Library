<?php
namespace App\Models;
use App\Core\Model;

class User extends Model {
    public function findByEmail(string $email): ?array {
        $stmt = $this->db->prepare('SELECT users.*, roles.name AS role_name FROM users JOIN roles ON roles.id = users.role_id WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }
    public function create(array $data): bool {
        $stmt = $this->db->prepare('INSERT INTO users (name,email,password,role_id,location,verification_status,created_at) VALUES (?,?,?,?,?,?,NOW())');
        return $stmt->execute([$data['name'],$data['email'],$data['password'],$data['role_id'],$data['location'] ?? null,$data['verification_status'] ?? 'Pending']);
    }
    public function all(?string $search = null, ?int $roleId = null): array {
        $sql = 'SELECT users.*, roles.name AS role_name FROM users JOIN roles ON roles.id = users.role_id WHERE 1=1';
        $params = [];
        if ($search) {
            $sql .= ' AND (users.name LIKE ? OR users.email LIKE ? OR COALESCE(users.location,"") LIKE ?)';
            $params[] = "%{$search}%"; $params[] = "%{$search}%"; $params[] = "%{$search}%";
        }
        if ($roleId) { $sql .= ' AND users.role_id = ?'; $params[] = $roleId; }
        $sql .= ' ORDER BY users.id DESC';
        $stmt = $this->db->prepare($sql); $stmt->execute($params); return $stmt->fetchAll();
    }
    public function find(int $id): ?array {
        $stmt = $this->db->prepare('SELECT users.*, roles.name AS role_name FROM users JOIN roles ON roles.id = users.role_id WHERE users.id = ?');
        $stmt->execute([$id]); return $stmt->fetch() ?: null;
    }
    public function update(int $id, array $data): bool {
        $fields = 'name=?, email=?, role_id=?, location=?, verification_status=?';
        $params = [$data['name'],$data['email'],$data['role_id'],$data['location'],$data['verification_status']];
        if (!empty($data['password'])) { $fields .= ', password=?'; $params[] = $data['password']; }
        $params[] = $id;
        $stmt = $this->db->prepare("UPDATE users SET {$fields} WHERE id=?");
        return $stmt->execute($params);
    }
    public function delete(int $id): bool { return $this->db->prepare('DELETE FROM users WHERE id=?')->execute([$id]); }
    public function countsByRole(): array {
        return $this->db->query('SELECT roles.name, COUNT(*) total FROM users JOIN roles ON roles.id = users.role_id GROUP BY roles.name ORDER BY roles.name')->fetchAll();
    }
}
