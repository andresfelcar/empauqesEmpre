<?php
@session_start();
require_once "controller/Controller.php";

$resultado = $_SESSION['user'];
if ($resultado == null) {
    header("Location:index.php");
}
$invoice =  new Controller();
if (!empty($_POST['companyName'])) {
    $invoice->Invoices(1, $_POST);
    header("Location:View_Invoice.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturación</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link href="resource/css/empleados.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />



</head>

<body>
    <div class="container-fluid fondo-amarillo">
        <div class="menu-usuario"><?php include('menu.php'); ?></div>
    </div>
    <div class="container-fluid content-invoice">

        <form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate>
            <div class="load-animate animated fadeInUp">

                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <p>
                        <h3 class="h3">Usuario:</h3>
                        <?php echo $resultado[1]; ?><br class="parrafo">
                        <?php echo $resultado[2]; ?><br class="parrafo">
                        <?php echo $resultado[4]; ?><br class="parrafo">
                        </p>

                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right">

                        <div class="form-group">
                            <label for="inputState">Nombre del Cliente</label>
                            <select name="companyName" id="companyName" class="form-control mi-selector" required
                                autofocus>
                                <option>Seleccione alguno</option>
                                <?php
                                $result = $invoice->Clients(0);
                                while ($items = $result->fetch_row()) : ?>
                                <option value="<?php echo $items[0]; ?>"><?php echo $items[1]; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <table class="table table-bordered table-hover" id="invoiceItem">
                            <tr>
                                <th scope="col" class="letra-blanca" width="1%"><input id="checkAll" class="formcontrol"
                                        type="checkbox"></th>
                                <th scope="col" class="letra-blanca" width="30%">Nombre Producto</th>
                                <th scope="col" class="letra-blanca" width="5%">Cantidad</th>
                                <th scope="col" class="letra-blanca" width="10%">Precio</th>
                                <th scope="col" class="letra-blanca" width="5%">Descuento</th>
                                <th scope="col" class="letra-blanca" width="10%">Total</th>
                            </tr>
                            <tr>
                                <td><input class="itemRow" type="checkbox"></td>
                                <td>
                                    <select name="productCode[]" id="productCode_1" class="form-control"
                                        onchange="javascript:selectProducts(this.value,1);">
                                        <option selected>Seleccione alguno</option>
                                        <?php
                                        $result = $invoice->Products(0);
                                        
                                        while ($items = $result->fetch_row()) : ?>
                                        <option value="<?php echo $items[0]; ?>"><?php echo $items[1]; ?></option>
                                        <?php endwhile; ?>
                                        
                                    </select>
                                   
                                </td>

                                <td> <input type="number" style="display: none;" id="idProduct_1"><input type="number"
                                        name="quantity[]" id="quantity_1" class="form-control quantity"
                                        onchange="javascript:validateQuantity(this.value,1);"></td>
                                <td><input type="number" name="price[]" id="price_1" class="form-control price"
                                        autocomplete="off"></td>
                                <td><input type="number" name="descuento[]" id="descuento_1" class="form-control total"
                                        autocomplete="off"></td>
                                <td><input type="number" name="total[]" id="total_1" class="form-control total"
                                        autocomplete="off" readonly="readonly"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                        <button class="btn btn-danger delete" id="removeRows" type="button">- Borrar</button>
                        <button class="btn btn-success" id="addRows" type="button">+ Agregar Más</button>
                    </div>
                </div>



                <div class="row">
                    <br>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <span class="form-inline">
                            <div class="form-group">
                                <label>SubTotal: &nbsp;</label>
                                <div class="input-group">
                                    <div class="input-group-addon currency">$</div>
                                    <input value="" type="number" class="form-control" name="subTotal" id="subTotal"
                                        placeholder="Subtotal">
                                </div>
                            </div>
                        </span>
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <h3>Notas: </h3>
                        <div class="form-group">
                            <textarea class="form-control txt" rows="5" name="notes" id="notes"
                                placeholder="Notas"></textarea>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="hidden" value="<?php echo $resultado[0]; ?>" class="form-control" name="userId">
                            <input data-loading-text="Guardando factura..." type="submit" name="invoice_btn"
                                value="Guardar Factura" class="btn btn-success submit_btn invoice-save-btm">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <span class="form-inline">
                            <div class="form-group">

                                <div class="input-group">
                                    <input value="" type="hidden" class="form-control" name="" id="taxRate"
                                        placeholder="Tasa de Impuestos">

                                </div>
                            </div>
                            <div class="form-group">

                                <div class="input-group">

                                    <input value="" type="hidden" class="form-control" name="" id="taxAmount"
                                        placeholder="Monto de Impuesto">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Total: &nbsp;</label>
                                <div class="input-group">
                                    <div class="input-group-addon currency">$</div>
                                    <input value="" type="number" class="form-control" name="totalAftertax"
                                        id="totalAftertax" placeholder="Total">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Cantidad pagada: &nbsp;</label>
                                <div class="input-group">
                                    <div class="input-group-addon currency">$</div>
                                    <input value="" type="number" class="form-control" name="amountPaid" id="amountPaid"
                                        placeholder="Cantidad pagada">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Cantidad debida: &nbsp;</label>
                                <div class="input-group">
                                    <div class="input-group-addon currency">$</div>
                                    <input value="" type="number" class="form-control" name="amountDue" id="amountDue"
                                        placeholder="Cantidad debida">
                                </div>
                            </div>
                        </span>
                    </div>
                </div>
                <div class="clearfix">
                </div>
            </div>
        </form>
    </div>
    <script src="resource/js/miselector.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="resource/js/invoice.js"></script>
    <script src="resource/js/validacion.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
</body>

</html>