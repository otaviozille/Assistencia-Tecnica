document.addEventListener("DOMContentLoaded", function() {
    console.log("Painel Admin carregado!");
});


document.addEventListener("DOMContentLoaded", function() {
    // Gráfico de Vendas
    var ctxVendas = document.getElementById('graficoVendas').getContext('2d');
    var graficoVendas = new Chart(ctxVendas, {
        type: 'bar', // Gráfico de barras
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            datasets: [{
                label: 'Vendas (R$)',
                data: [1200, 1900, 3000, 2500, 3200, 2800],
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfico de Usuários
    var ctxUsuarios = document.getElementById('graficoUsuarios').getContext('2d');
    var graficoUsuarios = new Chart(ctxUsuarios, {
        type: 'doughnut', // Gráfico de pizza
        data: {
            labels: ['Ativos', 'Inativos'],
            datasets: [{
                data: [350, 150],
                backgroundColor: ['#28a745', '#dc3545']
            }]
        },
        options: {
            responsive: true
        }
    });
});

/*MODO CLARO E ESCURO*/

document.addEventListener("DOMContentLoaded", function() {
    const toggleButton = document.getElementById("toggleMode");
    const body = document.body;

    // Verifica se o usuário já escolheu um tema anteriormente
    if (localStorage.getItem("theme") === "dark") {
        body.classList.add("dark-mode");
        toggleButton.textContent = "☀️ Modo Claro";
    }

    // Alterna entre os modos
    toggleButton.addEventListener("click", function() {
        body.classList.toggle("dark-mode");

        // Salva a preferência do usuário
        if (body.classList.contains("dark-mode")) {
            localStorage.setItem("theme", "dark");
            toggleButton.textContent = "☀️ Modo Claro";
        } else {
            localStorage.setItem("theme", "light");
            toggleButton.textContent = "🌙 Modo Escuro";
        }
    });
});