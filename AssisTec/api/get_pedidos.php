<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$servername = "localhost";
$username = "root"; // Usuário padrão do XAMPP
$password = ""; // No XAMPP, a senha padrão é vazia
$dbname = "assistec"; // Substitua pelo nome do seu banco

// Criando conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die(json_encode(["error" => "Falha na conexão com o banco de dados"]));
}

// Query para buscar os pedidos
$sql = "SELECT p.nome_produto, ped.quantidade, ped.data_pedido, ped.status 
        FROM pedidos ped
        JOIN produtos_vendas p ON ped.id_produto = p.id
        ORDER BY ped.data_pedido DESC"; 

$result = $conn->query($sql);

$pedidos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pedidos[] = $row;
    }
}

// Retorna os pedidos em JSON
echo json_encode($pedidos);

$conn->close();
?>
