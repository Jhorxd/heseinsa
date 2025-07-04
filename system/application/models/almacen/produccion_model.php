<?php

class Produccion_model extends model{

    var $somevar;

    private $empresa;
    private $compania;
    private $idcompania;

    public function __construct(){
        parent::__construct();
        $this->load->model('almacen/productounidad_model');
        
        $this->load->model('almacen/familia_model');
        $this->load->model('almacen/atributo_model');
        $this->load->model('almacen/productoproveedor_model');
        $this->load->model('almacen/productoprecio_model');
        $this->load->model('maestros/companiaconfiguracion_model');
        $this->load->model('maestros/compania_model');
        $this->load->model('almacen/serie_model');
        $this->empresa = $this->session->userdata('empresa');
        $this->compania = $this->session->userdata('compania');
        $this->idcompania = $this->session->userdata('idcompania');
    }

    #***********************************************
    #******** RECETAS
    #***********************************************

    public function listarRecetas($filter = null, $number_items='',$offset=''){
        $where = '';
        if ( isset($filter->codigo) && $filter->codigo != '')
            $where .= " AND r.REC_Codigo = $filter->codigo";

        if ( isset($filter->nombre) && $filter->nombre != '')
            $where .= " AND r.REC_Descripcion LIKE '%$filter->nombre%'";

        $limit = "";
        if((string)$offset != '' && $number_items != '')
            $limit = 'LIMIT '.$offset.','.$number_items;
        
        $sql = "SELECT *
                    FROM cji_receta r
                    WHERE r.REC_FlagEstado = '1' $where ORDER BY r.REC_Descripcion DESC $limit";
            
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function getRecetasDatatable($filter = NULL){
        $compania = $this->compania;

        $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
        $order = ( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

        $where = "";
        
        /*
            #búsqueda de articulos actualizada para buscar palabras
            $match="";
            $string = preg_split(" ", $filter->searchProducto);
            foreach ($string as $key => $value) {
                if($value!=" " && $value!="+" && $value!="-" && $value!="/" && strlen($value)>=3)
                 $match.=" +(".$value.")";//busqueda de la palabra como grupo +(palabra)
            }
            
            if ( strlen($filter->searchProducto) < 7 )
                $where .= " AND (p.PROD_Nombre LIKE '%$filter->searchProducto%' OR p.PROD_CodigoUsuario LIKE '%$filter->searchProducto%') "; 
            else
                $where .= ' AND MATCH(p.PROD_Nombre,p.PROD_CodigoUsuario) AGAINST ("'.$match.'" IN BOOLEAN MODE)';
        */

        if ( isset($filter->searchProducto) && $filter->searchProducto != "" && strlen($filter->searchProducto) > 2 )
            $where .= " AND CONCAT_WS(' ', r.REC_Descripcion, r.REC_CodigoUsuario) LIKE '%$filter->searchProducto%'";
        #else
        #    if ( isset($filter->searchProducto) && $filter->searchProducto != "" && strlen($filter->searchProducto) >= 20 )
        #        $where .= " AND Match(p.PROD_Nombre, p.PROD_CodigoUsuario) AGAINST ('$filter->searchProducto') ";
                
        /*if ( isset($filter->searchProducto) && $filter->searchProducto != "")
            $where .= " AND p.PROD_Nombre LIKE '%$filter->searchProducto%' ";*/

        if ( isset($filter->searchCodigoUsuario) && trim($filter->searchCodigoUsuario) != "")
            $where .= " AND r.REC_CodigoUsuario LIKE '$filter->searchCodigoUsuario' ";

        if ( isset($filter->searchModelo) && trim($filter->searchModelo) != "")
            $where .= " AND p.PROD_Modelo LIKE '$filter->searchModelo' ";

        if ( isset($filter->searchMarca) && trim($filter->searchMarca) != "")
            $where .= " AND m.MARCC_Descripcion LIKE '%$filter->searchMarca%' ";

        if ( isset($filter->searchFamilia) && trim($filter->searchFamilia) != "")
            $where .= " AND p.FAMI_Codigo = '$filter->searchFamilia' ";

        $sql = "SELECT *
                FROM cji_receta r
                WHERE r.REC_FlagEstado = 1 $where 
                ORDER BY r.REC_Descripcion DESC $limit";
        $query = $this->db->query($sql);

        if ($query->num_rows > 0) {
            return $query->result();
        }
        else
            return NULL;
    }

    public function obtenerRecetaProducto($producto, $almacen = NULL){
        $compania = $this->compania;
        
        $stock = ($almacen == NULL) ? "(SELECT SUM(ap.ALMPROD_Stock) FROM cji_almacenproducto ap WHERE rd.PROD_Codigo = ap.PROD_Codigo AND ap.COMPP_Codigo = $compania) as stock" : "(SELECT SUM(ap.ALMPROD_Stock) FROM cji_almacenproducto ap WHERE rd.PROD_Codigo = ap.PROD_Codigo AND ap.ALMAC_Codigo = $almacen) as stock";

        $sql = "SELECT r.REC_Codigo, r.REC_Descripcion, r.PROD_Codigo as PROD_CodigoReceta, r.REC_FlagEstado, rd.RECDET_Codigo, rd.PROD_Codigo as PROD_CodigoInsumo, rd.RECDET_Cantidad, rd.RECDET_FlagEstado,
                    p.PROD_Nombre as nombre_producto, p.PROD_CodigoUsuario, p.PROD_Modelo,
                    $stock
                        FROM cji_receta r
                            INNER JOIN cji_recetadetalle rd ON rd.REC_Codigo = r.REC_Codigo
                            LEFT JOIN cji_producto p ON p.PROD_Codigo = rd.PROD_Codigo
                            WHERE r.PROD_Codigo = $producto AND r.REC_FlagEstado = 1 AND rd.RECDET_FlagEstado = 1
                ";
        $query = $this->db->query($sql);

        $data = NULL;
        if ($query->num_rows > 0){
            foreach ($query->result() as $indice => $columna) {
                $columna->stock = ( $columna->stock == NULL ) ? 0 : $columna->stock;
                $data[] = $columna;
            }
        }
        return $data;
    }

    public function getInsumosRequired(){
        $compania = $this->compania;

        # LISTA TODOS LOS INSUMOS FALTANTES PARA COMPLETAR LAS ORDENES DE PRODUCCION
        $sql = "SELECT SUM(rd.RECDET_Cantidad) as cantidadReceta, SUM( rd.RECDET_Cantidad * pd.PRD_Cantidad ) as cantidaInsumos, rd.PROD_Codigo,
                    (SELECT p.PROD_Nombre FROM cji_producto p WHERE p.PROD_Codigo = rd.PROD_Codigo) as PROD_Nombre,
                    (SELECT p.PROD_UltimoCosto FROM cji_producto p WHERE p.PROD_Codigo = rd.PROD_Codigo) as PROD_UltimoCosto,
                    (SELECT p.AFECT_Codigo FROM cji_producto p WHERE p.PROD_Codigo = rd.PROD_Codigo) as AFECT_Codigo,
                    pu.UNDMED_Codigo,
                    (SELECT SUM(ap.ALMPROD_Stock) FROM cji_almacenproducto ap WHERE rd.PROD_Codigo = ap.PROD_Codigo AND ap.COMPP_Codigo = $compania) as stock,
                    SUM( rd.RECDET_Cantidad * pd.PRD_Cantidad ) - (SELECT SUM(ap.ALMPROD_Stock) FROM cji_almacenproducto ap WHERE rd.PROD_Codigo = ap.PROD_Codigo AND ap.COMPP_Codigo = $compania) as insumosFaltantes
                    
                    FROM cji_recetadetalle rd
                    INNER JOIN cji_receta r ON r.REC_Codigo = rd.REC_Codigo
                    INNER JOIN cji_producciondetalle pd ON pd.PROD_Codigo = r.PROD_Codigo
                    LEFT JOIN cji_productounidad pu ON pu.UNDMED_Codigo = rd.PROD_Codigo
                    WHERE pd.PRD_FlagEstado = 1 AND rd.RECDET_FlagEstado = 1 AND EXISTS(SELECT pr.PR_Codigo FROM cji_produccion pr WHERE pr.PR_FlagTerminado > 1 AND pr.PR_FlagOC IS NULL AND pr.PR_Codigo = pd.PR_Codigo)
                    GROUP BY rd.PROD_Codigo
                ";
        $query = $this->db->query($sql);
        
        # ACTUALIZA EL FlagOC DE TODOS LOS PEDIDOS, PARA QUE NO VUELVAN A SER CONTABILIZADOS AL GENERAR OTRA OC
        $update = "UPDATE cji_produccion pr SET pr.PR_FlagOC = 1 WHERE pr.PR_FlagTerminado > 1 AND pr.PR_FlagOC IS NULL
                    AND pr.PR_Codigo IN (SELECT pd.PR_Codigo
                                            FROM cji_recetadetalle rd
                                            INNER JOIN cji_receta r ON r.REC_Codigo = rd.REC_Codigo
                                            INNER JOIN cji_producciondetalle pd ON pd.PROD_Codigo = r.PROD_Codigo
                                            WHERE pd.PRD_FlagEstado = 1 AND rd.RECDET_FlagEstado = 1 AND pd.PR_Codigo = pr.PR_Codigo GROUP BY pd.PR_Codigo)
                    ";
        $this->db->query($update);

        $data = NULL;
        if ($query->num_rows > 0){
            foreach ($query->result() as $indice => $columna) {
                $columna->stock = ( $columna->stock == NULL ) ? 0 : $columna->stock;
                $columna->insumosFaltantes = ( $columna->insumosFaltantes == NULL ) ? $columna->cantidaInsumos : $columna->insumosFaltantes;
                $data[] = $columna;
            }
        }
        return $data;
    }

    public function detallesReceta($receta){
        $compania = $this->compania;
        $sql = "SELECT rd.*, (SELECT SUM(ap.ALMPROD_Stock) FROM cji_almacenproducto ap WHERE rd.PROD_Codigo = ap.PROD_Codigo AND ap.COMPP_Codigo = $compania) as stock
                    FROM cji_recetadetalle rd
                    WHERE rd.RECDET_FlagEstado = '1' AND rd.REC_Codigo = $receta";
            
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

    public function insertarReceta($filter){
        $data = array(
            "REC_Codigo" => NULL,
            "REC_Descripcion" => $descripcion,
            "PROD_Codigo" => $producto,
            "REC_FlagEstado" => '1'
        );
        $this->db->insert("cji_receta", (array)$filter);
        return $this->db->insert_id();
    }

    public function actualizarReceta($id,$filter){
        $where = array("REC_Codigo" => $id);
        $this->db->where($where);
        $retorno = $this->db->update("cji_receta",(array)$filter);
        return $retorno;
    }

    public function eliminar_receta($id){
        $where = array("REC_Codigo" => $id);
        $this->db->where($where);
        $data = array("REC_FlagEstado" => '0');
        $retorno = $this->db->update("cji_receta",$data);
        return $retorno;
    }

    public function estadoReceta($codigo, $flag = '0'){
        $sql = "UPDATE cji_receta
                    SET REC_FlagEstado = $flag
                    WHERE REC_Codigo = $codigo
                ";
        $query = $this->db->query($sql);
        if ( $query->num_rows > 0 )
            return true;
        else
            return false;
    }

    public function insertarProductoReceta($filter = NULL){
        $this->db->insert('cji_recetadetalle',(array)$filter);
        return $this->db->insert_id();
    }

    public function modificarProductoReceta($recetaDet, $filter = NULL){
        $where = array("RECDET_Codigo" => $recetaDet);
        $this->db->where($where);
        $this->db->update("cji_recetadetalle",(array)$filter);
    }


    ////////////////////////////////////////////////////////////////////////////////
    // PRODUCCION
    //


    public function getProduccionDatatable($filter = NULL){
        $compania = $this->compania;

        $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
        $order = ( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

        $where = "";
        
        
       $where = '';
        
        if (isset($filter->numero) && $filter->numero != '')
            $where .= " AND pr.PR_Codigo = '$filter->numero'";

        if (isset($filter->almacen) && $filter->almacen != '')
            $where .= " AND pr.PR_AlmaOrigen = '$filter->almacen'";

        if (isset($filter->almacenD) && $filter->almacenD != '')
            $where .= " AND pr.PR_AlmaDestino = '$filter->almacenD'";

        if (isset($filter->producto) && $filter->producto != '')
            $where .= " AND EXISTS (SELECT * FROM cji_producciondetalle iad WHERE iad.PR_Codigo = pr.PR_Codigo AND iad.PROD_Codigo = '$filter->producto')";

        if (isset($filter->fechaDesde) && $filter->fechaDesde != '') {
            if ($filter->fechaHasta == "")
                $filter->fechaHasta = $filter->fechaDesde;

            $where .= " AND pr.PR_FechaRecepcion BETWEEN '$filter->fechaDesde 00:00:00' AND '$filter->fechaHasta 23:59:59'";
        }
        
        $sql = "SELECT pr.*, 
                (SELECT al.ALMAC_Descripcion from cji_almacen al where pr.PR_AlmaOrigen = al.ALMAP_Codigo) as almacen_origen,
                (SELECT al.ALMAC_Descripcion from cji_almacen al where pr.PR_AlmaDestino = al.ALMAP_Codigo) as almacen_destino
                      FROM cji_produccion pr
                      WHERE pr.COMPP_Codigo = $this->compania $where
                      ORDER BY pr.PR_Codigo DESC
                      $limit
                ";
        $query = $this->db->query($sql);

        if ($query->num_rows > 0) {
            return $query->result();
        }
        else
            return NULL;
    }

    public function getAlmacenes($filter = NULL) {

        $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
        $order = "ORDER BY a.ALMAP_Codigo";//( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

        $where = '';
        if (isset($filter->descripcion) && $filter->descripcion != '')
            $where .= " AND a.ALMAC_Descripcion LIKE '%$filter->descripcion%'";

        if (isset($filter->tipo) && $filter->tipo != '')
            $where .= " AND a.TIPALM_Codigo = $filter->tipo";

        $sql = "SELECT a.*, ep.EESTABC_Descripcion, ta.TIPALM_Descripcion
                        FROM cji_almacen a
                        INNER JOIN cji_tipoalmacen ta ON ta.TIPALMP_Codigo = a.TIPALM_Codigo
                        INNER JOIN cji_emprestablecimiento ep ON ep.EESTABP_Codigo = a.EESTABP_Codigo
                        WHERE a.ALMAC_FlagEstado LIKE '1' $where
                        $order $limit
                ";

        $query = $this->db->query($sql);
        if ($query->num_rows > 0)
            return $query->result();
        else
            return array();
    }

    public function insertarProduccion($filter = NULL){
        $this->db->insert('cji_produccion',(array)$filter);
        $id = $this->db->insert_id();

        if ( $filter->PEDIP_Codigo != NULL && $filter->PEDIP_Codigo != ""){
            $sql = "UPDATE cji_pedido SET PEDIC_FlagEstado = $filter->PR_FlagTerminado WHERE PEDIP_Codigo = $filter->PEDIP_Codigo";
            $this->db->query($sql);
        }

        return $id;
    }

    public function guardarProduccion($filter)
    {
        $this->db->insert("cji_produccion", (array) $filter);
        return $this->db->insert_id();
    }
    public function insertarProductoProduccion($filter = NULL){
        $this->db->insert('cji_producciondetalle',(array)$filter);
        return $this->db->insert_id();
    }

    public function modificarProductoProduccion($produccionDet, $filter = NULL){
        $where = array("PRD_Codigo" => $produccionDet);
        $this->db->where($where);
        $this->db->update("cji_producciondetalle",(array)$filter);
    }

    public function getProduccion($ajuste)
    {

        $sql = "SELECT i.*, 
                (SELECT al.ALMAC_Descripcion from cji_almacen al where i.PR_AlmaOrigen = al.ALMAP_Codigo) as almacen_origen,
                (SELECT al.ALMAC_Descripcion from cji_almacen al where i.PR_AlmaDestino = al.ALMAP_Codigo) as almacen_destino
                FROM cji_produccion i
                WHERE i.PR_Codigo = '$ajuste'";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    public function getProduccionDetalle($ajuste)
    {

        $sql = "SELECT ad.*,  p.PROD_Nombre, p.PROD_CodigoUsuario
                                
                            FROM cji_producciondetalle ad
                            
                            INNER JOIN cji_producto p ON p.PROD_Codigo = ad.PROD_Codigo
                            
                            
                            WHERE ad.PR_Codigo = '$ajuste' AND ad.PRD_FlagEstado = 1
                        ";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    public function actualizarAjuste($id, $filter)
    {
        $this->db->where('PR_Codigo', $id);
        return $this->db->update('cji_produccion', $filter);
    }

    public function IngresoProductoTerminado($prodId, $cantidad, $almacen)
    {
        $sql = "UPDATE cji_almacenproducto SET ALMPROD_Stock := (ALMPROD_Stock + $cantidad) WHERE PROD_Codigo = $prodId AND ALMAC_Codigo = $almacen";
        return $this->db->query($sql);
    }

    public function retirarInsumo($prodId, $cantidad, $almacen)
    {
        $sql = "UPDATE cji_almacenproducto SET ALMPROD_Stock := (ALMPROD_Stock - $cantidad) WHERE PROD_Codigo = $prodId AND ALMAC_Codigo = $almacen";
        return $this->db->query($sql);
    }

    public function getProductosDatatable($filter = NULL){
        $compania = $this->compania;

        $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
        $order = ( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

        $where = "";
        
        /*
            #búsqueda de articulos actualizada para buscar palabras
            $match="";
            $string = preg_split(" ", $filter->searchProducto);
            foreach ($string as $key => $value) {
                if($value!=" " && $value!="+" && $value!="-" && $value!="/" && strlen($value)>=3)
                 $match.=" +(".$value.")";//busqueda de la palabra como grupo +(palabra)
            }
            
            if ( strlen($filter->searchProducto) < 7 )
                $where .= " AND (p.PROD_Nombre LIKE '%$filter->searchProducto%' OR p.PROD_CodigoUsuario LIKE '%$filter->searchProducto%') "; 
            else
                $where .= ' AND MATCH(p.PROD_Nombre,p.PROD_CodigoUsuario) AGAINST ("'.$match.'" IN BOOLEAN MODE)';
        */

        if ( isset($filter->searchProducto) && $filter->searchProducto != "" && strlen($filter->searchProducto) > 2 )
            $where .= " AND CONCAT_WS(' ', p.PROD_Nombre, p.PROD_CodigoUsuario) LIKE '%$filter->searchProducto%'";
        #else
        #    if ( isset($filter->searchProducto) && $filter->searchProducto != "" && strlen($filter->searchProducto) >= 20 )
        #        $where .= " AND Match(p.PROD_Nombre, p.PROD_CodigoUsuario) AGAINST ('$filter->searchProducto') ";
                
        /*if ( isset($filter->searchProducto) && $filter->searchProducto != "")
            $where .= " AND p.PROD_Nombre LIKE '%$filter->searchProducto%' ";*/

        if ( isset($filter->searchCodigoUsuario) && trim($filter->searchCodigoUsuario) != "")
            $where .= " AND p.PROD_CodigoUsuario LIKE '$filter->searchCodigoUsuario' ";

        if ( isset($filter->searchModelo) && trim($filter->searchModelo) != "")
            $where .= " AND p.PROD_Modelo LIKE '$filter->searchModelo' ";

        

        if ( isset($filter->searchFamilia) && trim($filter->searchFamilia) != "")
            $where .= " AND p.FAMI_Codigo = '$filter->searchFamilia' ";

        if ( isset($filter->searchFlagBS) && trim($filter->searchFlagBS) != "")
            $where .= " AND p.PROD_FlagBienServicio = '$filter->searchFlagBS' ";

        $sql = "SELECT p.PROD_Codigo, p.PROD_Nombre, p.PROD_FlagBienServicio, p.PROD_StockMinimo, p.PROD_StockMaximo, p.PROD_CodigoInterno, p.PROD_CodigoUsuario, p.PROD_CodigoOriginal, p.PROD_Modelo, p.PROD_GenericoIndividual, p.PROD_UltimoCosto, p.PROD_FlagEstado, p.AFECT_Codigo, p.FAMI_Codigo, CONCAT_WS(' - ', um.UNDMED_Simbolo, um.UNDMED_Descripcion) as UNDMED_Simbolo
                    FROM cji_producto p
                    INNER JOIN cji_productocompania pc ON pc.PROD_Codigo = p.PROD_Codigo
                    INNER JOIN cji_receta rc ON rc.PROD_Codigo = p.PROD_Codigo
                    LEFT JOIN cji_productounidad pu ON pu.PROD_Codigo = p.PROD_Codigo
                    LEFT JOIN cji_unidadmedida um ON um.UNDMED_Codigo = pu.UNDMED_Codigo
                    WHERE pc.COMPP_Codigo = $compania AND p.PROD_FlagEstado = 1 AND rc.REC_FlagEstado = 1
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


    public function confirmInventariadoProduccion($producto, $almacen)
    {
        

        $sql = "SELECT p.* FROM cji_producto p WHERE p.PROD_Codigo = $producto";
        $psInfo = $this->db->query($sql);

        if ($psInfo->num_rows > 0) {

            $ps = $psInfo->result();
            if ($ps[0]->PROD_FlagBienServicio == "B") {
                $sql = "SELECT inv.*
                            FROM cji_inventario inv
                            INNER JOIN cji_inventariodetalle invd ON invd.INVE_Codigo = inv.INVE_Codigo
                            WHERE inv.ALMAP_Codigo = $almacen AND invd.PROD_Codigo = $producto
                        ";
                $query = $this->db->query($sql);

                if ($query->num_rows > 0) {
                    return true;
                } else {
                    unset($query);
                    $sql = "SELECT MAX(INVE_Codigo) as INVE_Codigo
                            FROM cji_inventario inv
                            WHERE inv.ALMAP_Codigo = $almacen
                        ";
                    $query = $this->db->query($sql);
                    if ($query->num_rows > 0) {
                        foreach ($query->result() as $key => $value) {
                            $filter = new stdClass();
                            $filter->INVE_Codigo = $value->INVE_Codigo;
                            $filter->PROD_Codigo = $producto;
                            $filter->INVD_Cantidad = 0;
                            $filter->INVD_Pcosto = 0;
                            $filter->INVD_FechaRegistro = date('Y-m-d');
                            $filter->INVD_FlagActivacion = "1";
                            $result = $this->db->insert("cji_inventariodetalle", (array) $filter);

                            #####################################################
                            ###### INSERTAMOS EN EL ALMACEN
                            #####################################################
                            $cdInventario = new stdClass();
                            $cdInventario->cod_inventario = $value->INVE_Codigo;
                            $cdInventario->companiaDestino = $almacen;
                            $datos_inventario = $this->buscar_inventarioProduccion($cdInventario);
                            
                            $codigoAlmacenProducto = $this->almacenproducto_model->aumentar($datos_inventario[0]->ALMAP_Codigo, $producto, 0, 0); // Suma cantidad ingresada

                            #####################################################
                            ###### CREAMOS LA GUIA DE INGRESO
                            #####################################################
                            $cGuiaI = new stdClass();
                            $cGuiaI->TIPOMOVP_Codigo = 2;
                            $cGuiaI->ALMAP_Codigo = $almacen;
                            $cGuiaI->PROVP_Codigo = null;
                            $cGuiaI->DOCUP_Codigo = 4;
                            $cGuiaI->GUIAINC_Fecha = date('Y-m-d h:m:s');
                            $cGuiaI->GUIAINC_Observacion = '';
                            $cGuiaI->USUA_Codigo = $_SESSION['user'];
                            $cGuiaI->GUIAINC_Automatico = 1;
                            $cGuiaI->GUIAINC_NumeroRef = $value->INVE_Codigo;
                            $guia_id = $this->guiain_model->insertar($cGuiaI);

                            #####################################################
                            ###### INSERTAMOS EL PRODUCTO EN LA GUIA DE INGRESO
                            #####################################################       
                            $cGuiaId = new stdClass();
                            $cGuiaId->GUIAINP_Codigo = $guia_id;
                            $cGuiaId->PRODCTOP_Codigo = $producto;
                            $cGuiaId->ALMAP_Codigo = $almacen;
                            $cGuiaId->UNDMED_Codigo = 1;
                            $cGuiaId->GUIIAINDETC_GenInd = "G";
                            $cGuiaId->GUIAINDETC_Cantidad = "0";
                            $cGuiaId->GUIAINDETC_Costo = "0";
                            $cGuiaId->GUIAINDETC_Descripcion = '';
                            $cGuiaId->ALMAP_Codigo = $almacen;
                            $this->guiaindetalle_model->insertar($cGuiaId, false); # false para no ingresar al kardex

                            #####################################################
                            ###### CREAMOS EL LOTE
                            #####################################################
                            #$dLote = new stdClass();
                            #$dLote->PROD_Codigo = $producto;
                            #$dLote->LOTC_Cantidad = "0";
                            #$dLote->LOTC_Costo = "0";
                            #$dLote->GUIAINP_Codigo = $guia_id;
                            #$lote = $this->lote_model->insertar($dLote);
                            #$this->almaprolote_model->aumentar($almacen, $lote, 0, 0);

                            #####################################################
                            ###### INSERTAMOS EL MOVIMIENTO EN EL KARDEX
                            #####################################################
                            #$cKardex = new stdClass();
                            #$cKardex->KARD_Fecha = date('Y-m-d h:m:s');
                            #$cKardex->KARDC_Cantidad = 0;
                            #$cKardex->PROD_Codigo = $producto;
                            #$cKardex->KARDC_Costo = 0;
                            #$cKardex->KARDC_TipoIngreso = 3;
                            #$cKardex->LOTP_Codigo = $lote;
                            #$cKardex->TIPOMOVP_Codigo = NULL;
                            #$cKardex->KARDC_CodigoDoc = $value->INVE_Codigo;
                            #$cKardex->ALMPROD_Codigo = $almacen;
                            #$cKardex->KARDP_FlagEstado = 1;
                            #$this->kardex_model->insertar(4, $cKardex);

                        }
                    }
                }
            }
        }
    }

    public function buscar_inventarioProduccion($filter = null, $number_items = "", $offset = "")
    {

        if (isset($filter->cod_inventario) && $filter->cod_inventario != '')
            $this->db->where('cji_inventario.INVE_Codigo', $filter->cod_inventario);

        $compania = $this->compania;
        $this->db->where('cji_inventario.COMPP_Codigo', $filter->companiaDestino);
        $this->db->orderby('cji_inventario.INVE_Codigo', 'DESC');
        //$query = $this->db->get('cji_inventario', $number_items, $offset);
        return $this->db->get('cji_inventario', $number_items, $offset)->result();


        /*if ($query->num_rows > 0) {
            $data = array();

            foreach ($query->result() as $fila) {

                $data[] = $fila;
            }

            return $data;
        }*/
    }
    

}
?>