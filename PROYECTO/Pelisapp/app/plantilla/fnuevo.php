<?php

// Guardo la salida en un buffer (en memoria)
// No se envia al navegador
ob_start();
?>
<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<form name='ALTA' method="POST" action="index.php?orden=Alta" enctype="multipart/form-data"> <br>
NOMBRE: 		 <input type="text" name="nombre" value="<?php //$pelicula->nombre ?>"><br>
DIRECTOR: 		 <input type="text" id="director" name="director" value="<?php //$pelicula->director ?>"><br>
GÉNERO: 		 <input type="text" id="genero" name="genero" value="<?php //$pelicula->genero ?>"><br>
IMAGEN: 		 <input type="file"    name="imagen" value="<?php //$pelicula->imagen ?>" ><br>

<!-- Estado <select name="estado">
	<option value="A" selected="selected" >Activo</option>
	<option value="B"                     >Bloqueado</option>
	<option value="I"                     >Inactivo</option>  
</select>
Plan <select name="plan">
	<option value="0" selected="selected">Básico</option>
	<option value="1" >Profesional</option>
	<option value="2" >Premium</option>
    <option value="3" >Máster</option>
</select> --> <br>
	<input type="submit" value="Almacenar">
	<input type="cancel" value="Cancelar" size="10" onclick="javascript:window.location='index.php'" >
</form>
<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "principal.php";

?>