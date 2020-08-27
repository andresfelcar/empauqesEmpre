<?php
@session_start();
require_once "controller/Controller.php";
$resultado = $_SESSION['user'];
if ($resultado == null) {
    header("location:index.php");
}
if ($resultado[9] == 2) {
    header("location:View_Invoice.php");
}

if (!empty($_POST['nomb']) && !empty($_POST['apell'])) {
    $array = [];

    array_push($array, $_POST['nomb'], $_POST['apell'], $_POST['dni'], $_POST['cel'], $_POST['pass'], $_POST['email'],$_POST['tipousuario']);

    $empleados =  new Controller();

    $result = $empleados->Sellers(1, $array);
}

if (!empty($_POST['deletven'])) {
    $array = [];

    array_push($array, $_POST['deletven']);

    $empleados =  new Controller();

    $result = $empleados->Sellers(3, $array);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Productos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="resource/css/empleados.css">





    <title>Empleados</title>
</head>

<body>
  <div class="container-fluid fondo-amarillo">
   <div class="menu-usuario"><?php include('menu.php'); ?></div>
  </div>
       
      
    
    </div>
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-8">

            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th class="letra-blanca" scope="col">Codigo</th>
                        <th class="letra-blanca" scope="col">Nombre</th>
                        <th class="letra-blanca" scope="col">Apellido</th>
                        <th class="letra-blanca" scope="col">Documento</th>
                        <th class="letra-blanca" scope="col">Celular</th>
                        <th class="letra-blanca" scope="col">Correo</th>
                        <th class="letra-blanca" scope="col">Contraseña</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $emple = new Controller();
                        $vendedores = $emple->Sellers(0);
                        while ($mostrar = $vendedores->fetch_row()) {
                        ?>

                    <tr>

                        <td>
                            <p><?php echo $mostrar[0] ?></p>
                        </td>
                        <td>
                            <p><?php echo $mostrar[1] ?></p>
                        </td>
                        <td>
                            <p><?php echo $mostrar[2] ?></p>
                        </td>
                        <td>
                            <p><?php echo $mostrar[3] ?></p>
                        </td>
                        <td>
                            <p><?php echo $mostrar[4] ?></p>
                        </td>
                        <td>
                            <p class="overflow"><?php echo $mostrar[5] ?></p>
                        </td>
                        <td>
                            <p class="overflow"><?php echo $mostrar[6] ?></p>
                        </td>
                        <td><a href="Edit_Empleado.php?update_id=<?php echo $mostrar[0] ?>" title="Editar Factura">
                                <div class="btn fondo-amarillo"><span class="glyphicon glyphicon-edit"></span></div>
                            </a></td>

                    </tr>
                    <?php
                        }
                        ?>

                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <form class="form_reg" action="" method="POST">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nombre</label>
                    <input type="text" name="nomb" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="Ingrese el nombre">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Apellido</label>
                    <input type="text" name="apell" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="Ingresa el apellido">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Documento</label>
                    <input type="text" name="dni" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="Ingrese el documento">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Celular</label>
                    <input type="text" name="cel" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="Ingrese el celular">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Correo</label>
                    <input type="text" name="email" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="Ingrese el correo">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Contraseña</label>
                    <input type="password" name="pass" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="Ingrese la contraseña">
                </div>
                <div class="form-group">
                <select name="tipousuario" id="companyName" class="form-control" class="lista52">
                    <option value="1">Seleccione Administrador</option>
                    <option value="2">Seleccione Vendedor</option>

                </select>
                 </div>
        
        <div class="form-group text-center">
        <button type="submit" class="btn mt-4 fondo-amarillo">Registrar</button>
        </div>
        </form>
    </div>

    </div>
    </div>
    </div>
   

    </div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="resource/js/invoice.js"></script>
<script src="resource/js/input.js"></script>

</html>