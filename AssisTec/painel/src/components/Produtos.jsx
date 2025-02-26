import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";
import "./Produtos.css";

const Produtos = () => {
  const [produtos, setProdutos] = useState([]);
  const [search, setSearch] = useState("");
  const [marcaFiltro, setMarcaFiltro] = useState("");
  const [categoriaFiltro, setCategoriaFiltro] = useState("");
  const navigate = useNavigate();

  useEffect(() => {
    axios
      .get("http://localhost/Assistencia-Tecnica/AssisTec/api/get_produtos.php")
      .then((response) => {
        console.log("Resposta da API no React:", response.data);
        if (Array.isArray(response.data) && response.data.length > 0) {
          setProdutos(response.data);
        } else {
          console.error("Erro: API retornou um formato inválido!", response.data);
          setProdutos([]);
        }
      })
      .catch((error) => {
        console.error("Erro ao buscar produtos:", error);
        setProdutos([]);
      });
  }, []);

  // Verifica se os produtos possuem marca e categoria antes de criar os filtros
  const marcasDisponiveis = Array.from(new Set(produtos.map((p) => p.marca || "Desconhecido"))).filter(Boolean);
  const categoriasDisponiveis = Array.from(new Set(produtos.map((p) => p.categoria || "Sem categoria"))).filter(Boolean);

  // Filtragem dos produtos
  const produtosFiltrados = produtos.filter((produto) => {
    return (
      produto.nome_produto.toLowerCase().includes(search.toLowerCase()) &&
      (!marcaFiltro || produto.marca?.toLowerCase() === marcaFiltro.toLowerCase()) &&
      (!categoriaFiltro || produto.categoria?.toLowerCase() === categoriaFiltro.toLowerCase())
    );
  });

  return (
    <div className="produtos">
      <h2>Lista de Produtos</h2>

      {/* Barra de pesquisa e filtros */}
      <div className="filtros">
        <input
          type="text"
          placeholder="Pesquisar produto..."
          value={search}
          onChange={(e) => setSearch(e.target.value)}
        />

        <select value={marcaFiltro} onChange={(e) => setMarcaFiltro(e.target.value)}>
          <option value="">Filtrar por Marca</option>
          {marcasDisponiveis.map((marca, index) => (
            <option key={index} value={marca}>
              {marca}
            </option>
          ))}
        </select>

        <select value={categoriaFiltro} onChange={(e) => setCategoriaFiltro(e.target.value)}>
          <option value="">Filtrar por Categoria</option>
          {categoriasDisponiveis.map((categoria, index) => (
            <option key={index} value={categoria}>
              {categoria}
            </option>
          ))}
        </select>
      </div>

      {/* Container de produtos */}
      <div className="produtos-container">
        <div className="produtos-grid">
          {produtosFiltrados.length > 0 ? (
            produtosFiltrados.map((produto) => (
              <div
                key={produto.codigo_sku}
                className="produto-card"
                onClick={() => navigate(`/produto/${produto.codigo_sku}`)}
              >
                <h3>{produto.nome_produto}</h3>
              </div>
            ))
          ) : (
            <p>⚠ Nenhum produto encontrado.</p>
          )}
        </div>
      </div>
    </div>
  );
};

export default Produtos;
