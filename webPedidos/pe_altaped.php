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
    $customerNumber = $_POST['customerNumber'];
    $itemsSeleccionados = $_POST['items']; // Artículos seleccionados
    $numPago = $_POST['checkNumber'];
    $precioTotal = 0;

    // Validación del número de pago
    if (!preg_match('/^[A-Z]{2}[0-9]{5}$/', $numPago)) {
        die("Error: El número de pago debe tener el formato AA99999.");
    }

    $orderDate = date('Y-m-d');
    $requiredDate = $orderDate;
    $shippedDate = null;

    try {
        // Iniciar una transacción
        $conn->beginTransaction();

        // Insertar pedido en la tabla orders
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

        $orderId = $conn->lastInsertId(); // Obtener el ID del pedido insertado

        // Preparar inserción en orderdetails
        $stmtDetails = $conn->prepare(
            "INSERT INTO orderdetails (orderNumber, productCode, quantityOrdered, priceEach, orderLineNumber) 
             VALUES (:orderNumber, :productCode, :quantityOrdered, :priceEach, :orderLineNumber)"
        );

        $updateStock = $conn->prepare(
            "UPDATE products SET quantityInStock = quantityInStock - :quantityOrdered 
             WHERE productCode = :productCode"
        );

        foreach ($itemsSeleccionados as $index => $item) {
            $precioTotal += $item['quantity'] * $item['price'];

            // Insertar detalles del pedido
            $stmtDetails->execute([
                ':orderNumber' => $orderId,
                ':productCode' => $item['productCode'],
                ':quantityOrdered' => $item['quantity'],
                ':priceEach' => $item['price'],
                ':orderLineNumber' => $index + 1
            ]);

            // Actualizar stock
            $updateStock->execute([
                ':quantityOrdered' => $item['quantity'],
                ':productCode' => $item['productCode']
            ]);
        }

        // Registrar el pago en la tabla payments
        $stmtPayment = $conn->prepare(
            "INSERT INTO payments (customerNumber, checkNumber, paymentDate, amount) 
             VALUES (:customerNumber, :checkNumber, :paymentDate, :amount)"
        );
        $stmtPayment->execute([
            ':customerNumber' => $customerNumber,
            ':checkNumber' => $numPago,
            ':paymentDate' => $orderDate,
            ':amount' => $precioTotal
        ]);

        // Generar la firma para Redsys
        $merchantCode = 'YOUR_MERCHANT_CODE';  // Tu código de comercio
        $terminal = '1';  // El terminal, generalmente '1'
        $currency = '978';  // El código de moneda (978 es el código de EUR)
        $transactionType = '0';  // Tipo de transacción
        $urlMerchant = 'http://yourdomain.com/pe_respuesta.php';  // URL de respuesta
        $urlOk = 'http://yourdomain.com/pe_exito.php';  // URL de éxito
        $urlKo = 'http://yourdomain.com/pe_error.php';  // URL de error

        $key = 'YOUR_SECRET_KEY';  // Tu clave secreta proporcionada por Redsys
        $signatureKey = base64_decode($key);
        $data = $orderId . $merchantCode . $terminal . $precioTotal . $currency . $transactionType . $urlMerchant;
        $signature = base64_encode(hash_hmac('sha256', $data, $signatureKey, true));

        // Confirmar transacción en la base de datos
        $conn->commit();
        echo "Pedido realizado con éxito. Total: $precioTotal";
        
        // Redirigir a la pasarela de pago de Redsys
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
                <button type='submit'>Proceder al pago</button>
              </form>
              <script>document.getElementById('redsysForm').submit();</script>";
    } catch (Exception $e) {
        $conn->rollBack();
        die("Error al realizar el pedido: " . $e->getMessage());
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
        <label for="items">Artículos:</label>
        <select id="items" name="items[][productCode]" multiple required>
            <?php
            // Consulta para obtener los artículos disponibles en stock
            $stmt = $conn->query("SELECT productCode, productName, quantityInStock, buyPrice FROM products WHERE quantityInStock > 0");

            // Recorremos cada fila obtenida de la consulta
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $productCode = $row['productCode'];       // Código del producto
                $productName = $row['productName'];       // Nombre del producto
                $quantityInStock = $row['quantityInStock']; // Cantidad en stock
                $buyPrice = $row['buyPrice'];             // Precio de compra del producto

                // Crear una opción en el select para cada artículo disponible
                echo "<option value='$productCode' data-price='$buyPrice' data-stock='$quantityInStock'>
                $productName (En stock: $quantityInStock) - Precio: " . number_format($buyPrice, 2) . " €
              </option>";
            }
            ?>
        </select>
        <br>
        <button type="submit">Realizar Pedido</button>
    </form>
</body>

</html>