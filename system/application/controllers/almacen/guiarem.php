<?php
ini_set('error_reporting', 1);
/*
include("system/application/libraries/cezpdf.php");
include("system/application/libraries/class.backgroundpdf.php");
*/
class Guiarem extends controller{

    private $_hoy;
    ###############################COM####################################
    public function __construct(){
        parent::Controller();
        $this->load->model('almacen/guiarem_model');
        $this->load->model('almacen/guiasa_model');
        $this->load->model('almacen/guiain_model');
        $this->load->model('almacen/guiaremdetalle_model');
        $this->load->model('almacen/guiasadetalle_model');
        $this->load->model('almacen/guiaindetalle_model');
        $this->load->model('almacen/almacen_model');
        $this->load->model('almacen/seriemov_model');
        $this->load->model('almacen/Serie_model');
        $this->load->model('almacen/seriedocumento_model');
        $this->load->model('almacen/almacenproducto_model');
        $this->load->model('almacen/almacenproductoserie_model');
        $this->load->model('almacen/producto_model');
        $this->load->model('almacen/unidadmedida_model');
        $this->load->model('almacen/tipomovimiento_model');
        $this->load->model('maestros/documento_model');
        $this->load->model('maestros/compania_model');
        $this->load->model('maestros/ubigeo_model');
        $this->load->model('maestros/empresa_model');
        $this->load->model('maestros/companiaconfiguracion_model');
        $this->load->model('maestros/companiaconfidocumento_model');
        $this->load->model('maestros/moneda_model');
        $this->load->model('maestros/emprestablecimiento_model');
        $this->load->model('compras/ocompra_model');
        $this->load->model('compras/cotizacion_model');
        $this->load->model('compras/proveedor_model');
        $this->load->model('ventas/cliente_model');
        $this->load->model('ventas/presupuesto_model');
        $this->load->model('ventas/comprobante_model');
        $this->load->model('seguridad/usuario_model');
        $this->load->model('maestros/proyecto_model');
        $this->load->model('maestros/tipodocumento_model');
        $this->load->model('maestros/tipocodigo_model');
        $this->load->model('almacen/marca_model');
        $this->load->model('almacen/fabricante_model');
        $this->load->model('ventas/tipocliente_model');        
        $this->load->helper('form', 'url');
        $this->load->helper('utf_helper');
        $this->load->helper('util_helper');
        $this->load->helper('my_almacen');
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->library('lib_props');
        $this->load->library('tokens');
        $this->somevar['rol'] = $this->session->userdata('rol');
        $this->somevar['user'] = $this->session->userdata('user');
        $this->somevar['compania'] = $this->session->userdata('compania');
        $this->somevar['empresa'] = $this->session->userdata('empresa');
        $this->somevar['establec'] = $this->session->userdata('establec');
        date_default_timezone_set('America/Lima');
        $this->_hoy = mdate("%Y-%m-%d ", time());
    }
    ###############################FIN####################################
    
    #######################################
    #ACTUALIZACION 08/09/2021
    #DEV LUIS VALDES
    #######################################
#INICIO
//Nueva funcion exportar Guia para compras  14/08/2023
//Autor : Ingeniero Christopher

//Exportacion de formato de guias compras 

    
    public function formato_guias_compras()
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


        $estiloColumnasTituloCabezera= array(
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
            'color' => array('rgb' => '97d6ed')
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
        
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "Guia de remision de compra");
        $this->excel->getActiveSheet()->getStyle("A$lugar")->applyFromArray($estiloColumnasTituloCabezera);
        
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "Nª Orden");
        
        //Datos del proveedor
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "DATOS DEL PROVEEDOR");
        $this->excel->getActiveSheet()->getStyle("A$lugar")->applyFromArray($estiloColumnasTituloCabezera);
        
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "RUC/DNI");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "DENOMINACION(Razón Social)");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "PESO TOTAL");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "NÚMERO DE BULTOS");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "MODALIDAD DE TRANSPORTE");

        //Datos del traslado
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "DATOS DEL ENVIO");
        $this->excel->getActiveSheet()->getStyle("A$lugar")->applyFromArray($estiloColumnasTituloCabezera);
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "EMPRESA TRANSPORTE");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "RUC");

        //Datos del conductor
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "DATOS DEL VEHICULO/CONDUCTOR");
        $this->excel->getActiveSheet()->getStyle("A$lugar")->applyFromArray($estiloColumnasTituloCabezera);
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "NOMBRE CONDUCTOR");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "APELLIDO");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "DNI CONDUCTOR");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "REGISTRO MTC");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "CERTIFICADO");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "LICENCIA");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "PLACA");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "MARCA VEHICULO");

        $lugar+=2;

        
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "ITEM");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  "CODIGO");   
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  "DESCRIPCION");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  "CANTIDAD");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  "PRECIO");
        $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($estiloColumnasTitulo);

        $this->excel->getActiveSheet()->getColumnDimension("A")->setWidth("30");
        $this->excel->getActiveSheet()->getColumnDimension("B")->setWidth("30");
        $this->excel->getActiveSheet()->getColumnDimension("C")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("D")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("E")->setWidth("10");
        

        $filename = "FORMATO_GUIA_".date("YmdHis").".xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
    }
    
       public function formato_guias()
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


        $estiloColumnasTituloCabezera= array(
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
            'color' => array('rgb' => '97d6ed')
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
        
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "Guia de remision venta");
        $this->excel->getActiveSheet()->getStyle("A$lugar")->applyFromArray($estiloColumnasTituloCabezera);
        
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "Nª Orden");
        
        //Datos del Cliente
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "DATOS DE TRANSLADO");
        $this->excel->getActiveSheet()->getStyle("A$lugar")->applyFromArray($estiloColumnasTituloCabezera);
        
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "RUC/DNI");
        
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "DENOMINACION(Razón Social)");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "PESO TOTAL");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "NÚMERO DE BULTOS");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "MODALIDAD DE TRANSPORTE");
 

        //Datos del traslado
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "DATOS DEL ENVIO");
        $this->excel->getActiveSheet()->getStyle("A$lugar")->applyFromArray($estiloColumnasTituloCabezera);
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "EMPRESA TRANSPORTE");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "RUC");

        //Datos del conductor
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "DATOS DEL VEHICULO/CONDUCTOR");
        $this->excel->getActiveSheet()->getStyle("A$lugar")->applyFromArray($estiloColumnasTituloCabezera);
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "NOMBRE CONDUCTOR");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "APELLIDO");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "DNI CONDUCTOR");
        
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "REGISTRO MTC");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "CERTIFICADO");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "LICENCIA");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "PLACA");
        $lugar++;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "MARCA VEHICULO");

        $lugar+=2;

        
        $lugar++;
      //  $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "ITEM");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "CODIGO");   
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  "CANTIDAD");
       // $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  "PRECIO");
        $this->excel->getActiveSheet()->getStyle("A$lugar:B$lugar")->applyFromArray($estiloColumnasTitulo);

        $this->excel->getActiveSheet()->getColumnDimension("A")->setWidth("30");
        $this->excel->getActiveSheet()->getColumnDimension("B")->setWidth("30");
 
                // Forzar toda la columna A y B a formato de texto
        $this->excel->getActiveSheet()->getStyle('A:A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $this->excel->getActiveSheet()->getStyle('B:B')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);


        $filename = "FORMATO_GUIA_".date("YmdHis").".xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function reportGuia($startDate, $endDate){

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


        $estiloColumnasTituloCabezera= array(
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
            'color' => array('rgb' => '97d6ed')
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
        
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "FECHA EMISIÓN");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  "OPERACION");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  "SERIE");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  "NÚMERO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  "RUC");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar",  "DENOMINACIÓN");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("G$lugar",  "ALMACEN");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("H$lugar",  "DETALLE (LINEAS)");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("I$lugar",  "CANTIDAD");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("J$lugar",  "PESO BRUTO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("K$lugar",  "PESO UNIDAD DE MEDIDA");
        //$this->excel->setActiveSheetIndex($hoja)->setCellValue("L$lugar",  "VENDEDOR");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("L$lugar",  "FECHA DE TRANSLADO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("M$lugar",  "TRANSPORTISTA DOCUMENTO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("N$lugar",  "TRANSPORTISTA DENOMINACIÓN");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("O$lugar",  "PLACA");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("P$lugar",  "CONDUCTOR DOCUMENTO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("Q$lugar",  "CONDUCTOR NOMBRE");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("R$lugar",  "CONDUCTOR APELLIDOS");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("S$lugar",  "CONDUCTOR LICENCIA");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("T$lugar",  "PARTIDA UBIGEO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("U$lugar",  "PARTIDA DIRECCIÓN");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("V$lugar",  "LLEGADA UBIGEO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("W$lugar",  "LLEGADA DIRECCIÓN");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("X$lugar",  "OBSERVACIONES");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("Y$lugar",  "ESTADO");

        
        
        $this->excel->getActiveSheet()->getStyle("A$lugar:Y$lugar")->applyFromArray($estiloColumnasTitulo);

        $this->excel->getActiveSheet()->getColumnDimension("A")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("B")->setWidth("10");
        $this->excel->getActiveSheet()->getColumnDimension("C")->setWidth("10");
        $this->excel->getActiveSheet()->getColumnDimension("D")->setWidth("10");
        $this->excel->getActiveSheet()->getColumnDimension("E")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("F")->setWidth("50");
        $this->excel->getActiveSheet()->getColumnDimension("G")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("H")->setWidth("50");
        $this->excel->getActiveSheet()->getColumnDimension("I")->setWidth("10");
        $this->excel->getActiveSheet()->getColumnDimension("J")->setWidth("10");
        $this->excel->getActiveSheet()->getColumnDimension("K")->setWidth("10");
        //$this->excel->getActiveSheet()->getColumnDimension("L")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("L")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("M")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("N")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("O")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("P")->setWidth("12");
        $this->excel->getActiveSheet()->getColumnDimension("Q")->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension("R")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("S")->setWidth("20");
        $this->excel->getActiveSheet()->getColumnDimension("T")->setWidth("12");
        $this->excel->getActiveSheet()->getColumnDimension("U")->setWidth("50");
        $this->excel->getActiveSheet()->getColumnDimension("V")->setWidth("12");
        $this->excel->getActiveSheet()->getColumnDimension("W")->setWidth("50");
        $this->excel->getActiveSheet()->getColumnDimension("X")->setWidth("50");
        $this->excel->getActiveSheet()->getColumnDimension("Y")->setWidth("15");
        //$this->excel->getActiveSheet()->getColumnDimension("Z")->setWidth("15");

        $lugar++;

        $date = new stdClass();
        $date->startDate = $startDate;
        $date->endDate = $endDate;

        $dataGuia = $this->guiarem_model->reportGuia($date);

        

        foreach($dataGuia as $value){
           
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar", $value->GUIAREMC_Fecha);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar", $value->GUIAREMC_TipoOperacion);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar", $value->GUIAREMC_Serie);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar", $value->GUIAREMC_Numero);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar", empty($value->numero_proveedor)?$value->numero:$value->numero_proveedor);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("F$lugar", empty($value->razon_social_proveedor)?$value->razon_social:$value->razon_social_proveedor);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("G$lugar", $value->ALMAC_Descripcion);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("H$lugar", $value->GUIAREMDETC_Descripcion);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("I$lugar", $value->GUIAREMDETC_Cantidad);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("J$lugar", $value->GUIAREMC_PesoTotal);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("K$lugar", $value->UNDMED_Simbolo);
            //$this->excel->setActiveSheetIndex($hoja)->setCellValue("K$lugar", $value->vendedor);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("L$lugar", $value->GUIAREMC_FechaTraslado);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("M$lugar", $value->GUIAREMC_RucEmpresaTransp);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("N$lugar", $value->GUIAREMC_EmpresaTransp);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("O$lugar", $value->GUIAREMC_Placa);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("P$lugar", $value->GUIAREMC_PersReceDNI);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("Q$lugar", $value->GUIAREMC_NombreConductor);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("R$lugar", $value->GUIAREMC_ConductorApellido);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("S$lugar", $value->GUIAREMC_Licencia);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("T$lugar", $value->GUIAREMC_UbigeoPartida);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("U$lugar", $value->GUIAREMC_PuntoPartida);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("V$lugar", $value->GUIAREMC_UbigeoLlegada);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("W$lugar", $value->GUIAREMC_PuntoLlegada);
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("X$lugar", $value->GUIAREMC_Observacion);

            switch ($value->GUIAREMC_FlagEstado){
                case 1:
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("Y$lugar", 'APROBADO');
                    break;
                case 0:
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("Y$lugar", 'ANULADO');
                    break;
                default:
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("Y$lugar", 'SIN APROBAR');
                    break;
            }
            $lugar++;
        }

        $filename = "REPORTE_GUIA_".date("YmdHis").".xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
    }
    
       public function Leer_Guias_Excel() {
        //error_reporting(0);
        $respuesta   = array();
        $this->load->library('Excel');
        $archivo=$_FILES["file"]["tmp_name"];
        $inputFileType = PHPExcel_IOFactory::identify($archivo);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($archivo);
        $sheet = $objPHPExcel->getSheet(0); 
        $highestRow = $sheet->getHighestRow(); 
        $highestColumn = $sheet->getHighestColumn();

        $detalles   = array();
        $errores    = array();
        $erroneo    = false;
        $erClien    = false;
        $datos_guia = array();

            if ($highestRow > 19) 
            {   
                $fila=2;
                $numeroOrden    = $sheet->getCell('B'.$fila)->getValue();

                $fila+=2;
                $documentoCliente    = $sheet->getCell('B'.$fila)->getValue();
                $fila++;
                $denominacion   = $sheet->getCell('B'.$fila)->getValue();
                
                //Nuevo
                $fila++;
                $pesoExcel   = $sheet->getCell('B'.$fila)->getValue();
                $fila++;
                $bultoExcel   = $sheet->getCell('B'.$fila)->getValue();
                $fila++;
                $modoTransporte   = $sheet->getCell('B'.$fila)->getValue();
                $fila+=2;
                $empresaExcel   = $sheet->getCell('B'.$fila)->getValue();
                $fila++;
                $rucExcel   = $sheet->getCell('B'.$fila)->getValue();

                $fila+=2;
                $conductorExcel   = $sheet->getCell('B'.$fila)->getValue();
                $fila++;
                $apellidoExcel   = $sheet->getCell('B'.$fila)->getValue();

                $fila++;
                $dniExcel   = (string)$sheet->getCell('B'.$fila)->getValue();

                $fila++;
                $mtcExcel   = $sheet->getCell('B'.$fila)->getValue();
                $fila++;
                $certificadoExcel   = $sheet->getCell('B'.$fila)->getValue();
                $fila++;
                $licenciaExcel   = $sheet->getCell('B'.$fila)->getValue();
                $fila++;
                $PlacaExcel   = $sheet->getCell('B'.$fila)->getValue();
                $fila++;
                $marcaExcel   = $sheet->getCell('B'.$fila)->getValue();
                //Fin Nuevo

                $fecha_traslado = date('Y-m-d');
                //$ruc_cliente = "20394040011";//ese ruc es una prueba si existe o no existe quitar ese codigo y el ruc
                if ($ruc_cliente!=="" || $denominacion!="") { 
                    $cabecera=[
                        "numero_orden" => $numeroOrden,
                        "ruc_cliente"=>$documentoCliente,
                        "denominacion"=>$denominacion,
                        "Fecha_Traslado"=>$fecha_traslado,
                        "pesoExcel"=>$pesoExcel,
                        "modoTransporte"=>$modoTransporte,
                        "bultoExcel"=>$bultoExcel,
                        "empresaExcel"=>$empresaExcel,
                        "rucExcel"=>$rucExcel,
                        "conductorExcel"=>$conductorExcel,
                        "apellidoExcel"=>$apellidoExcel,
                        "mtcExcel"=>$mtcExcel,
                        "certificadoExcel"=>$certificadoExcel,
                        "licenciaExcel"=>$licenciaExcel,
                        "PlacaExcel"=>$PlacaExcel,
                        "dniExcel"=>$dniExcel,
                        "marcaExcel"=>$marcaExcel
                    ];
                }else{
                    goto fin;
                }
                //BUSCA CLIENTE
                $consulta = $this->cliente_model->buscarClienteRucEnter($documentoCliente, $this->somevar['compania']);
                
                if ($consulta==null) {
                    $erClien    = true;
                    goto fin;
                }else{
                    $clienteCod = $consulta[0]->CLIP_Codigo;
                }

                for ($row=20; $row <=$highestRow; $row++) {
                    
                   // $nitem       = $sheet->getCell('A'.$row)->getValue();
                   $codigo = (string) $sheet->getCell('A'.$row)->getValue();

                   // $descripcion = $sheet->getCell('C'.$row)->getValue();
                    $cantidad = $sheet->getCell('B'.$row)->getValue();
                  //  $precio = $sheet->getCell('E'.$row)->getValue();

                    $productoResult="";
                    if ($codigo!="") {
                        $productoResult = $this->producto_model->getProductoCodigo($codigo);
                    }

                    if ($productoResult != NULL){
                        if ($cantidad>0) {
                            $productoCodigo   = $productoResult[0]->PROD_Codigo;
                            $detalles[] = ["nitem"=>$nitem,"Producto"=>$codigo,"descripcion"=>$descripcion,"Cantidad"=>$cantidad,"precio"=>0];
                        }
                    }else{
                        $errores[]  = ["nitem"=>$nitem,"Producto"=>$codigo,"descripcion"=>$descripcion,"Cantidad"=>$cantidad,"precio"=>0,"codigo"=>$codigo];
                        //$erroneo    = true;
                    }
                }


                $datos_guia[] = ["Cabecera"=>$cabecera,"Detalles"=>$detalles];


                fin:

                if (count($datos_guia)>0 && $erroneo==false)
                {
                    //$this->somevar['rol'] = $this->session->userdata('rol');
                    //$this->somevar['user'] = $this->session->userdata('user');
                    //$this->somevar['compania'] = $this->session->userdata('compania');
                    //$this->somevar['empresa'] = $this->session->userdata('empresa');
                    //$this->somevar['establec'] = $this->session->userdata('establec');

                    for ($i=0; $i <count($datos_guia); $i++) { 
                        $establecimientoInfo  = $this->emprestablecimiento_model->listar($this->somevar['empresa'], '', $this->somevar['compania']);
                        $empresaInfo          =  $this->empresa_model->obtener_datosEmpresa($this->somevar['empresa']);

                        $filter = new stdClass();

                        $filter->PROYP_Codigo           = 0;
                        $filter->MONED_Codigo           = 1;
                        $filter->OCOMP_Codigo           = null;
                        $filter->OCOMP_Codigo           = null;
                        $filter->GUIAREMC_TipoOperacion = "V";
                        $filter->PRESUP_Codigo          = NULL;
                        $filter->TIPOMOVP_Codigo        = 1; //Venta
                        $filter->GUIAREMC_OtroMotivo    = "";
                        $filter->GUIAREMC_CodigoUsuario = 0;
                        $filter->ALMAP_Codigo           = 1;
                        $filter->USUA_Codigo            = $this->somevar['user'];
                        $filter->COMPP_Codigo           = $this->somevar['compania'];
                        //$filter->DOCUP_Codigo           = NULL;
                        $filter->GUIAREMC_ModTransporte = (strtolower($datos_guia[$i]["Cabecera"]["modoTransporte"]) == 'publico')?1:2;

                        //DATOS
                        $detalles=$datos_guia[$i]["Detalles"];

                        //DATOS
                        $filter->DOCUP_Codigo = $datos_guia[$i]["Cabecera"]["numero_orden"];
                        $filter->GUIAREMC_PesoTotal = (empty($datos_guia[$i]["Cabecera"]["pesoExcel"])?0:$datos_guia[$i]["Cabecera"]["pesoExcel"]);
                        $filter->GUIAREMC_NumBultos = (empty($datos_guia[$i]["Cabecera"]["bultoExcel"])?0:$datos_guia[$i]["Cabecera"]["bultoExcel"]);

                        $filter->GUIAREMC_EmpresaTransp = $datos_guia[$i]["Cabecera"]["empresaExcel"];
                        $filter->GUIAREMC_RucEmpresaTransp =  $datos_guia[$i]["Cabecera"]["rucExcel"];
                        $filter->GUIAREMC_TipoDocTransp = 6; //RUC

                        //DATOS
                        $sucursalInfo = $this->emprestablecimiento_model->getEmpresaEstablecimiento($this->somevar['establec']);
                        //DATOS

                        $filter->CLIP_Codigo                = $clienteCod;
                        $filter->GUIAREMC_PersReceNombre    = "";
                        $filter->GUIAREMC_PersReceDNI       = $datos_guia[$i]["Cabecera"]["dniExcel"]; 
                        $filter->GUIAREMC_NumeroRef         = "";
                        $filter->GUIAREMC_OCompra           = "";

                        //$filter->GUIAREMC_FechaTraslado = $datos_guia[$i]["Cabecera"]["Fecha_Traslado"];
                        $ft = explode("-",$datos_guia[$i]["Cabecera"]["Fecha_Traslado"]);
                        $filter->GUIAREMC_FechaTraslado=$datos_guia[$i]["Cabecera"]["Fecha_Traslado"];//$ft[2]."-".$ft[1]."-".$ft[0];

                        //DATOS
                        $sucursalInfoP = $this->emprestablecimiento_model->getEmpresaEstablecimientobyEmpresa($this->somevar['empresa']);


                        //Datos de Direccion Cliente

                        $datos_ubigeo_cliente=$this->emprestablecimiento_model->getDireccionClienteUbigeo($clienteCod);

                        if ($datos_ubigeo_cliente[0]->TipoPersona==1) 
                        {
                            $filter->GUIAREMC_UbigeoLlegada = $datos_ubigeo_cliente[0]->UBIGP_Codigo;
                            $filter->GUIAREMC_PuntoLlegada  = $datos_ubigeo_cliente[0]->UBIGEO;
                        }
                        else
                        {
                            $dd=explode("__", $datos_ubigeo_cliente[0]->UBIGEO);
                            $filter->GUIAREMC_UbigeoLlegada = $dd[0];
                            $filter->GUIAREMC_PuntoLlegada  = $dd[1];    
                        }

                        //Datos de Direccion Cliente

                        
                        $filter->GUIAREMC_UbigeoPartida = $sucursalInfoP[0]->UBIGP_Codigo;
                        $filter->GUIAREMC_PuntoPartida  = $sucursalInfoP[0]->EESTAC_Direccion;

                        $filter->GUIAREMC_Fecha         = date("Y-m-d"); 

                        $filter->EMPRP_Codigo           = 0; //PENDIENTE


                        //Nuevo Transportista

                        $datosConductor = $this->cliente_model->buscarConductorDoc($datos_guia[$i]["Cabecera"]["dniExcel"],2);
                        $datosTrans     = $this->cliente_model->transportistaRuc($datos_guia[$i]["Cabecera"]["rucExcel"],2);

                        if($datosTrans == NULL && $datosConductor == NULL){
                            $transportista = new stdClass();
                            $transportista->TRANS_Nombre            = $datos_guia[$i]["Cabecera"]["empresaExcel"];
                            $transportista->TRANS_Doc               = $datos_guia[$i]["Cabecera"]["rucExcel"];
                            $transportista->TRANS_Marca             = $datos_guia[$i]["Cabecera"]["marcaExcel"];
                            $transportista->TRANS_Placa             = $datos_guia[$i]["Cabecera"]["PlacaExcel"];
                            $transportista->TRANS_Registro          = $datos_guia[$i]["Cabecera"]["mtcExcel"];
                            $transportista->TRANS_NombreConductor   = (empty($datos_guia[$i]["Cabecera"]["conductorExcel"])?"":$datos_guia[$i]["Cabecera"]["conductorExcel"]." ".$datos_guia[$i]["Cabecera"]["apellidoExcel"]);
                            $transportista->TRANS_DocConductor      = $datos_guia[$i]["Cabecera"]["dniExcel"];
                            $transportista->TRANS_Licencia          = $datos_guia[$i]["Cabecera"]["licenciaExcel"];
                            $transportista->TRANS_Certificado       = $datos_guia[$i]["Cabecera"]["certificadoExcel"];
                            $this->cliente_model->insertar_transportista($transportista);
                        }elseif ($datosTrans != NULL && $datosConductor == NULL) {
                            $id_trans = $datosTrans[0]->ID_Trans;
                            $transportista = new stdClass();
                            $transportista->TRANS_NombreConductor   = $datos_guia[$i]["Cabecera"]["conductorExcel"]." ".$datos_guia[$i]["Cabecera"]["apellidoExcel"];
                            $transportista->TRANS_DocConductor      = $datos_guia[$i]["Cabecera"]["dniExcel"];
                            $transportista->TRANS_Licencia          = $datos_guia[$i]["Cabecera"]["licenciaExcel"];
                            $this->cliente_model->insertar_transportista($transportista);
                        }elseif ($datosTrans == NULL && $datosConductor != NULL) {
                            $id_trans = $datosConductor[0]->ID_Trans;
                            $transportista = new stdClass();
                            $transportista->TRANS_Nombre        = $datos_guia[$i]["Cabecera"]["empresaExcel"];
                            $transportista->TRANS_Doc           = $datos_guia[$i]["Cabecera"]["rucExcel"];
                            $transportista->TRANS_Marca         = $datos_guia[$i]["Cabecera"]["marcaExcel"];
                            $transportista->TRANS_Placa         = $datos_guia[$i]["Cabecera"]["PlacaExcel"];
                            $transportista->TRANS_Registro      = $datos_guia[$i]["Cabecera"]["mtcExcel"];
                            $transportista->TRANS_Certificado   = $datos_guia[$i]["Cabecera"]["certificadoExcel"];
                            $this->cliente_model->actualizar_transportista($id_trans,$transportista);
                        }else{
                            //no hace nada
                        }

                        //Fin Transportista




                        $filter->GUIAREMC_Marca             = $datos_guia[$i]["Cabecera"]["marcaExcel"];
                        $filter->GUIAREMC_Placa             = $datos_guia[$i]["Cabecera"]["PlacaExcel"];//$ruta[0]->Placa;
                        $filter->GUIAREMC_RegistroMTC       = $datos_guia[$i]["Cabecera"]["mtcExcel"];//$ruta[0]->MTC;
                        $filter->GUIAREMC_Certificado       = $datos_guia[$i]["Cabecera"]["certificadoExcel"];//$ruta[0]->Certificado;
                        $filter->GUIAREMC_Licencia          = $datos_guia[$i]["Cabecera"]["licenciaExcel"];//$ruta[0]->Licencia;
                        $filter->GUIAREMC_NombreConductor   = $datos_guia[$i]["Cabecera"]["conductorExcel"];//$ruta[0]->Nombre_Conductor;
                        $filter->GUIAREMC_ConductorApellido = $datos_guia[$i]["Cabecera"]["apellidoExcel"];//$ruta[0]->Apellido_Conductor;
                        $filter->GUIAREMC_Observacion       = "";//$datos_guia[$i]["Cabecera"]["Observacion"];
                        $filter->GUIAREMC_descuento100      = 0;
                        $filter->GUIAREMC_igv100            = 18;//$this->input->post('igv'); //FALTA
                        $filter->GUIAREMC_subtotal          = 0;//$this->input->post('preciototal'); //FALTA
                        $filter->GUIAREMC_descuento         = 0;//$this->input->post('descuentotal'); //FALTA
                        $filter->GUIAREMC_igv               = 0;//$this->input->post('igvtotal'); //FALTA
                        $filter->GUIAREMC_total             = 0;//$this->input->post('importetotal'); //FALTA
                        

                        $compania           = $this->somevar['compania'];

                        $cofiguracion_datos = $this->configuracion_model->obtener_numero_documento($compania, 10,'V');
                        $numero             = $cofiguracion_datos[0]->CONFIC_Numero + 1;
                        $this->configuracion_model->modificar_configuracion($compania, 10, $numero, $serie1 = null);

                        $filter->GUIAREMC_Numero = $numero;
                        $filter->GUIAREMC_FlagEstado = 2;
                        $filter->GUIAREMC_Serie = $cofiguracion_datos[0]->CONFIC_Serie;


                        $guiarem_id = $this->guiarem_model->insertar($filter);

                        if ($guiarem_id>0) 
                        {

                            for ($j=0; $j <count($detalles); $j++) { 
                                    
                                $producto = $this->producto_model->obtener_producto_x_codigo_usuario($detalles[$j]["Producto"]);
                                //$producto_nombre=$producto[0]->PROD_Nombre;
                                //if ($producto) {
                                //    var_dump($producto);exit;
                                //}else{
                                //    var_dump($detalles[$j]["Producto"]);exit;
                                //
                                //}
                                $producto_nombre="";
                                if ($detalles[$j]["Marca"]!="") 
                                {
                                    $producto_nombre.=" | ".$detalles[$j]["Marca"];
                                }
                                if ($detalles[$j]["Lote"]!="") 
                                {
                                    $producto_nombre.=" | Lote: ".$detalles[$j]["Lote"];
                                }
                                if ($detalles[$j]["Fecha"]!="" && $detalles[$j]["Fecha"]!="00-00-0000") 
                                {
                                    //$producto_nombre.=" | Fecha Venc.: ".$detalles[$j]["Fecha"];
                                }

                                $this->load->model('almacen/productounidad_model');
                                $productoUnidad = $this->productounidad_model->getProductoUnidad($producto[0]->PROD_Codigo);

                                $filter2 = new stdClass();
                                $filter2->GUIAREMP_Codigo           = $guiarem_id;
                                $filter2->PRODCTOP_Codigo           = $producto[0]->PROD_Codigo;
                                $filter2->UNDMED_Codigo             = $productoUnidad[0]->UNDMED_Codigo;
                                $filter2->LOTP_Codigo               = 0;
                                $filter2->AFECT_Codigo              = 1;
                                $filter2->GUIAREMDETC_Cantidad      = $detalles[$j]["Cantidad"];
                                $filter2->GUIAREMDETC_Pu            = 0;
                                $filter2->GUIAREMDETC_Subtotal      = $detalles[$j]["precio"]*$detalles[$j]["Cantidad"]/1.18;
                                $filter2->GUIAREMDETC_Descuento     = 0;
                                $filter2->GUIAREMDETC_Igv           = $detalles[$j]["precio"]*$detalles[$j]["Cantidad"]/6.555555208700783;
                                $filter2->GUIAREMDETC_Total         = $detalles[$j]["precio"]*$detalles[$j]["Cantidad"];
                                $filter2->GUIAREMDETC_Pu_ConIgv     = $detalles[$j]["precio"];
                                $filter2->GUIAREMDETC_Descuento100  = 0;
                                $filter2->GUIAREMDETC_Igv100        = 18;
                                $filter2->GUIAREMDETC_Costo         = 0;
                                $filter2->GUIAREMDETC_Venta         = 0;
                                $filter2->GUIAREMDETC_ITEM          = $detalles[$j]["nitem"];
                                $filter2->GUIAREMDETC_Peso          = $detalles[$j]["Peso"];
                                $filter2->GUIAREMDETC_GenInd        = "";
                                $filter2->GUIAREMDETC_Descripcion   = $producto[0]->PROD_Nombre;
                                $filter2->GUIAREMDETC_Observacion   = $producto_nombre;
                                $filter2->ALMAP_Codigo              = 1;

                                $this->guiaremdetalle_model->insertar($filter2);
                            }
                        }
                    }
                    $respuesta =  array('result' => 'success');
                }else{
                    $respuesta =  array('result' => 'error',"productos"=>$errores);
                }
            }

            echo json_encode($respuesta);
    }
    
    
       public function Leer_Guias_Excel_Compras()
    {
        //error_reporting(0);
        $respuesta   = array();
        $this->load->library('Excel');
        $archivo=$_FILES["file"]["tmp_name"];
        $inputFileType = PHPExcel_IOFactory::identify($archivo);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($archivo);
        $sheet = $objPHPExcel->getSheet(0); 
        $highestRow = $sheet->getHighestRow(); 
        $highestColumn = $sheet->getHighestColumn();
        
        $detalles   = array();
        $errores    = array();
        $erroneo    = false;
        $erClien    = false;
        $datos_guia = array();

            if ($highestRow > 19) 
            {   
                $fila=2;
                $numeroOrden    = $sheet->getCell('B'.$fila)->getValue();

                $fila+=2;
                $documentoProveedor    = $sheet->getCell('B'.$fila)->getValue();
                $fila++;
                $denominacion   = $sheet->getCell('B'.$fila)->getValue();
                
                //Nuevo
                $fila++;
                $pesoExcel   = $sheet->getCell('B'.$fila)->getValue();
                $fila++;
                $bultoExcel   = $sheet->getCell('B'.$fila)->getValue();
                $fila++;
                $modoTransporte   = $sheet->getCell('B'.$fila)->getValue();
                $fila+=2;
                $empresaExcel   = $sheet->getCell('B'.$fila)->getValue();
                $fila++;
                $rucExcel   = $sheet->getCell('B'.$fila)->getValue();

                $fila+=2;
                $conductorExcel   = $sheet->getCell('B'.$fila)->getValue();
                $fila++;
                $apellidoExcel   = $sheet->getCell('B'.$fila)->getValue();

                $fila++;
                $dniExcel   = $sheet->getCell('B'.$fila)->getValue();



                $fila++;
                $mtcExcel   = $sheet->getCell('B'.$fila)->getValue();
                $fila++;
                $certificadoExcel   = $sheet->getCell('B'.$fila)->getValue();
                $fila++;
                $licenciaExcel   = $sheet->getCell('B'.$fila)->getValue();
                $fila++;
                $PlacaExcel   = $sheet->getCell('B'.$fila)->getValue();
                $fila++;
                $marcaExcel   = $sheet->getCell('B'.$fila)->getValue();
                //Fin Nuevo

                $fecha_traslado = date('Y-m-d');
                
                if ($ruc_cliente!=="" || $denominacion!="") { 
                    $cabecera=[
                        "numero_orden" => $numeroOrden,
                        "ruc_proveedor"=>$documentoProveedor,
                        "denominacion"=>$denominacion,
                        "Fecha_Traslado"=>$fecha_traslado,
                        "pesoExcel"=>$pesoExcel,
                        "bultoExcel"=>$bultoExcel,
                        "modoTransporte"=>$modoTransporte,
                        "empresaExcel"=>$empresaExcel,
                        "rucExcel"=>$rucExcel,
                        "conductorExcel"=>$conductorExcel,
                        "apellidoExcel"=>$apellidoExcel,
                        "mtcExcel"=>$mtcExcel,
                        "certificadoExcel"=>$certificadoExcel,
                        "licenciaExcel"=>$licenciaExcel,
                        "PlacaExcel"=>$PlacaExcel,
                        "dniExcel"=>$dniExcel,
                        "marcaExcel"=>$marcaExcel
                    ];
                }else{
                    goto fin;
                }
                //BUSCA CLIENTE
                $consulta = $this->proveedor_model->buscarProveedorRuc($documentoProveedor, $this->somevar['compania']);
                
                if ($consulta==null) {
                    $erClien    = true;
                    goto fin;
                }else{
                    $proveedorCod = $consulta[0]->PROVP_Codigo;
                }

                
                for ($row=20; $row <=$highestRow; $row++) {
                    
                    $nitem       = $sheet->getCell('A'.$row)->getValue();
                    $codigo         = $sheet->getCell('B'.$row)->getValue();
                    $descripcion = $sheet->getCell('C'.$row)->getValue();
                    $cantidad = $sheet->getCell('D'.$row)->getValue();
                    $precio = $sheet->getCell('E'.$row)->getValue();

                    $productoResult="";
                    if ($codigo!="") {
                        $productoResult = $this->producto_model->getProductoCodigo($codigo);
                    }

                    if ($productoResult != NULL){
                        if ($cantidad>0) {
                            $productoCodigo   = $productoResult[0]->PROD_Codigo;
                            $detalles[] = ["nitem"=>$nitem,"Producto"=>$codigo,"descripcion"=>$descripcion,"Cantidad"=>$cantidad,"precio"=>$precio];
                        }
                    }else{
                        $errores[]  = ["nitem"=>$nitem,"Producto"=>$codigo,"descripcion"=>$descripcion,"Cantidad"=>$cantidad,"precio"=>$precio,"codigo"=>$codigo];
                        //$erroneo    = true;
                    }
                }


                $datos_guia[] = ["Cabecera"=>$cabecera,"Detalles"=>$detalles];


                fin:

                if (count($datos_guia)>0 && $erroneo==false)
                {
                    //$this->somevar['rol'] = $this->session->userdata('rol');
                    //$this->somevar['user'] = $this->session->userdata('user');
                    //$this->somevar['compania'] = $this->session->userdata('compania');
                    //$this->somevar['empresa'] = $this->session->userdata('empresa');
                    //$this->somevar['establec'] = $this->session->userdata('establec');

                    for ($i=0; $i <count($datos_guia); $i++) { 
                        $establecimientoInfo  = $this->emprestablecimiento_model->listar($this->somevar['empresa'], '', $this->somevar['compania']);
                        $empresaInfo          =  $this->empresa_model->obtener_datosEmpresa($this->somevar['empresa']);

                        $filter = new stdClass();

                        $filter->PROYP_Codigo           = 0;
                        $filter->MONED_Codigo           = 1;
                        $filter->OCOMP_Codigo           = null;
                        $filter->OCOMP_Codigo           = null;
                        $filter->GUIAREMC_TipoOperacion = "C";
                        $filter->PRESUP_Codigo          = NULL;
                        $filter->TIPOMOVP_Codigo        = 2; //Compra
                        $filter->GUIAREMC_OtroMotivo    = "";
                        $filter->GUIAREMC_CodigoUsuario = 0;
                        $filter->ALMAP_Codigo           = 1;
                        $filter->USUA_Codigo            = $this->somevar['user'];
                        $filter->COMPP_Codigo           = $this->somevar['compania'];
                        //$filter->DOCUP_Codigo           = NULL;
                        $filter->GUIAREMC_ModTransporte = (strtolower($datos_guia[$i]["Cabecera"]["modoTransporte"]) == 'public')?1:2;

                        //DATOS
                        $detalles=$datos_guia[$i]["Detalles"];
                    
                        //DATOS
                        $filter->DOCUP_Codigo = $datos_guia[$i]["Cabecera"]["numero_orden"];
                        $filter->GUIAREMC_PesoTotal = $datos_guia[$i]["Cabecera"]["pesoExcel"];
                        $filter->GUIAREMC_NumBultos = $datos_guia[$i]["Cabecera"]["bultoExcel"];

                        $filter->GUIAREMC_EmpresaTransp = $datos_guia[$i]["Cabecera"]["empresaExcel"];
                        $filter->GUIAREMC_RucEmpresaTransp =  $datos_guia[$i]["Cabecera"]["rucExcel"];
                        $filter->GUIAREMC_TipoDocTransp = 6; //RUC

                        //DATOS
                        $sucursalInfo = $this->emprestablecimiento_model->getEmpresaEstablecimiento($this->somevar['establec']);
                        //DATOS

                        $filter->PROVP_Codigo               = $proveedorCod;
                        $filter->GUIAREMC_PersReceNombre    = "";
                        $filter->GUIAREMC_PersReceDNI       = $datos_guia[$i]["Cabecera"]["dniExcel"]; 
                        $filter->GUIAREMC_NumeroRef         = "";
                        $filter->GUIAREMC_OCompra           = "";

                        //$filter->GUIAREMC_FechaTraslado = $datos_guia[$i]["Cabecera"]["Fecha_Traslado"];
                        $ft = explode("-",$datos_guia[$i]["Cabecera"]["Fecha_Traslado"]);
                        $filter->GUIAREMC_FechaTraslado=$datos_guia[$i]["Cabecera"]["Fecha_Traslado"];//$ft[2]."-".$ft[1]."-".$ft[0];

                        //DATOS
                        $sucursalInfoP = $this->emprestablecimiento_model->getEmpresaEstablecimientobyEmpresa($this->somevar['empresa']);


                        //Datos de Direccion Cliente

                        $datos_ubigeo_proveedor=$this->emprestablecimiento_model->getDireccionProveedorUbigeo($proveedorCod);

                        if ($datos_ubigeo_proveedor[0]->TipoPersona==1) 
                        {
                            $filter->GUIAREMC_UbigeoLlegada = $datos_ubigeo_proveedor[0]->UBIGP_Codigo;
                            $filter->GUIAREMC_PuntoLlegada  = $datos_ubigeo_proveedor[0]->UBIGEO;
                        }
                        else
                        {
                            $dd=explode("__", $datos_ubigeo_proveedor[0]->UBIGEO);
                            $filter->GUIAREMC_UbigeoLlegada = $dd[0];
                            $filter->GUIAREMC_PuntoLlegada  = $dd[1];    
                        }

                        //Datos de Direccion Cliente

                        
                        $filter->GUIAREMC_UbigeoPartida = $sucursalInfoP[0]->UBIGP_Codigo;
                        $filter->GUIAREMC_PuntoPartida  = $sucursalInfoP[0]->EESTAC_Direccion;

                        $filter->GUIAREMC_Fecha         = date("Y-m-d"); 

                        $filter->EMPRP_Codigo           = 0; //PENDIENTE


                        //Nuevo Transportista

                        $datosConductor = $this->cliente_model->buscarConductorDoc($datos_guia[$i]["Cabecera"]["dniExcel"],2);
                        $datosTrans     = $this->cliente_model->transportistaRuc($datos_guia[$i]["Cabecera"]["rucExcel"],2);

                        if($datosTrans == NULL && $datosConductor == NULL){
                            $transportista = new stdClass();
                            $transportista->TRANS_Nombre            = $datos_guia[$i]["Cabecera"]["empresaExcel"];
                            $transportista->TRANS_Doc               = $datos_guia[$i]["Cabecera"]["rucExcel"];
                            $transportista->TRANS_Marca             = $datos_guia[$i]["Cabecera"]["marcaExcel"];
                            $transportista->TRANS_Placa             = $datos_guia[$i]["Cabecera"]["PlacaExcel"];
                            $transportista->TRANS_Registro          = $datos_guia[$i]["Cabecera"]["mtcExcel"];
                            $transportista->TRANS_NombreConductor   = $datos_guia[$i]["Cabecera"]["conductorExcel"]." ".$datos_guia[$i]["Cabecera"]["apellidoExcel"];
                            $transportista->TRANS_DocConductor      = $datos_guia[$i]["Cabecera"]["dniExcel"];
                            $transportista->TRANS_Licencia          = $datos_guia[$i]["Cabecera"]["licenciaExcel"];
                            $transportista->TRANS_Certificado       = $datos_guia[$i]["Cabecera"]["certificadoExcel"];
                            $this->cliente_model->insertar_transportista($transportista);
                        }elseif ($datosTrans != NULL && $datosConductor == NULL) {
                            $id_trans = $datosTrans[0]->ID_Trans;
                            $transportista = new stdClass();
                            $transportista->TRANS_NombreConductor   = $datos_guia[$i]["Cabecera"]["conductorExcel"]." ".$datos_guia[$i]["Cabecera"]["apellidoExcel"];
                            $transportista->TRANS_DocConductor      = $datos_guia[$i]["Cabecera"]["dniExcel"];
                            $transportista->TRANS_Licencia          = $datos_guia[$i]["Cabecera"]["licenciaExcel"];
                            $this->cliente_model->insertar_transportista($transportista);
                        }elseif ($datosTrans == NULL && $datosConductor != NULL) {
                            $id_trans = $datosConductor[0]->ID_Trans;
                            $transportista = new stdClass();
                            $transportista->TRANS_Nombre        = $datos_guia[$i]["Cabecera"]["empresaExcel"];
                            $transportista->TRANS_Doc           = $datos_guia[$i]["Cabecera"]["rucExcel"];
                            $transportista->TRANS_Marca         = $datos_guia[$i]["Cabecera"]["marcaExcel"];
                            $transportista->TRANS_Placa         = $datos_guia[$i]["Cabecera"]["PlacaExcel"];
                            $transportista->TRANS_Registro      = $datos_guia[$i]["Cabecera"]["mtcExcel"];
                            $transportista->TRANS_Certificado   = $datos_guia[$i]["Cabecera"]["certificadoExcel"];
                            $this->cliente_model->actualizar_transportista($id_trans,$transportista);
                        }else{
                            //no hace nada
                        }

                        //Fin Transportista




                        $filter->GUIAREMC_Marca             = $datos_guia[$i]["Cabecera"]["marcaExcel"];
                        $filter->GUIAREMC_Placa             = $datos_guia[$i]["Cabecera"]["PlacaExcel"];//$ruta[0]->Placa;
                        $filter->GUIAREMC_RegistroMTC       = $datos_guia[$i]["Cabecera"]["mtcExcel"];//$ruta[0]->MTC;
                        $filter->GUIAREMC_Certificado       = $datos_guia[$i]["Cabecera"]["certificadoExcel"];//$ruta[0]->Certificado;
                        $filter->GUIAREMC_Licencia          = $datos_guia[$i]["Cabecera"]["licenciaExcel"];//$ruta[0]->Licencia;
                        $filter->GUIAREMC_NombreConductor   = $datos_guia[$i]["Cabecera"]["conductorExcel"];//$ruta[0]->Nombre_Conductor;
                        $filter->GUIAREMC_ConductorApellido = $datos_guia[$i]["Cabecera"]["apellidoExcel"];//$ruta[0]->Apellido_Conductor;
                        $filter->GUIAREMC_Observacion       = "";//$datos_guia[$i]["Cabecera"]["Observacion"];
                        $filter->GUIAREMC_descuento100      = 0;
                        $filter->GUIAREMC_igv100            = 18;//$this->input->post('igv'); //FALTA
                        $filter->GUIAREMC_subtotal          = 0;//$this->input->post('preciototal'); //FALTA
                        $filter->GUIAREMC_descuento         = 0;//$this->input->post('descuentotal'); //FALTA
                        $filter->GUIAREMC_igv               = 0;//$this->input->post('igvtotal'); //FALTA
                        $filter->GUIAREMC_total             = 0;//$this->input->post('importetotal'); //FALTA
                        

                        $compania           = $this->somevar['compania'];

                        $cofiguracion_datos = $this->configuracion_model->obtener_numero_documento($compania, 10,'V');
                        $numero             = $cofiguracion_datos[0]->CONFIC_Numero + 1;
                        $this->configuracion_model->modificar_configuracion($compania, 10, $numero, $serie1 = null);

                        $filter->GUIAREMC_Numero = $numero;
                        $filter->GUIAREMC_FlagEstado = 2;
                        $filter->GUIAREMC_Serie = $cofiguracion_datos[0]->CONFIC_Serie;


                        $guiarem_id = $this->guiarem_model->insertar($filter);

                        if ($guiarem_id>0) 
                        {

                            for ($j=0; $j <count($detalles); $j++) { 
                                    
                                $producto = $this->producto_model->obtener_producto_x_codigo_usuario($detalles[$j]["Producto"]);
                                //$producto_nombre=$producto[0]->PROD_Nombre;
                                //if ($producto) {
                                //    var_dump($producto);exit;
                                //}else{
                                //    var_dump($detalles[$j]["Producto"]);exit;
                                //
                                //}
                                $producto_nombre="";
                                if ($detalles[$j]["Marca"]!="") 
                                {
                                    $producto_nombre.=" | ".$detalles[$j]["Marca"];
                                }
                                if ($detalles[$j]["Lote"]!="") 
                                {
                                    $producto_nombre.=" | Lote: ".$detalles[$j]["Lote"];
                                }
                                if ($detalles[$j]["Fecha"]!="" && $detalles[$j]["Fecha"]!="00-00-0000") 
                                {
                                    //$producto_nombre.=" | Fecha Venc.: ".$detalles[$j]["Fecha"];
                                }

                                $this->load->model('almacen/productounidad_model');
                                $productoUnidad = $this->productounidad_model->getProductoUnidad($producto[0]->PROD_Codigo);

                                $filter2 = new stdClass();
                                $filter2->GUIAREMP_Codigo           = $guiarem_id;
                                $filter2->PRODCTOP_Codigo           = $producto[0]->PROD_Codigo;
                                $filter2->UNDMED_Codigo             = $productoUnidad[0]->UNDMED_Codigo;
                                $filter2->LOTP_Codigo               = 0;
                                $filter2->AFECT_Codigo              = 1;
                                $filter2->GUIAREMDETC_Cantidad      = $detalles[$j]["Cantidad"];
                                $filter2->GUIAREMDETC_Pu            = 0;
                                $filter2->GUIAREMDETC_Subtotal      =  $detalles[$j]["precio"]*$detalles[$j]["Cantidad"]/1.18;
                                $filter2->GUIAREMDETC_Descuento     = 0;
                                $filter2->GUIAREMDETC_Igv           = $detalles[$j]["precio"]*$detalles[$j]["Cantidad"]/6.555555208700783;
                                $filter2->GUIAREMDETC_Total         = $detalles[$j]["precio"]*$detalles[$j]["Cantidad"];
                                $filter2->GUIAREMDETC_Pu_ConIgv     = $detalles[$j]["precio"];
                                $filter2->GUIAREMDETC_Descuento100  = 0;
                                $filter2->GUIAREMDETC_Igv100        = 18;
                                $filter2->GUIAREMDETC_Costo         = 0;
                                $filter2->GUIAREMDETC_Venta         = 0;
                                $filter2->GUIAREMDETC_ITEM          = $detalles[$j]["nitem"];
                                $filter2->GUIAREMDETC_Peso          = $detalles[$j]["Peso"];
                                $filter2->GUIAREMDETC_GenInd        = "";
                                $filter2->GUIAREMDETC_Descripcion   = $producto[0]->PROD_Nombre;
                                $filter2->GUIAREMDETC_Observacion   = $producto_nombre;
                                $filter2->ALMAP_Codigo              = 1;

                                $this->guiaremdetalle_model->insertar($filter2);
                            }
                        }
                    }
                    $respuesta =  array('result' => 'success');
                }else{
                    $respuesta =  array('result' => 'error',"productos"=>$errores);
                }
            }

            echo json_encode($respuesta);
    }
    
    ###############################FIN#######################################
    

    public function envioGuiaSunat($codigo) {

        $datos_guiarem      = $this->guiarem_model->obtener($codigo);
        $tipoMovimiento     = trim($datos_guiarem[0]->TIPOMOVP_Codigo);
        $otro_motivo        = $datos_guiarem[0]->GUIAREMC_OtroMotivo;
        $tipo_oper          = $datos_guiarem[0]->GUIAREMC_TipoOperacion;
        $empresa_transporte = ($datos_guiarem[0]->EMPRP_Codigo != 0) ? $datos_guiarem[0]->EMPRP_Codigo : 1;
        $almacen            = $datos_guiarem[0]->ALMAP_Codigo;
        $usuario            = $datos_guiarem[0]->USUA_Codigo;
        $moneda             = $datos_guiarem[0]->MONED_Codigo;
        $referencia         = $datos_guiarem[0]->DOCUP_Codigo;
        $cliente            = $datos_guiarem[0]->CLIP_Codigo;
        $proveedor          = $datos_guiarem[0]->PROVP_Codigo;
        $recepciona_nombres = $datos_guiarem[0]->GUIAREMC_PersReceNombre;
        $recepciona_dni     = $datos_guiarem[0]->GUIAREMC_PersReceDNI;
        $numero_ref         = $datos_guiarem[0]->GUIAREMC_NumeroRef;
        $numero_ocompra     = $datos_guiarem[0]->GUIAREMC_OCompra;
        $serie              = $datos_guiarem[0]->GUIAREMC_Serie;
        $numero             = $datos_guiarem[0]->GUIAREMC_Numero;
        $numero_ref         = $datos_guiarem[0]->GUIAREMC_NumeroRef;
        $codigo_usuario     = $datos_guiarem[0]->GUIAREMC_CodigoUsuario;
        $observacion        = $datos_guiarem[0]->GUIAREMC_Observacion;
        $placa              = $datos_guiarem[0]->GUIAREMC_Placa;
        $marca              = $datos_guiarem[0]->GUIAREMC_Marca;
        $registro_mtc       = $datos_guiarem[0]->GUIAREMC_RegistroMTC;
        $certificado        = $datos_guiarem[0]->GUIAREMC_Certificado;
        $licencia           = $datos_guiarem[0]->GUIAREMC_Licencia;
        $nombre_conductor   = $datos_guiarem[0]->GUIAREMC_NombreConductor;
        $ocompra            = $datos_guiarem[0]->OCOMP_Codigo;
        $estado             = $datos_guiarem[0]->GUIAREMC_FlagEstado;
        $tipo_de_transporte = "0".$datos_guiarem[0]->GUIAREMC_ModTransporte;
        $compania           = $datos_guiarem[0]->COMPP_Codigo;
        $numero_de_bultos   = $datos_guiarem[0]->GUIAREMC_NumBultos;
        $peso_bruto_total   = $datos_guiarem[0]->GUIAREMC_PesoTotal;
        $transRazonSocial   = $datos_guiarem[0]->GUIAREMC_EmpresaTransp;
        $transporteRuc      = $datos_guiarem[0]->GUIAREMC_RucEmpresaTransp;
        $tipodoc_transporte = $datos_guiarem[0]->GUIAREMC_TipoDocTransp;
        $fechaIniTraslado   = $datos_guiarem[0]->GUIAREMC_FechaTraslado;
        $fechaEmision       = $datos_guiarem[0]->GUIAREMC_Fecha;
        $ubigeo_partida     = ( strlen($datos_guiarem[0]->GUIAREMC_UbigeoPartida) == 5 ) ? "0".$datos_guiarem[0]->GUIAREMC_UbigeoPartida : $datos_guiarem[0]->GUIAREMC_UbigeoPartida;
        $punto_partida      = $datos_guiarem[0]->GUIAREMC_PuntoPartida;

        $ubigeo_llegada     = ( strlen($datos_guiarem[0]->GUIAREMC_UbigeoLlegada) == 5) ? "0".$datos_guiarem[0]->GUIAREMC_UbigeoLlegada : $datos_guiarem[0]->GUIAREMC_UbigeoLlegada;
        $punto_llegada      = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;

        $tipo_de_comprobante = 7;
        
        if ($tipo_oper == 'C'){
            $exito = array("exito" => true, "tipo" => $tipo_de_comprobante, "msj" => "Documento aprobado");
            return $exito;
        }else{
            $datos_cliente = $this->cliente_model->obtener($cliente);
            if ($datos_cliente) {
                $idCliente      = $datos_cliente->idCliente;
                $nombres        = $datos_cliente->nombre;
                $ruc_cliente    = $datos_cliente->ruc;
                $dni_cliente    = $datos_cliente->dni;
                $ruc            = ( $ruc_cliente == NULL || $ruc_cliente == "" || $ruc_cliente == 0 ) ? $dni_cliente : $ruc_cliente;
                $direccion      = $datos_cliente->direccion;
                $email          = $datos_cliente->correo;
                $tipoDocIdentidad = $datos_cliente->tipoDocIdentidad;
            }
            
            switch ($tipoDocIdentidad) {
                case '1':
                    $cliente_tipoDoc = "1";
                break;
                case '2':
                    $cliente_tipoDoc = "-";
                break;
                case '4':
                    $cliente_tipoDoc = "4";
                break;
                case '6':
                    $cliente_tipoDoc = "6";
                break;
                case '7':
                    $cliente_tipoDoc = "7";
                break;
                case '0':
                    $cliente_tipoDoc = "0";
                break;
                default:
                    $cliente_tipoDoc = "1";
                break;
            }

            $items=array();
            
            $detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);

            $detaProductos = '';
            foreach ($detalle_guiarem as $indice => $valor) {

                $detacodi   = $valor->GUIAREMDETP_Codigo;
                $producto   = $valor->PRODCTOP_Codigo;
                $unidad     = $valor->UNDMED_Codigo;
                $cantidad   = $valor->GUIAREMDETC_Cantidad;
                if($valor->show_details == 2){
                    $modifiedProductName = explode('//', $valor->GUIAREMDETC_Observacion);
                    $nombreP = $modifiedProductName[1];
                    $codigoU = $modifiedProductName[0];
                }else{
                    $nombreP =  $valor->PROD_Nombre . " " . $valor->GUIAREMDETC_Observacion;
                    $codigoU = $valor->PROD_CodigoUsuario;
                  }
                // $nombreP    = $valor->GUIAREMDETC_Descripcion . " " . $valor->GUIAREMDETC_Observacion;
                // $codigoU    = $valor->PROD_CodigoUsuario;
                $uMedida    = $this->unidadmedida_model->obtener($valor->UNDMED_Codigo);
                $nUnidad    = ($uMedida[0]->UNDMED_Simbolo != "") ? $uMedida[0]->UNDMED_Simbolo : "ZZ";

                array_push($items,array(
                    "unidad_de_medida"          => "${nUnidad}",
                    "codigo"                    => "${codigoU}",
                    "descripcion"               => "${nombreP}",
                    "cantidad"                  => "${cantidad}",
                ));
            }


            //Definicion de token
            $deftoken   = $this->tokens->deftoken($compania);
            $ruta       = $deftoken['ruta'];
            $token      = $deftoken['token'];

            if ($ruta=="" || $token=="") {
                $exito = array("exito" => false, "tipo" => "", "msj" => "Error de configuracion de pasarela SUNAT Code: 1_tokn_libs");
            return $exito;
            }

            if ( $fechaEmision != date("Y-m-d") ){
                $fechanueva = new stdClass();
                $fechanueva->GUIAREMC_Fecha = date('Y-m-d');
                $fechaEmision = $fechanueva->GUIAREMC_Fecha;
                $this->guiarem_model->modificar($codigo, $fechanueva);
            }

            $tipoMovimiento = ( strlen($tipoMovimiento) == 1 ) ? "0$tipoMovimiento" : $tipoMovimiento;
            $datosGuia = array(                        
                "operacion"                         => "generar_guia",
                "tipo_de_comprobante"               => "${tipo_de_comprobante}",
                "serie"                             => "${serie}",
                "numero"                            => "${numero}",
                "cliente_tipo_de_documento"         => "${cliente_tipoDoc}",
                "cliente_numero_de_documento"       => "${ruc}",
                "cliente_denominacion"              => "${nombres}",
                "cliente_direccion"                 => "${direccion}",
                "cliente_email"                     => "${email}",
                "cliente_email_1"                   => "",
                "cliente_email_2"                   => "",
                "fecha_de_emision"                  => "${fechaEmision}",
                "observaciones"                     => "${observacion}",
                "motivo_de_traslado"                => "${tipoMovimiento}",
                "peso_bruto_total"                  => "${peso_bruto_total}", # 0 = No aplica
                "numero_de_bultos"                  => "${numero_de_bultos}", # 0 = No aplica
                "tipo_de_transporte"                => "${tipo_de_transporte}", # 1 = Publico | 2 = Privado
                "fecha_de_inicio_de_traslado"       => "${fechaIniTraslado}",
                "transportista_documento_tipo"      => "${tipodoc_transporte}", 
                "transportista_documento_numero"    => "${transporteRuc}",
                "transportista_denominacion"        => "${transRazonSocial}",
                "transportista_placa_numero"        => "${placa}",
                "conductor_documento_tipo"          => "1",
                "conductor_documento_numero"        => "${recepciona_dni}",
                "conductor_denominacion"            => "${nombre_conductor}",
                "conductor_numero_licencia" => "${licencia} ",
                "punto_de_partida_ubigeo"           => "${ubigeo_partida}",
                "punto_de_partida_direccion"        => "${punto_partida}",
                "punto_de_llegada_ubigeo"           => "${ubigeo_llegada}",
                "punto_de_llegada_direccion"        => "${punto_llegada}",
                "enviar_automaticamente_a_la_sunat" => "true",
                "enviar_automaticamente_al_cliente" => "true",
                "codigo_unico"                      => "",
                "formato_de_pdf"                    => "",
                "items"                             => $items
            );

            $data_json = json_encode($datosGuia);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $ruta);
            curl_setopt(
                $ch, CURLOPT_HTTPHEADER, array(
                    'Authorization: Token token="'.$token.'"',
                    'Content-Type: application/json',
                )
            );
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $respuesta  = curl_exec($ch);
            curl_close($ch);

            $leer_respuesta = json_decode($respuesta, true);

            //SI TIENE ERRORES NO PASA, NO SE EJECUTA LA RUTINA
            if (isset($leer_respuesta['errors'])) {
                $filter2->respuestas_compañia       = $compania;
                $filter2->respuestas_GuiaRem        = $codigo;
                $filter2->respuestas_serie          = $serie;
                $filter2->respuestas_numero         = $numero;
                $filter2->respuestas_tipoDocumento  = $tipo_de_comprobante;
                $filter2->respuestas_deta           = $leer_respuesta['errors'];
                $filter2->respuesta_jsonenviado     = 0;

                $exito = array("exito" => false, "tipo" => $tipo_de_comprobante, "msj" => $leer_respuesta['errors']);
            } else {
                //SI EL DOCUMENTO ES INMEDIATAMENTE ACEPTADO PASA NORMAL
                if ($leer_respuesta['aceptada_por_sunat'] == true){
                    $exito = array("exito" => true, "tipo" => $tipo_de_comprobante, "msj" => $leer_respuesta['sunat_description']);
                }else{
                    $exito = array("exito" => true, "tipo" => $tipo_de_comprobante, "msj" => $leer_respuesta['sunat_description']);
                }

                $filter2->respuestas_compañia           = $compania;
                $filter2->respuestas_GuiaRem            = $codigo;
                $filter2->respuestas_serie              = $leer_respuesta['serie'];
                $filter2->respuestas_numero             = $leer_respuesta['numero'];
                $filter2->respuestas_tipoDocumento      = $leer_respuesta['tipo_de_comprobante'];
                $filter2->respuestas_enlace             = $leer_respuesta['enlace'];
                $filter2->respuestas_aceptadaporsunat   = $leer_respuesta['aceptada_por_sunat'];
                $filter2->respuestas_sunatdescription   = $leer_respuesta['sunat_description'];
                $filter2->respuestas_sunatnote          = $leer_respuesta['sunat_note'];
                $filter2->respuestas_sunatresponsecode  = $leer_respuesta['sunat_responsecode'];
                $filter2->respuestas_sunatsoaperror     = $leer_respuesta['sunat_soap_error'];
                $filter2->respuestas_pdfzipbase64       = $leer_respuesta['pdf_zip_base64'];
                $filter2->respuestas_xmlzipbase64       = $leer_respuesta['xml_zip_base64'];
                $filter2->respuestas_cdrzipbase64       = $leer_respuesta['cdr_zip_base64'];
                $filter2->respuestas_cadenaparacodigoqr = $leer_respuesta['cadena_para_codigo_qr'];
                $filter2->respuestas_codigohash         = $leer_respuesta['codigo_hash'];
                $filter2->respuestas_enlacepdf          = $leer_respuesta['enlace_del_pdf'];
                $filter2->respuestas_enlacexml          = $leer_respuesta['enlace_del_xml'];
                $filter2->respuestas_enlacecdr          = $leer_respuesta['enlace_del_cdr'];
                $filter2->respuesta_jsonenviado         = 1;
                
            }

            $this->comprobante_model->insertar_respuestaSunat($filter2);

            return $exito;
        }
    }

    public function disparador($codigo, $tipo_oper = 'V'){
        
        $aceptada = false;

        if($codigo != null && $codigo != 0){
            if ($tipo_oper == 'V')
                $aceptada = $this->envioGuiaSunat($codigo);
            
            if ($aceptada["exito"] == true || $tipo_oper == "C"){
                $filter = new stdClass();
                $filter->GUIAREMC_FlagEstado = 1;
                $this->guiarem_model->modificar($codigo, $filter);
                if ($aceptada["exito"] == true || $tipo_oper == "V"){
                    $success = array( "result" => "success" ,"response" => $aceptada["msj"]);
                }else{
                    $success = array( "result" => "success" ,"response" => "Documento aprobado");
                }
            }else{
                $success = array( "result" => "error" ,"response" => $aceptada["msj"]);
            }
        }
        else{
            $success = array( "result" => "error" ,"response" => "Se ha presentado un error, por favor contacte con SOPORTE TECNICO");
        }
            
        echo json_encode($success);
    }

    public function ConsultarNubefact($codigo){
        $datos_comprobante  = $this->guiarem_model->obtener($codigo);
        $serie              = $datos_comprobante[0]->GUIAREMC_Serie;
        $numero             = ltrim($datos_comprobante[0]->GUIAREMC_Numero, "0");
        $compania           = $datos_comprobante[0]->COMPP_Codigo;    
        
        $deftoken = $this->tokens->deftoken("$compania");

        $ruta   = $deftoken['ruta'];
        $token  = $deftoken['token'];
        
        $tipo_de_comprobante = 7;
       
        $data2 = array(
            "operacion"             => "consultar_guia",
            "tipo_de_comprobante"   => "${tipo_de_comprobante}",
            "serie"                 => "${serie}",
            "numero"                => "${numero}"
        );
        $data_json = json_encode($data2);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Token token="'.$token.'"',
            'Content-Type: application/json',
            )
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta  = curl_exec($ch);
        curl_close($ch);
        
        $filter2 = new stdClass();

        $leer_respuesta = json_decode($respuesta, true);
        
        if (isset($leer_respuesta['errors'])) {
            $exito = array("exito" => false, "msj" => "El documento no fue encontrado");
        } else {
            if ($leer_respuesta['aceptada_por_sunat'] == true) {
                $filter2->respuestas_compañia           = $compania;
                $filter2->respuestas_GuiaRem            = $codigo;
                $filter2->respuestas_serie              = $leer_respuesta['serie'];
                $filter2->respuestas_numero             = $leer_respuesta['numero'];
                $filter2->respuestas_tipoDocumento      = $leer_respuesta['tipo_de_comprobante'];
                $filter2->respuestas_enlace             = $leer_respuesta['enlace'];
                $filter2->respuestas_aceptadaporsunat   = $leer_respuesta['aceptada_por_sunat'];
                $filter2->respuestas_sunatdescription   = $leer_respuesta['sunat_description'];
                $filter2->respuestas_sunatnote          = $leer_respuesta['sunat_note'];
                $filter2->respuestas_sunatresponsecode  = $leer_respuesta['sunat_responsecode'];
                $filter2->respuestas_sunatsoaperror     = $leer_respuesta['sunat_soap_error'];
                $filter2->respuestas_pdfzipbase64       = $leer_respuesta['pdf_zip_base64'];
                $filter2->respuestas_xmlzipbase64       = $leer_respuesta['xml_zip_base64'];
                $filter2->respuestas_cdrzipbase64       = $leer_respuesta['cdr_zip_base64'];
                $filter2->respuestas_cadenaparacodigoqr = $leer_respuesta['cadena_para_codigo_qr'];
                $filter2->respuestas_codigohash         = $leer_respuesta['codigo_hash'];
                $filter2->respuestas_enlacepdf          = $leer_respuesta['enlace_del_pdf'];
                $filter2->respuestas_enlacexml          = $leer_respuesta['enlace_del_xml'];
                $filter2->respuestas_enlacecdr          = $leer_respuesta['enlace_del_cdr'];
                $filter2->respuesta_jsonenviado         = 1;

                $exito = array("exito" => true, "result" => "success",  "msj" => $leer_respuesta['sunat_description']);
                $filter = new stdClass();
                $filter->GUIAREMC_FlagEstado = 1;
                $this->guiarem_model->modificar($codigo, $filter);
                $this->comprobante_model->actualizar_respuestaSunat($filter2);
            }else{
                $exito = array("exito" => false, "result" => "error",  "msj" => "El documento se encuentra en observación, por favor comuníquese con SOPORTE TÉCNICO");
            }
            
        }

        echo json_encode($exito);
    }

    public function consultarRespuestaPdfsunat($codigoRespCompro=null){
            $pdfRespSunat = $this->comprobante_model->consultar_respuestaSunat($codigoRespCompro,"T");
            
            if ( $pdfRespSunat->respuestas_enlacepdf == NULL || $pdfRespSunat->respuestas_enlacepdf == '' ){
                $pdfRespSunat->error = 1;
            }

            echo json_encode($pdfRespSunat);
        }

    public function getFechaE(){
        $id = $this->input->post("comprobante");
        $comprobanteInfo = $this->guiarem_model->obtener($id);


        if ( $comprobanteInfo != NULL ){
            foreach ($comprobanteInfo as $i => $val) {
                # SI ES UNA VENTA Y ES DISTINTO A COMPROBANTE
               
                if ( $val->GUIAREMC_TipoOperacion == "V"){

                    # SI LA FECHA ES DISTINTA AL DIA DE ENVIO (HOY)
                    if ( $val->GUIAREMC_Fecha != date("Y-m-d") )
                        $json = array( "update" => true, "fecha_hoy" => date("Y-m-d"), "comprobante_fecha" => $val->GUIAREMC_Fecha );
                    else
                        $json = array( "update" => false, "fecha_hoy" => date("Y-m-d"), "comprobante_fecha" => $val->GUIAREMC_Fecha );
                }
                else
                    $json = array( "update" => false, "fecha_hoy" => date("Y-m-d"), "comprobante_fecha" => $val->GUIAREMC_Fecha );
            }
        }
        else
            $json = array( "update" => true, "fecha_hoy" => date("Y-m-d"), "comprobante_fecha" => date("Y-m-d") );

        echo json_encode($json);
    }

    public function datatable_guiarem($tipo_oper = 'V'){
        $data['compania'] = $this->somevar['compania'];
        
        $posDT = -1;
        $columnas = array(
                            ++$posDT => "GUIAREMC_FechaRegistro",
                            ++$posDT => "GUIAREMC_Fecha",
                            ++$posDT => "GUIAREMC_Serie",
                            ++$posDT => "GUIAREMC_Numero",
                            ++$posDT => "nombre",
                            ++$posDT => "",
                            ++$posDT => "",
                            ++$posDT => "",
                            ++$posDT => "",
                            ++$posDT => "",
                            ++$posDT => ""
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

        $item       = ($this->input->post("start") != "") ? $this->input->post("start") : 0;

        $fecha_ini          = $this->input->post('fechai');
        $filter->fechai     = (trim($fecha_ini) != "") ? $fecha_ini : ""; # date("Y-m") . '-1';

        $fecha_fin          = $this->input->post('fechaf');
        $filter->fechaf     = (trim($fecha_fin) != "") ? $fecha_fin : date("Y-m-d");

        $filter->tipo_oper          = $tipo_oper;
        $filter->serie              = $this->input->post('seriei');
        $filter->numero             = $this->input->post('numero');
        $filter->cliente            = $this->input->post('cliente');
        $filter->ruc_cliente        = $this->input->post('ruc_cliente');
        $filter->nombre_cliente     = $this->input->post('nombre_cliente');
        $filter->proveedor          = $this->input->post('proveedor');
        $filter->ruc_proveedor      = $this->input->post('ruc_proveedor');
        $filter->nombre_proveedor   = $this->input->post('nombre_proveedor');
        $filter->producto           = $this->input->post('producto');
        $filter->codproducto        = $this->input->post('codproducto');
        $filter->nombre_producto    = $this->input->post('nombre_producto');

        $listado = $this->guiarem_model->getGuiaRemision($filter);

        $lista = array();
        if (count($listado) > 0) {
            foreach ($listado as $indice => $valor) {
                
                $letraParaConvertir     = "GR"; 
                $arrayConversorDeNumero = $this->documento_model->obtenerAbreviatura($letraParaConvertir);  
                foreach ($arrayConversorDeNumero as $valueConvert) {
                    $ConversorDeNumero = $valueConvert->DOCUP_Codigo;
                }

                $codigo = $valor->GUIAREMP_Codigo;
                $estadoAsociacion='';
                $listaGuiaremAsociados=$this->guiarem_model->buscarGuiaremComprobante($codigo,$estadoAsociacion);
                if (count($listaGuiaremAsociados) > 0){
                    $tipo_o = $listaGuiaremAsociados[0]->CPC_TipoOperacion;
                    $tipo_d = $listaGuiaremAsociados[0]->CPC_TipoDocumento;
                    $comp_id = $listaGuiaremAsociados[0]->CPP_Codigo;
                    $comp = $listaGuiaremAsociados[0]->CPC_Serie . '-' . $listaGuiaremAsociados[0]->CPC_Numero;
                    if ($tipo_d == "F"){
                        $comprobante = "<a href='".base_url()."index.php/ventas/comprobante/comprobante_ver_pdf/$comp_id/a4' target='_parent' data-fancybox data-type='iframe'> <span style='font-weight: bold; font-size: 7pt; color:green'>►$comp</span> </a>";
                        $boleta = '';
                    }
                    else {
                        $comprobante = '';
                        $boleta = "<a href='".base_url()."index.php/ventas/comprobante/comprobante_ver_pdf/$comp_id/a4' target='_parent' data-fancybox data-type='iframe'> <span style='font-weight: bold; font-size: 7pt; color:green'>►$comp</span> </a>";
                    }
                }
                else {
                    $comprobante = "";
                    $boleta = "";
                }
                 
                $fechaR         = mysql_to_human($valor->fechaReg);
                $fecha          = mysql_to_human($valor->GUIAREMC_FechaTraslado);
                $serie          = $valor->GUIAREMC_Serie;
                $numero         = $valor->GUIAREMC_Numero;
                $codigo_usuario = $valor->GUIAREMC_CodigoUsuario;
                $nombre_almacen = $valor->ALMAC_Descripcion;
                $numeroref      = $valor->GUIAREMC_NumeroRef;
                $nombre         = $valor->nombre;
                $estado         = $valor->GUIAREMC_FlagEstado;
                $oc             = $valor->OCOMP_Codigo;
                $TipoGuia       = $valor->GUIAREMC_TipoGuia;
                $img_estado     = "";
                $pdfSunat       = "";
                $eliminar       = ""; 

                $tipo_movimiento = $this->tipomovimiento_model->obtener($valor->TIPOMOVP_Codigo);
                $nombre_movimiento = strtolower($tipo_movimiento[0]->TIPOMOVC_Descripcion);

                if($nombre_movimiento == 'importacion' || $nombre_movimiento == "importación")
                    $es_importado = true;

                if($TipoGuia != 1){


                    $editar = ($estado == 1) ? "<img src='" . base_url() . "images/icono_aprobar.png' width='16' height='16' border='0' title='Aprobado' style='cursor: pointer'>" : $editar;
 
                    $pdfImprimir2   = "<a href='".base_url()."index.php/almacen/guiarem/guiarem_ver_pdf/$codigo/a4/1' data-fancybox data-type='iframe'><img src='" . base_url() . "images/pdf.png' width='16' height='16' border='0' title='Imprimir'></a>";
                    $disparador = "";
                    if ($estado==1) {
                        $view_estado = "<a href='#' ><img src='" . base_url() . "images/active.png' alt='Activo' title='Activo' /></a>";

                        $editar = "<img src='" . base_url() . "images/icono_aprobar.png' width='16' height='16' border='0' title='Aprobado' style='cursor: pointer'>";
                        if($tipo_oper == 'V'){
                            $respSunat = $this->comprobante_model->lsResSunat($codigo, '7', null);
                            if ($respSunat != NULL){
                                if ( $respSunat->respuestas_aceptadaporsunat == '0'){
                                    $disparador .= "<span class='detallesWrong'><a onclick='consultar_estado($codigo, $item);'>Consultar</a></span>";
                                    $editar = "<img src='" . base_url() . "images/error1.png' width='16' height='16' border='0' title='En observacion'>";
                                    $img_estado = "";
                                }   
                                
                            }
                            $pdfSunat .= "<a href='javascript:;' onclick=abrir_pdf_envioSunat('$codigo')><img src='" . base_url() . "images/pdf-sunat.png' width='16' height='16' border='0' title='pdf sunat'></a>";
                        }

                        $eliminar = '<a onclick="abrirAnulacionModal('.$codigo.',\''.$serie.'\',\''.$numero.'\');" href="javascript:;" class="enviarcorreo"><img src="' . base_url() . 'images/active.png" width="16" height="16" border="0" title="Anular documento"></a>';
                    }

                    if ($estado == 2) {
                        $editar = "<a href='javascript:;' onclick='editar_guiarem($codigo)'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                        if ($tipo_oper == 'V'){
                            $respSunat = $this->comprobante_model->lsResSunat($codigo, '7', null);
                           
                            if ($respSunat != NULL){
                                //se debe agregar el caso cuando el documento es rechazado porque ya existe
                                if ($respSunat->respuestas_aceptadaporsunat == null) {
                                    $disparador .= "<a href='javascript:;' onclick='disparador($codigo, $item)'>Aprobar</a><br> <span class='detallesWrong'>Denegado <span class='detallesWrong2'> $respSunat->respuestas_deta </span> </span>";
                                }
                                elseif ( $respSunat->respuestas_aceptadaporsunat == '0' ){
                                    $disparador = "<span class='detallesWrong'><a onclick='consultar_estado($codigo, $item)'>Consultar</a><span class='detallesWrong2'> $respSunat->respuestas_deta </span> </span>";
                                    $editar="";
                                }   
                                
                            }else{
                                $disparador = "<a href='javascript:;' onclick='disparador($codigo, $item)'>Aprobar</a>";
                            }
                        }else{
                            $disparador = "<a href='javascript:;' onclick='disparador($codigo, $item)'>Aprobar</a>";
                        }
                    }
                    
                    if ($estado == 0) {
                       $eliminar = "<img src='" . base_url() . "images/inactive.png' alt='Anulado' title='Eliminar' />";
                       $view_estado = "<img src='" . base_url() . "images/inactive.png' alt='Activo' title='Inactivo' />";
                       $respSunat = $this->comprobante_model->lsResSunat($codigo, '7', 1);
                        if ($respSunat != NULL){
                                $disparador = "<span class='detallesWrong'>Motivo Anulacion<span class='detallesWrong2'>$respSunat->respuestas_deta </span> </span>";
                                $editar="";
                            
                        }else{
                            $disparador = "";
                            $editar="";
                        }
                    }

                    if ($oc != '') {
                        if($es_importado) {
                            $this->load->model("ventas/importacion_model");

                            $datos_ocompra = $this->importacion_model->obtener_comprobante($oc);

                            $serie_documento = $datos_ocompra[0]->IMPOR_Serie;
                            $numero_documento = $datos_ocompra[0]->IMPOR_Numero;
                            $url_view_documento = "index.php/ventas/importacion/comprobante_ver_pdf_conmenbrete1/" . $tipo_oper . "/" . $oc;
                        }
                        else {
                           $datos_ocompra = $this->ocompra_model->obtener_ocompra($oc);

                            $serie_documento = $datos_ocompra[0]->OCOMC_Serie;
                            $numero_documento = $datos_ocompra[0]->OCOMC_Numero;
                            $url_view_documento = 'index.php/compras/ocompra/ver_ocompra/' . $oc . '/' . $tipo_oper;
                        }
                        $orden_compra = "<a href='".base_url()."index.php/compras/ocompra/ocompra_ver_pdf_conmenbrete/$oc/1' data-fancybox data-type='iframe'> <span style='font-weight: bold; font-size: 7pt; color:green'>►$serie_documento-$numero_documento</span> </a>";
                    }
                    else 
                        $orden_compra = "";
                    
                    
                    
                }
                else{
                    /**si se puede editar**/
                    if($estado == 2)
                        $editar = "<a href='javascript:;' onclick='editar_guiarem(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                    else 
                        $editar ='';
                    
                    $pdfImprimir = "<a href='javascript:;' onclick='comprobante_ver_pdf_conmenbrete($codigo, $ConversorDeNumero, 0, \"$tipo_oper\")'><img src='".base_url()."images/icono_imprimir.png' width='16' height='16' border='0' title='Imprimir'></a>";

                    if($tipo_oper == 'V'){
                        $pdfImprimir2 = "<a href='javascript:;' onclick='comprobante_ver_pdf_conmenbrete($codigo, $ConversorDeNumero, 1, \"$tipo_oper\")'><img src='" . base_url() . "images/pdf.png' width='16' height='16' border='0' title='Ver PDF'></a>";
                    }
                    else
                        if ($tipo_oper == 'C') {
                            $pdfImprimir2 = "<a href='javascript:;' onclick='guiarem_ver_pdf_conmenbrete($codigo)'><img src='" . base_url() . "images/pdf.png' width='16' height='16' border='0' title='Ver PDF COMPRA'></a>";
                    }

                    $disparador = "";
                    $eliminar ="";
                    $orden_compra = "";
                                        
                    if($estado==2)
                        $view_estado = "<a href='#' ><img src='" . base_url() . "images/proceso.png' alt='Activo' title='Activo' /></a>";
                    else
                        $view_estado = "<a href='#' ><img src='" . base_url() . "images/active.png' alt='Activo' title='Activo' /></a>";
                }

                $PDFCompromiso = NULL; // Compromiso
                if($estado == 1 && $tipo_oper == 'V')
                    $PDFCompromiso = ""; 
                $posDT = -1;
                $lista[] = array(
                        ++$posDT => $fecha,
                        ++$posDT => $serie,
                        ++$posDT => $this->getOrderNumeroSerie($numero),
                        ++$posDT => $nombre,
                        ++$posDT => $boleta,
                        ++$posDT => $comprobante,
                        ++$posDT => $orden_compra,
                        ++$posDT => $valor->DOCUP_Codigo, # EN ESTE CAMPO GUARDA LA OC
                        ++$posDT => $eliminar,
                        ++$posDT => "<div align='center' class='editar_data_$item'>$editar</div>", 
                        ++$posDT => $pdfImprimir2,
                        ++$posDT => "<div align='left' class='pdfSunat_$item'>
                                    <span class='icon-loading'></span>
                                    <span class='pdfSunat_data_$item'>$pdfSunat</span>
                                </div>", #$pdfSunat,
                        ++$posDT => "<div align='center' class='disparador_$item'>
                                    <span class='icon-loading'></span>
                                    <span class='disparador_data_$item'>$disparador</span>
                                </div>" # $disparador
                    );
                $item++;
            }
        }

        $filterAll = new stdClass();
        $filterAll->tipo_oper = $tipo_oper;
        $filterAll->tipo_docu = $tipo_docu;

        $filterAll->count = true;
        $filter->count = true;

        $recordsTotal = $this->guiarem_model->getGuiaRemision($filterAll);
        $recordsFiltered = $this->guiarem_model->getGuiaRemision($filter);

        $json = array(
                            "draw"            => intval( $this->input->post('draw') ),
                            "recordsTotal"    => $recordsTotal->registros,
                            "recordsFiltered" => $recordsFiltered->registros,
                            "data"            => $lista
                    );

        echo json_encode($json);
    }

    public function deshabilitar_guia($codigo='')
    {
        $codigo = $this->input->post("guia");
        $motivo = $this->input->post("motivo");
        
        $datos_guiarem = $this->guiarem_model->obtener($codigo);
        $filter_resp = new stdClass();
        $filter_resp->respuestas_compañia       = $datos_guiarem[0]->COMPP_Codigo;
        $filter_resp->respuestas_GuiaRem        = $codigo;
        $filter_resp->respuestas_serie          = $datos_guiarem[0]->GUIAREMC_Serie;
        $filter_resp->respuestas_numero         = $datos_guiarem[0]->GUIAREMC_Numero;
        $filter_resp->respuestas_tipoDocumento  = 7;
        $filter_resp->respuestas_deta           = $motivo;
        $filter_resp->respuesta_jsonenviado     = 0;
        //INSERTAMOS MOTIVO
        $this->comprobante_model->insertar_respuestaSunat($filter_resp);
        //DESHABILITAMOS LA GUIA
        $filter = new stdClass();
        $filter->GUIAREMC_FlagEstado = 0;
        $this->guiarem_model->modificar($codigo, $filter);

        $exito = array("exito" => true, "result" => "success",  "msj" => "La guia de remision remitente ".$datos_guiarem[0]->GUIAREMC_Serie." - ".$datos_guiarem[0]->GUIAREMC_Numero." ha sido deshabilitada");
        
        echo json_encode($exito);
    }

#FIN

    public function listar($tipo_oper = 'V', $j = 0, $limpia = ''){
        
        $data['compania'] = $this->somevar['compania'];
                
        $data["series_emitidas"] = $this->guiarem_model->getSeriesEmitidas($tipo_oper, "GR", $this->somevar['compania']);

        $data['titulo_busqueda'] = "BUSCAR GUIA DE REMISIÓN";
        $data['titulo_tabla'] = "RELACIÓN DE GUIAS DE REMISIÓN";
        $data['accion'] = base_url() . "index.php/almacen/guiarem/listar/$tipo_oper/0/";
        $data['oculto'] = form_hidden(array('base_url' => base_url(), 'tipo_oper' => $tipo_oper));
        $data['tipo_oper'] = $tipo_oper;
        $this->layout->view('almacen/guiarem_index', $data);
    }

    /* ======================================================================================================================================= */

    public function nueva($tipo_oper = 'V', $sucursal=''){
        /* :::: SE CREA LA SESSION :::*/
        $hoy = date('Y-m-d H:i:s');
        $cadena = strtotime($hoy).substr((string)microtime(), 1, 8);
        $tempSession = str_replace('.','',$cadena);
        $data['tempSession']  = $tempSession;
        if ($tipo_oper == 'C') {
            $data['tipo_docu'] = "GRV";
        }else{
            $data['tipo_docu'] = "GRC";
        }
        /* :::::::::::::::::::::::::::*/
        
        /**gcbq limpiamos la session de series guardadas**/
        unset($_SESSION['serie']);
        unset($_SESSION['serieReal']);
        unset($_SESSION['serieRealBD']);
        /**fin de limpiar session***/

        $data_confi = $this->companiaconfiguracion_model->obtener($sucursal);
        $tipo = 10;
        $data_confi_docu = $this->companiaconfidocumento_model->obtener($data_confi[0]->COMPCONFIP_Codigo, 10);
        $data_confi1 = $this->configuracion_model->obtener_numero_documento($sucursal, $tipo);
       
        $compania         = $sucursal;
        $data['compania'] = $sucursal;
        $data['sucursal'] = $sucursal;
        $usuario = $this->somevar['user'];
        $datos_usuario = $this->usuario_model->obtener($usuario);
        $nombre_usuario = $datos_usuario->PERSC_Nombre . " " . $datos_usuario->PERSC_ApellidoPaterno;
        $data['guia'] = "";
        $data['titulo'] = "NUEVA GUIA DE REMISION";
        $data['codigo'] = "";
        $data['tipo_oper'] = $tipo_oper;
        $data['contiene_igv'] = (($data_confi[0]->COMPCONFIC_PrecioContieneIgv == '1') ? true : false);
        $data['form_open'] = form_open(base_url() . 'index.php/almacen/guiarem/grabar', array("name" => "frmGuiarem", "id" => "frmGuiarem"));
        $data['oculto'] = form_hidden(array("base_url" => base_url(), 'tipo_oper' => $tipo_oper, "guiarem_id" => '', 'guiasa_id' => '', "centro_costo" => 1, "accion" => "n", 'contiene_igv' => ($data['contiene_igv'] == true ? '1' : '0'), "igv" => $data_confi[0]->COMPCONFIC_Igv, "tipo_codificacion" => $data_confi_docu[0]->COMPCONFIDOCP_Tipo));
        $data['serie'] = "";
        $data['numero'] = "";
        $data['codigo_usuario'] = "";
        $data['fecha'] = form_input(array("name" => "fecha", "id" => "fecha", "class" => "cajaPequena cajaSoloLectura", "readonly" => "readonly", "maxlength" => "10", "value" => mysql_to_human($this->_hoy)));
        $data['nombre_usuario'] = form_input(array("name" => "nombre_usuario", "id" => "nombre_usuario", "class" => "cajaMedia", "readonly" => "readonly", "maxlength" => "30", "value" => $nombre_usuario));
        $data['recepciona_nombres'] = form_input(array("name" => "recepciona_nombres", "id" => "recepciona_nombres", "class" => "cajaGeneral", "size" => "27", "maxlength" => "150"));
        $data['recepciona_dni'] = form_input(array("name" => "recepciona_dni", "id" => "recepciona_dni", "class" => "cajaGeneral", "size" => "10", "maxlength" => "8"));
        $atributos = array('width' => 600,
            'height' => 400,
            'scrollbars' => 'yes',
            'status' => 'yes',
            'resizable' => 'yes',
            'screenx' => '0',
            'screeny' => '0');
        $contenido = "<img height='16' width='16' src='" . base_url() . "images/ver.png' title='Buscar' border='0'>";
       
        $data['hidden'] = "";
        $data['cliente'] = "";
        $data['ruc_cliente'] = "";
        $data['nombre_cliente'] = "";
        $data['proveedor'] = "";
        $data['nombre_proveedor'] = "";
        $data['ruc_proveedor'] = "";
        $data['detalle'] = array();
        $filterin = new stdClass();
        $filterin->TIPOMOVC_Tipo = 2;
        $lista_almacen = $this->almacen_model->seleccionar();
        $lista_miEstablec = $this->emprestablecimiento_model->obtener($this->somevar['establec']);
        $direccion_miEstablec = "";
        //$direccion_miEstablec = $lista_miEstablec[0]->EESTAC_Direccion . ' ' . $lista_miEstablec[0]->distrito . ' - ' . $lista_miEstablec[0]->provincia . ' - ' . $lista_miEstablec[0]->departamento;

        $data['cboAlmacen'] = form_dropdown("almacen", $lista_almacen, obtener_val_x_defecto($lista_almacen), " class='cajaGrande' id='almacen'");
        $data['cboDocumento'] = form_dropdown("referencia", $this->documento_model->seleccionar('1'), "1", " class='comboMedio' style='width:140px' id='referencia'");
        $data['cboTipoMov'] = form_dropdown("tipo_movimiento", $this->tipomovimiento_model->seleccionar($filterin), "0", " class='comboGrande' id='tipo_movimiento'");
        $data['otro_motivo'] = form_input(array("name" => "otro_motivo", "id" => "otro_motivo", "class" => "cajaMedia", "style" => "width:auto", "maxlength" => "250"));
        //$data['cboEmpresaTrans'] = form_dropdown("empresa_transporte", $this->empresa_model->seleccionar(), "1", " class='comboGrande' id='empresa_transporte' style='width:300px'");
        $data['cboMoneda'] = form_dropdown("moneda", $this->moneda_model->seleccionar(), "1", " class='comboMedio' id='moneda' style='width:120px'");
        ///aumentado stv
        //$data['cboPresupuesto'] = $this->OPTION_generador($this->presupuesto_model->listar_presupuestos_noguiarem('F', '1689'), 'PRESUP_Codigo', array('PRESUC_Numero', 'nombre'), '', array('', '::Seleccione::'), ' / ');
        ////
        //$data['cboPresupuesto'] = $this->OPTION_generador($this->presupuesto_model->listar_presupuestos_noguiarem_cualquiera(), 'PRESUP_Codigo', array('PRESUC_Numero', 'nombre'), '', array('', '::Seleccione::'), ' / ');
        $data['cboFactura'] = ""; //$this->OPTION_generador($this->comprobante_model->listar_comprobantes_factura('V', 'F'), 'CPP_Codigo', array('CPC_Serie', 'CPC_Numero'), '', array('', '::Seleccione::'), ' / ');
        $data['cboCotizacion'] = ""; //form_dropdown("cotizacion", $this->cotizacion_model->seleccionar2(), "", " class='comboMedio' id='cotizacion' onchange='obtener_detalle_cotizacion();'");
        $data['form_close'] = form_close();
        ////////stv
        $data['seriecom'] = form_input(array("name" => "seriecom", "id" => "seriecom", "class" => "cajaGeneral", "size" => "5", "maxlength" => "10"));
        ////////
        $data['numero_ref'] = '';
        $data['ordencompra'] = '';
        $data['numero_ocompra'] = form_input(array("name" => "numero_ocompra", "id" => "numero_ocompra", "class" => "cajaGeneral", "size" => "23", "maxlength" => "50"));
        ///aumentado stv
        $datos_ocompra = $this->ocompra_model->obtener_ocompra(1);
        if (count($datos_ocompra) > 0) {
            $nombre_proveedor = '';
            $data['cboOrdencompra'] = "<option value='" . $datos_ocompra[0]->OCOMP_Codigo . "' selected='selected'>" . $datos_ocompra[0]->OCOMC_Numero . "-" . $nombre_proveedor . "</option>";
        }
        $data['fecha_traslado'] = form_input(array("name" => "fecha_traslado", "id" => "fecha_traslado", "class" => "cajaPequena cajaSoloLectura", "maxlength" => "10", "value" => date('d/m/Y')));
        $data['nombre_conductor'] = form_input(array("name" => "nombre_conductor", "id" => "nombre_conductor", "class" => "cajaGeneral", "size" => "27", "maxlength" => "150" ,"value" => ""));
        $data['marca'] = form_input(array("name" => "marca", "id" => "marca", "class" => "cajaGeneral", "size" => "27", "maxlength" => "100", "value" => ""));
        $data['placa'] = form_input(array("name" => "placa", "id" => "placa", "class" => "cajaPequena", "maxlength" => "20","value" => ""));
        $data['registro_mtc'] = form_input(array("name" => "registro_mtc", "id" => "registro_mtc", "class" => "cajaPequena", "maxlength" => "20"));
        $data['certificado'] = form_input(array("name" => "certificado", "id" => "certificado", "class" => "cajaPequena", "maxlength" => "10"));
        $data['licencia'] = form_input(array("name" => "licencia", "id" => "licencia", "class" => "cajaPequena", "maxlength" => "10","value" => ""));
        $data['observacion'] = form_textarea(array("name" => "observacion", "id" => "observacion", "class" => "fuente8", "cols" => "108", "rows" => "3"));
        $data['ubigeo_partida'] = form_input(array("name" => "ubigeo_partida", "id" => "ubigeo_partida", "class" => "cajaPequena cajaSoloLectura", "maxlength" => "20"));
        $data['ubigeo_llegada'] = form_input(array("name" => "ubigeo_llegada", "id" => "ubigeo_llegada", "class" => "cajaPequena cajaSoloLectura", "maxlength" => "20"));
        $data['punto_partida'] = form_input(array("name" => "punto_partida", "id" => "punto_partida", "class" => "cajaGrande", "style" => "width:20em", "size" => "50", "maxlength" => "250", "value" => ($tipo_oper == 'V' ? $direccion_miEstablec : '')));
        $data['punto_llegada'] = form_input(array("name" => "punto_llegada", "id" => "punto_llegada", "class" => "cajaGrande", "style" => "width:20em", "size" => "58", "maxlength" => "250", "value" => ($tipo_oper == 'C' ? $direccion_miEstablec : '')));
        $data['estado'] = form_dropdown("estado", array("1" => "Activo", "0" => "Anulado"), "1", " class='comboPequeno' id='estado'");
        $data['flagEstado'] =2;
        $data['observacion'] = "";
        $data['descuento'] = "0";
        $data['igv'] = $data_confi[0]->COMPCONFIC_Igv;
        $data['hidden'] = "";
        $data['preciototal'] = "";
        $data['descuentotal'] = "";
        $data['igvtotal'] = "";
        $data['importetotal'] = "";
        $data['modo'] = "insertar";
        $data['tipoGuia']=0;
        
        if ($tipo_oper == 'V') {
            $serie = $data_confi_docu[0]->COMPCONFIDOCP_Serie;
            $cofiguracion_datos = $this->configuracion_model->obtener_numero_documento($compania, $tipo);
            $data['tipo_codificacion'] = $data_confi_docu[0]->COMPCONFIDOCP_Tipo;
            $data['serie_suger'] = $cofiguracion_datos[0]->CONFIC_Serie;
            $data['numero_suger'] =$this->getOrderNumeroSerie($cofiguracion_datos[0]->CONFIC_Numero + 1);

            $data['serie'] = $cofiguracion_datos[0]->CONFIC_Serie;
            $data['numero'] = $this->getOrderNumeroSerie($cofiguracion_datos[0]->CONFIC_Numero + 1);
        }

        if ($tipo_oper == 'C') {
            $serie = $data_confi_docu[0]->COMPCONFIDOCP_Serie;
            $data_cod = $this->configuracion_model->obtener_ultimo_numero_guia_remision();

            $data['tipo_codificacion'] = $data_confi_docu[0]->COMPCONFIDOCP_Tipo;
            $data['serie_suger'] = $data_confi1[0]->CONFIC_Serie;
            $data['numero_suger_c'] =$data_cod->conteo;
        }

        $data['cboObra'] = form_dropdown("obra", array('' => ':: Seleccione ::'), "", " class='comboGrande'  id='obra'");
        $data['afectaciones'] = $this->producto_model->tipo_afectacion();
        $data["documentosNatural"] = $this->tipodocumento_model->listar_tipo_documento();
        $data["documentosJuridico"] = $this->tipocodigo_model->listar_tipo_codigo();
        //Nuevo producto
          $filterOrden = new stdClass();
          $filterOrden->dir = "ASC";
          $filterOrden->order = "FABRIC_Descripcion";
          $data['fabricantes'] = $this->fabricante_model->getFabricantes($filterOrden);
          
          $filterOrden->order = "MARCC_Descripcion";
          $data['marcas'] = $this->marca_model->getMarcas($filterOrden);
          $flagBS = "B";

          $data['familias'] = $this->producto_model->getFamilias($flagBS);
          $filterOrden->order = "UNDMED_Descripcion";
          $data['unidades'] = $this->unidadmedida_model->getUmedidas($filterOrden);
          $data['afectaciones'] = $this->producto_model->tipo_afectacion();

          $data["precio_monedas"] = $this->moneda_model->getMonedas();
          $data["precio_categorias"] = $this->tipocliente_model->getCategorias();

        //Fin Nuevo producto
        $this->layout->view('almacen/guiarem_nueva', $data);
    }
  /* ======================================================================================================================================= */
    public function editar($codigo, $tipo_oper = 'V'){
        /* :::: SE CREA LA SESSION :::*/
        $hoy = date('Y-m-d H:i:s');
        $cadena = strtotime($hoy).substr((string)microtime(), 1, 8);
        $tempSession = str_replace('.','',$cadena);
        $data['tempSession']  = $tempSession;
        if ($tipo_oper == 'C') {
            $data['tipo_docu'] = "GRV";
        }else{
            $data['tipo_docu'] = "GRC";
        }
        /* :::::::::::::::::::::::::::*/
        
        $datos_guiarem = $this->guiarem_model->obtener($codigo);
        $compania = $datos_guiarem[0]->COMPP_Codigo;
        $data_confi = $this->companiaconfiguracion_model->obtener($compania);
        $data_confi_docu = $this->companiaconfidocumento_model->obtener($data_confi[0]->COMPCONFIP_Codigo, 10);
        
        unset($_SESSION['serie']);
        $modo = "modificar";
        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;
        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;
        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;
        $almacen = $datos_guiarem[0]->ALMAP_Codigo;
        $usuario = $datos_guiarem[0]->USUA_Codigo;
        $referencia = $datos_guiarem[0]->DOCUP_Codigo;
        $cliente = $datos_guiarem[0]->CLIP_Codigo;
        $proveedor = $datos_guiarem[0]->PROVP_Codigo;
        $recepciona_nombres = $datos_guiarem[0]->GUIAREMC_PersReceNombre;
        $recepciona_dni = $datos_guiarem[0]->GUIAREMC_PersReceDNI;
        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;
        $numero_ocompra = $datos_guiarem[0]->GUIAREMC_OCompra;
        $serie = $datos_guiarem[0]->GUIAREMC_Serie;
        $numero = $datos_guiarem[0]->GUIAREMC_Numero;
        $codigo_usuario = $datos_guiarem[0]->GUIAREMC_CodigoUsuario;
        $fecha_traslado = $datos_guiarem[0]->GUIAREMC_FechaTraslado;
        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;
        $placa = $datos_guiarem[0]->GUIAREMC_Placa;
        $marca = $datos_guiarem[0]->GUIAREMC_Marca;
        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;
        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;
        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;
        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;
        $ocompra = $datos_guiarem[0]->OCOMP_Codigo;
        $tipoGuia=$datos_guiarem[0]->GUIAREMC_TipoGuia;
        $mod_transporte =  $datos_guiarem[0]->GUIAREMC_ModTransporte;
        $peso_total = $datos_guiarem[0]->GUIAREMC_PesoTotal;
        $num_bultos = $datos_guiarem[0]->GUIAREMC_NumBultos;
        $nombre_empresa_transporte = $datos_guiarem[0]->GUIAREMC_EmpresaTransp;
        $ruc_empresa_transporte = $datos_guiarem[0]->GUIAREMC_RucEmpresaTransp; 
        $tipodoc_transporte = $datos_guiarem[0]->GUIAREMC_TipoDocTransp; 

        if ($tipo_oper == 'V')
            $guiasa_id = $datos_guiarem[0]->GUIASAP_Codigo;
        else
            $guiasa_id = $datos_guiarem[0]->GUIAINP_Codigo;

        $fecha = $datos_guiarem[0]->GUIAREMC_Fecha;

        $ruc_cliente = '';
        $nombre_cliente = '';
        $nombre_proveedor = '';
        $ruc_proveedor = '';

       

        if ($tipo_oper == 'C') {
            $datos_proveedor = $this->proveedor_model->obtener($proveedor);
            if ($datos_proveedor) {
                $nombre_proveedor = $datos_proveedor->nombre;
                $ruc_cliente = $datos_proveedor->ruc;
                $dni_cliente = $datos_proveedor->dni;
                $ruc_proveedor = ( $ruc_cliente == NULL || $ruc_cliente == "" || $ruc_cliente == 0 ) ? $dni_cliente : $ruc_cliente;
                $tipoDocIdentidad = $datos_proveedor->tipoDocIdentidad;
            }
        } else {
            $datos_cliente = $this->cliente_model->obtener($cliente);
            if ($datos_cliente) {
                $idCliente = $datos_cliente->idCliente;
                $nombre_cliente = $datos_cliente->nombre;
                $ruc_clientes = $datos_cliente->ruc;
                $dni_cliente = $datos_cliente->dni;
                $ruc_cliente = ( $ruc_clientes == NULL || $ruc_clientes == "" || $ruc_clientes == 0 ) ? $dni_cliente : $ruc_clientes;
                $direccion   = $datos_cliente->direccion;
                $email   = $datos_cliente->correo;
                $tipoDocIdentidad = $datos_cliente->tipoDocIdentidad;
            }
        }

        

        $datos_usuario = $this->usuario_model->obtener($usuario);
        $nombre_usuario = $datos_usuario->PERSC_Nombre . " " . $datos_usuario->PERSC_ApellidoPaterno;
        $ubigeo_partida = $datos_guiarem[0]->GUIAREMC_UbigeoPartida;
        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;
        $ubigeo_llegada = $datos_guiarem[0]->GUIAREMC_UbigeoLlegada;
        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;
        $estado = $datos_guiarem[0]->GUIAREMC_FlagEstado;
        $moneda = $datos_guiarem[0]->MONED_Codigo;
        $presupuesto = $datos_guiarem[0]->PRESUP_Codigo;
        $subtotal = $datos_guiarem[0]->GUIAREMC_subtotal;
        $descuento = $datos_guiarem[0]->GUIAREMC_descuento;
        $igv = $datos_guiarem[0]->GUIAREMC_igv;
        $total = $datos_guiarem[0]->GUIAREMC_total;
        $igv100 = $datos_guiarem[0]->GUIAREMC_igv100;
        $descuento100 = $datos_guiarem[0]->GUIAREMC_descuento100;

        
        /**ponemos en en estado seleccionado presupuesto**/
        if($presupuesto!=null && trim($presupuesto)!="" &&  $presupuesto!=0){
            $estadoSeleccion=1;
            $codigoPresupuesto=$presupuesto;
            /**1:sdeleccionado,0:deseleccionado**/
            $this->presupuesto_model->modificarTipoSeleccion($codigoPresupuesto,$estadoSeleccion);
        }
        /**fin de poner**/
        
        
        $data['mod_transporte'] = $mod_transporte;
        $data['peso_total'] = $peso_total;
        $data['num_bultos'] = $num_bultos;
        $data['nombre_empresa_transporte'] = $nombre_empresa_transporte;
        $data['ruc_empresa_transporte'] = $ruc_empresa_transporte;
        $data['tipodoc_transporte'] = $tipodoc_transporte;

        $data['titulo'] = "EDITAR GUIA DE REMISION";
        $data['compania'] = $compania;
        $data['sucursal'] = $compania;
        $data['codigo'] = $codigo;
        $data['tipo_oper'] = $tipo_oper;
        $data['contiene_igv'] = (($data_confi[0]->COMPCONFIC_PrecioContieneIgv == '1') ? true : false);
        $data['form_open'] = form_open(base_url() . 'index.php/almacen/guiarem/grabar', array("name" => "frmGuiarem", "id" => "frmGuiarem", "onsubmit" => "return valida_guiarem();"));
        $data['oculto'] = form_hidden(array('accion' => "m", 'guiarem_id' => $codigo, 'guiasa_id' => $guiasa_id, 'modo' => $modo, 'base_url' => base_url(), 'tipo_oper' => $tipo_oper, 'contiene_igv' => ($data['contiene_igv'] == true ? '1' : '0'), "igv" => $data_confi[0]->COMPCONFIC_Igv));
        $data['serie'] = $serie;
        $data['numero'] = $numero;
        $data['codigo_usuario'] = $codigo_usuario;
        $data['fecha'] = form_input(array("name" => "fecha", "id" => "fecha", "class" => "cajaPequena cajaSoloLectura", "readonly" => "readonly", "maxlength" => "10", "value" => mysql_to_human($fecha)));
        $data['nombre_usuario'] = form_input(array("name" => "nombre_usuario", "id" => "nombre_usuario", "class" => "cajaMedia", "readonly" => "readonly", "maxlength" => "30", "value" => $nombre_usuario));
        $data['recepciona_nombres'] = form_input(array("name" => "recepciona_nombres", "id" => "recepciona_nombres", "class" => "cajaGeneral", "size" => "27", "maxlength" => "150", "value" => $recepciona_nombres));
        $data['recepciona_dni'] = form_input(array("name" => "recepciona_dni", "id" => "recepciona_dni", "class" => "cajaGeneral", "size" => "10", "maxlength" => "8", "value" => $recepciona_dni));

        $atributos = array('width' => 600, 'height' => 400, 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');

        $contenido = "<img id='verCliente' height='16' width='16' src='" . base_url() . "images/ver.png' title='Buscar' border='0'>";

        $data['vercliente'] = anchor_popup('ventas/cliente/ventana_busqueda_cliente', $contenido, $atributos);
        $data['verproducto'] = "<a href='#' id='verCliente' onclick='busqueda_producto_x_almacen();'>" . $contenido . "</a>";
        $data['hidden'] = "";
        $data['cliente'] = $cliente;
        $data['ruc_cliente'] = $ruc_cliente;
        $data['nombre_cliente'] = $nombre_cliente;
        $data['proveedor'] = $proveedor;
        $data['ruc_proveedor'] = $ruc_proveedor;
        $data['nombre_proveedor'] = $nombre_proveedor;
        $data['flagEstado'] = $estado;
        
        $filterin = new stdClass();
        $filterin->TIPOMOVC_Tipo = 2;

        //el tipo_oper asigna la varriable-----------------------------------------
        $data['guia'] = $guiasa_id;
        /////
        
        $disableAlmacen=$tipoGuia==1?"disabled":"id='almacen'";
        
        $data['almacen'] =$almacen;
        $data['cboAlmacen'] = form_dropdown("almacen", $this->almacen_model->seleccionar(), $almacen, " class='comboMedio' $disableAlmacen");
        
        $data['cboDocumento'] = form_dropdown("referencia", $this->documento_model->seleccionar('1'), $referencia, " class='comboMedio' style='width:140px' id='referencia'");
        $data['cboDirEntrega'] = form_dropdown("dir_entrega", array("" => "::Seleccione::"), "", " class='comboMedio' id='dir_entrega'");
        $data['cboTipoMov'] = form_dropdown("tipo_movimiento", $this->tipomovimiento_model->seleccionar($filterin), $tipo_movimiento, " class='comboMedio' id='tipo_movimiento'");
        $data['otro_motivo'] = form_input(array("name" => "otro_motivo", "id" => "otro_motivo", "class" => "cajaGeneral", "style" => "width:117px", "maxlength" => "250", "value" => $otro_motivo));
        $data['cboEmpresaTrans'] = form_dropdown("empresa_transporte", $this->empresa_model->seleccionar(), $empresa_transporte, " class='comboGrande' id='empresa_transporte' style='width:300px'");
        
        $disableMoneda=$tipoGuia==1?'disabled':"id='moneda'";
        $data['moneda'] =$moneda;
        $data['cboMoneda'] = form_dropdown("moneda", $this->moneda_model->seleccionar(), $moneda, " class='comboMedio'  style='width:120px' $disableMoneda");
        
        $data['cboPresupuesto'] = $this->OPTION_generador($this->presupuesto_model->listar_presupuestos_noguiarem('F', $codigo), 'PRESUP_Codigo', array('PRESUC_Numero', 'nombre'), $presupuesto, array('', '::Seleccione::'), ' / ');
        ////////stv
        $data['seriecom'] = form_input(array("name" => "seriecom", "id" => "seriecom", "class" => "cajaGeneral", "size" => "5", "maxlength" => "10"));
        ////////
        $data['numero_ref'] = $numero_ref;
        $data['ordencompraempresa'] = $referencia;
        $data['numero_ocompra'] = form_input(array("name" => "numero_ocompra", "id" => "numero_ocompra", "class" => "cajaGeneral", "size" => "23", "maxlength" => "50", "value" => $numero_ocompra));

       

            $tipo_movimiento = $this->tipomovimiento_model->obtener($datos_guiarem[0]->TIPOMOVP_Codigo);
            $nombre_movimiento = strtolower($tipo_movimiento[0]->TIPOMOVC_Descripcion);

            if($nombre_movimiento == 'importacion' || $nombre_movimiento == "importación") {
                $data["es_importado"] = $es_importado = true;
            }

            $this->load->model("ventas/importacion_model");        
    
            $data['ordencompra'] = $ocompra;
            /**verificamos si orden de compra existe **/
            if($ocompra!=null && $ocompra!=0 && trim($ocompra)!=""){
                $datosOrdenCompra = $es_importado ? $this->importacion_model->obtener_comprobante($ocompra) : $this->ocompra_model->obtener_ocompra($ocompra);
                $data['serieOC'] = $es_importado ? $datosOrdenCompra[0]->IMPOR_Serie : $datosOrdenCompra[0]->OCOMC_Serie;
                $data['numeroOC']= $es_importado ? $datosOrdenCompra[0]->IMPOR_Numero : $datosOrdenCompra[0]->OCOMC_Numero;
                $data['valorOC']=($tipo_oper=="V")?"0":"1";
            }
            /**fin de verificacion**/
            $data['presupuesto_codigo'] = $presupuesto;
            /**verificamos si presupuesto o cotizacion  existe **/
            if($presupuesto!=null && $presupuesto!=0 && trim($presupuesto)!=""){
                $datosOrdenCompra=$this->presupuesto_model->obtener_presupuesto($presupuesto);
                $data['seriePre'] = $datosOrdenCompra[0]->PRESUC_Serie;
                $data['numeroPre']= $datosOrdenCompra[0]->PRESUC_Numero;
            }
            /**fin de verificacion**/
            
        $data['modo'] = "modificar";

        $ubigeop = $this->ubigeo_model->obtener_ubigeo($ubigeo_partida);
        $ubigeol = $this->ubigeo_model->obtener_ubigeo($ubigeo_llegada);
       
        $data['ubigeopText'] = $ubigeop[0]->UBIGC_DescripcionDpto."-".$ubigeop[0]->UBIGC_DescripcionProv."-".$ubigeop[0]->UBIGC_Descripcion;
        $data['ubigeolText'] = $ubigeol[0]->UBIGC_DescripcionDpto."-".$ubigeol[0]->UBIGC_DescripcionProv."-".$ubigeol[0]->UBIGC_Descripcion;


        $data['fecha_traslado'] = form_input(array("name" => "fecha_traslado", "id" => "fecha_traslado", "class" => "cajaPequena", "maxlength" => "10", "readonly" => "readonly", "value" => mysql_to_human($fecha_traslado==null?date('Y-m-d'):$fecha_traslado)));
        $data['nombre_conductor'] = form_input(array("name" => "nombre_conductor", "id" => "nombre_conductor", "class" => "cajaGeneral", "size" => "27", "maxlength" => "150", "value" => $nombre_conductor));
        $data['marca'] = form_input(array("name" => "marca", "id" => "marca", "class" => "cajaGeneral", "size" => "27", "maxlength" => "100", "value" => $marca));
        $data['placa'] = form_input(array("name" => "placa", "id" => "placa", "class" => "cajaPequena", "maxlength" => "20", "value" => $placa));
        $data['registro_mtc'] = form_input(array("name" => "registro_mtc", "id" => "registro_mtc", "class" => "cajaPequena", "maxlength" => "20", "value" => $registro_mtc));
        $data['certificado'] = form_input(array("name" => "certificado", "id" => "certificado", "class" => "cajaPequena", "maxlength" => "10", "value" => $certificado));
        $data['licencia'] = form_input(array("name" => "licencia", "id" => "licencia", "class" => "cajaPequena", "maxlength" => "10", "value" => $licencia));
        $data['observacion'] = form_textarea(array("name" => "observacion", "id" => "observacion", "class" => "fuente8", "cols" => "108", "rows" => "3", "value" => $observacion));
        $data['ubigeo_partida'] = form_input(array("name" => "ubigeo_partida", "id" => "ubigeo_partida", "class" => "cajaPequena cajaSoloLectura", "maxlength" => "20", "value" => $ubigeo_partida));
        $data['ubigeo_llegada'] = form_input(array("name" => "ubigeo_llegada", "id" => "ubigeo_llegada", "class" => "cajaPequena cajaSoloLectura", "maxlength" => "20", "value" => $ubigeo_llegada));
        $data['punto_partida'] = form_input(array("name" => "punto_partida", "id" => "punto_partida", "class" => "cajaGeneral", "size" => "30", "maxlength" => "250", "value" => $punto_partida));
        $data['punto_llegada'] = form_input(array("name" => "punto_llegada", "id" => "punto_llegada", "class" => "cajaGeneral", "size" => "40", "maxlength" => "250", "value" => $punto_llegada));
        $data['estado'] = form_dropdown("estado", array("1" => "Activo", "0" => "Anulado"), $estado, " class='comboPequeno' id='estado'");

        $data['observacion'] = $observacion;
        $data['descuento'] = $descuento100;
        $data['igv'] = $igv100;
        $data['preciototal'] = $subtotal;
        $data['descuentotal'] = $descuento;
        $data['igvtotal'] = $igv;
        $data['importetotal'] = $total;
        $data['form_close'] = form_close();
        $data['serie_suger'] = "";
        $data['numero_suger'] = "";
        $data['tipoGuia'] =$tipoGuia;
        $data['cboCotizacion'] = form_dropdown("cotizacion", $this->cotizacion_model->seleccionar2(), "", " class='comboMedio' id='cotizacion' onchange='obtener_detalle_cotizacion();'");

        /* Detalle */

        $detalle = $this->guiaremdetalle_model->obtener2($codigo);
        unset($_SESSION['serie']);
        unset($_SESSION['serieReal']);
        unset($_SESSION['serieRealBD']);
        
        
        
        $data['tipo_codificacion'] = $data_confi_docu[0]->COMPCONFIDOCP_Tipo;

        $codigoproyecto = $datos_guiarem[0]->PROYP_Codigo;
        
        if($codigoproyecto != 0){
            $listaproyecto = $this->proyecto_model->seleccionar($codigoproyecto);
            $data['cboObra'] = form_dropdown("obra",$listaproyecto,$codigoproyecto, " class='comboGrande'  id='obra' ");
        }else{
            $data['cboObra'] = form_dropdown("obra", array('' => ':: Seleccione ::'), "", " class='comboGrande'  id='obra'");
        }
        $data['afectaciones'] = $this->producto_model->tipo_afectacion();
        $data["documentosNatural"] = $this->tipodocumento_model->listar_tipo_documento();
        $data["documentosJuridico"] = $this->tipocodigo_model->listar_tipo_codigo();
        //Nuevo producto
          $filterOrden = new stdClass();
          $filterOrden->dir = "ASC";
          $filterOrden->order = "FABRIC_Descripcion";
          $data['fabricantes'] = $this->fabricante_model->getFabricantes($filterOrden);
          
          $filterOrden->order = "MARCC_Descripcion";
          $data['marcas'] = $this->marca_model->getMarcas($filterOrden);
          $flagBS = "B";

          $data['familias'] = $this->producto_model->getFamilias($flagBS);
          $filterOrden->order = "UNDMED_Descripcion";
          $data['unidades'] = $this->unidadmedida_model->getUmedidas($filterOrden);
          $data['afectaciones'] = $this->producto_model->tipo_afectacion();

          $data["precio_monedas"] = $this->moneda_model->getMonedas();
          $data["precio_categorias"] = $this->tipocliente_model->getCategorias();

        //Fin Nuevo producto
        $this->layout->view('almacen/guiarem_nueva', $data);
    }
    
    public function guiarem_ver($codigo, $tipo_oper = 'V'){
        $data_confi = $this->companiaconfiguracion_model->obtener($this->somevar['compania']);
        $data_confi_docu = $this->companiaconfidocumento_model->obtener($data_confi[0]->COMPCONFIP_Codigo, 10);

        unset($_SESSION['serie']);
        $modo = "modificar";
        $datos_guiarem = $this->guiarem_model->obtener($codigo);
        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;
        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;
        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;
        $almacen = $datos_guiarem[0]->ALMAP_Codigo;
        $usuario = $datos_guiarem[0]->USUA_Codigo;
        $referencia = $datos_guiarem[0]->DOCUP_Codigo;
        $cliente = $datos_guiarem[0]->CLIP_Codigo;
        $proveedor = $datos_guiarem[0]->PROVP_Codigo;
        $recepciona_nombres = $datos_guiarem[0]->GUIAREMC_PersReceNombre;
        $recepciona_dni = $datos_guiarem[0]->GUIAREMC_PersReceDNI;
        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;
        $numero_ocompra = $datos_guiarem[0]->GUIAREMC_OCompra;
        $serie = $datos_guiarem[0]->GUIAREMC_Serie;
        $numero = $datos_guiarem[0]->GUIAREMC_Numero;
        $codigo_usuario = $datos_guiarem[0]->GUIAREMC_CodigoUsuario;
        $fecha_traslado = $datos_guiarem[0]->GUIAREMC_FechaTraslado;
        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;
        $placa = $datos_guiarem[0]->GUIAREMC_Placa;
        $marca = $datos_guiarem[0]->GUIAREMC_Marca;
        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;
        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;
        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;
        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;
        $ocompra = $datos_guiarem[0]->OCOMP_Codigo;
        if ($tipo_oper == 'V')
            $guiasa_id = $datos_guiarem[0]->GUIASAP_Codigo;
        else
            $guiasa_id = $datos_guiarem[0]->GUIAINP_Codigo;

        $fecha = $datos_guiarem[0]->GUIAREMC_Fecha;

        $ruc_cliente = '';
        $nombre_cliente = '';
        $nombre_proveedor = '';
        $ruc_proveedor = '';

        if ($cliente != '' && $cliente != '0') {
            $datos_cliente = $this->cliente_model->obtener($cliente);
            if ($datos_cliente) {
                $nombre_cliente = $datos_cliente->nombre;
                $ruc_cliente = $datos_cliente->ruc;
            }
        } elseif ($proveedor != '' && $proveedor != '0') {
            $datos_proveedor = $this->proveedor_model->obtener($proveedor);
            if ($datos_proveedor) {
                $nombre_proveedor = $datos_proveedor->nombre;
                $ruc_proveedor = $datos_proveedor->ruc;
            }
        }

        $datos_usuario = $this->usuario_model->obtener($usuario);
        $nombre_usuario = $datos_usuario->PERSC_Nombre . " " . $datos_usuario->PERSC_ApellidoPaterno;
        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;
        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;
        $estado = $datos_guiarem[0]->GUIAREMC_FlagEstado;
        $moneda = $datos_guiarem[0]->MONED_Codigo;
        $presupuesto = $datos_guiarem[0]->PRESUP_Codigo;
        $subtotal = $datos_guiarem[0]->GUIAREMC_subtotal;
        $descuento = $datos_guiarem[0]->GUIAREMC_descuento;
        $igv = $datos_guiarem[0]->GUIAREMC_igv;
        $total = $datos_guiarem[0]->GUIAREMC_total;
        $igv100 = $datos_guiarem[0]->GUIAREMC_igv100;
        $descuento100 = $datos_guiarem[0]->GUIAREMC_descuento100;

        $data['titulo'] = "VISTA PREVIA DE LA GUIA DE REMISION";
        $data['codigo'] = $codigo;
        $data['tipo_oper'] = $tipo_oper;
        $data['contiene_igv'] = (($data_confi[0]->COMPCONFIC_PrecioContieneIgv == '1') ? true : false);
        $data['form_open'] = form_open(base_url() . 'index.php/almacen/guiarem/grabar', array("name" => "frmGuiarem", "id" => "frmGuiarem", "onsubmit" => "return valida_guiarem();"));
        $data['oculto'] = form_hidden(array('accion' => "m", 'guiarem_id' => $codigo, 'guiasa_id' => $guiasa_id, 'modo' => $modo, 'base_url' => base_url(), 'tipo_oper' => $tipo_oper, 'contiene_igv' => ($data['contiene_igv'] == true ? '1' : '0'), "igv" => $data_confi[0]->COMPCONFIC_Igv));
        $data['serie'] = $serie;
        $data['numero'] = $numero;
        $data['codigo_usuario'] = $codigo_usuario;
        $data['fecha'] = form_input(array("name" => "fecha", "id" => "fecha", "class" => "cajaPequena cajaSoloLectura", "readonly" => "readonly", "maxlength" => "10", "value" => mysql_to_human($fecha)));
        $data['nombre_usuario'] = form_input(array("name" => "nombre_usuario", "id" => "nombre_usuario", "class" => "cajaMedia", "readonly" => "readonly", "maxlength" => "30", "value" => $nombre_usuario));
        $data['recepciona_nombres'] = form_input(array("name" => "recepciona_nombres", "id" => "recepciona_nombres", "class" => "cajaGeneral", "size" => "27", "maxlength" => "150", "value" => $recepciona_nombres));
        $data['recepciona_dni'] = form_input(array("name" => "recepciona_dni", "id" => "recepciona_dni", "class" => "cajaGeneral", "size" => "10", "maxlength" => "8", "value" => $recepciona_dni));

        $atributos = array('width' => 600, 'height' => 400, 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');

        $contenido = "<img id='verCliente' height='16' width='16' src='" . base_url() . "images/ver.png' title='Buscar' border='0'>";

        $data['vercliente'] = anchor_popup('ventas/cliente/ventana_busqueda_cliente', $contenido, $atributos);
        $data['verproducto'] = "<a href='#' id='verCliente' onclick='busqueda_producto_x_almacen();'>" . $contenido . "</a>";
        $data['hidden'] = "";
        $data['cliente'] = $cliente;
        $data['ruc_cliente'] = $ruc_cliente;
        $data['nombre_cliente'] = $nombre_cliente;
        $data['proveedor'] = $proveedor;
        $data['ruc_proveedor'] = $ruc_proveedor;
        $data['nombre_proveedor'] = $nombre_proveedor;

        $filterin = new stdClass();
        $filterin->TIPOMOVC_Tipo = 2;

        //el tipo_oper asigna la varriable-----------------------------------------
        $data['guia'] = $guiasa_id;
        /////

        $data['cboAlmacen'] = form_dropdown("almacen", $this->almacen_model->seleccionar(), $almacen, " class='comboMedio' id='almacen'");
        $data['cboDocumento'] = form_dropdown("referencia", $this->documento_model->seleccionar('1'), $referencia, " class='comboMedio' style='width:140px' id='referencia'");
        $data['cboDirEntrega'] = form_dropdown("dir_entrega", array("" => "::Seleccione::"), "", " class='comboMedio' id='dir_entrega'");
        $data['cboTipoMov'] = form_dropdown("tipo_movimiento", $this->tipomovimiento_model->seleccionar($filterin), $tipo_movimiento, " class='comboMedio' id='tipo_movimiento'");
        $data['otro_motivo'] = form_input(array("name" => "otro_motivo", "id" => "otro_motivo", "class" => "cajaGeneral", "style" => "width:117px", "maxlength" => "250", "value" => $otro_motivo));
        $data['cboEmpresaTrans'] = form_dropdown("empresa_transporte", $this->empresa_model->seleccionar(), $empresa_transporte, " class='comboGrande' id='empresa_transporte' style='width:300px'");
        $data['cboMoneda'] = form_dropdown("moneda", $this->moneda_model->seleccionar(), $moneda, " class='comboMedio' id='moneda' style='width:120px'");
        $data['cboPresupuesto'] = $this->OPTION_generador($this->presupuesto_model->listar_presupuestos_noguiarem('F', $codigo), 'PRESUP_Codigo', array('PRESUC_Numero', 'nombre'), $presupuesto, array('', '::Seleccione::'), ' / ');
        ////////stv
        $data['seriecom'] = form_input(array("name" => "seriecom", "id" => "seriecom", "class" => "cajaGeneral", "size" => "5", "maxlength" => "10"));
        ////////
        $data['numero_ref'] = form_input(array("name" => "numero_ref", "id" => "numero_ref", "class" => "cajaGeneral", "size" => "19", "maxlength" => "15", "value" => $numero_ref));
        $data['numero_ocompra'] = form_input(array("name" => "numero_ocompra", "id" => "numero_ocompra", "class" => "cajaGeneral", "size" => "23", "maxlength" => "50", "value" => $numero_ocompra));

        //$data['cboOrdencompra']   = $this->OPTION_generador($this->ocompra_model->obtener_ocompra($ocompra), 'OCOMP_Codigo', array('OCOMC_Numero','nombre'),'', array('','::Seleccione::'), ' - ');

        $datos_ocompra = $this->ocompra_model->obtener_ocompra($ocompra);

        //print_r($datos_ocompra);

        if (count($datos_ocompra) > 0)
            $data['cboOrdencompra'] = "<option value='" . $datos_ocompra[0]->OCOMP_Codigo . "' selected='selected'>" . $datos_ocompra[0]->OCOMC_Numero . "-" . $nombre_proveedor . "</option>";
        $data['modo'] = "modificar";

        //$data['cboOrdencompra']   = $this->OPTION_generador($this->ocompra_model->obtener_ocompra($codigo), 'OCOMP_Codigo', array('OCOMC_Numero','nombre'),'', array('','::Seleccione::'), ' - ');

        $data['fecha_traslado'] = form_input(array("name" => "fecha_traslado", "id" => "fecha_traslado", "class" => "cajaPequena", "maxlength" => "10", "readonly" => "readonly", "value" => mysql_to_human($fecha_traslado)));
        $data['nombre_conductor'] = form_input(array("name" => "nombre_conductor", "id" => "nombre_conductor", "class" => "cajaGeneral", "size" => "27", "maxlength" => "150", "value" => $nombre_conductor));
        $data['marca'] = form_input(array("name" => "marca", "id" => "marca", "class" => "cajaGeneral", "size" => "27", "maxlength" => "100", "value" => $marca));
        $data['placa'] = form_input(array("name" => "placa", "id" => "placa", "class" => "cajaPequena", "maxlength" => "20", "value" => $placa));
        $data['registro_mtc'] = form_input(array("name" => "registro_mtc", "id" => "registro_mtc", "class" => "cajaPequena", "maxlength" => "20", "value" => $registro_mtc));
        $data['certificado'] = form_input(array("name" => "certificado", "id" => "certificado", "class" => "cajaPequena", "maxlength" => "10", "value" => $certificado));
        $data['licencia'] = form_input(array("name" => "licencia", "id" => "licencia", "class" => "cajaPequena", "maxlength" => "10", "value" => $licencia));
        $data['observacion'] = form_textarea(array("name" => "observacion", "id" => "observacion", "class" => "fuente8", "cols" => "108", "rows" => "3", "value" => $observacion));
        $data['punto_partida'] = form_input(array("name" => "punto_partida", "id" => "punto_partida", "class" => "cajaGeneral", "size" => "57", "maxlength" => "250", "value" => $punto_partida));
        $data['punto_llegada'] = form_input(array("name" => "punto_llegada", "id" => "punto_llegada", "class" => "cajaGeneral", "size" => "58", "maxlength" => "250", "value" => $punto_llegada));
        $data['estado'] = form_dropdown("estado", array("1" => "Activo", "0" => "Anulado"), $estado, " class='comboPequeno' id='estado'");

        $data['observacion'] = $observacion;
        $data['descuento'] = $descuento100;
        $data['igv'] = $igv100;
        $data['preciototal'] = $subtotal;
        $data['descuentotal'] = $descuento;
        $data['igvtotal'] = $igv;
        $data['importetotal'] = $total;
        $data['form_close'] = form_close();
        $data['serie_suger'] = "";
        $data['numero_suger'] = "";
        $data['cboCotizacion'] = form_dropdown("cotizacion", $this->cotizacion_model->seleccionar2(), "", " class='comboMedio' id='cotizacion' onchange='obtener_detalle_cotizacion();'");

        /* Detalle */

        $detalle = $this->guiaremdetalle_model->obtener2($codigo);

        $detalle_guiarem = array();

        if (count($detalle) > 0) {

            foreach ($detalle as $indice => $valor) {

                $detacodi = $valor->GUIAREMDETP_Codigo;
                $producto = $valor->PRODCTOP_Codigo;
                $unidad = $valor->UNDMED_Codigo;
                $cantidad = $valor->GUIAREMDETC_Cantidad;
                $pu = $valor->GUIAREMDETC_Pu;
                $subtotal = $valor->GUIAREMDETC_Subtotal;
                $igv = $valor->GUIAREMDETC_Igv;
                $descuento = $valor->GUIAREMDETC_Descuento;
                $total = $valor->GUIAREMDETC_Total;
                $pu_conigv = $valor->GUIAREMDETC_Pu_ConIgv;
                $costo = $valor->GUIAREMDETC_Costo;
                $venta = $valor->GUIAREMDETC_Venta;
                $peso = $valor->GUIAREMDETC_Peso;
                $GenInd = $valor->GUIAREMDETC_GenInd;
                $descri = str_replace('"', "''", $valor->GUIAREMDETC_Descripcion);
                $datos_producto = $this->producto_model->obtener_producto($producto);
                $datos_unidad = $this->unidadmedida_model->obtener($unidad);
                $nombre_producto = $datos_producto[0]->PROD_Nombre;
                $codigo_interno = $datos_producto[0]->PROD_CodigoUsuario;
                if ($datos_unidad)
                    $nombre_unidad = $datos_unidad[0]->UNDMED_Descripcion;
                else
                    $nombre_unidad = "SERV";
                $objeto = new stdClass();
                $objeto->GUIAREMDETP_Codigo = $detacodi;
                $objeto->PROD_Codigo = $producto;
                $objeto->PROD_CodigoInterno = $codigo_interno;
                $objeto->GUIAREMDETC_Cantidad = $cantidad;
                $objeto->GUIAREMDETC_Pu = $pu;
                $objeto->GUIAREMDETC_Subtotal = $subtotal;
                $objeto->GUIAREMDETC_Descuento = $descuento;
                $objeto->GUIAREMDETC_Igv = $igv;
                $objeto->GUIAREMDETC_Total = $total;
                $objeto->GUIAREMDETC_Pu_ConIgv = $pu_conigv;
                $objeto->GUIAREMDETC_Costo = $costo;
                $objeto->GUIAREMDETC_Venta = $venta;
                $objeto->GUIAREMDETC_Peso = $peso;
                $objeto->UNDMED_Codigo = $unidad;
                $objeto->PROD_Nombre = $nombre_producto;
                $objeto->UNDMED_Simbolo = $nombre_unidad;
                $objeto->GUIAREMDETC_GenInd = $GenInd;
                $objeto->GUIAREMDETC_Descripcion = $descri;

                $detalle_guiarem[] = $objeto;

            }
        }
        $data['detalle'] = $detalle_guiarem;
        $data['tipo_codificacion'] = $data_confi_docu[0]->COMPCONFIDOCP_Tipo;
        $this->load->view('almacen/guiarem_ver', $data);
    }

    public function grabar(){

        $this->load->helper('my_guiarem');
        $guiarem_id = $this->input->post("guiarem_id");
        $compania = $this->input->post("sucursal");
        
        if($guiarem_id==null || $guiarem_id==0 || trim($guiarem_id)==""){
            $data_confi = $this->companiaconfiguracion_model->obtener($compania);
            $data_confi_docu = $this->companiaconfidocumento_model->obtener($data_confi[0]->COMPCONFIP_Codigo, 10);
            $tipo_codificacion = $data_confi_docu[0]->COMPCONFIDOCP_Tipo;
            //echo $guiarem_id; exit;
    
            switch ($tipo_codificacion){
                case '2':
                    if ($this->input->post('serie') == '')
                        exit('{"result":"error", "campo":"serie"}');
    
                    if ($this->input->post('numero') == '')
                        exit('{"result":"error", "campo":"numero"}');
                    break;
                case '3':
                    if ($this->input->post('codigo_usuario') == '')
                        exit('{"result":"error", "campo":"codigo_usuario"}');
                    break;
            }
        }

        $tipo_oper = $this->input->post('tipo_oper');

        if ($this->input->post('almacen') == '' || $this->input->post('almacen') == '0')
            exit('{"result":"error", "campo":"almacen"}');

        if ($tipo_oper == 'V' && $tipo_oper == '')
            exit('{"result":"error", "campo":"ruc_cliente"}');

        if ($tipo_oper == 'C' && $tipo_oper == '')
            exit('{"result":"error", "campo":"ruc_proveedor}');

        if ($this->input->post('tipo_movimiento') == '' || $this->input->post('tipo_movimiento') == '0')
            exit('{"result":"error", "campo":"tipo_movimiento"}');

        if ($this->input->post('fecha_traslado') == '')
            exit('{"result":"error", "campo":"fecha_traslado"}');

        if ($this->input->post('fecha_traslado') == '')
            exit('{"result":"error", "campo":"fecha_traslado"}');

        if ($this->input->post('tipo_movimiento') == '13' && $this->input->post('otro_motivo') == '')
            exit('{"result":"error", "campo":"otro_motivo"}');

        if ($this->input->post('punto_partida') == '')
            exit('{"result":"error", "campo":"punto_partida"}');

        if ($this->input->post('punto_llegada') == '')
            exit('{"result":"error", "campo":"punto_llegada"}');

        if ($this->input->post('estado') == '0' && $this->input->post('observacion') == '')
            exit('{"result":"error", "campo":"observacion"}');

        if ($this->input->post('moneda') == '0' || $this->input->post('moneda') == '')
            exit('{"result":"error", "campo":"moneda"}');


        //VERIFICO SI TODAS LAS SERIES HAN SIDO INGRESADAS

        $prodcodigo = $this->input->post('prodcodigo');
        $flagGenInd = $this->input->post('flagGenIndDet');
        $prodcantidad = $this->input->post('prodcantidad');
        $proddescri = $this->input->post('proddescri');
        $guia_id = $this->input->post("guiasa_id");  
        
        if ($this->input->post("serie"))
            $serie = $this->input->post("serie");

       $numero = NULL;

        

        $codigo_usuario = NULL;

        if ($this->input->post("codigo_usuario"))
            $codigo_usuario = $this->input->post("codigo_usuario");

        $almacen = $this->input->post("almacen");
        if ($tipo_oper == 'V')
            $cliente = $this->input->post("cliente");
        else
            $proveedor = $this->input->post("proveedor");

        $moneda = strtoupper($this->input->post("moneda"));
        $recepciona_nombres = strtoupper($this->input->post("recepciona_nombres"));
        $recepciona_dni = $this->input->post("recepciona_dni");
        $referencia = $this->input->post("ordencompraempresa");
        $numero_ref = $this->input->post("numero_ref");
        $numero_ocompra = $this->input->post("numeroOrden");
        $tipo_movimiento = $this->input->post("tipo_movimiento");
        $otro_motivo = $this->input->post("otro_motivo");
        $ubigeo_partida = $this->input->post("ubigeo_partida");
        $punto_partida = $this->input->post("punto_partida");
        $ubigeo_llegada = $this->input->post("ubigeo_llegada");
        $punto_llegada = $this->input->post("punto_llegada");
        $fecha_traslado = $this->input->post("fecha_traslado");
        $fecha = date('d/m/Y', time());
        $empresa_transporte = $this->input->post("empresa_transporte");
        $nombre_conductor = $this->input->post("nombre_conductor");
        $marca = $this->input->post("marca");
        $placa = $this->input->post("placa");
        $registro_mtc = $this->input->post("registro_mtc");
        $certificado = $this->input->post("certificado");
        $licencia = $this->input->post("licencia");
        $observacion = $this->input->post("observacion");
        $accion = $this->input->post("accion");
        $prodcodigo = $this->input->post('prodcodigo');
        $produnidad = $this->input->post('produnidad');
        $prodcantidad = $this->input->post('prodcantidad');
        $prodpu = $this->input->post('prodpu');
        $prodprecio = $this->input->post('prodprecio');
        $proddescuento = $this->input->post('proddescuento');
        $prodigv = $this->input->post('prodigv');
        $tafectacion = $this->input->post('tafectacion');
        $lote = $this->input->post('idLote');
        $prodimporte = $this->input->post('prodimporte');
        $prodpu_conigv = $this->input->post('prodpu_conigv');
        $prodigv100 = $this->input->post('prodigv100');
        $proddescuento100 = $this->input->post('proddescuento100');
        $prodcosto = $this->input->post('prodcosto');
        $prodventa = $this->input->post('prodventa');
        $proddescri = $this->input->post('proddescri');
        $observacionesdetalle = $this->input->post('prodobservacion');
        $detaccion = $this->input->post('detaccion');
        $detacodi = $this->input->post('detacodi');
        $flagGenInd = $this->input->post('flagGenIndDet');
        $estado = $this->input->post('flagEstado');
        $presupuesto = $this->input->post("presupuesto_codigo");
        $ordencompra = $this->input->post("ordencompra");
        $tipoGuia= $this->input->post("tipoGuia");
        $almacenProducto=$this->input->post("almacenProducto");
        $detobserv = "";
        
        $mod_transporte = $this->input->post("mod_transporte");
        $peso_total = $this->input->post("peso_total");
        $num_bultos = $this->input->post("num_bultos");
        $nombre_empresa_transporte = $this->input->post("nombre_empresa_transporte");
        $ruc_empresa_transporte = $this->input->post("ruc_empresa_transporte");
        $tipodoc_transporte = $this->input->post("tipodoc_transporte");

        $obra= $this->input->post('obra');
        $proyecto= $this->input->post('proyecto');

        $showDetails = $this->input->post('showDetails');

        $filter = new stdClass();

        $filter->PROYP_Codigo=$obra;
        $filter->MONED_Codigo = $moneda;
        $filter->OCOMP_Codigo=null;
        if ($ordencompra != '')
            $filter->OCOMP_Codigo = $ordencompra;
        
        $filter->GUIAREMC_TipoOperacion = $tipo_oper;
        
        $filter->PRESUP_Codigo = NULL;
        if ($presupuesto != '')
            $filter->PRESUP_Codigo = $presupuesto;

        $filter->TIPOMOVP_Codigo = $tipo_movimiento;
        $filter->GUIAREMC_OtroMotivo = strtoupper($otro_motivo);
        $filter->GUIAREMC_Serie = $serie;
        $filter->GUIAREMC_CodigoUsuario = $codigo_usuario;
        $filter->ALMAP_Codigo = NULL;

        if ($almacen != ''){
            $filter->ALMAP_Codigo = $almacen;
        }          

        $filter->USUA_Codigo = $this->somevar['user'];
        $filter->COMPP_Codigo = $compania;
        $filter->DOCUP_Codigo = NULL;
        
        $filter->GUIAREMC_ModTransporte = $mod_transporte;
        $filter->GUIAREMC_PesoTotal = $peso_total;
        $filter->GUIAREMC_NumBultos = $num_bultos;
        $filter->GUIAREMC_EmpresaTransp = $nombre_empresa_transporte;
        $filter->GUIAREMC_RucEmpresaTransp = $ruc_empresa_transporte;
        $filter->GUIAREMC_TipoDocTransp = $tipodoc_transporte;
        
        if ($referencia != '')
            $filter->DOCUP_Codigo = $referencia;

        if ($tipo_oper == 'V')
            $filter->CLIP_Codigo = $cliente;
        else
            $filter->PROVP_Codigo = $proveedor;
        
        $filter->GUIAREMC_PersReceNombre = $recepciona_nombres;
        $filter->GUIAREMC_PersReceDNI = $recepciona_dni;
        $filter->GUIAREMC_NumeroRef = $numero_ref;
        $filter->GUIAREMC_OCompra = $numero_ocompra;
        $filter->GUIAREMC_FechaTraslado = human_to_mysql($fecha_traslado);
        $filter->GUIAREMC_UbigeoPartida = $ubigeo_partida;
        $filter->GUIAREMC_PuntoPartida = strtoupper($punto_partida);
        $filter->GUIAREMC_UbigeoLlegada = $ubigeo_llegada;
        $filter->GUIAREMC_PuntoLlegada = strtoupper($punto_llegada);
        $filter->GUIAREMC_Fecha = human_to_mysql($fecha);
        $filter->EMPRP_Codigo = NULL;

        if ($empresa_transporte != '')
            $filter->EMPRP_Codigo = $empresa_transporte;

        $filter->GUIAREMC_Marca = strtoupper($marca);
        $filter->GUIAREMC_Placa = strtoupper($placa);
        $filter->GUIAREMC_RegistroMTC = strtoupper($registro_mtc);
        $filter->GUIAREMC_Certificado = strtoupper($certificado);
        $filter->GUIAREMC_Licencia = strtoupper($licencia);
        $filter->GUIAREMC_NombreConductor = strtoupper($nombre_conductor);
        $filter->GUIAREMC_descuento100 = $this->input->post('descuento');
        $filter->GUIAREMC_igv100 = $this->input->post('igv');
        $filter->GUIAREMC_subtotal = $this->input->post('preciototal');
        $filter->GUIAREMC_descuento = $this->input->post('descuentotal');
        $filter->GUIAREMC_igv = $this->input->post('igvtotal');
        $filter->GUIAREMC_total = $this->input->post('importetotal');
        
        
        if ($guiarem_id == "") {
            if ($accion == "m") {
                $this->guiaremdetalle_model->eliminar2($guiarem_id);
            }

        }

        if (isset($guiarem_id) && $guiarem_id > 0) {

            $numero = $this->input->post("numero");
            $filter->GUIAREMC_Numero = $numero;
            unset($filter->GUIAREMC_FechaRegistro);

            /**tipo guia interna:1 cambiamos de estado a estado:1**/
            if($tipoGuia==1){
                $filter->GUIAREMC_FlagEstado = 1;
            }

            
            
            if(!empty($referencia)){
                
                $ordenCompra = explode(' ',$observacion);
                if($ordenCompra[0] != 'ORDEN'){
                    $filter->GUIAREMC_Observacion =strtoupper("ORDEN DE COMPRA N° ".$referencia." ".$observacion);
                }else{
                    $exchangeOrdenCompra = str_replace($ordenCompra[4],$referencia,$observacion);
                    $filter->GUIAREMC_Observacion = strtoupper($exchangeOrdenCompra);
                }

            }else{
                $filter->GUIAREMC_Observacion = strtoupper($observacion);
            }
            
            $this->guiarem_model->modificar($guiarem_id, $filter);
            /**INTERNA:1 si es interna no se elimina **/
            if($tipoGuia==0){
                $this->guiaremdetalle_model->eliminar2($guiarem_id);
            }
            
        } else {
            $cofiguracion_datos = $this->configuracion_model->obtener_numero_documento($compania, 10,'V');

            if ($tipo_oper == 'V') {
                $numero = $cofiguracion_datos[0]->CONFIC_Numero + 1;
                //$numero = $this->getOrderNumeroSerie($numResul);
                $this->configuracion_model->modificar_configuracion($compania, 10, $numResul, $serie1 = null);
            }else{
                $numero = $this->input->post("numero");
            }
            
            $filter->GUIAREMC_Numero = $numero;
            $filter->GUIAREMC_FlagEstado = $estado;
            $filter->GUIAREMC_Observacion = (!empty($referencia))?"ORDEN DE COMPRA N° ".$referencia." ".strtoupper($observacion) : strtoupper($observacion);
            
            $guiarem_id = $this->guiarem_model->insertar($filter);

            $dataImportacion = new stdClass();
            $dataImportacion->GUIAREMP_Codigo = $guiarem_id;
            if(!is_null($ordencompra)) {
                $this->load->model("ventas/importacion_model");
                $this->importacion_model->modificar_comprobante($ordencompra, $dataImportacion);
            }
            
        }


        // gcbq ---orden de compra total bienes que existe 
        if ($ordencompra != "") {
            $cantidad_entregada_total = 0;
            $cantidad_total_ingresada = 0;
            $cant_total = 0;
            $detalle = $this->ocompra_model->obtener_detalle_ocompra($ordencompra);
            if (is_array($detalle) > 0) {
                foreach ($detalle as $valor2) {
                    $cant_total += $valor2->OCOMDEC_Cantidad;
                }
            }
        }
        ///////////////
        /**INTERNA:1  si es interna no se modifica solo lo puede hacer la factura que lo creo**/
       if($tipoGuia==0){
            if (is_array($prodcodigo)) {
    
                foreach ($prodcodigo as $indice => $valor) {
    
                        
                    $producto = $prodcodigo[$indice];
                    $codigoAlmacenProducto = $almacenProducto[$indice];
                    $unidad1 = $produnidad[$indice];
    
                    if ($unidad1 == "") {
                        $unidad = NULL;
                    } else {
                        $unidad = $unidad1;
                    }
    
                    $cantidad = $prodcantidad[$indice];
                    $costo = $prodcosto[$indice];
                    $venta = $prodventa[$indice];
                    $descri = $proddescri[$indice];
                    $observacionDet = $observacionesdetalle[$indice];
                    $accion = $detaccion[$indice];
                    $detflag = $flagGenInd[$indice];
    
                    //gcbq agrgar flagestado de terminado ocompra 
                    if ($ordencompra != '' && $accion!="e") {
    
                        $cantidad_entregada = calcular_cantidad_entregada_x_producto($tipo_oper, $tipo_oper,$ordencompra, $prodcodigo[$indice]);
                        $cantidad_entregada_total += $cantidad_entregada;
                        $cantidad_total_ingresada += $prodcantidad[$indice];
                        if ($cant_total <= $cantidad_entregada_total + $cantidad_total_ingresada) {
                            $this->ocompra_model->modificar_flagTerminado($this->input->post('ordencompra'), "1");
                        }
                        if ($cant_total > $cantidad_entregada_total + $cantidad_total_ingresada) {
                            $this->ocompra_model->modificar_flagTerminado($this->input->post('ordencompra'), "0");
                        }
                    }
                    ///////////////////
    
    
                    $observ = "Insertar";
                    $filter2 = new stdClass();
                    $filter2->GUIAREMP_Codigo = $guiarem_id;
                    $filter2->PRODCTOP_Codigo = $producto;
                    $filter2->UNDMED_Codigo = $unidad;
                    $filter2->LOTP_Codigo = $lote[$indice];
                    $filter2->AFECT_Codigo = $tafectacion[$indice];
                    $filter2->GUIAREMDETC_Cantidad = $cantidad;
                    $filter2->GUIAREMDETC_Pu = $prodpu[$indice];
                    $filter2->GUIAREMDETC_Subtotal = $prodprecio[$indice];
                    $filter2->GUIAREMDETC_Descuento = $proddescuento[$indice];
                    $filter2->GUIAREMDETC_Igv = $prodigv[$indice];
                    $filter2->GUIAREMDETC_Total = $prodimporte[$indice];
                    $filter2->GUIAREMDETC_Pu_ConIgv = $prodpu_conigv[$indice];
                    $filter2->GUIAREMDETC_Descuento100 = $proddescuento100[$indice];
                    $filter2->GUIAREMDETC_Igv100 = $prodigv100[$indice];
                    $filter2->GUIAREMDETC_Costo = $costo;
                    $filter2->GUIAREMDETC_Venta = $venta;
                    $filter2->GUIAREMDETC_ITEM=$indice+1;
                    $filter2->GUIAREMDETC_Peso = "";
                    $filter2->GUIAREMDETC_GenInd = $detflag;
                    $filter2->GUIAREMDETC_Descripcion = strtoupper($descri);
                    $filter2->GUIAREMDETC_Observacion = strtoupper($observacionDet);
                    $filter2->ALMAP_Codigo=$codigoAlmacenProducto;
                    $filter2->show_details=$showDetails[$indice];

                    if ($guiarem_id == "") {
                    } else {
                        if($accion!="e"){
                            $this->guiaremdetalle_model->insertar($filter2);
                            $producto_id=$valor;
                            /**gcbq insertar serie de cada producto**/
                            if($flagGenInd[$indice]=='I'){
                                if($producto_id!=null){
                                    /**obtenemos las series de session por producto***/
                                    $seriesProducto=$this->session->userdata('serieReal');
                                    $serieReal = $seriesProducto;
                                    if ($seriesProducto!=null && count($seriesProducto) > 0 && $seriesProducto!= "") {
                                        /***pongo todos en estado cero de las series asociadas a ese producto**/
                                        $seriesProductoBD=$this->session->userdata('serieRealBD');
                                        $serieBD = $seriesProductoBD;
                                        if($serieBD!=null && count($serieBD)>0){
                                            foreach ($serieBD as $alm1BD => $arrAlmacenBD) {
                                                if($alm1BD==$codigoAlmacenProducto){
                                                    foreach ($arrAlmacenBD as $ind1BD => $arrserieBD){
                                                        if ($ind1BD == $producto_id) {
                                                            foreach ($arrserieBD as $keyBD => $valueBD) {
                                                                /**cambiamos a ewstado 0**/
                                                                $filterSerie== new stdClass();
                                                                if($tipo_oper == 'C'){
                                                                    $filterSerie->SERIC_FlagEstado='0';
                                                                    $this->serie_model->modificar($valueBD->SERIP_Codigo,$filterSerie);
                                                                }
                                                                $filterSerieD= new stdClass();
                                                                $filterSerieD->SERDOC_FlagEstado='0';
                                                                $this->seriedocumento_model->modificar($valueBD->SERDOC_Codigo,$filterSerieD);
                                                                
                                                                /**TIPO OPERACION VENTA SE DESHABILITAN LAS SERIES SELECCIONADAS POR EL COMPROBANTE**/
                                                                if($tipo_oper == 'V'){
                                                                    /**eliminamos los registros en estadoSeleccion cero:0:desleccionado**/
                                                                    $this->almacenproductoserie_model->seleccionarSerieBD($serieCodigo,0);
                                                                }
                                                                /**FIN DE DESELECCIONAR***/
                                                            }
                                                            break;
                                                        }
                                                    }
                                                    break;
                                                }
                                            }
                                        }
                                        /**fin de poner estado cero**/
                                        foreach ($serieReal  as $alm2 => $arrAlmacen2) {
                                            if($alm2==$codigoAlmacenProducto){
                                                foreach ($arrAlmacen2 as $ind2 => $arrserie2){
                                                    if ($ind2 == $producto_id) {
                                                        foreach ($arrserie2 as $i => $serie) {
                                                            /**INSERTAMOS EN SERIE**/
                                                            $filterSerie== new stdClass();
                                                            if($tipo_oper=='C'){
                                                                $filterSerie->PROD_Codigo=$producto_id;
                                                                $filterSerie->SERIC_Numero=$serie->serieNumero;
                                                                if($serie->serieCodigo!=null && $serie->serieCodigo!=0)
                                                                    $filterSerie->SERIC_FechaModificacion=date("Y-m-d H:i:s");
                                                                else
                                                                    $filterSerie->SERIC_FechaRegistro=date("Y-m-d H:i:s");
                                                                         
                                                                    $filterSerie->SERIC_FlagEstado='1';
                                                                    if($serie->serieCodigo!=null && $serie->serieCodigo!=0){
                                                                        $this->serie_model->modificar($serie->serieCodigo,$filterSerie);
                                                                        
                                                                        $filterSerieD= new stdClass();
                                                                        $filterSerieD->SERDOC_FlagEstado='1';
                                                                        $this->seriedocumento_model->modificar($serie->serieDocumentoCodigo,$filterSerieD);
                                                                    }else{
                                                                        $filterSerie->ALMAP_Codigo=$codigoAlmacenProducto;
                                                                        $codigoSerie=$this->serie_model->insertar($filterSerie);
                                                                        /**insertamso serie documento**/
                                                                        /**DOCUMENTO COMPROBANTE**/
                                                                        $filterSerieD= new stdClass();
                                                                        $filterSerieD->SERDOC_Codigo=null;
                                                                        $filterSerieD->SERIP_Codigo=$codigoSerie;
                                                                        /**10:documento guiaremision**/
                                                                        $filterSerieD->DOCUP_Codigo=10;
                                                                        $filterSerieD->SERDOC_NumeroRef=$guiarem_id;
                                                                        /**1:ingreso**/
                                                                        $filterSerieD->TIPOMOV_Tipo=1;
                                                                        $filterSerieD->SERDOC_FechaRegistro=date("Y-m-d H:i:s");
                                                                        $filterSerieD->SERDOC_FlagEstado='1';
                                                                        $this->seriedocumento_model->insertar($filterSerieD);
                                                                        /**FIN DE INSERTAR EN SERIE**/
                                                                    }
                                                            }
                                                            /**FIN DE INSERTAR EN SERIE**/
                                                            /**ACTUALIZAMOS  EN SERIE  CON EL DOCUMENTO Y NUMERO DE REFERENCIA**/
                                                            if($tipo_oper=='V'){
                                                                if($serie->serieDocumentoCodigo!=null && $serie->serieDocumentoCodigo!=0){
                                                                    $filterSerie->SERDOC_FlagEstado='1';
                                                                    $this->seriedocumento_model->modificar($serie->serieDocumentoCodigo,$filterSerie);
                                                                }else{
                                                                    /**insertamso serie documento**/
                                                                    /**DOCUMENTO COMPROBANTE**/
                                                                    $filterSerieD= new stdClass();
                                                                    $filterSerieD->SERDOC_Codigo=null;
                                                                    $filterSerieD->SERIP_Codigo=$serie->serieCodigo;
                                                                    $filterSerieD->DOCUP_Codigo=10;
                                                                    $filterSerieD->SERDOC_NumeroRef=$guiarem_id;
                                                                    /**2:ingreso**/
                                                                    $filterSerieD->TIPOMOV_Tipo=2;
                                                                    $filterSerieD->SERDOC_FechaRegistro=date("Y-m-d H:i:s");
                                                                    $filterSerieD->SERDOC_FlagEstado='1';
                                                                    $this->seriedocumento_model->insertar($filterSerieD);
                                                                    /**FIN DE INSERTAR EN SERIE**/
                                                                }
                                                                /**los registros en estadoSeleccion 1:seleccionado**/
                                                                $this->almacenproductoserie_model->seleccionarSerieBD($serie->serieCodigo,1);
                                                            }               
                                                        }
                                                        break;
                                                    }
                                                }
                                                break;
                                            }
                                        }
                                        //if($estado=='2'){
                                            if($tipo_oper == 'C'){
                                                /**eliminamos los registros en estado cero**/
                                                $this->seriedocumento_model->eliminarEstadoDocumentoSerie(10,$guiarem_id);
                                            }
                                            
                                            if($tipo_oper == 'V'){
                                                /**eliminamos los registros en estado cero solo de serieDocumento**/
                                                $this->seriedocumento_model->eliminarDocumento($guiarem_id,10);
                                            }
                                            
                                        //}
                                         
                                    }
                                }
                            }
                            /**fin de insertar serie**/
                        }else{
                            
                            $producto_id=$valor;
                            /**gcbq insertar serie de cada producto**/
                            if($flagGenInd[$indice]='I'){
                                /***pongo todos en estado cero de las series asociadas a ese producto**/
                                $seriesProductoBD=$this->session->userdata('serieRealBD');
                                $serieBD = $seriesProductoBD;
                                if($serieBD!=null && count($serieBD)>0){
                                    foreach ($serieBD as $alm1BD => $arrAlmaBD) {
                                        if($alm1BD ==$codigoAlmacenProducto){
                                            foreach ($arrAlmaBD as $ind1BD => $arrserieBD) {
                                                if ($ind1BD == $producto_id) {
                                                    foreach ($arrserieBD as $keyBD => $valueBD) {
                                                        $serieCodigo=$valueBD->SERIP_Codigo;
                                                        /**cambiamos a ewstado 0**/
                                                        $filterSerie== new stdClass();
                            
                                                        /**SI ES COMPRA SE MODIFICA EL ESTADO***/
                                                        if($tipo_oper == 'C'){
                                                            $filterSerie->SERIC_FlagEstado='0';
                                                            $this->serie_model->modificar($serieCodigo,$filterSerie);
                                                        }
                                                         
                                                        /**si es venta solamente cambia de estado seridocumento**/
                                                        $filterSerieD= new stdClass();
                                                        $filterSerieD->SERDOC_FlagEstado='0';
                                                        $this->seriedocumento_model->modificar($valueBD->SERDOC_Codigo,$filterSerieD);
                            
                                                        /**TIPO OPERACION VENTA SE DESHABILITAN LAS SERIES SELECCIONADAS POR EL COMPROBANTE**/
                                                        if($tipo_oper == 'V'){
                                                            /**eliminamos los registros en estadoSeleccion cero:0:desleccionado**/
                                                            $this->almacenproductoserie_model->seleccionarSerieBD($serieCodigo,0);
                                                        }
                                                        /**FIN DE DESELECCIONAR***/
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    if($tipo_oper == 'C'){
                                        /**eliminamos los registros en estado cero**/
                                        $this->seriedocumento_model->eliminarEstadoDocumentoSerie(10,$guiarem_id);
                                    }
                                    
                                    if($tipo_oper == 'V'){
                                        /**eliminamos los registros en estado cero solo de serieDocumento**/
                                        $this->seriedocumento_model->eliminarDocumento($guiarem_id,10);
                                    }
                            
                            
                            
                                }
                                /**fin de poner estado cero**/
                            }
                            $codigoDetalle=$detacodi[$indice];
                            if($codigoDetalle!=0 && trim($codigoDetalle)!=""){
                                if($estado!=null && $estado==2){
                                    $this->guiaremdetalle_model->eliminar($codigoDetalle);

                                }else{
                                    $objetoM=new stdClass();
                                    $objetoM->GUIAREMDETC_FlagEstado=0;
                                    $this->guiaremdetalle_model->modificar($codigoDetalle,$objetoM);
                                   
                                }
                                 
                            }
                            
                        }
                    }

                    //$this->cotizacion_model->modificar_detcotizacion_flagCompra($detcotizacion->COTDEP_Codigo);
    
                }
            }
            
        }
        exit('{"result":"ok", "codigo":"' . $guiarem_id . '"}');
    }
    

    

    
    

    public function ConsultarGuiaElectronica( $codigo ){

        $datos_guiarem = $this->guiarem_model->obtener($codigo);
        $serie = trim($datos_guiarem[0]->GUIAREMC_Serie);
        $numero = trim($datos_guiarem[0]->GUIAREMC_Numero);

        $compania = $datos_guiarem[0]->COMPP_Codigo;               
        $deftoken = $this->tokens->deftoken("$compania");

        $ruta = $deftoken['ruta'];
        $token = $deftoken['token'];
        
        $tipo_de_comprobante = 5;
        $serieFac = $serie;
        
        $data2 = array(
            "operacion"             => "consultar_guia",
            "tipo_de_comprobante"   => "${tipo_de_comprobante}",
            "serie"                 => "${serieFac}",
            "numero"                => "${numero}"
        );
        $data_json = json_encode($data2);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt(
        $ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Token token="'.$token.'"',
            'Content-Type: application/json',
            )
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta  = curl_exec($ch);
        $respuesta2 = json_decode($respuesta);
        curl_close($ch);     
        $filter2 = new stdClass();
        $exito = false;
        /*
        {
             "tipo_de_comprobante": 1,
             "serie": "FFF1",
             "numero": 1,
             "enlace": "https://www.nubefact.com/cpe/d268f882-4554-a403c6712e6",
             "enlace_del_pdf": "",
             "enlace_del_xml": "",
             "enlace_del_cdr": "",
             "aceptada_por_sunat": true,
             "sunat_description": "La Factura numero FFF1-1, ha sido aceptada",
             "sunat_note": null,
             "sunat_responsecode": "0",
             "sunat_soap_error": "",
             "cadena_para_codigo_qr": "20600695771 | 01 | FFF1 | 000001 | ...",
             "codigo_hash": "xMLFMnbgp1/bHEy572RKRTE9hPY="
            }
        */
        
        if ( !isset($respuesta2->errors) && $respuesta2->enlace_del_pdf != NULL ){
            $filter2->respuestas_GuiaRem = $codigo;
            $filter2->respuestas_compañia = $compania;
            $filter2->respuestas_tipoDocumento = $tipo_de_comprobante; 
            $filter2->respuestas_serie = $respuesta2->serie;    
            $filter2->respuestas_numero = $respuesta2->numero;
            $filter2->respuestas_enlace = $respuesta2->enlace;
            $filter2->respuestas_aceptadaporsunat = $respuesta2->aceptada_por_sunat;
            $filter2->respuestas_sunatdescription = $respuesta2->sunat_description;
            $filter2->respuestas_sunatnote = $respuesta2->sunat_note;
            $filter2->respuestas_sunatresponsecode = $respuesta2->sunat_responsecode;
            $filter2->respuestas_sunatsoaperror = $respuesta2->sunat_soap_error;
            $filter2->respuestas_cadenaparacodigoqr = $respuesta2->cadena_para_codigo_qr;
            $filter2->respuestas_codigohash = $respuesta2->codigo_hash;
            $filter2->respuestas_enlacepdf = $respuesta2->enlace_del_pdf;
            $filter2->respuestas_enlacexml = $respuesta2->enlace_del_xml;
            $filter2->respuestas_enlacecdr = $respuesta2->enlace_del_cdr;
            $exito = true;
            $this->comprobante_model->insertar_respuestaSunat($filter2);
        }
        else{
            $exito = false;
        }

        return $exito;
    }


    public function buscar_guias_x_orden($tipo_oper, $orden)
    {

        $datosOrden = $this->ocompra_model->obtener_ocompra($orden);
        $lista = array();
        $data = array();
        if (count($datosOrden) > 0) {
            switch ($tipo_oper) {
                case 'C':
                    $data = $this->guiarem_model->buscar_x_orden('C', 'C', $datosOrden[0]->OCOMP_Codigo);
                    break;
                case 'V':
                    $data = $this->guiarem_model->buscar_x_orden('V', 'V', $datosOrden[0]->OCOMP_Codigo);
                    break;
            }
        }

        if (count($data) > 0) {

            foreach ($data as $value) {

                $filter = new stdClass();

                $filter->codigo = $value->GUIAREMP_Codigo;

                $filter->serie = $value->GUIAREMC_Serie;

                $filter->numero = $value->GUIAREMC_Numero;

                if ($tipo_oper == 'C') {

                    $razon = $this->proveedor_model->obtener($value->PROVP_Codigo);

                } else if ($tipo_oper == 'C') {

                    $razon = $this->cliente_model->obtener($value->CLIP_Codigo);

                }

                $filter->razon = $razon->nombre;

                $filter->total = $value->GUIAREMDETC_Total;

                //print_r($filter);exit;

                $lista[] = $filter;

            }

        }

        echo json_encode($lista);

    }

    public function ver_guias_x_orden_producto($tipo_orden, $tipo_guia, $cod_orden, $cod_prod){
        $guias = $this->guiarem_model->buscar_x_producto_orden($tipo_orden, $tipo_guia, $cod_orden, $cod_prod);
        $producto = $this->producto_model->obtener_producto($cod_prod);
        $lista_detalles = array();

        if (count($guias) > 0) {

            foreach ($guias as $key => $value) {
                $serie = $value->GUIAREMC_Serie;
                $numero = $value->GUIAREMC_Numero;
                $fecha = mysql_to_human($value->GUIAREMC_Fecha);
                if ($value->PROVP_Codigo != '')
                    $datos_prove = $this->proveedor_model->obtener($value->PROVP_Codigo);
                else
                    $datos_prove = $this->cliente_model->obtener($value->CLIP_Codigo);

                $razon = $datos_prove->nombre;
                $cantidad = $value->GUIAREMDETC_Cantidad;
                $objeto = new stdClass();
                $objeto->serie = $serie;
                $objeto->numero = $numero;
                $objeto->fecha = $fecha;
                $objeto->cantidad = $cantidad;
                $objeto->razon = $razon;
                $lista_detalles[] = $objeto;

            }

        }


        $data['lista_detalles'] = $lista_detalles;
        $data['producto'] = $producto;
        $this->load->view("almacen/guiarem_x_orden_producto", $data);

    }


    public function eliminar()
    {

        $guiarem_id = $this->input->post('codigo');
        $guiarem = $this->guiarem_model->obtener($guiarem_id);
        $guiasa_id = $guiarem[0]->GUIASAP_Codigo;
        $this->guiaremdetalle_model->eliminar2($guiarem_id);
        $this->guiarem_model->eliminar($guiarem_id);
        $this->guiasadetalle_model->eliminar2($guiasa_id);
        $this->guiasa_model->eliminar($guiasa_id);
        echo true;

    }


    public function obtener_detalle_guiarem($guiarem, $tipo_oper = 'V', $almacen = 1)
    {

        $detalle = $this->guiaremdetalle_model->listar($guiarem);
        $lista_detalles = array();
        $datos_guiarem = $this->guiarem_model->obtener($guiarem);
        $moneda = $datos_guiarem[0]->MONED_Codigo;
        $serie = $datos_guiarem[0]->GUIAREMC_Serie;
        $numero = $datos_guiarem[0]->GUIAREMC_Numero;
        $codigo_usuario = $datos_guiarem[0]->GUIAREMC_CodigoUsuario;
        $cliente = $datos_guiarem[0]->CLIP_Codigo;
        $proveedor = $datos_guiarem[0]->PROVP_Codigo;
        if ($tipo_oper == 'V'){
            $datos = $this->cliente_model->obtener($cliente);
            $ordenVenta = (!is_null($datos_guiarem[0]->OCOMP_Codigo))?$datos_guiarem[0]->OCOMP_Codigo:"";
        }
        else if ($tipo_oper == 'C')
            $datos = $this->proveedor_model->obtener($proveedor);

        if ($datos) {
            $ruc = $datos->ruc;
            $razon_social = $datos->nombre;
        } else {
            $ruc = "";
            $razon_social = "";
        }


        if (count($detalle) > 0) {
            
            foreach ($detalle as $indice => $valor) {
                $detacod = $valor->GUIAREMDETP_Codigo;
                $producto = $valor->PRODCTOP_Codigo;
                $unidad_medida = $valor->UNDMED_Codigo;
                $cantidad = $valor->GUIAREMDETC_Cantidad;
                $flagGenInd = $valor->GUIAREMDETC_GenInd;
                $pu = $valor->GUIAREMDETC_Pu;
                $subtotal = $valor->GUIAREMDETC_Subtotal;
                $igv = $valor->GUIAREMDETC_Igv;
                $descuento = $valor->GUIAREMDETC_Descuento;
                $total = $valor->GUIAREMDETC_Total;
                $pu_conigv = $valor->GUIAREMDETC_Pu_ConIgv;
                $datos_producto = $this->producto_model->obtener_producto($producto);
                $codigo_interno = $datos_producto[0]->PROD_CodigoInterno;
                $flagBS = $datos_producto[0]->PROD_FlagBienServicio;
                $costo = $datos_producto[0]->PROD_UltimoCosto;
                $almacenProducto = $datos_guiarem[0]->ALMAP_Codigo;
                $datos_almaprod = $this->almacenproducto_model->obtener($almacen, $producto);
                if ($datos_almaprod)
                    $stock = $datos_almaprod[0]->ALMPROD_Stock;
                else
                    $stock = "";

                $nombre_producto = str_replace('"', "''", $valor->GUIAREMDETC_Descripcion);
                $datos_umedida = $this->unidadmedida_model->obtener($unidad_medida);
                $nombre_unidad = $datos_umedida[0]->UNDMED_Descripcion;

               
                $objeto = new stdClass();
                $objeto->GUIAREMDETP_Codigo = $detacod;
                $objeto->PROD_Codigo = $producto;
                $objeto->PROD_CodigoInterno = $codigo_interno;
                $objeto->UNDMED_Codigo = $unidad_medida;
                $objeto->UNDMED_Descripcion = $nombre_unidad;
                $objeto->PROD_Nombre = $nombre_producto;
                $objeto->GUIAREMDETC_Cantidad = $cantidad;
                $objeto->GUIAREMDETC_Pu = $pu;
                $objeto->GUIAREMDETC_Subtotal = $subtotal;
                $objeto->GUIAREMDETC_Descuento = $descuento;
                $objeto->GUIAREMDETC_Igv = $igv;
                $objeto->GUIAREMDETC_Total = $total;
                $objeto->GUIAREMDETC_Pu_ConIgv = $pu_conigv;
                $objeto->Ruc = $ruc;
                $objeto->RazonSocial = $razon_social;
                $objeto->CLIP_Codigo = $cliente;
                $objeto->PROVP_Codigo=$proveedor;
                $objeto->MONED_Codigo = $moneda;
                $objeto->GUIAREMC_Serie = $serie;
                $objeto->GUIAREMC_Numero = $numero;
                $objeto->GUIAREMC_CodigoUsuario = $codigo_usuario;
                $objeto->ALMAP_Codigo =$almacenProducto;
                $objeto->GUIAREMDETC_GenInd =$flagGenInd;
                $objeto->OCOMP_Codigo = (isset($ordenVenta))?$ordenVenta:"";
                
                $objeto->onclick = $producto . ",'" . $codigo_interno . "','" . $nombre_producto . "'," . $cantidad . ",'" . $flagBS . "','" . $flagGenInd . "'," . $unidad_medida . ",'" . $nombre_unidad . "'," . $pu_conigv . "," . $pu . "," . $subtotal . "," . $igv . "," . $total . "," . $stock . "," . $costo;
                $lista_detalles[] = $objeto;
            }

        } else {

            $objeto = new stdClass();
            $objeto->GUIAREMDETP_Codigo = '';
            $objeto->Ruc = $ruc;
            $objeto->RazonSocial = $razon_social;
            $objeto->CLIP_Codigo = $cliente;
            $objeto->MONED_Codigo = $moneda;
            $objeto->GUIAREMC_Serie = $serie;
            $objeto->GUIAREMC_Numero = $numero;
            $objeto->GUIAREMC_CodigoUsuario = $codigo_usuario;
            $objeto->OCOMP_Codigo = (isset($ordenVenta))?$ordenVenta:"";
            $lista_detalles[] = $objeto;
        }
        $resultado = json_encode($lista_detalles);
        echo $resultado;

    }

    public function guiarem_ver_pdf($codigo, $formato = 'a4', $imagen = 0){

        switch ($formato) {
            case 'a4':
                    $this->lib_props->guiarem_pdf($codigo, $imagen);
                    #$this->guiarem_ver_pdf_a4($codigo, $imagen);
                break;
        }
    }

    public function guiarem_descarga_excel($codigo){
        $this->lib_props->guiarem_descarga_excel($codigo);
    }

    public function guiarem_ver_pdf_a4_pdf($codigo, $flagPdf = 0){

        $this->load->model('almacen/almacen_model');

        /* Datos principales */

        $hoy = date("Y-m-d");

        $datos_guiarem = $this->guiarem_model->obtener($codigo);
        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;
        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;
        $tipo_oper = $datos_guiarem[0]->GUIAREMC_TipoOperacion;
        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;
        $almacen = $datos_guiarem[0]->ALMAP_Codigo;
        $usuario = $datos_guiarem[0]->USUA_Codigo;
        $moneda = $datos_guiarem[0]->MONED_Codigo;
        $referencia = $datos_guiarem[0]->DOCUP_Codigo;
        $cliente = $datos_guiarem[0]->CLIP_Codigo;
        $proveedor = $datos_guiarem[0]->PROVP_Codigo;
        $recepciona_nombres = $datos_guiarem[0]->GUIAREMC_PersReceNombre;
        $recepciona_dni = $datos_guiarem[0]->GUIAREMC_PersReceDNI;
        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;
        $numero_ocompra = $datos_guiarem[0]->GUIAREMC_OCompra;
        $serie = $datos_guiarem[0]->GUIAREMC_Serie;
        $numero = $datos_guiarem[0]->GUIAREMC_Numero;
        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;
        $codigo_usuario = $datos_guiarem[0]->GUIAREMC_CodigoUsuario;
        $fecha = $datos_guiarem[0]->GUIAREMC_Fecha;
        $fecha_traslado = $datos_guiarem[0]->GUIAREMC_FechaTraslado;
        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;
        $placa = $datos_guiarem[0]->GUIAREMC_Placa;
        $marca = $datos_guiarem[0]->GUIAREMC_Marca;
        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;
        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;
        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;
        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;
        $ocompra = $datos_guiarem[0]->OCOMP_Codigo;
        $estado = $datos_guiarem[0]->GUIAREMC_FlagEstado;
        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;
        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;

        $tipo_movimiento = $this->tipomovimiento_model->obtener($tipo_movimiento);
        $movimiento_descripcion = $tipo_movimiento[0]->TIPOMOVC_Descripcion; 

        $fecha_traslado = mysql_to_human($fecha_traslado);
        $nFechaTraslado = explode( '/', $fecha_traslado );

        $fechaTraslado = ($datos_guiarem[0]->GUIAREMC_FechaTraslado == "" || $datos_guiarem[0]->GUIAREMC_FechaTraslado == NULL || $datos_guiarem[0]->GUIAREMC_FechaTraslado == "-") ? "" : $nFechaTraslado[0]." de ".ucfirst( strtolower($this->lib_props->mesesEs($nFechaTraslado[1])) )." del ".$nFechaTraslado[2];

        $fecha = mysql_to_human($fecha);
        $nFecha = explode( '/', $fecha );

        $fecha = ($datos_guiarem[0]->GUIAREMC_Fecha == "" || $datos_guiarem[0]->GUIAREMC_Fecha == NULL || $datos_guiarem[0]->GUIAREMC_Fecha == "-") ? "" : $nFecha[0]." de ".ucfirst( strtolower($this->lib_props->mesesEs($nFecha[1])) )." del ".$nFecha[2];

        $datos_moneda = $this->moneda_model->obtener($moneda);

        $nombre_almacen = '';
        if ($almacen != '') {
            $datos_almacen = $this->almacen_model->obtener($almacen);
            $nombre_almacen = $datos_almacen[0]->ALMAC_Descripcion;
        }

        $simbolo_moneda = $datos_moneda[0]->MONED_Simbolo;
        $moneda_nombre = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Descripcion : 'SOLES');

        if ($tipo_oper == 'C') {
            $datos_proveedor = $this->proveedor_model->obtener($proveedor);
            $nombres = $datos_proveedor->nombre;
            $ruc = $datos_proveedor->ruc;
            $telefono = $datos_proveedor->telefono;
            $direccion = $datos_proveedor->direccion;
            $fax = $datos_proveedor->fax;
        } else {
            $datos_cliente = $this->cliente_model->obtener($cliente);
            $nombres = $datos_cliente->nombre;
            $ruc = $datos_cliente->ruc;
            $telefono = $datos_cliente->telefono;
            $direccion = $datos_cliente->direccion;
            $fax = $datos_cliente->fax;
        }

        $transporte = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);
        
        $this->load->library("tcpdf");
        $medidas = "a4"; // a4 - carta
        $this->pdf = new pdfGuiaRemision('P', 'mm', $medidas, true, 'UTF-8', false);
        $this->pdf->SetTitle('GUIA REMISION '.$serie.'-'.$numero);
        $this->pdf->SetMargins(20, 42, 12); // Cada 10 es 1cm - Como es hoja estoy tratando las medidad en cm -> Rawil
        #$this->pdf->SetFont('dotricei', '', 7);
        $this->pdf->SetFont('dotricei', '', 7);
        if ($flagPdf == 1)
            $this->pdf->setPrintHeader(true);
        else
            $this->pdf->setPrintHeader(false);

        $this->pdf->setPrintFooter(false);
        $this->pdf->SetAutoPageBreak(false, 0);
        $this->pdf->AddPage();

        
        /* Listado de detalles */
            $detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);
            $detaProductos = '';
            foreach ($detalle_guiarem as $indice => $valor) {
                    $detacodi = $valor->GUIAREMDETP_Codigo;
                    $producto = $valor->PRODCTOP_Codigo;
                    $unidad = $valor->UNDMED_Codigo;
                    $cantidad = $valor->GUIAREMDETC_Cantidad;
                    $pu = $valor->GUIAREMDETC_Pu;
                    $subtotal = $valor->GUIAREMDETC_Subtotal;
                    $igv = $valor->GUIAREMDETC_Igv;
                    $descuento = $valor->GUIAREMDETC_Descuento;
                    $total = $valor->GUIAREMDETC_Total;
                    $pu_conigv = $valor->GUIAREMDETC_Pu_ConIgv;
                    $costo = $valor->GUIAREMDETC_Costo;
                    $venta = $valor->GUIAREMDETC_Venta;
                    $peso = $valor->GUIAREMDETC_Peso;
                    $GenInd = $valor->GUIAREMDETC_GenInd;

                    $datos_producto = $this->producto_model->obtener_producto($producto);
                    $nombre_producto = $valor->GUIAREMDETC_Descripcion . " <br>" . $valor->GUIAREMDETC_Observacion;
                    $codigo_usuario = $datos_producto[0]->PROD_CodigoUsuario;
                    
                $nomprod = $nombre_producto;
                $nomprod = ($GenInd == 'I') ? $nomprod.$this->ObtenerSeriesComprobante($codigo,$tipo_docu,$producto) : $nomprod;
                
                $unidadMedida = $this->unidadmedida_model->obtener($valor->UNDMED_Codigo);
                $medidaDetalle = "";
                $medidaDetalle = ($unidadMedida[0]->UNDMED_Simbolo != "") ? $unidadMedida[0]->UNDMED_Simbolo : "ZZ";

                    $detaProductos = $detaProductos. '<tr>
                        <td style="line-height:0.30cm; text-align:center;">'.$valor->GUIAREMDETC_Cantidad.'</td>
                        <td style="line-height:0.30cm; text-align:center;">'.$codigo_usuario.'</td>
                        <td style="line-height:0.30cm; text-align:left;">'.$nomprod.'</td>
                        <td style="line-height:0.30cm; text-align:right;">'.number_format($pu,2).'</td>
                        <td style="line-height:0.30cm; text-align:right;">'.number_format($total,2).'</td>
                    </tr>';
            }

        $this->pdf->SetY(44);
        $this->pdf->SetX(45);
            $guiaRemHTML = '<table style="text-align:center;" border="0">
                            <tr>
                                <td style="width:11cm;"></td>
                                <td style="width:2.5cm; font-weight:bold; text-align:center; font-size:10pt; color:#000;">'.$this->lib_props->getOrderNumeroSerie($numero).'</td>
                            </tr>
                        </table>
                        ';
        $this->pdf->writeHTML($guiaRemHTML,true,false,true,'');

        $comprobanteRelacionado = ($numero_ref != '') ? '<tr>
                                                            <td style="width:4cm; font-style:italic;">FACTURA / BOLETA</td>
                                                            <td style="text-align:left;">'.$numero_ref.'</td>
                                                        </tr>' : '';

        $fechaHTML = '<table border="0">
                        <tr>
                            <td style="width:6.5cm"></td>
                            <td>'.$fecha.'</td>
                        </tr>
                    </table>';
        $this->pdf->SetY(50.5);
        $this->pdf->writeHTML($fechaHTML,false,false,true,'');

        $tpCliente = ($tipo_oper == "V") ? "DESTINATARIO" : "PROVEEDOR";
        $clienteHTML = '<table cellpadding="0.1cm" border="0">
                            <tr>
                                <td style="line-height:0.30cm; width:2cm;"></td>
                                <td style="line-height:0.30cm; width:9.8cm;">'.substr($punto_partida, 0, 170).'</td>
                                <td style="line-height:0.30cm; width:6cm; text-indent:1.3cm; font-size:10pt;">'.$ruc.'</td>
                            </tr>
                        </table>';
        $posY = 57; // PUNTO PARTIDA - RUC
        $this->pdf->SetY($posY);
        $this->pdf->writeHTML($clienteHTML,false,false,true,'');

        $clienteHTML = '<table cellpadding="0.1cm" border="0">
                            <tr>
                                <td style="line-height:0.30cm; width:1cm;"></td>
                                <td style="line-height:0.30cm; width:10.8cm;">'.substr($nombres, 0 ,170).'</td>
                                <td style="line-height:0.30cm; width:6cm; text-indent:1.3cm;"></td>
                            </tr>
                        </table>';
        $posY += 5.8; // SEÑORES
        $this->pdf->SetY($posY);
        $this->pdf->writeHTML($clienteHTML,false,false,true,'');

        $clienteHTML = '<table cellpadding="0.1cm" border="0">
                            <tr> 
                                <td style="line-height:0.30cm; width:2cm;"></td>
                                <td style="line-height:0.30cm; width:9.8cm;">'.substr($punto_llegada, 0 ,170).'</td>
                                <td style="line-height:0.30cm; width:6cm; text-indent:1.3cm; font-size:10pt;">'.$referencia.'</td>
                            </tr>
                        </table>';
        $posY += 5.8; // PUNTO LLEGADA - OC
        $this->pdf->SetY($posY);
        $this->pdf->writeHTML($clienteHTML,false,false,true,'');

        $clienteHTML = '<table cellpadding="0.1cm" border="0">
                            <tr> 
                                <td style="line-height:0.30cm; width:3cm;"></td>
                                <td style="line-height:0.30cm; width:8.8cm;">'.substr($transporte[0]->EMPRC_RazonSocial, 0 ,85).'</td>
                                <td style="line-height:0.30cm; width:6cm; text-indent:1.3cm;"></td>
                            </tr>
                        </table>';
        $posY += 6.5; // EMPRESA TRANSPORTE
        $this->pdf->SetY($posY);
        $this->pdf->writeHTML($clienteHTML,false,false,true,'');

        $clienteHTML = '<table cellpadding="0.1cm" border="0">
                            <tr> 
                                <td style="line-height:0.30cm; width:3cm;"></td>
                                <td style="line-height:0.30cm; width:8.8cm;">'.substr($transporte[0]->EMPRC_RazonSocial, 0 ,85).'</td>
                                <td style="line-height:0.30cm; width:6cm; text-indent:1.3cm;"></td>
                            </tr>
                        </table>';
        $posY += 6; // NOMBRE O RAZON SOCIAL - CIUDAD
        $this->pdf->SetY($posY);
        $this->pdf->writeHTML($clienteHTML,false,false,true,'');

        $clienteHTML = '<table cellpadding="0.1cm" border="0">
                            <tr> 
                                <td style="line-height:0.30cm; width:0.8cm;"></td>
                                <td style="line-height:0.30cm; width:11cm;">'.substr($transporte[0]->EMPRC_Direccion, 0, 170).'</td>
                                <td style="line-height:0.30cm; width:6cm; text-indent:1.3cm;">'.$transporte[0]->EMPRC_Telefono.'</td>
                            </tr>
                        </table>';
        $posY += 5.5; // DIRECCION - TELEFONO
        $this->pdf->SetY($posY);
        $this->pdf->writeHTML($clienteHTML,false,false,true,'');

        $clienteHTML = '<table cellpadding="0.1cm" border="0">
                            <tr> 
                                <td style="line-height:0.30cm; width:3.2cm;"></td>
                                <td style="line-height:0.30cm; width:7cm;">'.$marca.' '.$placa.'</td>
                                <td style="line-height:0.30cm; width:7.6cm; text-indent:4.2cm;">'.$licencia.'</td>
                            </tr>
                        </table>';
        $posY += 6.8; // MARCA Y PLACA - LICENCIA
        $this->pdf->SetY($posY);
        $this->pdf->writeHTML($clienteHTML,true,false,true,'');

        $this->pdf->SetY(105);
        $this->pdf->SetX(20);
        $productoHTML = '<table border="0" cellpadding="0.0cm" cellpadding="0.0cm">
                    <tr>
                        <td style="width:1.3cm; text-align:center;"></td>
                        <td style="width:2.2cm; text-align:left;"></td>
                        <td style="width:9.8cm; text-align:center;"></td>
                        <td style="width:1.8cm; text-align:center;"></td>
                        <td style="width:2.3cm; text-align:center;"></td>
                    </tr>
                    '.$detaProductos.'
                </table>';
        $this->pdf->writeHTML($productoHTML,false,false,true,'');

        $movimientoHTML = '<table border="0">
                        <tr>
                            <td style="width:8cm"></td>
                            <td>'.$tipo_movimiento[0]->TIPOMOVP_Codigo.'</td>
                        </tr>
                    </table>';
        $this->pdf->SetY(-6);
        $this->pdf->writeHTML($movimientoHTML,false,false,true,'');


        if ($flagPdf == 0){
            #$this->pdf->Output('guiaRemision.pdf', 'D');
            $this->pdf->Output('guiaRemision.pdf', 'I');
        }
        else
            $this->pdf->Output('guiaRemision.pdf', 'I');
    }

    public function guiarem_ver_pdf_a4($codigo, $flagPdf = 0){

        if ($flagPdf == 1){
            $this->guiarem_ver_pdf_a4_pdf($codigo, $flagPdf);
            exit();
        }

        $this->load->model('almacen/almacen_model');

        /* Datos principales */

        $hoy = date("Y-m-d");

        $datos_guiarem = $this->guiarem_model->obtener($codigo);
        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;
        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;
        $tipo_oper = $datos_guiarem[0]->GUIAREMC_TipoOperacion;
        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;
        $almacen = $datos_guiarem[0]->ALMAP_Codigo;
        $usuario = $datos_guiarem[0]->USUA_Codigo;
        $moneda = $datos_guiarem[0]->MONED_Codigo;
        $referencia = $datos_guiarem[0]->DOCUP_Codigo;
        $cliente = $datos_guiarem[0]->CLIP_Codigo;
        $proveedor = $datos_guiarem[0]->PROVP_Codigo;
        $recepciona_nombres = $datos_guiarem[0]->GUIAREMC_PersReceNombre;
        $recepciona_dni = $datos_guiarem[0]->GUIAREMC_PersReceDNI;
        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;
        $numero_ocompra = $datos_guiarem[0]->GUIAREMC_OCompra;
        $serie = $datos_guiarem[0]->GUIAREMC_Serie;
        $numero = $datos_guiarem[0]->GUIAREMC_Numero;
        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;
        $codigo_usuario = $datos_guiarem[0]->GUIAREMC_CodigoUsuario;
        $fecha = $datos_guiarem[0]->GUIAREMC_Fecha;
        $fecha_traslado = $datos_guiarem[0]->GUIAREMC_FechaTraslado;
        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;
        $placa = $datos_guiarem[0]->GUIAREMC_Placa;
        $marca = $datos_guiarem[0]->GUIAREMC_Marca;
        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;
        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;
        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;
        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;
        $ocompra = $datos_guiarem[0]->OCOMP_Codigo;
        $estado = $datos_guiarem[0]->GUIAREMC_FlagEstado;
        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;
        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;

        $tipo_movimiento = $this->tipomovimiento_model->obtener($tipo_movimiento);
        $movimiento_descripcion = $tipo_movimiento[0]->TIPOMOVC_Descripcion; 

        $fecha_traslado = mysql_to_human($fecha_traslado);
        $nFechaTraslado = explode( '/', $fecha_traslado );

        $fechaTraslado = ($datos_guiarem[0]->GUIAREMC_FechaTraslado == "" || $datos_guiarem[0]->GUIAREMC_FechaTraslado == NULL || $datos_guiarem[0]->GUIAREMC_FechaTraslado == "-") ? "" : $nFechaTraslado[0]." de ".ucfirst( strtolower($this->lib_props->mesesEs($nFechaTraslado[1])) )." del ".$nFechaTraslado[2];

        $fecha = mysql_to_human($fecha);
        $nFecha = explode( '/', $fecha );

        $fecha = ($datos_guiarem[0]->GUIAREMC_Fecha == "" || $datos_guiarem[0]->GUIAREMC_Fecha == NULL || $datos_guiarem[0]->GUIAREMC_Fecha == "-") ? "" : $nFecha[0]."-".ucfirst( substr( strtolower($this->lib_props->mesesEs($nFecha[1])), 0, 3) )."-".$nFecha[2];

        $datos_moneda = $this->moneda_model->obtener($moneda);

        $nombre_almacen = '';
        if ($almacen != '') {
            $datos_almacen = $this->almacen_model->obtener($almacen);
            $nombre_almacen = $datos_almacen[0]->ALMAC_Descripcion;
        }

        $simbolo_moneda = $datos_moneda[0]->MONED_Simbolo;
        $moneda_nombre = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Descripcion : 'SOLES');

        if ($tipo_oper == 'C') {
            $datos_proveedor = $this->proveedor_model->obtener($proveedor);
            $nombres = $datos_proveedor->nombre;
            $ruc = $datos_proveedor->ruc;
            $telefono = $datos_proveedor->telefono;
            $direccion = $datos_proveedor->direccion;
            $fax = $datos_proveedor->fax;
        } else {
            $datos_cliente = $this->cliente_model->obtener($cliente);
            $nombres = $datos_cliente->nombre;
            $ruc = $datos_cliente->ruc;
            $telefono = $datos_cliente->telefono;
            $direccion = $datos_cliente->direccion;
            $fax = $datos_cliente->fax;
        }

        $transporte = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);
        
        #$this->load->library("tcpdf");
        #$medidas = "a4"; // a4 - carta
        #$this->pdf = new pdfGuiaRemision('P', 'mm', $medidas, true, 'UTF-8', false);
        #$this->pdf->SetTitle('GUIA REMISION '.$serie.'-'.$numero);
        #$this->pdf->SetMargins(20, 42, 12); // Cada 10 es 1cm - Como es hoja estoy tratando las medidad en cm -> Rawil
        ##$this->pdf->SetFont('dotricei', '', 7);
        #$this->pdf->SetFont('dotricei', '', 7);
        #if ($flagPdf == 1)
        #    $this->pdf->setPrintHeader(true);
        #else
        #    $this->pdf->setPrintHeader(false);
        #$this->pdf->setPrintFooter(false);
        #$this->pdf->SetAutoPageBreak(false, 0);
        #$this->pdf->AddPage();

        $archivo = 'GUIAREMISION.txt';
        if ( !unlink($archivo) ){
            if ( !unlink($archivo) ){
                echo "El documento no esta disponible, intentelo nuevamente.";
                exit();
            }
        }

        $handler = fopen($archivo,'a');
        
        /* Listado de detalles */
            $detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);
            $detaProductos = '';
            
        #$this->pdf->SetY(47.7);
        #$this->pdf->SetX(45);
            $guiaRemHTML = ''.$this->lib_props->getOrderNumeroSerie($numero).'';
        #$this->pdf->writeHTML($guiaRemHTML,true,false,true,'');

            $h = "<span style='line-height:5pt;'>".chr(13).chr(10)." </span>";

            fputs($handler,chr(13).chr(10));
            fputs($handler,chr(13).chr(10));
            fputs($handler,chr(13).chr(10));
            fputs($handler,chr(13).chr(10));
            fputs($handler,chr(13).chr(10));
            fputs($handler,chr(13).chr(10));
            fputs($handler,chr(13).chr(10));
            fputs($handler,chr(13).chr(10));
            fputs($handler,chr(13).chr(10));
            fputs($handler,chr(13).chr(10));
            fputs($handler,$h);
                fputs($handler,str_pad($guiaRemHTML, 75, " ", STR_PAD_LEFT));
            fputs($handler,chr(13).chr(10));
                
        $comprobanteRelacionado = ($numero_ref != '') ? ' '.$numero_ref.' ' : '';

        $fechaHTML = $fecha;

                fputs($handler,str_pad(" ", 38, " ", STR_PAD_LEFT));
                fputs($handler,$fechaHTML);
                fputs($handler,chr(13).chr(10));
                fputs($handler,chr(13).chr(10));

        $tpCliente = ($tipo_oper == "V") ? "DESTINATARIO" : "PROVEEDOR";
        $clienteHTML = str_pad('               '.substr($punto_partida, 0, 50), 50, " ").'            '.$ruc.' ';
        #$posY = 57; // PUNTO PARTIDA - RUC

                fputs($handler,$clienteHTML);
                fputs($handler,chr(13).chr(10));
                if ( strlen($punto_partida) > 50 ){
                    $clienteHTML = str_pad('               '.substr($punto_partida, 50, 90), 50, " ");
                    fputs($handler,$clienteHTML);
                }
                fputs($handler,chr(13).chr(10));

        #$posY += 5.8; // SEÑORES

                $clienteHTML = str_pad('         '.substr($nombres, 0, 50), 50, " ");
                fputs($handler,$clienteHTML);
                fputs($handler,$h);

        #$clienteHTML = ' '.substr($punto_llegada, 0 ,170).' '.$referencia.' ';
        #$posY += 5.8; // PUNTO LLEGADA - OC

                $clienteHTML = str_pad('               '.substr($punto_llegada, 0, 50), 50, " ").'        '.$referencia.' ';
                fputs($handler,$clienteHTML);
                fputs($handler,chr(13).chr(10));
                if ( strlen($punto_llegada) > 50 ){
                    $clienteHTML = str_pad('               '.substr($punto_llegada, 50, 90), 50, " ");
                    fputs($handler,$clienteHTML);
                }
                fputs($handler,chr(13).chr(10));

        #$posY += 6.5; // EMPRESA TRANSPORTE

                $clienteHTML = str_pad('                    '.substr($transporte[0]->EMPRC_RazonSocial, 0, 50), 50, " ");
                fputs($handler,$clienteHTML);
                fputs($handler,chr(13).chr(10));
                fputs($handler,chr(13).chr(10));

        #$posY += 6; // NOMBRE O RAZON SOCIAL - CIUDAD
        #$clienteHTML = ' '.substr($transporte[0]->EMPRC_Direccion, 0, 170).' '.$transporte[0]->EMPRC_Telefono.' ';

                $clienteHTML = str_pad('          '.substr($transporte[0]->EMPRC_Direccion, 0, 55), 50, " ");
                fputs($handler,$clienteHTML);
                $clienteHTML = str_pad('             '.substr($transporte[0]->EMPRC_Telefono, 0, 14), 20, " ", STR_PAD_LEFT);
                fputs($handler,$clienteHTML);
                fputs($handler,chr(13).chr(10));
                if ( strlen($transporte[0]->EMPRC_Direccion) > 50 ){
                    $clienteHTML = str_pad('          '.substr($transporte[0]->EMPRC_Direccion, 55, 100), 50, " ");
                    fputs($handler,$clienteHTML);
                }
                fputs($handler,chr(13).chr(10));

        #$clienteHTML = ' '.$marca.' '.$placa.' '.$licencia.' ';
        #$posY += 6.8; // MARCA Y PLACA - LICENCIA
        #$this->pdf->SetY($posY);
        #$this->pdf->writeHTML($clienteHTML,true,false,true,'');

                $clienteHTML = str_pad('                     '.$marca.'   '.$placa, 50, " ");
                fputs($handler,$clienteHTML);
                fputs($handler,chr(13).chr(10));
                fputs($handler,chr(13).chr(10));
                fputs($handler,chr(13).chr(10));
                fputs($handler,chr(13).chr(10));

        #$this->pdf->SetY(105);
        #$this->pdf->SetX(20);
        

        foreach ($detalle_guiarem as $indice => $valor) {
                    $detacodi = $valor->GUIAREMDETP_Codigo;
                    $producto = $valor->PRODCTOP_Codigo;
                    $unidad = $valor->UNDMED_Codigo;
                    $cantidad = $valor->GUIAREMDETC_Cantidad;
                    $pu = $valor->GUIAREMDETC_Pu;
                    $subtotal = $valor->GUIAREMDETC_Subtotal;
                    $igv = $valor->GUIAREMDETC_Igv;
                    $descuento = $valor->GUIAREMDETC_Descuento;
                    $total = $valor->GUIAREMDETC_Total;
                    $pu_conigv = $valor->GUIAREMDETC_Pu_ConIgv;
                    $costo = $valor->GUIAREMDETC_Costo;
                    $venta = $valor->GUIAREMDETC_Venta;
                    $peso = $valor->GUIAREMDETC_Peso;
                    $GenInd = $valor->GUIAREMDETC_GenInd;

                    $datos_producto = $this->producto_model->obtener_producto($producto);
                    $nombre_producto = $valor->GUIAREMDETC_Descripcion . " " . $valor->GUIAREMDETC_Observacion;
                    $codigo_usuario = $datos_producto[0]->PROD_CodigoUsuario;

                    /* OCULTAR PRECIOS */
                        $pu = "";
                        $total = "";
                    
                $nomprod = $nombre_producto;
                #$nomprod = ($GenInd == 'I') ? $nomprod.$this->ObtenerSeriesComprobante($codigo,$tipo_docu,$producto) : $nomprod;
                $nomprod = (strlen($nombre_producto) > 50) ? substr( $nombre_producto, 0, 50) : $nombre_producto;
                $nomprod2 = (strlen($nombre_producto) > 50) ? substr( $nombre_producto, 50, 100) : "";
                
                $unidadMedida = $this->unidadmedida_model->obtener($valor->UNDMED_Codigo);
                $medidaDetalle = "";
                $medidaDetalle = ($unidadMedida[0]->UNDMED_Simbolo != "") ? $unidadMedida[0]->UNDMED_Simbolo : "ZZ";

                    fputs($handler,''.str_pad($valor->GUIAREMDETC_Cantidad, 6, " ", STR_PAD_LEFT));
                    fputs($handler,'  '.str_pad($codigo_usuario, 8, " ", STR_PAD_LEFT));
                    fputs($handler,'     '.str_pad( $nomprod, 50, " "));
                    fputs($handler,'   '.str_pad(number_format($pu,2), 8, " ", STR_PAD_LEFT));
                    fputs($handler,'      '.str_pad(number_format($total,2), 8, " ", STR_PAD_LEFT));
                    fputs($handler,chr(13).chr(10));

                    if ($nomprod2 != ""){
                        fputs($handler,''.str_pad(" ", 6, " ", STR_PAD_LEFT));
                        fputs($handler,'  '.str_pad(" ", 8, " ", STR_PAD_LEFT));
                        fputs($handler,'     '.str_pad( $nomprod2, 50, " "));
                        fputs($handler,'   '.str_pad(number_format($pu,2), 8, " ", STR_PAD_LEFT));
                        fputs($handler,'      '.str_pad(number_format($total,2), 8, " ", STR_PAD_LEFT));
                        fputs($handler,chr(13).chr(10));
                    }
            }

        $productoHTML = ' '.$detaProductos.' ';
        $movimientoHTML = '          '.$tipo_movimiento[0]->TIPOMOVP_Codigo.' ';

        fclose($handler);

        $txt = base_url().$archivo.'?='.date('Y-m-d-h:i:s');
        #header('Location:'.$txt);
        $this->load->view('almacen/guia_rem_print');
    }

    

    public function ventana_muestra_recurrentes($tipo_oper, $codigo = '', $formato = 'SELECT_ITEM', $docu_orig = '', $almacen = "", $comprobante = '')
    {
        $cliente = '';
        $nombre_cliente = '';
        $ruc_cliente = '';
        $proveedor = '';
        $nombre_proveedor = '';
        $ruc_proveedor = '';
        $almacen_id = $almacen;
        if ($tipo_oper == 'V') {
            $cliente = $codigo;
            $datos_cliente = $this->cliente_model->obtener($cliente);
            if ($datos_cliente) {
                $nombre_cliente = $datos_cliente->nombre;
                $ruc_cliente = $datos_cliente->ruc;
            }
            $filter = new stdClass();
            $filter->cliente = $cliente;
        } else {
            $proveedor = $codigo;
            $datos_proveedor = $this->proveedor_model->obtener($proveedor);
            if ($datos_proveedor) {
                $nombre_proveedor = $datos_proveedor->nombre;
                $ruc_proveedor = $datos_proveedor->ruc;
            }
            $filter = new stdClass();
            $filter->proveedor = $proveedor;
        }


        $lista_guiarem = $this->guiarem_model->buscar($tipo_oper, $filter);
        $lista = array();
        foreach ($lista_guiarem as $indice => $value) {
            $pdfImprimir = "<a href='javascript:;' onclick='ver_detalle_documento_recu(" . $value->GUIAREMP_Codigo . ")'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Ver Detalles'></a>";
            $ir = "<a href='javascript:;' onclick='seleccionar_guiarem_recu(" . $value->GUIAREMP_Codigo . "," . $value->GUIAREMC_Serie . "," . $value->GUIAREMC_Numero . ")' ><img src='" . base_url() . "images/ir.png' width='16' height='16' border='0' title='Guia de remision " . $value->GUIAREMC_Serie . " - " . $value->GUIAREMC_Numero . "' /></a>";
            $lista[] = array(mysql_to_human($value->GUIAREMC_Fecha), $value->GUIAREMC_Serie, $value->GUIAREMC_Numero, $value->numdoc, $value->nombre, $value->MONED_Simbolo . ' ' . number_format($value->GUIAREMC_total), $pdfImprimir, $ir);
        }


        $data['lista'] = $lista;
        $data['cliente'] = $cliente;
        $data['nombre_cliente'] = $nombre_cliente;
        $data['ruc_cliente'] = $ruc_cliente;
        $data['proveedor'] = $proveedor;
        $data['nombre_proveedor'] = $nombre_proveedor;
        $data['ruc_proveedor'] = $ruc_proveedor;
        $data['almacen'] = $almacen_id;
        $data['tipo_oper'] = $tipo_oper;
        $data['comprobante'] = $comprobante;
        $data['form_open'] = form_open(base_url() . "index.php/ventas/comprobante/ventana_muestra_comprobante", array("name" => "frmGuiarem", "id" => "frmGuiarem"));
        $data['form_close'] = form_close();
        $data['form_hidden'] = form_hidden(array("base_url" => base_url()));
        $this->load->view('ventas/ventana_muestra_comprobante', $data);
        // $this->load->view('almacen/ventana_muestra_guiarem', $data);

    }

    public function getOrderNumeroSerie($numero){
 
                $cantidad=strlen($numero);

                if($cantidad==1){
                    $dato ="00000$numero";
                }
                if($cantidad==2){
                     $dato ="0000$numero";
                }
                if($cantidad==3){
                    $dato ="000$numero";
                }
                if($cantidad==4){
                    $dato= "00$numero";
                }
                if($cantidad==5){
                    $dato ="0$numero";
                }
                if($cantidad==6){
                    $dato ="$numero";
                }
                return $dato;
    }

    #######################################
    ## Funcion: buscarAsociarGuia
    ## Dev: Luis Valdes
    ## Fecha 03/08/2022
    #######################################

    public function buscarAsociarGuia()
    {
        $data['compania'] = $this->somevar['compania'];

        $posDT = -1;
        $columnas = array(
        ++$posDT => "GUIAREMC_FechaRegistro",
        ++$posDT => "GUIAREMC_Fecha",
        ++$posDT => "GUIAREMC_Serie",
        ++$posDT => "GUIAREMC_Numero",
        ++$posDT => "nombre",
        ++$posDT => "",
        ++$posDT => "",
        ++$posDT => "",
        ++$posDT => "",
        ++$posDT => "",
        ++$posDT => ""
        );

        $filter = new stdClass();
        $filter->tipo_oper          = $this->input->post('tipo_oper');
        $filter->cliente            = $this->input->post('cliente');
        $filter->proveedor          = $this->input->post('proveedor');
        
        $listado = $this->guiarem_model->buscarGuiaremAsociar($filter);
        

        $lista = array();
        if (count($listado) > 0) {
            foreach ($listado as $indice => $valor) {


                $codigo = $valor->GUIAREMP_Codigo;
                
                $fechaR         = mysql_to_human($valor->fechaReg);
                $fecha          = mysql_to_human($valor->GUIAREMC_FechaTraslado);
                $serie          = $valor->GUIAREMC_Serie;
                $numero         = $valor->GUIAREMC_Numero;
                $nombre         = $valor->nombre;
                $documento      = $valor->ruc;
                $ordencompra    = $valor->DOCUP_Codigo;
                $coticodigo     = $valor->OCOMP_Codigo;
                $cotinumero     = $valor->GUIAREMC_OCompra;

                $seleccionar = "<a href='javascript:;' onclick='seleccionar_guiarem($codigo, \"$serie\", \"$numero\"" . (empty($ordencompra) ? "" : ", \"$ordencompra\"") . (empty($coticodigo) ? "" : ", \"$coticodigo\"") . ", \"$cotinumero\")'><img src='".base_url()."images/ir.png' width='16' height='16' border='0' title='Seleccionar'></a>";

                $pdf            = "<button type='button' class='btn2 btn-default' href='".base_url()."index.php/almacen/guiarem/guiarem_ver_pdf/$codigo/a4/1' data-fancybox data-type='iframe'><img src='".base_url()."images/pdf.png' class='image-size-1l' title='Ver PDF'></button>";

                $posDT = -1;
                $lista[] = array(
                    ++$posDT => $fecha,
                    ++$posDT => $serie,
                    ++$posDT => $numero,
                    ++$posDT => $documento,
                    ++$posDT => $nombre,
                    ++$posDT => $pdf,
                    ++$posDT => $seleccionar,
                );
                $item++;
            }
        }

        $filterAll = new stdClass();
        $filterAll->tipo_oper   = $filter->tipo_oper;
        $filterAll->cliente     = $filter->cliente;
        $filterAll->count       = true;
        $filter->count          = true;

        $recordsTotal           = $this->guiarem_model->buscarGuiaremAsociar($filterAll);
        $recordsFiltered        = $this->guiarem_model->buscarGuiaremAsociar($filter);

        $json = array(
            "draw"            => intval( $this->input->post('draw') ),
            "recordsTotal"    => $recordsTotal->registros,
            "recordsFiltered" => $recordsFiltered->registros,
            "data"            => $lista
        );

        echo json_encode($json);
    }

    public function guia_asociada($codigo)
    {
        $estadoAsociacion='';
        $listaGuiaremAsociados=$this->guiarem_model->buscarGuiaremComprobante($codigo,$estadoAsociacion);
        if (count($listaGuiaremAsociados) > 0){
            $result=array("result"=>"success");
        }
        else {
            $result=array("result"=>"error");
        }
        echo json_encode($result);
    }


}

?>