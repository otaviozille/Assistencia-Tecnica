<?php
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT); // Senha criptografada
    $nivel = $_POST["nivel"]; // Pode ser "admin", "funcionario" ou "cliente"

    // Upload da foto do usuário
    $foto_nome = $_FILES["foto"]["name"];
    $foto_temp = $_FILES["foto"]["tmp_name"];
    $foto_destino = "uploads/" . $foto_nome;
    move_uploaded_file($foto_temp, $foto_destino);

    // Inserção no banco de dados
    $sql = "INSERT INTO usuarios (nome, email, senha, nivel, foto) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssss", $nome, $email, $senha, $nivel, $foto_destino);

    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso! <a href='index.php'>Fazer login</a>";
    } else {
        echo "Erro ao cadastrar usuário.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login">
        <form class="form" action="cadastro.php" method="post" enctype="multipart/form-data">
            <h2>Cadastro</h2>
            <input type="text" name="nome" placeholder="Nome completo" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            
            <label for="nivel">Nível de Acesso:</label>
            <select name="nivel" required>
                <option value="admin">Administrador</option>
                <option value="funcionario">Funcionário</option>
                <option value="cliente">Cliente</option>
            </select>

            <label for="foto">Foto de Perfil:</label>
            <input type="file" name="foto" accept="image/*" required>

            <button type="submit">Cadastrar</button>
            <p>Já tem uma conta? <a href="index.php">Faça login</a></p>
        </form>
    </div>
</body>
</html>
