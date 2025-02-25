
<?php
session_start();
session_unset();
session_destroy();

// Configuração CORS para permitir requisições do React
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

// Impede cache para garantir que o logout seja efetivo
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Retorna JSON indicando sucesso
header('Content-Type: application/json');
echo json_encode(["logout" => true]);
exit();

