<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fichero6</title>
</head>

<body>
    <?php
    function limpiar_campo($campoformulario) {
        $campoformulario = trim($campoformulario);
        $campoformulario = stripslashes($campoformulario);
        $campoformulario = htmlspecialchars($campoformulario);

        return $campoformulario;
    }
    /**************************************************************/
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fichero = limpiar_campo($_POST['fichero']);

        if (file_exists($fichero)) {
            $tamano = filesize($fichero);
            $fecha_modificacion = date("d/m/Y H:i", filemtime($fichero));

            echo "<h2>Información del Archivo</h2>";
            echo "<p>Nombre del archivo: " . $fichero . "</p>";
            echo "<p>Tamaño: " . $tamano . " bytes</p>";
            echo "<p>Última modificación: " . $fecha_modificacion . "</p>";
        } else {
            echo "<p>El archivo no existe.</p>";
        }
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        Nombre del Fichero:<input type="text" name="fichero" value="" required>
        <br><br>
        <input type="submit" value="Ver datos del fichero">
        <input type="reset" value="Borrar">
    </form>
</body>

</html>