import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import "./Sidebar.css";
import Logo from "../imgs/logo.png";
import { UilSignOutAlt, UilBars } from "@iconscout/react-unicons";
import { SidebarData } from "../Data/Data";
import { motion } from "framer-motion";

const Sidebar = ({ setIsAuthenticated }) => {
  const [selected, setSelected] = useState(0);
  const [expanded, setExpanded] = useState(true);
  const navigate = useNavigate();

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
    true: { left: '0' },
    false: { left: '-60%' }
  };

  return (
    <>
      <div className="bars" style={expanded ? { left: '60%' } : { left: '5%' }} onClick={() => setExpanded(!expanded)}>
        <UilBars />
      </div>
      <motion.div className='sidebar' variants={sidebarVariants} animate={window.innerWidth <= 768 ? `${expanded}` : ''}>
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
                if (item.heading === "Painel") navigate("/"); // Redireciona para o painel
                if (item.heading === "Pedidos") navigate("/pedidos");// Redireciona para pedidos
                if (item.heading === "Produtos") navigate("/produtos"); // Redireciona para produtos
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
    </>
  );
};

export default Sidebar;
