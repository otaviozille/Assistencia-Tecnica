<?php
session_start();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bcryptjs/2.4.3/bcrypt.min.js"></script>

</head>
<body>
    <div class="container mt-5">
        <h2>Cadastro de Usuário</h2>
        <form id="cadastroForm">
            <div class="mb-3">
                <label for="nomeUsuario" class="form-label">Nome de Usuário</label>
                <input type="text" class="form-control" id="nomeUsuario" required>
            </div>
            <div class="mb-3">
                <label for="emailUsuario" class="form-label">Email</label>
                <input type="email" class="form-control" id="emailUsuario" required>
            </div>
            <div class="mb-3">
                <label for="telefoneUsuario" class="form-label">Telefone</label>
                <input type="tel" class="form-control" id="telefoneUsuario">
            </div>
            <div class="mb-3">
                <label for="ruaUsuario" class="form-label">Rua</label>
                <input type="text" class="form-control" id="ruaUsuario">
            </div>
            <div class="mb-3">
                <label for="numeroUsuario" class="form-label">Número</label>
                <input type="text" class="form-control" id="numeroUsuario">
            </div>
            <div class="mb-3">
                <label for="complementoUsuario" class="form-label">Complemento</label>
                <input type="text" class="form-control" id="complementoUsuario">
            </div>
            <div class="mb-3">
                <label for="bairroUsuario" class="form-label">Bairro</label>
                <input type="text" class="form-control" id="bairroUsuario">
            </div>
            <div class="mb-3">
                <label for="cidadeUsuario" class="form-label">Cidade</label>
                <input type="text" class="form-control" id="cidadeUsuario">
            </div>
            <div class="mb-3">
                <label for="estadoUsuario" class="form-label">Estado</label>
                <input type="text" class="form-control" id="estadoUsuario">
            </div>
            <div class="mb-3">
                <label for="cepUsuario" class="form-label">CEP</label>
                <input type="text" class="form-control" id="cepUsuario">
            </div>
            <div class="mb-3">
                <label for="nivelUsuario" class="form-label">Nível de Usuário</label>
                <select class="form-control" id="nivelUsuario" required>
                    <option value="">Selecione...</option>
                    <option value="Admin">Admin</option>
                    <option value="Usuário">Usuário</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="senhaUsuario" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senhaUsuario" required>
            </div>
            <div class="mb-3">
                <label for="confirmarSenha" class="form-label">Confirmar Senha</label>
                <input type="password" class="form-control" id="confirmarSenha" required>
                <div class="text-danger" id="erroSenha" style="display: none;">As senhas não coincidem!</div>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>

    <script>
        document.getElementById("cadastroForm").addEventListener("submit", async function(event) {
            event.preventDefault();
            
            let senha = document.getElementById("senhaUsuario").value;
            let confirmarSenha = document.getElementById("confirmarSenha").value;
            let erroSenha = document.getElementById("erroSenha");

            if (senha !== confirmarSenha) {
                erroSenha.style.display = "block";
                return;
            } else {
                erroSenha.style.display = "none";
            }

            // Criptografando a senha
            const salt = await bcrypt.genSalt(10);
            const senhaCriptografada = await bcrypt.hash(senha, salt);

            const usuario = {
                nomeUsuario: document.getElementById("nomeUsuario").value,
                emailUsuario: document.getElementById("emailUsuario").value,
                telefoneUsuario: document.getElementById("telefoneUsuario").value,
                ruaUsuario: document.getElementById("ruaUsuario").value,
                numeroUsuario: document.getElementById("numeroUsuario").value,
                complementoUsuario: document.getElementById("complementoUsuario").value,
                bairroUsuario: document.getElementById("bairroUsuario").value,
                cidadeUsuario: document.getElementById("cidadeUsuario").value,
                estadoUsuario: document.getElementById("estadoUsuario").value,
                cepUsuario: document.getElementById("cepUsuario").value,
                nivelUsuario: document.getElementById("nivelUsuario").value,
                senhaCripusuario: senhaCriptografada
            };
            
            console.log("Dados do Usuário:", usuario);
            alert("Cadastro realizado com sucesso!");
            
            // Aqui você pode enviar os dados para o backend
        });
    </script>
</body>
</html>




