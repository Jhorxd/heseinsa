<?php

class Cobros extends Controller {

    public function __construct() {
        parent::Controller();
        $this->load->model('tesoreria/pago_model');
        $this->load->model('maestros/configuracion_model');
        $this->load->model('ventas/comprobante_model');
        $this->load->model('maestros/moneda_model');
        $this->load->model('maestros/formapago_model');
        $this->load->model('maestros/tipocambio_model');
        $this->load->model('compras/proveedor_model');
        $this->load->model('ventas/cliente_model');
        $this->load->model('maestros/compania_model');
        $this->load->library('lib_props');
        $this->somevar['compania'] = $this->session->userdata('compania');
        $this->somevar['empresa'] = $this->session->userdata('empresa');
        $this->somevar['user'] = $this->session->userdata('user');
        $this->somevar['rol'] = $this->session->userdata('rol');
    }

    public function index() {
        
    }

    public function planilla() {
        
        $lista = '';
        $total_soles = '';
        $total_dolares = '';
        $resumen_suma = '';
        $resumen_suma_d = '';
        $resumen_cantidad = '';
        $resumen_fpago = '';
        $formapago = '';
        $f_ini = $this->input->post('fecha_inicio') != '' ? $this->input->post('fecha_inicio') : '01/' . date('m/Y');
        $f_fin = $this->input->post('fecha_fin') != '' ? $this->input->post('fecha_fin') : date('d/m/Y');
        if ($this->input->post('forma_pago') != '') {
            $formapago = $this->input->post('forma_pago');
        } else {
            $formapago = '';
        }

        $comp_select = array();
        $lista_companias = $this->compania_model->listar_establecimiento($this->somevar['empresa']);
        foreach ($lista_companias as $key => $compania) {
            if (count($_POST) > 0) {
                if ($this->input->post('COMPANIA_' . $compania->COMPP_Codigo) == '1') {
                    $comp_select[] = $compania->COMPP_Codigo;
                    $lista_companias[$key]->checked = true;
                }
                else
                    $lista_companias[$key]->checked = false;
            }else {
                $comp_select[] = $compania->COMPP_Codigo;
                $lista_companias[$key]->checked = true;
            }
        }
        $lista_cuentaspago = $this->cuentaspago_model->buscar_x_fechas(human_to_mysql($f_ini), human_to_mysql($f_fin), '1', $comp_select,$formapago);
        $lista = array();
        $total_soles = 0;
        $total_dolares = 0;
        $formapago_soles = array(0, 0, 0, 0, 0, 0);
        $formapago_dolares = array(0, 0, 0, 0, 0, 0);
        $cantidad = array(0, 0, 0, 0, 0, 0);
        $total_soles = 0;
        $monto_dolares = 0;
        foreach ($lista_cuentaspago as $value) {
            $fecha_cuenta = mysql_to_human($value->CUE_FechaOper);
            $moneda_cuenta = $value->MONED_Simbolo2;
            $monto_cuenta = $value->CUE_Monto;

            $fecha = mysql_to_human($value->PAGC_FechaOper);
            $forma_pago = $this->pago_model->obtener_forma_pago($value->PAGC_FormaPago);

            $temp = $this->obtener_nombre_numdoc('CLIENTE', $value->CLIP_Codigo);
            $tipo_persona = $temp['tipo_persona'] == 2 ? 'NATURAL' : 'JURIDICO';
            $numdoc = $temp['numdoc'];
            $nombre = $temp['nombre'];
            $moneda = $value->MONED_Simbolo;
            $tdc = number_format($value->PAGC_TDC, 2);

            $monto_soles = 0;
            $monto_dolares = 0;
            if ($value->MONED_Codigo == 1) {
                $monto_soles = $value->CPAGC_Monto;
                $formapago_soles[$value->PAGC_FormaPago - 1]+=$monto_soles;
                $total_soles+=$monto_soles;
            } else {
                $monto_dolares = $value->CPAGC_Monto;
                $formapago_dolares[$value->PAGC_FormaPago - 1]+=$monto_dolares;
                $total_dolares+=$monto_dolares;
            }

            $cantidad[$value->PAGC_FormaPago - 1]++;

            $resumen_compania_sol[$value->COMPP_Codigo] = (isset($resumen_compania_sol[$value->COMPP_Codigo]) ? $resumen_compania_sol[$value->COMPP_Codigo] : 0) + $monto_soles;
            $resumen_compania_dol[$value->COMPP_Codigo] = (isset($resumen_compania_dol[$value->COMPP_Codigo]) ? $resumen_compania_dol[$value->COMPP_Codigo] : 0) + $monto_dolares;
            $lista[] = array($fecha, $forma_pago, $fecha_cuenta, $moneda_cuenta, number_format($monto_cuenta, 2), $tipo_persona, $numdoc, $nombre, $moneda, $tdc, ($monto_soles != 0 ? number_format($monto_soles, 2) : ''), ($monto_dolares != 0 ? number_format($monto_dolares, 2) : ''));
        }

        $lista_resumen = array();
        $lista_resumen[0] = array('EFECTIVO', $formapago_soles[0], $formapago_dolares[0], $cantidad[0]);
        $lista_resumen[1] = array('DEPOSITO', $formapago_soles[1], $formapago_dolares[1], $cantidad[1]);
        $lista_resumen[2] = array('CHEQUE', $formapago_soles[2], $formapago_dolares[2], $cantidad[2]);
        $lista_resumen[3] = array('CANJE POR FACTURA', $formapago_soles[3], $formapago_dolares[3], $cantidad[3]);
        $lista_resumen[4] = array('NOTA DE CREDITO', $formapago_soles[4], $formapago_dolares[4], $cantidad[4]);
        $lista_resumen[5] = array('DESCUENTO', $formapago_soles[5], $formapago_dolares[5], $cantidad[5]);

        $total_soles_res = 0;
        $total_dolares_res = 0;
        $total_cantidad = 0;
        for ($i = 0; $i <= 5; $i++) {
            $lista_resumen[$i] = array($this->pago_model->obtener_forma_pago($i + 1), $formapago_soles[$i] > 0 ? number_format($formapago_soles[$i], 2) : 0, $formapago_dolares[$i] > 0 ? number_format($formapago_dolares[$i], 2) : 0, $cantidad[$i]);
            $total_soles_res+=$formapago_soles[$i];
            $total_dolares_res+=$formapago_dolares[$i];
            $total_cantidad+=$cantidad[$i];
        }
        $total_compani_sol = 0;
        $total_compani_dol = 0;
        foreach ($lista_companias as $compania) {
            if (isset($resumen_compania_sol[$compania->COMPP_Codigo])) {
                $total_compani_sol+=$resumen_compania_sol[$compania->COMPP_Codigo];
                $resumen_compania_sol[$compania->COMPP_Codigo] = $resumen_compania_sol[$compania->COMPP_Codigo] > 0 ? number_format($resumen_compania_sol[$compania->COMPP_Codigo], 2) : 0;
            }else
                $resumen_compania_sol[$compania->COMPP_Codigo] = 0;
            if (isset($resumen_compania_dol[$compania->COMPP_Codigo])) {
                $total_compani_dol+=$resumen_compania_dol[$compania->COMPP_Codigo];
                $resumen_compania_dol[$compania->COMPP_Codigo] = $resumen_compania_dol[$compania->COMPP_Codigo] > 0 ? number_format($resumen_compania_dol[$compania->COMPP_Codigo], 2) : 0;
            }else
                $resumen_compania_dol[$compania->COMPP_Codigo] = 0;
        }
        $data['cboformapago'] = $this->OPTION_generador($this->formapago_model->listar(), 'FORPAP_Codigo', 'FORPAC_Descripcion', $formapago);
        $data['f_ini'] = $f_ini;
        $data['f_fin'] = $f_fin;
        $data['TODOS'] = $this->input->post('TODOS') == '1' ? true : false;
        $data['lista_companias'] = $lista_companias;
        $data['lista'] = $lista;
        $data['lista_resumen'] = $lista_resumen;
        $data['total_soles'] = number_format($total_soles, 2);
        $data['total_dolares'] = number_format($total_dolares, 2);
        $data['total_soles_res'] = number_format($total_soles_res, 2);
        $data['total_dolares_res'] = number_format($total_dolares_res, 2);
        $data['total_cantidad'] = $total_cantidad;
        $data['resumen_compania_sol'] = $resumen_compania_sol;
        $data['resumen_compania_dol'] = $resumen_compania_dol;
        $data['total_compani_sol'] = number_format($total_compani_sol, 2);
        $data['total_compani_dol'] = number_format($total_compani_dol, 2);
        $this->layout->view('reportes/planilla_cobranza', $data);
    }

    function obtener_nombre_numdoc($tipo, $codigo) {
        $nombre = '';
        $numdoc = '';
        $tipo_persona = '';
        if ($tipo == 'CLIENTE') {
            $datos_cliente = $this->cliente_model->obtener($codigo);
            if ($datos_cliente) {
                $nombre = $datos_cliente->nombre;
                $numdoc = $datos_cliente->ruc;
                $tipo_persona = $datos_cliente->tipo;
            }
        } else {
            $datos_proveedor = $this->proveedor_model->obtener($codigo);
            if ($datos_proveedor) {
                $nombre = $datos_proveedor->nombre;
                $numdoc = $datos_proveedor->ruc;
                $tipo_persona = $datos_cliente->tipo;
            }
        }
        return array('numdoc' => $numdoc, 'nombre' => $nombre, 'tipo_persona' => $tipo_persona);
    }

    public function cuentasporcobrar() 
    {
        
        $filter = new stdClass();
        $fecha_ini = $this->input->post('fechai');
        $filter->fechai = ($fecha_ini != "") ? $fecha_ini : "";
        $fecha_fin = $this->input->post('fechaf');
        $filter->fechaf = ($fecha_fin != "") ? $fecha_fin : "";

        $filter->serie              = $this->input->post('serie');
        $filter->numero             = $this->input->post('numero');
        $filter->cliente            = $this->input->post('cliente');
        $filter->ruc_cliente        = $this->input->post('ruc_cliente');
        $filter->nombre_cliente     = $this->input->post('nombre_cliente');
        $filter->cond_pago          = $this->input->post('estado_pago');
        $filter->comprobante        = $this->input->post('comprobante');
        $filter->proveedor          = $this->input->post('proveedor');
        $filter->ruc_proveedor      = $this->input->post('ruc_proveedor');
        $filter->nombre_proveedor   = $this->input->post('nombre_proveedor');
        $filter->producto           = '';
        $filter->codproducto        = '';
        $filter->nombre_producto    = '';
        $filter->MONED_Codigo       = $this->input->post('monedalista');
        $filter->tipo_cuenta        = $this->input->post('tipo_c');

        $filter->order = 'CPC_Fecha';
        $filter->dir = 'desc';

        $titulo_reporte             = $this->input->post('tipo_c')==1 ? "Reporte Cuentas por Cobrar":"Reporte de Cuenta por Pagar";
        
        $this->load->library('Excel');
        
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle($titulo_reporte);
       
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
             $estiloColumnasTitulo2 = array(
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
                                                'color' => array('rgb' => 'A6A6A6')
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

        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('2');
        
        
        // $listaVendedores = $this->directivo_model->listarVendedores();

        $lugar = 6;
                      
        $this->excel->setActiveSheetIndex(0)
        ->setCellValue("A$lugar", "N° DE FACTURA")
        ->setCellValue("B$lugar", "EMPRESA")
        ->setCellValue("C$lugar", "CIUDAD")
        ->setCellValue("D$lugar", "CORRESPONDE AL PACK (SI o NO)")
        ->setCellValue("E$lugar", "RUBRO")
        ->setCellValue("F$lugar", "FECHA DE EMISION")
        ->setCellValue("G$lugar", "FECHA DE RECEPCION POR PARTE DEL CLIENTE")
        ->setCellValue("H$lugar", "N° DE GUIA HESEINSA")
        ->setCellValue("I$lugar", "MONEDA")
        ->setCellValue("J$lugar", "MONTO")
        ->setCellValue("K$lugar", "3%/6% RETENCION")
        ->setCellValue("L$lugar", "MONTO NETO A COBRAR")
        ->setCellValue("M$lugar", "FORMA DE PAGO")
        ->setCellValue("N$lugar", "ESTADO")
        ->setCellValue("O$lugar", "Nº DE ORDEN DE COMPRA")
        ->setCellValue("P$lugar", "POSIBLE FECHA DE PAGO")
        ->setCellValue("Q$lugar", "FECHA DE PAGO POR PARTE DEL CLIENTE")
        ->setCellValue("R$lugar", "BANCO");


        $this->excel->getActiveSheet()->getStyle('A6:R6')->applyFromArray($estiloColumnasTitulo);

        $listado_cuentas = $this->cuentas_model->getCuentas($filter);
   
        // $ultima = 10;
        // $primer_saldo=0;
        foreach ($listado_cuentas as $indice => $data) {
            

            $listado_pagos = $this->cuentaspago_model->listar($data->CUE_Codigo);
            
            
            if($listado_pagos == NULL¨){
                $avance = 0;
            }
            else{
                $avance = $this->pago_model->sumar_pagos($listado_pagos, $data->MONED_Codigo);
            }

            switch ($data->CUE_FlagEstadoPago){
                case 'V':
                    $paymentStatus = 'PENDIENTE';
                    break;
                case 'A':
                    $paymentStatus = 'AVANCE';
                    break;
                default:
                    $paymentStatus = 'CANCELADO';
                    break;
            }
            
            $saldo = $data->CUE_Monto - $avance;
            
            $lugar++;

            $relatedData = $this->cuentaspago_model->obtainInvoiceRelatedToGuide($data->CUE_CodDocumento)[0];

            $this->excel->setActiveSheetIndex(0)
            ->setCellValue("A$lugar", $data->CPC_Serie.'-'.$data->CPC_Numero)
            ->setCellValue("B$lugar", $data->nombre)
            ->setCellValue("C$lugar", $relatedData->UBIGC_Descripcion)
            ->setCellValue("D$lugar", '')
            ->setCellValue("E$lugar", $data->LINC_Descripcion)
            ->setCellValue("F$lugar", $relatedData->CPC_Fecha)
            ->setCellValue("G$lugar", date('Y-m-d', strtotime($relatedData->CPC_Fecha . "+ 1 days")))
            ->setCellValue("H$lugar", $relatedData->GUIAREMC_Serie.'-'.$relatedData->GUIAREMC_Numero)
            ->setCellValue("I$lugar", $data->MONED_Simbolo)
            ->setCellValue("J$lugar", $data->CUE_Monto)
            ->setCellValue("K$lugar", $this->truncar(($data->CUE_Monto/100)*$relatedData->CPC_RetencionPorc, 2))
            ->setCellValue("L$lugar", $this->truncar(($data->CUE_Monto/100)*(100-$relatedData->CPC_RetencionPorc),2))
            ->setCellValue("M$lugar", $relatedData->FORPAC_Descripcion)
            ->setCellValue("N$lugar", $paymentStatus)
            ->setCellValue("O$lugar", $relatedData->CPP_Compracliente)
            ->setCellValue("P$lugar", $relatedData->CUOT_Fecha)
            ->setCellValue("Q$lugar", $data->PAGC_FechaOper)
            ->setCellValue("R$lugar", $data->BANC_Nombre);

        }

        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(20);


        $this->excel->setActiveSheetIndex(0)->mergeCells('A2:C2')->setCellValue('A2', $_SESSION['nombre_empresa']);
        $this->excel->getActiveSheet()->getStyle('A2')->applyFromArray($estiloColumnasTitulo2);

        $this->excel->setActiveSheetIndex(0)->setCellValue("A5", $titulo_reporte);
        
        // for($i = 'A'; $i <= 'Z'; $i++){
        //     $this->excel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(true);
        // }

        
        $filename = "Reporte ".date('Y-m-d').".xls"; //save our workbook as this file name
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0"); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function truncar($numero, $digitos)
    {
        $truncar = 10**$digitos;
        return intval($numero * $truncar) / $truncar;
    }

}

?>