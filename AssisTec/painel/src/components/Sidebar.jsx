import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import "./Sidebar.css";
import Logo from "../imgs/logo.png";
import { UilSignOutAlt, UilBars, UilTimes } from "@iconscout/react-unicons";
import { SidebarData } from "../Data/Data";
import { motion } from "framer-motion";

const Sidebar = ({ setIsAuthenticated }) => {
  const [selected, setSelected] = useState(0);
  const [expanded, setExpanded] = useState(true);
  const [showPopup, setShowPopup] = useState(false);
  const navigate = useNavigate();

  const handleReportClick = () => {
    setShowPopup(true);
  };

  const downloadReport = (type) => {
    window.open(`http://localhost/Assistencia-Tecnica/AssisTec/painel/pdf/pdf.php?tipo=${type}`, "_blank");
    setShowPopup(false);
  };

  const handleLogout = async () => {
    try {
      const response = await fetch("http://localhost/Assistencia-Tecnica/AssisTec/logout.php", {
        method: "GET",
        credentials: "include",
        headers: {
          "Accept": "application/json",
          "Content-Type": "application/json"
        }
      });

      if (!response.ok) {
        throw new Error(`Erro HTTP! Status: ${response.status}`);
      }

      const data = await response.json();
      if (data.logout) {
        setIsAuthenticated(false);
        setTimeout(() => {
          window.location.href = "http://localhost/Assistencia-Tecnica/AssisTec/index.php";
        }, 500);
      }
    } catch (error) {
      console.error("Erro ao fazer logout:", error);
    }
  };

  const sidebarVariants = {
    true: { left: "0" },
    false: { left: "-60%" }
  };

  return (
    <>
      <div className="bars" style={expanded ? { left: "60%" } : { left: "5%" }} onClick={() => setExpanded(!expanded)}>
        <UilBars />
      </div>
      <motion.div className="sidebar" variants={sidebarVariants} animate={window.innerWidth <= 768 ? `${expanded}` : ""}>
        <div className="logo">
          <img src={Logo} alt="logo" />
        </div>

        <div className="menu">
          {SidebarData.map((item, index) => (
            <div
              className={selected === index ? "menuItem active" : "menuItem"}
              key={index}
              onClick={() => {
                setSelected(index);
                if (item.heading === "Painel") navigate("/");
                if (item.heading === "Pedidos") navigate("/pedidos");
                if (item.heading === "Produtos") navigate("/produtos");
                if (item.heading === "Relatórios") handleReportClick();
              }}
            >
              <item.icon />
              <span>{item.heading}</span>
            </div>
          ))}
          <div className="menuItem logout" onClick={handleLogout} style={{ cursor: "pointer" }}>
            <UilSignOutAlt />
            <span>Logout</span>
          </div>
        </div>
      </motion.div>

      {showPopup && (
        <div className="popup-overlay" style={{
          position: "fixed", 
          top: 0, 
          left: 0, 
          width: "100%", 
          height: "100%", 
          backgroundColor: "rgba(0, 0, 0, 0.6)", 
          display: "flex", 
          justifyContent: "center", 
          alignItems: "center",
          zIndex: 1000
        }}>
          <div className="popup-content" style={{
            backgroundColor: "#f4f4f4", 
            padding: "30px", 
            borderRadius: "12px", 
            boxShadow: "0px 5px 15px rgba(0, 0, 0, 0.4)",
            textAlign: "center",
            maxWidth: "400px",
            width: "90%",
            position: "relative"
          }}>
            <UilTimes 
              onClick={() => setShowPopup(false)}
              style={{ position: "absolute", top: "10px", right: "15px", cursor: "pointer", fontSize: "24px", color: "#333" }}
            />
            <h2 style={{ marginBottom: "15px", color: "#333" }}>Baixar Relatório</h2>
            <p style={{ marginBottom: "20px", color: "#666" }}>Escolha o tipo de relatório para baixar:</p>
            <button onClick={() => downloadReport("produtos_vendas")} style={{ margin: "10px", padding: "12px 20px", borderRadius: "6px", backgroundColor: "#4CAF50", color: "white", border: "none", cursor: "pointer" }}>Produtos</button>
            <button onClick={() => downloadReport("pedidos")} style={{ margin: "10px", padding: "12px 20px", borderRadius: "6px", backgroundColor: "#2196F3", color: "white", border: "none", cursor: "pointer" }}>Pedidos</button>
            <button onClick={() => downloadReport("usuarios")} style={{ margin: "10px", padding: "12px 20px", borderRadius: "6px", backgroundColor: "#FF9800", color: "white", border: "none", cursor: "pointer" }}>Usuários</button>
            <button onClick={() => downloadReport("geral")} style={{ margin: "10px", padding: "12px 20px", borderRadius: "6px", backgroundColor: "#9C27B0", color: "white", border: "none", cursor: "pointer" }}>Relatório Geral</button>
          </div>
        </div>
      )}
    </>
  );
};

export default Sidebar;
