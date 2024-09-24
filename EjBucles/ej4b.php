<HTML>
<HEAD><TITLE> EJ4B – Tabla Multiplicar</TITLE></HEAD>
<BODY>
<?php
$num="8";
$resultado = "";

for ($i = 1; $i <= 10; $i++) {
    $resultado = $num * $i;
    echo "$num x $i = $resultado";
    echo "<br>";
}
?>
</BODY>
</HTML>