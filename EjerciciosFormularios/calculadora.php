<!DOCTYPE html>
<html lang="es">

<head>
    <title>Document</title>
</head>

<body>
    <h1>CALCULADORA</h1>
    <?php

    $operando1 = $_POST['operando1'];
    $operando2 = $_POST['operando2'];
    $operacion = $_POST['operacion'];

    switch ($operacion) {
        case 'suma':
            $resultado = $operando1 + $operando2;
            echo "<p>Resultado operación: $operando1 + $operando2 = $resultado</p>";
            break;

        case 'resta':
            $resultado = $operando1 - $operando2;
            echo "<p>Resultado operación: $operando1 - $operando2 = $resultado</p>";
            break;

        case 'producto':
            $resultado = $operando1 * $operando2;
            echo "<p>Resultado operación: $operando1 * $operando2 = $resultado</p>";
            break;
        case 'division':
            $resultado = $operando1 / $operando2;
            echo "<p>Resultado operación: $operando1 / $operando2 = $resultado</p>";
            break;
    }
    ?>
</body>

</html>