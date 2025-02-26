import React, { useEffect, useState } from "react";
import axios from "axios";
import "./Orders.css"; 

const Orders = () => {
  const [orders, setOrders] = useState([]);

  useEffect(() => {
    const fetchOrders = async () => {
      try {
        const response = await axios.get("http://localhost/Assistencia-Tecnica/AssisTec/api/get_orders.php");

        if (Array.isArray(response.data)) {
          setOrders(response.data);
        } else {
          console.error("Resposta da API não é um array:", response.data);
          setOrders([]);
        }
      } catch (error) {
        console.error("Erro ao buscar pedidos:", error);
        setOrders([]);
      }
    };

    fetchOrders();
  }, []);

  return (
    <div className="orders">
      <h2>Pedidos</h2>

      {orders.length === 0 ? (
        <p>Nenhum pedido encontrado.</p>
      ) : (
        <div className="orders-table-container">
          <table>
            <thead>
              <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Valor</th>
                <th>Data</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              {orders.map((order, index) => (
                <tr key={index}>
                  <td>{order.nome_produto}</td>
                  <td>{order.quantidade}</td>
                  <td>
                    R$ {order.valor_pedido ? parseFloat(order.valor_pedido.trim()).toFixed(2) : "0.00"}
                  </td>
                  <td>{new Date(order.data_pedido).toLocaleDateString("pt-BR")}</td>
                  <td>{order.status}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}
    </div>
  );
};

export default Orders;
