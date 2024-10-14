<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>fichero2</title>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $apellido1 = $_POST['apellido1'];
        $apellido2 = $_POST['apellido2'];
        $fechaNacimiento = $_POST['fechaNacimiento'];
        $localidad = $_POST['localidad'];

        $linea = $nombre . "##" . $apellido1 . "##" . $apellido2 . "##" . $fechaNacimiento . "##" . $localidad . "\n";

        $archivo = fopen("alumnos2.txt", "a");
        fwrite($archivo, $linea);
        fclose($archivo);
    }
    ?>

    <form method="POST" action="fichero2.php">
        Nombre: <input type="text" name="nombre" required><br>
        Primer Apellido: <input type="text" name="apellido1" required><br>
        Segundo Apellido: <input type="text" name="apellido2" required><br>
        Fecha de Nacimiento: <input type="text" name="fechaNacimiento" required><br>
        Localidad: <input type="text" name="localidad" required><br>
        <input type="submit" value="Enviar">
    </form>
</body>

</html>