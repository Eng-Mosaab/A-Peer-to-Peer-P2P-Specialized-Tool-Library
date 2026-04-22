<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Category;
use App\Models\Tool;

class ToolController extends Controller {
    private Tool $tools;
    private Category $categories;
    public function __construct(private \PDO $db) {
        $this->tools = new Tool($db);
        $this->categories = new Category($db);
    }
    public function index(): void {
        require_auth();
        $search = trim($_GET['search'] ?? '');
        $this->view('tools/index', [
            'title' => t('tools'),
            'tools' => $this->tools->all($search),
            'search' => $search,
        ]);
    }
    public function search(): void {
        require_auth();
        $search = trim($_GET['search'] ?? '');
        $this->json(['items' => $this->tools->all($search)]);
    }
    public function create(): void {
        require_auth();
        require_role(['Admin','Lender','Librarian']);
        if (is_post()) {
            $img = $this->handleFile('image', 'tool_images');
            $doc = $this->handleFile('document', 'tool_docs', true);
            $this->tools->create([
                'lender_id' => (int)auth_user()['id'],
                'category_id' => (int)$_POST['category_id'],
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'tool_condition' => trim($_POST['tool_condition']),
                'status' => trim($_POST['status']),
                'daily_rate' => (float)$_POST['daily_rate'],
                'deposit_amount' => (float)$_POST['deposit_amount'],
                'location' => trim($_POST['location']),
                'availability_notes' => trim($_POST['availability_notes']),
                'image_path' => $img,
                'document_path' => $doc,
            ]);
            flash('success', 'Tool added successfully.');
            $this->redirect('page=tools');
        }
        $this->view('tools/form', ['title' => t('add_tool'), 'categories' => $this->categories->all(), 'tool' => null]);
    }
    public function edit(): void {
        require_auth();
        require_role(['Admin','Lender','Librarian']);
        $id = (int)($_GET['id'] ?? 0);
        $tool = $this->tools->find($id);
        if (!$tool) die('Tool not found');
        if (is_post()) {
            $img = $this->handleFile('image', 'tool_images') ?? $tool['image_path'];
            $doc = $this->handleFile('document', 'tool_docs', true) ?? $tool['document_path'];
            $this->tools->update($id, [
                'category_id' => (int)$_POST['category_id'], 'name' => trim($_POST['name']), 'description' => trim($_POST['description']),
                'tool_condition' => trim($_POST['tool_condition']), 'status' => trim($_POST['status']),
                'daily_rate' => (float)$_POST['daily_rate'], 'deposit_amount' => (float)$_POST['deposit_amount'],
                'location' => trim($_POST['location']), 'availability_notes' => trim($_POST['availability_notes']),
                'image_path' => $img, 'document_path' => $doc,
            ]);
            flash('success', 'Tool updated successfully.');
            $this->redirect('page=tools');
        }
        $this->view('tools/form', ['title' => t('edit') . ' ' . t('tools'), 'categories' => $this->categories->all(), 'tool' => $tool]);
    }
    public function delete(): void {
        require_auth(); require_role(['Admin','Lender','Librarian']);
        $id = (int)($_GET['id'] ?? 0);
        $this->tools->delete($id);
        flash('success', 'Tool deleted.');
        $this->redirect('page=tools');
    }
    public function show(): void {
        require_auth();
        $tool = $this->tools->find((int)($_GET['id'] ?? 0));
        if (!$tool) die('Tool not found');
        $this->view('tools/show', ['title' => e($tool['name']), 'tool' => $tool]);
    }
    private function handleFile(string $field, string $configKey, bool $pdfOnly=false): ?string {
        if (empty($_FILES[$field]['name'])) return null;
        if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) return null;
        $file = $_FILES[$field];
        $config = app_config();
        $allowed = $pdfOnly ? $config['allowed_doc_types'] : $config['allowed_image_types'];
        if (!in_array($file['type'], $allowed, true)) return null;
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $name = uniqid($field . '_', true) . '.' . strtolower($ext);
        $target = $config['upload_paths'][$configKey] . $name;
        if (!is_dir(dirname($target))) mkdir(dirname($target), 0777, true);
        if (move_uploaded_file($file['tmp_name'], $target)) {
            return ($configKey === 'tool_images' ? 'tools/' : ($configKey === 'tool_docs' ? 'docs/' : 'evidence/')) . $name;
        }
        return null;
    }
}
