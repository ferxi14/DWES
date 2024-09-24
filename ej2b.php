<HTML>

<HEAD>
    <TITLE> EJ2B – Conversor Decimal a base n </TITLE>
</HEAD>

<BODY>
    <?php
    $num = "48";
    $base = "8";
    $resultado ="";
    $numAux = $num;
    
    while ($numAux > 0) {
        $resto = $numAux % $base;
        $resultado = $resto . $resultado;
        $numAux = (int)($numAux / $base);
    }


    echo "Numero $num en base $base = $resultado";
    ?>
</BODY>

</HTML>