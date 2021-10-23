<?php
function usuarioOk($usuario, $contraseña) :bool {
  
   $usuarioRev = "";
   $j = 0;
   
   for ($i = strlen($usuario)-1; $i >= 0 ; $i--) {
      $usuarioRev .= $usuario[$i];
      $j++;
      if ($j == strlen($usuario)) {
         break;
      }
   }
   
   if ( (strlen($usuario) >= 8) && ($contraseña == $usuarioRev) ) {
      return true;
   }
   else {
      return false;
   }
    
}
