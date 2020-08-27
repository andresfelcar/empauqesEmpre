<?php
@session_start();
$resultado = $_SESSION['user'];
if ($resultado == null) {
	header("Location:index.php");
}

?>
<!--validacion de inicio de sesion-->
<ul class="nav navbar-nav">
	<li class="dropdown">
		<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Menu de Usuario
			<span class="caret"></span></button>
		<ul class="dropdown-menu">
			<li><a href="View_Invoice.php">Lista de Facturas</a></li>
			<li><a href="Create_Invoice.php">Crear Factura</a></li>
			<li><a href="Clientes.php">Clientes</a></li>
			<?php 
			if($resultado[9]==1){
				echo '<li><a href="Empleados.php">Vendedores</a></li>';
				echo '<li><a href="View_Products.php">Productos</a></li>';
				echo '<li><a href="View_Ranking.php">Ventas</a></li>';
				echo '<li><a href="View_ProductsDay.php">Productos del día</a></li>';
				echo '<li><a href="View_Comision.php">Comisiones</a></li>';
			}
			?>
		</ul>
	</li>
	<li class="dropdown dr">
		<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Conectado: <?php echo $resultado[1]; ?>
			<span class="caret"></span></button>
		<ul class="dropdown-menu">
			<li><a href="Salir.php">Salir</a></li>
		</ul>
	</li>
</ul>
<br /><br /><br /><br />