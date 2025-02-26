<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Assistec";

// Conexão correta (sem argumento incorreto)
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Erro de conexão: " . $conn->connect_error]));
}

// Consulta SQL para buscar todos os produtos com marca e categoria
$query = "SELECT codigo_sku, nome_produto, categoria, marca FROM produtos_vendas";
$result = $conn->query($query);

$produtos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $produtos[] = $row;
    }
}

// Retorna os produtos em JSON
echo json_encode($produtos, JSON_UNESCAPED_UNICODE);

$conn->close();
?>
