<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fichero1</title>
</head>

<body>
    <?php
        function limpiar_campo($campoformulario) {
            $campoformulario = trim($campoformulario);
            $campoformulario = stripslashes($campoformulario); 
            $campoformulario = htmlspecialchars($campoformulario);  
          
            return $campoformulario;
        }


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = limpiar_campo($_POST['nombre']);
            $apellido1 = limpiar_campo($_POST['apellido1']);
            $apellido2 = limpiar_campo($_POST['apellido2']);
            $fechaNacimiento = limpiar_campo($_POST['fechaNacimiento']);
            $localidad = limpiar_campo($_POST['localidad']);

            $nombre = str_pad(substr($_POST['nombre'], 0, 40), 40, ' ', STR_PAD_RIGHT);
            $apellido1 = str_pad(substr($_POST['apellido1'], 0, 40), 40, ' ', STR_PAD_RIGHT);
            $apellido2 = str_pad(substr($_POST['apellido2'], 0, 41), 41, ' ', STR_PAD_RIGHT);
            $fechaNacimiento = str_pad(substr($_POST['fechaNacimiento'], 0, 10), 10, ' ', STR_PAD_RIGHT);
            $localidad = str_pad(substr($_POST['localidad'], 0, 27), 27, ' ', STR_PAD_RIGHT);
        
            $linea = $nombre . $apellido1 . $apellido2 . $fechaNacimiento . $localidad . "\n";
        
            $archivo = fopen("alumnos1.txt", "a");
            fwrite($archivo, $linea);
            fclose($archivo);
        }
    ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        Nombre: <input type="text" name="nombre" required><br>
        Primer Apellido: <input type="text" name="apellido1" required><br>
        Segundo Apellido: <input type="text" name="apellido2" required><br>
        Fecha de Nacimiento: <input type="text" name="fechaNacimiento" required><br>
        Localidad: <input type="text" name="localidad" required><br>
        <input type="submit" value="Enviar">
    </form>
</body>

</html>