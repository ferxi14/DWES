<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form name="calculadora" action="" method="post">
        <h1>CALCULADORA</h1>
        <label for="operando1">Operando 1:</label>
        <input type="number" id="operando1" name="operando1">
        <br>
        <label for="operando2">Operando 2:</label>
        <input type="number" id="operando2" name="operando2">
        <p>Selecciona operación:</p>
        <input type="radio" id="suma" name="operacion" value="suma">Suma <br>
        <input type="radio" id="resta" name="operacion" value="resta">Resta <br>
        <input type="radio" id="producto" name="operacion" value="producto">Producto <br>
        <input type="radio" id="division" name="operacion" value="division">Division <br>

        <input type="submit" value="enviar">
        <input type="reset" value="borrar">

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {


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
        }
        ?>
    </form>
</body>

</html>