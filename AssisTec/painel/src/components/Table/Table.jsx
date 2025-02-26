import React, { useEffect, useState } from "react";
import Table from "@mui/material/Table";
import TableBody from "@mui/material/TableBody";
import TableCell from "@mui/material/TableCell";
import TableContainer from "@mui/material/TableContainer";
import TableHead from "@mui/material/TableHead";
import TableRow from "@mui/material/TableRow";
import Paper from "@mui/material/Paper";
import axios from "axios";
import "./Table.css";

const makeStyle = (status) => {
  if (status === "Concluído") {
    return { background: "rgb(145 254 159 / 47%)", color: "green" };
  } else if (status === "Pendente") {
    return { background: "#ffadad8f", color: "red" };
  } else {
    return { background: "#59bfff", color: "white" };
  }
};

export default function BasicTable() {
  const [rows, setRows] = useState([]);

  useEffect(() => {
    axios.get("http://localhost/Assistencia-Tecnica/AssisTec/api/get_pedidos.php")
      .then((response) => {
        setRows(response.data);
      })
      .catch((error) => {
        console.error("Erro ao buscar pedidos:", error);
      });
  }, []);

  return (
    <div className="Table">
      <h3>Pedidos Recentes</h3>
      <TableContainer
      component={Paper}
      className="TableContainer"
      style={{ boxShadow: "0px 13px 20px 0px #80808029" }}
      >

        <Table sx={{ minWidth: 650 }} aria-label="simple table">
          <TableHead>
            <TableRow>
              <TableCell>Produto</TableCell>
              <TableCell align="left">Quantidade</TableCell>
              <TableCell align="left">Data</TableCell>
              <TableCell align="left">Status</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {rows.length > 0 ? (
              rows.map((row, index) => (
                <TableRow key={index}>
                  <TableCell>{row.nome_produto}</TableCell>
                  <TableCell align="left">{row.quantidade}</TableCell>
                  <TableCell align="left">
                    {new Date(row.data_pedido).toLocaleDateString("pt-BR")}
                  </TableCell>
                  <TableCell align="left">
                    <span className="status" style={makeStyle(row.status)}>
                      {row.status}
                    </span>
                  </TableCell>
                </TableRow>
              ))
            ) : (
              <TableRow>
                <TableCell colSpan={4} align="center">
                  Nenhum pedido encontrado.
                </TableCell>
              </TableRow>
            )}
          </TableBody>
        </Table>
      </TableContainer>
    </div>
  );
}
