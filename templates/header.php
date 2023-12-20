<?php
  include("process/conn.php");
  $msg = "";
  
    if(isset($_SESSION['msg'])){
      $msg = $_SESSION['msg'];
      $status = $_SESSION['status'];
      //limpar a msg
      $_SESSION['msg'] = "";
      $_SESSION['status'] = "";
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Faça seu pedido!</title>
  <!-- BOOTSTRAP -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  
  <!-- FONT AWESOME -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <!-- App CSS -->
<link rel="stylesheet" href="css/style.css">
<link rel="shortcut icon" href="img/favicon.ico">

</head>
<body>
  <header>
  <nav class="navbar navbar-expand-lg">
    <a href="index.php" class="navbar-brand">
      <img src="img/pizza.svg" alt="Pizzaria do João" id="brand-logo" >
    </a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <!-- LISTA DE PRODUTOS -->
    
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Peça sua pizza</a>
        </li>
        <li>
          <a class="nav-link" href="dashboard.php">Dashboard cozinha</a>
        </li>
        <li>
          <a class="nav-link" href="dashboard2.php">Dashboard entrega</a>
        </li>
        <li>
          <a class="nav-link" href="saborescadastro.php">Cadastro de sabores</a>
        </li>
        <li>
          <a class="nav-link" href="relatorio.php">Relatórios</a>
        </li>

      </ul>
    </div>
  </nav>
  </header>
  <?php 
  if ($msg !=""):?>
    <div class="alert alert-<?=$status ?>"> 
      <p> <?= $msg ?></p>
    </div>
    <?php endif; ?>