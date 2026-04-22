<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Role;
use App\Models\User;

class UserController extends Controller {
    private User $users; private Role $roles;
    public function __construct(private \PDO $db) { $this->users = new User($db); $this->roles = new Role($db); }
    public function index(): void {
        require_role('Admin');
        $search = trim($_GET['search'] ?? ''); $roleId = (int)($_GET['role_id'] ?? 0);
        $this->view('users/index', ['title' => t('users'), 'users' => $this->users->all($search, $roleId ?: null), 'roles' => $this->roles->all(), 'search'=>$search, 'roleId'=>$roleId]);
    }
    public function create(): void {
        require_role('Admin');
        if (is_post()) {
            $this->users->create([
                'name'=>trim($_POST['name']), 'email'=>trim($_POST['email']),
                'password'=>password_hash($_POST['password'], PASSWORD_DEFAULT),
                'role_id'=>(int)$_POST['role_id'], 'location'=>trim($_POST['location']),
                'verification_status'=>trim($_POST['verification_status'] ?: 'Pending')
            ]);
            flash('success', 'User created.'); $this->redirect('page=users');
        }
        $this->view('users/form', ['title' => 'Create User', 'roles' => $this->roles->all(), 'user' => null]);
    }
    public function edit(): void {
        require_role('Admin');
        $user = $this->users->find((int)($_GET['id'] ?? 0)); if (!$user) die('User not found');
        if (is_post()) {
            $this->users->update((int)$user['id'], [
                'name'=>trim($_POST['name']), 'email'=>trim($_POST['email']),
                'password'=>$_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '',
                'role_id'=>(int)$_POST['role_id'], 'location'=>trim($_POST['location']), 'verification_status'=>trim($_POST['verification_status'])
            ]);
            flash('success', 'User updated.'); $this->redirect('page=users');
        }
        $this->view('users/form', ['title' => 'Edit User', 'roles' => $this->roles->all(), 'user' => $user]);
    }
    public function delete(): void {
        require_role('Admin');
        $this->users->delete((int)($_GET['id'] ?? 0));
        flash('success', 'User deleted.'); $this->redirect('page=users');
    }
}
