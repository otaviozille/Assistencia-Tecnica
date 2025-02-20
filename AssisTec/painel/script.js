document.getElementById('atualizarDados').addEventListener('click', function() {
    // Simulando a atualização de dados
    const novasVendas = Math.floor(Math.random() * 20000); // Gera um valor aleatório para vendas
    const novasDespesas = Math.floor(Math.random() * 10000); // Gera um valor aleatório para despesas
    const novosGastos = Math.floor(Math.random() * 5000); // Gera um valor aleatório para gastos
    const totalUsuarios = Math.floor(Math.random() * 100); // Gera um valor aleatório para usuários

    // Atualiza os elementos com os novos valores
    document.getElementById('vendas').innerText = `💰 Vendas: R$ ${novasVendas}`;
    document.getElementById('despesas').innerText = `🧾 Despesas: R$ ${novasDespesas}`;
    document.getElementById('gastos').innerText = `📊 Gastos: R$ ${novosGastos}`;
    document.getElementById('usuarios').innerText = `👤 Total de Usuários: ${totalUsuarios}`;
});


document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("graficoVendas").getContext("2d");

    let dadosVendas = {
        labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun"],
        datasets: [{
            label: "Vendas (R$)",
            data: [], // Os dados virão dinamicamente
            backgroundColor: "rgba(54, 162, 235, 0.5)",
            borderColor: "rgba(54, 162, 235, 1)",
            borderWidth: 1
        }]
    };

    let grafico = new Chart(ctx, {
        type: "bar",
        data: dadosVendas,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Função para carregar os dados dinamicamente
    function carregarDados() {
        // Simulando uma API com dados dinâmicos
        fetch("https://api.exemplo.com/vendas") // Substitua por uma API real
            .then(response => response.json())
            .then(data => {
                // Atualizando os dados do gráfico
                dadosVendas.datasets[0].data = data.vendas;
                grafico.update();
            })
            .catch(error => console.error("Erro ao carregar os dados:", error));
    }

    // Chamando a função para carregar os dados ao iniciar
    carregarDados();

    // Atualiza os dados a cada 10 segundos (exemplo)
    setInterval(carregarDados, 10000);
});

document.addEventListener("DOMContentLoaded", function () {
    const ctxUsuarios = document.getElementById("graficoUsuarios").getContext("2d");

    let dadosUsuarios = {
        labels: ["Ativos", "Inativos"],
        datasets: [{
            data: [], // Os dados serão carregados dinamicamente
            backgroundColor: ["#28a745", "#dc3545"], // Verde para ativos, vermelho para inativos
            borderColor: ["#28a745", "#dc3545"],
            borderWidth: 1
        }]
    };

    let graficoUsuarios = new Chart(ctxUsuarios, {
        type: "doughnut",
        data: dadosUsuarios,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: "top"
                }
            }
        }
    });

    // Função para carregar os dados dinamicamente
    function carregarDadosUsuarios() {
        // Simulando uma API que retorna o número de usuários ativos e inativos
        fetch("dados.json") // Substitua por uma API real
            .then(response => response.json())
            .then(data => {
                // Atualizando os dados do gráfico
                dadosUsuarios.datasets[0].data = [data.ativos, data.inativos];
                graficoUsuarios.update();
            })
            .catch(error => console.error("Erro ao carregar os dados de usuários:", error));
    }

    // Carrega os dados ao iniciar
    carregarDadosUsuarios();

    // Atualiza os dados a cada 10 segundos (opcional)
    setInterval(carregarDadosUsuarios, 10000);
});


/*MODO CLARO E ESCURO*/

document.addEventListener("DOMContentLoaded", function() {
    const toggleButton = document.getElementById("toggleMode");
    const body = document.body;

    // Verifica se o usuário já escolheu um tema anteriormente
    if (localStorage.getItem("theme") === "dark") {
        body.classList.add("dark-mode");
        toggleButton.textContent = "☀️";
    }

    // Alterna entre os modos
    toggleButton.addEventListener("click", function() {
        body.classList.toggle("dark-mode");

        // Salva a preferência do usuário
        if (body.classList.contains("dark-mode")) {
            localStorage.setItem("theme", "dark");
            toggleButton.textContent = "☀️";
        } else {
            localStorage.setItem("theme", "light");
            toggleButton.textContent = "🌙";
        }
    });
});

//Botao para sidebar
document.getElementById('toggleSidebar').addEventListener('click', function() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active'); // Adiciona ou remove a classe 'active'
});