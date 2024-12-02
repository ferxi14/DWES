<?php

function limpiar_campo($campoformulario)
{
    $campoformulario = trim($campoformulario);
    $campoformulario = stripslashes($campoformulario);
    $campoformulario = htmlspecialchars($campoformulario);

    return $campoformulario;
}
/***************************************************************/
/* Funcion que genera tiradas de dados aleatoriamente recibiendo como parametro la cantidad de dados que se van a generar, devuelve un array con los resultados de las tiradas*/
function tirarDados($numDados)
{
    $resultados = array();
    for ($i = 0; $i < $numDados; $i++) {
        $resultados[] = rand(1, 6); // Número aleatorio entre 1 y 6
    }
    return $resultados;
}
/***************************************************************/
/* Funcion que calcula los puntos obtenidos en las tiradas de cada jugador  */
function calcularPuntos($dados)
{
    $puntos = array_sum($dados);

    $todosIguales = true;

    // si hay algun dado que no es igual se mantiene la puntuacion
    foreach ($dados as $dado) {
        if ($dado != $dados[0]) {
            $todosIguales = false;
            break;
        }
    }

    if (count($dados) > 1 && $todosIguales) {
        $puntos = 100;
    }

    return $puntos;
}
/***************************************************************/
/* Funcion para mostar la tabla con los nombres de los jugadores y las imágenes de los dados */
function generarTablaResultados($jugadores)
{
    echo '<h2>RESULTADO JUEGO DADOS</h2>';
    echo '<table border="1" style="text-align: center;">';

    foreach ($jugadores as $nombre => $dados) {
        echo '<tr>';
        echo '<td><strong>' . $nombre . '</strong></td>';

        // Mostrar la imagen de cada dado
        foreach ($dados as $dado) {
            echo '<td><img src="./images/' . $dado . '.png" width="50" height="50"></td>';
        }

        echo '</tr>';
    }
    echo '</table>';
}
/***************************************************************/
/* Funcion para mostrar las puntuaciones de cada jugador y quien ha ganado la partida */
function mostrarResultadosYGanadores($puntuaciones, $ganadores)
{
    // Mostrar los resultados
    echo '<br>';
    foreach ($puntuaciones as $nombre => $puntos) {
        echo '<p>' . $nombre . ' = ' . $puntos . '</p>';
    }

    // Mostrar los ganadores
    echo '<h3>GANADOR/es:</h3>';
    foreach ($ganadores as $ganador) {
        echo '<p>GANADOR: ' . $ganador . '</p>';
    }

    // Mostrar el número de ganadores
    echo '<p>NÚMERO DE GANADORES: ' . count($ganadores) . '</p>';
}
