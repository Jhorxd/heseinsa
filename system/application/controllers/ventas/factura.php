<?php
class Factura extends Controller
{
    public function __construct()
    {
        parent::Controller();
        $this->load->helper('form');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('html');
        $this->load->model('compras/cotizacion_model');
        $this->load->model('compras/pedido_model');
        $this->load->model('compras/proveedor_model');
        $this->load->model('ventas/factura_model');
        $this->load->model('ventas/facturadetalle_model');
        $this->load->model('ventas/presupuesto_model');
        $this->load->model('ventas/cliente_model');
        $this->load->model('almacen/producto_model');
        $this->load->model('almacen/almacen_model');
        $this->load->model('almacen/unidadmedida_model');
        $this->load->model('maestros/empresa_model');
        $this->load->model('maestros/persona_model');
        $this->load->model('maestros/moneda_model');
        $this->load->model('maestros/formapago_model');
        $this->load->model('maestros/condicionentrega_model');
        $this->load->model('seguridad/usuario_model');
        
    }
    public function index(){
        $this->load->view('seguridad/inicio');
        $this->load->library('layout','layout');
    }
    public function facturas($j='0')
    {   $this->load->library('layout','layout');
    
        $data['registros']   = count($this->factura_model->listar_facturas());
        $conf['base_url']    = site_url('ventas/facturas/');
        $conf['per_page']    = 10;
        $conf['num_links']   = 3;
        $conf['first_link']  = "&lt;&lt;";
        $conf['last_link']   = "&gt;&gt;";
        $conf['total_rows']  = $data['registros'];
        $offset              = (int)$this->uri->segment(3);
        $listado_facturas    = $this->factura_model->listar_facturas($conf['per_page'],$offset);
        $item                = $j+1;
        $lista               = array();
        if(count($listado_facturas)>0){
            foreach($listado_facturas as $indice=>$valor)
            {
                $codigo          = $valor->FACTP_Codigo;
                $presupuesto     = $valor->PRESUP_Codigo;
                $serie           = $valor->FACTC_Serie;
                $numero          = $valor->FACTC_Numero;
                $cliente         = $valor->CLIP_Codigo;
                $total           = $valor->FACTC_total;
                $fecha           = mysql_to_human($valor->FACTC_Fecha);
                $datos_cliente   = $this->cliente_model->obtener_datosCliente($cliente);
                $datos_presupuesto  = $this->presupuesto_model->obtener_presupuesto($presupuesto);
                $empresa         = $datos_cliente[0]->EMPRP_Codigo;
                $persona         = $datos_cliente[0]->PERSP_Codigo;
                $tipo            = $datos_cliente[0]->CLIC_TipoPersona;
                $n_presupuesto   = $datos_presupuesto[0]->PRESUC_Numero;
                if($n_presupuesto=='0'){$n_presupuesto = "****";}
                if($tipo==0){
                    $datos_persona = $this->persona_model->obtener_datosPersona($persona);
                    $nombre_cliente = $datos_persona[0]->PERSC_Nombre." ".$datos_persona[0]->PERSC_ApellidoPaterno." ".$datos_persona[0]->PERSC_ApellidoMaterno;
                }
                elseif($tipo==1){
                    $datos_empresa = $this->empresa_model->obtener_datosEmpresa($empresa);
                    $nombre_cliente = $datos_empresa[0]->EMPRC_RazonSocial;
                }
                $editar         = "<a href='javascript:;' onclick='editar_factura(".$codigo.")' target='_parent'><img src='".URL_IMAGE."modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver            = "<a href='javascript:;' onclick='ver_factura_pdf(".$codigo.")' target='_parent'><img src='".URL_IMAGE."ver.png' width='16' height='16' border='0' title='Ver'></a>";
                $ver2            = "<a href='javascript:;' onclick='ver_factura_pdf2(".$codigo.")' target='_parent'><img src='".URL_IMAGE."pdf.png' width='16' height='16' border='0' title='Ver PDF'></a>";
                $eliminar       = "<a href='javascript:;' onclick='eliminar_factura(".$codigo.")' target='_parent'><img src='".URL_IMAGE."eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $lista[]        = array($item++,$fecha,$serie, $numero,$n_presupuesto,$nombre_cliente,$total,$editar,$ver,$ver2,$eliminar);
            }
        }
        $data['titulo_tabla']    = "RELACI&Oacute;N de FACTURAS";
        $data['titulo_busqueda'] = "BUSCAR FACTURA";
        $data['lista']      = $lista;
        $data['oculto']     = form_hidden(array('base_url'=>base_url()));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('ventas/factura_index',$data);
    }
    public function factura_nueva()
    {   $this->load->library('layout','layout');
    
        $codigo               = "";
        $oculto               = form_hidden(array('codigo'=>$codigo,'base_url'=>base_url()));
        $data['url_action']   = base_url()."index.php/ventas/factura/factura_insertar";
        $data['titulo']       = "REGISTRAR FACTURAS";
        $data['formulario']   = "frmFactura";
        $data['oculto']       = $oculto;
        $data['onload']	      = "onload=\"$('#nombre').focus();\"";
        $data['cboMoneda']    = $this->OPTION_generador($this->moneda_model->listar(), 'MONED_Codigo', 'MONED_Descripcion', '2');
        $data['cboFormaPago'] = $this->OPTION_generador($this->formapago_model->listar(), 'FORPAP_Codigo', 'FORPAC_Descripcion', '1');
        $data['cboPresupuesto']      = $this->OPTION_presupuesto('0');
        $data['serie']           = "001";
        $data['numero']          = "";
        $data['ruc']             = "";
        $data['nombre_cliente']  = "";
        $data['cliente']         = "";
        $data['detalle_factura'] = array();
        $data['observacion']     = "";
        $data['focus']           = "";
        $data['pedido']          = "";
        $data['descuento']       = "0";
        $data['igv']             = "19";
        $data['hidden']          = "";
        $data['preciototal']     = "";
        $data['descuentotal']    = "";
        $data['igvtotal']        = "";
        $data['importetotal']    = "";
        $data['hidden']          = "";
        $data['observacion']     = "";
        $data['hoy']             = mysql_to_human(mdate("%Y-%m-%d ",time()));
        $atributos               = array('width'=>600,'height'=>400,'scrollbars'=>'yes','status'=>'yes','resizable'=>'yes','screenx'=>'0','screeny'=>'0');
        $contenido               = "<img height='16' width='16' src='".URL_IMAGE."ver.png' title='Buscar Cliente' border='0'>";
        $data['vercliente']	 = anchor_popup('ventas/cliente/ventana_busqueda_cliente',$contenido,$atributos);
        $data['verproducto']     = anchor_popup('almacen/producto/ventana_busqueda_producto',$contenido,$atributos);
        $this->layout->view('ventas/factura_nueva',$data);
    }
    public function factura_insertar()
    {   $this->load->library('layout','layout');
    
        $cliente          = $this->input->post('cliente');
        $presupuesto      = $this->input->post('presupuesto');
        $forma_pago       = $this->input->post('forma_pago');
        $observacion      = $this->input->post('observacion');
        $fecha            = human_to_mysql($this->input->post('fecha'));
        $numero           = "";//Se genera automatico y en forma correlativa.
        $serie            = $this->input->post('serie');
        $moneda           = $this->input->post('moneda');
        $descuento        = $this->input->post('descuento');
        $igv              = $this->input->post('igv');
        
        $subtotal         = $this->input->post('preciototal');
        $descuentotal     = $this->input->post('descuentotal');
        $igvtotal         = $this->input->post('igvtotal');
        $total            = $this->input->post('importetotal');
        
        
        $prodcodigo       = $this->input->post('prodcodigo');
        $prodpu           =  $this->input->post('prodpu');
        $prodcantidad     = $this->input->post('prodcantidad');
        $prodprecio       =  $this->input->post('prodprecio');
        $proddescuento    =  $this->input->post('proddescuento');
        $prodigv          =  $this->input->post('prodigv');
        $prodimporte      =  $this->input->post('prodimporte');
        $produnidad       = $this->input->post('produnidad');
        $proddescuento100 =  $this->input->post('proddescuento100');
        $prodigv100       =  $this->input->post('prodigv100');
        $factura          = $this->factura_model->insertar_factura($presupuesto,$forma_pago,$serie,$numero,$cliente,$moneda,$subtotal,$descuentotal,$igvtotal,$total,$igv,$descuento,$observacion,$fecha);
        if(count($prodcodigo)>0)
        {
            foreach($prodcodigo as $indice=>$valor)
            {
                $producto      = $prodcodigo[$indice];
                $unidad        = $produnidad[$indice];
                $pu            = $prodpu[$indice];
                $cantidad      = $prodcantidad[$indice];
                $subtotal      = $prodprecio[$indice];
                $detalle_descuento    = $proddescuento[$indice];
                $detalle_igv          = $prodigv[$indice];
                $total                = $prodimporte[$indice];
                $detalle_descuento100 = $proddescuento100[$indice];
                $detalle_igv100       = $prodigv100[$indice];
                $observ               = "";
                $this->facturadetalle_model->insertar($factura,$producto,$unidad,$pu,$cantidad,$subtotal,$detalle_descuento,$detalle_igv,$total,$detalle_descuento100,$detalle_igv100,$observ);
            }
        }
        $this->facturas();
    }
    public function factura_editar($codigo)
    {   $this->load->library('layout','layout');
    
        $datos_factura   = $this->factura_model->obtener_factura($codigo);
        $presupuesto     = $datos_factura[0]->PRESUP_Codigo;
        $serie           = $datos_factura[0]->FACTC_Serie;
        $numero          = $datos_factura[0]->FACTC_Numero;
        $cliente         = $datos_factura[0]->CLIP_Codigo;
        $forma_pago      = $datos_factura[0]->FORPAP_Codigo;
        $moneda          = $datos_factura[0]->MONED_Codigo;
        $subtotal        = $datos_factura[0]->FACTC_subtotal;
        $descuento       = $datos_factura[0]->FACTC_descuento;
        $igv             = $datos_factura[0]->FACTC_igv;
        $igv100          = $datos_factura[0]->FACTC_igv100;
        $descuento100    = $datos_factura[0]->FACTC_descuento100;
        $total           = $datos_factura[0]->FACTC_total;
        $observacion     = $datos_factura[0]->FACTC_Observacion;
        $fecha           = mysql_to_human($datos_factura[0]->FACTC_Fecha);
        $datos_cliente   = $this->cliente_model->obtener_datosCliente($cliente);
        $empresa         = $datos_cliente[0]->EMPRP_Codigo;
        $persona         = $datos_cliente[0]->PERSP_Codigo;
        $tipo            = $datos_cliente[0]->CLIC_TipoPersona;
        if($tipo==0)
        {   $datos_persona = $this->persona_model->obtener_datosPersona($persona);
            $nombre_cliente = $datos_persona[0]->PERSC_Nombre." ".$datos_persona[0]->PERSC_ApellidoPaterno." ".$datos_persona[0]->PERSC_ApellidoMaterno;
            $ruc  = $datos_persona[0]->PERSC_Ruc;
        }
        elseif($tipo==1)
        {   $datos_empresa = $this->empresa_model->obtener_datosEmpresa($empresa);
            $nombre_cliente = $datos_empresa[0]->EMPRC_RazonSocial;
            $ruc  = $datos_empresa[0]->EMPRC_Ruc;
        }
        $data['cboPresupuesto'] = $this->OPTION_presupuesto($presupuesto);
        $data['cboFormaPago']   = $this->OPTION_generador($this->formapago_model->listar(), 'FORPAP_Codigo', 'FORPAC_Descripcion', $forma_pago);
        $data['cboMoneda']      = $this->OPTION_generador($this->moneda_model->listar(), 'MONED_Codigo', 'MONED_Descripcion',$moneda);
        $data['serie']          = $serie;
        $data['numero']         = $numero;
        $data['ruc']            = $ruc;
        $data['descuento']      = $descuento100;
        $data['igv']            = $igv100;
        $data['descuentotal']   = $descuento;
        $data['igvtotal']       = $igv;
        $data['preciototal']    = $subtotal;
        $data['importetotal']   = $total;
        $data['nombre_cliente'] = $nombre_cliente;
        $oculto                 = form_hidden(array('codigo'=>$codigo,'base_url'=>base_url()));
        $data['titulo']         = "EDITAR FACTURA";
        $data['formulario']     = "frmFactura";
        $data['oculto']         = $oculto;
        $data['onload']		= "onload=\"\"";
        $data['url_action']     = base_url()."index.php/ventas/factura/factura_modificar";
        $atributos               = array('width'=>600,'height'=>400,'scrollbars'=>'yes','status'=>'yes','resizable'=>'yes','screenx'=>'0','screeny'=>'0');
        $contenido               = "<img height='16' width='16' src='".URL_IMAGE."ver.png' title='Buscar Cliente' border='0'>";
        $data['vercliente']	 = anchor_popup('ventas/cliente/ventana_busqueda_cliente',$contenido,$atributos);
        $data['verproducto']     = anchor_popup('almacen/producto/ventana_busqueda_producto',$contenido,$atributos);
        $data['hoy']            = $fecha;
        $data['cliente']        = $cliente;
        $data['observacion']    = $observacion;
        $data['hidden']         = "";
        $data['focus']          = "javascript:this.blur();return false;";
        $detalle                = $this->facturadetalle_model->listar($codigo);
        $detalle_factura        = $this->obtener_lista_detalles($codigo);
        
        $data['detalle_factura']= $detalle_factura;
        $this->layout->view('ventas/factura_nueva',$data);
    }
    public function factura_modificar()
    {   $this->load->library('layout','layout');
    
        $codigo        = $this->input->post('codigo');
        
        $cliente       = $this->input->post('cliente');
        $presupuesto   = $this->input->post('presupuesto');
        $forma_pago    = $this->input->post('forma_pago');
        $observacion   = $this->input->post('observacion');
        $fecha         = human_to_mysql($this->input->post('fecha'));
        $numero        = $this->input->post('numero');
        $serie         = $this->input->post('serie');
        $cliente       = $this->input->post('cliente');
        $moneda        = $this->input->post('moneda');
        $descuento100  = $this->input->post('descuento');
        $igv100        = $this->input->post('igv');
        
        $subtotal      =  $this->input->post('preciototal');
        $descuento     = $this->input->post('descuentotal');
        $igv           = $this->input->post('igvtotal');
        $total         = $this->input->post('importetotal');
        
        $prodcodigo    = $this->input->post('prodcodigo');
        $prodpu        = $this->input->post('prodpu');
        $prodcantidad  = $this->input->post('prodcantidad');
        $prodprecio    =  $this->input->post('prodprecio');
        $proddescuento =  $this->input->post('proddescuento');
        $prodigv       =  $this->input->post('prodigv');
        $prodimporte   =  $this->input->post('prodimporte');
        $produnidad    = $this->input->post('produnidad');
        $detaccion     = $this->input->post('detaccion');
        $detfact       = $this->input->post('detfact');
        $prodigv100    = $this->input->post('prodigv100');
        $proddescuento100 = $this->input->post('proddescuento100');
        $this->factura_model->modificar_factura($codigo,$presupuesto,$forma_pago,$serie,$numero,$cliente,$moneda,$subtotal,$descuento, $igv,$total,$igv100,$descuento100,$observacion,$fecha);
        if(count($detfact)>0)
        {
            foreach($detfact as $indice=>$valor){
              $detalle_accion    = $detaccion[$indice];

              $producto      = $prodcodigo[$indice];
              $unidad        = $produnidad[$indice];
              $pu            = $prodpu[$indice];
              $cantidad      = $prodcantidad[$indice];
              $subtotal      = $prodprecio[$indice];
              $detalle_descuento    = $proddescuento[$indice];
              $detalle_igv          = $prodigv[$indice];
              $total                = $prodimporte[$indice];
              $detalle_descuento100 = $proddescuento100[$indice];
              $detalle_igv100       = $prodigv100[$indice];
              $observ               = "";
              if($detalle_accion=='n'){
                    $this->facturadetalle_model->insertar($codigo,$producto,$unidad,$pu,$cantidad,$subtotal,$detalle_descuento,$detalle_igv,$total,$detalle_descuento100,$detalle_igv100,$observ);  
              }elseif($detalle_accion=='m') {
                      $this->facturadetalle_model->modificar($valor, $producto,$unidad,$pu,$cantidad,$subtotal,$detalle_descuento,$detalle_igv,$total,$detalle_descuento100,$detalle_igv100,$observ);
              }elseif($detalle_accion=='e'){
                      $this->facturadetalle_model->eliminar($valor);
              }
            }
        }
        $this->facturas();
        
    }
    public function factura_eliminar(){
        $this->load->library('layout','layout');
        
        $factura = $this->input->post('factura');
        $this->factura_model->eliminar_factura($factura);
    }
    public function factura_buscar(){

    }
    public function obtener_lista_detalles($codigo){
        $detalle                = $this->facturadetalle_model->listar($codigo);
        $lista_detalles        = array();
        if(count($detalle)>0){
            foreach($detalle as $indice=>$valor)
            {
                $detfact         = $valor->FACTDEP_Codigo;
                $producto        = $valor->PROD_Codigo;
                $unidad          = $valor->UNDMED_Codigo;
                $pu              = $valor->FACTDEC_Pu;
                $cantidad        = $valor->FACTDEC_Cantidad;
                $subtotal        = $valor->FACTDEC_Subtotal;
                $igv             = $valor->FACTDEC_Igv;
                $descuento       = $valor->FACTDEC_Descuento;
                $total           = $valor->FACTDEC_Total;
                $descuento100    = $valor->FACTDEC_Descuento100;
                $igv100          = $valor->FACTDEC_Igv100;
                $observacion     = $valor->FACTDEC_Observacion;
                $datos_producto  = $this->producto_model->obtener_producto($producto);
                $datos_unidad    = $this->unidadmedida_model->obtener($unidad);
                $nombre_producto = $datos_producto[0]->PROD_Nombre;
                $codigo_interno  = $datos_producto[0]->PROD_CodigoInterno;
                $nombre_unidad   = $datos_unidad[0]->UNDMED_Simbolo;
                $objeto   =   new stdClass();
                $objeto->FACTDEP_Codigo      = $detfact;
                $objeto->PROD_Codigo         = $producto;
                $objeto->PROD_CodigoInterno  = $codigo_interno;
                $objeto->UNDMED_Codigo       = $unidad;
                $objeto->UNDMED_Simbolo      = $nombre_unidad;
                $objeto->PROD_Nombre         = $nombre_producto;
                $objeto->FACTDEC_Pu          = $pu;
                $objeto->FACTDEC_Cantidad    = $cantidad;
                $objeto->FACTDEC_Subtotal    = $subtotal;
                $objeto->FACTDEC_Descuento   = $descuento;
                $objeto->FACTDEC_Igv         = $igv;
                $objeto->FACTDEC_Descuento100 = $descuento100;
                $objeto->FACTDEC_Igv100      = $igv100;
                $objeto->FACTDEC_Total       = $total;
                $objeto->FACTDEC_Observacion = $observacion;
                $lista_detalles[]           = $objeto;
            }
        }
        return $lista_detalles;
    }
    
    public function factura_ver_pdf(){

    }
    public function factura_ver_pdf2($codigo)
    {      
    
        $datos_factura   = $this->factura_model->obtener_factura($codigo);
        $presupuesto     = $datos_factura[0]->PRESUP_Codigo;
        $serie           = $datos_factura[0]->FACTC_Serie;
        $numero          = $datos_factura[0]->FACTC_Numero;
        $cliente         = $datos_factura[0]->CLIP_Codigo;
        $subtotal        = $datos_factura[0]->FACTC_subtotal;
        $descuento       = $datos_factura[0]->FACTC_descuento;
        $igv             = $datos_factura[0]->FACTC_igv;
        $igv100          = $datos_factura[0]->FACTC_igv100;
        $descuento100    = $datos_factura[0]->FACTC_descuento100;
        $total           = $datos_factura[0]->FACTC_total;
        $observacion     = $datos_factura[0]->FACTC_Observacion;
        $fecha           = mysql_to_human($datos_factura[0]->FACTC_Fecha);
        $vendedor        = $datos_factura[0]->USUA_Codigo ;
        $datos_cliente   = $this->cliente_model->obtener_datosCliente($cliente);
        $empresa         = $datos_cliente[0]->EMPRP_Codigo;
        $persona         = $datos_cliente[0]->PERSP_Codigo;
        $tipo            = $datos_cliente[0]->CLIC_TipoPersona;
        
        $temp            = $this->usuario_model->obtener($vendedor);
        $temp            = $this->persona_model->obtener_datosPersona($temp->PERSP_Codigo );
        $vendedor        = $temp[0]->PERSC_Nombre.' '.$temp[0]->PERSC_ApellidoPaterno.' '.$temp[0]->PERSC_ApellidoMaterno;
            
        if($tipo==0)
        {   $datos_persona    = $this->persona_model->obtener_datosPersona($persona);
            $nombre_cliente   = $datos_persona[0]->PERSC_Nombre." ".$datos_persona[0]->PERSC_ApellidoPaterno." ".$datos_persona[0]->PERSC_ApellidoMaterno;
            $ruc              = $datos_persona[0]->PERSC_Ruc;
            $telefono         = $datos_persona[0]->PERSC_Telefono;
            $movil            = $datos_persona[0]->PERSC_Movil;
            $direccion        = $datos_persona[0]->PERSC_Direccion;
            $fax              = $datos_persona[0]->PERSC_Fax;
        }
        elseif($tipo==1)
        {   $datos_empresa    = $this->empresa_model->obtener_datosEmpresa($empresa);
            $nombre_cliente   = $datos_empresa[0]->EMPRC_RazonSocial;
            $ruc              = $datos_empresa[0]->EMPRC_Ruc;
            $telefono         = $datos_empresa[0]->EMPRC_Telefono;
            $movil            = $datos_empresa[0]->EMPRC_Movil;
            $fax              = $datos_empresa[0]->EMPRC_Fax;
            $emp_direccion    = $this->empresa_model->obtener_establecimientosEmpresa_principal($empresa);
            $direccion        = $emp_direccion[0]->EESTAC_Direccion;
        }
        $detalle_factura        = $this->obtener_lista_detalles($codigo);
        
        $this->load->library('cezpdf');
        $this->load->helper('pdf_helper');
	
        prep_pdf();
 
        /*Cabecera*/
        $delta=20;
        $options = array("leading"=>10,"left"=>12);
        $this->cezpdf->ezText('<b>Factura No:  '.$numero.'</b>',17,array("leading"=>120,"left"=>150));
        $this->cezpdf->ezText('','');
          
        /*Datos generales*/ 
        $db_data=array(array('cols0'=>'', 'cols1'=>'Fecha','cols2'=>$fecha), 
                        array('cols0'=>'', 'cols1'=>'Vendedor','cols2'=>$vendedor),
                        array('cols0'=>'', 'cols1'=>'No','cols2'=>$serie.' - '.$numero)
                        );         
         $this->cezpdf->ezTable($db_data,"","",array(
            'width'=>555,
            'showLines'=>0,
            'shaded'=>0,
            'showHeadings'=>0,
            'xPos'=>'center',
            'fontSize'=>7,
            'cols'=>array(
                'cols0'=>array('width'=>350,'justification'=>'left'),
                'cols1'=>array('width'=>50,'justification'=>'left'),
                'cols2'=>array('width'=>155,'justification'=>'left')
                )
        ));
         $this->cezpdf->ezText('','');
         $this->cezpdf->ezText('','');
         
        /*Datos del cliente*/ 
        $db_data=array(array('cols1'=>'Cliente','cols2'=>$nombre_cliente, 'cols3'=>'Telefono', 'cols4'=>$telefono), 
                       array('cols1'=>'RUC','cols2'=>$ruc, 'cols3'=>'Movil', 'cols4'=>$movil),
                       array('cols1'=>'Direccion','cols2'=>$direccion, 'cols3'=>'Fax', 'cols4'=>$fax)
                        );         
         $this->cezpdf->ezTable($db_data,"","",array(
            'width'=>555,
            'showLines'=>0,
            'shaded'=>0,
            'showHeadings'=>0,
            'xPos'=>'center',
            'fontSize'=>9,
            'cols'=>array(
                'cols1'=>array('width'=>70,'justification'=>'left'),
                'cols2'=>array('width'=>285,'justification'=>'left'),
                'cols3'=>array('width'=>70,'justification'=>'left'),
                'cols4'=>array('width'=>130,'justification'=>'left')
                )
        ));
        
        $this->cezpdf->ezText('','');
              
        /*Listado de detalles*/
        $db_data=array();
        foreach($detalle_factura as $indice=>$valor){
            $db_data[] = array(
                'cols1'=>$indice+1,
                'cols2' =>$valor->PROD_Codigo,
                'cols3'=>$valor->PROD_Nombre,
                'cols4'=>number_format($valor->FACTDEC_Pu,2),
                'cols5'=>$valor->FACTDEC_Cantidad,
                'cols6'=>number_format($valor->FACTDEC_Subtotal,2),
                'cols7'=>number_format($valor->FACTDEC_Descuento,2),
                'cols8'=>number_format($valor->FACTDEC_Igv,2),
                'cols9'=>number_format($valor->FACTDEC_Total,2)
                );
         }
         $col_names = array(
            'cols1' => 'Itm',
            'cols2' => 'Codigo',
            'cols3' => 'Descripcion',
            'cols4' => 'P.U.',
            'cols5' => 'Cantidad',
            'cols6' => 'Precio',
            'cols7'  => 'Dscto',
            'cols8'  => 'I.G.V.',
            'cols9'  => 'Importe',
         );
         
         $this->cezpdf->ezTable($db_data,$col_names, '', array(
            'width'=>555,
            'showLines'=>1,
            'shaded'=>0,
            'showHeadings'=>1,
            'xPos'=>'center',
            'fontSize'=>9,
            'cols'=>array(
                'cols1'=>array('width'=>25,'justification'=>'center'),
                'cols2'=>array('width'=>50,'justification'=>'center'),
                'cols3'=>array('width'=>170,'justification'=>'left'),
                'cols4'=>array('width'=>50,'justification'=>'center'),
                'cols5'=>array('width'=>50,'justification'=>'center'),
                'cols6'=>array('width'=>50,'justification'=>'center'),
                'cols7'=>array('width'=>50,'justification'=>'center'),
		'cols8'=>array('width'=>50,'justification'=>'center'),
                'cols9'=>array('width'=>50,'justification'=>'center')
                )
         ));
         
         $this->cezpdf->ezText('','');
         
         /*Totales*/
         $db_data=array(array('cols0'=>'', 'cols1'=>'Sub-total','cols2'=>  number_format($subtotal,2)), 
                        array('cols0'=>'', 'cols1'=>'Descuento   '.$descuento100.' %','cols2'=>number_format($descuento,2)),
                        array('cols0'=>'', 'cols1'=>'IVG              '.$igv100.' %','cols2'=>number_format($igv,2)),
                        array('cols0'=>'', 'cols1'=>'Precio Total','cols2'=>number_format($total,2))
                        );         
         $this->cezpdf->ezTable($db_data,"","",array(
            'width'=>555,
            'showLines'=>0,
            'shaded'=>0,
            'showHeadings'=>0,
            'xPos'=>'center',
            'fontSize'=>9,
            'cols'=>array(
                'cols0'=>array('width'=>400,'justification'=>'left'),
                'cols1'=>array('width'=>100,'justification'=>'left'),
                'cols2'=>array('width'=>55,'justification'=>'right')
                )
        ));
        
         /*Observación*/
        $this->cezpdf->ezText('Observacion','');
        $this->cezpdf->ezText($observacion,'',array("leading"=>30));
        

        $cabecera = array('Content-Type'=>'application/pdf','Content-Disposition'=>'nama_file.pdf','Expires'=>'0','Pragma'=>'cache','Cache-Control'=>'private');
        $this->cezpdf->ezStream($cabecera);
    }
    

    /*Combos*/
    public function OPTION_presupuesto($indSel='')
    {
        $array_presupuesto = $this->presupuesto_model->listar_presupuestos();
        $arreglo = array();
        if(count($array_presupuesto)>0){
            foreach($array_presupuesto as $indice=>$valor){
                $cliente           = $valor->CLIP_Codigo;
                $datos_cliente     = $this->cliente_model->obtener_datosCliente($cliente);
                $empresa           = $datos_cliente[0]->EMPRP_Codigo;
                $persona           = $datos_cliente[0]->PERSP_Codigo;
                $tipo              = $datos_cliente[0]->CLIC_TipoPersona;
                if($tipo==0){
                    $datos_persona = $this->persona_model->obtener_datosPersona($persona);
                    $nombre_proveedor = $datos_persona[0]->PERSC_Nombre." ".$datos_persona[0]->PERSC_ApellidoPaterno." ".$datos_persona[0]->PERSC_ApellidoMaterno;
                }
                elseif($tipo==1){
                    $datos_empresa = $this->empresa_model->obtener_datosEmpresa($empresa);
                    $nombre_proveedor = $datos_empresa[0]->EMPRC_RazonSocial;
                }
                $indice1   = $valor->PRESUP_Codigo;
                $valor1    = $valor->PRESUC_Numero;
                if($valor1==0) $valor1='***';
                $arreglo[$indice1] = $valor1;
            }
        }
        $resultado = $this->html->optionHTML($arreglo,$indSel,array('','::Seleccione::'));
        return $resultado;
    }
}
?>