<?php

class Compania_model extends Model {

	public function __construct() {
		parent::__construct();
		$this->load->model('maestros/empresa_model');
		$this->load->model('maestros/emprestablecimiento_model');
	}

	public function listar_empresas() {
		$sql = "SELECT EMPRP_Codigo
							FROM cji_compania
							WHERE COMPC_FlagEstado LIKE '1'
							GROUP BY EMPRP_Codigo;
						";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
			return $query->result();
		}
		else
			return NULL;
	}

	public function listar_establecimiento($empresa) {
		$query = $this->db->where('cji_compania.EMPRP_Codigo', $empresa)
		->join('cji_emprestablecimiento e', 'e.EESTABP_Codigo=cji_compania.EESTABP_Codigo')
		->where('COMPC_FlagEstado', '1')
		->select('cji_compania.*, e.EESTABC_Descripcion')
		->get('cji_compania');
		if ($query->num_rows()> 0) {
			foreach ($query->result() as $fila) {
				$data[] = $fila;
			}
			return $data;
		}else
		return array();
	}

	public function valorizacion($fh_ini, $fh_fin, $comp_select, $producto_busca) {
		$sql = "SELECT Compania.EESTABC_Descripcion, e.Existencia, cp.CuotaxPagar, cc.CuotaxCobrar,Compania.COMPP_Codigo
		FROM 
		(
		SELECT com.COMPP_Codigo,eest.EESTABC_Descripcion 
		FROM cji_compania com 
		INNER JOIN cji_emprestablecimiento eest 
		ON eest.EESTABP_Codigo=com.EESTABP_Codigo 
		WHERE com.COMPC_FlagEstado=1 AND com.EMPRP_Codigo=1
		) AS Compania

		LEFT JOIN 
		/************ Existencia en Almacen  ***************/
		(
		SELECT SUM(apro.ALMPROD_CostoPromedio * apro.ALMPROD_Stock)
		AS Existencia, apro.COMPP_Codigo,apro.PROD_Codigo
		FROM cji_almacenproducto apro
		INNER JOIN cji_compania com
		ON apro.COMPP_Codigo=com.COMPP_Codigo
		WHERE apro.ALMPROD_Stock >0 
		GROUP BY apro.COMPP_Codigo";
		if ($producto_busca != "") {
			$sql.=" AND apro.PROD_Codigo =$producto_busca";
		} 
		/* GROUP BY ALMAC_Codigo */
		$sql.=") AS e 
		ON Compania.COMPP_Codigo = e.COMPP_Codigo

		LEFT JOIN 
		/************ Cuentas x Cobrar  ***************/
		(
		SELECT SUM( CUE_MONTO ) AS CuotaxCobrar, COMPP_Codigo
		FROM cji_cuentas
		WHERE CUE_TipoCuenta =1 
		AND CUE_FlagEstado=1
		GROUP BY COMPP_Codigo
		) AS cc 
		ON e.COMPP_Codigo = cc.COMPP_Codigo

		LEFT JOIN 
		/************ Cuentas x Pagar  ***************/
		(
		SELECT SUM( CUE_MONTO ) AS CuotaxPagar, COMPP_Codigo
		FROM cji_cuentas
		WHERE CUE_TipoCuenta =2
		AND CUE_FlagEstado=1
		GROUP BY COMPP_Codigo
		) AS cp 
		ON e.COMPP_Codigo = cp.COMPP_Codigo WHERE 1=1";

		if ($producto_busca != '') {
            //$sql.=" AND e.PROD_Codigo=$producto_busca ";
			$sql.=" AND Compania.COMPP_Codigo IN (SELECT COMPP_Codigo FROM cji_almacenproducto WHERE PROD_Codigo=$producto_busca) ";
            //$this->db->where_in('Compania.COMPP_Codigo', "SELECT COMPP_Codigo FROM cji_almacenproducto WHERE PROD_Codigo=$producto_busca");
		}

		if (count($comp_select) > 0) {
			$array_compania = "";
			$i = 0;
			foreach ($comp_select as $key => $value) {
				if ($i > 0) {
					$array_compania.=",";
				}
				$array_compania.=$value[0];
				$i++;
			}
			$sql.=" AND  Compania.COMPP_Codigo IN($array_compania) ";
            //$this->db->where_in('Compania.COMPP_Codigo', $array_compania);
		}

		$sql.=" GROUP BY Compania.COMPP_Codigo";
        //echo $sql;
        //$query = $this->db->get();
		$query = $this->db->query($sql);
		if ($query->num_rows()> 0) {
			foreach ($query->result() as $fila) {
				$data[] = $fila;
			}
			return $data;
		}

		return array();
	}

	public function listar_companias_usuario() {

		$sql = "SELECT * FROM cji_usuario_compania uc JOIN cji_compania c ON uc.COMPP_Codigo = c.COMPP_Codigo WHERE USUA_Codigo = '" . $this->session->userdata('user') . "'";
		$query = $this->db->query($sql);
		if ($query->num_rows()> 1) {
			foreach ($query->result() as $fila) {
				$data[] = $fila;
			}
			return $data;
		}

		return array();
	}

	public function obtener_compania($compania) {
		$where = array('COMPP_Codigo' => $compania);
		$query = $this->db->where($where)->get('cji_compania');
		if ($query->num_rows()> 0) {

			foreach ($query->result() as $fila) {
				$data[] = $fila;
			}
			return $data;
		}
	}

	public function modificar_compania($compania, $logo) {
		$data = array("COMPC_Logo" => $logo);
		$this->db->where("COMPP_Codigo", $compania);
		$this->db->update('cji_compania', $data);
	}

	public function listar($empresa='') {
    		
  		if($empresa!="" || $empresa!=NULL){
  			$this->db->where('EMPRP_Codigo', $empresa);
  		}

  		$query = $this->db->where('COMPC_FlagEstado', '1')->get('cji_compania');
      if ($query->num_rows()> 0) {
          foreach ($query->result() as $fila) {
              $data[] = $fila;
          }
          return $data;
      }
  }

	public function obtener($compania) {
		$where = array('COMPP_Codigo' => $compania);
		$query = $this->db->where($where)->get('cji_compania');
		if ($query->num_rows()> 0) {
			foreach ($query->result() as $fila) {
				$data[] = $fila;
			}
			return $data;
		}
	}

	public function modificar($compania, $logo, $tipo_valorizacion) {
		$data = array("COMPC_Logo" => $logo, "COMPC_TipoValorizacion" => $tipo_valorizacion);
		$this->db->where("COMPP_Codigo", $compania);
		$this->db->update('cji_compania', $data);
	}

	public function eliminar_compania_x_esta($establecimiento){
    	//$this->db->delete('cji_compania',array('EESTABP_Codigo' => $establecimiento));
		$data = array( 'COMPC_FlagEstado' => 0);
		$this->db->where('EESTABP_Codigo', $establecimiento);
		$this->db->update('cji_compania', $data); 
	}
	
	public function obtener_x_establecimiento($establecimiento) {
		$where = array('EESTABP_Codigo' => $establecimiento);
		$query = $this->db->where($where)->get('cji_compania');
		if ($query->num_rows()> 0) {
			foreach ($query->result() as $fila) {
				$data[] = $fila;
			}
			return $data;
		}
	}
	
	public function listar_compania() {
        /* $array_compania = $this->compania_model->listar_companias_usuario();
          $arreglo = array();
          $resultado = '';
          if(count($array_compania)>0){
          foreach($array_compania as $indice=>$valor){
          $compania   = $valor->COMPP_Codigo;
          $empresa          = $valor->EMPRP_Codigo;
          $datos_empresa   = $this->empresa_model->obtener_datosEmpresa($empresa);
          $razon_social         = $datos_empresa[0]->EMPRC_RazonSocial;
          $arreglo[$compania] = $razon_social;
          }
          $resultado = "<select onchange='cambiar_sesion();' name='cboCompania' id='cboCompania' class='comboMedio'>".$this->html->optionHTML($arreglo,$indSel,array('','::Seleccione::'))."</select>";
          }
          return $resultado; */

          $array_empresas = $this->compania_model->listar_empresas();
          $arreglo = array();
          foreach ($array_empresas as $indice => $valor) {
          	$empresa = $valor->EMPRP_Codigo;
          	$datos_empresa = $this->empresa_model->obtener_datosEmpresa($empresa);
          	$razon_social = $datos_empresa[0]->EMPRC_RazonSocial;
          	$arreglo[] = array('tipo' => '1', 'nombre' => $razon_social, 'compania' => '');

          	$array_establecimiento = $this->compania_model->listar_establecimiento($empresa);
          	foreach ($array_establecimiento as $indice => $valor) {
          		$compania = $valor->COMPP_Codigo;
          		$datos_establecimiento = $this->emprestablecimiento_model->obtener($valor->EESTABP_Codigo);
          		$nombre_establecimiento = $datos_establecimiento[0]->EESTABC_Descripcion;
          		$arreglo[] = array('tipo' => '2', 'nombre' => $nombre_establecimiento, 'compania' => $compania);
          	}
          }
          return $arreglo;
        }

        public function agregar_empresa( $filter ){
        	$this->db->insert('cji_empresa', $filter);
        	return $this->db->insert_id();
        }

        public function agregar_establecimiento( $filter ){
        	$this->db->insert('cji_emprestablecimiento', $filter);
        	return $this->db->insert_id();
        }

        public function agregar_compania( $filter ){

        	$this->db->insert('cji_compania', $filter);
        	$compania = $this->db->insert_id();

        # SI ESTA TABLA CONTIENE DATOS DE LA COMPANIA RECIEN CREADA, SE BORRAN PRIMERO
        	$sql = "DELETE FROM cji_companiaconfidocumento WHERE COMPCONFIP_Codigo = $compania";
        	$this->db->query($sql);

        	$sql = "INSERT INTO `cji_companiaconfidocumento` (`COMPCONFIDOCP_Codigo`, `COMPCONFIP_Codigo`, `DOCUP_Codigo`, `COMPCONFIDOCP_Tipo`, `COMPCONFIDOCP_Serie`, `COMPCONFIDOCP_FechaRegistro`, `COMPCONFIDOCP_FechaModificacion`, `COMPCONFIDOCP_FlagEstado`, `COMPCONFIDOCP_Imagen`, `COMPCONFIDOCP_ImagenCompra`, `COMPCONFIDOCP_PosicionGeneralX`, `COMPCONFIDOCP_PosicionGeneralY`) VALUES
        	(NULL, $compania, 1, '2', NULL, NOW(), NULL, '1', 'reporte.jpg', 'pedido.jpg', 0, 0),
        	(NULL, $compania, 2, '2', NULL, NOW(), NULL, '1', NULL, '0', 0, 0),
        	(NULL, $compania, 3, '2', NULL, NOW(), NULL, '1', NULL, '0', 0, 0),
        	(NULL, $compania, 4, '2', NULL, NOW(), NULL, '1', 'guia1.jpg', 'guia1.jpg', 0, 0),
        	(NULL, $compania, 5, '2', NULL, NOW(), NULL, '1', 'guia1.jpg', 'guia1.jpg', 0, 0),
        	(NULL, $compania, 6, '2', NULL, NOW(), NULL, '1', 'guia1.jpg', 'guiacompra.jpg', 0, 0),
        	(NULL, $compania, 7, '2', NULL, NOW(), NULL, '1', NULL, '0', 0, 0),
        	(NULL, $compania, 8, '2', NULL, NOW(), NULL, '1', 'factura.jpg', 'factura1.jpg', 10, 10),
        	(NULL, $compania, 9, '2', NULL, NOW(), NULL, '1', 'boleta.jpg', 'boleta.jpg', 45, 60),
        	(NULL, $compania, 10, '2', NULL, NOW(), NULL, '1', 'guia.jpg', 'guia_remision1.jpg', 0, 0),
        	(NULL, $compania, 11, '2', NULL, NOW(), NULL, '1', 'notacredito.jpg', '0', 0, 0),
        	(NULL, $compania, 12, '2', NULL, NOW(), NULL, '1', 'notadebito.jpg', '0', 0, 0),
        	(NULL, $compania, 13, '2', NULL, NOW(), NULL, '1', NULL, '0', 0, 0),
        	(NULL, $compania, 14, '2', NULL, NOW(), NULL, '1', 'menbrete1.jpg', 'comprobantecompra.jpg', 0, 0),
        	(NULL, $compania, 15, '2', NULL, NOW(), NULL, '1', NULL, '0', 0, 0);
        	";
        	$this->db->query($sql);

        # SI ESTA TABLA CONTIENE DATOS DE LA COMPANIA RECIEN CREADA, SE BORRAN PRIMERO
        	$sql = "DELETE FROM cji_companiaconfiguracion WHERE COMPP_Codigo = $compania";
        	$this->db->query($sql);

        	$filterCompaniaConfig = new stdClass();
        	$filterCompaniaConfig->COMPCONFIP_Codigo = NULL;
        	$filterCompaniaConfig->COMPP_Codigo = $compania;
        	$filterCompaniaConfig->COMPCONFIC_Igv = "18";
        	$filterCompaniaConfig->COMPCONFIC_PrecioContieneIgv = "1";
        	$filterCompaniaConfig->COMPCONFIC_DeterminaPrecio = "1";
        	$filterCompaniaConfig->COMPCONFIC_FechaRegistro = date("Y-m-d h:i:s");
        	$filterCompaniaConfig->COMPCONFIC_FechaModificacion = NULL;
        	$filterCompaniaConfig->COMPCONFIC_FlagEstado = "1";
        	$filterCompaniaConfig->COMPCONFIC_Cliente = "0";
        	$filterCompaniaConfig->COMPCONFIC_Proveedor = "0";
        	$filterCompaniaConfig->COMPCONFIC_Producto = "0";
        	$filterCompaniaConfig->COMPCONFIC_Familia = "0";
        	$filterCompaniaConfig->COMPCONFIC_StockComprobante = "1";
        	$filterCompaniaConfig->COMPCONFIC_StockGuia = "1";
        	$filterCompaniaConfig->COMPCONFIC_InventarioInicial = "1";

        	$this->db->insert('cji_companiaconfiguracion', $filterCompaniaConfig);
        	$this->db->insert_id();

        # SI ESTA TABLA CONTIENE DATOS DE LA COMPANIA RECIEN CREADA, SE BORRAN PRIMERO
        	$sql = "DELETE FROM cji_compadocumenitem WHERE COMPCONFIDOCP_Codigo = $compania";
        	$this->db->query($sql);

        	$sql = "INSERT INTO `cji_compadocumenitem` (`COMPADOCUITEM_Codigo`, `COMPADOCUITEM_Descripcion`, `COMPADOCUITEM_Abreviatura`, `COMPADOCUITEM_Valor`, `COMPADOCUITEM_UsuCrea`,
        	`COMPADOCUITEM_UsuModi`, `COMPADOCUITEM_FechaModi`, `COMPADOCUITEM_FechaIng`, `COMPADOCUITEM_Estado`, `DOCUITEM_Codigo`, `COMPCONFIDOCP_Codigo`,
        	`COMPADOCUITEM_Width`, `COMPADOCUITEM_Height`, `COMPADOCUITEM_Activacion`, `COMPADOCUITEM_PosicionX`, `COMPADOCUITEM_PosicionY`,
        	`COMPADOCUITEM_Variable`, `COMPADOCUITEM_TamanioLetra`, `COMPADOCUITEM_TipoLetra`, `COMPADOCUITEM_Nombre`, `COMPADOCUITEM_Listado`,
        	`COMPADOCUITEM_VGrupo`, `COMPADOCUITEM_Alineamiento`, `COMPADOCUITEM_Convertiraletras`) VALUES
        	(NULL, '', '', '', 'PERSONA PRINCIPAL ', '', NOW(), NOW(), '1', 1, $compania, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Ruc', 0, '', 'L', 0),
        	(NULL, '', '', '', 'PERSONA PRINCIPAL ', '', NOW(), NOW(), '1', 1, $compania, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Direccion', 0, '', 'L', 0),
        	(NULL, '', '', '', 'PERSONA PRINCIPAL ', '', NOW(), NOW(), '1', 1, $compania, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Cantidad', 0, '', 'L', 0),
        	(NULL, '', '', '', 'PERSONA PRINCIPAL ', '', NOW(), NOW(), '1', 1, $compania, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoNombre', 0, '', 'L', 0),
        	(NULL, '', '', '', 'PERSONA PRINCIPAL ', '', NOW(), NOW(), '1', 1, $compania, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoRuc', 0, '', 'L', 0),
        	(NULL, '', '', '', 'PERSONA PRINCIPAL ', '', NOW(), NOW(), '1', 1, $compania, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaEmision', 0, '', 'L', 0),
        	(NULL, '', '', '', 'PERSONA PRINCIPAL ', '', NOW(), NOW(), '1', 1, $compania, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaRecepcion', 0, '', 'L', 0),
        	(NULL, '', '', '', 'PERSONA PRINCIPAL ', '', NOW(), NOW(), '1', 1, $compania, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DescripcionProducto', 0, '', 'L', 0),
        	(NULL, '', '', '', 'PERSONA PRINCIPAL ', '', NOW(), NOW(), '1', 1, $compania, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'PrecioUnitario', 0, '', 'L', 0),
        	(NULL, '', '', '', 'PERSONA PRINCIPAL ', '', NOW(), NOW(), '1', 1, $compania, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'ImporteProducto', 0, '', 'L', 0),
        	(NULL, '', '', '', 'PERSONA PRINCIPAL ', '', NOW(), NOW(), '1', 1, $compania, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'TotalProducto', 0, '', 'L', 0),
        	(NULL, '', '', '', 'PERSONA PRINCIPAL ', '', NOW(), NOW(), '1', 1, $compania, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'NroOrdenVenta', 0, '', 'L', 0),
        	(NULL, '', '', '', 'PERSONA PRINCIPAL ', '', NOW(), NOW(), '1', 1, $compania, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Vendedor', 0, '', 'L', 0),
        	(NULL, '', '', '', 'PERSONA PRINCIPAL ', '', NOW(), NOW(), '1', 1, $compania, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'GuiaRemision', 0, '', 'L', 0),
        	(NULL, '', '', '', 'PERSONA PRINCIPAL ', '', NOW(), NOW(), '1', 1, $compania, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'SubTotal', 0, '', 'L', 0),
        	(NULL, '', '', '', 'PERSONA PRINCIPAL ', '', NOW(), NOW(), '1', 1, $compania, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'IGV', 0, '', 'L', 0),
        	(NULL, '', '', '', 'PERSONA PRINCIPAL ', '', NOW(), NOW(), '1', 1, $compania, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Total', 0, '', 'L', 0),
        	(NULL, '', '', '', 'PERSONA PRINCIPAL ', '', NOW(), NOW(), '1', 1, $compania, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'MontoEnLetras', 0, '', 'L', 1);
        	";
        	$this->db->query($sql);

        # SI ESTA TABLA CONTIENE DATOS DE LA COMPANIA RECIEN CREADA, SE BORRAN PRIMERO
        	$sql = "DELETE FROM cji_configuracion WHERE COMPP_Codigo = $compania";
        	$this->db->query($sql);

        	$sql = "INSERT INTO `cji_configuracion` (`CONFIP_Codigo`, `DOCUP_Codigo`, `CONFIC_Serie`, `CONFIC_Numero`, `CONFIC_FechaRegistro`, `COMPP_Codigo`, `CONFIC_FlagEstado`) VALUES
        	(NULL, 01, '000$compania', '0', NOW(), $compania, '1'),
        	(NULL, 02, 'OC0$compania', '0', NOW(), $compania, '1'),
        	(NULL, 03, '000$compania', '0', NOW(), $compania, '1'),
        	(NULL, 04, '000$compania', '0', NOW(), $compania, '1'),
        	(NULL, 05, '000$compania', '0', NOW(), $compania, '1'),
        	(NULL, 06, '000$compania', '0', NOW(), $compania, '1'),
        	(NULL, 07, '000$compania', '0', NOW(), $compania, '1'),
        	(NULL, 08, 'FPP$compania', '0', NOW(), $compania, '1'),
        	(NULL, 09, 'BPP$compania', '0', NOW(), $compania, '1'),
        	(NULL, 10, 'TPP$compania', '0', NOW(), $compania, '1'),
        	(NULL, 11, 'PP$compania', '0', NOW(), $compania, '1'),
        	(NULL, 12, 'PP$compania', '0', NOW(), $compania, '1'),
        	(NULL, 13, '000$compania', '0', NOW(), $compania, '1'),
        	(NULL, 14, 'CPP$compania', '0', NOW(), $compania, '1'),
        	(NULL, 15, '000$compania', '0', NOW(), $compania, '1'),
        	(NULL, 16, 'LET$compania', '0', NOW(), $compania, '1'),
        	(NULL, 17, '000$compania', '0', NOW(), $compania, '1'),
        	(NULL, 18, 'COT$compania', '0', NOW(), $compania, '1'),
        	(NULL, 20, '000$compania', '0', NOW(), $compania, '1'),
        	(NULL, 21, '000$compania', '0', NOW(), $compania, '1');
        	";
        	$this->db->query($sql);

        	return $compania;
        }

        public function agregar_usuario_compania( $filter ){
        	$sql = "SELECT * FROM cji_usuario_compania WHERE USUA_Codigo = $filter->USUA_Codigo";
        	$query = $this->db->query($sql);

        	if ($query->num_rows() > 0)
        		$filter->USUCOMC_Default = "0";
        	else
        		$filter->USUCOMC_Default = "1";

        	$this->db->insert('cji_usuario_compania', $filter);
        }

      }

      ?>