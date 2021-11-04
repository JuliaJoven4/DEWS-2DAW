<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apuesta</title>
</head>
<body>
    <!-- RESULTADO DE LA APUESTA: (PAR/IMPAR) GANASTE / PERDISTE // MENSAJE DE ERROR (NO DINERO DISPONIBLE) -->
    <?php echo $msg; ?>
    <p>Dispone de <?php echo $_SESSION['dinero']; ?> euros para jugar.</p>
    <form method="POST">
        <p>Cantidad a apostar: <input type="number" name="dineroApuesta"></p>
        <p>Tipo de apuesta: <input type="radio" name="apuesta" value="par" checked>Par <input type="radio" name="apuesta" value="impar">Impar</p>
        <button name="accion" value="apostar">Apostar cantidad</button>
        <button name="accion" value="abandonar">Abandonar el casino</button>
    </form>
    
</body>
</html>