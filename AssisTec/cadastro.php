<?php
session_start();
require 'conexao.php'; // Certifique-se de que a conexão está correta

function formatarCPF($cpf) {
    return preg_replace('/\D/', '', $cpf); // Remove tudo que não for número
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    $confirmar_senha = trim($_POST['confirmar_senha']);
    $cpf = formatarCPF($_POST['cpf']);
    $nivel_acesso = $_POST['nivel_acesso'];

    // Verificar se as senhas coincidem
    if ($senha !== $confirmar_senha) {
        $_SESSION['erro'] = "As senhas não coincidem.";
        header("Location: cadastro.php");
        exit();
    }

    // Validar CPF (deve ter 11 dígitos numéricos)
    if (!preg_match('/^\d{11}$/', $cpf)) {
        $_SESSION['erro'] = "CPF inválido. Digite apenas números.";
        header("Location: cadastro.php");
        exit();
    }

    try {
        // Hash da senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Inserir os dados no banco
        $stmt = $pdo->prepare("INSERT INTO usuarios (nomeUsuario, emailUsuario, senhaUsuario, senhaCripusuario, cpfUsuario, nivelUsuario, ativoUsuario) 
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $email, $senha, $senha_hash, $cpf, $nivel_acesso, 1]);

        // Redirecionar para o painel após cadastro
        $_SESSION['usuario'] = $email;
        header("Location: http://localhost:3000");
        exit();
    } catch (PDOException $e) {
        $_SESSION['erro'] = "Erro ao cadastrar: " . $e->getMessage();
        header("Location: cadastro.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function formatarCPF(input) {
            let cpf = input.value.replace(/\D/g, '');
            cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            input.value = cpf;
        }
    </script>
    <style>
        html, body {
            overflow: hidden;
        }
        select {
            width: 100%;
            padding: 14px;
            margin: 12px 0;
            border: none;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-radius: 25px;
            transition: 0.3s;
            text-align: center;
            font-size: 16px;
            cursor: pointer;
        }
        select:focus {
            background: rgba(255, 255, 255, 0.3);
            color: #fff;
        }
        select option {
            background: rgba(50, 50, 70, 0.9);
            color: #ffffff;
        }
        select:focus option:checked {
            background: rgba(100, 100, 150, 0.9);
        }
        h2 {
            color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="login">
        <form class="form" method="POST" action="cadastro.php">
            <img src="./img/login.png" class="imagem" alt="Logo">
            <h2>Cadastro</h2>
            <?php if (isset($_SESSION['erro'])) { echo "<p style='color:red;'>" . $_SESSION['erro'] . "</p>"; unset($_SESSION['erro']); } ?>
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <input type="password" name="confirmar_senha" placeholder="Confirmar Senha" required>
            <input type="text" name="cpf" placeholder="CPF (000.000.000-00)" required onkeyup="formatarCPF(this)">
            <select name="nivel_acesso" required>
                <option value="admin">Admin</option>
                <option value="vendedor">Vendedor</option>
                <option value="tesoureiro">Tesoureiro</option>
            </select>
            <button type="submit">Cadastrar</button>
            <p><a href="index.php" style="color: #f0f0f0;">Já tem uma conta? Faça login</a></p>
        </form>
    </div>
</body>
</html>
