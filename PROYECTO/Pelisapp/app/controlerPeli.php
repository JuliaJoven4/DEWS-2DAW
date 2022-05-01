<?php
// ------------------------------------------------
// Controlador que realiza la gestión de usuarios
// ------------------------------------------------

include_once 'config.php';
include_once 'modeloPeliDB.php'; 

/**********
/*
 * Inicio Muestra o procesa el formulario (POST)
 */

function ctlDescargarJSON() {

    $peliculas = ModeloPeliDB::GetAll();
    $json = json_encode($peliculas);
    header("Content-Type: application/json");
    echo $json;
    exit();

}

function  ctlPeliInicio(){
    die(" No implementado.");
   }

/*
 *  Muestra y procesa el formulario de alta //(nueva peli)
 */

function ctlPeliAlta () {

    /*if server request method == get se muestra fnuevo para rellenarlo y enviar la orden alta por post
    con los datos*/
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        include_once 'plantilla/fnuevo.php';

    //se envian los datos procesados
    } else {

        /*Solo se le envían los datos que mete el usuario: el código no, porque se incrementa
        automáticamente cuando se crea un nuevo usuario */
        $datos = [$_POST['nombre'], $_POST['director'], $_POST['genero'], $_POST['imagen']];
        $pelicula = ModeloPeliDB::PeliAdd($datos);

        ctlPeliVerPelis();

    }
}
/*
 *  Muestra y procesa el formulario de Modificación 
 */
function ctlPeliModificar (){
    
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        if (isset ($_GET['codigo'])) {
            $pelicula = ModeloPeliDB::GetOne($_GET['codigo']);
            include_once 'plantilla/fmodifica.php';
        }

    } else {

        $datos = [$_POST['nombre'], $_POST['director'], $_POST['genero'], $_POST['imagen']];
        ModeloPeliDB::PeliUpdate($_POST['codigo'], $datos);

        ctlPeliVerPelis();

    }

}



/*
 *  Muestra detalles de la pelicula
 */

function ctlPeliDetalles() {
    if (isset ($_GET['codigo'])) {
        $pelicula = ModeloPeliDB::GetOne($_GET['codigo']);
        /*$pelicula = new Pelicula();
        $pelicula->codigo_pelicula = 1;
        $pelicula->nombre="Spiderman";*/
        include_once 'plantilla/detalle.php';
    }
    //die(" No implementado.");
    
}
/*
 * Borrar Peliculas
 */

function ctlPeliBorrar() {
    if (isset ($_GET['codigo'])) {

        $pelicula = ModeloPeliDB::PeliDel($_GET['codigo']);

        ctlPeliVerPelis();

    }
    //die(" No implementado.");
}

/*
 * Cierra la sesión y vuelca los datos
 */
function ctlPeliCerrar(){
    session_destroy();
    modeloPeliDB::closeDB();
    header('Location:index.php');
}

/*
 * Muestro la tabla con los usuario 
 */ 
function ctlPeliVerPelis (){
    // Obtengo los datos del modelo
    $peliculas = ModeloPeliDB::GetAll(); 
    // Invoco la vista 
    include_once 'plantilla/verpeliculas.php';
   
}