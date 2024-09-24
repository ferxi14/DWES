<HTML>
<HEAD><TITLE> EJ3B – Conversor Decimal a base 16</TITLE></HEAD>
<BODY>
<?php
$num="48";
$base="16";
$resultado="";
$numAux = $num;
$caracHexa = "ABCDEF";

while ($numAux > 0) {
    $resto = $numAux % 16;
    if ($resto < 10) {
        $resultado = $resto . $resultado;
    } else {
        $resultado = $caracHexa[$resto - 10] . $resultado;
    }    

    $numAux = (int)($numAux/16);
}

echo "Numero $num en base $base = $resultado";


?>
</BODY>
</HTML>