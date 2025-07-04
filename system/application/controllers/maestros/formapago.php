<?php
class Formapago extends controller{

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
        
        
        $this->load->model('maestros/formapago_model');

        $this->empresa = $this->session->userdata('empresa');
        $this->compania = $this->session->userdata('compania');
        $this->url = base_url();
    }

    #########################
    ###### FUNCTIONS NEWS
    #########################

        public function listar(){
            $data['base_url'] = $this->url;
            $data['titulo_busqueda'] = "BUSCAR FORMAS DE PAGO";
            $data['titulo'] = "RELACIÓN DE FORMAS DE PAGO";
            $this->layout->view('maestros/formapago_index', $data);
        }

        public function datatable_fpago(){

            $columnas = array(
                                0 => "",
                                1 => "FORPAC_Descripcion"
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

            $formapagoInfo = $this->formapago_model->getFpagos($filter);
            $lista = array();
            
            if (count($formapagoInfo) > 0) {
                foreach ($formapagoInfo as $indice => $valor) {
                    $btn_modal = "<button type='button' onclick='editar($valor->FORPAP_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/modificar.png' class='image-size-1b'>
                                </button>";

                    $btn_eliminar = "<button type='button' onclick='deshabilitar($valor->FORPAP_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/documento-delete.png' class='image-size-1b'>
                                </button>";

                    $lista[] = array(
                                        0 => $indice + 1,
                                        1 => $valor->FORPAC_Descripcion,
                                        2 => $btn_modal,
                                        3 => $btn_eliminar
                                    );
                }
            }

            unset($filter->start);
            unset($filter->length);

            $json = array(
                                "draw"            => intval( $this->input->post('draw') ),
                                "recordsTotal"    => count($this->formapago_model->getFpagos()),
                                "recordsFiltered" => intval( count($this->formapago_model->getFpagos($filter)) ),
                                "data"            => $lista
                        );

            echo json_encode($json);
        }

        public function getFpago(){

            $fpago = $this->input->post("fpago");

            $formapagoInfo = $this->formapago_model->getFpago($fpago);
            $lista = array();
            
            if ( $formapagoInfo != NULL ){
                foreach ($formapagoInfo as $indice => $val) {
                    $lista = array(
                                        "fpago" => $val->FORPAP_Codigo,
                                        "descripcion" => $val->FORPAC_Descripcion
                                    );
                }

                $json = array("match" => true, "info" => $lista);
            }
            else
                $json = array("match" => false, "info" => "");

            echo json_encode($json);
        }

        public function guardar_registro(){

            $fpago = $this->input->post("fpago");
            $descripcion_fpago = $this->input->post("descripcion_fpago");
            
            $filter = new stdClass();
            $filter->FORPAC_Descripcion = strtoupper($descripcion_fpago);
            $filter->FORPAC_Orden = "0";
            $filter->FORPAC_FlagEstado = "1";

            if ($fpago != ""){
                $filter->FORPAP_Codigo = $fpago;
                $filter->FORPAC_FechaModificacion = date("Y-m-d H:i:s");
                $result = $this->formapago_model->actualizar_fpago($fpago, $filter);
            }
            else{
                $filter->FORPAC_FechaRegistro = date("Y-m-d H:i:s");
                $result = $this->formapago_model->insertar_fpago($filter);
            }

            if ($result)
                $json = array("result" => "success");
            else
                $json = array("result" => "error");
            
            echo json_encode($json);
        }

        public function deshabilitar_fpago(){

            $fpago = $this->input->post("fpago");

            $filter = new stdClass();
            $filter->FORPAC_FlagEstado  = "0";

            if ($fpago != ""){
                $filter->FORPAC_FechaModificacion = date("Y-m-d H:i:s");
                $result = $this->formapago_model->deshabilitar_fpago($fpago, $filter);
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

    public function listar_olds($j='0'){
        $data['nombre_formapago']  = "";
        $data['registros']   = count($this->formapago_model->listar());
        $conf['base_url']    = site_url('maestros/formapago/listar/');
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
        $listado            = $this->formapago_model->listar($conf['per_page'],$offset);
        $item               = $j+1;
        foreach($listado as $indice=>$valor)
        {
            $codigo         = $valor->FORPAP_Codigo;
            $editar         = "<a href='#' onclick='editar_formapago(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
            $ver            = "<a href='#' onclick='ver_formapago(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
            $eliminar       = "<a href='#' onclick='eliminar_formapago(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
            $lista[]        = array($item++,$valor->FORPAC_Descripcion,$editar,$ver,$eliminar);
        }
        $data['lista']            = $lista;
        $data['titulo_busqueda']  = "BUSCAR FORMA DE PAGO";
        $data['nombre_formapago'] = form_input(array( 'name'  => 'nombre_formapago','id' => 'nombre_formapago','value' => '','maxlength' => '100','class' => 'cajaMedia'));
        $data['form_open']        = form_open(base_url().'index.php/maestros/formapago/buscar',array("name"=>"form_busquedaFormapago","id"=>"form_busquedaFormapago"));
        $data['form_close']       = form_close();
        $data['titulo_tabla']     = "Relaci&oacute;n DE FORMAS DE PAGO";
        $data['oculto']           = form_hidden(array('accion'=>"",'codigo'=>"",'modo'=>"insertar",'base_url'=>base_url()));
        $this->layout->view('maestros/formapago_index',$data);
			
    }
    public function nuevo()
    {
        
        $lblDescripcion     = form_label("Nombre Forma de pago","Nombre Forma de pago");
        $nombre_formapago   = form_input(array( 'name'  => 'nombre_formapago','id' => 'nombre_formapago','value' => '','maxlength' => '100','class' => 'cajaMedia'));
        $data['titulo']     = "REGISTRAR FORMA DE PAGO";
        $data['form_open']  = form_open(base_url().'index.php/maestros/formapago/grabar',array("name"=>"frmFormapago","id"=>"frmFormapago"));
        $data['form_close'] = form_close();
        $data['campos']     = array($lblDescripcion);
        $data['valores']    = array($nombre_formapago);
        $data['oculto']     = form_hidden(array('codigo'=>"",'base_url'=>base_url(),'formapago_id'=>''));
        $data['onload']	    = "onload=\"$('#nombres').focus();\"";
        $this->layout->view('maestros/formapago_nuevo',$data);
    }
    public function editar($id)
    {
        
        $oFormapago             = $this->formapago_model->obtener($id);
        $lblDescripcion         = form_label("Nombre Forma pago","Nombre Forma pago");
        $nombre_formapago       = form_input(array( 'name'  => 'nombre_formapago','id' => 'nombre_formapago','value' => $oFormapago[0]->FORPAC_Descripcion,'maxlength' => '100','class' => 'cajaMedia'));
        $data['form_open']      = form_open(base_url().'index.php/maestros/formapago/grabar/',array("name"=>"frmFormapago","id"=>"frmFormapago"));
        $data['campos']         = array($lblDescripcion);
        $data['valores']        = array($nombre_formapago);
        $data['oculto']         = form_hidden(array('codigo'=>"",'base_url'=>base_url(),'formapago_id'=>$id));
        $data['form_hidden']    = form_hidden("base_url",base_url());
        $data['form_close']     = form_close();
        $data['titulo']  = "EDITAR FORMA DE PAGO";
        $this->layout->view('maestros/formapago_nuevo',$data);
    }
    public function grabar()
    {
        $this->form_validation->set_rules('nombre_formapago','Nombre de forma de pago','required');
        if($this->form_validation->run() == FALSE){
            $this->nuevo();
        }
        else{
            $descripcion  = $this->input->post("nombre_formapago");
            $formapago_id   = $this->input->post("formapago_id");
            $filter = new stdClass();
            $filter->FORPAC_Descripcion = strtoupper($descripcion);
            if(isset($formapago_id) && $formapago_id>0){
              $this->formapago_model->modificar($formapago_id,$filter);
            }
            else{
               $this->formapago_model->insertar($filter);
            }
            header("location:".base_url()."index.php/maestros/formapago/listar");
        }
    }
    public function eliminar()
    {
        $id = $this->input->post('formapago');
        $this->formapago_model->eliminar($id);
    }
    public function ver($codigo)
    {
        
        $datos_formapago       = $this->formapago_model->obtener($codigo);
        $data['nombre_formapago']= $datos_formapago[0]->FORPAC_Descripcion;
        $data['formapago']= $datos_formapago[0]->FORPAP_Codigo;
        $data['titulo']        = "VER FORMA DE PAGO";
        $data['oculto']        = form_hidden(array('base_url'=>base_url()));
        $this->layout->view('maestros/formapago_ver',$data);
    }
    public function buscar($j=0)
    {
        $this->load->library('layout','layout');
        $nombre_formapago = $this->input->post('nombre_formapago');
        $filter = new stdClass();
        $filter->FORPAC_Descripcion = $nombre_formapago;
        $data['registros']      = count($this->formapago_model->buscar($filter));
        $conf['base_url']       = site_url('maestros/almacen/buscar/');
        $conf['total_rows']     = $data['registros'];
        $conf['per_page']       = 10;
        $conf['num_links']      = 3;
        $conf['first_link']     = "&lt;&lt;";
        $conf['last_link']      = "&gt;&gt;";
        $offset                 = (int)$this->uri->segment(4);
        $listado                = $this->formapago_model->buscar($filter,$conf['per_page'],$offset);
        $item                   = $j+1;
        $lista                  = array();
        if(count($listado)>0){
            foreach($listado as $indice=>$valor){
                $codigo       = $valor->FORPAP_Codigo;
                $editar       = "<a href='#' onclick='editar_formapago(".$codigo.")' target='_parent'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver          = "<a href='#' onclick='ver_formapago(".$codigo.")' target='_parent'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                $eliminar     = "<a href='#' onclick='eliminar_formapago(".$codigo.")' target='_parent'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $lista[]      = array($item++,$valor->FORPAC_Descripcion,$editar,$ver,$eliminar);
            }
        }
        $data['titulo_tabla']    = "RESULTADO DE BUSQUEDA de FORMAS DE PAGO";
        $data['titulo_busqueda'] = "BUSCAR FORMA DE PAGO";
        $data['nombre_formapago']  = form_input(array( 'name'  => 'nombre_formapago','id' => 'nombre_formapago','value' => $nombre_formapago,'maxlength' => '100','class' => 'cajaMedia'));
        $data['form_open']       = form_open(base_url().'index.php/maestros/formapago/buscar',array("name"=>"form_busquedaFormapago","id"=>"form_busquedaFormapago"));
        $data['form_close']      = form_close();
        $data['lista']           = $lista;
        $data['oculto']          = form_hidden(array('base_url'=>base_url()));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('maestros/formapago_index',$data);
    }
}
?>