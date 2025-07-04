<?php

include("system/application/libraries/cezpdf.php");
include("system/application/libraries/class.backgroundpdf.php");

class Ventas extends Controller {

    public function __construct() {
        parent::Controller();
        $this->load->helper('form');
        $this->load->helper('date');
        $this->load->helper('util');
        $this->load->library('lib_props');
        $this->load->library('Excel');
        $this->load->model('reportes/ventas_model');
        $this->load->model('almacen/producto_model');
        $this->load->model('ventas/comprobantedetalle_model');
        $this->load->model('maestros/directivo_model');
        $this->load->model('maestros/moneda_model');
        $this->load->model('tesoreria/cuentas_model');
        $this->load->model('tesoreria/pago_model');
        $this->load->model('tesoreria/cuentaspago_model');
        $this->load->model('ventas/Comprobante_formapago_model');//para pdf de ventas del dia
        $this->load->model('almacen/almacen_model');


        $this->somevar['user'] = $this->session->userdata('user');
        $this->somevar['rol'] = $this->session->userdata('rol');
        $this->somevar['empresa'] = $this->session->userdata('empresa');
        $this->somevar['compania'] = $this->session->userdata('compania');
    }
    public function excel_producto_por_vendedor($vendedor = "", $fechai = NULL, $fechaf = NULL)
    {
            $fechaI = explode("-", $fechai);
        $fechaF = explode("-", $fechaf);
        $f_ini = ($fechai == NULL) ? date("Y-").date("m-")."-01" : "$fechai";
        $f_fin = ($fechaF == NULL) ? date('Y-m-d') : "$fechaf";
        if ($vendedor=='0') {
            $vendedor="";
        }
        $hoja=0;
        $vendedores = $this->directivo_model->listarVendedores($vendedor);
        foreach ($vendedores as $key => $value) {
            $vendedor = $value->PERSP_Codigo;
        
        
            $this->load->library('Excel');
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
                                                    'color' => array('argb' => 'ECF0F1')
                                                ),
                                                'alignment' =>  array(
                                                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                        'wrap'          => TRUE
                                                ),
                                                'borders' => array(
                                                    'allborders' => array(
                                                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                                                        'color' => array( 'rgb' => "000000")
                                                    )
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
                                                        'color' => array( 'rgb' => "000000")
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
                                                        'color' => array( 'rgb' => "000000")
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
            

            $fechai = mysql_to_human($f_ini);
            $fechaf = mysql_to_human($f_fin);
            $this->excel->setActiveSheetIndex($hoja);
            #$this->excel->getActiveSheet()->setTitle('Ventas por vendedor');
            $this->excel->createSheet($hoja);
            $this->excel->setActiveSheetIndex($hoja); //Seleccionar la pestaña deseada
            
            $this->excel->getActiveSheet()->setTitle($value->PERSC_Nombre); //Establecer nombre
            $this->excel->getActiveSheet()->getStyle('A1:H2')->applyFromArray($estiloTitulo);
            $this->excel->getActiveSheet()->getStyle('A4:H4')->applyFromArray($estiloTitulo);
            $this->excel->getActiveSheet()->getStyle('A3:H3')->applyFromArray($estiloColumnasTitulo);
            $this->excel->setActiveSheetIndex($hoja)->mergeCells('A1:H2')->setCellValue('A1', $_SESSION['nombre_empresa']);
            $this->excel->setActiveSheetIndex($hoja)->mergeCells('A3:H3')->setCellValue("A3", "REPORTE DE VENTAS POR PRODUCTO SEGUN VENDEDOR. DESDE $fechai HASTA $fechaf");
            $this->excel->setActiveSheetIndex($hoja)->mergeCells('A4:H4')->setCellValue('A4', $value->PERSC_Nombre." ".$value->PERSC_ApellidoPaterno." ".$value->PERSC_ApellidoMaterno);

            $lugar = 5;
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
            $this->excel->getActiveSheet()->getStyle('A5:H5')->applyFromArray($estiloColumnasTitulo);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", "CODIGO");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar", "NOMBRE");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar", "UNIDAD");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar", "MARCA");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar", "CANTIDAD");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar", "TOTAL S/");

            $productosInfo = $this->ventas_model->excel_reporte_por_producto_vendedor($f_ini, $f_fin, $vendedor);
            
            $fila = 6;
            if($productosInfo>0){
            foreach ($productosInfo as $key => $value) {
                        $unidadMedida = $this->unidadmedida_model->obtener($value['unidad']);
                $medidaDetalle = "";
                $medidaDetalle = ($unidadMedida[0]->UNDMED_Descripcion != "") ? $unidadMedida[0]->UNDMED_Descripcion : "UNIDAD";
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$fila",$value['PROD_CodigoUsuario']);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$fila",$value['PROD_Nombre']);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$fila",$medidaDetalle);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$fila",$value['MARCC_Descripcion']);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$fila",$value['cantidadTotal']);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$fila",$value['ventaTotal']);
                    $fila++;
            }
            }
            $hoja++;
        }

            $filename = "Ventas por vendedor ".date('Y-m-d').".xls"; //save our workbook as this file name
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0"); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');
    }
    public function filtroVendedor() {
        $this->load->library('layout', 'layout');
        $data['fecha_inicio'] = '';
        $data['fecha_fin'] = '';
        $data['cboVendedor'] = $this->lib_props->listarVendedores();

        if (isset($_POST['reporte'])) {
            $data['fecha_inicio'] = $_POST['fecha_inicio'];
            $data['fecha_fin'] = $_POST['fecha_fin'];
            $data['resumen'] = $this->ventas_model->ventas_por_vendedor_resumen($data['fecha_inicio'], $data['fecha_fin']);
            $data['mensual'] = $this->ventas_model->ventas_por_vendedor_mensual($data['fecha_inicio'], $data['fecha_fin']);
            $data['anual'] = $this->ventas_model->ventas_por_vendedor_anual($data['fecha_inicio'], $data['fecha_fin']);
        }
        $this->layout->view('reportes/ventas_por_vendedor', $data);
    }

    public function filtroVendedorExcel($fechai = NULL, $fechaf = NULL) {
        $fechaI = explode("-", $fechai);
        $fechaF = explode("-", $fechaf);
        $f_ini = ($fechai == NULL) ? date("Y-").date("m-")."-01" : "$fechai";
        $f_fin = ($fechaF == NULL) ? date('Y-m-d') : "$fechaf";

            $resumen = $this->ventas_model->ventas_por_vendedor_resumen($f_ini, $f_fin);
            $mensual = $this->ventas_model->ventas_por_vendedor_mensual($f_ini, $f_fin);
            $anual = $this->ventas_model->ventas_por_vendedor_anual($f_ini, $f_fin);
        
        $this->load->library('Excel');
        
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Ventas Por Vendedor');
        
        $TipoFont = array( 'font'  => array( 'bold'  => false, 'color' => array('rgb' => '000000'), 'size'  => 14, 'name'  => 'Calibri'));
        $TipoFont2 = array( 'font'  => array( 'bold'  => false, 'color' => array('rgb' => '000000'), 'size'  => 12, 'name'  => 'Calibri'));
        $style = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $style2 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $this->excel->getActiveSheet()->getStyle('A1:N1')->applyFromArray($TipoFont);
        $this->excel->getActiveSheet()->getStyle('A1:N1')->applyFromArray($style);

        $this->excel->getActiveSheet()->getStyle('A3:N3')->applyFromArray($TipoFont);
        $this->excel->getActiveSheet()->getStyle("A3:N3")->applyFromArray($style);

        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('40');
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('18');
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth('18');
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth('18');
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth('18');
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth('18');

        $this->excel->setActiveSheetIndex(0)->mergeCells('A1:E2')->setCellValue('A1', $_SESSION['nombre_empresa']);
        
        $this->excel->getActiveSheet()->getStyle("A3:E3")->applyFromArray($TipoFont2);
        $this->excel->getActiveSheet()->getStyle("A3:E3")->applyFromArray($style2);
        $this->excel->setActiveSheetIndex(0)->mergeCells("A3:E3")->setCellValue("A3", "REPORTE DESDE $f_ini HASTA $f_fin");
        
        $this->excel->setActiveSheetIndex(0)->setCellValue('A4', 'N');
        $this->excel->setActiveSheetIndex(0)->setCellValue('B4', 'VENDEDOR');
        $this->excel->setActiveSheetIndex(0)->setCellValue('C4', 'FECHA DESDE');
        $this->excel->setActiveSheetIndex(0)->setCellValue('D4', 'FECHA HASTA');
        $this->excel->setActiveSheetIndex(0)->setCellValue('E4', 'VENTA');
    
        #$this->excel->setActiveSheetIndex(0);
        $numeroS = 0;
        $lugar = 5;

        foreach($resumen as $col)
            $keys = array_keys($col);
        
        foreach($resumen as $indice => $valor){
            $numeroS+=1;
            $ventas=$valor[$keys[0]];
            $nombre=$valor[$keys[1]];
            $paterno=$valor[$keys[2]];

            $this->excel->setActiveSheetIndex(0)
            ->setCellValue('A'.$lugar, $numeroS)
            ->setCellValue('B'.$lugar, "$nombre $paterno")
            ->setCellValue('C'.$lugar, $f_ini)
            ->setCellValue('D'.$lugar, $f_fin)
            ->setCellValue('E'.$lugar, $ventas);
            $lugar+=1;    
        }

        $numeroS = 0;
        $lugar += 4;
        $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($TipoFont2);
        $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($style2);
        $this->excel->setActiveSheetIndex(0)->mergeCells("A$lugar:E$lugar")->setCellValue("A$lugar", "REPORTE MENSUAL");
        $lugar++;
        $this->excel->setActiveSheetIndex(0)->setCellValue("A$lugar", "N");
        $this->excel->setActiveSheetIndex(0)->setCellValue("B$lugar", "NOMBRE");
        #$this->excel->setActiveSheetIndex(0)->setCellValue("C$lugar", "VENTAS");

        foreach($mensual as $col)
            $keys = array_keys($col);

        $size = count($keys);
        $lcol = $lugar;
        $lugar++;

        foreach($mensual as $indice => $valor){ // listo todos los meses seleccionados
            for ($x = 2; $x < $size; $x++){
                $mes = substr($keys[$x], -1); // obtengo el mes
                $this->excel->setActiveSheetIndex(0)->setCellValue($this->lib_props->colExcel($x+1)."$lcol", $this->lib_props->mesesEs($mes));
            }
        }
        

        foreach($mensual as $indice => $valor){
            $numeroS+=1;
            $nombre=$valor[$keys[0]];
            $paterno=$valor[$keys[1]];

            for ($x = 2; $x < $size; $x++){ // 2 posicion de array donde inician ventas
                if ( $valor[$keys[$x]] != "" ){
                    $ventas = $valor[$keys[$x]];
                    $this->excel->setActiveSheetIndex(0)->setCellValue($this->lib_props->colExcel($x+1)."$lugar", $ventas); // x + 2 posision donde inician ventas + iniciar en columna D
                    #break;
                }
            }

            $this->excel->setActiveSheetIndex(0)
            ->setCellValue('A'.$lugar, $numeroS)
            ->setCellValue('B'.$lugar, "$nombre $paterno");
            $lugar+=1;
        }

        $numeroS = 0;
        $lugar += 4;
        $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($TipoFont2);
        $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($style2);
        $this->excel->setActiveSheetIndex(0)->setCellValue("A$lugar", "REPORTE ANUAL");
        $lugar++;
        $this->excel->setActiveSheetIndex(0)->setCellValue("A$lugar", "N");
        $this->excel->setActiveSheetIndex(0)->setCellValue("B$lugar", "NOMBRE");
        
        foreach($anual as $col)
            $keys = array_keys($col); // obtengo las llaves

        $size = count($keys);
        $lcol = $lugar;
        $lugar++;

        foreach($anual as $indice => $valor){ // listo todos los años seleccionados
            for ($x = 2; $x < $size; $x++){
                $anio = substr($keys[$x], 1); // obtengo el año
                $this->excel->setActiveSheetIndex(0)->setCellValue($this->lib_props->colExcel($x+1)."$lcol",$anio);
            }
        }
        

        foreach($anual as $indice => $valor){
            $numeroS+=1;
            $nombre=$valor[$keys[0]];
            $paterno=$valor[$keys[1]];

            for ($x = 2; $x < $size; $x++){ // 2 posicion de array donde inician ventas
                if ( $valor[$keys[$x]] != "" ){
                    $ventas = $valor[$keys[$x]];
                    $this->excel->setActiveSheetIndex(0)->setCellValue($this->lib_props->colExcel($x+1)."$lugar", $ventas); // x + 2 posision donde inician ventas + iniciar en columna D
                    #break;
                }
            }

            $this->excel->setActiveSheetIndex(0)
            ->setCellValue('A'.$lugar, $numeroS)
            ->setCellValue('B'.$lugar, "$nombre $paterno");
            $lugar+=1;
        }

        $filename = "Ventas De Vendedorre ".date('Y-m-d').".xls"; //save our workbook as this file name

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0"); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');
        #$this->layout->view('reportes/ventas_por_vendedor', $data);
    }

    public function filtroVendedorExcelDet($vendedor = "0", $fechai = NULL, $fechaf = NULL) {
        $fechaI = explode("-", $fechai);
        $fechaF = explode("-", $fechaf);
        $f_ini = ($fechai == NULL) ? date("Y-").date("m-")."-01" : "$fechai";
        $f_fin = ($fechaF == NULL) ? date('Y-m-d') : "$fechaf";

        
        $this->load->library('Excel');
        $hoja = 0;
        $this->excel->setActiveSheetIndex($hoja);
        $this->excel->getActiveSheet()->setTitle('Ventas por vendedor');
        
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
                                                'color' => array('argb' => 'ECF0F1')
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            ),
                                            'borders' => array(
                                                'allborders' => array(
                                                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                                                    'color' => array( 'rgb' => "000000")
                                                )
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
                                                    'color' => array( 'rgb' => "000000")
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
                                                    'color' => array( 'rgb' => "000000")
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

        ###########################################################################
        ###### HOJA 0 VENTAS POR VENDEDOR
        ###########################################################################
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
            $this->excel->getActiveSheet()->getStyle("A1:K2")->applyFromArray($estiloTitulo);
            $this->excel->getActiveSheet()->getStyle("A3:K3")->applyFromArray($estiloColumnasTitulo);

            $this->excel->setActiveSheetIndex($hoja)->mergeCells('A1:K2')->setCellValue('A1', $_SESSION['nombre_empresa']);        
            $this->excel->setActiveSheetIndex($hoja)->mergeCells("A3:K3")->setCellValue("A3", "VENTAS POR VENDEDOR DESDE $f_ini HASTA $f_fin");
            
            $lugar = 4;
            $vendedor = ($vendedor == 0) ? "" : $vendedor;
            $listaVendedores = $this->directivo_model->listarVendedores($vendedor);
            
            foreach ($listaVendedores as $indice => $data) {
                $numeroS = 0;
                $fpago = NULL;

                $resumen = $this->ventas_model->ventas_por_vendedor_general_suma($data->PERSP_Codigo, $f_ini, $f_fin);
                $detalle = $this->ventas_model->ventas_por_vendedor_detallado($data->PERSP_Codigo, $f_ini, $f_fin);

                if ($resumen != NULL){
                    foreach($resumen as $indice => $valor){
                        $numeroS += 1;

                        if ($numeroS == 1){
                            $lugarN = $lugar + 1;
                            foreach($detalle as $i => $val){
                                $this->excel->getActiveSheet()->getStyle("A$lugar:C$lugarN")->applyFromArray($estiloBold);
                                $this->excel->setActiveSheetIndex($hoja)
                                ->setCellValue("A$lugar", "DNI: $val->PERSC_NumeroDocIdentidad")
                                ->setCellValue("A$lugarN", "VENDEDOR: $val->PERSC_Nombre $val->PERSC_ApellidoPaterno $val->PERSC_ApellidoMaterno");
                                break;
                            }
                            $lugar += 1;
                        }
                    }

                    $lugar++;
                    $numeroS = 0;

                    foreach($detalle as $indice => $valor){
                        $numeroS += 1;

                        if ($numeroS == 1){
                            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", 'N');
                            $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar", 'FORMA DE PAGO');
                            $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar", 'CÓDIGO');
                            $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar", 'RUC Y RAZON SOCIAL');
                            $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar", 'SERIE');
                            $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar", 'NÚMERO');
                            $this->excel->setActiveSheetIndex($hoja)->setCellValue("G$lugar", 'TOTAL');
                            $this->excel->setActiveSheetIndex($hoja)->setCellValue("H$lugar", 'FECHA');
                            $this->excel->setActiveSheetIndex($hoja)->setCellValue("I$lugar", 'NOTA CREDITO RELACIONADA');
                            $this->excel->setActiveSheetIndex($hoja)->setCellValue("J$lugar", 'TOTAL');
                            $this->excel->setActiveSheetIndex($hoja)->setCellValue("K$lugar", 'FECHA');

                            $this->excel->getActiveSheet()->getStyle("A$lugar:K$lugar")->applyFromArray($estiloColumnasTitulo);
                            $lugar++;
                        }
                        
                        $this->excel->setActiveSheetIndex($hoja)
                        ->setCellValue("A$lugar", $numeroS)
                        ->setCellValue("B$lugar", $valor->FORPAC_Descripcion)
                        ->setCellValue("C$lugar", $valor->CLIC_CodigoUsuario)
                        ->setCellValue("D$lugar", $valor->nombre_cliente)
                        ->setCellValue("E$lugar", $valor->CPC_Serie)
                        ->setCellValue("F$lugar", $valor->CPC_Numero)
                        ->setCellValue("G$lugar", number_format($valor->CPC_Total,2))
                        ->setCellValue("H$lugar", $valor->CPC_Fecha)
                        ->setCellValue("I$lugar", $valor->CRED_Serie."-".$valor->CRED_Numero)
                        ->setCellValue("J$lugar", $valor->CRED_Total)
                        ->setCellValue("K$lugar", $valor->CRED_Fecha);

                        if ($indice % 2 == 0)
                            $this->excel->getActiveSheet()->getStyle("A$lugar:K$lugar")->applyFromArray($estiloColumnasPar);
                        else
                            $this->excel->getActiveSheet()->getStyle("A$lugar:K$lugar")->applyFromArray($estiloColumnasImpar);

                        $lugar+=1;
                        $fpago = $valor->FORPAC_Descripcion;
                    }
                    $lugar++;
                }
            }

            for($i = 'B'; $i <= 'K'; $i++){
                $this->excel->setActiveSheetIndex($hoja)->getColumnDimension($i)->setAutoSize(true);
            }

        ###########################################################################
        ###### HOJA 1 VENTAS POR PRODUCTO SEGUN VENDEDOR
        ###########################################################################
            $productosInfo = $this->ventas_model->ventas_por_producto_de_vendedor($f_ini, $f_fin);
            $col = count($productosInfo[0]);
            $split = $col - intval( $col / 2 ) + 7;
            $colE = $this->lib_props->colExcel( $split );
            $size = count($productosInfo);
            
            $hoja++;
            $this->excel->createSheet($hoja);
            $this->excel->setActiveSheetIndex($hoja); //Seleccionar la pestaña deseada
            $this->excel->getActiveSheet()->setTitle('Ventas por producto'); //Establecer nombre

            $this->excel->getActiveSheet()->getStyle('A1:'.$colE.'2')->applyFromArray($estiloTitulo);
            $this->excel->getActiveSheet()->getStyle('A3:'.$colE.'3')->applyFromArray($estiloColumnasTitulo);

            $this->excel->setActiveSheetIndex($hoja)->mergeCells('A1:'.$colE.'2')->setCellValue('A1', $_SESSION['nombre_empresa']);
            $this->excel->setActiveSheetIndex($hoja)->mergeCells('A3:'.$colE.'3')->setCellValue("A3", "REPORTE DE VENTAS POR PRODUCTO SEGUN VENDEDOR. DESDE $f_ini HASTA $f_fin");

            $numeroS = 0;
            $lugar = 5;
            
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", "CODIGO");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar", "NOMBRE");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar", "MARCA");


            $lugarTU = 4;
            $lugarT = $lugar;


            $this->excel->getActiveSheet()->getStyle("A$lugarTU:$colE$lugarT")->applyFromArray($estiloColumnasTitulo);
            $lugar++;

            for ($i = "D"; $i <= $colE; $i++){
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("$i$lugarT", "CANTIDAD" );
                $i++;
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("$i$lugarT", "TOTAL S/ " );
            }

            foreach($productosInfo as $nCol)
                $keys = array_keys($nCol);

            $merge = true;

            for ($x = 0; $x < $size; $x++){
                $vendedor = 0;
                $it = 4;
                for ($j = 0; $j < $col; $j++) {

                    if ( $keys[$j] != "vendedor".$vendedor ){
                            $this->excel->setActiveSheetIndex($hoja)->setCellValue($this->lib_props->colExcel( $j + 1 - $vendedor)."$lugar", $productosInfo[$x][ $keys[$j] ] );
                    }
                    
                    if ( $keys[$j] == "vendedor".$vendedor )
                        $vendedor++;

                    if ( $x == 0 ){

                        $c1 = $this->lib_props->colExcel( $it );
                        $c2 = $this->lib_props->colExcel( $it + 1 );
                        $cols = "$c1$lugarTU:$c2$lugarTU";

                        if ( $c2 > $colE)
                            $merge = false;

                        if ($merge == true){
                            #$this->excel->setActiveSheetIndex($hoja)->mergeCells($cols)->setCellValue($this->lib_props->colExcel($it).$lugarTU, $productosInfo[$x]["vendedor$j"] );
                            $this->excel->setActiveSheetIndex($hoja)->setCellValue($this->lib_props->colExcel($it).$lugarTU, $productosInfo[$x]["vendedor$j"] );
                            $it += 2;
                        }
                    }
                }

                #$this->excel->setActiveSheetIndex($hoja)->setCellValue("$colE$lugarT", "TOTAL" );

                if ($x % 2 == 0)
                    $this->excel->getActiveSheet()->getStyle("A$lugar:$colE$lugar")->applyFromArray($estiloColumnasPar);
                else
                    $this->excel->getActiveSheet()->getStyle("A$lugar:$colE$lugar")->applyFromArray($estiloColumnasImpar);

                $lugar++;
            }

            $this->excel->getActiveSheet()->getColumnDimension("A")->setWidth('18');
            $this->excel->getActiveSheet()->getColumnDimension("B")->setWidth('30');
            $this->excel->getActiveSheet()->getColumnDimension("B")->setWidth('20');
            for ($i = "D"; $i <= $colE; $i++)
                $this->excel->getActiveSheet()->getColumnDimension($i)->setWidth('11');

        ###########################################################################
        ###### HOJA 2 VENTAS POR MARCA SEGUN VENDEDOR
        ###########################################################################
            $marcasInfo = $this->ventas_model->ventas_por_marca_de_vendedor($f_ini, $f_fin);
            $col = count($marcasInfo[0]);
            $split = $col - intval( $col / 2 ) + 2;
            $colE = $this->lib_props->colExcel( $split );
            $size = count($marcasInfo);
            
            $hoja++;
            $this->excel->createSheet($hoja);
            $this->excel->setActiveSheetIndex($hoja); //Seleccionar la pestaña deseada
            $this->excel->getActiveSheet()->setTitle('Ventas por marca segun vendedor'); //Establecer nombre

            $this->excel->getActiveSheet()->getStyle('A1:'.$colE.'2')->applyFromArray($estiloTitulo);
            $this->excel->getActiveSheet()->getStyle('A3:'.$colE.'3')->applyFromArray($estiloColumnasTitulo);

            $this->excel->setActiveSheetIndex($hoja)->mergeCells('A1:'.$colE.'2')->setCellValue('A1', $_SESSION['nombre_empresa']);
            $this->excel->setActiveSheetIndex($hoja)->mergeCells('A3:'.$colE.'3')->setCellValue("A3", "REPORTE DE VENTAS POR MARCA SEGUN VENDEDOR. DESDE $f_ini HASTA $f_fin");

            $numeroS = 0;
            $lugar = 4;
            
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", "N");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar", "MARCA");

            $lugarT = $lugar;
            
            $this->excel->getActiveSheet()->getStyle("A$lugar:$colE$lugar")->applyFromArray($estiloColumnasTitulo);
            $lugar++;

            foreach($marcasInfo as $nCol)
                $keys = array_keys($nCol); // obtengo las llaves

            for ($x = 0; $x < $size; $x++){
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", $x + 1);
                $vendedor = 0;
                for ($j = 0; $j < $col; $j++) {

                    if ( $keys[$j] != "vendedor".$vendedor ){
                            $this->excel->setActiveSheetIndex($hoja)->setCellValue($this->lib_props->colExcel( $j + 2 - $vendedor)."$lugar", $marcasInfo[$x][ $keys[$j] ] );
                    }
                    
                    if ( $keys[$j] == "vendedor".$vendedor )
                        $vendedor++;

                    if ( $x == 0 )
                        $this->excel->setActiveSheetIndex($hoja)->setCellValue($this->lib_props->colExcel( $j + 3 )."$lugarT", $marcasInfo[$x]["vendedor$j"] );

                }

                $this->excel->setActiveSheetIndex($hoja)->setCellValue("$colE$lugarT", "TOTAL" );

                if ($x % 2 == 0)
                    $this->excel->getActiveSheet()->getStyle("A$lugar:$colE$lugar")->applyFromArray($estiloColumnasPar);
                else
                    $this->excel->getActiveSheet()->getStyle("A$lugar:$colE$lugar")->applyFromArray($estiloColumnasImpar);

                $lugar++;
            }

            for ($i = "B"; $i <= $colE; $i++)
                $this->excel->getActiveSheet()->getColumnDimension($i)->setWidth('20');
        
        $filename = "Ventas por vendedor ".date('Y-m-d').".xls"; //save our workbook as this file name
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0"); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');
    }

    public function filtroVendedorExcelGeneral($fechai = NULL, $fechaf = NULL) {
        $fechaI = explode("-", $fechai);
        $fechaF = explode("-", $fechaf);
        $f_ini = ($fechai == NULL) ? date("Y-").date("m-")."-01" : "$fechai";
        $f_fin = ($fechaF == NULL) ? date('Y-m-d') : "$fechaf";

        
        $this->load->library('Excel');
        
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Ventas Por Vendedor');
        
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

        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
        $this->excel->getActiveSheet()->getStyle("A1:H2")->applyFromArray($estiloTitulo);
        $this->excel->getActiveSheet()->getStyle("A3:H3")->applyFromArray($estiloColumnasTitulo);

        $this->excel->setActiveSheetIndex(0)->mergeCells('A1:H2')->setCellValue('A1', $_SESSION['nombre_empresa']);        
        $this->excel->setActiveSheetIndex(0)->mergeCells("A3:H3")->setCellValue("A3", "VENTAS POR VENDEDOR DESDE $f_ini HASTA $f_fin");
        
        $listaVendedores = $this->directivo_model->listarVendedores();

        $lugar = 5;
        
        foreach ($listaVendedores as $indice => $data) {
            $numeroS = 0;
            $fpago = NULL;

            $detalle = $this->ventas_model->ventas_por_vendedor_general($data->PERSP_Codigo, $f_ini, $f_fin);

            if ($detalle != NULL){
                foreach($detalle as $indice => $valor){
                    $numeroS += 1;

                    if ($numeroS == 1){
                        foreach($detalle as $i => $val){
                            $this->excel->getActiveSheet()->getStyle("A$lugar:H$lugar")->applyFromArray($estiloBold);
                            $this->excel->setActiveSheetIndex(0)->mergeCells("A$lugar:H$lugar")->setCellValue("A$lugar", "VENDEDOR: $val->vendedor");
                            break;
                        }
                        $lugar += 1;

                        $this->excel->getActiveSheet()->getStyle("A$lugar:H$lugar")->applyFromArray($estiloColumnasTitulo);
                        $this->excel->setActiveSheetIndex(0)->setCellValue("A$lugar", 'N');
                        $this->excel->setActiveSheetIndex(0)->setCellValue("B$lugar", 'FORMA DE PAGO');
                        $this->excel->setActiveSheetIndex(0)->setCellValue("C$lugar", 'FACTURAS');
                        $this->excel->setActiveSheetIndex(0)->setCellValue("D$lugar", 'BOLETAS');
                        $this->excel->setActiveSheetIndex(0)->setCellValue("E$lugar", 'COMPROBANTES');
                        $this->excel->setActiveSheetIndex(0)->setCellValue("F$lugar", 'TOTAL');
                        $this->excel->setActiveSheetIndex(0)->setCellValue("G$lugar", 'NOTAS DE CREDITO');
                        $this->excel->setActiveSheetIndex(0)->setCellValue("H$lugar", 'VENTAS - NOTAS DE CREDITO');
                        $lugar++;
                    }
                    
                    $this->excel->setActiveSheetIndex(0)
                    ->setCellValue("A$lugar", $numeroS)
                    ->setCellValue("B$lugar", $valor->FORPAC_Descripcion)
                    ->setCellValue("C$lugar", number_format($valor->totalFacturas,2))
                    ->setCellValue("D$lugar", number_format($valor->totalBoletas,2))
                    ->setCellValue("E$lugar", number_format($valor->totalComprobantes,2))
                    ->setCellValue("F$lugar", number_format($valor->total,2))
                    ->setCellValue("G$lugar", number_format($valor->totalNotas,2))
                    ->setCellValue("H$lugar", number_format($valor->total - $valor->totalNotas,2));

                    if ($indice % 2 == 0)
                        $this->excel->getActiveSheet()->getStyle("A$lugar:H$lugar")->applyFromArray($estiloColumnasPar);
                    else
                        $this->excel->getActiveSheet()->getStyle("A$lugar:H$lugar")->applyFromArray($estiloColumnasImpar);
                    $lugar++;
                }
                $lugar++;
                $numeroS = 0;
            }
        }
        
        for($i = 'A'; $i <= 'C'; $i++){
            $this->excel->setActiveSheetIndex(0)            
                ->getColumnDimension($i)->setAutoSize(true);
        }

        
        $filename = "Ventas por Vendedor General ".date('Y-m-d').".xls"; //save our workbook as this file name
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0"); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');
    }

    public function filtroProveedor() {
        $this->load->library('layout', 'layout');
        $data['fecha_inicio'] = '';
        $data['fecha_fin'] = '';
            
        $this->layout->view('reportes/compras_por_proveedor', $data);
    }

    public function resumen_ventas_detallado($fechai = NULL, $fechaf = NULL) {
        $fechaI = explode("-", $fechai);
        $fechaF = explode("-", $fechaf);
        $f_ini = ($fechai == NULL) ? date("Y-").date("m-")."-01" : "$fechai";
        $f_fin = ($fechaF == NULL) ? date('Y-m-d') : "$fechaf";

        
        $this->load->library('Excel');
        
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Resumen Detallado de Ventas');
        
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
                                                'size' => 10
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
            $estiloBold = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => true,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                ),
                                                'size' => 9
                                            )
                                        );

        $this->excel->getActiveSheet()->getStyle("A1:O2")->applyFromArray($estiloTitulo);
        $this->excel->getActiveSheet()->getStyle("A3:O3")->applyFromArray($estiloColumnasTitulo);

        $this->excel->setActiveSheetIndex(0)->mergeCells('A1:O2')->setCellValue('A1', $_SESSION['nombre_empresa']);        
        $this->excel->setActiveSheetIndex(0)->mergeCells("A3:O3")->setCellValue("A3", "DETALLE DE VENTAS DESDE $f_ini HASTA $f_fin");
        
        $lugar = 4;
        $numeroS = 0;

        $resumen = $this->ventas_model->resumen_ventas_detallado($f_ini, $f_fin);

        $this->excel->setActiveSheetIndex(0)->setCellValue("A$lugar", "FECHA DOC.");
        $this->excel->setActiveSheetIndex(0)->setCellValue("B$lugar", "FECHA REG.");
        $this->excel->setActiveSheetIndex(0)->setCellValue("C$lugar", "SERIE/NUMERO");
        $this->excel->setActiveSheetIndex(0)->setCellValue("D$lugar", "CLIENTE");
        $this->excel->setActiveSheetIndex(0)->setCellValue("E$lugar", "NOMBRE DE PRODUCTO");
        $this->excel->setActiveSheetIndex(0)->setCellValue("F$lugar", "MARCA");
        $this->excel->setActiveSheetIndex(0)->setCellValue("G$lugar", "LOTE");
        $this->excel->setActiveSheetIndex(0)->setCellValue("H$lugar", "FECHA VCTO");
        $this->excel->setActiveSheetIndex(0)->setCellValue("I$lugar", "CANTIDAD");
        $this->excel->setActiveSheetIndex(0)->setCellValue("J$lugar", "P/U");
        $this->excel->setActiveSheetIndex(0)->setCellValue("K$lugar", "TOTAL");
        $this->excel->setActiveSheetIndex(0)->setCellValue("L$lugar", "NOTA DE CREDITO");
        $this->excel->setActiveSheetIndex(0)->setCellValue("M$lugar", "CANTIDAD");
        $this->excel->setActiveSheetIndex(0)->setCellValue("N$lugar", "P/U");
        $this->excel->setActiveSheetIndex(0)->setCellValue("O$lugar", "TOTAL");
        $this->excel->getActiveSheet()->getStyle("A$lugar:O$lugar")->applyFromArray($estiloColumnasTitulo);

        if ($resumen != NULL){
            $lugar++;
            foreach($resumen as $indice => $valor){
                $fRegistro = explode(" ", $valor->CPC_FechaRegistro);
                $this->excel->setActiveSheetIndex(0)
                ->setCellValue("A$lugar", $valor->CPC_Fecha)
                ->setCellValue("B$lugar", $fRegistro[0])
                ->setCellValue("C$lugar", $valor->CPC_Serie." - ".$valor->CPC_Numero)
                ->setCellValue("D$lugar", $valor->clienteEmpresa.$valor->clientePersona)
                ->setCellValue("E$lugar", $valor->PROD_Nombre)
                ->setCellValue("F$lugar", $valor->MARCC_CodigoUsuario)
                ->setCellValue("G$lugar", $valor->LOTC_Numero)
                ->setCellValue("H$lugar", $valor->LOTC_FechaVencimiento)
                ->setCellValue("I$lugar", $valor->CPDEC_Cantidad)
                ->setCellValue("J$lugar", $valor->CPDEC_Pu_ConIgv)
                ->setCellValue("K$lugar", $valor->CPDEC_Total)
                ->setCellValue("L$lugar", $valor->CRED_Serie."-".$valor->CRED_Numero)
                ->setCellValue("M$lugar", $valor->CREDET_Cantidad)
                ->setCellValue("N$lugar", $valor->CREDET_Pu_ConIgv)
                ->setCellValue("O$lugar", $valor->CREDET_Total);
                if ($indice % 2 == 0)
                    $this->excel->getActiveSheet()->getStyle("A$lugar:O$lugar")->applyFromArray($estiloColumnasPar);
                else
                    $this->excel->getActiveSheet()->getStyle("A$lugar:O$lugar")->applyFromArray($estiloColumnasImpar);
                $lugar++;
            }
            $lugar++;
        }

        $this->excel->getActiveSheet()->getColumnDimension("D")->setWidth("25");
        $this->excel->getActiveSheet()->getColumnDimension("E")->setWidth("25");

        for($i = 'A'; $i <= 'O'; $i++){
            if ($i != 'D' && $i != 'E')
            $this->excel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(true);
        }

        
        $filename = "Reporte de ventas ".date('Y-m-d').".xls"; //save our workbook as this file name
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0"); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');
    }

    public function resumen_compras_detallado($fechai = NULL, $fechaf = NULL) {
        $fechaI = explode("-", $fechai);
        $fechaF = explode("-", $fechaf);
        $f_ini = ($fechai == NULL) ? date("Y-").date("m-")."-01" : "$fechai";
        $f_fin = ($fechaF == NULL) ? date('Y-m-d') : "$fechaf";

        
        $this->load->library('Excel');
        
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Resumen Detallado de Compras');
        
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
                                                'size' => 10
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
            $estiloBold = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => true,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                ),
                                                'size' => 9
                                            )
                                        );

        $this->excel->getActiveSheet()->getStyle("A1:I2")->applyFromArray($estiloTitulo);
        $this->excel->getActiveSheet()->getStyle("A3:I3")->applyFromArray($estiloColumnasTitulo);

        $this->excel->setActiveSheetIndex(0)->mergeCells('A1:I2')->setCellValue('A1', $_SESSION['nombre_empresa']);        
        $this->excel->setActiveSheetIndex(0)->mergeCells("A3:I3")->setCellValue("A3", "DETALLE DE COMPRAS DESDE $f_ini HASTA $f_fin");
        
        $lugar = 4;
        $numeroS = 0;

        $resumen = $this->ventas_model->resumen_compras_detallado($f_ini, $f_fin);

        $this->excel->setActiveSheetIndex(0)->setCellValue("A$lugar", "FECHA DOC.");
        $this->excel->setActiveSheetIndex(0)->setCellValue("B$lugar", "FECHA ING.");
        $this->excel->setActiveSheetIndex(0)->setCellValue("C$lugar", "SERIE/NUMERO");
        $this->excel->setActiveSheetIndex(0)->setCellValue("D$lugar", "PROVEEDOR");
        $this->excel->setActiveSheetIndex(0)->setCellValue("E$lugar", "NOMBRE DE PRODUCTO");
        $this->excel->setActiveSheetIndex(0)->setCellValue("F$lugar", "MARCA");
        $this->excel->setActiveSheetIndex(0)->setCellValue("G$lugar", "LOTE");
        $this->excel->setActiveSheetIndex(0)->setCellValue("H$lugar", "FECHA VCTO");
        $this->excel->setActiveSheetIndex(0)->setCellValue("I$lugar", "CANTIDAD");
        $this->excel->getActiveSheet()->getStyle("A$lugar:I$lugar")->applyFromArray($estiloColumnasTitulo);

        if ($resumen != NULL){
            $lugar++;
            foreach($resumen as $indice => $valor){
                $fRegistro = explode(" ", $valor->CPC_FechaRegistro);
                $this->excel->setActiveSheetIndex(0)
                ->setCellValue("A$lugar", $valor->CPC_Fecha)
                ->setCellValue("B$lugar", $fRegistro[0])
                ->setCellValue("C$lugar", $valor->CPC_Serie." - ".$valor->CPC_Numero)
                ->setCellValue("D$lugar", $valor->proveedorEmpresa.$valor->proveedorPersona)
                ->setCellValue("E$lugar", $valor->PROD_Nombre)
                ->setCellValue("F$lugar", $valor->MARCC_CodigoUsuario)
                ->setCellValue("G$lugar", $valor->LOTC_Numero)
                ->setCellValue("H$lugar", $valor->LOTC_FechaVencimiento)
                ->setCellValue("I$lugar", $valor->CPDEC_Cantidad);
                if ($indice % 2 == 0)
                    $this->excel->getActiveSheet()->getStyle("A$lugar:I$lugar")->applyFromArray($estiloColumnasPar);
                else
                    $this->excel->getActiveSheet()->getStyle("A$lugar:I$lugar")->applyFromArray($estiloColumnasImpar);
                $lugar++;
            }
            $lugar++;
        }

        $this->excel->getActiveSheet()->getColumnDimension("D")->setWidth("25");
        $this->excel->getActiveSheet()->getColumnDimension("E")->setWidth("25");

        for($i = 'A'; $i <= 'I'; $i++){
            if ($i != 'D' && $i != 'E')
            $this->excel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(true);
        }

        
        $filename = "Reporte de compras ".date('Y-m-d').".xls"; //save our workbook as this file name
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0"); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');
    }
    
    public function filtroTienda() {
        $monthf = date('m');
        $yearf = date('Y');
        $monthi = date('m');
        $yeari = date('Y');
        //date('Y-m-d', mktime(0,0,0, $monthf, $dayf, $yearf))
        
        $this->load->library('layout', 'layout');
        $data['fecha_inicio'] = '';
        $data['fecha_fin'] = '';

        if (isset($_POST['reporte'])) {
            $data['fecha_inicio'] = $_POST['fecha_inicio'];
            $data['fecha_fin'] = $_POST['fecha_fin'];
            $data['resumen'] = $this->ventas_model->ventas_por_tienda_resumen($data['fecha_inicio'], $data['fecha_fin']);
            $data['mensual'] = $this->ventas_model->ventas_por_tienda_mensual($data['fecha_inicio'], $data['fecha_fin']);
            $data['anual'] = $this->ventas_model->ventas_por_tienda_anual($data['fecha_inicio'], $data['fecha_fin']);
        }
         
        $this->layout->view('reportes/ventas_por_tienda', $data);
    }

    public function filtroMarca() {
        $this->load->library('layout', 'layout');
        $data['fecha_inicio'] = '';
        $data['fecha_fin'] = '';

        if (isset($_POST['reporte'])) {
            $data['fecha_inicio'] = $_POST['fecha_inicio'];
            $data['fecha_fin'] = $_POST['fecha_fin'];
            $data['resumen'] = $this->ventas_model->ventas_por_marca_resumen($data['fecha_inicio'], $data['fecha_fin']);
            $data['mensual'] = $this->ventas_model->ventas_por_marca_mensual($data['fecha_inicio'], $data['fecha_fin']);
            $data['anual'] = $this->ventas_model->ventas_por_marca_anual($data['fecha_inicio'], $data['fecha_fin']);
        }
        $this->layout->view('reportes/ventas_por_marca', $data);
    }

    public function filtroMarcaExcel($fechai = NULL, $fechaf = NULL) {
        $fechaI = explode("-", $fechai);
        $fechaF = explode("-", $fechaf);
        $f_ini = ($fechai == NULL) ? date("Y-").date("m-")."-01" : "$fechai";
        $f_fin = ($fechaF == NULL) ? date('Y-m-d') : "$fechaf";

            $resumen = $this->ventas_model->ventas_por_marca_resumen($f_ini, $f_fin);
            $mensual = $this->ventas_model->ventas_por_marca_mensual($f_ini, $f_fin);
            $anual = $this->ventas_model->ventas_por_marca_anual($f_ini, $f_fin);

        $this->load->library('Excel');
        $hoja = 0;
        $this->excel->setActiveSheetIndex($hoja);
        $this->excel->getActiveSheet()->setTitle('Ventas Por MARCA');
        
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
                                                    'color' => array( 'rgb' => "000000")
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
                                                    'color' => array( 'rgb' => "000000")
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

        ###########################################################################
        ###### HOJA 0 VENTAS POR MARCA
        ###########################################################################
            
            $this->excel->getActiveSheet()->getStyle("A1:E2")->applyFromArray($estiloTitulo);
            $this->excel->getActiveSheet()->getStyle("A3:E3")->applyFromArray($estiloColumnasTitulo);

            $this->excel->setActiveSheetIndex($hoja)->mergeCells('A1:E2')->setCellValue('A1', $_SESSION['nombre_empresa']);

            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('40');
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('18');
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth('18');
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth('18');
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth('18');
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth('18');

            $this->excel->setActiveSheetIndex($hoja)->mergeCells('A1:E2')->setCellValue('A1', $_SESSION['nombre_empresa']);
            $this->excel->setActiveSheetIndex($hoja)->mergeCells("A3:E3")->setCellValue("A3", "REPORTE DE VENTAS POR MARCA DESDE $f_ini HASTA $f_fin");
            
            $this->excel->setActiveSheetIndex($hoja)->setCellValue('A4', 'N');
            $this->excel->setActiveSheetIndex($hoja)->setCellValue('B4', 'MARCA');
            $this->excel->setActiveSheetIndex($hoja)->setCellValue('C4', 'FECHA DESDE');
            $this->excel->setActiveSheetIndex($hoja)->setCellValue('D4', 'FECHA HASTA');
            $this->excel->setActiveSheetIndex($hoja)->setCellValue('E4', 'VENTA');
            
            $lugar = 4;
            $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($estiloColumnasTitulo);
            
            $numeroS = 0;
            $lugar++;

            foreach($resumen as $col)
                $keys = array_keys($col);
            
            foreach($resumen as $indice => $valor){
                $numeroS += 1;
                $nombre = $valor[$keys[0]];
                $ventas = $valor[$keys[1]];

                $this->excel->setActiveSheetIndex($hoja)
                ->setCellValue('A'.$lugar, $numeroS)
                ->setCellValue('B'.$lugar, "$nombre")
                ->setCellValue('C'.$lugar, $f_ini)
                ->setCellValue('D'.$lugar, $f_fin)
                ->setCellValue('E'.$lugar, $ventas);

                if ($indice % 2 == 0)
                    $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($estiloColumnasPar);
                else
                    $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($estiloColumnasImpar);

                $lugar+=1;
            }

            $numeroS = 0;
            $lugar += 4;

            $this->excel->setActiveSheetIndex($hoja)->mergeCells("A$lugar:B$lugar")->setCellValue("A$lugar", "REPORTE MENSUAL");
            $this->excel->getActiveSheet()->getStyle("A$lugar:B$lugar")->applyFromArray($estiloColumnasTitulo);
            $ltituloMensual = $lugar;
            $lugar++;
            
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", "N");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar", "MARCA");
            #$this->excel->setActiveSheetIndex(0)->setCellValue("C$lugar", "VENTAS");
            $this->excel->getActiveSheet()->getStyle("A$lugar:B$lugar")->applyFromArray($estiloColumnasTitulo);

            foreach($mensual as $col)
                $keys = array_keys($col);

            $size = count($keys);
            $lcol = $lugar;
            $lugar++;

            foreach($mensual as $indice => $valor){ // listo todos los meses seleccionados
                for ($x = 1; $x < $size; $x++){
                    if ( strlen($keys[$x]) == 7  ) // Entre Octubre y diciembre son 7 caracteres por ello descuento del array $keys 2 caracteres y ese es el mes.
                        $mes = substr($keys[$x], -2);
                    else 
                        $mes = substr($keys[$x], -1);
                    
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue($this->lib_props->colExcel($x+2)."$lcol", $this->lib_props->mesesEs($mes));
                    $this->excel->getActiveSheet()->getStyle($this->lib_props->colExcel($x+2)."$lcol")->applyFromArray($estiloColumnasTitulo);
                    $this->excel->getActiveSheet()->getStyle($this->lib_props->colExcel($x+2)."$ltituloMensual")->applyFromArray($estiloColumnasTitulo);
                }
            }
            
            foreach($mensual as $indice => $valor){
                $numeroS += 1;
                $nombre = $valor[$keys[0]];
                
                if ($indice % 2 == 0)
                    $this->excel->getActiveSheet()->getStyle("A$lugar:B$lugar")->applyFromArray($estiloColumnasPar);
                else
                    $this->excel->getActiveSheet()->getStyle("A$lugar:B$lugar")->applyFromArray($estiloColumnasImpar);


                for ($x = 1; $x < $size; $x++){ // 1 posicion de array donde inician ventas
                    if ( $valor[$keys[$x]] != "" ){
                        $ventas = $valor[$keys[$x]];
                        $this->excel->setActiveSheetIndex($hoja)->setCellValue($this->lib_props->colExcel($x+2)."$lugar", $ventas); // x + 2 posision donde inician ventas + iniciar en columna C
                        #break;

                        if ($indice % 2 == 0)
                            $this->excel->getActiveSheet()->getStyle($this->lib_props->colExcel($x+2)."$lugar")->applyFromArray($estiloColumnasPar);
                        else
                            $this->excel->getActiveSheet()->getStyle($this->lib_props->colExcel($x+2)."$lugar")->applyFromArray($estiloColumnasImpar);
                    }
                }

                $this->excel->setActiveSheetIndex($hoja)->setCellValue('A'.$lugar, $numeroS)->setCellValue('B'.$lugar, "$nombre");
                $lugar+=1;
            }

            $numeroS = 0;
            $lugar += 4;
            $this->excel->getActiveSheet()->getStyle("A$lugar:B$lugar")->applyFromArray($estiloColumnasTitulo);
            $this->excel->setActiveSheetIndex($hoja)->mergeCells("A$lugar:C$lugar")->setCellValue("A$lugar", "REPORTE ANUAL");
            $lugar++;

            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", "N");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar", "MARCA");
            $this->excel->getActiveSheet()->getStyle("A$lugar:B$lugar")->applyFromArray($estiloColumnasTitulo);
            $ltituloMensual = $lugar;
            
            foreach($anual as $col)
                $keys = array_keys($col); // obtengo las llaves

            $size = count($keys);
            $lcol = $lugar;
            $lugar++;

            foreach($anual as $indice => $valor){ // listo todos los años seleccionados
                for ($x = 1; $x < $size; $x++){
                    $anio = substr($keys[$x], 1); // obtengo el año
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue($this->lib_props->colExcel($x+2)."$lcol",$anio);
                    $this->excel->getActiveSheet()->getStyle($this->lib_props->colExcel($x+2)."$lcol")->applyFromArray($estiloColumnasTitulo);
                    $this->excel->getActiveSheet()->getStyle($this->lib_props->colExcel($x+2)."$ltituloMensual")->applyFromArray($estiloColumnasTitulo);
                }
            }
            
            foreach($anual as $indice => $valor){
                $numeroS += 1;
                $nombre = $valor[$keys[0]];

                if ($indice % 2 == 0)
                    $this->excel->getActiveSheet()->getStyle("A$lugar:B$lugar")->applyFromArray($estiloColumnasPar);
                else
                    $this->excel->getActiveSheet()->getStyle("A$lugar:B$lugar")->applyFromArray($estiloColumnasImpar);

                for ($x = 1; $x < $size; $x++){ // 1 posicion de array donde inician ventas
                    if ( $valor[$keys[$x]] != "" ){
                        $ventas = $valor[$keys[$x]];
                        $this->excel->setActiveSheetIndex($hoja)->setCellValue($this->lib_props->colExcel($x+2)."$lugar", $ventas); // x + 2 posision donde inician ventas + iniciar en columna C
                        #break;
                        if ($indice % 2 == 0)
                            $this->excel->getActiveSheet()->getStyle($this->lib_props->colExcel($x+2)."$lugar")->applyFromArray($estiloColumnasPar);
                        else
                            $this->excel->getActiveSheet()->getStyle($this->lib_props->colExcel($x+2)."$lugar")->applyFromArray($estiloColumnasImpar);
                    }
                }

                $this->excel->setActiveSheetIndex($hoja)->setCellValue('A'.$lugar, $numeroS)->setCellValue('B'.$lugar, "$nombre");
                $lugar+=1;
            }

        ###########################################################################
        ###### HOJA 1 VENTAS POR MARCA SEGUN VENDEDOR
        ###########################################################################
            $marcasInfo = $this->ventas_model->ventas_por_marca_de_vendedor($f_ini, $f_fin);
            $col = count($marcasInfo[0]);
            $split = $col - intval( $col / 2 ) + 2;
            $colE = $this->lib_props->colExcel( $split );
            $size = count($marcasInfo);
            
            $hoja++;
            $this->excel->createSheet($hoja);
            $this->excel->setActiveSheetIndex($hoja); //Seleccionar la pestaña deseada
            $this->excel->getActiveSheet()->setTitle('Ventas por marca Segun Vendedor'); //Establecer nombre

            $this->excel->getActiveSheet()->getStyle('A1:'.$colE.'2')->applyFromArray($estiloTitulo);
            $this->excel->getActiveSheet()->getStyle('A3:'.$colE.'3')->applyFromArray($estiloColumnasTitulo);

            $this->excel->setActiveSheetIndex($hoja)->mergeCells('A1:'.$colE.'2')->setCellValue('A1', $_SESSION['nombre_empresa']);
            $this->excel->setActiveSheetIndex($hoja)->mergeCells('A3:'.$colE.'3')->setCellValue("A3", "REPORTE DE VENTAS POR MARCA SEGUN VENDEDOR. DESDE $f_ini HASTA $f_fin");

            $numeroS = 0;
            $lugar = 4;
            
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", "N");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar", "MARCA");

            $lugarT = $lugar;
            
            $this->excel->getActiveSheet()->getStyle("A$lugar:$colE$lugar")->applyFromArray($estiloColumnasTitulo);
            $lugar++;

            foreach($marcasInfo as $nCol)
                $keys = array_keys($nCol); // obtengo las llaves

            for ($x = 0; $x < $size; $x++){
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", $x + 1);
                $vendedor = 0;
                for ($j = 0; $j < $col; $j++) {

                    if ( $keys[$j] != "vendedor".$vendedor ){
                            $this->excel->setActiveSheetIndex($hoja)->setCellValue($this->lib_props->colExcel( $j + 2 - $vendedor)."$lugar", $marcasInfo[$x][ $keys[$j] ] );
                    }
                    
                    if ( $keys[$j] == "vendedor".$vendedor )
                        $vendedor++;

                    if ( $x == 0 )
                        $this->excel->setActiveSheetIndex($hoja)->setCellValue($this->lib_props->colExcel( $j + 3 )."$lugarT", $marcasInfo[$x]["vendedor$j"] );

                }

                $this->excel->setActiveSheetIndex($hoja)->setCellValue("$colE$lugarT", "TOTAL" );

                if ($x % 2 == 0)
                    $this->excel->getActiveSheet()->getStyle("A$lugar:$colE$lugar")->applyFromArray($estiloColumnasPar);
                else
                    $this->excel->getActiveSheet()->getStyle("A$lugar:$colE$lugar")->applyFromArray($estiloColumnasImpar);

                $lugar++;
            }

            for ($i = "B"; $i <= $colE; $i++)
                $this->excel->getActiveSheet()->getColumnDimension($i)->setWidth('20');


        $filename = "Ventas por MARCA desde ".$f_ini." hasta ".$f_fin.".xls"; //save our workbook as this file name

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0"); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');
        #$this->layout->view('reportes/ventas_por_vendedor', $data);
    }

    public function filtroFamilia() {
        $this->load->library('layout', 'layout');
        $data['fecha_inicio'] = '';
        $data['fecha_fin'] = '';

        if (isset($_POST['reporte'])) {
            $data['fecha_inicio'] = $_POST['fecha_inicio'];
            $data['fecha_fin'] = $_POST['fecha_fin'];
            $data['resumen'] = $this->ventas_model->ventas_por_familia_resumen($data['fecha_inicio'], $data['fecha_fin']);
            $data['mensual'] = $this->ventas_model->ventas_por_familia_mensual($data['fecha_inicio'], $data['fecha_fin']);
            $data['anual'] = $this->ventas_model->ventas_por_familia_anual($data['fecha_inicio'], $data['fecha_fin']);
        }
        $this->layout->view('reportes/ventas_por_familia', $data);
    }

    public function filtroFamiliaExcel($fechai = NULL, $fechaf = NULL) {
        #$this->load->library('layout', 'layout');
        $fechaI = explode("-", $fechai);
        $fechaF = explode("-", $fechaf);
        #$f_ini = ($fechaI == NULL) ? date("Y-").date("m-")."-01" : "$fechaI[2]-$fechaI[1]-$fechaI[0]";
        $f_ini = ($fechai == NULL) ? date("Y-").date("m-")."-01" : "$fechai";
        #$f_fin = ($fechaF == NULL) ? date('Y-m-d') : "$fechaF[5]-$fechaF[4]-$fechaF[3]";
        $f_fin = ($fechaF == NULL) ? date('Y-m-d') : "$fechaf";

            $resumen = $this->ventas_model->ventas_por_familia_resumen($f_ini, $f_fin);
            $mensual = $this->ventas_model->ventas_por_familia_mensual($f_ini, $f_fin);
            $anual = $this->ventas_model->ventas_por_familia_anual($f_ini, $f_fin);
        
        $this->load->library('Excel');
        
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Ventas Por Familia');
        
        $TipoFont = array( 'font'  => array( 'bold'  => false, 'color' => array('rgb' => '000000'), 'size'  => 14, 'name'  => 'Calibri'));
        $TipoFont2 = array( 'font'  => array( 'bold'  => false, 'color' => array('rgb' => '000000'), 'size'  => 12, 'name'  => 'Calibri'));
        $style = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $style2 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $this->excel->getActiveSheet()->getStyle('A1:N1')->applyFromArray($TipoFont);
        $this->excel->getActiveSheet()->getStyle('A1:N1')->applyFromArray($style);

        $this->excel->getActiveSheet()->getStyle('A3:N3')->applyFromArray($TipoFont);
        $this->excel->getActiveSheet()->getStyle("A3:N3")->applyFromArray($style);

        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('40');
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('18');
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth('18');
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth('18');
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth('18');
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth('18');

        $this->excel->setActiveSheetIndex(0)->mergeCells('A1:E2')->setCellValue('A1', $_SESSION['nombre_empresa']);
        
        $this->excel->getActiveSheet()->getStyle("A3:E3")->applyFromArray($TipoFont2);
        $this->excel->getActiveSheet()->getStyle("A3:E3")->applyFromArray($style2);
        $this->excel->setActiveSheetIndex(0)->mergeCells("A3:E3")->setCellValue("A3", "REPORTE DE VENTAS POR FAMILIA DESDE $f_ini HASTA $f_fin");
        
        $this->excel->setActiveSheetIndex(0)->setCellValue('A4', 'N');
        $this->excel->setActiveSheetIndex(0)->setCellValue('B4', 'FAMILIA');
        $this->excel->setActiveSheetIndex(0)->setCellValue('C4', 'FECHA DESDE');
        $this->excel->setActiveSheetIndex(0)->setCellValue('D4', 'FECHA HASTA');
        $this->excel->setActiveSheetIndex(0)->setCellValue('E4', 'VENTA');
    
        #$this->excel->setActiveSheetIndex(0);
        $numeroS = 0;
        $lugar = 5;

        foreach($resumen as $col)
            $keys = array_keys($col);
        
        foreach($resumen as $indice => $valor){
            $numeroS += 1;
            $nombre = $valor[$keys[0]];
            $ventas = $valor[$keys[1]];

            $this->excel->setActiveSheetIndex(0)
            ->setCellValue('A'.$lugar, $numeroS)
            ->setCellValue('B'.$lugar, "$nombre")
            ->setCellValue('C'.$lugar, $f_ini)
            ->setCellValue('D'.$lugar, $f_fin)
            ->setCellValue('E'.$lugar, $ventas);
            $lugar+=1;    
        }

        $numeroS = 0;
        $lugar += 4;
        $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($TipoFont2);
        $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($style2);
        $this->excel->setActiveSheetIndex(0)->mergeCells("A$lugar:E$lugar")->setCellValue("A$lugar", "REPORTE MENSUAL");
        $lugar++;
        $this->excel->setActiveSheetIndex(0)->setCellValue("A$lugar", "N");
        $this->excel->setActiveSheetIndex(0)->setCellValue("B$lugar", "FAMILIA");
        #$this->excel->setActiveSheetIndex(0)->setCellValue("C$lugar", "VENTAS");

        foreach($mensual as $col)
            $keys = array_keys($col);

        $size = count($keys);
        $lcol = $lugar;
        $lugar++;

        foreach($mensual as $indice => $valor){ // listo todos los meses seleccionados
            for ($x = 1; $x < $size; $x++){
                if ( strlen($keys[$x]) == 7  ) // Entre Octubre y diciembre son 7 caracteres por ello descuento del array $keys 2 caracteres y ese es el mes.
                    $mes = substr($keys[$x], -2);
                else 
                    $mes = substr($keys[$x], -1);
                
                $this->excel->setActiveSheetIndex(0)->setCellValue($this->lib_props->colExcel($x+2)."$lcol", $this->lib_props->mesesEs($mes));
            }
        }
        
        foreach($mensual as $indice => $valor){
            $numeroS += 1;
            $nombre = $valor[$keys[0]];

            for ($x = 1; $x < $size; $x++){ // 1 posicion de array donde inician ventas
                if ( $valor[$keys[$x]] != "" ){
                    $ventas = $valor[$keys[$x]];
                    $this->excel->setActiveSheetIndex(0)->setCellValue($this->lib_props->colExcel($x+2)."$lugar", $ventas); // x + 2 posision donde inician ventas + iniciar en columna C
                    #break;
                }
            }

            $this->excel->setActiveSheetIndex(0)
            ->setCellValue('A'.$lugar, $numeroS)
            ->setCellValue('B'.$lugar, "$nombre");
            $lugar+=1;
        }

        $numeroS = 0;
        $lugar += 4;
        $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($TipoFont2);
        $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($style2);
        $this->excel->setActiveSheetIndex(0)->setCellValue("A$lugar", "REPORTE ANUAL");
        $lugar++;
        $this->excel->setActiveSheetIndex(0)->setCellValue("A$lugar", "N");
        $this->excel->setActiveSheetIndex(0)->setCellValue("B$lugar", "FAMILIA");
        
        foreach($anual as $col)
            $keys = array_keys($col); // obtengo las llaves

        $size = count($keys);
        $lcol = $lugar;
        $lugar++;

        foreach($anual as $indice => $valor){ // listo todos los años seleccionados
            for ($x = 1; $x < $size; $x++){
                $anio = substr($keys[$x], 1); // obtengo el año
                $this->excel->setActiveSheetIndex(0)->setCellValue($this->lib_props->colExcel($x+2)."$lcol",$anio);
            }
        }
        

        foreach($anual as $indice => $valor){
            $numeroS += 1;
            $nombre = $valor[$keys[0]];

            for ($x = 1; $x < $size; $x++){ // 1 posicion de array donde inician ventas
                if ( $valor[$keys[$x]] != "" ){
                    $ventas = $valor[$keys[$x]];
                    $this->excel->setActiveSheetIndex(0)->setCellValue($this->lib_props->colExcel($x+2)."$lugar", $ventas); // x + 2 posision donde inician ventas + iniciar en columna C
                    #break;
                }
            }

            $this->excel->setActiveSheetIndex(0)
            ->setCellValue('A'.$lugar, $numeroS)
            ->setCellValue('B'.$lugar, "$nombre");
            $lugar+=1;
        }

        $filename = "Ventas por Familia desde ".$f_ini." hasta ".$f_fin.".xls"; //save our workbook as this file name

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0"); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');
        #$this->layout->view('reportes/ventas_por_vendedor', $data);
    }

    public function filtroProducto() {
        $this->load->library('layout', 'layout');
        $data['fecha_inicio'] = '';
        $data['fecha_fin'] = '';

        if (isset($_POST['reporte'])) {
            $data['fecha_inicio'] = $_POST['fecha_inicio'];
            $data['fecha_fin']  = $_POST['fecha_fin'];
            $data['resumen']    = $this->ventas_model->ventas_por_producto_resumen($data['fecha_inicio'], $data['fecha_fin']);
            $data['mensual']    = $this->ventas_model->ventas_por_producto_mensual($data['fecha_inicio'], $data['fecha_fin']);
            $data['anual']      = $this->ventas_model->ventas_por_producto_anual($data['fecha_inicio'], $data['fecha_fin']);
        }
        $this->layout->view('reportes/ventas_por_producto', $data);
    }
    
    public function Producto_stock() {
        $this->load->library('layout', 'layout');
     
        $listado_productos = $this->ventas_model->producto_stock();
        
        if(count($listado_productos)>0){
            foreach($listado_productos as $indice=>$valor){
                $nombre = $valor->PROD_Nombre;
                $fecha = $valor->fecha;
                $dias = $valor->dias;
                $lista[] = array($nombre,$fecha,$dias);
            }
        }
        $data['lista'] = $lista;
        $this->layout->view('reportes/producto_stock', $data);
    }
    
    public function filtroDiario() {
        $this->load->library('layout', 'layout');
        $data['fecha_inicio'] = '';
        $data['fecha_fin'] = '';

        if (isset($_POST['reporte'])) {
            $data['fecha_inicio'] = $_POST['fecha_inicio'];
            $data['fecha_fin'] = $_POST['fecha_fin'];
            $data['resumen'] = $this->ventas_model->ventas_por_dia($data['fecha_inicio'], $data['fecha_fin']);
        }
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->layout->view('reportes/ventas_por_dia', $data);
    }
    
    //FUNCION CREADO POR EL DESARROLLADOR ALDO
    public function ventasDiarias_pdf($date, $user){
        $compania = $this->somevar['compania'];
        $dailySalesReceipt = $this->ventas_model->ventasDiarioC($date, $compania);
        $num = 95;
        $db_data1 = array();
        foreach ($dailySalesReceipt as $value) {
            $db_data1[] = array(
                'cols1' => utf8_decode($value->CPC_Serie . "-" . $value->CPC_Numero)
            );
        }
        foreach ($db_data1 as $item) {
            $item['cols1'];
            $num = $num + 5;
        }
        $medidas = array(80, $num);
        $this->pdf = new tcpdf('P', 'mm', $medidas, true, 'UTF-8', false);
        $this->pdf->SetMargins(3, 3, 3);
        $this->pdf->SetAutoPageBreak(false);
        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);
        $this->pdf->SetFont('helvetica', '', 7);
        $this->pdf->AddPage();
        $compania = $this->somevar['compania'];
        $fecha_generacion = date("d-m-Y H:i:s");
        $usuario = $user;
        $tipo_doc = "";
        $dailySalesReceipt = $this->ventas_model->ventasDiarioC($date, $compania);
        $dailySalesNote = $this->ventas_model->ventasDiarioN($date, $compania);
        $totalDaily = $this->ventas_model->ventasTotal($date, $compania);
        $lista = $this->ventas_model->ventas_diarios($tipo_doc, $fecha_generacion);

        // $this->pdf->MultiCell(0, 5, utf8_decode("RONDON GRADOS JOSE ISRAEL"), 0, 'C', false);
        // $this->pdf->MultiCell(0, 5, utf8_decode("RUC 10102442623"), 0, 'C', false);
        // $this->pdf->MultiCell(0, 5, utf8_decode("Santa Anita"), 0, 'C', false);
        // $this->pdf->MultiCell(0, 5, utf8_decode("EL AGUSTINO - LIMA - LIMA"), 0, 'C', false);

        $this->pdf->MultiCell(0, 5, utf8_decode(""), 0, 'C', false);
        $this->pdf->MultiCell(0, 1, utf8_decode("VENTA DEL DIA"), 0, 'C', false);
        $this->pdf->Ln(1);
        $this->pdf->Cell(0,5,utf8_decode("------------------------------------------------------------------------------------------"),0,0,'C');
        $this->pdf->Ln(4);
        $this->pdf->Cell(36,2,utf8_decode("FECHA DE GENERACION"),0,0,'C');
        $this->pdf->Cell(40,2,utf8_decode("USUARIO"),0,0,'C');
        $this->pdf->Ln(1);
        $this->pdf->Cell(0,5,utf8_decode("------------------------------------------------------------------------------------------"),0,0,'C');
        $this->pdf->Ln(3);

        $this->pdf->Cell(36,4,utf8_decode($fecha_generacion),0,0,'C');
        $this->pdf->Cell(40,4,utf8_decode($user),0,0,'C');

        $this->pdf->Ln(4);
        $this->pdf->Cell(0,5,utf8_decode("------------------------------------------------------------------------------------------"),0,0,'C');
        $this->pdf->Ln(4);
        $this->pdf->Cell(22,2,utf8_decode("N COMPROBANTE"),0,0,'C');
        $this->pdf->Cell(19,2,utf8_decode("MONTO"),0,0,'C');
        $this->pdf->Cell(15,2,utf8_decode("METODO PAGO"),0,0,'C');
        $this->pdf->Cell(25,2,utf8_decode("ESTADO"),0,0,'C');
        $this->pdf->Ln(1);
        $this->pdf->Cell(0,5,utf8_decode("------------------------------------------------------------------------------------------"),0,0,'C');
        $this->pdf->Ln(5);

        $db_data1 = array();
        foreach ($dailySalesReceipt as $value) {
            $db_data1[] = array(
                'cols1' => utf8_decode($value->CPC_Serie . "-" . $value->CPC_Numero),
                'cols2' => utf8_decode($value->CPC_total . " S/"),
                'cols3' => utf8_decode($value->FORPAC_Descripcion),
                'cols4' => utf8_decode($value->Estado),
            );
        }
        foreach ($db_data1 as $row) {
            $this->pdf->Cell(18, 2, $row['cols1'], 0, 0, 'C');
            $this->pdf->Cell(19, 2, $row['cols2'], 0, 0, 'C');
            $this->pdf->Cell(15, 2, $row['cols3'], 0, 0, 'C');
            $this->pdf->Cell(28, 2, $row['cols4'], 0, 1, 'C');
        }
        $this->pdf->Ln(1);
        $this->pdf->Cell(0,5,utf8_decode("------------------------------------------------------------------------------------------"),0,0,'C');
        $this->pdf->Ln(4);
        $this->pdf->Cell(22,2,utf8_decode("N NOTA CREDITO"),0,0,'C');
        $this->pdf->Cell(19,2,utf8_decode("MONTO"),0,0,'C');
        $this->pdf->Cell(15,2,utf8_decode("METODO PAGO"),0,0,'C');
        $this->pdf->Cell(25,2,utf8_decode("ESTADO"),0,0,'C');
        $this->pdf->Ln(1);
        $this->pdf->Cell(0,5,utf8_decode("------------------------------------------------------------------------------------------"),0,0,'C');
        $this->pdf->Ln(5);
        $db_data2 = array();
        foreach ($dailySalesNote as $value) {
            $db_data2[] = array(
                'cols11' => $value->CRED_Serie."-".$value->CRED_Numero,
                'cols21' => $value->CRED_total." "."S/",
                'cols31' => $value->FORPAC_Descripcion,
                'cols41' => $value->Estado,
            );
        }
        foreach ($db_data2 as $row) {
            $this->pdf->Cell(18, 2, $row['cols11'], 0, 0, 'C');
            $this->pdf->Cell(19, 2, $row['cols21'], 0, 0, 'C');
            $this->pdf->Cell(15, 2, $row['cols31'], 0, 0, 'C');
            $this->pdf->Cell(28, 2, $row['cols41'], 0, 1, 'C');
        }
        $this->pdf->Ln(1);
        $this->pdf->Cell(0,5,utf8_decode("------------------------------------------------------------------------------------------"),0,0,'C');
        $this->pdf->Ln(4);
        $this->pdf->Cell(36,2,utf8_decode("DESCRIPCION"),0,0,'C');
        $this->pdf->Cell(40,2,utf8_decode("TOTAL"),0,0,'C');
        $this->pdf->Ln(1);
        $this->pdf->Cell(0,5,utf8_decode("------------------------------------------------------------------------------------------"),0,0,'C');
        $this->pdf->Ln(5);

        $total = 0;
        $letter = 'A';
        $db_data3 = array();
        foreach($totalDaily as $value){
            $db_data3[] = array(
                'cols13' => $value->FORPAC_Descripcion,
                'cols23' => $value->Total." "."S/"
            );
            $total+=$value->Total;
        }
        foreach ($db_data3 as $row) {
            $this->pdf->Cell(36, 2, utf8_decode($row['cols13']), 0, 0, 'C');
            $this->pdf->Cell(40, 2, utf8_decode($row['cols23']), 0, 1, 'C');
        }
        $this->pdf->Ln(1);
        $this->pdf->Cell(0,5,utf8_decode("------------------------------------------------------------------------------------------"),0,0,'C');
        $this->pdf->Ln(4);
        $this->pdf->Cell(36,2,utf8_decode("TOTAL"),0,0,'C');
        $this->pdf->Ln(1);
        $this->pdf->Cell(0,5,utf8_decode("------------------------------------------------------------------------------------------"),0,0,'C');
        $this->pdf->Ln(5);
        $total = 0;
        $db_data4 = array();
        foreach ($totalDaily as $value) {
          $total += $value->Total;
        }
        $db_data4[] = array(
             'cols24' => $total." "."S/"
        );
        foreach ($db_data4 as $row) {
            $this->pdf->Cell(36, 2, utf8_decode($row['cols24']), 0, 1, 'C');
        }
        $this->pdf->Output("", true);
    }

    public function ventasDiarias($date, $user)
	{
        $compania = $this->somevar['compania'];

		error_reporting(0);

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
				'color' => array('argb' => 'ECF0F1')
			),
			'alignment' =>  array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'          => TRUE
			)
		);

        $estiloColumnasDenegada = array(
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
				'color' => array('argb' => 'F8DE22')
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
        
        $dailySalesReceipt = $this->ventas_model->ventasDiarioC($date, $compania);
        $dailySalesNote = $this->ventas_model->ventasDiarioN($date, $compania);
        $totalDaily = $this->ventas_model->ventasTotal($date, $compania);

		$this->excel->setActiveSheetIndex($hoja);


		$lugar = 1;
		$this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "Fecha Generación");
		$this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  date("d-m-Y H:i:s"));
		$lugar = 2;
		$this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "Usuario");
		$this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $user);

		$lugar = 4;
        $this->excel->setActiveSheetIndex(0)
        ->setCellValue("A$lugar", "N° COMPROBANTE")
        ->setCellValue("B$lugar", "MONTO")
        ->setCellValue("C$lugar", "METODO DE PAGO")
        ->setCellValue("D$lugar", "ESTADO");

        $this->excel->getActiveSheet()->getStyle("A$lugar:D$lugar")->applyFromArray($estiloColumnasTitulo);


        $lugar = 5;
        foreach($dailySalesReceipt as $value){
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  $value->CPC_Serie."-".$value->CPC_Numero);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $value->CPC_total);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  $value->FORPAC_Descripcion);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  $value->Estado);
            if ($value->Estado == 'Denegado'){
                $this->excel->getActiveSheet()->getStyle("A$lugar:D$lugar")->applyFromArray($estiloColumnasDenegada);
            }else if($value->Estado == 'Anulado'){
                $this->excel->getActiveSheet()->getStyle("A$lugar:D$lugar")->applyFromArray($estiloColumnasDenegada);
            }
            $lugar++;
        }

        $lugar+=2;
        $this->excel->setActiveSheetIndex(0)
        ->setCellValue("A$lugar", "N° NOTA DE CREDITO")
        ->setCellValue("B$lugar", "MONTO")
        ->setCellValue("C$lugar", "METODO DE PAGO")
        ->setCellValue("D$lugar", "ESTADO");
        $this->excel->getActiveSheet()->getStyle("A$lugar:D$lugar")->applyFromArray($estiloColumnasTitulo);

        $lugar++;

        foreach($dailySalesNote as $value){
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  $value->CRED_Serie."-".$value->CRED_Numero);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $value->CRED_total);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  $value->FORPAC_Descripcion);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  $value->Estado);
            if ($value->Estado == 'Denegado'){
                $this->excel->getActiveSheet()->getStyle("A$lugar:D$lugar")->applyFromArray($estiloColumnasDenegada);
            }
            $lugar++;
        }

        $lugar+=2;

        $total = 0;
        $letter = 'A';
        foreach($totalDaily as $value){
            $this->excel->setActiveSheetIndex(0)->setCellValue($letter.$lugar, $value->FORPAC_Descripcion);
            $this->excel->getActiveSheet()->getStyle($letter.$lugar)->applyFromArray($estiloColumnasTitulo);
            $lugar++;
            $this->excel->setActiveSheetIndex(0)->setCellValue($letter.$lugar, $value->Total);
            $letter++;
            $lugar--;
            $total+=$value->Total;
        }

        $lugar+=3;
        $this->excel->setActiveSheetIndex(0)->setCellValue("A".$lugar, "TOTAL");
        $this->excel->getActiveSheet()->getStyle("A".$lugar)->applyFromArray($estiloColumnasTitulo);
        $this->excel->setActiveSheetIndex(0)->setCellValue("B".$lugar, $total);

        for ($i = "A"; $i <= "H"; $i++){
            $this->excel->getActiveSheet()->getColumnDimension($i)->setWidth("20");
        }

		$f = date("YmdHis");
		$filename = "Reporte_Pagos_" . $f . ".xls";
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;filename=$filename");
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		$objWriter->save('php://output');
	}

    public function ventasdiario($tipo = 'F') {

        $this->load->library('layout', 'layout');
        $hoy = date('Y-m-d');
        $data['titulo'] = "Ventas Diarias";
        $data['tipo_docu'] = $tipo;
        $data['titulo_tabla'] = "Ventas del dia";
        $data['lista'] = $this->ventas_model->ventas_diarios($tipo, $hoy);
        $data['fecha'] = $hoy;

        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->layout->view('reportes/ventas_diarios', $data);
    }

    public function ejecutarAjax(){
        $tipo_oper = $this->input->post('tipo_oper');
        $tipo = $this->input->post('tipo_doc');
        $mes = $this->input->post('mes');
        $anio = $this->input->post('anio');
        
        $lista = $this->ventas_model->registro_ventas($tipo_oper, $tipo, $mes, $anio); 
        $RetornarTable = "";
        $RetornarTable .= '<table class="fuente8 tableReporte" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                            <tr class="cabeceraTabla ">
                            <td width="10%">FEHCA DE EMISION</td>
                            <td width="7%">TIPO</td>
                            <td width="5%">SERIE</td>
                            <td width="5%">NUMERO</td>
                            <td width="10%">NOMBRE Y/O RAZON SOCIAL</td>
                            <td width="5%">RUC</td>
                            <td width="5%">VALOR VENTA</td>
                            <td width="5%">I.G.V</td>
                            <td width="5%">TOTAL IMPORTE</td>
                            </tr>';

        if(count($lista)>0){
            $valor_ventaS = 0;
            $valor_igvS = 0;
            $valor_totalS =0;
            $valor_ventaD = 0;
            $valor_igvD = 0;
            $valor_totalD =0;

            foreach ($lista as $indice => $valor) {
                $fecha = $valor->CPC_Fecha;
                $tipo = $valor->CPC_TipoDocumento;
                $serie = $valor->CPC_Serie;
                $numero = $valor->CPC_Numero;
                $flag = $valor->CPC_FlagEstado;
                $tipo_persona = $valor->CLIC_TipoPersona;
                $tipo_proveedor = $valor->PROVC_TipoPersona;
                $tipo_Moneda=$valor->MONED_Simbolo;
                $cod_Moneda=$valor->MONED_Codigo;
                if ($flag == 1) {
                    $venta = $valor->CPC_subtotal;
                    $igv = $valor->CPC_igv;
                    $total = $valor->CPC_total;

                   if($cod_Moneda==1){
                    $valor_ventaS += $venta;
                    $valor_igvS += $igv;
                    $valor_totalS +=$total;}
                    if($cod_Moneda==2){
                    $valor_ventaD += $venta;
                    $valor_igvD += $igv;
                    $valor_totalD +=$total;}    
                    
                    
                    if ($tipo_oper == 'V') {
                        if ($tipo_persona == '0') {
                            $nombre = $valor->PERSC_Nombre . " " . $valor->PERSC_ApellidoPaterno . " " . $valor->PERSC_ApellidoMaterno;
                            $ruc = $valor->PERSC_Ruc;
                        } else {
                            $nombre = $valor->EMPRC_RazonSocial;
                            $ruc = $valor->EMPRC_Ruc;
                        }
                    } else {
                        if ($tipo_proveedor == '0') {
                            $nombre = $valor->PERSC_Nombre . " " . $valor->PERSC_ApellidoPaterno . " " . $valor->PERSC_ApellidoMaterno;
                            $ruc = $valor->PERSC_Ruc;
                        } else {
                            $nombre = $valor->EMPRC_RazonSocial;
                            $ruc = $valor->EMPRC_Ruc;
                        }
                    }
                }
                else {

                    $nombre = "ANULADO";
                    $ruc = "";
                    $venta = "";
                    $igv = "";
                    $total = "";
                }

                $RetornarTable.='<tr>
                <td><div align="center">'.$fecha.'</div></td>
                <td><div align="left">';
                
                if ($tipo == 'F')
                    $RetornarTable .= "Factura";
                else
                    if($tipo == 'B')
                        $RetornarTable.="Boleta";
                else
                    if($tipo == 'N')
                        $RetornarTable.="Comprobante";

                $RetornarTable .= '</div></td>';
                $RetornarTable .= '<td><div align="center">'.$serie.'</div></td>
                    <td><div align="center">'.$numero.'</div></td>
                    <td><div align="center">'.$nombre.'</div></td>
                    <td><div align="center">'.$ruc.'</div></td>';
                $RetornarTable .= '<td><div align="center">'.$valor_ventaS.'</div></td><td><div align="center">'.$valor_igvS.'</div></td>
                                    <td><div align="center">S/.'.number_format($valor_totalS, 2).'</div></td> ';
            }
        }
        else {
            $RetornarTable .= '<table width="100%" cellspacing="0" cellpadding="3" border="0" class="fuente8">
                                    <tbody>
                                        <tr>
                                            <td width="100%" class="mensaje">No hay ning&uacute;n registro que cumpla con los criterios de b&uacute;squeda</td>
                                        </tr>
                                    </tbody>
                                </table>';
        }

        echo $RetornarTable;
    }

    public function ventasdiario_fecha($tipo = 'F', $hoy) {
        $this->load->library('layout', 'layout');
        $data['titulo'] = "Ventas Diarias";
        $data['tipo_docu'] = $tipo;
        $data['titulo_tabla'] = "Ventas del dia";
        $data['lista'] = $this->ventas_model->ventas_diarios($tipo, $hoy);
        $data['fecha'] = $hoy;

        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->layout->view('reportes/ventas_diarios', $data);
    }

    public function ventas_pdf($tipo_doc = "F", $hoy) {

        if ($tipo_doc == "F")
            $titulo = "REPORTE FACTURAS";
        if ($tipo_doc == "B")
            $titulo = "REPORTE BOLETAS";
        if ($tipo_doc == "N")
            $titulo = "REPORTE COMPROBANTES";
        $lista = $this->ventas_model->ventas_diarios($tipo_doc, $hoy);
        $this->cezpdf = new Cezpdf('a4', 'landscape');
        $this->cezpdf->ezText(($titulo . "  DIARIO  "), 11, array("left" => 180));

        $this->cezpdf->ezText('', '');
        /* Listado de detalles */
        $db_data = array();
        $valor_venta = 0;
        $valor_igv = 0;
        $valor_total = 0;
        foreach ($lista as $indice => $valor) {
            $tipo = $valor->CPC_TipoDocumento;
            $tipo_persona = $valor->CLIC_TipoPersona;
            $flag = $valor->CPC_FlagEstado;
            $nombre = '';
            if ($flag == 1) {

                if ($tipo_doc != "F") {
                    $subtotal = number_format($valor->CPC_total / 1.18, 2);
                    $igv = number_format($subtotal * 0.18, 2);
                } else {
                    $igv = $valor->CPC_igv;
                    $subtotal = $valor->CPC_subtotal;
                }
                $total = $valor->CPC_total;
                $valor_venta +=$subtotal;
                $valor_igv +=$igv;
                $valor_total +=$total;


                if ($tipo_doc == 'F')
                    $nombre = 'Factura';
                else
                    $nombre = 'Boleta';

                if ($tipo_persona == '0') {
                    $nombre_cliente = $valor->PERSC_Nombre . " " . $valor->PERSC_ApellidoPaterno . " " . $valor->PERSC_ApellidoMaterno;
                    $ruc = $valor->PERSC_Ruc;
                } else {
                    $nombre_cliente = $valor->EMPRC_RazonSocial;
                    $ruc = $valor->EMPRC_Ruc;
                }
            } else {
                $nombre_cliente = "ANULADO";
                $ruc = "";
                $subtotal = "";
                $igv = "";
                $total = "";
            }

            $db_data[] = array(
                'cols1' => $valor->CPC_Fecha,
                'cols2' => $nombre,
                'cols3' => $valor->CPC_Serie,
                'cols4' => $valor->CPC_Numero,
                'cols5' => $nombre_cliente,
                'cols6' => $ruc,
                'cols7' => $subtotal,
                'cols8' => $igv,
                'cols9' => $total,
            );
        }
        $col_names = array(
            'cols1' => 'Fecha',
            'cols2' => 'Tipo',
            'cols3' => 'Serie',
            'cols4' => 'Numero',
            'cols5' => 'Cliente',
            'cols6' => 'Ruc',
            'cols7' => 'Valor Venta',
            'cols8' => '   I.G.V      ',
            'cols9' => 'Importe Total',
        );

        $this->cezpdf->ezTable($db_data, $col_names, '', array(
            'width' => 450,
            'showLines' => 2,
            'shaded' => 0,
            'Leading' => 10,
            'showHeadings' => 1,
            'xPos' => 300,
            'fontSize' => 8,
            'cols' => array(
                'cols1' => array('width' => 58, 'justification' => 'center'),
                'cols2' => array('width' => 42, 'justification' => 'left'),
                'cols3' => array('width' => 35, 'justification' => 'left'),
                'cols4' => array('width' => 45, 'justification' => 'left'),
                'cols5' => array('width' => 155, 'justification' => 'center'),
                'cols6' => array('width' => 66, 'justification' => 'left'),
                'cols7' => array('width' => 54, 'justification' => 'left'),
                'cols9' => array('width' => 48, 'justification' => 'left'),
                'cols9' => array('width' => 48, 'justification' => 'left')
            )
        ));

        $db_data = array(
            array(
                'cols1' => '',
                'cols2' => '',
                'cols3' => '',
                'cols4' => '',
                'cols5' => '',
                'cols6' => number_format($valor_venta, 2)
                , 'cols7' => number_format($valor_igv, 2),
                'cols8' => number_format($valor_total, 2)),
        );



        $this->cezpdf->ezText('', '');
        $this->cezpdf->ezTable($db_data, "", "", array(
            'width' => 505,
            'showLines' => 0,
            'shaded' => 20,
            'showHeadings' => 0,
            'xPos' => 'center',
            'fontSize' => 9,
            'cols' => array(
                'cols1' => array('width' => 10, 'justification' => 'left'),
                'cols2' => array('width' => 10, 'justification' => 'left'),
                'cols3' => array('width' => 40, 'justification' => 'left'),
                'cols4' => array('width' => 45, 'justification' => 'left'),
                'cols5' => array('width' => 50, 'justification' => 'left'),
                'cols6' => array('width' => 55, 'justification' => 'left'),
                'cols7' => array('width' => 45, 'justification' => 'left'),
                'cols8' => array('width' => 55, 'justification' => 'left'),
            )
        ));




        $this->cezpdf->ezText('', 8);
        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => $tipo_doc . '.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');
        $this->cezpdf->ezStream($cabecera);
    }

    public function registro_ventas_pdf($tipo_oper, $tipo_doc = "F", $fecha1, $fecha2) {
        if ($tipo_oper == 'V') {
            $titulo_personal = 'Cliente';
            if ($tipo_doc == "F")
                $titulo = "REGISTRO DE  VENTAS FACTURAS";
            if ($tipo_doc == "B")
                $titulo = "REPORTE DE  VENTAS BOLETAS";
            if ($tipo_doc == "N")
                $titulo = "REPORTE DE  VENTAS COMPROBANTES";
        }

        else {

            $titulo_personal = 'Proveedor';

            if ($tipo_doc == "F")
                $titulo = "REGISTRO DE  COMPRAS FACTURAS";
            if ($tipo_doc == "B")
                $titulo = "REPORTE DE  COMPRAS BOLETAS";
            if ($tipo_doc == "N")
                $titulo = "REPORTE DE  COMPRAS COMPROBANTES";
        }
        $lista = $this->ventas_model->registro_ventas($tipo_oper, $tipo_doc, $fecha1, $fecha2);
        $this->cezpdf = new Cezpdf('a4', 'landscape');
        $this->cezpdf->ezText(($titulo), 11, array("left" => 180));

        $this->cezpdf->ezText('', '');
        /* Listado de detalles */
        $db_data = array();
        $valor_venta = 0;
        $valor_igv = 0;
        $valor_total = 0;
        foreach ($lista as $indice => $valor) {
            $tipo = $valor->CPC_TipoDocumento;
            $tipo_persona = $valor->CLIC_TipoPersona;
            $flag = $valor->CPC_FlagEstado;
            $nombre = '';
            if ($flag == 1) {

                if ($tipo_doc != "F") {
                    $subtotal = number_format($valor->CPC_total / 1.18, 2);
                    $igv = number_format($subtotal * 0.18, 2);
                } else {
                    $igv = $valor->CPC_igv;
                    $subtotal = $valor->CPC_subtotal;
                }
                $total = $valor->CPC_total;
                $valor_venta +=$subtotal;
                $valor_igv +=$igv;
                $valor_total +=$total;


                if ($tipo_doc == 'F')
                    $nombre = 'Factura';
                else
                    $nombre = 'Boleta';
                if ($tipo_persona == '0') {
                    $nombre_cliente = $valor->PERSC_Nombre . " " . $valor->PERSC_ApellidoPaterno . " " . $valor->PERSC_ApellidoMaterno;
                    $ruc = $valor->PERSC_Ruc;
                } else {
                    $nombre_cliente = $valor->EMPRC_RazonSocial;
                    $ruc = $valor->EMPRC_Ruc;
                }
            } else {
                $nombre_cliente = "ANULADO";
                $ruc = "";
                $subtotal = "";
                $igv = "";
                $total = "";
                if ($tipo_doc == 'F')
                    $nombre = 'Factura';
                else
                    $nombre = 'Boleta';
            }

            $db_data[] = array(
                'cols1' => $valor->CPC_Fecha,
                'cols2' => $nombre,
                'cols3' => $valor->CPC_Serie,
                'cols4' => $valor->CPC_Numero,
                'cols5' => $nombre_cliente,
                'cols6' => $ruc,
                'cols7' => $subtotal,
                'cols8' => $igv,
                'cols9' => $total,
            );
        }
        $col_names = array(
            'cols1' => 'Fecha',
            'cols2' => 'Tipo',
            'cols3' => 'Serie',
            'cols4' => 'Numero',
            'cols5' => $titulo_personal,
            'cols6' => 'Ruc',
            'cols7' => 'Valor Venta',
            'cols8' => '   I.G.V      ',
            'cols9' => 'Importe Total',
        );

        $this->cezpdf->ezTable($db_data, $col_names, '', array(
            'width' => 450,
            'showLines' => 1,
            'shaded' => 1,
            'Leading' => 10,
            'showHeadings' => 1,
            'xPos' => 300,
            'fontSize' => 8,
            'cols' => array(
                'cols1' => array('width' => 58, 'justification' => 'center'),
                'cols2' => array('width' => 42, 'justification' => 'left'),
                'cols3' => array('width' => 35, 'justification' => 'left'),
                'cols4' => array('width' => 45, 'justification' => 'left'),
                'cols5' => array('width' => 155, 'justification' => 'center'),
                'cols6' => array('width' => 66, 'justification' => 'left'),
                'cols7' => array('width' => 54, 'justification' => 'left'),
                'cols9' => array('width' => 48, 'justification' => 'left'),
                'cols9' => array('width' => 48, 'justification' => 'left')
            )
        ));

        $db_data = array(
            array(
                'cols1' => '',
                'cols2' => '',
                'cols3' => '',
                'cols4' => '',
                'cols5' => '',
                'cols6' => number_format($valor_venta, 2)
                , 'cols7' => number_format($valor_igv, 2),
                'cols8' => number_format($valor_total, 2)),
        );



        $this->cezpdf->ezText('', '');
        $this->cezpdf->ezTable($db_data, "", "", array(
            'width' => 505,
            'showLines' => 0,
            'shaded' => 20,
            'showHeadings' => 0,
            'xPos' => 'center',
            'fontSize' => 9,
            'cols' => array(
                'cols1' => array('width' => 10, 'justification' => 'left'),
                'cols2' => array('width' => 10, 'justification' => 'left'),
                'cols3' => array('width' => 40, 'justification' => 'left'),
                'cols4' => array('width' => 45, 'justification' => 'left'),
                'cols5' => array('width' => 50, 'justification' => 'left'),
                'cols6' => array('width' => 55, 'justification' => 'left'),
                'cols7' => array('width' => 45, 'justification' => 'left'),
                'cols8' => array('width' => 55, 'justification' => 'left'),
            )
        ));




        $this->cezpdf->ezText('', 8);
        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => $tipo_doc . '.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');
        $this->cezpdf->ezStream($cabecera);
    }

     //AQUI EXCEL NUEVO
    public function resumen_ventas_mensual($tipo_oper = "V", $tipo = "", $fecha1 = "", $fecha2 = "", $forma_pago = "", $vendedorOrStore = "", $moneda = "", $consolidado="") {
                
        if (isset($tipo) && $tipo!="" && $tipo!="-") {
            $tipo = $tipo;
        }else{
            $tipo = "";
        }
        if (isset($forma_pago) && $forma_pago!="" && $forma_pago!="-") {
            $forma_pago = $forma_pago;
        }else{
            $forma_pago = "";
        }

        if (isset($vendedorOrStore) && $vendedorOrStore!="" && $vendedorOrStore!="-") {
            $vendedorOrStore = $vendedorOrStore;
        }else{
            $vendedorOrStore = "";
        }
        if (isset($moneda) && $moneda!="" && $moneda!="-") {
            $moneda = $moneda;
        }else{
            $moneda = "";
        }
        if (isset($fecha1) && $fecha1!="" && $fecha1!=1) {
            $fecha1 = $fecha1;
        }else{
            $fecha1 = date('Y-m-d');
        }
        if (isset($fecha2) && $fecha2!="" && $fecha2!=1) {
            $fecha2 = $fecha2;
        }else{
            $fecha2 = date('Y-m-d');
        }    
        switch ($tipo_oper) {
            case 'C':
                    $operacion = "COMPRA";
                break;
            case 'V':
                    $operacion = "VENTA";
                break;
            
            default:
                    $operacion = "";
                break;
        }

        $this->load->library('Excel');
        
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle("Resumen De $operacion");
        
        ###########################################
        ######### ESTILOS #########################
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
                'size' => 10
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

            $estiloColumnasAnuladoNota = array(
                'font' => array(
                'name'      => 'Calibri',
                'bold'      => true,
                'color'     => array(
                'rgb' => '000000'
                ),
                'size' => 10
                ),
                'fill'  => array(
                'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('argb' => 'D20505')
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

            $estiloBold = array(
                'font' => array(
                'name'      => 'Calibri',
                'bold'      => true,
                'color'     => array(
                'rgb' => '000000'
                ),
                'size' => 9
                )
            );

        $fecha_ini      = explode("-", $fecha1);
        $fecha_fin      = explode("-", $fecha2);
        $fecha_inicio   = $fecha_ini[2]."/".$fecha_ini[1]."/".$fecha_ini[0];
        $fecha_final    = $fecha_fin[2]."/".$fecha_fin[1]."/".$fecha_fin[0];

        $this->excel->getActiveSheet()->getStyle("A1:O2")->applyFromArray($estiloTitulo);
        $this->excel->getActiveSheet()->getStyle("A3:O3")->applyFromArray($estiloColumnasTitulo);
        $this->excel->setActiveSheetIndex(0)->mergeCells('A1:Q2')->setCellValue('A1', $_SESSION['nombre_empresa']);        
        $this->excel->setActiveSheetIndex(0)->mergeCells("A3:Q3")->setCellValue("A3", "REPORTE DE $operacion del ".$fecha_inicio." hasta el ".$fecha_final);
        
        $lugar      = 4;
        $numeroS    = 0;

        $filter = new stdClass();
        $filter->tipo_oper      = $tipo_oper;
        $filter->tipo           = $tipo;
        $filter->fecha1         = $fecha1;
        $filter->fecha2         = $fecha2;
        $filter->forma_pago     = $forma_pago;
        if($tipo_oper == "V"){
            $filter->vendedor       = $vendedorOrStore;
        }else{
            $filter->almacen       = $vendedorOrStore;
        }
        $filter->moneda         = $moneda;
        $filter->consolidado    = $consolidado;

        $resumen = $this->ventas_model->resumen_ventas_mensual($filter);

        $this->excel->setActiveSheetIndex(0)->setCellValue("A$lugar", "FECHA EMISION.");
        $this->excel->setActiveSheetIndex(0)->setCellValue("B$lugar", "FECHA VENCIMIENTO");
        $this->excel->setActiveSheetIndex(0)->setCellValue("C$lugar", "TIPO DOC. (01: FACTURA. 03: BOLETA. 07: NOTA CREDITO. 12: TICKET, ETC)");
        $this->excel->setActiveSheetIndex(0)->setCellValue("D$lugar", "SERIE");
        $this->excel->setActiveSheetIndex(0)->setCellValue("E$lugar", "NUMERO");
        $this->excel->setActiveSheetIndex(0)->setCellValue("F$lugar", "TIPO ENTIDAD");
        $this->excel->setActiveSheetIndex(0)->setCellValue("G$lugar", "NUMERO DE DOC. DE ENTIDAD");
        $this->excel->setActiveSheetIndex(0)->setCellValue("H$lugar", "RAZON SOCIAL / APELLIDOS Y NOMBRES");
        $this->excel->setActiveSheetIndex(0)->setCellValue("I$lugar", "MONEDA");
        $this->excel->setActiveSheetIndex(0)->setCellValue("J$lugar", "T/C");
        $this->excel->setActiveSheetIndex(0)->setCellValue("K$lugar", "GRAVADA");
        $this->excel->setActiveSheetIndex(0)->setCellValue("L$lugar", "EXONERADA");
        $this->excel->setActiveSheetIndex(0)->setCellValue("M$lugar", "INAFECTA");
        $this->excel->setActiveSheetIndex(0)->setCellValue("N$lugar", "IGV");
        $this->excel->setActiveSheetIndex(0)->setCellValue("O$lugar", "TOTAL");
        $this->excel->setActiveSheetIndex(0)->setCellValue("P$lugar", "ESTADO");
        $this->excel->setActiveSheetIndex(0)->setCellValue("Q$lugar", ($tipo_oper == 'C')?"Almacen":"Vendedor");
        $this->excel->getActiveSheet()->getStyle("A$lugar:Q$lugar")->applyFromArray($estiloColumnasTitulo);

        if ($resumen != NULL){
            $lugar++;
            foreach($resumen as $indice => $valor){
                $fEmision = explode("-", $valor->CPC_Fecha);
                $fVencimiento = "";
                if ($valor->CPC_FechaVencimiento!=null) {
                    $fVencimiento = mysql_to_human($valor->CPC_FechaVencimiento);
                }

                $gravada    = $valor->gravada;
                $exonerada  = $valor->exonerada;
                $inafecta   = $valor->inafecta;
                $igv        = $valor->CPC_igv;
                $total      = $valor->CPC_total;
                $subtotal      = $valor->CPC_subtotal;


                switch ($valor->CPC_TipoDocumento) {
                    case 'F':
                        $tipoDoc = "01";
                        break;
                    case 'B':
                        $tipoDoc = "03";
                        break;
                    case 'N':
                        $tipoDoc = "00";
                        break;
                    case 'C':
                        $tipoDoc = "07";
                        $gravada    = '-'.$gravada;
                        $exonerada  = '-'.$exonerada;
                        $inafecta   = '-'.$inafecta;
                        $igv        = '-'.$igv;
                        $total      = '-'.$total;
                        $subtotal      = '-'.$subtotal;

                        break;
                    
                    default:
                        $tipoDoc = "00";
                        break;
                }

                if ( $valor->numero_documento_cliente != NULL ){
                    switch ( strlen($valor->numero_documento_cliente) ) {
                        case 11:
                            $tipoDocEntidad = "6";
                            break;
                        case 8:
                            $tipoDocEntidad = "1";
                            break;
                        default:
                            $tipoDocEntidad = "-";
                            break;
                    }
                }
                else{
                    switch ( strlen($valor->numero_documento_proveedor) ) {
                        case 11:
                            $tipoDocEntidad = "6";
                            break;
                        case 8:
                            $tipoDocEntidad = "1";
                            break;
                        default:
                            $tipoDocEntidad = "-";
                            break;
                    }
                }

                if ( $valor->numero_documento_cliente == "00000009" ){
                    $tipoDocEntidad = "0";
                }

                $estado = "";

                if ($tipo_oper == 'V') {
                    if ($valor->CPC_FlagEstado == "1") {
                        $estado = "APROBADO";
                    } else ($valor->CPC_FlagEstado == "0") {
                        $estado = "DESAPROBADO"  
                    };
                } else if ($tipo_oper == 'C') {
                    if ($valor->CPC_FlagEstado == "1") {
                        $estado = "APROBADO";
                    } else {
                        continue; 
                    }
                }
                

                $resultado                      = str_replace("indefinida", "", $valor->razon_social_cliente);
                $resultado2                     = str_replace("indefinida", "", $valor->razon_social_proveedor);
                $valor->razon_social_cliente    = $resultado;
                $valor->razon_social_proveedor  = $resultado2;
                
                $this->excel->setActiveSheetIndex(0)
                ->setCellValue("A$lugar", $fEmision[2]."/".$fEmision[1]."/".$fEmision[0])
                ->setCellValue("B$lugar", $fVencimiento)
                ->setCellValue("C$lugar", $tipoDoc)
                ->setCellValue("D$lugar", $valor->CPC_Serie)
                ->setCellValue("E$lugar", $valor->CPC_Numero)
                ->setCellValue("F$lugar", $tipoDocEntidad)
                ->setCellValue("G$lugar", $valor->numero_documento_cliente.$valor->numero_documento_proveedor)
                ->setCellValue("H$lugar", $valor->razon_social_cliente.$valor->razon_social_proveedor)
                ->setCellValue("I$lugar", $valor->MONED_Descripcion)
                ->setCellValue("J$lugar", $valor->CPC_TDC)
                ->setCellValue("K$lugar", number_format( $subtotal, 2,".","") )
                ->setCellValue("L$lugar", number_format( $exonerada, 2,".","") )
                ->setCellValue("M$lugar", number_format( $inafecta, 2,".","") )
                ->setCellValue("N$lugar", number_format( $igv, 2,".","") )
                ->setCellValue("O$lugar", number_format( $total, 2,".","") )
                ->setCellValue("P$lugar", $estado)
                ->setCellValue("Q$lugar", ($tipo_oper == "C")? $valor->ALMAC_Descripcion:$valor->vendedor);
                if ($indice % 2 == 0)
                    $this->excel->getActiveSheet()->getStyle("A$lugar:Q$lugar")->applyFromArray($estiloColumnasPar);
                else
                    $this->excel->getActiveSheet()->getStyle("A$lugar:Q$lugar")->applyFromArray($estiloColumnasImpar);
                
                $lugar++;
            }
            $lugar++;
        }

        $this->excel->getActiveSheet()->getColumnDimension("A")->setWidth("12");
        $this->excel->getActiveSheet()->getColumnDimension("B")->setWidth("12");
        $this->excel->getActiveSheet()->getColumnDimension("C")->setWidth("12");
        $this->excel->getActiveSheet()->getColumnDimension("D")->setWidth("10");
        $this->excel->getActiveSheet()->getColumnDimension("E")->setWidth("10");
        $this->excel->getActiveSheet()->getColumnDimension("F")->setWidth("10");
        $this->excel->getActiveSheet()->getColumnDimension("G")->setWidth("12");
        $this->excel->getActiveSheet()->getColumnDimension("H")->setWidth("40");
        $this->excel->getActiveSheet()->getColumnDimension("I")->setWidth("10");
        $this->excel->getActiveSheet()->getColumnDimension("J")->setWidth("10");
        $this->excel->getActiveSheet()->getColumnDimension("K")->setWidth("10");
        $this->excel->getActiveSheet()->getColumnDimension("L")->setWidth("12");
        $this->excel->getActiveSheet()->getColumnDimension("M")->setWidth("10");
        $this->excel->getActiveSheet()->getColumnDimension("N")->setWidth("10");
        $this->excel->getActiveSheet()->getColumnDimension("O")->setWidth("10");
        $this->excel->getActiveSheet()->getColumnDimension("P")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("Q")->setWidth("20");
  
        
        $filename = "Reporte de $operacion de ".$valor->CPC_Fecha.".xls"; //save our workbook as this file name
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0"); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');
    }

    
    public function registro_ventas_excel2($tipo_oper, $tipo_doc = "F", $fecha1, $fecha2) {
        if ($tipo_oper == 'V') {
            $titulo_personal = 'Cliente';
            if ($tipo_doc == "F")
                $titulo = "REGISTRO DE  VENTAS FACTURAS";
            if ($tipo_doc == "B")
                $titulo = "REPORTE DE  VENTAS BOLETAS";
            if ($tipo_doc == "N")
                $titulo = "REPORTE DE  VENTAS COMPROBANTES";
        }

        else {
            $titulo_personal = 'Proveedor';
            if ($tipo_doc == "F")
                $titulo = "REGISTRO DE  COMPRAS FACTURAS";
            if ($tipo_doc == "B")
                $titulo = "REPORTE DE  COMPRAS BOLETAS";
            if ($tipo_doc == "N")
                $titulo = "REPORTE DE  COMPRAS COMPROBANTES";
        }
        $this->load->library("PHPExcel");

        $phpExcel = new PHPExcel();
        $prestasi = $phpExcel->setActiveSheetIndex(0);
        //merger
        $phpExcel->getActiveSheet()->mergeCells('A1:J1');
        //manage row hight
        $phpExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
        //style alignment
        $styleArray = array(
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        $phpExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $phpExcel->getActiveSheet()->getStyle('A1:J1')->applyFromArray($styleArray);
        //border
        $styleArray1 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        //background
        $styleArray12 = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => 'FFEC8B',
                ),
            ),
        );
        //freeepane
        $phpExcel->getActiveSheet()->freezePane('A3');
        //coloum width
        $phpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6.1);
        $phpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $phpExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $prestasi->setCellValue('A1', $titulo);
        $phpExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($styleArray);
        $phpExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($styleArray1);
        $phpExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($styleArray12);
        $prestasi->setCellValue('A2', 'No');
        $prestasi->setCellValue('B2', 'Fecha');
        $prestasi->setCellValue('C2', 'Tipo');
        $prestasi->setCellValue('D2', 'Serie');
        $prestasi->setCellValue('E2', 'Numero');
        $prestasi->setCellValue('F2', $titulo_personal);
        $prestasi->setCellValue('G2', 'Ruc');
        $prestasi->setCellValue('H2', 'Valor Venta');
        $prestasi->setCellValue('I2', 'I.G.V');
        $prestasi->setCellValue('J2', 'Importe Total');



        $lista = $this->ventas_model->registro_ventas($tipo_oper, $tipo_doc, $fecha1, $fecha2);

        $no = 0;
        $rowexcel = 2;
        $valor_venta = 0;
        $valor_igv = 0;
        $valor_total = 0;
        foreach ($lista as $indice => $valor) {
            $tipo = $valor->CPC_TipoDocumento;
            $tipo_persona = $valor->CLIC_TipoPersona;
            $flag = $valor->CPC_FlagEstado;
            $nombre = '';
            if ($flag == 1) {

                if ($tipo_doc != "F") {
                    $subtotal = number_format($valor->CPC_total / 1.18, 2);
                    $igv = number_format($subtotal * 0.18, 2);
                } else {
                    $igv = $valor->CPC_igv;
                    $subtotal = $valor->CPC_subtotal;
                }
                $total = $valor->CPC_total;
                $valor_venta +=$subtotal;
                $valor_igv +=$igv;
                $valor_total +=$total;


                if ($tipo_doc == 'F')
                    $nombre = 'Factura';
                else
                    $nombre = 'Boleta';
                if ($tipo_persona == '0') {
                    $nombre_cliente = $valor->PERSC_Nombre . " " . $valor->PERSC_ApellidoPaterno . " " . $valor->PERSC_ApellidoMaterno;
                    $ruc = $valor->PERSC_Ruc;
                } else {
                    $nombre_cliente = $valor->EMPRC_RazonSocial;
                    $ruc = $valor->EMPRC_Ruc;
                }
            } else {
                $nombre_cliente = "ANULADO";
                $ruc = "";
                $subtotal = "";
                $igv = "";
                $total = "";
                if ($tipo_doc == 'F')
                    $nombre = 'Factura';
                else
                    $nombre = 'Boleta';
            }

            $no++;
            $rowexcel++;

            $prestasi->setCellValue('A' . $rowexcel, $no);
            $prestasi->setCellValue('B' . $rowexcel, $valor->CPC_Fecha);
            $prestasi->setCellValue('C' . $rowexcel, $nombre);
            $prestasi->setCellValue('D' . $rowexcel, $valor->CPC_Serie);
            $prestasi->setCellValue('E' . $rowexcel, $valor->CPC_Numero);
            $prestasi->setCellValue('F' . $rowexcel, $nombre_cliente);
            $prestasi->setCellValue('G' . $rowexcel, $ruc);
            $prestasi->setCellValue('H' . $rowexcel, $subtotal);
            $prestasi->setCellValue('I' . $rowexcel, $igv);
            $prestasi->setCellValue('J' . $rowexcel, $total);
        }

        $prestasi->setTitle('ReportE');
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"Report.xls\"");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
        $objWriter->save("php://output");
    }

#REPORTE DE GANANCIA
    public function ganancia($value='')
    {
        
        $data['titulo_tabla'] = "REPORTE DE GANANCIAS";
        $lista_companias = $this->compania_model->listar_establecimiento($this->somevar['empresa']);
        $filter = new stdClass();
        $filter->start  = $this->input->post("start");
        $filter->length = $this->input->post("length");
        $filter->search = $this->input->post("search")["value"];

        $ordenar = $this->input->post("order")[0]["column"];
        if ($ordenar != ""){
            $filter->order  = $columnas[$ordenar];
            $filter->dir    = $this->input->post("order")[0]["dir"];
        }

        $item = ($this->input->post("start") != "") ? $this->input->post("start") : 0;

        $filter->moneda     = $this->input->post('moneda');
        $filter->fechai     = ($this->input->post('fechai') != "") ? $this->input->post('fechai') : date('Y-m-d');
        $filter->fechaf     = ($this->input->post('fechaf') != "") ? $this->input->post('fechaf') : date('Y-m-d');
        $filter->producto   = $this->input->post('producto');
        $filter->compania   = $this->input->post('locales'); //$_SESSION['compania'];
        $ganancia_global    = $this->ventas_model->ganancia_global($filter);
        
        $total_comp     = $ganancia_global[0]->total_comp;
        $costo_total    = $ganancia_global[0]->costo_total;
        $venta_total    = $ganancia_global[0]->venta_total;
        $utilidad       = $ganancia_global[0]->utilidad;
        $por_utilidad   = $costo_total != 0 ? ($utilidad / $venta_total) * 100 : 0;
        
        $data['ventas_aprobadas']   = $total_comp != null ? $total_comp : 0;
        $data['total_ventas']       = number_format($venta_total,2);
        $data['total_costo']        = number_format($costo_total,2);
        $data['total_utilidad']     = number_format($utilidad,2);
        $data['por_utilidad']       = number_format($por_utilidad,2);
        $data['lista_companias']    = $lista_companias;


        $data['TODOS']  = $this->input->post('TODOS') == '1' ? true : false;
        $data['moneda'] = $this->moneda_model->listar();
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        
        $this->layout->view('reportes/ganancia', $data);
    }

    public function datatable_ganancia(){

        $columnas = array(
            0 => "",
            1 => "",
            2 => "",
            3 => "",
            4 => "",
            5 => "",
            6 => "",
            7 => ""
        );
            
        $filter = new stdClass();
        $filter->start  = $this->input->post("start");
        $filter->length = $this->input->post("length");
        $filter->search = $this->input->post("search")["value"];

        $ordenar = $this->input->post("order")[0]["column"];
        if ($ordenar != ""){
            $filter->order  = $columnas[$ordenar];
            $filter->dir    = $this->input->post("order")[0]["dir"];
        }

        $item = ($this->input->post("start") != "") ? $this->input->post("start") : 0;

        $filter->moneda     = $this->input->post('moneda');
        $filter->fechai     = ($this->input->post('fechai') != "") ? $this->input->post('fechai') : date('Y-m-d');
        $filter->fechaf     = ($this->input->post('fechaf') != "") ? $this->input->post('fechaf') : date('Y-m-d');
        $filter->producto   = $this->input->post('producto');
        $filter->compania   = $this->input->post('companias');

        $lista_ganancia = $this->ventas_model->reporte_ganancia($filter);
        
        $lista = array();
        $resumen_compania = array();
        foreach ($lista_ganancia as $value) {
            $fecha              = mysql_to_human($value->CPC_Fecha);
            $establec           = $value->EESTABC_Descripcion;
            $nombre_producto    = $value->PROD_Nombre;
            $cantidad           = $value->CPDEC_Cantidad;
            $simbolo_moneda     = $value->MONED_Simbolo;
            $pcosto             = $value->PROD_UltimoCosto;
            $pventa             = $value->CPDEC_Pu_ConIgv;
            $costo              = $pcosto * $value->CPDEC_Cantidad;
            $venta              = $pventa * $value->CPDEC_Cantidad;
            $total_costo        += $costo;
            $total_venta        += $venta;
            $utilidad           = $venta - $costo;
            $porc_util          = $costo != 0 ? ($utilidad / $costo) * 100 : 100;
            
            $resumen_compania[$value->COMPP_Codigo] = array(
                'costo' => isset($resumen_compania[$value->COMPP_Codigo]['costo']) ? $resumen_compania[$value->COMPP_Codigo]['costo'] + $costo : $costo,
                'venta' => isset($resumen_compania[$value->COMPP_Codigo]['venta']) ? $resumen_compania[$value->COMPP_Codigo]['venta'] + $venta : $venta
            );

            $lote_numero = $value->LOTC_Numero;
            $lote_fv = mysql_to_human($value->LOTC_FechaVencimiento);
           

            $posDT=-1;
            $lista[] = array(
                    ++$posDT => $fecha,
                    ++$posDT => $establec,
                    ++$posDT => $nombre_producto,
                    ++$posDT => $cantidad,
                    ++$posDT => $simbolo_moneda,
                    ++$posDT => number_format($pcosto, 2),
                    ++$posDT => number_format($pventa, 2),
                    ++$posDT => number_format($costo, 2),
                    ++$posDT => number_format($venta, 2),
                    ++$posDT => number_format($utilidad, 2),
                    ++$posDT => round($porc_util)."%"
                );
        }
        
        unset($filter->start);
        unset($filter->length);

        $json = array(
                "draw"            => intval( $this->input->post('draw') ),
                "recordsTotal"    => count($this->comprobantedetalle_model->reporte_ganancia()),
                "recordsFiltered" => intval( count($this->comprobantedetalle_model->reporte_ganancia($filter)) ),
                "data"            => $lista
        );

        echo json_encode($json);
    }

    public function busca_ganancia_global($value='')
    {
        
        $filter = new stdClass();
        $filter->start  = $this->input->post("start");
        $filter->length = $this->input->post("length");
        $filter->search = $this->input->post("search")["value"];

        $ordenar = $this->input->post("order")[0]["column"];
        if ($ordenar != ""){
            $filter->order  = $columnas[$ordenar];
            $filter->dir    = $this->input->post("order")[0]["dir"];
        }

        $item = ($this->input->post("start") != "") ? $this->input->post("start") : 0;

        $filter->moneda     = $this->input->post('moneda');
        $filter->fechai     = ($this->input->post('fechai') != "") ? $this->input->post('fechai') : date('Y-m-d');
        $filter->fechaf     = ($this->input->post('fechaf') != "") ? $this->input->post('fechaf') : date('Y-m-d');
        $filter->producto   = $this->input->post('producto');
        $filter->compania   = $this->input->post('companias');
        $ganancia_global    = $this->ventas_model->ganancia_global($filter);
        
        $total_comp     = $ganancia_global[0]->total_comp;
        $costo_total    = $ganancia_global[0]->costo_total;
        $venta_total    = $ganancia_global[0]->venta_total;
        $utilidad       = $ganancia_global[0]->utilidad;
        $por_utilidad   = $costo_total != 0 ? ($utilidad / $venta_total) * 100 : 0;
        

        $ventas_aprobadas   = $total_comp != null ? $total_comp : 0;
        $total_ventas       = number_format($venta_total,2);
        $total_costo        = number_format($costo_total,2);
        $total_utilidad     = number_format($utilidad,2);
        $por_utilidad       = number_format($por_utilidad,2);


        $success = array("ventas_aprobadas" => $ventas_aprobadas, "total_ventas" => $total_ventas, "total_costo" => $total_costo, "total_utilidad" => $total_utilidad, "por_utilidad" => $por_utilidad);
        
        echo json_encode($success);
    }

    public function gananciaPDF($codigo = 'ALL', $companias = '', $fecha = NULL) {

        $comp_select = explode("-", $companias);

        $lista = '';
        $total_soles = '';
        $total_dolares = '';
        $resumen_suma = '';
        $resumen_suma_d = '';
        $resumen_cantidad = '';
        $resumen_fpago = '';

        $producto = ($codigo == "ALL") ? "" : $codigo;

        $fechaIF = explode("-", $fecha);

        $f_ini = ($fecha == NULL) ? "01/".date("m/").date("Y") : "$fechaIF[0]/$fechaIF[1]/$fechaIF[2]";
        $f_fin = ($fecha == NULL) ? date('d/m/Y') : "$fechaIF[3]/$fechaIF[4]/$fechaIF[5]";

        $lista_companias = $this->compania_model->listar_establecimiento($this->somevar['empresa']);

        $total_costo = 0;
        $total_venta = 0;
        $total_util = 0;
        $total_porc_util = 0;
        $lista_ganancia = $this->comprobantedetalle_model->reporte_ganancia($producto, human_to_mysql($f_ini), human_to_mysql($f_fin), $comp_select);
        $lista = array();
        $resumen_compania = array();
        foreach ($lista_ganancia as $value) {

            $fecha = mysql_to_human($value->CPC_Fecha);
            $establec = $value->EESTABC_Descripcion;
            $nombre_producto = $value->PROD_Nombre;
            $cantidad = $value->CPDEC_Cantidad;
            $simbolo_moneda = $value->MONED_Simbolo;
            $pcosto = $value->ALMALOTC_Costo;
            $pventa = $value->CPDEC_Pu_ConIgv;
            $costo = $pcosto * $value->CPDEC_Cantidad;
            $venta = $pventa * $value->CPDEC_Cantidad;
            $total_costo+=$costo;
            $total_venta+=$venta;
            $utilidad = $venta - $costo;
            $porc_util = $costo != 0 ? ($utilidad / $costo) * 100 : 0;
            $resumen_compania[$value->COMPP_Codigo] = array('costo' => isset($resumen_compania[$value->COMPP_Codigo]['costo']) ? $resumen_compania[$value->COMPP_Codigo]['costo'] + $costo : $costo,
                'venta' => isset($resumen_compania[$value->COMPP_Codigo]['venta']) ? $resumen_compania[$value->COMPP_Codigo]['venta'] + $venta : $venta
            );

            $lote_numero = $value->LOTC_Numero;
            $lote_fv = mysql_to_human($value->LOTC_FechaVencimiento);
            $lista[] = array($fecha, $establec, $nombre_producto, $lote_numero, $lote_fv, $cantidad, $simbolo_moneda, number_format($pcosto, 2), number_format($pventa, 2), number_format($costo, 2), number_format($venta, 2), number_format($utilidad, 2), round($porc_util));
        }

        $total_util = $total_venta - $total_costo;
        $total_porc_util = $total_costo != 0 ? ($total_util / $total_costo) * 100 : 0;

        /* Resumen por compania */
        $t_resumen_costo = 0;
        $t_resumen_venta = 0;
        foreach ($lista_companias as $key => $compania) {
            if (isset($resumen_compania[$compania->COMPP_Codigo])) {
                $st_costo = $resumen_compania[$compania->COMPP_Codigo]['costo'];
                $st_venta = $resumen_compania[$compania->COMPP_Codigo]['venta'];
                $resumen_compania[$compania->COMPP_Codigo]['costo'] = $resumen_compania[$compania->COMPP_Codigo]['costo'] > 0 ? number_format($resumen_compania[$compania->COMPP_Codigo]['costo'], 2) : 0;
                $resumen_compania[$compania->COMPP_Codigo]['venta'] = $resumen_compania[$compania->COMPP_Codigo]['venta'] > 0 ? number_format($resumen_compania[$compania->COMPP_Codigo]['venta'], 2) : 0;
            } else {
                $resumen_compania[$compania->COMPP_Codigo]['costo'] = $st_costo = 0;
                $resumen_compania[$compania->COMPP_Codigo]['venta'] = $st_venta = 0;
            }
            $resumen_compania[$compania->COMPP_Codigo]['util'] = $st_venta - $st_costo;
            $resumen_compania[$compania->COMPP_Codigo]['porc'] = round($st_costo != 0 ? (($st_venta - $st_costo) / $st_costo) * 100 : 0, 2);
            $t_resumen_costo+=$st_costo;
            $t_resumen_venta+=$st_venta;
        }
        $t_resumen_util = $t_resumen_venta - $t_resumen_costo;
        $t_resumen_porc = $t_resumen_costo != 0 ? ($t_resumen_util / $t_resumen_costo) * 100 : 0;

        $img = 'images/img_db/menbrete1.jpg';
        $this->cezpdf = new Cezpdf('a4');
        $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img'=> $img));
        $this->cezpdf->ezSetCmMargins(5.5,4,1.5,1.5);
        $this->cezpdf->ezStartPageNumbers(60, 40, 10, 'left', '', 1);

        $this->cezpdf->ezText("", 8, array("leading" => 2));
        $this->cezpdf->ezText("REPORTE DE GANANCIA", 12, array("leading" => 10, "left" => 0, "justification" => "center"));
        $this->cezpdf->ezText("", 8, array("leading" => 10));
        
        if ( count($lista) > 0 ) {
            $view = array();

            foreach($lista as $indice=>$value){
                $view[] = array(
                            'col1' => $value[0],
                            'col2' => $value[1],
                            'col3' => $value[2],
                            'col4' => $value[3],
                            'col5' => $value[4],
                            'col6' => $value[5],
                            'col7' => $value[6],
                            'col8' => $value[7],
                            'col9' => $value[8],
                            'col10' => $value[9],
                            'col11' => $value[10],
                            'col12' => $value[11],
                            'col13' => $value[12]
                        );
            }

            $col_names = array(
                    'col1' => 'FECHA',
                    'col2' => 'ESTABLECIMIENTO',
                    'col3' => 'PRODUCTO',
                    'col4' => 'NUMETO LOTE',
                    'col5' => 'FECHA V.',
                    'col6' => 'CANT.',
                    'col7' => 'M.',
                    'col8' => 'P/COSTO',
                    'col9' => 'P/VENTA',
                    'col10' => 'COSTO',
                    'col11' => 'VENTA',
                    'col12' => 'UTILIDAD',
                    'col13' => '% UTIL'
            );

                $alignL = "left";
                $alignC = "center";
                $alignR = "right";

                $this->cezpdf->ezTable($view, $col_names, '', array(
                    'width' => 555,
                    'showLines' => 2,
                    'shaded' => 0,
                    'showHeadings' => 1,
                    'xPos' => '300',
                    'fontSize' => 6,
                    'cols' => array(
                        'col1' => array('width' => 45, 'justification' => $alignC), // FECHA
                        'col2' => array('width' => 60, 'justification' => $alignC), // ESTABLECIMIENTO
                        'col3' => array('width' => 70, 'justification' => $alignL),// PRODUCTO
                        'col4' => array('width' => 40, 'justification' => $alignC), // N. LOTE
                        'col5' => array('width' => 45, 'justification' => $alignC), // FECHA V.
                        'col6' => array('width' => 30, 'justification' => $alignR), // CANT.
                        'col7' => array('width' => 20, 'justification' => $alignR), // MONEDA
                        'col8' => array('width' => 40, 'justification' => $alignR), // P/COSTO
                        'col9' => array('width' => 40, 'justification' => $alignR), // P/VENTA
                        'col10' => array('width' => 40, 'justification' => $alignR),// COSTO
                        'col11' => array('width' => 40, 'justification' => $alignR),// VENTA
                        'col12' => array('width' => 40, 'justification' => $alignR),// UTILIDAD
                        'col13' => array('width' => 35, 'justification' => $alignR) // % UTILIDAD
                    )
                ));


        }

        $yPos = $this->cezpdf->y - $this->cezpdf->ez['bottomMargin'];
                
        if ($yPos < 70)
            $this->cezpdf->ezNewPage();

            if(count($lista_companias) > 0){
                $this->cezpdf->ezText("", 8, array("leading" => 15));
                $this->cezpdf->ezText("RESUMEN POR ESTABLECIMIENTO", 10, array("leading" => 10, "left" => 35));
                $this->cezpdf->ezText("", 8, array("leading" => 10));
            
                $col_names = array(
                        'col1' => 'ESTABLECIMIENTO',
                        'col2' => 'COSTO',
                        'col3' => 'VENTA',
                        'col4' => 'UTILIDAD',
                        'col5' => '% UTILIDAD'
                );

                $viewG = array();

                foreach($lista_companias as $indice=>$value){
                    $viewG[] = array(
                            'col1' => $value->EESTABC_Descripcion,
                            'col2' => $resumen_compania[$value->COMPP_Codigo]['costo'],
                            'col3' => $resumen_compania[$value->COMPP_Codigo]['venta'],
                            'col4' => $resumen_compania[$value->COMPP_Codigo]['util'],
                            'col5' => $resumen_compania[$value->COMPP_Codigo]['porc']
                        );
                }

                $alignL = "left";
                $alignC = "center";
                $alignR = "right";

                $this->cezpdf->ezTable($viewG, $col_names, '', array(
                    'width' => 525,
                    'showLines' => 2,
                    'shaded' => 0,
                    'showHeadings' => 1,
                    'xPos' => '295',
                    'fontSize' => 7,
                    'cols' => array(
                        'col1' => array('width' => 140, 'justification' => $alignL),
                        'col2' => array('width' => 70, 'justification' => $alignR),
                        'col3' => array('width' => 70, 'justification' => $alignR),
                        'col4' => array('width' => 70, 'justification' => $alignR),
                        'col5' => array('width' => 70, 'justification' => $alignR)
                    )
                ));
            }

        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');
        $this->cezpdf->ezStream($cabecera);
    }

    public function gananciaExcel($codigo, $companias, $fecha,$moneda) {


        $lista = '';
        $total_soles = '';
        $total_dolares = '';
        $resumen_suma = '';
        $resumen_suma_d = '';
        $resumen_cantidad = '';
        $resumen_fpago = '';

        $producto = (trim($codigo) == "noValue") ? "" : $codigo;


        $fechaIF = explode("-", $fecha);

        $f_ini = (trim($fecha) == 'noValue') ? date('d/m/Y') : "$fechaIF[2]/$fechaIF[1]/$fechaIF[0]";
        $f_fin = (trim($fecha) == 'noValue') ? date('d/m/Y') : "$fechaIF[5]/$fechaIF[4]/$fechaIF[3]";

        $lista_companias = $this->compania_model->listar_establecimiento($this->somevar['empresa']);


        $total_costo = 0;
        $total_venta = 0;
        $total_util  = 0;
        $total_porc_util = 0;
        $lista_ganancia = $this->ventas_model->reporte_ganancia_old($producto, human_to_mysql($f_ini), human_to_mysql($f_fin), $companias,$moneda);

        $lista = array();
        $resumen_compania = array();
        foreach ($lista_ganancia as $value) {
            $fecha = mysql_to_human($value->CPC_Fecha);
            $establec = $value->EESTABC_Descripcion;
            $nombre_producto = $value->PROD_Nombre;
            $cantidad = $value->CPDEC_Cantidad;
            $simbolo_moneda = $value->MONED_Simbolo;
            $pcosto = $value->PROD_UltimoCosto;
            $pventa = $value->CPDEC_Pu_ConIgv;
            $costo = $pcosto * $value->CPDEC_Cantidad;
            $venta = $pventa * $value->CPDEC_Cantidad;
            $total_costo+=$costo;
            $total_venta+=$venta;
            $utilidad = $venta - $costo;
            $porc_util = $costo != 0 ? ($utilidad / $costo) * 100 : 0;
            $resumen_compania[$value->COMPP_Codigo] = array('costo' => isset($resumen_compania[$value->COMPP_Codigo]['costo']) ? $resumen_compania[$value->COMPP_Codigo]['costo'] + $costo : $costo,
                'venta' => isset($resumen_compania[$value->COMPP_Codigo]['venta']) ? $resumen_compania[$value->COMPP_Codigo]['venta'] + $venta : $venta
            );

            $lote_numero = $value->LOTC_Numero;
            $lote_fv = mysql_to_human($value->LOTC_FechaVencimiento);
            $lista[] = array($fecha, $establec, $nombre_producto, $lote_numero, $lote_fv, $cantidad, $simbolo_moneda, number_format($pcosto, 2), number_format($pventa, 2), number_format($costo, 2), number_format($venta, 2), number_format($utilidad, 2), round($porc_util));
        }

        $total_util = $total_venta - $total_costo;
        $total_porc_util = $total_costo != 0 ? ($total_util / $total_costo) * 100 : 0;

        /* Resumen por compania */
        $t_resumen_costo = 0;
        $t_resumen_venta = 0;
        foreach ($lista_companias as $key => $compania) {
            if (isset($resumen_compania[$compania->COMPP_Codigo])) {
                $st_costo = $resumen_compania[$compania->COMPP_Codigo]['costo'];
                $st_venta = $resumen_compania[$compania->COMPP_Codigo]['venta'];
                $resumen_compania[$compania->COMPP_Codigo]['costo'] = $resumen_compania[$compania->COMPP_Codigo]['costo'] > 0 ? number_format($resumen_compania[$compania->COMPP_Codigo]['costo'], 2) : 0;
                $resumen_compania[$compania->COMPP_Codigo]['venta'] = $resumen_compania[$compania->COMPP_Codigo]['venta'] > 0 ? number_format($resumen_compania[$compania->COMPP_Codigo]['venta'], 2) : 0;
            } else {
                $resumen_compania[$compania->COMPP_Codigo]['costo'] = $st_costo = 0;
                $resumen_compania[$compania->COMPP_Codigo]['venta'] = $st_venta = 0;
            }
            $resumen_compania[$compania->COMPP_Codigo]['util'] = $st_venta - $st_costo;
            $resumen_compania[$compania->COMPP_Codigo]['porc'] = round($st_costo != 0 ? (($st_venta - $st_costo) / $st_costo) * 100 : 0, 2);
            $t_resumen_costo+=$st_costo;
            $t_resumen_venta+=$st_venta;
        }
        $t_resumen_util = $t_resumen_venta - $t_resumen_costo;
        $t_resumen_porc = $t_resumen_costo != 0 ? ($t_resumen_util / $t_resumen_costo) * 100 : 0;

        
        ###########################################
        ######### TITULO Y ESTILOS
        ###########################################
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Reporte de Ganancia');
            $TipoFont = array( 'font'  => array( 'bold'  => true, 'color' => array('rgb' => '000000'), 'size'  => 16, 'name'  => 'Calibri'));
            $TipoFont2 = array( 'font'  => array( 'bold'  => true, 'color' => array('rgb' => '000000'), 'size'  => 14, 'name'  => 'Calibri'));
            $style = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
            $style2 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

            $this->excel->getActiveSheet()->getStyle('A1:N1')->applyFromArray($TipoFont);
            $this->excel->getActiveSheet()->getStyle('A1:N1')->applyFromArray($style);
            $this->excel->getActiveSheet()->getStyle('A3:N3')->applyFromArray($TipoFont);
            $this->excel->getActiveSheet()->getStyle("A3:N3")->applyFromArray($style);

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
                                                'color' => array('argb' => 'ECF0F1')
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

            $this->excel->getActiveSheet()->getStyle("A4:K4")->applyFromArray($estiloColumnasTitulo);

        ###########################################

        $this->excel->setActiveSheetIndex(0)->mergeCells('A1:K2')->setCellValue('A1', $_SESSION['nombre_empresa']);
        
        $this->excel->getActiveSheet()->getStyle("A3:K3")->applyFromArray($TipoFont2);
        $this->excel->getActiveSheet()->getStyle("A3:K3")->applyFromArray($style2);
        $this->excel->setActiveSheetIndex(0)->mergeCells("A3:K3")->setCellValue("A3", "REPORTE DE GANANCIA DESDE El $f_ini HASTA $f_fin");
        
        ###########################################
        ######### TITULO DE COLUMNA RODUCTO
        ###########################################
            $lugar = 4;
            $this->excel->setActiveSheetIndex(0)->setCellValue("A$lugar", "FECHA");
            $this->excel->setActiveSheetIndex(0)->setCellValue("B$lugar", "ESTABLECIMIENTO");
            $this->excel->setActiveSheetIndex(0)->setCellValue("C$lugar", "DESCRIPCIÓN");
            $this->excel->setActiveSheetIndex(0)->setCellValue("D$lugar", "CANTIDAD");
            $this->excel->setActiveSheetIndex(0)->setCellValue("E$lugar", "MONEDA");
            $this->excel->setActiveSheetIndex(0)->setCellValue("F$lugar", "P / COSTO");
            $this->excel->setActiveSheetIndex(0)->setCellValue("G$lugar", "P / VENTA");
            $this->excel->setActiveSheetIndex(0)->setCellValue("H$lugar", "COSTO TOTAL");
            $this->excel->setActiveSheetIndex(0)->setCellValue("I$lugar", "VENTA TOTAL");
            $this->excel->setActiveSheetIndex(0)->setCellValue("J$lugar", "UTILIDAD");
            $this->excel->setActiveSheetIndex(0)->setCellValue("K$lugar", "% UTILIDAD");
        ###########################################

        $numeroS = 0;
        $lugar += 1;
        
        foreach($lista as $indice => $valor){
            $numeroS += 1;

            $this->excel->setActiveSheetIndex(0)
            ->setCellValue("A$lugar", $valor[0])
            ->setCellValue("B$lugar", $valor[1])
            ->setCellValue("C$lugar", $valor[2])
            ->setCellValue("D$lugar", $valor[5])
            ->setCellValue("E$lugar", $valor[6])
            ->setCellValue("F$lugar", $valor[7])
            ->setCellValue("G$lugar", $valor[8])
            ->setCellValue("H$lugar", $valor[9])
            ->setCellValue("I$lugar", $valor[10])
            ->setCellValue("J$lugar", $valor[11])
            ->setCellValue("K$lugar", $valor[12]);

      ;
            $lugar += 1;
        }

        for($i = 'A'; $i <= 'K'; $i++){
            $this->excel->setActiveSheetIndex(0)            
                ->getColumnDimension($i)->setAutoSize(true);
        }

        if(count($lista_companias) > 0) {
            $lugar += 3;
            $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($TipoFont2);
            $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($style2);
            $this->excel->setActiveSheetIndex(0)->mergeCells("A$lugar:E$lugar")->setCellValue("A$lugar", "RESUMEN POR ESTABLECIMIENTO");
            $lugar += 1;

            $this->excel->setActiveSheetIndex(0)->setCellValue("A$lugar", "ESTABLECIMIENTO");
            $this->excel->setActiveSheetIndex(0)->setCellValue("B$lugar", "COSTO TOTAL");
            $this->excel->setActiveSheetIndex(0)->setCellValue("C$lugar", "VENTA TOTAL");
            $this->excel->setActiveSheetIndex(0)->setCellValue("D$lugar", "UTILIDAD");
            $this->excel->setActiveSheetIndex(0)->setCellValue("E$lugar", "% UTILIDAD");
            if ($lugar % 2 == 0)
                $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($estiloColumnasPar);
            else
                $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($estiloColumnasImpar);
        }



                foreach($lista_companias as $indice => $value){

                          $lugar += 1;
                          $this->excel->setActiveSheetIndex(0)
                              ->setCellValue("A$lugar", $value->EESTABC_Descripcion)
                              ->setCellValue("B$lugar", $resumen_compania[$value->COMPP_Codigo]['costo'])
                              ->setCellValue("C$lugar", $resumen_compania[$value->COMPP_Codigo]['venta'])
                              ->setCellValue("D$lugar", $resumen_compania[$value->COMPP_Codigo]['util'])
                              ->setCellValue("E$lugar", $resumen_compania[$value->COMPP_Codigo]['porc']);



                }


        $filename = "Reporte de ganancia desde ".$f_ini." hasta ".$f_fin.".xls"; //save our workbook as this file name

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0"); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');
        #$this->layout->view('reportes/ventas_por_vendedor', $data);
    }
#FIN GANANCIA

    public function promedioVentaExcel($codigo = 'ALL', $fecha = NULL) {

        $lista = '';
        $total_soles = '';
        $total_dolares = '';
        $resumen_suma = '';
        $resumen_suma_d = '';
        $resumen_cantidad = '';
        $resumen_fpago = '';

        $producto = ($codigo == "ALL") ? "" : $codigo;

        $fechaIF = explode("-", $fecha);

        $f_ini = ($fecha == NULL) ? "01/".date("m/").date("Y") : "$fechaIF[0]/$fechaIF[1]/$fechaIF[2]";
        $f_fin = ($fecha == NULL) ? date('d/m/Y') : "$fechaIF[3]/$fechaIF[4]/$fechaIF[5]";

        $total_costo = 0;
        $total_venta = 0;
        $total_util = 0;
        $total_porc_util = 0;

        $lista_promedio = $this->comprobantedetalle_model->promedio_ventas_articulos($producto, human_to_mysql($f_ini), human_to_mysql($f_fin));
        $lista = array();
        foreach ($lista_promedio as $value) {
            $fecha = mysql_to_human($value->CPC_Fecha);
            $nombre_producto = $value->PROD_Nombre;
            $marca = $value->MARCC_Descripcion;
            $cantidad = $value->CPDEC_Cantidad;
            $simbolo_moneda = $value->MONED_Simbolo;
            $pventa_min = $value->pventa_minimo;
            $pventa_max = $value->pventa_maximo;
            $precio_promedio = $value->total / $value->cantidad_operaciones;

            $lista[] = array($fecha, $establec, $nombre_producto, $lote_numero, $lote_fv, $cantidad, $simbolo_moneda, number_format($pcosto, 2), number_format($pventa, 2), number_format($costo, 2), number_format($venta, 2), number_format($utilidad, 2), round($porc_util));
        }
        
        $this->load->library('Excel');
        
        ###########################################
        ######### TITULO Y ESTILOS
        ###########################################
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Reporte de Ganancia');
            $TipoFont = array( 'font'  => array( 'bold'  => true, 'color' => array('rgb' => '000000'), 'size'  => 16, 'name'  => 'Calibri'));
            $TipoFont2 = array( 'font'  => array( 'bold'  => true, 'color' => array('rgb' => '000000'), 'size'  => 14, 'name'  => 'Calibri'));
            $style = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
            $style2 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

            $this->excel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($TipoFont);
            $this->excel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($style);
            $this->excel->getActiveSheet()->getStyle('A3:H3')->applyFromArray($TipoFont);
            $this->excel->getActiveSheet()->getStyle("A3:H3")->applyFromArray($style);

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
                                                'color' => array('argb' => 'ECF0F1')
                                            ),
                                            'alignment' =>  array(
                                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                    'wrap'          => TRUE
                                            )
                                        );

            $this->excel->getActiveSheet()->getStyle("A4:H4")->applyFromArray($estiloColumnasTitulo);
        ###########################################

        $this->excel->setActiveSheetIndex(0)->mergeCells('A1:H2')->setCellValue('A1', $_SESSION['nombre_empresa']);
        
        $this->excel->getActiveSheet()->getStyle("A3:H3")->applyFromArray($TipoFont2);
        $this->excel->getActiveSheet()->getStyle("A3:H3")->applyFromArray($style2);
        $this->excel->setActiveSheetIndex(0)->mergeCells("A3:H3")->setCellValue("A3", "REPORTE DE PRECIOS DE VENTA DEL $f_ini HASTA $f_fin");
        
        ###########################################
        ######### TITULO DE COLUMNA RODUCTO
        ###########################################
            $lugar = 4;
            $this->excel->setActiveSheetIndex(0)->setCellValue("A$lugar", "ITEM");
            $this->excel->setActiveSheetIndex(0)->setCellValue("B$lugar", "DESCRIPCIÓN");
            $this->excel->setActiveSheetIndex(0)->setCellValue("C$lugar", "MARCA");
            $this->excel->setActiveSheetIndex(0)->setCellValue("D$lugar", "TOTAL P/V.");
            $this->excel->setActiveSheetIndex(0)->setCellValue("E$lugar", "N# OPERACIONES");
            $this->excel->setActiveSheetIndex(0)->setCellValue("F$lugar", "PRECIO MIN.");
            $this->excel->setActiveSheetIndex(0)->setCellValue("G$lugar", "PRECIO MAX.");
            $this->excel->setActiveSheetIndex(0)->setCellValue("H$lugar", "PRECIO PROMEDIO.");
        ###########################################

        $numeroS = 0;
        $lugar += 1;
        
        foreach ($lista_promedio as $value){
            $numeroS += 1;
            $fecha = mysql_to_human($value->CPC_Fecha);
            $nombre_producto = $value->PROD_Nombre;
            $marca = $value->MARCC_Descripcion;
            $cantidad = $value->CPDEC_Cantidad;
            $simbolo_moneda = $value->MONED_Simbolo;
            $pventa_min = $value->pventa_minimo;
            $pventa_max = $value->pventa_maximo;
            $precio_promedio = $value->total / $value->cantidad_operaciones;

            $lista[] = array($fecha, $establec, $nombre_producto, $lote_numero, $lote_fv, $cantidad, $simbolo_moneda, number_format($pcosto, 2), number_format($pventa, 2), number_format($costo, 2), number_format($venta, 2), number_format($utilidad, 2), round($porc_util));


            $this->excel->setActiveSheetIndex(0)
            ->setCellValue("A$lugar", $numeroS)
            ->setCellValue("B$lugar", $value->PROD_Nombre)
            ->setCellValue("C$lugar", $value->MARCC_Descripcion)
            ->setCellValue("D$lugar", $value->total)
            ->setCellValue("E$lugar", $value->cantidad_operaciones)
            ->setCellValue("F$lugar", $value->pventa_minimo)
            ->setCellValue("G$lugar", $value->pventa_maximo)
            ->setCellValue("H$lugar", $value->total / $value->cantidad_operaciones);

            if ($indice % 2 == 0)
                $this->excel->getActiveSheet()->getStyle("A$lugar:H$lugar")->applyFromArray($estiloColumnasPar);
            else
                $this->excel->getActiveSheet()->getStyle("A$lugar:H$lugar")->applyFromArray($estiloColumnasImpar);
            $lugar += 1;
        }

        for($i = 'A'; $i <= 'H'; $i++){
            $this->excel->setActiveSheetIndex(0)            
                ->getColumnDimension($i)->setAutoSize(true);
        }

        $filename = "Reporte de precios de venta desde ".$f_ini." hasta ".$f_fin.".xls"; //save our workbook as this file name

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0"); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');
        #$this->layout->view('reportes/ventas_por_vendedor', $data);
    }

    public function estado_cuenta() {
        $this->load->library('layout', 'layout');

        $total_soles = '';
        $total_dolares = '';
        $resumen_suma = '';
        $resumen_suma_d = '';
        $resumen_cantidad = '';
        $resumen_fpago = '';
        $cliente = $this->input->post('cliente');
        $proveedor = $this->input->post('proveedor');
        $moneda = $this->input->post('moneda') != '' ? $this->input->post('moneda') : '2';
        $f_ini = $this->input->post('fecha_inicio') != '' ? $this->input->post('fecha_inicio') : '01/' . date('m/Y');
        $f_fin = $this->input->post('fecha_fin') != '' ? $this->input->post('fecha_fin') : date('d/m/Y');
        $lista_moneda = $this->moneda_model->obtener($moneda);
        $moneda_simbolo = $lista_moneda[0]->MONED_Simbolo;
        $total_saldo = 0;
        $lista = array();
        $lista_ultimos = array();
        if ($cliente != '' || $proveedor != '') {
            $listado_cuentas = $this->cuentas_model->buscar(($cliente != '' ? '1' : '2'), ($cliente != '' ? $cliente : $proveedor), array('V', 'A', 'C'), human_to_mysql($f_ini), human_to_mysql($f_fin));
            foreach ($listado_cuentas as $value) {
                $fecha = mysql_to_human($value->CUE_FechaOper);
                $tipo_docu = $value->CPC_TipoDocumento == 'F' ? 'FAC' : 'B';
                $numero = $value->CPC_Serie . '-' . $value->CPC_Numero;
                $simbolo_moneda = $value->MONED_Simbolo;
                $monto = $value->CUE_Monto;
                $monto = cambiar_moneda($monto, $value->CPC_TDC, $value->MONED_Codigo, $moneda);

                $listado_pago = $this->cuentaspago_model->listar($value->CUE_Codigo);
                $lista_pago = array();
                if(count($listado_pago)>0){
                    foreach ($listado_pago as $pago){
                        $lista_pago[] = array(mysql_to_human($pago->PAGC_FechaOper), $pago->MONED_Simbolo, number_format($pago->CPAGC_Monto, 2), $this->pago_model->obtener_forma_pago($pago->PAGC_FormaPago), $pago->PAGC_Obs);
                    }
                
                }
                $saldo = $monto - $this->pago_model->sumar_pagos($listado_pago, $moneda);
                $total_saldo+=$saldo;
                $estado = $value->CUE_FlagEstadoPago == 'C' ? 'CANC' : 'ACT';
                $lista[] = array($fecha, $tipo_docu, $numero, $simbolo_moneda, number_format($monto, 2), $lista_pago, number_format($saldo, 2), $estado);
            }
            $listado_pago = $this->pago_model->listar_ultimos(($cliente != '' ? '1' : '2'), ($cliente != '' ? $cliente : $proveedor), 10);
            $lista_utlimos = array();
            foreach ($listado_pago as $pago) {
                $lista_ultimos[] = array(mysql_to_human($pago->PAGC_FechaOper), $pago->MONED_Simbolo, number_format($pago->PAGC_Monto, 2), $this->pago_model->obtener_forma_pago($pago->PAGC_FormaPago), $pago->PAGC_Obs);
            }
        }



        $data['cliente'] = $cliente;
        $data['ruc_cliente'] = $this->input->post('ruc_cliente');
        $data['nombre_cliente'] = $this->input->post('nombre_cliente');
        $data['proveedor'] = $proveedor;
        $data['ruc_proveedor'] = $this->input->post('ruc_proveedor');
        $data['nombre_proveedor'] = $this->input->post('nombre_proveedor');
        $data['moneda_simbolo'] = $moneda_simbolo;
        $data['cboMoneda'] = form_dropdown("moneda", $this->moneda_model->seleccionar(), $moneda, " class='comboMedio' id='moneda' style='width:150px'");
        $data['f_ini'] = $f_ini;
        $data['f_fin'] = $f_fin;
        $data['lista'] = $lista;
        $data['lista_ultimos'] = $lista_ultimos;
        $data['total_saldo'] = number_format($total_saldo, 2);
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->layout->view('reportes/estado_cuenta', $data);
    }

    public function descargarExcel($fechaini, $fechafin){
        $resultado = $this->ventas_model->ventas_por_dia($fechaini, $fechafin);

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
                                                    'color' => array( 'rgb' => "000000")
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
                                                    'color' => array( 'rgb' => "000000")
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

        ###########################################################################
        ###### HOJA 0 INGRESOS POR DIA
        ###########################################################################

            $tituloReporte = "Reporte de venta por dia";
            $titulosColumnas = array('FECHA DE COMPROBANTE', 'FECHA DE ULTIMO PAGO', 'NRO DOCUMENTO', 'VENTA S/', 'VENTA US$', 'CANCELADO', 'PENDIENTE', 'ESTADO');
            
            $this->excel->setActiveSheetIndex($hoja)->mergeCells('A1:H1');
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth('25');
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth('25');
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth('25');
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth('25');
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth('35');

            $this->excel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($estiloTitulo);
            $this->excel->getActiveSheet()->getStyle('A3:H3')->applyFromArray($estiloColumnasTitulo);
                            
            // Se agregan los titulos del reporte
            $this->excel->setActiveSheetIndex($hoja)
                        ->setCellValue('A1',  $tituloReporte)
                        ->setCellValue('A3',  $titulosColumnas[0])
                        ->setCellValue('B3',  $titulosColumnas[1])
                        ->setCellValue('C3',  $titulosColumnas[2])
                        ->setCellValue('D3',  $titulosColumnas[3])
                        ->setCellValue('E3',  $titulosColumnas[4])
                        ->setCellValue('F3',  $titulosColumnas[5])
                        ->setCellValue('G3',  $titulosColumnas[6])
                        ->setCellValue('H3',  $titulosColumnas[7]);
                
            $i = 4;
            $tota_dolares = 0;
            $tota_soles = 0;

            $pago_soles = 0;
            $pago_dolares = 0;

            $pendiente_soles = 0;
            $pendiente_dolares = 0;

            foreach ($resultado as $value) {
                $numero = $value['SERIE'] ."-". $value['NUMERO'];
     
                $pago = ( $value['FORPAP_Codigo'] == 1 ) ? $value['VENTAS'] : $this->ventas_model->total_pagos($value['CUE_Codigo'], $fechaini, $fechafin);
                $pendiente = $value['VENTAS'] - $pago;
     
                if( $value['MONED_Codigo'] == 2 ){
                    $soles = "0.00";
                    $dolares = $value['VENTAS'];
                    
                    $tota_dolares = $tota_dolares + $dolares;
                    $pago_dolares += $pago;
                    $pendiente_dolares += $pendiente;
                }else{
                    $soles = $value['VENTAS'];
                    $dolares = "0.00";   
                    
                    $tota_soles = $tota_soles + $soles;
                    $pago_soles += $pago;
                    $pendiente_soles += $pendiente;
                }

                switch ($value['CPC_FlagEstado']) {
                    case '0':
                        $status = "ANULADO";
                        $color = "F28A8C";
                        break;

                    default:
                        $status = "APROBADO";
                        $color = "FFFFFF";
                        break;
                }

                $this->excel->setActiveSheetIndex($hoja)
                        ->setCellValue("A$i",  $value['FECHA'])
                        ->setCellValue("B$i",  $value['FECHAPAGO'])
                        ->setCellValue("C$i",  $numero)
                        ->setCellValue("D$i",  $soles)
                        ->setCellValue("E$i",  $dolares)
                        ->setCellValue("F$i",  $pago)
                        ->setCellValue("G$i",  $pendiente)
                        ->setCellValue("H$i",  $status);

                if ( $value['CPC_FlagEstado'] == 0 )
                    $this->excel->getActiveSheet()->getStyle("A$i:H$i")->applyFromArray($colorCelda);

                $i++;
            }
                
            $this->excel->setActiveSheetIndex($hoja)
                        ->setCellValue("C$i", "TOTAL S/")
                        ->setCellValue("D$i", $tota_soles)
                        ->setCellValue("E$i", '')
                        ->setCellValue("F$i", $pago_soles)
                        ->setCellValue("G$i", $pendiente_soles);
            $i++;
            $this->excel->setActiveSheetIndex($hoja)
                        ->setCellValue("C$i", "TOTAL US$")
                        ->setCellValue("D$i", '')
                        ->setCellValue("E$i", $tota_dolares)
                        ->setCellValue("F$i", $pago_dolares)
                        ->setCellValue("G$i", $pendiente_dolares);
            
            $i--;
            $this->excel->getActiveSheet()->getStyle("A$i:H$i")->applyFromArray($estiloColumnasTitulo);
            $i++;
            $this->excel->getActiveSheet()->getStyle("A$i:H$i")->applyFromArray($estiloColumnasTitulo);

            for($i = 'A'; $i < 'D'; $i++){
                $this->excel->setActiveSheetIndex($hoja)->getColumnDimension($i)->setAutoSize(true);
            }
            
            # Se asigna el nombre a la hoja
            $this->excel->getActiveSheet()->setTitle('Ingreso Diario');
            # Se activa la hoja para que sea la que se muestre cuando el archivo se abre
            #$this->excel->setActiveSheetIndex($hoja);
            # INMOBILIZAR FILA
            $this->excel->getActiveSheet($hoja)->freezePaneByColumnAndRow(0,4);

        ###########################################################################
        ###### HOJA 1 VENTAS DEL DIA
        ###########################################################################
            $hoja++;
            $this->excel->createSheet($hoja);
            $this->excel->setActiveSheetIndex($hoja); //Seleccionar la pestaña deseada
            $this->excel->getActiveSheet()->setTitle('Ventas diarias general'); //Establecer nombre

            $this->excel->getActiveSheet()->getStyle("A1:G2")->applyFromArray($estiloTitulo);
            $this->excel->getActiveSheet()->getStyle("A3:G3")->applyFromArray($estiloColumnasTitulo);

            $this->excel->setActiveSheetIndex($hoja)->mergeCells('A1:G2')->setCellValue('A1', $_SESSION['nombre_empresa']);        
            $this->excel->setActiveSheetIndex($hoja)->mergeCells("A3:G3")->setCellValue("A3", "DETALLE DE VENTAS DESDE $fechaini HASTA $fechafin");
            
            $lugar = 4;
            $numeroS = 0;

            $resumen = $this->ventas_model->resumen_ventas($fechaini, $fechafin);

            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", "FECHA DOC.");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar", "FECHA REG.");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar", "SERIE/NUMERO");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar", "CLIENTE");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar", "TOTAL");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar", "NOTA DE CREDITO");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("G$lugar", "TOTAL");
            $this->excel->getActiveSheet()->getStyle("A$lugar:G$lugar")->applyFromArray($estiloColumnasTitulo);

            if ($resumen != NULL){
                $lugar++;
                foreach($resumen as $indice => $valor){
                    $fRegistro = explode(" ", $valor->CPC_FechaRegistro);
                    $this->excel->setActiveSheetIndex($hoja)
                    ->setCellValue("A$lugar", $valor->CPC_Fecha)
                    ->setCellValue("B$lugar", $fRegistro[0])
                    ->setCellValue("C$lugar", $valor->CPC_Serie." - ".$valor->CPC_Numero)
                    ->setCellValue("D$lugar", $valor->clienteEmpresa.$valor->clientePersona)
                    ->setCellValue("E$lugar", $valor->CPC_total)
                    ->setCellValue("F$lugar", $valor->CRED_Serie."-".$valor->CRED_Numero)
                    ->setCellValue("G$lugar", $valor->CRED_Total);
                    if ($indice % 2 == 0)
                        $this->excel->getActiveSheet()->getStyle("A$lugar:G$lugar")->applyFromArray($estiloColumnasPar);
                    else
                        $this->excel->getActiveSheet()->getStyle("A$lugar:G$lugar")->applyFromArray($estiloColumnasImpar);
                    $lugar++;
                }
                $lugar++;
            }

            $this->excel->getActiveSheet()->getColumnDimension("D")->setWidth("45");

            for($i = 'A'; $i <= 'G'; $i++){
                if ($i != "D")
                    $this->excel->setActiveSheetIndex($hoja)->getColumnDimension($i)->setAutoSize(true);
            }

        ###########################################################################
        ###### HOJA 2 VENTAS DEL DIA DETALLADO
        ###########################################################################
            $hoja++;
            $this->excel->createSheet($hoja);
            $this->excel->setActiveSheetIndex($hoja); //Seleccionar la pestaña deseada
            $this->excel->getActiveSheet()->setTitle('Ventas diarias detallado'); //Establecer nombre

            $this->excel->getActiveSheet()->getStyle("A1:O2")->applyFromArray($estiloTitulo);
            $this->excel->getActiveSheet()->getStyle("A3:O3")->applyFromArray($estiloColumnasTitulo);

            $this->excel->setActiveSheetIndex($hoja)->mergeCells('A1:O2')->setCellValue('A1', $_SESSION['nombre_empresa']);        
            $this->excel->setActiveSheetIndex($hoja)->mergeCells("A3:O3")->setCellValue("A3", "DETALLE DE VENTAS DESDE $fechaini HASTA $fechafin");
            
            $lugar = 4;
            $numeroS = 0;

            $resumen = $this->ventas_model->resumen_ventas_detallado($fechaini, $fechafin);

            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", "FECHA DOC.");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar", "FECHA REG.");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar", "SERIE/NUMERO");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar", "CLIENTE");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar", "NOMBRE DE PRODUCTO");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar", "MARCA");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("G$lugar", "LOTE");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("H$lugar", "FECHA VCTO");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("I$lugar", "CANTIDAD");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("J$lugar", "P/U");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("K$lugar", "TOTAL");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("L$lugar", "NOTA DE CREDITO");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("M$lugar", "CANTIDAD");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("N$lugar", "P/U");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("O$lugar", "TOTAL");
            $this->excel->getActiveSheet()->getStyle("A$lugar:O$lugar")->applyFromArray($estiloColumnasTitulo);

            if ($resumen != NULL){
                $lugar++;
                foreach($resumen as $indice => $valor){
                    $fRegistro = explode(" ", $valor->CPC_FechaRegistro);
                    $this->excel->setActiveSheetIndex($hoja)
                    ->setCellValue("A$lugar", $valor->CPC_Fecha)
                    ->setCellValue("B$lugar", $fRegistro[0])
                    ->setCellValue("C$lugar", $valor->CPC_Serie." - ".$valor->CPC_Numero)
                    ->setCellValue("D$lugar", $valor->clienteEmpresa.$valor->clientePersona)
                    ->setCellValue("E$lugar", $valor->PROD_Nombre)
                    ->setCellValue("F$lugar", $valor->MARCC_CodigoUsuario)
                    ->setCellValue("G$lugar", $valor->LOTC_Numero)
                    ->setCellValue("H$lugar", $valor->LOTC_FechaVencimiento)
                    ->setCellValue("I$lugar", $valor->CPDEC_Cantidad)
                    ->setCellValue("J$lugar", $valor->CPDEC_Pu_ConIgv)
                    ->setCellValue("K$lugar", $valor->CPDEC_Total)
                    ->setCellValue("L$lugar", $valor->CRED_Serie."-".$valor->CRED_Numero)
                    ->setCellValue("M$lugar", $valor->CREDET_Cantidad)
                    ->setCellValue("N$lugar", $valor->CREDET_Pu_ConIgv)
                    ->setCellValue("O$lugar", $valor->CREDET_Total);
                    if ($indice % 2 == 0)
                        $this->excel->getActiveSheet()->getStyle("A$lugar:O$lugar")->applyFromArray($estiloColumnasPar);
                    else
                        $this->excel->getActiveSheet()->getStyle("A$lugar:O$lugar")->applyFromArray($estiloColumnasImpar);
                    $lugar++;
                }
                $lugar++;
            }

            $this->excel->getActiveSheet()->getColumnDimension("D")->setWidth("25");
            $this->excel->getActiveSheet()->getColumnDimension("E")->setWidth("25");

            for($i = 'A'; $i <= 'O'; $i++){
                if ($i != 'D' && $i != 'E')
                $this->excel->setActiveSheetIndex($hoja)->getColumnDimension($i)->setAutoSize(true);
            }


        $filename = "Reporte-".date('Y-m-d').".xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function registro_ventas($tipo_oper, $tipo = 'F', $fecha1 = '', $fecha2 = '') {

        $data['cboFormaPago']   = $this->OPTION_generador($this->formapago_model->listar(), 'FORPAP_Codigo', 'FORPAC_Descripcion', '');
        
        $data['cboMoneda']      = $this->OPTION_generador($this->moneda_model->listar(), 'MONED_Codigo', 'MONED_Descripcion', '');
        $data['tipo_docu']      = $tipo;
        $data['tipo_oper']      = $tipo_oper;

        if ($tipo_oper == 'V'){
            $data['titulo_tabla'] = "REPORTE DE VENTAS";
            $data['cboVendedor']    = $this->lib_props->listarVendedores();
        }
        else{
            $data['titulo_tabla'] = "REPORTE DE COMPRAS";
            $data['cboAlmacen']    =$this->almacen_model->getAlmacens();
        }
        
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->layout->view('reportes/registro_ventas', $data);
    }

    public function registro_ventas_table(){

        $tipo_oper      = $this->input->post('tipo_oper');
        $tipo           = $this->input->post('tipo_doc');
        $fecha1         = $this->input->post('fecha1');
        $fecha2         = $this->input->post('fecha2');
        $forma_pago     = $this->input->post('forma_pago');
        $vendedorOrStore       = $this->input->post('vendedorOrStore');
        $moneda         = $this->input->post('moneda');
        $consolidado    = $this->input->post('consolidado');

        if (isset($fecha1) && $fecha1!="" && $fecha1!='1') {
            $fecha1 = $this->input->post('fecha1');
        }
        else{
            $fecha1=date('Y-m-d');
        }
        
        if (isset($fecha2) && $fecha2!="" && $fecha2!='1') {
            $fecha2=$this->input->post('fecha2');
        }
        else{
            $fecha2=date('Y-m-d');
        }
   
        if($tipo_oper=="V"){
            $operacion="Ventas";
        }
        else{
            $operacion="Compras";
        }

        $columns = array(
                            0 => "mes",
                            1 => "CPC_Fecha",
                            2 => "CPC_subtotal",
                            3 => "CPC_igv",
                            4 => "CPC_total",
                            5 => "CPC_TDC",
                            6 => "COMPP_Codigo",
                            7 => "CPC_Serie",
                            8 => "CPC_Numero",
                            9 => "CPC_TipoDocumento",
                            10 => "CPC_FlagEstado",
                            11 => "MONED_Codigo",
                            12 => "MONED_Simbolo",
                            13 => "MONED_Descripcion",
                            14 => "razon_social_cliente",
                            15 => "numero_documento_cliente",
                            16 => "razon_social_proveedor",
                            17 => "numero_documento_proveedor",
                            18 => "gravada",
                            19 => "exonerada",
                            20 => "inafecta",
                            21 => "gratuita",
                            22 => "FORPAC_Descripcion"
                        );

        $params = new stdClass();
        $params->search = $this->input->post("search")["value"];
        $params->limit = $this->input->post("start") . ", " . $this->input->post("length");
        $params->order .= ( $columns[$this->input->post("order")[0]["column"]] != "" && $columns[$this->input->post("order")[0]["dir"]] != "" ) ? $columns[$this->input->post("order")[0]["column"]] . ", " . $columns[$this->input->post("order")[0]["dir"]] : "$columns[1] ASC";
        
        $filter = new stdClass();
        $filter->tipo_oper      = $tipo_oper;
        $filter->tipo           = $tipo;
        $filter->fecha1         = $fecha1;
        $filter->fecha2         = $fecha2;
        $filter->forma_pago     = $forma_pago;
        if($tipo_oper == "C"){
            $filter->almacen       = $vendedorOrStore;
        }else{
            $filter->vendedor       = $vendedorOrStore;
        }
        $filter->moneda         = $moneda;
        $empresa = $this->somevar['empresa'];

        $companias = array();
        $array_compania =  $this->compania_model->listar_establecimiento($empresa);
        foreach ($array_compania as $key => $value){
          
          $companias[] = $value->COMPP_Codigo;
          
        }
        $companias = implode("','",$companias);
   
        $filter->consolidado    = $consolidado;
        $filter->companias      = $companias;
        

        $info = $this->ventas_model->resumen_ventas_mensual($filter);

        $cantidad_fac   = 0;
        $total_fac      = 0;
        $total_bol      = 0;
        $total_comp     = 0;
        $total_nota     = 0;
        $total          = 0;
        $total_fac_dolar      = 0;
        $total_bol_dolar      = 0;
        $total_comp_dolar     = 0;
        $total_nota_dolar     = 0;
        $total_dolar          = 0;
        $cont_facturas        = 0;
        $cont_boletas         = 0;
        $cont_notas           = 0;
        $cont_comprob         = 0;
        foreach ($info as $row => $col) {
            //LA CONSULTA TRAE UNO DE LOS CAMPOS COMO "INDEFINIDA" => AQUI SE ELIMINA LA PALABRA PARA QUE NO APAREZCA EN LA VISTA
            $resultado = str_replace("indefinida", "", $col->razon_social_cliente);
            $col->razon_social_cliente = $resultado;
            $tachado1="";
            $tachado2="";
            $fecha = explode("-", $col->CPC_Fecha);
            $col->CPC_Fecha = $fecha[2]."/".$fecha[1]."/".$fecha[0];

            $fecha_ven = explode("-", $col->CPC_FechaVencimiento);
            $col->CPC_FechaVencimiento = $fecha_ven[2]."/".$fecha_ven[1]."/".$fecha_ven[0];

            //DESGLOSE
            $igv            = $col->CPC_igv;
            $total_compr    = $col->CPC_total;
            $total_gravada  = $col->gravada;
            $exonerada      = $col->exonerada;
            $inafecta       = $col->inafecta;
            $gratuita       = $col->gratuita;

            if($col->CPC_FlagEstado=='1'){
                
                if ($col->MONED_Codigo==1) {
                    if($col->CPC_TipoDocumento=="C"){
                        $total -= $col->CPC_total;
                    }else{
                        $total += $col->CPC_total;
                    }
                }elseif($col->MONED_Codigo==2) {
                    if($col->CPC_TipoDocumento=="C"){
                        $total_dolar -= $col->CPC_total;
                    }else{
                        $total_dolar += $col->CPC_total;
                    }
                        
                }

                if($col->CPC_TipoDocumento=="F"){
                    $cont_facturas++;
                    $col->CPC_TipoDocumento="FACTURA";
                    if ($col->MONED_Codigo==1) {
                        $total_fac += $col->CPC_total;
                    }elseif($col->MONED_Codigo==2) {
                        $total_fac_dolar+=$col->CPC_total;
                    }
                }

                if($col->CPC_TipoDocumento=="P"){
                    $col->CPC_TipoDocumento="PEDIDO";
                    
                }

                if($col->CPC_TipoDocumento=="B"){
                    $cont_boletas++;
                    if ($col->MONED_Codigo==1) {
                        $total_bol += $col->CPC_total;
                    }elseif($col->MONED_Codigo==2) {
                        $total_bol_dolar+=$col->CPC_total;
                    }
                     $col->CPC_TipoDocumento="BOLETA";
                }

                if($col->CPC_TipoDocumento=="N"){
                    $cont_notas++;
                    if ($col->MONED_Codigo==1) {
                        $total_comp += $col->CPC_total;
                    }elseif($col->MONED_Codigo==2) {
                        $total_comp_dolar+=$col->CPC_total;
                    }
                     $col->CPC_TipoDocumento="COMPROBANTE";
                }

                if($col->CPC_TipoDocumento=="C"){
                    $cont_comprob++;
                    if ($col->MONED_Codigo==1) {
                        $total_nota += $col->CPC_total;
                    }elseif($col->MONED_Codigo==2) {
                        $total_nota_dolar+=$col->CPC_total;
                    }

                    $col->CPC_TipoDocumento="NOTA CREDITO";
                    $col->FORPAC_Descripcion="-";
                    $igv            = "-".$igv;
                    $total_compr    = "-".$total_compr;
                    $total_gravada  = "-".$total_gravada;
                    $exonerada      = "-".$exonerada;
                    $inafecta       = "-".$inafecta;
                    $gratuita       = "-".$gratuita;
                }

                $col->CPC_FlagEstado='<font color="green">APROBADO</font>';

            }elseif($col->CPC_FlagEstado=='0'){
                if($col->CPC_TipoDocumento=="F"){
                    $col->CPC_TipoDocumento="FACTURA";
                    
                }if($col->CPC_TipoDocumento=="B"){
                   
                     $col->CPC_TipoDocumento="BOLETA";
                }if($col->CPC_TipoDocumento=="N"){
                    
                     $col->CPC_TipoDocumento="COMPROBANTE";
                }if($col->CPC_TipoDocumento=="C"){
                    
                     $col->CPC_TipoDocumento="NOTA CREDITO";
                     $col->FORPAC_Descripcion="-";
                }if($col->CPC_TipoDocumento=="P"){
                    
                     $col->CPC_TipoDocumento="PEDIDO";
                     
                }
                $col->CPC_FlagEstado='<font color="red">ANULADO</font>';
                $tachado1="<strike>";
                $tachado2="</strike>";
            }
            if ($tipo_oper=="V") {
                $denominacion   = $col->razon_social_cliente;
                $num_doc        = $col->numero_documento_cliente;
            }else{
                $denominacion   = $col->razon_social_proveedor;
                $num_doc        = $col->numero_documento_proveedor;

            }


            $item=$row+1;
           
           
            $data[$row] = array(
                                "item"                  => $item,//0
                                "fecha"                 => $col->CPC_Fecha,//1
                                "fecha_ven"             => $col->CPC_FechaVencimiento,//1
                                "subtotal"              => $col->CPC_subtotal,//2
                                "igv"                   => $col->CPC_igv,//3
                                "total"                 => $total_compr,//4
                                "tdc"                   => $col->CPC_TDC,//5
                                "COMPP_Codigo"          => $col->COMPP_Codigo,//6
                                "serie"                 => $col->CPC_Serie.' '.$col->CPC_Numero,//7
                                "tipo_documento"        => $col->CPC_TipoDocumento,//9
                                "estado"                => $col->CPC_FlagEstado,//10
                                "MONED_Codigo"          => $col->MONED_Codigo,//11
                                "MONED_Simbolo"         => $col->MONED_Simbolo,//12
                                "moneda"                => $col->MONED_Descripcion,//13
                                "razon_social"          => $denominacion,//14
                                "num_doc"               => $num_doc,//15
                                "proveedor"             => $col->razon_social_proveedor,//16
                                "ruc_proveedor"         => $col->numero_documento_proveedor,//17
                                "gravada"               => $total_gravada,//18
                                "exonerada"             => $exonerada,//19
                                "inafecta"              => $inafecta,//20
                                "gratuita"              => $gratuita,//21
                                "FORPAC_Descripcion"    => $col->FORPAC_Descripcion,//22
                                "MONED_Descripcion"     => $col->MONED_Descripcion,//23
                                "tachado1"              => $tachado1,//24
                                "tachado2"              => $tachado2
                               
                            );

        }
        $totales = array(
                        "total"             => number_format($total,2), //0
                        "total_fac"         => number_format($total_fac,2), //1
                        "total_bol"         => number_format($total_bol,2), //2
                        "total_comp"        => number_format($total_comp,2), //3
                        "total_nota"        => number_format($total_nota,2), //4
                        "total_fac_dolar"   => number_format($total_fac_dolar,2), //5
                        "total_bol_dolar"   => number_format($total_bol_dolar,2), //6
                        "total_comp_dolar"  => number_format($total_comp_dolar,2), //7
                        "total_nota_dolar"  => number_format($total_nota_dolar,2), //8
                        "total_dolar"       => number_format($total_dolar,2), //9
                        "cantidad"          => $item,
                        "cont_facturas"     => $cont_facturas,//26
                        "cont_boletas"      => $cont_boletas, //27
                        "cont_notas"        => $cont_notas,   //28
                        "cont_comprob"      => $cont_comprob //29 //10
                    );

        $datos = array('data' =>$data,'totales' =>$totales);
        $json = $datos;

        echo json_encode($json);
    }

    /********************************************************
    * Funcion: CONCAR
    * crea reporte concar
    * Luis Valdes 09/10/2020  
    * Modificaciones ->  
    ********************************************************/

    public function concar($tipo_oper = "V", $tipo = "", $fecha1 = "", $fecha2 = "", $forma_pago = "", $vendedor = "", $moneda = "", $consolidado=""){

        if (isset($tipo) && $tipo!="" && $tipo!="-") {
            $tipo = $tipo;
        }else{
            $tipo = "";
        }
        if (isset($forma_pago) && $forma_pago!="" && $forma_pago!="-") {
            $forma_pago = $forma_pago;
        }else{
            $forma_pago = "";
        }

        if (isset($vendedor) && $vendedor!="" && $vendedor!="-") {
            $vendedor = $vendedor;
        }else{
            $vendedor = "";
        }
        if (isset($moneda) && $moneda!="" && $moneda!="-") {
            $moneda = $moneda;
        }else{
            $moneda = "";
        }
        if (isset($fecha1) && $fecha1!="" && $fecha1!=1) {
            $fecha1 = $fecha1;
        }else{
            $fecha1 = date('Y-m-d');
        }
        if (isset($fecha2) && $fecha2!="" && $fecha2!=1) {
            $fecha2 = $fecha2;
        }else{
            $fecha2 = date('Y-m-d');
        }    
        switch ($tipo_oper) {
            case 'C':
                    $operacion = "COMPRA";
                break;
            case 'V':
                    $operacion = "VENTA";
                break;
            
            default:
                    $operacion = "";
                break;
        }
                $fecha_ini = explode("-", $fecha1);
        $fecha_fin = explode("-", $fecha2);
        $fecha_inicio = $fecha_ini[2]."/".$fecha_ini[1]."/".$fecha_ini[0];
        $fecha_final = $fecha_fin[2]."/".$fecha_fin[1]."/".$fecha_fin[0];
                
                $filter = new stdClass();
        $filter->tipo_oper      = $tipo_oper;
        #$filter->tipo           = $tipo;
        $filter->fecha1         = $fecha1;
        $filter->fecha2         = $fecha2;
        #$filter->forma_pago     = $forma_pago;
        #$filter->vendedor       = $vendedor;
        #$filter->moneda         = $moneda;
        $filter->consolidado    = $consolidado;

        $reporte = $this->ventas_model->concar_model($filter);
        
        #############################################################
        #
        # INICION DE CREACION EXCEL CONCAR
        #
        #############################################################

        $this->load->library("Excel");
            $object = new PHPExcel();
            $object->setActiveSheetIndex(0);

            #INICIO CONFIGURACION DE CABECERAS
            /*INICIO CONFIGURACION DE CABECERAS*/
                $object->setActiveSheetIndex(0)->setCellValue('A1', 'Campo');
                $object->setActiveSheetIndex(0)->setCellValue('B1', 'Sub Diario');
                $object->setActiveSheetIndex(0)->setCellValue('C1', 'Número de Comprobante');
                $object->setActiveSheetIndex(0)->setCellValue('D1', 'Fecha de Comprobante');
                $object->setActiveSheetIndex(0)->setCellValue('E1', 'Código de Moneda');
                $object->setActiveSheetIndex(0)->setCellValue('F1', 'Glosa Principal');
                $object->setActiveSheetIndex(0)->setCellValue('G1', 'Tipo de Cambio');
                $object->setActiveSheetIndex(0)->setCellValue('H1', 'Tipo de Conversión');
                $object->setActiveSheetIndex(0)->setCellValue('I1', 'Flag de Conversión de Moneda');
                $object->setActiveSheetIndex(0)->setCellValue('J1', 'Fecha Tipo de Cambio');
                $object->setActiveSheetIndex(0)->setCellValue('K1', 'Cuenta Contable');
                $object->setActiveSheetIndex(0)->setCellValue('L1', 'Código de Anexo'); 
                $object->setActiveSheetIndex(0)->setCellValue('M1', 'Código de Centro de Costo');
                $object->setActiveSheetIndex(0)->setCellValue('N1', 'Debe / Haber');
                $object->setActiveSheetIndex(0)->setCellValue('O1', 'Importe Original');
                $object->setActiveSheetIndex(0)->setCellValue('P1', 'Importe en Dólares');
                $object->setActiveSheetIndex(0)->setCellValue('Q1', 'Importe en Soles');
                $object->setActiveSheetIndex(0)->setCellValue('R1', 'Tipo de Documento');
                $object->setActiveSheetIndex(0)->setCellValue('S1', 'Número de Documento');
                $object->setActiveSheetIndex(0)->setCellValue('T1', 'Fecha de Documento');
                $object->setActiveSheetIndex(0)->setCellValue('U1', 'Fecha de Vencimiento');
                $object->setActiveSheetIndex(0)->setCellValue('V1', 'Código de Area');
                $object->setActiveSheetIndex(0)->setCellValue('W1', 'Glosa Detalle');
                $object->setActiveSheetIndex(0)->setCellValue('X1', 'Código de Anexo Auxiliar');
                $object->setActiveSheetIndex(0)->setCellValue('Y1', 'Medio de Pago');
                $object->setActiveSheetIndex(0)->setCellValue('Z1', 'Tipo de Documento de Referencia');
                
                $object->setActiveSheetIndex(0)->setCellValue('AA1', 'Número de Documento Referencia');
                $object->setActiveSheetIndex(0)->setCellValue('AB1', 'Fecha Documento Referencia');
                $object->setActiveSheetIndex(0)->setCellValue('AC1', 'Nro Máq. Registradora Tipo Doc. Ref.');
                $object->setActiveSheetIndex(0)->setCellValue('AD1', 'Base Imponible Documento Referencia');
                $object->setActiveSheetIndex(0)->setCellValue('AE1', 'IGV Documento Provisión');
                $object->setActiveSheetIndex(0)->setCellValue('AF1', 'Tipo Referencia en estado MQ');
                $object->setActiveSheetIndex(0)->setCellValue('AG1', 'Número Serie Caja Registradora');
                $object->setActiveSheetIndex(0)->setCellValue('AH1', 'Fecha de Operación');
                $object->setActiveSheetIndex(0)->setCellValue('AI1', 'Tipo de Tasa');
                $object->setActiveSheetIndex(0)->setCellValue('AJ1', 'Tasa Detracción/Percepción');
                $object->setActiveSheetIndex(0)->setCellValue('AK1', 'Importe Base Detracción/Percepción Dólares');
                $object->setActiveSheetIndex(0)->setCellValue('AL1', 'Importe Base Detracción/Percepción Soles');
                $object->setActiveSheetIndex(0)->setCellValue('AM1', 'Tipo Cambio para \'F\'');
                $object->setActiveSheetIndex(0)->setCellValue('AN1', 'Importe de IGV sin derecho crédito fiscal');
            
            
                $object->setActiveSheetIndex(0)->setCellValue('A2', 'Restricciones');
                $object->setActiveSheetIndex(0)->setCellValue('B2', 'Ver T.G. 02');
                $object->setActiveSheetIndex(0)->setCellValue('C2', 'Los dos primeros dígitos son el mes y los otros 4 siguientes un correlativo');
                $object->setActiveSheetIndex(0)->setCellValue('D2', '');
                $object->setActiveSheetIndex(0)->setCellValue('E2', 'Ver T.G. 03');
                $object->setActiveSheetIndex(0)->setCellValue('F2', '');
                $object->setActiveSheetIndex(0)->setCellValue('G2', 'Llenar  solo si Tipo de Conversión es "C". Debe estar entre >=0 y <=9999.999999');
                $object->setActiveSheetIndex(0)->setCellValue('H2', 'Solo: "C"= Especial,"M"=Compra,"V"=Venta , "F" De acuerdo a fecha');
                $object->setActiveSheetIndex(0)->setCellValue('I2', 'Solo: "S" =Si se convierte, "N"= No se convierte');
                $object->setActiveSheetIndex(0)->setCellValue('J2', 'Si Tipo de Conversión "F"');
                $object->setActiveSheetIndex(0)->setCellValue('K2', 'Debe existir en la Tabla de Plan de Cuentas');
                $object->setActiveSheetIndex(0)->setCellValue('L2', 'Si Cuenta Contable tiene seleccionado Tipo de Anexo debe existir en la tabla de Anexos');
                $object->setActiveSheetIndex(0)->setCellValue('M2', 'Si Cuenta Contable tiene habilitado C. Costo, Ver T.G. 05');
                $object->setActiveSheetIndex(0)->setCellValue('N2', '"D" ó "H"');
                $object->setActiveSheetIndex(0)->setCellValue('O2', 'Importe original de la cuenta contable.Si Flag de Conversión de Moneda esta en ´S´, debe estar entre >=0 y <=99999999999.99');
                $object->setActiveSheetIndex(0)->setCellValue('P2', 'Importe de la Cuenta Contable en Dólares. Obligatorio si Flag de Conversión de Moneda esta en "N", debe estar entre >=0 y <=99999999999.99 ');
                $object->setActiveSheetIndex(0)->setCellValue('Q2', 'Importe de la Cuenta Contable en Soles. Obligatorio si Flag de Conversión de Moneda esta en "N", debe estra entre >=0 y <=99999999999.99 ');
                $object->setActiveSheetIndex(0)->setCellValue('R2', 'Si Cuenta Contable tiene habilitado le Documento Referencia Ver. T.G. 06');
                $object->setActiveSheetIndex(0)->setCellValue('S2', 'Si Cuenta Contable tiene habilitado el Documento Referencia Incluye Serie y Número');
                $object->setActiveSheetIndex(0)->setCellValue('T2', 'Si Cuenta Contable tiene Habilitado de Documento Referencia');
                $object->setActiveSheetIndex(0)->setCellValue('U2', 'Si Cuenta Contable tiene habilitado la Fecha de Vencimiento');
                $object->setActiveSheetIndex(0)->setCellValue('V2', 'Si Cuenta Contable tiene habilitado Area. Ver T.G. 26');
                $object->setActiveSheetIndex(0)->setCellValue('W2', '');
                $object->setActiveSheetIndex(0)->setCellValue('X2', 'Si Cuenta Contable tiene seleccionado Tipo de Anexo Referencia');
                $object->setActiveSheetIndex(0)->setCellValue('Y2', 'Si Cuenta Contable tiene habilitado Tipo Medio Pago Ver T.G. "S1"');
                $object->setActiveSheetIndex(0)->setCellValue('Z2', 'Si Tipo de Documento es "NA" ó "ND" Ver T.G. 06');
                
                $object->setActiveSheetIndex(0)->setCellValue('AA2', 'Si Tipo de Documento es "NC", "NA" ó "ND", incluye Serie y Número');
                $object->setActiveSheetIndex(0)->setCellValue('AB2', 'Si tipo de Documento es "NC", "NA" ó "ND"');
                $object->setActiveSheetIndex(0)->setCellValue('AC2', 'Si tipo de Documento es "NC", "NA" ó "ND". Solo cuando el Tipo Documento de Referencia "TK"');
                $object->setActiveSheetIndex(0)->setCellValue('AD2', 'Si tipo de Documento es "NC", "NA" ó "ND"');
                $object->setActiveSheetIndex(0)->setCellValue('AE2', 'Si tipo de Documento es "NC", "NA" ó "ND"');
                $object->setActiveSheetIndex(0)->setCellValue('AF2', 'Si la Cuenta Contable tiene Habilitado Documents Referencia 2 y tipo de Documento es "TK"');
                $object->setActiveSheetIndex(0)->setCellValue('AG2', 'Si la Cuenta Contable tiene Habilitado Documents Referencia 2 y tipo de Documento es "TK"');
                $object->setActiveSheetIndex(0)->setCellValue('AH2', 'Si la Cuenta Contable tiene Habilitado Documento Referencia 2. Cuando Tipo de Documento es "TK", consignar la fecha de emision del ticket');
                $object->setActiveSheetIndex(0)->setCellValue('AI2', 'Si la Cuenta Contable tiene conf. en tasa: Si es "1" ver T.G 28 y "2" ver T.G. 29.');
                $object->setActiveSheetIndex(0)->setCellValue('AJ2', 'Si la Cuenta Contable tiene configurada la tasa: Si es "1" ver T.G 28 y "2" ver T.G. 29. Debe estar entre >=0 y <=999.99');
                $object->setActiveSheetIndex(0)->setCellValue('AK2', 'Si la Cuenta Contable tiene configurada la Tasa. Debe ser el importe total del documento y estar entre >=0 y <=99999999999.99');
                $object->setActiveSheetIndex(0)->setCellValue('AL2', 'Si la Cuenta Contable tiene configurada la Tasa. Debe ser el importe total del documento y estar entre >=0 y <=99999999999.99');
                $object->setActiveSheetIndex(0)->setCellValue('AM2', 'Especificar solo si Tipo Conversión es "F". Se permite "M" Compra y "V" Venta.');
                $object->setActiveSheetIndex(0)->setCellValue('AN2', 'Especificar solo para comprobantes de compras con IGV sin derecho de crédito Fiscal. Se detalle solo en la cuenta 42xxxx');
                

                $object->setActiveSheetIndex(0)->setCellValue('A3', 'Tamaño/Formato');
                $object->setActiveSheetIndex(0)->setCellValue('B3', '2 Caracteres');
                $object->setActiveSheetIndex(0)->setCellValue('C3', '6 Caracteres');
                $object->setActiveSheetIndex(0)->setCellValue('D3', 'dd/mm/aaaa');
                $object->setActiveSheetIndex(0)->setCellValue('E3', '2 Caracteres');
                $object->setActiveSheetIndex(0)->setCellValue('F3', '40 Caracteres');
                $object->setActiveSheetIndex(0)->setCellValue('G3', 'Numérico 11, 6');
                $object->setActiveSheetIndex(0)->setCellValue('H3', '1 Caracteres');
                $object->setActiveSheetIndex(0)->setCellValue('I3', '1 Caracteres');
                $object->setActiveSheetIndex(0)->setCellValue('J3', 'dd/mm/aaaa');
                $object->setActiveSheetIndex(0)->setCellValue('K3', '8 Caracteres');
                $object->setActiveSheetIndex(0)->setCellValue('L3', '18 Caracteres');
                $object->setActiveSheetIndex(0)->setCellValue('M3', '6 Caracteres');    
                $object->setActiveSheetIndex(0)->setCellValue('N3', '1 Carácter');
                $object->setActiveSheetIndex(0)->setCellValue('O3', 'Numérico 14,2');
                $object->setActiveSheetIndex(0)->setCellValue('P3', 'Numérico 14,2');
                $object->setActiveSheetIndex(0)->setCellValue('Q3', 'Numérico 14,2');
                $object->setActiveSheetIndex(0)->setCellValue('R3', '2 Caracteres');
                $object->setActiveSheetIndex(0)->setCellValue('S3', '20 Caracteres');
                $object->setActiveSheetIndex(0)->setCellValue('T3', 'dd/mm/aaaa');
                $object->setActiveSheetIndex(0)->setCellValue('U3', 'dd/mm/aaaa');
                $object->setActiveSheetIndex(0)->setCellValue('V3', '3 Caracteres');
                $object->setActiveSheetIndex(0)->setCellValue('W3', '30 Caracteres');
                $object->setActiveSheetIndex(0)->setCellValue('X3', '18 Caracteres');
                $object->setActiveSheetIndex(0)->setCellValue('Y3', '8 Caracteres');
                $object->setActiveSheetIndex(0)->setCellValue('Z3', '2 Caracteres');
            
                $object->setActiveSheetIndex(0)->setCellValue('AA3', '20 Caracteres');
                $object->setActiveSheetIndex(0)->setCellValue('AB3', 'dd/mm/aaaa');
                $object->setActiveSheetIndex(0)->setCellValue('AC3', '20 Caracteres');
                $object->setActiveSheetIndex(0)->setCellValue('AD3', 'Númerico 14, 2');
                $object->setActiveSheetIndex(0)->setCellValue('AE3', 'Númerico 14, 2');
                $object->setActiveSheetIndex(0)->setCellValue('AF3', 'MQ');
                $object->setActiveSheetIndex(0)->setCellValue('AG3', '15 Caracteres');
                $object->setActiveSheetIndex(0)->setCellValue('AH3', 'dd/mm/aaaa');
                $object->setActiveSheetIndex(0)->setCellValue('AI3', '5 Caracteres');
                $object->setActiveSheetIndex(0)->setCellValue('AJ3', 'Númerico 14, 2');
                $object->setActiveSheetIndex(0)->setCellValue('AK3', 'Númerico 14, 2');
                $object->setActiveSheetIndex(0)->setCellValue('AL3', 'Númerico 14, 2');
                $object->setActiveSheetIndex(0)->setCellValue('AM3', '1 Caracter');
                $object->setActiveSheetIndex(0)->setCellValue('AN3', 'Númerico 14, 2');
                #FIN NOMBRE DE CABECERAS

                            $estilo = array( 
                      'borders' => array(
                        'outline' => array(
                          'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                      )
                        );
                        /* #INICIO ESTILOS*/
                         $object->getActiveSheet()->getStyle('A1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('B1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('C1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('D1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('E1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('F1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('G1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('H1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('I1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('J1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('K1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('L1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('M1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('N1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('O1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('P1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('Q1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('R1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('S1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('T1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('U1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('V1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('X1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('Y1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('Z1')->applyFromArray($estilo);
                    
                         $object->getActiveSheet()->getStyle('AA1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AB1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AC1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AD1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AE1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AF1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AG1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AH1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AI1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AJ1')->applyFromArray($estilo);        
                         $object->getActiveSheet()->getStyle('AK1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AL1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AM1')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AN1')->applyFromArray($estilo);        

                         $object->getActiveSheet()->getStyle('A2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('B2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('C2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('D2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('E2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('F2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('G2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('H2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('I2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('J2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('K2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('L2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('M2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('N2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('O2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('P2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('Q2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('R2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('S2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('T2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('U2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('V2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('X2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('Y2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('Z2')->applyFromArray($estilo);

                         $object->getActiveSheet()->getStyle('AA2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AB2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AC2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AD2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AE2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AF2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AG2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AH2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AI2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AJ2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AK2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AL2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AM2')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AN2')->applyFromArray($estilo);


                         $object->getActiveSheet()->getStyle('A3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('B3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('C3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('D3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('E3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('F3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('G3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('H3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('I3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('J3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('K3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('L3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('M3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('N3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('O3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('P3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('Q3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('R3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('S3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('T3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('U3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('V3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('X3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('Y3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('Z3')->applyFromArray($estilo);

                         $object->getActiveSheet()->getStyle('AA3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AB3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AC3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AD3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AE3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AF3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AG3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AH3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AI3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AJ3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AK3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AL3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AM3')->applyFromArray($estilo);
                         $object->getActiveSheet()->getStyle('AN3')->applyFromArray($estilo);

                             $estiloletra = array(
                        'font'  => array(
                            'bold'  => true,
                            'size'  => 8,
                            'name'  => 'Calibri'
                         ));

                            $object->getActiveSheet()->getStyle('A1:AN3')->applyFromArray($estiloletra);

                            $centrar = array(
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        )
                        );
                            $object->getActiveSheet()->getStyle("A1:AN3")->applyFromArray($centrar);

                            $object->getActiveSheet()->getColumnDimension('A')->setWidth(12); 
                            $object->getActiveSheet()->getColumnDimension('B')->setWidth(12); 
                            $object->getActiveSheet()->getColumnDimension('C')->setWidth(20); 
                            $object->getActiveSheet()->getColumnDimension('D')->setWidth(12); 
                            $object->getActiveSheet()->getColumnDimension('E')->setWidth(15); 
                            $object->getActiveSheet()->getColumnDimension('F')->setWidth(12); 
                            $object->getActiveSheet()->getColumnDimension('G')->setWidth(12); 
                            $object->getActiveSheet()->getColumnDimension('H')->setWidth(12); 
                            $object->getActiveSheet()->getColumnDimension('I')->setWidth(25); 
                            $object->getActiveSheet()->getColumnDimension('J')->setWidth(18); 
                            $object->getActiveSheet()->getColumnDimension('K')->setWidth(12); 
                            $object->getActiveSheet()->getColumnDimension('L')->setWidth(12); 
                            $object->getActiveSheet()->getColumnDimension('M')->setWidth(12); 
                            $object->getActiveSheet()->getColumnDimension('N')->setWidth(12); 
                            $object->getActiveSheet()->getColumnDimension('O')->setWidth(9); 
                            $object->getActiveSheet()->getColumnDimension('P')->setWidth(9); 
                            $object->getActiveSheet()->getColumnDimension('Q')->setWidth(13); 
                            $object->getActiveSheet()->getColumnDimension('R')->setWidth(6); 
                            $object->getActiveSheet()->getColumnDimension('S')->setWidth(15); 
                            $object->getActiveSheet()->getColumnDimension('T')->setWidth(15); 
                            $object->getActiveSheet()->getColumnDimension('U')->setWidth(16); 
                            $object->getActiveSheet()->getColumnDimension('V')->setWidth(11); 
                            $object->getActiveSheet()->getColumnDimension('W')->setWidth(11); 
                            $object->getActiveSheet()->getColumnDimension('X')->setWidth(6); 
                            $object->getActiveSheet()->getColumnDimension('Y')->setWidth(11); 
                            $object->getActiveSheet()->getColumnDimension('Z')->setWidth(11); 
                            $object->getActiveSheet()->getColumnDimension('AA')->setWidth(6); 
                            $object->getActiveSheet()->getColumnDimension('AB')->setWidth(11); 
                            $object->getActiveSheet()->getColumnDimension('AC')->setWidth(11); 
                            $object->getActiveSheet()->getColumnDimension('AD')->setWidth(6); 
                            $object->getActiveSheet()->getColumnDimension('AE')->setWidth(11); 
                            $object->getActiveSheet()->getColumnDimension('AF')->setWidth(11); 
                            $object->getActiveSheet()->getColumnDimension('AG')->setWidth(6); 
                            $object->getActiveSheet()->getColumnDimension('AH')->setWidth(11); 
                            $object->getActiveSheet()->getColumnDimension('AI')->setWidth(11); 
                            $object->getActiveSheet()->getColumnDimension('AJ')->setWidth(6); 
                            $object->getActiveSheet()->getColumnDimension('AK')->setWidth(6); 
                            $object->getActiveSheet()->getColumnDimension('Al')->setWidth(11); 
                            $object->getActiveSheet()->getColumnDimension('AM')->setWidth(11); 
                            $object->getActiveSheet()->getColumnDimension('AN')->setWidth(6); 

            /*#FIN CABECERAS*/

                #LLENADO DE DATOS
              $numCorrelativo = 0;
              $excel_row = 4;
                foreach ($reporte as $key => $row) {
                    $sn_modificado      = "";
                    $fecha_docu_refe    = "";
                    $tipo_doc_modifica  = "";
                    $nota_comprobante   = "";
                    $base_imponible     = "";
                    $codigo             = $row->codigo;
                    $num_doc            = $row->numero_documento_cliente;
                    $serie              = $row->serie;
                    $numero_sin_ceros   = $row->numero;
                    $numero             = str_pad($numero_sin_ceros, 6, "0", STR_PAD_LEFT);
                    $tipo_doc           = $row->tipo_doc;
                    $cliente            = $row->razon_social_cliente;
                    if(strlen($cliente)>15){
                        $cliente = substr($cliente, 0, 15);
                    }
                    $ser_num            = "FT ".$serie."-".$numero;
                    $glosa              = $cliente.",".$ser_num;
                    switch ($tipo_doc){
                        case 'F':
                            $TipoDetalle="FT";
                            $cuenta = "121201";
                            $detalle_comprobante = $this->ventas_model->detalles_concar_comprobantes($codigo);
                            $nota_comprobante       = $this->comprobante_model->validacion_NC($codigo); 
                            break;
                        case 'B':
                            $TipoDetalle="BV";
                            $cuenta = "121203";
                            $detalle_comprobante = $this->ventas_model->detalles_concar_comprobantes($codigo);
                            $nota_comprobante       = $this->comprobante_model->validacion_NC($codigo); 
                            
                            break;
                        case 'NC':
                            $TipoDetalle = "NA";
                            $detalle_comprobante = $this->ventas_model->detalle_concar_nota($codigo);

                            break;
                        
                        default:
                            $TipoDetalle = "NA";
                            break;
                    }           
                    #SE VERIFICA SI TIENE NOTA DE CREDITO O DEBITO ASOCIADO
                    if ($nota_comprobante!=null && $nota_comprobante!="") {
                        $sn_modificado          = $nota_comprobante[0]->CRED_Serie."-".$nota_comprobante[0]->CRED_Numero;
                        $fecha_docu_refe        = mysql_to_human($nota_comprobante[0]->CRED_Fecha);
                        $tipo_doc_nota          = $nota_comprobante[0]->CRED_TipoNota;
                        switch ($tipo_doc_nota) {
                            case 'C':
                                $tipo_doc_modifica  = "NC";
                                break;
                            case 'D':
                                $tipo_doc_modifica  = "ND";
                                break;
                        }   
                        
                        $base_imponible = $nota_comprobante[0]->CRED_total;
                    }

                    $numCorrelativo++;
                    $fecha = explode("-", $row->fecha);
                    $fecha_doc = $fecha[2]."/".$fecha[1]."/".$fecha[0];
                    $numComprobante = $fecha[1];
                    $numCorrelativoceros = str_pad($numCorrelativo, 4, "0", STR_PAD_LEFT); 
                    $numComprobante = $numComprobante . $numCorrelativoceros;
                    
                    $fecha_v = ($row->fecha_venci!="" || $row->fecha_venci!="" ? $row->fecha_venci : $row->fecha);
                    $fechav = explode("-", $fecha_v);
                    $fecha_venci = $fechav[2]."/".$fechav[1]."/".$fechav[0];


                    $producto  = 0;
                    $Dinicial  = 0;
                    $Dfinal    = 0;
                    $producto  = 0;
                    $DH        = "";
                    
                    for ($i=0; $i < 2 ; $i++) { 
                        
                        if ($i==1) {
                            $cuentaTotal = number_format($row->igv,2,'.',''); //IGV TOTAL
                            $cuenta="401111";
                            $DH="H";
                           
                        } else {
                            $cuentaTotal = number_format($row->total,2,'.',''); //TOTALES
                            $DH="D";
                            

                        }

                        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, "");                                       //A
                        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, "05");                                 //B
                        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $numComprobante);          //C
                        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $fecha_doc);                       //D
                        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, "MN");                                 //E
                        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $glosa);                         //F
                        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row,"");                                        //G
                        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, "M");                                  //H
                        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, "S");                                  //I
                        $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $fecha_doc);                       //J
                        $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $cuenta);                         //K
                        $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $num_doc);                        //L
                        $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, "");                                  //M
                        $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $DH);                                 //N
                        $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row,$cuentaTotal );                //O
                        $object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, "");                                  //P
                        $object->getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, "");                                  //Q
                        $object->getActiveSheet()->setCellValueByColumnAndRow(17, $excel_row, $TipoDetalle);                //R
                        $object->getActiveSheet()->setCellValueByColumnAndRow(18, $excel_row, $serie.'-'.$numero);//S
                        $object->getActiveSheet()->setCellValueByColumnAndRow(19, $excel_row, $fecha_doc);                  //T
                        $object->getActiveSheet()->setCellValueByColumnAndRow(20, $excel_row, $fecha_venci);                  //U
                        $object->getActiveSheet()->setCellValueByColumnAndRow(21, $excel_row, "");                                  //V
                        $object->getActiveSheet()->setCellValueByColumnAndRow(22, $excel_row, $glosa);                         //W
                        $object->getActiveSheet()->setCellValueByColumnAndRow(23, $excel_row, "");                                  //X
                        $object->getActiveSheet()->setCellValueByColumnAndRow(24, $excel_row, "");                                  //Y
                        $object->getActiveSheet()->setCellValueByColumnAndRow(25, $excel_row, $tipo_doc_modifica);  //Z TIPO DOC REFERENCIA(ND O NC)
                        $object->getActiveSheet()->setCellValueByColumnAndRow(26, $excel_row, $sn_modificado);//AA 
                        $object->getActiveSheet()->setCellValueByColumnAndRow(27, $excel_row, $fecha_docu_refe);                                    //AB fecha docu refe
                        $object->getActiveSheet()->setCellValueByColumnAndRow(28, $excel_row, "");                                  //AC
                        $object->getActiveSheet()->setCellValueByColumnAndRow(29, $excel_row, $base_imponible);                                 //AD
                        $object->getActiveSheet()->setCellValueByColumnAndRow(30, $excel_row, "");                                  //AE
                        $object->getActiveSheet()->setCellValueByColumnAndRow(31, $excel_row, "");                                  //AF
                        $object->getActiveSheet()->setCellValueByColumnAndRow(32, $excel_row, "");                                  //AG
                        $object->getActiveSheet()->setCellValueByColumnAndRow(33, $excel_row, "");                                  //AH
                        $object->getActiveSheet()->setCellValueByColumnAndRow(34, $excel_row, "");                                  //AI
                        $object->getActiveSheet()->setCellValueByColumnAndRow(35, $excel_row, "");                                  //AJ
                        $object->getActiveSheet()->setCellValueByColumnAndRow(36, $excel_row, "");                                  //AK
                        $object->getActiveSheet()->setCellValueByColumnAndRow(37, $excel_row, "");                                  //AL
                        $excel_row++;
                    }

                    #DETALLES DE PRODUCTOS
                    #$detalle_comprobante = $this->comprobantedetalle_model->detalles($codigo);
                    $ValorProducto = 0;
                    foreach ($detalle_comprobante as $key => $value) {
                        $ValorProducto  += number_format($value->det_subtotal,2,'.','');
                    }
                        $CuentaProducto = '701111';#$value->PROD_Cuenta;
                        
                        $subtotal_detalle  = number_format($ValorProducto,2,'.','');
                        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, "");//A
                        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, "05");//B
                        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $numComprobante);          //C
                        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $fecha_doc);//D
                        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, "MN");//E
                        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $glosa);//F
                        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row,"");//G
                        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, "M");//H
                        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, "S");//I
                        $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $fecha_doc);//J
                        $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $CuentaProducto);//K
                        $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $num_doc);//L
                        $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, "");//M
                        $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $DH);//N
                        $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $subtotal_detalle);//O
                        $object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, "");//P
                        $object->getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, "");//Q
                        $object->getActiveSheet()->setCellValueByColumnAndRow(17, $excel_row, $TipoDetalle);//R
                        $object->getActiveSheet()->setCellValueByColumnAndRow(18, $excel_row, $serie.'-'.$numero);//S
                        $object->getActiveSheet()->setCellValueByColumnAndRow(19, $excel_row, $fecha_doc);//T
                        $object->getActiveSheet()->setCellValueByColumnAndRow(20, $excel_row, $fecha_venci);//U
                        $object->getActiveSheet()->setCellValueByColumnAndRow(21, $excel_row, "");          //V
                        $object->getActiveSheet()->setCellValueByColumnAndRow(22, $excel_row, $glosa);//W
                        $object->getActiveSheet()->setCellValueByColumnAndRow(23, $excel_row, "");//X
                        $object->getActiveSheet()->setCellValueByColumnAndRow(24, $excel_row, "");//Y
                        $object->getActiveSheet()->setCellValueByColumnAndRow(25, $excel_row, $tipo_doc_modifica);  //Z TIPO DOC REFERENC
                        $object->getActiveSheet()->setCellValueByColumnAndRow(26, $excel_row, $sn_modificado);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(27, $excel_row, $fecha_docu_refe);                                    //AB fe
                        $object->getActiveSheet()->setCellValueByColumnAndRow(28, $excel_row, "");//AC
                        $object->getActiveSheet()->setCellValueByColumnAndRow(29, $excel_row, $base_imponible);//AD base imponible
                        $object->getActiveSheet()->setCellValueByColumnAndRow(30, $excel_row, "");//AE
                        $object->getActiveSheet()->setCellValueByColumnAndRow(31, $excel_row, "");          //AF
                        $object->getActiveSheet()->setCellValueByColumnAndRow(32, $excel_row, "");//AG
                        $object->getActiveSheet()->setCellValueByColumnAndRow(33, $excel_row, "");//AH
                        $object->getActiveSheet()->setCellValueByColumnAndRow(34, $excel_row, "");//AI
                        $object->getActiveSheet()->setCellValueByColumnAndRow(35, $excel_row, "");//AJ
                        $object->getActiveSheet()->setCellValueByColumnAndRow(36, $excel_row, "");//AK
                        $object->getActiveSheet()->setCellValueByColumnAndRow(37, $excel_row, "");//AL
                        $excel_row++;       

                }   

                #FIN LLENADO DATOS


                $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="REPORTE CONCAR '.date('d-m-y').'.xls"');
                $object_writer->save('php://output');

    }

    //REPORTE DE PRODUCTOS MAS VENDIDOS
    public function masVendidos()
    {
        // $rows = $this->ventas_model->reporte_productos_masVendidos();
        // var_dump($rows);
        $this->load->library('layout', 'layout');
        $data['titulo'] = "Registro de Compras Desde ";
        
        $data['cboFormaPago'] = $this->OPTION_generador($this->formapago_model->listar(), 'FORPAP_Codigo', 'FORPAC_Descripcion', '');
        $data['cboVendedor'] = $this->lib_props->listarVendedores();
        $data['cboMoneda'] = $this->OPTION_generador($this->moneda_model->listar(), 'MONED_Codigo', 'MONED_Descripcion', '');
        $data['tipo_docu'] = '';
        $data['tipo_oper'] = 'V';
        $data['titulo_tabla'] = "REPORTE DE PRODUCTOS MÁS VENDIDOS";
        
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->layout->view('reportes/productosMasVendidos', $data);
    }

    public function masVendidosAjax()
    {
        $data = [];

        // Filters
        $filter = new StdClass();
        $filter->fecha1 = $this->input->post('fecha1');
        $filter->fecha2 = $this->input->post('fecha2');
        $filter->tipo_doc = $this->input->post('tipo_doc');
        $filter->forma_pago = $this->input->post('forma_pago');
        $filter->vendedor = $this->input->post('vendedor');
        $filter->moneda = $this->input->post('moneda');

        $rows = $this->ventas_model->reporte_productos_masVendidos($filter);
        $tachado1 = ""; $tachado2 = "";

        foreach ($rows as $key => $col) 
        {
            $item = $key+1;
            $ultimoCosto = $col->PROD_UltimoCosto;
            $idMoneda = $col->idMoneda;
            $montoTC = $col->montoTC;
            $totalVentas = $col->totalPU;
            $promedioPU = floatval($col->totalPU) / floatval($col->cantidadProd);
            $promedioCT = 0;

            if (!empty($filter->moneda))
            {
                if ($filter->moneda == 2) // Dolares
                {
                    $totalVentas = $col->totalPU / $montoTC;
                    $ultimoCosto = $col->PROD_UltimoCosto / $montoTC;
                    $promedioPU  = (floatval($col->totalPU) / floatval($col->cantidadProd)) / $montoTC;
                    $promedioCT  = (floatval($ultimoCosto) / floatval($col->cantidadProd)) / $montoTC;
                }
            }

            $data[$key] = array(
                                "item"         => $item,
                                "producto"     => $col->PROD_Nombre,
                                "unidadMedida" => $col->UNDMED_Descripcion,
                                "cantidad"     => $col->cantidadProd,
                                "cantidadTipo" => $col->cantTipoDoc,
                                "totalVentas"  => floatval($totalVentas),
                                "totalCompras" => floatval($ultimoCosto),
                                "promedioPU"   => $promedioPU,
                                "promedioCT"   => $promedioCT,
                                "ganancia"     => 0,
                                "tachado1"     => '',
                                "tachado2"     => '',
                            );
        }

        $datos = array('data' =>$data, 'totales' => count($rows));
        $json = $datos;
        echo json_encode($json);
    }

    public function masVendidosExcel($typeDoc=0, $feha1=0, $fecha2=0, $formaPago=0, $vendedor=0, $moneda=0)
    {
        $filter = new StdClass();
        $filter->fecha1 = $feha1;
        $filter->fecha2 = $fecha2;
        $filter->tipo_doc = $typeDoc;
        $filter->forma_pago = $formaPago;
        $filter->vendedor = $vendedor;
        $filter->moneda = $moneda;
        $titulo = "REPORTE DE PRODUCTOS MÁS VENDIDOS";

        $phpExcel = new PHPExcel();
        $prestasi = $phpExcel->setActiveSheetIndex(0);
        $phpExcel->getActiveSheet()->mergeCells('A1:J1');
        $phpExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
        $styleArray = array(
                'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );

        $phpExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $phpExcel->getActiveSheet()->getStyle('A1:J1')->applyFromArray($styleArray);

        $styleArray1 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $styleArray12 = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => 'FFEC8B',
                ),
            ),
        );

        $center = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $phpExcel->getActiveSheet()->freezePane('A3');
        $phpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6.1);
        $phpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $phpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $prestasi->setCellValue('A1', $titulo);
        $phpExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($styleArray);
        $phpExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($styleArray1);
        $phpExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($styleArray12);
        $prestasi->setCellValue('A2', 'No');
        $prestasi->setCellValue('B2', 'Producto');
        $prestasi->setCellValue('C2', 'Unidad Medida');
        $prestasi->setCellValue('D2', 'Cant. Vendida');
        $prestasi->setCellValue('E2', 'Cant. Comprobantes');
        $prestasi->setCellValue('F2', 'Promedio P. Uni.');
        $prestasi->setCellValue('G2', 'Promedio C. Total');
        $prestasi->setCellValue('H2', 'Total Venta');
        $prestasi->setCellValue('I2', 'Total Compra');
        $prestasi->setCellValue('J2', 'Total Ganancia');

        $lista = $this->ventas_model->reporte_productos_masVendidos($filter);

        $no = 0;
        $rowexcel = 2;
        
        foreach ($lista as $indice => $valor) 
        {
            $no++;
            $rowexcel++;
            $ultimoCosto = $valor->PROD_UltimoCosto;
            $idMoneda    = $valor->idMoneda;
            $montoTC     = $valor->montoTC;
            $totalVentas = $valor->totalPU;
            $promedioPU  = floatval($valor->totalPU) / floatval($valor->cantidadProd);
            $promedioCT  = floatval($ultimoCosto) / floatval($valor->cantidadProd);

            if (!empty($filter->moneda))
            {
                if ($filter->moneda == 2) // Dolares
                {
                    $totalVentas = $valor->totalPU / $montoTC;
                    $ultimoCosto = $valor->PROD_UltimoCosto / $montoTC;
                    $promedioPU  = (floatval($valor->totalPU) / floatval($valor->cantidadProd)) / $montoTC;
                    $promedioCT  = (floatval($ultimoCosto) / floatval($valor->cantidadProd)) / $montoTC;
                }
            }

            $prestasi->setCellValue('A' . $rowexcel, $no);
            $prestasi->setCellValue('B' . $rowexcel, $valor->PROD_Nombre);
            $prestasi->setCellValue('C' . $rowexcel, $valor->UNDMED_Descripcion);
            $prestasi->setCellValue('D' . $rowexcel, $valor->cantidadProd);
            $prestasi->setCellValue('E' . $rowexcel, $valor->cantTipoDoc);
            $prestasi->setCellValue('F' . $rowexcel, $promedioPU);
            $prestasi->setCellValue('G' . $rowexcel, $promedioCT);
            $prestasi->setCellValue('H' . $rowexcel, $totalVentas);
            $prestasi->setCellValue('I' . $rowexcel, $ultimoCosto);
            $prestasi->setCellValue('J' . $rowexcel, 0);
        }

        $prestasi->setTitle('Reporte');
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"Reporte productos mas vendidos_".(date('his')).".xls\"");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
        $objWriter->save("php://output");
    }
    //FIN DE PRODUCTOS MAS VENDIDOS

//REPORTE POR PRODUCTOS
    public function reportes($tipo_oper=''){
        $anios                      = $this->ventas_model->anios_para_reportes('V');
        $listado_moendas            = $this->moneda_model->listar();
        $data['listado_moendas']    = $listado_moendas;
        $data['anios']              = $anios;
        $data['tipo_oper']          = $tipo_oper;
        $this->layout->view('reportes/reporte_productos', $data);
    }

    public function productos_vendidos_general()
    {
        $posDT = -1;
        $columnas = array(
            ++$posDT => "PROD_CodigoUsuario",
            ++$posDT => "p.PROD_Nombre",
            ++$posDT => "MARCC_Descripcion",
            ++$posDT => "cantidad_documentos",
            ++$posDT => "cantidad_vendidos",
            ++$posDT => "suma"
        );

        $filter = new stdClass();
        $filter->start = $this->input->post("start");
        $filter->length = $this->input->post("length");
        $filter->search = $this->input->post("search")["value"];

        $ordenar = $this->input->post("order")[0]["column"];
        if ($ordenar != "") {
            $filter->order = $columnas[$ordenar];
            $filter->dir = $this->input->post("order")[0]["dir"];
        }

        $filter->fech1      = $this->input->post('fechaDesde');
        $filter->fech2      = $this->input->post('fechaHasta');
        $filter->almacen    = $this->input->post('almacen');
        $filter->producto   = $this->input->post('producto');
        $filter->cliente    = $this->input->post('cliente');
        $filter->moneda     = $this->input->post('moneda');
        $filter->tipo_oper  = $this->input->post('tipo_oper');

        $reporte_result = $this->ventas_model->productos_vendidos_general($filter, false);
        $records = array();

        $cantidad       = 0;
        $total_global   = 0;
        $simbolo        = "S/";

        if ($reporte_result["records"] != NULL) {
            foreach ($reporte_result["records"] as $col) {
                $posDT = -1;
                $records[] = array(
                    ++$posDT => $col->PROD_CodigoUsuario,
                    ++$posDT => $col->PROD_Nombre,
                    ++$posDT => $col->MARCC_Descripcion,
                    ++$posDT => $col->cantidad_documentos,
                    ++$posDT => $col->cantidad_vendidos,
                    ++$posDT => $col->MONED_Simbolo." ".number_format($col->suma,2)
                );

                $cantidad       += $col->cantidad_vendidos;
                $total_global   += $col->suma;
                $simbolo        = $col->MONED_Simbolo;
            }
        }

        $totales = array('cantidad_total' => $cantidad, "total_global" => $total_global);
        
        
        $recordsTotal = ($reporte_result["recordsTotal"] != NULL) ? $reporte_result["recordsTotal"] : 0;
        $recordsFilter = $reporte_result["recordsFilter"];
    
        $json = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFilter,
            "data"            => $records,
            "cantidad_total"  => $cantidad,
            "total_global"    => $simbolo." ".$total_global
        );

        die(json_encode($json));
    }

    public function productos_vendidos_detalle()
    {
        $posDT = -1;
        $columnas = array(
            ++$posDT => "PROD_CodigoUsuario",
            ++$posDT => "p.PROD_Nombre",
            ++$posDT => "MARCC_Descripcion",
            ++$posDT => "cantidad_documentos",
            ++$posDT => "cantidad_vendidos",
            ++$posDT => "suma"
        );

        $filter = new stdClass();
        $filter->start = $this->input->post("start");
        $filter->length = $this->input->post("length");
        $filter->search = $this->input->post("search")["value"];

        $ordenar = $this->input->post("order")[0]["column"];
        if ($ordenar != "") {
            $filter->order = $columnas[$ordenar];
            $filter->dir = $this->input->post("order")[0]["dir"];
        }

        $filter->fech1      = $this->input->post('fechaDesde');
        $filter->fech2      = $this->input->post('fechaHasta');
        $filter->almacen    = $this->input->post('almacen');
        $filter->producto   = $this->input->post('producto');
        $filter->cliente    = $this->input->post('cliente');
        $filter->moneda     = $this->input->post('moneda');
        $filter->tipo_oper  = $this->input->post('tipo_oper');

        $reporte_result = $this->ventas_model->productos_vendidos_detalle($filter, false);
        $records = array();
        $cantidad_total = 0;
        $total_global   = 0;
        $simbolo        = "S/";
        if ($reporte_result["records"] != NULL) {
            foreach ($reporte_result["records"] as $valor) {
                $fecha          = $valor->fecha;
                $serie          = $valor->serie;
                $numero         = $valor->numero;
                $documento      = $valor->Documento;
                $denominacion   = $valor->Nombre;
                $moneda         = $valor->moneda_simbolo;
                $unidad         = $valor->unidad;
                $codigo         = $valor->prod_cod;
                $descripcion    = $valor->CPDEC_Descripcion;
                $cantidad       = $valor->CPDEC_Cantidad;
                $valoru         = $valor->CPDEC_Pu;
                $preciou        = $valor->CPDEC_Pu_ConIgv;
                $subtotal       = $valor->CPDEC_Subtotal;
                $igv            = $valor->CPDEC_Igv;
                $total          = $valor->CPDEC_Total;
                $moned_cod      = $valor->MONED_Codigo;

                $posDT = -1;
                $records[] = array(
                    ++$posDT => $fecha,
                    ++$posDT => $serie."-".$numero,
                    ++$posDT => $documento." - ".$denominacion,
                    ++$posDT => $codigo."-".$descripcion,
                    ++$posDT => $unidad,
                    ++$posDT => $cantidad,
                    ++$posDT => $moneda." ".$total
                    
                );
                $cantidad_total += $cantidad;
                $total_global   += $valor->CPDEC_Total;
                $simbolo        = $valor->moneda_simbolo;
            }
        }
        
        
        $recordsTotal = ($reporte_result["recordsTotal"] != NULL) ? $reporte_result["recordsTotal"] : 0;
        $recordsFilter = $reporte_result["recordsFilter"];
    
        $json = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFilter,
            "data"            => $records,
            "cantidad_total"  => $cantidad_total,
            "total_global"    => $simbolo." ".$total_global
        );

        die(json_encode($json));
    }

    public function productos_vendidos_mensual()
    {
        $posDT = -1;
        $columnas = array(
            ++$posDT => "PROD_CodigoUsuario",
            ++$posDT => "p.PROD_Nombre",
            ++$posDT => "MARCC_Descripcion",
            ++$posDT => "cantidad_documentos",
            ++$posDT => "cantidad_vendidos",
            ++$posDT => "suma"
        );

        $filter = new stdClass();
        $filter->start = $this->input->post("start");
        $filter->length = $this->input->post("length");
        $filter->search = $this->input->post("search")["value"];

        $ordenar = $this->input->post("order")[0]["column"];
        if ($ordenar != "") {
            $filter->order = $columnas[$ordenar];
            $filter->dir = $this->input->post("order")[0]["dir"];
        }

        $filter->fech1      = $this->input->post('fechaDesde');
        $filter->fech2      = $this->input->post('fechaHasta');
        $filter->almacen    = $this->input->post('almacen');
        $filter->producto   = $this->input->post('producto');
        $filter->cliente    = $this->input->post('cliente');
        $filter->moneda     = $this->input->post('moneda');
        $filter->tipo_oper  = $this->input->post('tipo_oper');

        $f1 = new DateTime($filter->fech1);
        $f2 = new DateTime($filter->fech2);

        $cant_meses = $f2->diff($f1);
        $cant_meses = $cant_meses->format('%m'); //devuelve el numero de meses entre ambas fechas.
        $listaMeses = array($f1->format('Y-m-d'));
        $listaMesesCabecera = array(formatMes($f1->format('m'))."-".$f1->format('Y'));

        for ($i = 1; $i <= $cant_meses; $i++) {

            $ultimaFecha = end($listaMeses);
            $ultimaFecha = new DateTime($ultimaFecha);
            $nuevaFecha = $ultimaFecha->add(new DateInterval("P1M"));
            $nuevaFecha = $nuevaFecha->format('Y-m-d');
            
            $valorF  = explode("-",$nuevaFecha);
            $anio   = $valorF[0];
            $mes    = $valorF[1];
            $nuevaFecha2 = formatMes($mes).'-'.$anio;
            array_push($listaMeses, $nuevaFecha);
            array_push($listaMesesCabecera, $nuevaFecha2);

        }

        $filter->listaMeses = $listaMeses;

        $reporte_result = $this->ventas_model->ventas_producto_mes($filter, false);
        $records    = array();
        $total_mes  = array();

        $cantidad_total = 0;
        $total_global   = 0;
        $simbolo        = "S/";

        //$this->vistaTablaMeses($listaMeses);

        if ($reporte_result["records"] != NULL) {
            foreach ($reporte_result["records"] as $row => $col) {
                foreach ($listaMeses as $key => $value) {
                    
                    $valor  = explode("-",$value);
                    $anio   = $valor[0];
                    $mes    = $valor[1];
                    
                    $mes = "Mes_".$key;
                    $total_mes[$key] = $col->$mes!=null? number_format($col->$mes,2) :"";
                   // $records[$key][++$posDT] = $col->$mes;
                }

                $posDT = -1;
                $records[$row] = array(
                    "codigousua"    => $col->PROD_CodigoUsuario,
                    "descripcion"   => $col->PROD_Nombre,
                    "marca"         => $col->MARCC_Descripcion,
                    "docs"          => $col->cantidad_documentos,
                    "cantidad"      => $col->cantidad_vendidos,
                    "meses"         => $total_mes
                );
        

                $cantidad_total += $col->cantidad_vendidos;
                $total_global   += $col->suma;
                $simbolo        = $col->MONED_Simbolo;
            }
        }

        $totales = array('cantidad_total' => $cantidad_total, "total_global" => $total_global);
        
        $recordsTotal  = ($reporte_result["recordsTotal"] != NULL) ? $reporte_result["recordsTotal"] : 0;
        $recordsFilter = $reporte_result["recordsFilter"];
    
        $json = array(
            //"draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFilter,
            "data"            => $records,
            "cantidad_total"  => $cantidad_total,
            "total_global"    => $simbolo." ".$total_global,
            "listaMeses"      => $listaMesesCabecera
        );



        //$this->load->view('reportes/tabla_reporte_mensual_productos', $data);
        die(json_encode($json));
    }

    public function productos_vendidos_anual()
    {
        $posDT = -1;
        $columnas = array(
            ++$posDT => "PROD_CodigoUsuario",
            ++$posDT => "p.PROD_Nombre",
            ++$posDT => "MARCC_Descripcion",
            ++$posDT => "cantidad_documentos",
            ++$posDT => "cantidad_vendidos",
            ++$posDT => "suma"
        );

        $filter = new stdClass();
        $filter->start = $this->input->post("start");
        $filter->length = $this->input->post("length");
        $filter->search = $this->input->post("search")["value"];

        $ordenar = $this->input->post("order")[0]["column"];
        if ($ordenar != "") {
            $filter->order = $columnas[$ordenar];
            $filter->dir = $this->input->post("order")[0]["dir"];
        }

        $filter->fech1      = $this->input->post('fechaDesde');
        $filter->fech2      = $this->input->post('fechaHasta');
        $filter->almacen    = $this->input->post('almacen');
        $filter->producto   = $this->input->post('producto');
        $filter->cliente    = $this->input->post('cliente');
        $filter->moneda     = $this->input->post('moneda');
        $filter->tipo_oper  = $this->input->post('tipo_oper');

        $diff = $filter->fech2 - $filter->fech1;
        
        $Ainicio = $filter->fech1;
        $listaAniosCabecera = array($Ainicio);
        for ($i = 0; $i < $diff; $i++) {
        
            $nuevaFecha2 = $Ainicio+$i+1;
            array_push($listaAniosCabecera, $nuevaFecha2);

        }

        $filter->listaAnios = $listaAniosCabecera;

        $reporte_result = $this->ventas_model->ventas_producto_anio($filter, false);
        $records    = array();
        $total_anio  = array();

        $cantidad_total = 0;
        $total_global   = 0;
        $simbolo        = "S/";

        //$this->vistaTablaMeses($listaMeses);

        if ($reporte_result["records"] != NULL) {
            foreach ($reporte_result["records"] as $row => $col) {
                foreach ($listaAniosCabecera as $key => $value) {
                    
                    $anio = "Anio_".$key;
                    $total_anio[$key] = $col->$anio!=null? number_format($col->$anio,2) :"";
                   // $records[$key][++$posDT] = $col->$mes;
                }
               
                $posDT = -1;
                $records[$row] = array(
                    "codigousua" => $col->PROD_CodigoUsuario,
                    "descripcion" => $col->PROD_Nombre,
                    "marca" => $col->MARCC_Descripcion,
                    "docs" => $col->cantidad_documentos,
                    "cantidad" => $col->cantidad_vendidos,
                    "anios" => $total_anio
                );
        

                $cantidad_total += $col->cantidad_vendidos;
                $total_global   += $col->total_venta;
                $simbolo        = $col->MONED_Simbolo;
            }
        }

        $totales = array('cantidad_total' => $cantidad_total, "total_global" => $total_global);
        
        $recordsTotal  = ($reporte_result["recordsTotal"] != NULL) ? $reporte_result["recordsTotal"] : 0;
        $recordsFilter = $reporte_result["recordsFilter"];
    
        $json = array(
            //"draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFilter,
            "data"            => $records,
            "cantidad_total"  => $cantidad_total,
            "total_global"    => $simbolo." ".$total_global,
            "listaAnios"      => $listaAniosCabecera
        );



        //$this->load->view('reportes/tabla_reporte_mensual_productos', $data);
        die(json_encode($json));
    }

    public function reporteProductoGeneral($tipo_oper,$moneda,$cliente,$fechai,$fechaf,$producto)
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
            'color' => array('argb' => 'ECF0F1')
          ),
          'alignment' =>  array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'          => TRUE
          )
        );

        $estiloColumnasHeader = array(
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
            'color' => array('argb' => 'EB2727')
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


        $filter = new stdClass();
        $filter->fech1      = $fechai;
        $filter->fech2      = $fechaf;
        $filter->fech1      = ($fechai == NULL || $fechai == "0") ? date("Y-m-d 00:00:00") : "$fechai";
        $filter->fech2      = ($fechaf == NULL || $fechaf == "0") ? date("Y-m-d 23:59:59") : "$fechaf";
        $filter->producto   = ($producto == NULL || $producto == "0") ? "" : "$producto";
        $filter->cliente    = ($cliente == NULL || $cliente == "0") ? "" : "$cliente";
        $filter->moneda     = $moneda;
        $filter->tipo_oper  = $tipo_oper;


        
        $titulo_reporte= ($tipo_oper=="V") ? "REPORTE GENERAL DE VENTAS POR PRODUCTO":"REPORTE GENERAL DE COMPRAS POR PRODUCTO";
        
        

        $this->excel->setActiveSheetIndex($hoja);
        $lugar=1;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "EMPRESA");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $_SESSION['nombre_empresa']);

        $lugar=2;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "TIPO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $titulo_reporte);

        $lugar=3;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "FECHA REPORTE");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  date("d-m-Y H:i:s"));

        $lugar=4;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "RANGO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $filter->fech1." al ".$filter->fech2);

        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "CODIGO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  "DESCRIPCIÓN");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  "MARCA");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  "CANTIDAD DE DOCUMENTOS");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  "CANTIDAD TOTAL");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar",  "MONEDA");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("G$lugar",  "MONTO TOTAL");
        
        $this->excel->getActiveSheet()->getStyle("A$lugar:F$lugar")->applyFromArray($estiloColumnasTitulo);
        $this->excel->getActiveSheet()->getColumnDimension("A")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("B")->setWidth("70");
        $this->excel->getActiveSheet()->getColumnDimension("C")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("D")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("E")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("F")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("G")->setWidth("20");


       

        $reporte_result     = $this->ventas_model->productos_vendidos_general($filter, false);
        $records = array();
        
        $cantidad       = 0;
        $total_global   = 0;
        $simbolo        = "S/";

        if ($reporte_result["records"] != NULL) {
            foreach ($reporte_result["records"] as $col) {
                
                $codUsua        = $col->PROD_CodigoUsuario;
                $descripcion    = $col->PROD_Nombre;
                $marca          = $col->MARCC_Descripcion;
                $cantDocs       = $col->cantidad_documentos;
                $cantidad       = $col->cantidad_vendidos;
                $moneda         = $col->MONED_Simbolo;
                $monto          = number_format($col->suma,2);
               

                $lugar++;
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  $codUsua);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $descripcion);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  $marca);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  $cantDocs);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  $cantidad);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar",  $moneda);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("G$lugar",  number_format($monto,2));
      
                $cantidad       += $col->cantidad_vendidos;
                $total_global   += $col->suma;
                $simbolo        = $col->MONED_Simbolo;
            }
        }

        $lugar++;
        $lugar++;
       
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  "TOTAL");    
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar",  $simbolo); 
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("G$lugar",  number_format($total_global,2)); 
        $titulo_archivo = ($tipo_oper=="V") ? "Reporte Vemtas General por producto ".date("YmdHis").".xls" : "Reporte Compras General por producto ".date("YmdHis").".xls";
        
        $filename = $titulo_archivo;
        
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');       
    }

    public function reporteProductoDetallado($tipo_oper,$moneda,$cliente,$fechai,$fechaf,$producto)
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
            'color' => array('argb' => 'ECF0F1')
          ),
          'alignment' =>  array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'          => TRUE
          )
        );

        $estiloColumnasHeader = array(
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
            'color' => array('argb' => 'EB2727')
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


        $filter = new stdClass();
        $filter->fech1      = $fechai;
        $filter->fech2      = $fechaf;
        $filter->fech1      = ($fechai == NULL || $fechai == "0") ? date("Y-m-d 00:00:00") : "$fechai";
        $filter->fech2      = ($fechaf == NULL || $fechaf == "0") ? date("Y-m-d 23:59:59") : "$fechaf";
        $filter->producto   = ($producto == NULL || $producto == "0") ? "" : "$producto";
        $filter->cliente    = ($cliente == NULL || $cliente == "0") ? "" : "$cliente";
        $filter->moneda     = $moneda;
        $filter->tipo_oper  = $tipo_oper;

        $titulo_reporte = ($tipo_oper=="V") ? "REPORTE DETALLADO DE VENTAS POR PRODUCTO" : "REPORTE DETALLADO DE COMPRAS POR PRODUCTO";

        $this->excel->setActiveSheetIndex($hoja);
        $lugar=1;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "EMPRESA");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $_SESSION['nombre_empresa']);

        $lugar=2;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "TIPO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $titulo_reporte);

        $lugar=3;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "FECHA REPORTE");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  date("d-m-Y H:i:s"));

        $lugar=4;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "RANGO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $filter->fech1." al ".$filter->fech2);

        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "Fecha");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  "Nro");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  "Documento");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  "Nombre");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  "Moneda");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar",  "Unidad");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("G$lugar",  "Codigo");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("H$lugar",  "Descripción");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("I$lugar",  "Cantidad");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("J$lugar",  "PU");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("K$lugar",  "Precio");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("L$lugar",  "Subtotal");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("M$lugar",  "IGV");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("N$lugar",  "Total");
        
        $this->excel->getActiveSheet()->getStyle("A$lugar:N$lugar")->applyFromArray($estiloColumnasTitulo);
        $this->excel->getActiveSheet()->getColumnDimension("A")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("B")->setWidth("70");
        $this->excel->getActiveSheet()->getColumnDimension("C")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("D")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("E")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("F")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("G")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("H")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("I")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("J")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("K")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("L")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("M")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("N")->setWidth("20");

        $reporte_result = $this->ventas_model->productos_vendidos_detalle($filter, false);
        $records = array();
        
        $cantidad       = 0;
        $total_global   = 0;
        $simbolo        = "S/";

        if ($reporte_result["records"] != NULL) {
            foreach ($reporte_result["records"] as $valor) {
                $fecha          = $valor->fecha;
                $serie          = $valor->serie;
                $numero         = $valor->numero;
                $documento      = $valor->Documento;
                $denominacion   = $valor->Nombre;
                $moneda         = $valor->moneda_simbolo;
                $unidad         = $valor->unidad;
                $codigo         = $valor->prod_cod;
                $descripcion    = $valor->CPDEC_Descripcion;
                $cantidad       = $valor->CPDEC_Cantidad;
                $valoru         = $valor->CPDEC_Pu;
                $preciou        = $valor->CPDEC_Pu_ConIgv;
                $subtotal       = $valor->CPDEC_Subtotal;
                $igv            = $valor->CPDEC_Igv;
                $total          = $valor->CPDEC_Total;
                $moned_cod      = $valor->MONED_Codigo;
               
                $lugar++;
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  $fecha);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $serie."-".$numero);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  $documento);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  $denominacion);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  $moneda);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar",  $unidad);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("G$lugar",  $codigo);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("H$lugar",  $descripcion);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("I$lugar",  $cantidad);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("J$lugar",  number_format($valoru,2));
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("K$lugar",  number_format($preciou,2));
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("L$lugar",  number_format($subtotal,2));
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("M$lugar",  number_format($igv,2));
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("N$lugar",  number_format($total,2));
                
                $cantidad_total += $cantidad;
                $total_global   += $valor->CPDEC_Total;
                $simbolo        = $valor->moneda_simbolo;
            }
        }

        $lugar++;
        $lugar++;
       
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  "TOTAL");    
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar",  $simbolo); 
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("G$lugar",  number_format($total_global,2)); 
        $titulo_archivo = ($tipo_oper=="V") ? "Reporte Ventas Detallado por producto ".date("YmdHis").".xls" : "Reporte Compras Detallado por producto ".date("YmdHis").".xls";
        
        $filename = $titulo_archivo;
        
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');       
    }

    public function reporteProductoMensual($tipo_oper,$moneda,$cliente,$fechai,$fechaf,$producto)
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
            'color' => array('argb' => 'ECF0F1')
          ),
          'alignment' =>  array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'          => TRUE
          )
        );

        $estiloColumnasHeader = array(
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
            'color' => array('argb' => 'EB2727')
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


        $filter = new stdClass();
        $filter->fech1      = $fechai;
        $filter->fech2      = $fechaf;
        $filter->fech1      = ($fechai == NULL || $fechai == "0") ? date("Y-m-d 00:00:00") : "$fechai";
        $filter->fech2      = ($fechaf == NULL || $fechaf == "0") ? date("Y-m-d 23:59:59") : "$fechaf";
        $filter->producto   = ($producto == NULL || $producto == "0") ? "" : "$producto";
        $filter->cliente    = ($cliente == NULL || $cliente == "0") ? "" : "$cliente";
        $filter->moneda     = $moneda;
        $filter->tipo_oper  = $tipo_oper;
        $titulo_reporte = ($tipo_oper=="V") ? "REPORTE DE VENTAS POR PRODUCTO POR MES" : "REPORTE DE COMPRAS POR PRODUCTO POR MES";
        $this->excel->setActiveSheetIndex($hoja);
        $lugar=1;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "EMPRESA");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $_SESSION['nombre_empresa']);

        $lugar=2;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "TIPO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $titulo_reporte);

        $lugar=3;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "FECHA REPORTE");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  date("d-m-Y H:i:s"));

        $lugar=4;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "RANGO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $filter->fech1." al ".$filter->fech2);

        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "Codigo");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  "Descripción");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  "Marca");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  "Nro Docs");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  "Cantidad");
        
        $this->excel->getActiveSheet()->getStyle("A$lugar:Z$lugar")->applyFromArray($estiloColumnasTitulo);
        $this->excel->getActiveSheet()->getColumnDimension("A")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("B")->setWidth("70");
        $this->excel->getActiveSheet()->getColumnDimension("C")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("D")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("E")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("F")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("G")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("H")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("I")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("J")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("K")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("L")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("M")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("N")->setWidth("20");

       
        $f1 = new DateTime($filter->fech1);
        $f2 = new DateTime($filter->fech2);

        $cant_meses = $f2->diff($f1);
        $cant_meses = $cant_meses->format('%m'); //devuelve el numero de meses entre ambas fechas.
        $listaMeses = array($f1->format('Y-m-d'));
        $listaMesesCabecera = array(formatMes($f1->format('m'))."-".$f1->format('Y'));
        $letra      = 6;

        for ($i = 1; $i <= $cant_meses; $i++) {

            $ultimaFecha = end($listaMeses);
            $ultimaFecha = new DateTime($ultimaFecha);
            $nuevaFecha = $ultimaFecha->add(new DateInterval("P1M"));
            $nuevaFecha = $nuevaFecha->format('Y-m-d');
            
            $valorF  = explode("-",$nuevaFecha);
            $anio   = $valorF[0];
            $mes    = $valorF[1];
            $nuevaFecha2 = formatMes($mes).'-'.$anio;
            array_push($listaMeses, $nuevaFecha);
            array_push($listaMesesCabecera, $nuevaFecha2);

        }

        $filter->listaMeses = $listaMeses;
        $reporte_result = $this->ventas_model->ventas_producto_mes($filter, false);
        
        foreach ($listaMesesCabecera as $key => $value) {
            $pos = $this->lib_props->colExcel($letra)."$lugar";
            $this->excel->setActiveSheetIndex($hoja)->setCellValue($pos,  $value);
            $letra++;
        }

        $records    = array();
        $total_mes  = array();

        $cantidad_total = 0;
        $total_global   = 0;
        $simbolo        = "S/";

        if ($reporte_result["records"] != NULL) {
            foreach ($reporte_result["records"] as $row => $col) {
                $letra = 6;
                $codigousua    = $col->PROD_CodigoUsuario;
                $descripcion   = $col->PROD_Nombre;
                $marca         = $col->MARCC_Descripcion;
                $docs          = $col->cantidad_documentos;
                $cantidad      = $col->cantidad_vendidos;
                $meses         = $total_me;
                
                $lugar++;
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  $codigousua);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $descripcion);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  $marca);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  $docs);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  $cantidad);
                foreach ($listaMeses as $key => $value) {
                    
                    $valor  = explode("-",$value);
                    $anio   = $valor[0];
                    $mes    = $valor[1];
                    
                    $mes = "Mes_".$key;
                    $total_mes[$key] = $col->$mes!=null? number_format($col->$mes,2) :"";
                    $pos = $this->lib_props->colExcel($letra)."$lugar";
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue($pos,  $col->$mes);
                    $letra++;
                }
                
                $cantidad_total += $col->cantidad_vendidos;
                $total_global   += $col->suma;
                $simbolo        = $col->MONED_Simbolo;
                
            }
        }
        
        $lugar++;
        $lugar++;
       
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  "TOTAL");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  $simbolo);
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar",  number_format($total_global,2));
        
        $titulo_archivo = ($tipo_oper=="V") ? "Reporte ventas mensual por producto ".date("YmdHis").".xls" : "Reporte compras mensual por producto ".date("YmdHis").".xls";
        
        $filename = $titulo_archivo;
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');       
    }

    public function reporteProductoAnual($tipo_oper,$moneda,$cliente,$fechai,$fechaf,$producto)
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
            'color' => array('argb' => 'ECF0F1')
          ),
          'alignment' =>  array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'          => TRUE
          )
        );

        $estiloColumnasHeader = array(
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
            'color' => array('argb' => 'EB2727')
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


        $filter = new stdClass();
        $filter->fech1      = $fechai;
        $filter->fech2      = $fechaf;
        $filter->fech1      = ($fechai == NULL || $fechai == "0") ? date("Y") : "$fechai";
        $filter->fech2      = ($fechaf == NULL || $fechaf == "0") ? date("Y") : "$fechaf";
        $filter->producto   = ($producto == NULL || $producto == "0") ? "" : "$producto";
        $filter->cliente    = ($cliente == NULL || $cliente == "0") ? "" : "$cliente";
        $filter->moneda     = $moneda;
        $filter->tipo_oper  = $tipo_oper;

        $titulo_reporte = ($tipo_oper=="V") ? "REPORTE DE VENTAS POR PRODUCTO POR AÑO" : "REPORTE DE COMPRAS POR PRODUCTO POR AÑO";

        $this->excel->setActiveSheetIndex($hoja);
        $lugar=1;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "EMPRESA");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $_SESSION['nombre_empresa']);

        $lugar=2;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "TIPO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $titulo_reporte);

        $lugar=3;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "FECHA REPORTE");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  date("d-m-Y H:i:s"));

        $lugar=4;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "RANGO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $filter->fech1." al ".$filter->fech2);

        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "Codigo");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  "Descripción");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  "Marca");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  "Nro Docs");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  "Cantidad");
        
        $this->excel->getActiveSheet()->getStyle("A$lugar:Z$lugar")->applyFromArray($estiloColumnasTitulo);
        $this->excel->getActiveSheet()->getColumnDimension("A")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("B")->setWidth("70");
        $this->excel->getActiveSheet()->getColumnDimension("C")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("D")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("E")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("F")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("G")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("H")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("I")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("J")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("K")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("L")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("M")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("N")->setWidth("20");

       
       

        $diff = $filter->fech2 - $filter->fech1;
        
        $Ainicio = $filter->fech1;
        $listaAniosCabecera = array($Ainicio);
        for ($i = 0; $i < $diff; $i++) {
        
            $nuevaFecha2 = $Ainicio+$i+1;
            array_push($listaAniosCabecera, $nuevaFecha2);

        }

        $filter->listaAnios = $listaAniosCabecera;

        $reporte_result = $this->ventas_model->ventas_producto_anio($filter, false);
        $records    = array();
        $total_anio  = array();

        $cantidad_total = 0;
        $total_global   = 0;
        $simbolo        = "S/";
        $letra          = 6;
        
        foreach ($listaAniosCabecera as $key => $value) {
            $pos = $this->lib_props->colExcel($letra)."$lugar";
            $this->excel->setActiveSheetIndex($hoja)->setCellValue($pos,  $value);
            $letra++;
        }

        if ($reporte_result["records"] != NULL) {
            foreach ($reporte_result["records"] as $row => $col) {
                $letra = 6;
                $codigousua    = $col->PROD_CodigoUsuario;
                $descripcion   = $col->PROD_Nombre;
                $marca         = $col->MARCC_Descripcion;
                $docs          = $col->cantidad_documentos;
                $cantidad      = $col->cantidad_vendidos;
                $meses         = $total_me;
                
                $lugar++;
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  $codigousua);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $descripcion);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  $marca);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  $docs);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  $cantidad);
                foreach ($listaAniosCabecera as $key => $value) {
                    $anio = "Anio_".$key;
                    $total_anio[$key] = $col->$anio!=null? number_format($col->$anio,2) :"";
                    $pos = $this->lib_props->colExcel($letra)."$lugar";
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue($pos,  $total_anio[$key]);
                    $letra++;
                }
                
                $cantidad_total += $col->cantidad_vendidos;
                $total_global   += $col->total_venta;
                $simbolo        = $col->MONED_Simbolo;
            }
        }

        $lugar++;
        $lugar++;
       
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  "TOTAL");    
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  $simbolo); 
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar",  number_format($total_global,2)); 
        
        $titulo_archivo = ($tipo_oper=="V") ? "Reporte ventas anual por producto ".date("YmdHis").".xls":"Reporte compras anual por producto ".date("YmdHis").".xls";

        $filename = $titulo_archivo;
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');       
    }

//FIN REPORTE POR PRODUCTOS

#VENTAS POR CLIENTE

    public function filtroCliente() {
        $this->load->library('layout', 'layout');
        $data['fecha_inicio'] = date("Y-m-d");
        $data['fecha_fin'] = date("Y-m-d");
        
        $data['cliente'] = "";
        $data['nombre_cliente'] = "";
        $data['buscar_cliente'] = "";
        $anios                      = $this->ventas_model->anios_para_reportes('V');
        $listado_moendas            = $this->moneda_model->listar();
        $data['listado_moendas']    = $listado_moendas;
        $data['anios']              = $anios;
        $data['tipo_oper']          = "V";
       
        $this->layout->view('reportes/ventas_por_cliente', $data);
    }

    public function datatable_ventas_clientes($tipo_oper = '', $tipo_docu = ''){
        
        $filter = new stdClass();
        $filter->start          = $this->input->post("start");
        $filter->length         = $this->input->post("length");
        $filter->cliente        = $this->input->post("cliente");
        $filter->acumulado      = $this->input->post("acumulado");
        $filter->fecha_inicio   = $this->input->post("fecha_inicio");
        $filter->fecha_fin      = $this->input->post("fecha_fin");
        $filter->moneda         = $this->input->post("moneda");
        $listado_comprobantes   = $this->ventas_model->ventas_reporte_rango($filter);

        $lista          = [];
        $total_global   = 0;
        $cantidad_total = 0;
        if ($listado_comprobantes != NULL) {
            foreach ($listado_comprobantes as $indice => $valor) {
               
                $fecha      = $filter->acumulado>0 ? "" : mysql_to_human($listado_comprobantes[$indice]["fecha"]);
                $estado     = $filter->acumulado>0 ? "1" : $listado_comprobantes[$indice]["estado"];
                
                $moneda         = $listado_comprobantes[$indice]["moneda"];
                $documento      = $listado_comprobantes[$indice]["Documento"];
                $comprobante    = $listado_comprobantes[$indice]["Comprobante"];
                $nombre         = $listado_comprobantes[$indice]["Nombre"];
                $total_doc      = $listado_comprobantes[$indice]["Total"] > 0 ? $listado_comprobantes[$indice]["Total"] : 0;

                $tachado1   = "";
                $tachado2   = "";
                $color_font = "";
                $color_font= "black";
                if ($estado == 0) {
                    $tachado1 = "<strike>";
                    $tachado2 = "</strike>";
                    $color_font= "red";
                }

                $documento      = "<font color=".$color_font.">".$tachado1.$documento.$tachado2."</font>";
                $comprobante    = "<font color=".$color_font.">".$tachado1.$comprobante.$tachado2."</font>";
                $nombre         = "<font color=".$color_font.">".$tachado1.$nombre.$tachado2."</font>";
                $total          = "<font color=".$color_font.">".$moneda." ".$tachado1.$total_doc.$tachado2."</font>";
                $fecha          = $filter->acumulado>0 ? "" : "<font color=".$color_font.">".$tachado1.mysql_to_human($listado_comprobantes[$indice]["fecha"]).$tachado2."</font>";
                $posDT = -1;
                $lista[] = array(
                      ++$posDT => $documento,
                      ++$posDT => $comprobante,
                      ++$posDT => $nombre,
                      ++$posDT => $total,
                      ++$posDT => $fecha
                  );
                $total_global   += $listado_comprobantes[$indice]["Total"];
                $cantidad_total += $valor->Total;
            }
        }
       

        unset($filter->start);
        unset($filter->length);
        $recordsTotal = $this->ventas_model->ventas_reporte_rango($filter);
        $filter->acumulado = 1;
        $recordsChats= $this->ventas_model->ventas_reporte_rango($filter);

        $json = array(
                "draw"            => intval( $this->input->post('draw') ),
                "recordsTotal"    => count($recordsTotal),
                "recordsFiltered" => count($recordsTotal),
                "data"            => $lista,
                "data_mostrar"    => $recordsChats,
                "total_global"    => $total_global,
                "cantidad_total"  => $cantidad_total
        );

        echo json_encode($json);
    }

    public function reporte_excel($cliente,$fi,$ff,$totales=0)
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
                    'color' => array('argb' => 'ECF0F1')
                  ),
                  'alignment' =>  array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap'          => TRUE
                  )
                );

                $estiloColumnasHeader = array(
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
                    'color' => array('argb' => 'EB2727')
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
                $lugar=1;
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "EMPRESA");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $_SESSION['nombre_empresa']);

                $lugar=2;
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "TIPO");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  "REPORTE POR CLIENTES");

                $lugar=3;
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "FECHA REPORTE");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  date("d-m-Y H:i:s"));

                $lugar=4;
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "RANGO");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $fi." / ".$ff);


                $lugar=6;
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "DOCUMENTO");
                $this->excel->setActiveSheetIndex($hoja)->mergeCells("B$lugar:C$lugar")->setCellValue("B$lugar",  "COMPROBANTE");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  "RAZON SOCIAL");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  "MONEDA");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar",  "TOTAL");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("G$lugar",  "FECHA");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("H$lugar",  "ESTADO");
                
                $this->excel->getActiveSheet()->getStyle("A$lugar:H$lugar")->applyFromArray($estiloColumnasTitulo);

                $this->excel->getActiveSheet()->getColumnDimension("A")->setWidth("20");
                $this->excel->getActiveSheet()->getColumnDimension("D")->setWidth("40");
          

            $filter = new stdClass();

            $filter->cliente        = $cliente;
            $filter->acumulado      = $totales;
            $filter->fecha_inicio   = $fi;
            $filter->fecha_fin      = $ff;
            $listado_comprobantes   = $this->ventas_model->ventas_reporte_rango($filter);
            $listado_moendas        = $this->moneda_model->listar();
            $total_s = 0;
            $total_d = 0;
            if ($listado_comprobantes != NULL) {
                foreach ($listado_comprobantes as $indice => $valor) {
                    //var_dump($valor["moneda"]);
                   // var_dump($valor["Total"]);
                    $fecha      = $filter->acumulado > 0 ? "" : mysql_to_human($valor["fecha"]);
                    $estado     = $valor["estado"] == 0 ? "ANULADO" : "";
                    $totalDet   = $valor["estado"] == 0 ? 0 : $valor["Total"];
                    $moneda     = $valor["moneda_cod"];
                    $moneda_des = $valor["moneda"];
                    $lugar++;
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  $valor["Documento"]);
                    $this->excel->setActiveSheetIndex($hoja)->mergeCells("B$lugar:C$lugar")->setCellValue("B$lugar",$valor["Comprobante"]);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  $valor["Nombre"]);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  $moneda_des);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar",  $totalDet);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("G$lugar",  $fecha);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("H$lugar",  $estado);
                    
                    if ($moneda==1) {
                        $total_s += $totalDet;
                    }else{
                        $total_d += $totalDet;
                    }
                }
            }

            
            $lugar++;

            $t_finals               = $total_s;
            $d_finals               = $total_d;
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  "TOTAL");    
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  "S/."); 
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar",  $t_finals); 

            if ($total_d>0) {
                $lugar++;
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar",  "TOTAL");    
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  "USD$"); 
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar",  $d_finals); 
            }   


            for($i = 'E'; $i <= 'H'; $i++){
                $this->excel->setActiveSheetIndex($hoja)->getColumnDimension($i)->setAutoSize(true);
            }              

            $filename = "Reporte por Cliente ".date("YmdHis").".xls";
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment;filename=$filename");
            header("Cache-Control: max-age=0");
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save('php://output');       
    }

    public function reporte_excel_producto($cliente, $fi ,$ff, $producto)
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
                    'color' => array('argb' => 'ECF0F1')
                  ),
                  'alignment' =>  array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap'          => TRUE
                  )
                );

                $estiloColumnasHeader = array(
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
                    'color' => array('argb' => 'EB2727')
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
                $lugar=1;
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "EMPRESA");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $_SESSION['nombre_empresa']);

                $lugar=2;
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "TIPO");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  "REPORTE POR CLIENTES");

                $lugar=3;
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "FECHA REPORTE");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  date("d-m-Y H:i:s"));

                $lugar=4;
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "RANGO");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $fi." / ".$ff);


                $lugar++;
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "FECHA");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  "SERIE");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  "NUMERO");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  "DOCUMENTO NUMERO");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  "DENOMINACIÓN");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar",  "MONEDA");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("G$lugar",  "UNIDAD DE MEDIDA");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("H$lugar",  "CODIGO");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("I$lugar",  "DESCRIPCIÓN");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("J$lugar",  "CANTIDAD");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("K$lugar",  "VALOR UNITARIO");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("L$lugar",  "PRECIO UNITARIO");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("M$lugar",  "SUBTOTAL");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("N$lugar",  "IGV");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("O$lugar",  "TOTAL");
                $this->excel->getActiveSheet()->getStyle("A$lugar:O$lugar")->applyFromArray($estiloColumnasTitulo);
                $this->excel->getActiveSheet()->getColumnDimension("A")->setWidth("20");
                $this->excel->getActiveSheet()->getColumnDimension("D")->setWidth("20");
                $this->excel->getActiveSheet()->getColumnDimension("E")->setWidth("50");
                $this->excel->getActiveSheet()->getColumnDimension("I")->setWidth("70");

            $filter = new stdClass();

            $filter->cliente        = $cliente;
            $filter->producto       = $producto;
            //$filter->acumulado    = $totales;
            $filter->fecha_inicio   = $fi;
            $filter->fecha_fin      = $ff;
            $listado_comprobantes   = $this->ventas_model->ventas_cliente_producto($filter);
            //var_dump($listado_comprobantes);exit();
         
            $total_s = 0;
            $total_d = 0;
            if ($listado_comprobantes != NULL) {
                foreach ($listado_comprobantes as $indice => $valor) {
                    //var_dump($valor->serie);exit();
                    $fecha          = $valor->fecha;
                    $serie          = $valor->serie;
                    $numero         = $valor->numero;
                    $documento      = $valor->Documento;
                    $denominacion   = $valor->Nombre;
                    $moneda         = $valor->moneda_simbolo;
                    $unidad         = $valor->unidad;
                    $codigo         = $valor->prod_cod;
                    $descripcion    = $valor->CPDEC_Descripcion;
                    $cantidad       = $valor->CPDEC_Cantidad;
                    $valoru         = $valor->CPDEC_Pu;
                    $preciou        = $valor->CPDEC_Pu_ConIgv;
                    $subtotal       = $valor->CPDEC_Subtotal;
                    $igv            = $valor->CPDEC_Igv;
                    $total          = $valor->CPDEC_Total;
                    $moned_cod      = $valor->MONED_Codigo;

                    $lugar++;
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  $fecha);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $serie);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  $numero);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  $documento);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  $denominacion);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar",  $moneda);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("G$lugar",  $unidad);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("H$lugar",  $codigo);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("I$lugar",  $descripcion);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("J$lugar",  $cantidad);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("K$lugar",  $valoru);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("L$lugar",  $preciou);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("M$lugar",  $subtotal);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("N$lugar",  $igv);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("O$lugar",  $total);
                    
                    if ($moned_cod==1) {
                        $total_s += $total;
                    }else{
                        $total_d += $total;
                    }
                }
            }

            $lugar++;
            $lugar++;

            $t_finals               = $total_s;
            $d_finals               = $total_d;
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  "TOTAL");    
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  "S/."); 
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar",  $t_finals); 

            if ($total_d>0) {
                $lugar++;
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar",  "TOTAL");    
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  "USD$"); 
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar",  $d_finals); 
            }   


            for($i = 'a'; $i <= 'O'; $i++){
                $this->excel->setActiveSheetIndex($hoja)->getColumnDimension($i)->setAutoSize(true);
            }              

            $filename = "Reporte por Cliente ".date("YmdHis").".xls";
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment;filename=$filename");
            header("Cache-Control: max-age=0");
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save('php://output');       
    }

#FIN REPORTE DE VENTAS POR CLIENTE

    
public function registro_ventas_pdf2($tipo_oper, $tipo_doc = "F", $fecha1, $fecha2, $forma_pago="", $consolidado=0, $sucursal='') 
    {
        $this->load->library('PdfHtml');
        $dompdf = new PdfHtml();

        $filter = new stdClass();
        $filter->tipo_oper  = $tipo_oper;
        $filter->tipo       = $tipo_doc;
        $filter->fecha1     = $fecha1;
        $filter->fecha2     = $fecha2;
        $empresa = $this->somevar['empresa'];
        if (isset($forma_pago) && $forma_pago!="" && $forma_pago!="-") {
            $forma_pago = $forma_pago;
        }else{
            $forma_pago = "";
        }

        $companias = array();
        $array_compania =  $this->compania_model->listar_establecimiento($empresa);
        foreach ($array_compania as $key => $value){
            $companias[] = $value->COMPP_Codigo;
        }

        $rowSucursal = $this->compania_model->obtener_compania($sucursal);
        $establecimiento = $this->emprestablecimiento_model->obtener($rowSucursal[0]->EESTABP_Codigo);
        $datos_empresa = $this->empresa_model->obtener_datosEmpresa($rowSucursal[0]->EMPRP_Codigo);
        $rowFormaPago = $this->formapago_model->getFpagos();

        $companias = implode("','",$companias);
        $filter->consolidado = $consolidado;

        if (!empty($forma_pago))
            $filter->forma_pago  = $forma_pago;

        $filter->companias   = $companias;

        $info = $this->ventas_model->resumen_ventas_mensual($filter);
        $html = $this->load->view('reportes/reporteVentaNubePDF', [
            'data' => $info,
            'establecimiento' => $establecimiento,
            'datos_empresa' => $datos_empresa,
            'fecha1' => $fecha1,
            'fecha2' => $fecha2,
            'rowsFormaPago' => $rowFormaPago,
            'db' => $this
        ], true);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
    
        $dompdf->render();
        $dompdf->stream("Reporte_ventas_consolidado.pdf", array("Attachment" => false));
    }
    



}
?>