<?php
class Boleta extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->library('form_validation');
		$this->load->library('pagination');		
		$this->load->library('html');
		$this->load->model('ventas_model');
        $this->load->model('compras/compras_model');
        $this->load->model('mantenimiento_model');
        $this->load->model('comercial/comercial_model');
        $this->load->model('producto/producto_model');
	}
	function index(){
		$this->load->view('seguridad/inicio');
	}
	function boletas($j='0'){
		$data['registros']  = count($this->compras_model->listar());
		$conf['base_url']   = site_url('compras/ocompras/');	
		$conf['per_page']   = 15;
		$conf['num_links']  = 3;
		$conf['first_link'] = "&lt;&lt;";
		$conf['last_link']  = "&gt;&gt;";	
		$conf['total_rows'] = $data['registros'];
		$offset             = (int)$this->uri->segment(3);
		$listado_ocompras     = $this->compras_model->listar($conf['per_page'],$offset);	
		$item               = $j+1;
		$lista              = array();
		if(count($listado_ocompras)>0){
			foreach($listado_ocompras as $indice=>$valor){
                 $arrfecha    = explode(" ",$valor->OCOMC_FechaRegistro);
                 $fecha         = $arrfecha[0];
				$codigo        = $valor->OCOMP_Codigo;
				$cotizacion = $valor->COTIP_Codigo;
				$pedido       = $valor->PEDIP_Codigo;
				$numero     = $valor->OCOMC_Numero;
				$proveedor= $valor->PROVP_Codigo;
				$ccosto         = $valor->CENCOSP_Codigo;
				$total            = $valor->OCOMC_total;
                $flagIngreso  = $valor->OCOMC_FlagIngreso;
                $moneda        = $valor->MONED_Codigo;
                $datos_moneda      = $this->mantenimiento_model->obtener($moneda);
                $datos_proveedor = $this->comercial_model->obtener_datosProveedor($proveedor);
                $datos_cotizacion = $this->compras_model->obtener_cotizacion($cotizacion);
                $datos_pedido       = $this->compras_model->obtener_pedido($pedido);
                $empresa   = $datos_proveedor[0]->EMPRP_Codigo;
                $persona   = $datos_proveedor[0]->PERSP_Codigo;
                $tipo           = $datos_proveedor[0]->PROVC_TipoPersona;
                $nro_pedido       = $datos_pedido[0]->PEDIC_Numero;
                $nro_cotizacion = $datos_cotizacion[0]->COTIC_Numero;
                $simbolo_moneda = $datos_moneda[0]->MONED_Simbolo;
                $monto_total = $simbolo_moneda." ".number_format($total,2);
                if($nro_cotizacion==0) $nro_cotizacion="***";
                if($nro_pedido==0) $nro_pedido="***";
                if($tipo==0){
                     $datos_persona = $this->comercial_model->obtener_datosPersona($persona);
                     $nombre_proveedor = $datos_persona[0]->PERSC_Nombre." ".$datos_persona[0]->PERSC_ApellidoPaterno." ".$datos_persona[0]->PERSC_ApellidoMaterno;
                }
                elseif($tipo==1){
                     $datos_empresa = $this->comercial_model->obtener_datosEmpresa($empresa);
                     $nombre_proveedor = $datos_empresa[0]->EMPRC_RazonSocial;
                }
                if($flagIngreso=="0"){
                     $msguiain = "Pend.";
                }elseif($flagIngreso=="1"){
                     $msguiain = "Si";
                }
				$editar         = "<a href='#' onclick='editar_ocompra(".$codigo.")' target='_parent'><img src='".URL_IMAGE."modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
				$ver               = "<a href='#' onclick='ver_ocompra_pdf(".$codigo.")' target='_parent'><img src='".URL_IMAGE."ver.png' width='16' height='16' border='0' title='Modificar'></a>";
				$eliminar    = "<a href='#' onclick='eliminar_ocompra(".$codigo.")' target='_parent'><img src='".URL_IMAGE."eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
				$lista[]         = array($item++,$fecha,$numero,$nro_cotizacion,$nro_pedido,$nombre_proveedor,$monto_total,$msguiain,$editar,$ver,$eliminar);
			}			
		}
		$data['titulo_tabla']    = "RELACI&Oacute;N de ORDENES DE COMPRA";	
		$data['titulo_busqueda'] = "BUSCAR ORDEN DE COMPRA";
		$data['lista']      = $lista;
		$data['oculto']     = form_hidden(array('base_url'=>base_url()));
		$this->pagination->initialize($conf);			
		$data['paginacion'] = $this->pagination->create_links();
		$this->load->view('ocompra_index',$data);		
	}
	function boleta_nueva(){
		$modo      = "";
		$accion    = "";
		$modo      = "insertar";
		$codigo    = "";	
		$oculto    = form_hidden(array('accion'=>$accion,'codigo'=>$codigo,'modo'=>$modo,'base_url'=>base_url()));
        $data['url_action']  = base_url()."index.php/compras/insertar_boleta";
		$data['titulo']            = "REGISTRAR ORDENES DE COMPRA";
		$data['formulario'] = "frmOrdenCompra";
		$data['oculto']          = $oculto;
		$data['onload']		    = "onload=\"$('#nombre').focus();\"";
        $data['descuento'] = "0";
        $data['igv']                 = "19";
		$data['cboMoneda']      = $this->seleccionar_moneda('1');
        $data['cboCotizacion']  = $this->seleccionar_cotizacion();
        $data['detalle_ocompra']        = array();
        $data['nombre_proveedor']  = "";
        $data['proveedor']                    = "";
        $data['numero']                         = "";
        $data['ruc']                                   = "";
        $data['preciototal']                  = "";
        $data['descuentotal']              = "";
        $data['igvtotal']                         = "";
        $data['importetotal']              = "";
        $data['observacion']               = "";
        $data['focus']                            = "";
         $data['hidden']                        = "";
          $data['pedido']                      = "0";
		$data['hoy']        = mdate("%Y-%m-%d ",time());
        $atributos           = array('width'=>600,'height'=>400,'scrollbars'=>'yes','status'=>'yes','resizable'=>'yes','screenx'=>'0','screeny'=>'0');
        $contenido         = "<img height='16' width='16' src='".URL_IMAGE."ver.png' title='Buscar Proveedor' border='0'>";
        $data['verproveedor']	  = anchor_popup('comercial/ventana_busqueda_proveedor',$contenido,$atributos);
		$this->load->view('ocompra_nueva',$data);
	}
	function boleta_insertar(){
          $this->form_validation->set_rules('nombre_proveedor','Nombre Proveedor','required');
          $this->form_validation->set_rules('nombre_usuario','Nombre Usuario','required');
          $this->form_validation->set_rules('cotizacion','Cotizacion','required');
          $this->form_validation->set_rules('moneda','Moneda','required');
          $this->form_validation->set_rules('descuento','Descuento','required');
          $this->form_validation->set_rules('igv','I.G.V.','required');
         if($this->form_validation->run()==FALSE){
               $this->nueva_ocompra();
         }else{
              $proveedor          = $this->input->post('proveedor');
               $pedido                = $this->input->post('pedido');
              $cotizacion           = $this->input->post('cotizacion');
              $moneda               = $this->input->post('moneda');
              $descuento          = $this->input->post('descuento');
              $igv                          = $this->input->post('igv');
              $preciototal         = $this->input->post('preciototal');
              $descuentotal    =  $this->input->post('descuentotal');
              $igvtotal                = $this->input->post('igvtotal');
              $importetotal     = $this->input->post('importetotal');
              $ccosto                  = $this->input->post('centro_costo');
              $observacion      = $this->input->post('observacion');
              $prodcodigo        =  $this->input->post('prodcodigo');
              $produnidad        =  $this->input->post('produnidad');
              $prodpu                 =  $this->input->post('prodpu');
              $prodcantidad    =  $this->input->post('prodcantidad');
              $prodprecio         =  $this->input->post('prodprecio');
              $proddescuento  =  $this->input->post('proddescuento');
              $prodigv                  =  $this->input->post('prodigv');
              $prodimporte       =  $this->input->post('prodimporte');
              $numero                 = "";//Se genera automatico y en forma correlativa.
              $detobserv            = "oob";
              $ocompra               = $this->compras_model->insertar_boleta($pedido,$cotizacion,$proveedor,$moneda,$descuento,$igv,$ccosto,$observacion,$preciototal,$descuentotal,$igvtotal,$importetotal);
              if(count($prodcodigo)>0){
                   foreach($prodcodigo as $indice=>$valor){
                        $producto = $prodcodigo[$indice];
                        $unidad     = $produnidad[$indice];
                        $pu              = $prodpu[$indice];
                        $cantidad  = $prodcantidad[$indice];
                        $subtotal      = $prodprecio[$indice];
                        $detalle_descuento = $proddescuento[$indice];
                        $detalle_igv             = $prodigv[$indice];
                        $total         = $prodimporte[$indice];
                        $observ      = "Insertar";
                         $this->compras_model->insertar_detalle_ocompra($ocompra,$cotizacion,$pedido,$producto,$pu,$cantidad,$subtotal,$detalle_descuento,$detalle_igv,$total,$unidad,$igv,$descuento,$observ);
                   }
              }
             $this->ocompras();
         }
	}
	function boleta_editar($codigo){
		$accion                  = "";
		$modo                   = "modificar";
		$datos_ocompra   = $this->compras_model->obtener_ocompra($codigo);
        $cotizacion          = $datos_ocompra[0]->COTIP_Codigo;
		$pedido                = $datos_ocompra[0]->PEDIP_Codigo;
        $numero              = $datos_ocompra[0]->OCOMC_Numero;
        $descuento100 = $datos_ocompra[0]->OCOMC_descuento100;
        $igv100                 = $datos_ocompra[0]->OCOMC_igv100;
        $proveedor                       = $datos_ocompra[0]->PROVP_Codigo;
        $centro_costo                  = $datos_ocompra[0]->CENCOSP_Codigo;
        $moneda                            =  $datos_ocompra[0]->MONED_Codigo;
        $subtotal                            = $datos_ocompra[0]->OCOMC_subtotal;
        $descuentototal              = $datos_ocompra[0]->OCOMC_descuento;
        $igvtotal                              = $datos_ocompra[0]->OCOMC_igv;
        $total                                    = $datos_ocompra[0]->OCOMC_total;
        $observacion                    = $datos_ocompra[0]->OCOMC_Observacion;
        $arrfecha                             = explode(" ",$datos_ocompra[0]->OCOMC_FechaRegistro);
        $fecha                                  = $arrfecha[0];
        $flagIngreso                      = $datos_ocompra[0]->OCOMC_FlagIngreso;
        $datos_proveedor          = $this->comercial_model->obtener_datosProveedor($proveedor);
        $empresa                           = $datos_proveedor[0]->EMPRP_Codigo;
        $persona                            = $datos_proveedor[0]->PERSP_Codigo;
        $tipo                                    = $datos_proveedor[0]->PROVC_TipoPersona;
        if($pedido=='1'){
                $opedido = "****";
        }
        else{
                $opedido = $pedido;
         }
        if($tipo==0){
               $datos_persona = $this->comercial_model->obtener_datosPersona($persona);
               $nombre_proveedor = $datos_persona[0]->PERSC_Nombre." ".$datos_persona[0]->PERSC_ApellidoPaterno." ".$datos_persona[0]->PERSC_ApellidoMaterno;
               $ruc  = $datos_persona[0]->PERSC_Ruc;
       }
        elseif($tipo==1){
               $datos_empresa = $this->comercial_model->obtener_datosEmpresa($empresa);
               $nombre_proveedor = $datos_empresa[0]->EMPRC_RazonSocial;
               $ruc  = $datos_empresa[0]->EMPRC_Ruc;
        }
        $data['focus']                   = "javascript:this.blur();return false;";
        $data['cboCotizacion']  = $this->seleccionar_cotizacion($cotizacion);
        $data['cboMoneda']      = $this->seleccionar_moneda($moneda);
        $data['numero']              = $numero;
        $data['ruc']                        = $ruc;
        $data['igv']                        = $igv100;
        $data['descuento']        = $descuento100;
        $data['nombre_proveedor'] = $nombre_proveedor;
        $data['pedido']               = $pedido;
        $data['cotizacion']          = $cotizacion;
		$oculto                              = form_hidden(array('accion'=>$accion,'codigo'=>$codigo,'modo'=>$modo,'base_url'=>base_url()));
		$data['titulo']                 = "EDITAR ORDEN DE COMPRA";
		$data['formulario']      = "frmOrdenCompra";
		$data['oculto']               = $oculto;
		$data['onload']		         = "onload=\"\"";
        $data['url_action']        = base_url()."index.php/compras/modificar_ocompra";
        $atributos                  = array('width'=>600,'height'=>400,'scrollbars'=>'yes','status'=>'yes','resizable'=>'yes','screenx'=>'0','screeny'=>'0');
        $contenido                = "<img height='16' width='16' src='".URL_IMAGE."ver.png' title='Buscar Proveedor' border='0'>";
        $data['verproveedor'] = anchor_popup('comercial/ventana_busqueda_proveedor',$contenido,$atributos);
        $data['hoy']                      = $fecha;
        $data['proveedor']        = $proveedor;
        $data['preciototal']      = $subtotal;
        $data['descuentotal']  = $descuentototal;
        $data['igvtotal']             = $igvtotal;
        $data['importetotal']  = $total;
        $data['observacion']   = $observacion;
         $data['hidden']            = $cotizacion!='0'?"style='display:none;'":"";
        $detalle                             = $this->compras_model->obtener_detalle_ocompra($codigo);
        $detalle_ocompra      = array();
        if(count($detalle)>0){
             foreach($detalle as $indice=>$valor){
                  $detocompra   = $valor->OCOMDEP_Codigo;
                   $producto        = $valor->PROD_Codigo;
                   $cantidad         = $valor->OCOMDEC_Cantidad;
                   $unidad            = $valor->UNDMED_Codigo;
                   $pu                     = $valor->OCOMDEC_Pu;
                   $subtotal         = $valor->OCOMDEC_Subtotal;
                   $igv                    = $valor->OCOMDEC_Igv;
                   $total                = $valor->OCOMDEC_Total;
                   $descuento    = $valor->OCOMDEC_Descuento;
                   $observ            = $valor->OCOMDEC_Observacion;
                   $datos_producto      = $this->producto_model->obtener_producto($producto);
                   $datos_unidad           = $this->unidadmedida_model->obtener($unidad);
                   $nombre_producto = $datos_producto[0]->PROD_Nombre;
                   $codigo_interno       = $datos_producto[0]->PROD_CodigoInterno;
                  $nombre_unidad      = $datos_unidad[0]->UNDMED_Simbolo;
                  $objeto   =   new stdClass();
                  $objeto->OCOMDEP_Codigo         = $detocompra;
                  $objeto->PROD_Codigo                  = $producto;
                  $objeto->PROD_CodigoInterno  = $codigo_interno;
                  $objeto->COTDEC_Cantidad         = $cantidad;
                  $objeto->UNDMED_Codigo           = $unidad;
                  $objeto->PROD_Nombre               = $nombre_producto;
                  $objeto->UNDMED_Simbolo        = $nombre_unidad;
                  $objeto->OCOMDEC_Subtotal     = $subtotal;
                  $objeto->OCOMDEC_Descuento = $descuento;
                  $objeto->OCOMDEC_Igv                 = $igv;
                  $objeto->OCOMDEC_Total             = $total;
                  $objeto->OCOMDEC_Pu                  = $pu;
                  $detalle_ocompra[]                          = $objeto;
           }
        }
         $data['detalle_ocompra']                = $detalle_ocompra;
		$this->load->view('ocompra_nueva',$data);
	}
	function boleta_modificar(){
          $codigo           = $this->input->post('codigo');
          $cotizacion   = $this->input->post('cotizacion');
         $pedido          = $this->input->post('pedido');
         $this->form_validation->set_rules('nombre_proveedor','Nombre Proveedor','required');
         $this->form_validation->set_rules('nombre_usuario','Nombre Usuario','required');
         $this->form_validation->set_rules('cotizacion','Numero de cotizacion','required');
         $this->form_validation->set_rules('moneda','Tipo de moneda','required');
         $this->form_validation->set_rules('igv','I.G.V.','required');
         $this->form_validation->set_rules('descuento','Descuento','required');
         //$this->form_validation->set_rules('prodcodigo','Detalle de Productos','callback_prodproducto_check');
		if($this->form_validation->run() == FALSE){
			$this->editar_ocompra($codigo);
		}
		else{
          $proveedor          = $this->input->post('proveedor');
          $cotizacion            = $this->input->post('cotizacion');
          $pedido                 = $this->input->post('pedido');
          $moneda               = $this->input->post('moneda');
          $descuento100   = $this->input->post('descuento');
          $igv100                  = $this->input->post('igv');
          $observacion      = $this->input->post('observacion');
          $subtotal              =  $this->input->post('preciototal');
          $descuento         = $this->input->post('descuentotal');
          $igv                         = $this->input->post('igvtotal');
          $total                     = $this->input->post('importetotal');
         $prodcodigo         = $this->input->post('prodcodigo');
         $prodpu                 = $this->input->post('prodpu');
          $prodcantidad    = $this->input->post('prodcantidad');
          $prodprecio        =  $this->input->post('prodprecio');
          $proddescuento =  $this->input->post('proddescuento');
          $prodigv                =  $this->input->post('prodigv');
          $prodimporte     =  $this->input->post('prodimporte');
          $produnidad       = $this->input->post('produnidad');
          $detaccion           = $this->input->post('detaccion');
          $detocom             = $this->input->post('detocom');
          $prodigv100         = $this->input->post('prodigv100');
          $proddescuento100 = $this->input->post('proddescuento100');
          $prodobserv      = "modificado";
          $this->compras_model->modificar_ocompra($codigo,$proveedor,$moneda,$descuento100,$igv100,$subtotal,$descuento,$igv,$total,$observacion);
		  if(count($detocom)>0){
               foreach($detocom as $indice=>$valor){
                      $detalle_ocompra   = $detocom[$indice];
                      $detalle_accion        = $detaccion[$indice];
                      $detalle_producto  = $prodcodigo[$indice];
                      $detalle_cantidad   = $prodcantidad[$indice];
                      $detalle_unidad      = $produnidad[$indice];
                      $detalle_descuento100 = $proddescuento100[$indice];
                      $detalle_igv100                =  $prodigv100[$indice];
                      $detalle_pu                    =   $prodpu[$indice];
                      $detalle_cantidad       =   $prodcantidad[$indice];
                      $detalle_precio            =   $prodprecio[$indice];
                      $detalle_descuento   =   $proddescuento[$indice];
                      $detalle_igv                   =   $prodigv[$indice];
                      $detalle_importe        =   $prodimporte[$indice];
                      if($detalle_accion=='n'){
                              $this->compras_model->insertar_detalle_ocompra($codigo,$cotizacion,$pedido,$detalle_producto,$detalle_pu,$detalle_cantidad,$detalle_precio,$detalle_descuento,$detalle_igv,$detalle_importe,$detalle_unidad,$detalle_igv100,$detalle_descuento100,"Insertar");
                      }elseif($detalle_accion=='m') {
                              $this->compras_model->modificar_producto_ocompra($detalle_ocompra,$detalle_igv100,$detalle_descuento100,$detalle_pu,$detalle_cantidad,$detalle_precio,$detalle_descuento,$detalle_igv,$detalle_importe,"Modificado");
                      }elseif($detalle_accion=='e'){
                              $this->compras_model->eliminar_producto_ocompra($detalle_ocompra);
                      }
                 }
          }
		  $this->ocompras();
		}	
	}
	function boleta_eliminar(){
		$codigo = $this->input->post('codigo');
		$this->boleta_model->eliminar($codigo);
		$this->load->view('ocompra_index');
	}
    function boleta_producto_eliminar(){
         $producto = $this->input->post('producto');
         echo $producto;
    }
	function boleta_ver(){
	
	}
    function boleta_ver_pdf($codigo){
            $this->load->library('cezpdf');
            $this->load->helper('pdf_helper');
            prep_pdf();
            $datos_ocompra                  = $this->compras_model->obtener_ocompra($codigo);
            $datos_detalle_ocompra = $this->compras_model->obtener_detalle_ocompra($codigo);
            /*Datos principales*/
          $cotizacion          = $datos_ocompra[0]->COTIP_Codigo;
          $pedido                = $datos_ocompra[0]->PEDIP_Codigo;
          $numero              = $datos_ocompra[0]->OCOMC_Numero;
          $descuento100 = $datos_ocompra[0]->OCOMC_descuento100;
          $igv100                 = $datos_ocompra[0]->OCOMC_igv100;
          $proveedor                       = $datos_ocompra[0]->PROVP_Codigo;
          $centro_costo                  = $datos_ocompra[0]->CENCOSP_Codigo;
          $moneda                            =  $datos_ocompra[0]->MONED_Codigo;
          $subtotal                            = $datos_ocompra[0]->OCOMC_subtotal;
          $descuentototal              = $datos_ocompra[0]->OCOMC_descuento;
          $igvtotal                              = $datos_ocompra[0]->OCOMC_igv;
          $total                                    = $datos_ocompra[0]->OCOMC_total;
          $observacion                    = $datos_ocompra[0]->OCOMC_Observacion;
          $arrfecha                             = explode(" ",$datos_ocompra[0]->OCOMC_FechaRegistro);
          $fecha                                  = $arrfecha[0];
          $flagIngreso                      = $datos_ocompra[0]->OCOMC_FlagIngreso;
          $datos_proveedor          = $this->comercial_model->obtener_datosProveedor($proveedor);
          $empresa                           = $datos_proveedor[0]->EMPRP_Codigo;
          $persona                            = $datos_proveedor[0]->PERSP_Codigo;
          $tipo                                    = $datos_proveedor[0]->PROVC_TipoPersona;
          if($pedido=='1'){$opedido = "****";}
          if($tipo==0){
               $datos_persona = $this->comercial_model->obtener_datosPersona($persona);
               $nombre_proveedor = $datos_persona[0]->PERSC_Nombre." ".$datos_persona[0]->PERSC_ApellidoPaterno." ".$datos_persona[0]->PERSC_ApellidoMaterno;
               $ruc  = $datos_persona[0]->PERSC_Ruc;
          }
          elseif($tipo==1){
               $datos_empresa = $this->comercial_model->obtener_datosEmpresa($empresa);
               $nombre_proveedor = $datos_empresa[0]->EMPRC_RazonSocial;
               $ruc  = $datos_empresa[0]->EMPRC_Ruc;
          }
            $this->cezpdf->ezText('<b>CALLE HUARI No 158 URB. MESA REDONDA - LOS OLIVOS - LIMA -Telefax: 533-7266        ventas@ferresat.com</b>');
            $this->cezpdf->ezText('');
            $this->cezpdf->ezText('<b>ORDEN DE COMPRA No '.$numero.'</b>');
            $this->cezpdf->ezText('<b>SeNor(es):</b>'.$nombre_proveedor);
            $this->cezpdf->ezText('<b>Nro de RUC:</b>'.$ruc);
            $this->cezpdf->ezText('<b>Direccion:</b>'.$nombre_proveedor);
            $this->cezpdf->ezText('<b>Fecha y hora de impresion:</b> '.date('Y-m-d').', '.date('H:i').' hrs.');
            $this->cezpdf->ezText('');
            if(count($datos_detalle_ocompra)>0){
                 foreach($datos_detalle_ocompra as $indice=>$valor){
                    $db_data[] = array('col1' => 'O.D.','col2' => '+9.75','col3' => '-1.25','col4' => '3','col5' => '+2.50','col6' => 'D.I. 4 mm','col7' => 'D.I. 4 mm');
                 }
            }
            $col_names = array(
                'col1' => 'Item',
                'col2' => 'Cantidad.',
                'col3' => 'U.Med.',
                'col4' => 'Codigo',
                'col5' => 'ARTICULO',
                'col6' => 'Precio Unitario',
                'col7'  => 'IMPORTE'
            );
            $this->cezpdf->ezTable($db_data, $col_names, 'ORDEN DE COMPRA ', array('width'=>550));
            $this->cezpdf->ezStream(array('Content-Disposition'=>'nama_file.pdf'));
    }
	function boleta_buscar(){
	
	}
    function boleta_productos_obtener($cotizacion){
         $datos_detalle_cotizacion = $this->compras_model->obtener_detalle_cotizacion($cotizacion);
         $listado = array();
         if(count($datos_detalle_cotizacion)>0){
              foreach($datos_detalle_cotizacion as $indice=>$valor){
                   $pedido                     = $valor->PEDIP_Codigo;
                   $producto                 = $valor->PROD_Codigo;
                   $unidad_medida   = $valor->UNDMED_Codigo;
                   $cantidad                  = $valor->COTDEC_Cantidad;
                    $datos_cotizacion  = $this->compras_model->obtener_cotizacion($cotizacion);
                    $proveedor              = $datos_cotizacion[0]->PROVP_Codigo;
                    $datos_proveedor = $this->comercial_model->obtener_datosProveedor($proveedor);
                    $empresa   = $datos_proveedor[0]->EMPRP_Codigo;
                    $persona   = $datos_proveedor[0]->PERSP_Codigo;
                    $tipo           = $datos_proveedor[0]->PROVC_TipoPersona;
                    if($tipo==0){
                         $datos_persona = $this->comercial_model->obtener_datosPersona($persona);
                         $razon_social = $datos_persona[0]->PERSC_Nombre." ".$datos_persona[0]->PERSC_ApellidoPaterno." ".$datos_persona[0]->PERSC_ApellidoMaterno;
                         $ruc = $datos_persona[0]->PERSC_Ruc;
                    }
                    elseif($tipo==1){
                          $datos_empresa = $this->comercial_model->obtener_datosEmpresa($empresa);
                          $razon_social = $datos_empresa[0]->EMPRC_RazonSocial;
                          $ruc = $datos_empresa[0]->EMPRC_Ruc;
                    }
                   $datos_producto = $this->producto_model->obtener_producto($producto);
                   $datos_umedida = $this->unidadmedida_model->obtener($unidad_medida);
                   $codigo_interno = $datos_producto[0]->PROD_CodigoInterno;
                   $nombre_producto = $datos_producto[0]->PROD_Nombre;
                   $nombre_unidad     = $datos_umedida[0]->UNDMED_Simbolo;
                   $objeto                        = new stdClass();
                   $objeto->PEDIP_Codigo                  = $pedido;
                   $objeto->PROD_Codigo                  = $producto;
                   $objeto->UNDMED_Codigo           = $unidad_medida;
                   $objeto->COTDEC_Cantidad         = $cantidad;
                   $objeto->PROD_CodigoInterno  = $codigo_interno;
                   $objeto->PROD_Nombre               = $nombre_producto;
                   $objeto->UNDMED_Simbolo        = $nombre_unidad;
                   $objeto->Ruc                                      = $ruc;
                   $objeto->RazonSocial                     = $razon_social;
                   $objeto->PROVP_Codigo              = $proveedor;
                   $listado[] = $objeto;
              }
         }
         $resultado = json_encode($listado);
         echo $resultado;
    }
	/*Combos*/
	function seleccionar_moneda($indSel=''){
		$array_rol = $this->compras_model->listar();
		$arreglo = array();
		foreach($array_rol as $indice=>$valor){
			$indice1   = $valor->MONED_Codigo;
			$valor1    = $valor->MONED_Descripcion;
			$arreglo[$indice1] = $valor1;
		}
		$resultado = $this->html->optionHTML($arreglo,$indSel,array('','::Seleccione::'));
		return $resultado;
	}
	function seleccionar_forma_pago($indSel=''){
		$array_rol = $this->compras_model->listar_formas_pago();
		$arreglo = array();
		foreach($array_rol as $indice=>$valor){
			$indice1   = $valor->FORPAP_Codigo;
			$valor1    = $valor->FORPAC_Descripcion;
			$arreglo[$indice1] = $valor1;
		}
		$resultado = $this->html->optionHTML($arreglo,$indSel,array('','::Seleccione::'));
		return $resultado;
	}
	function seleccionar_condicion_entrega($indSel=''){
		$array_rol = $this->condicionentrega_model->listar();
		$arreglo = array();
		foreach($array_rol as $indice=>$valor){
			$indice1   = $valor->CONENP_Codigo;
			$valor1    = $valor->CONENC_Descripcion;
			$arreglo[$indice1] = $valor1;
		}
		$resultado = $this->html->optionHTML($arreglo,$indSel,array('','::Seleccione::'));
		return $resultado;
	}
	function seleccionar_lugar_entrega($indSel=''){
		$array_rol = $this->compras_model->listar();
		$arreglo = array();
		foreach($array_rol as $indice=>$valor){
			$indice1   = $valor->ALMAP_Codigo;
			$valor1    = $valor->ALMAC_Descripcion;
			$arreglo[$indice1] = $valor1;
		}
		$resultado = $this->html->optionHTML($arreglo,$indSel,array('','::Seleccione::'));
		return $resultado;
	}
	function seleccionar_cotizacion($indSel=''){
		$array_cotizacion = $this->compras_model->listar_cotizaciones();
		$arreglo = array();
        if(count($array_cotizacion)>0){
             foreach($array_cotizacion as $indice=>$valor){
                    $proveedor                 = $valor->PROVP_Codigo;
                    $datos_proveedor   = $this->comercial_model->obtener_datosProveedor($proveedor);
                    $empresa    = $datos_proveedor[0]->EMPRP_Codigo;
                    $persona    = $datos_proveedor[0]->PERSP_Codigo;
                    $tipo            = $datos_proveedor[0]->PROVC_TipoPersona;
                    if($tipo==0){
                     $datos_persona = $this->comercial_model->obtener_datosPersona($persona);
                     $nombre_proveedor = $datos_persona[0]->PERSC_Nombre." ".$datos_persona[0]->PERSC_ApellidoPaterno." ".$datos_persona[0]->PERSC_ApellidoMaterno;
                    }
                    elseif($tipo==1){
                     $datos_empresa = $this->comercial_model->obtener_datosEmpresa($empresa);
                     $nombre_proveedor = $datos_empresa[0]->EMPRC_RazonSocial;
                    }
                    $indice1   = $valor->COTIP_Codigo;
                    $valor1    = $valor->COTIC_Numero;
                    if($valor1==0) $valor1='***';
                    $arreglo[$indice1] = $valor1;
             }
        }
		$resultado = $this->html->optionHTML($arreglo,$indSel,array('','::Seleccione::'));
		return $resultado;
	}
    function seleccionar_pedido($indSel=''){
		$array_pedido = $this->compras_model->listar_pedidos();
		$arreglo = array();
		foreach($array_pedido as $indice=>$valor){
            $ccosto    = $valor->CENCOST_Codigo;
            $datos_ccosto      = $this->mantenimiento_model->obtener_centro_costo($ccosto);
            $nombre_ccosto =  $datos_ccosto[0]->CENCOSC_Descripcion;
			$indice1   = $valor->PEDIP_Codigo;
			$valor1    = $valor->PEDIC_Numero;
            if($valor1==0) $valor1='***';
			$arreglo[$indice1] = $valor1." :: ".$nombre_ccosto;
		}
		$resultado = $this->html->optionHTML($arreglo,$indSel,array('0','::Seleccione ::'));
		return $resultado;
    }
}
?>