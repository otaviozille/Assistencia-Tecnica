<?php
session_start();
if (isset($_SESSION["id"])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Painel Assistência Técnica</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login">
        <form class="form" action="autenticar.php" method="post">
            <img src="./img/login.png" alt="Logo" class="imagem">
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
