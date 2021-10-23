<div>
<b> Detalles:</b><br>
<table>
<tr><td>Longitud:           </td><td><?= strlen(strip_tags($_REQUEST['comentario'])) ?></td></tr>
<tr><td>Nº de palabras:     </td><td><?= str_word_count(strip_tags($_REQUEST['comentario'])); ?></td></tr>
<tr><td>Letra + repetida:   </td><td>

<?php

$cad = strip_tags($_REQUEST['comentario']);
$cadSinEspacios = str_replace(' ', '',$cad);
$charArray = str_split($cadSinEspacios);
$charSinRep = array_unique($charArray);
$maxL = 0;
$contL = 0;
$letraMasRep = "";

foreach ($charSinRep as $posicion => $letra) {
    foreach ($charArray as $pos => $letRep) {
        if ($letra == $letRep) {
            $contL++;
            if ($contL > $maxL) {
                $maxL = $contL;
                $letraMasRep = $letRep;
            }
        }
    }
    $contL = 0;
}

echo $letraMasRep;

?>

</td></tr>
<tr><td>Palabra + repetida: </td><td>
<?php

    $cadena = strip_tags($_REQUEST['comentario']);
    $arrayPalabras = str_word_count(strtolower($cadena), 1, '@·$%&)("=?¿!¡');
    $palabrasSinRep = array_unique($arrayPalabras);
    $maxP = 0;
    $contP = 0;
    $palabraMasRep = "";

    foreach ($palabrasSinRep as $posicion => $palabra) {
        foreach ($arrayPalabras as $pos => $palRep) {
            if ($palabra == $palRep) {
                $contP++;
                if ($contP > $maxP) {
                    $maxP = $contP;
                    $palabraMasRep = $palRep;
                }
            }
        }
        $contP = 0;
    }
    if ($maxP <= 1) {
        echo "No hay una palabra que se repita más que las demás o solo hay una palabra.";
    }
    else {
        echo $palabraMasRep;
    }

?>
</td></tr>
</table>
</div>

