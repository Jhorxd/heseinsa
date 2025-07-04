<?php
class Menu extends Controller {

    private $compania;
    private $usuario;
    private $url;

    public function __construct() {
        parent::__construct();

        
        $this->load->model('seguridad/menu_model');
        $this->load->model('seguridad/permiso_model');

        $this->compania = $this->session->userdata("compania");
        $this->usuario = $this->session->userdata("user");
        $this->url = base_url();
    }

    public function index() {
        $data['titulo'] = "MENUS";
        $data['base_url'] = $this->url;
        $data['modulos'] = $this->menu_model->getModulos();
        $this->layout->view('basedatos/menu_index', $data);
    }

    public function datatable_menu(){

        $columnas = array(
                            0 => "modulo",
                            1 => "MENU_Descripcion",
                            2 => "MENU_Titulo",
                            3 => "MENU_Url",
                            4 => "MENU_AccesoRapido",
                            5 => "MENU_OrderBy",
                            6 => "estado"
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

        $filter->menu = $this->input->post('menu');
        $filter->modulo = $this->input->post('modulo');

        $menuInfo = $this->menu_model->getMenus($filter);
        $lista = array();
        
        if (count($menuInfo) > 0) {
            foreach ($menuInfo as $indice => $valor) {
                $btn_modal = "<button type='button' onclick='editar($valor->MENU_Codigo)' class='btn btn-default'>
                                <img src='".$this->url."/images/modificar.png' class='image-size-1b'>
                            </button>";

                if ($valor->MENU_FlagEstado == 1){
                    $btn_estado = "<button type='button' onclick='deshabilitar($valor->MENU_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/documento-delete.png' class='image-size-1b'>
                                </button>";
                }
                else{
                    $btn_estado = "<button type='button' onclick='habilitar($valor->MENU_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/documento-add.png' class='image-size-1b'>
                                </button>";
                }

                $colorAcceso = ($valor->MENU_AccesoRapido == '0') ? "color-red" : 'color-green';
                $colorEstado = ($valor->MENU_FlagEstado == '0') ? "color-red" : 'color-green';

                $lista[] = array(
                                    0 => ($valor->modulo == "") ? "Modulo" : $valor->modulo,
                                    1 => $valor->MENU_Descripcion,
                                    2 => $valor->MENU_Titulo,
                                    3 => $valor->MENU_Url,
                                    4 => "<span class='bold $colorAcceso'>$valor->acceso</span>",
                                    5 => $valor->MENU_OrderBy,
                                    6 => "<span class='bold $colorEstado'>$valor->estado</span>",
                                    7 => $btn_modal,
                                    8 => $btn_estado
                                );
            }
        }

        unset($filter->start);
        unset($filter->length);

        $json = array(
                            "draw"            => intval( $this->input->post('draw') ),
                            "recordsTotal"    => count($this->menu_model->getMenus()),
                            "recordsFiltered" => intval( count($this->menu_model->getMenus($filter)) ),
                            "data"            => $lista
                    );

        echo json_encode($json);
    }

    public function getMenu(){
        
        $codigo = $this->input->post("menu");

        $menuInfo = $this->menu_model->getMenu($codigo);
        $lista = array();
        
        if ( $menuInfo != NULL ){
            foreach ($menuInfo as $indice => $val) {
                $lista = array(
                                    "menu" => $val->MENU_Codigo,
                                    "padre" => $val->MENU_Codigo_Padre,
                                    "descripcion" => $val->MENU_Descripcion,
                                    "titulo" => $val->MENU_Titulo,
                                    "url" => $val->MENU_Url,
                                    "access" => $val->MENU_AccesoRapido,
                                    "order" => $val->MENU_OrderBy,
                                    "icon" => $val->MENU_Icon
                                );
            }

            $json = array("match" => true, "info" => $lista);
        }
        else
            $json = array("match" => false, "info" => "");

        echo json_encode($json);
    }

    public function guardar_registro(){

        $menu = $this->input->post("menu");
        
        $padre = $this->input->post("modulo_padre");
        $descripcion = $this->input->post("modulo_descripcion");
        $titulo = $this->input->post("modulo_titulo");
        $url = $this->input->post("modulo_url");
        $access = $this->input->post("modulo_access");
        $order = $this->input->post("modulo_order");
        $icono = $this->input->post("modulo_icono");

        $filter = new stdClass();
        $filter->MENU_Codigo_Padre = $padre;
        $filter->MENU_Descripcion = $descripcion;
        $filter->MENU_Titulo = $titulo;
        $filter->MENU_Url = $url;
        $filter->MENU_AccesoRapido = $access;
        $filter->MENU_OrderBy = $order;
        $filter->MENU_Icon = $icono;
        $filter->MENU_FlagEstado = "1";

        if ($menu != ""){
            $filter->MENU_Codigo = $menu;
            $filter->MENU_FechaModificacion = date("Y-m-d H:i:s");
            $result = $this->menu_model->actualizar($menu, $filter);
        }
        else{
            $filter->MENU_FechaRegistro = date("Y-m-d H:i:s");
            $menu = $this->menu_model->insertar($filter);

            ## REGISTRO EL PERMISO PARA EL USUARIO CCAPA
                $filterUsuarioPermiso = new stdClass();
                $filterUsuarioPermiso->ROL_Codigo = 7000; # 7000 ES EL ROL ASIGNADO AL USUARIO CCAPA
                $filterUsuarioPermiso->MENU_Codigo = $menu; 
                $filterUsuarioPermiso->COMPP_Codigo = $this->compania;
                $filterUsuarioPermiso->PERM_FlagEstado = 1;
                
                $result = $this->permiso_model->registrar_permiso($filterUsuarioPermiso);
        }

        if ($result)
            $json = array("result" => "success");
        else
            $json = array("result" => "error");
        
        echo json_encode($json);
    }

    public function habilitar_menu(){

        $menu = $this->input->post("menu");

        $filter = new stdClass();
        $filter->MENU_FlagEstado  = "1";

        if ($menu != ""){
            $result = $this->menu_model->actualizar($menu, $filter);

            $filterUsuarioPermiso = new stdClass();
            $filterUsuarioPermiso->ROL_Codigo = 7000; # 7000 ES EL ROL ASIGNADO AL USUARIO CCAPA
            $filterUsuarioPermiso->MENU_Codigo = $menu; 
            $filterUsuarioPermiso->COMPP_Codigo = $this->compania;
            $filterUsuarioPermiso->PERM_FlagEstado = 1;
            
            $result = $this->permiso_model->registrar_permiso($filterUsuarioPermiso);
        }

        if ($result)
            $json = array("result" => "success");
        else
            $json = array("result" => "error");
        
        echo json_encode($json);
    }

    public function deshabilitar_menu(){

        $menu = $this->input->post("menu");

        $filter = new stdClass();
        $filter->MENU_FlagEstado  = "0";

        if ($menu != ""){
            $result = $this->menu_model->actualizar($menu, $filter);
            $this->permiso_model->delete_menu_permiso($menu);
        }

        if ($result)
            $json = array("result" => "success");
        else
            $json = array("result" => "error");
        
        echo json_encode($json);
    }
}
?>