<?php

include_once 'config.php';
include_once 'Pelicula.php';

class ModeloPeliDB {

    private static $dbh = null;
    private static $consulta_peli = "Select * from peliculas where codigo_pelicula = :codigo";

    private static $borrar_peli = "Delete from peliculas where codigo_pelicula = :codigo";
    private static $nueva_peli = "Insert into peliculas (nombre,director,genero,imagen,
                                    trailer,enlace)" . " VALUES (?,?,?,?,?,?)";
    /*private static $modifica_peli = "UPDATE peliculas set nombre = ?, director = ?, " .
                                     "genero = ?, imagen = ? where codigo_pelicula = :codigo_pelicula";*/
    private static $modifica_peli = "UPDATE peliculas set nombre = :nombre, director = :director, 
                                    genero = :genero, imagen = :imagen, trailer = :trailer, enlace = :enlace
                                    where codigo_pelicula = :codigo_pelicula";
    private static $cambiar_nulos = "UPDATE peliculas SET puntuacion = 0, num_puntuacion = 0, 
                                    puntuacion_total = 0 WHERE puntuacion IS NULL AND num_puntuacion 
                                    IS NULL AND puntuacion_total IS NULL";

    public static function init() {

        if (self::$dbh == null) {
            try {
                // Cambiar  los valores de las constantes en config.php
                $dsn = "mysql:host=" . DBSERVER . ";dbname=" . DBNAME . ";charset=utf8";
                self::$dbh = new PDO($dsn, DBUSER, DBPASSWORD);
                // Si se produce un error se genera una excepción;
                self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Error de conexión " . $e->getMessage();
                exit();
            }
        }
    }


    // Borrar un usuario (boolean)
    //Borrar una peli
    public static function PeliDel ($codigo) {
        $stmt = self::$dbh->prepare(self::$borrar_peli);
        $stmt->bindValue(':codigo', $codigo);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            //include 'index.php';
            return true;
        }
        return false;
    }

    //Añadir nueva peli
    public static function PeliAdd ($datos): bool {

        $stmt = self::$dbh->prepare(self::$nueva_peli);
        $stmt->bindValue(1, $datos[0]);
        $stmt->bindValue(2, $datos[1]);
        $stmt->bindValue(3, $datos[2]);
        $stmt->bindValue(4, $datos[3]);
        $stmt->bindValue(5, $datos[4]);
        $stmt->bindValue(6, $datos[5]);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /*Creo una función que cambia los valores nulos a 0, para que no haya problemas a la hora de puntuar
    una nueva película al operar con sus funciones */
    public static function cambiarNulos () {

        $stmt = self::$dbh->prepare(self::$cambiar_nulos);

        if ($stmt->execute()) {

            return true;
        }
        return false;

    }

    //Actualizar peli
    public static function PeliUpdate ($codigo, $datos) {

        $stmt = self::$dbh->prepare(self::$modifica_peli);
        $stmt->bindValue(':codigo_pelicula', $codigo);
        $stmt->bindValue(':nombre', $datos[0]);
        $stmt->bindValue(':director', $datos[1]);
        $stmt->bindValue(':genero', $datos[2]);
        $stmt->bindValue(':imagen', $datos[3]);
        $stmt->bindValue(':trailer', $datos[4]);
        $stmt->bindValue(':enlace', $datos[5]);

        if ($stmt->execute()) {

            return true;
        }
        return false;
    }

    public static function NumPuntuaciones ($codigo) {

        if (!isset($_COOKIE[$codigo])) {
            $stmt = self::$dbh->prepare("UPDATE peliculas SET num_puntuacion = num_puntuacion + 1 WHERE 
            codigo_pelicula = :codigo_pelicula");
            $stmt->bindValue(':codigo_pelicula', $codigo);
            if ($stmt->execute()) {
                return true;
            }
            return false;
        } else {

            return false;
        }

    }

    public static function PuntuacionTotal ($codigo, $puntuacion) {

        if (!isset($_COOKIE[$codigo])) {

            if ($puntuacion >= 0 && $puntuacion <= 10) {

                $stmt = self::$dbh->prepare("UPDATE peliculas SET puntuacion_total = puntuacion_total + " . $puntuacion . "
                WHERE codigo_pelicula = :codigo_pelicula");
                $stmt->bindValue(':codigo_pelicula', $codigo);

                if ($stmt->execute()) {
                    return true;
                }
            } else {

                $stmt = self::$dbh->prepare("UPDATE peliculas SET num_puntuacion = num_puntuacion - 1 WHERE 
                codigo_pelicula = :codigo_pelicula");
                $stmt->bindValue(':codigo_pelicula', $codigo);
                $stmt->execute();

            }

        } return false;

    }

    //Guardar y procesar puntuación
    public static function PeliPuntua ($codigo, $puntuacionTotal, $numpuntuaciones) {

        //Creo la cookie con el código de la película a puntuar, si no existe, y ejecuto la consulta
        if (!isset($_COOKIE[$codigo])) {

            setcookie($codigo, 0, time() + 3600 * 24);
            $stmt = self::$dbh->prepare("UPDATE peliculas SET puntuacion = " . $puntuacionTotal . "
            /" . $numpuntuaciones . "WHERE codigo_pelicula = :codigo_pelicula");
            $stmt->bindValue(':codigo_pelicula', $codigo);

            if ($stmt->execute()) {

                $valor = $_SESSION['num_votaciones'];
                $valor++;
                $_SESSION['num_votaciones'] = $valor;
                setcookie('votaciones', $valor, time() + 3600 * 24);
                return true;

            }

        } return false;

    }

    public static function totalPeliculas () {

        $stmt = self::$dbh->prepare("SELECT COUNT(*) FROM peliculas");
        $stmt->execute();
        $pelisTotales = $stmt->fetchColumn();

        return $pelisTotales;

    }

    // Tabla de objetos con todas las peliculas
    public static function GetAll(): array {
        // Genero los datos para la vista que no muestra la contraseña

        $stmt = self::$dbh->query("select * from peliculas");

        $tpelis = [];
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
        while ($peli = $stmt->fetch()) {
            $tpelis[] = $peli;
        }
        return $tpelis;
    }

    //Tabla de objetos para paginación
    public static function GetAllPaginadas($offset, $limit): array {
        
        $stmt = self::$dbh->prepare("SELECT * FROM peliculas LIMIT " . $limit . " OFFSET " . $offset);
        $stmt->execute();
        $tpelis = [];
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
            while ($peli = $stmt->fetch()) {
                $tpelis[] = $peli;
            }
        
        return $tpelis;

    }

    // Datos de una película para visualizar
    public static function GetOne ($codigo) {
        //$datosuser = [];
        $stmt = self::$dbh->prepare(self::$consulta_peli);
        $stmt->bindValue(':codigo', $codigo);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            // Obtengo un objeto de tipo Pelicula, pero devuelvo una tabla
            // Para no tener que modificar el controlador
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
            $pelicula = $stmt->fetch();
        }
        return $pelicula;
    }

    public static function getTitulo ($busqueda) {

        $stmt = self::$dbh->prepare("Select * from peliculas where nombre like ?");
        $stmt->bindValue(1, "%" . $busqueda . "%");
        $stmt->execute();
        $pelis = [];
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');

        while( $pelicula = $stmt->fetch() ) {

            $pelis[] = $pelicula;

        }

        return $pelis;

    }

    public static function getDirector ($busqueda) {

        $stmt = self::$dbh->prepare("Select * from peliculas where director like ?");
        $stmt->bindValue(1, "%" . $busqueda . "%");
        $stmt->execute();
        $pelis = [];
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
        
        while( $pelicula = $stmt->fetch() ) {

            $pelis[] = $pelicula;

        }

        return $pelis;

    }

    public static function getGenero ($busqueda) {

        $stmt = self::$dbh->prepare("Select * from peliculas where genero like ?");
        $stmt->bindValue(1, "%" . $busqueda . "%");
        $stmt->execute();
        $pelis = [];
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
        
        while( $pelicula = $stmt->fetch() ) {

            $pelis[] = $pelicula;

        }

        return $pelis;

    }

    public static function closeDB() {
        self::$dbh = null;
    }
}