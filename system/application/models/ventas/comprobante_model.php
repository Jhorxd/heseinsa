<?php

class Comprobante_model extends Model {

    var $somevar;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->load->model('maestros/configuracion_model');
        $this->load->model('tesoreria/cuentas_model');
        $this->load->model('tesoreria/pago_model');
        $this->load->model('tesoreria/cuentaspago_model');
        $this->load->model('maestros/tipocambio_model');
        $this->load->model('almacen/seriemov_model');
        $this->load->model('ventas/comprobantedetalle_model');
        $this->load->model('almacen/guiasa_model');
        $this->load->model('almacen/guiarem_model');
        $this->load->model('almacen/productounidad_model');
        $this->load->model('almacen/lote_model');
        $this->load->model('almacen/almaprolote_model');
        $this->load->model('tesoreria/cuentaspago_model');
        $this->load->model('tesoreria/cuentas_model');
        $this->load->model('tesoreria/pago_model');
        $this->load->model('almacen/cuentaspago_model');
        $this->load->model('almacen/almacenproducto_model');
        $this->load->model('almacen/guiain_model');
        $this->load->model('almacen/kardex_model');
        $this->somevar['compania'] = $this->session->userdata('compania');
        $this->somevar['user'] = $this->session->userdata('user');
        $this->somevar['hoy'] = mdate("%Y-%m-%d %h:%i:%s", time());
    }

    /* ACTUALIZACION 01/09/2021 */
        public function insertar_respuestaSunat($filter = null) {
            $compania = $this->somevar['compania'];
            $user = $this->somevar ['user'];
            if ($filter->respuestas_tipoDocumento==7) {
                $where_del = array("respuestas_GuiaRem"=> $filter->respuestas_GuiaRem, "respuestas_tipoDocumento"=> $filter->respuestas_tipoDocumento, "respuestas_serie" => $filter->respuestas_serie);
            }else{
                $where_del = array("CPP_Codigo"=> $filter->CPP_codigo, "respuestas_tipoDocumento"=> $filter->respuestas_tipoDocumento, "respuestas_serie" => $filter->respuestas_serie ,"respuestas_numero" => $filter->respuestas_numero);
            }
            
            
            $this->db->delete("cji_respuestasunat",$where_del);

            $this->db->insert("cji_respuestasunat", $filter);
        }

        public function actualizar_respuestaSunat($filter = null) {
            $compania = $this->somevar['compania'];
            if ($filter->respuestas_tipoDocumento==7) {
                $where = array("respuestas_GuiaRem"=> $filter->respuestas_GuiaRem, "respuestas_tipoDocumento"=> $filter->respuestas_tipoDocumento, "respuestas_serie" => $filter->respuestas_serie ,"respuestas_numero" => $filter->respuestas_numero);
            }else{
                $where = array("CPP_Codigo"=> $filter->CPP_codigo, "respuestas_tipoDocumento"=> $filter->respuestas_tipoDocumento, "respuestas_serie" => $filter->respuestas_serie ,"respuestas_numero" => $filter->respuestas_numero);

            }
            $this->db->where($where);
            $this->db->update("cji_respuestasunat", $filter);
        }

        public function consultar_respuestaSunat($codigo,$tipo) {
            $compania = $this->somevar['compania'];
            if ($tipo=="T") {
                $sql = "SELECT * FROM cji_respuestasunat WHERE respuestas_GuiaRem = '$codigo' AND respuestas_tipoDocumento = 7 AND respuestas_enlace IS NOT NULL";
                
            }elseif($tipo=="C"){
                $sql = "SELECT * FROM cji_respuestasunat WHERE CPP_codigo = '$codigo' AND respuestas_tipoDocumento IN(1,2) AND respuestas_enlace IS NOT NULL";

            }elseif($tipo=="N") {
                $sql = "SELECT * FROM cji_respuestasunat WHERE CPP_codigo = '$codigo' AND respuestas_tipoDocumento IN(3,4) AND respuestas_enlace IS NOT NULL";
            }

            $query = $this->db->query($sql);

            if ($query->num_rows > 0) {
                foreach ($query->result() as $fila) {
                    $data[] = $fila;
                }
                return $data[0];
            }
            else
                return NULL;
        }

        public function lsResSunat($codigo, $tipoDoc = NULL, $anulacion = null) {
            $compania   = $this->somevar['compania'];
            $where      = "";
            
            if ($tipoDoc != NULL)
                $where = " AND respuestas_tipoDocumento IN($tipoDoc) ";

            if ($tipoDoc == 7){
                $sql = "SELECT * FROM cji_respuestasunat WHERE respuestas_codigo = (SELECT MAX(respuestas_codigo) FROM cji_respuestasunat WHERE respuestas_GuiaRem = '$codigo' AND respuestas_compañia = '$compania' $where)";
            }else{
                $sql = "SELECT * FROM cji_respuestasunat WHERE respuestas_codigo = (SELECT MAX(respuestas_codigo) FROM cji_respuestasunat WHERE CPP_codigo = '$codigo' AND respuestas_compañia = '$compania' $where)";
            }

            $query = $this->db->query($sql);

            if ($query->num_rows > 0) {
                foreach ($query->result() as $fila) {
                    $data[] = $fila;
                }
                return $data[0];
            }
            else
                return NULL;
        }

    /*FIN ACTUALIZADO 01/09/2021*/
    
    public function select_cmbVendedor( $vendedor = "" ){
        $empresa = $_SESSION['empresa'];
        $where = "";

        if ($vendedor != NULL && $vendedor != "")
            $where = " AND p.PERSP_Codigo = $vendedor";
        
        $sql = "SELECT p.PERSP_Codigo, p.PERSC_Nombre, p.PERSC_ApellidoPaterno
                    FROM cji_persona p
                    INNER JOIN cji_directivo d ON d.PERSP_Codigo = p.PERSP_Codigo
                    INNER JOIN cji_cargo c ON c.CARGP_Codigo = d.CARGP_Codigo
                    WHERE c.CARGC_Descripcion LIKE '%VENDEDOR%' AND p.PERSC_FlagEstado = 1 AND d.DIREC_FlagEstado = 1 AND d.EMPRP_Codigo = $empresa $where
                ";

        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }

    }
    public function listar_comprobantes($tipo_oper = 'V', $tipo_docu = 'F', $number_items = '', $offset = '') {
        $compania = $this->somevar['compania'];
        $where = array("COMPP_Codigo" => $compania, "CPC_TipoOperacion" => $tipo_oper,
            "CPC_TipoDocumento" => $tipo_docu);
        $query = $this->db->order_by('CPC_FechaRegistro', 'DESC')->where($where)->get('cji_comprobante', $number_items, $offset);  //order_by('CPC_Serie','desc')->order_by('CPC_Numero','desc')
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function listar_comprobantes_factura($tipo_oper = 'V', $tipo_docu = 'F', $number_items = '', $offset = '') {
        $compania = $this->somevar['compania'];
        $where = array("COMPP_Codigo" => $compania, "CPC_TipoOperacion" => $tipo_oper,
            "CPC_TipoDocumento" => $tipo_docu);
        $query = $this->db->order_by('CPC_Serie', 'desc')->order_by('CPC_Numero', 'desc')->where($where)->get('cji_comprobante', $number_items, $offset);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function busqueda_comprobante($tipo_oper = 'V', $tipo_docu = 'F', $filter = NULL) {

        $compania = $this->somevar['compania'];

        $where = '';
        if (isset($filter->seriei) && $filter->seriei != '') {
            $where .= ' and cp.CPC_Serie="' . $filter->seriei . '"';
        }
        if (isset($filter->numero) && $filter->numero != '') {
            $where .= ' and cp.CPC_Numero=' . $filter->numero;
        }

        if( isset($filter->fecha_ini) && $filter->fecha_ini != "" && isset($filter->fecha_fin) && $filter->fecha_fin != "" ){
            $where .= " AND cp.CPC_Fecha BETWEEN '$filter->fecha_ini 00:00:00' AND '$filter->fecha_fin 23:59:59' ";
        }

        if ($tipo_oper == 'V') {
            if (isset($filter->nombre_cliente) && $filter->nombre_cliente != '') {
                $where .= ' and EMPRC_RazonSocial LIKE "%' . $filter->nombre_cliente.'%"';
                $where .= ' OR PERSC_Nombre LIKE "%' . $filter->nombre_cliente.'%"';
                $where .= ' OR PERSC_ApellidoPaterno LIKE "%' . $filter->nombre_cliente.'%"';
                $where .= ' OR CLIC_CodigoUsuario LIKE "%' . $filter->nombre_cliente . '%"';
            }
            if (isset($filter->ruc_cliente) && $filter->ruc_cliente != '') {
                $where .= ' and EMPRC_Ruc LIKE "%' . $filter->ruc_cliente.'%"';
                $where .= ' OR PERSC_NumeroDocIdentidad LIKE "%' . $filter->ruc_cliente.'%"';
            }
        }
        else {
            if (isset($filter->nombre_proveedor) && $filter->nombre_proveedor != '') {
                $where .= ' and EMPRC_RazonSocial LIKE "%' . $filter->nombre_proveedor.'%"';
                $where .= ' OR PERSC_Nombre LIKE "%' . $filter->nombre_proveedor.'%"';
                $where .= ' OR PERSC_ApellidoPaterno LIKE "%' . $filter->nombre_proveedor.'%"';
            }
            if (isset($filter->ruc_proveedor) && $filter->ruc_proveedor != '') {
                $where .= ' and EMPRC_Ruc LIKE "%' . $filter->ruc_proveedor.'%"';
                $where .= ' OR PERSC_NumeroDocIdentidad LIKE "%' . $filter->ruc_proveedor.'%"';
            }
        }

        $sql = "SELECT cp.CPC_Fecha,
                       cp.CPP_Codigo,
                       cp.CPC_Serie,
                       cp.CPC_Numero,
                       cp.CPP_Codigo_canje,
                       cp.CPC_GuiaRemCodigo,
                       cp.CPC_DocuRefeCodigo,
                       cp.CPC_NombreAuxiliar,
                       cp.CLIP_Codigo,
                       cp.CPC_TipoDocumento,
                       m.MONED_Simbolo,
                       (SELECT COUNT(scpd.CPDEP_Codigo) FROM cji_comprobantedetalle scpd WHERE scpd.CPP_Codigo = cp.CPP_Codigo AND scpd.CPDEC_FlagEstado = 1 AND scpd.LOTP_Codigo = 0) as sin_lote,
                       (SELECT CLIC_CodigoUsuario FROM cji_cliente WHERE cji_cliente.CLIP_Codigo = cp.CLIP_Codigo LIMIT 1) as CLIC_CodigoUsuario,
                       (CASE " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . "  WHEN '1' THEN e.EMPRC_Ruc ELSE pe.PERSC_NumeroDocIdentidad end) numdoc,
                       (CASE " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . "  WHEN '1' THEN e.EMPRC_RazonSocial ELSE CONCAT(pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) end) nombre,
                       m.MONED_Simbolo,
                       cp.CPC_total,
                       cp.CPC_FlagEstado,
                       cp.OCOMP_Codigo,
                       CONCAT_WS('-',oc.OCOMC_Serie,oc.OCOMC_Numero) as seriOC
                FROM cji_comprobante cp
                LEFT JOIN cji_moneda m ON m.MONED_Codigo=cp.MONED_Codigo
                LEFT JOIN cji_comprobantedetalle cpd ON cpd.CPP_Codigo=cp.CPP_Codigo
                LEFT JOIN cji_ordencompra oc ON oc.OCOMP_Codigo=cp.OCOMP_Codigo
                " . ($tipo_oper != 'C' ? "INNER JOIN cji_cliente c ON c.CLIP_Codigo=cp.CLIP_Codigo" : "LEFT JOIN cji_proveedor c ON c.PROVP_Codigo=cp.PROVP_Codigo") . "
                LEFT JOIN cji_persona pe ON pe.PERSP_Codigo=c.PERSP_Codigo AND " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . " ='0'
                LEFT JOIN cji_empresa e ON e.EMPRP_Codigo=c.EMPRP_Codigo AND " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . "='1'

                    WHERE cp.CPC_TipoOperacion='" . $tipo_oper . "'
                     AND cp.COMPP_Codigo =" . $compania . " " . $where . " AND cp.CPC_TipoDocumento='" . $tipo_docu . "'

                GROUP BY cp.CPP_Codigo
                ORDER BY cp.CPC_Fecha DESC, cp.CPC_Numero DESC ";

        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            return $query->result();
        }
        return array();
    }

    public function getSeriesEmitidas($oper, $doc, $compania){
    	$sql = "SELECT CPC_Serie,
    							(SELECT con.CONFIC_Serie
    								FROM cji_configuracion con
    								WHERE con.COMPP_Codigo = $compania
    									AND con.DOCUP_Codigo IN(SELECT DOCUP_Codigo FROM cji_documento d WHERE d.DOCUC_ABREVI LIKE '$doc')
    									LIMIT 1
    							) serie_actual
    						FROM cji_comprobante
    						WHERE CPC_TipoOperacion LIKE '$oper'
    							AND CPC_TipoDocumento	LIKE '$doc'
    							AND COMPP_Codigo = $compania
    					GROUP BY CPC_Serie
    				";
    	$query = $this->db->query($sql);

    	if ($query->num_rows > 0)
    		return $query->result();
    	else
    		return NULL;
    }

    public function getComprobantes($filter = NULL){

        $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
        $order = $order = "ORDER BY cp.CPP_Codigo DESC";#( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

        $tipo_docu = $filter->tipo_docu;
        $tipo_oper = $filter->tipo_oper;

        $compania = $this->somevar['compania'];

        $where = '';
        if (isset($filter->seriei) && $filter->seriei != '') {
            $where .= ' and cp.CPC_Serie="' . $filter->seriei . '"';
        }
        if (isset($filter->numero) && $filter->numero != '') {
            $where .= ' and cp.CPC_Numero=' . $filter->numero;
        }

        if( isset($filter->fecha_ini) && $filter->fecha_ini != "" && isset($filter->fecha_fin) && $filter->fecha_fin != "" ){
            $where .= " AND cp.CPC_Fecha BETWEEN '$filter->fecha_ini 00:00:00' AND '$filter->fecha_fin 23:59:59' ";
        }

        if ($tipo_oper == 'V') {
            if (isset($filter->nombre_cliente) && $filter->nombre_cliente != '') {
                $where .= ' AND (EMPRC_RazonSocial LIKE "%' . $filter->nombre_cliente.'%"';
                $where .= ' OR PERSC_Nombre LIKE "%' . $filter->nombre_cliente.'%"';
                $where .= ' OR PERSC_ApellidoPaterno LIKE "%' . $filter->nombre_cliente.'%"';
                $where .= ' OR CLIC_CodigoUsuario LIKE "%' . $filter->nombre_cliente . '%" )';
            }
            if (isset($filter->ruc_cliente) && $filter->ruc_cliente != '') {
                $where .= ' and (EMPRC_Ruc LIKE "%' . $filter->ruc_cliente.'%"';
                $where .= ' OR PERSC_NumeroDocIdentidad LIKE "%' . $filter->ruc_cliente.'%")';
            }
        }
        else {
            $where .= " AND CPC_Serie NOT LIKE 'A%'";
            if (isset($filter->nombre_proveedor) && $filter->nombre_proveedor != '') {
                $where .= ' and (EMPRC_RazonSocial LIKE "%' . $filter->nombre_proveedor.'%"';
                $where .= ' OR PERSC_Nombre LIKE "%' . $filter->nombre_proveedor.'%"';
                $where .= ' OR PERSC_ApellidoPaterno LIKE "%' . $filter->nombre_proveedor.'%")';
            }
            if (isset($filter->ruc_proveedor) && $filter->ruc_proveedor != '') {
                $where .= ' and (EMPRC_Ruc LIKE "%' . $filter->ruc_proveedor.'%"';
                $where .= ' OR PERSC_NumeroDocIdentidad LIKE "%' . $filter->ruc_proveedor.'%")';
            }
        }
        
        if ( isset($filter->count) && $filter->count == true ){
        	$cols = "COUNT(DISTINCT cp.CPP_Codigo) as registros";
        	$group_by = "";
        	$limit = "";
        }
        else{
        	$cols = "cp.CPC_FechaRegistro, DATE(cp.CPC_FechaRegistro) CPC_FechaR, cp.CPC_Fecha, cp.CPP_Codigo, cp.CPC_Serie, cp.CPC_Numero, cp.CPP_Codigo_canje, cp.CPC_GuiaRemCodigo, cp.CPC_DocuRefeCodigo, cp.CPC_NombreAuxiliar, cp.CLIP_Codigo, cp.CPC_TipoDocumento, cp.CPC_total, cp.CPC_FlagEstado, cp.OCOMP_Codigo,
                       m.MONED_Simbolo,
                       
                       (SELECT CLIC_CodigoUsuario FROM cji_cliente WHERE cji_cliente.CLIP_Codigo = cp.CLIP_Codigo LIMIT 1) as CLIC_CodigoUsuario,
                       (CASE " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . "  WHEN '1' THEN e.EMPRC_Ruc ELSE pe.PERSC_NumeroDocIdentidad end) numdoc,
                       (CASE " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . "  WHEN '1' THEN e.EMPRC_RazonSocial ELSE CONCAT(pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) end) nombre,
                       m.MONED_Simbolo,
                       CASE
                       	WHEN cp.OCOMP_Codigo IS NOT NULL THEN cp.OCOMP_Codigo
                       	ELSE (SELECT g.OCOMP_Codigo
                       					FROM cji_comprobante_guiarem cg INNER JOIN cji_guiarem g ON g.GUIAREMP_Codigo = cg.GUIAREMP_Codigo
                       					WHERE cg.CPP_Codigo = cp.CPP_Codigo
                       						AND g.OCOMP_Codigo IS NOT NULL
                       						LIMIT 1
                       				)
                       END as idOC,
                       CASE
                       	WHEN cp.OCOMP_Codigo IS NOT NULL THEN (SELECT CONCAT_WS('-',oc.OCOMC_Serie,oc.OCOMC_Numero) FROM cji_ordencompra oc WHERE oc.OCOMP_Codigo = cp.OCOMP_Codigo)
                       	ELSE (SELECT (SELECT CONCAT_WS('-',ocg.OCOMC_Serie,ocg.OCOMC_Numero) FROM cji_ordencompra ocg WHERE ocg.OCOMP_Codigo = g.OCOMP_Codigo)
                       					FROM cji_comprobante_guiarem cg INNER JOIN cji_guiarem g ON g.GUIAREMP_Codigo = cg.GUIAREMP_Codigo
                       					WHERE cg.CPP_Codigo = cp.CPP_Codigo
                       						AND g.OCOMP_Codigo IS NOT NULL
                       						LIMIT 1
                       				)
                       END as seriOC
                ";
        	
        	$group_by = "GROUP BY cp.CPP_Codigo";
        }

        $sql = "SELECT $cols
                    FROM cji_comprobante cp
                    LEFT JOIN cji_moneda m ON m.MONED_Codigo=cp.MONED_Codigo
                    " . ($tipo_oper != 'C' ? "INNER JOIN cji_cliente c ON c.CLIP_Codigo=cp.CLIP_Codigo" : "LEFT JOIN cji_proveedor c ON c.PROVP_Codigo=cp.PROVP_Codigo") . "
                    LEFT JOIN cji_persona pe ON pe.PERSP_Codigo=c.PERSP_Codigo AND " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . " ='0'
                    LEFT JOIN cji_empresa e ON e.EMPRP_Codigo=c.EMPRP_Codigo AND " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . "='1'

                        WHERE cp.CPC_TipoOperacion='" . $tipo_oper . "'
                         AND cp.COMPP_Codigo =" . $compania . " " . $where . " AND cp.CPC_TipoDocumento='" . $tipo_docu . "'
                    $group_by
                    $order
                    $limit
                ";
        #                    --LEFT JOIN cji_comprobantedetalle cpd ON cpd.CPP_Codigo=cp.CPP_Codigo

        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
        	if ( isset($filter->count) && $filter->count == true )
          	return $query->row();
          else
          	return $query->result();
        }
        else
        	return NULL;
    }

  public function buscar_comprobante_venta_3($anio ,$mes ,$fech1 ,$fech2 ,$tipodocumento) {
        //CPC_TipoOperacion => V venta, C compra
        //CPC_TipoDocumento => F factura, B boleta
        //CPC_total => total de la FACTURA o BOLETA CPC_FechaRegistro  BETWEEN '20121201' AND '20121202'

        $where="";
        //----------
        if($anio!="--" && $mes =="--"){// SOLO AÑO
        $where="AND YEAR(CPC_FechaRegistro)='" . $anio . "'";
        }
        if($anio!="--" && $mes !="--" ){// MES Y  AÑO
            $where="AND YEAR(CPC_FechaRegistro)='" . $anio . "' AND MONTH(CPC_FechaRegistro)='" . $mes ."'";
        }
         if($anio=="--" && $mes !="--"){//MES CON AÑO ACTUAL
            $where="AND YEAR(CPC_FechaRegistro)=' ".date("Y")."' AND MONTH(CPC_FechaRegistro)='" . $mes ."'";
        }

        //-----------------
       
        if($anio=="--" && $mes =="--" && $fech1!="--" && $fech2=="--"){//FECHA INICIAL
                $where="AND CPC_FechaRegistro > '" . $fech1 . "'";
            }
        if($anio=="--" && $mes =="--" && $fech1!="--" && $fech2!="--" ){//FECHA INICIAL Y FECHA FINAL
                $where="AND CPC_FechaRegistro >= '" . $fech1 . "' AND CPC_FechaRegistro <= '" . $fech2 . "'";
            }
        
      
            //------------

        
            $wheretdoc= "";
            if($tipodocumento !="--")
                $wheretdoc= " AND CPC_TipoDocumento='".$tipodocumento."' ";

           

        $sql = " SELECT com.*,CONCAT(pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) as nombre , MONED_Simbolo from cji_comprobante com
        inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
        inner join cji_persona pe on pe.PERSP_Codigo = cl.PERSP_Codigo
        inner JOIN cji_moneda m ON m.MONED_Codigo=com.MONED_Codigo 
        WHERE CPC_TipoOperacion='V' ".$wheretdoc.$where."
        
        UNION 
        SELECT com.* ,EMPRC_RazonSocial as nombre ,MONED_Simbolo from cji_comprobante com
        inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
        inner join cji_empresa es on es.EMPRP_Codigo = cl.EMPRP_Codigo
        inner JOIN cji_moneda m ON m.MONED_Codigo = com.MONED_Codigo 
        WHERE CPC_TipoOperacion='V' ".$wheretdoc.$where."";

        //echo $sql;
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        return array();
    }
    public function buscardep($dato) {
       
        $sql = " SELECT * FROM cji_ubigeo  WHERE UBIGP_Codigo=" . $dato . "";

        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        return array();
    }
    public function contar_comprobantes($tipo_oper = 'V', $tipo_docu = 'F', $number_items = '', $offset = '', $fecha_registro = '') {
        $compania = $this->somevar['compania'];

        $limit = "";

        if ((string) $offset != '' && $number_items != '') {
            $limit = 'LIMIT ' . $offset . ',' . $number_items;
        }

        /*$sql = "SELECT COUNT(cp.CPP_Codigo) as total
                FROM cji_comprobante cp
                LEFT JOIN cji_moneda m ON m.MONED_Codigo=cp.MONED_Codigo
                LEFT JOIN cji_comprobantedetalle cpd ON cpd.CPP_Codigo=cp.CPP_Codigo
                " . ($tipo_oper != 'C' ? "INNER JOIN cji_cliente c ON c.CLIP_Codigo=cp.CLIP_Codigo" : "LEFT JOIN cji_proveedor c ON c.PROVP_Codigo=cp.PROVP_Codigo") . "
                LEFT JOIN cji_persona pe ON pe.PERSP_Codigo=c.PERSP_Codigo AND " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . " = '0'
                LEFT JOIN cji_empresa e ON e.EMPRP_Codigo=c.EMPRP_Codigo AND " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . " = '1'

                    WHERE cp.CPC_TipoOperacion='" . $tipo_oper . "'
                      AND cp.CPC_TipoDocumento='" . $tipo_docu . "' AND cp.COMPP_Codigo =" . $compania . "
                " . $limit;*/

        $sql = "SELECT COUNT(cp.CPP_Codigo) as total
                    FROM cji_comprobante cp
                        WHERE cp.CPC_TipoDocumento = '$tipo_docu' AND cp.CPC_TipoOperacion = '$tipo_oper' AND cp.COMPP_Codigo = '$compania' $limit";

        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            return $query->row()->total;
        }
        return array();
    }

    public function buscar_comprobantes($tipo_oper = 'V', $tipo_docu = 'F', $number_items = '', $offset = '', $fecha_registro = '') {
        $compania = $this->somevar['compania'];

        $limit = "";

        if ((string) $offset != '' && $number_items != '') {
            $limit = 'LIMIT ' . $offset . ',' . $number_items;
        }

        $sql = "SELECT cp.CPC_Fecha,
                       cp.CPP_Codigo,
                       cp.CPC_Serie,
                       cp.CPC_Numero,
                       cp.CPP_Codigo_canje,
                       cp.CPC_GuiaRemCodigo,
                       cp.CPC_DocuRefeCodigo,
                       cp.CPP_Compracliente,
                       cp.CPC_NombreAuxiliar,
                       cp.CLIP_Codigo,
                       cp.CPC_TipoDocumento,
                       cp.CPC_Observacion,
                       (SELECT COUNT(scpd.CPDEP_Codigo) FROM cji_comprobantedetalle scpd WHERE scpd.CPP_Codigo = cp.CPP_Codigo AND scpd.CPDEC_FlagEstado = 1 AND scpd.LOTP_Codigo = 0) as sin_lote,
                       (SELECT CLIC_CodigoUsuario FROM cji_cliente WHERE cji_cliente.CLIP_Codigo = cp.CLIP_Codigo LIMIT 1) as CLIC_CodigoUsuario,
                       (CASE " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . "  WHEN '1' THEN e.EMPRC_Ruc ELSE pe.PERSC_NumeroDocIdentidad end) numdoc,
                       (CASE " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . "  WHEN '1' THEN e.EMPRC_RazonSocial ELSE CONCAT(pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) end) nombre,
                       m.MONED_Simbolo,
                       cp.CPC_total,
                       cp.CPC_FlagEstado,
                       cp.OCOMP_Codigo,
                       CONCAT_WS('-',oc.OCOMC_Serie,oc.OCOMC_Numero) as seriOC
                FROM cji_comprobante cp
                LEFT JOIN cji_moneda m ON m.MONED_Codigo=cp.MONED_Codigo
                LEFT JOIN cji_comprobantedetalle cpd ON cpd.CPP_Codigo=cp.CPP_Codigo
                LEFT JOIN cji_ordencompra oc ON oc.OCOMP_Codigo=cp.OCOMP_Codigo
                " . ($tipo_oper != 'C' ? "INNER JOIN cji_cliente c ON c.CLIP_Codigo=cp.CLIP_Codigo" : "LEFT JOIN cji_proveedor c ON c.PROVP_Codigo=cp.PROVP_Codigo") . "
                LEFT JOIN cji_persona pe ON pe.PERSP_Codigo=c.PERSP_Codigo AND " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . " ='0'
                LEFT JOIN cji_empresa e ON e.EMPRP_Codigo=c.EMPRP_Codigo AND " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . "='1'
              
                    WHERE cp.CPC_TipoOperacion='" . $tipo_oper . "' 
                      AND cp.CPC_TipoDocumento='" . $tipo_docu . "' AND cp.COMPP_Codigo =" . $compania . "
                     
                GROUP BY cp.CPP_Codigo
                ORDER BY cp.CPC_Fecha DESC, cp.CPC_Numero DESC " . $limit;

        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            return $query->result();
        }
        return array();
    }

    public function buscar_comprobantes_asoc($tipo_oper, $tipo_docu = 'F', $filter = NULL, $number_items = '', $offset = '', $fecha_registro = '') {
        $compania = $this->somevar['compania'];

        $where = '';
        if (isset($filter->fechai) && $filter->fechai != '' && isset($filter->fechaf) && $filter->fechaf != '')
            $where .= ' and cp.CPC_Fecha BETWEEN "' . human_to_mysql($filter->fechai) . '" AND "' . human_to_mysql($filter->fechaf) . '"';
        if (isset($filter->seriei) && $filter->seriei != '')
            $where.=' and cp.CPC_Serie="' . $filter->seriei . '"';
        if (isset($filter->numero) && $filter->numero != '')
            $where.=' and cp.CPC_Numero=' . $filter->numero;


        if ($tipo_oper != 'C') {
            if (isset($filter->cliente) && $filter->cliente != '')
                $where.=' and cp.CLIP_Codigo=' . $filter->cliente;
        } else {
            if (isset($filter->proveedor) && $filter->proveedor != '')
                $where.=' and cp.PROVP_Codigo=' . $filter->proveedor;
        }
        
        if (isset($filter->producto) && $filter->producto != '')
            $where.=' and cpd.PROD_Codigo=' . $filter->producto;
        $limit = "";
        if ((string) $offset != '' && $number_items != '')
            $limit = 'LIMIT ' . $offset . ',' . $number_items;

        $sql = "SELECT cp.CPC_Fecha,
                       cp.CPP_Codigo,
                       cp.CPC_Serie,
                       cp.CPC_Numero,
                       cp.CPP_Codigo_canje,
                       cp.CPC_GuiaRemCodigo,
                       cp.CPC_DocuRefeCodigo,
                       cp.CPC_NombreAuxiliar,
                       cp.CLIP_Codigo,
                       (CASE " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . "  WHEN '1' THEN e.EMPRC_Ruc ELSE pe.PERSC_NumeroDocIdentidad end) numdoc,
                       (CASE " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . "  WHEN '1' THEN e.EMPRC_RazonSocial ELSE CONCAT(pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) end) nombre,
                       m.MONED_Simbolo,
                       cp.CPC_total,
                       cp.CPC_FlagEstado
                FROM  cji_comprobante cp
                LEFT JOIN cji_moneda m ON m.MONED_Codigo=cp.MONED_Codigo
                LEFT JOIN cji_comprobantedetalle cpd ON cpd.CPP_Codigo=cp.CPP_Codigo
                 " . ($tipo_oper != 'C' ? "INNER JOIN cji_cliente c ON c.CLIP_Codigo=cp.CLIP_Codigo" : "LEFT JOIN cji_proveedor c ON c.PROVP_Codigo=cp.PROVP_Codigo") . "
                LEFT JOIN cji_persona pe ON pe.PERSP_Codigo=c.PERSP_Codigo AND " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . " ='0'
                LEFT JOIN cji_empresa e ON e.EMPRP_Codigo=c.EMPRP_Codigo AND " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . "='1'
                
                WHERE cp.CPC_TipoOperacion='" . $tipo_oper . "' 
                      AND cp.CPC_TipoDocumento='" . $tipo_docu . "' AND cp.COMPP_Codigo =" . $compania . " " . $where . "
                      AND cp.CPC_DocuRefeCodigo = ''
                      AND cp.CPC_FlagEstado = '1'
                GROUP BY cp.CPP_Codigo
                ORDER BY cp.CPC_Fecha DESC, cp.CPC_Numero DESC  " . $limit; 
        //echo $sql."<br/>";
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        return array();
    }

    public function getComprobantesAsoc($filter = NULL) {

        $compania = $this->somevar['compania'];
        $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
        $order = "ORDER BY cp.CPP_Codigo";#( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

        $tipo_docu = $filter->tipo_docu;
        $tipo_oper = $filter->tipo_oper;

        $where = '';

        if ($tipo_oper != 'C') {
            if (isset($filter->cliente) && $filter->cliente != '')
                $where .= ' AND cp.CLIP_Codigo=' . $filter->cliente;
        }
        else {
            if (isset($filter->proveedor) && $filter->proveedor != '')
                $where .= ' AND cp.PROVP_Codigo=' . $filter->proveedor;
        }

        if (isset($filter->fecha) && $filter->fecha != '')
            $where .= " AND cp.CPC_Fecha BETWEEN '$filter->fecha' AND '$filter->fecha' ";

        if (isset($filter->serie) && $filter->serie != '')
            $where .= " AND cp.CPC_Serie LIKE '%$filter->serie%' ";

        if (isset($filter->numero) && $filter->numero != '')
            $where .= " AND cp.CPC_Numero = '$filter->numero' ";
        
        $sql = "SELECT cp.CPC_Fecha, cp.CPP_Codigo, cp.CPC_Serie, cp.CPC_Numero, cp.CPP_Codigo_canje, cp.CPC_GuiaRemCodigo, cp.CPC_DocuRefeCodigo, cp.CPC_NombreAuxiliar, cp.CLIP_Codigo, cp.CPC_TipoDocumento,
                       (CASE " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . "  WHEN '1' THEN e.EMPRC_Ruc ELSE pe.PERSC_NumeroDocIdentidad end) numdoc,
                       (CASE " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . "  WHEN '1' THEN e.EMPRC_RazonSocial ELSE CONCAT(pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) end) nombre, m.MONED_Simbolo, cp.CPC_total, cp.CPC_FlagEstado
                FROM  cji_comprobante cp
                LEFT JOIN cji_moneda m ON m.MONED_Codigo=cp.MONED_Codigo
                LEFT JOIN cji_comprobantedetalle cpd ON cpd.CPP_Codigo=cp.CPP_Codigo
                " . ($tipo_oper != 'C' ? "INNER JOIN cji_cliente c ON c.CLIP_Codigo=cp.CLIP_Codigo" : "LEFT JOIN cji_proveedor c ON c.PROVP_Codigo=cp.PROVP_Codigo") . "
                LEFT JOIN cji_persona pe ON pe.PERSP_Codigo=c.PERSP_Codigo AND " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . " ='0'
                LEFT JOIN cji_empresa e ON e.EMPRP_Codigo=c.EMPRP_Codigo AND " . ($tipo_oper != 'C' ? "c.CLIC_TipoPersona" : "c.PROVC_TipoPersona") . "='1'

                WHERE cp.CPC_TipoOperacion='" . $tipo_oper . "' AND cp.CPC_TipoDocumento='" . $tipo_docu . "' AND cp.COMPP_Codigo =" . $compania . " " . $where . " AND cp.CPC_FlagEstado = 1

                    GROUP BY cp.CPP_Codigo
                    $order
                    $limit
                ";

        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        return array();
    }

    public function comprobante_pago_pendiente($comprobante) {
        $query = $this->db->where('CUE_CodDocumento', $comprobante)->get('cji_cuentas');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function getComprobanteMail($comprobante){

        $sql = "SELECT cp.*, m.MONED_Simbolo,
                    (SELECT e.EMPRP_Codigo 
                            FROM cji_cliente c
                            LEFT JOIN cji_persona p ON p.PERSP_Codigo = c.PERSP_Codigo
                            LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = c.EMPRP_Codigo
                            WHERE c.CLIP_Codigo = cp.CLIP_Codigo
                    ) as empresa,

                    (SELECT e.EMPRC_Email 
                            FROM cji_cliente c
                            LEFT JOIN cji_persona p ON p.PERSP_Codigo = c.PERSP_Codigo
                            LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = c.EMPRP_Codigo
                            WHERE c.CLIP_Codigo = cp.CLIP_Codigo
                    ) as email,

                    (SELECT CONCAT_WS(' ', p.PERSC_Nombre, p.PERSC_ApellidoPaterno, e.EMPRC_RazonSocial)
                            FROM cji_cliente c
                            LEFT JOIN cji_persona p ON p.PERSP_Codigo = c.PERSP_Codigo
                            LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = c.EMPRP_Codigo
                            WHERE c.CLIP_Codigo = cp.CLIP_Codigo
                    ) as razon_social,

                    (SELECT CONCAT_WS(' ', p.PERSC_NumeroDocIdentidad, e.EMPRC_Ruc)
                            FROM cji_cliente c
                            LEFT JOIN cji_persona p ON p.PERSP_Codigo = c.PERSP_Codigo
                            LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = c.EMPRP_Codigo
                            WHERE c.CLIP_Codigo = cp.CLIP_Codigo
                    ) as ruc
                    
                    FROM cji_comprobante cp
                    LEFT JOIN cji_moneda m ON m.MONED_Codigo = cp.MONED_Codigo
                    WHERE cp.CPP_Codigo = $comprobante
                ";

        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        return array();
    }

    public function obtener_comprobante($comprobante) {
        #$query = $this->db->where('CPP_Codigo', $comprobante)->get('cji_comprobante');
        
        $sql = "SELECT c.*, oc.OCOMC_PersonaAutorizada as ordenCompra,
        					CASE
                   	WHEN c.OCOMP_Codigo IS NOT NULL THEN oc.OCOMC_Serie
                   	ELSE (SELECT (SELECT ocg.OCOMC_Serie FROM cji_ordencompra ocg WHERE ocg.OCOMP_Codigo = g.OCOMP_Codigo)
                   					FROM cji_comprobante_guiarem cg INNER JOIN cji_guiarem g ON g.GUIAREMP_Codigo = cg.GUIAREMP_Codigo
                   					WHERE cg.CPP_Codigo = c.CPP_Codigo
                   						AND g.OCOMP_Codigo IS NOT NULL
                   						LIMIT 1
                   				)
                   END as OCOMC_Serie,
                   CASE
                   	WHEN c.OCOMP_Codigo IS NOT NULL THEN oc.OCOMC_Numero
                   	ELSE (SELECT (SELECT ocg.OCOMC_Numero FROM cji_ordencompra ocg WHERE ocg.OCOMP_Codigo = g.OCOMP_Codigo)
                   					FROM cji_comprobante_guiarem cg INNER JOIN cji_guiarem g ON g.GUIAREMP_Codigo = cg.GUIAREMP_Codigo
                   					WHERE cg.CPP_Codigo = c.CPP_Codigo
                   						AND g.OCOMP_Codigo IS NOT NULL
                   						LIMIT 1
                   				)
                   END as OCOMC_Numero,
                (SELECT CONCAT_WS(' ', pp.PERSC_Nombre, pp.PERSC_ApellidoPaterno, pp.PERSC_ApellidoMaterno) FROM cji_persona pp WHERE pp.PERSP_Codigo = c.CPC_Vendedor LIMIT 1) as vendedor
                    FROM cji_comprobante c
                    LEFT JOIN cji_ordencompra oc ON oc.OCOMP_Codigo = c.OCOMP_Codigo
                    WHERE c.CPP_Codigo = $comprobante
                ";

        $query = $this->db->query($sql);
        
        $data = array();
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
        }
        return $data;
    }

    public function obtener_comprobante_rango($inicio = 1, $fin = 20, $oper = "V", $docu = "F"){
        $compania = $this->somevar['compania'];
        $sql = "SELECT c.CPP_Codigo
                    FROM cji_comprobante c
                    WHERE c.CPC_Numero >= $inicio AND c.CPC_Numero <= $fin AND c.COMPP_Codigo = $compania AND c.CPC_TipoOperacion = '$oper' AND c.CPC_TipoDocumento = '$docu'
                ";
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
        }
        return $data;
    }

    public function obtenerComprobantesConLetras($cliente, $tipo = 'C') {
        $compania = $this->somevar['compania'];

        if ($tipo == 'C')
            $where = "AND cp.PROVP_Codigo = '$cliente'";
        else
            $where = "AND cp.CLIP_Codigo = '$cliente'";


        $sql = "SELECT DISTINCT cp.CPP_Codigo, cp.CPC_total
                    FROM cji_comprobante as cp
                    INNER JOIN comprobantes_cuotas as cpc ON cp.CPP_Codigo = cpc.CPP_Codigo
                    WHERE cp.COMPP_Codigo = $compania AND cp.CPC_TipoOperacion = '$tipo' $where;
                ";

        $query = $this->db->query($sql);

        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        else
            return NULL;
    }

    

    public function motivoAnulacion($comprobante, $motivo) {
        $sql = "UPDATE cji_comprobante SET CPC_Observacion = UPPER(CONCAT(CPC_Observacion,' * ','$motivo')) WHERE CPP_Codigo = $comprobante;";
        $this->db->query($sql);
    }

    public function buscar_xserienum($serie, $numero, $doc, $oper) {
        $where = array('CPC_Serie' => $serie,
            'CPC_Numero' => $numero,
            'CPC_TipoDocumento' => $doc,
            'CPC_TipoOperacion' => $oper
        );
        $this->db->where($where);
        $query = $this->db->get('cji_comprobante');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function obtener_comprobante_ref($guia_rem) {
        $query = $this->db->where('GUIAREMP_Codigo', $guia_rem)->get('cji_comprobante');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function obtener_comprobante_ref2($guia_rem) {
        $query = $this->db->where(array('GUIAREMP_Codigo' => $guia_rem, 'CPC_FlagEstado' => 1))->get('cji_comprobante');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }
    
    public function obtener_comprobante_ref3($cod_fac) {
       $guia = explode("-", $cod_fac);
    
        $query = $this->db->where(array('GUIAREMC_Serie' => $guia[0] ,'GUIAREMC_Numero' => $guia[1],'GUIAREMC_FlagEstado' => 1 ))->get('cji_guiarem');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }
    public function obtener_comprobante_guiaref($numeroref) {
    
        $query = $this->db->where('GUIAREMC_NumeroRef', $numeroref)->get('cji_guiarem');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function insertar_comprobante($filter = null) {
        $compania  =  $filter->COMPP_Codigo;
        $user = $this->somevar ['user'];
        $filter->USUA_Codigo = $user;
        $this->db->insert("cji_comprobante", (array) $filter);

        $comprobante = $this->db->insert_id();
        switch ($filter->CPC_TipoDocumento) {
            case 'F': $codtipodocu = '8';
                break;
            case 'B': $codtipodocu = '9';
                break;
            case 'N': $codtipodocu = '14';
                break;
            default: $codtipodocu = '0';
                break;
        }
        
        if ($filter->CPC_DocuRefeCodigo !=''){
        if ($filter->CPC_TipoOperacion == 'V'){
            $this->configuracion_model->modificar_configuracion($compania, $codtipodocu, $filter->CPC_Numero);
            }
        }
        return $comprobante;
    }


    

    public function insertar_comprobante_guiarem($filter){
        if(count($filter)>0){
            $this->db->insert("cji_comprobante_guiarem", (array) $filter);
            $comprobanteGuiarem = $this->db->insert_id();
            return $comprobanteGuiarem;     
        }
    }
    
    
    public function insertar_comprobante2($filter) {
        $this->db->insert("cji_comprobante", (array) $filter);
        $comprobante = $this->db->insert_id();
        return $comprobante;
    }

    public function insertar_disparador($comprobante, $filter = null) {

        $compania = $this->somevar['compania'];
        $user = $this->somevar ['user'];
        switch ($filter->CPC_TipoDocumento) {
            case 'F': $codtipodocu = '8';
                break;
            case 'B': $codtipodocu = '9';
                break;
            case 'N': $codtipodocu = '14';
                break;
            default: $codtipodocu = '0';
                break;
        }

        $data = array(
            "CPC_FlagEstado" => 1
        );
        $this->db->where('CPP_Codigo', $comprobante);
        $this->db->update("cji_comprobante", $data);


        if ($filter->CPC_TipoOperacion == 'V')
            $this->configuracion_model->modificar_configuracion($compania, $codtipodocu, $filter->CPC_Numero);

        $filter2 = new stdClass();
        $filter2->CUE_TipoCuenta = $filter->CPC_TipoOperacion == 'V' ? 1 : 2;
        $filter2->DOCUP_Codigo = $codtipodocu;
        $filter2->CUE_CodDocumento = $comprobante;
        $filter2->MONED_Codigo = $filter->MONED_Codigo;
        $filter2->CUE_Monto = $filter->CPC_total;
        $filter2->CUE_FechaOper = $filter->CPC_Fecha;
        $filter2->COMPP_Codigo = $compania;
        $filter2->CUE_FlagEstado = '1';
        if (isset($filter->FORPAP_Codigo) && $filter->FORPAP_Codigo == 1) {
            $filter2->CUE_FlagEstadoPago = 'C';
        }
        $cuenta = $this->cuentas_model->insertar($filter2);

        if (isset($filter->FORPAP_Codigo) && $filter->FORPAP_Codigo == 1) {  //Si el pago es al contado           
            $filter3 = new stdClass();
            $filter3->PAGC_TipoCuenta = $filter->CPC_TipoOperacion == 'V' ? 1 : 2;
            $filter3->PAGC_FechaOper = $filter->CPC_Fecha;
            if ($filter3->PAGC_TipoCuenta == 1)
                $filter3->CLIP_Codigo = $filter->CLIP_Codigo;
            else
                $filter3->PROVP_Codigo = $filter->PROVP_Codigo;
            $filter4 = new stdClass();
            $filter4->TIPCAMC_Fecha = $filter->CPC_Fecha;
            $filter4->TIPCAMC_MonedaDestino = '2';
            $temp = $this->tipocambio_model->buscar($filter4);
            $tdc = is_array($temp) ? $temp[0]->TIPCAMC_FactorConversion : '';

            $filter3->PAGC_TDC = $tdc;
            $filter3->PAGC_Monto = $filter->CPC_total;
            $filter3->MONED_Codigo = $filter->MONED_Codigo;
            $filter3->PAGC_FormaPago = '1'; //Efectivo

            $filter3->PAGC_Obs = ($filter->CPC_TipoOperacion == 'V' ? 'INGRESO GENERADO' : 'SALIDA GENERADA') . ' AUTOMATICAMENTE POR EL PAGO AL CONTADO';
            $filter3->PAGC_Saldo = '0';

            $cod_pago = $this->pago_model->insertar($filter3, '', '', '');

            $filter5 = new stdClass();
            $filter5->CUE_Codigo = $cuenta;
            $filter5->PAGP_Codigo = $cod_pago;
            $filter5->CPAGC_TDC = $tdc;
            $filter5->CPAGC_Monto = $filter->CPC_total;
            $filter5->MONED_Codigo = $filter->MONED_Codigo;
            $this->cuentaspago_model->insertar($filter5);
            $filter3 = new stdClass();
        }
    }

    public function modificar_comprobante($comprobante, $filter = null) {
        $user = $this->somevar ['user'];
        $filter->USUA_Codigo = $user;

        $where = array("CPP_Codigo" => $comprobante);
        $this->db->where($where);
        $this->db->update('cji_comprobante', (array) $filter);
    }
    
    public function getVoucherSeries($comprobanteId){
        $this->db->select("CPC_Serie");
        $this->db->from("cji_comprobante");
        $this->db->where("CPP_Codigo", $comprobanteId);

        $query = $this->db->get();

        return $query->result();
    }

    public function buscarRolUsuario($nombre){
        
        $sql ="select USUA_usuario,USUA_Password,rol.ROL_Codigo,ROL_Descripcion from cji_rol rol 
                inner join cji_usuario usuario on rol.ROL_Codigo = usuario.ROL_Codigo where USUA_usuario = '$nombre' ;";
        $query = $this->db->query($sql);
        if($query->num_rows >0){
            foreach ($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
        
    }
    
    # SUMAR AL ALMACEN LA CANTIDAD DE PRODUCTOS DETALLADOS EN LA NOTA
    public function actualizarStock($comprobante, $idNota, $tipoNota, $anulacion = false){
        # TipoNota = 3 -> Credito
        # TipoNota = 4 -> Debito
        $this->load->model('ventas/notacreditodetalle_model');

        $compania = $this->somevar['compania'];

        if ($comprobante == NULL){
            if ($codAlmacen != NULL){
               return false;
            }
        }
        else{
            $list = $this->obtener_comprobante($comprobante);

            $gsap = $list[0]->GUIASAP_Codigo;


            $detalle = $this->detallesNota( $idNota );
            for ($i = 0; $i < count($detalle); $i++) {
                $prodcod = $detalle[$i]->PROD_Codigo;
                $unid_medida = $detalle[$i]->UNDMED_Codigo;
                #$cantidad = $detalle[$i]->CPDEC_Cantidad;
                $cantidad = 0;

                if ($prodcod != NULL){
                    // Ingresar al kardex los movimientos de la nota de credito y debito

                    if ($tipoNota == '3' || $tipoNota == 3){ // Si es nota de credito insertar movimientos en el kardex y mover stock
                        $almaCod = $this->AlmacenCodigoProducto($comprobante, $prodcod); // Consulta el almacen de donde se vendio cada producto
                        $almacencod = $almaCod[0]->ALMAP_Codigo; // Consulta el almacen de donde se vendio cada producto
                        $docupcod = ($tipoNota == "3") ? 11 : 12;

                        $almacenproducto_datos = $this->almacenproducto_model->obtener($almacencod, $prodcod);
                        $almacenprodcod = $almacenproducto_datos[0]->ALMPROD_Codigo;
                        $stock = $almacenproducto_datos[0]->ALMPROD_Stock;

                        $productoundad = $this->productounidad_model->obtener($prodcod, $unid_medida);
                        $cantidad = $detalle[$i]->CREDET_Cantidad;
                        $costo = $detalle[$i]->CREDET_Costo;

                        if ($anulacion == false){
                            $nuevostock = ( $list[0]->CPC_TipoOperacion == 'V' ) ? $stock + $cantidad : $stock - $cantidad; // Suma o resta (depende el tipo de operacion) al stock actual la cantidad del producto devuelto en la nota
                            if ( $list[0]->CPC_TipoOperacion == 'V' ){
                                $this->almacenproducto_model->aumentar($almacencod, $prodcod, $cantidad, $detalle[$i]->CREDET_Costo);
                                //aumento almacenprolete
                                if ($almacenprodcod!=NULL) {
                                    $this->almaprolote_model->aumentar($almacenprodcod, $detalle[$i]->LOTP_Codigo, $cantidad, $costo);
                                }
                            }
                            else{
                                $data = array("ALMPROD_Stock" => $nuevostock);
                                $where = array("ALMAC_Codigo" => $almacencod, "PROD_Codigo" => $prodcod, "COMPP_Codigo" => $compania);
                                $this->db->where($where);
                                $this->db->update('cji_almacenproducto', $data);
                                if ($almacenprodcod!=NULL) {
                                    $this->almaprolote_model->disminuir_stock($almacenprodcod, $detalle[$i]->LOTP_Codigo, $cantidad, $costo);
                                   
                                }
                            }
                        }
                        else{ # SI SE ESTA ANULANDO UNA NOTA DE CREDITO LA OPERACION SE INVIERTE, LA CANTIDAD VUELVE A SALIR DEL STOCK SI ES VENTA, SI ES COMPRA, VUELVE A ENTRAR.
                            $nuevostock = ( $list[0]->CPC_TipoOperacion == 'V' ) ? $stock - $cantidad : $stock + $cantidad; // Suma o resta (depende el tipo de operacion) al stock actual la cantidad del producto devuelto en la nota
                            if ( $list[0]->CPC_TipoOperacion == 'C' ){
                                $this->almacenproducto_model->aumentar($almacencod, $prodcod, $cantidad, $detalle[$i]->CREDET_Costo); # aumento almacenprolote
                                $this->almaprolote_model->aumentar($almacenprodcod, $detalle[$i]->LOTP_Codigo, $cantidad, $costo);
                            }
                            else{
                                $data = array("ALMPROD_Stock" => $nuevostock);
                                $where = array("ALMAC_Codigo" => $almacencod, "PROD_Codigo" => $prodcod, "COMPP_Codigo" => $compania);
                                $this->db->where($where);
                                $this->db->update('cji_almacenproducto', $data);
                                $this->almaprolote_model->disminuir_stock($almacenprodcod, $detalle[$i]->LOTP_Codigo, $cantidad, $costo);
                            }
                        }

                        $filter2 = new stdClass();
                        $filter2->PROD_Codigo = $prodcod;
                        $filter2->KARDC_CodigoDoc = $idNota; // Codigo del comprobante => nota
                        $filter2->KARD_Fecha = date('Y-m-d H:i:s');
                        $filter2->KARDC_Cantidad = $cantidad;

                        if ( $anulacion == false )
                            $filter2->KARDC_TipoIngreso = ( $list[0]->CPC_TipoOperacion == 'V' ) ? 1 : 2; # 1 ingreso, 2 salida -> Se invierte igual si es anulacion
                        else
                            $filter2->KARDC_TipoIngreso = ( $list[0]->CPC_TipoOperacion == 'C' ) ? 1 : 2; # 1 ingreso, 2 salida -> Se invierte igual si es anulacion

                        $filter2->ALMPROD_Codigo = $almacencod;
                        $filter2->LOTP_Codigo = $detalle[$i]->LOTP_Codigo;

                        $mov = ( $list[0]->CPC_TipoOperacion == 'V' ) ? 5 : 6; // 5 es un ingreso, 6 una salida

                        $filter2->KARDC_Costo = $costo; // Costo anterior
                        $insertarKardex = $this->kardex_model->insertar($mov, $filter2);
                    }
                }
            }

        }
    }

    public function detallesNota($nota){
        $sql = "SELECT cji_nota.CRED_TDC, cji_nota.MONED_Codigo, cji_nota.CRED_ComproInicio, cji_notadetalle.* FROM `cji_notadetalle` INNER JOIN cji_nota on cji_nota.CRED_Codigo = cji_notadetalle.CRED_Codigo WHERE cji_notadetalle.`CRED_Codigo` = $nota AND cji_notadetalle.`CREDET_FlagEstado` = 1 ORDER BY cji_notadetalle.CREDET_Codigo";
        $query = $this->db->query($sql);
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function AlmacenCodigoProducto($codComprobante, $producto){
        $sql = "SELECT ALMAP_Codigo FROM cji_comprobantedetalle WHERE CPP_Codigo = $codComprobante AND PROD_Codigo = $producto AND CPDEC_FlagEstado = 1";
        $query = $this->db->query($sql);
        if ($query->num_rows > 0){
            return $query->result();
        }
        else
            return NULL;
    }

    // End nota

    public function buscar_x_numero_presupuesto($tipo_oper, $tipo_docu, $presupuesto) {
        $compania = $this->somevar['compania'];

        $where = array("COMPP_Codigo" => $compania, "CPC_TipoOperacion" => $tipo_oper,
            "CPC_TipoDocumento" => $tipo_docu, "CPC_FlagEstado" => "1", "PRESUP_Codigo" => $presupuesto);
        $query = $this->db->order_by('CPC_Numero', 'desc')->where($where)->get('cji_comprobante');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function buscar_x_numero_presupuesto_cualquiera($tipo_oper, $tipo_docu, $presupuesto) {
        $compania = $this->somevar['compania'];

        $where = array("COMPP_Codigo" => $compania, "CPC_TipoOperacion" => $tipo_oper, "CPC_FlagEstado" => "1", "PRESUP_Codigo" => $presupuesto);
        $query = $this->db->order_by('CPC_Numero', 'desc')->where($where)->get('cji_comprobante');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function buscar_x_numero_ocompra($tipo_oper, $ocompra) {
        $compania = $this->somevar['compania'];

        $where = array("COMPP_Codigo" => $compania, "CPC_TipoOperacion" => $tipo_oper,
            "CPC_FlagEstado" => "1", "OCOMP_Codigo" => $ocompra);
        $query = $this->db->order_by('CPC_Numero', 'desc')->where($where)->get('cji_comprobante');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }
    /* ::::::::::::::::: IMPRESION GARANTIA  ::::::::::::::::::::::::::: */

    public function buscar_ocompra($ocompra) {
        $compania = $this->somevar['compania'];

        $where = array("OCOMC_FlagEstado" => "1", "OCOMP_Codigo" => $ocompra);
        $query = $this->db->where($where)->get('cji_ordencompra');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    public function buscar_proyecto($proyecto){
        $compania = $this->somevar['compania'];

        $where = array("PROYC_FlagEstado" => "1", "PROYP_Codigo" => $proyecto);
        $query = $this->db->where($where)->get('cji_proyecto');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
    
    public function buscar_direccion_proyecto($proyecto){
        $compania = $this->somevar['compania'];

        $where = array("DIRECC_FlagEstado" => "1", "PROYP_Codigo" => $proyecto);
        $query = $this->db->where($where)->get('cji_direccion');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    public function buscar_guiarem_comprobante($comprobante){
        $sql = "SELECT g.* FROM cji_comprobante_guiarem cg INNER JOIN cji_guiarem g ON g.GUIAREMP_Codigo = cg.GUIAREMP_Codigo WHERE cg.CPP_Codigo = $comprobante AND g.GUIAREMC_FlagEstado != 0";
        $query = $this->db->query($sql);

        if ( $query->num_rows()>0 ) {
            return $query->result();
        }
    }

    /* :::::::::::::::: IMPRESION GARANTIA ::::::::::::::::::::::::::::::: */

     // gcbq
     //parametros:
    // tipo_orden : para la operacion, COMPRA o VENTA en la OC
    // tipo_guia : para la operacion, COMPRA o VENTA en la GUIA
    // cod_orden : codigo de la OC
    // cod_prod : codigo del producto
    public function buscar_x_producto_orden($tipo_orden, $tipo_guia, $cod_orden, $cod_prod) {
        $compania = $this->somevar['compania'];
        $where = array(
            "c.COMPP_Codigo" => $compania, "c.CPC_FlagEstado" => "1",
            "o.OCOMP_Codigo" => $cod_orden, "PROD_Codigo" => $cod_prod,
            "o.OCOMC_TipoOperacion" => $tipo_orden, "CPC_TipoOperacion" => $tipo_guia
        );

        $this->db->from('cji_comprobante c');
        $this->db->join('cji_comprobantedetalle cd', 'cd.CPP_Codigo = c.CPP_Codigo');
        $this->db->join('cji_ordencompra o', 'c.OCOMP_Codigo = o.OCOMP_Codigo');
        $query = $this->db->order_by('CPC_Numero', 'desc')->where($where)->get();
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }
    
    public function buscar_x_orden($tipo_orden, $tipo_guia, $cod_orden) {
        $compania = $this->somevar['compania'];
        $where = array(
            "c.COMPP_Codigo" => $compania, "c.CPC_FlagEstado" => "1",
            "o.OCOMP_Codigo" => $cod_orden, "o.OCOMC_TipoOperacion" => $tipo_orden,
            "CPC_TipoOperacion" => $tipo_guia
        );

        $this->db->from('cji_comprobante c');
        $this->db->join('cji_comprobantedetalle cd', 'cd.CPP_Codigo = c.CPP_Codigo');
        $this->db->join('cji_ordencompra o', 'c.OCOMP_Codigo = o.OCOMP_Codigo');
        $query = $this->db->order_by('CPC_Numero', 'desc')->where($where)->group_by('c.CPP_Codigo')->get('');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        else
            return array();
    }

    public function buscar_x_numero_guiarem($guiarem) {
        $compania = $this->somevar['compania'];

        $where = array("COMPP_Codigo" => $compania,
            "CPC_FlagEstado" => "1", "GUIAREMP_Codigo" => $guiarem);
        $query = $this->db->where($where)->get('cji_comprobante');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function ultimo_serie_numero($tipo_oper, $tipo_docu) {
        $compania = $this->somevar['compania'];
        $where = array("COMPP_Codigo" => $compania, "CPC_TipoOperacion" => $tipo_oper, "CPC_TipoDocumento" => $tipo_docu);
        $query = $this->db->order_by('CPC_Serie', 'desc')->order_by('CPC_Numero', 'desc')->where($where)->get('cji_comprobante', 1);
        $result['serie'] = "001";
        $result['numero'] = "1";
        if ($query->num_rows > 0) {
            $data = $query->result();
            $result['serie'] = $data[0]->CPC_Serie;
            $result['numero'] = (int) $data[0]->CPC_Numero + 1;
        }
        return $result;
    }

    //REPORTES

    public function reporte_ocompra_5_clie_mas_importantes() {
        $sql = "SELECT Q.total,Q.nombre
                FROM
                        (SELECT SUM(o.OCOMC_total) total,
                                (CASE p.CLIC_TipoPersona WHEN '1' THEN e.EMPRC_RazonSocial 
                                ELSE CONCAT(pe.PERSC_Nombre, ' ', pe.PERSC_ApellidoPaterno, 
                                ' ', pe.PERSC_ApellidoMaterno) END) nombre
                        FROM cji_ordencompra o
                        INNER JOIN cji_cliente p ON p.CLIP_Codigo=o.CLIP_Codigo
                        LEFT JOIN cji_empresa e ON e.EMPRP_Codigo=p.EMPRP_Codigo AND p.CLIC_TipoPersona='1'
                        LEFT JOIN cji_persona pe ON pe.PERSP_Codigo=p.PERSP_Codigo AND p.CLIC_TipoPersona='0'
                        WHERE o.OCOMC_FlagEstado='1' AND o.OCOMP_Codigo<>0 AND o.OCOMC_TipoOperacion='V' AND o.OCOMC_FlagAprobado like '%'
                        GROUP BY o.CLIP_Codigo)Q
                ORDER BY Q.total DESC
                LIMIT 5";
        $query = $this->db->query($sql);

        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        return array();
    }

    public function reporte_oventa_monto_x_mes() {
        $sql = "SELECT
                    SUM((CASE MONTH(o.OCOMC_FechaRegistro) WHEN '01' THEN o.OCOMC_total ELSE 0 END)) enero,
                    SUM((CASE MONTH(o.OCOMC_FechaRegistro) WHEN '02' THEN o.OCOMC_total ELSE 0 END)) febrero,
                    SUM((CASE MONTH(o.OCOMC_FechaRegistro) WHEN '03' THEN o.OCOMC_total ELSE 0 END)) marzo,
                    SUM((CASE MONTH(o.OCOMC_FechaRegistro) WHEN '04' THEN o.OCOMC_total ELSE 0 END)) abril,
                    SUM((CASE MONTH(o.OCOMC_FechaRegistro) WHEN '05' THEN o.OCOMC_total ELSE 0 END)) mayo,
                    SUM((CASE MONTH(o.OCOMC_FechaRegistro) WHEN '06' THEN o.OCOMC_total ELSE 0 END)) junio,
                    SUM((CASE MONTH(o.OCOMC_FechaRegistro) WHEN '07' THEN o.OCOMC_total ELSE 0 END)) julio,
                    SUM((CASE MONTH(o.OCOMC_FechaRegistro) WHEN '08' THEN o.OCOMC_total ELSE 0 END)) agosto,
                    SUM((CASE MONTH(o.OCOMC_FechaRegistro) WHEN '09' THEN o.OCOMC_total ELSE 0 END)) setiembre,
                    SUM((CASE MONTH(o.OCOMC_FechaRegistro) WHEN '10' THEN o.OCOMC_total ELSE 0 END)) octubre,
                    SUM((CASE MONTH(o.OCOMC_FechaRegistro) WHEN '11' THEN o.OCOMC_total ELSE 0 END)) noviembre,
                    SUM((CASE MONTH(o.OCOMC_FechaRegistro) WHEN '12' THEN o.OCOMC_total ELSE 0 END)) diciembre
                FROM cji_ordencompra o
                WHERE o.OCOMC_FlagEstado='1' AND o.OCOMP_Codigo<>0 AND o.OCOMC_TipoOperacion='V' AND o.OCOMC_FlagAprobado like '%' AND YEAR(o.OCOMC_FechaRegistro)=YEAR(CURDATE())";
        //NOTA: en donde dice: o.OCOMC_FlagAprobado like '%' hay que reemplzar el comodin % por 1, pero como el usuario no est� aprobando las O compra lo estoy reemplazando por % para q salga el reporte
        $query = $this->db->query($sql);

        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        return array();
    }

    public function reporte_oventa_cantidad_x_mes() {
        $sql = "SELECT
                    SUM((CASE WHEN MONTH(o.OCOMC_FechaRegistro)='01' AND o.OCOMC_total<>0 THEN 1 ELSE 0 END)) enero,
                    SUM((CASE WHEN MONTH(o.OCOMC_FechaRegistro)='02' AND o.OCOMC_total<>0 THEN 1 ELSE 0 END)) febrero,
                    SUM((CASE WHEN MONTH(o.OCOMC_FechaRegistro)='03' AND o.OCOMC_total<>0 THEN 1 ELSE 0 END)) marzo,
                    SUM((CASE WHEN MONTH(o.OCOMC_FechaRegistro)='04' AND o.OCOMC_total<>0 THEN 1 ELSE 0 END)) abril,
                    SUM((CASE WHEN MONTH(o.OCOMC_FechaRegistro)='05' AND o.OCOMC_total<>0 THEN 1 ELSE 0 END)) mayo,
                    SUM((CASE WHEN MONTH(o.OCOMC_FechaRegistro)='06' AND o.OCOMC_total<>0 THEN 1 ELSE 0 END)) junio,
                    SUM((CASE WHEN MONTH(o.OCOMC_FechaRegistro)='07' AND o.OCOMC_total<>0 THEN 1 ELSE 0 END)) julio,
                    SUM((CASE WHEN MONTH(o.OCOMC_FechaRegistro)='08' AND o.OCOMC_total<>0 THEN 1 ELSE 0 END)) agosto,
                    SUM((CASE WHEN MONTH(o.OCOMC_FechaRegistro)='09' AND o.OCOMC_total<>0 THEN 1 ELSE 0 END)) setiembre,
                    SUM((CASE WHEN MONTH(o.OCOMC_FechaRegistro)='10' AND o.OCOMC_total<>0 THEN 1 ELSE 0 END)) octubre,
                    SUM((CASE WHEN MONTH(o.OCOMC_FechaRegistro)='11' AND o.OCOMC_total<>0 THEN 1 ELSE 0 END)) noviembre,
                    SUM((CASE WHEN MONTH(o.OCOMC_FechaRegistro)='12' AND o.OCOMC_total<>0 THEN 1 ELSE 0 END)) diciembre
            FROM cji_ordencompra o
            WHERE o.OCOMC_FlagEstado='1' AND  o.OCOMP_Codigo<>0 AND o.OCOMC_TipoOperacion='V' AND o.OCOMC_FlagAprobado like '%' AND YEAR(o.OCOMC_FechaRegistro)=YEAR(CURDATE())";
        //NOTA: en donde dice: o.OCOMC_FlagAprobado like '%' hay que reemplzar el comodin % por 1, pero como el usuario no est� aprobando las O compra lo estoy reemplazando por % para q salga el reporte
        $query = $this->db->query($sql);

        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        return array();
    }

    public function reporte_comparativo_compras_ventas($tipo_op) {
        //CPC_TipoOperacion => V venta, C compra
        //CPC_TipoDocumento => F factura, B boleta
        //CPC_total => total de la FACTURA o BOLETA
        $sql = "SELECT
                    SUM((CASE MONTH(c.CPC_FechaRegistro) WHEN '01' THEN c.CPC_total ELSE 0 END)) enero,
                    SUM((CASE MONTH(c.CPC_FechaRegistro) WHEN '02' THEN c.CPC_total ELSE 0 END)) febrero,
                    SUM((CASE MONTH(c.CPC_FechaRegistro) WHEN '03' THEN c.CPC_total ELSE 0 END)) marzo,
                    SUM((CASE MONTH(c.CPC_FechaRegistro) WHEN '04' THEN c.CPC_total ELSE 0 END)) abril,
                    SUM((CASE MONTH(c.CPC_FechaRegistro) WHEN '05' THEN c.CPC_total ELSE 0 END)) mayo,
                    SUM((CASE MONTH(c.CPC_FechaRegistro) WHEN '06' THEN c.CPC_total ELSE 0 END)) junio,
                    SUM((CASE MONTH(c.CPC_FechaRegistro) WHEN '07' THEN c.CPC_total ELSE 0 END)) julio,
                    SUM((CASE MONTH(c.CPC_FechaRegistro) WHEN '08' THEN c.CPC_total ELSE 0 END)) agosto,
                    SUM((CASE MONTH(c.CPC_FechaRegistro) WHEN '09' THEN c.CPC_total ELSE 0 END)) setiembre,
                    SUM((CASE MONTH(c.CPC_FechaRegistro) WHEN '10' THEN c.CPC_total ELSE 0 END)) octubre,
                    SUM((CASE MONTH(c.CPC_FechaRegistro) WHEN '11' THEN c.CPC_total ELSE 0 END)) noviembre,
                    SUM((CASE MONTH(c.CPC_FechaRegistro) WHEN '12' THEN c.CPC_total ELSE 0 END)) diciembre
            FROM cji_comprobante c
            WHERE c.CPC_TipoOperacion='" . $tipo_op . "' AND c.CPC_FlagEstado='1' AND  c.CPP_Codigo<>0 AND YEAR(c.CPC_FechaRegistro)=YEAR(CURDATE())";
        $query = $this->db->query($sql);

        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        return array();
    }

    public function buscar_comprobante_venta($fechai, $fechaf, $proveedor, $producto, $aprobado, $ingreso,$tipo_oper ,$number_items = '', $offset = '') {
        $where = '';
        if ($fechai != '' && $fechaf != '')
            $where = ' and o.OCOMC_FechaRegistro BETWEEN "' . $fechai . '" AND "' . $fechaf . '"';
        if ($proveedor != '')
            $where.=' and o.CLIP_Codigo=' . $proveedor;//PROVP_Codigo &&  CLIP_Codigo
        if ($producto != '')
            $where.=' and od.PROD_Codigo=' . $producto;
        if ($aprobado != '')
            $where.=' and o.OCOMC_FlagAprobado=' . $aprobado;
        if ($ingreso != '')
            $where.=' and o.OCOMC_FlagIngreso=' . $ingreso;
        $limit = "";
        if ((string) $offset != '' && $number_items != '')
            $limit = 'LIMIT ' . $offset . ',' . $number_items;

        $sql = "SELECT DATE_FORMAT(o.OCOMC_FechaRegistro, '%d/%m/%Y') fecha,
                         o.OCOMP_Codigo,
                         o.PEDIP_Codigo,
                         o.PROVP_Codigo,
                         o.CENCOSP_Codigo,
                         o.OCOMC_Numero,
                         
                           (CASE WHEN o.COTIP_Codigo =0 THEN '***'
                           ELSE CAST(ct.COTIC_Numero AS char) END) cotizacion,
                       (CASE p.CLIC_TipoPersona WHEN '1'
                       THEN e.EMPRC_RazonSocial
                       ELSE CONCAT( pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) end) nombre,
                       m.MONED_Simbolo,
                       o.OCOMC_total,
                       (CASE o.OCOMC_FlagAprobado 
                                WHEN '0' THEN 'Pend.'
                                WHEN '1' THEN 'Aprob.'
                                WHEN '2' THEN 'Desaprob.'
                                ELSE ''
                        END) aprobado,
                        (CASE o.OCOMC_FlagIngreso 
                                WHEN '0' THEN 'Pend.'
                                WHEN '1' THEN 'Si.'
                                ELSE ''
                        END) ingreso,
                        o.OCOMC_FlagEstado
                FROM cji_ordencompra o
                LEFT JOIN cji_moneda m ON m.MONED_Codigo=o.MONED_Codigo
                INNER JOIN cji_ocompradetalle od ON od.OCOMP_Codigo=o.OCOMP_Codigo
                INNER JOIN cji_cliente p ON p.CLIP_Codigo=o.CLIP_Codigo
                LEFT JOIN cji_persona pe ON pe.PERSP_Codigo=p.PERSP_Codigo AND p.CLIC_TipoPersona='0'
                LEFT JOIN cji_empresa e ON e.EMPRP_Codigo=p.EMPRP_Codigo AND p.CLIC_TipoPersona='1'
                LEFT JOIN cji_cotizacion ct ON ct.COTIP_Codigo=o.COTIP_Codigo
                WHERE o.OCOMC_FlagEstado='1' " . $where . " AND o.OCOMC_TipoOperacion='".$tipo_oper."'
                GROUP BY o.OCOMP_Codigo
                ORDER BY o.OCOMC_Numero DESC " . $limit . "
                ";
        //echo $sql;
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        return array();
    }

    public function buscar_factura_venta($fechai, $fechaf, $cliente, $aprobado, $ingreso,$tipo_oper ,$number_items = '', $offset = '') {
        $where = '';
        if ($fechai != '' && $fechaf != '')
            $where = ' and c.CPC_Fecha BETWEEN "' . $fechai . '" AND "' . $fechaf . '"';
        if ($cliente != '')
            $where.=' and c.CLIP_Codigo=' . $cliente;//PROVP_Codigo &&  CLIP_Codigo
        if ($aprobado != '')
            $where.=' and c.CPC_FlagEstado=' . $aprobado;

        $limit = "";
        if ((string) $offset != '' && $number_items != '')
            $limit = 'LIMIT ' . $offset . ',' . $number_items;

        $sql = "SELECT DATE_FORMAT(c.CPC_Fecha, '%d/%m/%Y') fecha,
                         c.CPP_Codigo,
                         c.CLIP_Codigo,
                         c.CPC_Serie,
                         c.CPC_Numero,
                       (CASE p.CLIC_TipoPersona WHEN '1'
                       THEN e.EMPRC_RazonSocial
                       ELSE CONCAT( pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) end) nombre,
                       m.MONED_Simbolo,
                       c.CPC_total,
                       (CASE c.CPC_FlagEstado 
                                WHEN '0' THEN 'Anulado.'
                                WHEN '1' THEN 'Aprobado'
                                WHEN '2' THEN 'Por Aprobar.'
                                ELSE ''
                        END) aprobado
                FROM cji_comprobante c
                LEFT JOIN cji_moneda m ON m.MONED_Codigo=c.MONED_Codigo
                INNER JOIN cji_cliente p ON p.CLIP_Codigo=c.CLIP_Codigo
                LEFT JOIN cji_persona pe ON pe.PERSP_Codigo=p.PERSP_Codigo AND p.CLIC_TipoPersona='0'
                LEFT JOIN cji_empresa e ON e.EMPRP_Codigo=p.EMPRP_Codigo AND p.CLIC_TipoPersona='1'
                WHERE c.CPC_FlagEstado='1' AND c.CPC_TipoDocumento = 'F' " . $where . " AND c.CPC_TipoOperacion='".$tipo_oper."'
                GROUP BY c.CPP_Codigo
                ORDER BY c.CPC_Numero DESC " . $limit . "
                ";
        //echo $sql;
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        return array();
    }


    public function buscar_comprobante_venta_2($anio) {
        //CPC_TipoOperacion => V venta, C compra
        //CPC_TipoDocumento => F factura, B boleta
        //CPC_total => total de la FACTURA o BOLETA
        $sql = " SELECT * FROM cji_comprobante c WHERE CPC_TipoOperacion='V' AND CPC_TipoDocumento='F' AND YEAR(CPC_FechaRegistro)=" . $anio . "";
        //echo $sql;
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        return array();
    }


    public function buscar_comprobante_compras($anio) {
        //CPC_TipoOperacion => V venta, C compra
        //CPC_TipoDocumento => F factura, B boleta
        //CPC_total => total de la FACTURA o BOLETA
        $sql = " SELECT c.*, m.MONED_Simbolo FROM cji_comprobante c  inner JOIN cji_moneda m ON m.MONED_Codigo=c.MONED_Codigo WHERE c.CPC_TipoOperacion='C' AND c.CPC_TipoDocumento='F' AND YEAR(c.CPC_FechaRegistro)=" . $anio . "";
        //echo $sql;
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        return array();
    }

    

    

    public function estadisticas_compras_ventas_mensual($tipo, $anio, $mes, $totales = false) {
        if ($tipo == 'V'){
            $sql = "
                    SELECT p.CLIP_Codigo,e.EMPRC_RazonSocial,e.EMPRC_Ruc,pe.PERSC_Nombre,pe.PERSC_NumeroDocIdentidad,MONTH(c.CPC_Fecha) AS mes,
                    c.CPC_Fecha,c.CPC_subtotal,c.CPC_igv,c.CPC_total AS monto, c.MONED_Codigo, m.MONED_Simbolo, c.COMPP_Codigo, c.CPC_Serie, c.CPC_Numero, c.CPC_TipoDocumento, c.CPC_FlagEstado
                    FROM cji_cliente p 
                    INNER JOIN cji_comprobante c ON p.CLIP_Codigo = c.CLIP_Codigo
                    LEFT JOIN cji_moneda m ON m.MONED_Codigo = c.MONED_Codigo
                    LEFT JOIN cji_empresa e ON e.EMPRP_Codigo=p.EMPRP_Codigo AND p.CLIC_TipoPersona='1' 
                    LEFT JOIN cji_persona pe ON pe.PERSP_Codigo=p.PERSP_Codigo AND p.CLIC_TipoPersona='0'
                    WHERE c.CPC_FlagEstado IN(0,1) AND c.COMPP_Codigo='".$this->somevar['compania']."' and c.CPC_TipoOperacion='" . $tipo . "' AND MONTH(CPC_Fecha) ='" . $mes . "' AND YEAR(CPC_Fecha) ='" . $anio . "' ORDER BY c.CPC_Fecha
            ";
        }
        else{
            $sql = "
                SELECT p.PROVP_Codigo,e.EMPRC_RazonSocial,e.EMPRC_Ruc,e.EMPRC_RazonSocial as PERSC_Nombre,MONTH(c.CPC_Fecha) AS mes,
                c.CPC_Fecha,c.CPC_subtotal,c.CPC_igv,c.CPC_total AS monto, c.MONED_Codigo, m.MONED_Simbolo, c.COMPP_Codigo, c.CPC_Serie, c.CPC_Numero, c.CPC_TipoDocumento, c.CPC_FlagEstado
                FROM cji_proveedor p 
                INNER JOIN cji_comprobante c ON p.PROVP_Codigo = c.PROVP_Codigo
                LEFT JOIN cji_moneda m ON m.MONED_Codigo = c.MONED_Codigo
                LEFT JOIN cji_empresa e ON e.EMPRP_Codigo=p.EMPRP_Codigo AND p.PROVC_TipoPersona='1' 
                WHERE c.CPC_FlagEstado IN(0,1) AND c.COMPP_Codigo='".$this->somevar['compania']."' and c.CPC_TipoOperacion='" . $tipo . "' AND MONTH(c.CPC_Fecha) ='" . $mes . "' AND YEAR(c.CPC_Fecha) ='" . $anio . "' ORDER BY c.CPC_Fecha
            ";
        }

        if ($totales == true){
            $sql = "
                    SELECT SUM(c.CPC_total) AS total, m.MONED_Simbolo, c.CPC_TipoDocumento
                    FROM cji_comprobante c
                    LEFT JOIN cji_moneda m ON m.MONED_Codigo = c.MONED_Codigo
                    WHERE c.CPC_FlagEstado = 1 AND c.COMPP_Codigo='".$this->somevar['compania']."' and c.CPC_TipoOperacion='" . $tipo . "' AND MONTH(CPC_Fecha) ='" . $mes . "' AND YEAR(CPC_Fecha) ='" . $anio . "' GROUP BY c.CPC_TipoDocumento, c.MONED_Codigo
            ";
        }

        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        return array();
    }

    public function estadisticas_compras_mensual($tipo, $anio, $mes) {
        $sql = "
                SELECT p.PROVP_Codigo,e.EMPRC_RazonSocial,e.EMPRC_Ruc,e.EMPRC_RazonSocial as PERSC_Nombre,MONTH(c.CPC_Fecha) AS mes,
                c.CPC_Fecha,c.CPC_subtotal,c.CPC_igv,c.CPC_total AS monto, c.COMPP_Codigo, c.CPC_Serie, c.CPC_Numero
                FROM cji_proveedor p 
                INNER JOIN cji_comprobante c ON p.PROVP_Codigo = c.PROVP_Codigo
                LEFT JOIN cji_empresa e ON e.EMPRP_Codigo=p.EMPRP_Codigo AND p.PROVC_TipoPersona='1' 
                WHERE c.COMPP_Codigo='".$this->somevar['compania']."' and c.CPC_TipoOperacion='" . $tipo . "' AND MONTH(c.CPC_Fecha) ='" . $mes . "' AND YEAR(c.CPC_Fecha) ='" . $anio . "' AND CPC_TipoDocumento='F' ORDER BY CPC_Fecha
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        return array();
    }
    

    /**modificar estado segun documento y codigo asociados**/
    public function modificarEstadoDocumetoCodigoAsociado($codigo,$estado){
        $filter->COMPGUI_FlagEstado = $estado;
        $where = array("CPP_Codigo" => $codigo);
        $this->db->where($where);
        $this->db->delete('cji_comprobante_guiarem', array("CPP_Codigo" => $codigo));
    }

    public function desvincularGuia($codigo){
        $filter->COMPGUI_FlagEstado = 0;
        $where = array("CPP_Codigo" => $codigo);
        $this->db->where($where);
        $this->db->update('cji_comprobante_guiarem', $filter);
    }
    
    public function buscarComprobanteGuiarem($comprobante,$estadoAsociacion){
        $this->db->from('cji_comprobante_guiarem cg');
        $this->db->join('cji_guiarem g', 'g.GUIAREMP_Codigo=cg.GUIAREMP_Codigo');
        
        if($estadoAsociacion!=null && trim($estadoAsociacion)!="")
            $this->db->where("cg.COMPGUI_FlagEstado =",$estadoAsociacion);
        
        
        $this->db->where("cg.CPP_Codigo",$comprobante);
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }
    
    /**obtener comprobantes tipo:N que crearon el comprbante tipo :F,B**/
    public function buscarComprobanteRelacionadoCanje($comprobanteCanje){
        $this->db->from('cji_comprobante c');
        $this->db->where("c.CPP_Codigo_Canje",$comprobanteCanje);
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }
public function verificar_inventariado($cod){
    $this->db->select('PROD_Codigo');
    $this->db->where('PROD_Codigo',$cod);
     $query = $this->db->get('cji_inventariodetalle');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
 }   
   
 public function buscar_comprobante_producto($fech1 = NULL, $fech2 = NULL, $tipodocumento, $Prodcod) {

    $fech1 = ($fech1 == NULL) ? date("Y-m-d 00:00:00") : "$fech1 00:00:00";
    $fech2 = ($fech2 == NULL) ? date("Y-m-d 23:59:59") : "$fech2 23:59:59";
    $compania = $this->somevar['compania'];
    
    $where="";    
    $wheretdoc= "";

    if($tipodocumento !="--")
        $wheretdoc= " AND CPC_TipoDocumento='".$tipodocumento."' ";
 
        $wherepro= "";
        if($Prodcod != "--")
            $wherepro= " AND cd.PROD_Codigo='".$Prodcod."' ";
 
        $sql = " SELECT com.*, cd.CPDEC_Total, CONCAT(pe.PERSC_Nombre, ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) as nombre , MONED_Simbolo, SUM(cd.CPDEC_Cantidad) as CPDEC_Cantidad, p.PROD_Nombre, marca.MARCC_Descripcion
                    FROM  cji_comprobantedetalle cd 
                    INNER JOIN  cji_comprobante com on cd.CPP_Codigo = com.CPP_Codigo
                    INNER JOIN cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
                    INNER JOIN cji_persona pe on pe.PERSP_Codigo = cl.PERSP_Codigo
                    INNER JOIN cji_moneda m ON m.MONED_Codigo=com.MONED_Codigo
                    INNER JOIN cji_producto p ON p.PROD_Codigo = cd.PROD_Codigo
                    LEFT JOIN cji_marca marca ON marca.MARCP_Codigo = p.MARCP_Codigo
                        WHERE CPC_TipoOperacion='V' AND com.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND  com.COMPP_Codigo = $compania $wheretdoc $where $wherepro AND CPC_Fecha BETWEEN '$fech1' AND '$fech2'
                        GROUP BY com.CPP_Codigo
                    UNION
                    SELECT com.*, cd.CPDEC_Total, EMPRC_RazonSocial as nombre, MONED_Simbolo, SUM(cd.CPDEC_Cantidad) as CPDEC_Cantidad, p.PROD_Nombre, marca.MARCC_Descripcion
                    FROM cji_comprobantedetalle cd
                    INNER JOIN cji_comprobante com on cd.CPP_Codigo = com.CPP_Codigo
                    INNER JOIN cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
                    INNER JOIN cji_empresa es on es.EMPRP_Codigo = cl.EMPRP_Codigo
                    INNER JOIN cji_moneda m ON m.MONED_Codigo = com.MONED_Codigo
                    INNER JOIN cji_producto p ON p.PROD_Codigo = cd.PROD_Codigo
                    LEFT JOIN cji_marca marca ON marca.MARCP_Codigo = p.MARCP_Codigo
                        WHERE CPC_TipoOperacion='V' AND com.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND  com.COMPP_Codigo = $compania $wheretdoc $where $wherepro AND CPC_Fecha BETWEEN '$fech1' AND '$fech2'
                        GROUP BY com.CPP_Codigo
                ";
            
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila)
                $data[] = $fila;
            return $data;
        }
        return array();
 }



 public function autocompleteProducto($keyword){
    try {
        $sql = "SELECT  PROD_Nombre,PROD_Codigo FROM cji_producto where PROD_Nombre LIKE '%" . $keyword . "%' and PROD_FlagEstado = 1 ";
 
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
 
    } catch (Exception $e) {
         
    }
 }

 public function get_adelantos_by_id_proyecto($id_proyecto, $oper = 'V')
 {
    $query = $this->db->from("cji_comprobante");

    $query->join("cji_comprobantedetalle", "cji_comprobantedetalle.CPP_Codigo = cji_comprobante.CPP_Codigo");

    $query->where("cji_comprobante.OCOMP_Codigo", $id_proyecto);
    $query->where("cji_comprobante.CPC_FlagEstado", 1);
    $query->where("cji_comprobante.CPC_TipoOperacion", $oper);
    $query->where("cji_comprobantedetalle.PROD_Codigo", 2147483647);
    $query->where("cji_comprobantedetalle.CPDEC_FlagEstado", 1);

    return $query->select("cji_comprobante.*, cji_comprobantedetalle.*")->get()->result();
 }

 public function get_consumo_adelantos_by_id_proyecto($id_proyecto, $oper = 'V')
 {
    $query = $this->db->from("cji_comprobante");

    $query->where("cji_comprobante.OCOMP_Codigo", $id_proyecto);
    $query->where("cji_comprobante.CPC_FlagUsaAdelanto", 1);
    $query->where("cji_comprobante.CPC_TipoOperacion", $oper);
    $query->where("cji_comprobante.CPC_FlagEstado", 1);

    return $query->select("cji_comprobante.*")->get()->result();
 }

    public function obtener_referencia_comprobante_by_id_detalle_compra($id_detalle_compra)
    {
        $result = $this->db->from("cji_comprobantedetalle")
                            ->where(array("cji_comprobantedetalle.OCOMP_Codigo_VC" => $id_detalle_compra, "cji_comprobantedetalle.CPDEC_FlagEstado" => 1))
                            ->join("cji_ocompradetalle", "cji_ocompradetalle.OCOMDEP_Codigo = cji_comprobantedetalle.OCOMP_Codigo_VC")
                            ->select("cji_ocompradetalle.*")->get()->result();

        if(count($result) == 0) return null;

        return $result[0];
    }

    public function listar_adelantos_by_id($id_compra, $tipo)
    {
        return $this->db->from("cji_comprobante")
                        ->join("cji_comprobantedetalle", "cji_comprobantedetalle.CPP_Codigo = cji_comprobante.CPP_Codigo")
                        ->join("cji_moneda", "cji_moneda.MONED_Codigo = cji_comprobante.MONED_Codigo")
                        ->join("cji_cliente", "cji_cliente.CLIP_Codigo = cji_comprobante.CLIP_Codigo", "LEFT")
                        ->join("cji_proveedor", "cji_proveedor.PROVP_Codigo = cji_comprobante.PROVP_Codigo", "LEFT")
                        ->join("cji_persona", "cji_persona.PERSP_Codigo = cji_cliente.PERSP_Codigo OR cji_persona.PERSP_Codigo = cji_proveedor.PERSP_Codigo", "LEFT")
                        ->join("cji_empresa", "cji_empresa.EMPRP_Codigo = cji_cliente.EMPRP_Codigo OR cji_empresa.EMPRP_Codigo = cji_proveedor.EMPRP_Codigo", "LEFT")
                        ->where("cji_comprobante.CPC_FlagEstado", 1)
                        ->where("cji_comprobante.OCOMP_Codigo", $id_compra)
                        ->like("cji_comprobantedetalle.CPDEC_Descripcion", "adelanto")
                        ->group_by("cji_comprobante.CPP_Codigo")
                        ->select("cji_comprobante.*, cji_moneda.*, cji_persona.*, cji_empresa.*")->get()->result();
    }

    public function obtener_cliente($cliente)
    {
        $sql = "SELECT e.* FROM cji_empresa e
                INNER JOIN cji_cliente c ON c.EMPRP_Codigo = e.EMPRP_Codigo 
                WHERE c.CLIP_Codigo = $cliente";
        $query  = $this->db->query($sql);

        if ($query->num_rows()>0) {
            return $query->result();
        }


    }

    public function obtener_cliente_dni($cliente)
    {
        $sql = "SELECT p.* FROM cji_persona p
                INNER JOIN cji_cliente c ON c.PERSP_Codigo = p.PERSP_Codigo 
                WHERE c.CLIP_Codigo = $cliente";
        $query  = $this->db->query($sql);

        if ($query->num_rows()>0) {
            return $query->result();
        }
    }

    public function obtener_comprobantexcuota($idcuota){
        $query = $this->db->select('*')
                          ->where('CUOT_Codigo',$idcuota)
                          ->get('comprobantes_cuotas');

        if ($query->num_rows()>0) {
            return $query->result();
        }
    }

    public function estado_pago_factura($idcomprobante){
        $query = $this->db->select('*')
                          ->where('CUE_CodDocumento',$idcomprobante)
                          ->get('cji_cuentas');

        if ($query->num_rows()>0) {
            return $query->result();
        }
    }

    public function relacion_clientes($vendedor) {
       
        $sql = "SELECT p.*, c.*,
                    (SELECT CONCAT_WS(' ', pp.PERSC_NumeroDocIdentidad, ' - ', pp.PERSC_Nombre, pp.PERSC_ApellidoPaterno, pp.PERSC_ApellidoMaterno) FROM cji_persona pp WHERE pp.PERSP_Codigo = c.PERSP_Codigo) as nombre_cliente,
                    (SELECT CONCAT_WS(' ', e.EMPRC_Ruc, e.EMPRC_RazonSocial) FROM cji_empresa e WHERE e.EMPRP_Codigo = c.EMPRP_Codigo) as razon_social,
                    (SELECT SUM(CPP_Codigo) FROM cji_comprobante c WHERE c.CPC_Vendedor = p.PERSP_Codigo AND c.CPC_FlagEstado = 1) as total_documentos,
                    (SELECT SUM(CPC_Total) FROM cji_comprobante c WHERE c.CPC_Vendedor = p.PERSP_Codigo AND c.CPC_FlagEstado = 1) as total_ventas

                    FROM cji_directivo d
                    INNER JOIN cji_persona p ON p.PERSP_Codigo = d.PERSP_Codigo
                    INNER JOIN cji_cliente c ON c.CLIC_Vendedor = p.PERSP_Codigo
                        WHERE d.DIREP_Codigo = $vendedor
                        ORDER BY total_ventas DESC
                ";
                
            $query = $this->db->query($sql);
            if ($query->num_rows > 0) {
                foreach ($query->result() as $fila)
                    $data[] = $fila;
                return $data;
            }
            return array();
    }

//ANULAR DOCUMENTO
    public function eliminar_comprobante($codigo) {
        $comprobante = $this->obtener_comprobante($codigo);
        $comprobante = $comprobante[0];

        if ($comprobante->CPC_TipoOperacion=="V") {
            $this->devolver_stock_anulado($comprobante);
        }else{
            $this->retirar_stock_anulado($comprobante);
        }
        $guiarem = $this->buscar_guiarem_comprobante($codigo);
        if ($guiarem!=null) {
           $this->desvincularGuia($codigo);
        }

        $cuentas = $this->cuentas_model->getCuentaComprobante($codigo);
        if ($cuentas != NULL){
            foreach ($cuentas as $key => $val) {
                $cuentaspago_datos = $this->cuentaspago_model->obtener($val->CUE_CodDocumento);
                if (count($cuentaspago_datos) > 0){
                    foreach ($cuentaspago_datos as $j => $v){
                    $codpago = $v->PAGP_Codigo;
                    $this->pago_model->anular($codpago);
                    }
              }
                $this->cuentaspago_model->eliminar($val->CUE_Codigo);
                $this->cuentas_model->eliminar($val->CUE_Codigo);
            }
        }
    }

    //DISMINUYE STOCK
    public function retirar_stock_anulado($comprobante)
    {
        
        $AlmacenOrigen                  = $comprobante->ALMAP_Codigo;
        $codigo                         = $comprobante->CPP_Codigo;
        $stock_actualizado              = 0;

        $detalle_comprobante = $this->comprobantedetalle_model->detalles($codigo);
        $done = false;
        if ($detalle_comprobante>0) {
            foreach ($detalle_comprobante as $key => $value) {
                if ($value->PROD_FlagBienServicio=="B") {
                   $cantidad = $value->CPDEC_Cantidad;
                   $producto = $value->PROD_Codigo;
                   //obtenemos los datos del producto en el almacen
                   $datosAlmacenProducto = $this->almacenproducto_model->obtener($AlmacenOrigen, $producto);
                   
                   if ($datosAlmacenProducto) {
                        $stock = $datosAlmacenProducto[0]->ALMPROD_Stock;
                        $stock_actualizado = $stock - $cantidad;
                        $filter_dism = new stdClass();
                        $filter_dism->ALMPROD_Stock  = $stock_actualizado;
                        $filter_dism->COMPP_Codigo   = $comprobante->COMPP_Codigo;
                        $filter_dism->ALMAC_Codigo   = $AlmacenOrigen;
                        $filter_dism->PROD_Codigo    = $producto;
                        $filter_dism->ALMPROD_Codigo = $datosAlmacenProducto[0]->ALMPROD_Codigo;
                        $filter_dism->ALMPROD_FechaModificacion    = date('Y-m-d H:i:s');
                        $done = $this->almacenproducto_model->actualizar_stock($filter_dism);
                   }else{
                        $this->inventario_model->confirmInventariado($producto, $AlmacenOrigen);
                        $datosAlmacenProducto = $this->almacenproducto_model->obtener($AlmacenOrigen, $producto);
                        $stock = $datosAlmacenProducto[0]->ALMPROD_Stock;
                        $stock_actualizado = $stock - $cantidad;
                        $filter_dism = new stdClass();
                        $filter_dism->ALMPROD_Stock  = $stock_actualizado;
                        $filter_dism->COMPP_Codigo   = $comprobante->COMPP_Codigo;
                        $filter_dism->ALMAC_Codigo   = $AlmacenOrigen;
                        $filter_dism->PROD_Codigo    = $producto;
                        $filter_dism->ALMPROD_Codigo = $datosAlmacenProducto[0]->ALMPROD_Codigo;
                        $filter_dism->ALMPROD_FechaModificacion    = date('Y-m-d H:i:s');
                        $done = $this->almacenproducto_model->actualizar_stock($filter_dism);
                   }
                    ############################
                    # REGISTRO DE KARDEX
                    ############################
                    $cKardex = new stdClass();
                    $cKardex->codigo_documento  = $comprobante->CPP_Codigo;
                    $cKardex->tipo_docu         = $comprobante->CPC_TipoDocumento;
                    $cKardex->producto          = $producto;
                    $cKardex->nombre_producto   = $value->CPDEC_Descripcion; 
                    $cKardex->cantidad          = $cantidad;
                    $cKardex->serie             = $comprobante->CPC_Serie;
                    $cKardex->numero            = $comprobante->CPC_Numero;
                    $cKardex->nombre_almacen    = ""; #opcionales (para futuro desarrollo)
                    $cKardex->moneda            = $comprobante->MONED_Codigo;
                    $cKardex->afectacion        = $value->AFECT_Codigo;
                    $cKardex->costo             = $value->CPDEC_Pu;
                    $cKardex->precio_con_igv    = $value->CPDEC_Pu_ConIgv;
                    $cKardex->subtotal          = $value->CPDEC_Subtotal;
                    $cKardex->total             = $value->CPDEC_Total;
                    $cKardex->compania          = $comprobante->COMPP_Codigo;
                    $cKardex->tipo_oper         = 1; # 1: SALIDA 2: INGRESO 
                    $cKardex->tipo_movimiento   = "SALIDA POR ANULACION DE COMPRA";
                    $cKardex->nombre            = ""; #opcionales (para futuro desarrollo)
                    $cKardex->numdoc            = ""; #opcionales (para futuro desarrollo)
                    $cKardex->almacen           = $value->ALMAP_Codigo;
                    $cKardex->cliente           = $comprobante->CLIP_Codigo;
                    $cKardex->proveedor         = $comprobante->PROVP_Codigo;
                    $cKardex->usuario           = $comprobante->USUA_Codigo; #Nombre o codigo?
                    $cKardex->estado            = 0;
                    $this->registrar_kardex($cKardex);
                }
            }
            $filter->CPC_FlagEstado     = 0;
            $this->comprobante_model->modificar_comprobante($codigo, $filter);
        }
        return $done;
    }

    //AUMENTA STOCK
    public function devolver_stock_anulado($comprobante)
    {
        
        $AlmacenDestino                 = $comprobante->ALMAP_Codigo;
        $codigo                         = $comprobante->CPP_Codigo;
        $stock_actualizado              = 0;

        $detalle_comprobante = $this->comprobantedetalle_model->detalles($codigo);
        $done = false;
        if ($detalle_comprobante>0) {
            foreach ($detalle_comprobante as $key => $value) {
                
                if ($value->PROD_FlagBienServicio=="B") {
                   $cantidad = $value->CPDEC_Cantidad;
                   $producto = $value->PROD_Codigo;
                   //obtenemos los datos del producto en el almacen
                   $datosAlmacenProducto = $this->almacenproducto_model->obtener($AlmacenDestino, $producto);

                   if ($datosAlmacenProducto) {
                        $stock = $datosAlmacenProducto[0]->ALMPROD_Stock;
                        $stock_actualizado = $stock + $cantidad;
                        $filter_dism = new stdClass();
                        $filter_dism->ALMPROD_Stock  = $stock_actualizado;
                        $filter_dism->COMPP_Codigo   = $comprobante->COMPP_Codigo;
                        $filter_dism->ALMAC_Codigo   = $AlmacenDestino;
                        $filter_dism->PROD_Codigo    = $producto;
                        $filter_dism->ALMPROD_Codigo = $datosAlmacenProducto[0]->ALMPROD_Codigo;
                        $filter_dism->ALMPROD_FechaModificacion    = date('Y-m-d H:i:s');
                        $done = $this->almacenproducto_model->actualizar_stock($filter_dism);
                   }else{
                        $this->inventario_model->confirmInventariado($producto, $AlmacenDestino);
                        $datosAlmacenProducto = $this->almacenproducto_model->obtener($AlmacenDestino, $producto);
                        $stock = $datosAlmacenProducto[0]->ALMPROD_Stock;
                        $stock_actualizado = $stock + $cantidad;
                        $filter_dism = new stdClass();
                        $filter_dism->ALMPROD_Stock  = $stock_actualizado;
                        $filter_dism->COMPP_Codigo   = $comprobante->COMPP_Codigo;
                        $filter_dism->ALMAC_Codigo   = $AlmacenDestino;
                        $filter_dism->PROD_Codigo    = $producto;
                        $filter_dism->ALMPROD_Codigo = $datosAlmacenProducto[0]->ALMPROD_Codigo;
                        $filter_dism->ALMPROD_FechaModificacion    = date('Y-m-d H:i:s');
                        $done = $this->almacenproducto_model->actualizar_stock($filter_dism);
                   }
                    ############################
                    # REGISTRO DE KARDEX
                    ############################
                    $cKardex = new stdClass();
                    $cKardex->codigo_documento  = $comprobante->CPP_Codigo;
                    $cKardex->tipo_docu         = $comprobante->CPC_TipoDocumento;
                    $cKardex->producto          = $producto;
                    $cKardex->nombre_producto   = $value->CPDEC_Descripcion;
                    $cKardex->cantidad          = $cantidad;
                    $cKardex->serie             = $comprobante->CPC_Serie;
                    $cKardex->numero            = $comprobante->CPC_Numero;
                    $cKardex->nombre_almacen    = ""; #opcionales (para futuro desarrollo)
                    $cKardex->moneda            = $comprobante->MONED_Codigo;
                    $cKardex->afectacion        = $value->AFECT_Codigo;
                    $cKardex->costo             = $value->CPDEC_Pu;
                    $cKardex->precio_con_igv    = $value->CPDEC_Pu_ConIgv;
                    $cKardex->subtotal          = $value->CPDEC_Subtotal;
                    $cKardex->total             = $value->CPDEC_Total;
                    $cKardex->compania          = $comprobante->COMPP_Codigo;
                    $cKardex->tipo_oper         = 2; # 1: salida 2: ingreso
                    $cKardex->tipo_movimiento   = "INGRESO POR ANULACION DE VENTA";
                    $cKardex->nombre            = ""; #opcionales (para futuro desarrollo)
                    $cKardex->numdoc            = ""; #opcionales (para futuro desarrollo)
                    $cKardex->almacen           = $value->ALMAP_Codigo;
                    $cKardex->cliente           = $comprobante->CLIP_Codigo;
                    $cKardex->proveedor         = $comprobante->PROVP_Codigo;
                    $cKardex->usuario           = $comprobante->USUA_Codigo; #Nombre o codigo?
                    $cKardex->estado            = 0;
                    $this->registrar_kardex($cKardex);
                }
            }
            $filter->CPC_FlagEstado     = 0;
            $this->comprobante_model->modificar_comprobante($codigo, $filter);
        }
        return $done;
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
        $cKardex->MONED_Codigo          = $filter->moneda;
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
//FIN ANULACION

    
}

?>