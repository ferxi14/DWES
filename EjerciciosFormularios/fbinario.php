<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="post">
        <h1>CONVERSOR BINARIO</h1>
        <label for="decimal">Numero decimal:</label>
        <input type="number" id="decimal" name="decimal">
        <input type="submit" value="enviar">
        <input type="reset" value="borrar">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $decimal = $_POST['decimal'];
        $binario = decbin($decimal);

        echo '<label for="decimal">Número decimal:</label>';
        echo '<input type="text" value="' . $decimal . '" readonly><br>';
        echo '<label for="binario">Número binario:</label>';
        echo '<input type="text" value="' . $binario . '" readonly><br>';
    }
    ?>

</body>
</body>

</html>