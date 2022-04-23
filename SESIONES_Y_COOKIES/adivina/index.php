<?php

session_start();

if (isset ($_GET['accion']) && $_GET['accion']=="Reiniciar"){
    session_destroy();
    header("Location: index.php");
}
$tcartas = [
  ["valor"=>1,"oculto"=>true],
  ["valor"=>2,"oculto"=>true],
  ["valor"=>3,"oculto"=>true],
  ["valor"=>4,"oculto"=>true],
  ["valor"=>5,"oculto"=>true],
  ["valor"=>6,"oculto"=>true],
  ["valor"=>7,"oculto"=>true],
  ["valor"=>8,"oculto"=>true],
  ["valor"=>9,"oculto"=>true],
  ["valor"=>10,"oculto"=>true],
  ["valor"=>1,"oculto"=>true],
  ["valor"=>2,"oculto"=>true],
  ["valor"=>3,"oculto"=>true],
  ["valor"=>4,"oculto"=>true],
  ["valor"=>5,"oculto"=>true],
  ["valor"=>6,"oculto"=>true],
  ["valor"=>7,"oculto"=>true],
  ["valor"=>8,"oculto"=>true],
  ["valor"=>9,"oculto"=>true],
  ["valor"=>10,"oculto"=>true],
];

if (isset($_SESSION['tcartas'])) {

  $tcartas = $_SESSION['tcartas'];

/*Si no existe una sesión (se empieza una partida nueva), se barajan las cartas y se cambian sus
posiciones */
} else {

  shuffle($tcartas);
  $_SESSION['tcartas'] = $tcartas;

}



/*
 * FUNCIONES AUXILIARES
 */

function vercartas() {

  if (isset($_GET['cartapulsada'])) {

    /*Si no existe, se crea la sesión 'fecha_inicio', que almacenará la fecha en la que se empezó la
    partida (en el momento en el que se pulse la primera carta) */
    if (!isset($_SESSION['fecha_inicio'])) {
      
      /*Almacenamos los segundos que han transcurrido desde el 1 de enero de 1970 con la función 'time',
      que nos va a servir para operar con la diferencia de segundos desde que empieza hasta que acaba
      la partida */
      $_SESSION['fecha_inicio'] = time();

    }

    /*Si no existe, se crea la sesión 'num_parejas', que almacenará el número de parejas que va acertando
    el usuario */
    if (!isset($_SESSION['num_parejas'])) {

      $_SESSION['num_parejas'] = 0;

    }

    pulsadas();
  
  }
  
    //Se almacena el valor de la sesión en la variable 'tabla' para que sea más cómodo usarlo
    $tabla = $_SESSION['tcartas'];

    //Se almacena el contenido del formulario en la variable 'resu'
    $resu = "<table><tbody><tr>";
    
    /* Para identificar las cartas, se le da una posición diferente a cada una
    (como podemos ver en la tabla inicial, hay 20 diferentes) */
    for ($i=0; $i<20; $i++) {

      //Se ordenan las cartas de 5 en 5
       if ($i %5 == 0) $resu .= "</tr><tr>";

      /*Se crea el botón correspondiente a cada carta, con el valor de su posición, que se va 
      generando en el ciclo for en el que estamos a través de i, y se le da el nombre de 
      'cartapulsada'
      El botón se crea añadiendo o quitando la palabra "disabled" en función de si la carta está
      oculta o no. */

       /*Si la carta en esa posición está oculta, se imprime la imagen vacía */
       if ( $tabla[$i]['oculto'] ){
        $resu .= " <td><button name='cartapulsada' " . " value=$i>";
        $resu .= "  <img src='cartas/vacio.svg'  height='150'> ";

       /*Si no, se imprime la imagen con el número correspondiente al valor de la carta que se
       encuentra en esa posición */
       } else {
       $resu .= " <td><button name='cartapulsada' disabled value=$i>"; 
       $resu .= " <img src='cartas/c".$tabla[$i]['valor'] .".svg' height='150'> ";
       }

       $resu .= "</button></td>";
    }
    $resu .= "</tr></tbody></table>";
    return $resu;
}

function pulsadas () {

  /*Se comprueba que existen las dos cartas antes de nada para que, si hemos fallado, al pulsar una
  tercera vez se den la vuelta las cartas correspondientes */
  if (isset($_SESSION['primera']) && isset($_SESSION['segunda'])) {

    comprobarFallo();

  }

  //Si no hay una primera carta pulsada
  if (!isset($_SESSION['primera'])) {

    //Se almacena en la sesión 'primera'
    $_SESSION['primera'] = $_GET['cartapulsada'];

    //Se le da la vuelta a esa carta
    $_SESSION['tcartas'][$_SESSION['primera']]['oculto'] = false;

    //Si ya existe
  } else {

    //Se comprueba que no existe la segunda carta pulsada
    if (!isset($_SESSION['segunda'])) {

      //Se almacena en la sesión 'segunda'
      $_SESSION['segunda'] = $_GET['cartapulsada'];

      //Se le da la vuelta a esa carta
      $_SESSION['tcartas'][$_SESSION['segunda']]['oculto'] = false;

      /*Se comprueba el acierto, para que la variable de sesión que almacena el número de parejas que
      hemos acertado se actualice nada más llegue la petición y nos avise inmediatamente de cuántas
      parejas tenemos y cuántas nos faltan por acertar */

      comprobarAcierto();

    }
    
  }

}

function comprobarFallo () {

  if ($_SESSION['tcartas'][$_SESSION['primera']]['valor'] !=
      $_SESSION['tcartas'][$_SESSION['segunda']]['valor']) {

        $_SESSION['tcartas'][$_SESSION['primera']]['oculto'] = true;
        $_SESSION['tcartas'][$_SESSION['segunda']]['oculto'] = true;
        unset($_SESSION['primera']);
        unset($_SESSION['segunda']);

      }

}

function comprobarAcierto () {

  if ($_SESSION['tcartas'][$_SESSION['primera']]['valor'] ==
      $_SESSION['tcartas'][$_SESSION['segunda']]['valor']) {

        unset($_SESSION['primera']);
        unset($_SESSION['segunda']);
        $_SESSION['num_parejas']++;

        if ($_SESSION['num_parejas'] < 10) {

          if ($_SESSION['num_parejas'] < 9) {

            echo "<br>¡ACERTASTE! Llevas " . $_SESSION['num_parejas'] . " parejas encontradas.
            Te faltan " . 10 - $_SESSION['num_parejas'] . " ¡Ánimo! <br>";

          } else {
            
            echo "<br>¡ACERTASTE! Llevas " . $_SESSION['num_parejas'] . " parejas encontradas.
            Te falta " . 10 - $_SESSION['num_parejas'] . " ¡Ánimo! <br>";

          }         

        } else {

          /*Cuando el usuario gana es cuando tenemos que darle uso a la variable de sesión que guarda
          la fecha de inicio de la partida, para guardar la diferencia en segundos en una cookie, si
          esta no existe, y comprobar si los segundos transcurridos en la partida actual son menores
          que los guardados anteriormente, si esta existe, y sustituir su valor por el nuevo. */

          record();
          
          echo "<b><h2>¡¡¡FELICIDADES!!! ¡HAS GANADO!</h2></b>";          

        }
  
      }

}

function record () {

  /*Creamos una variable que almacene los segundos que pasan hasta que termina la partida */
  $fecha_terminada = time() - $_SESSION['fecha_inicio'];

  //Ahora comprobamos si la cookie existe
  if (!isset($_COOKIE['record'])) {

    setcookie("record", $fecha_terminada, time()+60*60*24*30); //Duración de un mes

  } else {

    if ($fecha_terminada <= $_COOKIE['record']) {

      setcookie("record", $fecha_terminada, time()+60*60*24*30);

      //Llamamos a la función que nos devuelve una frase con los minutos y segundos que hemos tardado

      echo "<br><h2><b>¡¡¡NUEVO RÉCORD!!!</b></h2> ¡Has tardado " . min_seg($fecha_terminada) . 
      "en terminar la prueba!";

    } else {

      echo "¡Casi! El record actual está en " . min_seg($_COOKIE['record']) . ". Tú has tardado " . 
      min_seg($fecha_terminada) . " ¡Más suerte la próxima vez!";

    }

  }

}

function min_seg($sec) {

  $min = $sec/60;
      $hor = $min/60;

      $s = $sec%60;
      $m = $min%60;
      $h = $hor%24;

      return $m . " minutos y " . $s . " segundos";

}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>
   Buscar Parejas (INICIO)
  </title>
  <style> button { border: none; }</style>
</head>
<body>
<h1>Buscar la pareja</h1>
  <p>Haga clic en un par de cartas para descubrir las parejas.</p>

  <?php

  echo "El récord actual está en " . min_seg($_COOKIE['record']) . ".<br><br>";

  ?>

<form>
<?= vercartas() ?>
<p><input type="submit" name="accion" value="Reiniciar"></p>
</form>
</body>
</html>