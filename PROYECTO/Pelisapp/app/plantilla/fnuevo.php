<?php

// Guardo la salida en un buffer (en memoria)
// No se envia al navegador
ob_start();
?>
<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<form name='ALTA' method="POST" action="index.php?orden=Alta" enctype="multipart/form-data"> <br>
NOMBRE: 		 <input type="text" name="nombre"><br>
DIRECTOR: 		 <input type="text" id="director" name="director"><br>
GÉNERO: 		 <input type="text" id="genero" name="genero"><br>
IMAGEN: 		 <input type="file" name="imagen"><br> <br>
TRÁILER:		 <input type="text" name="trailer"><br>
ENLACE:			 <input type="text" name="enlace"><br>
	<input type="submit" value="Almacenar">
	<input type="cancel" value="Cancelar" size="10" onclick="javascript:window.location='index.php'" >
</form>
<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "principal.php";

?>