<?php
class basedatos extends Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('almacen/producto_model');
		$this->load->model('almacen/productounidad_model');
		$this->load->model('almacen/productoprecio_model');
		$this->load->model('compras/proveedor_model');
		$this->load->model('maestros/persona_model');
		$this->load->model('maestros/compania_model');
		$this->load->model('ventas/cliente_model');
		$this->load->model('almacen/marca_model');
		$this->load->model('almacen/familia_model');
		$this->load->model('maestros/empresa_model');
		$this->load->model('maestros/eliminar_model');
		
		$this->somevar['compania'] = $this->session->userdata('compania');
		$this->somevar['user'] = $this->session->userdata('user');
		$this->somevar['rol'] = $this->session->userdata('rol');
		$this->somevar['url'] = $_SERVER['REQUEST_URI'];
		date_default_timezone_set("America/Lima");
	}
	
	public function index()
	{
		$this->layout->view('seguridad/inicio');
	}
	
	public function basedatos_principal($j = 0){
		
			
		$this->layout->view('basedatos/basedatos_index');
		
	}
	
	public function ventana_cargar_Articulo($plantilla = "", $alerta = 1)
	{
		$data['aca']="";
		$data['plantilla'] = $plantilla;
		$data['alerta'] = $alerta;
		//  $data['lista'] = $this->proveedor_model->listarPlantillas();
		$this->load->view('basedatos/basedatosexcelarticulo_index',$data);

	}
	
	public function ventana_cargar_proveedor($plantilla = "", $alerta = 1)
	{
		$data['aca']="";
		$data['plantilla'] = $plantilla;
		$data['alerta'] = $alerta;
		$this->load->view('basedatos/basedatosexcelproveedor_index.php',$data);
	
	}
	
	public function ventana_cargar_cliente($plantilla = "", $alerta = 1)
	{
		$data['aca']="";
		$data['plantilla'] = $plantilla;
		$data['alerta'] = $alerta;
		$this->load->view('basedatos/basedatosexcelcliente_index.php',$data);
	
	}
	
	public function ventana_destruir_tablas($plantilla = "", $alerta = 1)
	{
		
		$data['plantilla'] = $plantilla;
		$data['alerta'] = $alerta;
		$this->load->view('basedatos/destrucciontablas_index.php');
	
	}
	
	public function ventana_destruir_transaccionales($plantilla = "", $alerta = 1)
	{
	
		$data['plantilla'] = $plantilla;
		$data['alerta'] = $alerta;
		$this->load->view('basedatos/destruccionTransaccionales_index.php');
	
	}
	
	public function insertararticulo(){
		
		
		$urlnueva = 0;
		if(isset($_POST['button'])){
			
			//subir la imagen del articulo
			$nameEXCEL = $_FILES['archivo']['name'];
			$tmpEXCEL = $_FILES['archivo']['tmp_name'];
			$extEXCEL = pathinfo($nameEXCEL);
			$urlnueva = "images/plantillas/temporal/articulo.xls";
			if(is_uploaded_file($tmpEXCEL)){
				copy($tmpEXCEL,$urlnueva);
			}
					 
			require_once 'system/application/libraries/PHPExcel/IOFactory.php';
	
			$objPHPExcel = PHPExcel_IOFactory::load('images/plantillas/temporal/articulo.xls');
			$objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true,true,true,true); // creo que es las hojas de excel
			$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
			$highestRow = $objWorksheet->getHighestRow(); // leer filas del excel
			$highestColumn = $objPHPExcel->getActiveSheet()->getHighestColumn(); // leer columnas de excel
			//cargamos el archivo que deseamos leer
			//$objPHPExcel = PHPExcel_IOFactory::load('xls/sin.xls');
			
			
			$resulError = "";
			$proddes = "";
			$contadorError = 0;
			foreach ($objHoja as $iIndice=>$objCelda ) {
			
				if($iIndice > 1){
				$ordenAdjA=$objCelda['A'];
				$ordenAdjB=$objCelda['B'];
				$ordenAdjC=$objCelda['C'];
				$ordenAdjD=$objCelda['D'];
				$ordenAdjE=$objCelda['E'];
				$ordenAdjF=$objCelda['F'];
				$ordenAdjG=$objCelda['G'];
				
				
				$proddes = $ordenAdjD;
			//	$arrlength = 0;
				if(trim($proddes) !="" ){
					$lista_proDet = $this->producto_model->verificaProductoDetalle($ordenAdjD);
					if(count($lista_proDet) > 0){
						$nombreprodcto = $lista_proDet[0]->PROD_Nombre;
						
					}else{
			
					$marcacodigo = 0;
					
					if(trim($marcacodigo) !=""){
					
						$lista_marDet = $this->marca_model->verificarMarcaDetalle($ordenAdjC);
						
						/** VALIDANDO SI EXISTE ESA MARCA EN LA TABLA cji_marca **/
					
						if(count($lista_marDet) > 0 ){
							$marcacodigo = $lista_marDet[0]->MARCP_Codigo;
							//	echo "<script>alert('Marca ".$marcacodigo."')</script>";
					
						}else{
							/**SI NO EXISTE SE CREA UNA NUEVA MARCA EN LA TABLA cji_marca ***/
							$filtros = new stdClass();
							$filtros->MARCC_Descripcion = $ordenAdjC;
							$marcacodigo = $this->marca_model->insertar($filtros);
							
						}
					}
					
					$familiacodigo = 0;
					
					if( trim($familiacodigo) !=""){
						/** VALIDANDO SI EXISTE LA FAMILIA EN LA TABLA cji_familia **/
						$lista_famiDet = $this->familia_model->verificarFamiliaDetalle($ordenAdjB);
						
						if(count($lista_famiDet) > 0){
							$familiacodigo = $lista_famiDet[0]->FAMI_Codigo;
								
						}else{
							/**SI NO EXISTE SE CREA UNA NUEVA FAMILIA EN LA TABLA cji_familia ***/
							
							$codigointerno = ""; // verificar esto
						//	echo "<script>alert('codigoInterno : ".$codigointerno."')</script>";
							$flagBS = "B";
							$descripcion = $ordenAdjB;
							$codrelacion = "0";
								
							$familiacodigo =	$this->familia_model->insertar_familia($flagBS,$descripcion,$codrelacion,$codigointerno, $codigousuario='');
								
						}
					
					}
										
 					$familia = $familiacodigo;
					$flagBS = "B";
					$tipo_producto = "NULL";
					$marca = $marcacodigo;
					$linea = "NULL";
					$padre = "NULL";
					$nombre_producto = $ordenAdjD;
					$nombrecorto_producto =$ordenAdjE;
					$descripcion_breve = $ordenAdjF;
					$pdf = "";
					$comentario = "";
					$stock_min = "";
						
					$codigo_usuario = $ordenAdjA;
						
						
					$imagen = "";
					$modelo = "";
					$presentacion = "";
					$geneindi = $ordenAdjG;
					$codigo_original ="";
						
					$codigo_familia = "1";
						
					$proveedor = "";
						
					$unidad_medida = "";
					$nombre_atributo = "";
						
					$factorprin = "";
						
					$atributo = "";
						
					$factor = "";
					$flagPrincipal = "";
					$fabricante = "";
						
						
					$codigo = $this->producto_model->insertar_producto_total($proveedor, $familia, $tipo_producto, $nombre_producto, $descripcion_breve, $comentario, $unidad_medida, $factor, $flagPrincipal, $atributo, $nombre_atributo, $codigo_familia, $fabricante, $linea, $marca, $imagen, $pdf, $modelo, $presentacion, $geneindi, $padre, $codigo_usuario, $nombrecorto_producto, $flagBS, $stock_min, $factorprin, $codigo_original);
						
					/**GUARDAR PRODUCTO_UNIDAD**/
					$filtros = new stdClass();
					$filtros->UNDMED_Codigo = "8";
					$filtros->PROD_Codigo = $codigo;
					$filtros->PRODUNIC_Factor = "1";
					$filtros->PRODUNIC_flagPrincipal = "1";
					$filtros->PRODUNIC_FechaModificacion = "";
					$filtros->PRODUNIC_flagEstado = "1";
					
					$this->productounidad_model->insertar($filtros);
					
					
					
					// /**GUARDAR PRODUCTO_PRECIO**/
						
					
					// 								$filter = new stdClass();
					// 								$filter->PROD_Codigo = $codigo;
					// 								$filter->MONED_Codigo = "1";
					// 								$filter->PRODUNIP_Codigo = "19";
					// 								$filter->TIPCLIP_Codigo = "0";
					// 								$filter->EESTABP_Codigo = "1";
					// 								$temp = $this->productoprecio_model->buscar($filter);
					// 								$filter->PRODPREC_Precio = "10";
					
					// 									$this->productoprecio_model->insertar($filter);
						
				}		
					
				}else{
					//$ver = $iIndice."  ".$objCelda['E'];
					$contadorError =$contadorError+ $iIndice;
					$resulError=$resulError."\n No se Guardo La Fila  = ".$iIndice.", \n";
				}
				
				}
				
			}
			

			if($contadorError >1){
				echo "<script>alert('Algunas Filas no se Guardaron Exitosamente Profavor de verificar el Log de Errores' )</script>";
			}else{
				echo "<script>alert('Se Inserato Correctamente ')</script>";
			}
			
			$data['aca']=$resulError;
			
				
			$this->load->view('basedatos/basedatosexcelarticulo_index.php',$data); 			// COMPROBANTE
		}//Termina el Button
		$file_with_path ="images/plantillas/temporal/articulo.xls";
		if (file_exists($file_with_path)) {
			unlink($file_with_path);
		}
		
}
	
					/***INSERTAR MASIVAMAMENTE EN UN EXCEL A PROVEDOR NATURAL O JURIDICA**/
	
	public function insertarproveedor(){
		$resulError = "";
		//  error_reporting(0);
		if(isset($_POST['button'])){
			//subir la imagen del articulo
			$nameEXCEL = $_FILES['archivo']['name'];
			$tmpEXCEL = $_FILES['archivo']['tmp_name'];
			$extEXCEL = pathinfo($nameEXCEL);
			$urlnueva = "images/plantillas/temporal/proveedorjuridico.xls";
			if(is_uploaded_file($tmpEXCEL)){
				copy($tmpEXCEL,$urlnueva);
			}
			
			$select = $_POST['select'];
			 
			require_once 'system/application/libraries/PHPExcel/IOFactory.php';
	
			$objPHPExcel = PHPExcel_IOFactory::load('images/plantillas/temporal/proveedorjuridico.xls');
			$objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			
			$contadorError = 0;
			if($select == "JURIDICA" ){
				
				
				foreach ($objHoja as $iIndice=>$objCelda) {
					if($iIndice > 1){
						
						$ordenAdjB=$objCelda['B'];
						$ordenAdjC=$objCelda['C'];
						$ordenAdjD=$objCelda['D'];
						$ordenAdjE=$objCelda['E'];
						$ordenAdjF=$objCelda['F'];
						$ordenAdjG=$objCelda['G'];
						$ordenAdjH=$objCelda['H'];
						$ordenAdjI=$objCelda['I'];
						
						$provRuc = $ordenAdjB;
						$ruc20 = substr($provRuc,0,2);
						
					$arrlength = 0;
							
						if(trim($provRuc) !="" && $ruc20 != 10){
							
							$lista_empreDet = $this->empresa_model->verificaEmpresaDetalle($provRuc);
							
							//$lista_provDet = $this->proveedor_model->verificaProveedorDetalle();
							$empresaRuc = "";
							
							if(count($lista_empreDet) > 0){
								$empresaRuc = $lista_empreDet[0]->EMPRP_Codigo;
								$empresa = $empresaRuc;
								$persona = "0";
								$tipo_persona = "1";
								$this->proveedor_model->insertar_datosProveedor($empresa, $persona, $tipo_persona);
								
							}else{
								$empresaRuc = $ordenAdjB;
														
								/**SI NO EXISTE SE CREA UNA NUEVA FAMILIA EN LA TABLA cji_familia ***/
								
								$tipocodigo="1";
								$ruc = $empresaRuc;
								$razon_social = $ordenAdjC;
								$telefono = $ordenAdjD;
								$fax = $ordenAdjE;
								$web= $ordenAdjF;
								$movil= $ordenAdjG;
								$email= $ordenAdjH;
								$ctactesoles = "";
								$ctactedolares = "";
								$direccion1 = $ordenAdjI;
								
								$codigoempresa = $this->empresa_model->insertar_datosEmpresa($tipocodigo, $ruc,$razon_social,$telefono,$fax,$web,$movil,$email, $sector_comercial='', $ctactesoles='', $ctactedolares='',$direccion=$direccion1);
								$empresa = $codigoempresa;
								$persona = "0";
								$tipo_persona = "1";
									
								$this->proveedor_model->insertar_datosProveedor($empresa, $persona, $tipo_persona);
							}
					    	
					    	
						}else{
							$contadorError =$contadorError+ $iIndice;
							$resulError=$resulError."\n No se Guardo La Fila  = ".$iIndice.", \n";
								
						}
						
						
						
						
						
					}
					
				}
			//	echo '<script language="javascript">alert("Se Inserto Correctamente en el Sistema");</script>';

			
			}
			
			if($select == "NATURAL" ){
				foreach ($objHoja as $iIndice=>$objCeldaprov) {
					if($iIndice > 1){
					$ordenAdjA=$objCeldaprov['A'];
					$ordenAdjB=$objCeldaprov['B'];
					$ordenAdjC=$objCeldaprov['C'];
					$ordenAdjD=$objCeldaprov['D'];
					$ordenAdjE=$objCeldaprov['E'];
					$ordenAdjF=$objCeldaprov['F'];
					$ordenAdjG=$objCeldaprov['G'];
					$ordenAdjH=$objCeldaprov['H'];
					$ordenAdjI=$objCeldaprov['I'];
					$ordenAdjJ=$objCeldaprov['J'];
					
					$provRuc = $ordenAdjA;
					$ruc10 = substr($provRuc,0,2);
					$dniverifica = $ordenAdjE;
					$arrlength = 0;
					
					if($ruc10 != 20 && trim($dniverifica) !=""){
							
						$lista_perDet = $this->persona_model->verificaPersonaDetalle($dniverifica,$provRuc);
					
						$empresaRuc = "";
							
						if(count($lista_perDet) > 0){
							$empresaRuc = $lista_perDet[0]->PERSP_Codigo;
								//echo "<script>alert(' Ya Existe el Ruc  :  ".$empresaRuc." Fila en Excel ".$iIndice."')</script>";
							$this->proveedor_model->insertar_datosProveedor( 0,$empresaRuc, 0);
								
						}else{
								
						$ubigeo_nacimiento = "0";
						$ubigeo_domicilio = "0";
						$estado_civil = "0";
						$nacionalidad = "0";
						$tipo_documento = "1";
						$nombres = $ordenAdjB;
						$paterno = $ordenAdjC;
						$materno = $ordenAdjD;
						$ruc = $ordenAdjA;
						$numero_documento1 = $ordenAdjE;
						$direccion1 = $ordenAdjF;
						$telefono1 = $ordenAdjG;
						$movil1 = $ordenAdjH;
						$email1 = $ordenAdjI;
						
						$sexo1 = "" ;
								if($ordenAdjJ == "FEMENINO" || $ordenAdjJ == "1" ){
									$sexo1 = 1;
								}else{
									$sexo1 = 0;
								}
						
						
						 $codigopersona = $this->persona_model->insertar_datosPersona($ubigeo_nacimiento, $ubigeo_domicilio, $estado_civil, $nacionalidad, $nombres, $paterno, $materno, $ruc, $tipo_documento, $numero_documento = $numero_documento1, $direccion = $direccion1, $telefono = $telefono1, $movil = $movil1, $email = $email1, $domicilio = '', $sexo = $sexo1, $fax = '', $web = '', $fechanac='');
						 $codperso =$codigopersona; 
						 $this->proveedor_model->insertar_datosProveedor( 0,$codperso, 0);
						}
						
					}else{
						$contadorError =$contadorError+ $iIndice;
						$resulError=$resulError."\n No se Guardo La Fila  = ".$iIndice.", \n";
						
						}
				  }
				
		    	}
			}
			
			if($contadorError >1){
				echo "<script>alert('Algunas Filas no se Guardaron Exitosamente Profavor de verificar el Log de Errores' )</script>";
			}else{
				echo "<script>alert('Se Inserato Correctamente ')</script>";
			}
			
			$data['aca']=$resulError;
			
			// COMPROBANTE
			$this->load->view('basedatos/basedatosexcelproveedor_index.php',$data);
		}
		
		$file_with_path ="images/plantillas/temporal/proveedorjuridico.xls";
		if (file_exists($file_with_path)) {
			unlink($file_with_path);
		}
	}
	
	
	/**INSERTAR EN LA BASE DATOS MEDIANTE UN EXCEL CLIENTE JURIDICO O NATURAL**/
	
	public function insertarcliente(){
		$resulError = "";

		//  error_reporting(0);
		if(isset($_POST['button'])){
			//subir la imagen del articulo
			$nameEXCEL = $_FILES['archivo']['name'];
			$tmpEXCEL = $_FILES['archivo']['tmp_name'];
			$extEXCEL = pathinfo($nameEXCEL);
			$urlnueva = "images/plantillas/temporal/cliente.xls";
			if(is_uploaded_file($tmpEXCEL)){
				copy($tmpEXCEL,$urlnueva);
			}
				
			$select = $_POST['select'];
		
			require_once 'system/application/libraries/PHPExcel/IOFactory.php';
		
			$objPHPExcel = PHPExcel_IOFactory::load('images/plantillas/temporal/cliente.xls');
			$objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				
				
			$objPHPExcelnatural = PHPExcel_IOFactory::load('images/plantillas/temporal/cliente.xls');
			$objHojajuridico=$objPHPExcelnatural->getActiveSheet()->toArray(null,true,true,true,true,true,true);
				
			$contadorError = 0;
				
			if($select == "PERSONA JURIDICA" ){
		
				foreach ($objHoja as $iIndice=>$objCelda) {
					if($iIndice > 1){
					$ordenAdjA=$objCelda['A'];
					$ordenAdjB=$objCelda['B'];
					$ordenAdjC=$objCelda['C'];
					$ordenAdjD=$objCelda['D'];
					$ordenAdjE=$objCelda['E'];
					$ordenAdjF=$objCelda['F'];
					$ordenAdjG=$objCelda['G'];
					$ordenAdjH=$objCelda['H'];
		
					$provRuc = $ordenAdjA;
					$ruc20 = substr($provRuc,0,2);
					
					$arrlength = 0;
					if(trim($provRuc) !="" && $ruc20 != 10){
							
						$lista_empreDet = $this->empresa_model->verificaEmpresaDetalle($provRuc);
					
						$empresaRuc = "";
							
						if(count($lista_empreDet) > 0){
							$empresaRuc = $lista_empreDet[0]->EMPRP_Codigo;
							//	echo "<script>alert(' Ya Existe el Ruc  :  ".$empresaRuc." Fila en Excel ".$iIndice."')</script>";
							$empresa = $empresaRuc;
							$persona = "0";
							$tipo_persona = "1";
							$categoria = "0";
							$forma_pago = "";
							$calificaciones = "0";
							$this->cliente_model->insertar_datosCliente($empresa,$persona,$tipo_persona, $categoria, $forma_pago,$calificaciones);
								
						}else{
					
					$tipocodigo="1";
					$ruc = $ordenAdjA;
					$razon_social = $ordenAdjB;
					$telefono = $ordenAdjC;
					$fax = $ordenAdjD;
					$web= $ordenAdjE;
					$movil= $ordenAdjF;
					$email= $ordenAdjG;
					$ctactesoles = "";
					$ctactedolares = "";
					$direccion1 = $ordenAdjH;
		
					$codigoempresacliente = $this->empresa_model->insertar_datosEmpresa($tipocodigo, $ruc,$razon_social,$telefono,$fax,$web,$movil,$email, $sector_comercial='', $ctactesoles='', $ctactedolares='',$direccion=$direccion1);
					
					$empresa = $codigoempresacliente;
					$persona = "0";
					$tipo_persona = "1";
					$categoria = "0";
					$forma_pago = "";
					$calificaciones = "0";
					
					$this->cliente_model->insertar_datosCliente($empresa,$persona,$tipo_persona, $categoria, $forma_pago,$calificaciones);
				  }
				}else{
					$contadorError =$contadorError+ $iIndice;
					$resulError=$resulError."\n No se Guardo La Fila  = ".$iIndice.", \n";
						
				}
			}
		}
	}			
			if($select == "PERSONA NATURAL" ){
				foreach ($objHojajuridico as $iIndice=>$objCeldaprov) {
					if($iIndice > 1){
						
					$ordenAdjA=$objCeldaprov['A'];
					$ordenAdjB=$objCeldaprov['B'];
					$ordenAdjC=$objCeldaprov['C'];
					$ordenAdjD=$objCeldaprov['D'];
					$ordenAdjE=$objCeldaprov['E'];
					$ordenAdjF=$objCeldaprov['F'];
					$ordenAdjG=$objCeldaprov['G'];
					$ordenAdjH=$objCeldaprov['H'];
					$ordenAdjI=$objCeldaprov['I'];
					$ordenAdjJ=$objCeldaprov['J'];
						
					$provRuc = $ordenAdjA;
					$ruc10 = substr($provRuc,0,2);
					$dniverifica = $ordenAdjE;
					$arrlength = 0;
						
					if($ruc10 != 20 && trim($dniverifica) !=""){
							
						$lista_clieDet = $this->persona_model->verificaPersonaDetalle($dniverifica,$provRuc);
							
						$clienRucDni = "";
							
						if(count($lista_clieDet) > 0){
							$clienRucDni = $lista_clieDet[0]->PERSP_Codigo;
							//	echo "<script>alert(' Ya Existe el Ruc  :  ".$empresaRuc." Fila en Excel ".$iIndice."')</script>";
							$empresa = "0";
							$persona = $clienRucDni;
							$tipo_persona = "";
							$categoria = "";
							$forma_pago = "";
							$calificaciones = "";
							$this->cliente_model->insertar_datosCliente($empresa,$persona,$tipo_persona, $categoria, $forma_pago,$calificaciones);
								
						}else{
						
							$ubigeo_nacimiento = "0";
							$ubigeo_domicilio = "0";
							$estado_civil = "0";
							$nacionalidad = "0";
							$tipo_documento = "1";
							$nombres = $ordenAdjB;
							$paterno = $ordenAdjC;
							$materno = $ordenAdjD;
							$ruc = $ordenAdjA;
							$numero_documento1 = $ordenAdjE;
							$direccion1 = $ordenAdjF;
							$telefono1 = $ordenAdjG;
							$movil1 = $ordenAdjH;
							$email1 = $ordenAdjI;
								
							$sexo1 = "" ;
							if($ordenAdjJ == "FEMENINO" || $ordenAdjJ == "1" ){
								$sexo1 = 1;
							}else{
								$sexo1 = 0;
							}
								
								
							$codigoempresaclientenatural=$this->persona_model->insertar_datosPersona($ubigeo_nacimiento, $ubigeo_domicilio, $estado_civil, $nacionalidad, $nombres, $paterno, $materno, $ruc, $tipo_documento, $numero_documento = $numero_documento1, $direccion = $direccion1, $telefono = $telefono1, $movil = $movil1, $email = $email1, $domicilio = '', $sexo = $sexo1, $fax = '', $web = '', $fechanac='');
							
							$empresa = "0";
							$persona = $codigoempresaclientenatural; 
							$tipo_persona = "";
							$categoria = "";
							$forma_pago = "";
							$calificaciones = "";
							
							$this->cliente_model->insertar_datosCliente($empresa,$persona,$tipo_persona, $categoria, $forma_pago,$calificaciones);
							}
					}else{
						$contadorError =$contadorError+ $iIndice;
						$resulError=$resulError."\n No se Guardo La Fila  = ".$iIndice.", \n";
						
					}
				}
			}
		}
		
		if($contadorError >1){
			echo "<script>alert('Algunas Filas no se Guardaron Exitosamente Porfavor de verificar el Log de Errores' )</script>";
		}else{
			echo "<script>alert('Se Inserato Correctamente ')</script>";
		}
		
		$data['aca']=$resulError;
		
			// COMPROBANTE
			$this->load->view('basedatos/basedatosexcelcliente_index.php',$data);
		}
		
		$file_with_path ="images/plantillas/temporal/cliente.xls";
		if (file_exists($file_with_path)) {
			unlink($file_with_path);
		}
		
	}
	
	/**Eliminar Tablas de la base de datos OsaErp**/
	public function eliminarTablas(){
		/**ELIMINAR TODO EL CONTENIDO DE LAS TABLAS - INICIO***/
		
		$eliminar = "delete from cji_almacenproducto";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_productoatributo";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_almaprolote";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_caja";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_caja_chekera";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_caja_cuenta";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_chekera";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_cheque";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_cliente";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_clientecompania";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_companiaconfiguracion where COMPCONFIP_Codigo > 1";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_comprobante";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_comprobantedetalle";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_comprobante_guiarem";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_correoenviar";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_cotizacion";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_cotizaciondetalle";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_cuentas";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_cuentasempresas";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_cuentaspago";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_direccion";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_directivo where EMPRP_Codigo > 1";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_emprcontacto  where EMPRP_Codigo > 1";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "delete from cji_empresa where TIPCOD_Codigo not in (3) and EMPRP_Codigo not in (1)" ;
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_empresatipoproveedor";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_emprestablecimiento where EMPRP_Codigo > 1";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_fabricante";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_familia";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_familiacompania";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_flujocaja";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_guiain";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_guiaindetalle";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_guiarem";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_guiaremdetalle";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_guiasa";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_guiasadetalle";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_guiatrans";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_guiatransdetalle";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_inventario";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_inventariodetalle";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_kardex";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_letra";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_linea";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_log";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_lote";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_loteprorrateo";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_marca";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_nota";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_notadetalle";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_ocompradetalle";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_ordencompra";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_pago";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_pedido";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_pedidodetalle";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_persona WHERE PERSP_Codigo > 1";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_plantilla";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_presupuesto";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_presupuestodetalle";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_producto";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_productoatributo";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_productocompania";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_productoprecio";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_productoproveedor";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_productopublicacion";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_productounidad";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_proveedor";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_proveedorcompania";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_proveedormarca";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_proyecto";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_recepcionproveedor";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_serie";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_seriedocumento";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_seriemov";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_terminal";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_tipocaja";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_tipocambio";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_tipoproducto";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_usuario where USUA_Codigo > 1";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_usuario_compania where USUA_Codigo > 1";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_usuario_terminal";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM impactousuario";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM impacto_documento";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM impacto_publicacion";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
 		
		$eliminar = "DELETE FROM cji_serie";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_seriedocumento";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_seriemov";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		$eliminar = "DELETE FROM cji_almacenproductoserie";
		$this->eliminar_model->Eliminar_Tabla($eliminar);
		
		
		
		$eliminar = "DELETE FROM cji_permiso";
		$eliminarfinal = $this->eliminar_model->Eliminar_Tabla($eliminar);
		/**ELIMINAR TODO EL CONTENIDO DE LAS TABLAS - FIN***/
		
		$vargetTxt = "";
		$eliminarfinal = "";
		if(trim($eliminarfinal) == ""){
		//	Leer todas las Filas del txt y mostrar el contenido
			$file = fopen("images/plantillas/insertarUsuario.txt", "r");
			while(!feof($file))
			{
				$vargetTxt = fgets($file);
				$this->eliminar_model->Agregar_Tabla($vargetTxt);
			}
			fclose($file);
								
		}else{
			
		}	
		
		echo "0";
				
	}
	
	public  function eliminarTransaccionales(){
		$this->eliminar_model->EliminarTransaccionales();
		echo "0";
	}

	###################################################################
	######## VACIAR TABLAS - RAWIL
	###################################################################

	public  function truncate_comprobantes(){
		$this->eliminar_model->truncate_comprobantes();
		$json = array("result" => "success");
		echo json_encode( $json );
	}
	
	public  function truncate_docs(){
		$this->eliminar_model->truncate_docs();
		$json = array("result" => "success");
		echo json_encode( $json );
	}
	
	public  function truncate_inventarios(){
		$this->eliminar_model->truncate_inventarios();
		$json = array("result" => "success");
		echo json_encode( $json );
	}
	
	public  function truncate_stock(){
		$this->eliminar_model->truncate_stock();
		$json = array("result" => "success");
		echo json_encode( $json );
	}
	
	public  function truncate_productos(){
		$this->eliminar_model->truncate_productos();
		$json = array("result" => "success");
		echo json_encode( $json );
	}
	
	public  function truncate_usuarios(){
		$this->eliminar_model->truncate_usuarios();
		$json = array("result" => "success");
		echo json_encode( $json );
	}

	public  function truncate_personal(){
		$this->eliminar_model->truncate_personal();
		$json = array("result" => "success");
		echo json_encode( $json );
	}

	public  function truncate_empresas(){
		$this->eliminar_model->truncate_empresas();
		$json = array("result" => "success");
		echo json_encode( $json );
	}

	public  function truncate_clientes_proveedores(){
		$this->eliminar_model->truncate_clientes_proveedores();
		$json = array("result" => "success");
		echo json_encode( $json );
	}

	public  function truncate_all(){
		$this->eliminar_model->truncate_all();
		$json = array("result" => "success");
		echo json_encode( $json );
	}

	public  function add_clientecompania(){
		$this->eliminar_model->truncate_clientecompania();
		$array_compania =  $this->compania_model->listar(null);
		$array_companiaclientes =  $this->cliente_model->getCLIP_Codigo();
		foreach ($array_companiaclientes as $key => $valor) {
			
			foreach ($array_compania as $key => $value){
				$this->cliente_model->insertar_cliente_empresa($valor->CLIP_Codigo,$value->COMPP_Codigo);
			}
		}
		$json = array("result" => "success");
		echo json_encode( $json );
	}


	public function add_productocompania($value='')
	{
		 
		$this->eliminar_model->truncate_productocompania();
        $listado = $this->producto_model->productos_sistema();
        $array_compania =  $this->compania_model->listar(null);
        
        if ( count($listado) > 0 ){
            foreach ($listado as $indice => $valor) {
            	foreach ($array_compania as $key => $value){
	                $data = array(
	                        "PROD_Codigo" => $valor->PROD_Codigo,
	                        "COMPP_Codigo" => $value->COMPP_Codigo
	                    );
	                $this->db->insert("cji_productocompania", $data);
            
            	}
            }
        }
            
	}
	
	public function obtener_estado_pago()
	{
		$empresa 		= $this->session->userdata('empresa');
		$datos 			= $this->empresa_model->obtener_datosEmpresa($empresa);
        $estado_pago 	= $datos[0]->EMPRC_EstadoPago;
        $numero_transaccion = $datos[0]->EMPRC_NumeroPago;
        
        $arrayName 		= array('pago' => $estado_pago, "deposito" => $numero_transaccion);

        echo json_encode($arrayName);
	}

	/*****************************************************
	/* FUNCIONES PARA TENER CONTROL DE PAGOS - BLOQUEO Y 
	/* DESBLOQUEO DE INGRESO AL SISTEMA
	/* DESARROLLADO POR LUIS VALDES
	/* 01/01/2020
	/*****************************************************/
	public function UpdateEstadoPago($value='')
	{
		$empresa 		= $this->session->userdata('empresa');
		$estado_pago	= $this->input->post("estado_pago");
		$deposito 		= $this->input->post("deposito");
		$filter 		= new stdClass();
		$filter->EMPRC_NumeroPago = $deposito;
		$filter->EMPRC_EstadoPago = $estado_pago;
		$this->empresa_model->UpdateEstadoPago($empresa,$filter);
		$json = array("result" => "success");
		echo json_encode( $json );
	}
}