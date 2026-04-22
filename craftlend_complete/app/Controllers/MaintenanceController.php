<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\MaintenanceRequest;
use App\Models\Tool;

class MaintenanceController extends Controller {
    private MaintenanceRequest $requests; private Tool $tools;
    public function __construct(private \PDO $db) { $this->requests = new MaintenanceRequest($db); $this->tools = new Tool($db); }
    public function index(): void { require_auth(); $this->view('maintenance/index',['title'=>t('maintenance'),'requests'=>$this->requests->all()]); }
    public function create(): void {
        require_auth();
        if (is_post()) {
            $evidence = $this->handleEvidence();
            $this->requests->create([
                'tool_id'=>(int)$_POST['tool_id'], 'created_by'=>(int)auth_user()['id'], 'title'=>trim($_POST['title']), 'description'=>trim($_POST['description']), 'priority'=>trim($_POST['priority']), 'status'=>trim($_POST['status']), 'evidence_path'=>$evidence,
            ]);
            flash('success', 'Maintenance request created.'); $this->redirect('page=maintenance');
        }
        $this->view('maintenance/form',['title'=>t('new_request'),'tools'=>$this->tools->all(),'request'=>null]);
    }
    public function edit(): void {
        require_auth(); $request = $this->requests->find((int)($_GET['id'] ?? 0)); if(!$request) die('Request not found');
        if (is_post()) {
            $evidence = $this->handleEvidence() ?? $request['evidence_path'];
            $this->requests->update((int)$request['id'], ['title'=>trim($_POST['title']),'description'=>trim($_POST['description']),'priority'=>trim($_POST['priority']),'status'=>trim($_POST['status']),'evidence_path'=>$evidence]);
            flash('success','Maintenance request updated.'); $this->redirect('page=maintenance');
        }
        $this->view('maintenance/form',['title'=>'Edit Request','tools'=>$this->tools->all(),'request'=>$request]);
    }
    private function handleEvidence(): ?string {
        if (empty($_FILES['evidence']['name'])) return null;
        if ($_FILES['evidence']['error'] !== UPLOAD_ERR_OK) return null;
        $file = $_FILES['evidence'];
        $allowed = array_merge(app_config()['allowed_image_types'], app_config()['allowed_doc_types']);
        if (!in_array($file['type'], $allowed, true)) return null;
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $name = uniqid('evidence_', true) . '.' . strtolower($ext);
        $target = app_config()['upload_paths']['evidence'] . $name;
        if (!is_dir(dirname($target))) mkdir(dirname($target), 0777, true);
        if (move_uploaded_file($file['tmp_name'], $target)) return 'evidence/' . $name;
        return null;
    }
}
