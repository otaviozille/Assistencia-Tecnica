<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../conexao.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");

if (!isset($_SESSION['idUsuario'])) {
    echo json_encode(["error" => "Usuário não autenticado"]);
    exit;
}


$idUsuario = $_SESSION['idUsuario'];

$stmt = $pdo->prepare("SELECT nomeUsuario, nivelUsuario, emailUsuario, telefoneUsuario, ruaUsuario, numeroUsuario, complementoUsuario, bairroUsuario, cidadeUsuario, estadoUsuario, cepUsuario, fotoUsuario FROM usuarios WHERE idUsuario = ?");
$stmt->execute([$idUsuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario) {
    $usuario['fotoUsuario'] = !empty($usuario['fotoUsuario']) ? base64_encode($usuario['fotoUsuario']) : "";
    echo json_encode($usuario);
} else {
    echo json_encode(["error" => "Usuário não encontrado"]);
}
?>
