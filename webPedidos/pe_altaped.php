<?php
$host = "localhost";
$username = "root";
$password = "rootroot";
$dbname = "pedidos";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerNumber = $_POST['customerNumber']; // ID del cliente
    $itemsSeleccionados = $_POST['items'];           // Artículos seleccionados
    $numPago = $_POST['checkNumber'];       // Número de pago
    $precioTotal = 0;                           // Total del pedido

    // Validación del número del pago
    if (!preg_match('/^[A-Z]{2}[0-9]{5}$/', $checkNumber)) {
        $error = "El número de pago debe tener el formato AA99999.";
    } else {
    
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Pedido</title>
</head>

<body>
    <h1>Realizar Pedido</h1>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="customerNumber">Número de Cliente:</label>
        <input type="number" id="customerNumber" name="customerNumber" required>
        <br>
        <label for="checkNumber">Número de Pago:</label>
        <input type="text" id="checkNumber" name="checkNumber" required>
        <br>

        <button type="submit">Realizar Pedido</button>
    </form>
</body>

</html>
