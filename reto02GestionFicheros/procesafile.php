<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    function limpiar_campo($campoformulario) {
        $campoformulario = trim($campoformulario);
        $campoformulario = stripslashes($campoformulario);
        $campoformulario = htmlspecialchars($campoformulario);

        return $campoformulario;
    }
    /***********************************************************/
    
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