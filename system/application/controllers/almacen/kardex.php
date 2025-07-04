<?php

class Kardex extends controller
{

    public function __construct()
    {
        parent::Controller();
        $this->load->model('almacen/kardex_model');
        $this->load->model('almacen/producto_model');
        $this->load->model('almacen/almacenproducto_model');
        $this->load->model('almacen/almacen_model');
        $this->load->model('almacen/guiain_model');
        $this->load->model('almacen/guiasa_model');
        $this->load->model('almacen/unidadmedida_model');
        $this->load->model('maestros/compania_model');
        $this->load->model('compras/proveedor_model');
        $this->load->model('ventas/cliente_model');
        $this->load->model('seguridad/usuario_model');
        $this->load->helper('form', 'url');
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->somevar['rol'] = $this->session->userdata('rol');
        $this->somevar['user'] = $this->session->userdata('user');
        $this->somevar['compania'] = $this->session->userdata('compania');
        $this->somevar['empresa'] = $this->session->userdata('empresa');
        $this->somevar['establec'] = $this->session->userdata('establec');
    }

    public function listar()
    {
        unset($_SESSION['serieReal']);
        unset($_SESSION['serieRealBD']);
        $this->load->library('layout', 'layout');
        $data['compania'] = $this->somevar['compania'];
        $data['titulo_tabla'] = "KARDEX DE PRODUCTOS";
        $data['form_open'] = form_open($url, array("name" => "frmkardex", "id" => "frmkardex"));
        $data['cboAlmacen'] = form_dropdown("almacen", $this->almacen_model->seleccionar($this->somevar['compania']), $almacen_id, " class='form-control w-porc-90' id='almacen'"); // EN 
        $atributos = array('width' => 700, 'height' => 450, 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $data['form_close'] = form_close();
        $this->layout->view('almacen/kardex_index', $data);
    }

    function obtener_nombre_numdoc($tipo, $codigo)
    {

        $nombre = '';
        $numdoc = '';
        if ($tipo == 'CLIENTE') {
            $datos_cliente = $this->cliente_model->obtener($codigo);
            if ($datos_cliente) {
                $nombre = $datos_cliente->nombre;
                $numdoc = $datos_cliente->ruc;
            }
        } else {
            $datos_proveedor = $this->proveedor_model->obtener($codigo);
            if ($datos_proveedor) {
                $nombre = $datos_proveedor->nombre;
                $numdoc = $datos_proveedor->ruc;
            }
        }
        return array('numdoc' => $numdoc, 'nombre' => $nombre);
    }

    function VerificarMovimiento($codKardex)
    {
        $filter = new stdClass();
        $filter->KARDC_FlagValida = '1';
        $filter->USUA_Codigo = $_SESSION['user'];
        $update = $this->kardex_model->verificarMovimiento($codKardex, $filter);

        if ($update == true) {
            $usuario = $this->usuario_model->obtener2($_SESSION['user']);
            $detaUsuario = $usuario[0]->PERSC_Nombre . " " . $usuario[0]->PERSC_ApellidoPaterno . " " . $usuario[0]->PERSC_ApellidoMaterno;
            echo  $detaUsuario;
        } else {
            echo 'error';
        }
    }

    public function reportKardex($startDate, $endDate, $productId, $storeId)
    {

        $this->load->library('Excel');
        $hoja = 0;

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
                'size' => 14
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
                'color' => array('rgb' => '69c9966e')
            ),
            'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'          => TRUE
            )
        );


        $estiloColumnasTituloCabezera = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => true,
                'color'     => array(
                    'rgb' => '000000'
                ),
                'size' => 12
            ),
            'fill'  => array(
                'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFC9B')
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
            'fill'  => array(
                'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('argb' => 'FFFFFFFF')
            ),
            'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'          => TRUE
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => "000000")
                )
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
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => "000000")
                )
            )
        );
        $estiloBold = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => true,
                'color'     => array(
                    'rgb' => '000000'
                ),
                'size' => 11
            )
        );
        $estiloCenter = array(
            'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'          => TRUE
            )
        );
        $estiloRight = array(
            'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'          => TRUE
            )
        );

        # ROJO PARA ANULADOS
        $colorCelda = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => false,
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'fill'  => array(
                'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('argb' => "F28A8C")
            )
        );

        $this->excel->setActiveSheetIndex($hoja);

        $lugar = 1;

        $dataProduct = $this->producto_model->getProducto($productId);
        $this->excel->getActiveSheet()->getStyle("A$lugar:D$lugar")->applyFromArray($estiloColumnasTituloCabezera);
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A1",  "CODIGO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B1", $dataProduct[0]->PROD_CodigoUsuario);
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("C1",  "PRODUCTO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("D1", $dataProduct[0]->PROD_Nombre);

        $lugar += 2;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "FECHA MOVIMIENTO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  "HORA");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  "DOCUMENTO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  "CLIENTE");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  "TIPO MOVIMIENTO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar",  "CANTIDAD");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("G$lugar",  "STOCK DISP.");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("H$lugar",  "P. UNITARIO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("I$lugar",  "TOTAL");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("J$lugar",  "ALMACEN DE ORIGEN");

        $this->excel->getActiveSheet()->getStyle("A$lugar:J$lugar")->applyFromArray($estiloColumnasTitulo);

        $this->excel->getActiveSheet()->getColumnDimension("A")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("B")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("C")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("D")->setWidth("45");
        $this->excel->getActiveSheet()->getColumnDimension("E")->setWidth("30");
        $this->excel->getActiveSheet()->getColumnDimension("F")->setWidth("10");
        $this->excel->getActiveSheet()->getColumnDimension("G")->setWidth("10");
        $this->excel->getActiveSheet()->getColumnDimension("H")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("I")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("J")->setWidth("20");

        $lugar++;

        $filter = new stdClass();
        $filter->producto     = $productId;
        $filter->fechai       = $startDate;
        $filter->fechaf       = $endDate;
        $filter->almacen      = $storeId;

        $dataKardex = $this->kardex_model->consultar_kardex($filter);

        $cantidad_salida  = 0;
        $cantidad_entrada = 0;
        $balance          = 0;

        foreach ($dataKardex as $value) {

            $denominacion   = $value->razon_social_cliente != NULL ? $value->razon_social_cliente : $value->razon_social_proveedor;

            if ($value->tipo_docu == "F" || $value->tipo_docu == "B" || $value->tipo_docu == "N") {
                if ($value->tipo_mov == 1) {
                    // if ($estado==1) {
                    //   $tipo_mov_d     = $fontaout.$descr_mov;
                    // }else{
                    //   $tipo_mov_d     = $anulado.$descr_mov;
                    // }
                    $cantidad_salida  += $value->cantidad;
                } else {
                    // if ($estado==1) {
                    //   $tipo_mov_d     = $fontin.$descr_mov;
                    // }else{
                    //   $tipo_mov_d     = $anulado.$descr_mov;
                    // }
                    $cantidad_entrada += $value->cantidad;
                }
            } else if ($value->tipo_docu == "T") {
                if ($value->tipo_mov == 1) {
                    $denominacion   = "TRASLADO DE ALMACEN";
                    // $tipo_mov_d     = $fontaout.$descr_mov;
                    $cantidad_salida  += $value->cantidad;
                } else {
                    $denominacion   = "TRASLADO DE ALMACEN";
                    // $tipo_mov_d     = $fontin.$descr_mov;
                    $cantidad_entrada += $value->cantidad;
                }
            } else if ($value->tipo_docu == "A") {
                if ($value->tipo_mov == 1) {
                    $cantidad_salida  = 0;
                    $cantidad_entrada = 0;
                    $balance          = 0;
                    $denominacion     = "REEMPLAZO POR AJUSTE";
                    // $tipo_mov_d       = $fontin.$descr_mov;
                    $cantidad_entrada  += $value->cantidad;
                } else {
                    $denominacion     = "SUMA POR AJUSTE";
                    // $tipo_mov_d       = $fontin.$descr_mov;
                    $cantidad_entrada += $value->cantidad;
                }
            } else if ($value->tipo_docu == "NC") {
                if ($value->tipo_mov == 1) {
                    // if ($estado==1) {
                    //   $tipo_mov_d     = $fontaout.$descr_mov;
                    // }else{
                    //   $tipo_mov_d     = $anulado.$descr_mov;
                    // }
                    $cantidad_salida  += $value->cantidad;
                } else {
                    // if ($estado==1) {
                    //   $tipo_mov_d     = $fontin.$descr_mov;
                    // }else{
                    //   $tipo_mov_d     = $anulado.$descr_mov;
                    // }
                    $cantidad_entrada += $value->cantidad;
                }
            } else if ($value->tipo_docu == "I") {
                if ($value->tipo_mov == 1) {
                    $cantidad_salida  = 0;
                    $cantidad_entrada = 0;
                    $balance          = 0;
                    $denominacion     = "INGRESO DE INVENTARIO";
                    // $tipo_mov_d       = $fontin.$descr_mov;
                    $cantidad_entrada  += $value->cantidad;
                } else {
                    $cantidad_salida  = 0;
                    $cantidad_entrada = 0;
                    $balance          = 0;
                    $denominacion     = "INGRESO DE INVENTARIO";
                    // $tipo_mov_d       = $fontin.$descr_mov;
                    $cantidad_entrada += $value->cantidad;
                }
            }

            $balance = $cantidad_entrada - $cantidad_salida;

            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", explode(" ", $value->fecha)[0]);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar", explode(" ", $value->fecha)[1]);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar", $value->serie . "-" . $value->numero);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar", $denominacion);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar", $value->tipo_des);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar", $value->cantidad);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("G$lugar", $balance);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("H$lugar", $value->moneda . " " . $value->pu_conIgv);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("I$lugar", $value->moneda . " " . $value->total);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("J$lugar", $value->nombre_almacen);

            $lugar++;
        }

        $filename = "REPORTE_KARDEX_" . date("YmdHis") . ".xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function reportKardexDeSunat($mesKSunat, $productId, $storeId)
    {
        // var_dump("entro aqui"); exit;
        $this->load->library('Excel');
        $hoja = 0;

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
                'size' => 14
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
                'color' => array('rgb' => '69c9966e')
            ),
            'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'          => TRUE
            )
        );


        $estiloColumnasTituloCabezera = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => true,
                'color'     => array(
                    'rgb' => '000000'
                ),
                'size' => 12
            ),
            'fill'  => array(
                'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFC9B')
            ),
            'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'          => TRUE
            )
        );

        $estiloColumnasTituloCabezeraKardexSunat = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => true,
                'color'     => array(
                    'rgb' => '000000'
                ),
                'size' => 12
            ),
            'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'          => TRUE
            ),
            // 'borders' => array(
            //     'allborders' => array(
            //         'style' => PHPExcel_Style_Border::BORDER_THIN,
            //         'color' => array('rgb' => "000000")
            //     )
            // ),
        );

        $estiloColumnasPar = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => false,
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'fill'  => array(
                'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('argb' => 'FFFFFFFF')
            ),
            'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'          => TRUE
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => "000000")
                )
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
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => "000000")
                )
            )
        );
        $estiloBold = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => true,
                'color'     => array(
                    'rgb' => '000000'
                ),
                'size' => 11
            )
        );
        $estiloCenter = array(
            'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'          => TRUE
            )
        );
        $estiloRight = array(
            'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'          => TRUE
            )
        );

        # ROJO PARA ANULADOS
        $colorCelda = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => false,
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'fill'  => array(
                'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('argb' => "F28A8C")
            )
        );

        $this->excel->setActiveSheetIndex($hoja);

        $lugar = 1;

        $datos_empresa = $this->empresa_model->obtener_datosEmpresa($this->somevar['empresa'])[0];

        $dataProduct = $this->producto_model->getProductoConUM($productId)[0];

        switch ($dataProduct->UNDMED_Codigo) {
            case "3":
                $unidadMedida = "1";
                break;
            case "18":
                $unidadMedida = "2";
                break;
            case "19":
                $unidadMedida = "6";
                break;
            case "1":
                $unidadMedida = "7";
                break;
            case "13":
                $unidadMedida = "8";
                break;
            case "28":
                $unidadMedida = "9";
                break;
            case "23":
                $unidadMedida = "11";
                break;
            case "7":
                $unidadMedida = "12";
                break;
            case "24":
                $unidadMedida = "13";
                break;
            case "9":
                $unidadMedida = "14";
                break;
            case "11":
                $unidadMedida = "15";
                break;
            default:
                // UNIDADES DE MEDIDA QUE NO MANEJA EL SISTEMA AUN
                $unidadMedida = "99";
                break;
        }

        // $this->excel->getActiveSheet()->getStyle("A$lugar:D$lugar")->applyFromArray($estiloColumnasTituloCabezera);
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A1",  'FORMATO 13.1: "REGISTRO DE INVENTARIO PERMANENTE VALORIZADO - DETALLE DEL INVENTARIO VALORIZADO"');

        $lugar += 2;

        $meses = [
            "01" => 'Enero',
            "02" => 'Febrero',
            "03" => 'Marzo',
            "04" => 'Abril',
            "05" => 'Mayo',
            "06" => 'Junio',
            "07" => 'Julio',
            "08" => 'Agosto',
            "09" => 'Septiembre',
            "10" => 'Octubre',
            "11" => 'Noviembre',
            "12" => 'Diciembre'
        ];

        $nombreMes = $meses[$mesKSunat];

        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", "Periodo: ")->mergeCells("A$lugar:D$lugar");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar", $nombreMes);
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", "RUC: ")->mergeCells("A$lugar:D$lugar");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar", "$datos_empresa->EMPRC_Ruc");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", "APELLIDOS Y NOMBRES, DENOMINACIÓN O RAZÓN SOCIAL: ")->mergeCells("A$lugar:D$lugar");
        // var_dump($dataProduct);
        // exit;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar", "$datos_empresa->EMPRC_RazonSocial");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", "ESTABLECIMIENTO (1): ")->mergeCells("A$lugar:D$lugar");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar", "$datos_empresa->EMPRC_Direccion");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", "CÓDIGO DE LA EXISTENCIA: ")->mergeCells("A$lugar:D$lugar");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar", "$dataProduct->PROD_CodigoInterno");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", "TIPO (TABLA 5): ")->mergeCells("A$lugar:D$lugar");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar", "1");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", "DESCRIPCIÓN: ")->mergeCells("A$lugar:D$lugar");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar", "$dataProduct->PROD_Nombre");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", "CÓDIGO DE LA UNIDAD DE MEDIDA (TABLA 6): ")->mergeCells("A$lugar:D$lugar");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar", "$unidadMedida");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", "MÉTODO DE VALUACIÓN: ")->mergeCells("A$lugar:D$lugar");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar", "Promedio");

        $lugar += 2;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", "DOCUMENTO DE TRASLADO, COMPROBANTE DE PAGO,")->mergeCells("A$lugar:D$lugar");
        $this->excel->getActiveSheet()->getStyle("A$lugar:D$lugar")->applyFromArray(array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar", "TIPO DE");
        $this->excel->getActiveSheet()->getStyle("E$lugar")->applyFromArray(array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar", "ENTRADAS")->mergeCells("F$lugar:H$lugar");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("I$lugar", "SALIDAS")->mergeCells("I$lugar:K$lugar");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("L$lugar", "SALDO FINAL")->mergeCells("L$lugar:N$lugar");
        $this->excel->getActiveSheet()->getStyle("F$lugar:N$lugar")->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));

        // ESTILOS GENERALES
        $this->excel->getActiveSheet()->getStyle("A$lugar:N$lugar")->applyFromArray($estiloColumnasTituloCabezeraKardexSunat);

        //CENTRAR LOS CAMPOS
        $this->excel->getActiveSheet()->getStyle("A$lugar:N$lugar")->applyFromArray($estiloCenter);

        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", "DOCUMENTO INTERNO O SIMILAR")->mergeCells("A$lugar:D$lugar");
        $this->excel->getActiveSheet()->getStyle("A$lugar:D$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar", "OPERACIÓN");
        $this->excel->getActiveSheet()->getStyle("E$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar", "CANTIDAD");
        $this->excel->getActiveSheet()->getStyle("F$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("G$lugar", "COSTO UNITARIO");
        $this->excel->getActiveSheet()->getStyle("G$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("H$lugar", "COSTO TOTAL");
        $this->excel->getActiveSheet()->getStyle("H$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("I$lugar", "CANTIDAD");
        $this->excel->getActiveSheet()->getStyle("I$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("J$lugar", "COSTO UNITARIO");
        $this->excel->getActiveSheet()->getStyle("J$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("K$lugar", "COSTO TOTAL");
        $this->excel->getActiveSheet()->getStyle("K$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("L$lugar", "CANTIDAD");
        $this->excel->getActiveSheet()->getStyle("L$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("M$lugar", "COSTO UNITARIO");
        $this->excel->getActiveSheet()->getStyle("M$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("N$lugar", "COSTO TOTAL");
        $this->excel->getActiveSheet()->getStyle("N$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));


        // ESTILOS GENERALES
        $this->excel->getActiveSheet()->getStyle("A$lugar:N$lugar")->applyFromArray($estiloColumnasTituloCabezeraKardexSunat);

        //CENTRAR LOS CAMPOS
        $this->excel->getActiveSheet()->getStyle("A$lugar:N$lugar")->applyFromArray($estiloCenter);


        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", "FECHA");
        $this->excel->getActiveSheet()->getStyle("A$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar", "TIPO (TABLA 10)");
        $this->excel->getActiveSheet()->getStyle("B$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar", "SERIE");
        $this->excel->getActiveSheet()->getStyle("C$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar", "NÚMERO");
        $this->excel->getActiveSheet()->getStyle("D$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar", "(TABLA 12)");
        $this->excel->getActiveSheet()->getStyle("E$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar", "");
        $this->excel->getActiveSheet()->getStyle("F$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("G$lugar", "");
        $this->excel->getActiveSheet()->getStyle("G$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("H$lugar", "");
        $this->excel->getActiveSheet()->getStyle("H$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("I$lugar", "");
        $this->excel->getActiveSheet()->getStyle("I$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("J$lugar", "");
        $this->excel->getActiveSheet()->getStyle("J$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("K$lugar", "");
        $this->excel->getActiveSheet()->getStyle("K$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("L$lugar", "");
        $this->excel->getActiveSheet()->getStyle("L$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("M$lugar", "");
        $this->excel->getActiveSheet()->getStyle("M$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("N$lugar", "");
        $this->excel->getActiveSheet()->getStyle("N$lugar")->applyFromArray(array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));

        // ESTILOS GENERALES
        $this->excel->getActiveSheet()->getStyle("A$lugar:N$lugar")->applyFromArray($estiloColumnasTituloCabezeraKardexSunat);

        //CENTRAR LOS CAMPOS
        $this->excel->getActiveSheet()->getStyle("A$lugar:N$lugar")->applyFromArray($estiloCenter);

        //QUE TODOS LOS CAMPOS TENGAN EL ANCHO DEL TEXTO Y SEA ADAPTABLE EN TODO EL EXCEL
        $this->excel->getActiveSheet()->getColumnDimension("A")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("B")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("C")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("D")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("E")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("F")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("G")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("H")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("I")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("J")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("K")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("L")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("M")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("N")->setWidth("15");

        $lugar++;

        $filter = new stdClass();
        $filter->producto     = $productId;
        $filter->mesKSunat    = $mesKSunat;
        $filter->almacen      = $storeId;

        // ? OBTENER EL SALDO INICIAL DEL KARDEX_PARA_SUNAT
        $dataKardexUltimoStock = $this->kardex_model->consultar_kardexSunatFinalMes($filter);
        $cantidad_salidaSaldoIni  = 0;
        $cantidad_entradaSaldoIni = 0;
        $balanceSaldoIni          = 0;

        foreach ($dataKardexUltimoStock as $value) {

            $denominacion   = $value->razon_social_cliente != NULL ? $value->razon_social_cliente : $value->razon_social_proveedor;

            if ($value->tipo_docu == "F" || $value->tipo_docu == "B" || $value->tipo_docu == "N") {
                if ($value->tipo_mov == 1) {
                    $cantidad_salidaSaldoIni  += $value->cantidad;
                } else {
                    $cantidad_entradaSaldoIni += $value->cantidad;
                }
            } else if ($value->tipo_docu == "T") {
                if ($value->tipo_mov == 1) {
                    $denominacion   = "TRASLADO DE ALMACEN";
                    $cantidad_salidaSaldoIni  += $value->cantidad;
                } else {
                    $denominacion   = "TRASLADO DE ALMACEN";
                    $cantidad_entradaSaldoIni += $value->cantidad;
                }
            } else if ($value->tipo_docu == "A") {
                if ($value->tipo_mov == 1) {
                    $cantidad_salidaSaldoIni  = 0;
                    $cantidad_entradaSaldoIni = 0;
                    $balanceSaldoIni          = 0;
                    $denominacion     = "REEMPLAZO POR AJUSTE";
                    $cantidad_entradaSaldoIni  += $value->cantidad;
                } else {
                    $denominacion     = "SUMA POR AJUSTE";
                    $cantidad_entradaSaldoIni += $value->cantidad;
                }
            } else if ($value->tipo_docu == "NC") {
                if ($value->tipo_mov == 1) {
                    $cantidad_salidaSaldoIni  += $value->cantidad;
                } else {
                    $cantidad_entradaSaldoIni += $value->cantidad;
                }
            } else if ($value->tipo_docu == "I") {
                if ($value->tipo_mov == 1) {
                    $cantidad_salidaSaldoIni  = 0;
                    $cantidad_entradaSaldoIni = 0;
                    $balanceSaldoIni          = 0;
                    $denominacion     = "INGRESO DE INVENTARIO";
                    $cantidad_entradaSaldoIni  += $value->cantidad;
                } else {
                    $cantidad_salidaSaldoIni  = 0;
                    $cantidad_entradaSaldoIni = 0;
                    $balanceSaldoIni          = 0;
                    $denominacion     = "INGRESO DE INVENTARIO";
                    $cantidad_entradaSaldoIni += $value->cantidad;
                }
            }

            $balanceSaldoIni = $cantidad_entradaSaldoIni - $cantidad_salidaSaldoIni;
            $costoSinIgv = $value->pu_sinIgv;
            $costoTotalSinIgvIni = $costoSinIgv * $balanceSaldoIni;
        }

        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", "01-$mesKSunat-2024");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar", 16);
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("L$lugar", $balanceSaldoIni);
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("M$lugar", $costoSinIgv);
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("N$lugar", $costoTotalSinIgvIni);

        $this->excel->getActiveSheet()->getStyle("A$lugar:N$lugar")->applyFromArray($estiloCenter);
        $this->excel->getActiveSheet()->getStyle("A$lugar:N$lugar")->applyFromArray($estiloColumnasPar);
        // ? FIN OBTENER EL SALDO INICIAL DEL KARDEX_PARA_SUNAT

        $lugar++;

        $dataKardex = $this->kardex_model->consultar_kardexSunat($filter);

        $cantidad_salida  = 0;
        $cantidad_entrada = 0;
        $balance          = 0;
        $balanceCostoTotal = 0;

        // var_dump($dataKardex); exit;
        // ? INGRESO
        $cantIngreso = 0;
        $precioUIngreso = 0;
        $precioTIIngreso = 0;

        // ? SALIDA
        $cantSalida = 0;
        $precioUSalida = 0;
        $precioTISalida = 0;

        // ? SALDO FINAL
        $cantSaldoFinal = $balanceSaldoIni;
        $precioUSaldoFinal = 0;
        $precioTISaldoFinal = 0;

        $tipoOperTabla12 = 99;

        foreach ($dataKardex as $key => $value) {

            $denominacion   = $value->razon_social_cliente != NULL ? $value->razon_social_cliente : $value->razon_social_proveedor;

            if ($value->tipo_docu == "F" || $value->tipo_docu == "B" || $value->tipo_docu == "N") {
                if ($value->tipo_mov == 1) {
                    // if ($estado==1) {
                    //   $tipo_mov_d     = $fontaout.$descr_mov;
                    // }else{
                    //   $tipo_mov_d     = $anulado.$descr_mov;
                    // }
                    $cantidad_salida  += $value->cantidad;
                    $tipoOperTabla12 = 1;
                } else {
                    // if ($estado==1) {
                    //   $tipo_mov_d     = $fontin.$descr_mov;
                    // }else{
                    //   $tipo_mov_d     = $anulado.$descr_mov;
                    // }
                    $cantidad_entrada += $value->cantidad;
                    $tipoOperTabla12 = 2;
                }
                switch ($value->tipo_docu) {
                    case 'F':
                        $tipoDocuSunat = "01";
                        break;

                    case 'B':
                        $tipoDocuSunat = "03";
                        break;

                    case 'N':
                        $tipoDocuSunat = "07";
                        break;
                    default:
                        $tipoDocuSunat = "00";
                        break;
                };
            } else if ($value->tipo_docu == "T") {
                if ($value->tipo_mov == 1) {
                    $denominacion   = "TRASLADO DE ALMACEN";
                    // $tipo_mov_d     = $fontaout.$descr_mov;
                    $cantidad_salida  += $value->cantidad;
                } else {
                    $denominacion   = "TRASLADO DE ALMACEN";
                    // $tipo_mov_d     = $fontin.$descr_mov;
                    $cantidad_entrada += $value->cantidad;
                }
            } else if ($value->tipo_docu == "A") {
                if ($value->tipo_mov == 1) {
                    $cantidad_salida  = 0;
                    $cantidad_entrada = 0;
                    $balance          = 0;
                    $denominacion     = "REEMPLAZO POR AJUSTE";
                    // $tipo_mov_d       = $fontin.$descr_mov;
                    $cantidad_entrada  += $value->cantidad;
                } else {
                    $denominacion     = "SUMA POR AJUSTE";
                    // $tipo_mov_d       = $fontin.$descr_mov;
                    $cantidad_entrada += $value->cantidad;
                }
            } else if ($value->tipo_docu == "NC") {
                if ($value->tipo_mov == 1) {
                    // if ($estado==1) {
                    //   $tipo_mov_d     = $fontaout.$descr_mov;
                    // }else{
                    //   $tipo_mov_d     = $anulado.$descr_mov;
                    // }
                    $cantidad_salida  += $value->cantidad;
                    $tipoOperTabla12 = 6;
                } else {
                    // if ($estado==1) {
                    //   $tipo_mov_d     = $fontin.$descr_mov;
                    // }else{
                    //   $tipo_mov_d     = $anulado.$descr_mov;
                    // }
                    $cantidad_entrada += $value->cantidad;
                    $tipoOperTabla12 = 5;
                }
            } else if ($value->tipo_docu == "I") {
                if ($value->tipo_mov == 1) {
                    $value->tipo_mov = 2;
                    $cantidad_salida  = 0;
                    $cantidad_entrada = 0;
                    $balance          = 0;
                    $denominacion     = "INGRESO DE INVENTARIO";
                    // $tipo_mov_d       = $fontin.$descr_mov;
                    $cantidad_entrada  += $value->cantidad;
                } else {
                    $value->tipo_mov = 2;
                    $cantidad_salida  = 0;
                    $cantidad_entrada = 0;
                    $balance          = 0;
                    $denominacion     = "INGRESO DE INVENTARIO";
                    // $tipo_mov_d       = $fontin.$descr_mov;
                    $cantidad_entrada += $value->cantidad;
                }
            }

            $balance = $cantidad_entrada - $cantidad_salida;
            if ($value->tipo_mov == 2) {
                $balanceCostoTotal = $balanceCostoTotal + ($value->cantidad * $value->pu_sinIgv);
                $cantIngreso += $value->cantidad;
                $precioUIngreso += $value->pu_sinIgv;
                $precioTIIngreso += $value->subtotal;
                $cantSaldoFinal += $value->cantidad;
                $costoTotalSinIgvIni += $value->subtotal;
            } else if ($value->tipo_mov == 1) {
                $balanceCostoTotal = $balanceCostoTotal - ($value->cantidad * $value->pu_sinIgv);
                $cantSalida += $value->cantidad;
                $precioUSalida += $value->pu_sinIgv;
                $precioTISalida += $value->subtotal;
                $cantSaldoFinal -= $value->cantidad;
                $costoTotalSinIgvIni -= $value->subtotal;
            }
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", explode(" ", $value->fecha)[0]);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar", $tipoDocuSunat);
            // $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar", explode(" ", $value->fecha)[1]);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar", preg_replace('/\D/', '', $value->serie));
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar", $value->numero);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar", $tipoOperTabla12);
            if ($value->tipo_mov == 2) {
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar", $value->cantidad);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("G$lugar", $value->pu_sinIgv);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("H$lugar", $value->subtotal);
            } else if ($value->tipo_mov == 1) {
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("I$lugar", $value->cantidad);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("J$lugar", $value->pu_sinIgv);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("k$lugar", $value->subtotal);
            }

            // TODO: OBTENER EL BALANCE

            $this->excel->setActiveSheetIndex($hoja)->setCellValue("L$lugar", $cantSaldoFinal);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("M$lugar", $value->pu_sinIgv);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("N$lugar", $costoTotalSinIgvIni);

            $this->excel->getActiveSheet()->getStyle("A$lugar:N$lugar")->applyFromArray($estiloCenter);
            $this->excel->getActiveSheet()->getStyle("A$lugar:N$lugar")->applyFromArray($estiloColumnasPar);

            $precioUSaldoFinal = $value->pu_sinIgv;

            $lugar++;
        }

        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar", "TOTALES");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar", $cantIngreso);
        // $this->excel->setActiveSheetIndex($hoja)->setCellValue("G$lugar", $precioUIngreso);
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("H$lugar", $precioTIIngreso);
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("I$lugar", $cantSalida);
        // $this->excel->setActiveSheetIndex($hoja)->setCellValue("J$lugar", $precioUSalida);
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("K$lugar", $precioTISalida);
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("L$lugar", $cantSaldoFinal);
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("M$lugar", $precioUSaldoFinal);
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("N$lugar", $costoTotalSinIgvIni);

        $this->excel->getActiveSheet()->getStyle("E$lugar:N$lugar")->applyFromArray($estiloCenter);
        $this->excel->getActiveSheet()->getStyle("E$lugar:N$lugar")->applyFromArray($estiloColumnasPar);

        $filename = "REPORTE_KARDEX_" . date("YmdHis") . ".xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
    }
    public function datatable_kardex($value = '')
    {

        $filter = new stdClass();
        $filter->producto     = $this->input->post('producto');
        $filter->almacen      = $this->input->post('almacen');
        $filter->descripcion  = $this->input->post('search_descripcion');
        $filter->fechai       = $this->input->post('fechai');
        $filter->fechaf       = $this->input->post('fechaf');
        $filter->ult_inventario = $this->input->post('ult_inventario');

        $cantidad_salida  = 0;
        $cantidad_entrada = 0;
        $balance          = 0;

        $kardex = $this->kardex_model->consultar_kardex($filter);

        if ($kardex) {
            foreach ($kardex as $key => $value) {
                $fontin       = "<font color='blue'>";
                $anulado      = "<font color='red'>";
                $fontaout     = "<font color='green'>";
                $fontend      = "</fon>";

                //DOCUMENTO INFO
                //$compania     = $value->COMPP_Codigo;
                $fecha        = $value->fecha;
                $almacen      = $value->almacen;
                $tipo_docu    = $value->tipo_docu;
                $codigoDoc    = $value->codigo_docu;
                $numDoc       = $value->serie . "-" . $value->numero;

                //DETALLE INFO
                $productoCod  = $value->codigo;
                //$nombreProd   = $value->PROD_Descripcion;
                $cantidad     = $value->cantidad;
                //$afectacion   = $value->KARDC_ProdAfectacion;
                //$pu           = $value->KARDC_Costo;
                $precioConIgv = $value->moneda . " " . $value->pu_conIgv;
                $subtotal     = $value->moneda . " " . $value->subtotal;
                $total        = $value->moneda . " " . $value->total;

                //MOVIMIENTO INFO
                $tipo_mov     = $value->tipo_mov;
                $descr_mov    = $value->tipo_des;
                $estado       = $value->estado;

                $num_doc        = $numDoc;
                $cantidad_final = $cantidad;
                $precio_conigv  = $precioConIgv;
                $nom_almacen    = $value->nombre_almacen;
                $denominacion   = $value->razon_social_cliente != NULL ? $value->razon_social_cliente : $value->razon_social_proveedor;

                if ($tipo_docu == "F" || $tipo_docu == "B" || $tipo_docu == "N") {
                    if ($tipo_mov == 1) {
                        if ($estado == 1) {
                            $tipo_mov_d     = $fontaout . $descr_mov;
                        } else {
                            $tipo_mov_d     = $anulado . $descr_mov;
                        }
                        $cantidad_salida  += $cantidad;
                    } else {
                        if ($estado == 1) {
                            $tipo_mov_d     = $fontin . $descr_mov;
                        } else {
                            $tipo_mov_d     = $anulado . $descr_mov;
                        }
                        $cantidad_entrada += $cantidad;
                    }
                } else if ($tipo_docu == "T") {
                    if ($tipo_mov == 1) {
                        $denominacion   = "TRASLADO DE ALMACEN";
                        $tipo_mov_d     = $fontaout . $descr_mov;
                        $cantidad_salida  += $cantidad;
                    } else {
                        $denominacion   = "TRASLADO DE ALMACEN";
                        $tipo_mov_d     = $fontin . $descr_mov;
                        $cantidad_entrada += $cantidad;
                    }
                } else if ($tipo_docu == "A") {
                    if ($tipo_mov == 1) {
                        $cantidad_salida  = 0;
                        $cantidad_entrada = 0;
                        $balance          = 0;
                        $denominacion     = "REEMPLAZO POR AJUSTE";
                        $tipo_mov_d       = $fontin . $descr_mov;
                        $cantidad_entrada  += $cantidad;
                    } else {
                        $denominacion     = "SUMA POR AJUSTE";
                        $tipo_mov_d       = $fontin . $descr_mov;
                        $cantidad_entrada += $cantidad;
                    }
                } else if ($tipo_docu == "NC") {
                    if ($tipo_mov == 1) {
                        if ($estado == 1) {
                            $tipo_mov_d     = $fontaout . $descr_mov;
                        } else {
                            $tipo_mov_d     = $anulado . $descr_mov;
                        }
                        $cantidad_salida  += $cantidad;
                    } else {
                        if ($estado == 1) {
                            $tipo_mov_d     = $fontin . $descr_mov;
                        } else {
                            $tipo_mov_d     = $anulado . $descr_mov;
                        }
                        $cantidad_entrada += $cantidad;
                    }
                } else if ($tipo_docu == "I") {
                    if ($tipo_mov == 1) {
                        $cantidad_salida  = 0;
                        $cantidad_entrada = 0;
                        $balance          = 0;
                        $denominacion     = "INGRESO DE INVENTARIO";
                        $tipo_mov_d       = $fontin . $descr_mov;
                        $cantidad_entrada  += $cantidad;
                    } else {
                        $cantidad_salida  = 0;
                        $cantidad_entrada = 0;
                        $balance          = 0;
                        $denominacion     = "INGRESO DE INVENTARIO";
                        $tipo_mov_d       = $fontin . $descr_mov;
                        $cantidad_entrada += $cantidad;
                    }
                }
                $rol= $this->somevar['rol'] = $this->session->userdata('rol');

                if($rol != 1){
                    $precio_conigv = "SIN PERMISOS PARA ACCEDER A ESTA INFORMACION";
                     $total = "SIN PERMISOS PARA ACCEDER A ESTA INFORMACION";
                }


                $balance = $cantidad_entrada - $cantidad_salida;

                $pos = 0;
                $lista[] = array(
                    $pos++ => $fecha,
                    $pos++ => $num_doc,
                    $pos++ => $denominacion,
                    $pos++ => $tipo_mov_d,
                    $pos++ => $cantidad_final,
                    $pos++ => $balance,
                    $pos++ => $precio_conigv,
                    $pos++ => $total,
                    $pos++ => $nom_almacen
                );
            }
        } else {
            $lista = array();
        }


        $json = array(
            "entrada"  => $cantidad_entrada,
            "salida"   => $cantidad_salida,
            "data"     => array_reverse($lista)
        );

        echo json_encode($json);
    }

    public function balancear_stock($value = '')
    {
        $filter = new stdClass();
        $filter->producto = $this->input->post('producto');
        $filter->almacen = $this->input->post('almacen');
        $filter->descripcion = $this->input->post('search_descripcion');
        $filter->fechai = $this->input->post('fechai');
        $filter->fechaf = $this->input->post('fechaf');

        $cantidad_salida  = 0;
        $cantidad_entrada = 0;

        $kardex = $this->kardex_model->consultar_kardex($filter);
        if ($kardex) {
            foreach ($kardex as $key => $value) {
                $fontin       = "<font color='blue'>";
                $anulado      = "<font color='red'>";
                $fontaout     = "<font color='green'>";
                $fontend      = "</fon>";

                //DOCUMENTO INFO
                //$compania     = $value->COMPP_Codigo;
                $fecha        = $value->fecha;
                $almacen      = $value->almacen;
                $tipo_docu    = $value->tipo_docu; # T: transferencia 
                $codigoDoc    = $value->codigo_docu;
                $numDoc       = $value->serie . "-" . $value->numero;

                //DETALLE INFO
                $productoCod  = $value->codigo;
                //$nombreProd   = $value->PROD_Descripcion;
                $cantidad     = $value->cantidad;
                //$afectacion   = $value->KARDC_ProdAfectacion;
                //$pu           = $value->KARDC_Costo;
                $precioConIgv = $value->moneda . " " . $value->pu_conIgv;
                $subtotal     = $value->moneda . " " . $value->subtotal;
                $total        = $value->moneda . " " . $value->total;

                //MOVIMIENTO INFO
                $tipo_mov     = $value->tipo_mov;
                $descr_mov    = $value->tipo_des;
                $estado       = $value->estado;

                $num_doc        = $numDoc;
                $cantidad_final = $cantidad;
                $precio_conigv  = $precioConIgv;
                $nom_almacen    = $value->nombre_almacen;
                $denominacion   = $value->razon_social_cliente != NULL ? $value->razon_social_cliente : $value->razon_social_proveedor;

                if ($tipo_docu == "F" || $tipo_docu == "B" || $tipo_docu == "N") {
                    if ($tipo_mov == 1) {
                        if ($estado == 1) {
                            $tipo_mov_d     = $fontaout . $descr_mov;
                        } else {
                            $tipo_mov_d     = $anulado . $descr_mov;
                        }
                        $cantidad_salida  += $cantidad;
                    } else {
                        if ($estado == 1) {
                            $tipo_mov_d     = $fontin . $descr_mov;
                        } else {
                            $tipo_mov_d     = $anulado . $descr_mov;
                        }
                        $cantidad_entrada += $cantidad;
                    }
                } else if ($tipo_docu == "T") {
                    if ($tipo_mov == 1) {
                        $denominacion   = "TRASLADO DE ALMACEN";
                        $tipo_mov_d     = $fontaout . $descr_mov;
                        $cantidad_salida  += $cantidad;
                    } else {
                        $denominacion   = "TRASLADO DE ALMACEN";
                        $tipo_mov_d     = $fontin . $descr_mov;
                        $cantidad_entrada += $cantidad;
                    }
                } else if ($tipo_docu == "A") {
                    if ($tipo_mov == 1) {
                        $cantidad_salida  = 0;
                        $cantidad_entrada = 0;
                        $balance          = 0;
                        $denominacion     = "REEMPLAZO POR AJUSTE";
                        $tipo_mov_d       = $fontin . $descr_mov;
                        $cantidad_entrada  += $cantidad;
                    } else {
                        $denominacion     = "SUMA POR AJUSTE";
                        $tipo_mov_d       = $fontin . $descr_mov;
                        $cantidad_entrada += $cantidad;
                    }
                } else if ($tipo_docu == "NC") {
                    if ($tipo_mov == 1) {
                        if ($estado == 1) {
                            $tipo_mov_d     = $fontaout . $descr_mov;
                        } else {
                            $tipo_mov_d     = $anulado . $descr_mov;
                        }
                        $cantidad_salida  += $cantidad;
                    } else {
                        if ($estado == 1) {
                            $tipo_mov_d     = $fontin . $descr_mov;
                        } else {
                            $tipo_mov_d     = $anulado . $descr_mov;
                        }
                        $cantidad_entrada += $cantidad;
                    }
                } else if ($tipo_docu == "I") {
                    if ($tipo_mov == 1) {
                        $cantidad_salida  = 0;
                        $cantidad_entrada = 0;
                        $balance          = 0;
                        $denominacion     = "INGRESO DE INVENTARIO";
                        $tipo_mov_d       = $fontin . $descr_mov;
                        $cantidad_entrada  += $cantidad;
                    } else {
                        $cantidad_salida  = 0;
                        $cantidad_entrada = 0;
                        $balance          = 0;
                        $denominacion     = "INGRESO DE INVENTARIO";
                        $tipo_mov_d       = $fontin . $descr_mov;
                        $cantidad_entrada += $cantidad;
                    }
                }

                $balance = $cantidad_entrada - $cantidad_salida;
            }

            $datas = new stdClass();
            $datas->ALMPROD_Stock = $balance;
            $almacen              = $filter->almacen;
            $product              = $filter->producto;

            $actualizar = $this->kardex_model->atualizar_sctock($almacen, $product, $datas);
            $exit       = array('resultado' => true, 'response' => $actualizar);
        } else {
            $exit = array('resultado' => false);
        }
        echo json_encode($exit);
    }

    public function balancear_stock_total($value = '')
    {

        $listado = $this->producto_model->productos_sistema();
        $lista = array();

        if (count($listado) > 0) {
            foreach ($listado as $indice => $valor) {

                $filter = new stdClass();
                $filter->producto = $valor->PROD_Codigo;
                $filter->almacen = $this->input->post('almacen');
                $filter->ult_inventario = 0;

                $cantidad_salida  = 0;
                $cantidad_entrada = 0;
                $balance          = 0;
                $kardex = $this->kardex_model->consultar_kardex($filter);
                if ($kardex) {
                    foreach ($kardex as $key => $value) {
                        $fontin       = "<font color='blue'>";
                        $anulado      = "<font color='red'>";
                        $fontaout     = "<font color='green'>";
                        $fontend      = "</fon>";

                        //DOCUMENTO INFO
                        //$compania     = $value->COMPP_Codigo;
                        $fecha        = $value->fecha;
                        $almacen      = $value->almacen;
                        $tipo_docu    = $value->tipo_docu; # T: transferencia 
                        $codigoDoc    = $value->codigo_docu;
                        $numDoc       = $value->serie . "-" . $value->numero;

                        //DETALLE INFO
                        $productoCod  = $value->codigo;
                        //$nombreProd   = $value->PROD_Descripcion;
                        $cantidad     = $value->cantidad;
                        //$afectacion   = $value->KARDC_ProdAfectacion;
                        //$pu           = $value->KARDC_Costo;
                        $precioConIgv = $value->moneda . " " . $value->pu_conIgv;
                        $subtotal     = $value->moneda . " " . $value->subtotal;
                        $total        = $value->moneda . " " . $value->total;

                        //MOVIMIENTO INFO
                        $tipo_mov     = $value->tipo_mov;
                        $descr_mov    = $value->tipo_des;
                        $estado       = $value->estado;

                        $num_doc        = $numDoc;
                        $cantidad_final = $cantidad;
                        $precio_conigv  = $precioConIgv;
                        $nom_almacen    = $value->nombre_almacen;
                        $denominacion   = $value->razon_social_cliente != NULL ? $value->razon_social_cliente : $value->razon_social_proveedor;

                        if ($tipo_docu == "F" || $tipo_docu == "B" || $tipo_docu == "N") {
                            if ($tipo_mov == 1) {
                                if ($estado == 1) {
                                    $tipo_mov_d     = $fontaout . $descr_mov;
                                } else {
                                    $tipo_mov_d     = $anulado . $descr_mov;
                                }
                                $cantidad_salida  += $cantidad;
                            } else {
                                if ($estado == 1) {
                                    $tipo_mov_d     = $fontin . $descr_mov;
                                } else {
                                    $tipo_mov_d     = $anulado . $descr_mov;
                                }
                                $cantidad_entrada += $cantidad;
                            }
                        } else if ($tipo_docu == "T") {
                            if ($tipo_mov == 1) {
                                $denominacion   = "TRASLADO DE ALMACEN";
                                $tipo_mov_d     = $fontaout . $descr_mov;
                                $cantidad_salida  += $cantidad;
                            } else {
                                $denominacion   = "TRASLADO DE ALMACEN";
                                $tipo_mov_d     = $fontin . $descr_mov;
                                $cantidad_entrada += $cantidad;
                            }
                        } else if ($tipo_docu == "A") {
                            if ($tipo_mov == 1) {
                                $cantidad_salida  = 0;
                                $cantidad_entrada = 0;
                                $balance          = 0;
                                $denominacion     = "REEMPLAZO POR AJUSTE";
                                $tipo_mov_d       = $fontin . $descr_mov;
                                $cantidad_entrada  += $cantidad;
                            } else {
                                $denominacion     = "SUMA POR AJUSTE";
                                $tipo_mov_d       = $fontin . $descr_mov;
                                $cantidad_entrada += $cantidad;
                            }
                        } else if ($tipo_docu == "NC") {
                            if ($tipo_mov == 1) {
                                if ($estado == 1) {
                                    $tipo_mov_d     = $fontaout . $descr_mov;
                                } else {
                                    $tipo_mov_d     = $anulado . $descr_mov;
                                }
                                $cantidad_salida  += $cantidad;
                            } else {
                                if ($estado == 1) {
                                    $tipo_mov_d     = $fontin . $descr_mov;
                                } else {
                                    $tipo_mov_d     = $anulado . $descr_mov;
                                }
                                $cantidad_entrada += $cantidad;
                            }
                        } else if ($tipo_docu == "I") {
                            if ($tipo_mov == 1) {
                                $cantidad_salida  = 0;
                                $cantidad_entrada = 0;
                                $balance          = 0;
                                $denominacion     = "INGRESO DE INVENTARIO";
                                $tipo_mov_d       = $fontin . $descr_mov;
                                $cantidad_entrada  += $cantidad;
                            } else {
                                $cantidad_salida  = 0;
                                $cantidad_entrada = 0;
                                $balance          = 0;
                                $denominacion     = "INGRESO DE INVENTARIO";
                                $tipo_mov_d       = $fontin . $descr_mov;
                                $cantidad_entrada += $cantidad;
                            }
                        }

                        $balance = $cantidad_entrada - $cantidad_salida;
                    }

                    $datas                = new stdClass();
                    $datas->ALMPROD_Stock = $balance;
                    $almacen              = $filter->almacen;
                    $product              = $filter->producto;
                    $actualizar           = $this->kardex_model->atualizar_sctock($almacen, $product, $datas);
                    $exit                 = array('resultado' => true, 'response' => "true");
                } else {
                    $exit = array('resultado' => false);
                }
            }
        }


        echo json_encode($exit);
    }

    ###########################
    public function ingreso_a_kardex($value = '')
    {

        $listado = $this->producto_model->productos_sistema();
        $lista = array();

        if (count($listado) > 0) {
            foreach ($listado as $indice => $valor) {

                $filter = new stdClass();
                $filter->producto = $valor->PROD_Codigo;
                $filter->almacen = $this->input->post('almacen');
                $filter->ult_inventario = 0;

                $cantidad_salida  = 0;
                $cantidad_entrada = 0;

                $kardex = $this->kardex_model->para_el_kardex($filter);
                if ($kardex) {
                    foreach ($kardex as $key => $value) {
                        $fecha        = "";
                        $almacen      = $value->almacen;
                        $nom_almacen  = $value->nombre_almacen;
                        $fecha        = $value->fecha; //mysql_to_human($value->fecha);
                        $num_doc      = $value->serie . ' - ' . $value->numero;
                        $precio_conigv = $value->pu_conIgv;
                        $fontin       = "<font color='blue'>";
                        $fontaout     = "<font color='green'>";
                        $fontend      = "</fon>";
                        $codprod      = $value->codigo;

                        $cantidad = $value->cantidad;

                        $cantidad_final = $cantidad;
                        $subtotal = $value->subtotal;
                        $total    = $value->total;

                        $cantidad = $cantidad;

                        if ($value->numero == "" || $value->numero == NULL) {
                            $num_doc = "INVENTARIO";
                        }
                        if ($value->tipo_oper == 'V') {
                            $cliente = $value->razon_social_cliente;
                            $tipo_mov = $fontaout . "SALIDA";
                            $cantidad_salida  += $cantidad;
                            ############################
                            # REGISTRO DE KARDEX
                            ############################
                            $cKardex = new stdClass();
                            $cKardex->fecha  = $value->fecha;
                            $cKardex->codigo_documento  = $value->codigo_docu;
                            $cKardex->tipo_docu         = $value->tipo_docu;
                            $cKardex->producto          = $codprod;
                            $cKardex->nombre_producto   = NULL;
                            $cKardex->cantidad          = $cantidad;
                            $cKardex->serie             = $value->serie;
                            $cKardex->numero            = $value->numero;
                            $cKardex->nombre_almacen    = NULL; #opcionales (para futuro desarrollo)
                            $cKardex->afectacion        = 1;
                            $cKardex->costo             = NULL;
                            $cKardex->precio_con_igv    = NULL;
                            $cKardex->subtotal          = $subtotal;
                            $cKardex->total             = $total;
                            $cKardex->compania          = $this->somevar['compania'];
                            $cKardex->tipo_oper         = 1; # 1: SALIDA 2: INGRESO 
                            $cKardex->tipo_movimiento   = "SALIDA POR VENTA";
                            $cKardex->nombre            = ""; #opcionales (para futuro desarrollo)
                            $cKardex->numdoc            = ""; #opcionales (para futuro desarrollo)
                            $cKardex->almacen           = $filter->almacen;
                            $cKardex->cliente           = $value->razon_social_cliente;
                            $cKardex->proveedor         = $value->razon_social_proveedor;
                            $cKardex->usuario           = 1;
                            $cKardex->estado            = 1;
                            $this->registrar_kardex($cKardex);
                        } elseif ($value->tipo_oper == 'C') {
                            $cliente = $value->razon_social_proveedor;
                            $tipo_mov = $fontin . "ENTRADA";
                            $cantidad_entrada += $cantidad;
                            ############################
                            # REGISTRO DE KARDEX
                            ############################
                            $cKardex = new stdClass();
                            $cKardex->fecha  = $value->fecha;
                            $cKardex->codigo_documento  = $value->codigo_docu;
                            $cKardex->tipo_docu         = $value->tipo_docu;
                            $cKardex->producto          = $codprod;
                            $cKardex->nombre_producto   = NULL;
                            $cKardex->cantidad          = $cantidad;
                            $cKardex->serie             = $value->serie;
                            $cKardex->numero            = $value->numero;
                            $cKardex->nombre_almacen    = NULL; #opcionales (para futuro desarrollo)
                            $cKardex->afectacion        = 1;
                            $cKardex->costo             = NULL;
                            $cKardex->precio_con_igv    = NULL;
                            $cKardex->subtotal          = $subtotal;
                            $cKardex->total             = $total;
                            $cKardex->compania          = $this->somevar['compania'];
                            $cKardex->tipo_oper         = 2; # 1: SALIDA 2: INGRESO 
                            $cKardex->tipo_movimiento   = "ENTRADA POR COMPRA";
                            $cKardex->nombre            = ""; #opcionales (para futuro desarrollo)
                            $cKardex->numdoc            = ""; #opcionales (para futuro desarrollo)
                            $cKardex->almacen           = $filter->almacen;
                            $cKardex->cliente           = $value->razon_social_cliente;
                            $cKardex->proveedor         = $value->razon_social_proveedor;
                            $cKardex->usuario           = 1;
                            $cKardex->estado            = 1;
                            $this->registrar_kardex($cKardex);
                        } else {
                            if ($value->tipo_oper == "I") {
                                $tipo_mov = $fontin . "ENTRADA";
                                $cliente  = "ENTRADA POR MOVIMIENTO DE INVENTARIO";
                                $cantidad_entrada += $cantidad;
                                ############################
                                # REGISTRO DE KARDEX
                                ############################
                                $cKardex = new stdClass();
                                $cKardex->fecha  = $value->fecha;
                                $cKardex->codigo_documento  = $value->codigo_docu;
                                $cKardex->tipo_docu         = $value->tipo_docu;
                                $cKardex->producto          = $codprod;
                                $cKardex->nombre_producto   = NULL;
                                $cKardex->cantidad          = $cantidad;
                                $cKardex->serie             = $value->serie;
                                $cKardex->numero            = $value->numero;
                                $cKardex->nombre_almacen    = NULL; #opcionales (para futuro desarrollo)
                                $cKardex->afectacion        = 1;
                                $cKardex->costo             = NULL;
                                $cKardex->precio_con_igv    = NULL;
                                $cKardex->subtotal          = $subtotal;
                                $cKardex->total             = $total;
                                $cKardex->compania          = $this->somevar['compania'];
                                $cKardex->tipo_oper         = 1; # 1: REEMPLAZO
                                $cKardex->tipo_movimiento   = "INGRESO DE INVENTARIO";
                                $cKardex->nombre            = ""; #opcionales (para futuro desarrollo)
                                $cKardex->numdoc            = ""; #opcionales (para futuro desarrollo)
                                $cKardex->almacen           = $filter->almacen;
                                $cKardex->cliente           = $value->razon_social_cliente;
                                $cKardex->proveedor         = $value->razon_social_proveedor;
                                $cKardex->usuario           = 1;
                                $cKardex->estado            = 1;
                                $this->registrar_kardex($cKardex);
                            }
                            if ($value->tipo_oper == "T") {
                                if ($value->almacen == $filter->almacen) {
                                    $tipo_mov = $fontaout . "SALIDA";
                                    $cliente  = "TRASLADO DE ALMACEN";
                                    $cantidad_salida  += $cantidad;
                                    ############################
                                    # REGISTRO DE KARDEX
                                    ############################
                                    $cKardex = new stdClass();
                                    $cKardex->fecha  = $value->fecha;
                                    $cKardex->codigo_documento  = $value->codigo_docu;
                                    $cKardex->tipo_docu         = $value->tipo_docu;
                                    $cKardex->producto          = $codprod;
                                    $cKardex->nombre_producto   = NULL;
                                    $cKardex->cantidad          = $cantidad;
                                    $cKardex->serie             = $value->serie;
                                    $cKardex->numero            = $value->numero;
                                    $cKardex->nombre_almacen    = NULL; #opcionales (para futuro desarrollo)
                                    $cKardex->afectacion        = 1;
                                    $cKardex->costo             = NULL;
                                    $cKardex->precio_con_igv    = NULL;
                                    $cKardex->subtotal          = $subtotal;
                                    $cKardex->total             = $total;
                                    $cKardex->compania          = $this->somevar['compania'];
                                    $cKardex->tipo_oper         = 1; # 1: SALIDA 2: INGRESO 
                                    $cKardex->tipo_movimiento   = "SALIDA POR TRASLADO DE ALMACEN";
                                    $cKardex->nombre            = ""; #opcionales (para futuro desarrollo)
                                    $cKardex->numdoc            = ""; #opcionales (para futuro desarrollo)
                                    $cKardex->almacen           = $filter->almacen;
                                    $cKardex->cliente           = $value->razon_social_cliente;
                                    $cKardex->proveedor         = $value->razon_social_proveedor;
                                    $cKardex->usuario           = 1;
                                    $cKardex->estado            = 1;
                                    $this->registrar_kardex($cKardex);
                                } else {
                                    $cliente  = "TRASLADO DE ALMACEN";
                                    $tipo_mov = $fontin . "ENTRADA";
                                    $cantidad_entrada += $cantidad;
                                    ############################
                                    # REGISTRO DE KARDEX
                                    ############################
                                    $cKardex = new stdClass();
                                    $cKardex->fecha  = $value->fecha;
                                    $cKardex->codigo_documento  = $value->codigo_docu;
                                    $cKardex->tipo_docu         = $value->tipo_docu;
                                    $cKardex->producto          = $codprod;
                                    $cKardex->nombre_producto   = NULL;
                                    $cKardex->cantidad          = $cantidad;
                                    $cKardex->serie             = $value->serie;
                                    $cKardex->numero            = $value->numero;
                                    $cKardex->nombre_almacen    = NULL; #opcionales (para futuro desarrollo)
                                    $cKardex->afectacion        = 1;
                                    $cKardex->costo             = NULL;
                                    $cKardex->precio_con_igv    = NULL;
                                    $cKardex->subtotal          = $subtotal;
                                    $cKardex->total             = $total;
                                    $cKardex->compania          = $this->somevar['compania'];
                                    $cKardex->tipo_oper         = 2; # 1: SALIDA 2: INGRESO 
                                    $cKardex->tipo_movimiento   = "INGRESO POR TRASLADO DE ALMACEN";
                                    $cKardex->nombre            = ""; #opcionales (para futuro desarrollo)
                                    $cKardex->numdoc            = ""; #opcionales (para futuro desarrollo)
                                    $cKardex->almacen           = $filter->almacen;
                                    $cKardex->cliente           = $value->razon_social_cliente;
                                    $cKardex->proveedor         = $value->razon_social_proveedor;
                                    $cKardex->usuario           = 1;
                                    $cKardex->estado            = 1;
                                    $this->registrar_kardex($cKardex);
                                }
                            }

                            if ($value->tipo_oper == "A") {
                                $total = "";
                                $cliente  = "AJUSTE DE INVENTARIO";
                                if ($value->codigo_docu == 1) {
                                    $tipo_mov = $fontin . "REEMPLAZO";
                                    $cantidad_entrada += $cantidad;
                                    ############################
                                    # REGISTRO DE KARDEX
                                    ############################
                                    $cKardex = new stdClass();
                                    $cKardex->fecha  = $value->fecha;
                                    $cKardex->codigo_documento  = $value->codigo_docu;
                                    $cKardex->tipo_docu         = $value->tipo_docu;
                                    $cKardex->producto          = $codprod;
                                    $cKardex->nombre_producto   = NULL;
                                    $cKardex->cantidad          = $cantidad;
                                    $cKardex->serie             = $value->serie;
                                    $cKardex->numero            = $value->numero;
                                    $cKardex->nombre_almacen    = NULL; #opcionales (para futuro desarrollo)
                                    $cKardex->afectacion        = 1;
                                    $cKardex->costo             = NULL;
                                    $cKardex->precio_con_igv    = NULL;
                                    $cKardex->subtotal          = $subtotal;
                                    $cKardex->total             = $total;
                                    $cKardex->compania          = $this->somevar['compania'];
                                    $cKardex->tipo_oper         = 1; # 1: REEMPLAZO
                                    $cKardex->tipo_movimiento   = "REEMPLAZO POR AJUSTE";
                                    $cKardex->nombre            = ""; #opcionales (para futuro desarrollo)
                                    $cKardex->numdoc            = ""; #opcionales (para futuro desarrollo)
                                    $cKardex->almacen           = $filter->almacen;
                                    $cKardex->cliente           = $value->razon_social_cliente;
                                    $cKardex->proveedor         = $value->razon_social_proveedor;
                                    $cKardex->usuario           = 1;
                                    $cKardex->estado            = 1;
                                    $this->registrar_kardex($cKardex);
                                } else {
                                    $tipo_mov = $fontin . "SUMA";
                                    $cantidad_entrada += $cantidad;
                                    ############################
                                    # REGISTRO DE KARDEX
                                    ############################
                                    $cKardex = new stdClass();
                                    $cKardex->fecha  = $value->fecha;
                                    $cKardex->codigo_documento  = $value->codigo_docu;
                                    $cKardex->tipo_docu         = $value->tipo_docu;
                                    $cKardex->producto          = $codprod;
                                    $cKardex->nombre_producto   = NULL;
                                    $cKardex->cantidad          = $cantidad;
                                    $cKardex->serie             = $value->serie;
                                    $cKardex->numero            = $value->numero;
                                    $cKardex->nombre_almacen    = NULL; #opcionales (para futuro desarrollo)
                                    $cKardex->afectacion        = 1;
                                    $cKardex->costo             = NULL;
                                    $cKardex->precio_con_igv    = NULL;
                                    $cKardex->subtotal          = $subtotal;
                                    $cKardex->total             = $total;
                                    $cKardex->compania          = $this->somevar['compania'];
                                    $cKardex->tipo_oper         = 2; # 1: SALIDA 2: INGRESO 
                                    $cKardex->tipo_movimiento   = "SUMA POR AJUSTE";
                                    $cKardex->nombre            = ""; #opcionales (para futuro desarrollo)
                                    $cKardex->numdoc            = ""; #opcionales (para futuro desarrollo)
                                    $cKardex->almacen           = $filter->almacen;
                                    $cKardex->cliente           = $value->razon_social_cliente;
                                    $cKardex->proveedor         = $value->razon_social_proveedor;
                                    $cKardex->usuario           = 1;
                                    $cKardex->estado            = 1;
                                    $this->registrar_kardex($cKardex);
                                }
                            }
                            if ($value->tipo_oper == "N") {
                                $total = "";
                                $cliente  = $value->razon_social_cliente;
                                $num_doc      = "NC " . $value->serie . ' - ' . $value->numero;
                                $tipo_mov = $fontin . "ENTRADA";
                                $cantidad_entrada += $cantidad;
                                ############################
                                # REGISTRO DE KARDEX
                                ############################
                                $cKardex = new stdClass();
                                $cKardex->fecha  = $value->fecha;
                                $cKardex->codigo_documento  = $value->codigo_docu;
                                $cKardex->tipo_docu         = $value->tipo_docu;
                                $cKardex->producto          = $codprod;
                                $cKardex->nombre_producto   = NULL;
                                $cKardex->cantidad          = $cantidad;
                                $cKardex->serie             = $value->serie;
                                $cKardex->numero            = $value->numero;
                                $cKardex->nombre_almacen    = NULL; #opcionales (para futuro desarrollo)
                                $cKardex->afectacion        = 1;
                                $cKardex->costo             = NULL;
                                $cKardex->precio_con_igv    = NULL;
                                $cKardex->subtotal          = $subtotal;
                                $cKardex->total             = $total;
                                $cKardex->compania          = $this->somevar['compania'];
                                $cKardex->tipo_oper         = 2; # 1: SALIDA 2: INGRESO 
                                $cKardex->tipo_movimiento   = "INGRESO POR NOTA DE CREDITO";
                                $cKardex->nombre            = ""; #opcionales (para futuro desarrollo)
                                $cKardex->numdoc            = ""; #opcionales (para futuro desarrollo)
                                $cKardex->almacen           = $filter->almacen;
                                $cKardex->cliente           = $value->razon_social_cliente;
                                $cKardex->proveedor         = $value->razon_social_proveedor;
                                $cKardex->usuario           = 1;
                                $cKardex->estado            = 1;
                                $this->registrar_kardex($cKardex);
                            }
                        }

                        //$balance = $cantidad_entrada - $cantidad_salida;



                    }




                    $exit       = array('resultado' => true, 'response' => "true");
                } else {
                    $exit = array('resultado' => false);
                }
            }
        }


        echo json_encode($exit);
    }


    public function registrar_kardex($filter)
    {
        $cKardex = new stdClass();

        $cKardex->KARD_Fecha            = $filter->fecha;
        $cKardex->KARDC_CodigoDoc       = $filter->codigo_documento;
        $cKardex->DOCUP_Codigo          = $filter->tipo_docu;
        $cKardex->PROD_Codigo           = $filter->producto;
        $cKardex->PROD_Descripcion      = $filter->nombre_producto; #opcionales (para futuro desarrollo)
        $cKardex->KARDC_Cantidad        = $filter->cantidad;
        $cKardex->KARDC_Serie           = $filter->serie;
        $cKardex->KARDC_Numero          = $filter->numero;
        $cKardex->KARDC_AlmacenDesc     = $filter->nombre_almacen; #opcionales (para futuro desarrollo)
        $cKardex->MONED_Codigo          = $filter->moneda;
        $cKardex->KARDC_ProdAfectacion  = $filter->afectacion;
        $cKardex->KARDC_Costo           = $filter->costo;
        $cKardex->KARDC_PrecioConIgv    = $filter->precio_con_igv;
        $cKardex->KARDC_Subtotal        = $filter->subtotal;
        $cKardex->KARDC_Total           = $filter->total;
        $cKardex->COMPP_Codigo          = $filter->compania;
        $cKardex->TIPOMOVP_Codigo       = $filter->tipo_oper;
        $cKardex->LOTP_Codigo           = NULL;
        $cKardex->KARDC_TipoIngreso     = $filter->tipo_movimiento;
        $cKardex->Denominacion          = $filter->nombre; #opcionales (para futuro desarrollo)
        $cKardex->NumDocRuc             = $filter->numdoc; #opcionales (para futuro desarrollo)
        $cKardex->ALMPROD_Codigo        = $filter->almacen;
        $cKardex->CLIP_Codigo           = $filter->cliente;
        $cKardex->PROVP_Codigo          = $filter->proveedor;
        $cKardex->USUA_Codigo           = $filter->usuario; #Nombre o codigo?
        $cKardex->KARDP_FlagEstado      = $filter->estado;
        $this->kardex_model->ingresar_kardex($cKardex);
    }
}
?>