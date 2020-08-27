<?php
@session_start();
require_once "controller/Controller.php";

$resultado = $_SESSION['user'];
if ($resultado == null) {
    header("Location:index.php");
}


if(!empty($_POST['id'])){
    $invoice =  new Controller();
    $array = array(
        0=>$_POST['id']
    );
    $resultado = $invoice->Invoices(3,$array);
    echo $resultado[0];
}


if(!empty($_POST['idDFactura'])){
    $invoice =  new Controller();
    $resultado = $invoice->Invoices(4,$_POST['idDFactura']);
    return $resultado;
}
?>