<?php

    //criar sessão de conxeão
@session_start();

    // conectar banco de dados
 require_once("conexao.php");

    //criação variaveis locais

 $usuario = $_POST['email'];
 $senha = $_POST['senha'];

    //criação da query
 $query = $pdo->query("SELECT * FROM usuarios where emailUsuario = '$usuario' and senhaUsuario = '$senha'");

    //criação variavel que irá receber o resultado da query
$result = $query->fetchAll(PDO::FETCH_ASSOC);
    //verificação se o resultado da query é maior que 0
$linha = @count($result);    
    //verificar se houve autenticação
if($linha > 0)
{

    $nome = $result[0]['nomeUsuario'];
    $id = $result[0]['idUsuario'];
    $nivel = $result[0]['nivelUsuario'];
    
    echo "<script>window.location.href = 'painel/index.php'</script>";

}
else
{

    echo "<script>window.alert('Usuário ou senha incorretos!')</script>";
    echo "<script>window.location.href = 'index.php'</script>";
    
}

?>