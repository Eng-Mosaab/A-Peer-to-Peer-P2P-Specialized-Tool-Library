<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Notification;
use App\Models\Reservation;
use App\Models\Tool;

class ReservationController extends Controller {
    private Reservation $reservations; private Tool $tools; private Notification $notifications;
    public function __construct(private \PDO $db) { $this->reservations = new Reservation($db); $this->tools = new Tool($db); $this->notifications = new Notification($db); }
    public function index(): void {
        require_auth();
        $status = trim($_GET['status'] ?? '');
        $borrowerId = has_role('Borrower') ? (int)auth_user()['id'] : null;
        $this->view('reservations/index', ['title'=>t('reservations'),'reservations'=>$this->reservations->all($status ?: null, $borrowerId), 'statusFilter'=>$status]);
    }
    public function create(): void {
        require_auth();
        if (is_post()) {
            $this->reservations->create([
                'borrower_id'=>(int)auth_user()['id'], 'tool_id'=>(int)$_POST['tool_id'], 'start_date'=>$_POST['start_date'], 'end_date'=>$_POST['end_date'], 'status'=>'Pending', 'notes'=>trim($_POST['notes'])
            ]);
            $this->notifications->create((int)auth_user()['id'], 'Reservation created', 'Your reservation request was saved.');
            flash('success', 'Reservation created.'); $this->redirect('page=reservations');
        }
        $this->view('reservations/form', ['title'=>t('new_reservation'),'tools'=>$this->tools->all(),'reservation'=>null,'mode'=>'create']);
    }
    public function edit(): void {
        require_auth();
        $reservation = $this->reservations->find((int)($_GET['id'] ?? 0)); if (!$reservation) die('Reservation not found');
        if (is_post()) {
            $this->reservations->update((int)$reservation['id'], ['start_date'=>$_POST['start_date'],'end_date'=>$_POST['end_date'],'status'=>trim($_POST['status']),'notes'=>trim($_POST['notes'])]);
            flash('success', 'Reservation updated.'); $this->redirect('page=reservations');
        }
        $this->view('reservations/form', ['title'=>'Edit Reservation','tools'=>$this->tools->all(),'reservation'=>$reservation,'mode'=>'edit']);
    }
    public function reschedule(): void {
        require_auth();
        $reservation = $this->reservations->find((int)($_GET['id'] ?? 0)); if (!$reservation) die('Reservation not found');
        if (is_post()) {
            $this->reservations->update((int)$reservation['id'], ['start_date'=>$_POST['start_date'],'end_date'=>$_POST['end_date'],'status'=>'Rescheduled','notes'=>trim($_POST['notes'])]);
            flash('success', 'Reservation rescheduled.'); $this->redirect('page=reservations');
        }
        $reservation['status'] = 'Rescheduled';
        $this->view('reservations/form', ['title'=>'Reschedule Reservation','tools'=>$this->tools->all(),'reservation'=>$reservation,'mode'=>'reschedule']);
    }
    public function approve(): void { require_role(['Admin','Librarian','Lender']); $this->change((int)($_GET['id'] ?? 0), 'Approved', 'Reservation approved.'); }
    public function reject(): void { require_role(['Admin','Librarian','Lender']); $this->change((int)($_GET['id'] ?? 0), 'Rejected', 'Reservation rejected.'); }
    public function cancel(): void { require_auth(); $this->change((int)($_GET['id'] ?? 0), 'Cancelled', 'Reservation cancelled.'); }
    public function returnTool(): void { require_auth(); $this->change((int)($_GET['id'] ?? 0), 'Returned', 'Tool marked as returned.'); }
    public function delete(): void { require_role(['Admin','Librarian']); $this->reservations->delete((int)($_GET['id'] ?? 0)); flash('success', 'Reservation deleted.'); $this->redirect('page=reservations'); }
    private function change(int $id, string $status, string $msg): void { $this->reservations->changeStatus($id, $status); flash('success', $msg); $this->redirect('page=reservations'); }
}
