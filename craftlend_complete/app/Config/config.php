<?php
return [
    'app_name' => 'CraftLend',
    'base_url' => 'http://localhost/craftlend_complete/public/index.php',
    'db' => [
        'host' => '127.0.0.1',
        'port' => '3306',
        'dbname' => 'craftlend_complete',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
    ],
    'upload_paths' => [
        'tool_images' => __DIR__ . '/../../public/uploads/tools/',
        'tool_docs' => __DIR__ . '/../../public/uploads/docs/',
        'evidence' => __DIR__ . '/../../public/uploads/evidence/',
    ],
    'allowed_image_types' => ['image/jpeg', 'image/png', 'image/webp'],
    'allowed_doc_types' => ['application/pdf'],
];
