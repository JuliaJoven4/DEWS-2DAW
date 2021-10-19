<?php

$destino = "../../MásPHP/imgusers/";
$nombres = $_FILES['ficheros']['name'];
$tamaños = $_FILES['ficheros']['size'];
$tipos = $_FILES['ficheros']['type'];
$ubi_temporales = $_FILES['ficheros']['tmp_name'];
$error = $_FILES['ficheros']['error'];
$es_imagen = true;
$tamaño_total = 0;

foreach ($_FILES['ficheros'] as $clave => $valor) {
print_r ($clave);
echo " --> ";
print_r ($valor);
echo "<br>";
}

if (isset ($_FILES['ficheros'])) {

    //Comprobamos el tipo de error en la subida e imprimimos la explicación.
    tipoError($error);

    //Comprobamos que el número de ficheros introducido no supere el máximo.
    if (count($tamaños) > 3) {
        echo "ERROR: Se ha excedido la cantidad máxima de ficheros.";
    }
    else {

        //Comprobamos si el archivo es una imagen o no.
        for ($i = 0; $i <= count($tipos)-1; $i++) {
            if ( ($tipos[$i] != "image/jpeg") && ($tipos[$i] != "image/png") ) {
                $es_imagen = false;
            }
        }
        if ($es_imagen == false) {
            echo "ERROR: Al menos uno de los archivos no se corresponde con el formato requerido.";
        }
        else {  
        /*Compruebo desde el servidor si el tamaño de todos los archivo es menor o mayor que el 
        límite establecido.
        para ello, recorro todos los archivos y voy sumando su valor. Si llega al máximo
        establecido, saltará un aviso. */
        //Con esta función, determino el tamaño máximo de todos los archivos.
        $tamaño_total = tamañoTotal($tamaños);

            //Controlo que no se superen el tamaño máximo total ni el individual.
            for ($i = 0; $i <= count($tamaños)-1; $i++) {
                if ($tamaño_total <= 300000) {
                        
                    if ($tamaños[$i] <= 200000) {
                        //Mover las imágenes del directorio temporal al de destino.
                        //move_uploaded_file($ubi_temporales[$i], $destino . $nombres[$i]);

                        if (hayNombre($nombres[$i], $destino)) {
                            echo "ERROR: El nombre del archivo ya existe en la carpeta de destino.";
                        }
                        else {
                            subirArchivos($ubi_temporales[$i], $destino, $nombres[$i]);
                        }
                    }
                }
                else {
                    echo "El tamaño de los ficheros supera el límite. <br>";
                    break;
                }
            }
        }
    }
}

function subirArchivos ($ubi, $dest, $nom) {
    move_uploaded_file($ubi, $dest . $nom);
}

function tamañoTotal ($tam) {
    $t_total = 0;
    for ($i = 0; $i <= count($tam)-1; $i++) {
        $t_total += $tam[$i];
    }

    return $t_total;
}

function hayNombre ($nombre, $dest) {
    $ruta = $dest . $nombre;
    if (file_exists($ruta)) {
        return true;
    }
}

function tipoError ($err) {
    for ($i = 0; $i <= count($err)-1; $i++) {
        switch ($err[$i]) {
            case 1:
                echo "ERROR: El tamaño del archivo en la posición " , $i , " excede el admitido por el servidor.<br>";
                break;
            case 2:
                echo "ERROR: El tamaño del archivo en la posición " , $i , " excede el admitido por el cliente.<br>";
                break;
            case 3:
                echo "ERROR: El archivo en la posición " , $i , " no se pudo subir completamente.<br>";
                break;
            case 4:
                echo "ERROR: No se seleccionó ningún archivo para ser subido.<br>";
                break;
            case 6:
                echo "ERROR: No existe un directorio temporal donde subir el archivo en la posición " , $i , ".<br>";
                break;
            case 7:
                echo "ERROR: No se pudo guardar el archivo en la posición " , $i , " en disco.<br>";
                break;
            case  8:
                echo "ERROR: Una extensión PHP evito la subida del archivo en la posición " , $i , ".<br>";
        }
    }
}

?>