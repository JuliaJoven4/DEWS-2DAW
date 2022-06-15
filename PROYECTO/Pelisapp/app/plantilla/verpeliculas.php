<?php
include_once 'app/Pelicula.php';
// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
$auto = $_SERVER['PHP_SELF'];

?>

<form action="index.php" method="GET">
	<input type="text" name="busqueda">
	<button name="orden" value="btitulo"> Buscar por título </button>
	<button name="orden" value="bdirector"> Buscar por director </button>
	<button name="orden" value="bgenero"> Buscar por género </button> <br><br>
</form>

<table>
	<th>Código</th>
	<th>Nombre</th>
	<th>Director</th>
	<th>Genero</th>
	<?php foreach ($peliculas as $peli) : ?>
		<tr>
			<td><?= $peli->codigo_pelicula ?></td>
			<td><?= $peli->nombre ?></td>
			<td><?= $peli->director ?></td>
			<td><?= $peli->genero ?></td>

			<td class="crudBotones"><a href="#" onclick="confirmarBorrar('<?= $peli->nombre . "','" . $peli->codigo_pelicula . "'" ?>);">🗑️ <br> Borrar</a></td>
			<td class="crudBotones"><a href="<?= $auto ?>?orden=Modificar&codigo=<?= $peli->codigo_pelicula ?>">📝 <br>Modificar</a></td>
			<td class="crudBotones"><a href="<?= $auto ?>?orden=Detalles&codigo=<?= $peli->codigo_pelicula ?>">📋 <br> Detalles</a></td>

			<!-- Añadimos un botón para puntuar -->
			<td class="crudBotones"><a href="<?= $auto ?>?orden=Puntuar&codigo=<?= $peli->codigo_pelicula ?>">&#11088; <br> Puntuar</a></td>

		</tr>
	<?php endforeach; ?>
</table>
<br>
<form name='f2' action='index.php'>
	<button name="orden" value="Alta"> Nueva película </button>
	<button name="orden" value="DescargarJSON"> Descargar JSON </button>
	<button name="orden" value="CerrarSesion">Cerrar sesión</button>
</form>
<?php

$pelisPorPagina = 10;
$totalPeliculas = ctlTotalPeliculas();
$totalPaginas = ceil($totalPeliculas / $pelisPorPagina);
$paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

?>

<div id="paginacion">
	<?php if ($paginaActual - 1 > 0): ?> <a class="boton" 
	href="index.php?pagina=<?= $paginaActual-1 ?>">&#60;&#60; Página anterior</a><?php endif;

	for ($i = 1; $i <= $totalPaginas; $i++) { ?>

		<a class="boton" href='index.php?pagina=<?= $i ?>'> <?= $i ?> </a>

	<?php }

	if ($paginaActual < $totalPaginas): ?> <a class="boton" 
	href="index.php?pagina=<?= $paginaActual+1 ?>">Página siguiente &#62;&#62;</a><?php endif; ?>

</div>

<style>

	td { 
		height: 35px;
		padding: 5px;
	}

	#paginacion {
		text-align: center;
		padding: 10px;
		background-color: silver;
		border: 1px solid black;
		margin-top: 20px;
	}

	.boton {
		padding: 10px;
		margin: 5px;
	}

	.boton:hover {

		background-color: gray;

	}

</style>

<?php

// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido de la página principal
$contenido = ob_get_clean();
include_once "principal.php";

?>