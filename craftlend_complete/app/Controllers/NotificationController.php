<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\EmailLog;
use App\Models\Notification;
use App\Models\Role;
use App\Models\User;

class NotificationController extends Controller {
    private Notification $notifications; private Role $roles; private EmailLog $emails; private User $users;
    public function __construct(private \PDO $db) { $this->notifications = new Notification($db); $this->roles = new Role($db); $this->emails = new EmailLog($db); $this->users = new User($db); }
    public function index(): void {
        require_auth();
        $items = has_role('Admin') ? $this->notifications->all() : $this->notifications->forUser((int)auth_user()['id']);
        $this->view('notifications/index',['title'=>t('notifications'),'items'=>$items,'roles'=>$this->roles->all(),'users'=>$this->users->all(),'emailLogs'=>$this->emails->all()]);
    }
    public function create(): void {
        require_role(['Admin','Librarian']);
        if (is_post()) {
            $targetType = $_POST['target_type'] ?? 'user';
            $title = trim($_POST['title'] ?? ''); $message = trim($_POST['message'] ?? '');
            if ($targetType === 'role') $this->notifications->createForRole((int)$_POST['role_id'], $title, $message);
            else $this->notifications->create((int)$_POST['user_id'], $title, $message);
            flash('success', 'Notification sent.');
        }
        $this->redirect('page=notifications');
    }
    public function sendEmail(): void {
        require_role(['Admin','Librarian']);
        if (is_post()) {
            $this->emails->create(['recipient_email'=>trim($_POST['recipient_email'] ?? ''),'subject'=>trim($_POST['subject'] ?? ''),'message'=>trim($_POST['message'] ?? '')]);
            flash('success', 'Email was logged as sent.');
        }
        $this->redirect('page=notifications');
    }
    public function markRead(): void { require_auth(); $id=(int)($_POST['id'] ?? 0); $ok=$this->notifications->markRead($id,(int)auth_user()['id']); $this->json(['success'=>$ok]); }
}
