<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 					'ab');
define('FOPEN_READ_WRITE_CREATE', 				'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 			'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| Datos de pagina
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('TITULO',                                'SISTEMA GESTION | OSA-ERP');
define('URL_IMAGE',                             'http://localhost/translogint/images/');
define('URL_JS',                                'http://localhost/translogint/system/application/views/javascript/');
define('URL_CSS',                               'http://localhost/translogint/system/application/views/estilos/');
define('URL_BASE',                              'http://localhost/translogint/');
define('FORMATO_IMPRESION',                     1);

/* FORMATO 1: FERRESAT
 * FORMATO 2: JIMMYPLAST
 * FORMATO 3: INSTRUMENTOS Y SISTEMAS
 * FORMATO 4: FERREMAX  
 * FORMATO 5: DISTRIBUIDORA CYG
 * FORMATO 8: IMPACTO
 */

## VERSIONES DE LOS JS Y CSS "ESTO EVITA BORRAR CACHE TRAS CADA ACTUALIZACION"
define('CSS', 'v-3.0.0.3');
define('JS', 'v-3.0.0.3');
define('IMG', 'v-3.0.0.0');

// TAMAÑO LIMITE DE DETALLES EN LOS DOCUMENTOS
define('VENTAS_GUIA', 1000);
define('COMPRAS_GUIA', 1000);
define('VENTAS_FACTURA', 1000);
define('VENTAS_BOLETA', 1000);
define('VENTAS_COMPROBANTE', 50);

define('COMPRAS_FACTURA', 1000);
define('COMPRAS_BOLETA', 1000);

define('COMPARTIR_PROVCOMPANIA', 1);//comparte provedores(todas las companias):1
define('COMPARTIR_CLICOMPANIA',1);//comparte clientes (todas las companias):1
define('COMPARTIR_ARTCOMPANIA',1);//comparte articulos(todas las companias):1
define('COMPARTIR_FAMCOMPANIA',1);//comparte familias(todas las companias):1
/* End of file constants.php */
/* Location: ./system/application/config/constants.php */