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
$nome = $_POST['nomeUsuario'] ?? null;
$email = $_POST['emailUsuario'] ?? null;
$telefone = $_POST['telefoneUsuario'] ?? null;
$senha = $_POST['senhaUsuario'] ?? null;
$rua = $_POST['ruaUsuario'] ?? null;
$numero = $_POST['numeroUsuario'] ?? null;
$complemento = $_POST['complementoUsuario'] ?? null;
$bairro = $_POST['bairroUsuario'] ?? null;
$cidade = $_POST['cidadeUsuario'] ?? null;
$estado = $_POST['estadoUsuario'] ?? null;
$cep = $_POST['cepUsuario'] ?? null;

// 🛠️ Atualiza os dados básicos (sem senha ainda)
$query = "UPDATE usuarios SET nomeUsuario=?, emailUsuario=?, telefoneUsuario=?, ruaUsuario=?, numeroUsuario=?, complementoUsuario=?, bairroUsuario=?, cidadeUsuario=?, estadoUsuario=?, cepUsuario=?";
$params = [$nome, $email, $telefone, $rua, $numero, $complemento, $bairro, $cidade, $estado, $cep];

// 🔑 Se a senha foi enviada, criptografa e atualiza
if (!empty($senha)) {
    $senhaCriptografada = password_hash($senha, PASSWORD_BCRYPT);
    $query .= ", senhaUsuario=?, senhaCripusuario=?";
    $params[] = $senha; // 🔹 Armazena a senha em texto puro (caso precise)
    $params[] = $senhaCriptografada; // 🔹 Armazena a senha criptografada
}

$query .= " WHERE idUsuario=?";
$params[] = $idUsuario;

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    echo json_encode(["message" => "Perfil atualizado com sucesso"]);
} catch (Exception $e) {
    echo json_encode(["error" => "Erro ao atualizar perfil: " . $e->getMessage()]);
}
?>
