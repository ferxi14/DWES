<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>CONVERSOR NUMERICO</h1>
    <?php

    function convertir($numero, $base) {
        switch ($base) {
            case 'binario':
                return decbin($numero);
            case 'octal':
                return decoct($numero);
            case 'hexadecimal':
                return dechex($numero);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $decimal = $_POST['decimal'];
        $conversor = $_POST['conversor'];

        echo "<p>Numero decimal: $decimal</p>";

        if ($conversor == 'todos') {
            echo "<p>Binario:" . convertir($decimal, 'binario') . "</p>";
            echo "<p>Octal: " . convertir($decimal, 'octal') . "</p>";
            echo "<p>Hexadecimal: " . convertir($decimal, 'hexadecimal') . "</p>";
        } else {
            $resultado = convertir($decimal, $conversor);
            echo "<p>" .$conversor . ": $resultado </p>";
        }

    }
    ?>
</body>
</html>