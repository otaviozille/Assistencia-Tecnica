<?php
$servername = "localhost";
$username = "root";  // Altere conforme necessário
$password = "";  // Altere conforme necessário
$dbname = "assistec";  // Nome do seu banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Buscar dados das vendas no banco
$sql = "SELECT id, nome_produto, valor_produto, quantidade_produto FROM produtos ORDER BY id DESC";
$result = $conn->query($sql);

// Criar array para gráfico
$dados_grafico = [];
while ($row = $result->fetch_assoc()) {
    $dados_grafico[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Vendas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        canvas { max-width: 600px; margin: 20px auto; }
    </style>
</head>
<body>

    <h1>Relatório de Vendas</h1>

    <!-- Tabela de Vendas -->
    <table>
        <tr>
            <th>ID</th>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Total (R$)</th>
            <th>Data</th>
        </tr>
        <?php foreach ($dados_grafico as $venda): ?>
        <tr>
            <td><?= $venda["id"] ?></td>
            <td><?= $venda["produto"] ?></td>
            <td><?= $venda["quantidade"] ?></td>
            <td><?= number_format($venda["total"], 2, ',', '.') ?></td>
            <td><?= date("d/m/Y H:i", strtotime($venda["data_venda"])) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- Gráfico de Vendas -->
    <canvas id="graficoVendas"></canvas>

    <script>
        const ctx = document.getElementById('graficoVendas').getContext('2d');
        const dadosGrafico = <?= json_encode($dados_grafico) ?>;

        const labels = dadosGrafico.map(venda => venda.produto);
        const valores = dadosGrafico.map(venda => venda.total);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Vendido (R$)',
                    data: valores,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>

</body>
</html>
