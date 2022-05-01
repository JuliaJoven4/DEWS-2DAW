<?php

include_once 'config.php';
include_once 'Pelicula.php';

class ModeloPeliDB {

    private static $dbh = null; 
    private static $consulta_peli = "Select * from peliculas where codigo_pelicula = :codigo";

    private static $borrar_peli = "Delete from peliculas where codigo_pelicula = :codigo"; 
    private static $nueva_peli = "Insert into peliculas (nombre,director,genero,imagen)".
                                    " VALUES (?,?,?,?)";
    private static $modifica_peli = "UPDATE peliculas set nombre = ?, director = ?, " .
                                     "genero = ?, imagen = ? where codigo_pelicula = :codigo";
    /*private static $modifica_peli = "UPDATE peliculas set nombre = :nombre, director = :director, 
                                    genero = :genero, imagen = :imagen where codigo_pelicula = :codigo";*/
     
public static function init(){
   
    if (self::$dbh == null){
        try {
            // Cambiar  los valores de las constantes en config.php
            $dsn = "mysql:host=" . DBSERVER . ";dbname=" . DBNAME . ";charset=utf8";
            self::$dbh = new PDO($dsn,DBUSER,DBPASSWORD);
            // Si se produce un error se genera una excepción;
            self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo "Error de conexión " . $e->getMessage();
            exit();
        }
        
    }
    
}


// Borrar un usuario (boolean)
//Borrar una peli
public static function PeliDel ($codigo){
    $stmt = self::$dbh->prepare(self::$borrar_peli);
    $stmt->bindValue(':codigo', $codigo);
    $stmt->execute();
    if ($stmt->rowCount() > 0 ) {
        //include 'index.php';
        return true;
    }
    return false;
}

//Añadir nueva peli
public static function PeliAdd ($datos):bool {

    $stmt = self::$dbh->prepare(self::$nueva_peli);
    $stmt->bindValue(1, $datos[0]);
    $stmt->bindValue(2, $datos[1]);
    $stmt->bindValue(3, $datos[2]);
    $stmt->bindValue(4, $datos[3]);

    $destino = '../img/';
    $archivo = $destino . basename($_FILES["imagen"]["name"]);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $archivo);

    if ($stmt->execute()){
        return true;
    }
    return false; 

}

// Actualizar un nuevo usuario (boolean)
// GUARDAR LA CLAVE CIFRADA
/*
public static function UserUpdate ($userid, $userdat){
    $clave = $userdat[0];
    // Si no tiene valor la cambio
    if ($clave == ""){ 
        $stmt = self::$dbh->prepare(self::$modifica_peli);
        $stmt->bindValue(1,$userdat[1] );
        $stmt->bindValue(2,$userdat[2] );
        $stmt->bindValue(3,$userdat[3] );
        $stmt->bindValue(4,$userdat[4] );
        $stmt->bindValue(5,$userid);
        if ($stmt->execute ()){
            return true;
        }
    } else {
        $clave = Cifrador::cifrar($clave);
        $stmt = self::$dbh->prepare(self::$modifica_peli);
        $stmt->bindValue(1,$clave );
        $stmt->bindValue(2,$userdat[1] );
        $stmt->bindValue(3,$userdat[2] );
        $stmt->bindValue(4,$userdat[3] );
        $stmt->bindValue(5,$userdat[4] );
        $stmt->bindValue(6,$userid);
        if ($stmt->execute ()){
            return true;
        }
    }
    return false; 
}*/

//Actualizar peli
public static function PeliUpdate ($codigo, $datos) {

    $stmt = self::$dbh->prepare(self::$modifica_peli);
    $stmt->bindValue(1, $datos[0]);
    $stmt->bindValue(2, $datos[1]);
    $stmt->bindValue(3, $datos[2]);
    $stmt->bindValue(4, $datos[3]);
    $stmt->bindValue(':codigo', $codigo);
    $stmt->execute();

    if ($stmt->rowCount() > 0 ) {
        //include 'index.php';
        return true;
    }
    return false;

}

/*public static function PeliUpdate ($datos) {

    $stmt = self::$dbh->prepare(self::$modifica_peli);
    $stmt->bindValue(':nombre', $datos[0]);
    $stmt->bindValue(':director', $datos[1]);
    $stmt->bindValue(':genero', $datos[2]);
    $stmt->bindValue(':imagen', $datos[3]);
    $stmt->execute();

    if ($stmt->rowCount() > 0 ) {
        //include 'index.php';
        return true;
    }
    return false;

}*/

// Tabla de objetos con todas las peliculas
public static function GetAll ():array{
    // Genero los datos para la vista que no muestra la contraseña
    
    $stmt = self::$dbh->query("select * from peliculas");
    
    $tpelis = [];
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
    while ( $peli = $stmt->fetch()){
        $tpelis[] = $peli;       
    }
    return $tpelis;
}

// Datos de una película para visualizar
public static function GetOne ($codigo) {
    $datosuser = [];
    $stmt = self::$dbh->prepare(self::$consulta_peli);
    $stmt->bindValue(':codigo',$codigo);
    $stmt->execute();
    if ($stmt->rowCount() > 0 ){
        // Obtengo un objeto de tipo Pelicula, pero devuelvo una tabla
        // Para no tener que modificar el controlador
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
        $pelicula = $stmt->fetch();
    }
    return $pelicula;

}

public static function closeDB(){
    self::$dbh = null;
}

} // class
