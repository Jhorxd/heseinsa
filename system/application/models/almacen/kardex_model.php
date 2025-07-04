<?php

class kardex_Model extends Model {

    protected $_name = "cji_kardex";

    public function __construct() {

        parent::__construct();

        $this->load->database();

        $this->somevar['compania'] = $this->session->userdata('compania');
    }

    public function listar_by_codigo_documento($cod_doc, $tipo, $filter) {


        $this->db->join('cji_producto', 'cji_producto.PROD_Codigo=  cji_kardex.PROD_Codigo');

        $this->db->join('cji_documento', 'cji_documento.DOCUP_Codigo=cji_kardex.DOCUP_Codigo');
        if (isset($filter->producto) && $filter->producto != "")
            $this->db->where('cji_producto.PROD_CodigoUsuario', $filter->producto);
        

        /**gcbq agregamos por almacen***/
        $this->db->join('cji_inventario', 'cji_inventario.INVE_Codigo=cji_kardex.KARDC_CodigoDoc');
        if (isset($filter->codigoAlmacen) && $filter->codigoAlmacen != "")
            $this->db->where('cji_inventario.ALMAP_Codigo', $filter->codigoAlmacen);
        
        /*
          if (isset($filter->fechai) && $filter->fechai != "")
          $this->db->where('DATE_FORMAT(cji_kardex.KARD_Fecha,"%Y-%m-%d")  >=', $filter->fechai);

          if (isset($filter->fechaf) && $filter->fechaf != "")
          $this->db->where('DATE_FORMAT(cji_kardex.KARD_Fecha,"%Y-%m-%d") <', $filter->fechaf);
         */
        #$conpania=$this->somevar['compania'];
        #$this->db->where('cji_kardex.COMPP_Codigo',$conpania);
          $this->db->where('cji_kardex.DOCUP_Codigo', $cod_doc);
          $this->db->where('cji_kardex.KARDC_TipoIngreso', $tipo);
          $this->db->order_by('cji_kardex.KARDP_Codigo DESC');
          $query = $this->db->get('cji_kardex');

          if ($query->num_rows > 0) {

            return $query->result();
        }
    }

    public function listar($filter = NULL) {

        #$ultimo_inventario = $this->listar_by_codigo_documento(4, 3, $filter);

        #if (!$ultimo_inventario)
        #    return array();

        if(isset($filter->producto) || $filter->producto != "") {
            $producto_id = $filter->producto;
        }

        $this->db->select('cji_kardex.*,cji_documento.*,sum(cji_kardex.KARDC_Cantidad) as KARDC_Cantidad2');

        $this->db->from('cji_kardex');

        $this->db->join('cji_producto', 'cji_producto.PROD_Codigo=  cji_kardex.PROD_Codigo');

        $this->db->join('cji_documento', 'cji_documento.DOCUP_Codigo=cji_kardex.DOCUP_Codigo');

        $this->db->where('cji_kardex.COMPP_Codigo', $filter->compania);

        if (isset($producto_id) && $producto_id != "") {
            $this->db->where('cji_producto.PROD_CodigoUsuario', $producto_id);
        }


        ////desbloqueado stv
        if (isset($filter->fechai) && $filter->fechai != "")
          $this->db->where('DATE_FORMAT(cji_kardex.KARD_Fecha,"%Y-%m-%d")  >=', $filter->fechai);

      if (isset($filter->fechaf) && $filter->fechaf != "")
          $this->db->where('DATE_FORMAT(cji_kardex.KARD_Fecha,"%Y-%m-%d") <', $filter->fechaf);

        #$this->db->where('cji_kardex.KARDP_Codigo >=', $ultimo_inventario[0]->KARDP_Codigo);

      $this->db->group_by(array('cji_kardex.DOCUP_Codigo', 'cji_kardex.KARDC_CodigoDoc'));

      $this->db->order_by('cji_kardex.KARD_Fecha ASC');

      $query = $this->db->get();

      $wProducto = (isset($producto_id) && $producto_id != "") ? " AND p.PROD_CodigoUsuario LIKE '$producto_id'" : "";
      $wFecha = (isset($filter->fechai) && $filter->fechai != "" && isset($filter->fechaf) && $filter->fechaf != "") ? " AND k.KARD_Fecha BETWEEN '$filter->fechai 00:00:00' AND '$filter->fechaf 23:59:59' " : "";

        #$sql = "SELECT k.*, d.*, SUM(k.KARDC_Cantidad) as KARDC_Cantidad2
        #            FROM cji_kardex k
        #            INNER JOIN cji_producto p ON p.PROD_Codigo = k.PROD_Codigo
        #            INNER JOIN cji_documento d ON d.DOCUP_Codigo = k.DOCUP_Codigo
        #                WHERE k.COMPP_Codigo = $filter->compania $wProducto $wFecha
        #                GROUP BY k.DOCUP_Codigo, 
        #                ORDER BY k.KARD_Fecha ASC
        #        ";
        #$query = $this->db->query($sql);

      if ($query->num_rows > 0) {
        return $query->result();
    }
}

public function listarFIFO(stdClass $filter) {

    $producto_id = $filter->producto;

    $this->db->select('*');

    $this->db->from('cji_kardex');

    $this->db->join('cji_producto', 'cji_producto.PROD_Codigo=cji_kardex.PROD_Codigo');

    $this->db->join('cji_documento', 'cji_documento.DOCUP_Codigo=cji_kardex.DOCUP_Codigo');

    $this->db->where('cji_kardex.COMPP_Codigo', $this->somevar['compania']);

    if (isset($producto_id) && $producto_id != "")
        $this->db->where('cji_producto.PROD_Codigo', $producto_id);

    if (isset($filter->fechai) && $filter->fechai != "")
        $this->db->where('DATE_FORMAT(cji_kardex.KARD_Fecha,"%Y-%m-%d")  >=', $filter->fechai);

    if (isset($filter->fechaf) && $filter->fechaf != "")
        $this->db->where('DATE_FORMAT(cji_kardex.KARD_Fecha,"%Y-%m-%d") <', $filter->fechaf);

    $this->db->order_by('cji_kardex.KARDP_Codigo');

    $query = $this->db->get();

    if ($query->num_rows > 0) {

        return $query->result();
    }
}

public function listarLIFO(stdClass $filter) {

    $producto_id = $filter->producto;

    $this->db->select('cji_kardex.*,cji_documento.*');

    $this->db->from('cji_kardex');

    $this->db->join('cji_producto', 'cji_producto.PROD_Codigo=cji_kardex.PROD_Codigo');

    $this->db->join('cji_documento', 'cji_documento.DOCUP_Codigo=cji_kardex.DOCUP_Codigo');

    $this->db->where('cji_kardex.COMPP_Codigo', $this->somevar['compania']);

    if (isset($producto_id) && $producto_id != "")
        $this->db->where('cji_producto.PROD_Codigo', $producto_id);

    if (isset($filter->fechai) && $filter->fechai != "")
        $this->db->where('DATE_FORMAT(cji_kardex.KARD_Fecha,"%Y-%m-%d") >=', $filter->fechai);

    if (isset($filter->fechaf) && $filter->fechaf != "")
        $this->db->where('DATE_FORMAT(cji_kardex.KARD_Fecha,"%Y-%m-%d") <', $filter->fechaf);

    $this->db->order_by('cji_kardex.KARDP_Codigo');

    $query = $this->db->get();

    if ($query->num_rows > 0) {

        return $query->result();
    }
}

public function obtener($documento_id, $codigo_doc) {

    $where = array("COMPP_Codigo" => $this->somevar['compania'], "DOCUP_Codigo" => $documento_id, "KARDC_CodigoDoc" => $codigo_doc);

    $query = $this->db->where($where)->get('cji_kardex');

    if ($query->num_rows > 0) {

        return $query->result();
    }
}

public function obtener_stock($producto_id) {

    $where = array("COMPP_Codigo" => $this->somevar['compania'], "PROD_Codigo" => $producto_id);

    $query = $this->db->order_by('KARDP_Codigo', 'desc')->where($where)->get('cji_kardex', 1);

    if ($query->num_rows > 0) {

        return $query->result();
    }
}

public function obtener_registros_x_dcto($producto_id, $documento_id, $codigo_doc) {

    $where = array("COMPP_Codigo" => $this->somevar['compania'], "PROD_Codigo" => $producto_id, "DOCUP_Codigo" => $documento_id, "KARDC_CodigoDoc" => $codigo_doc);

    $query = $this->db->where($where)->get('cji_kardex');

    if ($query->num_rows > 0) {

        return $query->result();
    }
}

public function insertar($dcto_id, stdClass $filter = null) {

    $fecha = $filter->KARD_Fecha;
    $cantidad = $filter->KARDC_Cantidad;
    $producto = $filter->PROD_Codigo;
    $costo = $filter->KARDC_Costo;
    $lote = $filter->LOTP_Codigo;
    $codigoAlamcenProducto = $filter->ALMPROD_Codigo;

    if ($dcto_id == 5 || $dcto_id == '5') {

            $tipo = 1; //Ingreso

        } else if ($dcto_id == 6 || $dcto_id == 7 || $dcto_id == '6' || $dcto_id == '7') {

                $tipo = 2; //Salida 

            } else if ($dcto_id == 4 || $dcto_id == '4') {
            $tipo = 3; //Inventario
        }

        $data = array(
            "PROD_Codigo" => $producto,
            "DOCUP_Codigo" => $dcto_id,
            "TIPOMOVP_Codigo" => $filter->TIPOMOVP_Codigo,
            "KARDC_CodigoDoc" => $filter->KARDC_CodigoDoc,
            "KARDC_TipoIngreso" => $tipo,
            "KARD_Fecha" => $fecha,
            "KARDC_Cantidad" => $cantidad,
            "KARDC_Costo" => $costo,
            "COMPP_Codigo" => $this->somevar['compania'],
            "LOTP_Codigo" => $lote,
            "ALMPROD_Codigo"=>$codigoAlamcenProducto,
            "KARDP_FlagEstado"=>1
        );

        $result = $this->db->insert("cji_kardex", $data);
        return $result;
    }

    public function insertar_2015($dcto_id, stdClass $filter = null) {

        $fecha = $filter->KARD_Fecha;
        $cantidad = $filter->KARDC_Cantidad;
        $producto = $filter->PROD_Codigo;
        $costo = $filter->KARDC_Costo;

        //$lote = $filter->LOTP_Codigo;

        if ($dcto_id == 5) {

            $tipo = 1; //Ingreso

        } elseif ($dcto_id == 6 || $dcto_id == 7) {

            $tipo = 2; //Salida

        } elseif ($dcto_id == 4) {
            $tipo = 3; //Inventario
        }

        $data = array(
            "PROD_Codigo" => $producto,
            "DOCUP_Codigo" => $dcto_id,
            "TIPOMOVP_Codigo" => $filter->TIPOMOVP_Codigo,
            "KARDC_CodigoDoc" => $filter->KARDC_CodigoDoc,
            "KARDC_TipoIngreso" => $tipo,
            "KARD_Fecha" => $fecha,
            "KARDC_Cantidad" => $cantidad,
            "KARDC_Costo" => $costo,
            "COMPP_Codigo" => $this->somevar['compania']
        );

        $result = $this->db->insert("cji_kardex", $data);
        return $result;
    }

    public function insertar_dsnto($dcto_id, stdClass $filter = null) {

        $fecha = $filter->KARD_Fecha;

        $cantidad = $filter->KARDC_Cantidad;

        $producto = $filter->PROD_Codigo;

        $costo = $filter->KARDC_Costo;

        $lote = $filter->LOTP_Codigo;

        $tipo = 3; //Inventario
        

        $data = array(
            "PROD_Codigo" => $producto,
            "DOCUP_Codigo" => $dcto_id,
            "TIPOMOVP_Codigo" => $filter->TIPOMOVP_Codigo,
            "KARDC_CodigoDoc" => $filter->KARDC_CodigoDoc,
            "KARDC_TipoIngreso" => $tipo,
            "KARD_Fecha" => $fecha,
            "KARDC_Cantidad" => $cantidad,
            "KARDC_Costo" => $costo,
            "COMPP_Codigo" => $this->somevar['compania'],
            "LOTP_Codigo" => $lote
        );

        $result = $this->db->insert("cji_kardex", $data);
        return $result;
    }
    
    public function eliminar($documento_id, $codigo, $producto_id) {

        $where = array("COMPP_Codigo" => $this->somevar['compania'], "PROD_Codigo" => $producto_id, "DOCUP_Codigo" => $documento_id, "KARDC_CodigoDoc" => $codigo);

        $data = array(
            'KARDC_Cantidad' => 0
        );

        $this->db->where($where);

        $this->db->update('cji_kardex', $data);
    }



    ////aumentado stv

    public function obtener_comprobante_saling($saling,$tipo,$docum_tipo) {

        if($tipo=='S'){

            if($docum_tipo!=10){
                $query = $this->db->where('GUIASAP_Codigo', $saling)->get('cji_comprobante');
            }else{
               $query = $this->db->where('GUIASAP_Codigo', $saling)->get('cji_guiarem');
           }
       }
       if($tipo=='I'){
        if($docum_tipo!=10){
            $query = $this->db->where('GUIAINP_Codigo', $saling)->get('cji_comprobante');
        }else{
            $query = $this->db->where('GUIAINP_Codigo', $saling)->get('cji_guiarem');
        }
    }




    if ($query->num_rows > 0) {
        foreach ($query->result() as $fila) {
            $data[] = $fila;
        }
        return $data;
    }
}



public function obtener_guiatrans_saling($saling,$tipo) {

    if($tipo=='S'){
        $query = $this->db->where('GUIASAP_Codigo', $saling)->get('cji_guiatrans');
    }elseif($tipo=='I'){
        $query = $this->db->where('GUIAINP_Codigo', $saling)->get('cji_guiatrans');
    }
    if ($query->num_rows > 0) {
        foreach ($query->result() as $fila) {
            $data[] = $fila;
        }
        return $data;
    }
}

public function obtener_comprobante_guainp($codigoGUIinp) {
    $query = $this->db->where('GUIAINP_Codigo', $codigoGUIinp)->get('cji_comprobante');
    if ($query->num_rows > 0) {
        foreach ($query->result() as $fila) {
            $data[] = $fila;
        }
        return $data;
    }
}

public function obtener_tipo_cambio($fecha_ingreso_gr) {
    $query = $this->db->where('TIPCAMC_Fecha', $fecha_ingreso_gr)->get('cji_tipocambio');
    if ($query->num_rows > 0) {
        foreach ($query->result() as $fila) {
            $data[] = $fila;
        }
        return $data;
    }
}

public function verificarMovimiento($codKardex, $filter){
    $where = array("KARDP_Codigo" => $codKardex);
    $this->db->where($where);
    return $this->db->update('cji_kardex', $filter);
}


    ############################################################
    # function: obtiene_movimeintos_kardex
    # description: obtiene movimeintos de productos en tablas 
    #              transaccionales
    # author: Luis Valdés      
    ############################################################
    public function consultar_kardex($filter='')
    {
        $compania = $this->somevar['compania'];
        $where = '';

        
        if (isset($filter->producto) && $filter->producto != ''){
            $where      .= " AND k.PROD_Codigo = $filter->producto";
        }

        if (isset($filter->almacen) && $filter->almacen != ''){
            $where      .= " AND k.ALMPROD_Codigo = $filter->almacen";
        }

        if (isset($filter->fechai) && $filter->fechai != ''){
            $fechaf      = (isset($filter->fechaf) && $filter->fechaf != '') ? $filter->fechaf : date("Y-m-d");
            $where      .= " AND k.KARD_Fecha BETWEEN '$filter->fechai 00:00:00' AND '$fechaf 23:59:59'";
        }


        //Si se toma en cuenta el conteo a partir de un ajuste
        if ($filter->ult_inventario == 0) {
           
            $code_max  = "SELECT MAX(k.KARDP_Codigo) as maximo FROM cji_kardex k WHERE k.DOCUP_Codigo = 'A' AND k.TIPOMOVP_Codigo = '1' $where";
            $code_maxi = "SELECT MAX(k.KARDP_Codigo) as maximo FROM cji_kardex k WHERE k.DOCUP_Codigo = 'I' $where";
            
            $query_FM   = $this->db->query($code_max);
            $query_FM_i = $this->db->query($code_maxi);
            
            if ($query_FM->num_rows() > 0 || $query_FM_i->num_rows()>0) {
                //var_dump($query_FM->num_rows());
                //var_dump($query_FM_i->num_rows());
                //exit();
                $fecha_macima   = $query_FM->result();
                $fecha_macima_i = $query_FM_i->result();
                $fecha_maxima_a = $fecha_macima[0]->maximo;
                $fecha_maxima_i = $fecha_macima_i[0]->maximo;
                
                //Se toma en cuenta el ultimo reemplazo en los almacenes (ajuste o ingreso de inventario)
                if ($fecha_maxima_a > $fecha_maxima_i) {
                    $fecha_maxima = $fecha_maxima_a;
                }else{
                    $fecha_maxima = $fecha_maxima_i;
                }

                if ($fecha_maxima) {
                    $where .= " AND k.KARDP_Codigo >= $fecha_maxima";
                }
                
            }
        }

        $sql="DROP TABLE IF EXISTS kardex";
        $query = $this->db->query($sql);

        $sql_comprobantes = "SELECT 
        k.ALMPROD_Codigo        AS almacen,
        k.KARD_Fecha            AS fecha,
        k.KARDC_CodigoDoc       AS codigo_docu,
        k.DOCUP_Codigo          AS tipo_docu,
        k.PROD_Codigo           AS codigo,
        m.MONED_Simbolo         AS moneda,
        k.KARDC_Cantidad        AS cantidad,
        k.KARDC_Serie           AS serie,
        k.KARDC_Numero          AS numero,
        al.ALMAC_Descripcion    AS nombre_almacen,
        k.KARDC_Total           AS total,
        k.KARDC_PrecioConIgv    AS pu_conIgv,
        k.KARDC_Subtotal        AS subtotal, 
        k.TIPOMOVP_Codigo       AS tipo_mov,
        k.KARDC_TipoIngreso     AS tipo_des,
        k.KARDP_FlagEstado      AS estado,

        (SELECT CONCAT_WS(' ', e.EMPRC_RazonSocial, p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno)
        FROM cji_cliente cc
        LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = cc.EMPRP_Codigo
        LEFT JOIN cji_persona p ON p.PERSP_Codigo = cc.PERSP_Codigo
        WHERE cc.CLIP_Codigo = k.CLIP_Codigo
        ) as razon_social_cliente,

        (SELECT CONCAT_WS(' ', e.EMPRC_RazonSocial, p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno)
        FROM cji_proveedor pp
        LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = pp.EMPRP_Codigo
        LEFT JOIN cji_persona p ON p.PERSP_Codigo = pp.PERSP_Codigo
        WHERE pp.PROVP_Codigo = k.PROVP_Codigo
        ) as razon_social_proveedor

        FROM cji_kardex k 
        LEFT JOIN cji_almacen al ON al.ALMAP_Codigo=k.ALMPROD_Codigo
        LEFT JOIN cji_moneda m ON m.MONED_Codigo=k.MONED_Codigo
        WHERE k.COMPP_Codigo = $compania $where ORDER BY k.KARD_Fecha ASC";

        // var_dump($sql_comprobantes);

        $query_transferencias = $this->db->query($sql_comprobantes);
        
        if ($query_transferencias->num_rows() > 0) {
            return $query_transferencias->result();
        }
        else{
            return array();
        }

    }

    public function consultar_kardexSunat($filter='')
    {
        // var_dump($filter); exit;
        $compania = $this->somevar['compania'];
        $where = '';

        
        if (isset($filter->producto) && $filter->producto != ''){
            $where      .= " AND k.PROD_Codigo = $filter->producto";
        }

        if (isset($filter->almacen) && $filter->almacen != ''){
            $where      .= " AND k.ALMPROD_Codigo = $filter->almacen";
        }

        if (isset($filter->mesKSunat) && $filter->mesKSunat != ''){
            $filter->mesKSunat = isset($filter->mesKSunat) ? $filter->mesKSunat : date('m');
            $where      .= " AND MONTH(k.KARD_Fecha) = $filter->mesKSunat";
        }


        //Si se toma en cuenta el conteo a partir de un ajuste
        if ($filter->ult_inventario == 0) {
           
            $code_max  = "SELECT MAX(k.KARDP_Codigo) as maximo FROM cji_kardex k WHERE k.DOCUP_Codigo = 'A' AND k.TIPOMOVP_Codigo = '1' $where";
            $code_maxi = "SELECT MAX(k.KARDP_Codigo) as maximo FROM cji_kardex k WHERE k.DOCUP_Codigo = 'I' $where";
            
            $query_FM   = $this->db->query($code_max);
            $query_FM_i = $this->db->query($code_maxi);
            
            if ($query_FM->num_rows() > 0 || $query_FM_i->num_rows()>0) {
                //var_dump($query_FM->num_rows());
                //var_dump($query_FM_i->num_rows());
                //exit();
                $fecha_macima   = $query_FM->result();
                $fecha_macima_i = $query_FM_i->result();
                $fecha_maxima_a = $fecha_macima[0]->maximo;
                $fecha_maxima_i = $fecha_macima_i[0]->maximo;
                
                //Se toma en cuenta el ultimo reemplazo en los almacenes (ajuste o ingreso de inventario)
                if ($fecha_maxima_a > $fecha_maxima_i) {
                    $fecha_maxima = $fecha_maxima_a;
                }else{
                    $fecha_maxima = $fecha_maxima_i;
                }

                if ($fecha_maxima) {
                    $where .= " AND k.KARDP_Codigo >= $fecha_maxima";
                }
                
            }
        }

        $sql="DROP TABLE IF EXISTS kardex";
        $query = $this->db->query($sql);

        $sql_comprobantes = "SELECT 
        k.ALMPROD_Codigo        AS almacen,
        k.KARD_Fecha            AS fecha,
        k.KARDC_CodigoDoc       AS codigo_docu,
        k.DOCUP_Codigo          AS tipo_docu,
        k.PROD_Codigo           AS codigo,
        m.MONED_Simbolo         AS moneda,
        k.KARDC_Cantidad        AS cantidad,
        k.KARDC_Serie           AS serie,
        k.KARDC_Numero          AS numero,
        al.ALMAC_Descripcion    AS nombre_almacen,
        k.KARDC_Total           AS total,
        k.KARDC_Costo           AS pu_sinIgv,
        k.KARDC_PrecioConIgv    AS pu_conIgv,
        k.KARDC_Subtotal        AS subtotal, 
        k.TIPOMOVP_Codigo       AS tipo_mov,
        k.KARDC_TipoIngreso     AS tipo_des,
        k.KARDP_FlagEstado      AS estado,

        (SELECT CONCAT_WS(' ', e.EMPRC_RazonSocial, p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno)
        FROM cji_cliente cc
        LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = cc.EMPRP_Codigo
        LEFT JOIN cji_persona p ON p.PERSP_Codigo = cc.PERSP_Codigo
        WHERE cc.CLIP_Codigo = k.CLIP_Codigo
        ) as razon_social_cliente,

        (SELECT CONCAT_WS(' ', e.EMPRC_RazonSocial, p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno)
        FROM cji_proveedor pp
        LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = pp.EMPRP_Codigo
        LEFT JOIN cji_persona p ON p.PERSP_Codigo = pp.PERSP_Codigo
        WHERE pp.PROVP_Codigo = k.PROVP_Codigo
        ) as razon_social_proveedor

        FROM cji_kardex k 
        LEFT JOIN cji_almacen al ON al.ALMAP_Codigo=k.ALMPROD_Codigo
        LEFT JOIN cji_moneda m ON m.MONED_Codigo=k.MONED_Codigo
        WHERE k.COMPP_Codigo = $compania $where ORDER BY k.KARD_Fecha ASC";

        // var_dump($sql_comprobantes); exit;

        $query_transferencias = $this->db->query($sql_comprobantes);
        
        if ($query_transferencias->num_rows() > 0) {
            return $query_transferencias->result();
        }
        else{
            return array();
        }

    }

    public function consultar_kardexSunatFinalMes($filter='')
    {
        // var_dump($filter); exit;
        $compania = $this->somevar['compania'];
        $where = '';

        
        if (isset($filter->producto) && $filter->producto != ''){
            $where      .= " AND k.PROD_Codigo = $filter->producto";
        }

        if (isset($filter->almacen) && $filter->almacen != ''){
            $where      .= " AND k.ALMPROD_Codigo = $filter->almacen";
        }

        if (isset($filter->mesKSunat) && $filter->mesKSunat != ''){
            $filter->mesKSunat = isset($filter->mesKSunat) ? $filter->mesKSunat : date('m');
            $where      .= " AND MONTH(k.KARD_Fecha) < $filter->mesKSunat";
        }


        //Si se toma en cuenta el conteo a partir de un ajuste
        if ($filter->ult_inventario == 0) {
           
            $code_max  = "SELECT MAX(k.KARDP_Codigo) as maximo FROM cji_kardex k WHERE k.DOCUP_Codigo = 'A' AND k.TIPOMOVP_Codigo = '1' $where";
            $code_maxi = "SELECT MAX(k.KARDP_Codigo) as maximo FROM cji_kardex k WHERE k.DOCUP_Codigo = 'I' $where";
            
            $query_FM   = $this->db->query($code_max);
            $query_FM_i = $this->db->query($code_maxi);
            
            if ($query_FM->num_rows() > 0 || $query_FM_i->num_rows()>0) {
                //var_dump($query_FM->num_rows());
                //var_dump($query_FM_i->num_rows());
                //exit();
                $fecha_macima   = $query_FM->result();
                $fecha_macima_i = $query_FM_i->result();
                $fecha_maxima_a = $fecha_macima[0]->maximo;
                $fecha_maxima_i = $fecha_macima_i[0]->maximo;
                
                //Se toma en cuenta el ultimo reemplazo en los almacenes (ajuste o ingreso de inventario)
                if ($fecha_maxima_a > $fecha_maxima_i) {
                    $fecha_maxima = $fecha_maxima_a;
                }else{
                    $fecha_maxima = $fecha_maxima_i;
                }

                if ($fecha_maxima) {
                    $where .= " AND k.KARDP_Codigo >= $fecha_maxima";
                }
                
            }
        }

        $sql="DROP TABLE IF EXISTS kardex";
        $query = $this->db->query($sql);

        $sql_comprobantes = "SELECT 
        k.ALMPROD_Codigo        AS almacen,
        k.KARD_Fecha            AS fecha,
        k.KARDC_CodigoDoc       AS codigo_docu,
        k.DOCUP_Codigo          AS tipo_docu,
        k.PROD_Codigo           AS codigo,
        m.MONED_Simbolo         AS moneda,
        k.KARDC_Cantidad        AS cantidad,
        k.KARDC_Serie           AS serie,
        k.KARDC_Numero          AS numero,
        al.ALMAC_Descripcion    AS nombre_almacen,
        k.KARDC_Total           AS total,
        k.KARDC_Costo           AS pu_sinIgv,
        k.KARDC_PrecioConIgv    AS pu_conIgv,
        k.KARDC_Subtotal        AS subtotal, 
        k.TIPOMOVP_Codigo       AS tipo_mov,
        k.KARDC_TipoIngreso     AS tipo_des,
        k.KARDP_FlagEstado      AS estado,

        (SELECT CONCAT_WS(' ', e.EMPRC_RazonSocial, p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno)
        FROM cji_cliente cc
        LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = cc.EMPRP_Codigo
        LEFT JOIN cji_persona p ON p.PERSP_Codigo = cc.PERSP_Codigo
        WHERE cc.CLIP_Codigo = k.CLIP_Codigo
        ) as razon_social_cliente,

        (SELECT CONCAT_WS(' ', e.EMPRC_RazonSocial, p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno)
        FROM cji_proveedor pp
        LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = pp.EMPRP_Codigo
        LEFT JOIN cji_persona p ON p.PERSP_Codigo = pp.PERSP_Codigo
        WHERE pp.PROVP_Codigo = k.PROVP_Codigo
        ) as razon_social_proveedor

        FROM cji_kardex k 
        LEFT JOIN cji_almacen al ON al.ALMAP_Codigo=k.ALMPROD_Codigo
        LEFT JOIN cji_moneda m ON m.MONED_Codigo=k.MONED_Codigo
        WHERE k.COMPP_Codigo = $compania $where ORDER BY k.KARD_Fecha ASC";

        // var_dump($sql_comprobantes); exit;

        $query_transferencias = $this->db->query($sql_comprobantes);
        
        if ($query_transferencias->num_rows() > 0) {
            return $query_transferencias->result();
        }
        else{
            return array();
        }

    }

    public function atualizar_sctock($id,$prod, $filter)
    {
        $where = array("ALMAC_Codigo" => $id,"PROD_Codigo"=>$prod);
        $this->db->where($where);
        
        return $this->db->update('cji_almacenproducto', $filter);
    }

    public function registrar_kardex($filter)
    {   
        if(isset($filter->isNotExistStore)){
            $fechaActual = date("Y-m-d H:i:s");

            $fechaActual = strtotime('-2 second', strtotime($fechaActual));
            
            $fechaActual = date("Y-m-d H:i:s",$fechaActual);

            unset($filter->isNotExistStore);
        }else{
            $fechaActual = date("Y-m-d H:i:s");
        }

        $filter->KARD_Fecha = $fechaActual;
        $this->db->insert("cji_kardex", (array) $filter);
        $kardex_id = $this->db->insert_id();
        return $kardex_id;
    }

    public function ingresar_kardex($filter)
    {   
        //$filter->KARD_Fecha = date('Y-m-d H:i:s');
        $this->db->insert("cji_kardex", (array) $filter);
        $kardex_id = $this->db->insert_id();
        return $kardex_id;
    }

    public function para_el_kardex($filter='')
    {
        $compania = $this->somevar['compania'];
        $limit      = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";

        $where      = '';
        $where_2    = '';
        $where_3    = '';
        $where_ajuste    = '';

        if (isset($filter->producto) && $filter->producto != ''){

        $where      .= " AND cd.PROD_Codigo = $filter->producto";
        $where_2    .= " AND gd.PROD_Codigo = $filter->producto";
        $where_3    .= " AND id.PROD_Codigo = $filter->producto";
        $where_4    .= " AND nd.PROD_Codigo = $filter->producto";
        $where_ajuste    .= " AND iad.PROD_Codigo = $filter->producto";
        }

        if (isset($filter->almacen) && $filter->almacen != ''){

        $where      .= " AND cd.ALMAP_Codigo = $filter->almacen";
        $where_2    .= " AND (g.GTRANC_AlmacenOrigen = $filter->almacen OR g.GTRANC_AlmacenDestino = $filter->almacen)";
        $where_3    .= " AND i.ALMAP_Codigo = $filter->almacen";
        $where_ajuste    .= " AND ia.ALMAP_Codigo = $filter->almacen";

        }

        if (isset($filter->fechai) && $filter->fechai != ''){
            $fechaf      = (isset($filter->fechaf) && $filter->fechaf != '') ? $filter->fechaf : date("Y-m-d");
            $where      .= " AND c.CPC_Fecha BETWEEN '$filter->fechai 00:00:00' AND '$fechaf 23:59:59'";
            $where_2    .= " AND g.GTRANC_Fecha BETWEEN '$filter->fechai 00:00:00' AND '$fechaf 23:59:59'";
            $where_3    .= " AND id.INVD_FechaRegistro BETWEEN '$filter->fechai 00:00:00' AND '$fechaf 23:59:59'";
            $where_4    .= " AND n.CRED_Fecha BETWEEN '$filter->fechai 00:00:00' AND '$fechaf 23:59:59'";
            $where_ajuste .= " AND iad.INVADET_FechaRegistro BETWEEN '$filter->fechai 00:00:00' AND '$fechaf 23:59:59'";
        }

        if ($filter->ult_inventario==6) {

            $fecha_max="SELECT MAX(a.INVA_FechaRegistro) as fecha_maxima FROM cji_inventarioajuste a LEFT JOIN cji_inventarioajustedetalle ad ON ad.INVA_Codigo=a.INVA_Codigo WHERE ad.PROD_Codigo=$filter->producto AND a.ALMAP_Codigo=$filter->almacen AND a.INVA_TipoMovimiento=1";
            $query_FM = $this->db->query($fecha_max);

            if ($query_FM->num_rows > 0) {
                $fecha_macima = $query_FM->result();
                $fecha_maxima = $fecha_macima[0]->fecha_maxima;
                $where      .= " AND cd.CPDEC_FechaRegistro >= '$fecha_maxima'";
                $where_2    .= " AND g.GTRANC_FechaRegistro >= '$fecha_maxima'";
                $where_3    .= " AND id.INVD_FechaRegistro >= '$fecha_maxima'";
                $where_4    .= " AND n.CRED_FechaRegistro >= '$fecha_maxima'";
                $where_ajuste .= " AND ia.INVA_FechaRegistro >= '$fecha_maxima'";
            }
        }

        $sql="DROP TABLE IF EXISTS kardex";
        $query = $this->db->query($sql);

        $sql_comprobantes = "CREATE TEMPORARY TABLE kardex
        SELECT 
        cd.ALMAP_Codigo         AS almacen,
        cd.CPDEC_FechaRegistro  AS fecha, 
        c.CPP_Codigo            AS codigo_docu, 
        cd.PROD_Codigo          AS codigo, 
        cd.CPDEC_Cantidad       AS cantidad, 
        c.CPC_Numero            AS numero, 
        c.CPC_Serie             AS serie, 
        al.ALMAC_Descripcion    AS nombre_almacen,
        cd.CPDEC_Total          AS total, 
        cd.CPDEC_Pu_ConIgv      AS pu_conIgv, 
        cd.CPDEC_Subtotal       AS subtotal, 
        c.CPC_TipoOperacion     AS tipo_oper,
        p.PROD_UltimoCosto      AS costo,
        c.CPC_FlagEstado        AS estado,
        c.CPC_TipoDocumento     AS tipo_docu,
        c.CLIP_Codigo           as razon_social_cliente,
        c.PROVP_Codigo          as razon_social_proveedor

        FROM cji_comprobantedetalle cd 
        LEFT JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo
        LEFT JOIN cji_almacen al ON cd.ALMAP_Codigo = al.ALMAP_Codigo
        LEFT JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
        WHERE cd.CPDEC_FlagEstado=1 and c.CPC_FlagEstado IN(1,2) AND c.CPP_Codigo_Canje = 0 and c.CPC_TipoDocumento!='I' AND c.COMPP_Codigo = $compania $where 
        UNION
        SELECT 
        g.GTRANC_AlmacenOrigen  AS almacen, 
        g.GTRANC_FechaRegistro  AS fecha, 
        g.GTRANP_Codigo         AS codigo_docu, 
        gd.PROD_Codigo          AS codigo, 
        gd.GTRANDETC_Cantidad   AS cantidad, 
        g.GTRANC_Numero         AS numero, 
        g.GTRANC_Serie          AS serie, 
        al.ALMAC_Descripcion    AS nombre_almacen,
        NULL                    AS total, 
        NULL                    AS pu_conIgv, 
        NULL                    AS subtotal, 
        'T'                     AS tipo_oper,
        NULL                    AS costo,
        g.GTRANC_EstadoTrans    AS estado,
        'T'                     AS tipo_docu,
        NULL AS razon_social_cliente,
        NULL AS razon_social_proveedor
        FROM cji_guiatransdetalle gd 
        LEFT JOIN cji_guiatrans g ON gd.GTRANP_Codigo = g.GTRANP_Codigo
        LEFT JOIN cji_almacen al ON g.GTRANC_AlmacenOrigen  = al.ALMAP_Codigo
        WHERE gd.GTRANDETC_FlagEstado!=0  AND g.GTRANC_FlagEstado!=0 AND g.GTRANC_EstadoTrans ='2'  $where_2

        UNION
        SELECT 
        i.ALMAP_Codigo          AS almacen, 
        id.INVD_FechaRegistro   AS fecha, 
        null                    AS codigo_docu, 
        id.PROD_Codigo          AS codigo, 

        id.INVD_Cantidad        AS cantidad, 
        i.INVE_Numero           AS numero, 
        i.INVE_Serie            AS serie, 
        al.ALMAC_Descripcion    AS nombre_almacen,
        NULL                    AS total, 
        NULL                    AS pu_conIgv, 
        NULL                    AS subtotal, 
        'I'                     AS tipo_oper,
        NULL                    AS costo,
        NULL                    AS estado,
        'I'                     AS tipo_docu,
        NULL AS razon_social_cliente,
        NULL AS razon_social_proveedor
        FROM cji_inventariodetalle id 
        LEFT JOIN cji_inventario i ON id.INVE_Codigo = i.INVE_Codigo
        LEFT JOIN cji_almacen al ON i.ALMAP_Codigo  = al.ALMAP_Codigo
        WHERE id.INVD_FlagActivacion!=0 AND i.COMPP_Codigo = $compania $where_3

        UNION
        SELECT 
        ia.ALMAP_Codigo             AS almacen, 
        ia.INVA_FechaRegistro       AS fecha, 
        ia.INVA_TipoMovimiento      AS codigo_docu, 
        iad.PROD_Codigo             AS codigo, 

        iad.INVADET_StockAjuste     AS cantidad, 
        ia.INVA_Numero              AS numero, 
        ia.INVA_Serie               AS serie, 
        almac.ALMAC_Descripcion     AS nombre_almacen,
        NULL                        AS total, 
        NULL                        AS pu_conIgv, 
        NULL                        AS subtotal, 
        'A'                         AS tipo_oper,
        NULL                        AS costo,
        NULL                        AS estado,
        'A'                     AS tipo_docu,
        NULL AS razon_social_cliente,
        NULL AS razon_social_proveedor
        FROM cji_inventarioajustedetalle iad
        LEFT JOIN cji_inventarioajuste ia ON iad.INVA_Codigo = ia.INVA_Codigo
        LEFT JOIN cji_almacen almac ON ia.ALMAP_Codigo  = almac.ALMAP_Codigo
        WHERE ia.INVA_FlagEstado=1 AND iad.INVADET_FlagEstado=1 AND ia.COMPP_Codigo = $compania $where_ajuste


        UNION
        SELECT 
        n.ALMAP_Codigo          AS almacen, 
        n.CRED_FechaRegistro    AS fecha, 
        n.CRED_Codigo           AS codigo_docu, 
        nd.PROD_Codigo          AS codigo, 
        nd.CREDET_Cantidad      AS cantidad, 
        n.CRED_numero           AS numero, 
        n.CRED_Serie            AS serie, 
        al.ALMAC_Descripcion    AS nombre_almacen,
        nd.CREDET_Total         AS total, 
        NULL                    AS pu_conIgv, 
        nd.CREDET_Subtotal      AS subtotal, 
        'N'                     AS tipo_oper,
        NULL                    AS costo,
        CRED_FlagEstado         AS estado,
        'NC'                     AS tipo_docu,
        n.CLIP_Codigo as razon_social_cliente,

        n.PROVP_Codigo as razon_social_proveedor

        FROM cji_notadetalle nd 
        LEFT JOIN cji_nota n ON nd.CRED_Codigo = n.CRED_Codigo
        LEFT JOIN cji_almacen al ON n.ALMAP_Codigo  = al.ALMAP_Codigo
        WHERE n.CRED_FlagEstado=1 AND nd.CREDET_FlagEstado=1 AND n.COMPP_Codigo = $compania AND n.DOCUP_Codigo IN (1,2,6,7) $where_4";


        $query_comprobantes = $this->db->query($sql_comprobantes);

        $sql_transferencias = "SELECT * FROM kardex order by fecha ASC";

        $query_transferencias = $this->db->query($sql_transferencias);

        $data = array();



        if ($query_transferencias->num_rows > 0) {
        return $query_transferencias->result();
        }
        else{
        return array();
        }

    }
}

?>