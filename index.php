<?php
@session_start();
require_once "controller/Controller.php";


$loginError = "";
if (!empty($_POST['email']) && !empty($_POST['password'])) {

	$login = new Controller();

	$array = [];
	
	array_push($array, $_POST['email'], $_POST['password']);

	$_SESSION['user'] = $login->Login(0,$array);

	$resultado = $_SESSION['user'];
	
	if ($resultado != null) {
		header("Location:View_Invoice.php");
	} else {
		$_SESSION['user']=null;
		$loginError = "Usuario o contraseña incorrectos";
	}
} else {
	$loginError = "Ingrese los datos";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Iniciar Sesión</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<link href="resource/css/style.css" rel="stylesheet">
	<link href="resource/css/iniciar_sesion.css" rel="stylesheet">
</head>

<body>
	<div class="naveg">
		<div class="heading">
			<h2 id="hh">Bienvenido a la Imperial</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6">
			<div class="login-form">
				<form action="" method="post">
					<h2 class="text-center">Iniciar Sesión</h2>
					<div class="form-group">
						<?php if ($loginError) { ?>
							<div class="alert alert-warning"><?php echo $loginError; ?></div>
						<?php } ?>
					</div>
					<div class="form-group">
						<input name="email" id="email" type="email" class="form-control" placeholder="Correo" autofocus required>
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password" placeholder="Contraseña" required>
					</div>
					<div class="form-group">
						<button type="submit" name="login" class="btn btn-primary" style="width: 100%;"> Acceder </button>
					</div>
					<div class="clearfix">
						<label class="pull-left checkbox-inline"><input type="checkbox"> Recordarme</label>
					</div>
				</form>
			</div>
		</div>
	</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="resource/js/invoice.js"></script>
</body>

</html>