<?php
include("system/application/libraries/cezpdf.php");
include("system/application/libraries/class.backgroundpdf.php");

class Almacen extends controller{

    private $empresa;
    private $compania;
    private $url;
    private $establecimiento;
    private $nombre_establecimiento;

    public function __construct(){
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('date');
        $this->load->helper('util');
        $this->load->helper('utf_helper');
        $this->load->helper('form', 'url');
        
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('html');
        $this->load->library('pagination');
        
        
        $this->load->model('almacen/almacen_model');
        $this->load->model('almacen/tipoalmacen_model');
        $this->load->model('almacen/almacenproducto_model');
        $this->load->model('almacen/fabricante_model');
        $this->load->model('almacen/unidadmedida_model');

        $this->empresa = $this->session->userdata('empresa');
        $this->compania = $this->session->userdata('compania');
        $this->establecimiento = $this->session->userdata('establec');
        $this->nombre_establecimiento = $this->session->userdata('nombre_establec');
        $this->url = base_url();
    }

    ######################
    #### FUNCTIONS NEWS
    ######################

        public function listar(){
            $data['base_url'] = $this->url;
            $data['tipo_almacen'] = $this->tipoalmacen_model->listar();
            $data['establecimiento'] = $this->establecimiento;
            $data['nombre_establecimiento'] = $this->nombre_establecimiento;

            $data['titulo_busqueda'] = "BUSCAR ALMACEN";
            $data['titulo'] = "RELACIÓN DE ALMACENES";
            $this->layout->view('almacen/almacen_index', $data);
        }

        public function datatable_almacen(){

            $columnas = array(
                                0 => "ALMAC_CodigoUsuario",
                                1 => "EESTABC_Descripcion",
                                2 => "ALMAC_Descripcion",
                                3 => "TIPALM_Descripcion",
                                4 => "ALMAC_Direccion"
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
            $filter->tipo = $this->input->post('tipo');

            $almacenInfo = $this->almacen_model->getAlmacens($filter);
            $lista = array();
            
            if (count($almacenInfo) > 0) {
                foreach ($almacenInfo as $indice => $valor) {
                    $btn_modal = "<button type='button' onclick='editar($valor->ALMAP_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/modificar.png' class='image-size-1b'>
                                </button>";

                    $btn_eliminar = "<button type='button' onclick='deshabilitar($valor->ALMAP_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/documento-delete.png' class='image-size-1b'>
                                </button>";

                    $lista[] = array(
                                        0 => $valor->ALMAC_CodigoUsuario,
                                        1 => $valor->EESTABC_Descripcion,
                                        2 => $valor->ALMAC_Descripcion,
                                        3 => $valor->TIPALM_Descripcion,
                                        4 => $valor->ALMAC_Direccion,
                                        5 => $btn_modal,
                                        6 => $btn_eliminar
                                    );
                }
            }

            unset($filter->start);
            unset($filter->length);

            $json = array(
                                "draw"            => intval( $this->input->post('draw') ),
                                "recordsTotal"    => count($this->almacen_model->getAlmacens()),
                                "recordsFiltered" => intval( count($this->almacen_model->getAlmacens($filter)) ),
                                "data"            => $lista
                        );

            echo json_encode($json);
        }

        public function getAlmacen(){

            $almacen = $this->input->post("almacen");

            $almacenInfo = $this->almacen_model->getAlmacen($almacen);
            $lista = array();
            
            if ( $almacenInfo != NULL ){
                foreach ($almacenInfo as $indice => $val) {
                    $lista = array(
                                        "almacen" => $val->ALMAP_Codigo,
                                        "codigo" => $val->ALMAC_CodigoUsuario,
                                        "descripcion" => $val->ALMAC_Descripcion,
                                        "tipo" => $val->TIPALM_Codigo,
                                        "direccion" => $val->ALMAC_Direccion
                                    );
                }

                $json = array("match" => true, "info" => $lista);
            }
            else
                $json = array("match" => false, "info" => "");

            echo json_encode($json);
        }

        public function guardar_registro(){

            $almacen = $this->input->post("almacen");
            $establecimiento = $this->input->post("establecimiento");
            $codigo_almacen = $this->input->post("codigo_almacen");
            $descripcion_almacen = $this->input->post("descripcion_almacen");
            $tipo_almacen = $this->input->post("tipo_almacen");
            $direccion_almacen = $this->input->post("direccion_almacen");
            
            $filter = new stdClass();
            $filter->TIPALM_Codigo = $tipo_almacen;
            $filter->EESTABP_Codigo = $this->establecimiento;
            $filter->CENCOSP_Codigo = "1";
            $filter->ALMAC_Descripcion = strtoupper($descripcion_almacen);
            $filter->ALMAC_Direccion = strtoupper($direccion_almacen);
            $filter->ALMAC_CodigoUsuario = $codigo_almacen;
            $filter->ALMAC_FlagEstado = "1";

            if ($almacen != ""){
                $filter->ALMAP_Codigo = $almacen;
                $filter->ALMAC_FechaModificacion = date("Y-m-d H:i:s");
                $result = $this->almacen_model->actualizar_almacen($almacen, $filter);
            }
            else{
                $filter->COMPP_Codigo = $this->compania;
                $filter->ALMAC_FechaRegistro = date("Y-m-d H:i:s");
                $result = $this->almacen_model->insertar_almacen($filter);

                $filter_inve = new stdClass();
                $filter_inve->INVE_Titulo   = "INVENTARIO ".$filter->ALMAC_Descripcion;
                $filter_inve->COMPP_Codigo  = $this->compania;
                $filter_inve->INVE_Serie    = "INV";
                $filter_inve->INVE_Numero   = $filter->ALMAC_CodigoUsuario;
                $filter_inve->ALMAP_Codigo  = $result;
                $filter_inve->INVE_FechaInicio  = date("Y-m-d H:i:s");
                $filter_inve->INVE_FechaRegistro = date("Y-m-d H:i:s");
                $filter_inve->INVE_FlagEstado = "1";

                $this->almacen_model->insertar_inventario($filter_inve);
    
            }

            if ($result)
                $json = array("result" => "success");
            else
                $json = array("result" => "error");
            
            echo json_encode($json);
        }

        public function deshabilitar_almacen(){

            $almacen = $this->input->post("almacen");

            $filter = new stdClass();
            $filter->ALMAC_FlagEstado  = "0";

            if ($almacen != ""){
                $filter->ALMAC_FechaModificacion = date("Y-m-d H:i:s");
                $result = $this->almacen_model->deshabilitar_almacen($almacen, $filter);
            }

            if ($result)
                $json = array("result" => "success");
            else
                $json = array("result" => "error");
            
            echo json_encode($json);
        }

    ######################
    #### FUNCTIONS OLDS
    ######################

    public function nuevo()
    {
        $lista_compania = $this->compania_model->obtener_compania($this->compania);
        $lista_estab = $this->emprestablecimiento_model->obtener($lista_compania[0]->EESTABP_Codigo);

        
        $lblEstab = form_label("Establecimiento", "Establecimiento");
        $lblDescripcion = form_label("Nombre Almacen", "Nombre Almacen");
        $lblTipoAlmacen = form_label('Tipo Almacen', 'Tipo Almacen');
        $lblDireccionAlmacen = form_label('Direccón Almacen', 'Dirección Almacen');
        $lblCodigoUsuario = form_label("Código", "CodigoUsuario");
        $nombre_estab = form_input(array('name' => 'establecimiento', 'id' => 'establecimiento', 'value' => $lista_estab[0]->EESTABC_Descripcion, 'maxlength' => '100', 'class' => 'cajaGrande cajaSoloLectura', 'readonly' => 'readonly'));
        $nombre_almacen = form_input(array('name' => 'descripcion', 'id' => 'descripcion', 'value' => '', 'maxlength' => '100', 'class' => 'cajaMedia'));
        $tipo_almacen = form_dropdown('tipo_almacen', $this->tipoalmacen_model->seleccionar(), 'large', "id='tipo_almacen' class='comboMedio'");
        $direccion_almacen = form_input(array('name' => 'direccion', 'id' => 'direccion', 'value' => '', 'maxlength' => '249', 'class' => 'cajaGrande', 'style' => 'width:100%;'));
        $codigo_usuario = form_input(array('name' => 'codigo_usuario', 'id' => 'codigo_usuario', 'value' => '', 'maxlength' => '20', 'class' => 'cajaPequena'));
        $data['titulo'] = "REGISTRAR ALMACEN";
        $data['form_open'] = form_open(base_url() . 'index.php/almacen/almacen/grabar', array("name" => "frmAlmacen", "id" => "frmAlmacen"));
        $data['form_close'] = form_close();
        $data['campos'] = array($lblEstab, $lblDescripcion, $lblTipoAlmacen, $lblDireccionAlmacen, $lblCodigoUsuario);
        $data['valores'] = array($nombre_estab, $nombre_almacen, $tipo_almacen, $direccion_almacen, $codigo_usuario);
        $data['oculto'] = form_hidden(array('codigo' => "", 'base_url' => base_url(), 'almacen_id' => ''));
        $data['onload'] = "onload=\"$('#nombres').focus();\"";
        $this->layout->view('almacen/almacen_nuevo', $data);
    }

    public function editar($id)
    {
        $lista_compania = $this->compania_model->obtener_compania($this->compania);
        $lista_estab = $this->emprestablecimiento_model->obtener($lista_compania[0]->EESTABP_Codigo);

        
        $oAlmacen = $this->almacen_model->obtener($id);
        $lblEstab = form_label("Establecimiento", "Establecimiento");
        $lblDescripcion = form_label("Nombre Almacen", "Nombre Almacen");
        $lblTipoAlmacen = form_label("Tipo Almacen", "Tipo almacen");
        $lblDireccionAlmacen = form_label('Direccón Almacen', 'Dirección Almacen');
        $lblCodigoUsuario = form_label("Código", "CodigoUsuario");
        $nombre_estab = form_input(array('name' => 'establecimiento', 'id' => 'establecimiento', 'value' => $lista_estab[0]->EESTABC_Descripcion, 'maxlength' => '100', 'class' => 'cajaGrande cajaSoloLectura', 'readonly' => 'readonly'));
        $nombre_almacen = form_input(array('name' => 'descripcion', 'id' => 'descripcion', 'value' => $oAlmacen[0]->ALMAC_Descripcion, 'maxlength' => '100', 'class' => 'cajaMedia'));
        $tipo_almacen = form_dropdown('tipo_almacen', $this->tipoalmacen_model->seleccionar(), $oAlmacen[0]->TIPALM_Codigo, "id='tipo_almacen' class='fuente8'");
        $direccion_almacen = form_input(array('name' => 'direccion', 'id' => 'direccion', 'value' => $oAlmacen[0]->ALMAC_Direccion, 'maxlength' => '249', 'class' => 'cajaGrande', 'style' => 'width:100%;'));
        $codigo_usuario = form_input(array('name' => 'codigo_usuario', 'id' => 'codigo_usuario', 'value' => $oAlmacen[0]->ALMAC_CodigoUsuario, 'maxlength' => '20', 'class' => 'cajaPequena'));
        $data['form_open'] = form_open(base_url() . 'index.php/almacen/almacen/grabar/', array("name" => "frmAlmacen", "id" => "frmAlmacen"));
        $data['campos'] = array($lblEstab, $lblDescripcion, $lblTipoAlmacen, $lblDireccionAlmacen, $lblCodigoUsuario);
        $data['valores'] = array($nombre_estab, $nombre_almacen, $tipo_almacen, $direccion_almacen, $codigo_usuario);
        $data['oculto'] = form_hidden(array('codigo' => "", 'base_url' => base_url(), 'almacen_id' => $id));
        $data['form_close'] = form_close();
        $data['titulo'] = "Editar ALMACEN";
        $this->layout->view('almacen/almacen_nuevo', $data);
    }

    public function grabar()
    {
        $this->form_validation->set_rules('descripcion', 'Nombre de almacen', 'required');
        $this->form_validation->set_rules('tipo_almacen', 'Tipo de almacen', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->nuevo();
        } else {
            $descripcion = $this->input->post("descripcion");
            $tipo_almacen = $this->input->post("tipo_almacen");
            $almacen_id = $this->input->post("almacen_id");
            $direccion = $this->input->post("direccion");
            $codigo_usuario = $this->input->post("codigo_usuario");
            $filter = new stdClass();
            $lista_compania = $this->compania_model->obtener_compania($this->compania);
            $filter->EESTABP_Codigo = $lista_compania[0]->EESTABP_Codigo;
            $filter->ALMAC_Descripcion = strtoupper($descripcion);
            $filter->TIPALM_Codigo = $tipo_almacen;
            $filter->CENCOSP_Codigo = 1;
            $filter->ALMAC_CodigoUsuario = $codigo_usuario;
            $filter->ALMAC_Direccion = $direccion;
            if (isset($almacen_id) && $almacen_id > 0) {
                $this->almacen_model->modificar($almacen_id, $filter);
            } else {
                $filter->COMPP_Codigo = $this->compania;
                $this->almacen_model->insertar($filter);
            }
            header("location:" . base_url() . "index.php/almacen/almacen/listar");
        }
    }

    public function eliminar()
    {
        $id = $this->input->post('almacen');
        $this->almacen_model->eliminar($id);
    }

    public function ver($codigo)
    {
        
        $datos_almacen = $this->almacen_model->obtener($codigo);
        $nombre_almacen = $datos_almacen[0]->ALMAC_Descripcion;
        $direccion_almacen = $datos_almacen[0]->ALMAC_Direccion;
        $tipo_almacen = $datos_almacen[0]->TIPALM_Codigo;
        $datos_tipoalmacen = $this->tipoalmacen_model->obtener($tipo_almacen);
        $nombre_tipoalmacen = $datos_tipoalmacen[0]->TIPALM_Descripcion;
        $data['nombre_almacen'] = $nombre_almacen;
        $data['direccion_almacen'] = $direccion_almacen;
        $data['nombre_tipoalmacen'] = $nombre_tipoalmacen;
        $data['titulo'] = "VER ALMACEN";
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->layout->view('almacen/almacen_ver', $data);
    }

    public function buscar($j = 0)
    {
        
        $nombre_almacen = $this->input->post('nombre_almacen');
        $tipo_almacen = $this->input->post('tipo_almacen');
        $filter = new stdClass();
        $filter->ALMAC_Descripcion = $nombre_almacen;
        $filter->TIPALM_Codigo = $tipo_almacen;
        $data['registros'] = count($this->almacen_model->buscar($filter));
        $conf['base_url'] = site_url('almacen/almacen/buscar/');
        $conf['per_page'] = 10;
        $conf['num_links'] = 3;
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['total_rows'] = $data['registros'];
        $offset = (int)$this->uri->segment(4);
        $listado = $this->almacen_model->buscar($filter, $conf['per_page'], $offset);
        $item = $j + 1;
        $lista = array();
        if (count($listado) > 0) {
            foreach ($listado as $indice => $valor) {
                $codigo = $valor->ALMAP_Codigo;
                $editar = "<a href='#' onclick='editar_almacen(" . $codigo . ")'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver = "<a href='#' onclick='ver_almacen(" . $codigo . ")'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                $eliminar = "<a href='#' onclick='eliminar_almacen(" . $codigo . ")'><img src='" . base_url() . "images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $lista[] = array($item++, $valor->ALMAC_Descripcion, $valor->EESTABC_Descripcion, $valor->ALMAC_CodigoUsuario, $valor->TIPALM_Descripcion, $editar, $ver, $eliminar, $valor->ALMAC_Direccion);
            }
        }
        $data['titulo_tabla'] = "RESULTADO DE BUSQUEDA de ALMACENES";
        $data['titulo_busqueda'] = "BUSCAR ALMACEN";
        $data['nombre_almacen'] = form_input(array('name' => 'nombre_almacen', 'id' => 'nombre_almacen', 'value' => $nombre_almacen, 'maxlength' => '100', 'class' => 'cajaMedia'));
        $data['tipo_almacen'] = form_dropdown('tipo_almacen', $this->tipoalmacen_model->seleccionar(), $tipo_almacen, "id='tipo_almacen' class='comboMedio'");
        $data['form_open'] = form_open(base_url() . 'index.php/almacen/almacen/buscar', array("name" => "form_busquedaAlmacen", "id" => "form_busquedaAlmacen"));
        $data['form_close'] = form_close();
        $data['lista'] = $lista;
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('almacen/almacen_index', $data);
    }

    public function reportes()
    {
        $combo = '';
        
        $data['titulo'] = "REPORTES DE ALMACEN";
        $data['combo'] = $combo;
        $data['cboAlmacen'] = form_dropdown("almacen_id", $this->almacen_model->seleccionar("TODOS"), false, " class='comboMedio' id='almacen_id'");
        $this->layout->view('almacen/alamcen_reporte', $data);
    }

    public function reporte_xls($almacen_id = "")
    {
        $listado = $this->almacenproducto_model->listar($almacen_id);
        $xls = utf8_decode_seguro('<b>REPORTE DE PRODUCTOS POR ALMACEN: ') . '</b>';
        $date = date('Y-m-d');
        //$item               = $j+1;
        $kk = 1;
        $lista = array();
        $producto_anterior = 0;
        $cantidad_anterior = 0;
        $costo_anterior = 0;
        $filtro = $almacen_id != "" ? true : false;
        header('Content-Disposition: attachment; filename="' . $date . '.xls"');
        header("Content-Type: application/vnd.ms-excel");
        $xls .= "
		<table border=1>
		<tr><th>Item</th><th>" . utf8_decode_seguro('Código Interno') . "</th><th>" . utf8_decode_seguro('Descripción') . "</th><th>" . utf8_decode_seguro('Código de Usuario') . "</th><th>Stock</th><th>Uni.</th><th>Costo</th><th>Valor</th></tr>
		";
        if (count($listado) > 0) {
            foreach ($listado as $indice => $valor) {
                $almacen = $valor->ALMAC_Codigo;
                $producto = $valor->PROD_Codigo;
                $cantidad = $valor->ALMPROD_Stock;
                $costo = $valor->ALMPROD_CostoPromedio;
                $producto = $valor->PROD_Codigo;
                $kardex = "<a href='#' onclick='ver_kardex(" . $producto_anterior . ")'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                if ($producto != $producto_anterior && $producto_anterior != 0) {
                    $kk++;
                    $datos_producto = $this->producto_model->obtener_producto($producto_anterior);
                    $nombre_prod = $datos_producto[0]->PROD_Nombre;
                    $codigo_prod = $datos_producto[0]->PROD_CodigoInterno;
                    $fabricante = $datos_producto[0]->FABRIP_Codigo;
                    $flagGenInd = $datos_producto[0]->PROD_GenericoIndividual;
                    $datos_fab = $this->fabricante_model->obtener($fabricante);
                    $nombre_fab = $datos_fab[0]->FABRIC_Descripcion;
                    $datos_unidad = $this->producto_model->obtener_producto_unidad($producto_anterior);
                    $unidad_med = $datos_unidad[0]->UNDMED_Codigo;
                    $datos_unidad2 = $this->unidadmedida_model->obtener($unidad_med);
                    $nombre_und = $datos_unidad2[0]->UNDMED_Simbolo;
                    $xls .= "<tr><td>" . ($indice++) . "</td><td>" . $codigo_prod . "</td><td>" . utf8_decode_seguro($nombre_prod) . "</td><td>" . $valor->PROD_CodigoUsuario . "</td><td>" . $cantidad_anterior . "</td><td>" . $nombre_und . "</td><td>" . number_format($costo_anterior, 2) . "</td><td>" . number_format($cantidad_anterior * $costo_anterior, 2) . "</td></tr>";
                } elseif ($producto == $producto_anterior) {
                    $cantidadn = $cantidad_anterior + $cantidad;
                    $coston = ($cantidad_anterior * $costo_anterior + $cantidad * $costo) / $cantidadn;
                    $cantidad = $cantidadn;
                    $costo = $coston;
                }
                $producto_anterior = $producto;
                $cantidad_anterior = $cantidad;
                $costo_anterior = $costo;
            }
            $datos_producto = $this->producto_model->obtener_producto($producto);
            $nombre_prod = $datos_producto[0]->PROD_Nombre;
            $codigo_prod = $datos_producto[0]->PROD_CodigoInterno;
            $fabricante = $datos_producto[0]->FABRIP_Codigo;
            $flagGenInd = $datos_producto[0]->PROD_GenericoIndividual;
            $datos_fab = $this->fabricante_model->obtener($fabricante);
            $nombre_fab = $datos_fab[0]->FABRIC_Descripcion;
            $datos_unidad = $this->producto_model->obtener_producto_unidad($producto);
            $unidad_med = $datos_unidad[0]->UNDMED_Codigo;
            $datos_unidad2 = $this->unidadmedida_model->obtener($unidad_med);
            $nombre_und = $datos_unidad2[0]->UNDMED_Simbolo;
            $xls .= "<tr><td>" . ($indice++) . "</td><td>" . $codigo_prod . "</td><td>" . utf8_decode_seguro($nombre_prod) . "</td><td>" . $valor->PROD_CodigoUsuario . "</td><td>" . $cantidad_anterior . "</td><td>" . $nombre_und . "</td><td>" . number_format($costo_anterior, 2) . "</td><td>" . number_format($cantidad_anterior * $costo_anterior, 2) . "</td></tr>";
        }
        $data['xls'] = $xls;
        $this->load->view('almacen/almacen_reporte_xls', $data);
    }
    
    
    public function obtener_stock_general_por_almacenes(){
		$producto = $this->input->post('product');

 		$consulta = $this->almacen_model->stock_general_por_almacenes($producto);
        $result = array();
      
        foreach ($consulta AS $datos => $value) {
 
          $empresa = $value->EMPRC_RazonSocial;
          $sucursal = $value->EESTABC_Descripcion;
          $almacen = $value->ALMAC_Descripcion;
          $stock = $value->ALMPROD_Stock ;
          $result[] = array("resultado" => "success" , "empresa" => $empresa, "sucursal" => $sucursal, "almacen" => $almacen, "stock" => $stock);
        }    
        
        echo json_encode($result);
	}
    

    
}

?>