<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "assistec";

try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8", "$usuario", "$senha");
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados";
    echo '<br>';
    echo $e->getMessage();
}
?>