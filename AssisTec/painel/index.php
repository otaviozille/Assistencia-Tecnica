<?php

//@session_start();

require_once("verificar.php");

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <!-- Sidebar (Menu Lateral) -->
    <nav class="sidebar">
        <h2>Sistema</h2>
        <ul>
            <li><a href="/AssisTec/painel/index.html">🏠 Home</a></li>
            <li><a href="/AssisTec/painel/pages/usuario.html">👤 Usuários</a></li>
            <li><a href="/AssisTec/painel/pages/relatorio.html">📊 Relatórios</a></li>
            <li><a href="logout.php">sair</a></li>
        </ul>
    </nav>

    <!-- Navbar (Barra Superior) -->
    <header class="navbar">
        <input type="text" placeholder="🔍 Pesquisar...">
        <div class="icons">
            <span>🔔</span>
            <span>👤 Nome Usuário</span>
            <button id="toggleMode">🌙</button>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="content">

        <h1>Dashboard</h1>
        <div class="cards">
            <div class="card">💰 Vendas: R$ 10.000</div>
            <div class="card">👤 Usuários: 500</div>
            <div class="card">📊 Relatórios: 15</div>
        </div>
        <div class="container">
            <h2>Gráficos de Estatísticas</h2>
            <div class="graficos">
                <canvas id="graficoVendas" class="grafico"></canvas>
                <canvas id="graficoUsuarios" class="grafico"></canvas>
            </div>
        </div>
        
        
    </main>

    <script src="/AssisTec/painel/script.js"></script>
</body>
</html>