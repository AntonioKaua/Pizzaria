<?php
include_once("conn.php");




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome']) && isset($_POST['senha'])) {
        $usuario = $_POST['nome'];
        $senha = $_POST['senha'];

        $query = "SELECT id, nome, senha FROM usuario WHERE nome = :nome LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nome', $usuario);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo "Senha do Banco de Dados: " . $result['senha'] . "<br>";
            echo "Senha Fornecida: " . $senha . "<br>";
            
            if (password_verify($senha, $result['senha'])) {
                $_SESSION['usuario'] = $result['nome'];
                $_SESSION['id_usuario'] = $result['id'];
                header("Location: http://localhost/pizzaJoao/index.php");
                exit();
            } else {
                $_SESSION["msg"] = "Senha incorreta";
                $_SESSION["status"] = "warning";
                header("Location: http://localhost/pizzaJoao/login.php");
                exit();
            }
        } else {
            $_SESSION["msg"] = "Usuário não encontrado";
            $_SESSION["status"] = "warning";
            header("Location: http://localhost/pizzaJoao/login.php");
            exit();
        }
    } else {
        $_SESSION["msg"] = "Preencha todos os campos";
        $_SESSION["status"] = "warning";
        header("Location: http://localhost/pizzaJoao/login.php");
        exit();
    }
} else {
    $_SESSION["msg"] = "Método de requisição inválido";
    $_SESSION["status"] = "warning";
    header("Location: http://localhost/pizzaJoao/login.php");
    exit();
}


?>
