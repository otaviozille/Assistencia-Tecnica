<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$servidor = "127.0.0.1"; // Use 127.0.0.1 para evitar conflitos com DNS
$usuario = "root";
$senha = "";
$banco = "assistec";

try {
    // Cria a conexão com PDO
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8", $usuario, $senha, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Ativa os erros do PDO
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Modo de fetch padrão
        PDO::ATTR_PERSISTENT => true // Mantém a conexão aberta para melhor performance
    ]);
    // echo "✅ Conexão bem-sucedida!"; // Descomente para testar no navegador
} catch (PDOException $e) {
    die("❌ Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>
