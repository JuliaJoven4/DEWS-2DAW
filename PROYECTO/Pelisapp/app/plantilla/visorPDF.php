<?php
ob_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visor de PDF</title>
</head>

<body>
    <h2> DETALLES </h2>
    <table border="1px">
        <tr>
            <td>CÓDIGO DE PELÍCULA: </td>
            <td> <?= $pelicula->codigo_pelicula ?></td>
        </tr>
        <tr>
            <td>NOMBRE: </td>
            <td> <?= $pelicula->nombre ?></td>
        </tr>
        <tr>
            <td>DIRECTOR: </td>
            <td> <?= $pelicula->director ?></td>
        </tr>
        <tr>
            <td>GÉNERO: </td>
            <td> <?= $pelicula->genero  ?></td>
        </tr>

        <?php if ($pelicula->imagen != null) : ?>

            <tr>
                <td>CARTEL: </td>
                <td><img src="http://localhost/PHP/RECUPERACION/PRUEBAS/peliculas_primera_modificacionNOIMG/PROYECTO/Pelisapp/<?= 'app/img/' . $pelicula->imagen ?>" height="300px" alt="Imagen no disponible"></td>
            </tr>

        <?php endif; ?>

        <tr>
            <td>PUNTUACIÓN: </td>

            <?php if ($pelicula->num_puntuacion != 0) : ?>
                <td> <?= $pelicula->puntuacion ?> (<?= $pelicula->num_puntuacion ?> valoraciones) </td>
        </tr>
    <?php else : ?>
        <td>Aún nadie ha puntuado esta película.</td>
        </tr>
    <?php endif;
            if ($pelicula->trailer != null) : ?>
        <tr>
            <td>Trailer: </td>
            <td> <?= $pelicula->trailer ?> </td>
        </tr>
    <?php endif;
            if ($pelicula->enlace != null) : ?>
        <tr>
            <td>Enlace de visualización: </td>
            <td><?= $pelicula->enlace ?></td>
        </tr>
    <?php endif; ?>

    </table>
</body>

</html>

<style>

    body { font-family: Arial, Helvetica, sans-serif; }
    table { border-collapse: collapse; }
    td {
        padding: 10px;
    }

</style>

<?php

$contenido = ob_get_clean();

require_once 'libreria/dompdf/autoload.inc.php';

use Dompdf\Dompdf as Dompdf;

$dompdf = new Dompdf();

//Código necesario para que se muestren las imágenes en el PDF
$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($contenido);

$dompdf->setPaper('letter');

//Hacemos visible el contenido que hemos cargado
$dompdf->render();

/*Hacemos que el PDF se visualice en una pestaña nueva al pulsar el botón */
$dompdf->stream("Detalles_pelicula.pdf", array("Attachment" => false));

?>