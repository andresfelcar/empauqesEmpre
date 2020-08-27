<?php
@session_start();
require_once "controller/Controller.php";

$resultado = $_SESSION['user'];
if ($resultado == null) {
	header("Location:index.php");
}

$invoice = new Controller();

if (!empty($_GET['update_id'])) {
	$invoiceValues = $invoice->Sellers(0, $_GET['update_id']);
    $items = $invoiceValues->fetch_row();
    
}
if (!empty($_POST['nomb']) && !empty($_POST['idin'])) {
    $array = [];

    array_push($array, $_POST['idin'],$_POST['nomb'], $_POST['apell'], $_POST['dni'], $_POST['cel'], $_POST['pass'], $_POST['email']);

    $empleados =  new Controller();

    $result = $empleados->Sellers(2, $array);
    header("location:Empleados.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="resource/css/Edit_Empleados.css">
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="form">
            <form class="form_reg" action="" method="POST">
               <p>Codigo<input value="<?php echo $items[0]; ?>" name="idin" class="input" type="text"></p>
                <p>Nombre: <input value="<?php echo $items[1]; ?>" name="nomb" class="input" type="text" required autofocus></p>
                <p>Apellido: <input value="<?php echo $items[2]; ?>" name="apell" class="input" type="text" required autofocus></p>
                <p>Documento: <input value="<?php echo $items[3]; ?>" name="dni" class="input" type="text" required autofocus></p>
                <p>Celular: <input value="<?php echo $items[4]; ?>" name="cel" class="input" type="text" required autofocus></p>
                <p>Correo: <input value="<?php echo $items[6]; ?>" name="email" class="input" type="text" required autofocus></p>
                <p>Contraseña: <input value="" name="pass" class="input" type="password" required autofocus></p>
                <button class="submit" type="submit"> Actualizar </button>

            </form>
        </div>
</div>

    
</body>
</html>