<?php

class Rol extends Controller{

    private $empresa;
    private $compania;
    private $url;

    public function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('html');
        $this->load->library('layout','layout');

        $this->load->model('seguridad/rol_model');
        $this->load->model('seguridad/permiso_model');

        $this->empresa = $this->session->userdata('empresa');
        $this->compania = $this->session->userdata('compania');
        $this->url = base_url();
    }

    public function index(){
        $this->layout->view('seguridad/rol_index');
    }

    ######################
    ##### FUNCTIONS NEWS
    ######################

        public function datatable_rol(){

            $columnas = array(
                                0 => "",
                                1 => "ROL_Descripcion"
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

            $filter->nombre = $this->input->post('nombre');

            $rolesInfo = $this->rol_model->getRoles($filter);
            $lista = array();
            
            if (count($rolesInfo) > 0) {
                foreach ($rolesInfo as $indice => $valor) {
                    $btn_modal = "<button type='button' onclick='editar($valor->ROL_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/modificar.png' class='image-size-1b'>
                                </button>";
                    $btn_borrar = "<button type='button' onclick='deshabilitar($valor->ROL_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/documento-delete.png' class='image-size-1b'>
                                </button>";

                    $lista[] = array(
                                        0 => $indice + 1,
                                        1 => $valor->ROL_Descripcion,
                                        2 => "",
                                        3 => $btn_modal,
                                        4 => $btn_borrar
                                    );
                }
            }

            unset($filter->start);
            unset($filter->length);

            $json = array(
                                "draw"            => intval( $this->input->post('draw') ),
                                "recordsTotal"    => count($this->rol_model->getRoles()),
                                "recordsFiltered" => intval( count($this->rol_model->getRoles($filter)) ),
                                "data"            => $lista
                        );

            echo json_encode($json);
        }

        public function guardar_registro(){

            $rol = $this->input->post("rol");
            $rol_nombre = $this->input->post("rol_nombre");

            $permiso = $this->input->post("permiso");

            $msj = "";

            #### INFORMACIÓN DEL ROL
                $filterRol = new stdClass();
                $filterRol->ROL_Descripcion = $rol_nombre;
                $filterRol->COMPP_Codigo = $this->compania;
                $filterRol->ROL_FlagEstado = "1";

            # ACTUALIZO LOS DATOS DEL ROL ELSE REGISTRO UN NUEVO ROL
            if ($rol != ""){
                $filterRol->ROL_FechaModificacion = date("Y-m-d H:i:s");
                $updated = $this->rol_model->actualizar_rol($rol, $filterRol);
            }
            else{
                $filterRol->ROL_FechaRegistro = date("Y-m-d H:i:s");
                $rol = $this->rol_model->registrar_rol($filterRol);
            }

            if ($rol != NULL){
                ### ASIGNAR PERMISOS
                $size = count($permiso);
                # PRIMERO ELIMINO TODOS LOS PERMISOS DEL ROL
                $this->permiso_model->clean_permisos($rol);
                # AHORA REGISTRO LOS NUEVOS
                if ($permiso != "" && $size > 0){
                    for ( $i=0; $i < $size; $i++ ){
                        $filterUsuarioPermiso = new stdClass();
                        $filterUsuarioPermiso->ROL_Codigo = $rol;
                        $filterUsuarioPermiso->MENU_Codigo = $permiso[$i];
                        $filterUsuarioPermiso->COMPP_Codigo = $this->compania;
                        $filterUsuarioPermiso->PERM_FlagEstado = 1;
                        
                        $this->permiso_model->registrar_permiso($filterUsuarioPermiso);
                    }
                }
                $result = "success";
            }
            else
                $result = "error";

            $json = array("result" => $result, "mensaje" => $msj);
            echo json_encode($json);
        }

        public function getPermisos(){
            $rol = $this->input->post('rol');

            $data = $this->permiso_model->getPermisosRol($rol);
            
            if ($data != NULL){
                $permisos = array();
                foreach ($data as $key => $value) {
                    $permisos[] = $value->MENU_Codigo;
                }

                $info = array(
                                "rol" => $data[0]->ROL_Codigo,
                                "descripcion" => $data[0]->ROL_Descripcion,
                                "permisos" => $permisos
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

        public function deshabilitar_rol(){
            $rol = $this->input->post("rol");

            $filter = new stdClass();
            $filter->ROL_FlagEstado  = "0";

            if ($rol != ""){
                $result = $this->rol_model->actualizar_rol($rol, $filter);
                $this->permiso_model->clean_permisos($rol);
            }

            if ($result)
                $json = array("result" => "success");
            else
                $json = array("result" => "error");
            
            echo json_encode($json);
        }

    ######################
    ##### FUNCTIONS OLDS
    ######################

    public function listar($j='0'){
        $data['registros'] = count($this->rol_model->listar_roles());
        $data['base_url'] = $this->url;

        $data['titulo_busqueda'] = "BUSCAR ROL";
        $data['titulo']    = "RELACIÓN DE ROLES";
        
        $modulos = $this->permiso_model->getModulos();
        $info = array();
        if ($modulos != NULL){
            foreach ($modulos as $i => $val) { # MODULOS
                $permisos = $this->permiso_model->getPermisos($val->MENU_Codigo);
                foreach ($permisos as $j => $value){ # PERMISOS
                    if ($j == 0){
                        $info[$i]["permiso"][] = $val->MENU_Codigo;
                        $info[$i]["descripcion"][] = $val->MENU_Descripcion;
                        $info[$i]["modulo"][] = true;
                    }
                    
                    $info[$i]["permiso"][] = $value->MENU_Codigo;
                    $info[$i]["descripcion"][] = $value->MENU_Descripcion;
                    $info[$i]["modulo"][] = false;
                }
            }
        }

        $data["modulos"] = $info;
        $this->layout->view('seguridad/rol_index',$data);
    }

    public function nuevo(){
        $this->load->library('layout','layout');
         $datos_roles = $this->rol_model->listar_roles();
        $arreglo = array(''=>'::Selecione::');
        foreach($datos_roles as $indice=>$valor){
            $indice1   = $valor->ROL_Codigo;
            $valor1    = $valor->ROL_Descripcion;
            $arreglo[$indice1] = $valor1;
        }
        $lblNombres = form_label('NOMBRE','nombre');

        $txtNombre = form_input(array('name'=>'txtRol','id'=>'txtRol','value'=>'','maxlength'=>'30','class'=>'cajaMedia'));

        $cboRol     = form_dropdown('cboRol',$arreglo,'large',"id='cboRol' class='fuente8'");
        $oculto     = form_hidden(array('accion'=>"",'codigo'=>"",'modo'=>"insertar",'base_url'=>base_url()));
        $data['titulo']     = "REGISTRAR ROL";
        $data['formulario'] = "frmRol";
        $data['campos']     = array($lblNombres);
        $data['valores']    = array($txtNombre);
        $data['oculto']     = $oculto;
        $data['onload']     = "onload=\"$('#txtNombre').focus();\"";
        $this->layout->view('seguridad/rol_nuevo',$data);
    }

    public function editar($codigo){
        $this->load->library('layout','layout');
        $datos_rol  = $this->rol_model->obtener_rol($codigo);
        $descripcion = $datos_rol[0]->ROL_Descripcion;
        $lblRol    = form_label('NOMBRE ROL','rol');
        $txtRol    = form_input(array('name'=>'txtRol','id'=>'txtRol','value'=>$descripcion,'maxlength'=>'50','class'=>'cajaMedia'));
        $oculto     = form_hidden(array('rol_id'=>$codigo,'base_url'=>base_url()));
        $data['titulo']     = "EDITAR ROL";
        $data['formulario'] = "frmRol";
        $data['campos']     = array($lblRol);
        $data['valores']    = array($txtRol);
        $data['oculto']     = $oculto;
                $data['codigo'] = $codigo;
        $data['onload']     = "onload=\"$('#txtRol').select();$('#txtRol').focus();\"";
        $this->layout->view('seguridad/rol_nuevo',$data);
    }
        
    public function grabar(){
        $this->form_validation->set_rules('txtRol','Nombre de rol','required'); 
        if($this->form_validation->run() == FALSE){
           $this->nuevo();

        }
        else{
            $descripcion  = $this->input->post('txtRol');
            $checkO = $this->input->post('checkO');
            $rol_id   = $this->input->post("rol_id");
        if(is_array($checkO))          
            $filter = new stdClass();
            $filter->ROL_Descripcion = strtoupper($descripcion);
            if(isset($rol_id) && $rol_id>0){
             $this->rol_model->modificar($rol_id,$filter,$checkO);
            }
            else{
               $filter->COMPP_Codigo = $this->compania;
               $this->rol_model->insertar($filter,$checkO);
            }
            header("location:".base_url()."index.php/seguridad/rol/listar");
        }
              
      }

    public function eliminar(){
       $rol = $this->input->post('rol');
       $this->rol_model->eliminar($rol);
        
    }
    
    public function buscar_roles($j='0'){
        $this->load->library('layout','layout');
        $nombres  = $this->input->post('txtNombre');           
        $data['txtNombre']     = $nombres;
        $filter   = new stdClass();
        $filter->nombres = $nombres;           
        $data['registros']   = count($this->rol_model->buscar_roles($filter));
        $conf['base_url']    = site_url('seguridad/rol/buscar_roles/');
        $conf['total_rows']  = $data['registros'];
        $conf['per_page']    = 10;
        $conf['num_links']   = 3;
        $conf['next_link']   = "&gt;";
        $conf['prev_link']   = "&lt;";
        $conf['first_link']  = "&lt;&lt;";
        $conf['last_link']   = "&gt;&gt;";
        $conf['uri_segment'] = 4;
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $listado_roles   = $this->rol_model->buscar_roles($filter,$conf['per_page'],$j);
        $item               = $j+1;
        $lista              = array();
        if(count($listado_roles)>0){
                foreach($listado_roles as $indice=>$valor)
                {
                    $codigo         = $valor->ROL_Codigo;
                    $nombre_rol     = $valor->ROL_Descripcion;
                    if ($nombre_rol != 'SISTEMAS'){
                        $editar         = "<a href='javascript:;' onclick='editar_rol(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                        $ver            = "<a href='javascript:;' onclick='ver_rol(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                        $eliminar       = "<a href='javascript:;' onclick='eliminar_rol(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                        $lista[]        = array($item,$nombre_rol,$editar,$ver,$eliminar);
                        $item++;
                    }
                    else
                        $data['registros']--;
                }
            }
            $data['action']         = base_url()."index.php/seguridad/rol/buscar_roles";
            $data['titulo_tabla']   = "RESULTADO DE BUSQUEDA de ROLES";
            $data['titulo_busqueda']= "BUSCAR ROLES";
            $data['lista']      = $lista;
            $data['oculto']     = form_hidden(array('base_url'=>base_url()));
            $this->layout->view('seguridad/rol_index',$data);
    }
    public function ver($codigo){
            $this->load->library('layout','layout');
            $data['datos_rol']    = $this->rol_model->obtener_rol($codigo);
            $data['titulo']       = "VER ROL";
            $data['oculto']       = form_hidden(array('base_url'=>base_url()));
            $this->layout->view('seguridad/rol_ver',$data);
    }
    public function JSON_listar_rol(){
            echo json_encode($this->rol_model->listar_roles());
    }
    
}
?>