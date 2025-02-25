import './App.css';
import { useState, useEffect } from 'react';
import MainDash from './components/MainDash/MainDash';
import RightSide from './components/RigtSide/RightSide';
import Sidebar from './components/Sidebar';

function App() {
  const [isAuthenticated, setIsAuthenticated] = useState(null);

  useEffect(() => {
    // Faz uma requisição para verificar a sessão do usuário
    const checkAuth = async () => {
      try {
        const response = await fetch("http://localhost/Assistencia-Tecnica/AssisTec/verificar_sessao.php", {
          method: "GET",
          credentials: "include",
        });

        const data = await response.json();
        if (data.authenticated) {
          setIsAuthenticated(true);
        } else {
          setIsAuthenticated(false);
        }
      } catch (error) {
        console.error("Erro ao verificar sessão:", error);
        setIsAuthenticated(false);
      }
    };

    checkAuth();
  }, []);

  // Se a autenticação ainda não foi verificada, exibe um loading
  if (isAuthenticated === null) {
    return <div>Carregando...</div>;
  }

  // Se não estiver autenticado, redireciona para o login
  if (!isAuthenticated) {
    window.location.href = "http://localhost/Assistencia-Tecnica/AssisTec/index.php";
    return null; // Evita renderizar a interface antes do redirecionamento
  }

  return (
    <div className="App">
      <div className="AppGlass">
        <Sidebar setIsAuthenticated={setIsAuthenticated} />
        <MainDash />
        <RightSide />
      </div>
    </div>
  );
}

export default App;
