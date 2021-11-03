<?php

session_start();

if ( ($_SERVER['REQUEST_METHOD'] == 'GET') && (empty($_GET['nombre'])) ) {
    include 'login.html';
}
if ( ($_SERVER['REQUEST_METHOD'] == 'GET') && (!empty($_GET['nombre'])) ) {
    $_SESSION['nombre'] = $_GET['nombre'];
    include 'inicio.php';
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['enviar'] == 'Anotar') {
        if (!isset($_SESSION['cantidadFrutas'][$_POST['fruta']])) {
            $_SESSION['cantidadFrutas'][$_POST['fruta']] = $_POST['cantidad'];
            include 'inicio.php';
        }
        else {
            $_SESSION['cantidadFrutas'][$_POST['fruta']] += $_POST['cantidad'];
            include 'inicio.php';
        }
    }
    else if ($_POST['enviar'] == 'Terminar') {
        include 'terminar.php';
        session_destroy();        
    }
}

?>