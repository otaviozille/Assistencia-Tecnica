
<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../conexao.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if (!isset($_SESSION['idUsuario'])) {
    echo json_encode(["error" => "Usuário não autenticado"]);
    exit;
}

$idUsuario = $_SESSION['idUsuario'];
$data = json_decode(file_get_contents("php://input"), true);

$nome = $data['nomeUsuario'] ?? null;
$email = $data['emailUsuario'] ?? null;
$telefone = $data['telefoneUsuario'] ?? null;
$rua = $data['ruaUsuario'] ?? null;
$numero = $data['numeroUsuario'] ?? null;
$complemento = $data['complementoUsuario'] ?? null;
$bairro = $data['bairroUsuario'] ?? null;
$cidade = $data['cidadeUsuario'] ?? null;
$estado = $data['estadoUsuario'] ?? null;
$cep = $data['cepUsuario'] ?? null;
$nivel = $data['nivelUsuario'] ?? null;

try {
    $query = "UPDATE usuarios SET nomeUsuario=?, emailUsuario=?, telefoneUsuario=?, ruaUsuario=?, numeroUsuario=?, complementoUsuario=?, bairroUsuario=?, cidadeUsuario=?, estadoUsuario=?, cepUsuario=?, nivelUsuario=? WHERE idUsuario=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$nome, $email, $telefone, $rua, $numero, $complemento, $bairro, $cidade, $estado, $cep, $nivel, $idUsuario]);

    echo json_encode(["message" => "Perfil atualizado com sucesso"]);
} catch (Exception $e) {
    echo json_encode(["error" => "Erro ao atualizar perfil: " . $e->getMessage()]);
}
?>
