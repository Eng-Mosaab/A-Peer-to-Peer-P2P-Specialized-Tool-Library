<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Role;
use App\Models\User;

class AuthController extends Controller {
    private User $users;
    private Role $roles;
    public function __construct(private \PDO $db) {
        $this->users = new User($db);
        $this->roles = new Role($db);
    }
    public function login(): void {
        if (is_post()) {
            $user = $this->users->findByEmail(trim($_POST['email'] ?? ''));
            if ($user && password_verify($_POST['password'] ?? '', $user['password'])) {
                $_SESSION['user'] = $user;
                flash('success', 'Login successful.');
                $this->redirect('page=dashboard');
            }
            flash('error', 'Invalid email or password.');
            $this->redirect('page=auth&action=login');
        }
        $this->view('auth/login', ['title' => t('login')]);
    }
    public function register(): void {
        if (is_post()) {
            $email = trim($_POST['email'] ?? '');
            if ($this->users->findByEmail($email)) {
                flash('error', 'This email already exists.');
                $this->redirect('page=auth&action=register');
            }
            $ok = $this->users->create([
                'name' => trim($_POST['name'] ?? ''),
                'email' => $email,
                'password' => password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT),
                'role_id' => (int)($_POST['role_id'] ?? 0),
                'location' => trim($_POST['location'] ?? ''),
            ]);
            if ($ok) {
                flash('success', 'Account created. Please login.');
                $this->redirect('page=auth&action=login');
            }
            flash('error', 'Could not create account.');
            $this->redirect('page=auth&action=register');
        }
        $this->view('auth/register', ['title' => t('register'), 'roles' => $this->roles->all()]);
    }
    public function logout(): void {
        session_destroy();
        header('Location: ' . base_url('page=home'));
        exit;
    }
}
