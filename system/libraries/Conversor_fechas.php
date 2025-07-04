<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Conversor_fechas{
   
   ////////////////////////////////////////////////////
   //Convierte fecha de mysql a español
   ////////////////////////////////////////////////////
   function fecha_mysql_a_espanol($fecha){
      ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
      $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
      return $lafecha;
   }

   ////////////////////////////////////////////////////
   //Convierte fecha de español a mysql
   ////////////////////////////////////////////////////
   function fecha_espanol_a_mysql($fecha){
      ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
      $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
      return $lafecha;
   }
   
}
?>