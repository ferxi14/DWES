<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fichero7</title>
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
    function crear_directorio($directorio) {
        if (!is_dir($directorio)) {
            if (mkdir($directorio, 0755, true)) {
                return "<p>Directorio creado: $directorio</p>";
            } else {
                return "<p>Error al crear el directorio: $directorio</p>";
            }
        }
        return ""; // No hay que devolver nada si el directorio ya existe
    }
    /**************************************************************/
    function copiar_fichero($fichero_origen, $fichero_destino) {

    }
    /**************************************************************/
    function renombrar_fichero($fichero_origen, $fichero_destino) {

    }
    /**************************************************************/
    function borrar_fichero($fichero_origen) {
        if (unlink($fichero_origen)) {
            return "<p>Fichero borrado correctamente.</p>";
        } else {
            return "<p>Error al borrar el fichero.</p>";
        }
    }
    /**************************************************************/
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fichero_origen = limpiar_campo($_POST['fichero_origen']);
        $fichero_destino = limpiar_campo($_POST['fichero_destino']);
        $operacion = $_POST['operacion'];

        if (!file_exists($fichero_origen)) {
            echo "<p> Error, el fichero de origen no existe </p>";

        } else {
            switch ($operacion) {
                case 'copiar':
                    echo copiar_fichero($fichero_origen, $fichero_destino);
                    break;

                case 'renombrar':
                    echo renombrar_fichero($fichero_origen, $fichero_destino);
                    break;

                case 'borrar':
                    echo borrar_fichero($fichero_origen);
                    break;

            }
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        Ruta del Fichero de Origen:<input type="text" name="fichero_origen" required>
        <br><br>
        Ruta del Fichero de Destino:<input type="text" name="fichero_destino" required>
        <br><br>

        <input type="radio" name="operacion" value="copiar" required> Copiar Fichero
        <input type="radio" name="operacion" value="renombrar"> Renombrar Fichero
        <input type="radio" name="operacion" value="borrar"> Borrar Fichero
        <br><br>

        <input type="submit" value="Ejecutar Operación">
        <input type="reset" value="Borrar">
    </form>
</body>

</html>