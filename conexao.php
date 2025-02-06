<?php
//5

//variaveis para conexao local

$servidor = 'localhost';
$banco = 'assistec';
$usuario = 'root';
$senha = '';

//tratar erros com o banco de dados

try {
    //Criar conexao com o banco de dados utilizando as variaveis
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco;charset =utf8", "$usuario", "$senha");
} catch (Exception $e) {
    echo 'Erro ao conectar com o banco de dados';
    echo '<br>';
    echo $e;
}



?>