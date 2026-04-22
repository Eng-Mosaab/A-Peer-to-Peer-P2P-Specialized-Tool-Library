<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\MaintenanceRequest;
use App\Models\Report;
use App\Models\Reservation;
use App\Models\Tool;
use App\Models\User;

class ReportController extends Controller {
    private Report $report; private User $users; private Tool $tools; private Reservation $reservations; private MaintenanceRequest $maintenance;
    public function __construct(private \PDO $db) { $this->report = new Report($db); $this->users = new User($db); $this->tools = new Tool($db); $this->reservations = new Reservation($db); $this->maintenance = new MaintenanceRequest($db); }
    public function index(): void {
        require_role(['Admin','Librarian','Technician']);
        $type = $_GET['type'] ?? 'summary'; $status = trim($_GET['status'] ?? ''); $search = trim($_GET['search'] ?? ''); $roleId = (int)($_GET['role_id'] ?? 0);
        $rows = match($type) {
            'users' => $this->users->all($search, $roleId ?: null),
            'tools' => $this->tools->all($search, $status ?: null),
            'reservations' => $this->reservations->reportRows($status ?: null),
            'maintenance' => $this->maintenance->all(),
            default => []
        };
        $this->view('reports/index', ['title'=>t('reports'),'stats'=>$this->report->summary(),'type'=>$type,'rows'=>$rows,'status'=>$status,'search'=>$search,'roleId'=>$roleId]);
    }
    public function export(): void {
        require_role(['Admin','Librarian','Technician']);
        $type = $_GET['type'] ?? 'summary'; $status = trim($_GET['status'] ?? ''); $search = trim($_GET['search'] ?? ''); $roleId = (int)($_GET['role_id'] ?? 0);
        $rows = match($type) {
            'users' => $this->users->all($search, $roleId ?: null),
            'tools' => $this->tools->all($search, $status ?: null),
            'reservations' => $this->reservations->reportRows($status ?: null),
            'maintenance' => $this->maintenance->all(),
            default => [$this->report->summary()]
        };
        header('Content-Type: text/csv; charset=utf-8'); header('Content-Disposition: attachment; filename="'.$type.'_report.csv"');
        $out = fopen('php://output', 'w'); if (!empty($rows)) { fputcsv($out, array_keys($rows[0])); foreach ($rows as $row) fputcsv($out, $row); } fclose($out); exit;
    }
}
