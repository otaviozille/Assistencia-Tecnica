<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["nivel"] != "admin") {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Painel Assistência Técnica</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="sidebar">
        <h4 class="text-center">Painel Admin</h4>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="gerenciar_usuarios.php">Gerenciar Usuários</a>
        <a href="relatorios.php">Relatórios</a>
        <a href="configuracoes.php">Configurações</a>
        <a href="logout.php">Sair</a>
    </div>
    
    <div class="content">
        <h2>Bem-vindo, <?php echo $_SESSION["nome"]; ?>!</h2>
        <p>Este é o painel administrativo da assistência técnica.</p>
    </div>
</body>
</html>
