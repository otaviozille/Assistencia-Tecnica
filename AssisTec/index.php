<?php
session_start();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function togglePassword() {
            var senha = document.getElementById("senha");
            var icon = document.getElementById("togglePassword");
            if (senha.type === "password") {
                senha.type = "text";
                icon.textContent = "🙈"; // Ícone de "ocultar"
            } else {
                senha.type = "password";
                icon.textContent = "👁"; // Ícone de "mostrar"
            }
        }
    </script>
</head>
<body>
    <div class="login">
        <form class="form" action="autenticar.php" method="POST">
            <img src="./img/login.png" class="imagem" alt="Logo">
            <input type="email" name="email" placeholder="E-mail" required>
            <div style="position: relative;">
                <input type="password" id="senha" name="senha" placeholder="Senha" required>
                <span id="togglePassword" onclick="togglePassword()" 
                      style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                    👁
                </span>
            </div>
            <button type="submit">Entrar</button>
            <p><a href="cadastro.php" style="color: #f0f0f0;">Cadastre-se</a></p>

        </form>
    </div>
</body>
</html>
