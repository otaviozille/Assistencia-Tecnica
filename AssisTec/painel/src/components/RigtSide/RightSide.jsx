import React, { useState, useEffect } from "react";
import axios from "axios";
import "./RightSide.css";
import defaultProfilePic from "../../imgs/default_perfil.png";
import { FaEye, FaEyeSlash } from "react-icons/fa";

const RightSide = () => {
  const [user, setUser] = useState({
    nomeUsuario: "",
    emailUsuario: "",
    telefoneUsuario: "",
    ruaUsuario: "",
    numeroUsuario: "",
    complementoUsuario: "",
    bairroUsuario: "",
    cidadeUsuario: "",
    estadoUsuario: "",
    cepUsuario: "",
    fotoUsuario: "",
    nivelUsuario: "",
  });

  const [editMode, setEditMode] = useState(false);
  const [selectedFile, setSelectedFile] = useState(null);
  const [showPassword, setShowPassword] = useState(false);

  useEffect(() => {
    axios.get("http://localhost/Assistencia-Tecnica/AssisTec/api/perfil.php", { withCredentials: true })
      .then(response => {
        if (response.data.error) {
          console.error("Erro ao buscar usuário:", response.data.error);
        } else {
          setUser(response.data);
        }
      })
      .catch(error => console.error("Erro ao buscar os dados do usuário", error));
  }, []);

  const handleChange = (e) => {
    setUser({ ...user, [e.target.name]: e.target.value });
  };

  const handleFileChange = (e) => {
    setSelectedFile(e.target.files[0]);
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
        const formData = new FormData();
        formData.append("nomeUsuario", user.nomeUsuario);
        formData.append("emailUsuario", user.emailUsuario);
        formData.append("telefoneUsuario", user.telefoneUsuario);
        formData.append("ruaUsuario", user.ruaUsuario);
        formData.append("numeroUsuario", user.numeroUsuario);
        formData.append("complementoUsuario", user.complementoUsuario);
        formData.append("bairroUsuario", user.bairroUsuario);
        formData.append("cidadeUsuario", user.cidadeUsuario);
        formData.append("estadoUsuario", user.estadoUsuario);
        formData.append("cepUsuario", user.cepUsuario);

        // 🔑 Só envia a senha se o usuário digitou algo
        if (user.senhaUsuario && user.senhaUsuario.trim() !== "") {
            formData.append("senhaUsuario", user.senhaUsuario);
        }

        if (selectedFile) {
            formData.append("fotoUsuario", selectedFile);
        }

        const response = await axios.post(
            "http://localhost/Assistencia-Tecnica/AssisTec/api/atualizar_perfil.php",
            formData,
            { withCredentials: true }
        );

        if (response.data.error) {
            alert("Erro ao atualizar perfil: " + response.data.error);
        } else {
            alert("Perfil atualizado com sucesso!");
            setEditMode(false);
            window.location.reload();
        }
    } catch (error) {
        console.error("Erro ao atualizar perfil:", error);
        alert("Erro ao atualizar perfil. Verifique o console.");
    }
};


  const handleUpload = (e) => {
    e.preventDefault();
    if (!selectedFile) return;
    
    const formData = new FormData();
    formData.append("fotoUsuario", selectedFile);
    
    axios.post("http://localhost/Assistencia-Tecnica/AssisTec/api/atualizar_foto.php", formData, {
      withCredentials: true,
      headers: { "Content-Type": "multipart/form-data" },
    })
    .then(() => {
      alert("Foto atualizada com sucesso!");
      setSelectedFile(null);
      window.location.reload();
    })
    .catch(error => console.error("Erro ao atualizar foto", error));
  };

  const handleRemovePhoto = async (e) => {
    e.preventDefault();

    try {
        const response = await axios.post(
            "http://localhost/Assistencia-Tecnica/AssisTec/api/remover_foto.php", // Caminho absoluto para evitar erro
            {},
            { withCredentials: true }
        );

        if (response.data.error) {
            alert("Erro ao remover foto: " + response.data.error);
            console.error("Erro ao remover foto:", response.data.error);
        } else {
            alert("Foto removida com sucesso!");

            // 🔄 Atualiza o estado do usuário para remover a foto imediatamente
            setUser(prevUser => ({ ...prevUser, fotoUsuario: "" }));

            // 🔄 Aguarde 500ms e recarregue os dados do usuário
            setTimeout(() => {
                window.location.reload();
            }, 500);
        }
    } catch (error) {
        console.error("Erro ao remover foto:", error);
        alert("Erro ao remover foto. Verifique o console.");
    }
};



  return (
    <div className="RightSide">
      <h3>Perfil do Usuário</h3>
      <div className="profile-container">
        <img 
          src={user.fotoUsuario ? `data:image/png;base64,${user.fotoUsuario}` : defaultProfilePic} 
          alt="Foto de Perfil" 
          className="profile-pic" 
        />
        <h4>{user.nomeUsuario || "Usuário Desconhecido"}</h4>
        <p className="user-level">{user.nivelUsuario || "Nível não definido"}</p>
        <button className="edit-button" onClick={() => setEditMode(true)}>Editar Perfil</button>
      </div>

      {editMode && (
        <div className="popup-overlay">
          <div className="popup">
            <h3>Editar Perfil</h3>
            <form onSubmit={handleSubmit} className="profile-form">
              <label>Foto do Perfil:</label>
              <input type="file" onChange={handleFileChange} accept="image/*" />
              <button className="upload-button" onClick={handleUpload}>Atualizar Foto</button>
              <button className="remove-button" type="button" onClick={handleRemovePhoto}>Remover Foto</button>
              <input type="text" name="nomeUsuario" value={user.nomeUsuario || ""} onChange={handleChange} placeholder="Nome" />
              <input type="email" name="emailUsuario" value={user.emailUsuario || ""} onChange={handleChange} placeholder="E-mail" />
              <div className="password-container">
                <input 
                  type={showPassword ? "text" : "password"} 
                  name="senhaUsuario" 
                  value={user.senhaUsuario || ""} 
                  onChange={handleChange} 
                  placeholder="Nova Senha" 
                />
                <button 
                  type="button" 
                  className="toggle-password" 
                  onClick={() => setShowPassword(!showPassword)}
                >
                  {showPassword ? <FaEyeSlash /> : <FaEye />}
                </button>
              </div>
              <input type="text" name="telefoneUsuario" value={user.telefoneUsuario || ""} onChange={handleChange} placeholder="Telefone" />
              <input type="text" name="ruaUsuario" value={user.ruaUsuario || ""} onChange={handleChange} placeholder="Rua" />
              <input type="text" name="numeroUsuario" value={user.numeroUsuario || ""} onChange={handleChange} placeholder="Número" />
              <input type="text" name="complementoUsuario" value={user.complementoUsuario || ""} onChange={handleChange} placeholder="Complemento" />
              <input type="text" name="bairroUsuario" value={user.bairroUsuario || ""} onChange={handleChange} placeholder="Bairro" />
              <input type="text" name="cidadeUsuario" value={user.cidadeUsuario || ""} onChange={handleChange} placeholder="Cidade" />
              <input type="text" name="estadoUsuario" value={user.estadoUsuario || ""} onChange={handleChange} placeholder="Estado" />
              <input type="text" name="cepUsuario" value={user.cepUsuario || ""} onChange={handleChange} placeholder="CEP" />
              <button className="save-button" type="submit">Salvar Alterações</button>
              <button className="close-button" type="button" onClick={() => setEditMode(false)}>Fechar</button>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};

export default RightSide;
