
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../conexao.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit(0);
}

if (!isset($_SESSION['idUsuario'])) {
    echo json_encode(["error" => "Usuário não autenticado"]);
    exit;
}

$idUsuario = $_SESSION['idUsuario'];

try {
    $stmt = $pdo->prepare("UPDATE usuarios SET fotoUsuario = NULL WHERE idUsuario = ?");
    $stmt->execute([$idUsuario]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(["message" => "Foto removida com sucesso"]);
    } else {
        echo json_encode(["error" => "Nenhuma alteração feita no banco de dados"]);
    }
} catch (Exception $e) {
    echo json_encode(["error" => "Erro ao remover foto: " . $e->getMessage()]);
}
?>
