<?php 
    session_start();
    $user = "root";
    $pass = "";
    $host = "localhost";
    $db = "pizzaria";
    $port = '3306'; // Porta do banco de dados
   
    try{

        $conn = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }catch(PDOException $e){
        print "Error: " . $e->getMessage()."<br>";
        die();
    }

?>