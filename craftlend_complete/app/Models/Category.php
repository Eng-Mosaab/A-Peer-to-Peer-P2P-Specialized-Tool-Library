<?php
namespace App\Models;
use App\Core\Model;

class Category extends Model {
    public function all(): array {
        return $this->db->query('SELECT * FROM categories ORDER BY name')->fetchAll();
    }
}
