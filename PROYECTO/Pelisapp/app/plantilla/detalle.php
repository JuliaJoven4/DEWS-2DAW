<?php

ob_start();
?>
<h2> Detalles </h2>
<table>
<tr><td>CÓDIGO DE PELÍCULA:  </td><td> <?= $pelicula->codigo_pelicula ?></td></tr>
<tr><td>NOMBRE:   </td><td>   <?= $pelicula->nombre ?></td></tr>
<tr><td>DIRECTOR:  </td><td>     <?= $pelicula->director ?></td></tr>
<tr><td>GÉNERO:    </td><td>    <?= $pelicula->genero  ?></td></tr>

<?php if($pelicula->imagen != null): ?>

<tr><td>CARTEL:  </td><td><img src="<?='app/img/' . $pelicula->imagen ?>" height="300px" alt="Imagen no disponible"></td></tr>

<?php endif; ?>

<tr><td>PUNTUACIÓN: </td>

<?php if ($pelicula->num_puntuacion != 0): ?>
 	<td> <?= $pelicula->puntuacion ?> (<?= $pelicula->num_puntuacion ?> valoraciones) </td></tr>
<?php else: ?>
    <td>Aún nadie ha puntuado esta película.</td></tr>
<?php endif;
if ($pelicula->trailer != null): ?>
    <tr><td>Trailer: </td><td> <iframe width="560" height="315" src="<?= $pelicula->trailer ?>" title="YouTube video player" 
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen></iframe> </td></tr>
<?php endif;
if ($pelicula->enlace != null): ?>
    <tr><td>Enlace de visualización: </td><td><a href="<?= $pelicula->enlace ?>" target="_blank"> Enlace a la plataforma de streaming </a></td></tr>
<?php endif; ?>

</table><br>
<input type="button" value=" Volver " size="10" onclick="javascript:window.location='index.php'" >
<a href="index.php?orden=DescargarPDF&codigo=<?= $pelicula->codigo_pelicula ?>"><button>Descargar PDF</button></a>
<?php

// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "principal.php";

?>