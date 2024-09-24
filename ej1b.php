<HTML>
<HEAD><TITLE> EJ1B – Conversor decimal a binario</TITLE></HEAD>
<BODY>
<?php
$num="168";
$numAux = $num;
$binario = "";

while ($numAux > 0){
    $resto = $numAux % 2;
    $binario = $binario . $resto;


    $numAux = (int)$numAux/2; 
}

echo "numero $num en binario: $binario";


?>
</BODY>
</HTML>