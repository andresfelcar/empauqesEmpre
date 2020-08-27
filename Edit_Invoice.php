<?php
@session_start();
require_once "controller/Controller.php";

$resultado = $_SESSION['user'];
if ($resultado == null) {
	header("Location:index.php");
}
$invoice = new Controller();
if (!empty($_GET['update_id']) && $_GET['update_id']) {
	$invoiceValues = $invoice->Invoices(0, array(3,$_GET['update_id']));
	$itemsF_C = $invoiceValues[0]->fetch_row();
}
if (!empty($_POST['invoice_btn']) && $_POST['invoice_btn'] == "Guardar factura") {
	$invoice->Invoices(2, $_POST);
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
	<link href="resource/css/style.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body>
	<div class="naveg">
		<h2 id="hh">Bienvenido a la Imperial</h2>
	</div>
	<div class="container content-invoice">
		<div class="marggin">
			<?php include('menu.php'); ?>
		</div>
		<form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate>
			<div class="load-animate animated fadeInUp">

				<input id="currency" type="hidden" value="$">
				<div class="row">
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<h3 class="h3">Usuario:</h3>
						<?php echo $resultado[1]; ?><br class="parrafo">
						<?php echo $resultado[2]; ?><br class="parrafo">
						<?php echo $resultado[4]; ?><br class="parrafo">
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right">
						<br>
						<div class="form-group">
							<label for="inputState">Nombre del Cliente</label>
							<select name="companyName" id="companyName" placeholder="Nombre de Empresa" class="form-control">
								<option>Seleccione alguno</option>
								<?php

								$result = $invoice->Clients(0);
								while ($items = $result->fetch_row()) : ?>
									<option <?php if ($items[1] == $itemsF_C[3]) {
												echo "selected";
											} ?> value="<?php echo $items[0]; ?>"><?php echo $items[1]; ?></option>
								<?php endwhile; ?>
							</select>
						</div>
						<br>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<table class="table table-bordered table-hover" id="invoiceItem">
							<tr>
								<th width="2%"><input id="checkAll" class="formcontrol" type="checkbox"></th>

								<th width="38%">Nombre Producto</th>
								<th width="15%">Cantidad</th>
								<th width="15%">Precio</th>
								<th width="15%">Total</th>
							</tr>
							<?php
							$count = 0;
							while ($invoiceItem = $invoiceValues[1]->fetch_row()) :
								$count++;

							?>
								<tr>
									<td><input class="itemRow" id="contador" type="checkbox" value="<?php echo $invoiceItem[4]; ?>"></td>
									<td>
										<input type="text" style="display: none;" value="<?php echo $invoiceItem[4]; ?>" name="detFactura[]" id="detFactura_<?php echo $count; ?>" class="form-control" autocomplete="off" readonly="readonly">
										<select name="productCode[]" id="productCode_<?php echo $count; ?>" class="form-control" onchange="javascript:selectProducts(this.value,<?php echo $count; ?>)">
											<option selected>Seleccione alguno</option>
											<?php
											$result = $invoice->Products(0);
											while ($items = $result->fetch_row()) : ?>
												<option <?php if ($items[1] == $invoiceItem[1]) {
															echo "selected";
														} ?> value="<?php echo $items[0]; ?>"><?php echo $items[1]; ?></option>
											<?php endwhile; ?>
										</select>
									<td><input type="number" value="<?php echo $invoiceItem[2]; ?>" name="quantity[]" id="quantity_<?php echo $count; ?>" class="form-control quantity" autocomplete="off"></td>
									<td><input type="number" value="<?php echo $invoiceItem[3]; ?>" name="price[]" id="price_<?php echo $count; ?>" class="form-control price" autocomplete="off" readonly="readonly"></td>
									<td><input type="number" value="<?php echo $invoiceItem[2] * $invoiceItem[3]; ?>" name="total[]" id="total_<?php echo $count; ?>" class="form-control total" autocomplete="off" readonly="readonly"></td>
									<input type="hidden" value="<?php echo $_GET['update_id']; ?>" class="form-control" name="itemId[]">
								</tr>
							<?php endwhile; ?>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
						<button class="btn btn-danger delete" id="removeRows" type="button" onclick="">- Borrar</button>
							<a href="New_Product.php?idFactura=<?php echo $itemsF_C[0]; ?>"><button class="btn btn-success" id="" type="button">+ Agregar Más</button></a>
					</div>
				</div>
				<div class="row">
					<br>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<span class="form-inline">
							<div class="form-group">
								<label>Subtotal: &nbsp;</label>
								<div class="input-group">
									<div class="input-group-addon currency">$</div>
									<input value="<?php echo $itemsF_C[2]; ?>" type="number" class="form-control" name="subTotal" id="subTotal" placeholder="Subtotal">
								</div>
							</div>
						</span>
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<h3>Notes: </h3>
						<div class="form-group">
							<textarea class="form-control txt" rows="5" name="notes" id="notes" placeholder="Your Notes"></textarea>
						</div>
						<br>
						<div class="form-group">
							<input type="hidden" value="<?php echo $response[0]; ?>" class="form-control" name="userId">
							<input type="hidden" value="<?php echo $itemsF_C[0]; ?>" class="form-control" name="invoiceId" id="invoiceId">
							<input data-loading-text="Updating Invoice..." type="submit" name="invoice_btn" value="Guardar factura" class="btn btn-success submit_btn invoice-save-btm">
						</div>

					</div>
				</div>
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