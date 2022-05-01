<?php

ob_start();
?>
<h2> Detalles </h2>
<table>
<tr><td>Código de película:  </td><td> <?= $pelicula->codigo_pelicula ?></td></tr>
<tr><td>Nombre:   </td><td>   <?= $pelicula->nombre ?></td></tr>
<tr><td>Director:  </td><td>     <?= $pelicula->director ?></td></tr>
<tr><td>Género:    </td><td>    <?= $pelicula->genero  ?></td></tr>
<tr><td>Cartel:  </td><td><img src=" <?= "../img/" . $pelicula->imagen ?> " height="300px"></td></tr>
</table><br>
<input type="button" value=" Volver " size="10" onclick="javascript:window.location='index.php'" >
<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido

$contenido = ob_get_clean();
include_once "principal.php";

?>