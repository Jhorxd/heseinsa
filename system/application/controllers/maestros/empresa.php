<?php
class Empresa extends Controller{

    private $empresa;
    private $compania;
    private $url;
    
    public function __construct(){
        parent::__construct();
        $this->load->model('maestros/empresa_model'); 
        $this->load->model('maestros/compania_model');
        $this->load->model('almacen/almacen_model');
        $this->load->model('maestros/persona_model'); 
        $this->load->model('maestros/tipoestablecimiento_model');
        $this->load->model('maestros/emprestablecimiento_model');
        $this->load->model('maestros/ubigeo_model');
        $this->load->model('maestros/directivo_model');
        $this->load->model('maestros/cargo_model');
        $this->load->model('maestros/area_model');
        $this->load->model('maestros/estadocivil_model');
        $this->load->model('maestros/nacionalidad_model');
        $this->load->model('maestros/tipocodigo_model');
        $this->load->model('maestros/tipodocumento_model');
        $this->load->model('maestros/sectorcomercial_model');
        $this->load->model('maestros/formapago_model');
        $this->load->model('compras/proveedor_model');
        $this->load->model('tesoreria/tipocaja_model');
        $this->load->model('maestros/cuentaempresa_model');
        $this->load->model('tesoreria/banco_model');
        $this->load->model('maestros/moneda_model');
      
        $this->load->library('html');
        $this->load->library('pagination'); 
        $this->load->library('layout','layout');

        $this->empresa = $this->session->userdata("empresa");
        $this->compania = $this->session->userdata("compania");
        $this->url = base_url();
    }

    ##########################
    ##### MODULO EMPRESAS
    ##########################
    ## DEV: LG -> Begin
    public function empresas(){
        $data["departamentos"]  = $this->ubigeo_model->listar_departamentos();
        $data["provincias"]     = $this->ubigeo_model->getProvincias("15");
        $data["distritos"]      = $this->ubigeo_model->getDistritos("15","01");
        $data["bancos"]         = $this->banco_model->listar_banco();
        $data["monedas"]        = $this->moneda_model->listar();
        $data['base_url']       = $this->url;
        $this->layout->view('maestros/empresa_index',$data);
    }
    ## DEV: LG -> End

    ## DEV: LG -> Begin
    public function datatable_empresas(){
        $posDT = -1;
        $columnas = array(
            ++$posDT => "CLIC_CodigoUsuario",
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

        $filter->codigo = $this->input->post('codigo');
        $filter->documento = $this->input->post('documento');
        $filter->nombre = $this->input->post('nombre');

        $empresasInfo = $this->empresa_model->listar_empresas(true);
        $lista = array();

        if ($empresasInfo != NULL) {
            foreach ($empresasInfo as $indice => $valor) {
                $btn_editar = "<button type='button' onclick='editar_empresa($valor->EMPRP_Codigo)' class='btn2 btn-default'>
                <img src='".$this->url."/images/modificar.png' class='image-size-1l'>
                </button>";

                $btn_sucursales = "<button type='button' onclick='sucursales($valor->EMPRP_Codigo, \"$valor->EMPRC_Ruc - $valor->EMPRC_RazonSocial\")' class='btn2 btn-default' title='Sucursales'><img src='".$this->url."/images/sucursal.png' class='image-size-1l'></button>";

                $btn_bancos = "<button type='button' onclick='modal_CtasBancarias(\"$valor->EMPRP_Codigo\", \"$valor->PERSP_Codigo\", \"$valor->numero - $valor->razon_social\")' class='btn2 btn-default' title='Bancos'><img src='".$this->url."/images/banco.png' class='image-size-1l'></button>";

                $posDT = -1;
                $lista[] = array(
                      
                    ++$posDT => $valor->EMPRC_Ruc,
                    ++$posDT => $valor->EMPRC_RazonSocial,
                    ++$posDT => $valor->EMPRC_Direccion,
                    ++$posDT => $btn_sucursales,
                    ++$posDT => $btn_bancos,
                    ++$posDT => $btn_editar
           
                );
            }
        }

        unset($filter->start);
        unset($filter->length);

        $json = array(
            "draw"            => intval( $this->input->post('draw') ),
            "recordsTotal"    => count($this->empresa_model->listar_empresas(true)),
            "recordsFiltered" => intval( count($this->empresa_model->listar_empresas(true)) ),
            "data"            => $lista
        );

        echo json_encode($json);
    }
    ## DEV: LG -> End

    public function sucursales(){

        $columnas = array(
            0 => "EESTABC_Descripcion",
            1 => "TESTC_Descripcion",
            2 => "EESTAC_Direccion",
            3 => "ubigeo_descripcion"
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

        $filter->empresa        = $this->input->post('empresa');
        $establecimientoInfo    = $this->emprestablecimiento_model->getEstablecimientos($filter);
        
        $lista = array();
        if ( $establecimientoInfo != NULL) {
            foreach ($establecimientoInfo as $indice => $valor) {
                $btn_editar = "<button type='button' onclick='editar_sucursal($valor->EESTABP_Codigo)' class='btn btn-default'><img src='".$this->url."/images/modificar.png' class='image-size-1b'></button>";

                $btn_deshabilitar = ($valor->EESTABC_FlagTipo == 1) ? "" : "<button type='button' onclick='deshabilitar_sucursal($valor->EESTABP_Codigo)' class='btn btn-default'><img src='".$this->url."/images/documento-delete.png' class='image-size-1b'></button>";

                $lista[] = array(
                    0 => $valor->EESTABC_Descripcion,
                    1 => $valor->TESTC_Descripcion,
                    2 => $valor->EESTAC_Direccion,
                    3 => $valor->ubigeo_descripcion,
                    4 => $btn_editar,
                    5 => $btn_deshabilitar
                );
            }
        }

        unset($filter->start);
        unset($filter->length);

        $json = array(
                            "draw"            => intval( $this->input->post('draw') ),
                            "recordsTotal"    => count($this->emprestablecimiento_model->getEstablecimientos()),
                            "recordsFiltered" => intval( count($this->emprestablecimiento_model->getEstablecimientos($filter)) ),
                            "data"            => $lista
                    );

        echo json_encode($json);
    }

    public function guardar_registro()
    {
        ## EMPRESA
        $empresaInfo = new stdClass();
        
        $empresaInfo->EMPRC_Ruc             = $numero_documento;
        $empresaInfo->EMPRC_RazonSocial     = $razon_social;
        $empresaInfo->EMPRC_Telefono        = $telefono;
        $empresaInfo->EMPRC_Movil           = $movil;
        $empresaInfo->EMPRC_Web             = $web;
        $empresaInfo->EMPRC_Email           = $correo;
        $empresaInfo->EMPRC_Direccion       = $direccion;
     
        if ($this->empresa_model->actualizar_empresa($empresa, $empresaInfo)) {
            $data=array("result"=>"success");
            echo json_encode($data); 
        }else{
            $data=array("result"=>"error");
            echo json_encode($data); 
        }
    }

    ##########################
    ##### FUNCTIONS NEWS
    ##########################

        ### SUCURSALES
            public function datatable_sucursales(){

                $columnas = array(
                                    0 => "EESTABC_Descripcion",
                                    1 => "TESTC_Descripcion",
                                    2 => "EESTAC_Direccion",
                                    3 => "ubigeo_descripcion"
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

                $filter->empresa = $this->input->post('empresa');

                $establecimientoInfo = $this->emprestablecimiento_model->getEstablecimientos($filter);
                
                $lista = array();
                if ( $establecimientoInfo != NULL) {
                    foreach ($establecimientoInfo as $indice => $valor) {
                        $btn_editar = ($valor->EESTABC_FlagTipo == 1) ? "" : "<button type='button' onclick='editar_sucursal($valor->EESTABP_Codigo)' class='btn btn-default'><img src='".$this->url."/images/modificar.png' class='image-size-1b'></button>";

                        $btn_deshabilitar = ($valor->EESTABC_FlagTipo == 1) ? "" : "<button type='button' onclick='deshabilitar_sucursal($valor->EESTABP_Codigo)' class='btn btn-default'><img src='".$this->url."/images/documento-delete.png' class='image-size-1b'></button>";

                        $lista[] = array(
                                            0 => $valor->EESTABC_Descripcion,
                                            1 => $valor->TESTC_Descripcion,
                                            2 => $valor->EESTAC_Direccion,
                                            3 => $valor->ubigeo_descripcion,
                                            4 => $btn_editar,
                                            5 => $btn_deshabilitar
                                        );
                    }
                }

                unset($filter->start);
                unset($filter->length);

                $json = array(
                                    "draw"            => intval( $this->input->post('draw') ),
                                    "recordsTotal"    => count($this->emprestablecimiento_model->getEstablecimientos()),
                                    "recordsFiltered" => intval( count($this->emprestablecimiento_model->getEstablecimientos($filter)) ),
                                    "data"            => $lista
                            );

                echo json_encode($json);
            }

            public function getEstablecimiento(){

                $sucursal = $this->input->post("sucursal");

                $sucursalInfo = $this->emprestablecimiento_model->getEstablecimiento($sucursal);
                $lista = array();
                
                if ( $sucursalInfo != NULL ){
                    foreach ($sucursalInfo as $i => $val) {
                        $lista = array(
                                            "sucursal" => $val->EESTABP_Codigo,
                                            "nombre" => $val->EESTABC_Descripcion,
                                            "tipo" => $val->TESTP_Codigo,
                                            "direccion" => $val->EESTAC_Direccion,
                                            "departamento" => substr($val->UBIGP_Codigo, 0, 2),
                                            "provincia" => substr($val->UBIGP_Codigo, 2, 2),
                                            "distrito" => substr($val->UBIGP_Codigo, 4, 2),
                                        );
                    }

                    $json = array("match" => true, "info" => $lista);
                }
                else
                    $json = array("match" => false, "info" => "");

                echo json_encode($json);
            }

            public function guardar_sucursal(){

                $sucursal = $this->input->post("sucursal");
                $sucursal_empresa = $this->input->post("sucursal_empresa");
                $nombre = $this->input->post("establecimiento_nombre");
                $tipo = $this->input->post("establecimiento_tipo");
                $direccion = $this->input->post("establecimiento_direccion");
                $departamento = strtoupper( $this->input->post("establecimiento_departamento") );
                $provincia = strtoupper( $this->input->post("establecimiento_provincia") );
                $distrito = strtoupper( $this->input->post("establecimiento_distrito") );

                #####################
                ###### SUCURSAL
                #####################

                    $sucursalInfo = new stdClass();
                    $sucursalInfo->TESTP_Codigo = $tipo;
                    $sucursalInfo->UBIGP_Codigo = $departamento.$provincia.$distrito;
                    $sucursalInfo->EESTABC_Descripcion = strtoupper($nombre);
                    $sucursalInfo->EESTAC_Direccion = strtoupper($direccion);
                    $sucursalInfo->EESTABC_FlagTipo = "0";
                    $sucursalInfo->EESTABC_FlagEstado = "1";

                if ($sucursal != ""){
                    $sucursalInfo->EESTABC_FechaModificacion = date("Y-m-d H:i:s");
                    $sucursal = $this->emprestablecimiento_model->actualizar_establecimiento($sucursal, $sucursalInfo);    
                }
                else{
                    if ($sucursal_empresa != ""){
                        $sucursalInfo->EMPRP_Codigo = $sucursal_empresa;

                        $sucursalInfo->EESTABC_FechaRegistro = date("Y-m-d H:i:s");
                        $sucursal = $this->emprestablecimiento_model->insertar_establecimiento($sucursalInfo);
                    }
                    else
                        $sucursal = false;
                    
                }

                if ($sucursal)
                    $json = array("result" => "success");
                else
                    $json = array("result" => "error");
                
                echo json_encode($json);
            }

            public function deshabilitar_sucursal(){

                $sucursal = $this->input->post("sucursal");

                $sucursalInfo = new stdClass();
                $sucursalInfo->EESTABC_FlagEstado = "0";
                $sucursalInfo->EESTABC_FechaModificacion = date("Y-m-d H:i:s");

                if ($sucursal != "")
                    $sucursal = $this->emprestablecimiento_model->actualizar_establecimiento($sucursal, $sucursalInfo);

                if ($sucursal)
                    $json = array("result" => "success");
                else
                    $json = array("result" => "error");
                
                echo json_encode($json);
            }

        ### CONTACTO
            public function datatable_contactos(){

                $columnas = array(
                                    0 => "ECONC_Descripcion",
                                    1 => "ECONC_Area",
                                    2 => "ECONC_Cargo",
                                    3 => "ECONC_Telefono",
                                    4 => "ECONC_Movil",
                                    5 => "ECONC_Fax",
                                    6 => "ECONC_Email"
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

                $filter->empresa = $this->input->post('empresa');
                $filter->persona = $this->input->post('persona');

                $contactoInfo = $this->empresa_model->getContactos($filter);
                
                $lista = array();
                if ( $contactoInfo != NULL) {
                    foreach ($contactoInfo as $indice => $valor) {
                        $btn_editar = "<button type='button' onclick='editar_contacto($valor->ECONP_Contacto)' class='btn btn-default'>
                                        <img src='".$this->url."/images/modificar.png' class='image-size-1b'>
                                    </button>";

                        $btn_deshabilitar = "<button type='button' onclick='deshabilitar_contacto($valor->ECONP_Contacto)' class='btn btn-default'>
                                        <img src='".$this->url."/images/documento-delete.png' class='image-size-1b'>
                                    </button>";

                        $lista[] = array(
                                            0 => $valor->ECONC_Descripcion,
                                            1 => $valor->ECONC_Area,
                                            2 => $valor->ECONC_Cargo,
                                            3 => $valor->ECONC_Telefono,
                                            4 => $valor->ECONC_Movil,
                                            5 => $valor->ECONC_Fax,
                                            6 => $valor->ECONC_Email,
                                            7 => $btn_editar,
                                            8 => $btn_deshabilitar
                                        );
                    }
                }

                unset($filter->start);
                unset($filter->length);

                $json = array(
                                    "draw"            => intval( $this->input->post('draw') ),
                                    "recordsTotal"    => count($this->empresa_model->getContactos()),
                                    "recordsFiltered" => intval( count($this->empresa_model->getContactos($filter)) ),
                                    "data"            => $lista
                            );

                echo json_encode($json);
            }

            public function getContacto(){
                $contacto = $this->input->post("contacto");
                $contactoInfo = $this->empresa_model->getContacto($contacto);

                if ($contactoInfo != NULL){
                    foreach ($contactoInfo as $key => $val)
                        $info = array(
                                        "contacto" => $val->ECONP_Contacto,
                                        "empresa" => $val->EMPRP_Codigo,
                                        "persona" => $val->PERSP_Contacto,
                                        "nombre" => $val->ECONC_Descripcion,
                                        "area" => $val->ECONC_Area,
                                        "cargo" => $val->ECONC_Cargo,
                                        "telefono" => $val->ECONC_Telefono,
                                        "movil" => $val->ECONC_Movil,
                                        "fax" => $val->ECONC_Fax,
                                        "correo" => $val->ECONC_Email
                                    );


                    $json = array("match" => true, "info" => $info);
                }
                else
                    $json = array("match" => true, "info" => NULL);

                echo json_encode($json);
            }

            public function guardar_contacto(){

                $contacto = $this->input->post("contacto");
                $empresa = $this->input->post("contacto_empresa");
                $persona = $this->input->post("contacto_persona");
                $nombre = strtoupper( $this->input->post("contacto_nombre") );
                $area = strtoupper( $this->input->post("contacto_area") );
                $cargo = strtoupper( $this->input->post("contacto_cargo") );
                $telefono = $this->input->post("contacto_telefono");
                $movil = $this->input->post("contacto_movil");
                $fax = $this->input->post("contacto_fax");
                $correo = $this->input->post("contacto_correo");

                #######################
                ###### CONTACTO
                #######################

                    $filter = new stdClass();
                    $filter->EMPRP_Codigo = ($empresa == "") ? 0 : $empresa;
                    $filter->PERSP_Contacto = ($persona == "") ? 0 : $persona;

                    $filter->ECONC_Descripcion = $nombre;
                    $filter->ECONC_Area = $area;
                    $filter->ECONC_Cargo = $cargo;
                    $filter->ECONC_Telefono = $telefono;
                    $filter->ECONC_Movil = $movil;
                    $filter->ECONC_Fax = $fax;
                    $filter->ECONC_Email = $correo;
                    $filter->ECONC_TipoContacto = "0"; # 0 : PERSONA | 1 : EMPRESA
                    $filter->ECONC_FlagEstado = "1";

                if ($contacto != ""){
                    $filter->ECONC_FechaModificacion = date("Y-m-d H:i:s");
                    $cta = $this->empresa_model->actualizar_contacto($contacto, $filter);    
                }
                else{
                    if ($empresa != "" || $persona != ""){
                        $filter->ECONC_FechaRegistro = date("Y-m-d H:i:s");
                        $contacto = $this->empresa_model->insertar_contacto($filter);
                    }
                    else
                        $contacto = false;
                    
                }

                if ($contacto)
                    $json = array("result" => "success");
                else
                    $json = array("result" => "error");
                
                echo json_encode($json);
            }

            public function deshabilitar_contacto(){

                $contacto = $this->input->post("contacto");

                $filter = new stdClass();
                $filter->ECONC_FlagEstado = "0";
                $filter->ECONC_FechaModificacion = date("Y-m-d H:i:s");

                if ($contacto != "")
                    $contacto = $this->empresa_model->actualizar_contacto($contacto, $filter);

                if ($contacto)
                    $json = array("result" => "success");
                else
                    $json = array("result" => "error");
                
                echo json_encode($json);
            }































            
    ##########################
    ##### FUNCTIONS OLDS
    ##########################

    public function index(){
        $this->layout->view('seguridad/inicio');    
    }

    public function empresas_($j=0){
        $data['numdoc'] = "";
        $data['nombre'] = "";
        $data['telefono'] = "";
        $data['titulo_tabla'] = "RELACIÓN DE EMPRESAS";
        $data['action'] = base_url()."index.php/maestros/empresa/buscar_empresas";
        $conf['base_url'] = site_url('maestros/empresa/empresas/');
        $data['registros'] = count($this->empresa_model->listar_empresas(true));
      
        $conf['total_rows'] = $data['registros'];
        $conf['per_page'] = 20;
        $conf['num_links']  = 3;
        $conf['next_link'] = "&gt;";
        $conf['prev_link'] = "&lt;";
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link']  = "&gt;&gt;";
        $conf['uri_segment'] = 4;//aba
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();

        $listado_emepresas = $this->empresa_model->listar_empresas(true, $conf['per_page'],$j);
        $item  = $j+1;
        $lista = array();
                    if(count($listado_emepresas)>0){
                            foreach($listado_emepresas as $indice=>$valor){
                                    $codigo         = $valor->EMPRP_Codigo;
                                    $ruc            = $valor->EMPRC_Ruc;
                                    $razon_social   = $valor->EMPRC_RazonSocial;
                                    $direccion      = $valor->EMPRC_Direccion;
                                    $telefono       = $valor->EMPRC_Telefono;
                                    $movil          = $valor->EMPRC_Movil;
                                    $editar         = "<a href='javascript:;' onclick='editar_empresa(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                                    $ver            = "<a href='javascript:;' onclick='ver_empresa(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                                    $eliminar       = ""; #"<a href='javascript:;' onclick='eliminar_empresa(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                                    $lista[]        = array($item,$ruc,$razon_social,$direccion, $telefono,
                                       // $movil,
                                        $editar,$ver,$eliminar);
                                    $item++;
                            }
                    }
        $data['lista'] = $lista;
        $this->layout->view("maestros/empresa_index",$data);
    }

    public function nuevo_empresa(){
        $data['cbo_dpto'] = $this->seleccionar_departamento("15");
        $data['cbo_prov'] = $this->seleccionar_provincia("15", "01");
        $data['cbo_dist'] = $this->seleccionar_distritos("15", "01", "01");
        $data['cbo_estadoCivil']  = $this->OPTION_generador($this->estadocivil_model->listar_estadoCivil(), 'ESTCP_Codigo', 'ESTCC_Descripcion');
        $data['cbo_nacionalidad'] = $this->OPTION_generador($this->nacionalidad_model->listar_nacionalidad(), 'NACP_Codigo', 'NACC_Descripcion', '193');
        $data['cbo_nacimiento']   = $this->OPTION_generador($this->ubigeo_model->listar_distritos('15', '01'), 'UBIGC_CodDist', 'UBIGC_Descripcion','01', array('00','::Seleccione::'));
        $data['tipocodigo']       = $this->OPTION_generador($this->tipocodigo_model->listar_tipo_codigo(), 'TIPCOD_Codigo', 'TIPCOD_Inciales', '1');
        $data['cbo_sectorComercial'] = $this->OPTION_generador($this->sectorcomercial_model->listar(), 'SECCOMP_Codigo', 'SECCOMC_Descripcion', '');
        $data['cboFormaPago']     = $this->OPTION_generador($this->formapago_model->listar(), 'FORPAP_Codigo', 'FORPAC_Descripcion', ''); //12: Al contado
        $data['modo']             = "insertar";

        $objeto = new stdClass();
        $objeto->id       = "";
        $objeto->tipo     = "";
        $objeto->ruc      = "";
        $objeto->nombre   = "";
        $objeto->telefono = "";
        $objeto->movil    = "";
        $objeto->fax      = "";
        $objeto->web      = "";
        $objeto->email    = "";
        $objeto->direccion="";
        $objeto->ctactesoles="";
        $objeto->TIP_Codigo="";
        $objeto->ctactedolares="";
        $data['datos'] = $objeto;
        $data["listBanco"]=array();
        $data['titulo'] = "REGISTRAR EMPRESA";
        $data['listado_empresaSucursal']  = array();
        $data['listado_empresaContactos'] = array();
        $data['cboNacimiento'] = "000000";
        $data['cboNacimientovalue'] = "";
        //$data["TIP_Codigo"]="";
        $this->load->view("maestros/empresa_nuevo",$data);
    }
    public function insertar_empresa()
    {
        $nombre_sucursal = array();
        $nombre_contacto = array();
        $empresa_persona = $this->input->post('empresa_persona');
        $tipocodigo      = $this->input->post('cboTipoCodigo');
        $ruc             = $this->input->post('ruc');
        $razon_social    = $this->input->post('razon_social');  
        $sector_comercial= $this->input->post('sector_comercial');  
        $telefono        = $this->input->post('telefono');
        $movil           = $this->input->post('movil');
        $fax             = $this->input->post('fax');
        $email           = $this->input->post('email');
        $web             = $this->input->post('web');
        $direccion       = $this->input->post('direccion');
        $departamento    = $this->input->post('cboDepartamento');
        $provincia       = $this->input->post('cboProvincia');
        $distrito        = $this->input->post('cboDistrito');   
        $ctactesoles     = $this->input->post('ctactesoles');
        $ctactedolares   = $this->input->post('ctactedolares');
        $ubigeo_domicilio= $departamento.$provincia.$distrito;
        
        /*Array de variables*/
        $nombre_sucursal      = $this->input->post('nombreSucursal');
        $direccion_sucursal   = $this->input->post('direccionSucursal');
        $tipo_establecimiento = $this->input->post('tipoEstablecimiento');      
        $arrayDpto            = $this->input->post('dptoSucursal');
        $arrayProv            = $this->input->post('provSucursal');
        $arrayDist            = $this->input->post('distSucursal');
        $persona_contacto     = $this->input->post('contactoPersona');
        $nombre_contacto      = $this->input->post('contactoNombre');
        $area_contacto        = $this->input->post('contactoArea');
        $cargo_contacto       = $this->input->post('cargo_encargado');
        $telefono_contacto    = $this->input->post('contactoTelefono');
        $email_contacto       = $this->input->post('contactoEmail');
        if($arrayDpto!='' && $arrayProv!='' && $arrayDist!=''){
                $ubigeo_sucursal  = $this->html->array_ubigeo($arrayDpto,$arrayProv,$arrayDist);
        }
        
        $empresa = $this->empresa_model->insertar_datosEmpresa($tipocodigo, $ruc,$razon_social,$telefono,$fax,$web,$movil,$email, $sector_comercial, $ctactesoles, $ctactedolares);

        $this->empresa_model->insertar_sucursalEmpresaPrincipal('1',$empresa,$ubigeo_domicilio,'PRINCIPAL',$direccion);//Direccion Principal
        //Insertar Establecimientos
        if($nombre_sucursal!=''){
            foreach($nombre_sucursal as $indice=>$valor){
                if($nombre_sucursal[$indice]!='' && $direccion_sucursal!='' && $tipo_establecimiento[$indice]!=''){
                    $ubigeo_s = strlen($ubigeo_sucursal[$indice])<6?"000000":$ubigeo_sucursal[$indice];
                    $this->empresa_model->insertar_sucursalEmpresa($tipo_establecimiento[$indice],$empresa,$ubigeo_s,$nombre_sucursal[$indice],$direccion_sucursal[$indice]);
                }
            }
        } 
        //Insertar contactos empresa
        if($nombre_contacto!=''){
            foreach($nombre_contacto as $indice=>$valor){
                if($nombre_contacto[$indice]!=''){
                    $pers_contacto = $persona_contacto[$indice];
                    $nom_contacto  = $nombre_contacto[$indice];
                    $car_contacto  = $cargo_contacto[$indice];
                    $ar_contacto   = $area_contacto[$indice];
                    $arrTelConctacto = explode("/",$telefono_contacto[$indice]);
                    switch(count($arrTelConctacto)){
                        case 2:
                        $tel_contacto  = $arrTelConctacto[0];
                        $mov_contacto  = $arrTelConctacto[1];   
                        break;
                        case 1:
                        $tel_contacto  = $arrTelConctacto[0];
                        $mov_contacto  = "";    
                        break;
                        case 0:
                        $tel_contacto  = "";
                        $mov_contacto  = "";    
                        break;                          
                    }   
                    $e_contacto    = $email_contacto[$indice];
                    
                    if($pers_contacto==''){
                        $pers_contacto = $this->persona_model->insertar_datosPersona('000000','000000','1','193',$nom_contacto,'','','','1');
                    }//Inserto persona
                    
                    $directivo = $this->empresa_model->insertar_directivoEmpresa($empresa,$pers_contacto,$car_contacto);
                    $this->empresa_model->insertar_areaEmpresa($ar_contacto,$empresa,$directivo,'::OBSERVACION::');
                    $this->empresa_model->insertar_contactoEmpresa($empresa,'::OBSERVACION:',$tel_contacto,$mov_contacto,$e_contacto,$pers_contacto);           
                }
            }
        }

       
    }
    public function editar_empresa(){

        $empresa = $this->input->post("empresa");
        $empresaInfo = $this->empresa_model->obtener_datosEmpresa($empresa);

        if ($empresaInfo != NULL){
            foreach ($empresaInfo as $key => $val)
                $info = array(
                    "empresa"           => $val->EMPRP_Codigo,
                    "numero_documento"  => $val->EMPRC_Ruc,
                    "razon_social"      => $val->EMPRC_RazonSocial,
                    "direccion"         => $val->EMPRC_Direccion,
                    "departamento"      => substr($val->ubigeo, 0, 2),
                    "provincia"         => substr($val->ubigeo, 2, 2),
                    "distrito"          => substr($val->ubigeo, 4, 2),
                    "telefono"          => $val->EMPRC_Telefono,
                    "movil"             => $val->EMPRC_Movil,
                    "correo"            => $val->EMPRC_Email,
                    "web"               => $val->EMPRC_Web
                );

            $json = array("match" => true, "info" => $info);
        }
        else
            $json = array("match" => true, "info" => NULL);

        echo json_encode($json);
    }
    
    public function modificar_empresa()
    {

        $empresa           = $this->input->post('empresa_persona'); 

        $tipocodigo        = $this->input->post('cboTipoCodigo');
        $ruc               = $this->input->post('ruc'); 
        $razon_social      = $this->input->post('razon_social');
        $sector_comercial  = $this->input->post('sector_comercial');
        $telefono          = $this->input->post('telefono');    
        $movil             = $this->input->post('movil');   
        $fax               = $this->input->post('fax'); 
        $email             = $this->input->post('email');   
        $web               = $this->input->post('web');
        $ubigeo_nacimiento = $this->input->post('cboNacimiento');
        $ubigeo_domicilio  = $this->input->post('cboDepartamento').$this->input->post('cboProvincia').$this->input->post('cboDistrito');
        $direccion         = $this->input->post('direccion');   
        $ctactesoles       = $this->input->post('ctactesoles');
        $ctactedolares     = $this->input->post('ctactedolares');
       
        $this->empresa_model->modificar_datosEmpresa($empresa,$tipocodigo, $ruc,$razon_social,$telefono,$movil,$fax,$web,$email, $sector_comercial, $ctactesoles, $ctactedolares, $direccion);
        $this->empresa_model->modificar_sucursalEmpresaPrincipal($empresa,'1',$ubigeo_domicilio,'PRINCIPAL',$direccion);
    }
    
    public function eliminar_empresa(){
       $empresa = $this->input->post('empresa');    
        $this->empresa_model->eliminar_empresa_total($empresa);
    }

    public function ver_empresa($empresa)
    {
     
        $datos                = $this->empresa_model->obtener_datosEmpresa($empresa);
        $datos_sucurPrincipal = $this->empresa_model->obtener_establecimientosEmpresa_principal($empresa);
        $ubigeo_domicilio     = $datos_sucurPrincipal[0]->UBIGP_Codigo;
        $datos_ubigeoDom_dpto = $this->ubigeo_model->obtener_ubigeo_dpto($ubigeo_domicilio);
        $data['dpto']         = $datos_ubigeoDom_dpto[0]->UBIGC_Descripcion;
        $data['prov']         = $datos_ubigeoDom_dpto[0]->UBIGC_Descripcion;
        $data['dist']         = $datos_ubigeoDom_dpto[0]->UBIGC_Descripcion;
        $data['direccion']    = $datos_sucurPrincipal[0]->EESTAC_Direccion;
        $data['telefono']     = $datos[0]->EMPRC_Telefono;
        $data['movil']        = $datos[0]->EMPRC_Movil;
        $data['fax']          = $datos[0]->EMPRC_Fax;
        $data['email']        = $datos[0]->EMPRC_Email;
        $data['web']          = $datos[0]->EMPRC_Web;
        $data['datos']  = $datos;
        $data['titulo'] = "VER EMPRESA";
        $this->load->view('maestros/empresa_ver',$data);
    }
    public function buscar_empresas($j='0'){

        $filter = new stdClass();
        $filter->EMPRC_Ruc  = $this->input->post('txtNumDoc');;
        $filter->EMPRC_RazonSocial = $this->input->post('txtNombre');
        $filter->EMPRC_Telefono = $this->input->post('txtTelefono');

        $data['numdoc']    = $filter->EMPRC_Ruc;
        $data['nombre']    = $filter->EMPRC_RazonSocial;
        $data['telefono']  = $filter->EMPRC_Telefono;
        $data['titulo_tabla']    = "RESULTADO DE BÚSQUEDA DE EMPRESAS";

        $data['registros']  = count($this->empresa_model->buscar_empresas($filter));
        $data['action'] = base_url()."index.php/maestros/empresa/buscar_empresas";
        $conf['base_url'] = site_url('maestros/empresa/buscar_empresas/');
        $conf['total_rows'] = $data['registros'];
        $conf['per_page']   = 50;
        $conf['num_links']  = 3;
        $conf['next_link'] = "&gt;";
        $conf['prev_link'] = "&lt;";
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link']  = "&gt;&gt;";
        $conf['uri_segment'] = 4;
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $listado_emepresas = $this->empresa_model->buscar_empresas($filter, $conf['per_page'],$j);
        $item            = $j+1;
        $lista           = array();
                    if(count($listado_emepresas)>0){
                            foreach($listado_emepresas as $indice=>$valor){
                                    $codigo         = $valor->EMPRP_Codigo;
                                    $ruc            = $valor->EMPRC_Ruc;
                                    $razon_social   = $valor->EMPRC_RazonSocial;
                                    $direccion =$valor->EMPRC_Direccion;
                                    $telefono       = $valor->EMPRC_Telefono;
                                   // $movil          = $valor->EMPRC_Movil;
                                    $editar         = "<a href='#' onclick='editar_empresa(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                                    $ver            = "<a href='#' onclick='ver_empresa(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                                    $eliminar       = "<a href='#' onclick='eliminar_empresa(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                                    $lista[]        = array($item,$ruc,$razon_social,$direccion,$telefono,
                                        //$movil,
                                        $editar,$ver,$eliminar);
                                    $item++;
                            }
                    }
        $data['lista'] = $lista;
        $this->layout->view("maestros/empresa_index",$data);

    }
    public function insertar_contacto(){
        $empresa      = $this->input->post('empresa');
        $pers_contacto  = $this->input->post('persona_contacto');
        $nom_contacto   = $this->input->post('nombre_contacto');
        $car_contacto   = $this->input->post('cargo_contacto');
        $ar_contacto    = $this->input->post('area_contacto');
        $telef_contacto = $this->input->post('telefono_contacto');
        $e_contacto     = $this->input->post('email_contacto');
        if($nom_contacto!=''){
                $arrTelConctacto = explode("/",$telef_contacto);
                switch(count($arrTelConctacto)){
                        case 2:
                                $tel_contacto  = $arrTelConctacto[0];
                                $mov_contacto  = $arrTelConctacto[1];   
                                break;
                        case 1:
                                $tel_contacto  = $arrTelConctacto[0];
                                $mov_contacto  = "";    
                                break;
                        case 0:
                                $tel_contacto  = "";
                                $mov_contacto  = "";    
                                break;                          
                }   
                if($pers_contacto==''){$pers_contacto = $this->persona_model->insertar_datosPersona('000000','000000','1','193',$nom_contacto,'','','','1');}//Inserto persona
                $directivo = $this->empresa_model->insertar_directivoEmpresa($empresa,$pers_contacto,$car_contacto);
                $this->empresa_model->insertar_areaEmpresa($ar_contacto,$empresa,$directivo,'::OBSERVACION::');
                $this->empresa_model->insertar_contactoEmpresa($empresa,'::OBSERVACION:',$tel_contacto,$mov_contacto,$e_contacto,$pers_contacto);           
        }
        $tablaHTML = $this->TABLA_contactos('p',$empresa);
        echo $tablaHTML;
    }
    
    
    public function insertar_marca(){
        $empresa      = $this->input->post('empresa');
        $codigo  = $this->input->post('codigo');
        if($codigo!='' && $empresa !=''){
                $this->empresa_model->insertar_marcaEmpresa($empresa,$codigo);          
        }
        $tablaHTML = $this->TABLA_marcas('p',$empresa);
        echo $tablaHTML;
    }
    
    public function insertar_tipo(){
        $proveedor      = $this->input->post('proveedor');
        $codigo       = $this->input->post('codigo');
        if($codigo!='' && $proveedor !=''){
                $this->proveedor_model->insertar_tipoProveedor($proveedor,$codigo);         
        }
        $tablaHTML = $this->TABLA_tipos('p',$proveedor);
        echo $tablaHTML;
    }

    public function editar_contacto(){
        $empresa      = $this->input->post('empresa');
        $persona        = $this->input->post('persona');

        $tablaHTML = $this->TABLA_contactos('p',$empresa,$persona);
        echo $tablaHTML;
    }

    public function modificar_contacto(){
        $empresa        = $this->input->post('empresa');
        $pers_contacto  = $this->input->post('persona_contacto');
        $nom_contacto   = $this->input->post('nombre_contacto');
        $car_contacto   = $this->input->post('cargo_contacto');
        $ar_contacto    = $this->input->post('area_contacto');
        $telef_contacto = $this->input->post('telefono_contacto');
        $e_contacto     = $this->input->post('email_contacto'); 
        $datos_directivo= $this->directivo_model->buscar_directivo($empresa,$pers_contacto);
        $directivo      = $datos_directivo[0]->DIREP_Codigo;
        if($nom_contacto!=''){
                $arrTelConctacto = explode("/",$telef_contacto);
                switch(count($arrTelConctacto)){
                        case 3:
                                $tel_contacto  = $arrTelConctacto[0];
                                $mov_contacto  = $arrTelConctacto[1];
                                $fax_contacto  = $arrTelConctacto[2];               
                                break;
                        case 2:
                                $tel_contacto  = $arrTelConctacto[0];
                                $mov_contacto  = $arrTelConctacto[1];
                                $fax_contacto  = "";
                                break;
                        case 1:
                                $tel_contacto  = $arrTelConctacto[0];
                                $mov_contacto  = "";    
                                $fax_contacto  = "";
                                break;
                        case 0:
                                $tel_contacto  = "";
                                $mov_contacto  = "";
                                $fax_contacto  = "";                    
                                break;                          
                }   
                $this->empresa_model->modificar_directivoEmpresa($empresa,$pers_contacto,$car_contacto);
                $this->empresa_model->modificar_areaEmpresa($empresa,$directivo,$ar_contacto,'::OPBSERVACION::');
                $this->empresa_model->modificar_contactoEmpresa($empresa,'::NINGUNA:',$pers_contacto,$tel_contacto,$mov_contacto,$fax_contacto,$e_contacto);
                $this->persona_model->modificar_datosPersona_nombres($pers_contacto,$nom_contacto,'','');
        }
        $tablaHTML = $this->TABLA_contactos('p',$empresa);
        echo $tablaHTML;        

    }
    public function eliminar_contacto(){
        $empresa         = $this->input->post('empresa');
        $persona         = $this->input->post('persona');

        $datos_directivo = $this->directivo_model->buscar_directivo($empresa,$persona);
        $directivo       = $datos_directivo[0]->DIREP_Codigo;
        $this->empresa_model->eliminar_empresarContacto($empresa,$persona,$directivo);
        $tablaHTML = $this->TABLA_contactos('p',$empresa);
        echo $tablaHTML;            
    }
    public function insertar_sucursal(){
        $empresa              = $this->input->post('empresa');
        $nombre_sucursal      = $this->input->post('nombre_sucursal');
        $direccion_sucursal   = $this->input->post('direccion_sucursal');
        $tipo_establecimiento = $this->input->post('tipo_establecimiento');
        $ubigeo_sucursal      = $this->input->post('ubigeo_sucursal');
        if($direccion_sucursal!=''){
            $ubigeo_s = strlen($ubigeo_sucursal)<6?"000000":$ubigeo_sucursal;
            $this->empresa_model->insertar_sucursalEmpresa($tipo_establecimiento,$empresa,$ubigeo_s,$nombre_sucursal,$direccion_sucursal);
        }
        $tablaHTML = $this->TABLA_sucursales($empresa);
        echo $tablaHTML;
    }
    public function editar_sucursal(){
        $empresa      = $this->input->post('empresa');
        $sucursal     = $this->input->post('sucursal');
        $tablaHTML = $this->TABLA_sucursales($empresa,$sucursal);
        echo $tablaHTML;
    }
    public function modificar_sucursal(){
        $empresa              = $this->input->post('empresa');
        $nombre_sucursal      = $this->input->post('nombre_sucursal');
        $direccion_sucursal   = $this->input->post('direccion_sucursal');
        $tipo_establecimiento = $this->input->post('tipo_establecimiento');
        $ubigeo_sucursal      = $this->input->post('ubigeo_sucursal');
        $sucursal_empresa     = $this->input->post('sucursal_empresa');
        if($direccion_sucursal!=''){
            $ubigeo_s = strlen($ubigeo_sucursal)<6?"000000":$ubigeo_sucursal;
            $this->empresa_model->modificar_sucursalEmpresa($sucursal_empresa,$tipo_establecimiento,$ubigeo_s,$nombre_sucursal,$direccion_sucursal);
        }
        $tablaHTML = $this->TABLA_sucursales($empresa);
        echo $tablaHTML;
    }
    //------------------------
    public function eliminar_sucursal(){
        $empresa       = $this->input->post('empresa');
        $sucursal      = $this->input->post('sucursal');
         $cantalmacen=$this->almacen_model->buscar_x_establec($sucursal);
         $cantcompania=$this->compania_model->obtener_x_establecimiento($sucursal);
         
        
        
          if(count($cantalmacen)>0){
         $this->almacen_model->eliminar_x_establecimiento($sucursal);
         } 
         if(count($cantcompania)>0){
         $this->compania_model->eliminar_compania_x_esta($sucursal);
         }
         $this->empresa_model->eliminar_sucursalEmpresa($sucursal);

        
    
        $tablaHTML = $this->TABLA_sucursales($empresa);
       echo $tablaHTML;  }
    //----------------------------
   
    
    
    public function TABLA_tipos($tipo,$proveedor,$pinta=0){
        $datos_marcasProveedor = $this->empresa_model->obtener_tiposEmpresa($proveedor);

        $tabla='<table id="tablaTipo" width="98%" class="fuente8" width="98%" cellspacing=0 cellpadding="6" border="1">
                <tr align="center" bgcolor="#BBBB20" height="10px;">
                <td>Nro</td>
                <td>Nombre del tipo de proveedor</td>
                <td>Borrar</td>
                <td>Editar</td>
                </tr>';

        $item = 1;
        if(count($datos_marcasProveedor)>0){
                foreach($datos_marcasProveedor as $valor){
                        $tabla.='<tr bgcolor="#ffffff">';
                        $nombre_marca  = $valor->FAMI_Descripcion;
                        $codigo   = $valor->FAMI_Codigo;
                        $registro = $valor->EMPTIPOP_Codigo;
                        $codigo  = "<input type='hidden' name='tipoCodigo[".$item."]' id='tipoCodigo[".$item."]' class='cajaMedia' value='".$codigo."'>";
                        // $nombre_marca .= "<input type='text' name='contactoNombre[".$item."]' id='contactoNombre[".$item."]' class='cajaMedia' value='".$nombre_marca."'>";
                        $editar  = "&nbsp;";
                        $eliminar  = "<a href='#' onclick='eliminar_tipo(".$registro.");'><img src='".base_url()."images/delete.gif' border='0'></a>";
                        $tabla.='<td>'.$item.'</td>';
                        $tabla.='<td>'.$nombre_marca.'</td>';
                        $tabla.='<td>'.$eliminar.'</td>';
                        $tabla.='<td>'.$editar.'</td>';
                        $tabla.='</tr>';
                        $item++;
                }
        }               
        $tabla.='</table>';
        if(count($datos_marcasProveedor)==0)
            $tabla.='<div id="msgRegistros" style="width:98%;text-align:center;height:20px;border:1px solid #000;">NO EXISTEN REGISTROS</div>';

        if($pinta=='1')
            echo $tabla;
        else
            return $tabla;
    }
    
    
    public function TABLA_marcas($tipo,$empresa,$pinta=0){
        $datos_marcasProveedor = $this->empresa_model->obtener_marcasEmpresa($empresa);

        $tabla='<table id="tablaMarca" width="98%" class="fuente8" width="98%" cellspacing=0 cellpadding="6" border="1">
                <tr align="center" bgcolor="#BBBB20" height="10px;">
                <td>Nro</td>
                <td>Nombre de la marca</td>
                <td>Borrar</td>
                <td>Editar</td>
                </tr>';

        $item = 1;
        if(count($datos_marcasProveedor)>0){
                foreach($datos_marcasProveedor as $valor){
                        $tabla.='<tr bgcolor="#ffffff">';
                        $nombre_marca  = $valor->MARCC_Descripcion;
                        $codigo   = $valor->MARCP_Codigo;
                        $registro = $valor->EMPMARP_Codigo;
                        $codigo  = "<input type='hidden' name='marcaCodigo[".$item."]' id='marcaCodigo[".$item."]' class='cajaMedia' value='".$codigo."'>";
                        // $nombre_marca .= "<input type='text' name='contactoNombre[".$item."]' id='contactoNombre[".$item."]' class='cajaMedia' value='".$nombre_marca."'>";
                        $editar  = "&nbsp;";
                        $eliminar  = "<a href='#' onclick='eliminar_marca(".$registro.");'><img src='".base_url()."images/delete.gif' border='0'></a>";
                        $tabla.='<td>'.$item.'</td>';
                        $tabla.='<td>'.$nombre_marca.'</td>';
                        $tabla.='<td>'.$eliminar.'</td>';
                        $tabla.='<td>'.$editar.'</td>';
                        $tabla.='</tr>';
                        $item++;
                }
        }               
        $tabla.='</table>';
        if(count($datos_marcasProveedor)==0)
            $tabla.='<div id="msgRegistros" style="width:98%;text-align:center;height:20px;border:1px solid #000;">NO EXISTEN REGISTROS</div>';

        if($pinta=='1')
            echo $tabla;
        else
            return $tabla;
    }
    
    public function TABLA_sucursales($empresa,$sucursal_select='', $pinta=0){
        $datos_sucursalesProveedor = $this->empresa_model->listar_sucursalesEmpresa($empresa, '0');
        $tabla='<table id="tablaSucursal" width="98%" class="fuente8" width="98%" cellspacing=0 cellpadding="6" border="0">
                <tr align="center" class="cab1" height="10px;">
                <td width="30">Nro</td>
                <td width="70">Nombre</td>
                <td width="120">Tipo Establecimiento</td>
                <td width="350">Direccion Sucursal (*)</td>
                <td width="200">Departamento / Provincia / Distrito</td>
                <td>Borrar</td>
                <td>Editar</td>
                </tr>';

        $item = 1;
        if(count($datos_sucursalesProveedor)>0){
                foreach($datos_sucursalesProveedor as $valor){
                        $tabla.='<tr bgcolor="#ffffff">';
                        $sucursal               = $valor->EESTABP_Codigo;
                        if($sucursal==$sucursal_select){
                            $ubigeo_domicilio         = $valor->UBIGP_Codigo;
                            $dpto_domicilio           = substr($ubigeo_domicilio,0,2);
                            $prov_domicilio           = substr($ubigeo_domicilio,2,2);
                            $dist_domicilio           = substr($ubigeo_domicilio,4,2);
                            $nombredistrito           = '';
                            if($ubigeo_domicilio!='000000' && $ubigeo_domicilio!=''){
                                $datos_ubigeo         = $this->ubigeo_model->obtener_ubigeo($ubigeo_domicilio);
                                if(count($datos_ubigeo)>0)
                                    $nombredistrito=$datos_ubigeo[0]->UBIGC_Descripcion;
                            }
                            $cbo_tipo = $this->seleccionar_tipoestablecimiento($valor->TESTP_Codigo);
                            $tabla.='<td>'.$item.'</td>';
                            $tabla.="<td align='left'>";
                            $tabla.="<input type='text' name='nombreSucursal[".$item."]' id='nombreSucursal[".$item."]' size='10' maxlength='150' class='cajaGeneral' value='".$valor->EESTABC_Descripcion ."'>";
                            $tabla.="</td>";
                            $tabla.="<td align='left'><select name='tipoEstablecimiento[".$item."]' id='tipoEstablecimiento[".$item."]' class='comboMedio' >".$cbo_tipo."</select></td>";
                            $tabla.="<td align='left'><input type='text' name='direccionSucursal[".$item."]' id='direccionSucursal[".$item."]' size='58' maxlength='200' class='cajaGeneral' value='".$valor->EESTAC_Direccion ."'></td>";
                            $tabla.="<td align='left'>";
                            $tabla.="<input type='hidden' name='empresaSucursal[".$item."]' id='empresaSucursal[".$item."]' class='cajaMedia' value='".$sucursal."'>";
                            $tabla.="<input type='hidden' name='dptoSucursal[".$item."]' id='dptoSucursal[".$item."]' class='cajaGrande' value='".$dpto_domicilio."'>";
                            $tabla.="<input type='hidden' name='provSucursal[".$item."]' id='provSucursal[".$item."]' class='cajaGrande' value='".$prov_domicilio."'>";
                            $tabla.="<input type='hidden' name='distSucursal[".$item."]' id='distSucursal[".$item."]' class='cajaGrande' value='".$dist_domicilio."'>";
                            $tabla.="<input type='text' name='distritoSucursal[".$item."]' id='distritoSucursal[".$item."]' size='24' class='cajaGeneral cajaSoloLectura' readonly='readonly' value='".$nombredistrito."'/> ";
                            $tabla.="<a href='javascript:;' onclick='abrir_formulario_ubigeo_sucursal(".$item.");'><image src='".base_url()."images/ver.png' border='0'></a>";
                            $tabla.="</td>";
                            $tabla.="<td align='center'>&nbsp;</td>";
                            $tabla.="<td align='center'><a href='javascript:;' onclick='modificar_sucursal(".$item.");'><img src='".base_url()."images/save.gif' border='0'></a></td>";                                   
                        }
                        else{                                        
                            $tipo_establecimiento   = $valor->TESTP_Codigo;
                            $ubigeo                 = $valor->UBIGP_Codigo;
                            $nombre_establecimiento = "";
                            if($tipo_establecimiento!=''){
                                $datos_establecimiento  = $this->tipoestablecimiento_model->obtener_tipoEstablecimiento($tipo_establecimiento);
                                if(count($datos_establecimiento)>0)
                                    $nombre_establecimiento = $datos_establecimiento[0]->TESTC_Descripcion;
                            }
                            $nombre_distrito='';
                            if($ubigeo!='000000' && $ubigeo!=''){
                                $datos_ubigeo           = $this->ubigeo_model->obtener_ubigeo($ubigeo);
                                if(count($datos_ubigeo)>0)
                                    $nombre_distrito        = $datos_ubigeo[0]->UBIGC_Descripcion;
                            }
                            $sucursal               = $valor->EESTABP_Codigo;
                            $descripcion = $valor->EESTABC_Descripcion;
                            $direccion   = $valor->EESTAC_Direccion;
                            $eliminar    = "<a href='#' onclick='eliminar_sucursal(".$sucursal.");'><img src='".base_url()."images/delete.gif' border='0'></a>";
                            $editar      = "<a href='#' onclick='editar_sucursal(".$sucursal.");'><img src='".base_url()."images/edit.gif' border='0'>";

                            $tabla.='<td>'.$item.'</td>';
                            $tabla.='<td>'.$descripcion.'</td>';
                            $tabla.='<td>'.$nombre_establecimiento.'</td>';
                            $tabla.='<td>'.$direccion.'</td>';
                            $tabla.='<td>'.$nombre_distrito.'</td>';
                            $tabla.='<td align="center">'.$eliminar.'</td>';
                            $tabla.='<td align="center">'.$editar.'</td>';
                        }
                        $tabla.='</tr>';
                        $item++;
                }
        }

        $tabla.='</table>';
        if(count($datos_sucursalesProveedor)==0)
            $tabla.='<div id="msgRegistros2" style="width:98%;text-align:center;height:20px;border:1px solid #000;">NO EXISTEN REGISTROS</div>';
        if($pinta=='1')
            echo $tabla;
        else
            return $tabla;
    }
    public function JSON_busca_empresa_xruc($tipo, $numero){
        $datos_empresa  = $this->empresa_model->busca_xnumeroDoc($tipo, $numero);  //Esta funcion me devuelde el registro de la empresa
        $resultado          = '[]';
        if(count($datos_empresa)>0){
            $datos_empresaSucursal = $this->empresa_model->obtener_establecimientoEmpresa($datos_empresa[0]->EMPRP_Codigo,'1');
            $dpto_domicilio     = "15";
            $prov_domicilio     = "01";
            $dist_domicilio     = "00";             
            if(count($datos_empresaSucursal)>0){
                $ubigeo_domicilio         = $datos_empresaSucursal[0]->UBIGP_Codigo;
                $dpto_domicilio           = substr($ubigeo_domicilio,0,2);
                $prov_domicilio           = substr($ubigeo_domicilio,2,2);
                $dist_domicilio           = substr($ubigeo_domicilio,4,2);  
            }

            $resultado   = '[{"codigo":"'.$datos_empresa[0]->EMPRP_Codigo.
                            '","cod_cliente":"'.$datos_empresa[0]->CLIP_Codigo.
                            '","razon_social":"'.$datos_empresa[0]->EMPRC_RazonSocial.
                            '","departamento":"'.$dpto_domicilio.
                            '","provincia":"'.$prov_domicilio.
                            '","distrito":"'.$dist_domicilio.
                            '","direccion":"'.$datos_empresaSucursal[0]->EESTAC_Direccion.
                            '","telefono":"'.$datos_empresa[0]->EMPRC_Telefono.
                            '","movil":"'.$datos_empresa[0]->EMPRC_Movil.
                            '","fax":"'.$datos_empresa[0]->EMPRC_Fax.
                            '","correo":"'.$datos_empresa[0]->EMPRC_Email.
                            '","paginaweb":"'.$datos_empresa[0]->EMPRC_Web.
                            '","sector_comercial":"'.$datos_empresa[0]->SECCOMP_Codigo.
                            '","ctactesoles":"'.$datos_empresa[0]->EMPRC_CtaCteSoles.
                            '","ctactedolares":"'.$datos_empresa[0]->EMPRC_CtaCteDolares.'"}]';
        }
        echo $resultado;
    }
    public function JSON_busca_empresa_proveedor_xruc($tipo, $numero){
        $datos_empresa  = $this->empresa_model->proveedor_busca_xnumeroDoc($tipo, $numero);  //Esta funcion me devuelde el registro de la empresa
        $resultado          = '[]';
        if(count($datos_empresa)>0){
            $datos_empresaSucursal = $this->empresa_model->obtener_establecimientoEmpresa($datos_empresa[0]->EMPRP_Codigo,'1');
            $dpto_domicilio     = "15";
            $prov_domicilio     = "01";
            $dist_domicilio     = "00";             
            if(count($datos_empresaSucursal)>0){
                $ubigeo_domicilio         = $datos_empresaSucursal[0]->UBIGP_Codigo;
                $dpto_domicilio           = substr($ubigeo_domicilio,0,2);
                $prov_domicilio           = substr($ubigeo_domicilio,2,2);
                $dist_domicilio           = substr($ubigeo_domicilio,4,2);  
            }

            $resultado   = '[{"codigo":"'.$datos_empresa[0]->EMPRP_Codigo.
                            '","cod_proveedor":"'.$datos_empresa[0]->PROVP_Codigo.
                            '","razon_social":"'.$datos_empresa[0]->EMPRC_RazonSocial.
                            '","departamento":"'.$dpto_domicilio.
                            '","provincia":"'.$prov_domicilio.
                            '","distrito":"'.$dist_domicilio.
                            '","direccion":"'.$datos_empresaSucursal[0]->EESTAC_Direccion.
                            '","telefono":"'.$datos_empresa[0]->EMPRC_Telefono.
                            '","movil":"'.$datos_empresa[0]->EMPRC_Movil.
                            '","fax":"'.$datos_empresa[0]->EMPRC_Fax.
                            '","correo":"'.$datos_empresa[0]->EMPRC_Email.
                            '","paginaweb":"'.$datos_empresa[0]->EMPRC_Web.
                            '","sector_comercial":"'.$datos_empresa[0]->SECCOMP_Codigo.
                            '","ctactesoles":"'.$datos_empresa[0]->EMPRC_CtaCteSoles.
                            '","ctactedolares":"'.$datos_empresa[0]->EMPRC_CtaCteDolares.'"}]';
        }
        echo $resultado;
    }
    public function seleccionar_area($indSel=''){
        $array_area = $this->area_model->listar_areas();
        $arreglo = array();
        foreach($array_area as $indice=>$valor){
                $indice1   = $valor->AREAP_Codigo;
                $valor1    = $valor->AREAC_Descripcion;
                $arreglo[$indice1] = $valor1;
        }
        $resultado = $this->html->optionHTML($arreglo,$indSel,array('0','::Seleccione::'));
        return $resultado;  
    }
    public function seleccionar_cargo($indSel=''){
        $array_area = $this->cargo_model->listar_cargos();
        $arreglo = array();
        foreach($array_area as $indice=>$valor){
                $indice1   = $valor->CARGP_Codigo;
                $valor1    = $valor->CARGC_Descripcion;
                $arreglo[$indice1] = $valor1;
        }
        $resultado = $this->html->optionHTML($arreglo,$indSel,array('0','::Seleccione::'));
        return $resultado;      
    }
    public function seleccionar_tipoestablecimiento($indDefault=''){
        $array_dist = $this->tipoestablecimiento_model->listar_tiposEstablecimiento();
        $arreglo = array();
        if(count($array_dist)>0){
                foreach($array_dist as $indice=>$valor){
                        $indice1   = $valor->TESTP_Codigo;
                        $valor1    = $valor->TESTC_Descripcion;
                        $arreglo[$indice1] = $valor1;
                }
        }
        $resultado = $this->html->optionHTML($arreglo,$indDefault,array('0','::Seleccione::'));
        return $resultado;
    }

    public function JSON_listar_contactos($empresa){
        $resultado = array();
        $listado_contactosEmpresa = $this->empresa_model->listar_contactosEmpresa($empresa);
        if(count($listado_contactosEmpresa)>0){
                foreach($listado_contactosEmpresa as $indice => $valor){
                    $persona         = $valor->ECONC_Persona;
                    $datos_persona   = $this->persona_model->obtener_datosPersona($persona);
                    $nombres_persona = $datos_persona[0]->PERSC_Nombre." ".$datos_persona[0]->PERSC_ApellidoPaterno." ".$datos_persona[0]->PERSC_ApellidoMaterno." ";
                    $datos_directivo = $this->directivo_model->buscar_directivo($empresa,$persona);
                    $directivo       = $datos_directivo[0]->DIREP_Codigo;
                    $cargo           = $datos_directivo[0]->CARGP_Codigo;
                    $datos_areaEmpresa = $this->empresa_model->obtener_areaEmpresa($empresa,$directivo);
                    $datos_cargo     = $this->cargo_model->obtener_cargo($cargo);
                    $nombre_cargo    = $datos_cargo[0]->CARGC_Descripcion;
                    $area            = $datos_areaEmpresa[0]->AREAP_Codigo;
                    $nombre_area     = '';
                    if($area!='0' && $area!=''){
                        $datos_area      = $this->area_model->obtener_area($area);
                        if(count($datos_area)>0)
                            $nombre_area     = $datos_area[0]->AREAC_Descripcion;
                    }
                    
                    $objeto = new stdClass();
                    $objeto->area            = $area;
                    $objeto->nombre_area     = $nombre_area;
                    $objeto->empresa         = $valor->EMPRP_Codigo;
                    $objeto->personacontacto = $valor->PERSP_Contacto;
                    $objeto->descripcion     = $valor->ECONC_Descripcion;
                    $objeto->telefono        = $valor->ECONC_Telefono==''?'&nbsp;':$valor->ECONC_Telefono;
                    $objeto->movil           = $valor->ECONC_Movil;
                    $objeto->fax             = $valor->ECONC_Fax;
                    $objeto->email           = $valor->ECONC_Email==''?'&nbsp;':$valor->ECONC_Email;
                    $objeto->persona         = $valor->ECONC_Persona;
                    $objeto->emprcontacto    = $valor->ECONP_Contacto;
                    $objeto->nombre_persona  = $nombres_persona;
                    $objeto->tipo_contacto   = $valor->ECONC_TipoContacto;
                    $objeto->nombre_cargo    = $nombre_cargo;
                    $resultado[]             = $objeto;
                }
        }
        echo json_encode($resultado);
    }
    public function JSON_listar_sucursales($empresa){
        $listado_sucursalesEmpresa = $this->empresa_model->listar_sucursalesEmpresa($empresa);
        echo json_encode($listado_sucursalesEmpresa);
    }
    public function JSON_listar_personal($empresa, $cargo){
        $lista_personal=$this->directivo_model->listar_directivo($empresa, $cargo);
        echo json_encode($lista_personal);
    }
    public function JSON_listar_sucursalesEmpresa(){
        $datos_compania = $this->compania_model->obtener_compania($this->session->userdata('compania'));
        if(count($datos_compania)>0){
            $lista_mis_sucursales=$this->empresa_model->listar_sucursalesEmpresa($datos_compania[0]->EMPRP_Codigo);
            foreach($lista_mis_sucursales as $key => $reg){
                $reg->distrito     = "";
                $reg->provincia    = "";
                $reg->departamento = "";
                if($reg->UBIGP_Codigo!='' && $reg->UBIGP_Codigo!='000000'){
                    $datos_ubigeo_dist = $this->ubigeo_model->obtener_ubigeo_dist($reg->UBIGP_Codigo);
                    $datos_ubigeo_prov = $this->ubigeo_model->obtener_ubigeo_prov($reg->UBIGP_Codigo);
                    $datos_ubigeo_dep  = $this->ubigeo_model->obtener_ubigeo_dpto($reg->UBIGP_Codigo);
                    if(count($datos_ubigeo_dist)>0)
                        $reg->distrito     = $datos_ubigeo_dist[0]->UBIGC_Descripcion;
                    if(count($datos_ubigeo_prov)>0)
                        $reg->provincia    = $datos_ubigeo_prov[0]->UBIGC_Descripcion;
                    if(count($datos_ubigeo_dep)>0)
                        $reg->departamento = $datos_ubigeo_dep[0]->UBIGC_Descripcion;
                }
                $lista_mis_sucursales[$key]=$reg;
            }
        }
        $result[]=array('Tipo'=>'1', 'Titulo'=>'MIS ESTABLECIMIENTOS');
        foreach($lista_mis_sucursales as $reg)
            $result[]=array('Tipo'=>'2','EESTAC_Direccion'=>$reg->EESTAC_Direccion, 'UBIGP_Codigo'=>$reg->UBIGP_Codigo, 'departamento'=>$reg->departamento, 'provincia'=>$reg->provincia, 'distrito'=>$reg->distrito);
        
        
        echo json_encode($result);
    }
    public function insert_cuantasEmpresa(){
       
        $filter = new stdClass();
        $filter->EMPRE_Codigo=$this->input->post("empresa_persona");
        $filter->PERSP_Codigo=0;
        $filter->BANP_Codigo=$this->input->post("txtBanco");
        $filter->MONED_Codigo=$this->input->post("txtMoneda");
        $filter->CUENT_NumeroEmpresa=$this->input->post("txtCuenta");
        $filter->CUENT_Titular=$this->input->post("txtTitular");
        $filter->CUENT_TipoCuenta=$this->input->post("txtTipoCuenta");
        $filter->CUENT_TipoPersona=$this->input->post("TIP_Codigo");
        $filter->CUENT_Oficina=$this->input->post("txtOficina");
        $filter->CUENT_Sectoriza=$this->input->post("txtSectoriza");
        $filter->CUENT_Interbancaria=$this->input->post("txtInterban");
        $filter->CUENT_FechaRegistro=mdate("%Y-%m-%d ", time());
        $filter->CUENT_UsuarioRegistro=$this->session->userdata('user');
        $filter->CUENT_FlagEstado="1";
        $this->empresa_model->insertCuentaEmpresa($filter);
       }

    public function update_cuantasEmpresa(){
        $codigo=$this->input->post("txtCodCuenEmpre");
        $filter = new stdClass();
        $filter->EMPRE_Codigo=$this->input->post("empresa_persona");
        $filter->PERSP_Codigo=0;
        $filter->BANP_Codigo=$this->input->post("txtBanco");
        $filter->MONED_Codigo=$this->input->post("txtMoneda");
        $filter->CUENT_NumeroEmpresa=$this->input->post("txtCuenta");
        $filter->CUENT_Titular=$this->input->post("txtTitular");
        $filter->CUENT_TipoCuenta=$this->input->post("txtTipoCuenta");
        $filter->CUENT_TipoPersona=$this->input->post("TIP_Codigo");
        $filter->CUENT_Oficina=$this->input->post("txtOficina");
        $filter->CUENT_Sectoriza=$this->input->post("txtSectoriza");
        $filter->CUENT_Interbancaria=$this->input->post("txtInterban");
        $filter->CUENT_FechaModificacion=mdate("%Y-%m-%d ", time());
        $filter->CUENT_UsuarioModificaion=$this->session->userdata('user');
        $filter->CUENT_FlagEstado="1";
        $this->empresa_model->UpdateCuentaEmpresa($codigo,$filter);
       }

//buscar para actualizar data

public function JSON_listCuentaEmpresaEditar($codigo){
    $lista_detalles = array();
    $dataCuenta= $this->empresa_model->listCuentaEmpresaCodigo($codigo);
    if(count($dataCuenta)>0){
      foreach ($dataCuenta as $key => $value) {
      $objeto = new stdClass();
      $objeto->CUENT_Codigo        =$value->CUENT_Codigo;
      $objeto->CUENT_NumeroEmpresa =$value->CUENT_NumeroEmpresa;
      $objeto->CUENT_Titular       =$value->CUENT_Titular;
      $objeto->CUENT_TipoPersona   =$value->CUENT_TipoPersona;
      $objeto->CUENT_FechaRegistro =$value->CUENT_FechaRegistro;
      $objeto->BANC_Nombre         =$value->BANC_Nombre;
      $objeto->MONED_Descripcion   =$value->MONED_Descripcion;
      $objeto->CUENT_TipoCuenta    =$value->CUENT_TipoCuenta;
      $objeto->BANC_Selec=$this->seleccionar_banco($value->BANP_Codigo);
      $lista_detalles[] = ($objeto);          
    
    }  
  
    }

    $resultado[] = array();
    $resultado = json_encode($lista_detalles,JSON_NUMERIC_CHECK);
    echo  $resultado;

}

    public function JSON_EliminarCuentaEmpresa($codigo){
        $this->empresa_model->eliminar_cuentaEmpresa($codigo);
    }

    public function TABLA_cuentaEmpresa($codigo,$tipo="", $number_items = '', $offset = ''){
       //E EDENTIFICA PARA EDITAR EL CONTENIDO
        $dataCuentaEditar= $this->empresa_model->listCuentaEmpresaCodigo($codigo);
        if($tipo=="E"){
            if(count($dataCuentaEditar)>0){
                foreach ($dataCuentaEditar as $key => $value) {
                    $tabla='<table id="tableData" border="0" class="fuente8" width="98%" cellspacing="0" cellpadding="6">
                    <tr> <td>Banco</td><td>
                    <select id="txtBanco" name="txtBanco" autofocus>' ;
                    $tabla.=$this->seleccionar_banco($value->BANP_Codigo);
                    $tabla.='</select ></td><td>N° Cuenta</td>
                    <td><input type="text" id="txtCuenta" name="txtCuenta" value="'.$value->CUENT_NumeroEmpresa.'" onkeypress="return soloLetras_andNumero(event)"></td>
                    <td>Titular</td>
                    <td><input type="text" id="txtTitular" name="txtTitular" value="'.$value->CUENT_Titular.'" onkeypress="return soloLetras_andNumero(event)"></td> 
                    <tr>
                    <td>Oficina (*)</td>
                    <td><input type="text" name="txtOficina" id="txtOficina" onkeypress="return soloLetras_andNumero(event)" value="'.$value->CUENT_Oficina.'"></td>
                    <td>Sectoriza (*)</td>
                    <td><input type="text" name="txtSectoriza" id="txtSectoriza" onkeypress="return soloLetras_andNumero(event)" value="'.$value->CUENT_Sectoriza.'"></td>
                    <td>Interbancaria (*)</td>
                    <td><input type="text" name="txtInterban" id="txtInterban" onkeypress="return soloLetras_andNumero(event)" value="'.$value->CUENT_Interbancaria.'"></td>
                    </tr> 
                    </tr><tr><td>Tipo de Cuenta</td><td>';
                    $tabla.='<select name="txtTipoCuenta" id="txtTipoCuenta" required="required">';
                    $tabla.='<option value="S">::SELECCIONE::</option>';
                    
                    if($value->CUENT_TipoCuenta==1){
                        $tabla.='<option value="1"  selected="selected" >Ahorros</option>';
                        $tabla.='<option value="2" >Corriente</option>'; 
                    }
                    else
                        if ($value->CUENT_TipoCuenta==2) {
                            $tabla.='<option value="1"   >Ahorros</option>';
                            $tabla.='<option value="2" selected="selected" >Corriente</option>'; 
                        }

                        $tabla.='</select>
                        </td>
                        <td>Moneda</td>
                        <td>
                        <select id="txtMoneda" name="txtMoneda" >';

                        $tabla.=$this->seleccionar_Moneda($value->MONED_Codigo);
                        $tabla.='</select></td> <td></td><td>' ;
                        $tabla.='<input type="hidden" id="txtCodCuenEmpre" name="txtCodCuenEmpre" value="'.$value->CUENT_Codigo.'">
                        <a href="#" id="btnInsertarCuentaE" onclick="insertar_cuentaEmpresa()">
                        <img src='.base_url().'images/botonagregar.jpg></a>
                        <a href="#" id="btnCancelarCuentaE" onclick="limpiar_cuentaEmpresa()">
                        <img src='.base_url().'images/botoncancelar.jpg></a>
                        </td> </tr><tr><td colspan="6">campos obligatorios (*)</td></tr></table>' ;
                        echo $tabla;
                    }
                }
            }
            else{

                $dataCuenta= $this->empresa_model->listCuentaEmpresa($codigo);

                $tabla='<table id="tableBancos" class="table table-bordered table-striped fuente8" width="98%" cellspacing="0" cellpadding="6" border="0"><thead>
                <tr align="center" class="cab1" height="10px;">
                <td>Item</td>
                <td>Banco</td>
                <td>N° Cuenta</td>
                <td>Nombre o Titular de la cuenta</td>
                <td>Moneda</td>
                <td>Tipo de cuanta</td>
                <td colspan="3">Acciones</td></thead>
                </tr><tbody>'; 
                
                if(count($dataCuenta)>0){
                    foreach ($dataCuenta as $key => $value) {
                        $tabla.='<tr bgcolor="#ffffff">';
                        $tabla.='<td align="center">'.($key+1).'</td>';
                        $tabla.='<td align="left">'.$value->BANC_Nombre.'</td>';
                        $tabla.='<td>'.$value->CUENT_NumeroEmpresa.'</td> ';              
                        $tabla.='<td align="left">'.$value->CUENT_Titular.'</td>';
                        $tabla.='<td align="left">'.$value->MONED_Descripcion.'</td>';
                        
                        if($value->CUENT_TipoCuenta==1){
                            $tabla.='<td>Ahorros</td>';
                        }else{
                          $tabla.='<td>Corriente</td>';
                      }

                      $tabla.='<td align="center">';
                      $tabla.='<a href="#" onclick="eliminar_cuantaEmpresa('.$value->CUENT_Codigo.');"><img src='.base_url().'images/delete.gif border="0"></a>';
                      $tabla.='</td>';
                      $tabla.='<td align="center">';
                      $tabla.='<a href="#" id="btnAcualizarE" onclick="actualizar_cuentaEmpresa('.$value->CUENT_Codigo.');"><img src='.base_url().'images/modificar.png border="0"></a>';
                      $tabla.='<td><a href="#" onclick="ventanaChekera('.$value->CUENT_Codigo.')"><img src='.base_url().'images/observaciones.png></a></td>';
                      $tabla.='</td>';
                      $tabla.='</tr>';
                  }
              }
              $tabla.='</tbody></table>';
              echo $tabla;
          }
    }
    public function seleccionar_banco($indSel=''){
        $array_area = $this->empresa_model->listBanco();
        $arreglo = array();
        foreach($array_area as $indice=>$valor){
            $indice1   = $valor->BANP_Codigo;
            $valor1    = $valor->BANC_Nombre;
            $arreglo[$indice1] = $valor1;
        }
        $resultado = $this->html->optionHTML($arreglo,$indSel,array('S','::SELECCIONE::'));
        return $resultado;
    }
    public function seleccionar_Moneda($indSel=''){
        $array_area = $this->empresa_model->listMoneda();
        $arreglo = array();
        foreach($array_area as $indice=>$valor){
            $indice1   = $valor->MONED_Codigo;
            $valor1    = $valor->MONED_Descripcion;
            $arreglo[$indice1] = $valor1;
        }
        $resultado = $this->html->optionHTML($arreglo,$indSel,array('S','::SELECCIONE::'));
        return $resultado;
    }
    public function seleccionar_TipoCuenta($indSel=''){
    } 

    public function JSON_ListarCuentaEmpresa($codigo){
        $lista_detalles = array();
        $listDetalle= $this->empresa_model->listCuentaEmpresaCodigo($codigo);
        if(count($listDetalle)>0){ 
            foreach ($listDetalle as $key => $value) {
               $objeto = new stdClass();
               $objeto->CUENT_Codigo        =$value->CUENT_Codigo;
               $objeto->CUENT_NumeroEmpresa =$value->CUENT_NumeroEmpresa;
               $objeto->CUENT_Titular       =$value->CUENT_Titular;
               $objeto->CUENT_TipoPersona   =$value->CUENT_TipoPersona;
               $objeto->CUENT_FechaRegistro =$value->CUENT_FechaRegistro;
               $objeto->BANC_Nombre         =$value->BANC_Nombre;
               $objeto->MONED_Descripcion   =$value->MONED_Descripcion;
               $objeto->CUENT_TipoCuenta    =$value->CUENT_TipoCuenta;

               $lista_detalles[] = ($objeto);
           }
           $resultado[] = array();
           $resultado = json_encode($lista_detalles);
           echo  $resultado;
       }  
    }//final del metodo JSON_ListarCuentaEmpresa

    //codigo para chekera
    public function listarChikera($codigo){
        $lista_detalles = array();
        $listDetalle= $this->empresa_model->listChikera($codigo);
        if(count($listDetalle)>0){ 
            foreach ($listDetalle as $key => $value) {
              $objeto = new stdClass();
              $objeto->CHEK_Codigo        =$value->CHEK_Codigo;
              $objeto->CUENT_NumeroEmpresa =$value->CUENT_NumeroEmpresa;
              $objeto->CHEK_FechaRegistro  =mysql_to_human($value->CHEK_FechaRegistro);
              $objeto->SERIP_Codigo  =$value->SERIP_Codigo;
              $objeto->CHEK_Numero=$value->CHEK_Numero;
              $lista_detalles[] = ($objeto);
          }
          $resultado[] = array();
          $resultado = json_encode($lista_detalles,JSON_NUMERIC_CHECK);
          echo  $resultado;  
      }    
    }   
    public function insertChekera(){
        $filter = new stdClass();
        $filter->SERIP_Codigo=$this->input->post("txtSerieChekera");
        $filter->CUENT_Codigo=$this->input->post("txtCodCuentaEmpre");
        $filter->EMPRP_Codigo=$this->input->post("empresa_persona");
        $filter->CHEK_Numero=$this->input->post("txtNumeroChek");
        //$filter->txtNumeroChek=$this->input->post("txtNumeroChek")
        $filter->PERSP_Codigo=0;
        $filter->CHEK_FechaRegistro=mdate("%Y-%m-%d ", time());
        $filter->CHEK_UsuarioRegistro=$this->session->userdata('user');
        $filter->CHEK_FlagEstado="1";
        $this->empresa_model->insertChekera($filter);
    } 

    public function eliminarChikera($codigo){
        $this->empresa_model->delete_chikera($codigo);
    }  

    public function TABLE_listarChekera($codigo){
      $detalleChikera=  $this->empresa_model->listChikera($codigo);
      $table='<table id="tablechekera" width="100%"
      cellpadding="6" border="0" >
      <thead>
      <tr style="background-color:#5F5F5F;color:#ffffff;font-weight: bold;">
      <td>Item</td><td>Fecha</td><td>Cuenta Empresa</td>
      <td>Serie</td><td>Numero</td><td>Accion</td>
      </tr>
      </thead>
      <tbody id="listarChekera" style="color:black">  ';
      if(count($detalleChikera)>0){
        foreach ($detalleChikera as $key => $value) {
           $table.='<tr>';
           $table.='<td>'.($key+1).'</td>';
           $table.='<td>'.mysql_to_human($value->CHEK_FechaRegistro).'</td>';
           $table.='<td>'.$value->CUENT_NumeroEmpresa.'</td>';
           $table.='<td>'.$value->SERIP_Codigo .'</td>';
           $table.='<td>'.$value->CHEK_Numero. '</td>';
           $table.='<td><a href="#" onclick="eliminarChikera('.$value->CHEK_Codigo.')" ><img src='.base_url().'images/delete.gif ></a></td>';
           $table.='</tr>';
       }
    }
    $table.='</tbody></table>';
    echo $table;
    } 
    public function getBuscaCuenta($codigo){
      $data_model = $this->cuentaempresa_model->getBuscarNumCuenta($codigo);
      if (count($data_model )>0) {
       echo json_encode($data_model);
    }

    }

    public function seleccionar_departamento($indDefault = ''){
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

    public function seleccionar_provincia($departamento, $indDefault = ''){
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

    public function seleccionar_distritos($departamento, $provincia, $indDefault = ''){
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

    public function searchEmpresa(){
        $search = $this->input->post("search");
        $info = $this->empresa_model->getEmpresas($search);
        if ($info != NULL){
            foreach ($info as $key => $value) {
                $result[] = array("value" => $value->EMPRC_RazonSocial, "label" => "$value->EMPRC_Ruc - $value->EMPRC_RazonSocial", "codigo" => $value->EMPRP_Codigo, "direccion" => $value->EMPRC_Direccion);
            }
            echo json_encode($result);
        }
    }

    #############OBSOLTA################
    public function TABLA_contactos($tipo,$empresa,$persona_select='', $pinta=0){
        $datos_contactoProveedor = $this->empresa_model->obtener_contactoEmpresa($empresa);

        $tabla='<table id="tablaContacto" width="98%" class="fuente8" width="98%" cellspacing=0 cellpadding="6" border="0">
                <tr align="center" class="cab1" height="10px;">
                <td>Nro</td>
                <td>Nombre del Contacto</td>
                <td>Area</td>
                <td>Cargo</td>
                <td>Tel&eacute;fonos</td>
                <td>Email</td>
                <td>Borrar</td>
                <td>Editar</td>
                </tr>';

        $item = 1;
        if(count($datos_contactoProveedor)>0){
                foreach($datos_contactoProveedor as $valor){
                        $tabla.='<tr bgcolor="#ffffff">';
                        $persona         = $valor->ECONC_Persona;
                        $datos_persona   = $this->persona_model->obtener_datosPersona($persona);
                        $datos_directivo = $this->directivo_model->buscar_directivo($empresa,$persona);
                        $directivo       = $datos_directivo[0]->DIREP_Codigo;
                        $datos_emparea   = $this->empresa_model->obtener_areaEmpresa($empresa,$directivo);  
                        $area            = $datos_emparea[0]->AREAP_Codigo;
                        $cargo           = $datos_directivo[0]->CARGP_Codigo;
                        $datos_cargo     = $this->cargo_model->obtener_cargo($cargo);
                        $datos_area      = $this->area_model->obtener_area($area); 
                        if($persona==$persona_select){
                                $nombres   = $datos_persona[0]->PERSC_Nombre." ".$datos_persona[0]->PERSC_ApellidoPaterno;
                                $cbo_area  = $this->seleccionar_area($area);
                                $cbo_cargo = $this->seleccionar_cargo($cargo);
                                $telefono  = $valor->ECONC_Telefono.($valor->ECONC_Movil!=''?'/':'').$valor->ECONC_Movil;
                                $nombre_persona  = "<input type='hidden' name='contactoPersona[".$item."]' id='contactoPersona[".$item."]' class='cajaMedia' value='".$persona."'>";
                                $nombre_persona .= "<input type='text' name='contactoNombre[".$item."]' id='contactoNombre[".$item."]' class='cajaMedia' onfocus='ocultar_homonimos(".$item.");' value='".$nombres."'>";
                                $nombre_area    = "<select name='contactoArea[".$item."]' id='contactoArea[".$item."]' class='comboMedio' >".$cbo_area."</option></select>";
                                $cargo_persona  = "<select name='cargo_encargado[".$item."]' id='cargo_encargado[".$item."]' class='cajaMedia'>".$cbo_cargo."</select>";
                                $telefono       = "<input type='text' name='contactoTelefono[".$item."]' id='contactoTelefono[".$item."]' class='cajaPequena' value='".$telefono."'>";
                                $email          = "<input type='text' name='contactoEmail[".$item."]' id='contactoEmail[".$item."]' class='cajaPequena' value='".$valor->ECONC_Email."'>";
                                $eliminar       = "&nbsp;";
                                if($tipo=="c"){
                                        $editar         = "<a href='#' onclick='modificar_clienteContacto(".$item.");'><img src='".base_url()."images/save.gif' border='0'></a>";
                                }
                                elseif($tipo=="p"){
                                        $editar         = "<a href='#' onclick='modificar_contacto(".$item.");'><img src='".base_url()."images/save.gif' border='0'></a>";                  
                                }
                        }
                        else{
                                $cargo_persona   = $datos_cargo[0]->CARGC_Descripcion;
                                $nombre_persona  = $datos_persona[0]->PERSC_Nombre." ".$datos_persona[0]->PERSC_ApellidoPaterno;
                                $nombre_area     = $datos_area[0]->AREAC_Descripcion;
                                $telefono        = $valor->ECONC_Telefono==''?'&nbsp;':$valor->ECONC_Telefono;
                                $email           = $valor->ECONC_Email==''?'&nbsp;':$valor->ECONC_Email;
                                if($tipo=='c'){
                                        $eliminar        = "<a href='#' onclick='eliminar_clienteContacto(".$persona.");'><img src='".base_url()."images/delete.gif' border='0'></a>";
                                        $editar          = "<div id='idEdit'><a href='#' onclick='editar_empresaContacto(".$persona.");'><img src='".base_url()."images/edit.gif' border='0'></a></div>";           
                                }
                                elseif($tipo=="p"){
                                        $eliminar        = "<a href='#' onclick='eliminar_contacto(".$persona.");'><img src='".base_url()."images/delete.gif' border='0'></a>";
                                        $editar          = "<div id='idEdit'><a href='#' onclick='editar_contacto(".$persona.");'><img src='".base_url()."images/edit.gif' border='0'></a>";                    
                                }
                        }
                        $tabla.='<td>'.$item.'</td>';
                        $tabla.='<td>'.$nombre_persona.'</td>';
                        $tabla.='<td>'.$nombre_area.'</td>';
                        $tabla.='<td>'.$cargo_persona.'</td>';
                        $tabla.='<td>'.$telefono.'</td>';
                        $tabla.='<td>'.$email.'</td>';
                        $tabla.='<td>'.$eliminar.'</td>';
                        $tabla.='<td>'.$editar.'</td>';
                        $tabla.='</tr>';
                        $item++;
                }       
        }               
        $tabla.='</table>';
        if(count($datos_contactoProveedor)==0)
            $tabla.='<div id="msgRegistros" style="width:98%;text-align:center;height:20px;border:1px solid #000;">NO EXISTEN REGISTROS</div>';

        if($pinta=='1')
            echo $tabla;
        else
            return $tabla;
    }
}       
?>