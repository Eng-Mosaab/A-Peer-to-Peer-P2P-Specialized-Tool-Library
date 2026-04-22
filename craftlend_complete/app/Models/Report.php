<?php
namespace App\Models;
use App\Core\Model;

class Report extends Model {
    public function summary(): array {
        return [
            'users' => (int)$this->db->query('SELECT COUNT(*) FROM users')->fetchColumn(),
            'tools' => (int)$this->db->query('SELECT COUNT(*) FROM tools')->fetchColumn(),
            'reservations' => (int)$this->db->query('SELECT COUNT(*) FROM reservations')->fetchColumn(),
            'maintenance' => (int)$this->db->query('SELECT COUNT(*) FROM maintenance_requests')->fetchColumn(),
            'notifications' => (int)$this->db->query('SELECT COUNT(*) FROM notifications')->fetchColumn(),
        ];
    }
}
