<?php

class Proyecto extends Controller{

	private $empresa;
	private $compania;
	private $usuario;
	private $url;

	public function __construct(){
		parent::__construct();		
		$this->load->model('maestros/proyecto_model');
		$this->load->model('maestros/directivo_model');
		$this->load->model('maestros/compania_model');
		$this->load->model('maestros/persona_model');
		$this->load->model('maestros/ubigeo_model');
		$this->load->model('ventas/cliente_model');
		
		$this->load->library('layout','layout');
		
		$this->empresa = $this->session->userdata('empresa');
		$this->compania = $this->session->userdata('compania');
		$this->usuario = $this->session->userdata('user');
		$this->url = base_url();
	}

	public function index(){
		$this->listar();
	}

	#########################
  ###### FUNCTIONS NEWS
  #########################

	public function listar(){
		$data['base_url'] = $this->url;
		$data['titulo_busqueda'] = "BUSCAR PROYECTO";
		$data['titulo'] = "RELACIÓN DE PROYECTOS";
		$data["departamentos"] = $this->ubigeo_model->listar_departamentos();
    $data["provincias"] = $this->ubigeo_model->getProvincias("15");
    $data["distritos"] = $this->ubigeo_model->getDistritos("15","01");
		$this->layout->view('maestros/proyecto_index', $data);
	}

	public function datatable_proyecto(){
		$j = -1;
		$columnas = array(
			++$j => "EMPRC_Ruc",
			++$j => "EMPRC_RazonSocial",
			++$j => "PROYC_Nombre"
		);

		$filter = new stdClass();
		$filter->start = $this->input->post("start");
		$filter->length = $this->input->post("length");
		$filter->search = $this->input->post("search")["value"];

		$ordenar = $this->input->post("order")[0]["column"];
		if ($ordenar != ""){
			$filter->order = $columnas[$ordenar];
			$filter->dir = $this->input->post("order")[0]["dir"];
		}

		$item = ($this->input->post("start") != "") ? $this->input->post("start") : 0;

		$filter->cliente = $this->input->post('search_cliente');
		$filter->proyecto_titulo = $this->input->post('search_proyecto');

		$proyectoInfo = $this->proyecto_model->getProyectos($filter);
		$lista = array();

		if ($proyectoInfo != NULL) {
			foreach ($proyectoInfo as $indice => $valor) {
				$btn_editar = "<button type='button' onclick='editar($valor->PROYP_Codigo)' class='btn btn-default'>
												<img src='".$this->url."/images/modificar.png' class='image-size-1b'>
											</button>";

				$btn_info = "<button type='button' onclick='viewInfo($valor->PROYP_Codigo)' class='btn btn-default'>
												<img src='".$this->url."/images/icono-documentos.png' class='image-size-1b'>
											</button>";

				$btn_directions = "<button type='button' onclick='viewdirections($valor->PROYP_Codigo)' class='btn btn-default'>
												<img src='".$this->url."/images/icon-map.png' class='image-size-1b'>
											</button>";

				$btn_eliminar = "<button type='button' onclick='deshabilitar($valor->PROYP_Codigo)' class='btn btn-default'>
														<img src='".$this->url."/images/documento-delete.png' class='image-size-1b'>
												</button>";

				$j = -1;
				$lista[] = array(
					++$j => $valor->EMPRC_Ruc,
					++$j => $valor->EMPRC_RazonSocial,
					++$j => $valor->PROYC_Nombre,
					++$j => $btn_editar,
					++$j => $btn_directions,
					++$j => $btn_info,
					++$j => $btn_eliminar
				);
			}
		}

		unset($filter->start);
		unset($filter->length);

		$json = array(
			"draw"            => intval( $this->input->post('draw') ),
			"recordsTotal"    => count($this->proyecto_model->getProyectos()),
			"recordsFiltered" => intval( count($this->proyecto_model->getProyectos($filter)) ),
			"data"            => $lista
		);

		echo json_encode($json);
	}

	public function getProyecto(){

		$proyecto = $this->input->post("proyecto");

		$proyectoInfo = $this->proyecto_model->getProyecto($proyecto);
		$lista = array();
		$comprobantes = array();

		if ( $proyectoInfo != NULL ){
			foreach ($proyectoInfo as $indice => $val) {
				$lista = array(
					"proyecto" => $val->PROYP_Codigo,
					"cliente" => $val->CLIP_Codigo,
					"ruc" => $val->EMPRC_Ruc,
					"razon_social" => $val->EMPRC_RazonSocial,
					"nombre_proyecto" => $val->PROYC_Nombre,
					"fecha_inicio" => $val->PROYC_FechaInicio,
					"fecha_inicio_corta" => mysql_to_human($val->PROYC_FechaInicio),
					"fecha_final" => $val->PROYC_FechaFin,
					"fecha_final_corta" => mysql_to_human($val->PROYC_FechaFin),
					"descripcion_proyecto" => $val->PROYC_Descripcion
				);
			}

			$comprobantesInfo = $this->proyecto_model->getComprobantes($proyecto);
			if ( $comprobantesInfo != NULL ){
				foreach ($comprobantesInfo as $i => $val){
					$btn_pdfA4 = "<button type='button' class='btn btn-default' href='".$this->url."index.php/ventas/comprobante/comprobante_ver_pdf/".$val->CPP_Codigo."/a4' data-fancybox data-type='iframe'>
									<img src='".$this->url."images/pdf.png' class='image-size-1b'>
								</button>";
					$comprobantes[] = array(
													"empresa_emisora" => $val->EMPRC_RazonSocial,
													"codigo" => $val->CPP_Codigo,
													"serie" => $val->CPC_Serie,
													"numero" => $val->CPC_Numero,
													"moneda" => $val->MONED_Simbolo,
													"importe" => $val->CPC_Total,
													"fecha" => mysql_to_human($val->CPC_Fecha),
													"documento" => $val->documento,
													"estado" => $val->estado,
													"pdf" => $btn_pdfA4
												);
				}
			}

			$json = array("match" => true, "info" => $lista, "comprobantes" => $comprobantes);
		}
		else
			$json = array("match" => false, "info" => "", "comprobantes" => NULL);

		echo json_encode($json);
	}

	public function guardar_registro(){
		
		$proyecto = $this->input->post("proyecto");
		$cliente = $this->input->post("cliente");
		$nombre_proyecto = $this->input->post("nombre_proyecto");
		$fecha_inicio = $this->input->post("fecha_inicio");
		$fecha_final = $this->input->post("fecha_final");
		$descripcion_proyecto = $this->input->post("descripcion_proyecto");

		$filter = new stdClass();
		$filter->PROYC_Nombre = strtoupper($nombre_proyecto);
		$filter->PROYC_Descripcion = strtoupper($descripcion_proyecto);
		$filter->PROYC_FechaInicio = ($fecha_inicio == "") ? date("Y-m-d") : $fecha_inicio;
		$filter->PROYC_FechaFin = ($fecha_final == "") ? date("Y-m-d") : $fecha_final;
		$filter->PROYC_CodigoUsuario = $this->usuario;
		$filter->CLIP_Codigo = $cliente;
		$filter->PROYC_FlagEstado = "1";

		if ($proyecto != ""){
			$filter->PROYP_Codigo = $proyecto;
			$filter->PROYC_FechaModificacion = date("Y-m-d H:i:s");
			$result = $this->proyecto_model->actualizar_proyecto($proyecto, $filter);
		}
		else{
			$filter->PROYC_FechaRegistro = date("Y-m-d H:i:s");
			$result = $this->proyecto_model->insertar_proyecto($filter);
		}


		if ($result)
			$json = array("result" => "success");
		else
			$json = array("result" => "error");

		echo json_encode($json);
	}

	public function deshabilitar_proyecto(){

		$proyecto = $this->input->post("proyecto");

		$filter = new stdClass();
		$filter->PROYC_FlagEstado  = "0";

		if ($proyecto != ""){
			$filter->PROYC_FechaModificacion = date("Y-m-d H:i:s");
			$result = $this->proyecto_model->deshabilitar_proyecto($proyecto, $filter);
		}

		if ($result)
			$json = array("result" => "success");
		else
			$json = array("result" => "error");

		echo json_encode($json);
	}


  ## DIRECTIONS
  #########################

	public function datatable_directions(){
			$posDT = -1;
      $columnas = array(
                          ++$posDT => "DIRECC_Descrip",
                          ++$posDT => "DIRECC_Referen",
                          ++$posDT => "dpto",
                          ++$posDT => "prov",
                          ++$posDT => "dist"
                      );
      
      $filter = new stdClass();
      $filter->start = $this->input->post("start");
      $filter->length = $this->input->post("length");
      $filter->search = $this->input->post("search")["value"];

      $ordenar = $this->input->post("order")[0]["column"];
      if ($ordenar != ""){
          $filter->order = $columnas[$ordenar];
          $filter->dir = $this->input->post("order")[0]["dir"];
      }

      $item = ($this->input->post("start") != "") ? $this->input->post("start") : 0;

      $filter->proyecto = $this->input->post('proyecto');
      $directionsInfo = $this->proyecto_model->getDirections($filter);
      
      $lista = array();
      if ( $directionsInfo != NULL) {
          foreach ($directionsInfo as $indice => $valor) {
              $btn_editar = "<button type='button' onclick='editar_directions($valor->DIRECC_Codigo)' class='btn btn-default'>
                              <img src='".$this->url."/images/modificar.png' class='image-size-1b'>
                          </button>";

              $btn_deshabilitar = "<button type='button' onclick='disable_directions($valor->DIRECC_Codigo, $valor->PROYP_Codigo)' class='btn btn-default'>
                              <img src='".$this->url."/images/documento-delete.png' class='image-size-1b'>
                          </button>";
              $posDT = -1;
              $lista[] = array(
                                ++$posDT => $valor->DIRECC_Descrip,
                                ++$posDT => $valor->DIRECC_Referen,
                                ++$posDT => $valor->dpto,
                                ++$posDT => $valor->prov,
                                ++$posDT => $valor->dist,
                                ++$posDT => $btn_editar,
                                ++$posDT => $btn_deshabilitar
                              );
          }
      }

      unset($filter->start);
      unset($filter->length);

      $json = array(
                          "draw"            => intval( $this->input->post('draw') ),
                          "recordsTotal"    => count($this->proyecto_model->getDirections()),
                          "recordsFiltered" => intval( count($this->proyecto_model->getDirections($filter)) ),
                          "data"            => $lista
                  );

      echo json_encode($json);
  }

  public function getDirection(){

		$direction = $this->input->post("direction");

		$directionInfo = $this->proyecto_model->getDirection($direction);
		$lista = array();

		if ( $directionInfo != NULL ){
			foreach ($directionInfo as $indice => $val) {
				$lista = array(
					"direction_id" => $val->DIRECC_Codigo,
					"proyecto" => $val->PROYP_Codigo,
					"direccion" => $val->DIRECC_Descrip,
					"referencia" => $val->DIRECC_Referen,
					
					"departamento" => substr($val->UBIGP_Domicilio, 0, 2),
          "provincia" => substr($val->UBIGP_Domicilio, 2, 2),
          "distrito" => substr($val->UBIGP_Domicilio, 4, 2)					
				);
			}

			$json = array("match" => true, "info" => $lista);
		}
		else
			$json = array("match" => false, "info" => "");

		echo json_encode($json);
	}

  public function save_direction(){
		
		$id = $this->input->post("direction_id");
		$proyecto = $this->input->post("proyecto_id");
		$direccion = $this->input->post("direccion_proyecto");
		$referencia = $this->input->post("referencia_proyecto");

	  $departamento = $this->input->post("departamento");
	  $provincia = $this->input->post("provincia");
	  $distrito = $this->input->post("distrito");
	  $ubigeo = $departamento.$provincia.$distrito;

		$filter = new stdClass();
		$filter->DIRECC_Descrip = $direccion;
		$filter->DIRECC_Referen = $referencia;
		$filter->PROYP_Codigo = $proyecto;
		$filter->UBIGP_Domicilio = $ubigeo;
		$filter->DIRECC_CodigoUsuario = $this->usuario;
		$filter->DIRECC_FlagEstado = "1";

		if ($id != ""){
			$filter->DIRECC_FechaModificacion = date("Y-m-d H:i:s");
			$result = $this->proyecto_model->updateDirection($id, $filter);
		}
		else{
			$filter->DIRECC_FechaRegistro = date("Y-m-d H:i:s");
			$result = $this->proyecto_model->saveDirection($filter);
		}


		if ($result)
			$json = array("result" => "success");
		else
			$json = array("result" => "error");

		echo json_encode($json);
	}

  public function disable_direction(){

      $direccion = $this->input->post("direccion");

      $filter = new stdClass();
      $filter->DIRECC_FlagEstado = "0";
      $filter->DIRECC_FechaModificacion = date("Y-m-d H:i:s");

      if ($direccion != "")
          $direccion = $this->proyecto_model->updateDirection($direccion, $filter);

      if ($direccion)
          $json = array("result" => "success");
      else
          $json = array("result" => "error");
      
      echo json_encode($json);
  }

    #########################
    ###### FUNCTIONS OLDS
    #########################


	public function proyectos($j=0){
		$data['nombres']       = "";
		$data['descripcion']    = "";
		$data['encargado']  = "";
		$data['titulo_tabla']  = "RELACIÓN DE PROYECTOS";
		$data['registros'] =  count($this->proyecto_model->listar_proyectos());
		$data['action'] = base_url()."index.php/maestros/proyecto/buscar_proyectos";
		$conf['base_url'] = site_url('maestros/proyecto/buscar_proyectos/');
		$conf['total_rows'] = $data['registros'];
		$conf['per_page'] = 50;
		$conf['num_links']  = 3;
		$conf['next_link'] = "&gt;";
		$conf['prev_link'] = "&lt;";
		$conf['first_link'] = "&lt;&lt;";
		$conf['last_link']  = "&gt;&gt;";
		$conf['uri_segment'] = 4;
		$this->pagination->initialize($conf);
		$data['paginacion'] = $this->pagination->create_links();
		$listado_proyectos = $this->proyecto_model->listar_proyectos($conf['per_page'],$j);
		$item        = $j+1;
		$lista           = array();
		if(count($listado_proyectos)>0){
			foreach($listado_proyectos as $indice=>$valor){
				$codigo        = $valor->PROYP_Codigo;
				$nombre        = $valor->PROYC_Nombre;
				$descripcion   = $valor->PROYC_Descripcion;
				$directivo     = $valor->DIREP_Codigo;
				if($directivo!=0){
					$temp          = $this->directivo_model-> obtener_directivo($directivo);
					$persona       = $temp[0]->PERSP_Codigo;
					$temp2         = $this->persona_model->obtener_datosPersona($persona);
					$encargado     = $temp2[0]->PERSC_Nombre;
				}else{
					$encargado="";
				}

				$editar         = "<a href='javascript:;' onclick='editar_proyecto(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
				$ver            = "<a href='javascript:;' onclick='ver_comprobantes_proyecto(".$codigo.")' data-toggle='modal' data-target='#ver_Proyectos' ><img src='".base_url()."images/proyecto.png' width='16' height='16' border='0' title='Ver'></a>";
				$eliminar       = "<a href='javascript:;' onclick='eliminar_proyecto(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Eliminar'></a>";
				$lista[]        = array($item,$nombre,$descripcion,$encargado,$editar,$ver,$eliminar,$codigo);
				$item++;
			}
		}
		$data['lista'] = $lista;
		$this->layout->view("maestros/proyecto_index",$data);
	}



	public function nuevo_proyecto(){

		$data['modo']  = "insertar"; 	   
		$objeto = new stdClass();
		$objeto->id     = "";
		$objeto->idDire     = "";
		$objeto->nombres     = "";
		$objeto->descripcion    = "";
		$objeto->fechai     = form_input(array("name"=>"fechai","id"=>"fechai","class"=>"cajaPequena","readonly"=>"readonly","maxlength"=>"10","value"=>""));
		$objeto->fechaf     = form_input(array("name"=>"fechaf","id"=>"fechaf","class"=>"cajaPequena","readonly"=>"readonly","maxlength"=>"10","value"=>""));
		$data['url_action'] = base_url() . "index.php/maestros/proyecto/insertar_proyecto";
		$data['descripcionDireccion'] = "";
		$data['referenciaDireccion'] = "";
		$data['cordenadaY'] = "";
		$data['cordenadaX'] = "";
		$data['cboDepartamento']  = $this->seleccionar_departamento('15');
		$data['cboProvincia']  = $this->seleccionar_provincia('15','01');
		$data['cboDistrito']  = $this->seleccionar_distritos('15','01');
		$data['datos'] = $objeto;
		$data['titulo'] = "REGISTRAR PROYECTO";
// 	   $data['listado_proyectos']  = array();
		$data['nombreProyecto'] = "";
		$data['descpProyecto'] = "";
		$data['detalle_direccion'] = array();
		$data['fechai'] = form_input(array("name"=>"fechai","id"=>"fechai","class"=>"cajaPequena","readonly"=>"readonly","maxlength"=>"10","value"=>""));
		$data['fechaf'] = form_input(array("name"=>"fechaf","id"=>"fechaf","class"=>"cajaPequena","readonly"=>"readonly","maxlength"=>"10","value"=>""));
		$data['cbo_clientes'] = $this->OPTION_generador($this->cliente_model->listar_cliente(), 'CLIP_Codigo', 'nombre', '');
		$data['direProyecto'] = "";
		$data["id_proyecto"] = "";
		$this->load->view("maestros/proyecto_nuevo",$data);
	}


	public function insertar_proyecto(){
		/** INSERTAR DATOS DEL PROYECTO **/
		$nombreProyecto = $this ->input -> post('nombreProyecto');
		$descpProyecto  = $this ->input -> post('descpProyecto');
		$fechai         = $this ->input -> post('fechai');
		$fechaf         = $this ->input -> post('fechaf');
		$cbo_clientes   = $this ->input -> post('cbo_clientes');
		$proyecto = $this->proyecto_model->insertar_datosProyecto($nombreProyecto,$descpProyecto,$fechai,$fechaf,$cbo_clientes);

		/** INSERTAR DATOS DE DIRECCI? **/
		$direccionCodigo  = $this ->input -> post('direccionCodigo');
		$descripcionDireccion  = $this ->input -> post('descripcionDireccion');
		$referenciaDireccion   = $this ->input -> post('referenciaDireccion');
		$cboDepartamento   = $this->input->post('cboDepartamentoD');
		$cboProvincia      = $this->input->post('cboProvinciaD');
		$cboDistrito       = $this->input->post('cboDistritoD');
		$cordenadaY     = $this->input->post('cordenadaY');
		$cordenadaX     = $this->input->post('cordenadaX');
		$direaccion 		= $this->input->post('direaccion');

		if(is_array($direccionCodigo)){
			foreach ($direccionCodigo as $indice => $valor){
				if($valor != $direccionCodigo){
					$filter = new stdClass();
					$filter ->DIRECC_Descrip = $descripcionDireccion[$indice];
					$filter ->DIRECC_Referen = $referenciaDireccion[$indice];
					$ubigeo_domicilio = $cboDepartamento[$indice].$cboProvincia[$indice].$cboDistrito[$indice];
					$filter ->UBIGP_Domicilio = $ubigeo_domicilio;
					$filter ->PROYP_Codigo = $proyecto;
					$filter ->DIRECC_Mapa = $cordenadaX[$indice];
					$filter ->DIRECC_StreetView = $cordenadaY[$indice];
					if ($direaccion[$indice] != 'e') {
						$this->proyecto_model->insertar_direccion($filter);
					}
				}
			}
		}               
		$this->proyectos();
	}


	public function editar_proyecto($proyecto){
		$compania=$this->somevar ['compania'];
		$temp =$this->compania_model->obtener_compania($compania);
		$empresa=$temp[0]->EMPRP_Codigo;

		$lista_directivos= $this->directivo_model->listar_directivo($empresa);

		$data['modo']	 = "modificar";
		$data['id']	  	 = $this->input->post('id');
		$datos_proyecto   = $this->proyecto_model->obtener_datosProyecto($proyecto);
		$nombreProyecto   = $datos_proyecto[0]->PROYC_Nombre;
		$descpProyecto    = $datos_proyecto[0]->PROYC_Descripcion;
		$fechai           = $datos_proyecto[0]->PROYC_FechaInicio;
		$fechaf           = $datos_proyecto[0]->PROYC_FechaFin;

		/* OBTENER DATOS DE DIRECCI? */
		$datos_direccion  	  = $this->proyecto_model->obtener_direccion($proyecto);
		$detalle_direccion 	  = $this->listar_detalle($proyecto);                

		$data['nombreProyecto']   = $nombreProyecto;
		$data["id_proyecto"] = $datos_proyecto[0]->PROYP_Codigo;
		$data['descpProyecto']    = $descpProyecto;
		$data['cbo_clientes'] 	  = $this->OPTION_generador($this->cliente_model->listar_cliente(), 'CLIP_Codigo', 'nombre',  $datos_proyecto[0] -> EMPRP_Codigo);
		$data['fechai']           = form_input(array("name"=>"fechai","id"=>"fechai","class"=>"cajaPequena","readonly"=>"readonly","maxlength"=>"10","value"=>$fechai));
		$data['fechaf']           = form_input(array("name"=>"fechaf","id"=>"fechaf","class"=>"cajaPequena","readonly"=>"readonly","maxlength"=>"10","value"=>$fechaf));
		$oculto               	  = form_hidden(array('accion'=>"",'codigo'=>$proyecto,'modo'=>"modificar",'base_url'=>base_url()));
		$data['oculto']           = $oculto;


		/* MOSTRAR DATOS DE DIRECCI? */

		$data['descripcionDireccion']  = "";
		$data['referenciaDireccion']   = "";   		        
		$data['cboDepartamento'] 	   = $this->seleccionar_departamento("");
		$data['cboProvincia'] 		   = $this->seleccionar_provincia("", "");
		$data['cboDistrito'] 		   = $this->seleccionar_distritos("", "", "");
		$data['cordenadaY']			   = "";
		$data['cordenadaX']			   = "";

		$data['detalle_direccion']     = $detalle_direccion;



		if($detalle_direccion!=null && count($detalle_direccion)>0){
			foreach ($detalle_direccion as $key=>$valor){
				$ubigeo_domicilio=$valor->UBIGP_Domicilio;
				$datosDepartamentoD=$this->ubigeo_model->obtener_ubigeo_dpto($ubigeo_domicilio);
				$nombreDepartamentoD='NO DEFINIDO';
				if(count($datosDepartamentoD)>0)
					$nombreDepartamentoD=$datosDepartamentoD[0]->UBIGC_Descripcion;

				$datosProvinciaD=$this->ubigeo_model->obtener_ubigeo_prov($ubigeo_domicilio);
				$nombreProvinciaD='NO DEFINIDO';
				if(count($datosProvinciaD)>0)
					$nombreProvinciaD=$datosProvinciaD[0]->UBIGC_Descripcion;

				$datosDistritoD=$this->ubigeo_model->obtener_ubigeo_dist($ubigeo_domicilio);
				$nombreDistritoD='NO DEFINIDO';
				if(count($datosDistritoD)>0)
					$nombreDistritoD=$datosDistritoD[0]->UBIGC_Descripcion;


				$data['nombreDepartamentoD'][]	=$nombreDepartamentoD;
				$data['nombreProvinciaD'][] 	=$nombreProvinciaD;
				$data['nombreDistritoD'][] 		=$nombreDistritoD;
			}
		}

		$objeto                 = new stdClass();
		$objeto->id             = $datos_proyecto[0]->PROYP_Codigo;
		$objeto->nombres        = $datos_proyecto[0]->PROYC_Nombre;
		$objeto->descripcion    = $datos_proyecto[0]->PROYC_Descripcion;
		$objeto->cbo_clientes   = $datos_proyecto[0]->EMPRP_Codigo;
		$objeto->fechai         = $datos_proyecto[0]->PROYC_FechaInicio;
		$objeto->fechaf         = $datos_proyecto[0]->PROYC_FechaFin;
		$data['datos']    		= $objeto;
		$data['titulo']  		= "EDITAR PROYECTO ::: ";
		$this->load->view("maestros/proyecto_nuevo",$data);
	}

	public function ver_proyecto($proyecto)
	{

		$datos   = $this->proyecto_model->obtener_datosProyecto($proyecto);
		$data['nombres']             = $datos[0]->PROYC_Nombre;
		$data['descripcion']         = $datos[0]->PROYC_Descripcion;
		$data['encargado']           = $datos[0]->DIREP_Codigo;
		$data['datos']  = $datos;
		$data['titulo'] = "VER PROYECTO";
		$this->load->view('maestros/proyecto_ver',$data);
	}

	public function obtener_comprobantes_proyecto()
	{
		$datos = array();
		$id_proyecto = $this->input->post('proyecto');
		$detalle = $this->proyecto_model->obtener_datosProyecto($id_proyecto);
		$comprobantes_proyecto = $this->proyecto_model->obtener_comprobantesxproyecto($id_proyecto);
		if (count($comprobantes_proyecto)>0 && count($detalle)>0) {
			foreach ($comprobantes_proyecto as $key => $value) {
          $cod_comprobante   = $value->CPP_Codigo; 
          $serie   = $value->CPC_Serie;
          $numero  = $value->CPC_Numero;
          $cliente = $value->CLIP_Codigo;
          $monto_total = $value->CPC_total;
          $fecha = $value->CPC_FechaModificacion;
          $empresa = $value->EMPRC_RazonSocial;
          $nombre_proyecto = $detalle[0]->PROYC_Nombre;
          $tipo_documento = $value->CPC_TipoDocumento;
          $datos[] = array(
          	'message' => 1,
          	'cod_comprobante' => $cod_comprobante,
          	'tipo_documento' => $tipo_documento,
          	'serie' => $serie,
          	'numero' => $numero,
          	'cliente' => $cliente,
          	'monto' => $monto_total,
          	'fecha' => $fecha,
          	'razon_social' => $empresa,
          	'proyecto' => $nombre_proyecto
          );   
        }

        echo json_encode($datos);
      }else{
      	$datos[] = array(
      		'message' => 0,
      		'cod_comprobante' => '',
      		'tipo_documento' => '',
      		'serie' => '',
      		'numero' => '',
      		'cliente' => '',
      		'monto' => '',
      		'fecha' => '',
      		'razon_social' => '',
      		'proyecto' => ''
      	);   
      	echo json_encode($datos);
      }
    }

    public function modificar_proyecto(){

    	$codigo             = $this->input->post('proyecto');
    	$nombreProyecto     = $this->input->post('nombreProyecto');
    	$descpProyecto      = $this->input->post('descpProyecto');
    	$cbo_clientes       = $this->input->post('cbo_clientes');
    	$fechai             = $this->input->post('fechai');
    	$fechaf             = $this->input->post('fechaf');	
    	$this->proyecto_model->modificar_datosProyecto($codigo,$nombreProyecto,$descpProyecto,$cbo_clientes,$fechai,$fechaf);

    	$direccionCodigo 	  = $this->input->post('direccionCodigo');
    	$descripcionDireccion = $this->input->post('descripcionDireccion');	
    	$referenciaDireccion  = $this->input->post('referenciaDireccion');

    	$cboDepartamento      = $this->input->post('cboDepartamentoD');
    	$cboProvincia         = $this->input->post('cboProvinciaD');
    	$cboDistrito          = $this->input->post('cboDistritoD');
    	$cordenadaX 		  = $this->input->post('cordenadaX');	
    	$cordenadaY           = $this->input->post('cordenadaY');
    	$direaccion 		  = $this->input->post('direaccion');
    	if (is_array($direccionCodigo) > 0) {
    		foreach ($direccionCodigo as $indice => $valor) {
    			$detalle_accion = $direaccion[$indice];
    			$filter = new stdClass();
    			$filter->DIRECC_Descrip   = $descripcionDireccion[$indice];
    			$filter->DIRECC_Referen   = $referenciaDireccion[$indice];
    			$ubigeo_domicilio = $cboDepartamento[$indice].$cboProvincia[$indice].$cboDistrito[$indice];
    			$filter ->UBIGP_Domicilio = $ubigeo_domicilio;
    			$filter->DIRECC_Mapa   	  = $cordenadaX[$indice];
    			$filter->DIRECC_StreetView  = $cordenadaY[$indice];
    			$filter->PROYP_Codigo 	  = $codigo;

    			if ($detalle_accion == 'n') {
    				$this->proyecto_model->insertar_direccion($filter);
    			} elseif ($detalle_accion == 'm') {
    				$this->proyecto_model->modificar_direccion($valor, $filter);
    			} elseif ($detalle_accion == 'e') {
    				$this->proyecto_model->eliminar_direccion($valor);
    			}

    		}
    	}

    }





    public function buscar_proyectos($j='0'){
    	$filter = new stdClass();
    	$filter->PROYC_Nombre = $this->input->post('nombres');
    	$data['nombres']      = $filter->PROYC_Nombre;
    	$data['titulo_tabla']    = "RESULTADO DE BÚSQUEDA DE PROYECTOS";
    	$data['registros']  = count($this->proyecto_model->buscar_proyectos($filter));
    	$data['action'] = base_url()."index.php/maestros/proyecto/buscar_proyectos";
    	$conf['base_url'] = site_url('maestros/proyecto/buscar_proyectos/');
    	$conf['total_rows'] = $data['registros'];
    	$conf['per_page']   = 10;
    	$conf['num_links']  = 3;
    	$conf['next_link'] = "&gt;";
    	$conf['prev_link'] = "&lt;";
    	$conf['first_link'] = "&lt;&lt;";
    	$conf['last_link']  = "&gt;&gt;";
    	$conf['uri_segment'] = 4;
    	$this->pagination->initialize($conf);
    	$data['paginacion'] = $this->pagination->create_links();
    	$listado_proyectos = $this->proyecto_model->buscar_proyectos($filter, $conf['per_page'],$j);
    	$item            = $j+1;
    	$lista           = array();
    	if(count($listado_proyectos)>0){
    		foreach($listado_proyectos as $indice=>$valor){
    			$proyecto       = $valor->PROYP_Codigo;
    			$nombres        = $valor->PROYC_Nombre;
    			$descripcion    = $valor->PROYC_Descripcion;
    			$encargado      = $valor->DIREP_Codigo;
    			$editar         = "<a href='#' onclick='editar_proyecto(".$proyecto.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
    			$ver            = "<a href='#' onclick='ver_proyecto(".$proyecto.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
    			$eliminar       = "<a href='#' onclick='eliminar_proyecto(".$proyecto.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
    			$lista[]        = array($item,$nombres,$descripcion,$encargado,$editar,$ver,$eliminar);
    			$item++;
    		}
    	}
    	$data['lista'] = $lista;
    	$this->layout->view("maestros/proyecto_index",$data);

    }


    public function eliminar_proyecto(){
    	$proyecto = $this->input->post('proyecto');
    	$this->proyecto_model->eliminar_proyecto($proyecto);
    }


    /*Agregado*/

    public function JSON_listar_proyecto($cliente){

    	$lista_todos=array();
    	$datoCliente = $this->cliente_model->obtener($cliente);


    	$listado_proyectos = $this->proyecto_model->listar_proyetos_cliente($datoCliente ->empresa);
    	foreach ($listado_proyectos as $key => $datos_proyecto) {

    		$objeto = new stdClass();
    		$objeto->PROYP_Codigo = $datos_proyecto->PROYP_Codigo;;
    		$objeto->nombre = $datos_proyecto->PROYC_Nombre;;
    		$objeto->descripcion = $datos_proyecto->PROYC_Descripcion;;
    		$lista_detalles[] = $objeto;

    	}
    	$resultado[] = array('Tipo' => '1', 'Titulo' => 'Los establecimientos de mi cliente');
    	$resultado = json_encode($lista_detalles);

    	echo  $resultado;
    }

    public function JSON_listar_departamento()
    {
    	echo json_encode($this->ubigeo_model->listar_depa($depa));
    }


    public function seleccionar_departamento($indDefault=''){
    	$array_dpto = $this->ubigeo_model->listar_departamentos();
    	$arreglo = array();
    	if(count($array_dpto)>0){
    		foreach($array_dpto as $indice=>$valor){
    			$indice1   = $valor->UBIGC_CodDpto;
    			$valor1    = $valor->UBIGC_DescripcionDpto;
    			$arreglo[$indice1] = $valor1;
    		}
    	}
    	$resultado = $this->html->optionHTML($arreglo,$indDefault,array('00','::Seleccione::'));
    	return $resultado;
    }


    public function seleccionar_provincia($departamento,$indDefault=''){
    	$array_prov = $this->ubigeo_model->listar_provincias($departamento);
    	$arreglo = array();
    	if(count($array_prov)>0){
    		foreach($array_prov as $indice=>$valor){
    			$indice1   = substr($valor->UBIGC_CodProv,2,2);
    			$valor1    = $valor->UBIGC_DescripcionProv;
    			$arreglo[$indice1] = $valor1;
    		}
    	}
    	$resultado = $this->html->optionHTML($arreglo,$indDefault,array('00','::Seleccione::'));
    	return $resultado;
    }


    public function seleccionar_distritos($departamento,$provincia,$indDefault=''){
    	$array_dist = $this->ubigeo_model->listar_distritos($departamento,$provincia);
    	$arreglo = array();
    	if(count($array_dist)>0){
    		foreach($array_dist as $indice=>$valor){
    			$indice1   = substr($valor->UBIGC_CodDist,4,2);
    			$valor1    = $valor->UBIGC_Descripcion;
    			$arreglo[$indice1] = $valor1;
    		}
    	}
    	$resultado = $this->html->optionHTML($arreglo,$indDefault,array('00','::Seleccione::'));
    	return $resultado;
    }



    public function listar_detalle($proyecto)
    {
    	$detalle = $this->proyecto_model->listar_detalle($proyecto);
    	$lista_detalles = array();
    	if (count($detalle) > 0) {
    		foreach ($detalle as $indice => $valor) {
    			$direccionCodigo 	  = $valor->DIRECC_Codigo;
    			$descripcionDireccion = $valor->DIRECC_Descrip;
    			$referenciaDireccion  = $valor->DIRECC_Referen;
    			$ubigeo_domicilio 	  = $valor->UBIGP_Domicilio;			
    			$cordenadaX 		  = $valor->DIRECC_Mapa;
    			$cordenadaY 		  = $valor->DIRECC_StreetView;

    			$objeto = new stdClass();
    			$objeto->DIRECC_Codigo= $direccionCodigo;
    			$objeto->DIRECC_Descrip = $descripcionDireccion;
    			$objeto->DIRECC_Referen = $referenciaDireccion;
    			$objeto ->UBIGP_Domicilio = $ubigeo_domicilio;		
    			$objeto->DIRECC_Mapa = $cordenadaX;
    			$objeto->DIRECC_StreetView = $cordenadaY;
    			$lista_detalles[] = $objeto;
    		}
    	}
    	return $lista_detalles;
    }

    public function get_adelantos_saldo($id_proyecto, $oper = "V")
    {
    	$res = array();

    	$total_adelanto_dolares = 0;
    	$porcentaje100_adelanto = 0;

    	$this->load->model("ventas/comprobante_model");
    	foreach ($this->comprobante_model->get_adelantos_by_id_proyecto($id_proyecto, $oper) as $adelanto) {
    		$tdc = $adelanto->MONED_Codigo == 1 ? 1 : $adelanto->CPC_TDC;
    		$tdc_dolar = $adelanto->MONED_Codigo >2 ? $adelanto->CPC_TDC_opcional : $adelanto->CPC_TDC;

    		$total_adelanto_dolares += ($adelanto->CPC_subtotal * $tdc) / $tdc_dolar;

    		preg_match_all("/[0-9]{1,2}(?=%)/i", $adelanto->CPDEC_Descripcion, $porcentajes);
    		$porcentaje100_adelanto += intval($porcentajes[0][0]);

    	}

    	$total_descontado_dolares = 0;

    	foreach ($this->comprobante_model->get_consumo_adelantos_by_id_proyecto($id_proyecto, $oper) as $consumo) {
    		$tdc = $adelanto->MONED_Codigo == 1 ? 1 : $adelanto->CPC_TDC;
    		$tdc_dolar = $adelanto->MONED_Codigo >2 ? $adelanto->CPC_TDC_opcional : $adelanto->CPC_TDC;

    		$total_descontado_dolares += $consumo->CPC_descuento;
    	}

    	$res["total_dolares"] = $total_adelanto_dolares;
    	$res["saldo_dolares"] = $total_adelanto_dolares - $total_descontado_dolares;
    	$res["porcentaje"] = $porcentaje100_adelanto;

    	echo json_encode($res);
    }

    public function estado($id_proyecto, $tipo)
    {
    	$res = array(
    		"total_soles" => 0,
    		"total_dolares" => 0,
    		"total_facturado" => 0,
    		"total_facturado_saldo" => 0,
    		"total_pagado" => 0,
    		"total_pagado_saldo" => 0,
    		"ordenes" => array()
    	);

    	$this->load->model("compras/ocompra_model");
    	$ordenes = $this->ocompra_model->listar_by_id_proyecto_tipo($id_proyecto, $tipo);

    	foreach ($ordenes as $orden) {
    		$tdc = strtolower($orden->MONED_smallName) == 'sol' ? 1 : $orden->OCOMP_TDC;
    		$tdc_dolar = strtolower($orden->MONED_smallName) == 'eur' ? $orden->OCOMP_TDC_opcional : $orden->OCOMP_TDC;

    		$total = isset($orden->OCOMDEC_Subtotal_calculado) ? floatval($orden->OCOMDEC_Subtotal_calculado) : floatval($orden->OCOMC_subtotal);
    		$total_soles = $total * $tdc;
    		$total_dolares = $total_soles / $tdc_dolar;

    		$total_facturado = 0;
    		$total_pagado = 0;
    		$comprobantes = array();

    //obteniendo los adelantos
    		foreach ($this->comprobante_model->listar_adelantos_by_id($orden->OCOMP_Codigo, $tipo) as $adelanto) {
    			$comprobante_total = floatval($adelanto->CPC_subtotal);

    			$comprobante_tdc = strtolower($adelanto->MONED_smallName) == 'sol' ? 1 : $adelanto->CPC_TDC;
    			$comprobante_tdc_dolar = strtolower($adelanto->MONED_smallName) == "eur" ? $adelanto->CPC_TDC_opcional : $adelanto->CPC_TDC;

    			$comprobante_soles = $comprobante_total * $comprobante_tdc;
    			$comprobante_dolares = $comprobante_soles / $comprobante_tdc_dolar;

    			$total_facturado += $comprobante_dolares;
    			$total_pagado_dolares = 0;

    			$total_facturado_100 = $comprobante_dolares * 100 / $adelanto->CPC_subtotal;

      #pagos
    			$this->load->model("tesoreria/cuentas_model");
    			foreach ($this->cuentas_model->suma_pago_by_id_comprobante($adelanto->CPP_Codigo, $tipo) as $pago) {
    				$pago_tdc = strtolower($pago->MONED_smallName) == 'sol' ? 1 : $pago->CPAGC_TDC;
    				$pago_tdc_dolar = $pago->CPAGC_TDC;

    				$pago_total = $pago->CPAGC_Monto;
    				$pago_soles = $pago_total * $pago_tdc;
    				$pago_dolares = $pago_soles / $pago_tdc_dolar;

    				$total_pagado_dolares += $pago_dolares * $total_facturado_100 / 100;
    			}

    			$total_pagado += $total_pagado_dolares;

    			$comprobantes[] = array(
    				"fecha" => "ADELANTO - " . mysql_to_human($adelanto->CPC_Fecha),
    				"cliente" => isset($adelanto->EMPRC_RazonSocial) ? $adelanto->EMPRC_RazonSocial : ($adelanto->PERSC_ApellidoPaterno." ".$adelanto->PERSC_ApellidoMaterno.", ".$adelanto->PERSC_Nombre),
    				"comprobante_numero" => $adelanto->CPC_TipoDocumento." ".str_pad(intval($adelanto->CPC_Serie), 3, '0', STR_PAD_LEFT)."-".str_pad(intval($adelanto->CPC_Numero), 6, '0', STR_PAD_LEFT),
    				"comprobante_link" => "https://www.google.com",
    				"moneda" => $adelanto->MONED_Simbolo,
    				"total" => $comprobante_total,
    				"total_soles" => $comprobante_soles,
    				"total_dolares" => $comprobante_dolares,
    				"total_pagado_dolares" => $total_pagado_dolares,
    				"total_pagado_saldo" => ($comprobante_dolares - $total_pagado_dolares)
    			);
    		}

    		$this->load->model("ventas/comprobantedetalle_model");
    		foreach ($this->comprobantedetalle_model->listar_estado_by_id_orden_tipo($orden->OCOMP_Codigo, $tipo) as $comprobante) {
    			$comprobante_total = floatval($comprobante->CPDEC_Subtotal_calculado);

    			$comprobante_tdc = strtolower($comprobante->MONED_smallName) == 'sol' ? 1 : $comprobante->CPC_TDC;
    			$comprobante_tdc_dolar = strtolower($comprobante->MONED_smallName) == "eur" ? $comprobante->CPC_TDC_opcional : $comprobante->CPC_TDC;

    			$comprobante_soles = $comprobante_total * $comprobante_tdc;
    			$comprobante_dolares = $comprobante_soles / $comprobante_tdc_dolar;

    			$total_facturado += $comprobante_dolares;
    			$total_pagado_dolares = 0;

    			$total_facturado_100 = $comprobante_dolares * 100 / $comprobante->CPC_subtotal;

      #pagos
    			$this->load->model("tesoreria/cuentas_model");
    			foreach ($this->cuentas_model->suma_pago_by_id_comprobante($comprobante->CPP_Codigo, $tipo) as $pago) {
    				$pago_tdc = strtolower($pago->MONED_smallName) == 'sol' ? 1 : $pago->CPAGC_TDC;
    				$pago_tdc_dolar = $pago->CPAGC_TDC;

    				$pago_total = $pago->CPAGC_Monto;
    				$pago_soles = $pago_total * $pago_tdc;
    				$pago_dolares = $pago_soles / $pago_tdc_dolar;

    				$total_pagado_dolares += $pago_dolares * $total_facturado_100 / 100;
    			}

    			$total_pagado += $total_pagado_dolares;

    			$comprobantes[] = array(
    				"fecha" => mysql_to_human($comprobante->CPC_Fecha),
    				"cliente" => isset($comprobante->EMPRC_RazonSocial) ? $comprobante->EMPRC_RazonSocial : ($comprobante->PERSC_ApellidoPaterno." ".$comprobante->PERSC_ApellidoMaterno.", ".$comprobante->PERSC_Nombre),
    				"comprobante_numero" => $comprobante->CPC_TipoDocumento." ".str_pad(intval($comprobante->CPC_Serie), 3, '0', STR_PAD_LEFT)."-".str_pad(intval($comprobante->CPC_Numero), 6, '0', STR_PAD_LEFT),
    				"comprobante_link" => "https://www.google.com",
    				"moneda" => $comprobante->MONED_Simbolo,
    				"total" => $comprobante_total,
    				"total_soles" => $comprobante_soles,
    				"total_dolares" => $comprobante_dolares,
    				"total_pagado_dolares" => $total_pagado_dolares,
    				"total_pagado_saldo" => ($comprobante_dolares - $total_pagado_dolares)
    			);
    		}

    		$res["total_soles"] += $total_soles;
    		$res["total_dolares"] += $total_dolares;
    		$res["total_facturado"] += $total_facturado;
    		$res["total_pagado"] += $total_pagado;

    		$res["ordenes"][] = array(
    			"cliente" => isset($orden->EMPRC_RazonSocial) ? $orden->EMPRC_RazonSocial : ($orden->PERSC_ApellidoPaterno. " " . $orden->PERSC_ApellidoMaterno . " , " . $orden->PERSC_Nombre),
    			"documento_numero" => strtoupper($tipo)."-".str_pad($orden->OCOMC_Numero, 4, '0',STR_PAD_LEFT)."-".strftime("%Y", strtotime($orden->OCOMC_Fecha)),
    			"documento_link" => "https://www.google.com.pe",
    			"moneda" => $orden->MONED_Simbolo,
    			"total" => $total,
    			"total_soles" => $total_soles,
    			"total_dolares" => $total_dolares,
    			"total_facturado" => $total_facturado,
    			"total_facturado_saldo" => $total_dolares - $total_facturado,
    			"total_pagado" => $total_pagado,
    			"total_pagado_saldo" => $total_facturado - $total_pagado,
    			"comprobantes" => $comprobantes
    		);
    	}

    	$res["total_facturado_saldo"] = floatval($res["total_dolares"] - $res["total_facturado"]);
    	$res["total_pagado_saldo"] = floatval($res["total_facturado"] - $res["total_pagado"]);

    	echo json_encode($res);
    }


    public function balance($id_proyecto)
    {
    	$res = array(
    		"total_precio_dolares" => 0,
    		"total_ingresos" => 0,
    		"total_egresos" => 0,
    		"total_liquidez" => 0,
    		"ordenes" => array()
    	);

    	$this->load->model("compras/ocompra_model");
    	$ordenes = $this->ocompra_model->listar_by_id_proyecto_tipo($id_proyecto, 'ov');

    	foreach ($ordenes as $orden) {
    		$tdc = strtolower($orden->MONED_smallName) == 'sol' ? 1 : $orden->OCOMP_TDC;
    		$tdc_dolar = strtolower($orden->MONED_smallName) == 'eur' ? $orden->OCOMP_TDC_opcional : $orden->OCOMP_TDC;

    /*$total = floatval($orden->OCOMC_subtotal);
    $total_soles = $total * $tdc;*/
    $total_dolares = 0;

    $total_ingresos = 0;
    $total_egresos = 0;

    $productos = array();
    $this->load->model("compras/ocompradetalle_model");

    foreach ($this->ocompradetalle_model->listar_productos_by_id_orden($orden->OCOMP_Codigo) as $producto) {
    	$precio = $producto->OCOMDEC_Pu;

    	$precio_unitario_soles = $precio * $tdc;
    	$precio_unitario_dolares = $precio_unitario_soles / $tdc_dolar;

    	$total_dolares += $precio_unitario_dolares * $producto->OCOMDEC_Cantidad;
    	$producto_ingresos = 0;
    	$producto_salidas = 0;

      //calculando los ingresos mediante las ventas
    	$this->load->model("ventas/comprobantedetalle_model");
    	foreach ($this->comprobantedetalle_model->listar_ventas_by_id_orden_producto($orden->OCOMP_Codigo, $producto->PROD_Codigo) as $ingreso) {
    		$ingreso_tdc = strtolower($ingreso->MONED_smallName) == "sol" ? 1 : $ingreso->CPC_TDC;
    		$ingreso_tdc_dolar = strtolower($ingreso->MONED_smallName) == "eur" ? $ingreso->CPC_TDC_opcional : $ingreso->CPC_TDC;

    		$ingreso_total = $ingreso->CPDEC_Subtotal;
    		$ingreso_total_soles = $ingreso_total * $ingreso_tdc;
    		$ingreso_total_dolares = $ingreso_total_soles / $ingreso_tdc_dolar;

    		$producto_ingresos += $ingreso_total_dolares;
    	}

    	$total_ingresos += $producto_ingresos;

      //calculando los egresos obteniendo el precio desde la importacion ya liquidada.
    	$this->load->model("ventas/importaciondetalle_model");
    	foreach ($this->importaciondetalle_model->listar_compras_by_id_orden_producto($orden->OCOMP_Codigo, $producto->PROD_Codigo) as $salida) {
    		$salida_tdc = strtolower($salida->MONED_smallName)== "sol" ? 1 : $salida->IMPOR_TDC;
    		$salida_tdc_dolar = strtolower($salida->MONED_smallName) == "eur" ? $salida->IMPOR_TDC_opcional : $salida->IMPOR_TDC;

    		$salida_total = $salida->IMPORDEC_Descuento;
    		$salida_total_soles = $salida_total * $salida_tdc;
    		$salida_total_dolares = $salida_total_soles / $salida_tdc_dolar;

    		$producto_salidas += $salida_total_dolares;
    	}

    	$total_egresos += $producto_salidas;

    	$productos[] = array(
    		"descripcion" => $producto->OCOMDEC_Descripcion,
    		"cantidad" => $producto->OCOMDEC_Cantidad,
    		"medida" => "UNIDAD",
    		"unitario_dolar" => $precio_unitario_dolares,
    		"total_dolar" => $precio_unitario_dolares * $producto->OCOMDEC_Cantidad,
    		"ingresos" => $producto_ingresos,
    		"egresos" => $producto_salidas,
    		"liquidez" => $producto_ingresos - $producto_salidas
    	);
    }

    $res["ordenes"][] = array(
    	"cliente" => isset($orden->EMPRC_RazonSocial) ? $orden->EMPRC_RazonSocial : ($orden->PERSC_ApellidoPaterno. " " . $orden->PERSC_ApellidoMaterno . " , " . $orden->PERSC_Nombre),
    	"documento_numero" => "OV-".str_pad($orden->OCOMC_Numero, 4, '0',STR_PAD_LEFT)."-".strftime("%Y", strtotime($orden->OCOMC_Fecha)),
    	"documento_link" => "https://www.google.com.pe",
    	"total_dolares" => $total_dolares,
    	"total_ingresos" => $total_ingresos,
    	"total_egresos" => $total_egresos,
    	"total_liquidez" => $total_ingresos - $total_egresos,
    	"productos" => $productos
    );

    $res["total_precio_dolares"] += $total_dolares;
    $res["total_ingresos"] += $total_ingresos;
    $res["total_egresos"] += $total_egresos;
  }

  $res["total_liquidez"] = floatval($res["total_ingresos"] - $res["total_egresos"]);

  echo json_encode($res);
}

}       
?>