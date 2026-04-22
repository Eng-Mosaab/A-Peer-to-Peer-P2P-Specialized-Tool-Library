<?php
namespace App\Models;
use App\Core\Model;

class Reservation extends Model {
    public function all(?string $status = null, ?int $borrowerId = null): array {
        $sql = 'SELECT reservations.*, tools.name AS tool_name, users.name AS borrower_name FROM reservations JOIN tools ON tools.id = reservations.tool_id JOIN users ON users.id = reservations.borrower_id WHERE 1=1';
        $params = [];
        if ($status) { $sql .= ' AND reservations.status = ?'; $params[] = $status; }
        if ($borrowerId) { $sql .= ' AND reservations.borrower_id = ?'; $params[] = $borrowerId; }
        $sql .= ' ORDER BY reservations.id DESC';
        $stmt = $this->db->prepare($sql); $stmt->execute($params); return $stmt->fetchAll();
    }
    public function create(array $d): bool {
        $stmt = $this->db->prepare('INSERT INTO reservations (borrower_id,tool_id,start_date,end_date,status,notes,created_at) VALUES (?,?,?,?,?,?,NOW())');
        return $stmt->execute([$d['borrower_id'],$d['tool_id'],$d['start_date'],$d['end_date'],$d['status'],$d['notes']]);
    }
    public function find(int $id): ?array { $stmt=$this->db->prepare('SELECT * FROM reservations WHERE id=?'); $stmt->execute([$id]); return $stmt->fetch() ?: null; }
    public function update(int $id, array $d): bool {
        $stmt = $this->db->prepare('UPDATE reservations SET start_date=?, end_date=?, status=?, notes=? WHERE id=?');
        return $stmt->execute([$d['start_date'],$d['end_date'],$d['status'],$d['notes'],$id]);
    }
    public function changeStatus(int $id, string $status): bool { return $this->db->prepare('UPDATE reservations SET status=? WHERE id=?')->execute([$status,$id]); }
    public function delete(int $id): bool { return $this->db->prepare('DELETE FROM reservations WHERE id=?')->execute([$id]); }
    public function countActive(): int { return (int)$this->db->query("SELECT COUNT(*) FROM reservations WHERE status IN ('Pending','Approved','Rescheduled')")->fetchColumn(); }
    public function reportRows(?string $status = null): array {
        $sql = 'SELECT reservations.id, users.name AS borrower, tools.name AS tool, reservations.start_date, reservations.end_date, reservations.status, reservations.created_at FROM reservations JOIN users ON users.id=reservations.borrower_id JOIN tools ON tools.id=reservations.tool_id WHERE 1=1';
        $params=[]; if($status){$sql.=' AND reservations.status=?';$params[]=$status;} $sql.=' ORDER BY reservations.id DESC';
        $stmt=$this->db->prepare($sql); $stmt->execute($params); return $stmt->fetchAll();
    }
}
