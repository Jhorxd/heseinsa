<?php
/* *********************************************************************************
Autor: Unknow
Dev: Luis Valdes
/* ******************************************************************************** */
class Inventario_model extends model
{

    var $somevar;
    public $compania = NULL;

    public function __construct()
    {
        parent::__construct();
        #$this->load->database();
        $this->compania = $this->session->userdata('compania');
        $this->somevar['idcompania'] = $this->session->userdata('idcompania');
    }

    #####################################################################################
    /** Begin Luis Valdes **/
    public function guardarInventario($filter)
    {
        $this->db->insert("cji_inventario", (array) $filter);
        return $this->db->insert_id();
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function actualizarInventario($id, $filter)
    {
        $this->db->where('INVE_Codigo', $id);
        return $this->db->update('cji_inventario', $filter);
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function guardarInventarioResponsable($filter)
    {
        $this->db->insert("cji_inventarioresp", (array) $filter);
        return $this->db->insert_id();
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function guardarInventarioDetalle($filter)
    {
        $this->db->insert("cji_inventariodetalle", (array) $filter);
        return $this->db->insert_id();
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function actualizarInventarioDetalle($id, $filter)
    {
        $this->db->where('INVD_Codigo', $id);
        return $this->db->update('cji_inventariodetalle', $filter);
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function getInventarios($filter = NULL, $onlyRecords = true)
    {

        $limit = (isset($filter->start) && isset($filter->length)) ? " LIMIT $filter->start, $filter->length " : "";
        $order = "ORDER BY i.INVE_FechaInicio DESC"; //(isset($filter->order) && isset($filter->dir)) ? "ORDER BY $filter->order $filter->dir " : "";

        $where = '';
        if (isset($filter->serie) && $filter->serie != '')
            $where .= " AND i.INVE_Serie LIKE '$filter->serie'";

        if (isset($filter->numero) && $filter->numero != '')
            $where .= " AND i.INVE_Numero LIKE '$filter->numero'";

        if (isset($filter->almacen) && $filter->almacen != '')
            $where .= " AND i.ALMAP_Codigo = '$filter->almacen'";

        if (isset($filter->responsable) && $filter->responsable != '')
            $where .= " AND EXISTS (SELECT * FROM cji_inventarioresp iar WHERE iar.INVE_Codigo = i.INVE_Codigo AND iar.PERSP_Codigo = '$filter->responsable')";

        if (isset($filter->producto) && $filter->producto != '')
            $where .= " AND EXISTS (SELECT * FROM cji_inventariodetalle iad WHERE iad.INVE_Codigo = i.INVE_Codigo AND iad.PROD_Codigo = '$filter->producto')";

        if (isset($filter->fechaDesde) && $filter->fechaDesde != '') {
            if ($filter->fechaHasta == "")
                $filter->fechaHasta = $filter->fechaDesde;

            $where .= " AND i.INVE_FechaRegistro BETWEEN '$filter->fechaDesde 00:00:00' AND '$filter->fechaHasta 23:59:59'";
        }

        $rec = "SELECT i.*, a.ALMAC_Descripcion
                            FROM cji_inventario i
                            INNER JOIN cji_almacen a ON a.ALMAP_Codigo = i.ALMAP_Codigo
                            WHERE a.COMPP_Codigo = '$this->compania' AND i.INVE_FlagEstado=1 $where $order $limit";

        $recF = "SELECT COUNT(*) as registros
                            FROM cji_inventario i
                            INNER JOIN cji_almacen a ON a.ALMAP_Codigo = i.ALMAP_Codigo
                            WHERE a.COMPP_Codigo = '$this->compania' AND i.INVE_FlagEstado=1 $where";

        $recT = "SELECT COUNT(*) as registros
                            FROM cji_inventario i
                            INNER JOIN cji_almacen a ON a.ALMAP_Codigo = i.ALMAP_Codigo
                            WHERE a.COMPP_Codigo = '$this->compania' AND i.INVE_FlagEstado=1;
                            ";

        $records = $this->db->query($rec);

        if ($onlyRecords == false) {
            $recordsFilter = $this->db->query($recF)->row()->registros;
            $recordsTotal = $this->db->query($recT)->row()->registros;
        }

        if ($records->num_rows() > 0) {
            if ($onlyRecords == false) {
                $info = array(
                    "records" => $records->result(),
                    "recordsFilter" => $recordsFilter,
                    "recordsTotal" => $recordsTotal
                );
            } else {
                $info = $records->result();
            }
        } else {
            if ($onlyRecords == false) {
                $info = array(
                    "records" => NULL,
                    "recordsFilter" => 0,
                    "recordsTotal" => $recordsTotal
                );
            } else {
                $info = $records->result();
            }
        }
        return $info;
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function getInventarioResp($ajuste)
    {
        $sql = "SELECT p.PERSP_Codigo, p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno, GROUP_CONCAT(DISTINCT ir.INVER_Observacion SEPARATOR ' <br>') as INVER_Observacion
                            FROM cji_inventarioresp ir
                            LEFT JOIN cji_persona p ON p.PERSP_Codigo = ir.PERSP_Codigo
                            WHERE ir.INVE_Codigo = '$ajuste'
                            GROUP BY p.PERSP_Codigo";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function getInventario($ajuste)
    {

        $sql = "SELECT i.*, a.ALMAC_Descripcion
                            FROM cji_inventario i
                            INNER JOIN cji_almacen a ON a.ALMAP_Codigo = i.ALMAP_Codigo
                            WHERE i.INVE_Codigo = '$ajuste'";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function getInventarioDetalles($ajuste)
    {

        $sql = "SELECT ad.*, ia.ALMAP_Codigo, ia.COMPP_Codigo, p.PROD_Nombre, p.PROD_CodigoUsuario, p.PROD_Modelo, m.MARCC_Descripcion,
                                (SELECT a.ALMPROD_Codigo
                                    FROM cji_almacenproducto a
                                    WHERE a.ALMAC_Codigo = ia.ALMAP_Codigo
                                    AND a.PROD_Codigo = ad.PROD_Codigo
                                ) as ALMPROD_Codigo, (SELECT a.ALMPROD_Stock
                                    FROM cji_almacenproducto a
                                    WHERE a.ALMAC_Codigo = ia.ALMAP_Codigo
                                    AND a.PROD_Codigo = ad.PROD_Codigo
                                ) as ALMPROD_Stock,
                                pe.PERSC_Nombre, pe.PERSC_ApellidoPaterno, pe.PERSC_ApellidoMaterno
                            FROM cji_inventariodetalle ad
                            INNER JOIN cji_inventario ia ON ia.INVE_Codigo = ad.INVE_Codigo
                            INNER JOIN cji_producto p ON p.PROD_Codigo = ad.PROD_Codigo
                            LEFT JOIN cji_persona pe ON pe.PERSP_Codigo = ad.PERSP_Codigo
                            LEFT JOIN cji_marca m ON m.MARCP_Codigo = p.MARCP_Codigo
                            WHERE ad.INVE_Codigo = '$ajuste' AND ad.INVD_FlagActivacion LIKE '1'
                        ";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    public function nuevoEnAlmacen($filter)
    {
        $this->db->insert("cji_almacenproducto", (array) $filter);
        $almacenprod_id = $this->db->insert_id();
        return $almacenprod_id;
    }

    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function actualizarInventarioCantidad($id, $cantidad)
    {
        $sql = "UPDATE cji_inventariodetalle SET INVD_Cantidad = $cantidad WHERE INVD_Codigo = $id";
        return $this->db->query($sql);
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function correlativoInventario($company)
    {
        $sql = "SELECT
                CASE
                    WHEN MAX(INVE_Numero) IS NULL THEN 0
                    ELSE MAX(INVE_Numero)
                END as cantidad
                FROM cji_inventario
                WHERE COMPP_Codigo = '$company'";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->row()->cantidad;
        } else {
            return 0;
        }
    }
    /** End Luis Valdes **/



























    #####################################################################################

    public function buscar_inventario($filter = null, $number_items = "", $offset = "")
    {

        if (isset($filter->cod_inventario) && $filter->cod_inventario != '')
            $this->db->where('cji_inventario.INVE_Codigo', $filter->cod_inventario);

        $compania = $this->compania;
        $this->db->where('cji_inventario.COMPP_Codigo', $compania);
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

    public function buscar_inventario_detalles($filter = null, $number_items = "", $offset = "")
    {

        $compania = $this->compania;

        $this->db->select('
                    cji_producto.PROD_Nombre,
                    cji_marca.MARCC_CodigoUsuario,
                    cji_producto.PROD_Codigo,
                    cji_producto.PROD_Presentacion,
                    cji_producto.PROD_GenericoIndividual,
                    cji_inventariodetalle.INVD_Codigo,
                    cji_inventariodetalle.INVD_FlagActivacion,
                    cji_inventariodetalle.INVE_Codigo,
                    cji_inventariodetalle.INVD_Cantidad,
                    cji_inventariodetalle.INVD_Pcosto,
                    cji_inventariodetalle.LOTC_Numero,
                    cji_inventariodetalle.LOTC_FechaVencimiento,
                    cji_inventario.ALMAP_Codigo
                ');

        if (isset($filter->codigo_inventario) && $filter->codigo_inventario != '') {
            $this->db->where('cji_inventariodetalle.INVE_Codigo', $filter->codigo_inventario);
        }
        if (isset($filter->codigo_detalle) && $filter->codigo_detalle != '') {
            $this->db->where('cji_inventariodetalle.INVD_Codigo', $filter->codigo_detalle);
        }

        if (isset($filter->PROD_Codigo) && $filter->PROD_Codigo != 0) {
            $this->db->where('cji_inventariodetalle.PROD_Codigo', $filter->PROD_Codigo);
        }

        $this->db->where('cji_inventario.COMPP_Codigo', $compania);
        $this->db->join('cji_inventario', 'cji_inventario.INVE_Codigo = cji_inventariodetalle.INVE_Codigo ', 'INNER');
        $this->db->join('cji_producto', 'cji_producto.PROD_Codigo = cji_inventariodetalle.PROD_Codigo ', 'left');
        $this->db->join('cji_marca', 'cji_marca.MARCP_Codigo = cji_producto.MARCP_Codigo ', 'left');
        $this->db->join('cji_almacenproducto', 'cji_almacenproducto.PROD_Codigo = cji_inventariodetalle.PROD_Codigo ', 'left');
        $this->db->join('cji_productoprecio', 'cji_productoprecio.PROD_Codigo = cji_inventariodetalle.PROD_Codigo ', 'left');
        $this->db->orderby('cji_inventariodetalle.INVD_Codigo', 'DESC');
        $this->db->group_by('cji_producto.PROD_Codigo');
        $query = $this->db->get('cji_inventariodetalle', $number_items, $offset);

        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function getProducto_Atributo($producto, $atributo)
    {

        $this->db->where(array('cji_productoatributo.ATRIB_Codigo' => $atributo, 'cji_productoatributo.PROD_Codigo' => $producto));
        $query = $this->db->get('cji_productoatributo');

        if ($query->num_rows > 0) {

            foreach ($query->result() as $fila) {

                $data[] = $fila;
            }
            return $data;
        }
    }

    public function insertar($datos)
    {

        $filter = new stdClass();
        $filter->INVE_Titulo = $datos['titulo'];
        $filter->COMPP_Codigo = $this->compania;
        $filter->INVE_Serie = $datos['serie'];
        $filter->INVE_Numero = $datos['numero'];
        $filter->ALMAP_Codigo = $datos['almacen'];
        $fecha = explode("/", $datos['fecha_inicio']);
        $filter->INVE_FechaInicio = "$fecha[2]-$fecha[1]-$fecha[0]";
        $filter->INVE_FlagEstado = "1";

        $result = $this->db->insert("cji_inventario", (array) $filter);

        return $result;
    }

    public function editar($datos)
    {

        $filter = new stdClass();
        $filter->INVE_Titulo = $datos['titulo'];
        $filter->ALMAP_Codigo = $datos['almacen'];
        $fecha = explode("/", $datos['fecha_inicio']);
        $filter->INVE_FechaInicio = "$fecha[2]-$fecha[1]-$fecha[0]";

        $this->db->where('cji_inventario.INVE_Codigo', $datos['cod_inventario']);
        $result = $this->db->update("cji_inventario", (array) $filter);

        return $result;
    }

    public function insertar_detalle($datos)
    {

        $filter = new stdClass();
        $filter->INVE_Codigo = $datos['cod_inventario'];
        $filter->PROD_Codigo = $datos['cod_producto'];
        $filter->INVD_Cantidad = $datos['cantidad'];
        $filter->INVD_Pcosto = $datos['p_costo'];
        $filter->LOTC_Numero = $datos['numero_lote'];
        $filter->LOTC_FechaVencimiento = $datos['vencimiento_lote'];

        $filter->INVD_FechaRegistro = date('Y-m-d');

        $result = $this->db->insert("cji_inventariodetalle", (array) $filter);

        return $result;
    }

    public function editar_detalle($datos)
    {

        $filter = new stdClass();
        $filter->INVD_Cantidad = $datos['cantidad'];
        $filter->INVD_Pcosto = $datos['p_costo'];
        $filter->LOTC_Numero = $datos['numero_lote'];
        $filter->LOTC_FechaVencimiento = $datos['vencimiento_lote'];

        $this->db->where('cji_inventariodetalle.INVD_Codigo', $datos['cod_detalle']);
        $result = $this->db->update("cji_inventariodetalle", (array) $filter);

        return $result;
    }

    public function editar_detalle_activacion($codigo_detalle)
    {

        $filter = new stdClass();
        $filter->INVD_FlagActivacion = 1;

        $this->db->where('cji_inventariodetalle.INVD_Codigo', $codigo_detalle);
        $result = $this->db->update("cji_inventariodetalle", (array) $filter);

        return $result;
    }

    public function eliminar_detalle($datos)
    {
        $this->db->trans_start();
        $this->db->where('cji_inventariodetalle.INVD_Codigo', $datos['cod_detalle']);
        $result = $this->db->delete('cji_inventariodetalle');
        $this->db->trans_complete();

        return $result;
    }

    public function removeInventory($id){
        $this->db->trans_start();
        $this->db->where('cji_inventario.INVE_Codigo', $id);
        $this->db->trans_complete();
        $this->db->delete('cji_inventario');
    }

    public function removeInventoryDetails($id){
        $this->db->trans_start();
        $this->db->where('cji_inventariodetalle.INVE_Codigo', $id);
        $this->db->delete('cji_inventariodetalle');
        $this->db->trans_complete();
    }

    public function count_inventario()
    {

        $this->db->select('COUNT(cji_inventario.INVE_Codigo) as conteo');
        $compania = $this->compania;
        $this->db->where('cji_inventario.COMPP_Codigo', $compania);
        $query = $this->db->get('cji_inventario');

        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    ///gcbq
    public function activacion_inventario($datos)
    {

        $filter = new stdClass();
        $filter->INVE_FechaFin =  date('Y-m-d');
        $filter->INVE_FechaRegistro = date('Y-m-d');
        $filter->INVE_FlagEstado = 1;


        $this->db->where('cji_inventario.INVE_Codigo', $datos['cod_inventario']);
        $result = $this->db->update("cji_inventario", (array) $filter);

        return $result;
    }
    public function eliminar_inventario_detalles($codigo)
    {

        $this->db->where('cji_inventariodetalle.INVE_Codigo', $codigo);
        $result = $this->db->delete('cji_inventariodetalle');

        if ($result)
            $this->eliminar_inventario($codigo);
    }
    public function eliminar_inventario($codigo)
    {

        $this->db->where('cji_inventario.INVE_Codigo', $codigo);
        $result = $this->db->delete('cji_inventario');

        return $result;
    }

    public function verificarProductoInventarios($codigoProducto)
    {
        $compania = $this->compania;
        $this->db->select('cji_producto.PROD_Codigo');
        $this->db->where('cji_inventariodetalle.PROD_Codigo', $codigoProducto);
        $this->db->where('cji_inventariodetalle.INVD_FlagActivacion', 1);
        $this->db->where('cji_inventario.COMPP_Codigo', $compania);
        $this->db->join('cji_inventario', 'cji_inventario.INVE_Codigo = cji_inventariodetalle.INVE_Codigo ', 'INNER');
        $this->db->join('cji_producto', 'cji_producto.PROD_Codigo = cji_inventariodetalle.PROD_Codigo ', 'INNER');
        $this->db->join('cji_almacenproducto', 'cji_almacenproducto.PROD_Codigo = cji_inventariodetalle.PROD_Codigo ', 'INNER');
        $this->db->orderby('cji_inventariodetalle.INVD_Codigo', 'DESC');
        $this->db->group_by('cji_producto.PROD_Codigo');
        $query = $this->db->get('cji_inventariodetalle');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    /**verificamos si el producto se encuentra inventariado y en el ese almacen**/
    public function verificarProductoInventarioAlmacen($codigoProducto, $almacen)
    {
        $compania = $this->compania;
        $this->db->select('cji_inventario.ALMAP_Codigo');
        $this->db->where('cji_inventariodetalle.PROD_Codigo', $codigoProducto);
        $this->db->where('cji_inventariodetalle.INVD_FlagActivacion', 1);
        $this->db->where('cji_inventario.COMPP_Codigo', $compania);
        $this->db->where('cji_inventario.ALMAP_Codigo', $almacen);
        $this->db->join('cji_inventario', 'cji_inventario.INVE_Codigo = cji_inventariodetalle.INVE_Codigo ', 'INNER');
        $this->db->orderby('cji_inventariodetalle.INVD_Codigo', 'DESC');
        $query = $this->db->get('cji_inventariodetalle');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    /** Begin Luis Valdes **/
    public function confirmInventariado($producto, $almacen)
    {
        $this->load->model("almacen/almacenproducto_model");
        $this->load->model("almacen/guiain_model");
        $this->load->model("almacen/guiaindetalle_model");
        $this->load->model("almacen/kardex_model");

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

                    $sql = "SELECT MAX(INVE_Codigo) as INVE_Codigo, INVE_Serie, INVE_Numero
                            FROM cji_inventario inv
                            WHERE inv.ALMAP_Codigo = $almacen
                        ";
                    $query = $this->db->query($sql);
                    if ($query->num_rows > 0) {
                        foreach ($query->result() as $key => $value) {
                            $filter = new stdClass();
                            $filter->INVE_Codigo    = $value->INVE_Codigo;
                            $filter->PROD_Codigo    = $producto;
                            $filter->INVD_Cantidad  = 0;
                            $filter->INVD_Pcosto    = 0;
                            $filter->INVD_FechaRegistro = date('Y-m-d H:i:s');
                            $filter->INVD_FlagActivacion = "1";
                            $result = $this->db->insert("cji_inventariodetalle", (array) $filter);

                            #####################################################
                            ###### INSERTAMOS EN EL ALMACEN
                            #####################################################
                            $cdInventario = new stdClass();
                            $cdInventario->cod_inventario = $value->INVE_Codigo;
                            $datos_inventario = $this->buscar_inventario($cdInventario);
                            $codigoAlmacenProducto = $this->almacenproducto_model->aumentar($datos_inventario[0]->ALMAP_Codigo, $producto, 0, 0); // Suma cantidad ingresada

                            #####################################################
                            ###### CREAMOS LA GUIA DE INGRESO
                            #####################################################
                            $cGuiaI = new stdClass();
                            $cGuiaI->TIPOMOVP_Codigo        = 2;
                            $cGuiaI->ALMAP_Codigo           = $almacen;
                            $cGuiaI->PROVP_Codigo           = null;
                            $cGuiaI->DOCUP_Codigo           = 4;
                            $cGuiaI->GUIAINC_Fecha          = date('Y-m-d H:i:s');
                            $cGuiaI->GUIAINC_Observacion    = '';
                            $cGuiaI->USUA_Codigo            = $_SESSION['user'];
                            $cGuiaI->GUIAINC_Automatico     = 1;
                            $cGuiaI->GUIAINC_NumeroRef      = $value->INVE_Codigo;
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
                            $cKardex = new stdClass();

                            $cKardex->KARDC_CodigoDoc       = $value->INVE_Codigo;
                            $cKardex->DOCUP_Codigo          = "I";
                            $cKardex->PROD_Codigo           = $producto;
                            $cKardex->PROD_Descripcion      = ""; #opcionales (para futuro desarrollo)
                            $cKardex->KARDC_Cantidad        = "0";
                            $cKardex->KARDC_Serie           = $value->INVE_Serie;
                            $cKardex->KARDC_Numero          = $value->INVE_Numero;
                            $cKardex->KARDC_AlmacenDesc     = ""; #opcionales (para futuro desarrollo)
                            $cKardex->MONED_Codigo          = ""; #opcionales (para futuro desarrollo)
                            $cKardex->KARDC_ProdAfectacion  = "";
                            $cKardex->KARDC_Costo           = "";
                            $cKardex->KARDC_PrecioConIgv    = "";
                            $cKardex->KARDC_Subtotal        = "";
                            $cKardex->KARDC_Total           = "";
                            $cKardex->COMPP_Codigo          = $this->compania;
                            $cKardex->TIPOMOVP_Codigo       = 2;
                            $cKardex->LOTP_Codigo           = NULL;
                            $cKardex->KARDC_TipoIngreso     = "ENTRADA POR INGRESO AUTOMATICO A INVENTARIO";
                            $cKardex->Denominacion          = "";
                            $cKardex->NumDocRuc             = "";
                            $cKardex->ALMPROD_Codigo        = $almacen;
                            $cKardex->CLIP_Codigo           = "";
                            $cKardex->PROVP_Codigo          = "";
                            $cKardex->USUA_Codigo           = ""; #Nombre o codigo?
                            $cKardex->KARDP_FlagEstado      = 1;
                            $cKardex->isNotExistStore       = true;
                            $this->kardex_model->registrar_kardex($cKardex);
                        }
                    }
                }
            }
        }
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function getAjustes($filter = NULL, $onlyRecords = true)
    {

        $limit = (isset($filter->start) && isset($filter->length)) ? " LIMIT $filter->start, $filter->length " : "";
        $order = "ORDER BY i.INVA_Codigo DESC"; //(isset($filter->order) && isset($filter->dir)) ? "ORDER BY $filter->order $filter->dir " : "";

        $where = '';
        if (isset($filter->serie) && $filter->serie != '')
            $where .= " AND i.INVA_Serie LIKE '$filter->serie'";

        if (isset($filter->numero) && $filter->numero != '')
            $where .= " AND i.INVA_Numero LIKE '$filter->numero'";

        if (isset($filter->almacen) && $filter->almacen != '')
            $where .= " AND i.ALMAP_Codigo = '$filter->almacen'";

        if (isset($filter->responsable) && $filter->responsable != '')
            $where .= " AND EXISTS (SELECT * FROM cji_inventarioajusteresp iar WHERE iar.INVA_Codigo = i.INVA_Codigo AND iar.PERSP_Codigo = '$filter->responsable')";

        if (isset($filter->producto) && $filter->producto != '')
            $where .= " AND EXISTS (SELECT * FROM cji_inventarioajustedetalle iad WHERE iad.INVA_Codigo = i.INVA_Codigo AND iad.PROD_Codigo = '$filter->producto')";

        if (isset($filter->fechaDesde) && $filter->fechaDesde != '') {
            if ($filter->fechaHasta == "")
                $filter->fechaHasta = $filter->fechaDesde;

            $where .= " AND i.INVA_FechaRegistro BETWEEN '$filter->fechaDesde 00:00:00' AND '$filter->fechaHasta 23:59:59'";
        }

        $rec = "SELECT i.*, a.ALMAC_Descripcion
                            FROM cji_inventarioajuste i
                            INNER JOIN cji_almacen a ON a.ALMAP_Codigo = i.ALMAP_Codigo
                            WHERE a.COMPP_Codigo = '$this->compania' $where $order $limit";

        $recF = "SELECT COUNT(*) as registros
                            FROM cji_inventarioajuste i
                            INNER JOIN cji_almacen a ON a.ALMAP_Codigo = i.ALMAP_Codigo
                            WHERE a.COMPP_Codigo = '$this->compania' $where";

        $recT = "SELECT COUNT(*) as registros
                            FROM cji_inventarioajuste i
                            INNER JOIN cji_almacen a ON a.ALMAP_Codigo = i.ALMAP_Codigo
                            WHERE a.COMPP_Codigo = '$this->compania'
                            ";

        $records = $this->db->query($rec);

        if ($onlyRecords == false) {
            $recordsFilter = $this->db->query($recF)->row()->registros;
            $recordsTotal = $this->db->query($recT)->row()->registros;
        }

        if ($records->num_rows() > 0) {
            if ($onlyRecords == false) {
                $info = array(
                    "records" => $records->result(),
                    "recordsFilter" => $recordsFilter,
                    "recordsTotal" => $recordsTotal
                );
            } else {
                $info = $records->result();
            }
        } else {
            if ($onlyRecords == false) {
                $info = array(
                    "records" => NULL,
                    "recordsFilter" => 0,
                    "recordsTotal" => $recordsTotal
                );
            } else {
                $info = $records->result();
            }
        }
        return $info;
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function getAjusteResp($ajuste)
    {
        $sql = "SELECT p.PERSP_Codigo, p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno, GROUP_CONCAT(DISTINCT ir.INVAR_Observacion SEPARATOR ' <br>') as INVAR_Observacion
                            FROM cji_inventarioajusteresp ir
                            LEFT JOIN cji_persona p ON p.PERSP_Codigo = ir.PERSP_Codigo
                            WHERE ir.INVA_Codigo = '$ajuste'
                            GROUP BY p.PERSP_Codigo";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function getAjuste($ajuste)
    {

        $sql = "SELECT i.*, CASE i.INVA_TipoMovimiento WHEN '1' THEN 'REEMPLAZAR STOCK' WHEN '2' THEN 'SUMAR AL STOCK' ELSE '' END as movimiento_descripcion, a.ALMAC_Descripcion, inv_ajus_rep.INVAR_Observacion
                            FROM cji_inventarioajuste i
                            INNER JOIN cji_almacen a ON a.ALMAP_Codigo = i.ALMAP_Codigo
                            inner join cji_inventarioajusteresp as inv_ajus_rep on inv_ajus_rep.INVA_Codigo = i.INVA_Codigo
                            WHERE i.INVA_Codigo = '$ajuste'";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function getAjusteDetails($ajuste)
    {

        $sql = "SELECT ad.*, ia.ALMAP_Codigo, ia.COMPP_Codigo, p.PROD_Nombre, p.PROD_CodigoUsuario, p.PROD_Modelo, m.MARCC_Descripcion,
                                (SELECT a.ALMPROD_Codigo
                                    FROM cji_almacenproducto a
                                    WHERE a.ALMAC_Codigo = ia.ALMAP_Codigo
                                    AND a.PROD_Codigo = ad.PROD_Codigo
                                ) as ALMPROD_Codigo,
                                pe.PERSC_Nombre, pe.PERSC_ApellidoPaterno, pe.PERSC_ApellidoMaterno
                            FROM cji_inventarioajustedetalle ad
                            INNER JOIN cji_inventarioajuste ia ON ia.INVA_Codigo = ad.INVA_Codigo
                            INNER JOIN cji_producto p ON p.PROD_Codigo = ad.PROD_Codigo
                            LEFT JOIN cji_persona pe ON pe.PERSP_Codigo = ad.PERSP_Codigo
                            LEFT JOIN cji_marca m ON m.MARCP_Codigo = p.MARCP_Codigo
                            WHERE ad.INVA_Codigo = '$ajuste' AND ad.INVADET_FlagEstado LIKE '1'
                        ";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function guardarAjuste($filter)
    {
        $this->db->insert("cji_inventarioajuste", (array) $filter);
        return $this->db->insert_id();
    }

    public function setInventory($filter)
    {
        $this->db->trans_start(); // Inicia la transacción
        $this->db->insert("cji_inventario", (array) $filter);
        $id = $this->db->insert_id();
        $this->db->trans_complete(); // Completa la transacción

        if ($this->db->trans_status() === FALSE) {
            // La transacción ha fallado
            return 'Error en la transacción';
        } else {
            // La transacción se ha completado con éxito
            return $id;
        }
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function guardarAjusteResponsable($filter)
    {
        $this->db->insert("cji_inventarioajusteresp", (array) $filter);
        return $this->db->insert_id();
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function actualizarAjuste($id, $filter)
    {
        $this->db->where('INVA_Codigo', $id);
        return $this->db->update('cji_inventarioajuste', $filter);
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function guardarAjusteDetalle($filter)
    {
        $this->db->insert("cji_inventarioajustedetalle", (array) $filter);
        return $this->db->insert_id();
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function actualizarAjusteDetalle($id, $filter)
    {
        $this->db->where('INVADET_Codigo', $id);
        return $this->db->update('cji_inventarioajustedetalle', $filter);
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function correlativoAjuste($company)
    {
        $sql = "SELECT
                            CASE
                                WHEN MAX(INVA_Numero) IS NULL THEN 0
                                ELSE MAX(INVA_Numero)
                            END as cantidad
                        FROM cji_inventarioajuste
                        WHERE COMPP_Codigo = '$company'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->row()->cantidad;
        } else {
            return 0;
        }
    }

    public function correlativeInventory($company)
    {
        $sql = "SELECT
                            CASE
                                WHEN MAX(INVE_Numero) IS NULL THEN 0
                                ELSE MAX(INVE_Numero)
                            END as cantidad
                        FROM cji_inventario
                        WHERE COMPP_Codigo = '$company'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->row()->cantidad;
        } else {
            return 0;
        }
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function guardarAjusteStock($filter)
    {
        $this->db->insert("cji_almacenproducto", (array) $filter);
        return $this->db->insert_id();
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function reemplazarAjusteStock($id, $filter)
    {
        $this->db->where('ALMPROD_Codigo', $id);
        return $this->db->update('cji_almacenproducto', $filter);
    }
    /** End Luis Valdes **/

    /** Begin Luis Valdes **/
    public function actualizarAjusteStock($id, $cantidad)
    {
        $sql = "UPDATE cji_almacenproducto SET ALMPROD_Stock = $cantidad WHERE ALMPROD_Codigo = $id";
        return $this->db->query($sql);
    }
    /** End Luis Valdes **/

    ## Dev: Luis Valdes -> Begin
    public function cargaStock($filter, $id)
    {
        if (
            isset($filter->file) && !empty($filter->file) &&
            isset($filter->ext) && !empty($filter->ext) &&
            isset($filter->inventario) && !empty($filter->inventario) &&
            isset($filter->almacen) && !empty($filter->almacen) &&
            isset($filter->persona) && !empty($filter->persona)
        ) {
            if (!file_exists($filter->file)) {
                return array('result' => 'error', 'details' => 'El archivo de importaci¨®n no se encuentra en el directorio especificado.');
            } else {
                /** Obtenemos la fecha en PHP porque la fecha en DB 'now()' trae la hora chile **/
                $date = date("Y-m-d H:i:s");

                #$sql = "TRUNCATE TABLE cji_almacenproducto_carga;";
                #$query = $this->db->query($sql);

                /** Paso 1: Cargamos la data del excel **/
                if ($filter->ext == "csv") {
                    $sql = "LOAD DATA LOCAL INFILE '$filter->file' 
                            INTO TABLE cji_almacenproducto_carga
                            FIELDS TERMINATED BY ';'
                            LINES TERMINATED BY '\n'
                            (PROD_CodigoUsuario, PROD_Nombre, PROD_Marca, PROD_Modelo, ALMPC_Cantidad);";
                } else {
                    $this->load->library('Excel');
                    $objReader = PHPExcel_IOFactory::createReader('Excel5');
                    $objPHPExcel = $objReader->load($filter->file);
                    $worksheet = $objPHPExcel->getActiveSheet();

                    $consulta = "SELECT PROD_Codigo, PROD_FlagBienServicio FROM cji_producto WHERE PROD_CodigoInterno in";
                    $data = "";
                    //$cod = "(".$data.")";

                    foreach ($worksheet->getRowIterator() as $row) {
                        if ($row->getRowIndex() > 1) {
                            $cellIterator = $row->getCellIterator();
                            $cellIterator->setIterateOnlyExistingCells(false);
                            $data .= ($data != "") ? ", " : " ";
                            foreach ($cellIterator as $cell) {
                                if (!is_null($cell)) {
                                    if (
                                        $cell->getCoordinate() == 'A' . $row->getRowIndex()
                                    ) {
                                        $data .= '"' . $cell->getValue() . '"';

                                        if ($cell->getCoordinate() != 'E' . $row->getRowIndex()) {
                                            $data .= ' ';
                                        }
                                    }
                                }
                            }
                            $data .= " ";
                        }
                        $cod = "(" . $data . ")";
                    }
                    $result = $consulta . $cod;


                    $obtener = $this->db->query($result);

                    //var_dump("Obtener data: ",$obtener->PROD_Codigo);

                    if ($obtener->row()->PROD_FlagBienServicio == 'S') {

                        //No inserta servicios como stock, validacion aplicada para curar bugs

                    } elseif ($obtener->row()->PROD_FlagBienServicio == 'B') {

                        $this->db->trans_start();

                        $insert = "INSERT INTO cji_almacenproducto_carga (PROD_CodigoUsuario, PROD_Nombre, PROD_Marca, PROD_Modelo, ALMPC_Cantidad) VALUES ";
                        $vals = array();

                        foreach ($worksheet->getRowIterator() as $row) {
                            if ($row->getRowIndex() > 1) {
                                $cellIterator = $row->getCellIterator();
                                $cellIterator->setIterateOnlyExistingCells(false);
                                $rowValues = array(); // Almacena los valores de la fila
                                foreach ($cellIterator as $cell) {
                                    if (!is_null($cell)) {
                                        if (
                                            $cell->getCoordinate() == 'A' . $row->getRowIndex() ||
                                            $cell->getCoordinate() == 'B' . $row->getRowIndex() ||
                                            $cell->getCoordinate() == 'C' . $row->getRowIndex() ||
                                            $cell->getCoordinate() == 'D' . $row->getRowIndex() ||
                                            $cell->getCoordinate() == 'E' . $row->getRowIndex()
                                        ) {
                                            $rowValues[] = $cell->getValue();
                                        }
                                    }
                                }
                        
                                // Verificar si al menos uno de los valores relevantes no está vacío
                                if (!empty(array_filter($rowValues))) {
                                    $vals[] = '("' . implode('", "', $rowValues) . '")'; // Agregamos la fila a $vals como un string
                                }
                            }
                        }
                    }
                }

                // Verificar si hay filas válidas antes de realizar la inserción

                //Se modifico el nombre de algunos campos para realizar la carga en ingreso de inventario y tambien se reemplazo la tabla 'ajusteintencario' por 'inventario' en la consultas siguientes.
                if (!empty($vals)) {
                    // Construir la consulta SQL
                    $sql = $insert . implode(', ', $vals);
                    // Ejecutar la consulta SQL de inserción
                    if ($this->db->query($sql)) {
                        /** Paso 2: Completamos los datos faltantes (ajuste, almacen, producto) y cambiamos el estado a pendiente o error **/
                        $sql = "UPDATE cji_almacenproducto_carga pc SET
                        pc.INVE_Codigo = $filter->inventario,
                        pc.ALMAP_Codigo = $filter->almacen,
                        pc.PROD_Codigo = (SELECT p.PROD_Codigo FROM cji_producto p WHERE p.PROD_CodigoUsuario = TRIM(pc.PROD_CodigoUsuario)),
                        pc.ALMPC_FlagEstado = CASE (SELECT COUNT(*) FROM cji_producto p WHERE p.PROD_CodigoUsuario = TRIM(pc.PROD_CodigoUsuario)) WHEN 0 THEN '4' ELSE '2' END
                        WHERE pc.ALMPC_FlagEstado LIKE '3'";
                        if ($this->db->query($sql)) {

                            /** Paso 3: Inserta en cji_inventariodetalle los items en estado pendiente **/
                            $sql = "INSERT INTO cji_inventariodetalle
                            (INVE_Codigo, PROD_Codigo, INVD_Cantidad, INVD_Pcosto, PERSP_Codigo, INVD_FechaRegistro, INVD_FechaModificacion, INVD_FlagActivacion, LOTC_Numero, LOTC_FechaVencimiento)
                            SELECT ac.INVE_Codigo, ac.PROD_Codigo, ac.ALMPC_Cantidad, NULL, $filter->persona, NOW(), NOW(), 1, NULL, NULL
                            FROM cji_almacenproducto_carga ac
                            WHERE ac.ALMPC_FlagEstado LIKE '2'";

                            if ($this->db->query($sql)) {
                                /** Paso 4: Cambia el estado de pendiente a aprobado para no considerar esos items en una próxima carga **/
                                $sql = "UPDATE cji_almacenproducto_carga pc SET pc.ALMPC_FlagEstado = '1'
                                    WHERE pc.ALMPC_FlagEstado LIKE '2'
                                        AND pc.ALMAP_Codigo = $filter->almacen
                                        AND EXISTS(SELECT d.PROD_Codigo FROM cji_inventariodetalle d WHERE d.INVE_Codigo = pc.INVE_Codigo AND d.PROD_Codigo = pc.PROD_Codigo) ";
                                $this->db->query($sql);

                                $sql = "SELECT COUNT(*) as cantidad FROM cji_almacenproducto_carga ac WHERE ac.ALMPC_FlagEstado LIKE '4'";
                                
                                if ($this->db->query($sql)->row()->cantidad == 0) {
                                    $this->db->trans_complete();
                                    return array('result' => 'success', 'details' => 'Ejecución completa.');
                                } else {
                                    $this->removeInventory($id);
                                    $this->removeInventoryDetails($id);
                                    $this->db->trans_rollback();
                                    return array('result' => 'warning', 'details' => 'Algunos productos no se cargaron por presentar códigos no registrados. Se elimino el inventario creado');
                                }
                            } else {
                                $this->removeInventory($id);
                                $this->removeInventoryDetails($id);
                                $this->db->trans_rollback();
                                return array('result' => 'error', 'details' => 'No es posible registrar los items.');
                            }
                        } else {
                            return array('result' => 'error', 'details' => 'Error al ejecutar mantenimiento de productos cargados.');
                        }
                    } else {
                        return array('result' => 'error', 'details' => 'No fue posible cargar los productos del documento.');
                    }
                } else {
                    // No había filas válidas para insertar
                    return array('result' => 'warning', 'details' => 'No se encontraron filas válidas para insertar en cji_almacenproducto_carga.');
                }
            }
        } else {
            return array('result' => 'error', 'details' => 'Parametros incompletos. Archivo: (' . ((isset($filter->file)) ? $filter->file : '') . ') Ajuste: (' . ((isset($filter->inventario)) ? $filter->inventario : '') . ') almacen: (' . ((isset($filter->almacen)) ? $filter->almacen : '') . ') persona: (' . ((isset($filter->persona)) ? $filter->persona : '') . ')');
        }
    }
    ## Dev: Luis Valdes -> End

    ## Dev: Luis Valdes -> Begin
    public function getProductosCargados($ajuste, $flag = '2')
    {
        $sql = "SELECT * FROM cji_almacenproducto_carga WHERE ALMPC_FlagEstado IN($flag) AND INVA_Codigo = $ajuste";
        $records = $this->db->query($sql);

        if ($records->num_rows() > 0) {
            return $records->result();
        } else {
            return NULL;
        }
    }
    ## Dev: Luis Valdes -> End
}
