<HTML>

<HEAD>
    <TITLE> EJ2-Direccion Red – Broadcast y Rango</TITLE>
</HEAD>

<BODY>
    <?php
    $ipcompleta = "192.168.16.100/16";

    $partes = explode("/", $ipcompleta);

    $direccionip = $partes[0];
    $mascara = $partes[1];

    $octetos = explode(".", $direccionip);

    /*********************************************/
    function calcDireccionRed($octetos, $mascara)
    {
        if ($mascara > 15 && $mascara < 24) {
            $octetos[2] = 0;
            $octetos[3] = 0;
        } else {
            if ($mascara > 24) {
                $octetos[3] = 0;
            } else {
                if ($mascara < 16) {
                    $octetos[1] = 0;
                    $octetos[2] = 0;
                    $octetos[3] = 0;
                }
            }
        }
        $direccionRed = implode(".", $octetos);

        return $direccionRed;
    }
    /*********************************************/
    function calcDireccionBroadcast($octetos, $mascara)
    {
        if ($mascara > 15 && $mascara < 24) {
            $octetos[2] = 255;
            $octetos[3] = 255;
        } else {
            if ($mascara > 24) {
                $octetos[3] = 255;
            } else {
                if ($mascara < 16) {
                    $octetos[1] = 255;
                    $octetos[2] = 255;
                    $octetos[3] = 255;
                }
            }
        }
        $direccionBroadcast = implode(".", $octetos);

        return $direccionBroadcast;
    }
    /**********************************************/


    $direccionRed = calcDireccionRed($octetos, $mascara);
    $direccionBroadcast = calcDireccionBroadcast($octetos, $mascara);

    echo "IP $ipcompleta";
    echo "<br>";
    echo "Mascara $mascara";
    echo "<br>";
    echo "Direccion de red $direccionRed";
    echo "<br>";
    echo "Direccion broadcast $direccionBroadcast";

    ?>
</BODY>

</HTML>