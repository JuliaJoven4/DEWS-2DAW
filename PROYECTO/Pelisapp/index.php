<?php

include_once 'app/Usuario.php';
session_start();
include_once 'app/config.php';
include_once 'app/controlerPeli.php';
include_once 'app/modeloPeliDB.php';
include_once 'app/controlerUsuario.php';
include_once 'app/modeloUsuarioDB.php';

// Inicializo los modelos
ModeloPeliDB::init();
modeloUsuarioDB::init();

//Definimos las variables a tener en cuenta para la paginación
$pelisPorPagina = 10;
$pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$offset = ($pagina_actual-1) * $pelisPorPagina;
$limit = $pelisPorPagina;

if (isset($_SESSION['usuario'])) {

    if (is_object($_SESSION['usuario'])) {

        /*Creamos una variable de sesión que almacene el número de veces que el mismo usuario ha votado,
        para que esta pueda utilizarse fuera del index */

        if (!isset($_SESSION['num_votaciones'])) {

            $_SESSION['num_votaciones'] = 0;
        
        }
        
        /*Si no existe, se crea la cookie con 0 como valor, que va a aumentar cuando ese mismo usuario vote por 
        una película. Si llega a 5, el usuario no podrá votar más hasta que pasen 24 horas */
        
        if (!isset($_COOKIE['votaciones'])) {

            /*Si no existe la cookie porque no se ha creado antes o se acabó su tiempo y se destruyó, 
            ponemos el valor de la sesión que guarda el número de votaciones a 0 */
            $_SESSION['num_votaciones'] = 0;
        
            setcookie('votaciones', $_SESSION['num_votaciones'], time() + 3600 * 24);
            //Duración de 24 horas
                        
        } 

        if ($_SESSION['usuario']->rol == 'administrador') {

            rutaAdmin($offset, $limit);
        
        }  else {
        
            rutaEstandar($offset, $limit);       
        
        }

    } else if ($_SESSION['usuario'] == 'invitado') {

        rutaInvitado($offset, $limit);

    }

} else {

    if (!empty ($_POST['usuario']) && !empty ($_POST['clave'])) {

        $usuarios = ctlDatosUsuarios();
        $_POST['usuario'] = limpiarCadena($_POST['usuario']);
        $_POST['clave'] = limpiarCadena($_POST['clave']);
    
        foreach ($usuarios as $user) {
    
            if ($user->nombre == $_POST['usuario'] && $user->clave == $_POST['clave']) {
    
                /*Si el usuario y la clave coinciden con un usuario registrado en la BDD, se crea la sesión que
                almacena sus credenciales. */

                $_SESSION['usuario'] = $user;

                header("Location: index.php");
    
            } else {

                $msg = "ERROR: Usuario o contraseña incorrectos.";
                include_once 'app/plantilla/formAcceso.php';

            }
    
        }
    
    } else if (isset($_POST['invitado'])) {

        $_SESSION['usuario'] = 'invitado';
        header("Location: index.php");

    } else {

        include_once 'app/plantilla/formAcceso.php';

    }

}

function rutaInvitado ($offset, $limit) {

    $rutasPelis = [
        "Inicio"      => "ctlPeliInicio",
        "Detalles"    => "ctlPeliDetalles",
        //Añadimos la orden correspondiente a puntuar
        "Cerrar"      => "ctlPeliCerrar",
        "VerPelis"    => "ctlPeliVerPelisInvitado",
        "DescargarJSON"  => "ctlDescargarJSON",
        "btitulo" => "ctlBuscarTituloInvitado",
        "bdirector" => "ctlBuscarDirectorInvitado",
        "bgenero" => "ctlBuscarGeneroInvitado",
        //Añadimos la orden correspondiente a cerrar sesión
        "CerrarSesion" => "ctlCerrarSesion",
        //Añadimos la orden correspondiente a descargar PDF
        "DescargarPDF" => "ctlDescargarPDF"
        
    ];

    // Evito inyección html enviando todos los datos recibidos por GET y POST a las funciones de limpieza
    limpiarArray($_POST);
    limpiarArray($_GET);

    if (isset($_GET['orden'])) {
        // La orden tiene una funcion asociada 
        if (isset($rutasPelis[$_GET['orden']])) {
            $procRuta = $rutasPelis[$_GET['orden']];
        } else {
            // Error no existe función para la ruta
            header('Status: 404 Not Found');
            echo '<html><body><h1>Error 404: No existe la ruta <i>' .
                $_GET['ctl'] .
                '</p></body></html>';
            exit;
        }
    } else {
        $procRuta = "ctlPeliVerPelisInvitado";
    }
    
    // Llamo a la función seleccionada
    return $procRuta($offset, $limit);

}

function rutaEstandar ($offset, $limit) {

    $rutasPelis = [
        "Inicio"      => "ctlPeliInicio",
        "Detalles"    => "ctlPeliDetalles",
        //Añadimos la orden correspondiente a puntuar
        "Puntuar" => "ctlPeliPuntuarEstandar",
        "Cerrar"      => "ctlPeliCerrar",
        "VerPelis"    => "ctlPeliVerPelisEstandar",
        "DescargarJSON"  => "ctlDescargarJSON",
        "btitulo" => "ctlBuscarTituloEstandar",
        "bdirector" => "ctlBuscarDirectorEstandar",
        "bgenero" => "ctlBuscarGeneroEstandar",
        //Añadimos la orden correspondiente a cerrar sesión
        "CerrarSesion" => "ctlCerrarSesion",
        //Añadimos la orden correspondiente a descargar PDF
        "DescargarPDF" => "ctlDescargarPDF"
        
    ];

    limpiarArray($_POST);
    limpiarArray($_GET);

    if (isset($_GET['orden'])) {
        // La orden tiene una funcion asociada 
        if (isset($rutasPelis[$_GET['orden']])) {
            $procRuta = $rutasPelis[$_GET['orden']];
        } else {
            // Error no existe función para la ruta
            header('Status: 404 Not Found');
            echo '<html><body><h1>Error 404: No existe la ruta <i>' .
                $_GET['ctl'] .
                '</p></body></html>';
            exit;
        }
    } else {
        $procRuta = "ctlPeliVerPelisEstandar";
    }
    
    // Llamo a la función seleccionada
    return $procRuta($offset, $limit);

}

function rutaAdmin ($offset, $limit) {

    // Enrutamiento
    // Relación entre peticiones y función que la va a tratar
    // Versión sin POO no manejo de Clases ni objetos
    // Rutas en MODO PELICULAS
    $rutasPelis = [
        "Inicio"      => "ctlPeliInicio",
        "Alta"        => "ctlPeliAlta",
        "Detalles"    => "ctlPeliDetalles",
        "Modificar"   => "ctlPeliModificar",
        "Borrar"      => "ctlPeliBorrar",
        //Añadimos la orden correspondiente a puntuar
        "Puntuar" => "ctlPeliPuntuar",
        "Cerrar"      => "ctlPeliCerrar",
        "VerPelis"    => "ctlPeliVerPelis",
        "DescargarJSON"  => "ctlDescargarJSON",
        "btitulo" => "ctlBuscarTitulo",
        "bdirector" => "ctlBuscarDirector",
        "bgenero" => "ctlBuscarGenero",
        //Añadimos la orden correspondiente a cerrar sesión
        "CerrarSesion" => "ctlCerrarSesion",
        //Añadimos la orden correspondiente a descargar PDF
        "DescargarPDF" => "ctlDescargarPDF"
        
    ];

    limpiarArray($_POST);
    limpiarArray($_GET);

    if (isset($_GET['orden'])) {
        // La orden tiene una funcion asociada 
        if (isset($rutasPelis[$_GET['orden']])) {
            $procRuta = $rutasPelis[$_GET['orden']];
        } else {
            // Error no existe función para la ruta
            header('Status: 404 Not Found');
            echo '<html><body><h1>Error 404: No existe la ruta <i>' .
                $_GET['ctl'] .
                '</p></body></html>';
            exit;
        }
    } else {
        $procRuta = "ctlPeliVerPelis";
    }
    
    // Llamo a la función seleccionada
    return $procRuta($offset, $limit);

}