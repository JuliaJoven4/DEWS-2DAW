<?php

// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
?>
<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<table>
<form name='ALTA' method="POST" action="index.php?orden=Modificar" enctype="multipart/form-data">
	<tr>
		<td>CÓDIGO: </td> <td><input type="text" name="codigo" readonly value="<?= $_GET['codigo']; ?>"> </td>
	</tr>
	<tr>
		<td>NOMBRE: </td>
		<td> <input type="text" name="nombre" value="<?= $pelicula->nombre ?>"> </td>
	</tr>
	<tr>
		<td>DIRECTOR: </td>
		<td> <input type="text" id="director" name="director" value="<?= $pelicula->director ?>"> </td>
	</tr>
	<tr>
		<td>GÉNERO: </td>
		<td> <input type="text" id="genero" name="genero" value="<?= $pelicula->genero ?>"> </td>
	</tr>
	<tr>
		<td>IMAGEN ACTUAL:</td>
		<?php if($pelicula->imagen != null): ?>
		<td><img src="<?='app/img/' . $pelicula->imagen ?>" height="300px" alt="Imagen no disponible"></td>
		<?php else: ?>
		<td>No hay una imagen para esta película. Pruebe a introducir una.</td>
	</tr>
	<?php endif; ?>
	<tr>
		<td>IMAGEN NUEVA: </td>
		<td> <input type="hidden" name="imagenanterior" value="<?= $pelicula->imagen ?>">
		<input type="file" name="imagen"> </td>
	</tr>
	<tr>
		<td>TRÁILER: </td>
		<td><input type="text" name="trailer" value="<?= $pelicula->trailer ?>"></td>
	</tr>
	<tr>
		<td>ENLACE: </td>
		<td><input type="text" name="enlace" value="<?= $pelicula->enlace ?>"></td>
	</tr>
	<tr>
		<td colspan="2"> <input type="submit" value=" Guardar ">
		<input type="cancel" value="Cancelar" size="10" onclick="javascript:window.location='index.php'" > </td>
	</tr>
</form>
</table>
<?php
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido

$contenido = ob_get_clean();
include_once "principal.php";

?>