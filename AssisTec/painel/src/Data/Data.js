// Sidebar imports
import {
  UilEstate,
  UilClipboardAlt,
  UilUsersAlt,
  UilPackage,
  UilChart,
  UilSignOutAlt,
} from "@iconscout/react-unicons";

// Analytics Cards imports
import { UilUsdSquare, UilMoneyWithdrawal } from "@iconscout/react-unicons";
import { useEffect, useState } from "react";
import axios from "axios"; // ✅ Importado corretamente

// Sidebar Data
export const SidebarData = [
  {
    icon: UilEstate,
    heading: "Painel",
  },
  {
    icon: UilClipboardAlt,
    heading: "Pedidos",
  },
  {
    icon: UilPackage,
    heading: "Produtos",
  },
  {
    icon: UilChart,
    heading: "Analytics",
  },
  
];

// Função para buscar os dados do dashboard
export const useDashboardData = () => {
  const [dashboardData, setDashboardData] = useState({
    total_vendas: 0,
    receita: 0,
    pedidos_pendentes: 0,
    produtos_vendidos: 0,
    historico_vendas: [],
    historico_receita: [], // ✅ Novo campo para histórico
  });

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get("http://localhost/Assistencia-Tecnica/AssisTec/api/get_dashboard_data.php");
        console.log("📊 Dados recebidos do backend:", response.data);
        setDashboardData(prevData => ({ ...prevData, ...response.data })); // ✅ Mantém os dados antigos para evitar re-render total
      } catch (error) {
        console.error("❌ Erro ao buscar os dados do dashboard:", error);
      }
    };
  
    fetchData();
    const interval = setInterval(fetchData, 5000);
  
    return () => clearInterval(interval);
  }, []);

  return dashboardData;
};

// Analytics Cards Data (agora dinâmico)
export const useCardsData = () => {
  const { total_vendas, receita, pedidos_pendentes, produtos_vendidos, historico_vendas, historico_receita } = useDashboardData();
  // Garantir que historico_vendas seja um array válido
  const vendasHistorico = Array.isArray(historico_vendas) ? historico_vendas : [];

  // Garante que produtos_vendidos é sempre um array válido
  const produtosVendasArray = Array.isArray(produtos_vendidos) ? produtos_vendidos : [];

  // Log para depuração
  console.log("📊 Produtos Vendidos do Backend:", produtosVendasArray);

   // ✅ SOMAR APENAS A RECEITA DOS DIAS QUE ESTÃO NO GRÁFICO:
   const receitaPeriodo = vendasHistorico.reduce((acc, venda) => acc + venda.total_vendas, 0);

    // Garante que historico_receita seja um array válido
  const receitaHistorico = Array.isArray(historico_receita) ? historico_receita : [];

  // Calcular a porcentagem de produtos vendidos em relação aos pendentes
  const totalProdutosVendidos = produtosVendasArray.reduce((acc, produto) => acc + (produto.total_vendido || 0), 0);
  const totalPedidos = totalProdutosVendidos + pedidos_pendentes;
  const porcentagemVendas = totalPedidos > 0 
  ? Math.round((totalProdutosVendidos / (totalProdutosVendidos + pedidos_pendentes)) * 100 * 100) / 100 
  : 0;

  return [
    {
      title: "Vendas",
      color: {
        backGround: "linear-gradient(180deg, #bb67ff 0%, #c484f3 100%)",
        boxShadow: "0px 10px 20px 0px #e0c6f5",
      },
      barValue: total_vendas * 10, // Continua usando total_vendas para o progresso no card
      value: `${total_vendas} `, // ✅ Agora mostra o número de vendas no card fechado
      png: UilUsdSquare,
      series: [
        {
          name: "Vendas por Dia",
          data: vendasHistorico.map((venda) => venda.total_vendas), // ✅ Agora exibe o número de vendas por dia no gráfico
        },
      ],
      categories: vendasHistorico.map((venda) => venda.data), // ✅ Exibe os dias corretamente no eixo X
    },
     {
      title: "Receita",
      color: {
        backGround: "linear-gradient(180deg, #FF919D 0%, #FC929D 100%)",
        boxShadow: "0px 10px 20px 0px #FDC0C7",
      },
      barValue: Math.round((receita / 500) * 100) / 100, // 🔧 Arredonda para no máximo 2 casas decimais
    
      value: `R$ ${receita.toLocaleString("pt-BR", { minimumFractionDigits: 2 })}`,
      png: UilMoneyWithdrawal,
      series: [
        {
          name: "Receita por Dia",
          data: receitaHistorico.length > 0 ? receitaHistorico.map((dia) => dia.receita_dia) : [0], // ✅ Corrigido para evitar erro
        },
      ],
      categories: receitaHistorico.length > 0 ? receitaHistorico.map((dia) => dia.data) : ["Sem dados"], // ✅ Corrigido para evitar erro
    },
    {
      title: "Pedidos Pendentes",
      color: {
        backGround: "linear-gradient(180deg, #FFC107 0%, #FFD700 100%)",
        boxShadow: "0px 10px 20px 0px #F9D59B",
      },
      barValue: pedidos_pendentes * 10, // Mostra o percentual de pedidos pendentes
      value: `${pedidos_pendentes} `, // ✅ Agora exibe apenas a quantidade de pedidos
      png: UilClipboardAlt,
      series: [
        {
          name: "Pendentes",
          data: historico_vendas.map((venda, index) => index % 2 === 0 ? pedidos_pendentes / 2 : pedidos_pendentes), 
        },
      ],
    },
    {
      title: "Produtos Vendidos",
      color: {
        backGround: "linear-gradient(180deg, #4CAF50 0%, #2E7D32 100%)",
        boxShadow: "0px 10px 20px 0px #A5D6A7",
      },
      barValue: produtosVendasArray.length > 0 ? produtosVendasArray.reduce((acc, produto) => acc + parseInt(produto.total_vendido, 10), 0) * 10 : 0,
      value: produtosVendasArray.length > 0 ? produtosVendasArray.reduce((acc, produto) => acc + parseInt(produto.total_vendido, 10), 0) : 0,
      png: UilClipboardAlt,
      series: [
        {
          name: "Produtos",
          data: produtosVendasArray.map((produto) => parseInt(produto.total_vendido, 10)), 
        },
      ],
      categories: produtosVendasArray.map((produto) => produto.nome_produto), // ✅ Garante que os nomes dos produtos sejam enviados
    },
  ];
};



