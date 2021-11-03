
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra</title>
</head>
<body>
    <p>REALICE SU COMPRA, <?= $_SESSION['nombre'] ?></p>
    <form method="POST">
    <p>Seleccione la fruta: <select name="fruta">
                <option value="Naranjas">Naranjas</option>
                <option value="Limones">Limones</option>
                <option value="Plátanos">Plátanos</option>
                <option value="Manzanas">Manzanas</option>
    </select></p>
    <p>Cantidad: <input type="number" name="cantidad"></p>
    <input type="submit" name="enviar" value="Anotar">
    <input type="submit" name="enviar" value="Terminar">
    </form>
</body>
</html>