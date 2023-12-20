<?php
  include_once("templates/header.php");
  include_once("process/orders.php");


  if (!isset($_SESSION['usuario'])) {
      $_SESSION["msg"] = "Acesso não autorizado. Faça login para continuar.";
      $_SESSION["status"] = "warning";
      header("Location: http://localhost/pizzaJoao/pizzaJoao/pizzaJoao/login.php");
      exit();
  }

  $query = "SELECT
      YEAR(pedidos.data_hora) AS ano,
      MONTH(pedidos.data_hora) AS mes,
      SUM(sabores.preco) AS valor_total_pizza
  FROM
      pedidos
  JOIN
      pizzas ON pedidos.pizza_id = pizzas.id
  JOIN
      pizza_sabor ON pizzas.id = pizza_sabor.pizza_id
  JOIN
      sabores ON pizza_sabor.sabor_id = sabores.id
  GROUP BY
      YEAR(pedidos.data_hora),
      MONTH(pedidos.data_hora)
  ORDER BY
      ano,
      mes;";

$stmt = $conn->prepare($query);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div id="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Relatório de Valor Total de Pizzas Vendidas por Mês</h2>
            </div>
            <div class="col-md-12 table-container">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Ano</th>
                            <th scope="col">Mês</th>
                            <th scope="col">Valor Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $row): ?>
                            <tr>
                                <td><?= $row["ano"] ?></td>
                                <td><?= $row["mes"] ?></td>
                                <td>R$ <?= number_format($row["valor_total_pizza"], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php

    $query = "SELECT
            sabores.*,
            COUNT(pizza_sabor.sabor_id) AS num_aparicoes
        FROM
            sabores
        INNER JOIN
            pizza_sabor ON sabores.id = pizza_sabor.sabor_id
        GROUP BY
            sabores.id
        ORDER BY
            num_aparicoes DESC;";

    $stmt = $conn->prepare($query);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div id="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Relatório de Sabores Mais Vendidos</h2>
            </div>
            <div class="col-md-12 table-container">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Preço</th>
                            <th scope="col">Aparições</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $row): ?>
                            <tr>
                                <td><?= $row["id"] ?></td>
                                <td><?= $row["nome"] ?></td>
                                <td>R$ <?= number_format($row["preco"], 2) ?></td>
                                <td><?= $row["num_aparicoes"] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
    $query = "SELECT
    num_sabores,
    COUNT(*) AS num_pizzas
FROM (
    SELECT
        pizza_id,
        COUNT(*) AS num_sabores
    FROM
        pizza_sabor
    GROUP BY
        pizza_id
) AS pizzas_sabores
GROUP BY
    num_sabores
ORDER BY
    num_pizzas DESC;";

$stmt = $conn->prepare($query);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div id="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Relatório de Tipo de Pizza Mais Popular</h2>
            </div>
            <div class="col-md-12 table-container">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Número de Sabores</th>
                            <th scope="col">Número de Pizzas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $row): ?>
                            <tr>
                                <td><?= $row["num_sabores"] ?></td>
                                <td><?= $row["num_pizzas"] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once("templates/footer.php");
?>