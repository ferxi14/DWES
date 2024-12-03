<?php
$host = "localhost";
$username = "root";
$password = "rootroot";
$dbname = "comprasweb";


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