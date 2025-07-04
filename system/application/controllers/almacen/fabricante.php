<?php
class Fabricante extends controller{

    private $empresa;
    private $compania;
    private $url;

    public function __construct(){
        parent::__construct();
        
        $this->load->helper('html');
        $this->load->helper('url');
        
        $this->load->library('pagination');
        $this->load->library('html');
        $this->load->library('form_validation');
        
        
        $this->load->model('almacen/fabricante_model');

        $this->empresa = $this->session->userdata('empresa');
        $this->compania = $this->session->userdata('compania');
        $this->url = base_url();
    }

    #########################
    ###### FUNCTIONS NEWS
    #########################

        public function listar(){
            $data['base_url'] = $this->url;
            $data['titulo_busqueda'] = "BUSCAR FABRICANTES";
            $data['titulo'] = "RELACIÓN DE FABRICANTES";
            $this->layout->view('almacen/fabricante_index', $data);
        }

        public function datatable_fabricante(){

            $columnas = array(
                                0 => "",
                                1 => "FABRIC_CodigoUsuario",
                                2 => "FABRIC_Descripcion"
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

            $filter->descripcion = $this->input->post('descripcion');

            $fabricanteInfo = $this->fabricante_model->getFabricantes($filter);
            $lista = array();
            
            if (count($fabricanteInfo) > 0) {
                foreach ($fabricanteInfo as $indice => $valor) {
                    $btn_modal = "<button type='button' onclick='editar($valor->FABRIP_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/modificar.png' class='image-size-1b'>
                                </button>";

                    $btn_eliminar = "<button type='button' onclick='deshabilitar($valor->FABRIP_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/documento-delete.png' class='image-size-1b'>
                                </button>";

                    $lista[] = array(
                                        0 => $indice + 1,
                                        1 => $valor->FABRIC_CodigoUsuario,
                                        2 => $valor->FABRIC_Descripcion,
                                        3 => $btn_modal,
                                        4 => $btn_eliminar
                                    );
                }
            }

            unset($filter->start);
            unset($filter->length);

            $json = array(
                                "draw"            => intval( $this->input->post('draw') ),
                                "recordsTotal"    => count($this->fabricante_model->getFabricantes()),
                                "recordsFiltered" => intval( count($this->fabricante_model->getFabricantes($filter)) ),
                                "data"            => $lista
                        );

            echo json_encode($json);
        }

        public function getFabricante(){

            $fabricante = $this->input->post("fabricante");

            $fabricanteInfo = $this->fabricante_model->getFabricante($fabricante);
            $lista = array();
            
            if ( $fabricanteInfo != NULL ){
                foreach ($fabricanteInfo as $indice => $val) {
                    $lista = array(
                                        "fabricante" => $val->FABRIP_Codigo,
                                        "codigo" => $val->FABRIC_CodigoUsuario,
                                        "descripcion" => $val->FABRIC_Descripcion
                                    );
                }

                $json = array("match" => true, "info" => $lista);
            }
            else
                $json = array("match" => false, "info" => "");

            echo json_encode($json);
        }

        public function guardar_registro(){

            $fabricante = $this->input->post("fabricante");
            $codigo_fabricante = $this->input->post("codigo_fabricante");
            $descripcion_fabricante = $this->input->post("descripcion_fabricante");
            
            $filter = new stdClass();
            $filter->FABRIC_Descripcion = strtoupper($descripcion_fabricante);
            $filter->FABRIC_CodigoUsuario = $codigo_fabricante;
            $filter->FABRIC_FlagEstado = "1";

            if ($fabricante != ""){
                $filter->FABRIP_Codigo = $fabricante;
                $filter->FABRIC_FechaModificacion = date("Y-m-d H:i:s");
                $result = $this->fabricante_model->actualizar_fabricante($fabricante, $filter);
            }
            else{
                $filter->FABRIC_FechaRegistro = date("Y-m-d H:i:s");
                $result = $this->fabricante_model->insertar_fabricante($filter);
            }

            if ($result)
                $json = array("result" => "success");
            else
                $json = array("result" => "error");
            
            echo json_encode($json);
        }

        public function deshabilitar_fabricante(){

            $fabricante = $this->input->post("fabricante");

            $filter = new stdClass();
            $filter->FABRIC_FlagEstado  = "0";

            if ($fabricante != ""){
                $filter->FABRIC_FechaModificacion = date("Y-m-d H:i:s");
                $result = $this->fabricante_model->deshabilitar_fabricante($fabricante, $filter);
            }

            if ($result)
                $json = array("result" => "success");
            else
                $json = array("result" => "error");
            
            echo json_encode($json);
        }

    #########################
    ###### FUNCTIONS OLDS
    #########################

    public function nuevo(){
        
        $lblDescripcion     = form_label("NOMBRE FABRICANTE","Nombre Fabricante");
        $lblCodigoUsuario    = form_label("Código","CodigoUsuario");
        $nombre_fabricante   = form_input(array( 'name'  => 'nombre_fabricante','id' => 'nombre_fabricante','value' => '','maxlength' => '100','class' => 'cajaMedia'));
        $codigo_usuario     = form_input(array( 'name'  => 'codigo_usuario','id' => 'codigo_usuario','value' => '','maxlength' => '20','class' => 'cajaPequena'));
        $data['titulo']     = "REGISTRAR FABRICANTE";
        $data['form_open']  = form_open(base_url().'index.php/fabricante/fabricante/grabar',array("name"=>"frmFabricante","id"=>"frmFabricante"));
        $data['form_close'] = form_close();
        $data['campos']     = array($lblDescripcion, $lblCodigoUsuario);
        $data['valores']    = array($nombre_fabricante, $codigo_usuario);
        $data['oculto']     = form_hidden(array('codigo'=>"",'base_url'=>base_url(),'fabricante_id'=>''));
        $data['onload']	    = "onload=\"$('#nombres').focus();\"";
        $this->layout->view('fabricante/fabricante_nuevo',$data);
    }

    public function editar($id){
        
        $oFabricante            = $this->fabricante_model->obtener($id);
        $lblDescripcion         = form_label("Nombre Fabricante","Nombre Fabricante");
        $lblCodigoUsuario    = form_label("Código","CodigoUsuario");
        $nombre_fabricante       = form_input(array( 'name'  => 'nombre_fabricante','id' => 'nombre_fabricante','value' => $oFabricante[0]->FABRIC_Descripcion,'maxlength' => '100','class' => 'cajaMedia'));
        $codigo_usuario     = form_input(array( 'name'  => 'codigo_usuario','id' => 'codigo_usuario','value' => $oFabricante[0]->FABRIC_CodigoUsuario,'maxlength' => '20','class' => 'cajaPequena'));
        $data['form_open']      = form_open(base_url().'index.php/fabricante/fabricante/grabar/',array("name"=>"frmFabricante","id"=>"frmFabricante"));
        $data['campos']         = array($lblDescripcion, $lblCodigoUsuario);
        $data['valores']        = array($nombre_fabricante, $codigo_usuario);
        $data['oculto']         = form_hidden(array('codigo'=>"",'base_url'=>base_url(),'fabricante_id'=>$id));
        $data['form_hidden']    = form_hidden("base_url",base_url());
        $data['form_close']     = form_close();
        $data['titulo']  = "EDITAR FABRICANTE";
        $this->layout->view('fabricante/fabricante_nuevo',$data);
    }

    public function grabar(){
        $this->form_validation->set_rules('nombre_fabricante','Nombre de fabricante','required');
        if($this->form_validation->run() == FALSE){
            $this->nuevo();
        }
        else{
            $descripcion  = $this->input->post("nombre_fabricante");
            $fabricante_id   = $this->input->post("fabricante_id");
            $codigo_usuario   = $this->input->post("codigo_usuario");
            $filter = new stdClass();
            $filter->FABRIC_Descripcion = strtoupper($descripcion);
            $filter->FABRIC_CodigoUsuario = $codigo_usuario;
            if(isset($fabricante_id) && $fabricante_id>0){
              $this->fabricante_model->modificar($fabricante_id,$filter);
            }
            else{
               $this->fabricante_model->insertar($filter);
            }
            header("location:".base_url()."index.php/fabricante/fabricante/listar");
        }
    }

    public function eliminar()
    {
        $id = $this->input->post('fabricante');
        $this->fabricante_model->eliminar($id);
    }

    public function ver($codigo){
        
        $datos_fabricante       = $this->fabricante_model->obtener($codigo);
        $data['nombre_fabricante']= $datos_fabricante[0]->FABRIC_Descripcion;
        $data['fabricante']    = $datos_fabricante[0]->FABRIP_Codigo;
        $data['titulo']        = "VER FABRICANTE";
        $data['oculto']        = form_hidden(array('base_url'=>base_url()));
        $this->layout->view('fabricante/fabricante_ver',$data);
    }

    public function buscar($j=0){
        $this->load->library('layout','layout');
        $nombre_fabricante = $this->input->post('nombre_fabricante');
        $filter = new stdClass();
        $filter->FABRIC_Descripcion = $nombre_fabricante;
        $data['registros']      = count($this->fabricante_model->buscar($filter));
        $conf['base_url']       = site_url('maestros/fabricante/buscar/');
        $conf['total_rows']     = $data['registros'];
        $conf['per_page']       = 10;
        $conf['num_links']      = 3;
        $conf['first_link']     = "&lt;&lt;";
        $conf['last_link']      = "&gt;&gt;";
        $offset                 = (int)$this->uri->segment(4);
        $listado                = $this->fabricante_model->buscar($filter,$conf['per_page'],$offset);
        $item                   = $j+1;
        $lista                  = array();
        if(count($listado)>0){
            foreach($listado as $indice=>$valor){
                $codigo       = $valor->FABRIP_Codigo;
                $editar       = "<a href='#' onclick='editar_fabricante(".$codigo.")' target='_parent'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver          = "<a href='#' onclick='ver_fabricante(".$codigo.")' target='_parent'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                $eliminar     = "<a href='#' onclick='eliminar_fabricante(".$codigo.")' target='_parent'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $lista[]      = array($item++,$valor->FABRIC_Descripcion,$valor->FABRIC_CodigoUsuario,$editar,$ver,$eliminar);
            }
        }
        $data['titulo_tabla']    = "RESULTADO DE BUSQUEDA de FABRICANTES";
        $data['titulo_busqueda'] = "BUSCAR FABRICANTE";
        $data['nombre_fabricante']  = form_input(array( 'name'  => 'nombre_fabricante','id' => 'nombre_fabricante','value' => $nombre_fabricante,'maxlength' => '100','class' => 'cajaMedia'));
        $data['form_open']       = form_open(base_url().'index.php/fabricante/fabricante/buscar',array("name"=>"form_busquedaFabricante","id"=>"form_busquedaFabricante"));
        $data['form_close']      = form_close();
        $data['lista']           = $lista;
        $data['oculto']          = form_hidden(array('base_url'=>base_url()));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('fabricante/fabricante_index',$data);
    }
}
?>