<?php
include_once("conn.php");

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

// Prepara a instrução SQL usando prepared statements
$senha_hashed = password_hash($senha, PASSWORD_DEFAULT);
$sql = $conn->prepare("INSERT INTO usuario (nome, email, senha) VALUES (:nome, :email, :senha)");
$sql->bindParam(':nome', $nome, PDO::PARAM_STR);
$sql->bindParam(':email', $email, PDO::PARAM_STR);
$sql->bindParam(':senha', $senha_hashed, PDO::PARAM_STR);

// Executa a instrução SQL
if ($sql->execute()) {
    $_SESSION["msg"] = "Cadastro feito com sucesso";
    $_SESSION["status"] = "success";
    header("Location: http://localhost/pizzaJoao/login.php");
    exit();
} else {
    echo "Erro ao inserir dados: " . $sql->$error;
}
