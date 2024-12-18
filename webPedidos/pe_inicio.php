<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_unset();
    session_destroy();
    setcookie(session_name(), '', time() - 3600, "/");
    header("Location: pe_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de la web de pedidos</title>
</head>

<body>
    <div>
        <h1>Bienvenido</h1>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <button type="submit">Cerrar sesión</button>
        </form>

        <nav>
            <a href="pe_altaped.php">Realizar pedido</a>
            <br>
            <a href="pe_consped.php">Consultar pedidos</a>
            <br>
            <a href="pe_consprodstock.php">Consultar stock disponible</a>
            <br>
            <a href="pe_constock.php">Consultar stock total de una determinada linea de productos</a>
            <br>
            <a href="pe_topprod.php">Consultar unidades vendidas</a>
            <br>
            <a href="pe_conspago.php">Consultar pagos</a>
        </nav>
    </div>
</body>

</html>