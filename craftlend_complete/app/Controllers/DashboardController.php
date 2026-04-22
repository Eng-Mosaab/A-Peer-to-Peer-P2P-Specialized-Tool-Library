<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\MaintenanceRequest;
use App\Models\Notification;
use App\Models\Reservation;
use App\Models\Tool;
use App\Models\User;

class DashboardController extends Controller {
    public function __construct(private \PDO $db) {}
    public function index(): void {
        require_auth();
        $tools = new Tool($this->db);
        $users = new User($this->db);
        $reservations = new Reservation($this->db);
        $maintenance = new MaintenanceRequest($this->db);
        $notifications = new Notification($this->db);
        $stats = [
            'tools' => $tools->countAll(),
            'activeReservations' => $reservations->countActive(),
            'openMaintenance' => $maintenance->countOpen(),
            'unreadNotifications' => $notifications->unreadCount((int)auth_user()['id']),
        ];
        $this->view('dashboard/index', [
            'title' => t('dashboard'),
            'stats' => $stats,
            'roleCounts' => has_role('Admin') ? $users->countsByRole() : [],
        ]);
    }
    public function profile(): void {
        require_auth();
        $this->view('dashboard/profile', ['title' => t('profile')]);
    }
}
