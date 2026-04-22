<?php
namespace App\Controllers;
use App\Core\Controller;
class ThemeController extends Controller {
    public function switch(): void {
        $theme = $_GET['theme'] ?? 'light';
        $_SESSION['theme'] = in_array($theme, ['light','dark'], true) ? $theme : 'light';
        $back = $_SERVER['HTTP_REFERER'] ?? base_url('page=home');
        header('Location: ' . $back);
        exit;
    }
}
