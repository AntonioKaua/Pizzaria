<?php
  include_once("templates/header_login.php");
  
?>
<head>
    <link rel="stylesheet" href="css/cadastro.css">
</head>



<div class="container">
    <form  class="form" action="process/cadastro_usuario.php" method="post">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome de usuário:</label>
            <input type="text" class="form-control" id="nome" aria-describedby="Nome" name="nome">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha do usuário:</label>
            <input type="password" class="form-control" id="senha" name="senha">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php
include_once("templates/footer.php");
?>


