<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Binario</title>
</head>

<body>
    <h1>CONVERSOR BINARIO</h1>
    <?php

    $decimal = $_POST['decimal'];
    $binario = decbin($decimal);

    echo '<label for="decimal">Número Decimal:</label>';
    echo '<input type="text" value="' . $decimal . '" readonly><br>';
    echo '<label for="binario">Número Binario:</label>';
    echo '<input type="text" value="' . $binario . '" readonly><br>';

    ?>
</body>

</html>