<?php
class Cargo extends Controller{

    private $compania;
    private $usuario;
    private $url;

    public function __construct(){
        parent::__construct();
        $this->load->helper('form');

        $this->load->library('layout','layout');
        $this->load->library('form_validation');
        $this->load->library('lib_props');
        
        $this->load->model('maestros/cargo_model');

        $this->compania = $this->session->userdata("compania");
        $this->usuario = $this->session->userdata("user");
        $this->url = base_url();
    }

    public function index(){
        $this->cargos();
    }

    ###########################
    ###### FUNCTIONS NEWS
    ###########################
    
        public function cargos( $j = "" ){
            $data['registros']  = count($this->cargo_model->listar_cargos());
            $conf['base_url']   = $this->url;

            $data['titulo']    = "RELACIÓN DE CARGOS";
            $data['titulo_busqueda'] = "BUSCAR CARGO";
            $this->layout->view('maestros/cargo_index',$data);
        }

        public function datatable_cargo(){

            $columnas = array(
                                0 => "",
                                1 => "CARGC_Nombre",
                                2 => "CARGC_Descripcion",
                                3 => "CARGC_FlagEstado"
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

            $cargoInfo = $this->cargo_model->getCargos($filter);
            $lista = array();
            
            if (count($cargoInfo) > 0) {
                foreach ($cargoInfo as $indice => $valor) {
                    $btn_modal = "<button type='button' onclick='editar($valor->CARGP_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/modificar.png' class='image-size-1b'>
                                </button>";
                    $btn_borrar = "<button type='button' onclick='deshabilitar($valor->CARGP_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/documento-delete.png' class='image-size-1b'>
                                </button>";

                    $lista[] = array(
                                        0 => $indice + 1,
                                        1 => $valor->CARGC_Nombre,
                                        2 => $valor->CARGC_Descripcion,
                                        3 => $btn_modal,
                                        4 => $btn_borrar
                                    );
                }
            }

            unset($filter->start);
            unset($filter->length);

            $json = array(
                                "draw"            => intval( $this->input->post('draw') ),
                                "recordsTotal"    => count($this->cargo_model->getCargos()),
                                "recordsFiltered" => intval( count($this->cargo_model->getCargos($filter)) ),
                                "data"            => $lista
                        );

            echo json_encode($json);
        }

        public function getCargo(){

            $codigo = $this->input->post("cargo");

            $cargoInfo = $this->cargo_model->getCargo($codigo);
            $lista = array();
            
            if ( $cargoInfo != NULL ){
                foreach ($cargoInfo as $indice => $val) {
                    $lista = array(
                                        "cargo" => $val->CARGP_Codigo,
                                        "nombre" => $val->CARGC_Nombre,
                                        "descripcion" => $val->CARGC_Descripcion
                                    );
                }

                $json = array("match" => true, "info" => $lista);
            }
            else
                $json = array("match" => false, "info" => "");

            echo json_encode($json);
        }

        public function guardar_registro(){

            $cargo = $this->input->post("cargo");
            $nombre = strtoupper( $this->input->post("cargo_nombre") );
            $descripcion = strtoupper( $this->input->post("cargo_descripcion") );

            $filter = new stdClass();
            $filter->CARGC_Nombre      = strtoupper($nombre);
            $filter->CARGC_Descripcion = strtoupper($descripcion);
            $filter->CARGC_FlagEstado  = "1";

            if ($cargo != ""){
                $filter->CARGP_Codigo = $cargo;
                $result = $this->cargo_model->actualizar($cargo, $filter);
            }
            else
                $result = $this->cargo_model->insertar($filter);

            if ($result)
                $json = array("result" => "success");
            else
                $json = array("result" => "error");
            
            echo json_encode($json);
        }

        public function deshabilitar_cargo(){

            $cargo = $this->input->post("cargo");

            $filter = new stdClass();
            $filter->CARGC_FlagEstado  = "0";

            if ($cargo != "")
                $result = $this->cargo_model->actualizar($cargo, $filter);

            if ($result)
                $json = array("result" => "success");
            else
                $json = array("result" => "error");
            
            echo json_encode($json);
        }
    
    ###########################
    ###### FUNCTIONS OLDS
    ###########################

    public function nuevo_cargo(){
            $this->load->library('layout','layout');
            $modo      = "";
            $accion    = "";
            $modo      = "insertar";
            $codigo    = "";
            $data['form_open']  = form_open(base_url().'index.php/maestros/cargo/insertar_cargo',array("name"=>"frmCargo","id"=>"frmCargo"));
            $data['form_close'] = form_close();
            $lblCargo  = form_label('NOMBRE DEL CARGO','nombre');
            $txtCargo  = form_input(array('name'=>'nombre','id'=>'nombre','value'=>'','maxlength'=>'30','class'=>'cajaMedia'));
            $oculto    = form_hidden(array('accion'=>$accion,'codigo'=>$codigo,'modo'=>$modo,'base_url'=>base_url()));
            $data['titulo']     = "REGISTRAR CARGOS";
            $data['formulario'] = "frmProveedor";
            $data['campos']     = array($lblCargo);
            $data['valores']    = array($txtCargo);
            $data['oculto']     = $oculto;
            $data['onload']     = "onload=\"$('#nombre').focus();\"";
            $this->layout->view('maestros/cargo_nuevo',$data);
    }

    public function insertar_cargo(){
            $this->form_validation->set_rules('nombre','Nombre de cargo ','required');
            if($this->form_validation->run() == FALSE){
                    $this->nuevo_cargo();
            }
            else{
                    $nombre = $this->input->post('nombre');
                    $this->cargo_model->insertar_cargo($nombre);
                    $this->cargos();
            }
    }

    public function editar_cargo($codigo){
        $this->load->library('layout','layout');
        $accion       = "";
        $modo         = "modificar";
        $datos_cargo  = $this->cargo_model->obtener_cargo($codigo);
        $nombre_cargo = $datos_cargo[0]->CARGC_Descripcion;
        $data['form_open']  = form_open(base_url().'index.php/maestros/cargo/modificar_cargo',array("name"=>"frmCargo","id"=>"frmCargo"));
        $data['form_close'] = form_close();
        $lblCargo     = form_label('NOMBRE DEL CARGO','nombre');
        $txtCargo     = form_input(array('name'=>'nombre','id'=>'nombre','value'=>$nombre_cargo,'maxlength'=>'30','class'=>'cajaMedia'));
        $oculto       = form_hidden(array('accion'=>$accion,'codigo'=>$codigo,'modo'=>$modo,'base_url'=>base_url()));
        $data['titulo']     = "EDITAR CARGOS";
        $data['formulario'] = "frmProveedor";
        $data['campos']     = array($lblCargo);
        $data['valores']    = array($txtCargo);
        $data['oculto']     = $oculto;
        $data['onload']     = "onload=\"$('#nombre').select();$('#nombre').focus();\"";
        $this->layout->view('maestros/cargo_nuevo',$data);
    }

    public function modificar_cargo(){
        $this->form_validation->set_rules('nombre','Nombre de cargo','required');
        if($this->form_validation->run() == FALSE){
                $this->nuevo_cargo();
        }
        else{
                $cargo  = $this->input->post('codigo');
                $nombre = $this->input->post('nombre');
                $this->cargo_model->modificar_cargo($cargo,$nombre);
                $this->cargos();
        }
    }

    public function eliminar_cargo(){
        $cargo = $this->input->post('cargo');
        $this->cargo_model->eliminar_cargo($cargo);
    }

    public function ver_cargo($codigo){
        $this->load->library('layout','layout');
        $data['datos_cargo'] = $this->cargo_model->obtener_cargo($codigo);
        $data['titulo']      = "VER CARGO";
        $data['oculto']      = form_hidden(array('base_url'=>base_url()));
        $this->layout->view('maestros/cargo_ver',$data);
    }

    public function buscar_cargos($j='0'){
        $this->load->library('layout','layout');
        $nombre_cargo       = $this->input->post('txtCargo');
        $filter=new stdClass();
        $filter->nombre_cargo = $nombre_cargo;
        $data['txtCargo']   = $nombre_cargo;
        $data['registros']  = count($this->cargo_model->buscar_cargos($filter));
        $conf['base_url']   = site_url('maestros/cargo/buscar_cargos/');
        $conf['per_page']   = 10;
        $conf['num_links']  = 3;
        $conf['next_link'] = "&gt;";
        $conf['prev_link'] = "&lt;";
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link']  = "&gt;&gt;";
        $conf['uri_segment'] = 4;
        $conf['total_rows'] = $data['registros'];
        $offset             = (int)$this->uri->segment(4);
        //echo $conf['per_page'].' - '.$offset;
        $listado_cargos     = $this->cargo_model->buscar_cargos($filter,$conf['per_page'],$offset);
        //echo '<br/>'.count($listado_cargos);
        $item               = $j+1;
        $lista              = array();
        if(count($listado_cargos)>0){
            foreach($listado_cargos as $indice=>$valor){
                $codigo         = $valor->CARGP_Codigo;
                $editar         = "<a href='#' onclick='editar_cargo(".$codigo.")' target='_parent'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver            = "<a href='#' onclick='ver_cargo(".$codigo.")' target='_parent'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                $eliminar       = "<a href='#' onclick='eliminar_cargo(".$codigo.")' target='_parent'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $lista[]        = array($item++,$valor->CARGC_Descripcion,$editar,$ver,$eliminar);
            }
        }
        $data['action']          = base_url()."index.php/maestros/cargo/buscar_cargos";
        $data['titulo_tabla']    = "RESULTADO DE BUSQUEDA de CARGOS";
        $data['titulo_busqueda'] = "BUSCAR CARGO";
        $data['lista']      = $lista;
        $data['oculto']     = form_hidden(array('base_url'=>base_url()));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('maestros/cargo_index',$data);
    }
    public function tabla_cargo($lista){
            $tab_cargo  = '<table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">';
            $tab_cargo .= '<tr class="cabeceraTabla">';
            $tab_cargo .= '<td width="5%">ITEM</td>';
            $tab_cargo .= '<td width="60%">NOMBRES DE CARGOS</td>';
            $tab_cargo .= '<td width="5%">&nbsp;</td>';
            $tab_cargo .= '<td width="5%">&nbsp;</td>';
            $tab_cargo .= '<td width="6%">&nbsp;</td>';
            $tab_cargo .= '</tr>';
            if(count($lista)>0){
                    foreach($lista as $indice=>$valor){
                            $class = $indice%2==0?'itemParTabla':'itemImparTabla';
                            $tab_cargo .= '<tr class="'.$class.'">';
                            $tab_cargo .= '<td><div align="center">'.$valor[0].'</div></td>';
                            $tab_cargo .= '<td><div align="left">'.$valor[1].'</div></td>';
                            $tab_cargo .= '<td><div align="center">'.$valor[2].'</div></td>';
                            $tab_cargo .= '<td><div align="center">'.$valor[3].'</div></td>';
                            $tab_cargo .= '<td><div align="center">'.$valor[4].'</div></td>';
                            $tab_cargo .= '</tr>';
                    }
            }
            else{
                    $tab_cargo .= '<table width="100%" cellspacing="0" cellpadding="3" border="0" class="fuente8">';
                    $tab_cargo .= '<tbody>';
                    $tab_cargo .= '<tr>';
                    $tab_cargo .= '<td width="100%" class="mensaje">No hay ning&uacute;n registro que cumpla con los criterios de b&uacute;squeda</td>';
                    $tab_cargo .= '</tr>';
                    $tab_cargo .= '</tbody>';
                    $tab_cargo .= '</table>';
            }
            $tab_cargo .= '</table>';
            return $tab_cargo;
    }

    public function listar_cargos(){
        $listado_cargos = $this->cargo_model->listar_cargos();
        $resultado = json_encode($listado_cargos);
        $data['listado_cargos'] =$resultado;
        $this->load->view('maestros/listado_cargos',$data);
    }

    /*
    public function registro_cargos_pdf(){
      
        $this->load->library('cezpdf');
        $this->load->helper('pdf_helper');
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

        $this->cezpdf->ezText('<b>LISTADO CARGO</b>', 14, array("leading" => 0, 'left' => 185));
        $this->cezpdf->ezText('', '', array("leading" => 10));

        $db_data = array();


        $compania=  $this->session->userdata('compania');
        $objecargos=  $this->Global_model->get_where('cji_cargo',array('CARGC_FlagEstado'=>1,'COMPP_Codigo'=>$compania),0);
        //$lista = array();
        
           if (count($objecargos) > 0) {
            foreach ($objecargos as $indice => $valor) {
                $codigo = $valor->CARGP_Codigo;
                $descripcion = $valor->CARGC_Descripcion;
                
                       
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


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => $codificacion . '.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        ob_end_clean();

        $this->cezpdf->ezStream($cabecera);
    }
    */
}
?>