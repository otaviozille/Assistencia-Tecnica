<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Conectar ao banco de dados
$servername = "localhost";
$username = "root"; // Altere se necessário
$password = ""; // Altere se necessário
$dbname = "assistec"; // Confirme o nome do banco

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die(json_encode(["error" => "Falha na conexão com o banco de dados"]));
}

// Consulta os pedidos e obtém o nome do produto corretamente
$sql = "SELECT 
            p.id AS id_pedido, 
            pv.nome_produto, 
            p.quantidade, 
            pv.preco AS preco_unitario, 
            p.valor_total AS valor_pedido, 
            p.data_pedido, 
            p.status 
        FROM pedidos p
        JOIN produtos_vendas pv ON p.id_produto = pv.id
        ORDER BY p.data_pedido DESC";

$result = $conn->query($sql);

// Cria um array para armazenar os pedidos
$pedidos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pedidos[] = $row;
    }
} else {
    echo json_encode(["error" => "Nenhum pedido encontrado no banco"]);
    exit();
}

// Retorna os pedidos em formato JSON
echo json_encode($pedidos, JSON_PRETTY_PRINT);
$conn->close();
?>
