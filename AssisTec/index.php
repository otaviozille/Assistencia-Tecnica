<!DOCTYPE html>
<html lang="br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AssisTec</title>
    <!--2-->
    <link rel="stylesheet" href="style.css">
    <!--3-->
    <link rel="shortcut icon" type="imge/x-icon" href="./img/icone.png">
</head>
<body>
    <!--1-->
    <!--Criar as divs de Login-->
    <div class= "Login">
        <div class="form">
            <!--3-->
            <img src="./img/login.png" class="imagem" >
            <!--4-->
            <form action="autenticar.php" method="post">
    <!--2-->
    <!--Criar os input de login-->
    <input type="email" name="usuario"  placeholder="Digite seu email" required>
    <input type="password" name="senha"  placeholder="Senha" required>
    <button>Login</button>

            </form>
        </div>
    </div>
</body>
</html>
