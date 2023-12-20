<?php 
include_once("conn.php");

$method = $_SERVER['REQUEST_METHOD'];

if($method === "GET"){
  $pedidosQuery = $conn->query("SELECT * FROM pedidos WHERE status_id  IN (2, 3);");

  $pedidos = $pedidosQuery->fetchAll();
  $pizzas = [];

  //Montar a pizza
  foreach($pedidos as $pedido){
    $pizza = [];

    //definir um array para pizza
    $pizza["id"] = $pedido["pizza_id"];

    //RESGATANDO A PIZZA
    $pizzaQuery = $conn->prepare("SELECT * FROM pizzas WHERE id = :pizza_id");
    $pizzaQuery->bindParam(":pizza_id", $pizza["id"]);
    $pizzaQuery->execute();

    //TRAZENDO AS BORDAS E MASSAS VIA PIZZA
    $pizzaData = $pizzaQuery->fetch(PDO::FETCH_ASSOC);
    
    //RESGATANDO A BORDA
    $bordaQuery = $conn->prepare("SELECT * FROM bordas WHERE id = :borda_id"); 
    $bordaQuery->bindParam(":borda_id", $pizzaData["borda_id"]);

    $bordaQuery->execute();

    $borda = $bordaQuery->fetch(PDO::FETCH_ASSOC);

    $pizza["borda"] = $borda["tipo"];

    //RESGATANDO MASSA
    $massaQuery = $conn->prepare("SELECT * FROM massas WHERE id = :massa_id"); 
    $massaQuery->bindParam(":massa_id", $pizzaData["massa_id"]);

    $massaQuery->execute();

    $massa = $massaQuery->fetch(PDO::FETCH_ASSOC);

    $pizza["massa"] = $massa["tipo"];

    $pizza["data_hora"] = $pedido["data_hora"];

    //RESGATANDO OS SABORES

    $saboresQuery = $conn->prepare("SELECT * FROM pizza_sabor WHERE pizza_id = :pizza_id"); 
    $saboresQuery->bindParam(":pizza_id", $pizza["id"]);

    $saboresQuery->execute();

    $sabores = $saboresQuery->fetchAll(PDO::FETCH_ASSOC);
    //resgatando os nomes dos sabores
    $saboresDaPizza = []; 
    $saborQuery = $conn->prepare("SELECT * FROM sabores WHERE id = :sabor_id");

    $saboresDaPizza = [];
    $saborQuery = $conn->prepare("SELECT * FROM sabores WHERE id = :sabor_id");


    foreach ($sabores as $sabor) {
        $saborQuery->bindParam(":sabor_id", $sabor["sabor_id"]);
        $saborQuery->execute();
        $saborPizza = $saborQuery->fetch(PDO::FETCH_ASSOC);
        array_push($saboresDaPizza,$saborPizza["nome"]);
     }

     $consultaPreco = $conn->prepare("SELECT ps.sabor_id, s.preco
     FROM pizza_sabor AS ps
     JOIN sabores AS s ON ps.sabor_id = s.id WHERE ps.pizza_id = :pizza_id");
     $consultaPreco->bindParam(":pizza_id", $pizza["id"]);
     $consultaPreco->execute();
     if ($consultaPreco) {
         $precosSabores = $consultaPreco->fetchAll(PDO::FETCH_ASSOC);
         $precoMedia = 0;
         foreach ($precosSabores as $precoSabor) {
             $precoMedia += $precoSabor["preco"];
         }
             $numSabores = count($precosSabores);
             if ($numSabores > 0) {
                 $precoMedia /= $numSabores;
             }
         $pizza["precoMedia"] = $precoMedia;
     } 

    $pizza["sabores"] = $saboresDaPizza;
    //add o status do pedido
    $pizza["status"] = $pedido["status_id"];
    //add o array de pizza no array PIZZAS
    array_push($pizzas,$pizza);
  }
  //echo "<pre>"; print_r($pizzas); echo "</pre>";
  //RESGATANDO O STATUS DA PIZZA
    $statusQuery = $conn->query("SELECT * FROM status WHERE id IN (2,3);");
    $status = $statusQuery->fetchAll();

}else if($method  === "POST"){
  $type = $_POST['type'];
  //deletar o pedido
  if($type === "delete"){
    $pizzaId = $_POST["id"];
    $deleteQuery = $conn->prepare("DELETE FROM pedidos WHERE pizza_id = :pizza_id;");
    $deleteQuery->bindParam(":pizza_id",$pizzaId, PDO::PARAM_INT);
    $deleteQuery->execute();
    $_SESSION["msg"] = "Pedido removido com sucesso!";
    $_SESSION["status"] = "danger";

   
  }else if($type === "update"){
    $pizzaId = $_POST["id"];
    $statusId = $_POST["status"];
    $updateQuery = $conn->prepare("UPDATE pedidos SET status_id = :status_id WHERE pizza_id = :pizza_id;");

    $updateQuery->bindParam(":status_id",$statusId, PDO::PARAM_INT);

    $updateQuery->bindParam(":pizza_id",$pizzaId, PDO::PARAM_INT);

      $updateQuery->execute();
      $_SESSION["msg"] = "Pedido ATUALIZADO com sucesso";
      $_SESSION["status"]= "primary";
    }
    header("Location:../dashboard2.php");

}

?>