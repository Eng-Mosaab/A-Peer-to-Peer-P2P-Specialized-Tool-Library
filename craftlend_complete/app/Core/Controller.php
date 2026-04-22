<?php
namespace App\Core;

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';
        if (!file_exists($viewFile)) {
            http_response_code(404);
            die('View not found');
        }
        include __DIR__ . '/../Views/layouts/header.php';
        include $viewFile;
        include __DIR__ . '/../Views/layouts/footer.php';
    }

    protected function redirect(string $query = ''): void
    {
        header('Location: ' . base_url($query));
        exit;
    }

    protected function json(array $payload): void
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
