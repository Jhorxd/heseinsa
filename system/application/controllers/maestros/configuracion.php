<?php

class Configuracion extends Controller {

    public function __construct() {
        parent::Controller();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('html');
        $this->load->model('maestros/empresa_model');
        $this->load->model('seguridad/permiso_model');
        $this->load->model('maestros/compania_model');
        $this->load->model('maestros/configuracion_model');
        $this->load->model('maestros/companiaconfiguracion_model');
        
    }

    public function index() {
        $this->layout->view('seguridad/inicio');
    }

    public function cambiar_sesion() {
        $_SESSION['compania'] = $_POST['compania'];
        $compania = $this->compania_model->obtener_compania($_POST['compania']);
        $empresa = $this->empresa_model->obtener_datosEmpresa($compania[0]->EMPRP_Codigo);
        $datos_compania = $this->compania_model->obtener($_POST['compania']);
        $_SESSION['empresa'] = $compania[0]->EMPRP_Codigo;
        $_SESSION['nombre_empresa'] = $empresa[0]->EMPRC_RazonSocial;
        $this->somevar['empresa'] = $compania[0]->EMPRP_Codigo;
        $this->somevar['nombre_empresa'] = $empresa[0]->EMPRC_RazonSocial;
        $this->somevar['compania'] = $_POST['compania'];
        $obtener_rol = $this->permiso_model->obtener_rol_compania($_POST['compania'], $this->session->userdata('user'));
        $_SESSION['establec'] = $datos_compania[0]->EESTABP_Codigo;
        $_SESSION['rol']=$obtener_rol[0]->ROL_Codigo;
        $_SESSION['desc_rol']=$obtener_rol[0]->ROL_Descripcion;
        //var_dump($obtener_rol);
        echo "Ok";
    }

    /* Configuracion */

    public function editar_configuracion($value='')
    {
        $data['compania']       = $this->session->userdata('compania');
        $compania               = $data['compania'];
        $comp_confi             = $this->companiaconfiguracion_model->obtener($compania);
        $comp_confi=$comp_confi[0];
        //var_dump($comp_confi->COMPCONFIC_Igv);exit();
        $data['igv100']            = $comp_confi->COMPCONFIC_Igv;
        $data['contiene_igv']   = $comp_confi->COMPCONFIC_PrecioContieneIgv[0];
        $data['tipo_precio']    = $comp_confi->COMPCONFIC_DeterminaPrecio; //0: Los árticulos tienen un único precio, 1: El precio depende del tipo de cliente, 2: El precio depende de la tienda, 3: El precio depedente de la combinación de las dos últimas

        //compartir datos entre empresas
        $data['clientes']       = $comp_confi->COMPCONFIC_Cliente;
        $data['proveedor']      = $comp_confi->COMPCONFIC_Proveedor;
        $data['producto']       = $comp_confi->COMPCONFIC_Producto;
        $data['familia']        = $comp_confi->COMPCONFIC_Familia;

        //SERIES Y NÚMEROS ACTUALES DE LOS DOCUMETOS
        $datos_configuracion = $this->configuracion_model->obtener_configuracion($compania);
        foreach ($datos_configuracion as $indice => $valor) {
            $id = $valor->DOCUP_Codigo;
            $serie = $valor->CONFIC_Serie;
            $numero = $valor->CONFIC_Numero;
            switch ($id) {
                case 1 :
                    $arrayValores_serie[0] = $serie;
                    $arrayValores[0] = $numero;
                    break; //orden_pedido
                case 2: 
                    $arrayValores_serie[1] = $serie;
                    $arrayValores[1] = $numero;
                    break; //cotizacion
                case 3: 
                    $arrayValores_serie[2] = $serie;
                    $arrayValores[2] = $numero;
                    break; //orden de compra
                case 4: 
                    $arrayValores_serie[3] = $serie;
                    $arrayValores[3] = $numero;
                    break; //inventario
                case 5: 
                    $arrayValores_serie[4] = $serie;
                    $arrayValores[4] = $numero;
                    break; //guiain
                case 6: 
                    $arrayValores_serie[5] = $serie;
                    $arrayValores[5] = $numero;
                    break; //guiasa
                case 7: 
                    $arrayValores_serie[6] = $serie;
                    $arrayValores[6] = $numero;
                    break; //valesa
                case 8: 
                    $arrayValores_serie[7] = $serie;
                    $arrayValores[7] = $numero;
                    break; //factura
                case 9: 
                    $arrayValores_serie[8] = $serie;
                    $arrayValores[8] = $numero;
                    break; //boleta
                case 10: 
                    $arrayValores_serie[9] = $serie;
                    $arrayValores[9] = $numero;
                    break; //guiaremi
                case 11: 
                    $arrayValores_serie[10] = $serie;
                    $arrayValores[10] = $numero;
                    break; //notacred
                case 12: 
                    $arrayValores_serie[11] = $serie;
                    $arrayValores[11] = $numero;
                    break; //notadeb
                case 13: 
                    $arrayValores_serie[12] = $serie;
                    $arrayValores[12] = $numero;
                    break; //presupuesto
                case 14: 
                    $arrayValores_serie[13] = $serie;
                    $arrayValores[13] = $numero;
                    break; //comprobante general
                case 15: 
                    $arrayValores_serie[14] = $serie;
                    $arrayValores[14] = $numero;
                    break; //guiarem
                case 16: 
                    $arrayValores_serie[15] = $serie;
                    $arrayValores[15] = $numero;
                    break; //letra
                case 17: 
                    $arrayValores_serie[16] = $serie;
                    $arrayValores[16] = $numero;
                    break; //orden de servicios
                case 18: 
                    $arrayValores_serie[17] = $serie;
                    $arrayValores[17] = $numero;
                    break;//orden de venta COTIZACIONES
                case 20: 
                    $arrayValores_serie[18] = $serie;
                    $arrayValores[18] = $numero;
                    break;//produccion NO SE USA
                case 21: 
                    $arrayValores_serie[19] = $serie;
                    $arrayValores[19] = $numero;
                    break;//DESPACHO no se usa
            }
        }
        $documentos = array(
            "orden_pedido_serie"=> $arrayValores_serie[0],
            "cotizacion_serie"  => $arrayValores_serie[1], 
            "ocompra_serie"     => $arrayValores_serie[2],
            "inventario_serie"  => $arrayValores_serie[3], 
            "guiain_serie"      => $arrayValores_serie[4], 
            "guiasa_serie"      => $arrayValores_serie[5],
            "vale_serie"        => $arrayValores_serie[6], 
            "factura_serie"     => $arrayValores_serie[7], 
            "boleta_serie"      => $arrayValores_serie[8],
            "guiarem_serie"     => $arrayValores_serie[9], 
            "notacred_serie"    => $arrayValores_serie[10], 
            "notadeb_serie"     => $arrayValores_serie[11],
            "presupuesto_serie" => $arrayValores_serie[12], 
            "compgene_serie"    => $arrayValores_serie[13], 
            "transfe_serie"     => $arrayValores_serie[14],
            "letra"             => $arrayValores_serie[15],
            "orden_servicio_s"  => $arrayValores_serie[16],
            "orden_venta_serie" => $arrayValores_serie[17], 
            "produccion_serie"  => $arrayValores_serie[18],
            "despacho_serie"    => $arrayValores_serie[19],
            
            "orden_pedido"      => $arrayValores[0], 
            "cotizacion"        => $arrayValores[1], 
            "ocompra"           => $arrayValores[2],
            "inventario"        => $arrayValores[3], 
            "guiain"            => $arrayValores[4], 
            "guiasa"            => $arrayValores[5],
            "vale"              => $arrayValores[6], 
            "factura"           => $arrayValores[7], 
            "boleta"            => $arrayValores[8],
            "guiarem"           => $arrayValores[9], 
            "notacred"          => $arrayValores[10], 
            "notadeb"           => $arrayValores[11],
            "presupuesto"       => $arrayValores[12], 
            "compgene"          => $arrayValores[13], 
            "transferencia"     => $arrayValores[14],
            "letra"             => $arrayValores[15], 
            "orden_servicio"    => $arrayValores[16], 
            "orden_venta"       => $arrayValores[17], 
            "produccion"        => $arrayValores[18],
            "despacho"          => $arrayValores[19]
        );

        $data['documentos'] = $documentos;
        $this->layout->view('maestros/configuracion_nuevo', $data);
    }

    public function modificar_configuracion() {
    
        $cboPrincipal           = $_SESSION['compania'];
        
        $tipo_valorizacion      = $this->input->post('tipo_valorizacion');
        //NUMEROS
        $ordenventa             = $this->input->post("orden_venta");
        $factura                = $this->input->post('factura');
        $boleta                 = $this->input->post('boleta');
        $comprobante_general    = $this->input->post('compgene');
        $guia_remision          = $this->input->post('guiarem');
        $nota_credito           = $this->input->post('notacred');
        $orden_compra           = $this->input->post('ocompra');
        
        $orden_pedido           = $this->input->post('orden_pedido');
        $cotizacion             = $this->input->post('cotizacion');
        $orden_servicio         = $this->input->post('orden_servicio');
        $inventario             = $this->input->post('inventario');
        $guia_ingreso           = $this->input->post('guia_ingreso');
        $guia_salida            = $this->input->post('guia_salida');
        $vale_salida            = $this->input->post('vale_salida');
        $nota_debito            = $this->input->post('nota_debito');
        $presupuesto            = $this->input->post('presupuesto');
        $importacion            = $this->input->post('importacion');
        $cobrarnumero           = $this->input->post("cobrar_numero");
        $pagarnumero            = $this->input->post("pagar_numero");

        //SERIES
        $ordenventa_serie       = $this->input->post("orden_venta_serie");
        $factura_serie          = $this->input->post('factura_serie');
        $boleta_serie           = $this->input->post('boleta_serie');
        $comp_general_serie     = $this->input->post('compgene_serie');
        $guia_remision_serie    = $this->input->post('guiarem_serie');
        $nota_credito_serie     = $this->input->post('notacred_serie');
        $orden_compra_serie     = $this->input->post('ocompra_serie');
        

        $orden_pedido_serie     = $this->input->post('orden_pedido_serie');
        $cotizacion_serie       = $this->input->post('cotizacion_serie');
        $orden_servicio_serie   = $this->input->post('orden_servicio_serie');
        $inventario_serie       = $this->input->post('inventario_serie');
        $guia_ingreso_serie     = $this->input->post('guia_ingreso_serie');
        $guia_salida_serie      = $this->input->post('guia_salida_serie');
        $vale_salida_serie      = $this->input->post('vale_salida_serie');
        $nota_debito_serie      = $this->input->post('nota_debito_serie');
        $presupuesto_serie      = $this->input->post('presupuesto_serie');
        $importacion_serie      = $this->input->post('importacion_serie');
        $cobrarserie            = $this->input->post("cobrar_serie");
        $pagarserie             = $this->input->post("pagar_serie");

        $igv                = $this->input->post('igv');
        $contiene_igv       = $this->input->post('contiene_igv');
        $determina_precio   = $this->input->post('cboDeterminaPrecio');
        $cliente            = $this->input->post('cliente_com');
        $proveedor          = $this->input->post('proveedor_com');
        $producto           = $this->input->post('producto_com');
        $familia            = $this->input->post('familia_com');
        $s_comprobante      = $this->input->post('s_comprobante');
        $s_guia             = $this->input->post('s_guia');
        $inventario_inicial = $this->input->post('inventario_inicial');
        
        $datos = array(
            "ordenventa"            => $ordenventa,
            "factura"               => $factura,
            "boleta"                => $boleta,
            "comprobante_general"   => $comprobante_general,
            "guia_remision"         => $guia_remision,
            "nota_credito"          => $nota_credito,
            "orden_compra"          => $orden_compra
        );

        $datos_serie = array(
            "ordenventa"            => $ordenventa_serie,
            "factura"               => $factura_serie,
            "boleta"                => $boleta_serie,
            "comprobante_general"   => $comp_general_serie,
            "guia_remision"         => $guia_remision_serie,
            "nota_credito"          => $nota_credito_serie,
            "orden_compra"          => $orden_compra_serie
        );

        $logo = "Mi loguito";
        $this->configuracion_model->modificar_configuracion_total($cboPrincipal, $logo, $tipo_valorizacion, $datos, $datos_serie);
        $this->companiaconfiguracion_model->modificar($cboPrincipal, $igv, ($contiene_igv == '' ? '0' : $contiene_igv), $determina_precio);
        
        $this->companiaconfiguracion_model->modificar_compartido($cboPrincipal, $cliente, $proveedor, $producto, $familia, $determinaprecio);
        
        $json = array("result" => "success", "message" => $json_message ,"codigo"=>$cliente);
        echo json_encode($json);
    
    }
    public function editar_configuracion_() {
        $compania = $this->session->userdata('compania');
        $datos_compania = $this->compania_model->obtener($compania);
        $comp_confi = $this->companiaconfiguracion_model->obtener($compania);
        $tipo_val_compania = $datos_compania[0]->COMPC_TipoValorizacion;
        $lblCompania = form_label('Empresa Principal ', 'compania');
        $lblLogo = form_label('Logo', 'logo');
        $lblTipoVal = form_label('Tipo Valorizacion', 'Tipo Valorizacion');
        $lblIGV = form_label('I.G.V. (%)', 'lbligv');
        $lblFacBol = form_label('Facturas y Boletas', 'facbol');
        $lblGuia = form_label('Guias', 'guias');
        $lblInventarioInicial = form_label('Inventario Inicial', 'inventarioIni');
        $lblContieneIGV = form_label('El precio de los árticulos tienen incluido el I.G.V.', 'lblcontienen_igv');
        $lblDeterminaPrecio = form_label('Modo de determinación del precio de un árticulo', 'determinaprecio');
        $cbo_compania = "<select name='cboCompania' id='cboCompania' class='comboMedio' onchange='cargar_configuracion_detalle(this.value);'>" . $this->seleccionar_compania($compania) . "</select>";
        $igv = form_input(array('name' => 'igv', 'id' => 'igv', 'value' => $comp_confi[0]->COMPCONFIC_Igv, 'maxlength' => '2', 'class' => 'cajaPequena2'));
        $contiene_igv = form_checkbox(array('name' => 'contiene_igv', 'id' => 'contiene_igv'), '1', ($comp_confi[0]->COMPCONFIC_PrecioContieneIgv[0] == '1' ? true : false));
        $FacBol = form_checkbox(array('name' => 's_comprobante', 'disabled' => '', 'id' => 's_comprobante'), '1', ($comp_confi[0]->COMPCONFIC_StockComprobante[0] == '1' ? true : false));
        $guia = form_checkbox(array('name' => 's_guia', 'disabled' => '', 'id' => 's_guia'), '1', ($comp_confi[0]->COMPCONFIC_StockGuia[0] == '1' ? true : false));
        $inventario_inicial = form_checkbox(array('name' => 'inventario_inicial', 'id' => 'inventario_inicial'), '1', ($comp_confi[0]->COMPCONFIC_InventarioInicial[0] == '1' ? true : false));
        $cbo_determinaprecio = "<select name='cboDeterminaPrecio' id='cboDeterminaPrecio' class='comboGrande'>" . $this->seleccionar_determinaprecio($comp_confi[0]->COMPCONFIC_DeterminaPrecio) . "</select>";
        $file_compania = "<input type='file' value='Subir'  class=''>";
        $tipo_valorizacion = form_radio("tipo_valorizacion", "0", ($tipo_val_compania == 0) ? TRUE : FALSE) . "FIFO" . form_radio("tipo_valorizacion", "1", ($tipo_val_compania == 1) ? TRUE : FALSE) . "LIFO";
        $data['campos'] = array($lblCompania, $lblLogo, $lblTipoVal, $lblIGV, $lblContieneIGV, $lblDeterminaPrecio, $lblGuia, $lblFacBol, $lblInventarioInicial);
        $data['valores'] = array($cbo_compania, $file_compania, $tipo_valorizacion, $igv, $contiene_igv, $cbo_determinaprecio, $guia, $FacBol, $inventario_inicial);
        //$modo                = "";
        $accion = "";
        $modo = "insertar";
        $codigo = "";
        $oculto = form_hidden(array('accion' => $accion, 'codigo' => $codigo, 'modo' => $modo, 'base_url' => base_url()));
        $data['titulo'] = "CONFIGURACION DEL SISTEMA ";
        $data['formulario'] = "frmConfiguracion";
        $data['oculto'] = $oculto;
        $data['onload'] = "onload=\"$('#nombre').focus();\"";
        $data['url_action'] = base_url() . "index.php/maestros/configuracion/modificar_configuracion";
        $arrayValores = array("0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0","0","0");
        $arrayValores_serie = array("0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0","0","0");
        $datos_configuracion = $this->configuracion_model->obtener_configuracion($compania);
        //print_r($comp_confi);exit;
        $data['cliente'] = $comp_confi[0]->COMPCONFIC_Cliente;
        $data['proveedor'] = $comp_confi[0]->COMPCONFIC_Proveedor;
        $data['producto'] = $comp_confi[0]->COMPCONFIC_Producto;
        $data['familia'] = $comp_confi[0]->COMPCONFIC_Familia;

        foreach ($datos_configuracion as $indice => $valor) {
            $id = $valor->DOCUP_Codigo;
            $serie = $valor->CONFIC_Serie;
            $numero = $valor->CONFIC_Numero;
            switch ($id) {
                case 1 :$arrayValores_serie[0] = $serie;
                    $arrayValores[0] = $numero;
                    break; //orden_pedido
                case 2: $arrayValores_serie[1] = $serie;
                    $arrayValores[1] = $numero;
                    break; //cotizacion
                case 3: $arrayValores_serie[2] = $serie;
                    $arrayValores[2] = $numero;
                    break; //ocompra
                case 4: $arrayValores_serie[3] = $serie;
                    $arrayValores[3] = $numero;
                    break; //inventario
                case 5: $arrayValores_serie[4] = $serie;
                    $arrayValores[4] = $numero;
                    break; //guiain
                case 6: $arrayValores_serie[5] = $serie;
                    $arrayValores[5] = $numero;
                    break; //guiasa
                case 7: $arrayValores_serie[6] = $serie;
                    $arrayValores[6] = $numero;
                    break; //valesa
                case 8: $arrayValores_serie[7] = $serie;
                    $arrayValores[7] = $numero;
                    break; //factura
                case 9: $arrayValores_serie[8] = $serie;
                    $arrayValores[8] = $numero;
                    break; //boleta
                case 10: $arrayValores_serie[9] = $serie;
                    $arrayValores[9] = $numero;
                    break; //guiaremi
                case 11: $arrayValores_serie[10] = $serie;
                    $arrayValores[10] = $numero;
                    break; //notacred
                case 12: $arrayValores_serie[11] = $serie;
                    $arrayValores[11] = $numero;
                    break; //notadeb
                case 13: $arrayValores_serie[12] = $serie;
                    $arrayValores[12] = $numero;
                    break; //presupuesto
                case 14: $arrayValores_serie[13] = $serie;
                    $arrayValores[13] = $numero;
                    break; //comprobante general
                case 15: $arrayValores_serie[14] = $serie;
                    $arrayValores[14] = $numero;
                    break; //importacion
                case 17: $arrayValores_serie[15] = $serie;
                    $arrayValores[15] = $numero;
                    break; //orden de servicios
                case 18: $arrayValores_serie[16] = $serie;
                    $arrayValores[16] = $numero;
                    break;//orden de venta
                 case 20: $arrayValores_serie[17] = $serie;
                    $arrayValores[17] = $numero;
                    break;//cuentas por cobrar
                case 21: $arrayValores_serie[18] = $serie;
                    $arrayValores[18] = $numero;
                    break;//cuentas por pagar
            }
        }
        $documentos = array(
            "orden_pedido_serie" => $arrayValores_serie[0], "cotizacion_serie" => $arrayValores_serie[1], "ocompra_serie" => $arrayValores_serie[2],
            "inventario_serie" => $arrayValores_serie[3], "guiain_serie" => $arrayValores_serie[4], "guiasa_serie" => $arrayValores_serie[5],
            "valesa_serie" => $arrayValores_serie[6], "factura_serie" => $arrayValores_serie[7], "boleta_serie" => $arrayValores_serie[8],
            "guiarem_serie" => $arrayValores_serie[9], "notacred_serie" => $arrayValores_serie[10], "notadeb_serie" => $arrayValores_serie[11],
            "presupuesto_serie" => $arrayValores_serie[12], "compgene_serie" => $arrayValores_serie[13], "importacion_serie" => $arrayValores_serie[14],"oservicio_serie" => $arrayValores_serie[15],"ordenventa_serie" => $arrayValores_serie[16],
            "cobrar_serie"=> $arrayValores_serie[17], "pagar_serie"=> $arrayValores_serie[18],

            "orden_pedido" => $arrayValores[0], "cotizacion" => $arrayValores[1], "ocompra" => $arrayValores[2],
            "inventario" => $arrayValores[3], "guiain" => $arrayValores[4], "guiasa" => $arrayValores[5],
            "valesa" => $arrayValores[6], "factura" => $arrayValores[7], "boleta" => $arrayValores[8],
            "guiarem" => $arrayValores[9], "notacred" => $arrayValores[10], "notadeb" => $arrayValores[11],
            "presupuesto" => $arrayValores[12], "compgene" => $arrayValores[13], "importacion" => $arrayValores[14],
            "oservicio" => $arrayValores[15], "ordenventa" => $arrayValores[16], "cobrar_numero" => $arrayValores[17] , "pagar_numero" => $arrayValores[18]
        );
        $data['documentos'] = $documentos;
        $this->layout->view('maestros/configuracion_nuevo', $data);
    }

    public function modificar_configuracion_() {
        $this->form_validation->set_rules('cboCompania', 'EMPRESA PRINCIPAL', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->editar_configuracion();
        } else {
            $cboPrincipal = $this->input->post('cboCompania');
            //$filePrincipal = $this->input->post();
            $tipo_valorizacion = $this->input->post('tipo_valorizacion');
            $orden_pedido = $this->input->post('orden_pedido');
            $cotizacion = $this->input->post('cotizacion');
            $orden_compra = $this->input->post('orden_compra');
            $orden_servicio = $this->input->post('orden_servicio');
            $inventario = $this->input->post('inventario');
            $guia_ingreso = $this->input->post('guia_ingreso');
            $guia_salida = $this->input->post('guia_salida');
            $vale_salida = $this->input->post('vale_salida');
            $factura = $this->input->post('factura');
            $boleta = $this->input->post('boleta');
            $guia_remision = $this->input->post('guia_remision');
            $nota_credito = $this->input->post('nota_credito');
            $nota_debito = $this->input->post('nota_debito');
            $presupuesto = $this->input->post('presupuesto');
            $comprobante_general = $this->input->post('comprobante_general');
            $importacion = $this->input->post('importacion');
            $ordenventa = $this->input->post("ordenventa");
            $cobrarnumero = $this->input->post("cobrar_numero");
            $pagarnumero = $this->input->post("pagar_numero");

            $orden_pedido_serie = $this->input->post('orden_pedido_serie');
            $cotizacion_serie = $this->input->post('cotizacion_serie');
            $orden_compra_serie = $this->input->post('orden_compra_serie');
            $orden_servicio_serie = $this->input->post('orden_servicio_serie');
            $inventario_serie = $this->input->post('inventario_serie');
            $guia_ingreso_serie = $this->input->post('guia_ingreso_serie');
            $guia_salida_serie = $this->input->post('guia_salida_serie');
            $vale_salida_serie = $this->input->post('vale_salida_serie');
            $factura_serie = $this->input->post('factura_serie');
            $boleta_serie = $this->input->post('boleta_serie');
            $guia_remision_serie = $this->input->post('guia_remision_serie');
            $nota_credito_serie = $this->input->post('nota_credito_serie');
            $nota_debito_serie = $this->input->post('nota_debito_serie');
            $presupuesto_serie = $this->input->post('presupuesto_serie');
            $comprobante_general_serie = $this->input->post('comprobante_general_serie');
            $importacion_serie = $this->input->post('importacion_serie');
            $ordenventa_serie = $this->input->post("ordenventa_serie");
            $cobrarserie = $this->input->post("cobrar_serie");
            $pagarserie = $this->input->post("pagar_serie");

            $igv = $this->input->post('igv');
            $contiene_igv = $this->input->post('contiene_igv');
            $determina_precio = $this->input->post('cboDeterminaPrecio');

            $cliente = $this->input->post('cliente_com');
            $proveedor = $this->input->post('proveedor_com');
            $producto = $this->input->post('producto_com');
            $familia = $this->input->post('familia_com');
            $s_comprobante = $this->input->post('s_comprobante');
            $s_guia = $this->input->post('s_guia');
            $inventario_inicial = $this->input->post('inventario_inicial');

            if ($determina_precio == '')
                $determina_precio = '0';

            $datos = array(
                "orden_pedido" => $orden_pedido,
                "cotizacion" => $cotizacion,
                "orden_compra" => $orden_compra,
                "orden_servicio" => $orden_servicio,
                "inventario" => $inventario,
                "guia_ingreso" => $guia_ingreso,
                "guia_salida" => $guia_salida,
                "vale_salida" => $vale_salida,
                "factura" => $factura,
                "boleta" => $boleta,
                "guia_remision" => $guia_remision,
                "nota_credito" => $nota_credito,
                "nota_debito" => $nota_debito,
                "presupuesto" => $presupuesto,
                "comprobante_general" => $comprobante_general,
                "importacion" => $importacion,
                "ordenventa" => $ordenventa,
                "cobrarnumero" => $cobrarnumero,
                "pagarnumero" => $pagarnumero
            );
            $datos_serie = array(
                "orden_pedido" => $orden_pedido_serie,
                "cotizacion" => $cotizacion_serie,
                "orden_compra" => $orden_compra_serie,
                "orden_servicio" => $orden_servicio_serie,
                "inventario" => $inventario_serie,
                "guia_ingreso" => $guia_ingreso_serie,
                "guia_salida" => $guia_salida_serie,
                "vale_salida" => $vale_salida_serie,
                "factura" => $factura_serie,
                "boleta" => $boleta_serie,
                "guia_remision" => $guia_remision_serie,
                "nota_credito" => $nota_credito_serie,
                "nota_debito" => $nota_debito_serie,
                "presupuesto" => $presupuesto_serie,
                "comprobante_general" => $comprobante_general_serie,
                "importacion" => $importacion_serie,
                "ordenventa_serie" => $ordenventa_serie,
                "cobrarserie" => $cobrarserie,
                "pagarserie" => $pagarserie
            );
            $logo = "Mi loguito";
            $this->configuracion_model->modificar_configuracion_total($cboPrincipal, $logo, $tipo_valorizacion, $datos, $datos_serie);
            $this->companiaconfiguracion_model->modificar($cboPrincipal, $igv, ($contiene_igv == '' ? '0' : $contiene_igv), $determina_precio);
            if ($cliente)
                $cliente = "1";
            else
                $cliente = "0";
            if ($proveedor)
                $proveedor = "1";
            else
                $proveedor = "0";
            if ($producto)
                $producto = "1";
            else
                $producto = "0";
            if ($familia)
                $familia = "1";
            else
                $familia = "0";
            if ($s_comprobante)
                $s_comprobante = "1";
            else
                $s_comprobante = "1";
            if ($s_guia)
                $s_guia = "1";
            else
                $s_guia = "1";
            if ($inventario_inicial)
                $inventario_inicial = "1";
            else
                $inventario_inicial = "0";
            //echo $cliente." - ".$proveedor." - ".$producto." - ".$familia;exit;
            $this->companiaconfiguracion_model->modificar_compartido($cboPrincipal, $cliente, $proveedor, $producto, $familia);
            $this->companiaconfiguracion_model->modificar_mov_stock($cboPrincipal, $s_comprobante, $s_guia);
            $this->companiaconfiguracion_model->modificar_inventario_inicial($cboPrincipal, $inventario_inicial);
            $this->layout->view('seguridad/inicio');
        }
    }

    public function cargar_configuracion_detalle() {
        $compania = $this->input->post('compania');
        $datos_configuracion = $this->configuracion_model->obtener_configuracion($compania);
        if (count($datos_configuracion) > 0) {
            foreach ($datos_configuracion as $indice => $valor) {
                $id = $valor->DOCUP_Codigo;
                $numero = $valor->CONFIC_Numero;
                switch ($id) {
                    case 1 : $arrayValores[0] = $numero;
                        break; //orden_pedido
                    case 2: $arrayValores[1] = $numero;
                        break; //cotizacion
                    case 3: $arrayValores[2] = $numero;
                        break; //ocompra
                    case 4: $arrayValores[3] = $numero;
                        break; //inventario
                    case 5: $arrayValores[4] = $numero;
                        break; //guiain
                    case 6: $arrayValores[5] = $numero;
                        break; //guiasa
                    case 7: $arrayValores[6] = $numero;
                        break; //valesa
                    case 8: $arrayValores[7] = $numero;
                        break; //factura
                    case 9: $arrayValores[8] = $numero;
                        break; //boleta
                    case 10: $arrayValores[9] = $numero;
                        break; //guiaremi
                    case 11: $arrayValores[10] = $numero;
                        break; //notacred
                    case 12: $arrayValores[11] = $numero;
                        break; //notadeb
                }
            }
            $tblCompania = '<table class="fuente8" width="98%" cellspacing="0" cellpadding="6" border="0">';
            $tblCompania .='<tr>';
            $tblCompania.='<td width="12%"><div align="left">Orden de Pedido</div></td>';
            $tblCompania.=' <td width="22%"><div align="left">';
            $tblCompania.='<input type="text" class="cajaPequena" name="orden_pedido" id="orden_pedido" value="' . $arrayValores[0] . '">';
            $tblCompania.='</div></td>';
            $tblCompania.='<td align="left" valign="top"><div align="left">Guia de Ingreso</div></td>';
            $tblCompania.='<td align="left" valign="top"><div align="left">';
            $tblCompania.='<input type="text" class="cajaPequena" name="guia_ingreso" id="guia_ingreso" value="' . $arrayValores[4] . '">';
            $tblCompania.='</div></td>';
            $tblCompania.='<td width="13%"><div align="left">Boleta</div></td>';
            $tblCompania.='<td width="20%" align="center" valign="top">';
            $tblCompania.='<div align="left"><input type="text" class="cajaPequena" name="boleta" id="boleta" value="' . $arrayValores[8] . '"></div>';
            $tblCompania.='</td>';
            $tblCompania.='</tr>';
            $tblCompania.='<tr>';
            $tblCompania.='<td width="12%"><div align="left">Cotizaci&oacute;n</div></td>';
            $tblCompania.='<td width="22%"><div align="left">';
            $tblCompania.='<input type="text" class="cajaPequena" name="cotizacion" id="cotizacion" value="' . $arrayValores[1] . '">';
            $tblCompania.='</div></td>';
            $tblCompania.='<td align="left" valign="top"><div align="left">Guia de Salida</div></td>';
            $tblCompania.='<td align="left" valign="top"><div align="left">';
            $tblCompania.='<input type="text" class="cajaPequena" name="guia_salida" id="guia_salida" value="' . $arrayValores[5] . '">';
            $tblCompania.='</div></td>';
            $tblCompania.='<td><div align="left">Guia de remisi&oacute;n</div></td>';
            $tblCompania.='<td align="center" valign="top"><div align="left">';
            $tblCompania.='<input type="text" class="cajaPequena" name="guia_remision" id="guia_remision" value="' . $arrayValores[9] . '">';
            $tblCompania.='</div></td>';
            $tblCompania.='</tr>';
            $tblCompania.='<tr>';
            $tblCompania.='<td width="12%"><div align="left">Orden de Compra</div></td>';
            $tblCompania.='<td width="22%"><div align="left">';
            $tblCompania.='<input type="text" class="cajaPequena" name="orden_compra" id="orden_compra" maxlength="11" onBlur="obtener_proveedor();" value="' . $arrayValores[2] . '">';
            $tblCompania.='</div></td>';
            $tblCompania.='<td align="left" valign="top"><div align="left">Vale de salida</div></td>';
            $tblCompania.='<td align="left" valign="top"><div align="left">';
            $tblCompania.='<input type="text" class="cajaPequena" name="vale_salida" id="vale_salida" value="' . $arrayValores[6] . '">';
            $tblCompania.='</div></td>';
            $tblCompania.='<td align="left" valign="top"><div align="left">Nota de cr&eacute;dito</div></td>';
            $tblCompania.='<td align="left" valign="top"><div align="left">';
            $tblCompania.='<input type="text" class="cajaPequena" name="nota_credito" id="nota_credito" value="' . $arrayValores[10] . '">';
            $tblCompania.='</div></td>';
            $tblCompania.='</tr>';
            $tblCompania.='<tr>';
            $tblCompania.='<td align="left" valign="top"><div align="left">Inventario</div></td>';
            $tblCompania.='<td align="left" valign="top"><div align="left">';
            $tblCompania.='<input type="text" class="cajaPequena" name="inventario" id="inventario" value="' . $arrayValores[3] . '">';
            $tblCompania.='</div></td>';
            $tblCompania.='<td width="11%"><div align="left">Factura</div></td>';
            $tblCompania.='<td width="22%" align="center" valign="top"><div align="left">';
            $tblCompania.='<input type="text" class="cajaPequena" name="factura" id="factura" value="' . $arrayValores[7] . '">';
            $tblCompania.='</div></td>';
            $tblCompania.='<td align="left" valign="top"><div align="left">Nota de d&eacute;bito</div></td>';
            $tblCompania.='<td align="left" valign="top"><div align="left">';
            $tblCompania.='<input type="text" class="cajaPequena" name="nota_debito" id="nota_debito" value="' . $arrayValores[11] . '">';
            $tblCompania.='</div></td>';
            $tblCompania.='</tr>';
            $tblCompania.='<tr>';
            $tblCompania.='<td align="left" valign="top">&nbsp;</td>';
            $tblCompania.='<td align="left" valign="top">&nbsp;</td>';
            $tblCompania.='<td>&nbsp;</td>';
            $tblCompania.='<td align="center" valign="top">&nbsp;</td>';
            $tblCompania.='<td align="left" valign="top">&nbsp;</td>';
            $tblCompania.='<td align="left" valign="top">&nbsp;</td>';
            $tblCompania.='</tr>';
            $tblCompania.='</table>';
        } else {
            $tblCompania = '<table>';
            $tblCompania.='<tr>';
            $tblCompania.='<td>NO EXISTEN REGISTROS</td>';
            $tblCompania.='</tr>';
            $tblCompania.='</table>';
        }
        echo $tblCompania;
    }

    public function seleccionar_compania($indSel = '') {
        $array_compania = $this->compania_model->listar();
        $arreglo = array();
        foreach ($array_compania as $indice => $valor) {
            $compania = $valor->COMPP_Codigo;
            $indice = $valor->EMPRP_Codigo;
            $datos_empresa = $this->empresa_model->obtener_datosEmpresa($indice);
            if(count($datos_empresa)>0){
            $razon_social = $datos_empresa[0]->EMPRC_RazonSocial;
            $arreglo[$compania] = $razon_social;
        	}
        }
        $resultado = $this->html->optionHTML($arreglo, $indSel, array('', '::Seleccione::'));
        return $resultado;
    }

    function seleccionar_determinaprecio($indSel = '') {
        $arreglo = array('0' => 'Los árticulos poseen un único precio.',
            '1' => 'El precio de un árticulo depende de la categoría del cliente.',
            '2' => 'El precio de un árticulo depente de la tienda.',
            '3' => 'El precio de un árticulo depende de la categoría del cliente y de la tienda.');
        $resultado = $this->html->optionHTML($arreglo, $indSel, array('', '::Seleccione::'));
        return $resultado;
    }

    public function cargar_configuracion_compartido() {
        $compania = $this->input->post('compania');
        $comp_confi = $this->companiaconfiguracion_model->obtener($compania);
        $cliente = $comp_confi[0]->COMPCONFIC_Cliente;
        $proveedor = $comp_confi[0]->COMPCONFIC_Proveedor;
        $producto = $comp_confi[0]->COMPCONFIC_Producto;
        $familia = $comp_confi[0]->COMPCONFIC_Familia;
        if ($cliente == "1") {
            $chk_c = '<input type="checkbox" name="cliente_com" id="cliente_com" checked="checked" />';
        } else {
            $chk_c = '<input type="checkbox" name="cliente_com" id="cliente_com" />';
        }
        if ($proveedor == "1") {
            $chk_pr = '<input type="checkbox" name="proveedor_com" id="proveedor_com" checked="checked" />';
        } else {
            $chk_pr = '<input type="checkbox" name="proveedor_com" id="proveedor_com" />';
        }
        if ($producto == "1") {
            $chk_p = '<input type="checkbox" name="producto_com" id="producto_com" checked="checked" />';
        } else {
            $chk_p = '<input type="checkbox" name="producto_com" id="producto_com" />';
        }
        if ($familia == "1") {
            $chk_f = '<input type="checkbox" name="familia_com" id="familia_com" checked="checked" />';
        } else {
            $chk_f = '<input type="checkbox" name="familia_com" id="familia_com" />';
        }
        $div = '';
        $div.='<table class="fuente8" width="98%" cellspacing="0" cellpadding="6" border="0">
				  <tr>
					<td colspan="2"><b>COMPARTIR</b></td>
				  </tr>
				  <tr>
					<td width="20%">CLIENTES</td>
					<td align="left">' . $chk_c . '</td>
				  </tr>
				  <tr>
					<td width="20%">PROVEEDORES</td>
					<td align="left">' . $chk_pr . '</td>
				  </tr>
				  <tr>
					<td width="20%">PRODUCTOS</td>
					<td align="left">' . $chk_p . '</td>
				  </tr>
				  <tr>
					<td width="20%">FAMILIAS</td>
					<td align="left">' . $chk_f . '</td>
				  </tr>
				  <tr>
					<td colspan="2"><div align="center"><hr width="100%"></div></td>
				  </tr>
			   </table>';
        echo $div;
    }

    #######################################
    ###### AGREGAR EMPRESAS Y COMPAÑIAS
    #######################################

    public function agregar_empresa(){
        $filter = new stdClass();
        $filter->CIIUP_Codigo = "0";
        $filter->TIPCOD_Codigo = "1";
        $filter->SECCOMP_Codigo = "1"; # 1 PARA QUE LA EMPRESA ESTE DISPONIBLE PARA HACER TRANSPORTES EN LA GUIA DE REMISIÓN
        $filter->EMPRC_Ruc = $this->input->post("ruc");
        $filter->EMPRC_RazonSocial = $this->input->post("razon_social");
        $filter->EMPRC_Telefono = $this->input->post("telefono");
        $filter->EMPRC_Movil = $this->input->post("movil");
        $filter->EMPRC_Fax = $this->input->post("fax");
        $filter->EMPRC_Web = $this->input->post("web");
        $filter->EMPRC_Email = $this->input->post("email");
        $filter->EMPRC_CtaCteSoles = "";
        $filter->EMPRC_CtaCteDolares = "";
        $filter->EMPRC_FechaRegistro = date("Y-m-d h:i:s");
        $filter->EMPRC_FechaModificacion = NULL;
        $filter->EMPRC_FlagEstado = "1";
        $filter->EMPRC_Direccion = $this->input->post("direccion");

        $empresa = $this->compania_model->agregar_empresa($filter);

        if ($empresa != NULL && $empresa != "")
            $json = array("result" => "success");
        else
            $json = array("result" => "error");

        echo json_encode($json);
    }

    public function agregar_companias(){

        $empresa = $this->input->post("empresa");
        $ubigeo = $this->input->post("ubigeo");
        $descripcion = $this->input->post("descripcion");
        $direccion = $this->input->post("direccion");
        $flagProducto = true;//$this->input->post("compartir_productos");

        ###################################
        ######### ESTABLECIMIENTO
        ###################################
            $filterEstablecimiento = new stdClass();
            $filterEstablecimiento->EESTABP_Codigo = NULL;
            $filterEstablecimiento->TESTP_Codigo = "1";
            $filterEstablecimiento->EMPRP_Codigo = $empresa;
            $filterEstablecimiento->UBIGP_Codigo = $ubigeo;
            $filterEstablecimiento->EESTABC_Descripcion = $descripcion;
            $filterEstablecimiento->EESTAC_Direccion = $direccion;
            $filterEstablecimiento->EESTABC_FechaRegistro = date('Y-m-d h:i:s');
            $filterEstablecimiento->EESTABC_FechaModificacion = NULL;
            $filterEstablecimiento->EESTABC_FlagTipo = "1";
            $filterEstablecimiento->EESTABC_FlagEstado = "1";

            $establecimiento = $this->compania_model->agregar_establecimiento($filterEstablecimiento);

        ###################################
        ######### COMPAÑIA
        ###################################
            $filterCompania = new stdClass();
            $filterCompania->COMPP_Codigo = NULL;
            $filterCompania->EMPRP_Codigo = $empresa;
            $filterCompania->EESTABP_Codigo = $establecimiento;
            $filterCompania->COMPC_Logo = "";
            $filterCompania->COMPC_TipoValorizacion = "0";
            $filterCompania->COMPC_FlagEstado = "1";

            $compania = $this->compania_model->agregar_compania($filterCompania);

        ###################################
        ######### USUARIOS
        ###################################
            # USUARIO CCAPA
            $filterUsuarioCompania = new stdClass();
            $filterUsuarioCompania->USUCOMP_Codigo = NULL;
            $filterUsuarioCompania->USUA_Codigo = 2;
            $filterUsuarioCompania->COMPP_Codigo = $compania;
            $filterUsuarioCompania->ROL_Codigo = "7000";
            $filterUsuarioCompania->CARGP_Codigo = "0";
            $filterUsuarioCompania->USUCOMC_Default = "1";

            $this->compania_model->agregar_usuario_compania($filterUsuarioCompania);

            # USUARIO ADMINISTRADOR
            $filterUsuarioCompania->USUA_Codigo = 1;
            $filterUsuarioCompania->ROL_Codigo = "1";
            $filterUsuarioCompania->CARGP_Codigo = "1";
            $filterUsuarioCompania->USUCOMC_Default = "1";

            $this->compania_model->agregar_usuario_compania($filterUsuarioCompania);


        ###################################
        ######### PRODUCTOS
        ###################################  
            if($flagProducto==true){  
                $listado = $this->producto_model->productos_sistema();
                $lista = array();
                
                if ( count($listado) > 0 ){
                    foreach ($listado as $indice => $valor) {
                        $data = array(
                                "PROD_Codigo" => $valor->PROD_Codigo,
                                "COMPP_Codigo" => $compania
                            );
                        $this->db->insert("cji_productocompania", $data);
                    }
                }
            }
        ###################################

        $json = array("result" => "success");
        echo json_encode($json);
    }

}

?>