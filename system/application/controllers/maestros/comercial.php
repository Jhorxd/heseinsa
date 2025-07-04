<?php
class Comercial extends Controller{
    public function __construct()
    {
        parent::Controller();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('html');
        $this->load->model('maestros/comercial_model');
    }
    public function index(){
        $this->load->library('layout','layout');
        $this->layout->view('seguridad/inicio');
    }
    public function sector_comercial($j='0'){
        $this->load->library('layout','layout');
        $data['txtComercial']   = "";
        $data['registros']  = count($this->comercial_model->listar_comerciales());
        $conf['base_url']   = site_url('maestros/comercial/comerciales/');
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
        $listado_comerciales     = $this->comercial_model->listar_comerciales($conf['per_page'],$offset);
        $item               = $j+1;
        $lista                = array();
        if(count($listado_comerciales)>0){
             foreach($listado_comerciales as $indice=>$valor){
                 $codigo         = $valor->SECCOMP_Codigo;
                 $editar         = "<a href='#' onclick='editar_comercial(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                 $ver            = "<a href='#' onclick='ver_comercial(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                 $eliminar       = "<a href='#' onclick='eliminar_comercial(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                 $lista[]        = array($item++,$valor->SECCOMC_Descripcion,$editar,$ver,$eliminar);
             }
        }
        $data['action']          = base_url()."index.php/maestros/Comercial/buscar_comerciales";
        $data['titulo_tabla']    = "RELACI&Oacute;N de COMERCIALES";
        $data['titulo_busqueda'] = "BUSCAR COMERCIAL";
        $data['lista']      = $lista;

        $this->layout->view('maestros/comercial_index',$data);
    }
    public function filtrar_data($j=0){
       $data['registros']  = count($this->comercial_model->listar_comerciales());
       $nombre_comercial       = $this->input->post('nombre');
        $filter=new stdClass();
        $filter->nombre_comercial = $nombre_comercial;

        $conf['base_url']   = site_url('maestros/comercial/filtrar_data/');
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
        $listado_comerciales     = $this->comercial_model->buscar_comerciales($filter,$conf['per_page'],$offset);
  $datatable=      '<div class="acciones">
            <div id="botonBusqueda">
                <ul id="imprimirComercial" class="lista_botones"><li id="imprimir">Imprimir</li></ul>
                <ul onclick="nuevo_comercial()" id="nuevoComercial" class="lista_botones"><li id="nuevo">Nuevo Comercial</li></ul>
                <ul id="limpiarComercial" class="lista_botones"><li id="limpiar">Limpiar</li></ul>
                <ul onclick="buscar_sector_comercial()" id="buscarComercial" class="lista_botones"><li id="buscar">Buscar</li></ul> 
            </div>
            <div id="lineaResultado">
              <table class="fuente7" width="100%" cellspacing=0 cellpadding=3 border=0>
                    <tr>
                    <td width="50%" align="left">N de comerciales encontrados:&nbsp;'.count($this->comercial_model->buscar_comerciales($filter,$conf['per_page'],$offset)).'</td>
              </table>
            </div>
</div> ';
$datatable.='<div id="cabeceraResultado" class="header">RELACI&Oacute;N de COMERCIALES</div>
 <div id="frmResultado">
                <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                    <tr class="cabeceraTabla">
                        <td width="5%">ITEM</td>
                        <td width="60%">NOMBRES DE COMERCIALES</td>
                        <td width="5%">&nbsp;</td>
                        <td width="5%">&nbsp;</td>
                        <td width="6%">&nbsp;</td>
                    </tr>';
        
        $lista                = array();
        if(count($listado_comerciales)>0){
             foreach($listado_comerciales as $indice=>$valor){
                $item               = $j+$indice+1;
                 $class = $indice%2==0?'itemParTabla':'itemImparTabla';
                    $codigo         = $valor->SECCOMP_Codigo;
                 $editar         = "<a href='#' onclick='editar_comercial(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                 $ver            = "<a href='#' onclick='ver_comercial(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                 $eliminar       = "<a href='#' onclick='eliminar_comercial(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";          
                    $datatable.='<tr class="'.$class.'">
                            <td><div align="center">'.$item.'</div></td><td><div align="left">'.$valor->SECCOMC_Descripcion.'</div></td><td><div align="center">'.$editar.'</div></td>
                                        <td><div align="center">'.$ver.'</div></td>
                                        <td><div align="center">'.$eliminar.'</div></td>
                                </tr>';
                 
                 
                
             }
        }
        echo   $datatable;
       
    }
    public function nuevo_comercial(){
        $this->load->library('layout','layout');
        $data['form_open']  = form_open(base_url().'index.php/maestros/comercial/insertar_comercial',array("name"=>"frmComercial","id"=>"frmComercial"));
        $data['form_close'] = form_close();
        $data['titulo']     = "REGISTRAR COMERCIAL";
        $data['formulario'] = "frmProveedor";
        $data['nombre']="";//$nombre_comercial;
        $data['Codigo']="";//$datos_comercial[0]->SECCOMP_Codigo;
        
        $this->layout->view('maestros/comercial_nuevo',$data);
    }
    public function insertar_comercial(){
        $nombre = $this->input->post('nombre');
        $this->comercial_model->insertar_comercial($nombre);
                   
    }
    public function editar_comercial($codigo){
        $this->load->library('layout','layout');
        $accion       = "";
        $modo         = "modificar";
        $datos_comercial  = $this->comercial_model->obtener_comercial($codigo);
        $nombre_comercial = $datos_comercial[0]->SECCOMC_Descripcion;
        $data['nombre']=$nombre_comercial;
        $data['Codigo']=$datos_comercial[0]->SECCOMP_Codigo;
        $data['form_open']  = form_open(base_url().'index.php/maestros/comercial/modificar_comercial',array("name"=>"frmComercial","id"=>"frmComercial"));
        $data['form_close'] = form_close();
        
        $data['titulo']     = "EDITAR COMERCIALES";
        $data['formulario'] = "frmProveedor";

        $this->layout->view('maestros/comercial_nuevo',$data);
    }
    public function modificar_comercial(){
        $comercial  = $this->input->post('codigo');
        $nombre = $this->input->post('nombre');
        $this->comercial_model->modificar_comercial($comercial,$nombre);                      
    }
    public function eliminar_comercial(){
        $comercial = $this->input->post('codigo');
        $this->comercial_model->eliminar_comercial($comercial);
    }
    public function ver_comercial($codigo)
    {
        $this->load->library('layout','layout');
        $data['datos_comercial'] = $this->comercial_model->obtener_comercial($codigo);
        $data['titulo']      = "VER COMERCIAL";
        $data['oculto']      = form_hidden(array('base_url'=>base_url()));
        $this->layout->view('maestros/comercial_ver',$data);
    }

  public function listar_comerciales(){
            $listado_comerciales = $this->comercial_model->listar_comerciales();
            $resultado = json_encode($listado_comerciales);
            $data['listado_comerciales'] =$resultado;
            $this->load->view('maestros/listado_comerciales',$data);
    }
    public function comerciales_pdf($datas="") {
      
        $this->load->library('cezpdf');
        $this->load->helper('pdf_helper');
         $this->cezpdf = new Cezpdf('a4');
        $datacreator = array(
            'Title' => 'Estadillo de ',
            'Name' => 'Estadillo de ',
            'Author' => 'NUEVO',
            'Subject' => 'PDF con Tablas',
            'Creator' => 'info@ccapasistema.com',
            'Producer' => 'http://www.osa-erp.com'
        );

        $this->cezpdf->addInfo($datacreator);
        $this->cezpdf->selectFont(APPPATH . 'libraries/fonts/Helvetica.afm');
        $delta = 20;
        $this->cezpdf->ezText('<b>LISTADO COMERCIAL</b>', 14, array("leading" => 0, 'left' => 185));
        $this->cezpdf->ezText('', '', array("leading" => 10));
        $db_data = array();
        $filter=new stdClass();
        $filter->nombre_comercial = $datas;

    $objecargos=$this->comercial_model->buscar_comerciales($filter); 
        
           if (count($objecargos) > 0) {
            foreach ($objecargos as $indice => $valor) {
                $codigo = $valor->SECCMP_Codigo;
                $descripcion = $valor->SECCOMC_Descripcion;
                $db_data[] = array(
                    'cols1' => $indice + 1,
                    'cols2' => $descripcion
                );
            }
        } 
    $col_names = array(
            'cols1' => '<b>ITEM</b>',
            'cols2' => '<b>DESCRIPCION</b>'
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
                'cols2' => array('width' => 245, 'justification' => 'left'),
                'cols3' => array('width' => 245, 'justification' => 'left')
            )
        ));
    $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'sector_comercial'. '.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

    ob_end_clean();
    $this->cezpdf->ezStream($cabecera);
    }
}
?>