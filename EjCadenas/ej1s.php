<HTML>
<HEAD><TITLE> EJ1-Conversion IP Decimal a Binario </TITLE></HEAD>
<BODY>
<?php
$ip="192.168.200.122";
$partes = explode(".", $ip);

for ($i=0; $i< count($partes); $i++) 
    $partes[$i] = sprintf('%08b', $partes[$i]);

$ip_binaria = implode(".", $partes);

printf("IP %s en binario es %s", $ip, $ip_binaria);
?>
</BODY>
</HTML>