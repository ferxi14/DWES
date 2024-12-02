<?php
/* Nombre Alumno: Fernando Gómez Rodriguez */

include('media7func.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $nombre1 = limpiar_campo($_POST['nombre1']);
        $nombre2 = limpiar_campo($_POST['nombre2']);
        $nombre3 = limpiar_campo($_POST['nombre3']);
        $nombre4 = limpiar_campo($_POST['nombre4']);
        $numcartas = limpiar_campo($_POST['numcartas']);
        $apuesta = limpiar_campo($_POST['apuesta']);

        /*if (empty($nombre3) && empty($nombre4)) {
            $jugadores = array(
                $nombre1 => jugarCartas($numcartas),
                $nombre2 => jugarCartas($numcartas)
            );
        } elseif (empty($nombre3)) {
            $jugadores = array(
                $nombre1 => jugarCartas($numcartas),
                $nombre2 => jugarCartas($numcartas),
                $nombre4 => jugarCartas($numcartas)
            );
        } elseif (empty($nombre4)) {
            $jugadores = array(
                $nombre1 => jugarCartas($numcartas),
                $nombre2 => jugarCartas($numcartas),
                $nombre3 => jugarCartas($numcartas)
            );
        }*/
        if ((!empty($nombre1)) || (!empty($nombre2)) || (!empty($nombre3)) || (!empty($nombre4))) {
            $jugadores = array(
                $nombre1 => jugarCartas($numcartas),
                $nombre2 => jugarCartas($numcartas),
                $nombre3 => jugarCartas($numcartas),
                $nombre4 => jugarCartas($numcartas)
            ); 
        } elseif (empty($nombre3) && empty($nombre4)) {
            $jugadores = array(
                $nombre1 => jugarCartas($numcartas),
                $nombre2 => jugarCartas($numcartas)
            );
        } elseif (empty($nombre3)) {
            $jugadores = array(
                $nombre1 => jugarCartas($numcartas),
                $nombre2 => jugarCartas($numcartas),
                $nombre4 => jugarCartas($numcartas)
            );
        } elseif (empty($nombre4)) {
            $jugadores = array(
                $nombre1 => jugarCartas($numcartas),
                $nombre2 => jugarCartas($numcartas),
                $nombre3 => jugarCartas($numcartas)
            );
        } 
        
        var_dump($jugadores);

        $puntuacion = array();
        foreach ($jugadores as $nombre => $cartas) {
            $puntuacion[$nombre] = calcularPuntos($cartas);
            
        }
        var_dump($puntuacion);

        $ganadores = array();


    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
