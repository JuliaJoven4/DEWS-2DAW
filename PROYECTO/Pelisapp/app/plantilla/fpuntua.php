<?php

// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
?>
<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>

<?php if ($_COOKIE['votaciones'] >= 5): ?>

	<h3>Ya se han realizado cinco votaciones en el día de hoy. Inténtelo de nuevo más tarde.</h3>
	<input type="cancel" value="Volver" size="10" onclick="javascript:window.location='index.php'" >

<?php else: ?>	

<table>
<form name='ALTA' method="POST" action="index.php?orden=Puntuar">
	<tr>
		<td>CÓDIGO: </td>
		<td><input type="text" name="codigo" readonly value="<?= $_GET['codigo']; ?>"> </td>
	</tr>
	<tr>
		<td>NOMBRE: </td>
		<td> <?= $pelicula->nombre ?> </td>
	</tr>
	<tr>
		<td>DIRECTOR: </td>
		<td> <?= $pelicula->director ?> </td>
	</tr>
	<tr>
		<td>GÉNERO: </td>
		<td> <?= $pelicula->genero ?> </td>
	</tr>
	<?php if($pelicula->imagen != null): ?>
	<tr>
		<td>CARTEL:  </td>
		<td><img src="<?='app/img/' . $pelicula->imagen ?>" height="300px" alt="Imagen no disponible"></td>
	</tr>

	<?php endif; ?>
	</tr>
	<?php if ($pelicula->trailer != null): ?>
    	<tr><td>TRÁILER: </td><td> <iframe width="560" height="315" src="<?= $pelicula->trailer ?>" title="YouTube video player" 
            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen></iframe> </td>
	<?php endif; ?>
	</tr>
	<tr>
		<td>ENLACE: </td>
        <td><a href="<?= $pelicula->enlace ?>"> Enlace a la plataforma de streaming </a></td>
	</tr>
    <tr>
        <td>PUNTUACIÓN ACTUAL: </td>
        <?php if ($pelicula->num_puntuacion != 0): ?>
    		<td> <?= $pelicula->puntuacion ?> (<?= $pelicula->num_puntuacion ?> valoraciones) </td>
	</tr>
		<?php else: ?>
    		<td>Aún nadie ha puntuado esta película.</td>
	</tr>
		<?php endif; ?>
    <tr>
        <td>Introduzca su puntuación: </td>
        <td>
            <input type="number" name="puntuacionUsu">
        </td>
    </tr>
	<tr>
		<td colspan="2"> <input type="submit" value="Enviar">
			<input type="cancel" value="Cancelar" size="10" onclick="javascript:window.location='index.php'" >
		</td>
	</tr>
</form>
</table>

<?php endif; ?>

<?php
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido

$contenido = ob_get_clean();
include_once "principal.php";

?>