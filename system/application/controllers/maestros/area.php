<?php
class Area extends Controller{
	public function __construct()
        {
            parent::Controller();
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->library('pagination');
            $this->load->library('html');
            $this->load->model('maestros/area_model');
	}
	public function index(){
		$this->load->library('layout','layout'); 
		$this->layout->view('seguridad/inicio');	
	}
	public function areas($j='0')
        {
            $this->load->library('layout','layout');
            $data['txtArea']    = "";
            $data['registros']  = count($this->area_model->listar_areas());
            $conf['base_url']   = site_url('maestros/area/areas/');
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
            $listado_areas      = $this->area_model->listar_areas($conf['per_page'],$offset);
            $item               = $j+1;
            $lista               = array();
            if(count($listado_areas)>0){
                 foreach($listado_areas as $indice=>$valor){
                     $codigo         = $valor->AREAP_Codigo;
                     $editar         = "<a href='#' onclick='editar_area(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                     $ver            = "<a href='#' onclick='ver_area(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                     $eliminar       = "<a href='#' onclick='eliminar_area(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                     $lista[]        = array($item++,$valor->AREAC_Descripcion,$editar,$ver,$eliminar);
                 }
            }
            $data['action']          = base_url()."index.php/maestros/area/buscar_areas";
            $data['titulo_tabla']    = "RELACI&Oacute;N de &Aacute;REAS";
            $data['titulo_busqueda'] = "BUSCAR AREA";
            $data['lista']      = $lista;
            $data['oculto']     = form_hidden(array('base_url'=>base_url()));
            $this->layout->view('maestros/area_index',$data);
	}	
	public function nueva_area(){
		$this->load->library('layout','layout'); 	
		$lblArea  = form_label('NOMBRE DEL AREA','area');
		$txtArea  = form_input(array('name'=>'nombres','id'=>'nombres','value'=>'','maxlength'=>'30','class'=>'cajaMedia'));
		$oculto    = form_hidden(array('accion'=>"",'codigo'=>"",'modo'=>"insertar",'base_url'=>base_url()));	
		$data['titulo']     = "REGISTRAR AREA";		
		$data['formulario'] = "frmArea";	
		$data['campos']     = array($lblArea);
		$data['valores']    = array($txtArea);		
		$data['oculto']     = $oculto;
		$data['onload']		= "onload=\"$('#nombres').focus();\"";
		$this->layout->view('maestros/area_nueva',$data);
	}	
	public function insertar_area(){
		$this->form_validation->set_rules('nombres','Nombre','required');
		if($this->form_validation->run() == FALSE){
			$this->nueva_area();
		}
		else{
			$nombres = $this->input->post('nombres');
			$this->area_model->insertar_area($nombres);
			$this->load->view('maestros/area_index');		
		}
	}	
	public function editar_area($codigo){
		$this->load->library('layout','layout'); 	
		$datos_area  = $this->area_model->obtener_area($codigo);
		$descripcion = $datos_area[0]->AREAC_Descripcion;
		$lblArea    = form_label('NOMBRE AREA','area');
		$txtArea    = form_input(array('name'=>'nombres','id'=>'nombres','value'=>$descripcion,'maxlength'=>'50','class'=>'cajaMedia'));
		$oculto     = form_hidden(array('accion'=>"",'codigo'=>$codigo,'modo'=>"modificar",'base_url'=>base_url()));	
		$data['titulo']     = "EDITAR AREA";		
		$data['formulario'] = "frmArea";	
		$data['campos']     = array($lblArea);
		$data['valores']    = array($txtArea);		
		$data['oculto']     = $oculto;
		$data['onload']		= "onload=\"$('#txtArea').select();$('#txtArea').focus();\"";		
		$this->layout->view('maestros/area_nueva',$data);
	}
	public function modificar_area(){
		$this->form_validation->set_rules('nombres','Nombre','required');
		if($this->form_validation->run() == FALSE){
			$this->nueva_area();
		}
		else{
			$area        = $this->input->post('codigo');
			$descripcion = $this->input->post('nombres');
			$this->area_model->modificar_area($area,$descripcion);
			$this->load->view('maestros/area_index');		
		}	
	}
	public function eliminar_area(){
		$area = $this->input->post('area');
		$this->area_model->eliminar_area($area);
	}
	public function ver_area($codigo){
		$this->load->library('layout','layout'); 	
		$data['datos_area']    = $this->area_model->obtener_area($codigo);
		$data['titulo']        = "VER AREA";
		$data['oculto']        = form_hidden(array('base_url'=>base_url()));
		$this->layout->view('maestros/area_ver',$data);
	}
    public function buscar_areas($j='0')
    {
        $this->load->library('layout','layout');
        $nombre_area            = $this->input->post('txtArea');
        $filter = new stdClass();
        $filter->nombre_area  = $nombre_area;
        $data['txtArea']      = $nombre_area;
        $data['registros']    = count($this->area_model->buscar_areas($filter));
        $conf['base_url']     = site_url('maestros/area/buscar_areas/');
        $conf['per_page']     = 10;
        $conf['num_links']    = 3;
        $conf['first_link']   = "&lt;&lt;";
        $conf['last_link']    = "&gt;&gt;";
        $conf['total_rows']   = $data['registros'];
        $offset               = (int)$this->uri->segment(4);
        $listado_areas        = $this->area_model->buscar_areas($filter,$conf['per_page'],$offset);
        $item                 = $j+1;
        $lista                = array();
        if(count($listado_areas)>0){
            foreach($listado_areas as $indice=>$valor){
                $codigo         = $valor->AREAP_Codigo;
                $editar          = "<a href='#' onclick='editar_area(".$codigo.")' target='_parent'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver               = "<a href='#' onclick='ver_area(".$codigo.")' target='_parent'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                $eliminar     = "<a href='#' onclick='eliminar_area(".$codigo.")' target='_parent'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $lista[]          = array($item++,$valor->AREAC_Descripcion,$editar,$ver,$eliminar);
            }
        }
        $data['action']          = base_url()."index.php/maestros/area/buscar_areas";
        $data['titulo_tabla']    = "RESULTADO DE BUSQUEDA de AREAS";
        $data['titulo_busqueda'] = "BUSCAR AREA";
        $data['lista']      = $lista;
        $data['oculto']     = form_hidden(array('base_url'=>base_url()));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('maestros/area_index',$data);
    }
    public function listar_areas(){
        $listado_areas = $this->area_model->listar_areas();
        $resultado = json_encode($listado_areas);
        $data['listado_areas'] =$resultado;
        $this->load->view('maestros/listado_areas',$data);
    }
}
?>