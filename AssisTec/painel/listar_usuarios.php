<?php
$servername = "localhost";
$username = "root";  // Altere se necessário
$password = "";  // Altere se necessário
$dbname = "assistec";  // Nome do banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Buscar usuários
$sql = "SELECT idUsuario, nomeUsuario, emailUsuario, nivelUsuario, ativoUsuario, telefoneUsuario, 
               ruaUsuario, numeroUsuario, bairroUsuario, cidadeUsuario, estadoUsuario, cepUsuario, fotoUsuario 
        FROM usuarios ORDER BY idUsuario DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["idUsuario"] . "</td>";
        echo "<td>" . $row["nomeUsuario"] . "</td>";
        echo "<td>" . $row["emailUsuario"] . "</td>";
        echo "<td>" . $row["nivelUsuario"] . "</td>";
        echo "<td>" . $row["ativoUsuario"] . "</td>";
        echo "<td>" . $row["telefoneUsuario"] . "</td>";
        echo "<td>" . $row["ruaUsuario"] . ", " . $row["numeroUsuario"] . ", " . $row["bairroUsuario"] . 
             " - " . $row["cidadeUsuario"] . "/" . $row["estadoUsuario"] . " - CEP: " . $row["cepUsuario"] . "</td>";
        echo "<td><img src='/uploads/" . $row["fotoUsuario"] . "' width='50'></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>Nenhum usuário encontrado</td></tr>";
}

$conn->close();
?>

