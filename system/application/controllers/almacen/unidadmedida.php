<?php
class Unidadmedida extends controller{

    private $empresa;
    private $compania;
    private $url;

    public function __construct(){
        parent::__construct();
        $this->load->model('almacen/unidadmedida_model');
        $this->load->helper('form','url');
        
        $this->load->library('pagination');
        $this->load->library('form_validation');
        
        
        $this->empresa = $this->session->userdata('empresa');
        $this->compania = $this->session->userdata('compania');
        $this->url = base_url();
    }

    #########################
    ###### FUNCTIONS NEWS
    #########################

        public function listar(){
            $data['base_url'] = $this->url;
            $data['titulo_busqueda'] = "BUSCAR UNIDAD DE MEDIDA";
            $data['titulo'] = "RELACIÓN DE UNIDADES DE MEDIDA";
            $this->layout->view('almacen/unidadmedida_index', $data);
        }

        public function datatable_um(){

            $columnas = array(
                                0 => "",
                                1 => "UNDMED_Simbolo",
                                2 => "UNDMED_Descripcion"
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

            $umInfo = $this->unidadmedida_model->getUmedidas($filter);
            $lista = array();
            
            if (count($umInfo) > 0) {
                foreach ($umInfo as $indice => $valor) {
                    $btn_modal = "<button type='button' onclick='editar($valor->UNDMED_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/modificar.png' class='image-size-1b'>
                                </button>";

                    $btn_eliminar = "<button type='button' onclick='deshabilitar($valor->UNDMED_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/documento-delete.png' class='image-size-1b'>
                                </button>";

                    $lista[] = array(
                                        0 => $indice + 1,
                                        1 => $valor->UNDMED_Simbolo,
                                        2 => $valor->UNDMED_Descripcion,
                                        3 => $btn_modal,
                                        4 => $btn_eliminar
                                    );
                }
            }

            unset($filter->start);
            unset($filter->length);

            $json = array(
                                "draw"            => intval( $this->input->post('draw') ),
                                "recordsTotal"    => count($this->unidadmedida_model->getUmedidas()),
                                "recordsFiltered" => intval( count($this->unidadmedida_model->getUmedidas($filter)) ),
                                "data"            => $lista
                        );

            echo json_encode($json);
        }

        public function getUnidad(){

            $um = $this->input->post("um");

            $umInfo = $this->unidadmedida_model->getUmedida($um);
            $lista = array();
            
            if ( $umInfo != NULL ){
                foreach ($umInfo as $indice => $val) {
                    $lista = array(
                                        "um" => $val->UNDMED_Codigo,
                                        "simbolo" => $val->UNDMED_Simbolo,
                                        "descripcion" => $val->UNDMED_Descripcion
                                    );
                }

                $json = array("match" => true, "info" => $lista);
            }
            else
                $json = array("match" => false, "info" => "");

            echo json_encode($json);
        }

        public function guardar_registro(){

            $um = $this->input->post("um");
            $descripcion_um = $this->input->post("descripcion_um");
            $simbolo_um = $this->input->post("simbolo_um");
            
            $filter = new stdClass();
            $filter->UNDMED_Descripcion = strtoupper($descripcion_um);
            $filter->UNDMED_Simbolo = $simbolo_um;
            $filter->UNDMED_FlagEstado = "1";

            if ($um != ""){
                $filter->UNDMED_Codigo = $um;
                $filter->UNDMED_FechaModificacion = date("Y-m-d H:i:s");
                $result = $this->unidadmedida_model->actualizar_unidad($um, $filter);
            }
            else{
                $filter->UNDMED_FechaRegistro = date("Y-m-d H:i:s");
                $result = $this->unidadmedida_model->insertar_unidad($filter);
            }

            if ($result)
                $json = array("result" => "success");
            else
                $json = array("result" => "error");
            
            echo json_encode($json);
        }

        public function deshabilitar_um(){

            $um = $this->input->post("um");

            $filter = new stdClass();
            $filter->UNDMED_FlagEstado  = "0";

            if ($um != ""){
                $filter->UNDMED_FechaModificacion = date("Y-m-d H:i:s");
                $result = $this->unidadmedida_model->deshabilitar_unidad($um, $filter);
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

    public function listar_old($j='0'){
        
        $data['registros']  = count($this->unidadmedida_model->listar());
        $conf['base_url']   = site_url('almacen/unidadmedida/listar/');
        $conf['total_rows'] = $data['registros'];
        $conf['per_page']   = 10;
        $conf['num_links']  = 3;
        $conf['next_link'] = "&gt;";
        $conf['prev_link'] = "&lt;";
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link']  = "&gt;&gt;";
        $conf['uri_segment'] = 4;
        $offset             = (int)$this->uri->segment(4);
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $listado            = $this->unidadmedida_model->listar($conf['per_page'],$offset);
        $item               = $j+1;
        foreach($listado as $indice=>$valor)
        {
            $codigo         = $valor->UNDMED_Codigo;
            $editar         = "<a href='#' onclick='editar_unidadmedida(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
            $ver            = "<a href='#' onclick='ver_unidadmedida(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
            $eliminar       = "<a href='#' onclick='eliminar_unidadmedida(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
            $lista[]        = array($item++,$valor->UNDMED_Descripcion,$valor->UNDMED_Simbolo,$editar,$ver,$eliminar);
        }
        $data['lista']           = $lista;
        $data['titulo_busqueda'] = "BUSCAR UNIDAD MEDIDA";
        $data['nombre_unidadmedida'] = form_input(array( 'name'  => 'nombre_unidadmedida','id' => 'nombre_unidadmedida','value' => '','maxlength' => '100','class' => 'cajaMedia'));
        $data['simbolo']         = form_input(array( 'name'  => 'simbolo','id' => 'simbolo','value' => '','maxlength' => '100','class' => 'cajaMedia'));
        $data['form_open']       = form_open(base_url().'index.php/almacen/unidadmedida/buscar',array("name"=>"form_busquedaUnidadmedida","id"=>"form_busquedaUnidadmedida"));
        $data['form_close']      = form_close();
        $data['titulo_tabla']    = "Relaci&oacute;n UNIDAD DE MEDIDAS";
        $data['oculto']          = form_hidden(array('accion'=>"",'codigo'=>"",'modo'=>"insertar",'base_url'=>base_url()));	
        $this->layout->view('almacen/unidadmedida_index',$data);
			
    }
    public function nueva()
    {
        $lblDescripcion     = form_label("Nombre Unidad","Nombre Unidad de medida");
        $lblSimbolo         = form_label('Simbolo','Simbolo');
        $nombre_unidadmedida     = form_input(array( 'name'  => 'nombre_unidadmedida','id' => 'nombre_unidadmedida','value' => '','maxlength' => '100','class' => 'cajaMedia'));
        $simbolo            = form_input(array( 'name'  => 'simbolo','id' => 'simbolo','value' => '','maxlength' => '100','class' => 'cajaMedia'));
        $data['titulo']     = "REGISTRAR UNIDAD DE MEDIDA";
        $data['form_open']  = form_open(base_url().'index.php/almacen/unidadmedida/grabar',array("name"=>"frmUnidadmedida","id"=>"frmUnidadmedida"));
        $data['form_close'] = form_close();
        $data['campos']     = array($lblDescripcion,$lblSimbolo);
        $data['valores']    = array($nombre_unidadmedida,$simbolo);
        $data['oculto']     = form_hidden(array('codigo'=>"",'base_url'=>base_url(),'unidadmedida_id'=>''));
        $data['onload']	    = "onload=\"$('#nombres').focus();\"";
        $this->layout->view('almacen/unidadmedida_nueva',$data);
    }
    public function editar($id)
    {
        
        $oUnidadmedida          = $this->unidadmedida_model->obtener($id);
        $lblDescripcion         = form_label("Nombre Unidad","Nombre Unidad de medida");
        $lblSimbolo             = form_label("Simbolo","Simbolo");
        $nombre_unidadmedida    = form_input(array( 'name'  => 'nombre_unidadmedida','id' => 'nombre_unidadmedida','value' => $oUnidadmedida[0]->UNDMED_Descripcion,'maxlength' => '100','class' => 'cajaMedia'));
        $simbolo                = form_input(array( 'name'  => 'simbolo','id' => 'simbolo','value' => $oUnidadmedida[0]->UNDMED_Simbolo,'maxlength' => '100','class' => 'cajaMedia'));
        $data['form_open']      = form_open(base_url().'index.php/almacen/unidadmedida/grabar/',array("name"=>"frmUnidadmedida","id"=>"frmUnidadmedida"));
        $data['campos']         = array($lblDescripcion,$lblSimbolo);
        $data['valores']        = array($nombre_unidadmedida,$simbolo);
        $data['oculto']         = form_hidden(array('codigo'=>"",'base_url'=>base_url(),'unidadmedida_id'=>$id));
        $data['form_hidden']    = form_hidden("base_url",base_url());
        $data['form_close']     = form_close();
        $data['unidadmedida_id']= form_hidden("unidadmedida_id",$id);
        $data['titulo']  = "EDITAR UNIDAD MEDIDA";
        $this->layout->view('almacen/unidadmedida_nueva',$data);
    }
    public function grabar()
    {
        $this->form_validation->set_rules('nombre_unidadmedida','Nombre de unidad medida','required');
        $this->form_validation->set_rules('simbolo','Simbolo','required');
        if($this->form_validation->run() == FALSE){
            $this->nueva();
        }
        else{
            $nombre_unidadmedida  = $this->input->post("nombre_unidadmedida");
            $simbolo = $this->input->post("simbolo");
            $unidadmedida_id = $this->input->post("unidadmedida_id");
            $filter = new stdClass();
            $filter->UNDMED_Descripcion = strtoupper($nombre_unidadmedida);
            $filter->UNDMED_Simbolo     = $simbolo;
            if(isset($unidadmedida_id) && $unidadmedida_id>0){
              $this->unidadmedida_model->modificar($unidadmedida_id,$filter);
            }
            else{
               $this->unidadmedida_model->insertar($filter);
            }
            header("location:".base_url()."index.php/almacen/unidadmedida/listar");
        }
    }
    public function eliminar()
    {
        $id = $this->input->post('unidadmedida');
        $this->unidadmedida_model->eliminar($id);
    }
    public function ver($codigo)
    {
        
        $datos_umedida         = $this->unidadmedida_model->obtener($codigo);
        $nombre_umedida        = $datos_umedida[0]->UNDMED_Descripcion;
        $simbolo               = $datos_umedida[0]->UNDMED_Simbolo;
        $data['nombre_unidadmedida']     = $nombre_umedida;
        $data['simbolo']       = $simbolo;
        $data['titulo']        = "VER UNIDAD MEDIDA";
        $data['oculto']        = form_hidden(array('base_url'=>base_url()));
        $this->layout->view('almacen/unidadmedida_ver',$data);
    }
    public function buscar($j=0)
    {
        $this->load->library('layout','layout');
        $nombre_unidadmedida    = $this->input->post('nombre_unidadmedida');
        $simbolo                = $this->input->post('simbolo');
        $filter = new stdClass();
        $filter->UNDMED_Descripcion = $nombre_unidadmedida;
        $filter->UNDMED_Simbolo     = $simbolo;
        $data['registros']      = count($this->unidadmedida_model->buscar($filter));
        $conf['base_url']       = site_url('maestros/unidadmedida/buscar/');
        $conf['total_rows']     = $data['registros'];
        $conf['per_page']       = 10;
        $conf['num_links']      = 3;
        $conf['first_link']     = "&lt;&lt;";
        $conf['last_link']      = "&gt;&gt;";
        $offset                 = (int)$this->uri->segment(4);
        $listado                = $this->unidadmedida_model->buscar($filter,$conf['per_page'],$offset);
        $item                   = $j+1;
        $lista                  = array();
        if(count($listado)>0){
            foreach($listado as $indice=>$valor){
                $codigo       = $valor->UNDMED_Codigo;
                $editar       = "<a href='#' onclick='editar_unidadmedida(".$codigo.")' target='_parent'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver          = "<a href='#' onclick='ver_unidadmedida(".$codigo.")' target='_parent'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                $eliminar     = "<a href='#' onclick='eliminar_unidadmedida(".$codigo.")' target='_parent'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $lista[]      = array($item++,$valor->UNDMED_Descripcion,$valor->UNDMED_Simbolo,$editar,$ver,$eliminar);
            }
        }
        $data['titulo_tabla']    = "RESULTADO DE BUSQUEDA de UNIDADES DE MEDIDA";
        $data['titulo_busqueda'] = "BUSCAR UNIDAD MEDIDA";
        $data['nombre_unidadmedida'] = form_input(array( 'name'  => 'nombre_unidadmedida','id' => 'nombre_unidadmedida','value' => $nombre_unidadmedida,'maxlength' => '100','class' => 'cajaMedia'));
        $data['simbolo']         = form_input(array( 'name'  => 'simbolo','id' => 'simbolo','value' => $simbolo,'maxlength' => '100','class' => 'cajaMedia'));
        $data['form_open']       = form_open(base_url().'index.php/almacen/unidadmedida/buscar',array("name"=>"form_busquedaUnidadmedida","id"=>"form_busquedaUnidadmedida"));
        $data['form_close']      = form_close();
        $data['lista']           = $lista;
        $data['oculto']          = form_hidden(array('base_url'=>base_url()));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('almacen/unidadmedida_index',$data);
    }
}
?>