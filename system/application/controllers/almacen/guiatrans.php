<?php

include("system/application/libraries/cezpdf.php");
include("system/application/libraries/class.backgroundpdf.php");

class Guiatrans extends controller
{
    private $_hoy;

    public function __construct()
    {
        parent::Controller();
        $this->load->model('almacen/guiatransdetalle_model');
        $this->load->model('almacen/guiasadetalle_model');
        $this->load->model('almacen/guiaindetalle_model');
        $this->load->model('almacen/guiatrans_model');
        $this->load->model('almacen/guiatransdetalle_model');
        $this->load->model('almacen/almacen_model');
        $this->load->model('almacen/almacenproducto_model');
        $this->load->model('almacen/inventario_model');
        $this->load->model('almacen/producto_model');
        $this->load->model('maestros/empresa_model');
        $this->load->model('maestros/documento_model');
        $this->load->model('maestros/empresa_model');
        $this->load->model('maestros/companiaconfiguracion_model');
        $this->load->model('maestros/companiaconfidocumento_model');
        $this->load->model('almacen/seriedocumento_model');
        $this->load->helper('form', 'url');
        $this->load->helper('utf_helper');
        $this->load->helper('util_helper');
        $this->load->helper('my_almacen');
        $this->load->library('form_validation');
        $this->load->library('lib_props');
        $this->somevar['user']      = $this->session->userdata('user');
        $this->somevar['compania']  = $this->session->userdata('compania');
        $this->somevar['establec']  = $this->session->userdata('establec');
        date_default_timezone_set('America/Lima');
        $this->_hoy = mdate("%Y-%m-%d ", time());
    }

    public function listar($j = 0)
    {
        $this->load->library('layout', 'layout');

        $data['fechai'] = '';
        $data['fechaf'] = '';
        $data['serie'] = '';
        $data['numero'] = '';
        $data['producto'] = '';
        $data['codproducto'] = '';
        $data['nombre_producto'] = '';
        $data['movimiento'] = '';
        $data['compkardex'] = $this->somevar['compania'];;

        $data['titulo_busqueda'] = "GUIAS DE TRANSFERENCIA";
        $data['titulo_tabla'] = "GUIAS DE TRANSFERENCIA";
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->layout->view('almacen/guiatrans_index', $data);
    }

    public function datatable_guias_salida()
    {
        $columnas = array(
            0 => "GTRANC_Fecha",
            1 => "GTRANC_Serie",
            2 => "GTRANC_Numero",
            3 => "EESTABC_DescripcionOri",
            4 => ""
        );
        
        $filter             = new stdClass();
        $filter->start      = $this->input->post("start");
        $filter->length     = $this->input->post("length");
        $filter->fechai     = $this->input->post("fechai");
        $filter->fechaf     = $this->input->post("fechaf");
        $filter->serie      = $this->input->post("serie");
        $filter->numero     = $this->input->post("numero");
        $filter->movimiento = $this->input->post("movimiento");
        
        if ($filter->fechaf == "" || $filter->fechaf == null) {
            $filter->fechaf = date('y-m-d');
        }

        $ordenar = $this->input->post("order")[0]["column"];
        if ($ordenar != ""){
            $filter->order  = $columnas[$ordenar];
            $filter->dir    = $this->input->post("order")[0]["dir"];
        }

        $item = ($this->input->post("start") != "") ? $this->input->post("start") : 0;

        $guias_transito = $this->guiatrans_model->listar_transferencias_salida($filter);
        $lista = array();

        if (count($guias_transito) > 0) {
            foreach ($guias_transito as $indice => $valor) {
                $codigo         = $valor->GTRANP_Codigo;
                $estado_mov     = $valor->GTRANC_EstadoTrans;
                $estado_guia    = $valor->GTRANC_FlagEstado;
                $anular         = "";
                $editar         = "";

                $pdf = "<a href='javascript:;' onclick='guiatrans_ver_pdf($codigo,1)'><img src='" . base_url() . "images/pdf.png' width='16' height='16' border='0' title='Ver PDF'></a>";

                switch ($estado_mov) {
                    case 0:  // Pendiente
                        if ($estado_guia == 0) {
                            $movimiento_actual = "<div style='width:70px; height:17px; background-color: #ab080c; text-align:center; color: #f1f1f1' >Anulado</div>";
                        } else {
                            $editar = "<a href='javascript:;' onclick='editar_guiatrans(" . $codigo . ")'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                            $anular = "<a title='Cancelar la transferencia' href='#' onClick='anular_guia(".$codigo.");'><img src='" . base_url() . "images/error.png' width='14px' height='14px'></a>";

                            $movimiento_actual = "<a href='#' id='trans".$codigo."' title='Transferencia pediente, falta confirmar' onClick='cargarTransferencia(" . $estado_mov . ",".$codigo.");' ><div style='width:70px; height:17px; background-color: #FF6464; text-align:center' >Pendiente</div></a>";
                        }
                    break;
                    case 1: // Transito
                        $movimiento_actual = "<a href='#' id='trans".$codigo."' title='Enviado correctamente, puede cancelar el envio dando un click' onClick='devolucion(" . $estado_mov . ",".$codigo.");' ><div style='width:70px; height:17px; background-color: orange; text-align:center' >Enviado</div></a>";
                    break;
                    case 2: // Recibido
                        $movimiento_actual = "<div style='width:70px; height:17px; background-color: #00D269; text-align:center'>Recibido</div>";
                    break;
                    case 3: // Devolucion
                        $movimiento_actual = "<div style='width:70px; height:17px; background-color: #5baba8; text-align:center'>Devolucion</div>";
                    break;
                }

                $lista[] = array(
                    0 => mysql_to_human($valor->GTRANC_Fecha),
                    1 => $valor->GTRANC_Serie,
                    2 => $this->lib_props->getOrderNumeroSerie($valor->GTRANC_Numero),
                    3 => $valor->EESTABC_DescripcionDest." - ".$valor->ALMAC_DescripcionDes,
                    4 => $movimiento_actual,
                    5 => $anular,
                    6 => $editar,
                    7 => $pdf,
                    8 => ""
                );
            }
        }

        unset($filter->start);
        unset($filter->length);

        $filterAll              = new stdClass();
        $filterAll->tipo_oper   = $tipo_oper;
        $filterAll->tipo_docu   = $tipo_docu;

        $json = array(
                            "draw"            => intval( $this->input->post('draw') ),
                            "recordsTotal"    => count($this->guiatrans_model->listar_transferencias_salida($filterAll)),
                            "recordsFiltered" => intval( count($this->guiatrans_model->listar_transferencias_salida($filter)) ),
                            "data"            => $lista
                    );

        echo json_encode($json);
    }

    public function datatable_guias_ingreso() 
    {
        $columnas = array(
            0 => "GTRANC_Fecha",
            1 => "GTRANC_Serie",
            2 => "GTRANC_Numero",
            3 => "EESTABC_DescripcionOri",
            4 => ""
        );
        
        $filter         = new stdClass();
        $filter->start  = $this->input->post("start");
        $filter->length = $this->input->post("length");
        $filter->search = $this->input->post("search")["value"];
        $filter->fechai = $this->input->post("fechai");
        $filter->fechaf = $this->input->post("fechaf");
        $filter->serie  = $this->input->post("serie");
        $filter->numero = $this->input->post("numero");
        $filter->movimiento = $this->input->post("movimiento");
        if ($filter->fechaf=="" || $filter->fechaf==null) {
            $filter->fechaf = date('y-m-d');
        }
        $ordenar = $this->input->post("order")[0]["column"];
        if ($ordenar != ""){
            $filter->order = $columnas[$ordenar];
            $filter->dir = $this->input->post("order")[0]["dir"];
        }

        $item = ($this->input->post("start") != "") ? $this->input->post("start") : 0;

        $guias_transito = $this->guiatrans_model->listar_transferencias_ingreso($filter);
        $lista = array();

        if (count($guias_transito) > 0) {
                foreach ($guias_transito as $indice => $valor) {

                    $codigo         = $valor->GTRANP_Codigo;
                    $estado_mov     = $valor->GTRANC_EstadoTrans;
                    $estado_guia    = $valor->GTRANC_FlagEstado;
                    $pdf = "<a href='javascript:;' onclick='guiatrans_ver_pdf($codigo,1)'><img src='" . base_url() . "images/pdf.png' width='16' height='16' border='0' title='Ver PDF'></a>";
                    switch ($estado_mov) {
                        
                        case 0: // Pendiente
                            if ($estado_guia == 0) {
                                $movimiento_actual = "<div style='width:70px; height:17px; background-color: #ab080c; text-align:center; color: #f1f1f1' >Anulado</div>";
                            } else {
                                $movimiento_actual = "<div  id='trans".$codigo."' style='width:70px; height:17px; background-color: #FF6464; text-align:center'>Pendiente</div>";
                            }
                        break;
                        
                        case 1: // Transito
                            $movimiento_actual = "<a href='#' id='trans".$codigo."' title='Enviado correctamente, puede cancelar el envio dando un click' onClick='cargarTransferencia(" . $estado_mov . ",".$codigo.");' ><div style='width:70px; height:17px; background-color: yellow; text-align:center' >Transito</div></a>";
                        break;
                       
                        case 2:  // Recibido
                            $movimiento_actual = "<div style='width:70px; height:17px; background-color: #00D269; text-align:center'>Recibido</div>";
                        break;
                        
                        case 3: // Devolucion
                            $movimiento_actual = "<div style='width:70px; height:17px; background-color: #5baba8; text-align:center'>Devolucion</div>";
                        break;

                    }



                    $lista[] = array(
                        0 => mysql_to_human($valor->GTRANC_Fecha),
                        1 => $valor->GTRANC_Serie,
                        2 => $this->lib_props->getOrderNumeroSerie($valor->GTRANC_Numero),
                        3 => $valor->EESTABC_DescripcionOri." - ".$valor->ALMAC_DescripcionOri,
                        4 => $movimiento_actual,
                        5 => $pdf
                    );
                }
        }

        unset($filter->start);
        unset($filter->length);

        $filterAll = new stdClass();
        $filterAll->tipo_oper = $tipo_oper;
        $filterAll->tipo_docu = $tipo_docu;

        $json = array(
        "draw"            => intval( $this->input->post('draw') ),
        "recordsTotal"    => count($this->guiatrans_model->listar_transferencias_ingreso($filterAll)),
        "recordsFiltered" => intval( count($this->guiatrans_model->listar_transferencias_ingreso($filter)) ),
        "data"            => $lista
        );

        echo json_encode($json);
    }

    public function datatable_guias_transito()
    {

        $columnas = array(
                            0 => "GTRANC_Fecha",
                            1 => "GTRANC_Serie",
                            2 => "GTRANC_Numero",
                            3 => "EESTABC_DescripcionOri",
                            4 => ""
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

        $guias_transito = $this->guiatrans_model->listar_transferencias_transito($filter);
        $lista = array();

        if (count($guias_transito) > 0) {
            foreach ($guias_transito as $indice => $valor) {
                $lista[] = array(
                                    0 => $valor->GTRANC_Fecha,
                                    1 => $valor->GTRANC_Serie,
                                    2 => $this->lib_props->getOrderNumeroSerie($valor->GTRANC_Numero),
                                    3 => $valor->EESTABC_DescripcionOri,
                                    4 => "TRANSITO"
                                );
            }
        }

        unset($filter->start);
        unset($filter->length);

        $filterAll = new stdClass();
        $filterAll->tipo_oper = $tipo_oper;
        $filterAll->tipo_docu = $tipo_docu;

        $json = array(
                            "draw"            => intval( $this->input->post('draw') ),
                            "recordsTotal"    => count($this->guiatrans_model->listar_transferencias_transito($filterAll)),
                            "recordsFiltered" => intval( count($this->guiatrans_model->listar_transferencias_transito($filter)) ),
                            "data"            => $lista
                    );

        echo json_encode($json);
    }

    public function nueva()
    {

        /* :::: SE CREA LA SESSION :::*/
        $hoy                    = date('Y-m-d H:i:s');
        $cadena                 = strtotime($hoy).substr((string)microtime(), 1, 8);
        $tempSession            = str_replace('.','',$cadena);
        $data['tempSession']    = $tempSession;
        /* :::::::::::::::::::::::::::*/

        $compania           = $this->somevar['compania'];
        $data['compania']   = $compania;
        $data_confi         = $this->companiaconfiguracion_model->obtener($this->somevar['compania']);
        $tipo               = 15;
        $data_confi_docu    = $this->companiaconfidocumento_model->obtener($data_confi[0]->COMPCONFIP_Codigo, $tipo);
        $data_confi1        = $this->configuracion_model->obtener_numero_documento($compania, $tipo);
        $data['titulo']     = "NUEVA GUIA DE TRANSFERENCIA";
        $data['codigo']     = "";
        $data['form_open']  = form_open(base_url() . 'index.php/almacen/guiatrans/grabar', array("name" => "frmGuiatrans", "id" => "frmGuiatrans", "onSubmit" => "javascript:return FALSE"));
        $data['form_close'] = form_close();
        $data['oculto']     = form_hidden(array("base_url" => base_url(), "tipo_codificacion" => $data_confi_docu[0]->COMPCONFIDOCP_Tipo, 'codigo' => ''));
        $data['cboEmpresaTrans'] = form_dropdown("empresa_transporte", $this->empresa_model->seleccionar(), "1", " class='comboGrande' id='empresa_transporte' style='width:300px'");
        
        $data['fecha'] = form_input(array("name" => "fecha", "id" => "fecha", "class" => "cajaPequena cajaSoloLectura", "readonly" => "readonly", "maxlength" => "10", "value" => mysql_to_human($hoy)));
        $data['observacion']    = "";
        $data['codguiain']      = "";
        $data['codguiasa']      = "";
        
        $data['tipoguia']       = $tipo;
        $data['detalle']        = array();

        $lista_almacen          = $this->almacen_model->cargarAlmacenesPorCompania($compania);
        $lista_almacen_general  = $this->seleccionar_destino_general();
        $data['listar_almacen'] = $lista_almacen;
        $data['cboAlmacenDestino']  = $lista_almacen_general;
        $data['estado'] = form_dropdown("estado", array("1" => "Activo", "0" => "Anulado"), "1", " class='comboPequeno' id='estado' style='display:none'");
      
        $data['serie']        = $data_confi1[0]->CONFIC_Serie;
        $data['numero']       = $data_confi1[0]->CONFIC_Numero + 1;

        $this->layout->view('almacen/guiatrans_nueva', $data);
    }

    public function grabar()
    {
        $tipo       = 15;
        $compania   = $this->input->post("compania_incial");
        
        if ($this->input->post('almacen') == '' || $this->input->post('almacen') == '0')
            exit('{"result":"error", "campo":"almacen"}');
        if ($this->input->post('almacen_destino') == '' || $this->input->post('almacen_destino') == '0')
            exit('{"result":"error", "campo":"almacen_destino"}');
        if ($this->input->post('almacen') == $this->input->post('almacen_destino'))
            exit('{"result":"error", "campo":"almacen_destino"}');
        if ($this->input->post('fecha') == '')
            exit('{"result":"error", "campo":"fecha"}');
        if ($this->input->post('estado') == '0' && $this->input->post('observacion') == '')
            exit('{"result":"error", "campo":"observacion"}');

        $codigo     = $this->input->post("codigo");
        $compania   = $this->input->post("compania");
        $serie      = $this->input->post("serie");
        
        $configuracion_datos    = $this->configuracion_model->obtener_numero_documento($compania, $tipo);
        
        $codigo_usuario         = $this->input->post("codigo_usuario") ? $this->input->post("codigo_usuario") : NULL;
        $almacen                = $this->input->post("almacen");
        $almacen_destino        = $this->input->post("almacen_destino");
        $fecha                  = $this->input->post("fecha");
        $observacion            = $this->input->post("observacion") ? $this->input->post("observacion") : NULL;
        $estado                 = $this->input->post("estado");
        
        $prodcodigo         = $this->input->post('prodcodigo');
        $produnidad         = $this->input->post('produnidad');
        $prodcantidad       = $this->input->post('prodcantidad');
        $prodcosto          = $this->input->post('prodcosto');
        $proddescri         = $this->input->post('proddescri');
        $detaccion          = $this->input->post('detaccion');
        $detacodi           = $this->input->post('detacodi');
        $flagGenInd         = $this->input->post('flagGenIndDet');
        $almacenProducto    = $this->input->post('almacenProducto');
        
        

        $filter = new stdClass();
        $filter->GTRANC_Serie           = $serie;
        $filter->GTRANC_Numero          = $numero;
        $filter->GTRANC_CodigoUsuario   = $codigo_usuario;
        $filter->GTRANC_AlmacenOrigen   = $almacen;
        $filter->GTRANC_AlmacenDestino  = $almacen_destino;
        $filter->GTRANC_Fecha           = human_to_mysql($fecha);
        $filter->GTRANC_Observacion     = $observacion;
        $filter->GTRANC_Placa           = $placa;
        $filter->GTRANC_Licencia        = $licencia;
        $filter->GTRANC_Chofer          = $chofer;
        $filter->EMPRP_Codigo           = $transporte;
        $filter->COMPP_Codigo           = $compania;
        $filter->USUA_Codigo            = $this->somevar['user'];
        $filter->GTRANC_FlagEstado      = $estado;
        $filter->PEDIP_Codigo           = $rucempresatransporte;

        if (isset($codigo) && $codigo > 0) {
            $numero = $this->input->post("numero") ? $this->input->post("numero") : NULL;
            $filter->GTRANC_Numero  = $numero;
            $guiatrans_id           = $this->guiatrans_model->actualiza_guiatrans($codigo, $filter);
            if ($guiatrans_id > 0) {
                $this->guiatransdetalle_model->eliminar($guiatrans_id);
            }
                
        } else {
            $numero = $configuracion_datos[0]->CONFIC_Numero + 1;
            $filter->GTRANC_Numero = $numero;
            $guiatrans_id = $this->guiatrans_model->insertar($filter);
        }

        if ($guiatrans_id!=0) {

            if (is_array($prodcodigo)) {
                foreach ($prodcodigo as $indice => $valor) {
                    $producto   = $prodcodigo[$indice];
                    $unidad     = $produnidad[$indice];
                    $cantidad   = $prodcantidad[$indice];
                    $costo      = $prodcosto[$indice];
                    $descri     = $proddescri[$indice];
                    $accion     = $detaccion[$indice];
                    $detflag    = $flagGenInd[$indice];

                    $filter2 = new stdClass();
                    $filter2->GTRANP_Codigo         = $guiatrans_id;
                    $filter2->PROD_Codigo           = $producto;
                    $filter2->UNDMED_Codigo         = $unidad;
                    $filter2->GTRANDETC_Cantidad    = $cantidad;
                    $filter2->GTRANDETC_Costo       = $costo;
                    $filter2->GTRANDETC_GenInd      = $detflag;
                    $filter2->GTRANDETC_Descripcion = $descri;
                    $filter2->GTRANDETC_FlagEstado  = 1;

                    if ( $detaccion[$indice] != 'e' )
                        $this->guiatransdetalle_model->insertar($filter2);
                    
                    /**verificacion de tipo de producto si es con serie**/
                    if ( $detflag == 'I' ){
                        if ( $valor != null ){
                            /**obtenemos las series de session por producto***/
                            $codigoAlmacenProducto = $almacen;
                            $seriesProducto = $_SESSION['serieReal'];
                            #$seriesProducto=$this->session->userdata('serieReal');

                            if ($seriesProducto!=null && count($seriesProducto) > 0 && $seriesProducto!= "") {
                                if( $accion != 'n' ){
                                    $producto_id=$valor;
                                    /***pongo todos en estado cero de las series asociadas a ese producto**/
                                    $seriesProductoBD = $_SESSION['serieRealBD'];
                                    $serieBD = $seriesProductoBD;
                                    if($serieBD!=null && count($serieBD)>0){
                                        foreach ($serieBD as $almBD => $arrAlmacenBD) {
                                            if($almBD==$codigoAlmacenProducto){
                                                foreach ($arrAlmacenBD as $ind1BD => $arrserieBD) {
                                                    if ($ind1BD == $producto_id) {
                                                        foreach ($arrserieBD as $keyBD => $valueBD) {
                                                            /**cambiamos a estado 0**/
                                                            $filterSerieD = new stdClass();
                                                            $filterSerieD->SERDOC_FlagEstado = '0';
                                                            $this->seriedocumento_model->modificar($valueBD->SERDOC_Codigo,$filterSerieD);
                                                            /**deseleccionamos los registros en estadoSeleccion cero:0:desleccionado**/
                                                            $tcomp = "GT-".$guiatrans_id;
                                                            $this->almacenproductoserie_model->seleccionarSerieBD($valueBD->SERIP_Codigo,0,$tcomp);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                
                                if( $accion != 'e' ){
                                    foreach ($seriesProducto as $alm2 => $arrAlmacen2) {
                                        if($alm2==$codigoAlmacenProducto){
                                            foreach ($arrAlmacen2 as $ind2 => $arrserie2){
                                                if ($ind2 == $valor) {
                                                    $serial = $arrserie2;
                                                    if($serial != null && count($serial) > 0){
                                                        foreach ($serial as $i => $serie) {
                                                            $serieNumero=$serie->serieNumero;
                                                            if($serie->serieDocumentoCodigo!=null && $serie->serieDocumentoCodigo!=0){
                                                                $filterSerie= new stdClass();
                                                                $filterSerie->SERDOC_FlagEstado='1';
                                                                $this->seriedocumento_model->modificar($serie->serieDocumentoCodigo,$filterSerie);
                                                            }else{
                                                                /**insertamso serie documento**/
                                                                /**DOCUMENTO COMPROBANTE**/
                                                                $filterSerieD = new stdClass();
                                                                $filterSerieD->SERDOC_Codigo = NULL;
                                                                $filterSerieD->SERIP_Codigo = $serie->serieCodigo;
                                                                /**guiatransferencia origen :10**/
                                                                $filterSerieD->DOCUP_Codigo = 15;
                                                                $filterSerieD->SERDOC_NumeroRef = $guiatrans_id;
                                                                /**2:salida**/
                                                                $filterSerieD->TIPOMOV_Tipo = 6;
                                                                $filterSerieD->SERDOC_FechaRegistro=date("Y-m-d H:i:s");
                                                                $filterSerieD->SERDOC_FlagEstado='1';
                                                                $this->seriedocumento_model->insertar($filterSerieD);
                                                                /**FIN DE INSERTAR EN SERIE**/
                                                                /**los registros en estadoSeleccion 1:seleccionado**/
                                                            }
                                                            $tcomp = "GT-".$guiatrans_id;
                                                            $this->almacenproductoserie_model->seleccionarSerieBD($serie->serieCodigo,1,$tcomp);
                                                        }
                                                    }
                                                    break;
                                                }
                                            }
                                            break;
                                        }
                                    }
                                }
                                
                                if($accion != 'n'){
                                    /**eliminamos los registros en estado cero solo de serieDocumento**/
                                    $this->seriedocumento_model->eliminarDocumento($guiatrans_id,15);
                                }
                            }
                        }
                    }
                    
                    
                    
                    /**fin de verificacion**/
                }
            }

            exit('{"result":"ok", "codigo":"' . $guiatrans_id . '"}');
        } else {
            exit('{"result":"error", "codigo":"' . $guiatrans_id . '"}');
        }
    }

    public function editar($codigo)
    {
        /* :::: SE CREA LA SESSION :::*/
        $hoy                    = date('Y-m-d H:i:s');
        $cadena                 = strtotime($hoy).substr((string)microtime(), 1, 8);
        $tempSession            = str_replace('.','',$cadena);
        $data['tempSession']    = $tempSession;
        /* :::::::::::::::::::::::::::*/
        $datos_guiatrans = $this->guiatrans_model->obtener($codigo);
        $tipo_oper      = "V";
        $tipo           = 15;
        
        $compania           = $datos_guiatrans[0]->COMPP_Codigo;
        $data['compania']   = $compania;
        $data_confi         = $this->companiaconfiguracion_model->obtener($compania);
        $data_confi_docu    = $this->companiaconfidocumento_model->obtener($data_confi[0]->COMPCONFIP_Codigo, $tipo);
        $data_confi1        = $this->configuracion_model->obtener_numero_documento($compania, $tipo);
        $data['titulo']     = "EDITAR GUIA DE TRANSFERENCIA";
        $data['tipo_docu']  = "GT";
        
        $data['codigo']     = $codigo;
        $data['form_open']  = form_open(base_url() . 'index.php/almacen/guiatrans/grabar', array("name" => "frmGuiatrans", "id" => "frmGuiatrans"));
        $data['form_close'] = form_close();
        $data['oculto']     = form_hidden(array("base_url" => base_url(), "codigo" => $codigo));
        $data['codguiain']  = $datos_guiatrans[0]->GUIAINP_Codigo;
        $data['codguiasa']  = $datos_guiatrans[0]->GUIASAP_Codigo;
        $almacorigen        = $datos_guiatrans[0]->GTRANC_AlmacenOrigen;
        $data['almacorigen'] = $almacorigen;
        
        $data['tipoguia'] = $tipo;

        $data['serie']      = $datos_guiatrans[0]->GTRANC_Serie;
        $data['numero']     = $datos_guiatrans[0]->GTRANC_Numero;
        $data['codigo_usuario'] = $datos_guiatrans[0]->GTRANC_CodigoUsuario;
        $data['fecha'] = form_input(array("name" => "fecha", "id" => "fecha", "class" => "cajaPequena cajaSoloLectura", "readonly" => "readonly", "maxlength" => "10", "value" => mysql_to_human($codigo != '' ? $datos_guiatrans[0]->GTRANC_Fecha : $this->_hoy)));
        $data['observacion'] = $datos_guiatrans[0]->GTRANC_Observacion;
       
        $lista_almacen              = $this->almacen_model->cargarAlmacenesPorCompania($datos_guiatrans[0]->COMPP_Codigo);
        $lista_almacen_general      = $this->seleccionar_destino_general($datos_guiatrans[0]->GTRANC_AlmacenDestino);
        $data['listar_almacen']     = $lista_almacen;
        $data['cboAlmacenDestino']  = $lista_almacen_general;
        
        $data['estado'] = form_dropdown("estado", array("1" => "Activo", "0" => "Anulado"), ($codigo != '' ? $datos_guiatrans[0]->GTRANC_FlagEstado : '1'), " class='comboPequeno' id='estado'");
        
        $this->layout->view('almacen/guiatrans_nueva', $data);
    }

    public function cargarTransferencia()
    {
        $userCod    = $this->session->userdata('user');
        $codTrans   = $this->input->post('guiaTrans');
        $estado     = $this->input->post('estado');
        $compkardex = $this->input->post('compkardex');

        $buscarGuiaTransferencia    = $this->guiatrans_model->obtener2($codTrans);
        $estadoTransferencia        = $buscarGuiaTransferencia->GTRANC_EstadoTrans;
        
        ################################################################
        
        $EstadoTrans        = $buscarGuiaTransferencia->GTRANC_EstadoTrans;
        $filter = new stdClass();
        $filter->COMPP_Codigo           = $compkardex;
        $filter->GTRANC_CodigoUsuario   = $buscarGuiaTransferencia->GTRANC_CodigoUsuario;
        $filter->GTRANC_AlmacenOrigen   = $buscarGuiaTransferencia->GTRANC_AlmacenOrigen;
        $filter->GTRANC_AlmacenDestino  = $buscarGuiaTransferencia->GTRANC_AlmacenDestino;
        $filter->GTRANC_Fecha           = $buscarGuiaTransferencia->GTRANC_Fecha;
        $filter->USUA_Codigo            = $buscarGuiaTransferencia->USUA_Codigo;
        $filter->GTRANC_Serie           = $buscarGuiaTransferencia->GTRANC_Serie;
        $filter->GTRANC_Numero          = $buscarGuiaTransferencia->GTRANC_Numero;
        $filter->GTRANC_FlagEstado      = $buscarGuiaTransferencia->GTRANC_FlagEstado;
        $filter->GTRANP_Codigo          = $codTrans;

        $AlmacenOrigen   = $buscarGuiaTransferencia->GTRANC_AlmacenOrigen;
        $data = array();
        if ($EstadoTrans==2 || $EstadoTrans==3) {
            $data = array( 
                "estado"        => "error",
                "movimiento"    => 1,
                "mensaje"       => "El movimiento ya fue realizado, se recargua la lista"
            );

        }else{
            switch ($EstadoTrans) {
                case '0':
                    //PASA A ESTADO ENVIADO
                    $estado_siguiente   = 1;
                    $actualiza          = $this->guiatrans_model->actualiza_usuatrans($userCod, $estado_siguiente, $codTrans);
                    //SI SE ACTUALIZA LA GUIA HACE EL DESCUENTO EN EL ALMACEN DE ORIGEN
                    if ($actualiza) {
                        $this->disminuir_stock($filter);
                        $data = array( 
                            "estado"        => "success",
                            "movimiento"    => 0,
                            "mensaje"       => "EL envío se ha realizado con exito"
                        );
                    }else{
                        $data = array( 
                            "estado"        => "error",
                            "movimiento"    => 0,
                            "mensaje"       => "Se ha presentado un error al enviar"
                        );
                    }
                    break;
                case '1':
                    //PASA A ESTADO RECIBIDO EN EL DESTINO
                    $estado_siguiente   = 2;
                    if ($estado==0) {
                        // La transferencia fue enviada pero el javascript se quedó en estado 0, por lo tanto no se ejecuta la transferencia
                        $data = array( 
                            "estado"        => "error",
                            "movimiento"    => 1,
                            "mensaje"       => "El movimiento ya fue realizado, se recargua la lista"
                        );
                    }else{
                        if ($estado==2) {
                            //la transferencia ya ha sido recibida en el almacen de destino
                            $data = array( 
                                "estado"        => "error",
                                "movimiento"    => 1,
                                "mensaje"       => "El movimiento ya fue recibido, se recargua la lista"
                            );
                        }else{
                            $actualiza          = $this->guiatrans_model->actualiza_usuatrans($userCod, $estado_siguiente, $codTrans);
                            if ($actualiza) {
                                $this->aumentar_stock($filter);
                                $data = array( 
                                    "estado"        => "success",
                                    "movimiento"    => 1,
                                    "mensaje"       => "EL envío se ha recibido con exito"
                                );
                            }else{
                                $data = array( 
                                    "estado"        => "error",
                                    "movimiento"    => 1,
                                    "mensaje"       => "Se ha presentado un error al enviar"
                                );
                            }
                        }
                    }
                    
                    break;
            }

        }
        echo json_encode($data);
    }

    public function devolucion()
    {
        $userCod    = $this->session->userdata('user');
        $codTrans   = $this->input->post('guiaTrans');
        $estado     = $this->input->post('estado');
        $compkardex = $this->input->post('compkardex');

        $buscarGuiaTransferencia    = $this->guiatrans_model->obtener2($codTrans);
        $estadoTransferencia        = $buscarGuiaTransferencia->GTRANC_EstadoTrans;
        
        ################################################################
        
        $EstadoTrans        = $buscarGuiaTransferencia->GTRANC_EstadoTrans;
        $filter = new stdClass();
        $filter->GTRANC_CodigoUsuario   = $buscarGuiaTransferencia->GTRANC_CodigoUsuario;
        $filter->GTRANC_AlmacenOrigen   = $buscarGuiaTransferencia->GTRANC_AlmacenOrigen;
        $filter->GTRANC_AlmacenDestino  = $buscarGuiaTransferencia->GTRANC_AlmacenDestino;
        $filter->GTRANC_Fecha           = $buscarGuiaTransferencia->GTRANC_Fecha;
        $filter->COMPP_Codigo           = $compkardex;
        $filter->USUA_Codigo            = $buscarGuiaTransferencia->USUA_Codigo;
        $filter->GTRANC_Serie           = $buscarGuiaTransferencia->GTRANC_Serie;
        $filter->GTRANC_Numero          = $buscarGuiaTransferencia->GTRANC_Numero;
        $filter->GTRANC_FlagEstado      = $buscarGuiaTransferencia->GTRANC_FlagEstado;
        $filter->GTRANP_Codigo          = $codTrans;

        $AlmacenOrigen   = $buscarGuiaTransferencia->GTRANC_AlmacenOrigen;
        $data = array();
        if ($EstadoTrans==2 || $EstadoTrans==3) {
            $data = array( 
                "estado"        => "error",
                "movimiento"    => 1,
                "mensaje"       => "El movimiento ya fue realizado, se recargua la lista"
            );

        }else{
            switch ($EstadoTrans) {
                case '0':
                    $data = array( 
                        "estado"        => "error",
                        "movimiento"    => 0,
                        "mensaje"       => "No puede hacer devolucion de una transferencia pendiente"
                    );
                    break;
                case '1':
                    //TRANSITO DEVUELTO
                    $estado_siguiente   = 3;
                    $actualiza          = $this->guiatrans_model->actualiza_usuatrans($userCod, $estado_siguiente, $codTrans);
                    if ($actualiza){
                        $this->devolucion_origen($filter);
                        $data = array( 
                            "estado"        => "success",
                            "movimiento"    => 1,
                            "mensaje"       => "EL envío se ha CANCELADO con exito"
                        );
                    }else{
                        $data = array( 
                            "estado"        => "error",
                            "movimiento"    => 1,
                            "mensaje"       => "Se ha presentado un error al devolver la transferencia"
                        );
                    }
                    
                    break;
            
            }

        }
        echo json_encode($data);
    }

    public function guiatrans_ver_pdf($codigo, $format = "print", $img = 0)
    {
        switch ($format) {
            case "print":
                $this->guiatrans_print($codigo, $img);
                break;
            case "pdf":
                $this->guiatrans_pdf($codigo, $img);
                break;
            default:
                $this->guiatrans_pdf($codigo, $img);
                break;
        }
    }

    public function guiatrans_pdf($codigo, $flagPdf = 0, $enviarcorreo = false)
    {
        $this->lib_props->guiatrans_pdf($codigo, $flagPdf, $enviarcorreo);
        return NULL;
    }

    public function anular_trasnferencia(){
         $compania = $this->somevar['compania'];
         $codigo = $this->input->post('codigo');
         $response = $this->guiatrans_model->eliminar($codigo);
         return $response;
    }

    public function disminuir_stock($filter)
    {
        
        $AlmacenOrigen                  = $filter->GTRANC_AlmacenOrigen;
        $codigo                         = $filter->GTRANP_Codigo;
        $stock_actualizado              = 0;

        $detalle_comprobante            = $this->guiatransdetalle_model->listar($codigo);
        $done = false;
        if ($detalle_comprobante>0) {
            foreach ($detalle_comprobante as $key => $value) {
               $cantidad = $value->GTRANDETC_Cantidad;
               $producto = $value->PROD_Codigo;
               //obtenemos los datos del producto en el almacen
               $datosAlmacenProducto = $this->almacenproducto_model->obtener($AlmacenOrigen, $producto);

               if ($datosAlmacenProducto) {
                    $stock = $datosAlmacenProducto[0]->ALMPROD_Stock;
                    $stock_actualizado = $stock - $cantidad;
                    $filter_dism = new stdClass();
                    $filter_dism->ALMPROD_Stock  = $stock_actualizado;
                    $filter_dism->COMPP_Codigo   = $filter->COMPP_Codigo;
                    $filter_dism->ALMAC_Codigo   = $AlmacenOrigen;
                    $filter_dism->PROD_Codigo    = $producto;
                    $filter_dism->ALMPROD_Codigo = $datosAlmacenProducto[0]->ALMPROD_Codigo;
                    $filter_dism->ALMPROD_FechaModificacion    = date('Y-m-d H:i:s');
                    $done = $this->guiatrans_model->actualizar_stock($filter_dism);
               }else{
                    $this->inventario_model->confirmInventariado($producto, $AlmacenOrigen);
                    $datosAlmacenProducto = $this->almacenproducto_model->obtener($AlmacenOrigen, $producto);
                    $stock = $datosAlmacenProducto[0]->ALMPROD_Stock;
                    $stock_actualizado = $stock - $cantidad;
                    $filter_dism = new stdClass();
                    $filter_dism->ALMPROD_Stock  = $stock_actualizado;
                    $filter_dism->COMPP_Codigo   = $filter->COMPP_Codigo;
                    $filter_dism->ALMAC_Codigo   = $AlmacenOrigen;
                    $filter_dism->PROD_Codigo    = $producto;
                    $filter_dism->ALMPROD_Codigo = $datosAlmacenProducto[0]->ALMPROD_Codigo;
                    $filter_dism->ALMPROD_FechaModificacion    = date('Y-m-d H:i:s');
                    $done = $this->guiatrans_model->actualizar_stock($filter_dism);
               }
                ############################
                # REGISTRO DE KARDEX
                ############################
                $cKardex = new stdClass();
                $cKardex->codigo_documento  = $codigo;
                $cKardex->tipo_docu         = "T";
                $cKardex->producto          = $producto;
                $cKardex->nombre_producto   = $value->GTRANDETC_Descripcion;
                $cKardex->cantidad          = $cantidad;
                $cKardex->serie             = $filter->GTRANC_Serie;
                $cKardex->numero            = $filter->GTRANC_Numero;
                $cKardex->nombre_almacen    = NULL; #opcionales (para futuro desarrollo)
                $cKardex->moneda            = NULL;
                $cKardex->afectacion        = NULL;
                $cKardex->costo             = NULL;
                $cKardex->precio_con_igv    = NULL;
                $cKardex->subtotal          = NULL;
                $cKardex->total             = NULL;
                $cKardex->compania          = $filter->COMPP_Codigo;
                $cKardex->tipo_oper         = 1; # 1: SALIDA 2: INGRESO 
                $cKardex->tipo_movimiento   = "SALIDA POR TRANSFERENCIA";
                $cKardex->nombre            = NULL; #opcionales (para futuro desarrollo)
                $cKardex->numdoc            = NULL; #opcionales (para futuro desarrollo)
                $cKardex->almacen           = $AlmacenOrigen;
                $cKardex->cliente           = NULL;
                $cKardex->proveedor         = NULL;
                $cKardex->usuario           = $filter->GTRANC_CodigoUsuario; #Nombre o codigo?
                $cKardex->estado            = 1;
                $this->registrar_kardex($cKardex);
            }
        }
        return $done;
    }

    public function aumentar_stock($filter)
    {
        
        $AlmacenDestino                 = $filter->GTRANC_AlmacenDestino;
        $codigo                         = $filter->GTRANP_Codigo;
        $stock_actualizado              = 0;

        $detalle_comprobante            = $this->guiatransdetalle_model->listar($codigo);
        $done = false;
        if ($detalle_comprobante>0) {
            foreach ($detalle_comprobante as $key => $value) {
               $cantidad = $value->GTRANDETC_Cantidad;
               $producto = $value->PROD_Codigo;
               //obtenemos los datos del producto en el almacen
               $datosAlmacenProducto = $this->almacenproducto_model->obtener($AlmacenDestino, $producto);

               if ($datosAlmacenProducto) {
                    $stock = $datosAlmacenProducto[0]->ALMPROD_Stock;
                    $stock_actualizado = $stock + $cantidad;
                    $filter_dism = new stdClass();
                    $filter_dism->ALMPROD_Stock  = $stock_actualizado;
                    $filter_dism->COMPP_Codigo   = $filter->COMPP_Codigo;
                    $filter_dism->ALMAC_Codigo   = $AlmacenDestino;
                    $filter_dism->PROD_Codigo    = $producto;
                    $filter_dism->ALMPROD_Codigo = $datosAlmacenProducto[0]->ALMPROD_Codigo;
                    $filter_dism->ALMPROD_FechaModificacion    = date('Y-m-d H:i:s');
                    $done = $this->guiatrans_model->actualizar_stock($filter_dism);
               }else{
                    $this->inventario_model->confirmInventariado($producto, $AlmacenDestino);
                    $datosAlmacenProducto = $this->almacenproducto_model->obtener($AlmacenDestino, $producto);
                    $stock = $datosAlmacenProducto[0]->ALMPROD_Stock;
                    $stock_actualizado = $stock + $cantidad;
                    $filter_dism = new stdClass();
                    $filter_dism->ALMPROD_Stock  = $stock_actualizado;
                    $filter_dism->COMPP_Codigo   = $filter->COMPP_Codigo;
                    $filter_dism->ALMAC_Codigo   = $AlmacenDestino;
                    $filter_dism->PROD_Codigo    = $producto;
                    $filter_dism->ALMPROD_Codigo = $datosAlmacenProducto[0]->ALMPROD_Codigo;
                    $filter_dism->ALMPROD_FechaModificacion    = date('Y-m-d H:i:s');
                    $done = $this->guiatrans_model->actualizar_stock($filter_dism);
               }
                ############################
                # REGISTRO DE KARDEX
                ############################
                $cKardex = new stdClass();
                $cKardex->codigo_documento  = $codigo;
                $cKardex->tipo_docu         = "T";
                $cKardex->producto          = $producto;
                $cKardex->nombre_producto   = $value->GTRANDETC_Descripcion;
                $cKardex->cantidad          = $cantidad;
                $cKardex->serie             = $filter->GTRANC_Serie;
                $cKardex->numero            = $filter->GTRANC_Numero;
                $cKardex->nombre_almacen    = NULL; #opcionales (para futuro desarrollo)
                $cKardex->afectacion        = NULL;
                $cKardex->costo             = NULL;
                $cKardex->precio_con_igv    = NULL;
                $cKardex->subtotal          = NULL;
                $cKardex->total             = NULL;
                $cKardex->compania          = $filter->COMPP_Codigo;
                $cKardex->tipo_oper         = 2; # 1: SALIDA 2: INGRESO 
                $cKardex->tipo_movimiento   = "ENTRADA POR TRANSFERENCIA";
                $cKardex->nombre            = NULL; #opcionales (para futuro desarrollo)
                $cKardex->numdoc            = NULL; #opcionales (para futuro desarrollo)
                $cKardex->almacen           = $AlmacenDestino;
                $cKardex->cliente           = NULL;
                $cKardex->proveedor         = NULL;
                $cKardex->usuario           = $filter->GTRANC_CodigoUsuario; #Nombre o codigo?
                $cKardex->estado            = 1;
                $this->registrar_kardex($cKardex);

            }
        }
        return $done;
    }

    public function devolucion_origen($filter)
    {
        
        $AlmacenOrigen                  = $filter->GTRANC_AlmacenOrigen;
        $codigo                         = $filter->GTRANP_Codigo;
        $stock_actualizado              = 0;

        $detalle_comprobante            = $this->guiatransdetalle_model->listar($codigo);
        $done = false;
        if ($detalle_comprobante>0) {
            foreach ($detalle_comprobante as $key => $value) {
               $cantidad = $value->GTRANDETC_Cantidad;
               $producto = $value->PROD_Codigo;
               //obtenemos los datos del producto en el almacen
               $datosAlmacenProducto = $this->almacenproducto_model->obtener($AlmacenOrigen, $producto);

               if ($datosAlmacenProducto) {
                    $stock = $datosAlmacenProducto[0]->ALMPROD_Stock;
                    $stock_actualizado = $stock + $cantidad;
                    $filter_dism = new stdClass();
                    $filter_dism->ALMPROD_Stock  = $stock_actualizado;
                    $filter_dism->COMPP_Codigo   = $filter->COMPP_Codigo;
                    $filter_dism->ALMAC_Codigo   = $AlmacenOrigen;
                    $filter_dism->PROD_Codigo    = $producto;
                    $filter_dism->ALMPROD_FechaModificacion    = date('Y-m-d H:i:s');
                    $filter_dism->ALMPROD_Codigo = $datosAlmacenProducto[0]->ALMPROD_Codigo;
                    $done = $this->guiatrans_model->actualizar_stock($filter_dism);
               }else{
                    $this->inventario_model->confirmInventariado($producto, $AlmacenOrigen);
                    $datosAlmacenProducto = $this->almacenproducto_model->obtener($AlmacenOrigen, $producto);
                    $stock = $datosAlmacenProducto[0]->ALMPROD_Stock;
                    $stock_actualizado = $stock + $cantidad;
                    $filter_dism = new stdClass();
                    $filter_dism->ALMPROD_Stock  = $stock_actualizado;
                    $filter_dism->COMPP_Codigo   = $filter->COMPP_Codigo;
                    $filter_dism->ALMAC_Codigo   = $AlmacenOrigen;
                    $filter_dism->PROD_Codigo    = $producto;
                    $filter_dism->ALMPROD_Codigo = $datosAlmacenProducto[0]->ALMPROD_Codigo;
                    $filter_dism->ALMPROD_FechaModificacion    = date('Y-m-d H:i:s');
                    $done = $this->guiatrans_model->actualizar_stock($filter_dism);
               }
                ############################
                # REGISTRO DE KARDEX
                ############################
                $cKardex = new stdClass();
                $cKardex->codigo_documento  = $codigo;
                $cKardex->tipo_docu         = "T";
                $cKardex->producto          = $producto;
                $cKardex->nombre_producto   = $value->GTRANDETC_Descripcion;
                $cKardex->cantidad          = $cantidad;
                $cKardex->serie             = $filter->GTRANC_Serie;
                $cKardex->numero            = $filter->GTRANC_Numero;
                $cKardex->nombre_almacen    = NULL; #opcionales (para futuro desarrollo)
                $cKardex->afectacion        = NULL;
                $cKardex->costo             = NULL;
                $cKardex->precio_con_igv    = NULL;
                $cKardex->subtotal          = NULL;
                $cKardex->total             = NULL;
                $cKardex->compania          = $filter->COMPP_Codigo;
                $cKardex->tipo_oper         = 2; # 1: SALIDA 2: INGRESO 
                $cKardex->tipo_movimiento   = "ENTRADA POR DEVOLUCION";
                $cKardex->nombre            = ""; #opcionales (para futuro desarrollo)
                $cKardex->numdoc            = ""; #opcionales (para futuro desarrollo)
                $cKardex->almacen           = $AlmacenOrigen;
                $cKardex->cliente           = NULL;
                $cKardex->proveedor         = NULL;
                $cKardex->usuario           = $filter->GTRANC_CodigoUsuario; #Nombre o codigo?
                $cKardex->estado            = 1;
                $this->registrar_kardex($cKardex);

            }
        }
        return $done;
    }

    public function seleccionar_destino_general($sel = NULL)
    {
        $almacen = $this->almacen_model->seleccionar_destino_general();

        $option = "";
        $emp = "";
        $j = 0;

        if ( count($almacen) > 0){
            $option .= "<select name='almacen_destino' id='almacen_destino' class='comboGrande'>";
            foreach ($almacen as $indice => $val) {
                if ($val->EMPRP_Codigo != $emp){
                    $emp = $val->EMPRP_Codigo;
                   
                    if ($j > 0)
                        $option .= "</optgroup>";

                    $option .= "<optgroup label='$val->EMPRC_RazonSocial'>";
                }

                $option .= ($sel != NULL AND $sel == $val->ALMAP_Codigo) ? "<option value='$val->ALMAP_Codigo' selected>$val->EESTABC_Descripcion - $val->ALMAC_Descripcion</option>" : "<option value='$val->ALMAP_Codigo'>$val->EESTABC_Descripcion - $val->ALMAC_Descripcion</option>";
                $j++;
            }
            $option .= "</optgroup>";
            $option .= "</select>";
        }
        return $option;
    }

    public function registrar_kardex($filter)
    {
        $cKardex = new stdClass();
        
        $cKardex->KARDC_CodigoDoc       = $filter->codigo_documento;
        $cKardex->DOCUP_Codigo          = $filter->tipo_docu;
        $cKardex->PROD_Codigo           = $filter->producto;
        $cKardex->PROD_Descripcion      = $filter->nombre_producto; #opcionales (para futuro desarrollo)
        $cKardex->KARDC_Cantidad        = $filter->cantidad;
        $cKardex->KARDC_Serie           = $filter->serie;
        $cKardex->KARDC_Numero          = $filter->numero;
        $cKardex->KARDC_AlmacenDesc     = $filter->nombre_almacen; #opcionales (para futuro desarrollo)
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
        $this->kardex_model->registrar_kardex($cKardex);
    }

}#EOF

?>