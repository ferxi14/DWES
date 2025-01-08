<?php
require_once 'pe_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener el número de cliente desde el formulario
    $customerNumber = $_POST['customerNumber'];

    // Consulta SQL para obtener los pedidos y detalles del cliente
    $stmt = $conn->prepare("
        SELECT o.orderNumber, o.orderDate, o.status, od.orderLineNumber, p.productName, od.quantityOrdered, od.priceEach
        FROM orders o
        JOIN orderdetails od ON o.orderNumber = od.orderNumber
        JOIN products p ON od.productCode = p.productCode
        WHERE o.customerNumber = :customerNumber
        ORDER BY od.orderLineNumber ASC
    ");
    $stmt->execute([':customerNumber' => $customerNumber]);

    // Obtener todos los resultados de la consulta
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Pedidos</title>
</head>
<body>
    <h1>Consulta de Pedidos por Cliente</h1>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="customerNumber">Número de Cliente:</label>
        <select id="customerNumber" name="customerNumber" required>
            <?php
            // Obtener los números de cliente para mostrar en el formulario
            $stmtClientes = $conn->query("SELECT customerNumber, customerName FROM customers");
            while ($row = $stmtClientes->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['customerNumber']}'>{$row['customerName']} ({$row['customerNumber']})</option>";
            }
            ?>
        </select>
        <button type="submit">Consultar Pedidos</button>
    </form>

    <?php if (isset($pedidos) && count($pedidos) > 0): ?>
        <h2>Pedidos de Cliente <?php echo $customerNumber; ?></h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Número Pedido</th>
                    <th>Fecha Pedido</th>
                    <th>Estado Pedido</th>
                    <th>Número Línea</th>
                    <th>Nombre Producto</th>
                    <th>Cantidad Pedida</th>
                    <th>Precio Unidad</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($pedidos as $pedido) {
                    echo "<tr>";
                    echo "<td>{$pedido['orderNumber']}</td>";
                    echo "<td>{$pedido['orderDate']}</td>";
                    echo "<td>{$pedido['status']}</td>";
                    echo "<td>{$pedido['orderLineNumber']}</td>";
                    echo "<td>{$pedido['productName']}</td>";
                    echo "<td>{$pedido['quantityOrdered']}</td>";
                    echo "<td>" . number_format($pedido['priceEach'], 2) . " €</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    <?php elseif (isset($pedidos)): ?>
        <p>No se encontraron pedidos para el cliente seleccionado.</p>
    <?php endif; ?>
</body>
</html>
