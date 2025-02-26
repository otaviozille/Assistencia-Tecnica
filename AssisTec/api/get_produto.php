<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
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

// Verifica se o ID do produto foi passado na URL
if (!isset($_GET["id"])) {
    die(json_encode(["error" => "ID do produto não especificado."]));
}

$id = $conn->real_escape_string($_GET["id"]);

// Consulta SQL para buscar um único produto
$query = "SELECT 
            codigo_sku, nome_produto, categoria, vendas, preco, 
            data_adicao, descricao, quantidade_estoque, marca 
          FROM produtos_vendas 
          WHERE codigo_sku = '$id'";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc(), JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(["error" => "Produto não encontrado."]);
}

$conn->close();
?>
