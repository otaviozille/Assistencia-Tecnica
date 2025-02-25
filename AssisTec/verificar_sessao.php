<<<<<<< HEAD
<?php
session_start();
header("Content-Type: application/json");

if (isset($_SERVER['HTTP_ORIGIN'])) {
    $http_origin = $_SERVER['HTTP_ORIGIN'];
    if (strpos($http_origin, "http://localhost:") === 0) {
        header("Access-Control-Allow-Origin: $http_origin");
    }
}

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit(0);
}

// 🔹 Agora retorna `idUsuario`
if (isset($_SESSION["idUsuario"])) {
    echo json_encode([
        "authenticated" => true,
        "idUsuario" => $_SESSION["idUsuario"], 
        "user" => $_SESSION["nome"],
        "nivel" => $_SESSION["nivel"]
    ]);
} else {
    echo json_encode(["authenticated" => false]);
}
?>
=======
<?php
session_start();
header("Content-Type: application/json");

if (isset($_SERVER['HTTP_ORIGIN'])) {
    $http_origin = $_SERVER['HTTP_ORIGIN'];
    if (strpos($http_origin, "http://localhost:") === 0) {
        header("Access-Control-Allow-Origin: $http_origin");
    }
}

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit(0);
}

// 🔹 Agora retorna `idUsuario`
if (isset($_SESSION["idUsuario"])) {
    echo json_encode([
        "authenticated" => true,
        "idUsuario" => $_SESSION["idUsuario"], 
        "user" => $_SESSION["nome"],
        "nivel" => $_SESSION["nivel"]
    ]);
} else {
    echo json_encode(["authenticated" => false]);
}
?>
>>>>>>> 73c4a9e (adição painel e edição perfil)
