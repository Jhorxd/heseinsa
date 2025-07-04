<?php

class Directivo extends Controller {

    private $empresa;
    private $compania;
    private $usuario;
    private $url;

    Public function __construct() {
        parent::__construct();
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
        $this->load->model('maestros/formapago_model');
        $this->load->model('maestros/sectorcomercial_model');

        $this->load->model('tesoreria/banco_model');
        $this->load->model('ventas/tipocliente_model');

        $this->load->helper('date');
        $this->load->helper('json');
        $this->load->library('html');
        $this->load->library('table');
        
        $this->load->library('pagination');
        $this->load->library('lib_props');

        $this->empresa = $this->session->userdata("empresa");
        $this->compania = $this->session->userdata("compania");
        $this->usuario = $this->session->userdata("usuario");
        $this->url = base_url();
    }

    ###########################
    ###### FUNCTIONS NEWS
    ###########################

        public function index() {
            $this->directivos();
        }

        public function directivos( $j = "" ){
            ## SELECTS
                $data["documentos"] = $this->tipodocumento_model->listar_tipo_documento();
                $data['edo_civil'] = $this->estadocivil_model->listar_estadoCivil();
                $data['nacionalidad'] = $this->nacionalidad_model->listar_nacionalidad();
                $data["categorias_cliente"] = $this->tipocliente_model->listar();
                $data["cargos"] = $this->cargo_model->getCargos();
                $data["bancos"] = $this->banco_model->listar_banco();
                $data["lista_empresas"] = $this->empresa_model->listar_empresas();

            $data['registros']  = count($this->directivo_model->getDirectivos());
            $conf['base_url']   = $this->url;

            $data['titulo_tabla']    = "RELACIÓN DE EMPLEADOS";
            $data['titulo_busqueda'] = "BUSCAR EMPLEADO";
            $this->layout->view('maestros/directivo_index',$data);
        }

        public function datatable_empleado(){

            $columnas = array(
                                0 => "DIREC_CodigoEmpleado",
                                1 => "PERSC_NumeroDocIdentidad",
                                2 => "PERSC_Nombre",
                                3 => "PERSC_ApellidoPaterno",
                                4 => "CARGC_Descripcion",
                                5 => ""
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

            $empleadoInfo = $this->directivo_model->getDirectivos($filter);
            $lista = array();
            
            if (count($empleadoInfo) > 0) {
                foreach ($empleadoInfo as $indice => $valor) {
                    $btn_modal = "<button type='button' onclick='editar($valor->DIREP_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/modificar.png' class='image-size-1b'>
                                </button>";
                   
                    $btn_ficha = "<button href='".$this->url."index.php/maestros/directivo/ficha_empleado/$valor->DIREP_Codigo' data-fancybox data-type='iframe' class='btn btn-default'>
                                <img src='".$this->url."/images/pdf.png' class='image-size-1b'>
                            </button>";
                    $btn_clientes = "<button href='".$this->url."index.php/maestros/directivo/relacion_clientes/$valor->DIREP_Codigo' data-fancybox data-type='iframe' class='btn btn-default'>
                                <img src='".$this->url."/images/icon-clientes.png' class='image-size-1b'>
                            </button>";

                    $btn_borrar = "<button type='button' onclick='deshabilitar($valor->DIREP_Codigo)' class='btn btn-default'><img src='".$this->url."/images/documento-delete.png' class='image-size-1b'></button>";

                    $eliminar_personal = ($valor->PERSP_Codigo==1) ? "" : $btn_borrar;

                    $lista[] = array(
                                        0 => "$valor->DIREC_CodigoEmpleado",
                                        1 => "$valor->PERSC_NumeroDocIdentidad",
                                        2 => "$valor->PERSC_Nombre",
                                        3 => "$valor->PERSC_ApellidoPaterno $valor->PERSC_ApellidoMaterno",
                                        4 => "$valor->CARGC_Nombre",
                                        5 => "$btn_ficha",
                                        6 => "$btn_modal",
                                        7 => "$eliminar_personal",
                                        8 => "$btn_clientes"
                                    );
                }
            }

            unset($filter->start);
            unset($filter->length);

            $json = array(
                                "draw"            => intval( $this->input->post('draw') ),
                                "recordsTotal"    => count($this->directivo_model->getDirectivos()),
                                "recordsFiltered" => intval( count($this->directivo_model->getDirectivos($filter)) ),
                                "data"            => $lista
                        );

            echo json_encode($json);
        }

        public function getEmpleado(){

            $codigo = $this->input->post("empleado"); # DIRECTIVO

            $empleadoInfo = $this->directivo_model->getDirectivo($codigo);
            $lista = array();
            
            if ( $empleadoInfo != NULL ){
                foreach ($empleadoInfo as $indice => $val) {
                    $lista = array(
                                        "tipo_documento" => $val->PERSC_TipoDocIdentidad,
                                        "numero_documento" => $val->PERSC_NumeroDocIdentidad,
                                        "numero_ruc" => $val->PERSC_Ruc,
                                        "nombres" => $val->PERSC_Nombre,
                                        "apellido_paterno" => $val->PERSC_ApellidoPaterno,
                                        "apellido_materno" => $val->PERSC_ApellidoMaterno,
                                        "fecha_nacimiento" => $val->PERSC_FechaNacz,
                                        "genero" => $val->PERSC_Sexo,
                                        "edo_civil" => $val->ESTCP_EstadoCivil,
                                        "nacionalidad" => $val->NACP_Nacionalidad,

                                        "telefono" => $val->PERSC_Telefono,
                                        "movil" => $val->PERSC_Movil,
                                        "fax" => $val->PERSC_Fax,
                                        "correo" => $val->PERSC_Email,
                                        "web" => $val->PERSC_Web,
                                        "direccion" => $val->PERSC_Direccion,
                                        "direccion" => $val->PERSC_Domicilio,

                                        "banco" => $val->BANP_Codigo,
                                        "cta_soles" => $val->PERSC_CtaCteSoles,
                                        "cta_dolares" => $val->PERSC_CtaCteDolares,
                                        
                                        "empleado" => $val->DIREP_Codigo,
                                        "cargo" => $val->CARGP_Codigo,
                                        "numero_contrato" => $val->DIREC_NroContrato,
                                        "fecha_inicio" => $val->DIREC_FechaInicio,
                                        "fecha_final" => $val->DIREC_FechaFin,
                                        "codigo_empleado" => $val->DIREC_CodigoEmpleado
                                    );
                }

                $json = array("match" => true, "info" => $lista);
            }
            else
                $json = array("match" => false, "info" => "");

            echo json_encode($json);
        }

        public function guardar_registro(){

            $empleado           = $this->input->post("empleado"); # DIRECTIVO
            $tipo_documento     = $this->input->post("tipo_documento");
            $numero_documento   = $this->input->post("numero_documento");
            $numero_ruc         = $this->input->post("numero_ruc");
            $nombres            = strtoupper( $this->input->post("nombres") );
            $apellido_paterno   = strtoupper( $this->input->post("apellido_paterno") );
            $apellido_materno   = strtoupper( $this->input->post("apellido_materno") );
            $fecha_nacimiento   = $this->input->post("fecha_nacimiento");
            $genero             = $this->input->post("genero");
            $edo_civil          = $this->input->post("edo_civil");
            $nacionalidad       = $this->input->post("nacionalidad");
            $direccion          = strtoupper( $this->input->post("direccion") );
            
            $telefono           = $this->input->post("telefono");
            $movil              = $this->input->post("movil");
            $fax                = $this->input->post("fax");
            $correo             = $this->input->post("correo");
            $web                = $this->input->post("web");
            
            $banco              = $this->input->post("banco");
            $cta_soles          = $this->input->post("cta_soles");
            $cta_dolares        = $this->input->post("cta_dolares");

            $cargo              = $this->input->post("cargo");
            $numero_contrato    = $this->input->post("numero_contrato");
            $fecha_inicio       = $this->input->post("fecha_inicio");
            $fecha_final        = $this->input->post("fecha_final");


            ### PERSONA
                $personaInfo = new stdClass();
                $personaInfo->PERSC_TipoDocIdentidad    = $tipo_documento;
                $personaInfo->PERSC_NumeroDocIdentidad  = $numero_documento;
                $personaInfo->PERSC_Ruc                 = $numero_ruc;
                $personaInfo->PERSC_Nombre              = strtoupper($nombres);
                $personaInfo->PERSC_ApellidoPaterno     = strtoupper($apellido_paterno);
                $personaInfo->PERSC_ApellidoMaterno     = strtoupper($apellido_materno);
                $personaInfo->PERSC_FechaNacz           = $fecha_nacimiento;
                $personaInfo->PERSC_Sexo                = $genero;
                $personaInfo->ESTCP_EstadoCivil         = $edo_civil;
                $personaInfo->NACP_Nacionalidad         = $nacionalidad;
                
                $personaInfo->PERSC_Telefono            = $telefono;
                $personaInfo->PERSC_Movil               = $movil;
                $personaInfo->PERSC_Fax                 = $fax;
                $personaInfo->PERSC_Email               = $correo;
                $personaInfo->PERSC_Web                 = $web;

                $personaInfo->BANP_Codigo               = $banco;
                $personaInfo->PERSC_CtaCteSoles         = $cta_soles;
                $personaInfo->PERSC_CtaCteDolares       = $cta_dolares;

                $personaInfo->UBIGP_LugarNacimiento     = "000000";
                $personaInfo->UBIGP_Domicilio           = "000000";
                $personaInfo->PERSC_Direccion           = strtoupper($direccion);
                $personaInfo->PERSC_Domicilio           = strtoupper($direccion);

            ### DIRECTIVO
                $directivoInfo = new stdClass();
                $directivoInfo->EMPRP_Codigo            = $this->empresa;
                $directivoInfo->CARGP_Codigo            = $cargo;
                $directivoInfo->TIPCLIP_Codigo          = "";
                $directivoInfo->DIREC_Imagen            = "";
                $directivoInfo->DIREC_FechaInicio       = $fecha_inicio;
                $directivoInfo->DIREC_FechaFin          = $fecha_final;
                $directivoInfo->DIREC_NroContrato       = $numero_contrato;
                $directivoInfo->DIREC_CodigoEmpleado    = $this->generateCodeDirectivo();

            if ($empleado != ""){
                $directivo = $this->directivo_model->actualizar_directivo($empleado, $directivoInfo);
                $persona = $this->directivo_model->actualizar_persona($empleado, $personaInfo);

                if ($directivo != NULL && $persona != NULL)
                    $result = true;
                else
                    $result = false;
            }
            else{
                $persona = $this->directivo_model->insertar_persona($personaInfo);

                if ($persona != NULL){
                    $directivoInfo->PERSP_Codigo = $persona;
                    $directivo = $this->directivo_model->insertar_directivo($directivoInfo);

                    $result = true;
                }
                else
                    $result = false;
            }

            if ($result)
                $json = array("result" => "success");
            else
                $json = array("result" => "error");
            
            echo json_encode($json);
        }

        public function deshabilitar_empleado(){

            $empleado = $this->input->post("empleado");

            $directivoInfo = new stdClass();
            $directivoInfo->DIREC_FlagEstado  = "0";

            $personaInfo = new stdClass();
            $personaInfo->PERSC_FlagEstado  = "0";

            if ($empleado != ""){
                $result = $this->directivo_model->actualizar_directivo($empleado, $directivoInfo);
                if ($result){
                    $result = $this->directivo_model->actualizar_persona($empleado, $personaInfo);
                    $result = $this->directivo_model->deshabilitar_usuario($empleado);
                }
            }

            if ($result)
                $json = array("result" => "success");
            else
                $json = array("result" => "error");
            
            echo json_encode($json);
        }

    #############################################
    ###### DOCS PDF
    #############################################

        public function ficha_empleado($codigo, $enviarcorreo = false){

            $medidas = "a4"; // a4 - carta

            $this->pdf = new pdfGeneral('P', 'mm', $medidas, true, 'UTF-8', false);
            $this->pdf->SetMargins(10, 55, 10); // Cada 10 es 1cm - Como es hoja estoy tratando las medidad en cm -> Rawil
            $this->pdf->SetTitle("FICHA DEL EMPLEADO");
            $this->pdf->SetFont('freesans', '', 8);
            $this->pdf->setPrintHeader(true);

            ### INFORMACION DEL PACIENTE
                $empleadoInfo = $this->directivo_model->getDirectivo($codigo);
                
                $documento_descripcion  = $empleadoInfo[0]->tipo_documento;
                $documento_numero       = $empleadoInfo[0]->PERSC_NumeroDocIdentidad;
                $documento_ruc          = $empleadoInfo[0]->PERSC_Ruc;
                $nombres                = $empleadoInfo[0]->PERSC_Nombre;
                $apellido_paterno       = $empleadoInfo[0]->PERSC_ApellidoPaterno;
                $apellido_materno       = $empleadoInfo[0]->PERSC_ApellidoMaterno;
                $genero                 = $empleadoInfo[0]->genero;
                $fecha_nacimiento       = $empleadoInfo[0]->PERSC_FechaNacz;
                $edo_civil              = $empleadoInfo[0]->ESTCC_Descripcion;
                
                $telefono               = $empleadoInfo[0]->PERSC_Telefono;
                $movil                  = $empleadoInfo[0]->PERSC_Movil;
                $fax                    = $empleadoInfo[0]->PERSC_Fax;
                $correo                 = $empleadoInfo[0]->PERSC_Email;
                $direccion              = $empleadoInfo[0]->PERSC_Direccion;

                $nacionalidad           = $empleadoInfo[0]->NACC_Descripcion;
                $web                    = $empleadoInfo[0]->PERSC_Web;

                $banco                  = $empleadoInfo[0]->BANC_Nombre;
                $cta_soles              = $empleadoInfo[0]->PERSC_CtaCteSoles;
                $cta_dolares            = $empleadoInfo[0]->PERSC_CtaCteDolares;

                $cargo                  = $empleadoInfo[0]->CARGC_Nombre;
                $contrato_numero        = $empleadoInfo[0]->DIREC_NroContrato;
                $contrato_inicio        = $empleadoInfo[0]->DIREC_FechaInicio;
                $contrato_fin           = $empleadoInfo[0]->contrato_fin;

                ##### FECHA DE NACIMIENTO
                    $fechaN = new DateTime($fecha_nacimiento); # CREA UN OBJETO CON LA FECHA DE NACIMIENTO
                    $fechaH = new DateTime(date("Y-m-d")); # CREA UN OBJETO CON LA FECHA DE HOY
                    $fechaF = $fechaN->diff($fechaH); # CREA UN OBJETO CON LA DIFERENCIA ENTRE AMBAS FECHAS

                ##### FECHA DE CONTRATO
                    if ($contrato_fin != 'INDEFINIDO'){
                        $contrato_fechaI = new DateTime($contrato_inicio); # CREA UN OBJETO CON LA FECHA DE CONTRATO
                        $contrato_fechaF = new DateTime($contrato_fin); # CREA UN OBJETO CON LA FECHA DE EXPIRACIÓN
                        $contrato_vence = $contrato_fechaI->diff($contrato_fechaF); # CREA UN OBJETO CON LA DIFERENCIA ENTRE AMBAS FECHAS
                        #$contrato_vence->m .= " MES(ES)";

                        $contrato_inicio = mysql_to_human($contrato_inicio);
                        $contrato_fin = mysql_to_human($contrato_fin);

                        $contrato_vence->duracion = ($contrato_vence->y * 12) + $contrato_vence->m;
                        $contrato_vence->duracion .= " MES(ES)";
                    }
                    else{
                        $contrato_vence = new stdClass();
                        $contrato_vence->duracion = "";
                    }

            $companiaInfo = $this->compania_model->obtener($this->compania);
            $establecimientoInfo = $this->emprestablecimiento_model->listar( $companiaInfo[0]->EMPRP_Codigo, '', $companiaInfo[0]->COMPP_Codigo );
            $empresaInfo =  $this->empresa_model->obtener_datosEmpresa( $establecimientoInfo[0]->EMPRP_Codigo );
            
            $tipoDocumento  = "FICHA DEL EMPLEADO";
            $tipoDocumentoF = "FICHA DEL EMPLEADO";
            
            $header = new stdClass();
            $header->ruc    = $empresaInfo[0]->EMPRC_Ruc;
            $header->serie  = NULL;
            $header->numero = NULL;
            $header->RazonSocial  = $empresaInfo[0]->EMPRC_RazonSocial;
            $header->direccion    = $establecimientoInfo[0]->EESTAC_Direccion;
            $header->ubigeo       = $establecimientoInfo[0]->distrito . ' - ' . $establecimientoInfo[0]->provincia . ' - ' . $establecimientoInfo[0]->departamento;

            $this->pdf->settingHeaderData($header, $tipoDocumento);

            //$this->pdf->settingHeaderData($empresaInfo[0]->EMPRC_Ruc, $tipoDocumento, "", NULL);

            $this->pdf->AddPage();
            $this->pdf->SetAutoPageBreak(true, 1);

            ##### INFORMACIÓN DEL EMPLEADO
                $empleadoHTML = '<table cellpadding="1.5mm" border="0">
                            <tr bgcolor="#E1E1E1">
                                <th style="width: 18.8cm; font-weight:bold">INFORMACIÓN DEL EMPLEADO</th>
                            </tr>
                            <tr>
                                <td style="border-bottom: #EEE 1mm solid; width:1.5cm; font-weight:bold;">'.$documento_descripcion.'</td>
                                <td style="border-bottom: #EEE 1mm solid; width:2.0cm;">'.$documento_numero.'</td>

                                <td style="border-bottom: #EEE 1mm solid; width:1.5cm; font-weight:bold;">R.U.C.</td>
                                <td style="border-bottom: #EEE 1mm solid; width:2.0cm;">'.$documento_ruc.'</td>

                                <td style="border-bottom: #EEE 1mm solid; width:4.0cm; font-weight:bold;">NOMBRE Y APELLIDOS:</td>
                                <td style="border-bottom: #EEE 1mm solid; width:7.8cm;">'.$nombres.' '.$apellido_paterno.' '.$apellido_materno.'</td>
                            </tr>
                            <tr>
                                <td style="border-bottom: #EEE 1mm solid; width:2.0cm; font-weight:bold;">GENERO:</td>
                                <td style="border-bottom: #EEE 1mm solid; width:2.5cm;">'.$genero.'</td>

                                <td style="border-bottom: #EEE 1mm solid; width:4.0cm; font-weight:bold;">FECHA DE NACIMIENTO:</td>
                                <td style="border-bottom: #EEE 1mm solid; width:2.0cm;">'.mysql_to_human($fecha_nacimiento).'</td>
                                
                                <td style="border-bottom: #EEE 1mm solid; width:1.5cm; font-weight:bold;">EDAD:</td>
                                <td style="border-bottom: #EEE 1mm solid; width:1.5cm;">'.$fechaF->y.' años</td>

                                <td style="border-bottom: #EEE 1mm solid; width:2.0cm; font-weight:bold;">EDO. CIVIL:</td>
                                <td style="border-bottom: #EEE 1mm solid; width:3.3cm;">'.$edo_civil.'</td>
                            </tr>
                            <tr>
                                <td style="border-bottom: #EEE 1mm solid; width:3.0cm; font-weight:bold;">NACIONALIDAD:</td>
                                <td style="border-bottom: #EEE 1mm solid; width:5.0cm;">'.$nacionalidad.'</td>

                                <td style="border-bottom: #EEE 1mm solid; width:2.0cm; font-weight:bold;">TELEFONO:</td>
                                <td style="border-bottom: #EEE 1mm solid; width:3.0cm;">'.$telefono.'</td>

                                <td style="border-bottom: #EEE 1mm solid; width:1.5cm; font-weight:bold;">MOVIL:</td>
                                <td style="border-bottom: #EEE 1mm solid; width:4.3cm;">'.$movil.'</td>
                            </tr>
                            <tr>
                                <td style="border-bottom: #EEE 1mm solid; width:2.0cm; font-weight:bold;">CORREO:</td>
                                <td style="border-bottom: #EEE 1mm solid; width:6.0cm;">'.$correo.'</td>

                                <td style="border-bottom: #EEE 1mm solid; width:1.2cm; font-weight:bold;">FAX:</td>
                                <td style="border-bottom: #EEE 1mm solid; width:2.5cm;">'.$fax.'</td>

                                <td style="border-bottom: #EEE 1mm solid; width:1.1cm; font-weight:bold;">WEB:</td>
                                <td style="border-bottom: #EEE 1mm solid; width:6.0cm;">'.$web.'</td>

                            </tr>
                            <tr>
                                <td style="width:2.0cm; font-weight:bold;">DIRECCIÓN:</td>
                                <td style="width:16.8cm;">'.$direccion.'</td>
                            </tr>
                        </table>';

                $posI = $this->pdf->getY(); # OBTENGO LA POSICION INICIAL
                $this->pdf->writeHTML($empleadoHTML,true,false,true,'');
                $posF = $this->pdf->getY(); # OBTENGO LA POSICION LUEGO DE IMPRIMIR

                $this->pdf->RoundedRect(8, $posI-2, 192, $posF-$posI, 1.50, '1111', ''); # RESTO LA POSICION FINAL MENOS LA INICIAL PARA EL ALTO DEL CUADRO
                $this->pdf->setY($posF + 3);

            ##### CUENTA BANCARIA
                $bancoHTML = '<table cellpadding="1.5mm" border="0">
                            <tr bgcolor="#E1E1E1">
                                <th style="width: 18.8cm; font-weight:bold">CUENTA BANCARIA</th>
                            </tr>
                            <tr>
                                <td style="border-bottom: #EEE 1mm solid; width:1.5cm; font-weight:bold;">BANCO:</td>
                                <td style="border-bottom: #EEE 1mm solid; width:4.5cm;">'.$banco.'</td>

                                <td style="border-bottom: #EEE 1mm solid; width:2.0cm; font-weight:bold;">CTA SOLES:</td>
                                <td style="border-bottom: #EEE 1mm solid; width:4.0cm;">'.$cta_soles.'</td>

                                <td style="border-bottom: #EEE 1mm solid; width:2.5cm; font-weight:bold;">CTA DOLARES:</td>
                                <td style="border-bottom: #EEE 1mm solid; width:4.3cm;">'.$cta_dolares.'</td>
                            </tr>
                        </table>';

                $posI = $this->pdf->getY(); # OBTENGO LA POSICION INICIAL
                $this->pdf->writeHTML($bancoHTML,true,false,true,'');
                $posF = $this->pdf->getY(); # OBTENGO LA POSICION LUEGO DE IMPRIMIR

                $this->pdf->RoundedRect(8, $posI-2, 192, $posF-$posI, 1.50, '1111', ''); # RESTO LA POSICION FINAL MENOS LA INICIAL PARA EL ALTO DEL CUADRO
                $this->pdf->setY($posF + 3);

            ##### INFORMACIÓN DEL CONTRATO
                $contratoHTML = '<table cellpadding="1.5mm" border="0">
                            <tr bgcolor="#E1E1E1">
                                <th style="width: 18.8cm; font-weight:bold">CONTRATO</th>
                            </tr>
                            <tr>
                                <td style="border-bottom: #EEE 1mm solid; width:1.5cm; font-weight:bold;">CARGO:</td>
                                <td style="border-bottom: #EEE 1mm solid; width:7.5cm;">'.$cargo.'</td>

                                <td style="border-bottom: #EEE 1mm solid; width:4.0cm; font-weight:bold;">NÚMERO DE CONTRATO:</td>
                                <td style="border-bottom: #EEE 1mm solid; width:5.8cm;">'.$contrato_numero.'</td>
                            </tr>
                            <tr>
                                <td style="border-bottom: #EEE 1mm solid; width:1.5cm; font-weight:bold;">INICIO:</td>
                                <td style="border-bottom: #EEE 1mm solid; width:2.0cm;">'.$contrato_inicio.'</td>

                                <td style="border-bottom: #EEE 1mm solid; width:2.5cm; font-weight:bold;">VENCIMIENTO:</td>
                                <td style="border-bottom: #EEE 1mm solid; width:3.0cm;">'.$contrato_fin.'</td>

                                <td style="border-bottom: #EEE 1mm solid; width:2.0cm; font-weight:bold;">DURACIÓN:</td>
                                <td style="border-bottom: #EEE 1mm solid; width:7.8cm;">'.$contrato_vence->duracion.'</td>
                            </tr>
                        </table>';

                $posI = $this->pdf->getY(); # OBTENGO LA POSICION INICIAL
                $this->pdf->writeHTML($contratoHTML,true,false,true,'');
                $posF = $this->pdf->getY(); # OBTENGO LA POSICION LUEGO DE IMPRIMIR

                $this->pdf->RoundedRect(8, $posI-2, 192, $posF-$posI, 1.50, '1111', ''); # RESTO LA POSICION FINAL MENOS LA INICIAL PARA EL ALTO DEL CUADRO



            if ($enviarcorreo == false)
                $this->pdf->Output("ficha.pdf", 'I');
            else
                return $this->pdf->Output("ficha.pdf", 'S');
        }

        public function relacion_clientes($directivo, $flagPdf = 1, $enviarcorreo = false){

            $medidas = "a4"; // a4 - carta
            $this->pdf = new pdfGeneral('P', 'mm', $medidas, true, 'UTF-8', false);
            $this->pdf->SetMargins(10, 55, 10); // Cada 10 es 1cm - Como es hoja estoy tratando las medidad en cm -> Rawil
            $this->pdf->SetTitle("RELACIÓN DE CLIENTES");
            $this->pdf->SetFont('freesans', '', 8);
            $this->pdf->setPrintHeader(true);

            $companiaInfo = $this->compania_model->obtener($this->compania);
            $establecimientoInfo = $this->emprestablecimiento_model->listar( $companiaInfo[0]->EMPRP_Codigo, '', $companiaInfo[0]->COMPP_Codigo );
            $empresaInfo =  $this->empresa_model->obtener_datosEmpresa( $establecimientoInfo[0]->EMPRP_Codigo );
            
            $tipoDocumento = "RELACIÓN DE<br>CLIENTES";
            $tipoDocumentoF = "RELACIÓN DE<br>CLIENTES";
            
            $this->pdf->settingHeaderData($empresaInfo[0]->EMPRC_Ruc, $tipoDocumento, "", NULL);

            $this->pdf->AddPage();
            $this->pdf->SetAutoPageBreak(true, 1);
            
            /* Listado de detalles */
                $listado = $this->directivo_model->relacion_clientes($directivo);
                $deta = "";
                $j = 1;
                foreach ($listado as $indice => $valor) {
                    $bgcolor = ( $indice % 2 == 0 ) ? "#FFFFFF" : "#F1F1F1";

                        $deta = $deta. '
                        <tr bgcolor="'.$bgcolor.'">
                            <td style="border-left: #cccccc 1mm solid; border-right: #cccccc 1mm solid; border-bottom:#cccccc 1mm solid; border-top:#cccccc 1mm solid; text-align:center;">'.$valor->CLIC_CodigoUsuario.'</td>
                            <td style="border-left: #cccccc 1mm solid; border-right: #cccccc 1mm solid; border-bottom:#cccccc 1mm solid; border-top:#cccccc 1mm solid; text-align:left;">'.$valor->nombre_cliente.$valor->razon_social.'</td>
                            <td style="border-left: #cccccc 1mm solid; border-right: #cccccc 1mm solid; border-bottom:#cccccc 1mm solid; border-top:#cccccc 1mm solid; text-align:center;">'.$valor->total_documentos.'</td>
                            <td style="border-left: #cccccc 1mm solid; border-right: #cccccc 1mm solid; border-bottom:#cccccc 1mm solid; border-top:#cccccc 1mm solid; text-align:left;">'.$valor->total_ventas.'</td>
                        </tr>';
                    $j++;
                }
                
            $detalleHTML = '<table style="font-size:7.5pt;" cellpadding="0.1cm" border="0">
                                <tr>
                                    <td style="width:2.5cm; font-style:normal; font-weight:bold;">VENDEDOR:</td>
                                    <td style="width:15cm; text-indent:0.1cm; text-align:justification">'.$listado[0]->PERSC_Nombre.' - '.$listado[0]->PERSC_ApellidoPaterno.' - '.$listado[0]->PERSC_ApellidoMaterno.'</td>
                                </tr>
                            </table>';

            $this->pdf->writeHTML($detalleHTML,true,false,true,'');

            $productoHTML = '
                    <table cellpadding="0.05cm">
                        <tr style="font-size:8pt;">
                            <th colspan="8" style="font-style:normal; font-weight:bold; text-align:left; border-bottom: 1px #000 solid;">LISTA DE CLIENTES</th>
                        </tr>
                        <tr bgcolor="#F1F1F1" style="font-size:7.5pt;">
                            <th style="border-left: #cccccc 1mm solid; border-right: #cccccc 1mm solid; border-bottom:#cccccc 1mm solid; border-top:#cccccc 1mm solid; font-style:normal; font-weight:bold; text-align:center; width:03.0cm;">ID CLIENTE</th>
                            
                            <th style="border-left: #cccccc 1mm solid; border-right: #cccccc 1mm solid; border-bottom:#cccccc 1mm solid; border-top:#cccccc 1mm solid; font-style:normal; font-weight:bold; text-align:center; width:10.0cm;">RUC/DNI - RAZÓN SOCIAL</th>
                            
                            <th style="border-left: #cccccc 1mm solid; border-right: #cccccc 1mm solid; border-bottom:#cccccc 1mm solid; border-top:#cccccc 1mm solid; font-style:normal; font-weight:bold; text-align:right; width:3.0cm;">CANTIDAD DOC.</th>
                            
                            <th style="border-left: #cccccc 1mm solid; border-right: #cccccc 1mm solid; border-bottom:#cccccc 1mm solid; border-top:#cccccc 1mm solid; font-style:normal; font-weight:bold; text-align:right; width:3.0cm;">TOTAL VENTAS</th>
                        </tr>
                        '.$deta.'
                    </table>';
            $this->pdf->writeHTML($productoHTML,true,false,true,'');
                        
            $nameFile = "Clientes por vendedor.pdf";

            if ($enviarcorreo == false)
                $this->pdf->Output($nameFile, 'I');
            else
                return $this->pdf->Output($nameFile, 'S');
        }


    ###########################
    ###### FUNCTIONS OLDS
    ###########################

        public function directivos_old($j = 0) {
            $data['codigo'] = "";
            $data['numdoc'] = "";
            $data['personacod'] = "";
            $data['nombre'] = "";
            $data['cargo'] = "";
            $data['fecini'] = "";
            $data['fecfin'] = "";
            $data['contrato'] = "";
            $data['titulo_tabla'] = "RELACIÓN DE EMPLEADOS";
            $data['registros'] = count($this->directivo_model->lista_vendedores2());
            $data['action'] = base_url() . "index.php/maestros/directivo/buscar_directivos";
            $conf['base_url'] = site_url('maestros/directivo/directivos/');
            $conf['total_rows'] = $data['registros'];
            $conf['per_page'] = 50;
            $conf['num_links'] = 3;
            $conf['next_link'] = "&gt;";
            $conf['prev_link'] = "&lt;";
            $conf['first_link'] = "&lt;&lt;";
            $conf['last_link'] = "&gt;&gt;";
            $conf['uri_segment'] = 4;
            $data['cbo_empresa'] = $this->seleccionar_empresa("1");
            $this->pagination->initialize($conf);
            $data['paginacion'] = $this->pagination->create_links();
            $listado_directivos = $this->directivo_model->lista_vendedores2();
            $item = $j + 1;
            $lista = array();
            if (count($listado_directivos) > 0) {
                foreach ($listado_directivos as $indice => $valor) {
                    $codigo = $valor->DIREP_Codigo;
                    $numdoc = $valor->dni;
                    $nombres = $valor->nombre . " " . $valor->paterno . " " . $valor->materno;
                    $empresa = $valor->empresa;//empresa
                    $cargo = $valor->cargo;
                    $inicio = mysql_to_human($valor->Inicio);
                    $fin = mysql_to_human($valor->Fin);
                    $contrato = $valor->Nro_Contrato;
                    $editar = "<a href='javascript:;' onclick='editar_directivo(" . $codigo . ")'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                    $ver = "<a href='javascript:;' onclick='ver_directivo(" . $codigo . ")'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Ver'></a>";
                    $eliminar = ""; #"<a href='javascript:;' onclick='eliminar_directivo(" . $codigo . ")'><img src='" . base_url() . "images/eliminar.png' width='16' height='16' border='0' title='Eliminar'></a>";
                    $relacion_clientes = "<a href='javascript:;' onclick='clientes_directivo($codigo)'><img src='" . base_url() . "images/pdf.png' width='16' height='16' border='0' title='Eliminar'></a>";
                    $lista[] = array($item, $numdoc, $nombres, $empresa, $cargo, $contrato, $inicio, $fin, $editar, $ver, $eliminar, $relacion_clientes, $valor->DIREC_CodigoEmpleado);
                    $item++;
                }
            }
            $data['lista'] = $lista;
            $this->layout->view("maestros/directivo_index", $data);
        }

        public function buscar_directivos($j = '0') {
            $numdoc = $this->input->post('txtNumDoc');
            $nombre = $this->input->post('txtNombre');
            $codigoEmpleado = $this->input->post('txtCodigoEmpleado');
           
            $empresa = $this->input->post('cboCompania');
            $filter = new stdClass();
            $filter->numdoc = $numdoc;
            $filter->nombre = $nombre;
            $filter->empresa = $empresa;
            $filter->codigoEmpleado = $codigoEmpleado;

            $data['numdoc'] = $numdoc;
            $data['nombre'] = $nombre;
            $data['cbo_empresa'] = $this->seleccionar_empresa($empresa);
            $data['titulo_tabla'] = "RESULTADO DE BÚSQUEDA DE EMPLEADOS";

            $data['registros'] = count($this->directivo_model->buscar_directivo2($filter));
            $data['action'] = base_url() . "index.php/maestros/directivo/buscar_directivos";
            $conf['base_url'] = site_url('maestros/directivo/buscar_directivos/');
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
            $listado_directivos = $this->directivo_model->buscar_directivo2($filter, $conf['per_page'], $j);
            $item = $j + 1;
            $lista = array();
            if (count($listado_directivos) > 0) {
                foreach ($listado_directivos as $indice => $valor) {
                    $codigo = $valor->DIREP_Codigo;
                    $numdoc = $valor->dni;
                    $nombres = $valor->nombre . " " . $valor->paterno . " " . $valor->materno;
                    $empresa = $valor->empresa;
                    $cargo = $valor->cargo;
                    $inicio = $valor->Inicio;
                    $fin = $valor->Fin;
                    $contrato = $valor->Nro_Contrato;
                    $editar = "<a href='#' onclick='editar_directivo(" . $codigo . ")'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                    $ver = "<a href='#' onclick='ver_directivo(" . $codigo . ")'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                    $eliminar = ""; #"<a href='#' onclick='eliminar_directivo(" . $codigo . ")'><img src='" . base_url() . "images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                    $relacion_clientes = "<a href='javascript:;' onclick='clientes_directivo($codigo)'><img src='" . base_url() . "images/pdf.png' width='16' height='16' border='0' title='Eliminar'></a>";
                    $lista[] = array($item, $numdoc, $nombres, $empresa, $cargo, $contrato, $inicio, $fin, $editar, $ver, $eliminar, $relacion_clientes, $valor->DIREC_CodigoEmpleado);
                    $item++;
                }
            }
            $data['lista'] = $lista;
            $this->layout->view("maestros/directivo_index", $data);
        }

        public function nuevo_directivo() {
            $data['cbo_cargo'] = $this->seleccionar_cargo();
            $data['cbo_categoria'] = $this->seleccionar_categoria();
            $data['cbo_empresa'] = $this->seleccionar_empresa("1");
            //$data['cbo_Cargo']              = $this->OPTION_generador($this->cargo_model->listar_cargos(), 'CARGP_Codigo', 'CARGC_Descripcion', ''); //12: Al contado
            $data['cbo_dpto'] = $this->seleccionar_departamento('15');
            $data['cbo_prov'] = $this->seleccionar_provincia('15', '01');
            $data['cbo_dist'] = $this->seleccionar_distritos('15', '01');
            $data['cbo_estadoCivil'] = $this->seleccionar_estadoCivil('');
            $data['cbo_nacionalidad'] = $this->seleccionar_nacionalidad('193');
            $data['cbo_nacimiento'] = $this->seleccionar_distritos('15', '01', '01');
            $data['cbo_sectorComercial'] = $this->OPTION_generador($this->sectorcomercial_model->listar(), 'SECCOMP_Codigo', 'SECCOMC_Descripcion', '');
            $data['cboFormaPago'] = $this->OPTION_generador($this->formapago_model->listar(), 'FORPAP_Codigo', 'FORPAC_Descripcion', ''); //12: Al contado
            $data['tipocodigo'] = $this->seleccionar_tipocodigo('1');
            $data['display'] = "";
            $data['display_datosEmpresa'] = "display:none;";
            $data['display_datosDirectivo'] = "";
            $data['nombres'] = "";
            $data['paterno'] = "";
            $data['materno'] = "";
            $data['fecnac'] = "";
            $data['imagen'] = "";
            $data['numero_documento'] = "";
            $data['personacod'] = "";
            $data['ruc'] = "";
            $data['sexo'] = "";
            $data['tipo_documento'] = $this->seleccionar_tipodocumento('1');
            $data['tipo_persona'] = "0";
            $data['id'] = "";
            $data['modo'] = "insertar";
            $data['fecini'] = mysql_to_human(mdate("%Y-%m-%d ", time()));
            $data['fecfin'] = mysql_to_human(mdate("%Y-%m-%d ", time()));
            $data['contrato'] = "";
            $objeto = new stdClass();
            $objeto->id = "";
            $objeto->personacod = "";
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
            $data['titulo'] = "REGISTRAR EMPLEADO";
            $data['listado_empresaSucursal'] = array();
            $data['listado_empresaContactos'] = array();
            $data['cboNacimiento'] = "000000";
            $data['cboNacimientovalue'] = "";
            $this->load->view("maestros/directivo_nuevo", $data);
        }

        public function insertar_directivo() {
            if ($this->input->post('tipo_persona') == '0') {
                if ($this->input->post('tipo_documento') == '1' && $this->input->post('numero_documento') != '' && strlen($this->input->post('numero_documento')) != 8)
                    exit('{"result":"error", "campo":"numero_documento", "msg": "Valor inválido"}');
                if ($this->input->post('nombres') == '')
                    exit('{"result":"error", "campo":"nombres"}');
                if ($this->input->post('paterno') == '')
                    exit('{"result":"error", "campo":"paterno"}');
                if ($this->input->post('cboEstadoCivil') == '0')
                    exit('{"result":"error", "campo":"cboEstadoCivil"}');
            }else {
                if ($this->input->post('ruc') == '')
                    exit('{"result":"error", "campo":"ruc"}');
                if ($this->input->post('cboTipoCodigo') == '1' && $this->input->post('ruc') != '' && strlen($this->input->post('ruc')) != 11)
                    exit('{"result":"error", "campo":"ruc", "msg": "Valor inválido"}');
                if ($this->input->post('razon_social') == '')
                    exit('{"result":"error","campo":"razon_social"}');
            }

            $nombre_sucursal = array();
            $nombre_contacto = array();
            $personacod = $this->input->post('personacod');
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
            $categoria = $this->input->post('categoria');
            $sector_comercial = $this->input->post('sector_comercial');
            $forma_pago = $this->input->post('forma_pago');
            $ctactesoles = $this->input->post('ctactesoles');
            $ctactedolares = $this->input->post('ctactedolares');
            $ubigeo_domicilio = $departamento . $provincia . $distrito;

            //Datos exclusivos de la persona
            $nombres = $this->input->post('nombres');
            $paterno = $this->input->post('paterno');
            $materno = $this->input->post('materno');
            $tipo_documento = $this->input->post('tipo_documento');
            $numero_documento = $this->input->post('numero_documento');
            $fechanac = $this->input->post('fechanac');
            $ubigeo_nacimiento = $this->input->post('cboNacimiento') == '' ? '000000' : $this->input->post('cboNacimiento');
            $sexo = $this->input->post('cboSexo');
            $estado_civil = $this->input->post('cboEstadoCivil');
            $nacionalidad = $this->input->post('cboNacionalidad');
            $ruc_persona = $this->input->post('ruc_persona');

            //DIRECTIVO DATOS
            $finicio = human_to_mysql($this->input->post('fechai'));
            $ffin = human_to_mysql($this->input->post('fechaf'));
            $cargo = $this->input->post('cboCargo');
            $categoriaCliente = $this->input->post('cboCategoria');
            //$empresad = $this->input->post('cboEmpresa');
            $contrato = $this->input->post('contrato');
            $compania = $this->input->post('empresa_persona');
            $idCompania = $this->input->post('idCompania');

            $idempresa = $this->directivo_model->obtener_empresa($idCompania);
            $empresad = $idempresa[0]->EMPRP_Codigo;
            //var_dump($idempresa[0]->EMPRP_Codigo);
            //echo "<br/>";
            // var_dump($idCompania);
            // exit();
            /* Array de variables */
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

            if ($arrayDpto != '' && $arrayProv != '' && $arrayDist != '') {
                $ubigeo_sucursal = $this->html->array_ubigeo($arrayDpto, $arrayProv, $arrayDist);
            }

            $config['upload_path'] = 'images/';
            $config['allowed_types'] = 'jpg|gif|png';
            $config['max_size'] = '5120';
            $config['max_width'] = '0';
            $config['max_height'] = '0';

            $imagen = $this->input->post('foto');
            $this->load->library('upload', $config);
            //print_r($_FILES);
            if (!$this->upload->do_upload('foto')) {
                $error = '';
                $imagen = "";
            } else {

                $data1 = $this->upload->data();

                $imagen = $data1['file_name'];
            }
            if ($tipo_persona == 0) {//Persona                
                $empresa = 0;
                if ($personacod != '' && $personacod != '0') {
                    $persona = $personacod;
                    $this->persona_model->modificar_datosPersona($persona, $ubigeo_nacimiento, $ubigeo_domicilio, $estado_civil, $nacionalidad, $nombres, $paterno, $materno, $ruc_persona, $tipo_documento, $numero_documento, $direccion, $telefono, $movil, $email, $direccion, $sexo, $fax, $web, $fechanac);
                    //$this->persona_model->modificar_datosPersona($persona,$ubigeo_nacimiento,$ubigeo_domicilio,$estado_civil,$nacionalidad,$nombres,$paterno,$materno,$ruc_persona,$tipo_documento,$numero_documento,$direccion,$telefono,$movil,$email,$domicilio,$sexo,$fax,$web);
                } else {
                    //echo "Entro ok";
                    //var_dump($fechanac);
                    $persona = $this->persona_model->insertar_datosPersona($ubigeo_nacimiento, $ubigeo_domicilio, $estado_civil, $nacionalidad, $nombres, $paterno, $materno, $ruc_persona, $tipo_documento, $numero_documento, $direccion, $telefono, $movil, $email, $direccion, $sexo, $fax, $web, $fechanac);
                    //$persona = $this->persona_model->insertar_datosPersona($ubigeo_nacimiento,$ubigeo_domicilio,$estado_civil,$nacionalidad,$nombres,$paterno,$materno,$ruc_persona,$tipo_documento,$numero_documento,$direccion,$telefono,$movil,$email,$direccion,$sexo,$web,$ctactesoles,$ctactedolares);                    
                }
                //exit();
                //$cliente=$this->directivo_model->insertar_datosDirectivo($empresa,$persona,$tipo_persona, $categoria, $forma_pago);
                $directivo = $this->directivo_model->insertar_datosDirectivo( $empresad, $persona, $finicio, $ffin, $cargo, $contrato, $imagen, $categoriaCliente, $this->generateCodeDirectivo() );
            }

            $this->directivos();
        }

        //A_Editar
        public function editar_directivo($id) {
            $data['id'] = $id;
            $data['modo'] = "modificar";
            $datos = $this->directivo_model->obtener_directivo($id);
            $tipo_persona = "0"; //$datos[0]->CLIC_TipoPersona;
            $persona = $datos[0]->PERSP_Codigo;
            $data['personacod'] = $datos[0]->PERSP_Codigo;
            $data['fecini'] = mysql_to_human($datos[0]->DIREC_FechaInicio);
            $data['fecfin'] = mysql_to_human($datos[0]->DIREC_FechaFin);
            $data['cbo_cargo'] = $this->seleccionar_cargo($datos[0]->CARGP_Codigo);
            $data['cbo_categoria'] = $this->seleccionar_categoria($datos[0]->TIPCLIP_Codigo);
            $data['cbo_empresa'] = $this->seleccionar_empresa($datos[0]->EMPRP_Codigo);
            $data['contrato'] = $datos[0]->DIREC_NroContrato;
            $data['imagen'] = $datos[0]->DIREC_Imagen;
            //var_dump((array)$datos[0]->DIREC_Imagen);
            $data['modo'] = "modificar";
            $data['display'] = "style='display: none'";
            $data['tipo_persona'] = $tipo_persona;

            //$data['cbo_categoria'] = $this->seleccionar_categoria($datos[0]->TIPCLIP_Codigo);
            //$data['cboFormaPago']  = $this->OPTION_generador($this->formapago_model->listar(), 'FORPAP_Codigo', 'FORPAC_Descripcion', $datos[0]->FORPAP_Codigo);
            if ($tipo_persona == 0) {//Persona
                $datos_persona = $this->persona_model->obtener_datosPersona($persona);
                $ubigeo_domicilio = $datos_persona[0]->UBIGP_Domicilio;
                $ubigeo_nacimiento = $datos_persona[0]->UBIGP_LugarNacimiento;
                $nacionalidad = $datos_persona[0]->NACP_Nacionalidad;
                $estado_civil = $datos_persona[0]->ESTCP_EstadoCivil;
                $fec_nac = $datos_persona[0]->PERSC_FechaNac;
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
                $data['fecnac'] = $fec_nac;
                $data['ruc'] = $datos_persona[0]->PERSC_Ruc;
                $data['sexo'] = $datos_persona[0]->PERSC_Sexo;
                $data['cbo_estadoCivil'] = $this->seleccionar_estadoCivil($estado_civil);
                $data['cbo_nacionalidad'] = $this->seleccionar_nacionalidad($nacionalidad);
                $data['fecnac'] = $datos_persona[0]->PERSC_FechaNac;
                //var_dump((array)$datos_persona[0]->PERSC_FechaNac);
                $data['cboNacimiento'] = $ubigeo_nacimiento;
                $nombre_persona = $datos_persona[0]->PERSC_ApellidoPaterno . " " . $datos_persona[0]->PERSC_ApellidoMaterno . " " . $datos_persona[0]->PERSC_Nombre;
                $datos_nacimiento = $this->ubigeo_model->obtener_ubigeo($ubigeo_nacimiento);
                $data['cboNacimientovalue'] = $ubigeo_nacimiento == '000000' ? '' : $datos_nacimiento[0]->UBIGC_Descripcion;
                $data['cbo_dpto'] = $this->seleccionar_departamento($dpto_domicilio);
                $data['cbo_prov'] = $this->seleccionar_provincia($dpto_domicilio, $prov_domicilio);
                $data['cbo_dist'] = $this->seleccionar_distritos($dpto_domicilio, $prov_domicilio, $dist_domicilio);
                $data['direccion'] = $datos_persona[0]->PERSC_Direccion;

                /* Mejorar esto */
                $objeto = new stdClass();
                $objeto->id = $datos_persona[0]->PERSP_Codigo;
                $objeto->personacod = $data['personacod'];
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
                $objeto->tipo = "0";
                $objeto->fecini = $data['fecini'];
                $objeto->fecfin = $data['fecfin'];
                $objeto->cargo = $data['cbo_cargo'];
                $objeto->contrato = $data['contrato'];
                $data['datos'] = $objeto;
                /**/
                $data['display_datosEmpresa'] = "display:none;";
                $data['display_datosDirectivo'] = "";
                $data['titulo'] = "EDITAR EMPLEADO ::: " . $nombre_persona;
            }
            $this->load->view("maestros/directivo_nuevo", $data);
        }

        public function modificar_directivo() {

            $directivo = $this->input->post('id');

            //$empresa = $this->input->post('cboCompania');
            $personacod = $this->input->post('personacod');
            $cargo = $this->input->post('cboCargo');
            $fecini = human_to_mysql($this->input->post('fechai'));
            $fecfin = human_to_mysql($this->input->post('fechaf'));
            $contrato = $this->input->post('contrato');

            //INICIO

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
            $categoria = $this->input->post('categoria');
            $sector_comercial = $this->input->post('sector_comercial');
            $forma_pago = $this->input->post('forma_pago');
            $ctactesoles = $this->input->post('ctactesoles');
            $ctactedolares = $this->input->post('ctactedolares');
            $ubigeo_domicilio = $departamento . $provincia . $distrito;
            
            $idCompania = $this->input->post('idCompania');
            $idempresa = $this->directivo_model->obtener_empresa($idCompania);
            $empresa = $idempresa[0]->EMPRP_Codigo;
            
            //Datos exclusivos de la persona
            $nombres = $this->input->post('nombres');
            $paterno = $this->input->post('paterno');
            $materno = $this->input->post('materno');
            $tipo_documento = $this->input->post('tipo_documento');
            $numero_documento = $this->input->post('numero_documento');
            $ubigeo_nacimiento = $this->input->post('cboNacimiento') == '' ? '000000' : $this->input->post('cboNacimiento');
            $sexo = $this->input->post('cboSexo');
            $estado_civil = $this->input->post('cboEstadoCivil');
            $nacionalidad = $this->input->post('cboNacionalidad');
            $ruc_persona = $this->input->post('ruc_persona');
            $fecnac = $this->input->post('fechanac');
            //var_dump($fecnac);
            //DIRECTIVO DATOS
            $finicio = human_to_mysql($this->input->post('fechai'));
            $ffin = human_to_mysql($this->input->post('fechaf'));
            $cargo = $this->input->post('cboCargo');
            $categoriaCliente = $this->input->post('cboCategoria');
            //$empresad = $this->input->post('cboEmpresa');
            $contrato = $this->input->post('contrato');

            //FIN
            $config['upload_path'] = 'images/';
            $config['allowed_types'] = 'jpg|gif|png';
            $config['max_size'] = '5120';
            $config['max_width'] = '0';
            $config['max_height'] = '0';


            $imagen = $this->input->post('foto');

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('foto')) {
                $error = '';
                $imagen = "";
            } else {


                $data1 = $this->upload->data();

                $imagen = $data1['file_name'];
            }
            
            if ($tipo_persona == 0) {//Persona
                if ($personacod != '' && $personacod != '0') {
                    $persona = $personacod;
                    $this->persona_model->modificar_datosPersona($persona, $ubigeo_nacimiento, $ubigeo_domicilio, $estado_civil, $nacionalidad, $nombres, $paterno, $materno, $ruc_persona, $tipo_documento, $numero_documento, $direccion, $telefono, $movil, $email, $direccion, $sexo, $fax, $web, $fecnac);
                } else {
                    $persona = $this->persona_model->insertar_datosPersona($ubigeo_nacimiento, $ubigeo_domicilio, $estado_civil, $nacionalidad, $nombres, $paterno, $materno, $ruc_persona, $tipo_documento, $numero_documento, $direccion, $telefono, $movil, $email, $direccion, $sexo, $web, $fecnac);
                }
                $this->directivo_model->modificar_datosDirectivo($directivo, $empresa, $personacod, $cargo, $fecini, $fecfin, $contrato, $imagen, $categoriaCliente);
            }

            $this->directivos();
        }

        //A_Ver_directivo
        public function ver_directivo($directivo) {
            $datosD = $this->directivo_model->obtener_directivo($directivo);
            $persona = $datosD[0]->PERSP_Codigo;
            $data['personacod'] = $datosD[0]->PERSP_Codigo;
            $data['fecini'] = mysql_to_human($datosD[0]->DIREC_FechaInicio);
            $data['fecfin'] = mysql_to_human($datosD[0]->DIREC_FechaFin);

            $datosC = $this->cargo_model->obtener_cargo($datosD[0]->CARGP_Codigo);
            $data['cbo_cargo'] = $datosC[0]->CARGC_Descripcion;
            $datosE = $this->empresa_model->obtener_datosEmpresa($datosD[0]->EMPRP_Codigo);
            $data['cbo_empresa'] = $datosE[0]->EMPRC_RazonSocial;
            $data['contrato'] = $datosD[0]->DIREC_NroContrato;

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

            $data['datos'] = $datos;
            $data['titulo'] = "VER EMPLEADO";

            $this->load->view('maestros/directivo_ver', $data);
        }

        public function eliminar_directivo() {
            $directivo = $this->input->post('directivo');
            $this->directivo_model->eliminar_directivo($directivo);
        }

        public function seleccionar_cargo($indDefault = '') {
            $array_dist = $this->cargo_model->listar_cargos();

            $arreglo = array();
            if (count($array_dist) > 0) {
                foreach ($array_dist as $indice => $valor) {
                    $indice1 = $valor->CARGP_Codigo;
                    $valor1 = $valor->CARGC_Descripcion;
                    $arreglo[$indice1] = $valor1;
                }
            }
            $resultado = $this->html->optionHTML($arreglo, $indDefault, array('0', '::Seleccione::'));
            return $resultado;
        }

        public function seleccionar_categoria($indDefault = '') {
            $array_dist = $this->tipocliente_model->listar();
            $arreglo = array();
            if (count($array_dist) > 0) {
                foreach ($array_dist as $indice => $valor) {
                    $indice1 = $valor->TIPCLIP_Codigo;
                    $valor1 = $valor->TIPCLIC_Descripcion;
                    $arreglo[$indice1] = $valor1;
                }
            }
            $resultado = $this->html->optionHTML($arreglo, $indDefault, array('0', '::Seleccione::'));
            return $resultado;
        }

        public function seleccionar_empresa($indDefault = '') {
            $array_dist = $this->empresa_model->listar_empresas();

            $arreglo = array();
            if (count($array_dist) > 0) {
                foreach ($array_dist as $indice => $valor) {
                    $indice1 = $valor->EMPRP_Codigo;
                    $valor1 = $valor->EMPRC_RazonSocial;
                    $arreglo[$indice1] = $valor1;
                }
            }
            $resultado = $this->html->optionHTML($arreglo, $indDefault, array('0', '::Seleccione::'));
            return $resultado;
        }

        public function seleccionar_departamento($indDefault = '') {
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

        public function seleccionar_provincia($departamento, $indDefault = '') {
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

        public function seleccionar_distritos($departamento, $provincia, $indDefault = '') {
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

        public function seleccionar_estadoCivil($indSel) {
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

        public function seleccionar_nacionalidad($indSel = '') {
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

        public function seleccionar_tipodocumento($indDefault = '') {
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

        public function seleccionar_tipocodigo($indDefault = '') {
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

        public function JSON_buscar_directivo($numdoc) {
            $datos_empresa = $this->empresa_model->obtener_datosEmpresa2($numdoc);
            $datos_persona = $this->persona_model->obtener_datosPersona2($numdoc);
            $resultado = '[{"CLIP_Codigo":"0","EMPRC_Ruc":"","EMPRC_RazonSocial":""}]';
            if (count($datos_empresa) > 0) {
                $empresa = $datos_empresa[0]->EMPRP_Codigo;
                $razon_social = $datos_empresa[0]->EMPRC_RazonSocial;
                $datosCliente = $this->cliente_model->obtener_datosCliente2($empresa);
                if (count($datosCliente) > 0) {
                    $cliente = $datosCliente[0]->CLIP_Codigo;
                    $resultado = '[{"CLIP_Codigo":"' . $cliente . '","EMPRC_Ruc":"' . $numdoc . '","EMPRC_RazonSocial":"' . $razon_social . '"}]';
                }
            } elseif (count($datos_persona) > 0) {
                $persona = $datos_persona[0]->PERSP_Codigo;
                $nombres = $datos_persona[0]->PERSC_Nombre . " " . $datos_persona[0]->PERSC_ApellidoPaterno . " " . $datos_persona[0]->PERSC_ApellidoMaterno;
                $datosCliente = $this->cliente_model->obtener_datosCliente3($persona);
                if (count($datosCliente) > 0) {
                    $cliente = $datosCliente[0]->CLIP_Codigo;
                    $resultado = '[{"CLIP_Codigo":"' . $cliente . '","EMPRC_Ruc":"' . $numdoc . '","EMPRC_RazonSocial":"' . $nombres . '"}]';
                }
            }
            echo $resultado;
        }

        public function registro_directivo_pdf($documento='', $nombre='', $empresa='')
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

                

            $this->cezpdf->ezText('', '', array("leading" => 35));
            $this->cezpdf->ezText('<b>RELACION DE EMPLEADOS</b>', 14, array("leading" => 0, 'left' => 185));
            $this->cezpdf->ezText('', '', array("leading" => 10));


            /* Datos del cliente */

            $db_data = array();


            $listado_productos = $this->directivo_model->listar_directivo_pdf($documento,$nombre,$empresa);
        
                if (count($listado_productos) > 0) {
                    foreach ($listado_productos as $indice => $valor) {
                        $dni = $valor->dni;
                        $nombre = $valor->nombre." ".$valor->paterno." ".$valor->materno;
                        $empresa = $valor->empresa;
                        $cargo = $valor->cargo;
                        $inicio = $valor->Inicio;
                        $fin = $valor->Fin;
                        $contrato = $valor->Nro_Contrato;


                        $db_data[] = array(
                            'cols1' => $indice + 1,
                            'cols2' => $dni,
                            'cols3' => $nombre,
                            'cols4' => $empresa,
                            'cols5' => $cargo,
                            'cols6' => $contrato,
                            'cols7' => $fin,
                            'cols8' => $inicio,
                        );
                    }
                }

            


            $col_names = array(
                'cols1' => '<b>ITEM</b>',
                'cols2' => '<b>DNI</b>',
                'cols3' => '<b>NOMBRE</b>',
                'cols4' => '<b>EMPRESA</b>',
                'cols5' => '<b>CARGO</b>',
                'cols6' => '<b>CONTRATO</b>',
                'cols7' => '<b>INICIO</b>',
                'cols8' => '<b>FIN</b>'
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
                    'cols2' => array('width' => 50, 'justification' => 'center'),
                    'cols3' => array('width' => 120, 'justification' => 'center'),
                    'cols4' => array('width' => 100, 'justification' => 'center'),
                    'cols5' => array('width' => 70, 'justification' => 'center'),
                    'cols6' => array('width' => 60, 'justification' => 'center'),
                    'cols7' => array('width' => 60, 'justification' => 'center'), 
                    'cols8' => array('width' => 60, 'justification' => 'center')
                )
            ));


            $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => $codificacion . '.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

            ob_end_clean();

            $this->cezpdf->ezStream($cabecera);
        }

        public function generateCodeDirectivo(){
            $code = $this->directivo_model->getCodeDirectivo();
            $inicial = substr($_SESSION["nombre_empresa"],0,3);
            $code = ($code == NULL || $code == '') ? "$inicial-0" : $code;
            
            $codeString = substr($code, 0, 4);
            $codeInt = substr($code, 4);

            $codeInt++;
            $nvoCode = $codeString . $this->lib_props->getNumberFormat($codeInt,3);

            return $nvoCode;
        }

}
?>