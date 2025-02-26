<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assistec"; // Altere para o nome correto do seu banco de dados

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die(json_encode(["error" => "Falha na conexão com o banco de dados: " . $conn->connect_error]));
}

// Total de vendas concluídas
$sql = "SELECT COUNT(*) AS total_vendas FROM pedidos WHERE status = 'Concluído'";
$result = $conn->query($sql);
$total_vendas = $result->fetch_assoc()["total_vendas"] ?? 0;

// Receita total
$sql = "SELECT SUM(valor_total) AS receita FROM pedidos WHERE status = 'Concluído'";
$result = $conn->query($sql);
$receita = $result->fetch_assoc()["receita"] ?? 0;

// Pedidos pendentes
$sql = "SELECT COUNT(*) AS pedidos_pendentes FROM pedidos WHERE status = 'Pendente'";
$result = $conn->query($sql);
$pedidos_pendentes = $result->fetch_assoc()["pedidos_pendentes"] ?? 0;

// Produtos mais vendidos (Gráfico de Barras)
$sql = "SELECT p.nome_produto, SUM(pd.quantidade) AS total_vendido 
        FROM pedidos pd
        INNER JOIN produtos_vendas p ON pd.id_produto = p.id
        WHERE pd.status = 'Concluído'
        GROUP BY p.nome_produto
        ORDER BY total_vendido DESC";

$result = $conn->query($sql);
$produtos_vendidos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $produtos_vendidos[] = [
            "nome_produto" => $row["nome_produto"],
            "total_vendido" => (int)$row["total_vendido"]
        ];
    }
}

// Histórico de vendas - Número de pedidos concluídos por dia
$sql = "SELECT DATE(data_pedido) AS data, COUNT(id) AS total_vendas
        FROM pedidos
        WHERE status = 'Concluído'
        GROUP BY DATE(data_pedido)
        ORDER BY data_pedido ASC";

$result = $conn->query($sql);
$historico_vendas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $historico_vendas[] = [
            "data" => $row["data"],
            "total_vendas" => (int)$row["total_vendas"]
        ];
    }
}

// 📌 ADICIONADO: Histórico de receita - Valor total das vendas por dia (necessário para corrigir o gráfico)
$sql = "SELECT DATE(data_pedido) AS data, SUM(valor_total) AS receita_dia
        FROM pedidos
        WHERE status = 'Concluído'
        GROUP BY DATE(data_pedido)
        ORDER BY data_pedido ASC";

$result = $conn->query($sql);
$historico_receita = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $historico_receita[] = [
            "data" => $row["data"],
            "receita_dia" => (float)$row["receita_dia"]
        ];
    }
}

// Cálculo da porcentagem de vendas concluídas em relação aos pedidos totais
$total_pedidos = $total_vendas + $pedidos_pendentes;
$porcentagem_vendas = $total_pedidos > 0 ? round(($total_vendas / $total_pedidos) * 100) : 0;

// Resposta JSON
$response = [
    "total_vendas" => $total_vendas,
    "receita" => number_format($receita, 2, ".", ""),
    "pedidos_pendentes" => $pedidos_pendentes,
    "produtos_vendidos" => $produtos_vendidos,
    "historico_vendas" => $historico_vendas, // ✅ Continua mostrando o número de pedidos por dia
    "historico_receita" => $historico_receita, // ✅ Agora inclui a receita diária para o gráfico
    "porcentagem_vendas" => $porcentagem_vendas
];

echo json_encode($response, JSON_PRETTY_PRINT);

// Fechar conexão
$conn->close();
?>
