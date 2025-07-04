<?php

class Almacenproducto_Model extends Model {

    protected $_name = "cji_almacenproducto";
    private $compania;

    public function __construct() {
        parent::__construct();
        $this->load->model('almacen/producto_model');
        $this->compania = $this->session->userdata('compania');
    }

    public function listar_original($search = "", $modelo = "",  $number_items = '', $offset = '') {
        $where = "";
        
        if ( $search != "" && strlen($search) < 4 )
            $where = " AND (p.PROD_Nombre LIKE '%$search%' OR p.PROD_CodigoUsuario LIKE '%search%') ";
        else
            if ( $search != "" && strlen($search) >= 4 )
                $where = " AND Match(p.PROD_Nombre, p.PROD_CodigoUsuario) AGAINST ('$search') ";

        if ($modelo != "")
            $where .= " AND p.PROD_Modelo LIKE '$modelo' ";

            $limit = ($number_items != "" && $offset != "") ? " LIMIT $offset, $number_items" : "";

        $sql = "SELECT almp.ALMPROD_Codigo, almp.ALMPROD_Stock, almp.COMPP_Codigo, al.ALMAP_Codigo, almp.ALMAC_Codigo, al.ALMAC_Descripcion, al.ALMAC_Direccion, al.EESTABP_Codigo, p.PROD_Codigo, p.PROD_Nombre, p.PROD_FlagBienServicio, p.PROD_StockMinimo, p.PROD_StockMaximo, p.PROD_CodigoInterno, p.PROD_CodigoUsuario, p.PROD_CodigoOriginal, p.PROD_Modelo, p.PROD_GenericoIndividual, p.PROD_FlagEstado, p.AFECT_Codigo, ta.AFECT_Descripcion, m.MARCP_Codigo, m.MARCC_CodigoUsuario, m.MARCC_Descripcion, p.FAMI_Codigo, f.FAMI_Descripcion
                    FROM cji_almacenproducto almp
                    INNER JOIN cji_almacen al ON al.ALMAP_Codigo = almp.ALMAC_Codigo
                    INNER JOIN cji_producto p ON p.PROD_Codigo = almp.PROD_Codigo
                    LEFT JOIN cji_marca m ON m.MARCP_Codigo = p.MARCP_Codigo
                    INNER JOIN cji_tipo_afectacion ta ON ta.AFECT_Codigo = p.AFECT_Codigo
                    LEFT JOIN cji_familia f ON f.FAMI_Codigo = p.FAMI_Codigo
                    LEFT JOIN cji_fabricante fb ON fb.FABRIP_Codigo = p.FABRIP_Codigo
                    WHERE al.COMPP_Codigo = ".$this->compania." AND p.PROD_FlagEstado = 1
                    $where
                    ORDER BY p.PROD_Nombre, almp.ALMAC_Codigo
                    $limit
                ";
        $query = $this->db->query($sql);

        if ($query->num_rows > 0) {
            return $query->result();
        }
        else
            return NULL;
    }
    
     public function insertar_mov($info){
      
        $this->db->insert("cji_movimiento_item", (array) $info);
        return $this->db->insert_id();
    }

    public function actualizar_mov($id_prodcuto, $info){
        $this->db->where('movI_Codigo',$id_prodcuto);
            return $this->db->update('cji_movimiento_item', $info);
    }

    public function getTable($filter = null) {
        $this->db->select("*");
        $this->db->from("cji_movimiento_item");
        $this->db->order_by('movI_Codigo','DESC');
        
        if (isset($filter->producto) && $filter->producto !== '') {
            $this->db->like('PROD_Codigo', $filter->producto);
        }
    
        if (isset($filter->fechai) && $filter->fechai !== '' && isset($filter->fechaf) && $filter->fechaf !== '') {
            $this->db->where('movI_Fecha >=', $filter->fechai);
            $this->db->where('movI_Fecha <=', $filter->fechaf);
        }
    
        // Aplicar orden y límite
        /*  if (isset($filter->order) && isset($filter->dir)) {
            $this->db->order_by($filter->order, $filter->dir);
        } */
    
        if (isset($filter->length) && isset($filter->start)) {
            $this->db->limit($filter->length, $filter->start);
        }
        $query = $this->db->get();
       
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }

        
    }

    public function getMercaderiaEdit($id) {

        $this->db->select("*");
        $this->db->from("cji_movimiento_item");
        $this->db->where('movI_Codigo', $id);
        
        if ($filter->length !== null && $filter->start !== null) {
            $this->db->limit($filter->length, $filter->start);
        }
        $query = $this->db->get();
       
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }

        
    }

    public function getMercaderia($filter = null) {

        $where = '';
        if (isset($filter->fechai) && $filter->fechai != ''){
            $fechaf = (isset($filter->fechaf) && $filter->fechaf != '') ? $filter->fechaf : date("Y-m-d");
            $where .= "movI_Fecha BETWEEN '$filter->fechai' AND '$fechaf'";
        }

        $this->db->select("*");
        $this->db->from("cji_movimiento_item");
        $this->db->where($where);

        
        if ($filter->length !== null && $filter->start !== null) {
            $this->db->limit($filter->length, $filter->start);
        }
        $query = $this->db->get();
       
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }

        
    }

    public function productos_sistema_mov($id){
        
        $sql = "SELECT p.*
                    FROM cji_producto p
                    WHERE p.PROD_FlagEstado = 1 AND p.PROD_codigo = $id
                ";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        else
            return NULL;
    }

    public function listar($filter = NULL) {

        $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
        $order = ( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

        $where = "";

        if ( isset($filter->search) && $filter->search != "" && strlen($filter->search) >= 19)
            $where .= " AND Match(p.PROD_Nombre, p.PROD_CodigoUsuario) AGAINST ('$filter->search') ";
        

        /*
        #búsqueda de articulos actualizada para buscar palabras
        $match="";
        $string = preg_split(" ", $filter->searchProducto);
        foreach ($string as $key => $value) {
            if($value!=" " && $value!="+" && $value!="-" && strlen($value)>=3)
             $match.=" +(".$value.")";//busqueda de la palabra como grupo +(palabra)
        }
        
        if ( strlen($filter->searchProducto) < 20 )
            $where .= " AND (p.PROD_Nombre LIKE '%$filter->searchProducto%' OR p.PROD_CodigoUsuario LIKE '%$filter->searchProducto%') "; 
        else
            $where .= ' AND MATCH(p.PROD_Nombre,p.PROD_CodigoUsuario) AGAINST ("'.$match.'" IN BOOLEAN MODE)';
        */
            
        if ( isset($filter->searchProducto) && $filter->searchProducto != "" && strlen($filter->searchProducto) > 2 )
            $where .= " AND CONCAT_WS(' ', p.PROD_Nombre, p.PROD_CodigoUsuario) LIKE '%$filter->searchProducto%'";

        if ( isset($filter->searchModelo) && $filter->searchModelo != "")
            $where .= " AND p.PROD_Modelo LIKE '$filter->searchModelo' ";

        if ( isset($filter->searchMarca) && $filter->searchMarca != "")
            $where .= " AND m.MARCP_Codigo = '$filter->searchMarca' ";

        if ( isset($filter->searchCodigoUsuario) && trim($filter->searchCodigoUsuario) != "")
            $where .= " AND p.PROD_CodigoUsuario LIKE '$filter->searchCodigoUsuario' ";

        if ( isset($filter->searchModelo) && trim($filter->searchModelo) != "")
            $where .= " AND p.PROD_Modelo LIKE '$filter->searchModelo' ";

        if ( isset($filter->searchFamilia) && trim($filter->searchFamilia) != "")
            $where .= " AND p.FAMI_Codigo = '$filter->searchFamilia' ";
        
        if ( isset($filter->almacen) && $filter->almacen != "")
            $where .= " AND al.ALMAP_Codigo = '$filter->almacen' ";

        //var_dump($where);exit();

        $sql = "SELECT almp.ALMPROD_Codigo, almp.ALMPROD_Stock, almp.COMPP_Codigo, al.ALMAP_Codigo, almp.ALMAC_Codigo, al.ALMAC_Descripcion, al.ALMAC_Direccion, al.EESTABP_Codigo, p.PROD_Codigo, p.PROD_Nombre, p.PROD_FlagBienServicio, p.PROD_StockMinimo, p.PROD_StockMaximo, p.PROD_CodigoInterno, p.PROD_CodigoUsuario, p.PROD_CodigoOriginal, p.PROD_Modelo, p.PROD_GenericoIndividual, p.PROD_FlagEstado, p.AFECT_Codigo, p.PROD_UltimoCosto, ta.AFECT_Descripcion, m.MARCP_Codigo, m.MARCC_CodigoUsuario, m.MARCC_Descripcion, p.FAMI_Codigo, f.FAMI_Descripcion, fb.FABRIC_Descripcion, CONCAT_WS(' - ', um.UNDMED_Simbolo, um.UNDMED_Descripcion) as UNDMED_Simbolo
                    FROM cji_almacenproducto almp
                    INNER JOIN cji_almacen al ON al.ALMAP_Codigo = almp.ALMAC_Codigo
                    INNER JOIN cji_producto p ON p.PROD_Codigo = almp.PROD_Codigo
                    LEFT JOIN cji_marca m ON m.MARCP_Codigo = p.MARCP_Codigo
                    LEFT JOIN cji_productounidad pu ON pu.PROD_Codigo = p.PROD_Codigo
                    LEFT JOIN cji_unidadmedida um ON um.UNDMED_Codigo = pu.UNDMED_Codigo
                    LEFT JOIN cji_tipo_afectacion ta ON ta.AFECT_Codigo = p.AFECT_Codigo
                    LEFT JOIN cji_familia f ON f.FAMI_Codigo = p.FAMI_Codigo
                    LEFT JOIN cji_fabricante fb ON fb.FABRIP_Codigo = p.FABRIP_Codigo
                    WHERE p.PROD_FlagBienServicio='B' AND al.COMPP_Codigo = ".$this->compania." AND p.PROD_FlagEstado = 1
                    $where
                    $order
                    $limit
                ";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        else
            return NULL;
    }

    public function listar_general($filter = NULL) {

        $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
        $order = ( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

        $where = "";

        if ( isset($filter->searchCodigo) && $filter->searchCodigo != "" )
            $where .= " AND p.PROD_CodigoUsuario LIKE '%$filter->searchCodigo%' ";

        if ( isset($filter->searchNombre) && $filter->searchNombre != "" )
            $where .= " AND p.PROD_Nombre LIKE '%$filter->searchNombre%' ";

        if ( isset($filter->searchModelo) && $filter->searchModelo != "")
            $where .= " AND p.PROD_Modelo LIKE '$filter->searchModelo' ";

        if ( isset($filter->searchFlagBS) && $filter->searchFlagBS != "")
            $where .= " AND p.PROD_FlagBienServicio LIKE '$filter->searchFlagBS' ";

        $sql = "SELECT p.*, pc.COMPP_Codigo
                    FROM cji_producto p
                    INNER JOIN cji_productocompania pc ON pc.PROD_Codigo = p.PROD_Codigo AND pc.COMPP_Codigo = $this->compania
                    WHERE p.PROD_FlagEstado LIKE '1'
                    $where
                    $order
                    $limit
                ";
        $query = $this->db->query($sql);

        if ($query->num_rows > 0) {
            return $query->result();
        }
        else
            return NULL;
    }

    public function detalles($almacen_id = "", $number_items = '', $offset = '') {
        $where = ($almacen_id != "") ? " AND p.PROD_CodigoUsuario LIKE '%$almacen_id%'" : "";
        $limit = ($number_items != "" && $offset != "") ? " LIMIT $offset, $number_items" : "";

        $sql = "SELECT almp.ALMPROD_Codigo, almp.ALMPROD_Stock, almp.COMPP_Codigo, al.ALMAP_Codigo, al.ALMAC_Descripcion, al.ALMAC_Direccion, al.EESTABP_Codigo, p.PROD_Codigo, p.PROD_Nombre, p.PROD_FlagBienServicio, p.PROD_StockMinimo, p.PROD_StockMaximo, p.PROD_CodigoInterno, p.PROD_CodigoUsuario, p.PROD_CodigoOriginal, p.PROD_Modelo, p.PROD_GenericoIndividual, p.PROD_FlagEstado, p.AFECT_Codigo, ta.AFECT_Descripcion, m.MARCP_Codigo, m.MARCC_CodigoUsuario, m.MARCC_Descripcion, p.FAMI_Codigo, f.FAMI_Descripcion, l.LOTC_Numero, l.LOTC_FechaVencimiento, almpl.ALMALOTC_Cantidad, almpl.ALMALOTC_Costo
                    FROM cji_almacenproducto almp
                    INNER JOIN cji_almaprolote almpl ON almpl.ALMPROD_Codigo = almp.ALMPROD_Codigo
                    INNER JOIN cji_lote l ON l.LOTP_Codigo = almpl.LOTP_Codigo
                    INNER JOIN cji_almacen al ON al.ALMAP_Codigo = almp.ALMAC_Codigo
                    INNER JOIN cji_producto p ON p.PROD_Codigo = almp.PROD_Codigo
                    LEFT JOIN cji_marca m ON m.MARCP_Codigo = p.MARCP_Codigo
                    INNER JOIN cji_tipo_afectacion ta ON ta.AFECT_Codigo = p.AFECT_Codigo
                    LEFT JOIN cji_familia f ON f.FAMI_Codigo = p.FAMI_Codigo
                    LEFT JOIN cji_fabricante fb ON fb.FABRIP_Codigo = p.FABRIP_Codigo
                    WHERE al.COMPP_Codigo = ".$this->compania." AND p.PROD_FlagEstado = 1 AND almpl.ALMALOTC_Cantidad > 0 AND almpl.ALMALOTC_FlagEstado = 1
                    $where
                    ORDER BY p.PROD_Nombre, almp.ALMAC_Codigo
                    $limit
                ";
        $query = $this->db->query($sql);


        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

    public function obtenerSumaStock(){
        $empresa = $_SESSION['empresa'];
        $sql = "SELECT SUM(ALMPROD_Stock) as stock, e.EESTABC_Descripcion as descripcion FROM cji_almacenproducto ap
                    INNER JOIN cji_almacen a ON a.ALMAP_Codigo = ap.ALMAC_Codigo
                    INNER JOIN cji_productocompania pc ON pc.COMPP_Codigo = a.COMPP_Codigo AND pc.PROD_Codigo = ap.PROD_Codigo
                    INNER JOIN cji_producto p ON pc.PROD_Codigo = p.PROD_Codigo AND p.PROD_FlagEstado = 1
                    INNER JOIN cji_emprestablecimiento e ON e.EESTABP_Codigo = a.EESTABP_Codigo
                    WHERE e.EMPRP_Codigo = $empresa
                    GROUP BY ap.ALMAC_Codigo
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

    public function obtenerSumaStockFamilia(){
        $empresa = $_SESSION['empresa'];
        $sql = "SELECT SUM(ALMPROD_Stock) as stock, e.EESTABC_Descripcion as descripcion, f.FAMI_Descripcion FROM cji_almacenproducto ap
                    INNER JOIN cji_almacen a ON a.ALMAP_Codigo = ap.ALMAC_Codigo
                    INNER JOIN cji_productocompania pc ON pc.COMPP_Codigo = a.COMPP_Codigo AND pc.PROD_Codigo = ap.PROD_Codigo
                    INNER JOIN cji_producto p ON pc.PROD_Codigo = p.PROD_Codigo AND p.PROD_FlagEstado = 1
                    LEFT JOIN cji_familia f ON f.FAMI_Codigo = p.FAMI_Codigo
                    INNER JOIN cji_emprestablecimiento e ON e.EESTABP_Codigo = a.EESTABP_Codigo
                    WHERE e.EMPRP_Codigo = $empresa 
                    GROUP BY ap.ALMAC_Codigo, p.FAMI_Codigo
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

    public function listar2($almacen_id = "", $number_items = '', $offset = '') {
        $number_items=50;
        $this->db->select('*');
        $this->db->from('cji_almacenproducto');
        $this->db->join('cji_almacen', 'cji_almacen.ALMAP_Codigo=cji_almacenproducto.ALMAC_Codigo');
        $this->db->join('cji_producto', 'cji_producto.PROD_Codigo=cji_almacenproducto.PROD_Codigo');
        $this->db->join('cji_familia', 'cji_familia.FAMI_Codigo=cji_producto.FAMI_Codigo', 'left');
        $this->db->join('cji_fabricante', 'cji_fabricante.FABRIP_Codigo=cji_producto.FABRIP_Codigo', 'left');
        $this->db->limit($number_items, $offset);
        $this->db->where('cji_almacen.COMPP_Codigo', $this->compania);
        $this->db->where('cji_producto.PROD_FlagEstado', '1');
        if ($almacen_id != "") {
            $this->db->like('cji_producto.PROD_Nombre', $almacen_id, 'both');
        }
        $this->db->order_by('cji_producto.PROD_Nombre');
        $this->db->order_by('cji_almacenproducto.ALMAC_Codigo');
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

    public function listarCotizados($search = "", $inicio = 0, $fin = 0) {
        if ( $search != "" && strlen($search) < 4 )
            $where = " AND (p.PROD_Nombre LIKE '%$search%' OR p.PROD_CodigoUsuario LIKE '%search%') ";
        else
            if ( $search != "" && strlen($search) >= 4 )
                $where = " AND Match(p.PROD_Nombre, p.PROD_CodigoUsuario) AGAINST ('$search') ";

        $number = ( $inicio != 0 && $fin != 0 ) ? " oc.OCOMC_Numero >= $inicio AND oc.OCOMC_Numero <= $fin AND" : "";

        /*CANTIDAD DE PRODUCTOS SIN CONTAR LOS QUE YA ESTAN FACTURADOS
        (SELECT SUM(ocd.OCOMDEC_Cantidad) FROM cji_ocompradetalle ocd
                    INNER JOIN cji_ordencompra oc ON oc.OCOMP_Codigo = ocd.OCOMP_Codigo
                    WHERE $number oc.OCOMC_TipoOperacion = 'V' AND oc.OCOMC_FlagEstado != 0 AND ocd.OCOMDEC_FlagEstado = 1 AND ocd.PROD_Codigo = p.PROD_Codigo AND
                    NOT EXISTS(SELECT g.OCOMP_Codigo FROM cji_guiarem g WHERE g.OCOMP_Codigo = oc.OCOMP_Codigo)
                    AND NOT EXISTS(SELECT c.OCOMP_Codigo FROM cji_comprobante c WHERE c.OCOMP_Codigo = oc.OCOMP_Codigo) ) as cantidad,

        (SELECT SUM(ocd.OCOMDEC_Total) FROM cji_ocompradetalle ocd
                    INNER JOIN cji_ordencompra oc ON oc.OCOMP_Codigo = ocd.OCOMP_Codigo
                    WHERE $number oc.OCOMC_TipoOperacion = 'V' AND oc.OCOMC_FlagEstado != 0 AND ocd.OCOMDEC_FlagEstado = 1 AND ocd.PROD_Codigo = p.PROD_Codigo AND
                    NOT EXISTS(SELECT g.OCOMP_Codigo FROM cji_guiarem g WHERE g.OCOMP_Codigo = oc.OCOMP_Codigo)
                    AND NOT EXISTS(SELECT c.OCOMP_Codigo FROM cji_comprobante c WHERE c.OCOMP_Codigo = oc.OCOMP_Codigo) ) as pv

        */

        /*$sql = "SELECT almp.ALMPROD_Codigo, almp.ALMPROD_Stock, almp.COMPP_Codigo, al.ALMAP_Codigo, almp.ALMAC_Codigo, al.ALMAC_Descripcion, al.ALMAC_Direccion, al.EESTABP_Codigo, p.PROD_Codigo, p.PROD_Nombre, p.PROD_FlagBienServicio, p.PROD_StockMinimo, p.PROD_StockMaximo, p.PROD_CodigoInterno, p.PROD_CodigoUsuario, p.PROD_CodigoOriginal, p.PROD_Modelo, p.PROD_GenericoIndividual, p.PROD_FlagEstado, p.AFECT_Codigo, ta.AFECT_Descripcion, m.MARCP_Codigo, m.MARCC_CodigoUsuario, m.MARCC_Descripcion, p.FAMI_Codigo, f.FAMI_Descripcion,
                (SELECT SUM(ocd.OCOMDEC_Cantidad) FROM cji_ocompradetalle ocd
                    INNER JOIN cji_ordencompra oc ON oc.OCOMP_Codigo = ocd.OCOMP_Codigo
                    WHERE $number oc.OCOMC_TipoOperacion = 'V' AND oc.OCOMC_FlagEstado != 0 AND ocd.OCOMDEC_FlagEstado = 1 AND ocd.PROD_Codigo = p.PROD_Codigo) as cantidad,
                p.PROD_UltimoCosto as costo,
                (SELECT SUM(ocd.OCOMDEC_Total) FROM cji_ocompradetalle ocd
                    INNER JOIN cji_ordencompra oc ON oc.OCOMP_Codigo = ocd.OCOMP_Codigo
                    WHERE $number oc.OCOMC_TipoOperacion = 'V' AND oc.OCOMC_FlagEstado != 0 AND ocd.OCOMDEC_FlagEstado = 1 AND ocd.PROD_Codigo = p.PROD_Codigo) as pv

                FROM cji_almacenproducto almp
                INNER JOIN cji_almacen al ON al.ALMAP_Codigo = almp.ALMAC_Codigo
                INNER JOIN cji_producto p ON p.PROD_Codigo = almp.PROD_Codigo
                LEFT JOIN cji_marca m ON m.MARCP_Codigo = p.MARCP_Codigo
                LEFT JOIN cji_tipo_afectacion ta ON ta.AFECT_Codigo = p.AFECT_Codigo
                LEFT JOIN cji_familia f ON f.FAMI_Codigo = p.FAMI_Codigo
                LEFT JOIN cji_fabricante fb ON fb.FABRIP_Codigo = p.FABRIP_Codigo
                    WHERE al.COMPP_Codigo = ".$this->compania." AND p.PROD_FlagEstado = 1
                    $where
                    ORDER BY p.PROD_Nombre, almp.ALMAC_Codigo
                    $limit
                ";*/
        $compania = $this->compania;
        $sql = "SELECT
                    (SELECT almp.ALMPROD_Stock FROM cji_almacenproducto almp
                        WHERE almp.COMPP_Codigo = ocP.COMPP_Codigo AND almp.PROD_Codigo = ocdP.PROD_Codigo LIMIT 1) as ALMPROD_Stock,

                p.PROD_Codigo, p.PROD_Nombre, p.PROD_FlagBienServicio, p.PROD_StockMinimo, p.PROD_StockMaximo, p.PROD_CodigoInterno, p.PROD_CodigoUsuario, p.PROD_CodigoOriginal, p.PROD_Modelo, p.PROD_GenericoIndividual, p.PROD_FlagEstado, p.AFECT_Codigo, ta.AFECT_Descripcion, m.MARCP_Codigo, m.MARCC_CodigoUsuario, m.MARCC_Descripcion, p.FAMI_Codigo, f.FAMI_Descripcion,
                (SELECT SUM(ocd.OCOMDEC_Cantidad) FROM cji_ocompradetalle ocd
                    INNER JOIN cji_ordencompra oc ON oc.OCOMP_Codigo = ocd.OCOMP_Codigo
                    WHERE $number oc.OCOMC_TipoOperacion = 'V' AND oc.OCOMC_FlagEstado != 0 AND ocd.OCOMDEC_FlagEstado = 1 AND ocd.PROD_Codigo = p.PROD_Codigo) as cantidad,
                p.PROD_UltimoCosto as costo,
                (SELECT SUM(ocd.OCOMDEC_Total) FROM cji_ocompradetalle ocd
                    INNER JOIN cji_ordencompra oc ON oc.OCOMP_Codigo = ocd.OCOMP_Codigo
                    WHERE $number oc.OCOMC_TipoOperacion = 'V' AND oc.OCOMC_FlagEstado != 0 AND ocd.OCOMDEC_FlagEstado = 1 AND ocd.PROD_Codigo = p.PROD_Codigo) as pv

                FROM cji_ocompradetalle ocdP
                INNER JOIN cji_ordencompra ocP ON ocP.OCOMP_Codigo = ocdP.OCOMP_Codigo
                INNER JOIN cji_producto p ON p.PROD_Codigo = ocdP.PROD_Codigo
                LEFT JOIN cji_marca m ON m.MARCP_Codigo = p.MARCP_Codigo
                LEFT JOIN cji_tipo_afectacion ta ON ta.AFECT_Codigo = p.AFECT_Codigo
                LEFT JOIN cji_familia f ON f.FAMI_Codigo = p.FAMI_Codigo
                LEFT JOIN cji_fabricante fb ON fb.FABRIP_Codigo = p.FABRIP_Codigo
                    WHERE ocP.COMPP_Codigo = $compania AND ocP.OCOMC_FlagEstado != 0 AND ocdP.OCOMDEC_FlagEstado = 1 AND p.PROD_FlagEstado = 1
                    GROUP BY p.PROD_Codigo
                    ORDER BY p.PROD_Nombre
                ";
        $query = $this->db->query($sql);

        if ($query->num_rows > 0) {
            foreach ($query->result() as $indice => $fila) {
                    $fila->costo = ($fila->costo == NULL) ? 0 : $fila->costo;
                    $fila->pv = ($fila->pv == NULL) ? 0 : $fila->pv;
                    $fila->ALMPROD_Stock = ($fila->ALMPROD_Stock == NULL) ? 0 : $fila->ALMPROD_Stock;

                    if ($fila->pv > 0 )
                        $fila->pv = $fila->pv / $fila->cantidad;

                if ( $fila->cantidad != NULL && $fila->cantidad != '' && $fila->cantidad > 0 ){
                    $data[] = $fila;
                }
            }
            return $data;
        }
        else
            return NULL;
    }

    public function listar_almacen($almacen_id = "", $number_items = '', $offset = '') {

        // print_r($_SESSION);

        $this->db->from('cji_almacenproducto');
        $this->db->join('cji_almacen', 'cji_almacen.ALMAP_Codigo=cji_almacenproducto.ALMAC_Codigo');
        $this->db->join('cji_producto', 'cji_producto.PROD_Codigo=cji_almacenproducto.PROD_Codigo');
        $this->db->join('cji_familia', 'cji_familia.FAMI_Codigo=cji_producto.FAMI_Codigo', 'left');
        $this->db->join('cji_fabricante', 'cji_fabricante.FABRIP_Codigo=cji_producto.FABRIP_Codigo', 'left');
        $this->db->limit($number_items, $offset);
        //  $this->db->where('cji_almacen.COMPP_Codigo',$this->compania);
        $this->db->where('cji_producto.PROD_FlagEstado', '1');
        if ($almacen_id != "") {
            $this->db->like('cji_producto.PROD_Nombre', $almacen_id);
        }
        $this->db->where('cji_almacenproducto.COMPP_Codigo', $this->compania);
        $this->db->order_by('cji_producto.PROD_Nombre');
        $this->db->order_by('cji_almacenproducto.ALMAC_Codigo');

        $query = $this->db->get();
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

    public function colocar_stock($almacen_id, $producto_id, $cantidad, $pcosto = '') {

        $filter = new stdClass();
        $filter->COMPP_Codigo = $this->compania;
        $filter->ALMAC_Codigo = $almacen_id;
        $filter->PROD_Codigo = $producto_id;
        $stock = $this->obtener($almacen_id, $producto_id);
        $pcosto = ( $pcosto == '' || is_null($pcosto) ) ? 0 : $pcosto;

        $almacenprod_id = 0;
        if (count($stock) > 0) {
            $almacenprod_id = $stock[0]->ALMPROD_Codigo;
            $cantidad_total = $cantidad;

            $filter->ALMPROD_Stock = $cantidad_total;
            $this->db->where("ALMPROD_Codigo", $almacenprod_id);
            $this->db->update("cji_almacenproducto", (array) $filter);
        } else {
            $filter->ALMPROD_Stock = $cantidad;
            $filter->ALMPROD_CostoPromedio = $pcosto;
            $this->db->insert("cji_almacenproducto", (array) $filter);
            $almacenprod_id = $this->db->insert_id();
        }

        //Aumento stock a la tabla producto y agrego el precio costo
        $this->producto_model->modificar_stock($producto_id, $cantidad);
        if ( $pcosto > 0 )
            $this->producto_model->modificar_ultCosto($producto_id, $pcosto);

        return $almacenprod_id;
    }

    public function listar_compania($compania, $producto) {
        $this->db->select('*');
        $this->db->from('cji_almacenproducto');
        $this->db->join('cji_almacen', 'cji_almacen.ALMAP_Codigo=cji_almacenproducto.ALMAC_Codigo');
        $this->db->join('cji_producto', 'cji_producto.PROD_Codigo=cji_almacenproducto.PROD_Codigo');
        $this->db->join('cji_familia', 'cji_familia.FAMI_Codigo=cji_producto.FAMI_Codigo', 'left');
        $this->db->join('cji_fabricante', 'cji_fabricante.FABRIP_Codigo=cji_producto.FABRIP_Codigo', 'left');
        $this->db->where('cji_almacen.COMPP_Codigo', $compania);
        $this->db->where('cji_almacenproducto.PROD_Codigo', $producto);
        $this->db->order_by('cji_producto.PROD_Nombre');
        $this->db->order_by('cji_almacenproducto.ALMAC_Codigo');
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

    public function obtener($almacen_id, $producto_id) {
        $compania = $this->compania;
        $this->db->select("*");
        $where = array();
        if($almacen_id != NULL && $almacen_id != 0)
       		$where = array("ALMAC_Codigo" => $almacen_id, "PROD_Codigo" => $producto_id);
        else
        	$where = array("PROD_Codigo" => $producto_id);
        
        $this->db->join('cji_almacen', 'cji_almacen.ALMAP_Codigo = cji_almacenproducto.ALMAC_Codigo');
       	$this->db->where($where);
       	$this->db->order_by('ALMAC_Codigo');
        $query = $this->db->get('cji_almacenproducto');
        
        if($query->num_rows > 0){
        	return $query->result();
        }else{
        	return NULL;
        }
    }

    public function aumentar($almacen_id, $producto_id, $cantidad, $costo) {
        $compania = $this->compania;
        $filter = new stdClass();
        $filter->COMPP_Codigo = $compania;
        $filter->ALMAC_Codigo = $almacen_id;
        $filter->PROD_Codigo = $producto_id;
        $stock = $this->obtener($almacen_id, $producto_id);
        if (count($stock) > 0) {
            $almacenprod_id = $stock[0]->ALMPROD_Codigo;
            $anterior = $stock{0}->ALMPROD_Stock;
            $costo_anterior = $stock[0]->ALMPROD_CostoPromedio;
            $cantidad_total = $cantidad + $anterior;
            if ($cantidad_total == 0)
                $costo_promedio = 0;
            else
                $costo_promedio = ($anterior * $costo_anterior + $cantidad * $costo) / $cantidad_total;
            $filter->ALMPROD_Stock = $cantidad_total;
            $filter->ALMPROD_CostoPromedio = $costo_promedio;
            $this->db->where("ALMPROD_Codigo", $almacenprod_id);
            $this->db->update("cji_almacenproducto", (array) $filter);
        }else {
            $filter->ALMPROD_Stock = $cantidad;
            $filter->ALMPROD_CostoPromedio = $costo;
            $this->db->insert("cji_almacenproducto", (array) $filter);
            $almacenprod_id = $this->db->insert_id();
        }
        //Aumento stock a la tabla producto
        $datos_producto = $this->producto_model->obtener_producto($producto_id);
        $stock_inicial = $datos_producto[0]->PROD_Stock;
        $this->producto_model->modificar_stock($producto_id, ($stock_inicial + $cantidad));
        //Actualizo el ultimo costo
        $this->producto_model->modificar_ultCosto($producto_id, $costo);
        return $almacenprod_id;
    }

    public function disminuir($almacen_id, $producto_id, $cantidad, $costo) {
        $stock = $this->obtener($almacen_id, $producto_id);
        if (count($stock) > 0) {
            $almacenprod_id = $stock[0]->ALMPROD_Codigo;
            $anterior = $stock[0]->ALMPROD_Stock;
            $costo_anterior = $stock[0]->ALMPROD_CostoPromedio;
            if ($cantidad != $anterior) {
                $cantidad_total = $anterior - $cantidad;
                $costo_promedio = ($anterior * $costo_anterior - $cantidad * $costo) / $cantidad_total;
            } else {
                $cantidad_total = 0;
                $costo_promedio = 0;
            }
            $compania = $this->compania;
            $filter = new stdClass();
            $filter->ALMAC_Codigo = $almacen_id;
            $filter->PROD_Codigo = $producto_id;
            $filter->COMPP_Codigo = $compania;
            $filter->ALMPROD_Stock = $cantidad_total;
            $filter->ALMPROD_CostoPromedio = $costo_promedio;
            $this->db->where("ALMPROD_Codigo", $almacenprod_id);
            $this->db->update("cji_almacenproducto", (array) $filter);
            //Disminuyo stock a la tabla producto
            $datos_producto = $this->producto_model->obtener_producto($producto_id);
            $stock_inicial = $datos_producto[0]->PROD_Stock;
            $this->producto_model->modificar_stock($producto_id, ($stock_inicial - $cantidad));
            //Actualizo el ultimo costo
            $this->producto_model->modificar_ultCosto($producto_id, $costo);
            return $almacenprod_id;
        }
    }

    public function disminuir2($almacen_id, $producto_id, $cantidad, $costo) {
        $stock = $this->obtener($almacen_id, $producto_id);
        if (count($stock) > 0) {
            $almacenprod_id = $stock[0]->ALMPROD_Codigo;
            $cantidad_original = $stock[0]->ALMPROD_Stock;
            $costo_anterior = $stock[0]->ALMPROD_CostoPromedio;
            if ($cantidad != $cantidad_original) {
                $cantidad_total = $cantidad_original - $cantidad;
                $costo_promedio = ($cantidad_original * $costo_anterior - $cantidad * $costo) / $cantidad_total;
            } else {
                $cantidad_total = 0;
                $costo_promedio = 0;
            }
            $compania = $this->compania;
            $filter = new stdClass();
            $filter->ALMAC_Codigo = $almacen_id;
            $filter->PROD_Codigo = $producto_id;
            $filter->COMPP_Codigo = $compania;
            $filter->ALMPROD_Stock = $cantidad_total;
            $filter->ALMPROD_CostoPromedio = $costo_promedio;
            $this->db->where("ALMPROD_Codigo", $almacenprod_id);
            $this->db->update("cji_almacenproducto", (array) $filter);
            //Disminuyo stock a la tabla producto
            $datos_producto = $this->producto_model->obtener_producto($producto_id);
            $stock_inicial = $datos_producto[0]->PROD_Stock;
            $this->producto_model->modificar_stock($producto_id, ($stock_inicial - $cantidad));
            //Actualizo el ultimo costo
            $this->producto_model->modificar_ultCosto($producto_id, $costo);
            return $almacenprod_id;
        }
    }

    public function devolver($almacen_id, $producto_id, $cantidad, $costo) {
        $compania = $this->compania;
        $filter = new stdClass();
        $filter->COMPP_Codigo = $compania;
        $filter->ALMAC_Codigo = $almacen_id;
        $filter->PROD_Codigo = $producto_id;
        $stock = $this->obtener($almacen_id, $producto_id);
        if (count($stock) > 0) {
            $almacenprod_id = $stock->ALMPROD_Codigo;
            $anterior = $stock->ALMPROD_Stock;
            $costo_anterior = $stock->ALMPROD_CostoPromedio;
            $cantidad_total = $cantidad + $anterior;
            if ($cantidad_total == 0)
                $costo_promedio = 0;
            else
                $costo_promedio = ($anterior * $costo_anterior + $cantidad * $costo) / $cantidad_total;
            $filter->ALMPROD_Stock = $cantidad_total;
            $filter->ALMPROD_CostoPromedio = $costo_promedio;
            $this->db->where("ALMPROD_Codigo", $almacenprod_id);
            $this->db->update("cji_almacenproducto", (array) $filter);
        }
        else {
            $filter->ALMPROD_Stock = $cantidad;
            $filter->ALMPROD_CostoPromedio = $costo;
            $this->db->insert("cji_almacenproducto", (array) $filter);
            $almacenprod_id = $this->db->insert_id();
        }
        //Aumento stock a la tabla producto
        $datos_producto = $this->producto_model->obtener_producto($producto_id);
        $stock_inicial = $datos_producto[0]->PROD_Stock;
        $this->producto_model->modificar_stock($producto_id, ($stock_inicial + $cantidad));
        return $almacenprod_id;
    }

    public function buscar_x_fechas($f_ini, $f_fin, $producto_busca, $companias = '') {
        if ($producto_busca != "")
            $where = array('ap.ALMPROD_FechaRegistro >=' => $f_ini, 'ap.ALMPROD_FechaRegistro <=' => $f_fin, 'ap.PROD_Codigo' => $producto_busca);
        else
            $where = array('ap.ALMPROD_FechaRegistro >=' => $f_ini, 'ap.ALMPROD_FechaRegistro <=' => $f_fin);
        $companias = is_array($companias) ? $companias : array($this->compania);

        $query = $this->db->where($where)
                        ->where_in('ap.COMPP_Codigo', $companias)
                        ->select('ap.*')->from('cji_almacenproducto ap')->get();
        if ($query->num_rows > 0)
            return $query->result();
        else
            return array();
    }
	public function obtener_almacen($almacen_id){
	 $where = array("ALMAP_Codigo" => $almacen_id);
        $query = $this->db->where($where)->get('cji_almacen');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
	}

    public function valoriza_stock($value='')
    {
        $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
        $order = ( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

        $where = "";

        if ( isset($filter->search) && $filter->search != "" && strlen($filter->search) >= 19)
            $where .= " AND Match(p.PROD_Nombre, p.PROD_CodigoUsuario) AGAINST ('$filter->search') ";
        

        /*
        #búsqueda de articulos actualizada para buscar palabras
        $match="";
        $string = preg_split(" ", $filter->searchProducto);
        foreach ($string as $key => $value) {
            if($value!=" " && $value!="+" && $value!="-" && strlen($value)>=3)
             $match.=" +(".$value.")";//busqueda de la palabra como grupo +(palabra)
        }
        
        if ( strlen($filter->searchProducto) < 20 )
            $where .= " AND (p.PROD_Nombre LIKE '%$filter->searchProducto%' OR p.PROD_CodigoUsuario LIKE '%$filter->searchProducto%') "; 
        else
            $where .= ' AND MATCH(p.PROD_Nombre,p.PROD_CodigoUsuario) AGAINST ("'.$match.'" IN BOOLEAN MODE)';
        */
            
        if ( isset($filter->searchProducto) && $filter->searchProducto != "" && strlen($filter->searchProducto) > 2 )
            $where .= " AND CONCAT_WS(' ', p.PROD_Nombre, p.PROD_CodigoUsuario) LIKE '%$filter->searchProducto%'";

        if ( isset($filter->searchModelo) && $filter->searchModelo != "")
            $where .= " AND p.PROD_Modelo LIKE '$filter->searchModelo' ";

        if ( isset($filter->searchMarca) && $filter->searchMarca != "")
            $where .= " AND m.MARCP_Codigo = '$filter->searchMarca' ";

        if ( isset($filter->searchCodigoUsuario) && trim($filter->searchCodigoUsuario) != "")
            $where .= " AND p.PROD_CodigoUsuario LIKE '$filter->searchCodigoUsuario' ";

        if ( isset($filter->searchModelo) && trim($filter->searchModelo) != "")
            $where .= " AND p.PROD_Modelo LIKE '$filter->searchModelo' ";

        if ( isset($filter->searchFamilia) && trim($filter->searchFamilia) != "")
            $where .= " AND p.FAMI_Codigo = '$filter->searchFamilia' ";
        
        if ( isset($filter->almacen) && $filter->almacen != "")
            $where .= " AND al.ALMAP_Codigo = '$filter->almacen' ";

        //var_dump($where);exit();

        $sql = "SELECT almp.ALMPROD_Codigo, almp.ALMPROD_Stock, almp.COMPP_Codigo, al.ALMAP_Codigo, almp.ALMAC_Codigo, al.ALMAC_Descripcion, al.ALMAC_Direccion, al.EESTABP_Codigo, p.PROD_Codigo, p.PROD_Nombre, p.PROD_FlagBienServicio, p.PROD_StockMinimo, p.PROD_StockMaximo, p.PROD_CodigoInterno, p.PROD_CodigoUsuario, p.PROD_CodigoOriginal, p.PROD_Modelo, p.PROD_GenericoIndividual, p.PROD_FlagEstado, p.AFECT_Codigo, p.PROD_UltimoCosto, ta.AFECT_Descripcion, m.MARCP_Codigo, m.MARCC_CodigoUsuario, m.MARCC_Descripcion, p.FAMI_Codigo, f.FAMI_Descripcion, fb.FABRIC_Descripcion, CONCAT_WS(' - ', um.UNDMED_Simbolo, um.UNDMED_Descripcion) as UNDMED_Simbolo
                    FROM cji_almacenproducto almp
                    INNER JOIN cji_almacen al ON al.ALMAP_Codigo = almp.ALMAC_Codigo
                    INNER JOIN cji_producto p ON p.PROD_Codigo = almp.PROD_Codigo
                    LEFT JOIN cji_marca m ON m.MARCP_Codigo = p.MARCP_Codigo
                    LEFT JOIN cji_productounidad pu ON pu.PROD_Codigo = p.PROD_Codigo
                    LEFT JOIN cji_unidadmedida um ON um.UNDMED_Codigo = pu.UNDMED_Codigo
                    LEFT JOIN cji_tipo_afectacion ta ON ta.AFECT_Codigo = p.AFECT_Codigo
                    LEFT JOIN cji_familia f ON f.FAMI_Codigo = p.FAMI_Codigo
                    LEFT JOIN cji_fabricante fb ON fb.FABRIP_Codigo = p.FABRIP_Codigo
                    WHERE p.PROD_FlagBienServicio='B' AND al.COMPP_Codigo = ".$this->compania." AND p.PROD_FlagEstado = 1
                    $where
                    $order
                    $limit
                ";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        else
            return NULL;
    }

    public function detalles_almacen($compania = "") {
        $where = ($almacen_id != "") ? " AND almp.ALMAC_Codigo = $almacen_id" : "";
        
        $sql = "SELECT almp.ALMPROD_Codigo, almp.ALMPROD_Stock, almp.COMPP_Codigo, al.ALMAP_Codigo, al.ALMAC_Descripcion, al.ALMAC_Direccion, al.EESTABP_Codigo, p.PROD_Codigo, p.PROD_Nombre, p.PROD_FlagBienServicio, p.PROD_CodigoInterno, p.PROD_UltimoCosto, p.PROD_FlagEstado
                    FROM cji_almacenproducto almp
                    LEFT JOIN cji_almacen al ON al.ALMAP_Codigo = almp.ALMAC_Codigo
                    LEFT JOIN cji_producto p ON p.PROD_Codigo = almp.PROD_Codigo
                    WHERE al.COMPP_Codigo = $compania AND p.PROD_FlagEstado = 1 
                    ";

        $query = $this->db->query($sql);

        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

    //MANEJO DE STOCK SIN RUTINAS
    public function actualizar_stock($filter)
    {
        $this->db->where("ALMPROD_Codigo", $filter->ALMPROD_Codigo);
        $id = $this->db->update("cji_almacenproducto", (array) $filter);
        return $id;
    }

} ?>