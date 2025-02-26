import React, { useState } from "react";
import "./Sidebar.css";
import Logo from "../imgs/logo.png";
import { UilSignOutAlt } from "@iconscout/react-unicons";
import { SidebarData } from "../Data/Data";
import { UilBars } from "@iconscout/react-unicons";
import { motion } from "framer-motion";

const Sidebar = ({ setIsAuthenticated }) => {
  const [selected, setSelected] = useState(0);

  const [expanded, setExpaned] = useState(true)

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
        console.log("Resposta do servidor:", data);

        if (data.logout) {
            console.log("Logout realizado com sucesso!");
            setIsAuthenticated(false); // Remove autenticação no React
            
            // Aguarda um pequeno delay antes de redirecionar
            setTimeout(() => {
                window.location.href = "http://localhost/Assistencia-Tecnica/AssisTec/index.php";
            }, 500); // 500ms de delay para evitar problemas de atualização
        } else {
            console.error("Erro ao deslogar.");
        }
    } catch (error) {
        console.error("Erro ao fazer logout:", error);
    }
};


  const sidebarVariants = {
    true: {
      left : '0'
    },
    false:{
      left : '-60%'
    }
  }
  console.log(window.innerWidth)
  return (
    <>
      <div className="bars" style={expanded?{left: '60%'}:{left: '5%'}} onClick={()=>setExpaned(!expanded)}>
        <UilBars />
      </div>
    <motion.div className='sidebar'
    variants={sidebarVariants}
    animate={window.innerWidth<=768?`${expanded}`:''}
    >
      {/* logo */}
      <div className="logo">
        <img src={Logo} alt="logo" />
        
      </div>

      <div className="menu">
        {SidebarData.map((item, index) => {
          return (
            <div
              className={selected === index ? "menuItem active" : "menuItem"}
              key={index}
              onClick={() => setSelected(index)}
            >
              <item.icon />
              <span>{item.heading}</span>
            </div>
          );
        })}
         {/* Logout */}
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
