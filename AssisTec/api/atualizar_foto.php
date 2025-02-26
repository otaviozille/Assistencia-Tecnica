
<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../conexao.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if (!isset($_SESSION['idUsuario'])) {
    echo json_encode(["error" => "Usuário não autenticado"]);
    exit;
}

$idUsuario = $_SESSION['idUsuario'];

if (!empty($_FILES['fotoUsuario']['tmp_name'])) {
    $foto = file_get_contents($_FILES['fotoUsuario']['tmp_name']);

    try {
        $query = "UPDATE usuarios SET fotoUsuario=? WHERE idUsuario=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$foto, $idUsuario]);

        echo json_encode(["message" => "Foto atualizada com sucesso"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Erro ao atualizar foto: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Nenhuma imagem foi enviada"]);
}
?>
