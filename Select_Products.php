<?php
@session_start();
require_once "controller/Controller.php";

$resultado = $_SESSION['user'];
if ($resultado == null) {
    header("Location:index.php");
}

if(!empty($_POST['table'])){
    $invoice =  new Controller();
    $response= $invoice->Products(0);
    $response= $response->fetch_all();
    echo json_encode($response);
}
if(!empty($_POST['idProduct'])){
    $invoice =  new Controller();
    $response= $invoice->Products(0,$_POST['idProduct']);
    $response= $response->fetch_all();
    echo json_encode($response);
}

?>