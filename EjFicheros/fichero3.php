<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fichero3</title>
</head>

<body>
    <?php
    $archivo = "alumnos1.txt";

    $lineas = file($archivo);
    $numFilas = count($lineas);

    echo "<table border='1'>";
    echo "<tr>
            <th>Nombre</th>
            <th>Primer Apellido</th>
            <th>Segundo Apellido</th>
            <th>Fecha de Nacimiento</th>
            <th>Localidad</th>
          </tr>";

    foreach ($lineas as $linea) {
        $nombre = trim(substr($linea, 0, 40));
        $apellido1 = trim(substr($linea, 40, 40));
        $apellido2 = trim(substr($linea, 80, 41));
        $fechaNacimiento = trim(substr($linea, 121, 10));
        $localidad = trim(substr($linea, 131, 27));

        echo "<tr>
                <td>$nombre</td>
                <td>$apellido1</td>
                <td>$apellido2</td>
                <td>$fechaNacimiento</td>
                <td>$localidad</td>
              </tr>";
    }

    echo "</table>";


    echo "<p>se han leido $numFilas filas</p>";
    
    ?>


</body>

</html>