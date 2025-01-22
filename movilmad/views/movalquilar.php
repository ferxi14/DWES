<?php
session_start();
if (!isset($_SESSION['usuario'])) {
	header("Location: movlogin.php");
	exit();
}

require_once '../db/movconfig.php';

$user = $_SESSION['usuario'];
try {
    $conn = conexionDB();

    $vehiculosDisponibles = [];
    $sql = "SELECT matricula, marca, modelo FROM rvehiculos WHERE disponible = 'S'";
    $stmt = $conn->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $vehiculosDisponibles[] = $row;
    }

    if (!isset($_SESSION['cesta'])) {
        $_SESSION['cesta'] = [];
    }

    if (isset($_POST['agregar'])) {
        if (count($_SESSION['cesta']) < 3) {
            $vehiculoSeleccionado = $_POST['vehiculos'];
            $_SESSION['cesta'][] = $vehiculoSeleccionado;
        } else {
            echo "No puedes agregar más de 3 vehículos.";
        }
    }

    if (isset($_POST['vaciar'])) {
        $_SESSION['cesta'] = [];
    }

} catch (PDOException $e) {
    die("ERROR: No se pudo conectar a la base de datos. " . $e->getMessage());
}
?>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Bienvenido a MovilMAD</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
</head>

<body>
	<h1>Servicio de ALQUILER DE E-CARS</h1>

	<div class="container ">
		<!--Aplicacion-->
		<div class="card border-success mb-3" style="max-width: 30rem;">
			<div class="card-header">Menú Usuario - ALQUILAR VEHÍCULOS</div>
			<div class="card-body">


				<!-- INICIO DEL FORMULARIO -->
				<form action="" method="post">

					<B>Bienvenido/a:</B> <?php echo $user['email']; ?><BR><BR>
					<B>Identificador Cliente:</B><?php echo $user['idcliente']; ?> <BR><BR>

					<B>Vehiculos disponibles en este momento:</B> <?php echo date('Y-m-d H:i:s'); ?> <BR><BR>

					<B>Matricula/Marca/Modelo: </B><select name="vehiculos" class="form-control">
						<?php foreach ($vehiculosDisponibles as $vehiculo): ?>
							<option value="<?php echo $vehiculo['matricula']; ?>">
								<?php echo $vehiculo['matricula'] . '/' . $vehiculo['marca'] . '/' . $vehiculo['modelo']; ?>
							</option>
						<?php endforeach; ?>
					</select>


					<BR> <BR><BR><BR><BR><BR>
					<div>
						<input type="submit" value="Agregar a Cesta" name="agregar" class="btn btn-warning disabled">
						<input type="submit" value="Realizar Alquiler" name="alquilar" class="btn btn-warning disabled">
						<input type="submit" value="Vaciar Cesta" name="vaciar" class="btn btn-warning disabled">
					</div>
				</form>
				<!-- FIN DEL FORMULARIO -->
				<h3>Vehículos en la Cesta:</h3>
				<ul>
					<?php foreach ($_SESSION['cesta'] as $vehiculo): ?>
						<li><?php echo $vehiculo; ?></li>
					<?php endforeach; ?>
				</ul>
				<a href="logout.php">Cerrar Sesion</a>
</body>

</html>