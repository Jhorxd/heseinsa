<?php
# CONTROLLER:.php
class Movmercaderia extends controller {
    private $url;

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
        $this->url = base_url();

    }

    public function index() {
        $data['cboAlmacen'] = form_dropdown("almacen", $this->almacen_model->seleccionar($this->somevar['compania']), $almacen_id, " class='form-control w-porc-90' id='almacen'"); // EN 
        $this->layout->view('almacen/movmercaderia_index', $data);
    }

    public function tabla_mov(){
        $columnas = array(
            0 => "",
            1 => "CAJA_Codigo",
            2 => "CAJA_Nombre",
            3 => "tipCa_Descripcion"
        );

        $filter             = new stdClass();
        $filter->start      = $this->input->post("start");
        $filter->length     = $this->input->post("length");
        $filter->fechai     = $this->input->post("fechai");
        $filter->fechaf     = $this->input->post("fechaf");
        $filter->producto   = $this->input->post("producto");
        /* var_dump($filter);
        exit; */
        if ($filter->fechaf == "" || $filter->fechaf == null) {
            $filter->fechaf = date('y-m-d');
        }

        $ordenar = $this->input->post("order")[0]["column"];
        if ($ordenar != ""){
            $filter->order  = $columnas[$ordenar];
            $filter->dir    = $this->input->post("order")[0]["dir"];
        }

        $item = ($this->input->post("start") != "") ? $this->input->post("start") : 0;

        $filter->codigo = $this->input->post('codigo');
        $filter->descripcion = $this->input->post('descripcion');
        $filter->compania = $this->compania;

        $colorInfo = $this->almacenproducto_model->getTable($filter);
        $lista = array();

        if (count($colorInfo) > 0) {
        foreach ($colorInfo as $indice => $valor) {

            if($valor->movI_FlagMov == "1"){
                $movimiento = "<li class ='btn btn-danger'>SALIDA</lid>";
            }else{
                $movimiento = "<li class ='btn btn-success'>ENTRADA</lid>";
            }

            $productoDatos = $this->almacenproducto_model->productos_sistema_mov($valor->PROD_Codigo);
            $productoNombre = $productoDatos[0]->PROD_Nombre;

            $editar = "<button type='button' onclick='editar_mercaderia($valor->movI_Codigo)' class='btn btn-default' title='editar'><img src='".$this->url."images/file.png' class='image-size-1b'></button>";

            


        $lista[] = array(
                            0 => $indice + 1,
                            1 => $valor->movI_Fecha,
/*                             2 => $valor->movI_numDoc,
 */                            2 => $valor->movI_receptor,
                            3 => $productoNombre,
                            4 => $valor->movI_Cantidad,
                            5 => $valor->movI_Ocompra,
                            6 => $valor->movI_Destino,
                            7 => $movimiento,
                            8 => $editar,


                        );
        }
        }

        unset($filter->start);
        unset($filter->length);

        $json = array(
                    "draw"            => intval( $this->input->post('draw') ),
                                         "recordsTotal"    => count($this->almacenproducto_model->getTable()),
                                            "recordsFiltered" => intval( count($this->almacenproducto_model->getTable()) ),
                    "data"            => $lista
            );

        echo json_encode($json);
    }

    public function insertar_mov(){
        $id_registro = $this->input->post("id_registro");
        $id_item = $this->input->post("code_producto"); /* para futuro desarrollo */
        
        $id_prodcuto = $this->input->post("id_prodcuto");
        $id_dia = $this->input->post("id_dia");
        $id_cantidad = $this->input->post("id_cantidad");
        $id_destino = $this->input->post("id_destino");
        $id_oc = $this->input->post("id_oc");
        $tipo_mov = $this->input->post("tipo_mov");
        $id_obs = $this->input->post("id_obs");
        $id_doc = $this->input->post("id_doc");
        $id_recep = $this->input->post("id_recep");

          /* CONVIERTO DE STRING A INT */
        $idItem = (int)$id_item;

        $filter = new stdClass();
        $filter->PROD_Codigo = $idItem;
        $filter->movI_Fecha = $id_dia;
        $filter->movI_Cantidad = $id_cantidad;
        $filter->movI_Destino = $id_destino;
        $filter->movI_Ocompra = $id_oc;
        $filter->movI_numDoc = $id_doc;
        $filter->movI_FlagMov = $tipo_mov;
        $filter->movI_Observaciones =  $id_obs;
        $filter->movI_receptor =  $id_recep;
      

        if($id_registro != ""){

            $filter->movI_FechaMovEdit = date("Y-m-d");
            $result = $this->almacenproducto_model->actualizar_mov($id_registro, $filter);

        }else{
            $result = $this->almacenproducto_model->insertar_mov($filter);

        }

        if ($result)
        $json = array("result" => "success");
        else
            $json = array("result" => "error");
        
        echo json_encode($json);

    }

    public function get_productos_barcode(){

        $barcode = $this->input->post("barcode"); 

        $filter = new stdClass();
        $filter->PROD_FlagBienServicio  = "B";
        $filter->cod_producto           = $barcode;

        $producto = $this->producto_model->search_barcode($filter);

        $descripcion = $producto[0]->PROD_Nombre;
        $id = $producto[0]->PROD_Codigo;

        if ($producto)
        $json = array(
        "result" => "success", 
        "id_p"  => $id,
        "descripcion" => $descripcion

        );
        else
            $json = array(
                "result" => "error"
            );
        
        echo json_encode($json);
    }

    public function get_mov(){

        $id = $this->input->post("id"); 

        $mercaderia = $this->almacenproducto_model->getMercaderiaEdit($id);

        $dia = $mercaderia[0]->movI_Fecha;
        $doc = $mercaderia[0]->movI_numDoc;
        $razon_social  = $mercaderia[0]->movI_receptor;
        
        $id_Producto = $mercaderia[0]->PROD_Codigo;
        $productoDatos = $this->almacenproducto_model->productos_sistema_mov($id_Producto);
        $productoNombre = $productoDatos[0]->PROD_Nombre;
        
        $cantidad = $mercaderia[0]->movI_Cantidad;
        $ocompra = $mercaderia[0]->movI_Ocompra;
        $destino = $mercaderia[0]->movI_Destino;
        $movimiento = $mercaderia[0]->movI_FlagMov;
        $obs = $mercaderia[0]->movI_Observaciones;

        $id = $mercaderia[0]->movI_Codigo;

        if ($mercaderia)
        $json = array(
        "result" => "success", 
        "id_prodcuto" =>$id_Producto,
        "id"    => $id, #id del registro
        "fecha"  => $dia,
        "numDoc" => $doc,
        "recep"  => $razon_social,
        "producto"  => $productoNombre,
        "cantidad"  => $cantidad,
        "ocompra"  => $ocompra,
        "destino"  => $destino,
        "movimiento"  => $movimiento,
        "observaciones" => $obs
        );
        else
            $json = array(
                "result" => "error"
            );
        
        echo json_encode($json);
    }

    public function excel_mov_caja($search_fechai='', $search_fechaf=''){
        
        $filter = new stdClass();
        $filter->start = 0;
        #$filter->length = 10;
        $filter->search = $this->input->post("search")["value"];

        $ordenar = $this->input->post("order")[0]["column"];
        if ($ordenar != ""){
            $filter->order = $columnas[$ordenar];
            $filter->dir = $this->input->post("order")[0]["dir"];
        }

        $item = ($this->input->post("start") != "") ? $this->input->post("start") : 0;

       
        if($search_fechai =='' && $search_fechaf==''){
             
             $filter->fechai = date("Y-m-d");
             $filter->fechaf = date("Y-m-d"); 
        }else{
          
            $filter->fechai = $search_fechai;
            $filter->fechaf = $search_fechaf;
        }

       
        $filter->nombre = $this->input->post('descripcion');
        $filter->tipo = $this->input->post('tipo');

    
        $movimientosInfo = $this->almacenproducto_model->getMercaderia($filter);
       /*  var_dump($movimientosInfo);
        exit; */
      ##########################################################################

      $this->load->library('Excel');

      $objPHPExcel = new PHPExcel();

      $objPHPExcel->setActiveSheetIndex(0);
      $hoja = $objPHPExcel->getActiveSheet();

      $estiloTitulo = array(
          'font' => array('name' => 'Calibri', 'bold' => true, 'color' => array('rgb' => '000000'), 'size' => 14),
          'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => TRUE)
      );
  
      $estiloColumnasTitulo = array(
          'font' => array('name' => 'Calibri', 'bold' => true, 'color' => array('rgb' => '000000'), 'size' => 11),
          'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('argb' => '5FF1C3')),
          'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => TRUE)
      );
  
      $estiloColumnasPar = array(
          'font' => array('name' => 'Calibri', 'bold' => false, 'color' => array('rgb' => '000000')),
          'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('argb' => 'FFFFFFFF')),
          'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => TRUE),
          'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')))
      );
  
      $estiloColumnasImpar = array(
          'font' => array('name' => 'Calibri', 'bold' => false, 'color' => array('rgb' => '000000')),
          'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('argb' => 'DCDCDCDC')),
          'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => TRUE),
          'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')))
      );
  
      $estiloBold = array(
          'font' => array('name' => 'Calibri', 'bold' => true, 'color' => array('rgb' => '000000'), 'size' => 11)
      );

      
  
      // ROJO PARA ANULADOS
      $colorCelda = array(
          'font' => array('name' => 'Calibri', 'bold' => false, 'color' => array('rgb' => '000000')),
          'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('argb' => 'F28A8C'))
      );

    $estilo_ingreso = array(
        'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '00FF00')), // Verde
    );
    
    $estilo_egreso = array(
        'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'FF0000')), // Rojo
    );

    $estilo_anulado = array(
        'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'E9FF0D')), // Rojo
    );

    if($search_fechai != ''){
        $fecha = $search_fechai;
    }else{
        $fecha = date("Y-m-d");
    }

      $hoja->setCellValue('A1', 'Movimiento de Mercaderia '.$fecha);
      $hoja->mergeCells('A1:G1'); // Fusionamos celdas para el título
      $hoja->getStyle('A1')->applyFromArray($estiloTitulo);

      $lugar = 2;
      $hoja->setCellValue("A$lugar", 'DIA');
      $hoja->setCellValue("B$lugar", 'CLIENTE - PROVEEDOR');
      $hoja->setCellValue("C$lugar", 'PRODUCTO');
      $hoja->setCellValue("D$lugar", 'CANTIDAD');
      $hoja->setCellValue("E$lugar", 'ORDEN DE COMPRA');
      $hoja->setCellValue("F$lugar", 'DESTINO');
      $hoja->setCellValue("G$lugar", 'DOCUMENTOS RELACIONADOS');
      $hoja->setCellValue("H$lugar", 'MOVIMIENTO');

      $hoja->getStyle("A$lugar:H$lugar")->applyFromArray($estiloColumnasTitulo);
      $hoja->getStyle("I$lugar:H$lugar")->applyFromArray($estiloColumnasTitulo);

      foreach($movimientosInfo as $i => $infomov){
          $lugar++;
          $dia = $infomov->movI_Fecha;
          $receptor = $infomov->movI_receptor;
          $cod_producto = $infomov->PROD_Codigo;
          $cantidad = $infomov->movI_Cantidad;
          $ocompra = $infomov->movI_Ocompra;
          $destino = $infomov->movI_Destino;

          $movimiento = $infomov->movI_FlagMov;
          $documentoRel = $infomov->movI_numDoc;
        
          if($movimiento == "1"){
            $movimiento = "SALIDA";
          }else{
            $movimiento = "ENTRADA";
          }
          $productoDatos = $this->almacenproducto_model->productos_sistema_mov($cod_producto);
            $productoNombre = $productoDatos[0]->PROD_Nombre;

    
          $hoja->setCellValue("A$lugar", $dia);
          $hoja->setCellValue("B$lugar", $receptor);
          $hoja->setCellValue("C$lugar", $productoNombre);
          $hoja->setCellValue("D$lugar", $cantidad);
          $hoja->setCellValue("E$lugar", $ocompra);
          $hoja->setCellValue("F$lugar", $destino);
          $hoja->setCellValue("G$lugar", $documentoRel);
          $hoja->setCellValue("H$lugar", $movimiento);

          $estiloFila = ($i % 2 == 0) ? $estiloColumnasPar : $estiloColumnasImpar;
          $hoja->getStyle("A$lugar:H$lugar")->applyFromArray($estiloFila);
        
      }
       

          $estiloFila = ($i % 2 == 0) ? $estiloColumnasPar : $estiloColumnasImpar;
          $hoja->getStyle("I$lugar:H$lugar")->applyFromArray($estiloFila); 

        $hoja->getColumnDimension("A")->setWidth("25");
        $hoja->getColumnDimension("B")->setWidth("25");
        $hoja->getColumnDimension("C")->setWidth("25");
        $hoja->getColumnDimension("D")->setWidth("25");
        $hoja->getColumnDimension("E")->setWidth("25");
        $hoja->getColumnDimension("F")->setWidth("25");
        $hoja->getColumnDimension("G")->setWidth("25");
        $hoja->getColumnDimension("H")->setWidth("25");


      $nombreArchivo = 'MOVIMIENTO DE MERCADERIA '.$fecha.'.xlsx';
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
      header('Cache-Control: max-age=0');
      $objWriter->save('php://output');
      exit;
    }


}

?>