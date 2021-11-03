<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>La Frutería del siglo XXI</h1>
            <p>Este es su pedido: </p>
            <table border="1px" style="border-collapse:collapse">
                <tr>
                    <td>
                        <?php foreach ($_SESSION['cantidadFrutas'] as $fruta => $cantidad) {
                            echo "<p><b>" . $fruta . " </b>" . $cantidad . "</p>";
                        } ?>
                    </td>
                </tr>
            </table>
            <p>Muchas gracias por su pedido.</p>
            <input type="button" value=" NUEVO CLIENTE "
            onclick="location.href='<?=$_SERVER['PHP_SELF'];?>'">
</body>
</html>