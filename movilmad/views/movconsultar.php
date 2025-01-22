<?php
session_start();
if (!isset($_SESSION['usuario'])) {
	header("Location: movlogin.php");
	exit();
}

require_once '../db/movconfig.php';
$user = $_SESSION['usuario'];
$resultados = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fechadesde'], $_POST['fechahasta'])) {
	$fechadesde = $_POST['fechadesde'];
	$fechahasta = $_POST['fechahasta'];

	try {
		$db = conexionDB();

		$query = "SELECT matricula, fecha_alquiler, fecha_devolucion, preciototal 
                      FROM ralquileres 
                      WHERE idcliente = :idcliente 
                        AND fecha_alquiler BETWEEN :fechadesde AND :fechahasta
                      ORDER BY fecha_alquiler ASC";

		$stmt = $db->prepare($query);
		$stmt->bindParam(':idcliente', $user['idcliente'], PDO::PARAM_INT);
		$stmt->bindParam(':fechadesde', $fechadesde);
		$stmt->bindParam(':fechahasta', $fechahasta);
		$stmt->execute();

		$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		$error = "Error en la consulta: " . $e->getMessage();
	}
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
			<div class="card-header">Menú Usuario - CONSULTA ALQUILERES </div>
			<div class="card-body">




				<!-- INICIO DEL FORMULARIO -->
				<form action="" method="post">

					<B>Bienvenido/a:</B> <?php echo $user['email']; ?><BR><BR>
					<B>Identificador Cliente:</B><?php echo $user['idcliente']; ?> <BR><BR>

					Fecha Desde: <input type='date' name='fechadesde' value='' size=10 placeholder="fechadesde" class="form-control">
					Fecha Hasta: <input type='date' name='fechahasta' value='' size=10 placeholder="fechahasta" class="form-control"><br><br>

					<div>
						<input type="submit" value="Consultar" name="Consultar" class="btn btn-warning disabled">

						<input type="button" value="Volver" name="Volver" class="btn btn-warning disabled" onclick="window.location.href='movwelcome.php'">

					</div>
				</form>
				<!-- FIN DEL FORMULARIO -->
				<?php if (!empty($resultados)): ?>
					<h3>Resultados de la consulta:</h3>
					<table border="1">
						<thead>
							<tr>
								<th>Matrícula</th>
								<th>Fecha Alquiler</th>
								<th>Fecha Devolución</th>
								<th>Precio Total</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($resultados as $row): ?>
								<tr>
									<td><?php echo htmlspecialchars($row['matricula']); ?></td>
									<td><?php echo htmlspecialchars($row['fecha_alquiler']); ?></td>
									<td>
										<?php
										if ($row['fecha_devolucion']) {
											echo htmlspecialchars($row['fecha_devolucion']);
										} else {
											echo 'No devuelto';
										}
										?>
									</td>
									<td>
										<?php
										if ($row['preciototal'] != null) {
											echo htmlspecialchars($row['preciototal'], 2);
										} else {
											echo 'Pendiente';
										}
										?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php endif; ?>
				<a href="logout.php">Cerrar Sesión</a>

</body>

</html>