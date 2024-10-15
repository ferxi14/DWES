<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fichero4</title>
</head>

<body>
    <?php
    function crearTabla($lineas) {
        echo "<table border='1'>";
        echo "<tr>
                <th>Nombre</th>
                <th>Primer Apellido</th>
                <th>Segundo Apellido</th>
                <th>Fecha de Nacimiento</th>
                <th>Localidad</th>
            </tr>";

        foreach ($lineas as $linea) {
            $linea = trim($linea);
            $campos = explode("##", $linea);

            $nombre = $campos[0];
            $apellido1 = $campos[1];
            $apellido2 = $campos[2];
            $fechaNacimiento = $campos[3];
            $localidad = $campos[4];

            echo "<tr>
            <td>$nombre</td>
            <td>$apellido1</td>
            <td>$apellido2</td>
            <td>$fechaNacimiento</td>
            <td>$localidad</td>
          </tr>";
        }

        echo "</table>";
    }
    /***********************************************************/
    function mostrarNumeroFilas($numFilas)
    {
        echo "<p>Se han leído $numFilas filas</p>";
    }
    /***********************************************************/
    $archivo = "alumnos2.txt";

    $lineas = file($archivo);
    $numFilas = count($lineas);

    crearTabla($lineas);
    mostrarNumeroFilas($numFilas);
    ?>


</body>

</html>