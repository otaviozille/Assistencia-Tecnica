<?php
// Simulação de dados de vendas e pedidos
$salesData = [
    ["month" => "Jan", "sales" => 4000],
    ["month" => "Feb", "sales" => 3000],
    ["month" => "Mar", "sales" => 5000],
    ["month" => "Apr", "sales" => 7000],
    ["month" => "May", "sales" => 6000],
];

$recentOrders = [
    ["id" => "#1023", "product" => "Smartphone X", "price" => "$899", "status" => "Enviado"],
    ["id" => "#1022", "product" => "Laptop Pro", "price" => "$1299", "status" => "Pendente"],
    ["id" => "#1021", "product" => "Fone Bluetooth", "price" => "$199", "status" => "Entregue"],
];
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Cliente</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { display: flex; flex-wrap: wrap; gap: 20px; }
        .card { background:rgb(42, 44, 46); padding: 20px; border-radius: 8px; box-shadow: 2px 2px 10px rgba(0,0,0,0.1); }
        .card h2 { margin-top: 0; }
        .sales-summary { flex: 1; min-width: 300px; }
        .orders-table { flex: 2; min-width: 500px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background:rgb(119, 123, 128); color: white; }
    </style>
</head>
<body>

    <h1>Dashboard do Cliente</h1>
    <div class="container">

        <!-- Bloco de Resumo de Vendas -->
        <div class="card sales-summary">
            <h2>Resumo de Vendas</h2>
            <ul>
                <?php foreach ($salesData as $sale): ?>
                    <li><?= $sale["month"] ?>: <strong>$<?= number_format($sale["sales"], 2, ",", ".") ?></strong></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Bloco de Pedidos Recentes -->
        <div class="card orders-table">
            <h2>Pedidos Recentes</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentOrders as $order): ?>
                        <tr>
                            <td><?= $order["id"] ?></td>
                            <td><?= $order["product"] ?></td>
                            <td><?= $order["price"] ?></td>
                            <td><?= $order["status"] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>
