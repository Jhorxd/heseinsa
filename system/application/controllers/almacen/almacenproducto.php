<?php
# CONTROLLER: almacenproducto.php
class Almacenproducto extends controller {

    public function __construct() {
        parent::Controller();
        $this->load->model('almacen/almacenproductoserie_model');
        $this->load->model('almacen/almacenproducto_model');
        $this->load->model('almacen/almacen_model');
        $this->load->model('almacen/producto_model');
        $this->load->model('almacen/unidadmedida_model');
        $this->load->model('almacen/fabricante_model');
        $this->load->model('almacen/marca_model');
        $this->load->helper('form', 'url');
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->library('lib_props');
        $this->somevar['compania'] = $this->session->userdata('compania');
    }

    public function listar($j = '0') {
        
        $data['registros'] = count($this->almacenproducto_model->listar($almacen_id));
        $listado = $this->almacenproducto_model->listar($almacen_id, $modelo, $conf['per_page'], $offset);
        $data['familias']       = $this->producto_model->getFamilias(null);
        $data['modelos']        = $this->producto_model->getModelos();
        $data['listaMarcas']    = $this->marca_model->listar_marca();
        $data['titulo_tabla']   = "STOCK DE ALMACENES";
        $lista_almacen          = $this->almacen_model->getAlmacens();
        $data['almacenes']      = $lista_almacen;
        $valorizacion           = $this->almacenproducto_model->valoriza_stock($filter);
        
        foreach ($valorizacion as $key => $value) {
            if ($value->ALMPROD_Stock>0) {
                $total_valorizado    += $value->PROD_UltimoCosto*$value->ALMPROD_Stock;
                $cantidad_total      += $value->ALMPROD_Stock;
            }
           
        }

        $data['valorizacion']   = "S./ ".$total_valorizado;
        $data['cantidad']       = $cantidad_total;

        $data['form_open']  = form_open(base_url() . 'index.php/almacen/almacenproducto/listar', array("name" => "frmStock", "id" => "frmStock"));
        $data['form_close'] = form_close();
        
        $this->layout->view('almacen/almacenproducto_index', $data);
    }

    public function datatable_almacen_producto(){

        $columnas = array(
                            0 => "PROD_CodigoUsuario",
                            1 => "PROD_Nombre",
                            2 => "MARCC_Descripcion",
                            3 => "ALMPROD_Stock",
                            4 => "UNDMED_Simbolo",
                            5 => "ALMAC_Descripcion"
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

        $filter->searchCodigoUsuario    = $this->input->post("txtCodigo");
        $filter->searchProducto         = $this->input->post("txtNombre");
        $filter->searchFamilia          = $this->input->post("txtFamilia");
        $filter->searchModelo           = $this->input->post("txtModelo");
        $filter->searchMarca            = $this->input->post("txtMarca");
        $filter->almacen                = $this->input->post("almacen");

        $listado = $this->almacenproducto_model->listar($filter);

        $lista = array();
        $item++;
        
        if ( count($listado) > 0 ){
            foreach ($listado as $indice => $valor) {
                $almacen = $valor->ALMAC_Codigo;
                #$producto = $valor->PROD_Codigo;
                #$producto1 = $valor->PROD_Codigo;
                $costo = $valor->ALMPROD_CostoPromedio;

                $nombre_prod = $valor->PROD_Nombre;
                $codigo_prod = $valor->PROD_CodigoUsuario;
                $familia = $valor->FAMI_Descripcion;
                $fabricante = $valor->FABRIC_Descripcion;
                $flagGenInd = $valor->PROD_GenericoIndividual;
                $cantidad = $valor->ALMPROD_Stock;
                                
                $marca = $valor->MARCC_Descripcion;

                $lista[] = array($codigo_prod, $nombre_prod, $familia, $marca, $cantidad, $valor->UNDMED_Simbolo, $valor->ALMAC_Descripcion);
                $item++;
            }
        }

        unset($filter->start);
        unset($filter->length);

        $json = array(
                            "draw"            => intval( $this->input->post('draw') ),
                            "recordsTotal"    => intval( count($this->almacenproducto_model->listar()) ),
                            "recordsFiltered" => intval( count($this->almacenproducto_model->listar($filter)) ),
                            "data"            => $lista
                    );

        echo json_encode($json);

    }

    public function listar_general($j = '0') {
        $data['codigo'] = "";
        $data['nombre'] = "";
        $data['familia'] = "";
        $data['marca'] = "";

        $this->load->library('layout', 'layout');
        $data['registros'] = count($this->producto_model->listar_productos_general('B'));
        $data['action'] = base_url() . "index.php/almacen/almacenproducto/buscar_general";
        $data['action2'] = base_url() . "index.php/almacen/kardex/listar";
        $conf['base_url'] = site_url('almacen/almacenproducto/listar_general');
        $conf['per_page'] = 50;
        $conf['num_links'] = 10;
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['total_rows'] = $data['registros'];
        $conf['uri_segment'] = 4;
        $offset = (int) $this->uri->segment(4);
        $lista_producto = $this->producto_model->listar_productos_general('B', $conf['per_page'], $offset);
        $lista_establec = $this->emprestablecimiento_model->listar($this->session->userdata('empresa'));

        $lista = array();
        $montoTotal = 0;
        $total_valor = 0;
        $total_prods = 0;
        if (count($lista_producto) > 0) {
            foreach ($lista_producto as $producto) {
                $stock = array();
                $total = 0;
                $precios = array();
                foreach ($lista_establec as $establec) {
                    $lista_almacen = $this->almacen_model->buscar_x_establec($establec->EESTABP_Codigo);
                    $cantidad = 0;
                    $valoraza = 0;
                    foreach ($lista_almacen as $almacen) {
                        $cant_almacen=$this->producto_model->obtener_stock($producto->PROD_Codigo, '', $almacen->ALMAP_Codigo);
                        if ($cant_almacen>0) {
                            $cantidad +=$cant_almacen;
                            $valoraza += $cantidad*$producto->PROD_UltimoCosto;
                        }
                         
                    }

                    $total_valor += $valoraza;
                    $total_prods += $cantidad;

                }
            }
        }

        $data['lista_establec'] = $lista_establec;
        $data['stock_total'] = $total_prods;
        $data['montoTotal'] = $total_valor;

        $data['lista_establec'] = $lista_establec;

        $data['totalesCat'] = $this->almacenproducto_model->obtenerSumaStock();
        $data['totalesFami'] = $this->almacenproducto_model->obtenerSumaStockFamilia();
        
        $data['titulo_tabla'] = "STOCK DE GENERAL DE PRODUCTOS";
        $data['oculto'] = form_hidden(array('accion' => "", 'codigo' => "", 'modo' => "insertar", 'base_url' => base_url()));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('almacen/almacenproducto_general', $data);
    }

    public function datatable_almacen_producto_general(){

        $columnas = array(
                            0 => "PROD_CodigoUsuario",
                            1 => "PROD_Nombre"
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

        $filter->searchCodigo = $this->input->post("txtCodigo");
        $filter->searchNombre = $this->input->post("txtNombre");
        $filter->searchModelo = $this->input->post("txtModelo");
        $filter->searchFlagBS = "B";

        $listado = $this->almacenproducto_model->listar_general($filter);
        $lista_establec = $this->emprestablecimiento_model->listar($this->session->userdata('empresa'));


        $lista = array();
        $item++;
        
        if ( count($listado) > 0 ){
            foreach ($listado as $indice => $valor) {

                $total = 0;
                $total_valorizado=0;
                $lista[$indice] = array(
                                    0 => $valor->PROD_CodigoUsuario,
                                    1 => $valor->PROD_Nombre
                                );
                $j = 2;

                foreach ($lista_establec as $establec) {
                    $lista_almacen = $this->almacen_model->buscar_x_establec($establec->EESTABP_Codigo);
                    $cantidad        = 0;
                    $cantidad_actual = 0;
                    foreach ($lista_almacen as $almacen) {
                        $cant_almacen = $this->producto_model->obtener_stock($valor->PROD_Codigo, '', $almacen->ALMAP_Codigo);
                        $cantidad_actual += $cant_almacen;
                        if ($cant_almacen>0) {
                            $cantidad += $cant_almacen;
                            
                        }
                        
                    }
                    $valorizado = $cantidad*$valor->PROD_UltimoCosto;
                    $lista[$indice][$j] = $cantidad_actual.' <font style="color:red ; font-weight:bolder;" >S/'.$valorizado;
                    $total_valorizado+=$valorizado;
                    $total += $cantidad;
                    $j++;
                }
                $lista[$indice][$j] = $total.' <font style="color:red ; font-weight:bolder;" >S/'.$total_valorizado;
            }
        }

        unset($filter->start);
        unset($filter->length);

        $json = array(
                            "draw"            => intval( $this->input->post('draw') ),
                            "recordsTotal"    => intval( count($this->almacenproducto_model->listar_general()) ),
                            "recordsFiltered" => intval( count($this->almacenproducto_model->listar_general($filter)) ),
                            "data"            => $lista
                    );

        echo json_encode($json);

    }

   

    public function ver($codigo) {
        
        $datos_almacen = $this->almacen_model->obtener($codigo);
        $nombre_almacen = $datos_almacen[0]->ALMAC_Descripcion;
        $tipo_almacen = $datos_almacen[0]->TIPALM_Codigo;
        $datos_tipoalmacen = $this->tipoalmacen_model->obtener($tipo_almacen);
        $nombre_tipoalmacen = $datos_tipoalmacen[0]->TIPALM_Descripcion;
        $data['nombre_almacen'] = $nombre_almacen;
        $data['nombre_tipoalmacen'] = $nombre_tipoalmacen;
        $data['titulo'] = "VER ALMACEN";
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->layout->view('almacen/almacen_ver', $data);
    }

    public function buscar($j = 0) {
        
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
        $offset = (int) $this->uri->segment(4);
        $listado = $this->almacen_model->buscar($filter, $conf['per_page'], $offset);
        $item = $j + 1;
        $lista = array();
        if (count($listado) > 0) {
            foreach ($listado as $indice => $valor) {
                $codigo = $valor->ALMAP_Codigo;
                $editar = "<a href='#' onclick='editar_almacen(" . $codigo . ")' target='_parent'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver = "<a href='#' onclick='ver_almacen(" . $codigo . ")' target='_parent'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                $eliminar = "<a href='#' onclick='eliminar_almacen(" . $codigo . ")' target='_parent'><img src='" . base_url() . "images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $lista[] = array($item++, $valor->ALMAC_Descripcion, $valor->TIPALM_Descripcion, $editar, $ver, $eliminar);
            }
        }
        $data['titulo_tabla'] = "RESULTADO DE BUSQUEDA de ALMACENES";
        $data['titulo_busqueda'] = "BUSCAR ALMACEN";
        $data['nombre_almacen'] = form_input(array('name' => 'nombre_almacen', 'id' => 'nombre_almacen', 'value' => $nombre_almacen, 'maxlength' => '100', 'class' => 'cajaMedia'));
        $data['tipo_almacen'] = form_dropdown('tipo_almacen', $this->tipoalmacen_model->seleccionar(), $tipo_almacen, "id='tipo_almacen' class='comboMedio'");
        $data['form_open'] = form_open(base_url() . 'index.php/almacen/almacen/buscar', array("name" => "form_busquedaAlmacen", "id" => "form_busquedaAlmacen"));
        $data['form_close'] = form_close();
        $data['lista'] = $lista;
        $data['modelos'] = $this->producto_model->getModelos();
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('almacen/almacen_index', $data);
    }
    
    public function verReporteExcel( $modelo = "" ){
        $this->load->library('Excel');
        $listadoAlmacen = $this->almacenproducto_model->listar("", $modelo);
        
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Reporte');

        ###########################################
        ######### ESTILOS
        ###########################################
            $estiloTitulo = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => true,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                ),
                                                'size' => 11
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

            $estiloColumnasTitulo = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => true,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                ),
                                                'size' => 11
                                            ),
                                            'fill'  => array(
                                                'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('argb' => 'ECF0F1')
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

            $estiloColumnasPar = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => false,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                )
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

            $estiloColumnasImpar = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => false,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                )
                                            ),
                                            'fill'  => array(
                                                'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('argb' => 'DCDCDCDC')
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
        $this->excel->getActiveSheet()->getStyle("A1:K2")->applyFromArray($estiloTitulo);
        $this->excel->getActiveSheet()->getStyle("A3:K3")->applyFromArray($estiloColumnasTitulo);
        $this->excel->setActiveSheetIndex(0)->mergeCells('A1:K2')->setCellValue('A1', $_SESSION['nombre_empresa']);
        
        $lugar = 3;
        $this->excel->setActiveSheetIndex(0)->setCellValue("A$lugar", 'N');
        $this->excel->setActiveSheetIndex(0)->setCellValue("B$lugar", 'Almacen');
        $this->excel->setActiveSheetIndex(0)->setCellValue("C$lugar", 'Codigo');
        $this->excel->setActiveSheetIndex(0)->setCellValue("D$lugar", 'Descripcion');
        $this->excel->setActiveSheetIndex(0)->setCellValue("E$lugar", 'Familia');
        $this->excel->setActiveSheetIndex(0)->setCellValue("F$lugar", 'Modelo');
        $this->excel->setActiveSheetIndex(0)->setCellValue("G$lugar", 'Marca');
        $this->excel->setActiveSheetIndex(0)->setCellValue("H$lugar", 'Stock General');
        $this->excel->setActiveSheetIndex(0)->setCellValue("I$lugar", 'Stock Minimo');
        $this->excel->setActiveSheetIndex(0)->setCellValue("J$lugar", 'Costo');
        $this->excel->setActiveSheetIndex(0)->setCellValue("K$lugar", 'Total Valorizado');
    
        $numeroS = 0;
        $lugar = 4;

        $producto = "";
        
        foreach($listadoAlmacen as $indice => $valor){
            $numeroS+=1;
            $Almacen = $valor->ALMAC_Descripcion;
            $total_valorizado = $valor->ALMPROD_Stock*$valor->PROD_UltimoCosto;
            $this->excel->setActiveSheetIndex(0)
            ->setCellValue("A$lugar", $numeroS)
            ->setCellValue("B$lugar", $valor->ALMAC_Descripcion)
            ->setCellValue("C$lugar", $valor->PROD_CodigoUsuario)
            ->setCellValue("D$lugar", $valor->PROD_Nombre)
            ->setCellValue("E$lugar", $valor->FAMI_Descripcion)
            ->setCellValue("F$lugar", $valor->PROD_Modelo)
            ->setCellValue("G$lugar", $valor->MARCC_Descripcion)
            ->setCellValue("H$lugar", $valor->ALMPROD_Stock)
            ->setCellValue("I$lugar", $valor->PROD_StockMinimo)
            ->setCellValue("J$lugar", $valor->PROD_UltimoCosto)
            ->setCellValue("K$lugar", $total_valorizado);

            if ($indice > 1 && $producto == $valor->PROD_Codigo)
                $this->excel->getActiveSheet()->getStyle("A$lugar:K$lugar")->applyFromArray($estiloColumnasPar);
            else
                $this->excel->getActiveSheet()->getStyle("A$lugar:K$lugar")->applyFromArray($estiloColumnasImpar);

            $lugar+=1;
            $producto = $valor->PROD_Codigo;
        }

        for($i = 'A'; $i <= 'K'; $i++){
            $this->excel->setActiveSheetIndex(0)            
                ->getColumnDimension($i)->setAutoSize(true);
        }
        
        $filename = "Stock almacen general ".date('Y-m-d').".xls"; //save our workbook as this file name

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0"); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');
    }
    
    public function verCotizados($inicio = 0, $fin = 0){
        $this->load->library('Excel');
        $listadoAlmacen = $this->almacenproducto_model->listarCotizados("", $inicio, $fin);
        
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Reporte');

        ###########################################
        ######### ESTILOS
        ###########################################
            $estiloTitulo = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => true,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                ),
                                                'size' => 11
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

            $estiloColumnasTitulo = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => true,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                ),
                                                'size' => 9
                                            ),
                                            'fill'  => array(
                                                'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('argb' => 'ECF0F1')
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

            $estiloColumnasPar = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => false,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                ),
                                                'size' => 9
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

            $estiloColumnasImpar = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => false,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                ),
                                                'size' => 9
                                            ),
                                            'fill'  => array(
                                                'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('argb' => 'DCDCDCDC')
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('25');
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('10');
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('11');
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth('10');
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth('11');
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth('10');
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth('10');

        $rango = ($inicio > 0 && $fin > 0) ? " COTIZADO DESDE EL NÚMERO $inicio HASTA $fin." : "";
        $this->excel->getActiveSheet()->getStyle("A1:G3")->applyFromArray($estiloTitulo);
        $this->excel->setActiveSheetIndex(0)->mergeCells('A1:G2')->setCellValue('A1', $_SESSION['nombre_empresa']);
        $this->excel->setActiveSheetIndex(0)->mergeCells('A3:G3')->setCellValue('A3', "STOCK ACTUAL DE ARTICULOS Y CANTIDAD COTIZADA. $rango EMITIDO EL : ".date("d / m / Y")." a las: ".date("h:i:s") );
        
        $lugar = 4;
        $this->excel->getActiveSheet()->getStyle("A$lugar:G$lugar")->applyFromArray($estiloColumnasTitulo);
        $this->excel->setActiveSheetIndex(0)->setCellValue("A$lugar", 'Descripcion');
        $this->excel->setActiveSheetIndex(0)->setCellValue("B$lugar", 'Marca');
        $this->excel->setActiveSheetIndex(0)->setCellValue("C$lugar", 'Stock Minimo');
        $this->excel->setActiveSheetIndex(0)->setCellValue("D$lugar", 'Stock Actual');
        $this->excel->setActiveSheetIndex(0)->setCellValue("E$lugar", 'Stock Cotizado');
        $this->excel->setActiveSheetIndex(0)->setCellValue("F$lugar", 'Precio Costo');
        $this->excel->setActiveSheetIndex(0)->setCellValue("G$lugar", 'Precio Venta');
    
        $numeroS = 0;
        $lugar++;

        $producto = "";

        $tcosto = 0;
        $tpv = 0;
        
        foreach($listadoAlmacen as $indice => $valor){
            $numeroS+=1;
            $Almacen = $valor->ALMAC_Descripcion;
            $this->excel->setActiveSheetIndex(0)
            ->setCellValue("A$lugar", $valor->PROD_Nombre)
            ->setCellValue("B$lugar", $valor->MARCC_CodigoUsuario)
            ->setCellValue("C$lugar", $valor->PROD_StockMinimo)
            ->setCellValue("D$lugar", $valor->ALMPROD_Stock)
            ->setCellValue("E$lugar", $valor->cantidad)
            ->setCellValue("F$lugar", number_format($valor->costo,2) )
            ->setCellValue("G$lugar", number_format($valor->pv,2) );

            if ($indice > 1 && $producto == $valor->PROD_Codigo)
                $this->excel->getActiveSheet()->getStyle("A$lugar:G$lugar")->applyFromArray($estiloColumnasPar);
            else
                $this->excel->getActiveSheet()->getStyle("A$lugar:G$lugar")->applyFromArray($estiloColumnasImpar);

            $lugar+=1;
            $producto = $valor->PROD_Codigo;

            $tcosto += $valor->costo;
            $tpv += $valor->pv;
        }

        $this->excel->setActiveSheetIndex(0)
            ->setCellValue("E$lugar", "TOTAL")
            ->setCellValue("F$lugar", number_format($tcosto,2) )
            ->setCellValue("G$lugar",  number_format($tpv,2));

        #for($i = 'C'; $i <= 'G'; $i++){
        #    $this->excel->setActiveSheetIndex(0)            
        #        ->getColumnDimension($i)->setAutoSize(true);
        #}
        
        $filename = "Stock general y cantidad cotizada ".date('Y-m-d').".xls"; //save our workbook as this file name

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0"); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');
    }

    
    public function registro_producto_pdf($flagbs = 'B', $codigo='', $nombre='')
    {

        $this->load->library('cezpdf');
        $this->load->helper('pdf_helper');
        //prep_pdf();
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

            


        $this->cezpdf->ezText('<b>LISTADO FAMILIA DE ARTICULOS</b>', 14, array("leading" => 0, 'left' => 185));
        $this->cezpdf->ezText('', '', array("leading" => 10));


        /* Datos del cliente */

        $db_data = array();

        //LIMPIAR

       
        $filter = new stdClass();
        $filter->flagBS = 'B';
        $filter->codigo = $codigo;
        $filter->nombre = $nombre;
      
        $lista_producto = $this->producto_model->buscar_productos_general($filter);
        $lista_establec = $this->emprestablecimiento_model->listar($this->session->userdata('empresa'));
        $item = $j + 1;
        $lista = array();
        if (count($lista_producto) > 0) {
            foreach ($lista_producto as $producto) {
                $stock = array();
                $total = 0;
                foreach ($lista_establec as $establec) {
                    $lista_almacen = $this->almacen_model->buscar_x_establec($establec->EESTABP_Codigo);
                    $cantidad = 0;
                    foreach ($lista_almacen as $almacen) {
                        $cantidad += $this->producto_model->obtener_stock($producto->PROD_Codigo, '', $almacen->ALMAP_Codigo);
                    }
                    $total+=$cantidad;
                    $stock[] = $cantidad;
                }
                $stock[] = $total;
                $lista[] = array($item++, $producto->PROD_Codigo, $producto->PROD_GenericoIndividual, $producto->PROD_CodigoUsuario, $producto->PROD_Nombre, $stock);
            }
        }
        $data['lista'] = $lista;
       
        //FIN
            if(count($lista)>0){
                    foreach($lista as $indice=>$valor){
                    $codigo = $valor->FAMI_Codigo;
                    $codigo_interno = $valor->FAMI_CodigoInterno;
                    $descripcion = $valor->FAMI_Descripcion;


                    $db_data[] = array(
                        'cols1' => $indice + 1,
                        'cols2' => $codigo_interno,
                        'cols3' => $descripcion
                    );
                }
            }

        


        $col_names = array(
            'cols1' => '<b>ITEM</b>',
            'cols2' => '<b>CODIGO</b>',
            'cols3' => '<b>DESCRIPCION</b>'
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
                'cols2' => array('width' => 70, 'justification' => 'center'),
                'cols3' => array('width' => 245, 'justification' => 'left')
            )
        ));


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => $codificacion . '.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        ob_end_clean();

        $this->cezpdf->ezStream($cabecera);
    }


    public function excel_stock_general() //Reporte All
    {
      
        $lista_producto = $this->producto_model->listar_productos_general('B', "", "");
        $lista_establec = $this->emprestablecimiento_model->listar($this->session->userdata('empresa'));
        $item = $j + 1;
        $lista = array();
        $montoTotal = 0;
        
        $this->load->library('Excel');
        
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Reporte General de Empresa');

        ###########################################
        ######### ESTILOS
        ###########################################
            $estiloTitulo = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => true,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                ),
                                                'size' => 11
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

            $estiloColumnasTitulo = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => true,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                ),
                                                'size' => 11
                                            ),
                                            'fill'  => array(
                                                'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('argb' => 'ECF0F1')
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

            $estiloColumnasPar = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => false,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                )
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

            $estiloColumnasImpar = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => false,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                )
                                            ),
                                            'fill'  => array(
                                                'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('argb' => 'DCDCDCDC')
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

        
        
        $lugar = 4;
        $lugar_cabecera = 3;
        $this->excel->setActiveSheetIndex(0)->setCellValue("A$lugar_cabecera", 'Codigo');
        $this->excel->setActiveSheetIndex(0)->setCellValue("B$lugar_cabecera", 'Nombre');
        if (count($lista_producto) > 0) {
            foreach ($lista_producto as $producto) {
                $stock = array();
                $total = 0;
                $total_valorizado = 0;
                $precios = array();
                $this->excel->setActiveSheetIndex(0)->setCellValue("A$lugar", $producto->PROD_CodigoUsuario);
                $this->excel->setActiveSheetIndex(0)->setCellValue("B$lugar", $producto->PROD_Nombre);
                $letra = 3;
                foreach ($lista_establec as $establec){
                    
                    $this->excel->setActiveSheetIndex(0)->setCellValue($this->lib_props->colExcel($letra).$lugar_cabecera, $establec->EESTABC_Descripcion);
                    $this->excel->setActiveSheetIndex(0)->setCellValue($this->lib_props->colExcel($letra+1).$lugar_cabecera, "COSTO");

                    $lista_almacen = $this->almacen_model->buscar_x_establec($establec->EESTABP_Codigo);
                    $cantidad = 0;
                    foreach ($lista_almacen as $almacen) {
                        $cantidad += $this->producto_model->obtener_stock($producto->PROD_Codigo, '', $almacen->ALMAP_Codigo);
                    }

                    $this->excel->setActiveSheetIndex(0)->setCellValue($this->lib_props->colExcel($letra).$lugar, $cantidad);
                    
                    $valorizado = $producto->PROD_UltimoCosto*$cantidad;
                    $total+=$cantidad;
                    $total_valorizado+=$valorizado;
                    $stock[] = $cantidad;
                    $letra = $letra+1;
                    $this->excel->setActiveSheetIndex(0)->setCellValue($this->lib_props->colExcel($letra).$lugar, $valorizado);
                    $letra = $letra+1;
                    
                }
                $this->excel->setActiveSheetIndex(0)->setCellValue($this->lib_props->colExcel($letra).$lugar, $producto->PROD_Nombre);
                
                
                $this->excel->setActiveSheetIndex(0)->setCellValue($this->lib_props->colExcel($letra).$lugar, $total);
                $this->excel->setActiveSheetIndex(0)->setCellValue($this->lib_props->colExcel($letra+1).$lugar, $total_valorizado);
                $lugar++;

            }
        }
        $this->excel->setActiveSheetIndex(0)->setCellValue($this->lib_props->colExcel($letra)."3", 'TOTAL');
        $this->excel->setActiveSheetIndex(0)->setCellValue($this->lib_props->colExcel($letra+1)."3", 'TOTAL VAL.');
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
        $this->excel->getActiveSheet()->getStyle("A1:".$this->lib_props->colExcel($letra+1)."2")->applyFromArray($estiloTitulo);
        $this->excel->getActiveSheet()->getStyle("A3:".$this->lib_props->colExcel($letra+1).'3')->applyFromArray($estiloColumnasTitulo);
        $this->excel->setActiveSheetIndex(0)->mergeCells('A1:'.$this->lib_props->colExcel($letra+1).'2')->setCellValue('A1', $_SESSION['nombre_empresa']); 

        $letra_final=$this->lib_props->colExcel($letra+1);
        for($i = 'A'; $i <= $letra_final; $i++){
            $this->excel->setActiveSheetIndex(0)            
                ->getColumnDimension($i)->setAutoSize(true);
        }

        $filename = "Stock General Empresa ".date('Y-m-d').".xls"; //save our workbook as this file name

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0"); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');



    }
    public function datatable_stockcosto(){

        $columnas = array(
                            0 => "PROD_CodigoUsuario",
                            1 => "PROD_Nombre",
                            2 => "MARCC_Descripcion",
                            3 => "ALMPROD_Stock",
                            4 => "UNDMED_Simbolo",
                            5 => "ALMAC_Descripcion"
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

        $filter->searchProducto = $this->input->post("nombre_prod");
        $filter->searchModelo = $this->input->post("txtModelo");
        $filter->searchMarca = $this->input->post("txtMarca");

        $lista = array();
        $item++;
        $lista_establec = $this->compania_model->listar($this->session->userdata('empresa'));

        foreach ($lista_establec as $key => $value) {
            $establecimiento_datos=$this->emprestablecimiento_model->getEstablecimiento($value->EESTABP_Codigo);
            $establecimiento = $establecimiento_datos[0]->EESTABC_Descripcion;
            $detalles_almacen = $this->almacenproducto_model->detalles_almacen($value->COMPP_Codigo);
            $stock=0;
            $valorizado=0;
            foreach ($detalles_almacen as $key => $valor) {
                if ($valor->ALMPROD_Stock>0) {//solo refleja las cantidades positivas
                    $stock+=$valor->ALMPROD_Stock;
                    $valorizado+=$valor->ALMPROD_Stock*$valor->PROD_UltimoCosto;
                }
            }

            $lista[] = array(
                $establecimiento, 
                $stock,
                "S/ ".$valorizado
                
            );
            
        }
        
        unset($filter->start);
        unset($filter->length);

        $json = array(
            "draw"            => intval( $this->input->post('draw') ),
            "recordsTotal"    => intval( count($this->almacenproducto_model->listar()) ),
            "recordsFiltered" => intval( count($this->almacenproducto_model->listar($filter)) ),
            "data"            => $lista
        );

        echo json_encode($json);

    }

#REPORTES ALMACEN

    public function verReporteExcel_Det( $modelo = "" ){
        $this->load->library('Excel');
        $listadoAlmacen = $this->almacenproducto_model->listar("", $modelo);
        
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Reporte');

        ###########################################
        ######### ESTILOS
        ###########################################
            $estiloTitulo = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => true,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                ),
                                                'size' => 11
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

            $estiloColumnasTitulo = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => true,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                ),
                                                'size' => 11
                                            ),
                                            'fill'  => array(
                                                'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('argb' => 'ECF0F1')
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

            $estiloColumnasPar = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => false,
                                                'color'     => array(
                                                'rgb' => '000000'
                                                )
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

            $estiloColumnasImpar = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => false,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                )
                                            ),
                                            'fill'  => array(
                                                'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('argb' => 'DCDCDCDC')
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
        $this->excel->getActiveSheet()->getStyle("A1:K2")->applyFromArray($estiloTitulo);
        $this->excel->getActiveSheet()->getStyle("A3:K3")->applyFromArray($estiloColumnasTitulo);
        $this->excel->setActiveSheetIndex(0)->mergeCells('A1:K2')->setCellValue('A1', $_SESSION['nombre_empresa']);
        
        $lugar = 3;
        $this->excel->setActiveSheetIndex(0)->setCellValue("A$lugar", 'Nro');
        $this->excel->setActiveSheetIndex(0)->setCellValue("B$lugar", 'CODIGO');
        $this->excel->setActiveSheetIndex(0)->setCellValue("C$lugar", 'DESCRIPCION');
        $this->excel->setActiveSheetIndex(0)->setCellValue("D$lugar", 'P.COSTO');
        $this->excel->setActiveSheetIndex(0)->setCellValue("E$lugar", 'P. VENTA');
        $this->excel->setActiveSheetIndex(0)->setCellValue("F$lugar", 'STOCK');
        $this->excel->setActiveSheetIndex(0)->setCellValue("G$lugar", 'C.TOTAL');
        $this->excel->setActiveSheetIndex(0)->setCellValue("H$lugar", 'V. TOTAL SOLES');
        $this->excel->setActiveSheetIndex(0)->setCellValue("I$lugar", 'GANANCIA ESTIMADA');
        $this->excel->setActiveSheetIndex(0)->setCellValue("J$lugar", 'UNIDAD');
        $this->excel->setActiveSheetIndex(0)->setCellValue("K$lugar", 'ALMACEN');
        
    
        $numeroS = 0;
        $lugar = 4;

        $producto = "";
        
        


        $listado = $this->almacenproducto_model->listar();

        $lista = array();
        $item++;
        
        if ( count($listado) > 0 ){
            foreach ($listado as $indice => $valor) {
                if ($valor->ALMPROD_Stock>0) {
                    $numeroS = $indice+1;
                    $almacen = $valor->ALMAC_Codigo;
                    #$producto = $valor->PROD_Codigo;
                    #$producto1 = $valor->PROD_Codigo;
                    $p_costo=$valor->PROD_UltimoCosto;
                    $pucosto = $p_costo;

                    $nombre_prod = $valor->PROD_Nombre;
                    $codigo_prod = $valor->PROD_CodigoUsuario;
                    $familia = $valor->FAMI_Descripcion;
                    $fabricante = $valor->FABRIC_Descripcion;
                    $flagGenInd = $valor->PROD_GenericoIndividual;
                    $cantidad = $valor->ALMPROD_Stock;
                                    
                    $marca = $valor->MARCC_Descripcion;
                    
                    $categorias = $this->producto_model->getSoloPrecios($valor->PROD_Codigo);
                    $j = 0;
                    $pu_venta ="";
                    $total_venta = "";
                    $T_venta = 0;
                    $span_ganancia = "";
                    $total_costo = $cantidad*$p_costo;
                    #var_dump($categorias);exit();
                    foreach ($categorias as $i => $v){
                        if ($v->MONED_Codigo==1 ) {
                            # code...
                        $ganancia_estimada = 0;
                        $total_v = 0;
                        $total_v = $cantidad*$v->PRODPREC_Precio;
                        $moneda = $v->MONED_Simbolo;
                        if ($v->PRODPREC_Precio>0) {
                            $color="green";
                        }else{
                            $color="red";

                        }
                        $total_venta = $total_v;
                        $pu_venta = $v->PRODPREC_Precio;
                        
                        $ganancia_estimada = $total_v - $total_costo;
                        $span_ganancia = $ganancia_estimada;
                        }

                    }
                    
                    $this->excel->setActiveSheetIndex(0)
                    ->setCellValue("A$lugar", $numeroS)
                    ->setCellValue("B$lugar", $codigo_prod)
                    ->setCellValue("C$lugar", $nombre_prod)
                    ->setCellValue("D$lugar", $pucosto)
                    ->setCellValue("E$lugar", $pu_venta)
                    ->setCellValue("F$lugar", $cantidad)
                    ->setCellValue("G$lugar", $total_costo)
                    ->setCellValue("H$lugar", $total_venta)
                    ->setCellValue("I$lugar", $span_ganancia)
                    ->setCellValue("J$lugar", $valor->UNDMED_Simbolo)
                    ->setCellValue("K$lugar", $valor->ALMAC_Descripcion);
                    

                    if ($indice > 1 && $producto == $valor->PROD_Codigo)
                        $this->excel->getActiveSheet()->getStyle("A$lugar:K$lugar")->applyFromArray($estiloColumnasPar);
                    else
                        $this->excel->getActiveSheet()->getStyle("A$lugar:K$lugar")->applyFromArray($estiloColumnasImpar);

                    $lugar+=1;
                    $producto = $valor->PROD_Codigo;    
                    
                    
                }
            }
        }


        for($i = 'A'; $i <= 'K'; $i++){
            $this->excel->setActiveSheetIndex(0)            
                ->getColumnDimension($i)->setAutoSize(true);
        }
        
        $filename = "Stock almacen Detalles ".date('Y-m-d').".xls"; //save our workbook as this file name

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0"); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');
    }

    public function verReporteExcelDetalle(){
        $this->load->library('Excel');
        $listadoAlmacen = $this->almacenproducto_model->detalles();
        
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Reporte');

        ###########################################
        ######### ESTILOS
        ###########################################
            $estiloTitulo = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => true,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                ),
                                                'size' => 11
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

            $estiloColumnasTitulo = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => true,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                ),
                                                'size' => 11
                                            ),
                                            'fill'  => array(
                                                'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('argb' => 'ECF0F1')
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

            $estiloColumnasPar = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => false,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                )
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

            $estiloColumnasImpar = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => false,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                )
                                            ),
                                            'fill'  => array(
                                                'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('argb' => 'DCDCDCDC')
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
        $this->excel->getActiveSheet()->getStyle("A1:K2")->applyFromArray($estiloTitulo);
        $this->excel->getActiveSheet()->getStyle("A3:K3")->applyFromArray($estiloColumnasTitulo);
        $this->excel->setActiveSheetIndex(0)->mergeCells('A1:K2')->setCellValue('A1', $_SESSION['nombre_empresa']);
        
        $lugar = 3;
        $this->excel->setActiveSheetIndex(0)->setCellValue("A$lugar", 'N');
        $this->excel->setActiveSheetIndex(0)->setCellValue("B$lugar", 'Almacen');
        $this->excel->setActiveSheetIndex(0)->setCellValue("C$lugar", 'Codigo');
        $this->excel->setActiveSheetIndex(0)->setCellValue("D$lugar", 'Descripcion');
        $this->excel->setActiveSheetIndex(0)->setCellValue("E$lugar", 'Familia');
        $this->excel->setActiveSheetIndex(0)->setCellValue("F$lugar", 'Modelo');
        $this->excel->setActiveSheetIndex(0)->setCellValue("G$lugar", 'Marca');
        $this->excel->setActiveSheetIndex(0)->setCellValue("H$lugar", 'Numero de lote');
        $this->excel->setActiveSheetIndex(0)->setCellValue("I$lugar", 'Vencimiento de lote');
        $this->excel->setActiveSheetIndex(0)->setCellValue("J$lugar", 'Precio Costo');
        $this->excel->setActiveSheetIndex(0)->setCellValue("K$lugar", 'Stock Lote');
    
        $numeroS = 0;
        $lugar = 4;

        $producto = "";
        
        foreach($listadoAlmacen as $indice => $valor){
            $numeroS+=1;
            $Almacen = $valor->ALMAC_Descripcion;
            $this->excel->setActiveSheetIndex(0)
            ->setCellValue("A$lugar", $numeroS)
            ->setCellValue("B$lugar", $valor->ALMAC_Descripcion)
            ->setCellValue("C$lugar", $valor->PROD_CodigoUsuario)
            ->setCellValue("D$lugar", $valor->PROD_Nombre)
            ->setCellValue("E$lugar", $valor->FAMI_Descripcion)
            ->setCellValue("F$lugar", $valor->PROD_Modelo)
            ->setCellValue("G$lugar", $valor->MARCC_Descripcion)
            ->setCellValue("H$lugar", $valor->LOTC_Numero)
            ->setCellValue("I$lugar", $valor->LOTC_FechaVencimiento)
            ->setCellValue("J$lugar", number_format($valor->ALMALOTC_Costo,2))
            ->setCellValue("K$lugar", $valor->ALMALOTC_Cantidad);

            if ($indice > 1 && $producto == $valor->PROD_Codigo)
                $this->excel->getActiveSheet()->getStyle("A$lugar:K$lugar")->applyFromArray($estiloColumnasPar);
            else
                $this->excel->getActiveSheet()->getStyle("A$lugar:K$lugar")->applyFromArray($estiloColumnasImpar);

            $lugar+=1;
            $producto = $valor->PROD_Codigo;
        }

        for($i = 'A'; $i <= 'K'; $i++){
            $this->excel->setActiveSheetIndex(0)            
                ->getColumnDimension($i)->setAutoSize(true);
        }
        
        $filename = "Stock almacen detallado ".date('Y-m-d').".xls"; //save our workbook as this file name

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0"); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');
    }


}

?>