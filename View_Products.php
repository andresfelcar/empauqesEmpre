<?php
@session_start();
require_once "controller/Controller.php";
//validacion admin
$resultado = $_SESSION['user'];
if ($resultado == null) {
    header("location:index.php");
}
if ($resultado[9] == 2) {
    header("location:View_Invoice.php");
}

//validacion de el post definido
if (!empty($_POST['nombrePro']) && !empty($_POST['precio'])) {

    //creamos array
    $array = [];
    //agregamos datos al array  array_push(nombre_del_array,Variable1,varable2,variables...);
    array_push($array, $_POST['nombrePro'], $_POST['precio'], $_POST['cantidad']);
//objeto para acceder al sellers
$productos =  new Controller();

$result = $productos->Products(1, $array);
}
//validacion segundo form
if(!empty($_POST['codigor'])) {

    //creamos array
    $array = [];
    //agregamos datos al array  array_push(nombre_del_array,Variable1,varable2,variables...);
    array_push($array, $_POST['codigor']);
//objeto para acceder al sellers
$product =  new Controller();

$result = $product->Products(3,$array);
}

?>


<!DOCTYPE html>
<html>

<head>
    <title>Productos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="resource/css/empleados.css">
</head>

<body>


<div class="container-fluid fondo-amarillo">
   <div class="menu-usuario"><?php include('menu.php'); ?></div>
  </div>
       
      
    
    </div>
    <div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-8">

            <table class="table">
                <thead class="thead-dark ">
                    <tr>
                        <th class="letra-blanca" scope="col">Codigo</th>
                        <th class="letra-blanca" scope="col">Nombre</th>
                        <th class="letra-blanca" scope="col">Precio</th>
                        <th class="letra-blanca" scope="col">Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $emple = new Controller();
                        $vendedores = $emple->Products(0);
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
                    <label for="exampleInputEmail1">Nombre Producto</label>
                    <input type="text" name="nombrePro" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="Ingrese el nombre">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Precio</label>
                    <input type="text" name="precio" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="Ingresa el precio">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Cantidad</label>
                    <input type="text" name="cantidad" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="Ingrese la cantidad">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Comicion</label>
                    <input type="text" name="comicion" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="Ingrese la comicion ej: 0.06">
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
    <script src="resource/js/produ.js"></script>
</html>
