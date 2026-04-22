<?php
namespace App\Controllers;
use App\Core\Controller;
class LanguageController extends Controller {
    public function switch(): void {
        $lang = $_GET['lang'] ?? 'en';
        $_SESSION['lang'] = in_array($lang, ['en','ar'], true) ? $lang : 'en';
        $back = $_SERVER['HTTP_REFERER'] ?? base_url('page=home');
        header('Location: ' . $back);
        exit;
    }
}
