<?php
/* *********************************************************************************
Autor: Unknow
Fecha: Unknow

Dev: Rawil Ceballo -> RC
Dev: Luis Valdes	 -> LV
/* ******************************************************************************** */

class Proveedor extends Controller{

	## Dev: RC -> Begin - El array somevar es reemplazado por atributos
	private $empresa;
	private $compania;
	private $url;
	## Dev: RC -> End

	## Dev: RC -> Begin
	public function __construct(){
		parent::__construct();

		$this->load->library('html');
		$this->load->library('table');

		$this->load->library('pagination');
		$this->load->helper('json');

		$this->load->model('maestros/compania_model');
		$this->load->model('maestros/empresa_model');
		$this->load->model('maestros/persona_model');
		$this->load->model('maestros/directivo_model');
		$this->load->model('maestros/cargo_model');
		$this->load->model('maestros/area_model');
		$this->load->model('maestros/tipoestablecimiento_model');
		$this->load->model('maestros/nacionalidad_model');
		$this->load->model('maestros/tipodocumento_model');
		$this->load->model('maestros/tipocodigo_model');
		$this->load->model('maestros/estadocivil_model');
		$this->load->model('maestros/ubigeo_model');
		$this->load->model('maestros/sectorcomercial_model');
		$this->load->model('compras/proveedor_model');
		$this->load->model('ventas/cliente_model');

		$this->load->model('ventas/tipocliente_model');
		$this->load->model('maestros/emprestablecimiento_model');
		$this->load->model('maestros/formapago_model');
		$this->load->model('maestros/moneda_model');
		$this->load->model('tesoreria/banco_model');

		$this->load->library('lib_props');

		$this->empresa = $this->session->userdata('empresa');
		$this->compania = $this->session->userdata('compania');
		$this->url = base_url();
	}

	public function verificar_numero(){

		$numero = $this->input->post('numero');
		$serie = $this->input->post('serie');

		$model = $this->ocompra_model->numero($numero, $serie);

		echo $model;

	}
	## Dev: RC -> Begin
	public function index() {
		$this->proveedores();
	}
	## Dev: RC -> End

	## Dev: RC -> Begin
	public function proveedores( $j = "" ){
    ## SELECTS
		$data["documentosNatural"] = $this->tipodocumento_model->listar_tipo_documento();
		$data["documentosJuridico"] = $this->tipocodigo_model->listar_tipo_codigo();

		$data['edo_civil'] = $this->estadocivil_model->listar_estadoCivil();
		$data['nacionalidad'] = $this->nacionalidad_model->listar_nacionalidad();

		$data["cargos"] = $this->cargo_model->getCargos();
		$data["bancos"] = $this->banco_model->listar_banco();
		$data["lista_empresas"] = $this->empresa_model->listar_empresas();

		$data["sector_comercial"] = $this->sectorcomercial_model->listar();
		$data["tipo_establecimiento"] = $this->tipoestablecimiento_model->getTipoEstablecimientos();

		$data["forma_pago"] = $this->formapago_model->getFpagos();
		$data["monedas"] = $this->moneda_model->listar();
		$data["categorias_cliente"] = $this->tipocliente_model->listar();
		$data["vendedor"] = $this->directivo_model->listarVendedores();

		$data["departamentos"] = $this->ubigeo_model->listar_departamentos();
		$data["provincias"] = $this->ubigeo_model->getProvincias("15");
		$data["distritos"] = $this->ubigeo_model->getDistritos("15","01");

		$data['registros']  = count($this->proveedor_model->getProveedores());
		$data['base_url']   = $this->url;

		$data['titulo_tabla']    = "RELACIÓN DE PROVEEDORES";
		$data['titulo_busqueda'] = "BUSCAR PROVEEDOR";
		$this->layout->view('compras/proveedor_index',$data);
	}
	## Dev: RC -> End

	## Dev: RC -> Begin
	public function datatable_proveedor(){
		$posDT = -1;
		$columnas = array(
			++$posDT => "documento",
			++$posDT => "numero",
			++$posDT => "razon_social"
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

		$filter->documento = $this->input->post('documento');
		$filter->nombre = $this->input->post('nombre');

		$proveedorInfo = $this->proveedor_model->getProveedores($filter);
		$lista = array();

		if ($proveedorInfo != NULL) {
			foreach ($proveedorInfo as $indice => $valor) {
                $razon_s = $valor->razon_social;
                $extraer_first_letter = substr($razon_s, 0, 1);

                if($extraer_first_letter == '"'){
               
                $razon_f = trim($razon_s, '"');

				$btn_editar = "<button type='button' onclick='editar_proveedor($valor->PROVP_Codigo)' class='btn2 btn-default'>
				<img src='".$this->url."/images/modificar.png' class='image-size-1l'>
				</button>";

				$btn_sucursales = ($valor->PROVC_TipoPersona == 0) ? "" : "<button type='button' onclick='sucursales($valor->EMPRP_Codigo, \"$valor->numero - $razon_f\")' class='btn2 btn-default' title='Sucursales'>
				<img src='".$this->url."/images/sucursal.png' class='image-size-1l'>
				</button>";

				$btn_contactos = ($valor->PROVC_TipoPersona == 0) ? "" : "<button type='button' onclick='modal_contactos(\"$valor->EMPRP_Codigo\", \"$valor->PERSP_Codigo\", \"$valor->numero - $razon_f\")' class='btn2 btn-default' title='Contactos'>
				<img src='".$this->url."/images/contactos.png' class='image-size-1l'>
				</button>";

				$btn_bancos = "<button type='button' onclick='modal_CtasBancarias(\"$valor->EMPRP_Codigo\", \"$valor->PERSP_Codigo\", \"$valor->numero - $razon_f\")' class='btn2 btn-default' title='Bancos'>
				<img src='".$this->url."/images/banco.png' class='image-size-1l'>
				</button>";

				$btn_ficha = "<button href='".$this->url."index.php/maestros/directivo/ficha_empleado/$valor->DIREP_Codigo' data-fancybox data-type='iframe' class='btn2 btn-default'>
				<img src='".$this->url."/images/pdf.png' class='image-size-1l'>
				</button>";

				$btn_deshabilitar = "<button type='button' onclick='deshabilitar_proveedor($valor->PROVP_Codigo)' class='btn2 btn-default'>
                                <img src='".$this->url."/images/documento-delete.png' class='image-size-1l'>
                            </button>";

				$btn_documentos = "<button type='button' onclick='docs_emitidos($valor->PROVP_Codigo, \"$valor->numero\", \"$razon_f\")' class='btn2 btn-default'>
                                <img src='".$this->url."/images/icono-documentos.png' class='image-size-1l'>
                            </button>";


                
						}else{
                            $razon_so = $valor->razon_social;
                            $razon_g = str_replace("'", '',$razon_so);

							$btn_editar = "<button type='button' onclick='editar_proveedor($valor->PROVP_Codigo)' class='btn2 btn-default'>
							<img src='".$this->url."/images/modificar.png' class='image-size-1l'>
							</button>";
			
							$btn_sucursales = ($valor->PROVC_TipoPersona == 0) ? "" : "<button type='button' onclick='sucursales($valor->EMPRP_Codigo, \"$valor->numero - $razon_g\")' class='btn2 btn-default' title='Sucursales'>
							<img src='".$this->url."/images/sucursal.png' class='image-size-1l'>
							</button>";
			
							$btn_contactos = ($valor->PROVC_TipoPersona == 0) ? "" : "<button type='button' onclick='modal_contactos(\"$valor->EMPRP_Codigo\", \"$valor->PERSP_Codigo\", \"$valor->numero - $razon_g\")' class='btn2 btn-default' title='Contactos'>
							<img src='".$this->url."/images/contactos.png' class='image-size-1l'>
							</button>";
			
							$btn_bancos = "<button type='button' onclick='modal_CtasBancarias(\"$valor->EMPRP_Codigo\", \"$valor->PERSP_Codigo\", \"$valor->numero - $razon_g\")' class='btn2 btn-default' title='Bancos'>
							<img src='".$this->url."/images/banco.png' class='image-size-1l'>
							</button>";
			
							$btn_ficha = "<button href='".$this->url."index.php/maestros/directivo/ficha_empleado/$valor->DIREP_Codigo' data-fancybox data-type='iframe' class='btn2 btn-default'>
							<img src='".$this->url."/images/pdf.png' class='image-size-1l'>
							</button>";
			
							$btn_deshabilitar = "<button type='button' onclick='deshabilitar_proveedor($valor->PROVP_Codigo)' class='btn2 btn-default'>
											<img src='".$this->url."/images/documento-delete.png' class='image-size-1l'>
										</button>";
			
							$btn_documentos = "<button type='button' onclick='docs_emitidos($valor->PROVP_Codigo, \"$valor->numero\", \"$razon_g\")' class='btn2 btn-default'>
											<img src='".$this->url."/images/icono-documentos.png' class='image-size-1l'>
										</button>";
						}

				$posDT = -1;
				$lista[] = array(
					++$posDT => $valor->documento,
					++$posDT => $valor->numero,
					++$posDT => $valor->razon_social,
					++$posDT => $btn_editar,
					++$posDT => $btn_documentos,
					++$posDT => $btn_bancos,
					++$posDT => $btn_contactos,
					++$posDT => $btn_sucursales,
					++$posDT => $btn_deshabilitar
				);

			}
		}

		unset($filter->start);
		unset($filter->length);

		$json = array(
			"draw"            => intval( $this->input->post('draw') ),
			"recordsTotal"    => count($this->proveedor_model->getProveedores()),
			"recordsFiltered" => intval( count($this->proveedor_model->getProveedores($filter)) ),
			"data"            => $lista
		);

		echo json_encode($json);
	}
	## Dev: RC -> End

	## Dev: RC -> Begin
	public function getDocumentos(){
    # 0 : NATURAL | 1 : JURIDICO
		$tipo = $this->input->post("tipo");

		if ($tipo == "0")
			$info = $this->tipodocumento_model->listar_tipo_documento();
		else
			$info = $this->tipocodigo_model->listar_tipo_codigo();

		if ($info != NULL){
			if ($tipo == "0"){
				foreach ($info as $key => $val)
					$documentos[] = array("codigo" => $val->TIPDOCP_Codigo, "inicial" => $val->TIPOCC_Inciales);
			}
			else{
				foreach ($info as $key => $val)
					$documentos[] = array("codigo" => $val->TIPCOD_Codigo, "inicial" => $val->TIPCOD_Inciales);
			}

			$json = array("match" => true, "documentos" => $documentos);
		}
		else
			$json = array("match" => true, "documentos" => $documentos);

		echo json_encode($json);
	}
	## Dev: RC -> End

	## Dev: RC -> Begin
	public function getProveedor(){
		$proveedor = $this->input->post("proveedor");
		$proveedorInfo = $this->proveedor_model->getProveedor($proveedor);

		if ($proveedorInfo != NULL){
			foreach ($proveedorInfo as $key => $val)
				$info = array(
					"proveedor" => $val->PROVP_Codigo,
					"tipo_cliente" => $val->PROVC_TipoPersona,
					"tipo_documento" => $val->tipo_documento,
					"numero_documento" => $val->numero,

					"razon_social" => $val->razon_social,
					"nombres" => $val->PERSC_Nombre,
					"apellido_paterno" => $val->PERSC_ApellidoPaterno,
					"apellido_materno" => $val->PERSC_ApellidoMaterno,

					"genero" => $val->PERSC_Sexo,
					"edo_civil" => $val->ESTCP_EstadoCivil,
					"nacionalidad" => $val->NACP_Nacionalidad,

					"direccion" => $val->direccion,

					"departamento" => substr($val->ubigeo, 0, 2),
					"provincia" => substr($val->ubigeo, 2, 2),
					"distrito" => substr($val->ubigeo, 4, 2),

					"sector_comercial" => $val->SECCOMP_Codigo,
					"forma_pago" => $val->FORPAP_Codigo,
					"categoria" => $val->TIPCLIP_Codigo,

					"telefono" => $val->telefono,
					"movil" => $val->movil,
					"fax" => $val->fax,
					"correo" => $val->correo,
					"web" => $val->web
				);

			$json = array("match" => true, "info" => $info);
		}
		else
			$json = array("match" => true, "info" => NULL);

		echo json_encode($json);
	}
	## Dev: RC -> End

	## Dev: RC -> Begin
	
	public function guardar_registro(){

		$proveedor = $this->input->post("proveedor");

		$empresa = 0;
		$persona = 0;
		$empresa_pertenece = $this->empresa;
		if ( $proveedor != "" ){
			$clienteInfo = $this->proveedor_model->getProveedor($proveedor);
			$empresa = $clienteInfo[0]->EMPRP_Codigo;
			$persona = $clienteInfo[0]->PERSP_Codigo;
		}

		$tipo_cliente 		= $this->input->post("tipo_cliente");
		$tipo_documento 	= $this->input->post("tipo_documento");
		$numero_documento 	= $this->input->post("numero_documento");
		$razon_social 		= strtoupper( $this->input->post("razon_social"));
		$nombres 			= strtoupper( $this->input->post("nombres") );
		$apellido_paterno 	= strtoupper( $this->input->post("apellido_paterno") );
		$apellido_materno 	= strtoupper( $this->input->post("apellido_materno") );
		$genero 			= $this->input->post("genero");
		$edo_civil 			= $this->input->post("edo_civil");
		$nacionalidad 		= $this->input->post("nacionalidad");
		$fecha_nacimiento 	= $this->input->post("fecha_nacimiento");
		$direccion 			= strtoupper( $this->input->post("direccion") );
		$departamento 		= $this->input->post("departamento");
		$provincia 			= $this->input->post("provincia");
		$distrito 			= $this->input->post("distrito");
		$ubigeo 			= $departamento.$provincia.$distrito;
		
		if ($ubigeo=="") {
			$ubigeo="150101";
		}

		$idcliente 			= $this->input->post("idcliente");
		$vendedor 			= $this->input->post("vendedor");
		$sector_comercial 	= $this->input->post("sector_comercial");
		$forma_pago 		= $this->input->post("forma_pago");
		$categoria 			= $this->input->post("categoria");
		$telefono 			= $this->input->post("telefono");
		$movil 				= $this->input->post("movil");
		$fax 				= $this->input->post("fax");
		$correo 			= $this->input->post("correo");
		$web 				= $this->input->post("web");

    	## EMPRESA
		$empresaInfo = new stdClass();
		$empresaInfo->CIIUP_Codigo      	= 0;
		$empresaInfo->TIPCOD_Codigo     	= $tipo_documento;
		$empresaInfo->SECCOMP_Codigo    	= $sector_comercial;
		$empresaInfo->EMPRC_Ruc         	= $numero_documento;
		$empresaInfo->EMPRC_RazonSocial 	= $razon_social;
		$empresaInfo->EMPRC_Telefono    	= $telefono;
		$empresaInfo->EMPRC_Movil       	= $movil;
		$empresaInfo->EMPRC_Fax         	= $fax;
		$empresaInfo->EMPRC_Web         	= $web;
		$empresaInfo->EMPRC_Email       	= $correo;
		$empresaInfo->EMPRC_CtaCteSoles 	= "";
		$empresaInfo->EMPRC_CtaCteDolares	= "";
		$empresaInfo->EMPRC_FlagEstado  	= "1";
		$empresaInfo->EMPRC_Direccion   	= $direccion;
		$empresaInfo->EMPRC_EmpCod      	= $empresa_pertenece;

    	## PERSONA
		$personaInfo = new stdClass();
		$personaInfo->UBIGP_LugarNacimiento 	= "000000";
		$personaInfo->UBIGP_Domicilio       	= $ubigeo;
		$personaInfo->ESTCP_EstadoCivil     	= $edo_civil;
		$personaInfo->NACP_Nacionalidad     	= $nacionalidad;
		$personaInfo->PERSC_Nombre          	= $nombres;
		$personaInfo->PERSC_ApellidoPaterno 	= $apellido_paterno;
		$personaInfo->PERSC_ApellidoMaterno 	= $apellido_materno;
		$personaInfo->PERSC_TipoDocIdentidad 	= $tipo_documento;
		$personaInfo->PERSC_Ruc             	= "";
		$personaInfo->PERSC_NumeroDocIdentidad 	= $numero_documento;
		$personaInfo->PERSC_FechaNac        	= $fecha_nacimiento;
		$personaInfo->PERSC_FechaNacz        	= $fecha_nacimiento;
		$personaInfo->PERSC_Direccion       	= $direccion;
		$personaInfo->PERSC_Telefono        	= $telefono;
		$personaInfo->PERSC_Movil           	= $movil;
		$personaInfo->PERSC_Fax             	= $fax;
		$personaInfo->PERSC_Email           	= $correo;
		$personaInfo->PERSC_Domicilio       	= $direccion;
		$personaInfo->PERSC_Web             	= $web;
		$personaInfo->PERSC_Sexo            	= $genero;
		$personaInfo->PERSC_FlagEstado      	= "1";
		$personaInfo->PERSC_EmpCod      		= $empresa_pertenece;
    	#$persona->BANP_Codigo           = NULL;

   	 	## CLIENTE

		$clienteInfo = new stdClass();
		$clienteInfo->CLIC_TipoPersona   = $tipo_cliente;
		$clienteInfo->TIPCLIP_Codigo     = $categoria;
		$clienteInfo->CLIC_Vendedor      = $vendedor;
		$clienteInfo->FORPAP_Codigo      = $forma_pago;
  		
		$clienteInfo->CLIC_Digemin       = "";
		$clienteInfo->CLIC_flagCalifica  = 1;
		$clienteInfo->CLIC_FlagEstado    = "1";

    	## PROVEEDOR

		$proveedorInfo = new stdClass();
		$proveedorInfo->PROVC_TipoPersona = $tipo_cliente;
		$proveedorInfo->PROVC_FlagEstado = "1";

    	## SUCURSAL

		$sucursalInfo = new stdClass();
		$sucursalInfo->TESTP_Codigo = 1;
		$sucursalInfo->UBIGP_Codigo = $ubigeo;
		$sucursalInfo->EESTABC_Descripcion = "PRINCIPAL";
		$sucursalInfo->EESTAC_Direccion = $direccion;
		$sucursalInfo->EESTABC_FlagTipo = "1";
		$sucursalInfo->EESTABC_FlagEstado = "1";

		$this->db->trans_start();

		if ($proveedor != ""){
			if ($tipo_cliente == "0"){
				if ($persona != 0)
					$this->persona_model->actualizar_persona($persona, $personaInfo);
			}
			else{
				if ($empresa != 0){
					$this->empresa_model->actualizar_empresa($empresa, $empresaInfo);

					$sucursalInfo->EMPRP_Codigo = $empresa;
					$establecimiento = $this->emprestablecimiento_model->actualizar_establecimiento_principal($sucursalInfo);
				}
			}

			$proveedorInfo->EMPRP_Codigo  = $empresa;
			$proveedorInfo->PERSP_Codigo  = $persona;

			$proveedor = $this->proveedor_model->actualizar_proveedor($proveedor, $proveedorInfo);

			if ($proveedor){
				$json_result = "success";
				$json_message = "Actualización satisfactoria.";
			}
			else{
				$json_result = "error";
				$json_message = "El número de documento $numero_documento, ya se encuentra registrado.";
			}
		}
		else{

			$result = $this->empresa_model->EmpresaExiste($numero_documento, $tipo_cliente, $this->empresa);
        
	        $es_cliente = $result[0]->CLIP_Codigo;
	        $es_proveed = $result[0]->PROVP_Codigo;

			if ( $es_proveed !=null){
				$json_result = "error";
				$json_message = "El número de documento $numero_documento, ya se encuentra registrado.";
			}
			else{
				if ($es_cliente == null && $es_proveed == null) {
					if ($tipo_cliente == "0")
						$persona = $this->persona_model->insertar_persona($personaInfo);
					else{
						$empresa = $this->empresa_model->insertar_empresa($empresaInfo);

						$sucursalInfo->EMPRP_Codigo = $empresa;
						$establecimiento = $this->emprestablecimiento_model->insertar_establecimiento($sucursalInfo);
					}	
				}else{
					$persona = ($result[0]->PERSP_Codigo!=null) ? $result[0]->PERSP_Codigo : 0;
	        		$empresa = ($result[0]->EMPRP_Codigo!=null) ? $result[0]->EMPRP_Codigo : 0;
				}
				

				$clienteInfo->CLIC_CodigoUsuario = $this->generateCodeCliente();
				$clienteInfo->EMPRP_Codigo  = $empresa;
				$clienteInfo->PERSP_Codigo  = $persona;
				$proveedorInfo->PERSP_Codigo = $persona;
				$proveedorInfo->EMPRP_Codigo = $empresa;

				$proveedor = $this->proveedor_model->insertar_proveedor($proveedorInfo);
				
				$array_compania =  $this->compania_model->listar_establecimiento($this->empresa);
					foreach ($array_compania as $key => $value) {
						$this->proveedor_model->insertar_proveedor_empresa($proveedor,$value->COMPP_Codigo);
					}
				
				if ($proveedor != 0 && $proveedor != NULL){
					$json_result = "success";
					$json_message = "Registro satisfactorio.";
				}
				else{
					$json_result = "error";
					$json_message = "No fue posible registrar al pro. Intentelo nuevamente";
				}
			}
		}

		if($this->db->trans_status() == false)
      		$this->db->trans_rollback();
    	else
     		$this->db->trans_commit();

		$json = array("result" => $json_result, "message" => $json_message ,"codigo" => $proveedor);
		echo json_encode($json);
	}
	## Dev: RC -> End

	## Dev: RC -> Begin
	public function deshabilitar_proveedor(){
    $proveedor = $this->input->post("proveedor");

    if ($proveedor != ""){
    	$docsExists = $this->proveedor_model->docs_generated_exists($proveedor);

    	if ($docsExists == false){
		    $filter = new stdClass();
		    $filter->PROVC_FlagEstado = "0";
		    $filter->PROVC_FechaModificacion = date("Y-m-d H:i:s");
	      $oper = $this->proveedor_model->actualizar_proveedor($proveedor, $filter);

	      if ($oper){
			  	$result = "success";
			  	$message = "Operacion exitosa";
			  }
			  else{
			  	$result = "error";
			  	$message = "¡Ups! Proveedor no eliminado, intentalo nuevamente.";
			  }
		  }
		  else{
		  	$result = "info";
		  	$message = "No se pueden eliminar proveedores con documentos asociados.";
		  }

      $json = array("result" => $result, "message" => $message);
	  }
	  else
      $json = array("result" => "error", "message" => "Proveedor no seleccionado.");
    
    echo json_encode($json);
  }
	## Dev: RC -> End

	## Dev: RC -> Begin
	public function docs_emitidos(){

    $posDT = -1;
		$columnas = array(
			++$posDT => "EMPRC_RazonSocial",
			++$posDT => "documento",
			++$posDT => "fechaRegistro",
			++$posDT => "fecha",
			++$posDT => "serie",
			++$posDT => "numero",
			++$posDT => "total"
		);

		$filter = new stdClass();
		$filter->start = $this->input->post("start");
		$filter->length = $this->input->post("length");

		$ordenar = $this->input->post("order")[0]["column"];
		if ($ordenar != ""){
			$filter->order = $columnas[$ordenar];
			$filter->dir = $this->input->post("order")[0]["dir"];
		}

		$item = ($this->input->post("start") != "") ? $this->input->post("start") : 0;

		$proveedor = $this->input->post('proveedor');

		$proveedorInfo = $this->proveedor_model->docs_emitidos($proveedor, $filter);
		$lista = array();

		if ($proveedorInfo != NULL) {
			foreach ($proveedorInfo as $i => $val) {
				$posDT = -1;
				$lista[] = array(
					++$posDT => $val->EMPRC_RazonSocial,
					++$posDT => $val->documento,
					++$posDT => $val->fechaRegistro,
					++$posDT => $val->fecha,
					++$posDT => $this->lib_props->getNumberFormat($val->serie,6),
					++$posDT => $this->lib_props->getNumberFormat($val->numero,6),
					++$posDT => $val->total
				);
			}
		}

		unset($filter->start);
		unset($filter->length);
		unset($filter->order);
		unset($filter->dir);

		$filter->count = true;
    $recordsTotal = $this->proveedor_model->docs_emitidos($proveedor, $filter);
    #$recordsFiltered = $this->proveedor_model->docs_emitidos($proveedor);
    $recordsFiltered = $recordsTotal;

		$json = array(
			"draw"            => intval( $this->input->post('draw') ),
			"recordsTotal"    => $recordsTotal->registros,
			"recordsFiltered" => $recordsFiltered->registros,
			"data"            => $lista
		);

		echo json_encode($json);
  }
	## Dev: RC -> End
	
	## Dev: Rawil Ceballo -> Begin
	public function search_documento(){
		$empresa_pertenece = $this->empresa;
		$numero = trim($this->input->post('numero'));
		$exists = $this->empresa_model->documento_exists($numero,$empresa_pertenece);

		if ($exists == false){
			$getCode = $this->generateCodeCliente();
			
			if (is_numeric($numero)){
				$url = "https://www.amcsolutionstec.com/produccion/api/api/getRuc/".$numero;

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 3);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				$result = curl_exec($ch);
				curl_close($ch);

				$object = json_decode($result);

				if ($object->match == true){
					$tipo_cliente = "";
					$data = $object->result;

					if ( $data->documento == 'DNI' ){
						$info = array(
							"documento" => "DNI",
							"dni" => (isset($data->dni)) ? $data->dni : $numero,
							"nombre" => (isset($data->nombres)) ? $data->nombres : "",
							"paterno" => (isset($data->apellido_paterno)) ? $data->apellido_paterno : "",
							"materno" => (isset($data->apellido_materno)) ? $data->apellido_materno : ""
						);
						$tipo_cliente = 0;
					}
					else if ( $data->documento == 'RUC' ){
						$info = array(
							"documento" => $data->documento,
							"ruc" => $data->ruc,
							"razon_social" => $data->razon_social,
							"direccion" => $data->direccion,
							"ubigeo" => $data->ubigeo,
							"estado" => $data->estado,
							"condicion" => $data->condicion,
							"tipovia" => $data->tipovia,
							"nombrevia" => $data->nombrevia,
							"codigozona" => $data->codigozona,
							"tipozona" => $data->tipozona,
							"numero" => $data->numero,
							"interior" => $data->interior,
							"lote" => $data->lote,
							"departamento" => $data->departamento,
							"manzana" => $data->manzana,
							"kilometro" => $data->kilometro
						);
						$tipo_cliente = 1;
					}

					$object = new stdClass();
					$object->result = $info;

					$json = array(
						"exists" => $exists,
						"match" => true,
						"tipo_cliente" => $tipo_cliente,
						"message" => "El documento fue encontrado",
						"info" => $object,
						"id_cliente" => $getCode
					);
				}
				else{
					$json = array("exists" => $exists, "match" => false, "message" => "Documento no encontrado.");
				}
			}
			else{
				$json = array("exists" => $exists, "match" => false, "message" => "Formato de RUC/DNI invalido.");
			}
		}
		else{
			$json = array("exists" => $exists, "match" => true, "message" => "El documento $numero, fue registrado anteriormente.");
		}
		echo json_encode($json);
		die();
	}
	## Dev: Rawil Ceballo -> End

	## Dev: RC -> Begin
	public function generateCodeCliente(){
		$rjson = $this->input->post("json");
		$code = $this->cliente_model->getCodeCliente();
		$nvoCode = "CL0".$code;

		if ($rjson != ""){
			$json = array("code" => $nvoCode);
			echo json_encode($json);
		}
		else
			return $nvoCode;
	}
	## Dev: RC -> End

	## Dev: RC -> Begin
	public function obtUbigueo($dir){
    if ($dir == "-" || $dir == "- ")
      return "000000";

    $ubigeo = $this->ubigeo_model->buscar_ubigeo($dir);
    $ubigeo[0]->UBIGC_CodProv = substr($ubigeo[0]->UBIGC_CodProv,2,2);
    $ubigeo[0]->UBIGC_CodDist = substr($ubigeo[0]->UBIGC_CodDist,4,2);

    return $ubigeo[0];
  }
	## Dev: RC -> End

  ###########################
  ###### FUNCTIONS OLDS
  ###########################

	public function proveedores2($j = 0){
		$data['numdoc'] = "";
		$data['nombre'] = "";
		$data['telefono'] = "";
		$data['tipo'] = "";
		$data['listado_empresaTipos'] = array();
		$data['codtipoproveedor'] = '';
		$data['nombre_tipoproveedor'] = '';
		$data['codmarca'] = '';
		$data['nombre_marcaproveedor'] = '';
		$data['titulo_tabla'] = "RELACIÓN DE PROVEEDORES";
		$data['registros'] = count($this->proveedor_model->listar_proveedor());
		$data['action'] = base_url() . "index.php/compras/proveedor/buscar_proveedores";
		$conf['base_url'] = site_url('compras/proveedor/proveedores/');
		$conf['total_rows'] = $data['registros'];
		$conf['per_page'] = 50;
		$conf['num_links'] = 3;
		$conf['next_link'] = "&gt;";
		$conf['prev_link'] = "&lt;";
		$conf['first_link'] = "&lt;&lt;";
		$conf['last_link'] = "&gt;&gt;";
		$conf['uri_segment'] = 4;
		$this->pagination->initialize($conf);
		$data['paginacion'] = $this->pagination->create_links();
		$listado_proveedores = $this->proveedor_model->listar_proveedor($conf['per_page'], $j);
		$item = $j + 1;
		$lista = array();
		if (count($listado_proveedores) > 0) {
			foreach ($listado_proveedores as $indice => $valor) {
				$codigo = $valor->PROVP_Codigo;
				$ruc = $valor->ruc;
				$dni = $valor->dni;
				$razon_social = $valor->nombre;
				$direccion = $valor->direccion;
				$tipo_cliente = $valor->PROVC_TipoPersona == 1 ? "P.JURIDICA" : "P.NATURAL";
                //$telefono = $valor->telefono;
               // $movil = $valor->movil;
				$editar = "<a href='#' onclick='editar_proveedor(" . $codigo . ")'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
				$ver = "<a href='#' onclick='ver_proveedor(" . $codigo . ")'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
				$eliminar = "<a href='#' onclick='eliminar_proveedor(" . $codigo . ")'><img src='" . base_url() . "images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
				$lista[] = array($item, $ruc, $dni, $razon_social,
					$tipo_cliente, $direccion, 
                         // $telefono, 
                          //$movil, 
					$editar, $ver, $eliminar);
				$item++;
			}
		}
		$data['lista'] = $lista;
		$this->layout->view("compras/proveedor_index", $data);
	}

	public function nuevo_proveedor()
	{
		$data['cbo_dpto'] = $this->seleccionar_departamento('15');
		$data['cbo_prov'] = $this->seleccionar_provincia('15', '01');
		$data['cbo_dist'] = $this->seleccionar_distritos('15', '01');
		$data['cbo_estadoCivil'] = $this->seleccionar_estadoCivil('');
		$data['cbo_nacionalidad'] = $this->seleccionar_nacionalidad('193');
		$data['cbo_nacimiento'] = $this->seleccionar_distritos('15', '01', '01');
		$data['tipocodigo'] = $this->seleccionar_tipocodigo('1');
		$data['cbo_sectorComercial'] = $this->OPTION_generador($this->sectorcomercial_model->listar(), 'SECCOMP_Codigo', 'SECCOMC_Descripcion', '');
		$data['display'] = "";
		$data['display_datosEmpresa'] = "";
		$data['display_datosPersona'] = "display:none;";
		$data['nombres'] = "";
		$data['paterno'] = "";
		$data['materno'] = "";
		$data['numero_documento'] = "";
		$data['ruc'] = "";
		$data['sexo'] = "";
		$data['tipo_documento'] = $this->seleccionar_tipodocumento('1');
		$data['tipo_persona'] = "1";
		$data['id'] = "";
		$data['modo'] = "insertar";
		$objeto = new stdClass();
		$objeto->id = "";
		$objeto->tipo = "";
		$objeto->ruc = "";
		$objeto->nombre = "";
		$objeto->telefono = "";
		$objeto->movil = "";
		$objeto->fax = "";
		$objeto->web = "";
		$objeto->email = "";
		$objeto->direccion = "";
		$objeto->ctactesoles = "";
		$objeto->ctactedolares = "";
		$data['datos'] = $objeto;
		$data["listBanco"]=array();
		$data['titulo'] = "REGISTRAR PROVEEDOR";
		$data['listado_empresaSucursal'] = array();
		$data['listado_empresaContactos'] = array();
		$data['listado_empresaMarcas'] = array();
		$data['listado_empresaTipos'] = array();
		$data['cboNacimiento'] = "000000";
		$data['cboNacimientovalue'] = "";
		$this->load->view("compras/proveedor_nuevo", $data);
	}

	public function insertar_proveedor(){
		if ($this->input->post('tipo_persona') == '0') {
			if ($this->input->post('tipo_documento') == '1' && $this->input->post('numero_documento') != '' && strlen($this->input->post('numero_documento')) != 8)
				exit ('{"result":"error", "campo":"numero_documento", "msg": "Valor inválido"}');
			if ($this->input->post('nombres') == '')
				exit ('{"result":"error", "campo":"nombres"}');
			if ($this->input->post('paterno') == '')
				exit ('{"result":"error", "campo":"paterno"}');
			if ($this->input->post('cboEstadoCivil') == '0')
				exit ('{"result":"error", "campo":"cboEstadoCivil"}');
			if ($this->input->post('cboNacimiento') == '0')
				exit ('{"result":"error", "campo":"cboNacimiento"}');
		} else {
			if ($this->input->post('ruc') == '')
				exit ('{"result":"error", "campo":"ruc"}');
			if ($this->input->post('cboTipoCodigo') == '1' && $this->input->post('ruc') != '' && strlen($this->input->post('ruc')) != 11)
				exit ('{"result":"error", "campo":"ruc", "msg": "Valor inválido"}');
			if ($this->input->post('razon_social') == '')
				exit ('{"result":"error","campo":"razon_social"}');
		}

		$nombre_sucursal = array();
		$nombre_contacto = array();
		$empresa_persona = $this->input->post('empresa_persona');
		$tipo_persona = $this->input->post('tipo_persona');
		$tipocodigo = $this->input->post('cboTipoCodigo');
		$ruc = $this->input->post('ruc');
		$razon_social = $this->input->post('razon_social');
		$telefono = $this->input->post('telefono');
		$movil = $this->input->post('movil');
		$fax = $this->input->post('fax');
		$email = $this->input->post('email');
		$web = $this->input->post('web');
		$direccion = $this->input->post('direccion');
		$departamento = $this->input->post('cboDepartamento');
		$provincia = $this->input->post('cboProvincia');
		$distrito = $this->input->post('cboDistrito');
		$sector_comercial = $this->input->post('sector_comercial');
		$ctactesoles = $this->input->post('ctactesoles');
		$ctactedolares = $this->input->post('ctactedolares');
		$ubigeo_domicilio = $departamento . $provincia . $distrito;

		if ($ubigeo_domicilio == "" && trim($direccion) != "" && trim($direccion) != "-" || $ubigeo_domicilio == "000000" && trim($direccion) != "" && trim($direccion) != "-"){
			$detaUbg = $this->ubigeo_model->buscar_ubigeo($direccion);
            $ubigeo_domicilio = $detaUbg[0]->UBIGC_CodDist; # $departamento . $provincia . $distrito;
          }

          $nombres = $this->input->post('nombres');
          $paterno = $this->input->post('paterno');
          $materno = $this->input->post('materno');
          $tipo_documento = $this->input->post('tipo_documento');
          $numero_documento = $this->input->post('numero_documento');
          $ubigeo_nacimiento = $this->input->post('cboNacimiento') == '' ? '000000' : $this->input->post('cboNacimiento');
          $sexo = $this->input->post('cboSexo');

          if ($this->input->post('cboEstadoCivil') == '') {
          	$estado_civil = null;
          } else {
          	$estado_civil = $this->input->post('cboEstadoCivil');
          }

          $nacionalidad = $this->input->post('cboNacionalidad');
          $ruc_persona = $this->input->post('ruc_persona');

          /*Array de variables*/
          $nombre_sucursal = $this->input->post('nombreSucursal');
          $direccion_sucursal = $this->input->post('direccionSucursal');
          $tipo_establecimiento = $this->input->post('tipoEstablecimiento');
          $arrayDpto = $this->input->post('dptoSucursal');
          $arrayProv = $this->input->post('provSucursal');
          $arrayDist = $this->input->post('distSucursal');
          $persona_contacto = $this->input->post('contactoPersona');
          $nombre_contacto = $this->input->post('contactoNombre');
          $area_contacto = $this->input->post('contactoArea');
          $cargo_contacto = $this->input->post('cargo_encargado');
          $telefono_contacto = $this->input->post('contactoTelefono');
          $email_contacto = $this->input->post('contactoEmail');

          if ( $this->proveedor_model->proveedor_exists($ruc, $numero_documento, $ruc_persona) == true ){
          	exit("{'result':'error', 'message':'El Documento $ruc $numero_documento $ruc_persona\nYa se encuentra registrado.'}");
          }

          if ($arrayDpto != '' && $arrayProv != '' && $arrayDist != '') {
          	$ubigeo_sucursal = $this->html->array_ubigeo($arrayDpto, $arrayProv, $arrayDist);
          }

        if ($tipo_persona == 1) {//Empresa
        	$persona = 0;
        	if ($empresa_persona != '' && $empresa_persona != '0') {
        		$empresa = $empresa_persona;
        		$this->empresa_model->modificar_datosEmpresa($empresa, $tipocodigo, $ruc, $razon_social, $telefono, $movil, $fax, $web, $email, $sector_comercial, $ctactesoles, $ctactedolares,$direccion);
        	} else
        	$empresa = $this->empresa_model->insertar_datosEmpresa($tipocodigo, $ruc, $razon_social, $telefono, $fax, $web, $movil, $email, $sector_comercial, $ctactesoles, $ctactedolares,$direccion);
            //Direccion Principal
        	$this->empresa_model->insertar_sucursalEmpresaPrincipal('1', $empresa, $ubigeo_domicilio, 'PRINCIPAL', $direccion);
        	$this->proveedor_model->insertar_datosProveedor($empresa, $persona, $tipo_persona);

            //Insertar Establecimientos
        	if ($nombre_sucursal != '') {
        		foreach ($nombre_sucursal as $indice => $valor) {
        			if ($nombre_sucursal[$indice] != '' && $direccion_sucursal != '' && $tipo_establecimiento[$indice] != '') {
        				$ubigeo_s = strlen($ubigeo_sucursal[$indice]) < 6 ? "000000" : $ubigeo_sucursal[$indice];
        				$this->empresa_model->insertar_sucursalEmpresa($tipo_establecimiento[$indice], $empresa, $ubigeo_s, $nombre_sucursal[$indice], $direccion_sucursal[$indice]);
        				exit($ubigeo_s);
        			}
        		}
        	}
            //Insertar contactos empresa
        	if ($nombre_contacto != '') {
        		foreach ($nombre_contacto as $indice => $valor) {
        			if ($nombre_contacto[$indice] != '') {
        				$pers_contacto = $persona_contacto[$indice];
        				$nom_contacto = $nombre_contacto[$indice];
        				$car_contacto = $cargo_contacto[$indice];
        				$ar_contacto = $area_contacto[$indice];
        				$arrTelConctacto = explode("/", $telefono_contacto[$indice]);
        				switch (count($arrTelConctacto)) {
        					case 2:
        					$tel_contacto = $arrTelConctacto[0];
        					$mov_contacto = $arrTelConctacto[1];
        					break;
        					case 1:
        					$tel_contacto = $arrTelConctacto[0];
        					$mov_contacto = "";
        					break;
        					case 0:
        					$tel_contacto = "";
        					$mov_contacto = "";
        					break;
        				}
        				$e_contacto = $email_contacto[$indice];
        				if ($pers_contacto == '') {
        					$pers_contacto = $this->persona_model->insertar_datosPersona('000000', '000000', '1', '193', $nom_contacto, '', '', '', '1');
                        }//Inserto persona
                        $directivo = $this->empresa_model->insertar_directivoEmpresa($empresa, $pers_contacto, $car_contacto);
                        $this->empresa_model->insertar_areaEmpresa($ar_contacto, $empresa, $directivo, '::OBSERVACION::');
                        $this->empresa_model->insertar_contactoEmpresa($empresa, '::OBSERVACION:', $tel_contacto, $mov_contacto, $e_contacto, $pers_contacto);
                      }
                    }
                  }
        } //Persona
        elseif ($tipo_persona == 0) {
        	$empresa = 0;
        	if ($empresa_persona != '' && $empresa_persona != '0') {
        		$persona = $empresa_persona;
        		$this->persona_model->modificar_datosPersona($persona, $ubigeo_nacimiento, $ubigeo_domicilio, $estado_civil, $nacionalidad, $nombres, $paterno, $materno, $ruc_persona, $tipo_documento, $numero_documento, $direccion, $telefono, $movil, $email, $domicilio, $sexo, $fax, $web, $ctactesoles, $ctactedolares);
        	} else
        	$persona = $this->persona_model->insertar_datosPersona($ubigeo_nacimiento, $ubigeo_domicilio, $estado_civil, $nacionalidad, $nombres, $paterno, $materno, $ruc_persona, $tipo_documento, $numero_documento, $direccion, $telefono, $movil, $email, $direccion, $sexo, $web, $ctactesoles, $ctactedolares);

        	$cliente = $this->proveedor_model->insertar_datosProveedor($empresa, $persona, $tipo_persona);
        }
        exit('{"result": "ok", "codigo":"' . $cliente . '"}');
      }

      public function editar_proveedor($id)
      {
      	$datos = $this->proveedor_model->obtener_datosProveedor($id);
      	$tipo_persona = $datos[0]->PROVC_TipoPersona;
      	$persona = $datos[0]->PERSP_Codigo;
      	$empresa = $datos[0]->EMPRP_Codigo;
      	$data['display'] = "style='display:none;'";
      	$data['modo'] = "modificar";
      	$data['tipo_persona'] = $tipo_persona;
      	$data['id'] = $id;
      	$id_proveedor = $id;

      	$data["listBanco"]=$this->proveedor_model->listar_bancos();
      	$data['listMoneda']=$this->proveedor_model->listMoneda();


        if ($tipo_persona == 0) {//Persona
        	$data['listado_cuentaEmpresa']= $this->empresa_model->listCuentaEmpresa($persona);

        	$datos_persona = $this->persona_model->obtener_datosPersona($persona);
        	$ubigeo_domicilio = $datos_persona[0]->UBIGP_Domicilio;
        	$ubigeo_nacimiento = $datos_persona[0]->UBIGP_LugarNacimiento;
        	$nacionalidad = $datos_persona[0]->NACP_Nacionalidad;
        	$estado_civil = $datos_persona[0]->ESTCP_EstadoCivil;
        	$dpto_domicilio = substr($ubigeo_domicilio, 0, 2);
        	$prov_domicilio = substr($ubigeo_domicilio, 2, 2);
        	$dist_domicilio = substr($ubigeo_domicilio, 4, 2);
        	$dpto_nacimiento = substr($ubigeo_nacimiento, 0, 2);
        	$prov_nacimiento = substr($ubigeo_nacimiento, 2, 2);
        	$dist_nacimiento = substr($ubigeo_nacimiento, 4, 2);
        	$data['nombres'] = $datos_persona[0]->PERSC_Nombre;
        	$data['paterno'] = $datos_persona[0]->PERSC_ApellidoPaterno;
        	$data['materno'] = $datos_persona[0]->PERSC_ApellidoMaterno;
        	$data['tipo_documento'] = $this->seleccionar_tipodocumento($datos_persona[0]->PERSC_TipoDocIdentidad);
        	$data['numero_documento'] = $datos_persona[0]->PERSC_NumeroDocIdentidad;

        	$data['ruc'] = $datos_persona[0]->PERSC_Ruc;
        	$data['sexo'] = $datos_persona[0]->PERSC_Sexo;
        	$data['cbo_estadoCivil'] = $this->seleccionar_estadoCivil($estado_civil);
        	$data['cbo_nacionalidad'] = $this->seleccionar_nacionalidad($nacionalidad);
        	$data['cboNacimiento'] = $ubigeo_nacimiento;
        	$nombre_persona = $datos_persona[0]->PERSC_ApellidoPaterno . " " . $datos_persona[0]->PERSC_ApellidoMaterno . " " . $datos_persona[0]->PERSC_Nombre;
        	$datos_nacimiento = $this->ubigeo_model->obtener_ubigeo($ubigeo_nacimiento);
        	$data['cboNacimientovalue'] = $ubigeo_nacimiento == '000000' ? '' : $datos_nacimiento[0]->UBIGC_Descripcion;
        	$data['cbo_dpto'] = $this->seleccionar_departamento($dpto_domicilio);
        	$data['cbo_prov'] = $this->seleccionar_provincia($dpto_domicilio, $prov_domicilio);
        	$data['cbo_dist'] = $this->seleccionar_distritos($dpto_domicilio, $prov_domicilio, $dist_domicilio);
        	$data['direccion'] = $datos_persona[0]->PERSC_Direccion;
        	/*Mejorar esto*/
        	$objeto = new stdClass();
        	$objeto->id = $datos_persona[0]->PERSP_Codigo;
        	$objeto->persona = $datos_persona[0]->PERSP_Codigo;
        	$objeto->empresa = 0;
        	$objeto->nombre = $datos_persona[0]->PERSC_ApellidoPaterno . " " . $datos_persona[0]->PERSC_ApellidoMaterno . " " . $datos_persona[0]->PERSC_Nombre;
        	$objeto->ruc = $datos_persona[0]->PERSC_Ruc;
        	$objeto->telefono = $datos_persona[0]->PERSC_Telefono;
        	$objeto->fax = $datos_persona[0]->PERSC_Fax;
        	$objeto->movil = $datos_persona[0]->PERSC_Movil;
        	$objeto->web = $datos_persona[0]->PERSC_Web;
        	$objeto->direccion = $datos_persona[0]->PERSC_Direccion;
        	$objeto->email = $datos_persona[0]->PERSC_Email;
        	$objeto->ctactesoles = $datos_persona[0]->PERSC_CtaCteSoles;
        	$objeto->ctactedolares = $datos_persona[0]->PERSC_CtaCteDolares;
        	$objeto->dni = $datos_persona[0]->PERSC_NumeroDocIdentidad;

        	$objeto->TIP_Codigo = $tipo_persona;

        	$objeto->tipo = "0";
        	$data['datos'] = $objeto;
        	/**/

        	/* Enviar arreglo vacio  */
        	$data['listado_empresaMarcas'] = array();
        	$data['listado_empresaTipos'] = array();
        	$data['display_datosEmpresa'] = "display:none;";
        	$data['display_datosPersona'] = "";
        	$data['titulo'] = "EDITAR PROVEEDOR ::: " . $nombre_persona;
        }
        else
        	if ($tipo_persona == 1) {
        		$data['listado_cuentaEmpresa']= $this->empresa_model->listCuentaEmpresa($empresa);

        		$datos_empresa = $this->empresa_model->obtener_datosEmpresa($empresa);
        		$razon_social = $datos_empresa[0]->EMPRC_RazonSocial;
        		$datos = $this->empresa_model->obtener_datosEmpresa($empresa);
        		/**/
        		$datos_empresaSucursal = $this->empresa_model->obtener_establecimientoEmpresa($empresa, '1');
        		if (count($datos_empresaSucursal) > 0) {
        			$direccion = $datos_empresaSucursal[0]->EESTAC_Direccion;
        		} else {
        			$direccion = "";
        		}
        		$id = $datos_empresa[0]->EMPRP_Codigo;
        		$tipocodigo = $datos_empresa[0]->TIPCOD_Codigo;

        		$objeto = new stdClass();
        		$objeto->id = $datos[0]->EMPRP_Codigo;
        		$objeto->persona = 0;
        		$objeto->empresa = $datos[0]->EMPRP_Codigo;
        		$objeto->nombre = $datos[0]->EMPRC_RazonSocial;
        		$objeto->ruc = $datos[0]->EMPRC_Ruc;
        		$objeto->telefono = $datos[0]->EMPRC_Telefono;
        		$objeto->fax = $datos[0]->EMPRC_Fax;
        		$objeto->movil = $datos[0]->EMPRC_Movil;
        		$objeto->web = $datos[0]->EMPRC_Web;
        		$objeto->direccion = $direccion;
        		$objeto->email = $datos[0]->EMPRC_Email;
        		$objeto->ctactesoles = $datos[0]->EMPRC_CtaCteSoles;
        		$objeto->ctactedolares = $datos[0]->EMPRC_CtaCteDolares;
        		$objeto->tipo = "1";
        		$objeto->dni = "";

        		$objeto->TIP_Codigo = $tipo_persona;

        		$data['datos'] = $objeto;
        		/*Mejorar esto*/
        		$datos_empresaSucursal = $this->empresa_model->obtener_establecimientoEmpresa($empresa, '1');
        		$listado_empresaSucursal = $this->listar_sucursalesEmpresa($empresa, '0');
        		$listado_empresaContactos = $this->listar_contactosEmpresa($empresa);
        		$listado_empresaMarcas = $this->listar_marcasEmpresa($empresa);
        		$listado_empresaTipos = $this->listar_tiposEmpresa($id_proveedor);

        		if (count($datos_empresaSucursal) > 0) {
        			$ubigeo_domicilio = $datos_empresaSucursal[0]->UBIGP_Codigo;
        			$dpto_domicilio = substr($ubigeo_domicilio, 0, 2);
        			$prov_domicilio = substr($ubigeo_domicilio, 2, 2);
        			$dist_domicilio = substr($ubigeo_domicilio, 4, 2);

        		} else {
        			$dpto_domicilio = "15";
        			$prov_domicilio = "01";
        			$dist_domicilio = "";
        		}
        		$data['cbo_sectorComercial'] = $this->OPTION_generador($this->sectorcomercial_model->listar(), 'SECCOMP_Codigo', 'SECCOMC_Descripcion', $datos[0]->SECCOMP_Codigo);
        		$data['listado_empresaContactos'] = $listado_empresaContactos;
        		$data['listado_empresaSucursal'] = $listado_empresaSucursal;
        		$data['listado_empresaMarcas'] = $listado_empresaMarcas;
        		$data['listado_empresaTipos'] = $listado_empresaTipos;
        		$data['cbo_dpto'] = $this->seleccionar_departamento($dpto_domicilio);
        		$data['cbo_prov'] = $this->seleccionar_provincia($dpto_domicilio, $prov_domicilio);
        		$data['cbo_dist'] = $this->seleccionar_distritos($dpto_domicilio, $prov_domicilio, $dist_domicilio);
                //$data['direccion']              = $direccion_domicilio;
        		$data['display_datosEmpresa'] = "";
        		$data['display_datosPersona'] = "display:none;";
        		$data['nombres'] = "";
        		$data['paterno'] = "";
        		$data['materno'] = "";
        		$data['tipocodigo'] = $this->seleccionar_tipocodigo($tipocodigo);
        		$data['ruc'] = "";
        		$data['numero_documento'] = "";
        		$data['sexo'] = "0";
        		$data['tipo_documento'] = $this->seleccionar_tipodocumento('1');
        		$data['cbo_nacionalidad'] = $this->seleccionar_nacionalidad('193');
        		$data['titulo'] = "EDITAR PROVEEDOR ::: " . $razon_social;
        	}
        	$data['listado_empresaTipos'] = array();
        	$this->load->view("compras/proveedor_nuevo", $data);
        }

        public function modificar_proveedor()
        {
        	$id = $this->input->post('id');
        	$datos = $this->proveedor_model->obtener_datosProveedor($id);
        	$empresa = $datos[0]->EMPRP_Codigo;
        	$persona = $datos[0]->PERSP_Codigo;
        	$tipo_persona = $datos[0]->PROVC_TipoPersona;
        	$tipocodigo = $this->input->post('cboTipoCodigo');
        	$ruc = $this->input->post('ruc');
        	$razon_social = $this->input->post('razon_social');
        	$telefono = $this->input->post('telefono');
        	$movil = $this->input->post('movil');
        	$fax = $this->input->post('fax');
        	$email = $this->input->post('email');
        	$web = $this->input->post('web');
        	$sector_comercial = $this->input->post('sector_comercial');
        	$ctactesoles = $this->input->post('ctactesoles');
        	$ctactedolares = $this->input->post('ctactedolares');

        	$ubigeo_nacimiento = $this->input->post('cboNacimiento');
        	$ubigeo_domicilio = $this->input->post('cboDepartamento') . $this->input->post('cboProvincia') . $this->input->post('cboDistrito');;
        	$domicilio = $this->input->post('direccion');
        	$estado_civil = $this->input->post('cboEstadoCivil');
        	$nacionalidad = $this->input->post('cboNacionalidad');
        	$nombres = $this->input->post('nombres');
        	$paterno = $this->input->post('paterno');
        	$materno = $this->input->post('materno');
        	$ruc_persona = $this->input->post('ruc_persona');
        	$tipo_documento = $this->input->post('tipo_documento');
        	$numero_documento = $this->input->post('numero_documento');
        	$direccion = $this->input->post('direccion');
        	$sexo = $this->input->post('cboSexo');
        	if ($tipo_persona == 0) {
        		$this->persona_model->modificar_datosPersona($persona, $ubigeo_nacimiento, $ubigeo_domicilio, $estado_civil, $nacionalidad, $nombres, $paterno, $materno, $ruc_persona, $tipo_documento, $numero_documento, $direccion, $telefono, $movil, $email, $domicilio, $sexo, $fax, $web, $ctactesoles, $ctactedolares);
        	} elseif ($tipo_persona == 1) {
        		$this->empresa_model->modificar_datosEmpresa($empresa, $tipocodigo, $ruc, $razon_social, $telefono, $movil, $fax, $web, $email, $sector_comercial, $ctactesoles, $ctactedolares,$direccion);
        		$this->empresa_model->modificar_sucursalEmpresaPrincipal($empresa, '1', $ubigeo_domicilio, 'PRINCIPAL', $direccion);
            //Modificar contactows empresa
        	}
        }

        public function eliminar_proveedor()
        {
        	$proveedor = $this->input->post('proveedor');
        /*$datos_proveedor = $this->proveedor_model->obtener_datosProveedor($proveedor);
        $tipo_cliente  = $datos_proveedor[0]->PROVC_TipoPersona;
        $persona         = $datos_proveedor[0]->PERSP_Codigo;
        $empresa         = $datos_proveedor[0]->EMPRP_Codigo;
        if($tipo_cliente=='0'){//Persona
            $this->persona_model->eliminar_persona($persona);
        }
        elseif($tipo_cliente=='1'){
            $this->empresa_model->eliminar_empresa_total($empresa);
          }*/

          $eliminar = $this->proveedor_model->eliminar_proveedor($proveedor);
          echo $eliminar;
        }


        public function eliminar_marca()
        {
        	$marca = $this->input->post('marca');
        	$empresa = $this->input->post('empresa');
        	$this->empresa_model->eliminar_marcaEmpresa($marca, $empresa);
        	echo $this->TABLA_marcas('p', $empresa);
        }

        public function eliminar_tipo()
        {
        	$tipo = $this->input->post('tipo');
        	$proveedor = $this->input->post('proveedor');
        	$this->empresa_model->eliminar_tipoProveedor($tipo);
        	echo $this->TABLA_tipos('p', $proveedor);
        }

        public function TABLA_tipos($tipo, $proveedor, $pinta = 0)
        {
        	$datos_marcasProveedor = $this->empresa_model->obtener_tiposEmpresa($proveedor);

        	$tabla = '<table id="tablaTipo" width="98%" class="fuente8" width="98%" cellspacing=0 cellpadding="6" border="1">
        	<tr align="center" bgcolor="#BBBB20" height="10px;">
        	<td>Nro</td>
        	<td>Nombre del tipo de proveedor</td>
        	<td>Borrar</td>
        	<td>Editar</td>
        	</tr>';

        	$item = 1;
        	if (count($datos_marcasProveedor) > 0) {
        		foreach ($datos_marcasProveedor as $valor) {
        			$tabla .= '<tr bgcolor="#ffffff">';
        			$nombre_marca = $valor->FAMI_Descripcion;
        			$codigo = $valor->FAMI_Codigo;
        			$registro = $valor->EMPTIPOP_Codigo;
        			$codigo = "<input type='hidden' name='tipoCodigo[" . $item . "]' id='tipoCodigo[" . $item . "]' class='cajaMedia' value='" . $codigo . "'>";
                // $nombre_marca .= "<input type='text' name='contactoNombre[".$item."]' id='contactoNombre[".$item."]' class='cajaMedia' value='".$nombre_marca."'>";
        			$editar = "&nbsp;";
        			$eliminar = "<a href='#' onclick='eliminar_tipo(" . $registro . ");'><img src='" . base_url() . "images/delete.gif' border='0'></a>";
        			$tabla .= '<td>' . $item . '</td>';
        			$tabla .= '<td>' . $nombre_marca . '</td>';
        			$tabla .= '<td>' . $eliminar . '</td>';
        			$tabla .= '<td>' . $editar . '</td>';
        			$tabla .= '</tr>';
        			$item++;
        		}
        	}
        	$tabla .= '</table>';
        	if (count($datos_marcasProveedor) == 0)
        		$tabla .= '<div id="msgRegistros" style="width:98%;text-align:center;height:20px;border:1px solid #000;">NO EXISTEN REGISTROS</div>';

        	if ($pinta == '1')
        		echo $tabla;
        	else
        		return $tabla;
        }

        public function TABLA_marcas($tipo, $empresa, $pinta = 0)
        {
        	$datos_marcasProveedor = $this->empresa_model->obtener_marcasEmpresa($empresa);

        	$tabla = '<table id="tablaMarca" width="98%" class="fuente8" width="98%" cellspacing=0 cellpadding="6" border="1">
        	<tr align="center" bgcolor="#BBBB20" height="10px;">
        	<td>Nro</td>
        	<td>Nombre de la marca</td>
        	<td>Borrar</td>
        	<td>Editar</td>
        	</tr>';

        	$item = 1;
        	if (count($datos_marcasProveedor) > 0) {
        		foreach ($datos_marcasProveedor as $valor) {
        			$tabla .= '<tr bgcolor="#ffffff">';
        			$nombre_marca = $valor->MARCC_Descripcion;
        			$codigo = $valor->MARCP_Codigo;
        			$registro = $valor->EMPMARP_Codigo;
        			$codigo = "<input type='hidden' name='marcaCodigo[" . $item . "]' id='marcaCodigo[" . $item . "]' class='cajaMedia' value='" . $codigo . "'>";
                // $nombre_marca .= "<input type='text' name='contactoNombre[".$item."]' id='contactoNombre[".$item."]' class='cajaMedia' value='".$nombre_marca."'>";
        			$editar = "&nbsp;";
        			$eliminar = "<a href='#' onclick='eliminar_marca(" . $registro . ");'><img src='" . base_url() . "images/delete.gif' border='0'></a>";
        			$tabla .= '<td>' . $item . '</td>';
        			$tabla .= '<td>' . $nombre_marca . '</td>';
        			$tabla .= '<td>' . $eliminar . '</td>';
        			$tabla .= '<td>' . $editar . '</td>';
        			$tabla .= '</tr>';
        			$item++;
        		}
        	}
        	$tabla .= '</table>';
        	if (count($datos_marcasProveedor) == 0)
        		$tabla .= '<div id="msgRegistros" style="width:98%;text-align:center;height:20px;border:1px solid #000;">NO EXISTEN REGISTROS</div>';

        	if ($pinta == '1')
        		echo $tabla;
        	else
        		return $tabla;
        }

        public function buscar_proveedores($j = '0')
        {
        	$numdoc = $this->input->post('txtNumDoc');
        	$nombre = $this->input->post('txtNombre');
        	$telefono = $this->input->post('txtTelefono');
        	$tipo = $this->input->post('cboTipoProveedor');
        	$codtipoproveedor = $this->input->post('tipoCodigo');
        	$nombre_tipoproveedor = $this->input->post('tipoNombre');
        	$codmarca = $this->input->post('marcaCodigo');
        	$nombre_marcaproveedor = $this->input->post('marcaNombre');
        //$direccion=$this->input->post('txtDireccion');
        	$filter = new stdClass();
        	$filter->numdoc = $numdoc;
        	$filter->nombre = $nombre;
        	$filter->telefono = $telefono;
        	$filter->codtipoproveedor = $codtipoproveedor;
        	$filter->codmarca = $codmarca;
        //$filter->direccion=$direccion;

        	$data['numdoc'] = $numdoc;
        	$data['nombre'] = $nombre;
        	$data['telefono'] = $telefono;
        	$data['tipo'] = $tipo;
        	$data['codtipoproveedor'] = $codtipoproveedor;
        	$data['nombre_tipoproveedor'] = $nombre_tipoproveedor;
        	$data['codmarca'] = $codmarca;
        	$data['nombre_marcaproveedor'] = $nombre_marcaproveedor;
        //$data['direccion']=$direccion;
        	$data['titulo_tabla'] = "RESULTADO DE BÚSQUEDA DE PROVEEDORES";

        	$data['registros'] = count($this->proveedor_model->buscar_proveedor($filter));
        	$conf['base_url'] = site_url('compras/proveedor/buscar_proveedores/');
        	$data['action'] = base_url() . "index.php/compras/proveedor/buscar_proveedores";
        	$conf['total_rows'] = $data['registros'];
        	$conf['per_page'] = 50;
        	$conf['num_links'] = 3;
        	$conf['next_link'] = "&gt;";
        	$conf['prev_link'] = "&lt;";
        	$conf['first_link'] = "&lt;&lt;";
        	$conf['last_link'] = "&gt;&gt;";
        	$conf['uri_segment'] = 4;
        	$this->pagination->initialize($conf);
        	$data['paginacion'] = $this->pagination->create_links();
        	$listado_proveedores = $this->proveedor_model->buscar_proveedor($filter, $conf['per_page'], $j);
        	$item = $j + 1;
        	$lista = array();
        	if (count($listado_proveedores) > 0) {
        		foreach ($listado_proveedores as $indice => $valor) {
        			$codigo = $valor->PROVP_Codigo;
        			$ruc = $valor->ruc;
        			$dni = $valor->dni;
        			$razon_social = $valor->nombre;
        			$direccion=$valor->direccion;
        			$tipo_cliente = $valor->PROVC_TipoPersona == 1 ? "P.JURIDICA" : "P.NATURAL";

                //$telefono = $valor->telefono;
                //$movil = $valor->movil;
        			$editar = "<a href='#' onclick='editar_proveedor(" . $codigo . ")'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
        			$ver = "<a href='#' onclick='ver_proveedor(" . $codigo . ")'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
        			$eliminar = "<a href='#' onclick='eliminar_proveedor(" . $codigo . ")'><img src='" . base_url() . "images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
        			$lista[] = array($item, $ruc, $dni, $razon_social, 
        				$tipo_cliente,$direccion,
                 //$telefono, $movil,
        				$editar, $ver, $eliminar);
        			$item++;
        		}
        	}
        	$data['lista'] = $lista;
        	$this->layout->view("compras/proveedor_index", $data);

        }

        public function ventana_selecciona_proveedor($buscar)
        {
        	if (is_numeric($buscar))
        		$this->session->set_userdata(array('ruc' => $buscar, 'nombre' => ''));
        	else
        		$this->session->set_userdata(array('ruc' => '', 'nombre' => $buscar));

        	$this->ventana_busqueda_proveedor();
        }

        public function ventana_busqueda_proveedor($j = 0, $limpia = '')
        {
        	$ruc = $this->input->post('ruc');
        	$nombre = $this->input->post('nombre');
        	if ($limpia == '1') {
        		$this->session->unset_userdata('ruc');
        		$this->session->unset_userdata('nombre');
        	}
        	if (count($_POST) > 0) {
        		$this->session->set_userdata(array('ruc' => $ruc, 'nombre' => $nombre));
        	} else {
        		$ruc = $this->session->userdata('ruc');
        		$nombre = $this->session->userdata('nombre');
        	}
        	$filter = new stdClass();
        	$filter->ruc = $ruc;
        	$filter->nombre = $nombre;
        	$data['ruc'] = $ruc;
        	$data['nombre'] = $nombre;

        	$data['registros'] = count($this->proveedor_model->buscar_proveedor($filter));
        	$data['action'] = base_url() . 'index.php/compras/proveedor/ventana_busqueda_proveedor';
        	$conf['base_url'] = site_url('compras/proveedor/ventana_busqueda_proveedor');
        	$conf['total_rows'] = $data['registros'];
        	$conf['per_page'] = 10;
        	$conf['num_links'] = 3;
        	$conf['next_link'] = "&gt;";
        	$conf['prev_link'] = "&lt;";
        	$conf['first_link'] = "&lt;&lt;";
        	$conf['last_link'] = "&gt;&gt;";
        	$conf['uri_segment'] = 4;
        	$this->pagination->initialize($conf);
        	$data['paginacion'] = $this->pagination->create_links();
        	$listado_proveedores = $this->proveedor_model->buscar_proveedor($filter, $conf['per_page'], $j);
        	$item = $j + 1;
        	$lista = array();
        	if (count($listado_proveedores) > 0) {
        		foreach ($listado_proveedores as $indice => $valor) {
        			$empresa = $valor->EMPRP_Codigo;
        			$persona = $valor->PERSP_Codigo;
        			$codigo = $valor->PROVP_Codigo;
        			$ruc = $valor->ruc;
        			$ruc_c = (($filter->ruc != '') ? str_replace($filter->ruc, '<span class="texto_busq">' . $filter->ruc . '</span>', $ruc) : $ruc);
        			$razon_social = $valor->nombre;
        			$razon_social_c = (($filter->nombre != '') ? str_replace(strtoupper($filter->nombre), '<span class="texto_busq">' . strtoupper($filter->nombre) . '</span>', $razon_social) : $razon_social);
        			$tipo_cliente = $valor->PROVC_TipoPersona == 1 ? "P.JURIDICA" : "P.NATURAL";
        			$telefono = $valor->telefono;
        			$movil = $valor->movil;
        			$lista_Establec = $this->emprestablecimiento_model->listar($empresa, '1');
        			$direccion = count($lista_Establec) > 0 ? $lista_Establec[0]->EESTAC_Direccion . ' ' . ($lista_Establec[0]->UBIGP_Codigo != '000000' ? $lista_Establec[0]->distrito . ' - ' . $lista_Establec[0]->provincia . ' - ' . $lista_Establec[0]->departamento : '') : '';
        			$ctactesoles = "";
        			$ctactedolares = "";
        			$seleccionar = "<a href='#' onclick='seleccionar_proveedor(" . $codigo . ",\"" . ($ruc) . "\",\"" . $razon_social . "\", " . $empresa . ", " . $persona . ", \"" . $direccion . "\")'><img src='" . base_url() . "images/convertir.png'  border='0' title='Seleccionar'></a>";
        			$lista[] = array($item, $ruc_c, $razon_social_c, $tipo_cliente, $seleccionar, $codigo, $empresa, $persona, $ctactesoles, $ctactedolares, $direccion);
        			$item++;
        		}
        	}
        	$data['lista'] = $lista;
        	$data['cbo_categoria'] = $this->OPTION_generador($this->sectorcomercial_model->listar(), 'SECCOMP_Codigo', 'SECCOMC_Descripcion', '');
        	$data['tipo_documento'] = $this->seleccionar_tipodocumento('1');
        	$data['tipocodigo'] = $this->seleccionar_tipocodigo('1');
        	$this->load->view('compras/proveedor_ventana_busqueda', $data);
        }

        public function obtener_nombre_proveedor($numdoc)
        {
        	$datos_empresa = $this->empresa_model->obtener_datosEmpresa2($numdoc);
        	$datos_persona = $this->persona_model->obtener_datosPersona2($numdoc);
        	$resultado = '[{"PROVP_Codigo":"0","EMPRC_Ruc":"","EMPRC_RazonSocial":""}]';
        	if (count($datos_empresa) > 0) {
        		$empresa = $datos_empresa[0]->EMPRP_Codigo;
        		$razon_social = $datos_empresa[0]->EMPRC_RazonSocial;
        		$datosProveedor = $this->proveedor_model->obtener_datosProveedor2($empresa);
        		if (count($datosProveedor) > 0) {
        			$proveedor = $datosProveedor[0]->PROVP_Codigo;
        			$resultado = '[{"PROVP_Codigo":"' . $proveedor . '","EMPRC_Ruc":"' . $numdoc . '","EMPRC_RazonSocial":"' . $razon_social . '"}]';
        		}
        	} elseif (count($datos_persona) > 0) {
        		$persona = $datos_persona[0]->PERSP_Codigo;
        		$nombres = $datos_persona[0]->PERSC_Nombre . " " . $datos_persona[0]->PERSC_ApellidoPaterno . " " . $datos_persona[0]->PERSC_ApellidoMaterno;
        		$datosProveedor = $this->proveedor_model->obtener_datosProveedor3($persona);
        		if (count($datosProveedor) > 0) {
        			$proveedor = $datosProveedor[0]->PROVP_Codigo;
        			$resultado = '[{"PROVP_Codigo":"' . $proveedor . '","EMPRC_Ruc":"' . $numdoc . '","EMPRC_RazonSocial":"' . $nombres . '"}]';
        		}
        	}
        	echo $resultado;
        }

        public function obtener_proveedor($proveedor)
        {
        	$datos_proveedor = $this->proveedor_model->obtener($proveedor);
        	echo json_encode($datos_proveedor);
        }

        public function ver_proveedor($proveedor)
        {
        	$datos_proveedor = $this->proveedor_model->obtener_datosProveedor($proveedor);
        	$persona = $datos_proveedor[0]->PERSP_Codigo;
        	$empresa = $datos_proveedor[0]->EMPRP_Codigo;
        	$tipo_cliente = $datos_proveedor[0]->PROVC_TipoPersona;
        	if ($tipo_cliente == 0) {
        		$datos = $this->persona_model->obtener_datosPersona($persona);
        		$tipo_doc = $datos[0]->PERSC_TipoDocIdentidad;
        		$estado_civil = $datos[0]->ESTCP_EstadoCivil;
        		$nacionalidad = $datos[0]->NACP_Nacionalidad;
        		$nacimiento = $datos[0]->UBIGP_LugarNacimiento;
        		$sexo = $datos[0]->PERSC_Sexo;
        		$ubigeo_domicilio = $datos[0]->UBIGP_Domicilio;
        		$datos_nacionalidad = $this->nacionalidad_model->obtener_nacionalidad($nacionalidad);
        		$datos_nacimiento = $this->ubigeo_model->obtener_ubigeo($nacimiento);
        		$datos_ubigeoDom_dpto = $this->ubigeo_model->obtener_ubigeo_dpto($ubigeo_domicilio);
        		$datos_ubigeoDom_prov = $this->ubigeo_model->obtener_ubigeo_prov($ubigeo_domicilio);
        		$datos_ubigeoDom_dist = $this->ubigeo_model->obtener_ubigeo($ubigeo_domicilio);
        		$datos_doc = $this->tipodocumento_model->obtener_tipoDocumento($tipo_doc);
        		$datos_estado_civil = $this->estadocivil_model->obtener_estadoCivil($estado_civil);
        		$data['nacionalidad'] = $datos_nacionalidad[0]->NACC_Descripcion;
        		$data['nacimiento'] = $datos_nacimiento[0]->UBIGC_Descripcion;
        		$data['tipo_doc'] = $datos_doc[0]->TIPOCC_Inciales;
        		$data['estado_civil'] = $datos_estado_civil[0]->ESTCC_Descripcion;
        		$data['sexo'] = $sexo == 0 ? 'MASCULINO' : 'FEMENINO';
        		$data['telefono'] = $datos[0]->PERSC_Telefono;
        		$data['movil'] = $datos[0]->PERSC_Movil;
        		$data['fax'] = $datos[0]->PERSC_Fax;
        		$data['email'] = $datos[0]->PERSC_Email;
        		$data['web'] = $datos[0]->PERSC_Web;
        		$data['direccion'] = $datos[0]->PERSC_Direccion;
        		$data['dpto'] = $datos_ubigeoDom_dpto[0]->UBIGC_Descripcion;
        		$data['prov'] = $datos_ubigeoDom_prov[0]->UBIGC_Descripcion;
        		$data['dist'] = $datos_ubigeoDom_dist[0]->UBIGC_Descripcion;
        	} elseif ($tipo_cliente == 1) {
        		$datos = $this->empresa_model->obtener_datosEmpresa($empresa);
        		$datos_sucurPrincipal = $this->empresa_model->obtener_establecimientosEmpresa_principal($empresa);
        		$ubigeo_domicilio = $datos_sucurPrincipal[0]->UBIGP_Codigo;
        		$datos_ubigeoDom_dpto = $this->ubigeo_model->obtener_ubigeo_dpto($ubigeo_domicilio);
        		$data['dpto'] = $datos_ubigeoDom_dpto[0]->UBIGC_Descripcion;
        		$data['prov'] = $datos_ubigeoDom_dpto[0]->UBIGC_Descripcion;
        		$data['dist'] = $datos_ubigeoDom_dpto[0]->UBIGC_Descripcion;
        		$data['direccion'] = $datos_sucurPrincipal[0]->EESTAC_Direccion;
        		$data['telefono'] = $datos[0]->EMPRC_Telefono;
        		$data['movil'] = $datos[0]->EMPRC_Movil;
        		$data['fax'] = $datos[0]->EMPRC_Fax;
        		$data['email'] = $datos[0]->EMPRC_Email;
        		$data['web'] = $datos[0]->EMPRC_Web;
        	}
        	$data['datos'] = $datos;
        	$data['titulo'] = "VER PROVEEDOR";
        	$data['tipo'] = $tipo_cliente;
        	$this->load->view('compras/proveedor_ver', $data);
        }

        public function obtener_datosEmpresa_array($datos_empresa)
        {
        	$resultado = array();
        	foreach ($datos_empresa as $indice => $valor) {
        		$objeto = new stdClass();
        		$empresa = $datos_empresa[$indice]->EMPRP_Codigo;
        		$datos_empresaSucursal = $this->empresa_model->obtener_establecimientoEmpresa($empresa, '1');
        		if (count($datos_empresaSucursal) > 0) {
        			$direccion = $datos_empresaSucursal[0]->EESTAC_Direccion;
        		} else {
        			$direccion = "";
        		}
        		$objeto->id = $datos_empresa[$indice]->EMPRP_Codigo;
        		$objeto->persona = 0;
        		$objeto->empresa = $datos_empresa[$indice]->EMPRP_Codigo;
        		$objeto->nombre = $datos_empresa[$indice]->EMPRC_RazonSocial;
        		$objeto->ruc = $datos_empresa[$indice]->EMPRC_Ruc;
        		$objeto->telefono = $datos_empresa[$indice]->EMPRC_Telefono;
        		$objeto->fax = $datos_empresa[$indice]->EMPRC_Fax;
        		$objeto->movil = $datos_empresa[$indice]->EMPRC_Movil;
        		$objeto->web = $datos_empresa[$indice]->EMPRC_Web;
        		$objeto->direccion = $direccion;
        		$objeto->email = $datos_empresa[$indice]->EMPRC_Email;
        		$objeto->tipo = "1";
        		$objeto->dni = "";
        		$resultado[$indice] = $objeto;
        	}
        	return $resultado;
        }

        public function listar_sucursalesEmpresa($empresa)
        {
        	$listado_sucursalesEmpresa = $this->empresa_model->listar_sucursalesEmpresa($empresa, '0');
        	$resultado = array();
        	if (count($listado_sucursalesEmpresa) > 0) {
        		foreach ($listado_sucursalesEmpresa as $indice => $valor) {
        			$tipo = $valor->TESTP_Codigo;
        			$ubigeo = $valor->UBIGP_Codigo;
        			$datos_tipoEstab = $this->tipoestablecimiento_model->obtener_tipoEstablecimiento($tipo);
        			$nombre_tipo = "";
        			if ($tipo != '') {
        				$datos_tipoEstab = $this->tipoestablecimiento_model->obtener_tipoEstablecimiento($tipo);
        				if (count($datos_tipoEstab) > 0)
        					$nombre_tipo = $datos_tipoEstab[0]->TESTC_Descripcion;
        			}
        			$nombre_ubigeo = "";
        			if ($ubigeo != '000000' && $ubigeo != '') {
        				$datos_ubigeo = $this->ubigeo_model->obtener_ubigeo($ubigeo);
        				if (count($datos_ubigeo) > 0)
        					$nombre_ubigeo = $datos_ubigeo[0]->UBIGC_Descripcion;
        			}
        			$objeto = new stdClass();
        			$objeto->tipo = $valor->TESTP_Codigo;
        			$objeto->nombre_tipo = $nombre_tipo;
        			$objeto->empresa = $valor->EMPRP_Codigo;
        			$objeto->ubigeo = $valor->UBIGP_Codigo;
        			$objeto->des_ubigeo = $nombre_ubigeo;
        			$objeto->descripcion = $valor->EESTABC_Descripcion == '' ? '&nbsp;' : $valor->EESTABC_Descripcion;
        			$objeto->direccion = $valor->EESTAC_Direccion == '' ? "&nbsp;" : $valor->EESTAC_Direccion;
        			$objeto->estado = $valor->EESTABC_FlagEstado;
        			$objeto->sucursal = $valor->EESTABP_Codigo;
        			$resultado[] = $objeto;
        		}
        	}
        	return $resultado;
        }

        public function listar_contactosEmpresa($empresa)
        {
        	$listado_contactosEmpresa = $this->empresa_model->listar_contactosEmpresa($empresa);
        	$resultado = array();
        	if (count($listado_contactosEmpresa) > 0) {
        		foreach ($listado_contactosEmpresa as $indice => $valor) {
        			$persona = $valor->ECONC_Persona;
        			$datos_persona = $this->persona_model->obtener_datosPersona($persona);
        			$nombres_persona = $datos_persona[0]->PERSC_Nombre . " " . $datos_persona[0]->PERSC_ApellidoPaterno . " " . $datos_persona[0]->PERSC_ApellidoMaterno . " ";
        			$datos_directivo = $this->directivo_model->buscar_directivo($empresa, $persona);
        			$directivo = $datos_directivo[0]->DIREP_Codigo;
        			$cargo = $datos_directivo[0]->CARGP_Codigo;
        			$datos_areaEmpresa = $this->empresa_model->obtener_areaEmpresa($empresa, $directivo);
        			$datos_cargo = $this->cargo_model->obtener_cargo($cargo);
        			$nombre_cargo = $datos_cargo[0]->CARGC_Descripcion;
        			$area = $datos_areaEmpresa[0]->AREAP_Codigo;
        			$datos_area = $this->area_model->obtener_area($area);
        			$nombre_area = $datos_area[0]->AREAC_Descripcion;
        			$objeto = new stdClass();
        			$objeto->area = $area;
        			$objeto->nombre_area = $nombre_area;
        			$objeto->empresa = $valor->EMPRP_Codigo;
        			$objeto->personacontacto = $valor->PERSP_Contacto;
        			$objeto->descripcion = $valor->ECONC_Descripcion;
        			$objeto->telefono = $valor->ECONC_Telefono == '' ? '&nbsp;' : $valor->ECONC_Telefono;
        			$objeto->movil = $valor->ECONC_Movil;
        			$objeto->fax = $valor->ECONC_Fax;
        			$objeto->email = $valor->ECONC_Email == '' ? '&nbsp;' : $valor->ECONC_Email;
        			$objeto->persona = $valor->ECONC_Persona;
        			$objeto->nombre_persona = $nombres_persona;
        			$objeto->tipo_contacto = $valor->ECONC_TipoContacto;
        			$objeto->nombre_cargo = $nombre_cargo;
        			$resultado[] = $objeto;
        		}
        	}
        	return $resultado;
        }

        public function listar_marcasEmpresa($empresa)
        {
        	$listado_marcasEmpresa = $this->empresa_model->listar_marcasEmpresa($empresa);
        	$resultado = array();
        	if (count($listado_marcasEmpresa) > 0) {
        		foreach ($listado_marcasEmpresa as $indice => $valor) {
        			$objeto = new stdClass();
        			$objeto->numero = $valor->EMPRP_Codigo;
        			$objeto->registro = $valor->EMPMARP_Codigo;
        			$objeto->nombre_marca = $valor->MARCC_Descripcion;
        			$resultado[] = $objeto;
        		}
        	}
        	return $resultado;
        }

        public function listar_tiposEmpresa($proveedor)
        {
        	$empresa = $proveedor;
        	$listado_tiposEmpresa = $this->empresa_model->listar_tiposEmpresa($proveedor);
        	$resultado = array();
        	if (count($listado_tiposEmpresa) > 0) {
        		foreach ($listado_tiposEmpresa as $indice => $valor) {
        			$objeto = new stdClass();
        			$objeto->numero = $valor->FAMI_Codigo;
        			$objeto->registro = $valor->EMPTIPOP_Codigo;
        			$objeto->nombre_tipo = $valor->FAMI_Descripcion;
        			$resultado[] = $objeto;
        		}
        	}
        	return $resultado;
        }

        public function seleccionar_estadoCivil($indSel)
        {
        	$array_dist = $this->estadocivil_model->listar_estadoCivil();
        	$arreglo = array();
        	foreach ($array_dist as $indice => $valor) {
        		$indice1 = $valor->ESTCP_Codigo;
        		$valor1 = $valor->ESTCC_Descripcion;
        		$arreglo[$indice1] = $valor1;
        	}
        	$resultado = $this->html->optionHTML($arreglo, $indSel, array('0', '::Seleccione::'));
        	return $resultado;
        }

        public function seleccionar_nacionalidad($indSel = '')
        {
        	$array_dist = $this->nacionalidad_model->listar_nacionalidad();
        	$arreglo = array();
        	foreach ($array_dist as $indice => $valor) {
        		$indice1 = $valor->NACP_Codigo;
        		$valor1 = $valor->NACC_Descripcion;
        		$arreglo[$indice1] = $valor1;
        	}
        	$resultado = $this->html->optionHTML($arreglo, $indSel, array('', '::Seleccione::'));
        	return $resultado;
        }

        public function insertar_areaEmpresa($nombre_area){
        	$this->empresa_model->insertar_areaEmpresa($area, $empresa, $descripcion);
        }

        public function seleccionar_departamento($indDefault = '')
        {
        	$array_dpto = $this->ubigeo_model->listar_departamentos();
        	$arreglo = array();
        	if (count($array_dpto) > 0) {
        		foreach ($array_dpto as $indice => $valor) {
        			$indice1 = $valor->UBIGC_CodDpto;
        			$valor1 = $valor->UBIGC_DescripcionDpto;
        			$arreglo[$indice1] = $valor1;
        		}
        	}
        	$resultado = $this->html->optionHTML($arreglo, $indDefault, array('00', '::Seleccione::'));
        	return $resultado;
        }

        public function seleccionar_provincia($departamento, $indDefault = '')
        {
        	$array_prov = $this->ubigeo_model->listar_provincias($departamento);
        	$arreglo = array();
        	if (count($array_prov) > 0) {
        		foreach ($array_prov as $indice => $valor) {
        			$indice1 = substr($valor->UBIGC_CodProv,2,2);
        			$valor1 = $valor->UBIGC_DescripcionProv;
        			$arreglo[$indice1] = $valor1;
        		}
        	}
        	$resultado = $this->html->optionHTML($arreglo, $indDefault, array('00', '::Seleccione::'));
        	return $resultado;
        }

        public function seleccionar_distritos($departamento, $provincia, $indDefault = '')
        {
        	$array_dist = $this->ubigeo_model->listar_distritos($departamento, $provincia);
        	$arreglo = array();
        	if (count($array_dist) > 0) {
        		foreach ($array_dist as $indice => $valor) {
        			$indice1 = substr($valor->UBIGC_CodDist,4,2);
        			$valor1 = $valor->UBIGC_Descripcion;
        			$arreglo[$indice1] = $valor1;
        		}
        	}
        	$resultado = $this->html->optionHTML($arreglo, $indDefault, array('00', '::Seleccione::'));
        	return $resultado;
        }

        public function seleccionar_tipocodigo($indDefault = '')
        {
        	$array_dist = $this->tipocodigo_model->listar_tipo_codigo();
        	$arreglo = array();
        	if (count($array_dist) > 0) {
        		foreach ($array_dist as $indice => $valor) {
        			$indice1 = $valor->TIPCOD_Codigo;
        			$valor1 = $valor->TIPCOD_Inciales;
        			$arreglo[$indice1] = $valor1;
        		}
        	}
        	$resultado = $this->html->optionHTML($arreglo, $indDefault, array('0', '::Seleccione::'));
        	return $resultado;
        }

        public function seleccionar_tipodocumento($indDefault = '')
        {
        	$array_dist = $this->tipodocumento_model->listar_tipo_documento();
        	$arreglo = array();
        	if (count($array_dist) > 0) {
        		foreach ($array_dist as $indice => $valor) {
        			$indice1 = $valor->TIPDOCP_Codigo;
        			$valor1 = $valor->TIPOCC_Inciales;
        			$arreglo[$indice1] = $valor1;
        		}
        	}
        	$resultado = $this->html->optionHTML($arreglo, $indDefault, array('0', '::Seleccione::'));
        	return $resultado;
        }

        public function JSON_listar_sucursalesEmpresa($proveedor = '')
        {
        	$listado_sucursalesEmpresa = array();
        	if ($proveedor != '') {
        		$datos_proveedor = $this->proveedor_model->obtener($proveedor);
        		$empresa = $datos_proveedor->empresa;
        		if ($empresa != '0' && $empresa != '') {
        			$listado_sucursalesEmpresa = $this->empresa_model->listar_sucursalesEmpresa($empresa);
        			foreach ($listado_sucursalesEmpresa as $key => $reg) {
        				$reg->distrito = "";
        				$reg->provincia = "";
        				$reg->departamento = "";
        				if ($reg->UBIGP_Codigo != '' && $reg->UBIGP_Codigo != '000000') {
        					$datos_ubigeo_dist = $this->ubigeo_model->obtener_ubigeo_dist($reg->UBIGP_Codigo);
        					$datos_ubigeo_prov = $this->ubigeo_model->obtener_ubigeo_prov($reg->UBIGP_Codigo);
        					$datos_ubigeo_dep = $this->ubigeo_model->obtener_ubigeo_dpto($reg->UBIGP_Codigo);
        					if (count($datos_ubigeo_dist) > 0)
        						$reg->distrito = $datos_ubigeo_dist[0]->UBIGC_Descripcion;
        					if (count($datos_ubigeo_prov) > 0)
        						$reg->provincia = $datos_ubigeo_prov[0]->UBIGC_Descripcion;
        					if (count($datos_ubigeo_dep) > 0)
        						$reg->departamento = $datos_ubigeo_dep[0]->UBIGC_Descripcion;
        				}
        				$listado_sucursalesEmpresa[$key] = $reg;
        			}
        		} else {
        			$filter = new stdClass();
        			$filter->EESTAC_Direccion = $datos_proveedor->direccion;
        			$filter->UBIGP_Codigo = $datos_proveedor->ubigeo;
        			$filter->departamento = $datos_proveedor->departamento;
        			$filter->provincia = $datos_proveedor->provincia;
        			$filter->distrito = $datos_proveedor->distrito;
        			$listado_sucursalesEmpresa = array($filter);
        		}
        	}

        	$result[] = array('Tipo' => '1', 'Titulo' => 'LOS ESTABLECIMIENTOS DE MI PROVEEDOR');
        	foreach ($listado_sucursalesEmpresa as $reg)
        		$result[] = array('Tipo' => '2', 'EESTAC_Direccion' => $reg->EESTAC_Direccion, 'UBIGP_Codigo' => $reg->UBIGP_Codigo, 'departamento' => $reg->departamento, 'provincia' => $reg->provincia, 'distrito' => $reg->distrito);

        	echo json_encode($result);
        }

        public function autocomplete(){
        	$keyword = $this->input->post('term');
        	$compania = $this->compania;
        	$consulta = $this->proveedor_model->buscarProveedor($keyword, $compania);
        	$result = array();
        	$contactos = array();

        	if($consulta != NULL){
        		foreach ($consulta as $key => $value) {
        			$tipoPersona = $value->CLIC_TipoPersona;
        			if ( $tipoPersona== '0') {
        				$nombre = $value->PERSC_Nombre . ' ' .$value->PERSC_ApellidoPaterno;
        				$ruc = $value->PERSC_Ruc;
        				$ruc = ($ruc == NULL || $ruc == 0) ? $value->PERSC_NumeroDocIdentidad : $ruc;
        				$codigoEmpresa = $value->PERSP_Codigo;
        				$direccion="";
        			} else {
        				$nombre =$value->EMPRC_RazonSocial;
        				$ruc = $value->EMPRC_Ruc;
        				$codigoEmpresa = $value->EMPRP_Codigo;
        				$contactos = $this->empresa_model->listar_contactosEmpresa($codigoEmpresa);
        				$direccion = $value->EMPRC_Direccion;
        			}
        			$result[] = array("value" => $nombre, "label" => "$ruc - $nombre", "nombre" => $nombre, "codigo" => $value->PROVP_Codigo, "ruc" => $ruc, "tipoPersona" => $tipoPersona, "codigoEmpresa" => $codigoEmpresa, "contactos" =>  $contactos, "direccion" => $direccion);
        		}
        	}
        	echo json_encode($result);
        }

        public function autocomplete_ruc(){
        	$keyword = $this->input->post('term');
        	$compania = $this->compania;
        	$consulta = $this->proveedor_model->buscarProveedorRuc($keyword, $compania);
        	$result = array();
        	$contactos = array();

        	if ($consulta != NULL) {
        		foreach ($consulta AS $cliente => $value) {
        			$tipoPersona = $value->PROVC_TipoPersona;
        			if ($tipoPersona== '0') {
        				$nombre = $value->PERSC_Nombre;
        				$ruc = $value->PERSC_NumeroDocIdentidad;
        				$codigoEmpresa = $value->PERSP_Codigo;
        			}
        			else {
        				$nombre = $value->EMPRC_RazonSocial;
        				$ruc = $value->EMPRC_Ruc;
        				$codigoEmpresa = $value->EMPRP_Codigo;
        				$contactos = $this->empresa_model->listar_contactosEmpresa($codigoEmpresa);
        			}
        			$result[] = array("value" => $ruc, "label" => "$ruc - $nombre", "nombre" => $nombre, "codigo" => $value->PROVP_Codigo, "ruc" => $ruc, "tipoPersona" => $tipoPersona, "codigoEmpresa" => $codigoEmpresa, "contactos" =>  $contactos);
        		}
        	}
        	echo json_encode($result);
        }

        function JSON_buscar_proveedor($numdoc){
        	$datos_empresa = $this->empresa_model->obtener_datosEmpresa2($numdoc);
        	$datos_persona = $this->persona_model->obtener_datosPersona2($numdoc);
        	$resultado = '[{"PROVP_Codigo":"0","EMPRC_Ruc":"","EMPRC_RazonSocial":""}]';
        	if (count($datos_empresa) > 0) {
        		$empresa = $datos_empresa[0]->EMPRP_Codigo;
        		$razon_social = $datos_empresa[0]->EMPRC_RazonSocial;
        		$datosCliente = $this->proveedor_model->obtener_datosCliente2($empresa);
        		if (count($datosCliente) > 0) {
        			$cliente = $datosCliente[0]->PROVP_Codigo;
        			$resultado = '[{"PROVP_Codigo":"' . $cliente . '","EMPRC_Ruc":"' . $numdoc . '","EMPRC_RazonSocial":"' . $razon_social . '"}]';
        		}
        	} elseif (count($datos_persona) > 0) {
        		$persona = $datos_persona[0]->PERSP_Codigo;
        		$nombres = $datos_persona[0]->PERSC_Nombre . " " . $datos_persona[0]->PERSC_ApellidoPaterno . " " . $datos_persona[0]->PERSC_ApellidoMaterno;
        		$datosCliente = $this->proveedor_model->obtener_datosCliente3($persona);
        		if (count($datosCliente) > 0) {
        			$cliente = $datosCliente[0]->PROVP_Codigo;
        			$resultado = '[{"PROVP_Codigo":"' . $cliente . '","EMPRC_Ruc":"' . $numdoc . '","EMPRC_RazonSocial":"' . $nombres . '"}]';
        		}
        	}
        	echo $resultado;
        }

        public function registro_proveedor_pdf($telefono, $docum, $nombre)
        {

        	$this->load->library('cezpdf');
        	$this->load->helper('pdf_helper');
        //prep_pdf();
        	$this->cezpdf = new Cezpdf('a4');
        	$datacreator = array(
        		'Title' => 'Estadillo de ',
        		'Name' => 'Estadillo de ',
        		'Author' => 'Vicente Producciones',
        		'Subject' => 'PDF con Tablas',
        		'Creator' => 'info@vicenteproducciones.com',
        		'Producer' => 'http://www.vicenteproducciones.com'
        	);

        	$this->cezpdf->addInfo($datacreator);
        	$this->cezpdf->selectFont(APPPATH . 'libraries/fonts/Helvetica.afm');
        	$delta = 20;

        	$this->cezpdf->ezText('<b>RELACION DE PROVEEDORES</b>', 14, array("leading" => 0, 'left' => 185));
        	$this->cezpdf->ezText('', '', array("leading" => 10));

        	$db_data = array();

        	$listado_proveedor = $this->proveedor_model->listar_proveedor_pdf($telefono, $docum, $nombre);

        	if (count($listado_proveedor) > 0) {
        		foreach ($listado_proveedor as $indice => $valor) {
        			$ruc = $valor->ruc;
        			$dni = $valor->dni;
        			$razon_social = $valor->nombre;
        			$direccion=$valor->direccion;
        			$tipo_cliente = $valor->PROVC_TipoPersona == 1 ? "P.JURIDICA" : "P.NATURAL";

        			$db_data[] = array(
        				'cols1' => $indice + 1,
        				'cols2' => $ruc,
        				'cols3' => $dni,
        				'cols4' => $razon_social,
        				'cols5' => $tipo_cliente,
        				'cols6' => $direccion
        			);
        		}
        	}

        	$col_names = array(
        		'cols1' => '<b>ITEM</b>',
        		'cols2' => '<b>RUC</b>',
        		'cols3' => '<b>DNI</b>',
        		'cols4' => '<b>NOMBRE O RAZÓN SOCIAL</b>',
        		'cols5' => '<b>T. P.</b>',
        		'cols6' => '<b>DIRECCION</b>'
        	);

        	$this->cezpdf->ezTable($db_data, $col_names, '', array(
        		'width' => 525,
        		'showLines' => 1,
        		'shaded' => 1,
        		'showHeadings' => 1,
        		'xPos' => 'center',
        		'fontSize' => 8,
        		'cols' => array(
        			'cols1' => array('width' => 30, 'justification' => 'center'),
        			'cols2' => array('width' => 70, 'justification' => 'center'),
        			'cols3' => array('width' => 50, 'justification' => 'center'),
        			'cols4' => array('width' => 150, 'justification' => 'center'),
        			'cols5' => array('width' => 70, 'justification' => 'center'),
        			'cols6' => array('width' => 100, 'justification' => 'center')
        		)
        	));


        	$cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => $codificacion . '.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        	ob_end_clean();

        	$this->cezpdf->ezStream($cabecera);
        }
      }

      ?>