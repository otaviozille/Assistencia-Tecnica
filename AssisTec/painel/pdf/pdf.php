<?php
require_once __DIR__ . '/config.php'; // Conexão com o banco de dados
require_once __DIR__ . '/dompdf/dompdf/autoload.inc.php'; // Caminho correto para DomPDF

use Dompdf\Dompdf;
use Dompdf\Options;

// Configurações do DomPDF
$options = new Options();
$options->set('defaultFont', 'Arial');
$dompdf = new Dompdf($options);

if (!isset($_GET['tipo'])) {
    die("Erro: Tipo de relatório não especificado.");
}

$tipo = $_GET['tipo'];
$html = "<h1>Relatório - " . ucfirst(str_replace("_", " ", $tipo)) . "</h1>";

// Conectar ao banco usando PDO
global $conn;
$query = "";

switch ($tipo) {
    case "produtos_vendas":
        $query = "SELECT id, nome_produto, categoria, vendas, preco FROM produtos_vendas";
        $html .= "<h2>Produtos Vendidos</h2>
                  <table border='1'>
                    <tr><th>ID</th><th>Produto</th><th>Categoria</th><th>Vendas</th><th>Preço</th></tr>";
        break;

    case "pedidos":
        $query = "SELECT p.id, u.nomeUsuario AS cliente, pr.nome_produto AS produto, 
                         p.quantidade, p.valor_total, p.data_pedido, p.status 
                  FROM pedidos p
                  JOIN usuarios u ON p.id_usuario = u.idUsuario
                  JOIN produtos_vendas pr ON p.id_produto = pr.id";
        $html .= "<h2>Pedidos</h2>
                  <table border='1'>
                    <tr><th>ID Pedido</th><th>Cliente</th><th>Produto</th><th>Quantidade</th><th>Valor Total</th>
                    <th>Data do Pedido</th><th>Status</th></tr>";
        break;

    case "usuarios":
        $query = "SELECT idUsuario, nomeUsuario, cpfUsuario, emailUsuario FROM usuarios";
        $html .= "<h2>Usuários</h2>
                  <table border='1'>
                    <tr><th>ID</th><th>Nome</th><th>CPF</th><th>Email</th></tr>";
        break;

    case "geral":
        // Mostra TODAS as tabelas no relatório geral

        // PEDIDOS
        $html .= "<h2>Pedidos</h2>
                  <table border='1'>
                    <tr><th>ID Pedido</th><th>Cliente</th><th>Produto</th><th>Quantidade</th><th>Valor Total</th>
                    <th>Data do Pedido</th><th>Status</th></tr>";

        $query = "SELECT p.id, u.nomeUsuario AS cliente, pr.nome_produto AS produto, 
                         p.quantidade, p.valor_total, p.data_pedido, p.status 
                  FROM pedidos p
                  JOIN usuarios u ON p.id_usuario = u.idUsuario
                  JOIN produtos_vendas pr ON p.id_produto = pr.id";

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $row) {
            $html .= "<tr>";
            foreach ($row as $value) {
                $html .= "<td>" . htmlspecialchars($value) . "</td>";
            }
            $html .= "</tr>";
        }
        $html .= "</table><br>";

        // PRODUTOS VENDIDOS
        $html .= "<h2>Produtos Vendidos</h2>
                  <table border='1'>
                    <tr><th>ID</th><th>Produto</th><th>Categoria</th><th>Vendas</th><th>Preço</th></tr>";

        $query = "SELECT id, nome_produto, categoria, vendas, preco FROM produtos_vendas";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $row) {
            $html .= "<tr>";
            foreach ($row as $value) {
                $html .= "<td>" . htmlspecialchars($value) . "</td>";
            }
            $html .= "</tr>";
        }
        $html .= "</table><br>";

        // USUÁRIOS
        $html .= "<h2>Usuários</h2>
                  <table border='1'>
                    <tr><th>ID</th><th>Nome</th><th>CPF</th><th>Email</th></tr>";

        $query = "SELECT idUsuario, nomeUsuario, cpfUsuario, emailUsuario FROM usuarios";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $row) {
            $html .= "<tr>";
            foreach ($row as $value) {
                $html .= "<td>" . htmlspecialchars($value) . "</td>";
            }
            $html .= "</tr>";
        }
        $html .= "</table><br>";

        break;

    default:
        die("Erro: Tipo de relatório inválido.");
}

// Se não for "geral", processa normalmente
if ($tipo !== "geral") {
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $html .= "<tr>";
        foreach ($row as $value) {
            $html .= "<td>" . htmlspecialchars($value) . "</td>";
        }
        $html .= "</tr>";
    }
    $html .= "</table>";
}

// Gerando o PDF com DomPDF
$dompdf->loadHtml($html);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();
$dompdf->stream("relatorio_$tipo.pdf", ["Attachment" => true]);

?>
