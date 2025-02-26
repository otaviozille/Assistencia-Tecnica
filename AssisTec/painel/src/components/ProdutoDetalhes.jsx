import React, { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import axios from "axios";
import "./ProdutoDetalhes.css";

const ProdutoDetalhes = () => {
  const { id } = useParams();
  const navigate = useNavigate();
  const [produto, setProduto] = useState(null);

  useEffect(() => {
    axios
      .get(`http://localhost/Assistencia-Tecnica/AssisTec/api/get_produto.php?id=${id}`)
      .then((response) => {
        console.log("Detalhes do Produto:", response.data);
        setProduto(response.data);
      })
      .catch((error) => {
        console.error("Erro ao buscar detalhes do produto:", error);
      });
  }, [id]);

  if (!produto) return <p>Carregando...</p>;

  return (
    <div className="produto-detalhes">
      <h2>{produto.nome_produto}</h2>
      <p><strong>ID:</strong> {produto.codigo_sku}</p>
      <p><strong>Categoria:</strong> {produto.categoria}</p>
      <p><strong>Marca:</strong> {produto.marca}</p>
      <p><strong>Preço:</strong> R$ {parseFloat(produto.preco).toFixed(2)}</p>
      <p><strong>Vendas:</strong> {produto.vendas}</p>
      <p><strong>Estoque:</strong> {produto.quantidade_estoque} unidades</p>
      <p><strong>Data de Adição:</strong> {produto.data_adicao}</p>
      <p><strong>Descrição:</strong> {produto.descricao}</p>
      <button className="voltar" onClick={() => navigate("/produtos")}>
        Voltar para Produtos
      </button>
    </div>
  );
};

export default ProdutoDetalhes;
