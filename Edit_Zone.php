<?php
@session_start();
require_once "controller/Controller.php";

$resultado = $_SESSION['user'];
if ($resultado == null) {
	header("Location:Login.php");
}

$zone = new Controller();

if (!empty($_GET['update_id'])) {

	$invoiceValues = $zone->Zone(0, $_GET['update_id']);
    $items = $invoiceValues->fetch_row();
    
}
if (!empty($_POST['nombreZona'])) {
    $array = [];
    array_push($array, $_POST['codigo'],$_POST['nombreZona']);
    $result = $zone->Zone(2, $array);
    header("location:Zonas.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="resource/css/Edit_Producto.css">
    <title>Editar Zona</title>
</head>
<body>
<div class="container">
    <div class="form">
            <form class="form_reg" action="" method="POST">
               <p>Codigo<input value="<?php echo $items[0]; ?>" name="codigo" class="input" type="text"></p>
                <p>Nombre: <input value="<?php echo $items[1]; ?>" name="nombreZona" class="input" type="text" required autofocus></p>
                <button class="submit" type="submit"> Actualizar </button>

            </form>
        </div>
</div>

    
</body>
</html>