<?php 
include_once("conn.php");

$method =$_SERVER['REQUEST_METHOD'];



//Resgatando os dados, montagem do pedido
if($method === 'GET'){ //3 iguais
  $bordasQuery = $conn->query("SELECT * FROM bordas;");
  $bordas = $bordasQuery->fetchAll();

  $massasQuery = $conn->query("SELECT * FROM massas;");
  $massas = $massasQuery->fetchAll();

  $saboresQuery = $conn->query("SELECT * FROM sabores;");
  $sabores = $saboresQuery->fetchAll();



}else if($method === 'POST'){
  $data = $_POST;
  $borda = $data['borda'];
  $massa = $data['massa'];
  $sabores = $data['sabores'];
  
  //Validação qtd de sabores

  if(empty($sabores)){
    $_SESSION["msg"] = "Selecione no mínimo 1 sabor";
    $_SESSION["status"] = "warning";

  }else if(count($sabores) > 4){
    $_SESSION["msg"] = "Selecione no máximo 4 sabores";
    $_SESSION["status"] = "warning";
    
  }else{
    //SALVANDO AS BORDAS E MASSAS
    $stmt = $conn->prepare("INSERT INTO pizzas (borda_id, massa_id) VALUES(:borda, :massa)");
    // fILTRAR OS INPUTS
    $stmt->bindParam(":borda",$borda, PDO::PARAM_INT);
    $stmt->bindParam(":massa",$massa, PDO::PARAM_INT);
    $stmt->execute();

    //resgatar o último id da pizza
    $pizzaId = $conn->lastInsertId();

    $stmt = $conn->prepare("INSERT INTO pizza_sabor (pizza_id,sabor_id) VALUES (:pizza,:sabor)");

    //repete até salvar todos os sabores
    foreach($sabores as $sabor){
      $stmt->bindParam(":pizza",$pizzaId, PDO::PARAM_INT);
      $stmt->bindParam(":sabor",$sabor, PDO::PARAM_INT);
      $stmt->execute();
    }
    //criar pedido
    $stmt = $conn->prepare("INSERT INTO pedidos (pizza_id,status_id) VALUES (:pizza,:status)");
    $statusId = 1;
    $stmt->bindParam(":pizza",$pizzaId);
    $stmt->bindParam(":status",$statusId);
    $stmt->execute();
    //EXIBIR MSG DE SUCESSO
    $_SESSION["msg"] = "Pedido Realizado com sucesso!";
    $_SESSION["status"] = "success";

  }
  header("Location:..");

  

}
?>
