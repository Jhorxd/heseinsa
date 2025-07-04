<?php

class Linea extends controller{

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
        
        
        $this->load->model('almacen/linea_model');
                
        $this->empresa = $this->session->userdata('empresa');
        $this->compania = $this->session->userdata('compania');
        $this->url = base_url();
    }

    #########################
    ###### FUNCTIONS NEWS
    #########################

        public function listar(){
            $data['base_url'] = $this->url;
            $data['titulo_busqueda'] = "BUSCAR LINEAS";
            $data['titulo'] = "RELACIÓN DE LINEAS";
            $this->layout->view('almacen/linea_index', $data);
        }

        public function datatable_linea(){

            $columnas = array(
                                0 => "",
                                1 => "LINC_CodigoUsuario",
                                2 => "LINC_Descripcion"
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

            $lineaInfo = $this->linea_model->getLineas($filter);
            $lista = array();
            
            if (count($lineaInfo) > 0) {
                foreach ($lineaInfo as $indice => $valor) {
                    $btn_modal = "<button type='button' onclick='editar($valor->LINP_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/modificar.png' class='image-size-1b'>
                                </button>";

                    $btn_eliminar = "<button type='button' onclick='deshabilitar($valor->LINP_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/documento-delete.png' class='image-size-1b'>
                                </button>";

                    $lista[] = array(
                                        0 => $indice + 1,
                                        1 => $valor->LINC_CodigoUsuario,
                                        2 => $valor->LINC_Descripcion,
                                        3 => $btn_modal,
                                        4 => $btn_eliminar
                                    );
                }
            }

            unset($filter->start);
            unset($filter->length);

            $json = array(
                                "draw"            => intval( $this->input->post('draw') ),
                                "recordsTotal"    => count($this->linea_model->getLineas()),
                                "recordsFiltered" => intval( count($this->linea_model->getLineas($filter)) ),
                                "data"            => $lista
                        );

            echo json_encode($json);
        }

        public function getLinea(){

            $linea = $this->input->post("linea");

            $lineaInfo = $this->linea_model->getLinea($linea);
            $lista = array();
            
            if ( $lineaInfo != NULL ){
                foreach ($lineaInfo as $indice => $val) {
                    $lista = array(
                                        "linea" => $val->LINP_Codigo,
                                        "codigo" => $val->LINC_CodigoUsuario,
                                        "descripcion" => $val->LINC_Descripcion
                                    );
                }

                $json = array("match" => true, "info" => $lista);
            }
            else
                $json = array("match" => false, "info" => "");

            echo json_encode($json);
        }

        public function guardar_registro(){

            $linea = $this->input->post("linea");
            $codigo_linea = $this->input->post("codigo_linea");
            $descripcion_linea = $this->input->post("descripcion_linea");
            
            $filter = new stdClass();
            $filter->LINC_Descripcion = strtoupper($descripcion_linea);
            $filter->LINC_CodigoUsuario = $codigo_linea;
            $filter->LINC_FlagEstado = "1";

            if ($linea != ""){
                $filter->LINP_Codigo = $linea;
                $filter->LINC_FechaModificacion = date("Y-m-d H:i:s");
                $result = $this->linea_model->actualizar_linea($linea, $filter);
            }
            else{
                $filter->LINC_FechaRegistro = date("Y-m-d H:i:s");
                $result = $this->linea_model->insertar_linea($filter);
            }

            if ($result)
                $json = array("result" => "success");
            else
                $json = array("result" => "error");
            
            echo json_encode($json);
        }

        public function deshabilitar_linea(){

            $linea = $this->input->post("linea");

            $filter = new stdClass();
            $filter->LINC_FlagEstado  = "0";

            if ($linea != ""){
                $filter->LINC_FechaModificacion = date("Y-m-d H:i:s");
                $result = $this->linea_model->deshabilitar_linea($linea, $filter);
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
        
        $data['nombre_linea']  = "";
        $data['registros']   = count($this->linea_model->listar());
        $conf['base_url']    = site_url('almacen/linea/listar/');
        $conf['total_rows']  = $data['registros'];
        $conf['per_page']    = 10;
        $conf['num_links']   = 3;
        $conf['next_link']   = "&gt;";
        $conf['prev_link']   = "&lt;";
        $conf['first_link']  = "&lt;&lt;";
        $conf['last_link']   = "&gt;&gt;";
        $conf['uri_segment'] = 4;
        $offset              = (int)$this->uri->segment(4);
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $listado            = $this->linea_model->listar($conf['per_page'],$offset);
        $item               = $j+1;
        $lista              = array();
        if(count($listado)>0){
        foreach($listado as $indice=>$valor)
            {
                $codigo         = $valor->LINP_Codigo;
                $editar         = "<a href='#' onclick='editar_linea(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver            = "<a href='#' onclick='ver_linea(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                $eliminar       = "<a href='#' onclick='eliminar_linea(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $lista[]        = array($item++,$valor->LINC_Descripcion,$valor->LINC_CodigoUsuario,$editar,$ver,$eliminar);
            }
        }
        $data['lista']            = $lista;
        $data['titulo_busqueda']  = "BUSCAR LINEA";
        $data['nombre_linea'] = form_input(array( 'name'  => 'nombre_linea','id' => 'nombre_linea','value' => '','maxlength' => '100','class' => 'cajaMedia'));
        $data['form_open']        = form_open(base_url().'index.php/almacen/linea/buscar',array("name"=>"form_busquedaLinea","id"=>"form_busquedaLinea"));
        $data['form_close']       = form_close();
        $data['titulo_tabla']     = "Relaci&oacute;n DE LINEAS";
        $data['oculto']           = form_hidden(array('accion'=>"",'codigo'=>"",'modo'=>"insertar",'base_url'=>base_url()));
        $this->layout->view('almacen/linea_index',$data);
			
    }
    public function nueva()
    {
        
        $lblDescripcion     = form_label("Nombre LINEA","Nombre LINEA");
        $lblCodigoUsuario       = form_label("Código","CodigoUsuario");
        $nombre_linea   = form_input(array( 'name'  => 'nombre_linea','id' => 'nombre_linea','value' => '','maxlength' => '100','class' => 'cajaMedia'));
        $codigo_usuario         = form_input(array( 'name'  => 'codigo_usuario','id' => 'codigo_usuario','value' => '','maxlength' => '20','class' => 'cajaPequena'));
        $data['titulo']     = "REGISTRAR LINEA";
        $data['form_open']  = form_open(base_url().'index.php/almacen/linea/grabar',array("name"=>"frmLinea","id"=>"frmLinea"));
        $data['form_close'] = form_close();
        $data['campos']     = array($lblDescripcion, $lblCodigoUsuario);
        $data['valores']    = array($nombre_linea, $codigo_usuario);
        $data['oculto']     = form_hidden(array('codigo'=>"",'base_url'=>base_url(),'linea_id'=>''));
        $data['onload']	    = "onload=\"$('#nombres').focus();\"";
        $this->layout->view('almacen/linea_nueva',$data);
    }
    public function editar($id)
    {
        
        $oLinea                 = $this->linea_model->obtener($id);
        $lblDescripcion         = form_label("Nombre Forma pago","Nombre Forma pago");
        $lblCodigoUsuario       = form_label("Código","CodigoUsuario");
        $nombre_linea       = form_input(array( 'name'  => 'nombre_linea','id' => 'nombre_linea','value' => $oLinea[0]->LINC_Descripcion,'maxlength' => '100','class' => 'cajaMedia'));
        $codigo_usuario         = form_input(array( 'name'  => 'codigo_usuario','id' => 'codigo_usuario','value' => $oLinea[0]->LINC_CodigoUsuario,'maxlength' => '20','class' => 'cajaPequena'));
        $data['form_open']      = form_open(base_url().'index.php/almacen/linea/grabar/',array("name"=>"frmLinea","id"=>"frmLinea"));
        $data['campos']         = array($lblDescripcion, $lblCodigoUsuario);
        $data['valores']        = array($nombre_linea, $codigo_usuario);
        $data['oculto']         = form_hidden(array('codigo'=>"",'base_url'=>base_url(),'linea_id'=>$id));
        $data['form_hidden']    = form_hidden("base_url",base_url());
        $data['form_close']     = form_close();
        $data['titulo']  = "EDITAR LINEA";
        $this->layout->view('almacen/linea_nueva',$data);
    }
    public function grabar()
    {
        $this->form_validation->set_rules('nombre_linea','Nombre de LINEA','required');
        if($this->form_validation->run() == FALSE){
            $this->nuevo();
        }
        else{
            $descripcion  = $this->input->post("nombre_linea");
            $linea_id   = $this->input->post("linea_id");
            $codigo_usuario   = $this->input->post("codigo_usuario");
            $filter = new stdClass();
            $filter->LINC_Descripcion = strtoupper($descripcion);
            $filter->LINC_CodigoUsuario = $codigo_usuario;
            if(isset($linea_id) && $linea_id>0){
              $this->linea_model->modificar($linea_id,$filter);
            }
            else{
               $this->linea_model->insertar($filter);
            }
            header("location:".base_url()."index.php/almacen/linea/listar");
        }
    }
    public function eliminar()
    {
        $id = $this->input->post('linea');
        $this->linea_model->eliminar($id);
    }
    public function ver($codigo)
    {
        
        $datos_linea       = $this->linea_model->obtener($codigo);
        $data['nombre_linea']= $datos_linea[0]->LINC_Descripcion;
        $data['linea']= $datos_linea[0]->LINP_Codigo;
        $data['titulo']        = "VER LINEA";
        $data['oculto']        = form_hidden(array('base_url'=>base_url()));
        $this->layout->view('almacen/linea_ver',$data);
    }
    public function buscar($j=0)
    {
        $this->load->library('layout','layout');
        $nombre_linea = $this->input->post('nombre_linea');
        $filter = new stdClass();
        $filter->LINC_Descripcion = $nombre_linea;
        $data['registros']      = count($this->linea_model->buscar($filter));
        $conf['base_url']       = site_url('almacen/almacen/buscar/');
        $conf['total_rows']     = $data['registros'];
        $conf['per_page']       = 10;
        $conf['num_links']      = 3;
        $conf['first_link']     = "&lt;&lt;";
        $conf['last_link']      = "&gt;&gt;";
        $offset                 = (int)$this->uri->segment(4);
        $listado                = $this->linea_model->buscar($filter,$conf['per_page'],$offset);
        $item                   = $j+1;
        $lista                  = array();
        if(count($listado)>0){
            foreach($listado as $indice=>$valor){
                $codigo       = $valor->LINP_Codigo;
                $editar       = "<a href='#' onclick='editar_linea(".$codigo.")' target='_parent'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver          = "<a href='#' onclick='ver_linea(".$codigo.")' target='_parent'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                $eliminar     = "<a href='#' onclick='eliminar_linea(".$codigo.")' target='_parent'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $lista[]      = array($item++,$valor->LINC_Descripcion,$valor->LINC_CodigoUsuario,$editar,$ver,$eliminar);
            }
        }
        $data['titulo_tabla']    = "RESULTADO DE BUSQUEDA de LINEAS";
        $data['titulo_busqueda'] = "BUSCAR LINEA";
        $data['nombre_linea']  = form_input(array( 'name'  => 'nombre_linea','id' => 'nombre_linea','value' => $nombre_linea,'maxlength' => '100','class' => 'cajaMedia'));
        $data['form_open']       = form_open(base_url().'index.php/almacen/linea/buscar',array("name"=>"form_busquedaLinea","id"=>"form_busquedaLinea"));
        $data['form_close']      = form_close();
        $data['lista']           = $lista;
        $data['oculto']          = form_hidden(array('base_url'=>base_url()));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('almacen/linea_index',$data);
    }
}
?>