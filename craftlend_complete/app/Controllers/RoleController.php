<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Role;

class RoleController extends Controller {
    private Role $roles;
    public function __construct(private \PDO $db) { $this->roles = new Role($db); }
    public function index(): void {
        require_role('Admin');
        $search = trim($_GET['search'] ?? '');
        $this->view('roles/index', ['title' => t('roles'), 'roles' => $this->roles->all($search), 'search' => $search]);
    }
    public function create(): void {
        require_role('Admin');
        if (is_post()) {
            try { $this->roles->create(trim($_POST['name'] ?? '')); flash('success','Role created.'); }
            catch (\Throwable $e) { flash('error','Role name must be unique.'); }
            $this->redirect('page=roles');
        }
        $this->view('roles/form', ['title' => t('new_role'), 'role' => null]);
    }
    public function edit(): void {
        require_role('Admin');
        $role = $this->roles->find((int)($_GET['id'] ?? 0)); if (!$role) die('Role not found');
        if (is_post()) {
            try { $this->roles->update((int)$role['id'], trim($_POST['name'] ?? '')); flash('success','Role updated.'); }
            catch (\Throwable $e) { flash('error','Could not update role.'); }
            $this->redirect('page=roles');
        }
        $this->view('roles/form', ['title' => t('edit').' '.t('roles'), 'role' => $role]);
    }
    public function delete(): void {
        require_role('Admin');
        try { $this->roles->delete((int)($_GET['id'] ?? 0)); flash('success','Role deleted.'); }
        catch (\Throwable $e) { flash('error','Role cannot be deleted while users are using it.'); }
        $this->redirect('page=roles');
    }
}
