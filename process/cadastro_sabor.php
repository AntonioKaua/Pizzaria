<?php
include_once("conn.php");

$sabor = $_POST['nome'];
$preco = $_POST['preco'];

// Prepara a instrução SQL usando prepared statements
$sql = $conn->prepare("INSERT INTO sabores (nome, preco) VALUES (:nome, :preco)");
$sql->bindParam(':nome', $sabor, PDO::PARAM_STR);
$sql->bindParam(':preco', $preco, PDO::PARAM_STR);

// Executa a instrução SQL
if ($sql->execute()) {
    $_SESSION["msg"] = "Dados inseridos com sucesso";
    $_SESSION["status"] = "success";
    header("Location: http://localhost/pizzaJoao/saborescadastro.php");
    exit();
} else {
    echo "Erro ao inserir dados: " . $sql->$error;
}