<?php
  include_once("templates/header_login.php");
  
?>
<head>
    <link rel="stylesheet" href="css/cadastro.css">
</head>



<div class="container">
    <form  class="form" action="process/loginProcess.php" method="post">
            <div class="mb-3">
            <label for="nome" class="form-label">Usuário:</label>
            <input type="text" class="form-control" id="nome" aria-describedby="Nome" name="nome">
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha:</label>
            <input type="password" class="form-control" id="senha" name="senha">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php
include_once("templates/footer.php");
?>




 