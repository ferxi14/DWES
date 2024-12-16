<?php

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
