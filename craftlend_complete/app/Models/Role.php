<?php
namespace App\Models;
use App\Core\Model;

class Role extends Model {
    public function all(?string $search = null): array {
        if ($search) {
            $stmt = $this->db->prepare('SELECT * FROM roles WHERE name LIKE ? ORDER BY name');
            $stmt->execute(["%{$search}%"]);
            return $stmt->fetchAll();
        }
        return $this->db->query('SELECT * FROM roles ORDER BY name')->fetchAll();
    }
    public function find(int $id): ?array { $stmt=$this->db->prepare('SELECT * FROM roles WHERE id=?'); $stmt->execute([$id]); return $stmt->fetch() ?: null; }
    public function create(string $name): bool { return $this->db->prepare('INSERT INTO roles (name) VALUES (?)')->execute([$name]); }
    public function update(int $id, string $name): bool { return $this->db->prepare('UPDATE roles SET name=? WHERE id=?')->execute([$name,$id]); }
    public function delete(int $id): bool { return $this->db->prepare('DELETE FROM roles WHERE id=?')->execute([$id]); }
}
