<?php

session_start();

$msg = "";

if (!isset($_COOKIE['veces'])) {
    $veces = 1;
    setcookie('veces', $veces, time() + 60*60*24*30);
} else {
    $veces = $_COOKIE['veces'];
}

if ( ($_SERVER['REQUEST_METHOD'] == 'GET') && (empty($_GET['dineroInicial'])) ) {
    include 'inicio.html';
}
if ( ($_SERVER['REQUEST_METHOD'] == 'GET') && (!empty($_GET['dineroInicial'])) ) {
    $_SESSION['dinero'] = $_GET['dineroInicial'];
    include 'apuesta.php';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset ($_POST['accion'])) {
        if ($_POST['accion'] == 'apostar') {
            $numCasino = random_int(1, 10);
            if ($numCasino % 2 == 0) {
                $resultadoCasino = "par";
            } else {
                $resultadoCasino = "impar";
            }
        
            if (isset($_POST['apuesta'])) {
                if ($_POST['apuesta'] == $resultadoCasino) {
                    $msg = "RESULTADO DE LA APUESTA: " . $resultadoCasino . "<br> ¡HA GANADO!";
                    if (is_numeric($_POST['dineroApuesta'])) {
                        $_SESSION['dinero'] += $_POST['dineroApuesta'];
                        
                    } else { $msg = "Debe introducir un importe para apostar."; }
                    include 'apuesta.php';
                } else {
                    $msg = "RESULTADO DE LA APUESTA: " . $resultadoCasino . "<br> HA PERDIDO :(";
                    if (is_numeric($_POST['dineroApuesta'])) {
                        $_SESSION['dinero'] -= $_POST['dineroApuesta'];
                    } else { $msg = "Debe introducir un importe para apostar."; }
                    include 'apuesta.php';
                }
            }
        } else {
            include 'final.php';
            $veces++;
            setcookie('veces', $veces, time() + 60*60*24*30);
        }
    }
}

?>