<?php
require 'conexao.php';

$sql = "SELECT pedidos.id, usuarios.nomeUsuario, produtos_vendas.nome_produto, pedidos.quantidade, 
                  pedidos.valor_total, pedidos.data_pedido, pedidos.status 
           FROM pedidos
           INNER JOIN usuarios ON pedidos.id_usuario = usuarios.idUsuario
           INNER JOIN produtos_vendas ON pedidos.id_produto = produtos_vendas.id";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background-color: #f8f9fa; }
        .container { margin-top: 20px; }
        .card { margin-bottom: 20px; }
    </style>
</head>
<body>
           
<h3 class="text-center my-4">Lista de Pedidos</h3>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>id_Usuário</th>
                    <th>id_Produto</th>
                    <th>Quantidade</th>
                    <th>Valor Total (R$)</th>
                    <th>Data do Pedido</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?php echo $pedido['id']; ?></td>
                        <td><?php echo $pedido['id_usuario']; ?></td>
                        <td><?php echo $pedido['id_produto']; ?></td>
                        <td><?php echo $pedido['quantidade']; ?></td>
                        <td>R$ <?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?></td>
                        <td><?php echo $pedido['data_pedido']; ?></td>
                        <td><?php echo $pedido['status']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="container">
        <h2 class="text-center my-4"></h2>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pedidos por Status</h5>
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Vendas por Produto</h5>
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    
    <script>
        // Dados de exemplo para gráficos (substituir com dados reais via PHP)
        var statusData = {
            labels: ["Pendente", "Aprovado", "Enviado", "Entregue"],
            datasets: [{
                label: "Pedidos",
                data: [5, 10, 7, 3], // Substituir com contagem real
                backgroundColor: ["#ffc107", "#28a745", "#17a2b8", "#007bff"]
            }]
        };

        var salesData = {
            labels: ["Produto A", "Produto B", "Produto C"],
            datasets: [{
                label: "Vendas",
                data: [15, 20, 10], // Substituir com contagem real
                backgroundColor: ["#ff6384", "#36a2eb", "#ffcd56"]
            }]
        };

        new Chart(document.getElementById("statusChart"), { type: "pie", data: statusData });
        new Chart(document.getElementById("salesChart"), { type: "bar", data: salesData });
    </script>
</body>
</html>
