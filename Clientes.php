<?php
@session_start();
require_once "controller/Controller.php";

$resultado = $_SESSION['user'];
if ($resultado == null) {
    header("Location:index.php");
}
//validacion de el post definido
if (!empty($_POST['nomcli']) && !empty($_POST['direc'])) {

    //creamos array
    $array = [];
    //agregamos datos al array  array_push(nombre_del_array,Variable1,varable2,variables...);
    array_push($array, $_POST['nomcli'], $_POST['tel'], $_POST['cel'], $_POST['direc']);
    //objeto para acceder al sellers
    $clientes =  new Controller();

    $result = $clientes->Clients(1, $array);
}

$zonas =  new Controller();
if (!empty($_POST['code'])) {

    //creamos array
    $array = [];
    //agregamos datos al array  array_push(nombre_del_array,Variable1,varable2,variables...);
    array_push($array, $_POST['code']);
    //objeto para acceder al sellers
    $deletecli =  new Controller();

    $result = $deletecli->Clients(3, $array);
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



    <link href="resource/css/empleados.css" rel="stylesheet">


</head>

<body>
    <div class="container-fluid fondo-amarillo">
        <div class="menu-usuario"><?php include('menu.php'); ?></div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">

                <table id="table" class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="letra-blanca" width="10%"> Codigo</th>
                            <th scope="col" class="letra-blanca" width="25%"> Cliente</th>
                            <th scope="col" class="letra-blanca" width="20%"> CC</th>
                            <th scope="col" class="letra-blanca" width="20%"> Celular</th>
                            <th scope="col" class="letra-blanca" width="25%"> Direccion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    $emple = new Controller();
                    $vendedores = $emple->Clients(0);
                    while ($mostrar = $vendedores->fetch_row()) {
                ?>

                        <tr>

                            <td><?php echo $mostrar[0] ?></td>
                            <td><?php echo $mostrar[1] ?></td>
                            <td><?php echo $mostrar[2] ?></td>
                            <td><?php echo $mostrar[3] ?></td>
                            
                            <td><?php echo $mostrar[5] ?></td>
                            <td><a href="Edit_Clientes.php?update_id=<?php echo $mostrar[0] ?>" title="Editar Factura">
                                    <div class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span>
                                    </div>
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
                        <label for="exampleInputEmail1">Nombre Cliente</label>
                        <input type="text" name="nomcli" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="Ingrese el nombre del cliente">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">CC</label>
                        <input type="text" name="tel" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="Ingresa el documento">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Celular</label>
                        <input type="text" name="cel" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="Ingrese el celular">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Direccion</label>
                        <input type="text" name="direc" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="Ingrese la direccion">
                    </div>


                    <div class="form-group text-center">
                        <button type="submit" class="btn mt-4 fondo-amarillo">Registrar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="resource/js/invoice.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

</body>

</html>