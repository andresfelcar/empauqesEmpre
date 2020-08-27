<?php
@session_start();
require_once "controller/Controller.php";
//validacion admin
$resultado = $_SESSION['user'];
if ($resultado == null) {
    header("location:index.php");
}
if ($resultado[9] == 2) {
    header("location:View_zonas.php");
}
$invoice = new Controller();

if (!empty($_GET['update_idd'])) {
	$invoiceValues = $invoice->Clients(4, $_GET['update_idd']);
   
    
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
          <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />


    
    <link href="resource/css/style.css" rel="stylesheet">
    <link href="resource/css/clientes2.css" rel="stylesheet">

</head>

<body>
<div class="naveg">
        <div class="heading">
            <h2 id="hh">Clientes</h2>
        </div>
    </div>
    <div class="tabla">
        <div class="inclu"><?php include('menu.php'); ?></div>
        <table id="table">
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Cliente</th>
                    <th>Telefono</th>
                    <th>Celular</th>
                    <th>Correo</th>
                    <th>Direccion</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($mostrar = $invoiceValues->fetch_row()) {
                ?>

                    <tr>

                        <td><?php echo $mostrar[0]; ?></td>
                        <td><?php echo $mostrar[1]; ?></td>
                        <td><?php echo $mostrar[2]; ?></td>
                        <td><?php echo $mostrar[3]; ?></td>
                        <td><?php echo $mostrar[4]; ?></td>
                        <td><?php echo $mostrar[5]; ?></td>
                        

                    </tr>
                    <?php
                }
                ?>

            </tbody>
            </table>
        </div>
    </div>
   
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="resource/js/invoice.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    
</body>

</html>
