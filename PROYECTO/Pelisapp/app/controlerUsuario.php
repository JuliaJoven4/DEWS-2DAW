<?php

include_once 'config.php';
include_once 'modeloUsuarioDB.php';

function ctlDatosUsuarios () {

    $usuarios = modeloUsuarioDB::GetAllUsers();
    return $usuarios;

}

function ctlCerrarSesion () {

    unset($_SESSION['usuario']);
    header('Location: index.php');

}

?>