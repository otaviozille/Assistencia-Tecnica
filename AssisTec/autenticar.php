
<?php
session_start();
require_once("conexao.php");

$usuario = $_POST['email'];
$senha = $_POST['senha'];

$query = $pdo->prepare("SELECT * FROM usuarios WHERE emailUsuario = :email AND senhaUsuario = :senha");
$query->bindParam(':email', $usuario, PDO::PARAM_STR);
$query->bindParam(':senha', $senha, PDO::PARAM_STR);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

if (count($result) > 0) {
    $_SESSION['idUsuario'] = $result[0]['idUsuario'];
    $_SESSION['nome'] = $result[0]['nomeUsuario'];
    $_SESSION['nivel'] = $result[0]['nivelUsuario'];

    header("Location: http://localhost:3000/dashboard");
    exit();
} else {
    echo "<script>alert('Usuário ou senha incorretos!'); window.location.href = 'index.php';</script>";
}
?>

