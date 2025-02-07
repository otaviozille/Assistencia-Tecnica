<?php 
//6
// Validar usuário e senha para efertuar login no sistema

// Conectar ao banco de dados
require_once("conexao.php")

// Criar variáveis locais para receber o que foi
// Digitado nos INPUT´s: usuári e senha no index.php
$usuario = $_POST ['usuario'];
$senha = $_POST ['senha'];

// Criar a query de consulta ao banco  de dados para 
// verificar se o usuario esta cadastrado e se a senha está correta
$query = $pdo->query("SELECT * from usuarios where
emailUsuario = '$usuario' and senhaUsuario = '$senha' ");

// Criar uma variável para armazenar o resultado da query
$result=$query->fetchAll(PDO::FETCH_ASSOC);

//Teste:
// Verificar o result para ver se está correto
$linha = @count($result);
// echo $linha

//Verificar se tem autentificação
if($linha > 0){
   $_SESSION [$nome] = $result[0]['nomeUsuario'];
   $_SESSION [$id]= $result[0]['idUsuario'];
   $_SESSION [$nivel] = $result[0]['nivelUsuario'];

   // Direcionar para a Tela de sistema: ./painel/ibdex.php
   echo '<script>window.locatin= "painel"</script>';

}

else{
    echo '<script>window.alert("Usuario e/ou Senha Incorretos")</script>';
    echo '<script>window.locatin= "index.php"</script>';
}













?>