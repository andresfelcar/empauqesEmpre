<?php
@session_start();
require_once "controller/Controller.php";

$resultado = $_SESSION['user'];
if ($resultado == null) {
    header("Location:index.php");
}

$invoice =  new Controller();

$array=[
    0=>$resultado[9],
    1=>$resultado[0],
    2=>$_POST['idInvoice']
];
$result = $invoice->Invoices(6, $array);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturacion</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link href="resource/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="naveg">
        <h2 id="hh">Facturas</h2>
    </div>
    <div class="container">
        <div class="marggin">
            <?php include('menu.php'); ?>
        </div>
        <table id="data-table" class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th width="7%">Fac. No.</th>
                    <th width="15%">Fecha Creación</th>
                    <th width="30%">Cliente</th>
                    <th width="15%">Factura Total</th>
                    <th width="3%"></th>
                    <th width="3%"></th>
                    <th width="3%"></th>
                </tr>
            </thead>
            <?php
            while ($resultado = $result->fetch_row()) : ?>
                <tr>
                    <td><?php echo $resultado[0] ?></td>
                    <td><?php echo $resultado[1] ?></td>
                    <td><?php echo $resultado[2] ?></td>
                    <td><?php echo $resultado[3] ?></td>
                    <td class="td"><a href="Print_Invoice.php?invoice_id=<?php echo $resultado[0] ?>" title="Imprimir Factura">
                            <div class="btn btn-primary"><span class="glyphicon glyphicon-print"></span></div>
                        </a></td>
                    <td class="td"><a href="Edit_Invoice.php?update_id=<?php echo $resultado[0] ?>" title="Editar Factura">
                            <div class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span></div>
                        </a></td>
                    <td class="td"><a href="#" id="<?php echo $resultado[0] ?>" class="deleteInvoice" title="Borrar Factura">
                            <div class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></div>
                        </a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="resource/js/invoice.js"></script>
</body>

</html>