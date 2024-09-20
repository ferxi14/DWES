<HTML>
<HEAD><TITLE> EJ2-Direccion Red – Broadcast y Rango</TITLE></HEAD>
<BODY>
<?php
$ipcompleta="192.168.16.100/16";

$partes = explode("/",$ipcompleta);

$direccionip = $partes[0];
$mascara = $partes[1];

$octetos = explode (".", $direccionip);

if ($mascara > 15 && $mascara < 24) {
    octetos[2] = 0;
    octetos[3] = 0;
} else {
    if ($mascara > 24) {
        octetos[3] = 0;
    } else {
        if($mascara < 16) {
            octetos[1] = 0;
            octetos[2] = 0;
            octetos[3] = 0;
        }
    }
}



?>
</BODY>
</HTML>