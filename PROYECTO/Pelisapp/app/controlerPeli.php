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

function ctlDescargarPDF($offset, $limit) {

    if (isset($_GET['codigo'])) {
        $pelicula = ModeloPeliDB::GetOne($_GET['codigo']);
        include_once 'plantilla/visorPDF.php';
    }

}

function ctlDescargarJSON($offset, $limit)
{

    $peliculas = ModeloPeliDB::GetAll();
    $json = json_encode($peliculas);
    header("Content-Type: application/json");
    echo $json;
    exit();
}

function  ctlPeliInicio($offset, $limit)
{
    die("No implementado.");
}

/*
 *  Muestra y procesa el formulario de alta //(nueva peli)
 */

function ctlPeliAlta($offset, $limit)
{

    /*if server request method == get se muestra fnuevo para rellenarlo y enviar la orden alta por post
    con los datos*/
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        include_once 'plantilla/fnuevo.php';

    //Se envian los datos procesados
    } else {

        if ( !empty($_FILES['imagen']['name']) ) {

            if ( $msg = errorSubida() ) {

                include_once 'plantilla/fnuevo.php';

                return;

            } else {

                $imagen = $_FILES['imagen']['name'];

            }

        } else {

            $imagen = NULL;

        }

        /*Solo se le envían los datos que mete el usuario: el código no, porque se incrementa
        automáticamente cuando se crea un nuevo usuario */
        $datos = [$_POST['nombre'], $_POST['director'], $_POST['genero'], $imagen, $_POST['trailer'], $_POST['enlace']];

        $pelicula = ModeloPeliDB::PeliAdd($datos);
        ModeloPeliDB::cambiarNulos();

        ctlPeliVerPelis($offset, $limit);
    }
}

function errorSubida () {

    $nombreImagen = $_FILES['imagen']['name'];
    $temporal =   $_FILES['imagen']['tmp_name'];

    $msg = false;

    if ($_FILES['imagen']['error'] != 0 ) {

        $msg = "El fichero no ha podido subirse.";

    } else if ($_FILES['imagen']['type'] != "image/jpeg" && $_FILES['imagen']['type'] != "image/png") {

        $msg = "ERROR: el formato de la imagen no es ni JPEG ni PNG. No se puede completar la subida.";

    } else if (! move_uploaded_file($temporal, 'app/img/'. $nombreImagen )) {
       $msg= "ERROR: no se ha podido subir la imagen a imágenes.";
       return;
    }

    return $msg;

}

/*
 *  Muestra y procesa el formulario de Modificación 
 */
function ctlPeliModificar($offset, $limit) {

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        if (isset($_GET['codigo'])) {
            $pelicula = ModeloPeliDB::GetOne($_GET['codigo']);
            include_once 'plantilla/fmodifica.php';
        }
    } else {

        if ( !empty ($_FILES['imagen']['name']) ) {

            if ( $msg = errorSubida() ) {

                include_once 'plantilla/fmodifica.php';
                return;

            } else {

                $imagen = $_FILES['imagen']['name'];     

            }

        } else {

            $imagen = $_POST['imagenanterior'];

        }

        $datos = [$_POST['nombre'], $_POST['director'], $_POST['genero'], $imagen, $_POST['trailer'], $_POST['enlace']];
        ModeloPeliDB::PeliUpdate($_POST['codigo'], $datos);
        ctlPeliVerPelis($offset, $limit);
    }
}

//Función para puntuar una película
function ctlPeliPuntuar($offset, $limit) {

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        $pelicula = ModeloPeliDB::GetOne($_GET['codigo']);
        include_once 'plantilla/fpuntua.php';

    } else {

        if (isset ($_POST['puntuacionUsu'])) {

            ModeloPeliDB::NumPuntuaciones($_POST['codigo']);
            $se_puntua = ModeloPeliDB::PuntuacionTotal($_POST['codigo'], $_POST['puntuacionUsu']);

            if ($se_puntua == false) {

                include_once 'plantilla/mal_votado.php';

            } else {

                $pelicula = ModeloPeliDB::GetOne($_POST['codigo']);
                $numPuntuaciones = $pelicula->num_puntuacion;
                $puntuacionTotal = $pelicula->puntuacion_total;
                $respuesta = ModeloPeliDB::PeliPuntua($_POST['codigo'], $puntuacionTotal, "'" . $numPuntuaciones . "'");

                if ($respuesta == false) {
                    include_once 'plantilla/ya_votado.php';
                } else {
                    ctlPeliVerPelis($offset, $limit);
                }

            }
        }
    }
}

function ctlPeliPuntuarEstandar($offset, $limit) {

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        $pelicula = ModeloPeliDB::GetOne($_GET['codigo']);
        include_once 'plantilla/fpuntua.php';

    } else {

        if (isset ($_POST['puntuacionUsu'])) {

            ModeloPeliDB::NumPuntuaciones($_POST['codigo']);
            $se_puntua = ModeloPeliDB::PuntuacionTotal($_POST['codigo'], $_POST['puntuacionUsu']);

            if ($se_puntua == false) {

                include_once 'plantilla/mal_votado.php';
                
            } else {

                $pelicula = ModeloPeliDB::GetOne($_POST['codigo']);
                $numPuntuaciones = $pelicula->num_puntuacion;
                $puntuacionTotal = $pelicula->puntuacion_total;
                $respuesta = ModeloPeliDB::PeliPuntua($_POST['codigo'], $puntuacionTotal, "'" . $numPuntuaciones . "'");

                if ($respuesta == false) {
                    include_once 'plantilla/ya_votado.php';
                } else {
                    ctlPeliVerPelisEstandar($offset, $limit);
                }
            }
        }
    }
}

/*
 *  Muestra detalles de la pelicula
 */

function ctlPeliDetalles($offset, $limit) {
    if (isset($_GET['codigo'])) {
        $pelicula = ModeloPeliDB::GetOne($_GET['codigo']);
        include_once 'plantilla/detalle.php';
    }
    //die(" No implementado.");

}
/*
 * Borrar Peliculas
 */

function ctlPeliBorrar($offset, $limit) {
    if (isset($_GET['codigo'])) {

        $pelicula = ModeloPeliDB::PeliDel($_GET['codigo']);

        ctlPeliVerPelis();
    }
}

function ctlBuscarTitulo($offset, $limit) {

    if (isset($_GET['busqueda'])) {

        $busqueda = $_GET['busqueda'];
        $peliculas = ModeloPeliDB::getTitulo($busqueda);
        include_once 'plantilla/verpeliculas.php';
    }
}

function ctlBuscarTituloEstandar($offset, $limit) {

    if (isset($_GET['busqueda'])) {

        $busqueda = $_GET['busqueda'];
        $peliculas = ModeloPeliDB::getTitulo($busqueda);
        include_once 'plantilla/verpeliculasEstandar.php';
    }
}

function ctlBuscarTituloInvitado($offset, $limit) {

    if (isset($_GET['busqueda'])) {

        $busqueda = $_GET['busqueda'];
        $peliculas = ModeloPeliDB::getTitulo($busqueda);
        include_once 'plantilla/verpeliculasInvitado.php';
    }
}

function ctlBuscarDirector($offset, $limit) {

    if (isset($_GET['busqueda'])) {

        $busqueda = $_GET['busqueda'];
        $peliculas = ModeloPeliDB::getDirector($busqueda);
        include_once 'plantilla/verpeliculas.php';
    }
}

function ctlBuscarDirectorEstandar($offset, $limit) {

    if (isset($_GET['busqueda'])) {

        $busqueda = $_GET['busqueda'];
        $peliculas = ModeloPeliDB::getDirector($busqueda);
        include_once 'plantilla/verpeliculasEstandar.php';
    }
}

function ctlBuscarDirectorInvitado($offset, $limit) {

    if (isset($_GET['busqueda'])) {

        $busqueda = $_GET['busqueda'];
        $peliculas = ModeloPeliDB::getDirector($busqueda);
        include_once 'plantilla/verpeliculasInvitado.php';
    }
}

function ctlBuscarGenero($offset, $limit) {

    if (isset($_GET['busqueda'])) {

        $busqueda = $_GET['busqueda'];
        $peliculas = ModeloPeliDB::getGenero($busqueda);
        include_once 'plantilla/verpeliculas.php';
    }
}

function ctlBuscarGeneroEstandar($offset, $limit) {

    if (isset($_GET['busqueda'])) {

        $busqueda = $_GET['busqueda'];
        $peliculas = ModeloPeliDB::getGenero($busqueda);
        include_once 'plantilla/verpeliculasEstandar.php';
    }
}

function ctlBuscarGeneroInvitado($offset, $limit) {

    if (isset($_GET['busqueda'])) {

        $busqueda = $_GET['busqueda'];
        $peliculas = ModeloPeliDB::getGenero($busqueda);
        include_once 'plantilla/verpeliculasInvitado.php';
    }
}

/*
 * Cierra la sesión y vuelca los datos
 */
function ctlPeliCerrar() {
    session_destroy();
    modeloPeliDB::closeDB();
    header('Location:index.php');
}

function ctlTotalPeliculas() {

    $peliculas_totales = ModeloPeliDB::totalPeliculas();
    return $peliculas_totales;

}

/*
 * Muestro la tabla con los usuario 
 */
function ctlPeliVerPelis($offset, $limit) {
    // Obtengo los datos del modelo
    $peliculas = ModeloPeliDB::GetAllPaginadas($offset, $limit);
    // Invoco la vista 
    include_once 'plantilla/verpeliculas.php';
}

function ctlPeliVerPelisEstandar($offset, $limit) {
    // Obtengo los datos del modelo
    $peliculas = ModeloPeliDB::GetAllPaginadas($offset, $limit);
    // Invoco la vista 
    include_once 'plantilla/verpeliculasEstandar.php';
}

function ctlPeliVerPelisInvitado($offset, $limit) {
    // Obtengo los datos del modelo
    $peliculas = ModeloPeliDB::GetAllPaginadas($offset, $limit);
    // Invoco la vista 
    include_once 'plantilla/verpeliculasInvitado.php';
}

//Funciones de limpieza

//Trata el elemento enviado
function limpiarCadena(string $entrada):string{
    $salida = trim($entrada); // Elimina espacios antes y después de los datos
    $salida = stripslashes($salida); // Elimina backslashes \
    $salida = htmlspecialchars($salida); // Traduce caracteres especiales en entidades HTML
    return $salida;
}

//Trata todos los elementos de un array
function limpiarArray(array &$entrada){
    
    foreach ($entrada as $key => $value ) { //Limpia cada elemento del array por individual
        $entrada[$key] = limpiarCadena($value);
    }
}