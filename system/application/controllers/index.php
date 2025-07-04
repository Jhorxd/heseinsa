<?php

class Index extends Controller{

	public $base_url;

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('almacen/producto_model');
		
		$this->load->model('maestros/empresa_model');
		$this->load->model('maestros/emprestablecimiento_model');
		$this->load->model('maestros/compania_model');
		$this->load->model('maestros/persona_model');
		$this->load->model('maestros/directivo_model');
		$this->load->model('maestros/tipocambio_model');
		$this->load->model('maestros/moneda_model');
		$this->load->model('seguridad/permiso_model');
		$this->load->model('seguridad/menu_model');
		$this->load->model('seguridad/usuario_model');
		$this->load->model('seguridad/usuario_compania_model');
		$this->load->model('seguridad/rol_model');
		$this->load->library('html');
		
		$this->somevar['compania'] = $this->session->userdata('compania');
		$this->base_url = base_url();
	}

	public function index( $msg = NULL ){
		$data["msg"] = $msg;
		unset($msg);
		$this->load->view("index", $data);
	}

	public function pos( $msg = NULL ){
		$this->load->model('maestros/formapago_model');
		$this->load->model('ventas/tipocliente_model');
		$this->load->model('tesoreria/caja_model');
		$this->load->model('maestros/tipodocumento_model');
		$this->load->model('maestros/tipocodigo_model');
		$this->load->model('almacen/productounidad_model');
		$this->load->model('almacen/almacen_model');
    
		$almacenInfo = $this->almacen_model->getAlmacens($filter);
		
		$data['Categorias'] 		= $this->tipocliente_model->getCategorias();
		$data['cboVendedor'] 		= $this->directivo_model->listarVendedores();
		$data['cboMoneda'] 			= $this->moneda_model->listar();
		$data['cboFormaPago'] 		= $this->formapago_model->listar_punto_venta();
		$data["compania"] 			= $this->somevar['compania'];
		$data['cajas'] 				= $this->caja_model->getCajas();
		$data['usuario'] 			= $this->session->userdata('user_name');
		$data["documentosNatural"] 	= $this->tipodocumento_model->listar_tipo_documento();
		$data["documentosJuridico"] = $this->tipocodigo_model->listar_tipo_codigo();
		$data["almacenes"] 			= $almacenInfo;

    	$fav = $this->producto_model->productos_favs($almacenInfo[0]->ALMAP_Codigo);

    	$datos_fav = [];
		foreach ($fav as $key => $value) 
		{
			$datosUnidadProducto = $this->productounidad_model->obtenerprincipal($cod_prod);
			if ( count($datosUnidadProducto) > 0 ) {
				$codunidad 	= $datosUnidadProducto->UNDMED_Codigo;
			}else{
				$codunidad 	= 1;
			}

			$PrecioXcliente = $this->producto_model->seleccionar_precio_cliente($value->PROD_Codigo);       
			$pventa 		= $PrecioXcliente[0]->PRODPREC_Precio;

			$datos = array(
				"almacenProducto" 	=> 1,
				"codigo" 			=> $value->PROD_Codigo,
				"codinterno" 		=> $value->PROD_CodigoInterno,
				"codunidad" 		=> $codunidad,
				"descripcion" 		=> $value->PROD_Nombre,
				"flagGenInd" 		=> "",
				"img" 				=> $value->PROD_Imagen,
				"pventa" 			=> $pventa,
				"tipo_afectacion" 	=> $value->AFECT_Codigo,
				"value" 			=> $value->PROD_Nombre,
				"stock" 			=> $value->ALMPROD_Stock
			);
			
			array_push($datos_fav, $datos);
		}

	   	$data["favoritos"] 	= $datos_fav;
	    $cambio_dia 		= $this->tipocambio_model->obtener_tdc_dolar(date('Y-m-d'));

	    if (count($cambio_dia) > 0) {
	        $data['tdcDolar'] = $cambio_dia[0]->TIPCAMC_FactorConversion;
	    } else {
	        $data['tdcDolar'] = '';
	    }

	    $data["nombre_sucursal"] = $this->session->userdata('nombre_establec');

		$this->load->view("layout/layout2.php", $data);
	}

	public function getFavoritos()
	{
		$this->load->model('almacen/productounidad_model');
		$almacen 	= $this->input->post("almacen");
		$fav 			= $this->producto_model->productos_favs($almacen);

	    $datos_fav=[];
	    foreach ($fav as $key => $value) 
	    {
	      $datosUnidadProducto = $this->productounidad_model->obtenerprincipal($cod_prod);
	      if ( count($datosUnidadProducto) > 0 ) {
	          $codunidad = $datosUnidadProducto->UNDMED_Codigo;
	      }else{
	          $codunidad = 1;
	      }
	   	
		    $PrecioXcliente = $this->producto_model->seleccionar_precio_cliente($value->PROD_Codigo);       
		    $pventa = $PrecioXcliente[0]->PRODPREC_Precio;

		    $datos=array("almacenProducto"=>1,"codigo"=>$value->PROD_Codigo,"codinterno"=>$value->PROD_CodigoInterno,"codunidad"=>$codunidad,"descripcion"=>$value->PROD_Nombre,"flagGenInd"=>"","img"=>$value->PROD_Imagen,"pventa"=>$pventa,"tipo_afectacion"=>$value->AFECT_Codigo,"value"=>$value->PROD_Nombre,"stock" => $value->ALMPROD_Stock);
		    array_push($datos_fav, $datos);

	    }
	   	echo json_encode($datos_fav);
	}
	

	public function ingresar_sistema(){
		$this->form_validation->set_rules('txtUsuario', 'Nombre Usuario', 'required|max_length[200]');
		$this->form_validation->set_rules('txtClave', 'Clave de Usuario', 'required|max_length[200]|md5');
		if ($this->form_validation->run() == FALSE) {
			$this->index();
		}
		else {
			$txtUsuario = $this->input->post('txtUsuario');
			$txtClave 	= $this->input->post('txtClave');

			$datos_usuario = $this->usuario_model->obtener_datosUsuarioLogin($txtUsuario, $txtClave);
			if (count($datos_usuario) > 0) {
				$empresa 		= $this->usuario_model->obtener_empresa_usuario($datos_usuario[0]->USUA_Codigo);
				$datos_usu_com 	= $this->usuario_compania_model->listar($datos_usuario[0]->USUA_Codigo, $empresa[0]->EMPRP_Codigo);

				if (count($datos_usu_com) > 0) {
					$datos_compania = $this->compania_model->obtener($datos_usu_com[0]->COMPP_Codigo);
					$datos_empresa 	= $this->empresa_model->obtener_datosEmpresa($datos_compania[0]->EMPRP_Codigo);
					$datos_establec = $this->emprestablecimiento_model->obtener($datos_compania[0]->EESTABP_Codigo);
					$usuario 		= $datos_usuario[0]->USUA_Codigo;
	        
					$obtener_rol 	= $this->usuario_model->obtener_rolesUsuario($usuario, $empresa);
					if (count($obtener_rol) > 0) {
						$persona 		= $datos_usuario[0]->PERSP_Codigo;
						$rol 			= $obtener_rol[0]->ROL_Codigo;
						$desc_rol 		= $obtener_rol[0]->ROL_Descripcion;
						$datos_persona 	= $this->persona_model->obtener_datosPersona($persona);
						$datos_rol 		= $this->rol_model->obtener_rol($rol);
						$nombre_rol 	= $datos_rol[0]->ROL_Descripcion;
						$nombre_persona = $datos_persona[0]->PERSC_Nombre . " " . $datos_persona[0]->PERSC_ApellidoPaterno;
						$datos_permisos = $this->permiso_model->obtener_permisosMenu($rol);
						$data2 			= array();
						foreach ($datos_permisos as $valor) {
							$menu 			= $valor->MENU_Codigo;
							$datos_menu 	= $this->menu_model->obtener_datosMenu($menu);
							$nombre_menu 	= $datos_menu[0]->MENU_Descripcion;
							$url 			= $datos_menu[0]->MENU_Url;
							$data2[] 		= array($menu, $nombre_menu, $url);
						}
						$data = array(
							'user' 				=> $usuario,
							'persona' 			=> $persona,
							'nombre_persona' 	=> $nombre_persona,
							'rol' 				=> $rol,
							'desc_rol' 			=> $desc_rol,
							'nombre_rol' 		=> $nombre_rol,
							'compania' 			=> $datos_usu_com[0]->COMPP_Codigo,
							'empresa' 			=> $datos_empresa[0]->EMPRP_Codigo,
							'nombre_empresa' 	=> $datos_empresa[0]->EMPRC_RazonSocial,
							'establec' 			=> $datos_establec[0]->EESTABP_Codigo,
							'nombre_establec' 	=> $datos_establec[0]->EESTABC_Descripcion,
							'constante' 		=> 0,
							'menu' 				=> 0,
							'user_name' 		=> strtolower($txtUsuario),
							'idcompania' 		=> $datos_compania[0]->COMPP_Codigo,
							'codUsuario'		=> $datos_usuario[0]->PERSP_Codigo,
						);
						//?guardamos los datos de la session en la base de datos
						$ip_del_cliente = $_SERVER['REMOTE_ADDR'];	
						$this->usuario_model->guardarSession($nombre_persona, $desc_rol,$ip_del_cliente);
						//?fin
						$this->session->set_userdata($data);
						$this->session->set_userdata('datos_menu', $data2);
						
				    	if($desc_rol == "VENDEDOR JUNIOR" || $desc_rol == "VENDEDOR SENIOR"){
	                        header("Location:" . base_url() . "index.php/index/pos");
						}elseif($desc_rol == "Vendedor Junior" || $desc_rol == "Vendedor Senior"){	
							header("Location:" . base_url() . "index.php/index/pos");
						}elseif($desc_rol == "Vendedor junior" || $desc_rol == "Vendedor senior"){
							header("Location:" . base_url() . "index.php/index/pos");
						}elseif($desc_rol == "VENDEDOR junior" || $desc_rol == "VENDEDOR senior"){
							header("Location:" . base_url() . "index.php/index/pos");
						}elseif($desc_rol == "vendedor JUNIOR" || $desc_rol == "vendedor SENIOR"){
							header("Location:" . base_url() . "index.php/index/pos");
						}elseif($desc_rol == "vendedor junior" || $desc_rol == "vendedor senior"){
							header("Location:" . base_url() . "index.php/index/pos");	
						}elseif($desc_rol == "vendedor Junior" || $desc_rol == "vendedor Senior"){
							header("Location:" . base_url() . "index.php/index/pos");								
						}elseif($desc_rol == "vendedor junior" || $desc_rol == "vendedor senior"){
							header("Location:" . base_url() . "index.php/index/pos");	
						}elseif($desc_rol == "VENDEDOR junior" || $desc_rol == "VENDEDOR senior"){
							header("Location:" . base_url() . "index.php/index/pos");																
						}else{
	                        header("Location:" . base_url() . "index.php/index/inicio");
						}
						
					}
					else {
						$msgError = "<br><div align='center' class='error'>Su usuario no tiene acceso a la informacion de ninguna empresa.</div>";
						$this->index($msgError);
					}
				}
				else {
					$msgError = "<br><div align='center' class='error'>Su usuario no tiene acceso a la informacion de ninguna empresa.</div>";
					$this->index($msgError);
				}
			}
			else {
				$msgError = "<br><div align='center' class='error'>Usuario y/o contraseña no valido.</div>";
				$this->index($msgError);
			}
		}
	}

	public function inicio($j = 0, $k = 0){
		$fecha = date("Y-m-d");
		$data = array();

		$tcInfo = $this->tipocambio_model->getTCday($fecha);
		$faltan = 0;

		if ($tcInfo != NULL){
			foreach ($tcInfo as $key => $value){
				if ( $value->TIPCAMC_FactorConversion == NULL || $value->TIPCAMC_FactorConversion == 0 )
					$faltan = 1;
			}

			$data["tcf"] = $faltan;
		}
		else{
			$data["tcf"] = 1;
			echo "aqui";
		}

		$data["compania"] = $compania;
		$data["nombre_empleado"] = $_SESSION['nombre_persona'];

		$this->layout->view("seguridad/inicio", $data);
	}

	public function salir_sistema(){
		session_destroy();
		unset($_SESSION);
		header("Location:".$this->base_url);
	}

	public function seleccionar_compania(){
		$array_empresas = $this->compania_model->listar_empresas();
		$arreglo = array();
		foreach ($array_empresas as $indice => $valor) {
			$empresa = $valor->EMPRP_Codigo;
			$datos_empresa = $this->empresa_model->obtener_datosEmpresa($empresa);
			$razon_social = $datos_empresa[0]->EMPRC_RazonSocial;
			$arreglo[] = array('tipo' => '1', 'nombre' => $razon_social, 'empresa' => $empresa);
		}
		return $arreglo;
	}

	/**gcbq:ponemos en session el menu seleccionado**/
	public function sessionMenuSeleccion(){
		$idMenuSeleccionado = $this->input->post('idMenuSeleccionadoReal');
		$idMenuSub = $this->input->post('idMenusubReal');

		if($idMenuSeleccionado!=null && $idMenuSeleccionado!=0)
			$_SESSION['idMenuSeleccionado']=$idMenuSeleccionado;
		else
			unset($_SESSION['idMenuSeleccionado']);

		if($idMenuSub!=null && $idMenuSub!=0)
			$_SESSION['idMenuSub']=$idMenuSub;
		else
			unset($_SESSION['idMenuSub']);
	}



}
?>