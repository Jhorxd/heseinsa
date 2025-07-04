<?php

class Emprestablecimiento_model extends Model {

    private $empresa;
    private $compania;
    private $usuario;

    public function __construct() {
        parent::__construct();
        $this->load->helper('date');
        $this->load->model('maestros/ubigeo_model');
        $this->empresa = $this->session->userdata('empresa');
        $this->compania = $this->session->userdata('compania');
        $this->usuario = $this->session->userdata('usuario');
    }
    
    public function getEmpresaEstablecimiento($codigo){


        $sql = "SELECT e.*, c.*, ee.*,
                        p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno, p.PERSC_Sexo, p.ESTCP_EstadoCivil, p.NACP_Nacionalidad,

                        CASE c.CLIC_TipoPersona
                            WHEN 0 THEN p.PERSC_TipoDocIdentidad
                            WHEN 1 THEN e.TIPCOD_Codigo
                            ELSE ''
                        END as tipo_documento,
                        CASE c.CLIC_TipoPersona
                            WHEN 0 THEN tp.TIPOCC_Inciales
                            WHEN 1 THEN tc.TIPCOD_Inciales
                            ELSE ''
                        END as documento,
                        CASE c.CLIC_TipoPersona
                            WHEN 0 THEN p.PERSC_NumeroDocIdentidad
                            WHEN 1 THEN e.EMPRC_Ruc
                            ELSE ''
                        END as numero,
                        CASE c.CLIC_TipoPersona
                            WHEN 0 THEN CONCAT_WS(' ', p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno)
                            WHEN 1 THEN e.EMPRC_RazonSocial
                            ELSE ''
                        END as razon_social,
                        CASE c.CLIC_TipoPersona
                            WHEN 0 THEN p.PERSC_Direccion
                            WHEN 1 THEN e.EMPRC_Direccion
                            ELSE ''
                        END as direccion,
                        CASE c.CLIC_TipoPersona
                            WHEN 0 THEN p.UBIGP_Domicilio
                            WHEN 1 THEN (SELECT ep.UBIGP_Codigo FROM cji_emprestablecimiento ep WHERE ep.EMPRP_Codigo = e.EMPRP_Codigo AND ep.EESTABC_FlagTipo LIKE '1' AND ep.EESTABC_FlagEstado LIKE '1' LIMIT 1)
                            ELSE ''
                        END as ubigeo,
                        CASE c.CLIC_TipoPersona
                            WHEN 0 THEN p.PERSC_Telefono
                            WHEN 1 THEN e.EMPRC_Telefono
                            ELSE ''
                        END as telefono,
                        CASE c.CLIC_TipoPersona
                            WHEN 0 THEN p.PERSC_Movil
                            WHEN 1 THEN e.EMPRC_Movil
                            ELSE ''
                        END as movil,
                        CASE c.CLIC_TipoPersona
                            WHEN 0 THEN p.PERSC_Fax
                            WHEN 1 THEN e.EMPRC_Fax
                            ELSE ''
                        END as fax,
                        CASE c.CLIC_TipoPersona
                            WHEN 0 THEN p.PERSC_Email
                            WHEN 1 THEN e.EMPRC_Email
                            ELSE ''
                        END as correo,
                        CASE c.CLIC_TipoPersona
                            WHEN 0 THEN p.PERSC_Web
                            WHEN 1 THEN e.EMPRC_Web
                            ELSE ''
                        END as web
            FROM cji_cliente c
            LEFT JOIN cji_persona p ON p.PERSP_Codigo = c.PERSP_Codigo
            LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = c.EMPRP_Codigo
            LEFT JOIN cji_emprestablecimiento ee ON e.EMPRP_Codigo = ee.EMPRP_Codigo
            LEFT JOIN cji_tipdocumento tp ON tp.TIPDOCP_Codigo = p.PERSC_TipoDocIdentidad
            LEFT JOIN cji_tipocodigo tc ON tc.TIPCOD_Codigo = e.TIPCOD_Codigo
            WHERE ee.EESTABP_Codigo = $codigo";
            
       //$sql = "SELECT ee.*,e.* FROM cji_emprestablecimiento ee LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = ee.EMPRP_Codigo  WHERE e.EESTAC_CodigoModular = $codigo";
        
        $query = $this->db->query($sql);

        if ($query->num_rows > 0)
            return $query->result();
        else
            return NULL;
    }
    
    public function getDireccionClienteUbigeo($clinte)
    {
        $sql=
        '
            SELECT 
            CASE c.CLIC_TipoPersona
            WHEN 0 THEN CONCAT_WS("__",per.UBIGP_Domicilio,per.PERSC_Direccion)
            WHEN 1 THEN e.EMPRC_Direccion
            END as UBIGEO,
            c.CLIC_TipoPersona as TipoPersona,
            ee.EESTAC_Direccion,
            ee.UBIGP_Codigo
            FROM cji_cliente c
            LEFT JOIN cji_persona per ON per.PERSP_Codigo=c.PERSP_Codigo
            LEFT JOIN cji_empresa e ON e.EMPRP_Codigo=c.EMPRP_Codigo
            LEFT JOIN cji_emprestablecimiento ee ON ee.EMPRP_Codigo=e.EMPRP_Codigo
            WHERE c.CLIP_Codigo='.$clinte;

            
            $query = $this->db->query($sql);

            if ($query->num_rows > 0)
                return $query->result();
            else
                return NULL;
    }
    
    
    public function getDireccionProveedorUbigeo($proveedor)
        {
            $sql=
            '
              SELECT  CASE p.PROVC_TipoPersona
                WHEN 0 THEN CONCAT_WS("__",per.UBIGP_Domicilio,per.PERSC_Direccion)
                WHEN 1 THEN emp.EMPRC_Direccion
                END as UBIGEO,
                p.PROVC_TipoPersona as TipoPersona,
                ee.EESTAC_Direccion,
                ee.UBIGP_Codigo
                FROM cji_proveedor as p
                LEFT join cji_persona per on per.PERSP_Codigo = p.PERSP_Codigo
                left join cji_empresa emp on emp.EMPRP_Codigo = p.EMPRP_Codigo
                left join cji_emprestablecimiento ee on ee.EMPRP_Codigo = emp.EMPRP_Codigo
                where p.PROVP_Codigo='.$proveedor;

                
                $query = $this->db->query($sql);

                if ($query->num_rows > 0)
                    return $query->result();
                else
                    return NULL;
        }
    
    public function getEmpresaEstablecimientobyEmpresa($empresa)
    {
        $sql="SELECT * FROM cji_emprestablecimiento WHERE EMPRP_Codigo=".$empresa;
            $query = $this->db->query($sql);

            if ($query->num_rows > 0)
                return $query->result();
            else
                return NULL;
    }

    #########################
    ##### FUNCTIONS NEWS
    #########################

        public function getEstablecimientos($filter = NULL){
            $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
            $order = ( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

            $where = '';
            if (isset($filter->empresa) && $filter->empresa != '')
                $where .= " AND e.EMPRP_Codigo = $filter->empresa";

            $sql = "SELECT e.*, te.TESTC_Descripcion, CONCAT_WS(' ', u.UBIGC_Descripcion, ' - ', u.UBIGC_DescripcionProv, ' - ', u.UBIGC_DescripcionDpto) as ubigeo_descripcion
                            FROM cji_emprestablecimiento e
                            LEFT JOIN cji_tipoestablecimiento te ON te.TESTP_Codigo = e.TESTP_Codigo
                            LEFT JOIN cji_ubigeo u ON u.UBIGP_Codigo = e.UBIGP_Codigo
                            WHERE e.EESTABC_FlagEstado LIKE '1'
                            $where
                            $order $limit
                    ";

            $query = $this->db->query($sql);
            if ($query->num_rows > 0)
                return $query->result();
            else
                return NULL;
        }

        public function getEstablecimiento($establecimiento){

            $sql = "SELECT e.* FROM cji_emprestablecimiento e WHERE e.EESTABP_Codigo = $establecimiento";
            $query = $this->db->query($sql);

            if ($query->num_rows > 0)
                return $query->result();
            else
                return NULL;
        }

        public function insertar_establecimiento($filter){
            $this->db->insert("cji_emprestablecimiento", (array) $filter);
            return $this->db->insert_id();
        }

        public function actualizar_establecimiento_principal($filter){
            $this->db->where('EMPRP_Codigo',$filter->EMPRP_Codigo);
            $this->db->where('EESTABC_FlagTipo','1');
            $this->db->where('EESTABC_FlagEstado','1');
            return $this->db->update('cji_emprestablecimiento', $filter);
        }

        public function actualizar_establecimiento($establecimiento, $filter){
            $this->db->where('EESTABP_Codigo',$establecimiento);
            return $this->db->update('cji_emprestablecimiento', $filter);
        }

    #########################
    ##### FUNCTIONS OLDS
    #########################

    public function listar($empresa, $tipo = '',$comp_select=null) {
        $this->db->where('cji_emprestablecimiento.EMPRP_Codigo', $empresa)->where('EESTABC_FlagEstado', '1');
        $this->db->where_in('cji_compania.COMPP_Codigo',$comp_select);
        if ($tipo !== '')
            $this->db->where('cji_emprestablecimiento.EESTABC_FlagTipo', $tipo);
        $this->db->join('cji_compania', 'cji_compania.EESTABP_Codigo = cji_emprestablecimiento.EESTABP_Codigo', 'left');
       
        $this->db->where_not_in('cji_emprestablecimiento.EESTABP_Codigo', '0')        
                ->order_by('EESTABC_Descripcion')->select('cji_emprestablecimiento.*,cji_compania.COMPP_Codigo');
        $query = $this->db->get('cji_emprestablecimiento');
        if ($query->num_rows > 0) {
            $result = $query->result();
            foreach ($result as $key => $reg) {
                $result[$key]->distrito = "";
                $result[$key]->provincia = "";
                $result[$key]->departamento = "";
                if ($reg->UBIGP_Codigo != '' && $reg->UBIGP_Codigo != '000000') {
                    $datos_ubigeo_dist = $this->ubigeo_model->obtener_ubigeo_dist($reg->UBIGP_Codigo);
                    $datos_ubigeo_prov = $this->ubigeo_model->obtener_ubigeo_prov($reg->UBIGP_Codigo);
                    $datos_ubigeo_dep = $this->ubigeo_model->obtener_ubigeo_dpto($reg->UBIGP_Codigo);
                    if (count($datos_ubigeo_dist) > 0)
                        $result[$key]->distrito = $datos_ubigeo_dist[0]->UBIGC_Descripcion;
                    if (count($datos_ubigeo_prov) > 0)
                        $result[$key]->provincia = $datos_ubigeo_prov[0]->UBIGC_Descripcion;
                    if (count($datos_ubigeo_dep) > 0)
                        $result[$key]->departamento = $datos_ubigeo_dep[0]->UBIGC_Descripcion;
                }
            }
            return $result;
        }else
            return array();
    }

    public function obtener($id) {
        $where = array("EESTABP_Codigo" => $id, "EESTABC_FlagEstado" => "1");
        $query = $this->db->where($where)->get('cji_emprestablecimiento');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $fila->distrito = "";
                $fila->provincia = "";
                $fila->departamento = "";
                if ($fila->UBIGP_Codigo != '' && $fila->UBIGP_Codigo != '000000') {
                    $datos_ubigeo_dist = $this->ubigeo_model->obtener_ubigeo_dist($fila->UBIGP_Codigo);
                    $datos_ubigeo_prov = $this->ubigeo_model->obtener_ubigeo_prov($fila->UBIGP_Codigo);
                    $datos_ubigeo_dep = $this->ubigeo_model->obtener_ubigeo_dpto($fila->UBIGP_Codigo);
                    if (count($datos_ubigeo_dist) > 0)
                        $fila->distrito = $datos_ubigeo_dist[0]->UBIGC_Descripcion;
                    if (count($datos_ubigeo_prov) > 0)
                        $fila->provincia = $datos_ubigeo_prov[0]->UBIGC_Descripcion;
                    if (count($datos_ubigeo_dep) > 0)
                        $fila->departamento = $datos_ubigeo_dep[0]->UBIGC_Descripcion;
                }
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function insertar(stdClass $filter = null) {
        $this->db->insert("cji_emprestablecimiento", (array) $filter);
    }

    public function modificar($id, $filter) {
        $this->db->where("EESTABP_Codigo", $id);
        $this->db->update("cji_emprestablecimiento", (array) $filter);
    }

    public function eliminar($id) {
        $this->db->delete('cji_emprestablecimiento', array('EESTABP_Codigo' => $id));
    }

    public function eliminarlog_establecimiento($id) {
        //$this->db->delete('cji_emprestablecimiento',array('EESTABP_Codigo' => $id));
        $data = array('EESTABC_FlagEstado' => 0);
        $this->db->where('EESTABP_Codigo', $id);
        $this->db->update('cji_emprestablecimiento', $data);
    }

}

?>