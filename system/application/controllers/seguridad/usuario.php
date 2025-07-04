<?php

class Usuario extends Controller{

    private $empresa;
    private $compania;
    private $rol;
    private $url;

    public function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('html');
        $this->load->library('tokens');
        $this->load->model('almacen/guiatrans_model');
        $this->load->model('almacen/guiain_model');
        $this->load->model('almacen/guiarem_model');
        $this->load->model('maestros/persona_model');
        $this->load->model('ventas/comprobante_model');
        $this->load->model('ventas/notacredito_model');
        $this->load->model('seguridad/usuario_model');
        $this->load->model('seguridad/usuario_compania_model');
        $this->load->model('maestros/emprestablecimiento_model');
        $this->load->model('maestros/compania_model');
        $this->load->model('maestros/directivo_model');
        $this->load->model('seguridad/rol_model');
        

        $this->empresa = $this->session->userdata('empresa');
        $this->compania = $this->session->userdata('compania');
        $this->rol = $this->session->userdata('rol');
        $this->url = base_url();
    }

    public function index(){
        $this->layout->view('seguridad/inicio');
    }

    ########################
    ##### FUNCTIONS NEWS
    ########################

        public function usuarios($j = '0'){
            $data['txtNombres'] = "";
            $data['txtUsuario'] = "";
            $data['txtRol'] = "";
            $data['registros'] = count($this->usuario_model->listar_usuarios());
            $conf['base_url'] = base_url();
            $data['titulo_busqueda'] = "BUSCAR USUARIO";
            $data['titulo'] = "RELACIÓN DE USUARIOS";

            $data['directivos'] = $this->directivo_model->listar_combodirectivo($this->empresa);
            
            $data['roles'] = $this->rol_model->listar_roles(true);# true: si se comparten los roles entre empresas | false:no se comparten
            
            $data['establecimientos'] = $this->usuario_model->getEstablecimientos();
            $this->layout->view('seguridad/usuario_index', $data);
        }

        public function datatable_usuarios(){
            $columnas = array(
                                0 => "nombres",
                                1 => "USUA_usuario",
                                2 => "ROL_Descripcion"
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

            $filter->searchNombre = $this->input->post("txtNombres");
            $filter->searchUsuario = $this->input->post("txtUsuario");
            $filter->searchRol = $this->input->post("txtRol");

            $listado = $this->usuario_model->getUsuariosDatatable($filter);
            $lista = array();
            
            if ( count($listado) > 0 ){
                foreach ($listado as $indice => $valor){

                    $btn_editar = "<button type='button' onclick='editar_usuario($valor->PERSP_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/modificar.png' class='image-size-1b'>
                                </button>";

                    $btn_view = "<button type='button' onclick='ver_usuario($valor->USUA_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/icono-documentos.png' class='image-size-1b'>
                                </button>";

                    $btn_eliminar = "<button type='button' onclick='deshabilitar($valor->USUA_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/documento-delete.png' class='image-size-1b'>
                                </button>";
                    $eliminar_personal = ($valor->USUA_Codigo==1) ? "" : $btn_eliminar;            
                    $lista[] = array(
                        0 => $valor->nombres,
                        1 => $valor->USUA_usuario,
                        2 => $valor->ROL_Descripcion,
                        3 => $btn_editar,
                        4 => $btn_view,
                        5 => $eliminar_personal
                    );
                }
            }

            unset($filter->start);
            unset($filter->length);

            $json = array(
                                "draw"            => intval( $this->input->post('draw') ),
                                "recordsTotal"    => intval( count($this->usuario_model->getUsuariosDatatable()) ),
                                "recordsFiltered" => intval( count($this->usuario_model->getUsuariosDatatable($filter)) ),
                                "data"            => $lista
                        );

            echo json_encode($json);
        }

        public function guardar_registro(){

            $usuario        = $this->input->post("usuario");
            $persona        = $this->input->post("persona");
            $nombre_usuario = $this->input->post("txtUsuario");
            $clave          = $this->input->post("txtClave");
            $clave2         = $this->input->post("txtClave2");
            $msj            = "";

            if ($clave == $clave2){       
                $establecimientos   = $this->input->post("establecimientos");
                $rol                = $this->input->post("rol");
                $acceso             = $this->input->post("acceso");

                #### INFORMACIÓN DEL USUARIO
                $filterUsuario                  = new stdClass();
                $filterUsuario->PERSP_Codigo    = $persona;
                $filterUsuario->ROL_Codigo      = "0";
                $filterUsuario->USUA_usuario    = $nombre_usuario;
                
                if ($clave != "")
                    $filterUsuario->USUA_Password = md5($clave);
                
                $filterUsuario->USUA_FechaRegistro = date("Y-m-d H:i:s");
                $filterUsuario->USUA_FlagEstado = 1;
                $filterUsuario->EMPRP_Codigo = $this->empresa;

                # ACTUALIZO LOS DATOS DEL USUARIO ELSE REGISTRO UN NUEVO USUARIO
                if ($usuario != ""){
                    $filterUsuario->USUA_Codigo = $usuario;
                    $updated = $this->usuario_model->actualizar_usuario($usuario, $filterUsuario);
                }
                else
                    $usuario = $this->usuario_model->registrar_usuario($filterUsuario);

                if ($usuario != NULL){
                    ### ASIGNAR ESTABLECIMIENTOS
                    $size = count($establecimientos);
                    # PRIMERO ELIMINO TODOS LOS ACCESOS DEL USUARIO
                    $this->usuario_compania_model->clean_acceso_usuario($usuario);
                    # AHORA REGISTRO LOS NUEVOS
                    if ($establecimientos != "" && $size > 0){
                        $default = true;
                        for ( $i=0; $i < $size; $i++ ){
                            if ($acceso[$i] == 1){
                                $filterUsuarioCompania = new stdClass();
                                $filterUsuarioCompania->USUA_Codigo     = $usuario;
                                $filterUsuarioCompania->COMPP_Codigo    = $establecimientos[$i];
                                $filterUsuarioCompania->ROL_Codigo      = $rol[$i];
                                $filterUsuarioCompania->CARGP_Codigo    = "1";
                                $filterUsuarioCompania->USUCOMC_Default = ($default == true) ? 1 : 0;
                                
                                $this->usuario_compania_model->registrar_acceso_usuario($filterUsuarioCompania);
                                $default = false;
                            }
                        }
                    }
                    $result = "success";
                }
                else
                    $result = "error";
            }
            else{
                $result = "error";
                $msj = "LAS CONTRASEÑAS NO COINCIDEN";
            }

            $json = array("result" => $result, "mensaje" => $msj);
            echo json_encode($json);
        }

        public function deshabilitar_usuario(){
            $usuario = $this->input->post('usuario');
            $result = $this->usuario_model->deshabilitar_usuario($usuario);

            if ($result)
                $json = array("result" => "success");
            else
                $json = array("result" => "error");
            
            echo json_encode($json);
        }

        public function getUsuario(){
            $usuario = $this->input->post('usuario');

            $data = $this->usuario_model->getUsuario($usuario);
            
            if ($data != NULL){

                $acceso = $this->usuario_model->getAccesoUsuario($data[0]->USUA_Codigo);

                $access = array();
                if ($acceso != NULL){
                    foreach ($acceso as $i => $val){
                        $access[$i]["empresa"] = $val->EMPRC_RazonSocial;
                        $access[$i]["establecimiento"] = $val->EESTABC_Descripcion;
                        $access[$i]["rol"] = $val->ROL_Descripcion;
                    }
                }

                $info = array(
                                "usuario" => $data[0]->USUA_Codigo,
                                "nombre_usuario" => $data[0]->USUA_usuario,
                                
                                "nombres" => $data[0]->PERSC_Nombre,
                                "apellido_paterno" => $data[0]->PERSC_ApellidoPaterno,
                                "apellido_materno" => $data[0]->PERSC_ApellidoMaterno,
                                
                                "acceso" => $access
                            );
            }
            else
                $info = NULL;

            if ($info != NULL)
                $json = array("match" => true, "info" => $info);
            else
                $json = array("match" => false, "info" => NULL);

            echo json_encode($json);
        }

        public function getPersonaUsuario(){
            $persona = $this->input->post('persona');

            $data = $this->usuario_model->getPersonaUsuario($persona);
            
            if ( $data[0]->USUA_usuario != NULL && $data[0]->USUA_usuario != ""){
                $nombre_usuario = $data[0]->USUA_usuario;
                $acceso = $this->usuario_model->getAccesoUsuario($data[0]->USUA_Codigo);
            }
            else{
                if ($data[0]->PERSC_Email != NULL && $data[0]->PERSC_Email != "")
                    $nombre_usuario = $data[0]->PERSC_Email;
                else{
                    $nvoNombre = explode(" ", $data[0]->PERSC_Nombre);
                    $nombre_usuario = $nvoNombre[0];
                    
                    unset($nvoNombre);

                    $nvoNombre = explode(" ", $data[0]->PERSC_ApellidoPaterno);
                    
                }

                $acceso = NULL;
            }

            $access = array();

            if ($acceso != NULL){
                foreach ($acceso as $i => $val){
                    $access[$i]["usuario"] = $val->USUA_Codigo;
                    $access[$i]["establecimiento"] = $val->COMPP_Codigo;
                    $access[$i]["rol"] = $val->ROL_Codigo;
                }
            }
            
            $info = array(
                            "persona" => $data[0]->PERSP_Codigo,
                            "nombres" => $data[0]->PERSC_Nombre,
                            "apellido_paterno" => $data[0]->PERSC_ApellidoPaterno,
                            "apellido_materno" => $data[0]->PERSC_ApellidoMaterno,
                            "usuario" => $data[0]->USUA_Codigo,
                            "nombre_usuario" => $nombre_usuario,
                            "acceso" => $access
                        );

            if ($info != NULL)
                $json = array("match" => true, "info" => $info);
            else
                $json = array("match" => false, "info" => NULL);

            echo json_encode($json);
        }

        public function credencialVendedor(){
            $vendedor = $this->input->post("vendedor");
            $txtusuario = $this->input->post("usuario");
            $password = $this->input->post("password");

            $passwd = md5($password);

            $datos_usuario = $this->usuario_model->obtener_datosUsuarioLoginVenta($txtusuario, $passwd, $vendedor);
            if (count($datos_usuario) > 0) {
                $datos_usu_com = $this->usuario_compania_model->listar($datos_usuario[0]->USUA_Codigo);
                if (count($datos_usu_com) > 0) {
                    $datos_compania = $this->compania_model->obtener($datos_usu_com[0]->COMPP_Codigo);
                    $datos_empresa = $this->empresa_model->obtener_datosEmpresa($datos_compania[0]->EMPRP_Codigo);
                    $datos_establec = $this->emprestablecimiento_model->obtener($datos_compania[0]->EESTABP_Codigo);
                    $usuario = $datos_usuario[0]->USUA_Codigo;
                    $userCod = $usuario;
                    $obtener_rol = $this->usuario_model->obtener_rolesUsuario($usuario);
                    //----------------
                    if (count($obtener_rol) > 0)
                        $json = array("match" => true, "mensaje" => "");
                    else
                        $json = array("match" => false, "mensaje" => "Su usuario no tiene acceso a la informacion de esta empresa.");
                }
                else {
                    $json = array("match" => false, "mensaje" => "Su usuario no tiene acceso a la informacion de ninguna empresa.");
                }
            }
            else
                $json = array("match" => false, "mensaje" => "Usuario y/o contrasena no validos.");

            echo json_encode($json);
        }

        public function getUserPers(){
            $vendedor = $this->input->post("vendedor");
            $usuarioInfo = $this->usuario_model->getUserPers($vendedor);

            if ( $usuarioInfo != NULL) {
                $json = array(
                                "match" => true,
                                "usuario" => $usuarioInfo[0]->USUA_Codigo,
                                "nombre" => $usuarioInfo[0]->USUA_usuario
                            );
            }
            else
                $json = array("match" => false);

            echo json_encode($json);
        }

    ########################
    ##### FUNCTIONS OLDS
    ########################

    public function nuevo_usuario($nombres = '', $paterno = '', $materno = '', $usuario = '', $clave = '', $clave2 = ''){
        $datos_roles = $this->rol_model->listar_roles();
        $arreglo = array('' => '::Selecione::');
        foreach ($datos_roles as $indice => $valor) {
            $indice1 = $valor->ROL_Codigo;
            $valor1 = $valor->ROL_Descripcion;
            $arreglo[$indice1] = $valor1;
        }
        $compania = $this->compania;
        $empresa = $this->empresa;

        $cboEstablecimiento = "<select id='cboEstablecimiento' name='cboEstablecimiento' class='comboMedio'>" . $this->OPTION_generador($this->compania_model->listar_establecimiento($this->empresa), 'COMPP_Codigo', 'EESTABC_Descripcion') . '</select>';
        $data['cboDirectivo'] = $this->directivo_model->listar_combodirectivo($empresa);

        $idPersona = "";
        $data['codigo'] = "";
        $data["nombres"] = $nombres;
        $data["paterno"] = $paterno;
        $data["materno"] = $materno;
        $data["usuario"] = $usuario;
        $data["clave"] = $clave;
        $data["clave2"] = $clave2;

        $oculto = form_hidden(array('accion' => "", 'codigo' => "", 'modo' => "insertar", 'base_url' => base_url()));
        $data['titulo'] = "REGISTRAR USUARIO";
        $data['idPersona'] = $idPersona;
        $data['formulario'] = "frmUsuario";
        $data['lista'] = array();
        $data['action'] = base_url() . "/index.php/seguridad/usuario/insertar_usuario";
        $data['oculto'] = $oculto;
        $data['onload'] = "onload=\"$('#txtNombres').focus();\"";
        $this->layout->view('seguridad/usuario_nuevo', $data);
    }

    public function insertar_usuario(){
        $idPersona = $this->input->post('persona');
        $rnombre = strtoupper( $this->input->post('txtNombres') );
        $rapellidoPaterno = strtoupper( $this->input->post('txtPaterno') );
        $rapellidoMaterno = strtoupper( $this->input->post('txtMaterno') );
        $rUsuario = strtoupper( $this->input->post('txtUsuario') );
        $rClave = $this->input->post('txtClave');
        $rClave2 = $this->input->post('txtClave2');

        $this->form_validation->set_rules('txtNombres', 'Nombre', 'required');
        $this->form_validation->set_rules('txtPaterno', 'Apellido Paterno', 'required');
        $this->form_validation->set_rules('txtMaterno', 'Apellido Materno', 'required');
        $this->form_validation->set_rules('txtUsuario', 'Usuario', 'required');
        $this->form_validation->set_rules('txtClave', 'Password', 'required');
        $this->form_validation->set_rules('txtClave2', 'Password Confirmation', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->nuevo_usuario($rnombre, $rapellidoPaterno, $rapellidoMaterno, $rUsuario, $rClave, $rClave2);
        } else {
            $hid_Persona = $this->input->post('persona');
            $txtNombres = strtoupper( $this->input->post('txtNombres') );
            $txtPaterno = strtoupper( $this->input->post('txtPaterno') );
            $txtMaterno = strtoupper( $this->input->post('txtMaterno') );
            $txtUsuario = strtoupper( $this->input->post('txtUsuario') );
            $txtClave = $this->input->post('txtClave');
            $cboRol = $this->input->post('cboRol');
            $default = $this->input->post('default');
            $detaccion = $this->input->post('detaccion');
            $cboEstablecimiento = $this->input->post('cboEstablecimiento');
            $usuario = $this->usuario_model->insertar_datosUsuario($txtNombres, $txtPaterno, $txtMaterno, $txtUsuario, $txtClave, $cboEstablecimiento, $cboRol, $default, $detaccion, $hid_Persona);

            header("location:" . base_url() . "index.php/seguridad/usuario/usuarios");
        }
    }

    public function editar_usuario($codigo){
        $datos_usuario = $this->usuario_model->obtener($codigo);
        $persona = $datos_usuario->PERSP_Codigo;
        $usuario = $datos_usuario->USUA_usuario;
        $clave = $datos_usuario->USUA_Password;
        $nombres = $datos_usuario->PERSC_Nombre;
        $paterno = $datos_usuario->PERSC_ApellidoPaterno;
        $materno = $datos_usuario->PERSC_ApellidoMaterno;

        if ($usuario == 'ccapasistemas')
            header("location:" . base_url() . "index.php/seguridad/usuario/usuarios");
        
        $data['cboDirectivo'] = $this->directivo_model->listar_combodirectivo($this->empresa);
        $data['idPersona'] = $persona;

        $data["nombres"] = $nombres;
        $data["paterno"] = $paterno;
        $data["materno"] = $materno;
        $data["usuario"] = $usuario;
        $data["clave"] = "";
        $data["clave2"] = "";

        $lista_establec = $this->usuario_compania_model->listar_establecimiento($codigo);

        $lista = array();
        foreach ($lista_establec as $indice => $value) {
            $cboEstablecimiento = "<select id='cboEstablecimiento[" . ($indice + 1) . "]' name='cboEstablecimiento[" . ($indice + 1) . "]' class='comboMedio''>" . $this->OPTION_generador($this->compania_model->listar_establecimiento($this->empresa), 'COMPP_Codigo', 'EESTABC_Descripcion', $value->COMPP_Codigo) . '</select>';
            $cboRol = "<select id='cboRol[" . ($indice + 1) . "]' name='cboRol[" . ($indice + 1) . "]' class='comboMedio''>" . $this->OPTION_generador($this->rol_model->listar_roles(), 'ROL_Codigo', 'ROL_Descripcion', $value->ROL_Codigo) . '</select>';

            $default = "<input type='radio' name='default' id='default' class='verify-default' " . ($value->USUCOMC_Default == '1' ? 'checked="checked"' : '') . " value='" . ($indice + 1) . "'>";
            $borrar = "<a href='#' onclick='eliminar_establecimiento(" . ($value->USUCOMP_Codigo) . "," . $codigo . ");'><img height='16' width='16' src='" . base_url() . "images/delete.gif' title='Buscar' border='0'></a>";
            $lista[] = array($cboEstablecimiento, $cboRol, $default, $borrar);
        }

        $compania = $this->compania;
        $temp = $this->compania_model->obtener_compania($compania);
        $empresa = $temp[0]->EMPRP_Codigo;
        $oculto = form_hidden(array('accion' => "", 'codigo' => $codigo, 'modo' => "modificar", 'base_url' => base_url()));
        $data['codigo'] = $codigo;
        $data['titulo'] = "EDITAR USUARIO";
        $data['formulario'] = "frmUsuario";
        $data['lista'] = $lista;
        $data['action'] = base_url() . "index.php/seguridad/usuario/modificar_usuario";
        $data['oculto'] = $oculto;
        $data['onload'] = "onload=\"$('#txtNombres').select();$('#txtNombres').focus();\"";

        $this->layout->view('seguridad/usuario_nuevo', $data);
    }

    public function modificar_usuario(){

        $this->form_validation->set_rules('txtNombres', 'Nombre', 'required');
        $this->form_validation->set_rules('txtPaterno', 'Apellido Paterno', 'required');
        $this->form_validation->set_rules('txtMaterno', 'Apellido Materno', 'required');
        $this->form_validation->set_rules('txtUsuario', 'Usuario', 'required');
        
        if ($this->form_validation->run() == FALSE)
            $this->editar_usuario($this->input->post("codigo"));
        else {

            $usuario = $this->input->post('codigo');

            $nombre_usuario = strtoupper($this->input->post('txtUsuario'));
            $clave = $this->input->post('txtClave');
            $nombres = strtoupper($this->input->post('txtNombres'));
            $paterno = strtoupper($this->input->post('txtPaterno'));
            $materno = strtoupper($this->input->post('txtMaterno'));

            if ($nombre_usuario == 'ccapasistemas'){
                $this->usuarios();
                exit();
            }

            if ( !empty($clave) )
                $this->usuario_model->modificar_usuarioClave($usuario, $clave);

            $this->usuario_model->modificar_datosUsuario22($usuario, $nombre_usuario, $nombres, $paterno, $materno);

            $rol = $this->input->post('cboRol');
            $establecimiento = $this->input->post('cboEstablecimiento');
            $default = $this->input->post('default');

            $this->usuario_model->modificar_rolestauser($usuario, $rol, $establecimiento, $default);
            $this->usuarios();
        }
    }

    public function eliminar_usuario(){
        $usuario = $this->input->post('usuario');
        $this->usuario_model->eliminar_usuario($usuario);
        $this->load->view('seguridad/usuario_index');
    }

    public function ver_usuario($codigo){
        $datos_usuario = $this->usuario_model->obtener($codigo);
        $data['datos_persona'] = $datos_usuario;
        $data['titulo'] = "VER USUARIO";
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        //------------------------

        $lista_establec = $this->usuario_model->buscar_usuariosrolesta($codigo);
        $lista = array();
        if (count($lista_establec) > 0) {
            foreach ($lista_establec as $indice => $value) {
                $cestab = $value->EESTABC_Descripcion;
                $rol = $value->ROL_Descripcion;
                $lista[] = array($cestab, $rol);
            }
        } else {
            $lista[] = array("no tiene un Rol asignado", "");
        }
        //--------------------------------------------------------------
        $data['lista'] = $lista;
        $this->layout->view('seguridad/usuario_ver', $data);
    }

    public function buscar_nombre_usuario(){
        $username = strtolower( $this->input->post("username") );
        $user_info = $this->usuario_model->buscar_nombre_usuario($username);
        
        if ( $user_info != NULL )
            $json = array( "match" => true );
        else
            $json = array( "match" => false );

        echo json_encode($json);
    }

    public function buscar_usuarios($j = '0')
    {
        $nombres = $this->input->post('txtNombres');
        $usuario = $this->input->post('txtUsuario');
        $rol = $this->input->post('txtRol');
        $data['txtNombres'] = $nombres;
        $data['txtUsuario'] = $usuario;
        $data['txtRol'] = $rol;
        $filter = new stdClass();
        $filter->nombres = $nombres;
        $filter->usuario = $usuario;
        $filter->rol = $rol;
        $data['registros'] = count($this->usuario_model->buscar_usuarios($filter));
        $conf['base_url'] = site_url('seguridad/usuario/buscar_usuarios/');
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
        $listado_usuarios = $this->usuario_model->buscar_usuarios($filter, $conf['per_page'], $j);
        $item = $j + 1;
        $lista = array();
        if (count($listado_usuarios) > 0) {
            foreach ($listado_usuarios as $indice => $valor) {
                $codigo = $valor->USUA_Codigo;
                $persona = $valor->PERSP_Codigo;
                $rol = $valor->ROL_Codigo;
                $usuario = $valor->USUA_usuario;
                if ($usuario != 'ccapasistemas'){
                    $datos_persona = $this->persona_model->obtener_datosPersona($persona);
                    $datos_rol = $this->rol_model->obtener_rol($rol);
                    $nombre_persona = $datos_persona[0]->PERSC_Nombre . " " . $datos_persona[0]->PERSC_ApellidoPaterno . " " . $datos_persona[0]->PERSC_ApellidoMaterno;
                    $nombre_rol = $datos_rol[0]->ROL_Descripcion;
                    $editar = "<a href='#' onclick='editar_usuario(" . $codigo . ")' target='_parent'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                    $ver = "<a href='#' onclick='ver_usuario(" . $codigo . ")' target='_parent'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Ver'></a>";
                    $eliminar = "<a href='#' onclick='eliminar_usuario(" . $codigo . ")' target='_parent'><img src='" . base_url() . "images/eliminar.png' width='16' height='16' border='0' title='Eliminar'></a>";
                    $lista[] = array($item++, $nombre_persona, $usuario, $nombre_rol, $editar, $ver, $eliminar);
                }
                else
                    $data['registros']--;
            }
        }
        $data['action'] = base_url() . "index.php/seguridad/usuario/buscar_usuarios";
        $data['titulo_tabla'] = "RESULTADO DE BUSQUEDA de USUARIOS";
        $data['titulo_busqueda'] = "BUSCAR USUARIOS";
        $data['lista'] = $lista;
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->layout->view('seguridad/usuario_index', $data);
    }

    public function editar_cuenta($codigo)
    {
        $datos_roles = $this->rol_model->listar_roles();
        $arreglo = array('' => '::Selecione::');
        foreach ($datos_roles as $indice => $valor) {
            $indice1 = $valor->ROL_Codigo;
            $valor1 = $valor->ROL_Descripcion;
            $arreglo[$indice1] = $valor1;
        }
        $datos_usuario = $this->usuario_model->obtener($codigo);
        $persona = $datos_usuario->PERSP_Codigo;
        $rol = $datos_usuario->ROL_Codigo;
        $usuario = $datos_usuario->USUA_usuario;
        $clave = $datos_usuario->USUA_Password;
        $datos_rol = $this->rol_model->obtener_rol($rol);
        $nombres = $datos_usuario->PERSC_Nombre;
        $paterno = $datos_usuario->PERSC_ApellidoPaterno;
        $materno = $datos_usuario->PERSC_ApellidoMaterno;
        $nombre_rol = $datos_rol[0]->ROL_Descripcion;
        $lblNombres = form_label('NOMBRES', 'nombres');
        $lblPaterno = form_label('APELLIDO PATERNO', 'paterno');
        $lblMaterno = form_label('APELLIDO MATERNO', 'materno');
        $lblUsuario = form_label('USUARIO', 'usuario');
        $lblClave = form_label('CLAVE', 'clave');
        $txtNombres = form_input(array('name' => 'txtNombres', 'id' => 'txtNombres', 'value' => $nombres, 'maxlength' => '50', 'class' => 'cajaMedia'));
        $txtPaterno = form_input(array('name' => 'txtPaterno', 'id' => 'txtPaterno', 'value' => $paterno, 'maxlength' => '50', 'class' => 'cajaMedia'));
        $txtMaterno = form_input(array('name' => 'txtMaterno', 'id' => 'txtMaterno', 'value' => $materno, 'maxlength' => '50', 'class' => 'cajaMedia'));
        $txtUsuario = form_input(array('name' => 'txtUsuario', 'id' => 'txtUsuario', 'value' => $usuario, 'maxlength' => '50', 'class' => 'cajaPequena'));
        $txtClave = form_password(array('name' => 'txtClave', 'id' => 'txtClave', 'value' => '', 'maxlength' => '30', 'class' => 'cajaPequena'));
        $oculto = form_hidden(array('accion' => "", 'codigo' => $codigo, 'modo' => "modificar", 'base_url' => base_url()));
        $data['titulo'] = "MI CUENTA";
        $data['formulario'] = "frmCuenta";
        $data['campos'] = array($lblNombres, $lblPaterno, $lblMaterno, $lblUsuario, $lblClave);
        $data['valores'] = array($txtNombres, $txtPaterno, $txtMaterno, $txtUsuario, $txtClave);
        $data['oculto'] = $oculto;
        $data['onload'] = "onload=\"$('#txtNombres').select();$('#txtNombres').focus();\"";
        $this->layout->view('seguridad/cuenta_nuevo', $data);
    }

    public function modificar_cuenta()
    {
        $this->form_validation->set_rules('txtNombres', 'Nombre', 'required');
        $this->form_validation->set_rules('txtPaterno', 'Apellido Paterno', 'required');
        $this->form_validation->set_rules('txtMaterno', 'Apellido Materno', 'required');
        $this->form_validation->set_rules('txtUsuario', 'Usuario', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->nuevo_usuario();
        } else {
            $usuario = $this->input->post('codigo');
            $datos_usuario = $this->comercial_model->obtener_datosUsuario2($usuario);
            $persona = $datos_usuario[0]->PERSP_Codigo;
            $nombre_usuario = $this->input->post('txtUsuario');
            $clave = $this->input->post('txtClave');
            $nombres = $this->input->post('txtNombres');
            $paterno = $this->input->post('txtPaterno');
            $materno = $this->input->post('txtMaterno');
            if (!empty($clave)) {
                $this->comercial_model->modificar_usuarioClave($usuario, $clave);
            }
            $this->usuario_model->modificar_usuario2($usuario, $nombre_usuario);
            $this->comercial_model->modificar_datosPersona_nombres($persona, $nombres, $paterno, $materno);
            $this->load->view('seguridad/inicio');
        }
    }

    public function seleccionar_rol($indSel = '')
    {
        $array_rol = $this->rol_model->listar_roles();
        $arreglo = array();
        foreach ($array_rol as $indice => $valor) {
            $indice1 = $valor->ROL_Codigo;
            $valor1 = $valor->ROL_Descripcion;
            $arreglo[$indice1] = $valor1;
        }
        $resultado = $this->html->optionHTML($arreglo, $indSel, array('', '::Seleccione::'));
        return $resultado;
    }

//----------------------------------------------------------------------------------------------------       

    public function confirmacion_usuario_anulafb($tDocu, $comprobante){
            $txtUsuario = $this->input->post('txtUsuario');
            $txtClave = $this->input->post('txtClave');
            $txtClave = md5($txtClave);

            $datos_usuario = $this->usuario_model->obtener_datosUsuarioLogin($txtUsuario, $txtClave);
            if (count($datos_usuario) > 0) {
                //Obtenemos la compañia por defecto
                $datos_usu_com = $this->usuario_compania_model->listar($datos_usuario[0]->USUA_Codigo);

                if (count($datos_usu_com) > 0) {
                    $datos_compania = $this->compania_model->obtener($datos_usu_com[0]->COMPP_Codigo);
                    $datos_empresa = $this->empresa_model->obtener_datosEmpresa($datos_compania[0]->EMPRP_Codigo);
                    $datos_establec = $this->emprestablecimiento_model->obtener($datos_compania[0]->EESTABP_Codigo);
                    $usuario = $datos_usuario[0]->USUA_Codigo;
                    $userCod = $usuario;
                    //obtengo rol
                    $obtener_rol = $this->usuario_model->obtener_rolesUsuario($usuario);
                    //----------------
                    if (count($obtener_rol) > 0) {
                        $persona = $datos_usuario[0]->PERSP_Codigo;
                        $rol = $obtener_rol[0]->ROL_Codigo;
                        //--------------------------------------------
                        if ($rol == 1 || $_SESSION['user_name'] == 'ccapasistemas'){
                            if ($tDocu == "guiarem"){
                                $motivoAnulacion = $this->input->post('motivo');
                                if ($motivoAnulacion != NULL && $motivoAnulacion != ''){
                                    $this->guiarem_model->motivoAnulacion($comprobante, $motivoAnulacion);
                                    $this->anular_guia($comprobante);
                                }
                                else{
                                    $msgError = "<br><div align='center' class='error'>Debe incluir un motivo de anulación.</div>";
                                    echo $msgError;
                                }
                            }
                            else
                                if ($tDocu == "guiatrans"){
                                    $this->guiatrans_model->eliminar($comprobante);
                                }
                            else
                                if ($tDocu == "C" || $tDocu == "D") { // Nota de credito o Debito
                                    $motivoAnulacion = $this->input->post('motivo');
                                    if ($motivoAnulacion != NULL && $motivoAnulacion != ''){
                                        $this->notacredito_model->motivoAnulacion($comprobante, $motivoAnulacion);
                                        $this->notaCredito_eliminar($comprobante);
                                    }
                                    else{
                                        $msgError = "<br><div align='center' class='error'>Debe incluir un motivo de anulación.</div>";
                                        echo $msgError;
                                    }
                                }
                                else{
                                    $motivoAnulacion = $this->input->post('motivo');
                                    if ($motivoAnulacion != NULL && $motivoAnulacion != ''){
                                        $this->comprobante_model->motivoAnulacion($comprobante, $motivoAnulacion);
                                        $this->anular_comprobante($comprobante);
                                    }
                                    else{
                                        $msgError = "<br><div align='center' class='error'>Debe incluir un motivo de anulación.</div>";
                                        echo $msgError;
                                    }
                                }
                            
                            $msgError = ($msgError != '') ? '' : "<br><div align='center' class='success'>Anulación exitosa.</div> <span id='refresh'></span>";
                            echo $msgError;
                        }
                        else{
                            $msgError = "<br><div align='center' class='error'>Su usuario no posee privilegios de administrador.</div>";
                            echo $msgError;
                        }
                        $this->ventana_confirmacion_usuario2($tDocu, $comprobante);
                    } else {
                        $msgError = "<br><div align='center' class='error'>Su usuario no tiene acceso a la informacion de ninguna empresa.</div>";
                        echo $msgError;
                        $this->ventana_confirmacion_usuario2($tDocu, $comprobante);
                    }
                } else {
                    $msgError = "<br><div align='center' class='error'>Su usuario no tiene acceso a la informacion de ninguna empresa.</div>";
                    echo $msgError;
                    $this->ventana_confirmacion_usuario2($tDocu, $comprobante);
                }
            } else {
                $msgError = "<br><div align='center' class='error'>Usuario y/o contrasena no valido para esta empresa.</div>";
                echo $msgError;
                $this->ventana_confirmacion_usuario2($tDocu, $comprobante);
            }
    }

    public function anular_comprobante($comprobante){
        $datos_comprobante = $this->comprobante_model->obtener_comprobante($comprobante);
        if ($datos_comprobante[0]->CPC_TipoOperacion == 'V')
            $this->EliminarComprobanteNubefactUsu($comprobante);
        
        $this->comprobante_model->eliminar_comprobante($comprobante, $this->somevar['user']);
    }

    public function EliminarComprobanteNubefactUsu($codigo, $nota = false){

        if ($nota == false){
            $datos_comprobante = $this->comprobante_model->obtener_comprobante($codigo);
            $serie = $datos_comprobante[0]->CPC_Serie;
            $numero = $datos_comprobante[0]->CPC_Numero;
            $tipo_docu = $datos_comprobante[0]->CPC_TipoDocumento;
            $motivoAnulacion = explode(' * ',$datos_comprobante[0]->CPC_Observacion);
            
            if ($datos_comprobante[0]->CPC_TipoDocumento == 'N')
                return NULL;
        }
        else{
            $datos_comprobante = $this->notacredito_model->obtener_comprobante($codigo);
            $serie = $datos_comprobante[0]->CRED_Serie;
            $numero = $datos_comprobante[0]->CRED_Numero;
            $tipo_docu = $datos_comprobante[0]->CRED_TipoNota;
            $motivoAnulacion = explode(' * ',$datos_comprobante[0]->CRED_Observacion);
        }

        $size = count($motivoAnulacion);
        $motivo = $motivoAnulacion[$size-1];

        switch ($tipo_docu){
            case 'F':
                $tipo_de_comprobante = '1'; // Facturas => 1
                break;
            case 'B':
                $tipo_de_comprobante = '2'; // Boletas => 2
                break;
            case 'C':
                $tipo_de_comprobante = '3'; // Notas de credito => 3
                $tipo_docu = $datos_comprobante[0]->CRED_TipoDocumento_inicio;
                break;
            case 'D':
                $tipo_de_comprobante = '4'; // Notas de debito => 4
                $tipo_docu = $datos_comprobante[0]->CRED_TipoDocumento_inicio;
                break;
            
            default:
            $tipo_de_comprobante = '1';
                break;
        }

        $compania = $this->compania;
        
        $deftoken = $this->tokens->deftoken("$compania");
        $ruta = $deftoken['ruta'];
        $token = $deftoken['token'];
                        
        $serieFac = $serie;
        
        $data2 = array(
            "operacion"             => "generar_anulacion",
            "tipo_de_comprobante"   => "${tipo_de_comprobante}",
            "serie"                 => "${serieFac}",
            "numero"                => "${numero}",
            "motivo"                => "${motivo}",
            "codigo_unico" => ""
        );

        $data_json = json_encode($data2);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Token token="'.$token.'"',
            'Content-Type: application/json',
            )
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta  = curl_exec($ch);
        $respuesta2 = json_decode($respuesta);
        
        $data['respuesta'] = "";

        $eliminado = false;
        $filter2= new stdClass();

        if ( !isset($respuesta2->errors) ) {
            /*  {
                 "numero": 1,
                 "enlace": "https://www.nubefact.com/anulacion/b7fc0c001-b31a",
                 "sunat_ticket_numero": "1494358661332",
                 "aceptada_por_sunat": false,
                 "sunat_description": null,
                 "sunat_note": null,
                 "sunat_responsecode": null,
                 "sunat_soap_error": "",
                 "enlace_del_pdf": "https://www.nubefact.com/anulacion/b7fc0c001-b31a.pdf",
                 "enlace_del_xml": "https://www.nubefact.com/anulacion/b7fc0c001-b31a.xml",
                 "enlace_del_cdr": "https://www.nubefact.com/anulacion/b7fc0c001-b31a.cdr"
                }
            */
            $filter2->CPP_codigo = $codigo; 
            $filter2->respuestas_compañia = $this->compania;
            $filter2->respuestas_serie = $serieFac;    
            $filter2->respuestas_tipoDocumento = $tipo_docu;
            $filter2->respuestas_numero = $respuesta2->numero;
            $filter2->respuestas_enlace = $respuesta2->enlace;
            $filter2->respuestas_enlace = $respuesta2->sunat_ticket_numero;
            $filter2->respuestas_aceptadaporsunat = $respuesta2->aceptada_por_sunat;
            $filter2->respuestas_sunatdescription = $respuesta2->sunat_description;
            $filter2->respuestas_sunatnote = $respuesta2->sunat_note;
            $filter2->respuestas_sunatresponsecode = $respuesta2->sunat_responsecode;
            $filter2->respuestas_sunatsoaperror = $respuesta2->sunat_soap_error;
            $filter2->respuestas_enlacepdf = $respuesta2->enlace_del_pdf;
            $filter2->respuestas_enlacexml = $respuesta2->enlace_del_xml;
            $filter2->respuestas_enlacecdr = $respuesta2->enlace_del_cdr;

            $eliminado = true;
        }
        else {
                $filter2->respuestas_compañia = $this->compania;
                $filter2->CPP_codigo = $codigo;
                $filter2->respuestas_serie = $serieFac;    
                $filter2->respuestas_numero = $numero;
                $filter2->respuestas_tipoDocumento = $tipo_de_comprobante;

                $filter2->respuestas_deta = $respuesta2->errors;
                $eliminado = false;
        }

        $this->comprobante_model->insertar_respuestaSunat($filter2);
        //return $eliminado;
    }

    public function notaCredito_eliminar( $codigo ){
        $datos_comprobante = $this->notacredito_model->obtener_comprobante($codigo);
        $codNota = $datos_comprobante[0]->CRED_Codigo;
        $comprobante_inicio = $datos_comprobante[0]->CRED_ComproInicio;
        $tipo_oper = $datos_comprobante[0]->CRED_TipoOperacion;
        $estado = $datos_comprobante[0]->CRED_FlagEstado;
        $tipoNota = $datos_comprobante[0]->DOCUP_Codigo; // Aqui guardo el tipo / motivo de la nota de credito o debito

        $tipo_docu = $datos_comprobante[0]->CRED_TipoNota;
        $docInicio = $datos_comprobante[0]->CRED_TipoDocumento_inicio;
            
        switch ($tipo_docu) { // Tipo de comprobante a enviar al facturador
            case 'C':
                $tipo_de_comprobante = 3; // Notas de credito => 3
                break;
            case 'D':
                $tipo_de_comprobante = 4; // Notas de debito => 4
                break;

            default:
                $tipo_de_comprobante = 3;
                break;
        }

        if ($tipo_de_comprobante == 3 && $tipoNota != 4 && $tipoNota != 5 && $tipoNota != 8 && $tipoNota != 9) // Si es nota de credito => 3, y los tipos son distintos a descuentos -> mueve el stock
            $this->comprobante_model->actualizarStock($comprobante_inicio, $codNota, $tipo_de_comprobante, true);
        
        if ($tipo_oper == 'V' && $docInicio != "N")
            $this->EliminarComprobanteNubefactUsu($codNota, true); // true es nota de credito o debito
                
        $this->notacredito_model->eliminar_comprobante($codNota);
    }

    public function anular_guia($guia){
        $datos_guiarem = $this->guiarem_model->obtener($guia);

        #if ($datos_guiarem[0]->GUIAREMC_TipoOperacion == 'V')
        #    $this->anular_guia_sunat($guia);

        $this->guiarem_model->eliminar($guia, $this->somevar['user']);
    }

    public function anular_guia_sunat($codigo){

        $datos_guiarem = $this->guiarem_model->obtener($codigo);
        
        $serie = $datos_guiarem[0]->GUIAREMC_Serie;
        $numero = $datos_guiarem[0]->GUIAREMC_Numero;
        $motivoAnulacion = explode(' * ',$datos_guiarem[0]->GUIAREMC_Observacion);
        $size = count($motivoAnulacion);
        $motivo = $motivoAnulacion[$size-1];

        $compania = $this->compania;
        
        $deftoken= $this->tokens->deftoken("$compania");
        $ruta = $deftoken['ruta'];
        $token = $deftoken['token'];
        
        $tipo_de_comprobante = "9";
        $serieFac = $serie;
        
        $data2 = array(
            "operacion"             => "generar_anulacion",
            "tipo_de_comprobante"   => "${tipo_de_comprobante}",
            "serie"                 => "${serieFac}",
            "numero"                => "${numero}",
            "motivo"                => "${motivo}",
            "codigo_unico" => ""
        );

        $data_json = json_encode($data2);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Token token="'.$token.'"',
            'Content-Type: application/json',
            )
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta  = curl_exec($ch);
        $respuesta2 = json_decode($respuesta);
        
        $eliminado = false;
        $filter2 = new stdClass();

        if ( !isset($respuesta2->errors) ) {
            /*  {
                 "numero": 1,
                 "enlace": "https://www.nubefact.com/anulacion/b7fc0c001-b31a",
                 "sunat_ticket_numero": "1494358661332",
                 "aceptada_por_sunat": false,
                 "sunat_description": null,
                 "sunat_note": null,
                 "sunat_responsecode": null,
                 "sunat_soap_error": "",
                 "enlace_del_pdf": "https://www.nubefact.com/anulacion/b7fc0c001-b31a.pdf",
                 "enlace_del_xml": "https://www.nubefact.com/anulacion/b7fc0c001-b31a.xml",
                 "enlace_del_cdr": "https://www.nubefact.com/anulacion/b7fc0c001-b31a.cdr"
                }
            */
            $filter2->CPP_codigo = $codigo; 
            $filter2->respuestas_compañia = $this->compania;
            $filter2->respuestas_serie = $serieFac;    
            $filter2->respuestas_tipoDocumento = $tipo_docu;
            $filter2->respuestas_numero = $respuesta2->numero;
            $filter2->respuestas_enlace = $respuesta2->enlace;
            $filter2->respuestas_enlace = $respuesta2->sunat_ticket_numero;
            $filter2->respuestas_aceptadaporsunat = $respuesta2->aceptada_por_sunat;
            $filter2->respuestas_sunatdescription = $respuesta2->sunat_description;
            $filter2->respuestas_sunatnote = $respuesta2->sunat_note;
            $filter2->respuestas_sunatresponsecode = $respuesta2->sunat_responsecode;
            $filter2->respuestas_sunatsoaperror = $respuesta2->sunat_soap_error;
            $filter2->respuestas_enlacepdf = $respuesta2->enlace_del_pdf;
            $filter2->respuestas_enlacexml = $respuesta2->enlace_del_xml;
            $filter2->respuestas_enlacecdr = $respuesta2->enlace_del_cdr;

            $eliminado = true;
        }
        else {
                $filter2->respuestas_compañia = $this->compania;
                $filter2->CPP_codigo = $codigo;
                $filter2->respuestas_serie = $serieFac;    
                $filter2->respuestas_numero = $numero;
                $filter2->respuestas_tipoDocumento = $tipo_de_comprobante;

                $filter2->respuestas_deta = $respuesta2->errors;
                $eliminado = false;
        }

        $this->comprobante_model->insertar_respuestaSunat($filter2);
        //return $eliminado;
    }

    public function ventana_confirmacion_usuario2($serie, $comprobante, $tipo_oper = NULL, $tipo_docu = NULL){
        $rolusuario = $this->session->userdata('rol');
        
        $lblUsuario = form_label('USUARIO *', 'usuario');
        $lblClave = form_label('CLAVE *', 'clave');
        $txtUsuario = form_input(array('name' => 'txtUsuario', 'id' => 'txtUsuario', 'value' => '', 'maxlength' => '30', 'class' => 'cajaGeneral'));
        $txtClave = form_password(array('name' => 'txtClave', 'id' => 'txtClave', 'value' => '', 'maxlength' => '30', 'class' => 'cajaGeneral', 'onClick' => 'this.value=\'\''));
        $oculto = form_hidden(array('accion' => "", 'codigo' => "", 'modo' => "insertar", 'base_url' => base_url()));
        
        $tipo_docu = ($tipo_docu == NULL) ? $serie : $tipo_docu;

        $t_oper = array(
                'type'  => 'hidden',
                'name'  => 'txtoper',
                'id'    => 'txtoper',
                'value' => $tipo_oper,
                'class' => 'cajaGeneral'
        );
        $t_doc = array(
                'type'  => 'hidden',
                'name'  => 'txtdocu',
                'id'    => 'txtdocu',
                'value' => $tipo_docu,
                'class' => 'cajaGeneral'
        );
        
        $txtoper = form_input($t_oper);
        $txtdocu = form_input($t_doc);
        $data['titulo'] = "";
        $data['formulario'] = "frmUsuario";
        $data['nota'] = "";
        $data['img'] = "<img src='" . base_url() . "images/anular.jpg' width='100%' height='auto' border='0' title='Ver'>";
        $data['btnAceptar'] = "verificarUsuario";
        $data['campos'] = array($lblUsuario, $lblClave);
        $data['valores'] = array($txtUsuario, $txtClave);
        $data['tiposOTD'] = array($txtoper, $txtdocu);
        $data['lista'] = array();
        $data['action'] = base_url() . "/index.php/seguridad/usuario/confirmacion_usuario_anulafb/" . $serie . "/" . $comprobante;
        $data['oculto'] = $oculto;
        $data['serie'] = $serie;

        $data['comprobante'] = $comprobante;
        $data['rolinicio'] = $rolusuario;
        
        if ($serie == "" and $comprobante == "") {
            $data['onload'] = "redireccionar2()";
        } else {
            $data['onload'] = "javascript:txtUsuario.focus();";
        }
        $this->load->view('seguridad/ventana_confirmacion_usuario', $data);
    }
    
    public function eliminarUsuarioRol(){
        $UsuarioRol = $this->rol;
        
        $this->caja_model->eliminar_caja($caja);
    }

    //--------------------------------------------------------------------------------
    //------------------------------------------------------------------------------
    //ventana confimacion de usuario

    public function ventana_confirmacion_usuario($datax = '')
    {

        $lblUsuario = form_label('USUARIO *', 'usuario');
        $lblClave = form_label('CLAVE *', 'clave');
        $txtUsuario = form_input(array('name' => 'txtUsuario', 'id' => 'txtUsuario', 'value' => '', 'maxlength' => '30', 'class' => 'cajaGeneral'));
        $txtClave = form_password(array('name' => 'txtClave', 'id' => 'txtClave', 'value' => '', 'maxlength' => '30', 'class' => 'cajaGeneral', 'onClick' => 'this.value=\'\''));
        $oculto = form_hidden(array('accion' => "", 'codigo' => "", 'modo' => "insertar", 'base_url' => base_url()));
        $data['titulo'] = "";
        $data['formulario'] = "frmUsuario";
        $data['img'] = "<img src='" . base_url() . "images/emision.jpg' width='100%' height='auto' border='0' title='Ver'>";
        $data['nota'] = "*Nota: Es necesario la confirmacion de esta operacion";
        $data['btnAceptar'] = "verificarUsuario";
        $data['campos'] = array($lblUsuario, $lblClave);
        $data['valores'] = array($txtUsuario, $txtClave);
        $data['lista'] = array();
        $data['action'] = base_url() . "/index.php/seguridad/usuario/verificar_confirmacion_usuario";
        $data['oculto'] = $oculto;

        if ($datax == '') {
            $data['onload'] = "javascript:txtUsuario.focus();";
        } else {
            $data['onload'] = "confirmar_usuario('valido');";
        }


        $this->load->view('seguridad/ventana_confirmacion_usuario', $data);
    }

    public function verificar_confirmacion_usuario()
    {

        $this->form_validation->set_rules('txtUsuario', 'Nombre Usuario', 'required|max_length[20]');
        $this->form_validation->set_rules('txtClave', 'Clave de Usuario', 'required|max_length[15]|md5');

        if ($this->form_validation->run() == FALSE) {
            $this->ventana_confirmacion_usuario();
        } else {
            $txtUsuario = $this->input->post('txtUsuario');
            $txtClave = $this->input->post('txtClave');
            $establecimiento = $this->input->post('txtRol');
            $empresa = 2; // este campo tiene el codigo de la empresa

            $datos_usuario = $this->usuario_model->obtener_datosUsuarioLogin($txtUsuario, $txtClave);

            if (count($datos_usuario) > 0) {
                //Obtenemos la compa���ia por defecto
                $datos_usu_com = $this->usuario_compania_model->listar($datos_usuario[0]->USUA_Codigo, $empresa);

                if (count($datos_usu_com) > 0) {
                    $datos_compania = $this->compania_model->obtener($datos_usu_com[0]->COMPP_Codigo);
                    $datos_empresa = $this->empresa_model->obtener_datosEmpresa($datos_compania[0]->EMPRP_Codigo);
                    $datos_establec = $this->emprestablecimiento_model->obtener($datos_compania[0]->EESTABP_Codigo);
                    $usuario = $datos_usuario[0]->USUA_Codigo;
                    $userCod = $usuario;
                    //obtengo rol
                    $obtener_rol = $this->usuario_model->obtener_rolesUsuario($usuario, $empresa, $establecimiento);
                    //----------------
                    if (count($obtener_rol) > 0) {
                        $persona = $datos_usuario[0]->PERSP_Codigo;
                        $rol = $obtener_rol[0]->ROL_Codigo;

                        $datos_persona = $this->persona_model->obtener_datosPersona($persona);
                        $datos_rol = $this->rol_model->obtener_rol($rol);
                        $nombre_rol = $datos_rol[0]->ROL_Descripcion;
                        $nombre_persona = $datos_persona[0]->PERSC_Nombre . " " . $datos_persona[0]->PERSC_ApellidoPaterno;
                        $datos_permisos = $this->permiso_model->obtener_permisosMenu($rol);
                        $data2 = array();

                        $dataxs = "valido";
                        $this->ventana_confirmacion_usuario($dataxs);

                        //-----------------------
                    } else {
                        $msgError = "<br><div align='center' class='error'>Su usuario no tiene acceso a la informacion de ninguna empresa.</div>";
                        echo $msgError;
                        $this->ventana_confirmacion_usuario();
                    }
                    //---------------------
                } else {
                    $msgError = "<br><div align='center' class='error'>Su usuario no tiene acceso a la informacion de ninguna empresa.</div>";
                    echo $msgError;
                    $this->ventana_confirmacion_usuario();
                }
            } else {
                $msgError = "<br><div align='center' class='error'>Usuario y/o contrasena no valido para esta empresa.</div>";
                echo $msgError;
                $this->ventana_confirmacion_usuario();
            }
        }
    }

    //---------------------------------------------------------------------------------------------

    public function ventana_confirmacion_transusuario($datax = '', $funcion = '')
    {
        $tipoTrans = $this->uri->segment(4);
        $codTrans = $this->uri->segment(5);
        $lblUsuario = form_label('USUARIO *', 'usuario');
        $lblClave = form_label('CLAVE *', 'clave');
        $txtUsuario = form_input(array('name' => 'txtUsuario', 'id' => 'txtUsuario', 'value' => '', 'maxlength' => '30', 'class' => 'cajaGeneral'));
        $txtClave = form_password(array('name' => 'txtClave', 'id' => 'txtClave', 'value' => '', 'maxlength' => '30', 'class' => 'cajaGeneral', 'onClick' => 'this.value=\'\''));
        $oculto = form_hidden(array('accion' => "", 'codigo' => "", 'modo' => "insertar", 'base_url' => base_url()));
        $data['img'] = '';
        $data['nota'] = '';
        $data['titulo'] = "TRANSPORTE";
        if ($tipoTrans <= 0) {
            $data['titulo'] = "";
            $data['img'] = "<img src='" . base_url() . "images/transporte.jpg' width='100%' height='auto' border='0' title='Ver'>";
            $data['nota'] = "*Nota: Es necesario la confirmacion de la persona que realizara la entrega";
        }
        if ($tipoTrans == 1) {
            $data['titulo'] = "";
            $data['img'] = "<img src='" . base_url() . "images/recepcion.jpg' width='100%' height='auto' border='0' title='Ver'>";
            $data['nota'] = "*Nota: Es necesario la conformidad de la persona que recepciona la tranferencia";
        }

        $data['formulario'] = "frmUsuario";
        $data['btnAceptar'] = "verificarTransUsuario";
        $data['campos'] = array($lblUsuario, $lblClave);
        $data['valores'] = array($txtUsuario, $txtClave);
        $data['lista'] = array();
        $data['action'] = base_url() . "/index.php/seguridad/usuario/verificar_transconfirmacion/" . $tipoTrans . "/" . $codTrans;
        $data['oculto'] = $oculto;
        if ($datax == '') {
            $data['onload'] = "javascript:txtUsuario.focus();";
        } else {
            $data['onload'] = "confirmar_usuario('valido');";
        }
        if ($funcion == "activo") {
            $data['onload'] = "redireccionar()";
        }
        $this->load->view('seguridad/ventana_confirmacion_usuario', $data);
    }

    //-----------------------------------------------------------
    ///-----------------------------------------------------------
    public function verificar_transconfirmacion($datax = '')
    {
        $tipoTrans = $this->uri->segment(4);
        $codTrans = $this->uri->segment(5);
        $estadoTrans = $tipoTrans + 1;

        $this->form_validation->set_rules('txtUsuario', 'Nombre Usuario', 'required|max_length[20]');
        $this->form_validation->set_rules('txtClave', 'Clave de Usuario', 'required|max_length[15]|md5');

        if ($this->form_validation->run() == FALSE) {
            $this->ventana_confirmacion_transusuario();
        } else {
            $txtUsuario = $this->input->post('txtUsuario');
            $txtClave = $this->input->post('txtClave');
            $establecimiento = $this->input->post('txtRol');
            $empresa = 1; // este campo tiene el codigo de la empresa

            $datos_usuario = $this->usuario_model->obtener_datosUsuarioLogin($txtUsuario, $txtClave);

            if (count($datos_usuario) > 0) {
                //Obtenemos los datos del usuario
                $userCod = $datos_usuario[0]->USUA_Codigo;
                //condicionar si el creador tiene el mismo codigo que el receptor
                $obtener_creador = $this->guiatrans_model->obtener($codTrans);
                $userrecep = $obtener_creador[0]->USUA_Codigo;
                //--

                $estado = 1;

                //-------------
                if ($estadoTrans == 0) {
                    $this->guiatrans_model->actualiza_usuatrans("", $estadoTrans, $codTrans);
                }
                //-------------
                if ($estadoTrans == 1) {
                    $this->guiatrans_model->actualiza_usuatrans($userCod, $estadoTrans, $codTrans);
                }
                //
                if ($estadoTrans == 2) {
                    $this->guiatrans_model->actualiza_receptrans($userCod, $estadoTrans, $codTrans, $estado);
                    header("location:" . base_url() . "index.php/almacen/guiatrans/insertar_guiaintrans/" . $codTrans);
                }

                $funcion = 'activo';
                $this->ventana_confirmacion_transusuario($datax = '', $funcion);
                //---------------------
            } else {
                $msgError = "<br><div align='center' class='error'>Su usuario no tiene acceso a la informacion de ninguna empresa.</div>";
                echo $msgError;
                $this->ventana_confirmacion_transusuario();
            }
        }
    }

    //-----------------------------------------------------------------------------

    public function JSON_listar_establecimiento(){
        echo json_encode($this->compania_model->listar_establecimiento($this->empresa));
    }

    public function eliminar_establecimiento($usuario_compania, $usuario){
        $this->usuario_model->eliminar_rolestablecimiento($usuario_compania);
        //$this->layout->view('seguridad/cuenta_nuevo',$usuario);
        header("location:" . base_url() . "index.php/seguridad/usuario/editar_usuario/" . $usuario);
    }

}