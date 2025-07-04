<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/* *********************************************************************************
Autor: Unknow
Fecha: Unknow

Dev: Rawil Ceballo -> RC
Dev: Luis Valdes	 -> LV


Dev: RC -> Begin
	- Metodo layout renombrado a __construct para corregir advertencia por tener mismo
		nombre que la libreria.
	- Esta libreria se carga automaticamente en todos los controladores.
	- Se agrega el atributo $base_url y se envia a todas las vistas (asi evitamos llamar
		varias veces a la misma funcion).
Dev: RC -> End
/* ******************************************************************************** */

class Layout{

	protected $obj;
	public $layout;
	public $base_url;

	public function __construct($layout = "layout/layout"){
		$this->obj =& get_instance();
		$this->layout = $layout;
		$this->obj->load->model('seguridad/permiso_model');
		$this->obj->load->model("almacen/producto_model");
		$this->obj->load->model("almacen/producto_model");
		$this->obj->load->model('ventas/tipocliente_model');
		$this->obj->load->model('almacen/almacen_model');
		$this->obj->load->helper('my_almacen_helper');

		$this->base_url = base_url();
	}

	public function setLayout($layout){
		$this->layout = $layout;
	}    

	public function view($view, $data = null, $return = false){
		$url = $this->base_url . "index.php/index/salir_sistema";

		## Dev: RC -> Begin
		## Obtenemos los datos de la sesion
		$empresa        = $this->obj->session->userdata('empresa');
		$compania       = $this->obj->session->userdata('compania');
		$nombre_empresa = $this->obj->session->userdata('nombre_empresa');
		$nombre_persona = $this->obj->session->userdata('nombre_persona');
		$persona        = $this->obj->session->userdata('persona');
		$user           = $this->obj->session->userdata('user');
		$nom_user       = $this->obj->session->userdata('user_name');
		$rol            = $this->obj->session->userdata('rol');
		$desc_rol       = $this->obj->session->userdata('desc_rol');

		## redirigimos al inicio si sesion contiene un valor NULL o ""
		if ($compania == NULL || $empresa == NULL || $user == NULL || $persona == NULL || $rol == NULL || $compania == "" || $empresa == "" || $user == "" || $persona == "" || $rol == "" ){
			header("Location: $url");
		}
		else{
			$lista_compania = $this->obj->usuario_compania_model->listar_compania();
			$lista_almacen  = $this->obj->almacen_model->getAlmacens();
			
			## Asignamos a $data los valores de la sesion que enviaremos a la vista
			$data["lista_compania"] = $lista_compania;
			$data["url"] 			= $url;
			$data["empresa"] 		= $empresa;
			$data["compania"]		= $compania;
			$data["nombre_empresa"] = $nombre_empresa;
			$data["nombre_persona"] = $nombre_persona;
			$data["persona"] 		= $persona;
			$data["user"] 			= $user;
			$data["nom_user"] 		= $nom_user;
			$data["desc_rol"] 		= $desc_rol;
			$data["base_url"] 		= $this->base_url;
			$data['cboAlmacenLa'] 	=  $lista_almacen;
			$data["precio_categorias"] = $this->obj->tipocliente_model->getCategorias();
			if ( !isset($data["tipo_oper"]) )
				$data["tipo_oper"] = "";

			$data["menus_base"] = $this->obj->permiso_model->obtener_permisosMenu($this->obj->session->userdata('rol'));

			$data["subMenu"]    = $this->obj->permiso_model->menuAccesoRapido($rol);

			## Se debe redefinir una consulta y/o alerta de stock que no sobre cargue el sistema en cada vista
			## Mientras tanto $data["productos"] = true
	    $data["productos"]  = true; #$this->obj->producto_model->stockMin(false);
		## Dev: RC -> End

	    $loadedData = array();
	    $loadedData['content_for_layout'] = $this->obj->load->view($view,$data,true);   

	    if($return){
	    	$output = $this->obj->load->view($this->layout, $loadedData, true);
	    	return $output;
	    }
	    else{
	    	$this->obj->load->view($this->layout, $loadedData, false);
	    }
  	}
  }
}

?>