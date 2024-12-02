<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fichero5</title>
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
    function mostrarFicheroCompleto($fichero) {
        echo "<h3>Contenido del Fichero:</h3>";
        echo file_get_contents($fichero);
        echo "<br>";
    }
    /**************************************************************/
    function mostrarLineaFichero($fichero, $numLinea) {
        $file = file($fichero);

        echo "Línea " . $numLinea . ": " . $file[$numLinea - 1];
    }
    /**************************************************************/
    function mostrarPrimerasLineasFichero($fichero, $numLineas) {
        $file = file($fichero);
        $lineas = min($numLineas, count($file)); 
        echo "<h3>Primeras $lineas líneas:</h3>";

        for ($i = 0; $i < $lineas; $i++)
            echo "Línea " . ($i + 1) . ": " . $file[$i] . "<br>";
    }
    /**************************************************************/
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fichero = limpiar_campo($_POST['fichero']);
        $operacion = limpiar_campo($_POST['operaciones']);
        $numLinea = limpiar_campo($_POST['numLinea']);
        $numLineas = limpiar_campo($_POST['numLineas']);

        if (!file_exists($fichero)) {
            echo "Error: El fichero no existe.";
        } else {
            switch ($operacion) {
                case 'mostrarFichero':
                    mostrarFicheroCompleto($fichero);
                    break;

                case 'mostrarLinea':
                    mostrarLineaFichero($fichero, $numLinea);
                    break;

                case 'mostrarPrimerasLineas':
                    mostrarPrimerasLineasFichero($fichero, $numLineas);
                    break;
            }
        }
    }

    ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <h2>Operaciones Ficheros</h2>
        Fichero: <input type="text" name="fichero" value=""><br><br>
        Operaciones:<br>
        <input type="radio" name="operaciones" value="mostrarFichero" checked> Mostrar fichero<br>
        <input type="radio" name="operaciones" value="mostrarLinea"> Mostrar línea
        <input type="text" name="numLinea" placeholder=""> del fichero<br>
        <input type="radio" name="operaciones" value="mostrarPrimerasLineas"> Mostrar las
        <input type="text" name="numLineas" value=""> primeras líneas<br><br>

        <input type="submit" value="Enviar">
        <input type="reset" value="Borrar">
    </form>
</body>

</html>