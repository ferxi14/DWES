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
    $itemsSeleccionados = $_POST['items'];      // Artículos seleccionados
    $numPago = $_POST['checkNumber'];           // Número de pago
    $precioTotal = 0;                           // Total del pedido

    // Validación del número del pago
    if (!preg_match('/^[A-Z]{2}[0-9]{5}$/', $checkNumber)) {
        $error = "El número de pago debe tener el formato AA99999.";
    } else {
        $orderDate = date('Y-m-d');
        $requiredDate = $orderDate; // Fecha de solicitud igual a la fecha del sistema
        $shippedDate = null;

        // Registro del pedido en la base de datos
        $stmt = $conn->prepare(
            "INSERT INTO orders (customerNumber, orderDate, requiredDate, shippedDate, status) 
            VALUES (:customerNumber, :orderDate, :requiredDate, :shippedDate, 'In Process')"
        );
        $stmt->execute([
            ':customerNumber' => $customerNumber,
            ':orderDate' => $orderDate,
            ':requiredDate' => $requiredDate,
            ':shippedDate' => $shippedDate
        ]);

        // Integración con Redsys
        $orderId = $conn->lastInsertId();
        $precioTotal = 100;
        $merchantCode = 'YOUR_MERCHANT_CODE';
        $terminal = '1';
        $currency = '978';
        $transactionType = '0';
        $urlMerchant = 'http://yourdomain.com/pe_respuesta.php';
        $urlOk = 'http://yourdomain.com/pe_exito.php';
        $urlKo = 'http://yourdomain.com/pe_error.php';

        // Generar firma
        $key = 'YOUR_SECRET_KEY';
        $signature = hash('sha256', $orderId . $merchantCode . $terminal . $precioTotal . $currency . $transactionType . $urlMerchant . $key);

        // Redirigir a la pasarela de pago
        echo "<form id='redsysForm' action='https://sis.redsys.es/sis/realizarPago' method='POST'>
                <input type='hidden' name='Ds_Merchant_Amount' value='$precioTotal'>
                <input type='hidden' name='Ds_Merchant_Order' value='$orderId'>
                <input type='hidden' name='Ds_Merchant_MerchantCode' value='$merchantCode'>
                <input type='hidden' name='Ds_Merchant_Currency' value='$currency'>
                <input type='hidden' name='Ds_Merchant_TransactionType' value='$transactionType'>
                <input type='hidden' name='Ds_Merchant_Terminal' value='$terminal'>
                <input type='hidden' name='Ds_Merchant_MerchantURL' value='$urlMerchant'>
                <input type='hidden' name='Ds_Merchant_UrlOK' value='$urlOk'>
                <input type='hidden' name='Ds_Merchant_UrlKO' value='$urlKo'>
                <input type='hidden' name='Ds_Merchant_Signature' value='$signature'>
              </form>
              <script>document.getElementById('redsysForm').submit();</script>";
        exit();
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