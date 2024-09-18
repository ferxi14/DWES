<HTML>
<HEAD><TITLE> EJ1-Conversion IP Decimal a Binario </TITLE></HEAD>
<BODY>
<?php
$ip="192.168.200.122";
$partes = explode(".", $ip);

/*******************************************/
function decimalAbinario($numero) {
    $binario = '';
    
    
    for ($i = 7; $i >= 0; $i--) {
        $bit = ($numero >> $i) & 1; 
        $binario .= $bit; 
    }

    return $binario; 
}
/*******************************************/
for ($i=0; $i< count($partes); $i++) 
    $partes[$i] = decimalAbinario($partes[$i]);

$ip_binaria = implode(".", $partes);

echo "IP $ip en binario es $ip_binaria";
?>
</BODY>
</HTML>