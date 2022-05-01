<?php

// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
?>
<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<form name='ALTA' method="POST" action="index.php?orden=Modificar">
CÓDIGO : <input type="text" name="codigo" readonly value="<?= $_GET['codigo']; //$pelicula->codigo_pelicula ?>"> <br>
NOMBRE     : <input type="text" name="nombre" value="<?= $pelicula->nombre ?>"><br>
DIRECTOR: 		 <input type="text" id="director" name="director" value="<?= $pelicula->director ?>"><br>
GÉNERO: 		 <input type="text" id="genero" name="genero" value="<?= $pelicula->genero ?>"><br>
IMAGEN: 		 <input type="file"    name="imagen" value="<?= $pelicula->imagen ?>" > <br> <br>
	<input type="submit" value=" Guardar ">
	<input type="cancel" value="Cancelar" size="10" onclick="javascript:window.location='index.php'" >
</form>
<?php
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido

$contenido = ob_get_clean();
include_once "principal.php";

?>