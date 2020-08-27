<?php
@session_start();
require_once "controller/Controller.php";

$resultado = $_SESSION['user'];
if ($resultado == null) {
	header("Location:Login.php");
}
$invoice = new Controller();
if(!empty($_POST['productCode']) && !empty($_POST['quantity']) && !empty($_POST['total'])){
    $array=[];
    array_push($array,$_GET['idFactura'],$_POST['productCode'],$_POST['quantity'],$_POST['total']);
    $invoice->Invoices(5,$array);
    header('Location:Edit_Invoice.php?update_id='.$_GET['idFactura']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link href="resource/css/style.css" rel="stylesheet">
    <link href="resource/css/New_Product.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

</head>
<body>
<div class="container">
			<form class="formulario" method="POST" action="">
				<div class="inputs">
					<label>¿Desea agregar un nuevo producto?</label>
					<select name="productCode" id="productCode_n" class="form-control" onchange="javascript:selectProducts(this.value,'n');">
						<option selected>Seleccione alguno</option>
						<?php
						$result = $invoice->Products(0);
						while ($items = $result->fetch_row()) : ?>
							<option value="<?php echo $items[0]; ?>"><?php echo $items[1]; ?></option>
						<?php endwhile; ?>
					</select>
					<br>
					<label>Cantidad</label>
					<input type="number" name="quantity" id="quantity_n" class="form-control quantity" onchange="javascript:validateQuantity(this.value,'n');">
					<br>
					<label>Precio</label>
					<input type="number" style="display: none;" id="idProduct_n">
					<input type="number" name="price" id="price_n" class="form-control price" autocomplete="off" readonly="readonly">
					<br>
					<label>Total</label>
					<input type="number" name="total" id="total_n" class="form-control total" autocomplete="off" readonly="readonly">
                </div>
                <div class="botones">
                    <button type="submit" class="btn btn-success">Añadir</button>
                    <a href="Edit_Invoice.php?update_id=<?php echo $_GET['idFactura']; ?>"><button type="button" class="btn btn-danger">Cancelar</button>
                </div>
			</form>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="resource/js/ajax.js"></script>
	<script src="resource/js/invoice.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
</body>
</html>