<?php
/* *********************************************************************************
Autor: Unknow
Dev: Luis Valdes
Dev: Luis Valdes
/* ******************************************************************************** */
class Inventario extends Controller
{
    private $compania;
    private $usuario;
    private $persona;
    private $persona_nombre;
    private $url;
    private $nombre_establec;
    private $nombre_empresa;

    public function __construct()
    {
        parent::Controller();
        $this->load->helper('form');
        $this->load->helper('date');
        $this->load->helper('util');
        $this->load->helper('utf_helper');
        $this->load->helper('my_permiso');
        $this->load->helper('my_almacen');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('html');
        $this->load->library('pagination');
        $this->load->library('layout', 'layout');
        $this->load->library('lib_props');
        $this->load->model('almacen/guiain_model');
        $this->load->model('almacen/guiaindetalle_model');
        $this->load->model('almacen/inventario_model');
        $this->load->model('almacen/kardex_model');
        $this->load->model('almacen/almacen_model');
        $this->load->model('almacen/almacenproducto_model');

        $this->load->model('almacen/lote_model');
        $this->load->model('almacen/almaprolote_model');

        $this->load->model('almacen/almacenproductoserie_model');
        $this->load->model('almacen/Serie_model');
        $this->load->model('almacen/seriedocumento_model');

        $this->load->model('almacen/Seriemov_model');
        $this->load->model('maestros/directivo_model');
        $this->load->model('maestros/configuracion_model');

        $this->compania         = $this->session->userdata('compania');
        $this->usuario          = $this->session->userdata('user');
        $this->persona          = $this->session->userdata('persona');
        $this->persona_nombre   = $this->session->userdata('nombre_persona');
        $this->nombre_establec  = $this->session->userdata('nombre_establec');
        $this->nombre_empresa   = $this->session->userdata('nombre_empresa');
        $this->url = base_url();

        date_default_timezone_set('America/Lima');
    }

    public function listar()
    {

        $filter = new stdClass();
        $filter->dir            = "ASC";
        $filter->order          = "ALMAC_Descripcion";
        $filter->order          = "PERSC_Nombre";
        $data["almacenes"]      = $this->almacen_model->getAlmacens($filter);
        $data["personal"]       = $this->directivo_model->getDirectivos($filter);
        $data["persona_id"]     = $this->persona;
        $data["persona_nombre"] = $this->persona_nombre;
        $data["fecha"]          = date('Y-m-d');
        $data["serie"]          = "INV0" . $this->compania;
        $data["compania"]       = $this->compania;
        $data["comp_inicial"]   = $this->compania;
        $data["base_url"]       = $this->url;

        $this->layout->view('almacen/inventario_index', $data);
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function dtInventarios()
    {
        $posDT = -1;
        $columnas = array(
            ++$posDT => "INVE_Numero",
            ++$posDT => "ALMAC_Descripcion",
            ++$posDT => "INVE_FechaRegistro",
            ++$posDT => ""
        );

        $filter = new stdClass();
        $filter->start  = $this->input->post("start");
        $filter->length = $this->input->post("length");
        $filter->search = $this->input->post("search")["value"];

        $ordenar = $this->input->post("order")[0]["column"];
        if ($ordenar != "") {
            $filter->order  = $columnas[$ordenar];
            $filter->dir    = $this->input->post("order")[0]["dir"];
        }

        $filter->serie          = trim($this->input->post('serie'));
        $filter->numero         = ltrim($this->input->post('numero'), '0');
        $filter->fechaDesde     = $this->input->post('fechaDesde');
        $filter->fechaHasta     = $this->input->post('fechaHasta');
        $filter->responsable    = $this->input->post('responsable');
        $filter->almacen        = $this->input->post('almacen');
        $filter->producto       = $this->input->post('producto');

        $ajustesInfo = $this->inventario_model->getInventarios($filter, false);
        $records = array();
        // ############################# BEGINT aldo  ###########################
        $this->load->library('session');
        $rol = $this->session->userdata('rol');
        $rolEntero = intval($rol);
        // ############################# END  ###########################

        if ($ajustesInfo["records"] != NULL) {
            foreach ($ajustesInfo["records"] as $col) {
                // ############################# BEGINT aldo ###########################
                if ($rol == 7000) {
                    $btn_modal ="<button type='button' id='btn-editar-" . $col->INVE_Codigo . "' onclick='editar($col->INVE_Codigo)' class='btn btn-default'><img src='" . $this->url . "/images/icono_nuevo.png' class='image-size-1b'></button>" ;
                } 
                // ############################# END  ###########################
                
                $btn_load = ($col->INVE_FlagActivacion == "2") ? "<div id='div-btn-load-" . $col->INVE_Codigo . "'><button type='button' id='btn-load-" . $col->INVE_Codigo . "' onclick='modalCargarInventario($col->INVE_Codigo, $col->ALMAP_Codigo)' class='btn btn-default'>
                <img src='" . $this->url . "/images/excel.png' class='image-size-1b'>
                </button></div>" : "<button type='button' onclick='downloadCargados($col->INVE_Codigo)' class='btn btn-default'>
                <img src='" . $this->url . "/images/excel.png' class='image-size-1b'>
                </button>";

                $btn_details = "<button type='button' onclick='details($col->INVE_Codigo)' class='btn btn-default'>
                <img src='" . $this->url . "/images/icono_buscar.png' class='image-size-1b'>
                </button>";

                //$btn_aprobar = ($col->INVE_FlagActivacion == "2") ? "<button type='button' onclick='aprobar($col->INVE_Codigo)' class='btn btn-primary'>Aprobar</button>" : "<img src='" . $this->url . "/images/icono_aprobar.png' class='image-size-1b'/>";

                $responsablesInfo = $this->inventario_model->getInventarioResp($col->INVE_Codigo);
                $responsable = "";
                if ($responsablesInfo != NULL) {
                    foreach ($responsablesInfo as $i => $val) {
                        $responsable .= "<p>" . ($i + 1) . " - $val->PERSC_Nombre $val->PERSC_ApellidoPaterno</p>";
                    }
                }

                $fecha = explode(" ", $col->INVE_FechaInicio);

                $posDT = -1;
                $records[] = array(
                    ++$posDT => mysql_to_human($fecha[0]),
                    ++$posDT => $col->INVE_Serie . "-" . $this->lib_props->getNumberFormat($col->INVE_Numero, 6),
                    ++$posDT => $col->INVE_Titulo,
                    ++$posDT => $col->ALMAC_Descripcion,
                    ++$posDT => $btn_modal,
                    ++$posDT => $btn_load,
                    ++$posDT => $btn_details
                );
            }
        }

        $recordsTotal = ($ajustesInfo["recordsTotal"] != NULL) ? $ajustesInfo["recordsTotal"] : 0;
        $recordsFilter = $ajustesInfo["recordsFilter"];

        $json = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFilter,
            "data"            => $records
        );

        die(json_encode($json));
    }

    public function searchProductoBarcode($response = "json", $request = NULL)
    {
        $valDefault = "codigo";
        $filter = new stdClass();
    
        $almacen = trim($this->input->post("almacen"));

        $filter->start = 0;
        $filter->length = 15;
        $filter->cod_producto = trim($this->input->post("codigo"));
        $filter->PROD_FlagBienServicio = "B";
        
        $json = array();
        $productosInfo = $producto = $this->producto_model->search_barcode($filter);
        //var_dump($productosInfo);exit();
        if ($productosInfo != NULL) {
            foreach ($productosInfo as $row => $col) {
                
                $stockInfo = $this->almacenproducto_model->obtener($almacen, $col->PROD_Codigo);
                $json[] = array(
                    "result"=> "success",
                    "value" => ($valDefault == "codigo") ? $col->PROD_CodigoUsuario : $col->PROD_Nombre,
                    "label" => $col->PROD_CodigoUsuario . " - " . $col->PROD_Nombre,
                    "id" => $col->PROD_Codigo,
                    "codigo" => $col->PROD_CodigoUsuario,
                    "nombre" => $col->PROD_Nombre,
                    "stock" => ($stockInfo != NULL) ? $stockInfo[0]->ALMPROD_Stock : 0,
                    "almacen" => $almacen,
                    "flagBS" => $col->PROD_FlagBienServicio
                );
            }
        }else{
            $json[] = array("result"=> "nofound");
        }
        die(json_encode($json));
    }

    public function guardarInventario()
    {

        $id = $this->input->post("ajuste");
        $compania               = $this->input->post("comp_inicial");
        $serieFormAjuste        = $this->input->post("serieFormAjuste");
        $numeroFormAjuste       = $this->input->post("numeroFormAjuste");
        $almacenFormAjuste      = $this->input->post("almacenFormAjuste");
        $movimientoFormAjuste   = $this->input->post("movimientoFormAjuste");
        $titulo_inventario      = $this->input->post("titulo_inventario");
        $fecha_inicio           = $this->input->post("fecha");

        $ajuste_ids             = $this->input->post("ajuste_ids");
        $ajuste_producto        = $this->input->post("ajuste_producto");
        $ajuste_cantidad        = $this->input->post("ajuste_cantidad");
        $ajuste_flags           = $this->input->post("ajuste_flags");
        $responsable            = $this->input->post("responsable_prd");

        /** HEADER **/
        $filter = new stdClass();
        //$filter->INVA_TipoMovimiento = $movimientoFormAjuste;
        $filter->ALMAP_Codigo       = $almacenFormAjuste;
        $filter->COMPP_Codigo       = trim($compania);
        $filter->INVE_FlagEstado    = "1";

        /** DETAILS **/
        $details = new stdClass();
        $details->almacen       = $almacenFormAjuste;
        $details->ajusteDT      = $ajuste_ids;
        $details->producto      = $ajuste_producto;
        $details->cantidad      = $ajuste_cantidad;
        $details->flag          = $ajuste_flags;
        $details->responsable   = $responsable;
        $details->compania      = $compania;
        

        /** RESPONSABLE **/
        $resp = new stdClass();
        $resp->PERSP_Codigo = $this->persona;
        $resp->INVER_FechaRegistro = date("Y-m-d H:i:s");
        $resp->INVER_Observacion = $this->input->post("observacionFormAjuste");

        if ($id != NULL && $id != "") {
            $filter->INVE_FechaModificacion = date("Y-m-d H:i:s");
            $update = $this->inventario_model->actualizarInventario($id, $filter);

            if ($update) {
                $json_result = "success";
                $json_message = "Ajuste actualizado";

                $resp->INVE_Codigo  = $id;
                $this->inventario_model->guardarInventarioResponsable($resp);
                $details->ajuste    = $id;
                $details->serie     = $serieFormAjuste;
                $details->numero    = $numeroFormAjuste;
                $this->setInventoryDetails($details);
            } else {
                $json_result    = "error";
                $json_message   = "Error al actualizar el registro, intentelo nuevamente.";
            }
        } else {
            $correlativo = $this->inventario_model->correlativoInventario($compania);
            $filter->INVE_Titulo        = $titulo_inventario;
            $filter->INVE_Serie         = $serieFormAjuste;
            $filter->INVE_Numero        = ++$correlativo;
            $filter->INVE_FechaInicio   = date($fecha_inicio." H:i:s");
            $filter->INVE_FechaRegistro = date($fecha_inicio." H:i:s");
            $details->serie             = $filter->INVE_Serie;
            $details->numero            = $filter->INVE_Numero;
            $id = $this->inventario_model->guardarInventario($filter);

            if ($id) {
                $json_result = "success";
                $json_message = "Ajuste registrado";

                $resp->INVE_Codigo = $id;
                $this->inventario_model->guardarInventarioResponsable($resp);

                $details->ajuste = $id;
                $this->setInventoryDetails($details);
            } else {
                $json_result = "error";
                $json_message = "Error al guardar el registro, intentelo nuevamente.";
            }
        }

        $json = array("result" => $json_result, "message" => $json_message);
        die(json_encode($json));
    }

    private function guardarInventarioDetalle($val)
    {
        $error = false;
        $size = count($val->producto);
        if ($size > 0) {
            for ($i = 0; $i < $size; $i++) {
                $colDetalles = new stdClass();
                $colDetalles->INVE_Codigo   = $val->ajuste;
                $colDetalles->PROD_Codigo   = $val->producto[$i];
                $colDetalles->INVD_Cantidad = $val->cantidad[$i];
                $compania                   = $val->compania;
                $stockInfo = $this->almacenproducto_model->obtener($val->almacen, $val->producto[$i]);
                
                $colDetalles->INVD_FlagActivacion   = $val->flag[$i];

                if ($colDetalles->INVD_Cantidad>0 && $val->flag[$i] == "1") {
                    if ($val->ajusteDT[$i] == "") {
                        if ($val->flag[$i] == "1") {
                            $colDetalles->INVD_FechaRegistro = date("Y-m-d H:i:s");
                            $this->inventario_model->guardarInventarioDetalle($colDetalles);
                            $datosAlmacenProducto = $this->almacenproducto_model->obtener($val->almacen, $colDetalles->PROD_Codigo);

                            if ($datosAlmacenProducto) {
                                //SI EXISTE EN EL ALMACEN SE REEMPLAZA LA CANTIDAD
                                $almaprod               = $datosAlmacenProducto[0]->ALMPROD_Codigo;
                                $stockU                 = new stdClass();
                                $stockU->ALMPROD_Stock  = $colDetalles->INVD_Cantidad;
                                $resultado              = $this->inventario_model->reemplazarAjusteStock($almaprod, $stockU);
                            }else{
                                //SI NO EXISTE SE REGISTRA EL PRODUCTO EN EL ALMACEN CON LOS DATOS INGRESADOS
                                $newAlmac = new stdClass();
                                $newAlmac->COMPP_Codigo             = $compania;
                                $newAlmac->ALMAC_Codigo             = $val->almacen;
                                $newAlmac->PROD_Codigo              = $colDetalles->PROD_Codigo;
                                $newAlmac->ALMPROD_Stock            = $colDetalles->INVD_Cantidad;
                                $newAlmac->ALMPROD_CostoPromedio    = 0;
                                $this->inventario_model->nuevoEnAlmacen($newAlmac);
                            }
                            ############################
                            # REGISTRO DE KARDEX
                            ############################
                            $cKardex = new stdClass();
                            $cKardex->codigo_documento  = $val->ajuste;
                            $cKardex->tipo_docu         = "I";
                            $cKardex->producto          = $colDetalles->PROD_Codigo;
                            $cKardex->nombre_producto   = NULL;
                            $cKardex->cantidad          = $colDetalles->INVD_Cantidad;
                            $cKardex->serie             = $val->serie;
                            $cKardex->numero            = $val->numero;
                            $cKardex->nombre_almacen    = NULL; #opcionales (para futuro desarrollo)
                            $cKardex->moneda            = NULL;
                            $cKardex->afectacion        = NULL;
                            $cKardex->costo             = NULL;
                            $cKardex->precio_con_igv    = NULL;
                            $cKardex->subtotal          = NULL;
                            $cKardex->total             = NULL;
                            $cKardex->compania          = $compania;
                            $cKardex->tipo_oper         = 1; # 1: Reemplazo 2: Suma 
                            $cKardex->tipo_movimiento   = "INGRESO POR INVENTARIO";
                            $cKardex->nombre            = NULL; #opcionales (para futuro desarrollo)
                            $cKardex->numdoc            = NULL; #opcionales (para futuro desarrollo)
                            $cKardex->almacen           = $val->almacen;
                            $cKardex->cliente           = NULL;
                            $cKardex->proveedor         = NULL;
                            $cKardex->usuario           = $this->usuario; #Nombre o codigo?
                            $cKardex->estado            = 1;
                            $this->registrar_kardex($cKardex);
                        }
                    } else {
                        //SUMA LA CANTIDAD EXISTENTE EN EL INVENTARIO
                        $colDetalles->INVD_FechaModificacion = date("Y-m-d H:i:s");
                        $this->inventario_model->actualizarInventarioCantidad($val->ajusteDT[$i], $colDetalles->INVD_Cantidad);

                        //SUMA LA CANTIDAD EXISTENTE EN EL ALMACEN
                        $datosAlmacenProducto = $this->almacenproducto_model->obtener($val->almacen, $colDetalles->PROD_Codigo);

                        if ($datosAlmacenProducto) {
                            $almaprod = $datosAlmacenProducto[0]->ALMPROD_Codigo;
                            $this->inventario_model->actualizarAjusteStock($almaprod, $colDetalles->INVD_Cantidad);
                        }else{
                            //SE REGISTRA EL PRODUCTO EN EL ALMACEN CON LOS DATOS INGRESADOS
                            $newAlmac = new stdClass();
                            $newAlmac->COMPP_Codigo             = $compania;
                            $newAlmac->ALMAC_Codigo             = $val->almacen;
                            $newAlmac->PROD_Codigo              = $colDetalles->PROD_Codigo;
                            $newAlmac->ALMPROD_Stock            = $colDetalles->INVD_Cantidad;
                            $newAlmac->ALMPROD_CostoPromedio    = 0;
                            $this->inventario_model->nuevoEnAlmacen($newAlmac);
                            
                        }
                        ############################
                        # REGISTRO DE KARDEX
                        ############################
                        $cKardex = new stdClass();
                        $cKardex->codigo_documento  = $val->ajuste;
                        $cKardex->tipo_docu         = "I";
                        $cKardex->producto          = $colDetalles->PROD_Codigo;
                        $cKardex->nombre_producto   = NULL;
                        $cKardex->cantidad          = $colDetalles->INVD_Cantidad;
                        $cKardex->serie             = $val->serie;
                        $cKardex->numero            = $val->numero;
                        $cKardex->nombre_almacen    = NULL; #opcionales (para futuro desarrollo)
                        $cKardex->moneda            = NULL;
                        $cKardex->afectacion        = NULL;
                        $cKardex->costo             = NULL;
                        $cKardex->precio_con_igv    = NULL;
                        $cKardex->subtotal          = NULL;
                        $cKardex->total             = NULL;
                        $cKardex->compania          = $compania;
                        $cKardex->tipo_oper         = 2; # 1: Reemplazo 2: Suma 
                        $cKardex->tipo_movimiento   = "SUMA POR INVENTARIO";
                        $cKardex->nombre            = NULL; #opcionales (para futuro desarrollo)
                        $cKardex->numdoc            = NULL; #opcionales (para futuro desarrollo)
                        $cKardex->almacen           = $val->almacen;
                        $cKardex->cliente           = NULL;
                        $cKardex->proveedor         = NULL;
                        $cKardex->usuario           = $this->usuario; #Nombre o codigo?
                        $cKardex->estado            = 1;
                        $this->registrar_kardex($cKardex);
                    }
                    
                }else{
                    $flagdetalle = new stdClass();
                    $flagdetalle->INVD_FlagActivacion = $val->flag[$i];
                    $flagdetalle->INVD_FechaModificacion = date("Y-m-d H:i:s");
                    $this->inventario_model->actualizarInventarioDetalle($val->ajusteDT[$i],$flagdetalle);
                    
                }
            }
        }
    }

    private function setInventoryDetails($val)
    {
        $error = false;
        $size = count($val->producto);
        if ($size > 0) {
            for ($i = 0; $i < $size; $i++) {
                $colDetalles = new stdClass();
                $colDetalles->INVE_Codigo   = $val->ajuste;
                $colDetalles->PROD_Codigo   = $val->producto[$i];
                $colDetalles->INVD_Cantidad = $val->cantidad[$i];
                $compania                   = $val->compania;
                $stockInfo = $this->almacenproducto_model->obtener($val->almacen, $val->producto[$i]);
                
                $colDetalles->INVD_FlagActivacion   = $val->flag[$i];

                if ($colDetalles->INVD_Cantidad>=0 && $val->flag[$i] == "1") {
                    if ($val->ajusteDT[$i] == "") {
                        if ($val->flag[$i] == "1") {
                            $colDetalles->INVD_FechaRegistro = date("Y-m-d H:i:s");
                            $this->inventario_model->guardarInventarioDetalle($colDetalles);
                            $datosAlmacenProducto = $this->almacenproducto_model->obtener($val->almacen, $colDetalles->PROD_Codigo);

                            if ($datosAlmacenProducto) {
                                //SI EXISTE EN EL ALMACEN SE REEMPLAZA LA CANTIDAD
                                $almaprod               = $datosAlmacenProducto[0]->ALMPROD_Codigo;
                                $stockU                 = new stdClass();
                                $stockU->ALMPROD_Stock  = $colDetalles->INVD_Cantidad;
                                $resultado              = $this->inventario_model->reemplazarAjusteStock($almaprod, $stockU);
                            }else{
                                //SI NO EXISTE SE REGISTRA EL PRODUCTO EN EL ALMACEN CON LOS DATOS INGRESADOS
                                $newAlmac = new stdClass();
                                $newAlmac->COMPP_Codigo             = $compania;
                                $newAlmac->ALMAC_Codigo             = $val->almacen;
                                $newAlmac->PROD_Codigo              = $colDetalles->PROD_Codigo;
                                $newAlmac->ALMPROD_Stock            = $colDetalles->INVD_Cantidad;
                                $newAlmac->ALMPROD_CostoPromedio    = 0;
                                $this->inventario_model->nuevoEnAlmacen($newAlmac);
                            }
                            ############################
                            # REGISTRO DE KARDEX
                            ############################
                            $cKardex = new stdClass();
                            $cKardex->codigo_documento  = $val->ajuste;
                            $cKardex->tipo_docu         = "I";
                            $cKardex->producto          = $colDetalles->PROD_Codigo;
                            $cKardex->nombre_producto   = NULL;
                            $cKardex->cantidad          = $colDetalles->INVD_Cantidad;
                            $cKardex->serie             = $val->serie;
                            $cKardex->numero            = $val->numero;
                            $cKardex->nombre_almacen    = NULL; #opcionales (para futuro desarrollo)
                            $cKardex->moneda            = NULL;
                            $cKardex->afectacion        = NULL;
                            $cKardex->costo             = NULL;
                            $cKardex->precio_con_igv    = NULL;
                            $cKardex->subtotal          = NULL;
                            $cKardex->total             = NULL;
                            $cKardex->compania          = $compania;
                            $cKardex->tipo_oper         = 1; # 1: Reemplazo 2: Suma 
                            $cKardex->tipo_movimiento   = "INGRESO POR INVENTARIO";
                            $cKardex->nombre            = NULL; #opcionales (para futuro desarrollo)
                            $cKardex->numdoc            = NULL; #opcionales (para futuro desarrollo)
                            $cKardex->almacen           = $val->almacen;
                            $cKardex->cliente           = NULL;
                            $cKardex->proveedor         = NULL;
                            $cKardex->usuario           = $this->usuario; #Nombre o codigo?
                            $cKardex->estado            = 1;
                            $this->registrar_kardex($cKardex);
                        }
                    } else {
                        //Para la carga masiva
                        $colDetalles->INVD_FechaModificacion = date("Y-m-d H:i:s");
                        $this->inventario_model->actualizarInventarioCantidad($val->ajusteDT[$i], $colDetalles->INVD_Cantidad);

                        
                        $datosAlmacenProducto = $this->almacenproducto_model->obtener($val->almacen, $colDetalles->PROD_Codigo);

                        if ($datosAlmacenProducto) {
                            $almaprod = $datosAlmacenProducto[0]->ALMPROD_Codigo;
                            $this->inventario_model->actualizarAjusteStock($almaprod, $colDetalles->INVD_Cantidad);
                        }else{
                            //SE REGISTRA EL PRODUCTO EN EL ALMACEN CON LOS DATOS INGRESADOS
                            $newAlmac = new stdClass();
                            $newAlmac->COMPP_Codigo             = $compania;
                            $newAlmac->ALMAC_Codigo             = $val->almacen;
                            $newAlmac->PROD_Codigo              = $colDetalles->PROD_Codigo;
                            $newAlmac->ALMPROD_Stock            = $colDetalles->INVD_Cantidad;
                            $newAlmac->ALMPROD_CostoPromedio    = 0;
                            $this->inventario_model->nuevoEnAlmacen($newAlmac);
                            
                        }
                        ############################
                        # REGISTRO DE KARDEX
                        ############################
                        $cKardex = new stdClass();
                        $cKardex->codigo_documento  = $val->ajuste;
                        $cKardex->tipo_docu         = "I";
                        $cKardex->producto          = $colDetalles->PROD_Codigo;
                        $cKardex->nombre_producto   = NULL;
                        $cKardex->cantidad          = $colDetalles->INVD_Cantidad;
                        $cKardex->serie             = $val->serie;
                        $cKardex->numero            = $val->numero;
                        $cKardex->nombre_almacen    = NULL; #opcionales (para futuro desarrollo)
                        $cKardex->moneda            = NULL;
                        $cKardex->afectacion        = NULL;
                        $cKardex->costo             = NULL;
                        $cKardex->precio_con_igv    = NULL;
                        $cKardex->subtotal          = NULL;
                        $cKardex->total             = NULL;
                        $cKardex->compania          = $compania;
                        $cKardex->tipo_oper         = 2; # 1: Reemplazo 2: Suma 
                        $cKardex->tipo_movimiento   = "INGRESO POR INVENTARIO";
                        $cKardex->nombre            = NULL; #opcionales (para futuro desarrollo)
                        $cKardex->numdoc            = NULL; #opcionales (para futuro desarrollo)
                        $cKardex->almacen           = $val->almacen;
                        $cKardex->cliente           = NULL;
                        $cKardex->proveedor         = NULL;
                        $cKardex->usuario           = $this->usuario; #Nombre o codigo?
                        $cKardex->estado            = 1;
                        $this->registrar_kardex($cKardex);
                    }
                    
                }else{
                    $flagdetalle = new stdClass();
                    $flagdetalle->INVD_FlagActivacion = $val->flag[$i];
                    $flagdetalle->INVD_FechaModificacion = date("Y-m-d H:i:s");
                    $this->inventario_model->actualizarInventarioDetalle($val->ajusteDT[$i],$flagdetalle);
                    
                }
            }
        }
    }

    /** End Luis Valdes **/


    /** Begin Luis Valdes **/
    public function getInventario()
    {
        $ajuste     = $this->input->post("ajuste");
        $ajusteInfo = $this->inventario_model->getInventario($ajuste);

        if ($ajusteInfo != NULL) {
            $detailsInfo    = $this->inventario_model->getInventarioDetalles($ajuste);
            $dAjuste        = array();
            $details        = array();
            $responsable    = array();

            if ($detailsInfo != NULL) {
                foreach ($detailsInfo as $i => $val) {
                    $details[] = array(
                        "registro"              => $val->INVD_Codigo,
                        "producto"              => $val->PROD_Codigo,
                        "codigo"                => $val->PROD_CodigoUsuario,
                        "descripcion"           => $val->PROD_Nombre,
                        "stock"                 => $val->INVD_Cantidad,
                        "fecha_ingreso"         => $val->INVD_FechaRegistro,
                        "cantidad"              => $val->ALMPROD_Stock,
                        "responsable"           => $val->PERSP_Codigo,
                        "responsable_nombre"    => "$val->PERSC_Nombre $val->PERSC_ApellidoPaterno</p>",
                    );
                }
            }

            $responsablesInfo = $this->inventario_model->getInventarioResp($ajuste);
            if ($responsablesInfo != NULL) {
                foreach ($responsablesInfo as $i => $val) {
                    $responsable[] = array(
                        "persona"       => $val->PERSP_Codigo,
                        "nombre"        => "$val->PERSC_Nombre $val->PERSC_ApellidoPaterno</p>",
                        "observacion"   => $val->INVER_Observacion
                    );
                }
            }

            foreach ($ajusteInfo as $i => $val) {
                $dAjuste = array(
                    "ajuste"                    => $val->INVE_Codigo,
                    "movimiento"                => $val->INVE_TipoMovimiento,
                    "movimiento_descripcion"    => $val->movimiento_descripcion,
                    "almacen"                   => $val->ALMAP_Codigo,
                    "almacen_nombre"            => $val->ALMAC_Descripcion,
                    "compania"                  => $val->COMPP_Codigo,
                    "serie"                     => $val->INVE_Serie,
                    "numero"                    => $this->lib_props->getNumberFormat($val->INVE_Numero, 6),
                    "productos"                 => $details,
                    "responsables"              => $responsable,
                    "titulo_inventario"         => $val->INVE_Titulo
                );
                $json = array("match" => true, "info" => $dAjuste);
            }
        } else
            $json = array("match" => false);

        die(json_encode($json));
    }
    /** End Luis Valdes **/


    /** REAJUSTE DE INVENTARIO **/

    /** Begin Luis Valdes **/
    public function reajuste()
    {
        $filter = new stdClass();
        $filter->dir = "ASC";
        $filter->order = "ALMAC_Descripcion";
        $data["almacenes"] = $this->almacen_model->getAlmacens($filter);

        $filter->order = "PERSC_Nombre";
        $data["personal"] = $this->directivo_model->getDirectivos($filter);

        $data["persona_id"] = $this->persona;
        $data["persona_nombre"] = $this->persona_nombre;

        $data["serie"] = "AJ00" . $this->compania;
        $data["base_url"] = $this->url;
        $this->layout->view('almacen/inventario_reajuste', $data);
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function dtReajustes()
    {
        $posDT = -1;
        $columnas = array(
            ++$posDT => "INVA_Numero",
            ++$posDT => "ALMAC_Descripcion",
            ++$posDT => "INVA_FechaRegistro",
            ++$posDT => ""
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

        $filter->serie = trim($this->input->post('serie'));
        $filter->numero = ltrim($this->input->post('numero'), '0');
        $filter->fechaDesde = $this->input->post('fechaDesde');
        $filter->fechaHasta = $this->input->post('fechaHasta');
        $filter->responsable = $this->input->post('responsable');
        $filter->almacen = $this->input->post('almacen');
        $filter->producto = $this->input->post('producto');

        $ajustesInfo = $this->inventario_model->getAjustes($filter, false);
        $records = array();

        if ($ajustesInfo["records"] != NULL) {
            foreach ($ajustesInfo["records"] as $col) {
                $btn_modal = ($col->INVA_FlagEstado == "2") ? "<button type='button' id='btn-editar-" . $col->INVA_Codigo . "' onclick='editar($col->INVA_Codigo)' class='btn btn-default'>
                <img src='" . $this->url . "/images/modificar.png' class='image-size-1b'>
                </button>" : "";

                $btn_load = ($col->INVA_FlagEstado == "2") ? "<div id='div-btn-load-" . $col->INVA_Codigo . "'><button type='button' id='btn-load-" . $col->INVA_Codigo . "' onclick='modalCargarInventario($col->INVA_Codigo, $col->ALMAP_Codigo)' class='btn btn-default'>
                <img src='" . $this->url . "/images/excel.png' class='image-size-1b'>
                </button></div>" : "<button type='button' onclick='downloadCargados($col->INVA_Codigo)' class='btn btn-default'>
                <img src='" . $this->url . "/images/excel.png' class='image-size-1b'>
                </button>";

                $btn_details = "<button type='button' onclick='details($col->INVA_Codigo)' class='btn btn-default'>
                <img src='" . $this->url . "/images/icono-documentos.png' class='image-size-1b'>
                </button>";

                $btn_aprobar = ($col->INVA_FlagEstado == "2") ? "<button type='button' onclick='aprobar($col->INVA_Codigo)' class='btn btn-primary'>Aprobar</button>" : "<img src='" . $this->url . "/images/icono_aprobar.png' class='image-size-1b'/>";

                $responsablesInfo = $this->inventario_model->getAjusteResp($col->INVA_Codigo);
                $responsable = "";
                if ($responsablesInfo != NULL) {
                    foreach ($responsablesInfo as $i => $val) {
                        $responsable .= "<p>" . ($i + 1) . " - $val->PERSC_Nombre $val->PERSC_ApellidoPaterno</p>";
                    }
                }

                $fecha = explode(" ", $col->INVA_FechaRegistro);

                $posDT = -1;
                $records[] = array(
                    ++$posDT => $col->INVA_Serie . "-" . $this->lib_props->getNumberFormat($col->INVA_Numero, 6),
                    ++$posDT => $col->ALMAC_Descripcion,
                    ++$posDT => mysql_to_human($fecha[0]),
                    ++$posDT => $responsable,
                    ++$posDT => $btn_modal,
                    ++$posDT => $btn_load,
                    ++$posDT => $btn_details,
                    ++$posDT => "<div id='btn-estado-" . $col->INVA_Codigo . "' class='text-center'>$btn_aprobar</div>"
                );
            }
        }

        $recordsTotal = ($ajustesInfo["recordsTotal"] != NULL) ? $ajustesInfo["recordsTotal"] : 0;
        $recordsFilter = $ajustesInfo["recordsFilter"];

        $json = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFilter,
            "data"            => $records
        );

        die(json_encode($json));
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function getAjuste()
    {
        $ajuste = $this->input->post("ajuste");
        $ajusteInfo = $this->inventario_model->getAjuste($ajuste);

        if ($ajusteInfo != NULL) {
            $detailsInfo = $this->inventario_model->getAjusteDetails($ajuste);

            $dAjuste = array();
            $details = array();
            $responsable = array();

            if ($detailsInfo != NULL) {
                foreach ($detailsInfo as $i => $val) {
                    $details[] = array(
                        "registro" => $val->INVADET_Codigo,
                        "producto" => $val->PROD_Codigo,
                        "codigo" => $val->PROD_CodigoUsuario,
                        "descripcion" => $val->PROD_Nombre,
                        "stock" => $val->INVADET_Stock,
                        "cantidad" => $val->INVADET_StockAjuste,
                        "responsable" => $val->PERSP_Codigo,
                        "responsable_nombre" => "$val->PERSC_Nombre $val->PERSC_ApellidoPaterno</p>",
                    );
                }
            }

            $responsablesInfo = $this->inventario_model->getAjusteResp($ajuste);
            if ($responsablesInfo != NULL) {
                foreach ($responsablesInfo as $i => $val) {
                    $responsable[] = array(
                        "persona" => $val->PERSP_Codigo,
                        "nombre" => "$val->PERSC_Nombre $val->PERSC_ApellidoPaterno</p>",
                        "observacion" => $val->INVAR_Observacion
                    );
                }
            }

            foreach ($ajusteInfo as $i => $val) {
                $dAjuste = array(
                    "ajuste" => $val->INVA_Codigo,
                    "movimiento" => $val->INVA_TipoMovimiento,
                    "movimiento_descripcion" => $val->movimiento_descripcion,
                    "almacen" => $val->ALMAP_Codigo,
                    "almacen_nombre" => $val->ALMAC_Descripcion,
                    "compania" => $val->COMPP_Codigo,
                    "serie" => $val->INVA_Serie,
                    "numero" => $this->lib_props->getNumberFormat($val->INVA_Numero, 6),
                    "productos" => $details,
                    "responsables" => $responsable,
                    "observacion" =>$val->INVAR_Observacion,
                );
                $json = array("match" => true, "info" => $dAjuste);
            }
        } else
            $json = array("match" => false);

        die(json_encode($json));
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function guardarReajuste()
    {

        $id = $this->input->post("ajuste");
        $serieFormAjuste = $this->input->post("serieFormAjuste");
        $numeroFormAjuste = $this->input->post("numeroFormAjuste");
        $almacenFormAjuste = $this->input->post("almacenFormAjuste");
        $movimientoFormAjuste = $this->input->post("movimientoFormAjuste");

        $ajuste_ids = $this->input->post("ajuste_ids");
        $ajuste_producto = $this->input->post("ajuste_producto");
        $ajuste_cantidad = $this->input->post("ajuste_cantidad");
        $ajuste_flags = $this->input->post("ajuste_flags");
        $responsable = $this->input->post("responsable_prd");

        /** HEADER **/
        $filter = new stdClass();
        $filter->ALMAP_Codigo = $almacenFormAjuste;
        $filter->INVA_TipoMovimiento = $movimientoFormAjuste;
        $filter->COMPP_Codigo = trim($this->compania);
        $filter->INVA_FlagEstado = "2";

        /** DETAILS **/
        $details = new stdClass();
        $details->almacen = $almacenFormAjuste;
        $details->ajusteDT = $ajuste_ids;
        $details->producto = $ajuste_producto;
        $details->cantidad = $ajuste_cantidad;
        $details->flag = $ajuste_flags;
        $details->responsable = $responsable;

        /** RESPONSABLE **/
        $resp = new stdClass();
        $resp->PERSP_Codigo = $this->input->post("responsableFormAjuste");
        $resp->INVAR_FechaRegistro = date("Y-m-d H:i:s");
        $resp->INVAR_Observacion = $this->input->post("observacionFormAjuste");

        if ($id != NULL && $id != "") {
            $filter->INVA_FechaModificacion = date("Y-m-d H:i:s");
            $update = $this->inventario_model->actualizarAjuste($id, $filter);

            if ($update) {
                $json_result = "success";
                $json_message = "Ajuste actualizado";

                $resp->INVA_Codigo = $id;
                $this->inventario_model->guardarAjusteResponsable($resp);

                $details->ajuste = $id;
                $this->guardarAjusteDetalle($details);
            } else {
                $json_result = "error";
                $json_message = "Error al actualizar el registro, intentelo nuevamente.";
            }
        } else {
            $filter->INVA_Serie = $serieFormAjuste;
            $filter->INVA_Numero = $this->correlativoAjuste("controller");
            $filter->INVA_FechaRegistro = date("Y-m-d");

            $id = $this->inventario_model->guardarAjuste($filter);

            if ($id) {
                $json_result = "success";
                $json_message = "Ajuste registrado";

                $resp->INVA_Codigo = $id;
                $this->inventario_model->guardarAjusteResponsable($resp);

                $details->ajuste = $id;
                $this->guardarAjusteDetalle($details);
            } else {
                $json_result = "error";
                $json_message = "Error al guardar el registro, intentelo nuevamente.";
            }
        }


        $json = array("result" => $json_result, "message" => $json_message);
        die(json_encode($json));
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    private function guardarAjusteDetalle($val)
    {
        $size = count($val->producto);
        if ($size > 0) {
            for ($i = 0; $i < $size; $i++) {
                $colDetalles = new stdClass();
                $colDetalles->INVA_Codigo = $val->ajuste;
                $colDetalles->PROD_Codigo = $val->producto[$i];
                $colDetalles->INVADET_StockAjuste = $val->cantidad[$i];

                $stockInfo = $this->almacenproducto_model->obtener($val->almacen, $val->producto[$i]);
                $colDetalles->INVADET_Stock = ($stockInfo != NULL) ? $stockInfo[0]->ALMPROD_Stock : 0;
                $colDetalles->INVADET_FlagEstado = $val->flag[$i];

                $colDetalles->PERSP_Codigo = $val->responsable[$i];

                if ($val->ajusteDT[$i] == "") {
                    if ($val->flag[$i] == "1") {
                        $colDetalles->INVADET_FechaRegistro = date("Y-m-d H:i:s");
                        $this->inventario_model->guardarAjusteDetalle($colDetalles);
                    }
                } else {
                    $colDetalles->INVADET_FechaModificacion = date("Y-m-d H:i:s");
                    $this->inventario_model->actualizarAjusteDetalle($val->ajusteDT[$i], $colDetalles);
                }
            }
        }
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function aprobarReajuste()
    {
        $id = $this->input->post("ajuste");
        if ($id != NULL && $id != "") {
            $ajusteInfo = $this->inventario_model->getAjuste($id);
            if ($ajusteInfo != NULL) {
                $filter = new stdClass();
                $filter->INVA_FlagEstado = "1";
                $filter->INVA_FechaModificacion = date("Y-m-d H:i:s");
                $update = $this->inventario_model->actualizarAjuste($id, $filter);

                if ($update) {
                    /** Responsable **/
                    $resp = new stdClass();
                    $resp->INVA_Codigo = $id;
                    $resp->PERSP_Codigo = $this->persona;
                    $resp->INVAR_FechaRegistro = date("Y-m-d H:i:s");
                    $resp->INVAR_Observacion = "Ajuste de inventario aprobado.";
                    $this->inventario_model->guardarAjusteResponsable($resp);

                    $detailsInfo = $this->inventario_model->getAjusteDetails($id);
                    if ($detailsInfo != NULL) {
                        foreach ($detailsInfo as $i => $val) {
                            if ($val->ALMPROD_Codigo != NULL) {
                                if ($ajusteInfo[0]->INVA_TipoMovimiento == 1) {
                                    /** Si el tipo de movimiento es 1, reemplaza la cantidad agregada por la nueva **/
                                    $stockU = new stdClass();
                                    $stockU->ALMPROD_Stock = $val->INVADET_StockAjuste;
                                    $this->inventario_model->reemplazarAjusteStock($val->ALMPROD_Codigo, $stockU);
                                } else {
                                    /** caso contrario suma al stock la cantidad nueva **/
                                    $this->inventario_model->actualizarAjusteStock($val->ALMPROD_Codigo, $val->INVADET_StockAjuste);
                                }
                            } else {
                                $stockU = new stdClass();
                                $stockU->COMPP_Codigo = $val->COMPP_Codigo;
                                $stockU->ALMAC_Codigo = $val->ALMAP_Codigo;
                                $stockU->PROD_Codigo = $val->PROD_Codigo;
                                $stockU->ALMPROD_Stock = $val->INVADET_StockAjuste;
                                $stockU->ALMPROD_CostoPromedio = "0";
                                $this->inventario_model->guardarAjusteStock($stockU);
                            }
                            ############################
                            # REGISTRO DE KARDEX
                            ############################
                            $cKardex = new stdClass();
                            $cKardex->codigo_documento  = $id;
                            $cKardex->tipo_docu         = "A";
                            $cKardex->producto          = $val->PROD_Codigo;
                            $cKardex->nombre_producto   = NULL;
                            $cKardex->cantidad          = $val->INVADET_StockAjuste;
                            $cKardex->serie             = $ajusteInfo[0]->INVA_Serie;
                            $cKardex->numero            = $ajusteInfo[0]->INVA_Numero;
                            $cKardex->nombre_almacen    = NULL; #opcionales (para futuro desarrollo)
                            $cKardex->moneda            = NULL;
                            $cKardex->afectacion        = NULL;
                            $cKardex->costo             = NULL;
                            $cKardex->precio_con_igv    = NULL;
                            $cKardex->subtotal          = NULL;
                            $cKardex->total             = NULL;
                            $cKardex->compania          = $val->COMPP_Codigo;
                            $cKardex->tipo_oper         = $ajusteInfo[0]->INVA_TipoMovimiento; # 1: Reemplazo 2: Suma 
                            $cKardex->tipo_movimiento   = ($ajusteInfo[0]->INVA_TipoMovimiento==1) ? "REEMPLAZO":"SUMA";
                            $cKardex->nombre            = NULL; #opcionales (para futuro desarrollo)
                            $cKardex->numdoc            = NULL; #opcionales (para futuro desarrollo)
                            $cKardex->almacen           = $val->ALMAP_Codigo;
                            $cKardex->cliente           = NULL;
                            $cKardex->proveedor         = NULL;
                            $cKardex->usuario           = $this->usuario; #Nombre o codigo?
                            $cKardex->estado            = 1;
                            $this->registrar_kardex($cKardex);
                        }
                    }

                    $json_result = "success";
                    $json_message = "Ajuste actualizado";
                } else {
                    $json_result = "error";
                    $json_message = "Error al aprobar el ajuste, intentelo nuevamente.";
                }
            } else {
                $json_result = "warning";
                $json_message = "Ajuste no encontrado.";
            }
        } else {
            $json_result = "warning";
            $json_message = "Ajuste no seleccionado, intentelo nuevamente.";
        }

        $json = array("result" => $json_result, "message" => $json_message);
        die(json_encode($json));
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function searchProducto($response = "json", $request = NULL)
    {
        $valDefault = "codigo";
        $filter = new stdClass();

        if ($response == "json") {
            $almacen = trim($this->input->post("almacen"));

            $filter->start                  = 0;
            $filter->length                 = 15;
            $filter->searchCodigoUsuario    = trim($this->input->post("codigo"));
            $filter->searchProducto         = trim($this->input->post("nombre"));
            $filter->searchFamilia          = trim($this->input->post("familia"));
            $filter->searchModelo           = trim($this->input->post("modelo"));
            $filter->searchMarca            = trim($this->input->post("marca"));
            $filter->flagBS                 = "B";
            $valDefault = (trim($this->input->post("default")) != "") ? trim($this->input->post("default")) : $valDefault;
        } else {
            $filter = $request;
        }

        $json = array();
        $productosInfo = $this->producto_model->getProductosSearch($filter);
        if ($productosInfo != NULL) {
            foreach ($productosInfo as $row => $col) {
                $stockInfo = $this->almacenproducto_model->obtener($almacen, $col->PROD_Codigo);
                $json[] = array(
                    "value"     => ($valDefault == "codigo") ? $col->PROD_CodigoUsuario : $col->PROD_Nombre,
                    "label"     => $col->PROD_CodigoUsuario . " - " . $col->PROD_Nombre,
                    "id"        => $col->PROD_Codigo,
                    "codigo"    => $col->PROD_CodigoUsuario,
                    "nombre"    => $col->PROD_Nombre,
                    "stock"     => ($stockInfo != NULL) ? $stockInfo[0]->ALMPROD_Stock : 0,
                    "almacen"   => $almacen,
                    "flagBS"    => $col->PROD_FlagBienServicio
                );
            }
        }
        die(json_encode($json));
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function correlativoAjuste($response = "json")
    {
        $valDefault = "codigo";
        $filter = new stdClass();

        $almacen = $this->input->post("almacen");
        $correlativo = $this->inventario_model->correlativoAjuste($this->compania);

        if ($response == "json") {
            $json = array("cantidad" => ++$correlativo);
            die(json_encode($json));
        } else {
            return ++$correlativo;
        }
    }

    public function correlativeInventory($response = "json")
    {
        $correlativo = $this->inventario_model->correlativeInventory($this->compania);

        if ($response == "json") {
            $json = array("cantidad" => ++$correlativo);
            die(json_encode($json));
        } else {
            return ++$correlativo;
        }
    }
    /** End Luis Valdes **/

    /** Cargar Stock **/

    ## Dev: Luis Valdes -> Begin
    public function cargarStock()
    {
        $json_result = "";
        $json_titulo = "";
        $json_message = "";
        $id = "";

        $patch = "documentos/stock/";
        if (!file_exists($patch)) {
            mkdir($patch);
        }
        $this->db->trans_start();

        if (!empty($_FILES['excelCS']['name'])) {
            $name = explode(".", $_FILES['excelCS']['name']);
            $size = count($name);
            if ($size > 0) {
                $file = "cargaStock." . $name[--$size];
                $ext = array("csv", "xls", "xlsx");
                if (in_array($name[$size], $ext)) {
                    if (move_uploaded_file($_FILES['excelCS']['tmp_name'], $patch . "/" . $file)) {
                        $almacen = $this->input->post('almacenCS');

                        $ajuste = $this->input->post("ajusteCS");
                        
                        if ($ajuste != "") {
                            $ajusteInfo = $this->inventario_model->getAjuste($ajuste);
                            if ($ajusteInfo != NULL) {
                                $id = $ajuste;
                                if ($ajusteInfo[0]->ALMAP_Codigo != $almacen) {
                                    $filterAjust = new stdClass();
                                    $filterAjust->ALMAP_Codigo = $almacen;
                                    $filterAjust->INVA_FechaModificacion = date("Y-m-d H:i:s");
                                    $this->inventario_model->actualizarAjuste($id, $filterAjust);
                                }
                            } else {
                                $id = false;
                            }
                        } else {
                            $filter = new stdClass();
                            $filter->ALMAP_Codigo = $almacen;
                            $filter->COMPP_Codigo = trim($this->compania);
                            $filter->INVA_Serie = "AJ00" . $this->compania;
                            $filter->INVA_Numero = $this->correlativoAjuste("controller");
                            $filter->INVA_FechaRegistro = date("Y-m-d");
                            $filter->INVA_TipoMovimiento = "2";
                            $filter->INVA_FlagEstado = "2";
                            $id = $this->inventario_model->guardarAjuste($filter);
                        }

                        if ($id) {
                            $json_result = "success";
                            $json_message = "Ajuste registrado";

                            /** Responsable **/
                            $resp = new stdClass();
                            $resp->PERSP_Codigo = $this->persona;
                            $resp->INVAR_FechaRegistro = date("Y-m-d H:i:s");
                            $resp->INVAR_Observacion = "Carga masiva de stock";
                            $resp->INVA_Codigo = $id;
                            $this->inventario_model->guardarAjusteResponsable($resp);

                            /** Inicia la importacion a la DB en tabla intermedia **/
                            $filterCarga = new stdClass();
                            $filterCarga->file = $patch . "/" . $file;
                            $filterCarga->ext = $name[$size];
                            $filterCarga->ajuste = $id;
                            $filterCarga->almacen = $almacen;
                            $filterCarga->persona = $this->persona;
                            $result = $this->inventario_model->cargaStock($filterCarga);

                            $json_result = $result["result"];
                            $json_titulo = "Ejecución completada";
                            $json_message = $result["details"];
                        } else {
                            $json_result = "error";
                            $json_titulo = "Error al generar el ajuste, intentelo nuevamente.";
                        }
                    } else {
                        $json_result = "error";
                        $json_titulo = "Error al intentar cargar el archivo";
                        $json_message = $this->upload->display_errors();
                    }
                } else {
                    $json_result = "error";
                    $json_titulo = "Extensión de archivo no permitida.";
                }
            } else {
                $json_result = "error";
                $json_titulo = "Extensión de archivo no reconocible.";
            }
        }

        if (!$this->db->trans_status() || $json_result == 'error') {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        $json = array("result" => $json_result, "titulo" => $json_titulo, "message" => $json_message, "ajuste" => $id);
        die(json_encode($json));
    }

    public function loadStockInventory()
    {
        $json_result = "";
        $json_titulo = "";
        $json_message = "";
        $id = "";

        $patch = "documentos/stock/";
        if (!file_exists($patch)) {
            mkdir($patch);
        }
        $this->db->trans_start();

        if (!empty($_FILES['excelCS']['name'])) {
            $name = explode(".", $_FILES['excelCS']['name']);
            $size = count($name);
            if ($size > 0) {
                $file = "cargaStock." . $name[--$size];
                $ext = array("csv", "xls", "xlsx");
                if (in_array($name[$size], $ext)) {
                    if (move_uploaded_file($_FILES['excelCS']['tmp_name'], $patch . "/" . $file)) {
                        $almacen = $this->input->post('almacenCS');

                        $ajuste = $this->input->post("ajusteCS");
                        
                        if ($ajuste != "") {
                            $ajusteInfo = $this->inventario_model->getAjuste($ajuste);
                            if ($ajusteInfo != NULL) {
                                $id = $ajuste;
                                if ($ajusteInfo[0]->ALMAP_Codigo != $almacen) {
                                    $filterAjust = new stdClass();
                                    $filterAjust->ALMAP_Codigo = $almacen;
                                    $filterAjust->INVA_FechaModificacion = date("Y-m-d H:i:s");
                                    $this->inventario_model->actualizarAjuste($id, $filterAjust);
                                }
                            } else {
                                $id = false;
                            }
                        } else {
                            $filter = new stdClass();
                            $filter->INVE_Titulo = $name[0];
                            $filter->ALMAP_Codigo = $almacen;
                            $filter->COMPP_Codigo = trim($this->compania);
                            $filter->INVE_Serie = "INV0" . $this->compania;
                            $filter->INVE_Numero = $this->correlativeInventory("controller");
                            $filter->INVE_FechaInicio = date("Y-m-d H:i:s");
                            $filter->INVE_FechaRegistro = date("Y-m-d H:i:s");
                            $filter->INVE_FlagEstado = "1";
                            
                            $id = $this->inventario_model->setInventory($filter);
                        }

                        if ($id) {
                            $json_result = "success";
                            $json_message = "Inventario registrado";

                            /** Responsable **/
                            $resp = new stdClass();
                            $resp->PERSP_Codigo = $this->persona;
                            $resp->INVER_FechaRegistro = date("Y-m-d H:i:s");
                            $resp->INVER_Observacion = "Carga masiva de stock";
                            $resp->INVE_Codigo = $id;
                            $this->inventario_model->guardarInventarioResponsable($resp);

                            /** Inicia la importacion a la DB en tabla intermedia **/
                            $filterCarga = new stdClass();
                            $filterCarga->file = $patch . "/" . $file;
                            $filterCarga->ext = $name[$size];
                            $filterCarga->inventario = $id;
                            $filterCarga->almacen = $almacen;
                            $filterCarga->persona = $this->persona;

                            $result = $this->inventario_model->cargaStock($filterCarga, $id);

                            $json_result = $result["result"];
                            $json_titulo = "Ejecución completada";
                            $json_message = $result["details"];
                        } else {
                            $json_result = "error";
                            $json_titulo = "Error al generar el ajuste, intentelo nuevamente.";
                        }
                    } else {
                        $json_result = "error";
                        $json_titulo = "Error al intentar cargar el archivo";
                        $json_message = $this->upload->display_errors();
                    }
                } else {
                    $json_result = "error";
                    $json_titulo = "Extensión de archivo no permitida.";
                }
            } else {
                $json_result = "error";
                $json_titulo = "Extensión de archivo no reconocible.";
            }
        }

        if (!$this->db->trans_status() || $json_result == 'error') {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        $json = array("result" => $json_result, "titulo" => $json_titulo, "message" => $json_message, "ajuste" => $id);
        die(json_encode($json));
    }
    ## Dev: Luis Valdes -> End

    ## Dev: Luis Valdes -> Begin
    public function productosCargadosExcel($ajuste)
    {
        $this->load->library('Excel');

        /** ESTILOS **/
        $styleYelow = array(
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

        /** ESTILOS **/
        $styleRed = array(
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
                'color' => array('argb' => '94CD32')
            ),
            'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'          => TRUE
            )
        );

        $hoja = 0;
        /** HOJA 0 COTIZACIÓN **/
        $this->excel->setActiveSheetIndex($hoja);
        $this->excel->getActiveSheet()->setTitle("Productos Cargados.");

        $data = false;

        $i = "A";
        $this->excel->getActiveSheet()->getColumnDimension($i)->setWidth("25");
        $this->excel->getActiveSheet()->getColumnDimension(++$i)->setWidth("40");
        $this->excel->getActiveSheet()->getColumnDimension(++$i)->setWidth("25");
        $this->excel->getActiveSheet()->getColumnDimension(++$i)->setWidth("25");
        $this->excel->getActiveSheet()->getColumnDimension(++$i)->setWidth("15");

        $productosInfo = $this->inventario_model->getProductosCargados($ajuste, '1');
        if ($productosInfo != NULL) {
            $lugar = 1;
            $this->excel->setActiveSheetIndex($hoja)->mergeCells("A$lugar:E$lugar")->setCellValue("A$lugar",  "PRODUCTOS ACEPTADOS");
            $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($styleYelow);

            /** Columnas **/
            $lugar++;
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "CÓDIGO DE PRODUCTO");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  "NOMBRE Ó DESCRIPCION");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  "MARCA");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  "MODELO");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  "CANTIDAD");
            $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($styleYelow);
            $lugar++;

            foreach ($productosInfo as $col) {
                /** Items **/
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "$col->PROD_CodigoUsuario");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $col->PROD_Nombre);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  $col->PROD_Marca);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  $col->PROD_Modelo);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  $col->ALMPC_Cantidad);
                $lugar++;
            }
            $data = true;
        }

        $productosInfo = $this->inventario_model->getProductosCargados($ajuste, '4');
        if ($productosInfo != NULL) {
            $lugar += 3;
            $this->excel->setActiveSheetIndex($hoja)->mergeCells("A$lugar:E$lugar")->setCellValue("A$lugar",  "PRODUCTOS RECHAZADOS");
            $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($styleRed);

            /** Columnas **/
            $lugar++;
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "CÓDIGO DE PRODUCTO");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  "NOMBRE Ó DESCRIPCION");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  "MARCA");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  "MODELO");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  "CANTIDAD");
            $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($styleRed);
            $lugar++;

            foreach ($productosInfo as $col) {
                /** Items **/
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  $col->PROD_CodigoUsuario);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $col->PROD_Nombre);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  $col->PROD_Marca);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  $col->PROD_Modelo);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  $col->ALMPC_Cantidad);
                $lugar++;
            }
            $data = true;
        }

        $productosInfo = $this->inventario_model->getProductosCargados($ajuste, '0');
        if ($productosInfo != NULL) {
            $lugar += 3;
            $this->excel->setActiveSheetIndex($hoja)->mergeCells("A$lugar:E$lugar")->setCellValue("A$lugar",  "PRODUCTOS ELIMINADOS");
            $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($styleYelow);

            /** Columnas **/
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "CÓDIGO DE PRODUCTO");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  "NOMBRE Ó DESCRIPCION");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  "MARCA");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  "MODELO");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  "CANTIDAD");
            $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($styleYelow);
            $lugar++;

            foreach ($productosInfo as $col) {
                /** Items **/
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  $col->PROD_CodigoUsuario);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $col->PROD_Nombre);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  $col->PROD_Marca);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  $col->PROD_Modelo);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  $col->ALMPC_Cantidad);
                $lugar++;
            }
            $data = true;
        }

        if (!$data) {
            $productosInfo = $this->inventario_model->getAjusteDetails($ajuste);
            if ($productosInfo != NULL) {
                $lugar = 1;
                $this->excel->setActiveSheetIndex($hoja)->mergeCells("A$lugar:E$lugar")->setCellValue("A$lugar",  "PRODUCTOS APROBADOS");
                $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($styleYelow);

                /** Columnas **/
                $lugar++;
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "CÓDIGO DE PRODUCTO");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  "NOMBRE Ó DESCRIPCION");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  "MARCA");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  "MODELO");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  "CANTIDAD");
                $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($styleYelow);
                $lugar++;

                foreach ($productosInfo as $col) {
                    /** Items **/
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "$col->PROD_CodigoUsuario");
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $col->PROD_Nombre);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  $col->MARCC_Descripcion);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  $col->PROD_Modelo);
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  $col->INVADET_StockAjuste);
                    $lugar++;
                }
                $data = true;
            }
        }

        $filename = "productos cargados " . date('H:i:s d-m-Y') . ".xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
    }
    ## Dev: Luis Valdes -> End

    ## Dev: Luis Valdes -> Begin
    public function formatLoadExcel()
    {
        $this->load->library('Excel');
    
        /** ESTILOS **/
        $estiloTitulo = array(
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
        
       
        $hoja = 0;
        /** HOJA 0 COTIZACIÓN **/
        $this->excel->setActiveSheetIndex($hoja);
        $this->excel->getActiveSheet()->setTitle("Formato de carga");

        $i = "A";
        $this->excel->getActiveSheet()->getColumnDimension($i)->setWidth("25");
        $this->excel->getActiveSheet()->getColumnDimension(++$i)->setWidth("40");
        $this->excel->getActiveSheet()->getColumnDimension(++$i)->setWidth("25");
        $this->excel->getActiveSheet()->getColumnDimension(++$i)->setWidth("25");
        $this->excel->getActiveSheet()->getColumnDimension(++$i)->setWidth("15");

        /** Columnas **/
        $lugar = 1;
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "CÓDIGO DE PRODUCTO"); 
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  "NOMBRE Ó DESCRIPCION");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  "MARCA");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  "MODELO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  "CANTIDAD");
        $this->excel->getActiveSheet()->getStyle("A$lugar:E$lugar")->applyFromArray($estiloTitulo);
        $lugar++;
        
        /** Items **/
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "CODE001");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  "EL NOMBRE DEL PRODUCTO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  "LA MARCA");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  "EL MODELO");
        $this->excel->setActiveSheetIndex($hoja)->setCellValue("E$lugar",  "CANTIDAD");

        $filename = "Formato de carga.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
    }
    ## Dev: Luis Valdes -> End


    ## Dev: Luis Valdes -> Begin
    
    public function DetalleInventarioExcel($ajuste)
    {
        $this->load->library('Excel');

        /** ESTILOS **/
        $styleYelow = array(
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
                'horizontal' => "left",
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'          => TRUE
            )
        );

        /** ESTILOS **/
        $styleYelow2 = array(
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
                'horizontal' => "center",
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'          => TRUE
            )
        );

        /** ESTILOS **/
        $styleRed = array(
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
                'color' => array('argb' => '94CD32')
            ),
            'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'          => TRUE
            )
        );
        

        $ajusteInfo = $this->inventario_model->getInventario($ajuste);
        
        $titulo = $ajusteInfo[0]->INVE_Titulo;
        $serie  = $ajusteInfo[0]->INVE_Serie;
        $numero = $ajusteInfo[0]->INVE_Numero;
        $fecha  = $ajusteInfo[0]->INVE_FechaInicio;
        $almac  = $ajusteInfo[0]->ALMAC_Descripcion;
        
        $hoja = 0;
        /** HOJA 0 COTIZACIÓN **/
        $this->excel->setActiveSheetIndex($hoja);
        $this->excel->getActiveSheet()->setTitle($titulo);

        $data = false;

        $i = "A";
        $this->excel->getActiveSheet()->getColumnDimension($i)->setWidth("25");
        $this->excel->getActiveSheet()->getColumnDimension(++$i)->setWidth("40");
        $this->excel->getActiveSheet()->getColumnDimension(++$i)->setWidth("25");
        $this->excel->getActiveSheet()->getColumnDimension(++$i)->setWidth("25");
        
        $ajusteDetalleInfo = $this->inventario_model->getInventarioDetalles($ajuste);
        if ($ajusteDetalleInfo != NULL) {
            $lugar = 1;
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "REPORTE DE INVENTARIO ".$this->nombre_empresa);
            $this->excel->setActiveSheetIndex($hoja)->mergeCells("A$lugar:D$lugar")->setCellValue("B$lugar", $titulo);
            $this->excel->getActiveSheet()->getStyle("A$lugar:D$lugar")->applyFromArray($styleYelow2);

            $lugar++;
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "TITULO INVENTARIO:");
            $this->excel->setActiveSheetIndex($hoja)->mergeCells("B$lugar:D$lugar")->setCellValue("B$lugar", $titulo);
            $this->excel->getActiveSheet()->getStyle("A$lugar:D$lugar")->applyFromArray($styleYelow);

            $lugar++;
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "ESTABLECIMIENTO:");
            $this->excel->setActiveSheetIndex($hoja)->mergeCells("B$lugar:D$lugar")->setCellValue("B$lugar", $this->nombre_establec);
            $this->excel->getActiveSheet()->getStyle("A$lugar:D$lugar")->applyFromArray($styleYelow);
            $lugar++;

            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "ALMACEN:");
            $this->excel->setActiveSheetIndex($hoja)->mergeCells("B$lugar:D$lugar")->setCellValue("B$lugar", $almac);
            $this->excel->getActiveSheet()->getStyle("A$lugar:D$lugar")->applyFromArray($styleYelow);

            $lugar++;

            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "FECHA DE CREACIÓN:");
            $this->excel->setActiveSheetIndex($hoja)->mergeCells("B$lugar:D$lugar")->setCellValue("B$lugar", $fecha);
            $this->excel->getActiveSheet()->getStyle("A$lugar:D$lugar")->applyFromArray($styleYelow);

            $lugar++;

            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "USUARIO DESCARGA:");
            $this->excel->setActiveSheetIndex($hoja)->mergeCells("B$lugar:D$lugar")->setCellValue("B$lugar", $this->persona_nombre);
            $this->excel->getActiveSheet()->getStyle("A$lugar:D$lugar")->applyFromArray($styleYelow);

            $lugar++;
            $lugar++;

            $this->excel->setActiveSheetIndex($hoja)->mergeCells("A$lugar:D$lugar")->setCellValue("A$lugar", "LISTA DE PRODUCTOS EN INVENTARIO");
            $this->excel->getActiveSheet()->getStyle("A$lugar:D$lugar")->applyFromArray($styleYelow2);

            /** Columnas **/
            $lugar++;
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "CÓDIGO DE PRODUCTO");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  "NOMBRE Ó DESCRIPCION");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  "MARCA");
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  "CANTIDAD");
            
            $this->excel->getActiveSheet()->getStyle("A$lugar:D$lugar")->applyFromArray($styleYelow);
            $lugar++;

            foreach ($ajusteDetalleInfo as $col) {
                /** Items **/
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "$col->PROD_CodigoUsuario");
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("B$lugar",  $col->PROD_Nombre);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("C$lugar",  $col->MARCC_Descripcion);
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("D$lugar",  $col->INVD_Cantidad);
              
                $lugar++;
            }
            $data = true;
        }

        

        $filename = $titulo." " .$serie." ".$numero. " " . date('H:i:s d-m-Y') . ".xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$filename");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
    }
    ## Dev: Luis Valdes -> End


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
        $cKardex->MONED_Codigo          = $filter->moneda; #opcionales (para futuro desarrollo)
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

#EOF
}
