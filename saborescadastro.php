<?php
  include_once("templates/header.php");


  if (!isset($_SESSION['usuario'])) {
      $_SESSION["msg"] = "Acesso não autorizado. Faça login para continuar.";
      $_SESSION["status"] = "warning";
      header("Location: http://localhost/pizzaJoao/login.php");
      exit();
  }
?>
<head>
    <link rel="stylesheet" href="css/cadastro.css">
</head>



<div class="container">
<form  class="form" action="process/cadastro_sabor.php" method="post">
  <div class="mb-3">
    <label for="nome" class="form-label">Sabor:</label>
    <input type="text" class="form-control" id="nome" aria-describedby="Sabor" name="nome">
  </div>
  <div class="mb-3">
    <label for="preco" class="form-label">Preço:</label>
    <input type="number" class="form-control" id="preco" name="preco">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

<?php
include_once("templates/footer.php");
?>