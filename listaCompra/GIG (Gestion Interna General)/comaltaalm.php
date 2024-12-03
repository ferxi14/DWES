<?php
$host = "localhost";
$username = "root";
$password = "rootroot";
$dbname = "comprasweb";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $localidad = trim($_POST['localidad']);

        if (!empty($localidad)) {
            // Obtener el último número de almacén
            $stmt = $conn->prepare("SELECT MAX(num_almacen) AS max_num FROM ALMACEN");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (isset($row['max_num']) && $row['max_num'] != null) {
                $ultimo_numero = (int) $row['max_num'];
            } else {
                $ultimo_numero = 0; // Si no hay registros, comenzar desde 0
            } 

            $nuevo_numero = $ultimo_numero + 1;

            // Insertar el nuevo almacén
            $stmt = $conn->prepare("INSERT INTO ALMACEN (num_almacen, localidad) VALUES (:num_almacen, :localidad)");
            $stmt->execute([
                ':num_almacen' => $nuevo_numero,
                ':localidad' => $localidad
            ]);

            echo "Almacén añadido con número: $nuevo_numero.";
        } else {
            echo "La localidad no puede estar vacía.";
        }
    }
} catch (PDOException $e) {
    echo "Conexión fallida: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Alta de Almacenes</title>
</head>

<body>
    <h1>Alta de Almacenes</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="localidad">Localidad del almacén:</label>
        <input type="text" id="localidad" name="localidad" required>
        <button type="submit">Agregar Almacén</button>
    </form>
</body>

</html>