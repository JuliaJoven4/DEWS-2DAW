<?php

include_once 'config.php';
include_once 'Usuario.php';

class modeloUsuarioDB {

    public static $dbh = null;
    private static $consulta_usuario = "Select * from usuarios where nombre = :nombre";

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

    // Tabla de objetos con todos los usuarios
    public static function GetAllUsers(): array {

        $stmt = self::$dbh->query("select * from usuarios");

        $tusuarios = [];
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
        while ($usuario = $stmt->fetch()) {
            $tusuarios[] = $usuario;
        }
        return $tusuarios;
    }

    // Datos de un usuario para visualizar
    public static function GetOneUser ($nombre) {
        $stmt = self::$dbh->prepare(self::$consulta_usuario);
        $stmt->bindValue(':codigo', $nombre);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            // Obtengo un objeto de tipo Pelicula, pero devuelvo una tabla
            // Para no tener que modificar el controlador
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
            $usuario = $stmt->fetch();
        }
        return $usuario;
    }

}

?>