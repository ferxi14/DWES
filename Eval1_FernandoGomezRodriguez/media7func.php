<?php
/* Fernando Gómez Rodríguez */

function limpiar_campo($campoformulario)
{
    $campoformulario = trim($campoformulario);
    $campoformulario = stripslashes($campoformulario);
    $campoformulario = htmlspecialchars($campoformulario);

    return $campoformulario;
}
/**************************************************************/
function jugarCartas($numcartas) {
    $cartas = array();

    for ($i = 0; $i < $numcartas; $i++) {
        $cartas[] = rand(1, 10); 
    }
    return $cartas;
}
/**************************************************************/
function calcularPuntos($cartas) {
    $puntos = array_sum($cartas);

    foreach ($cartas as $carta) {
        if ($carta == 8 || $carta == 9 || $carta == 10) {
            $puntos -= $carta;
            $puntos += 0.5;
        } 
    }
    return $puntos;

}
?>