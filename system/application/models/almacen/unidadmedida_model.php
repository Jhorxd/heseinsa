<?php
class Unidadmedida_model extends model{
    
    private $empresa;
    private $compania;
    
    public function __construct(){
        parent::__construct();
        $this->load->helper('date');

        $this->empresa = $this->session->userdata('empresa');
        $this->compania = $this->session->userdata('compania');
    }


    #########################
    ###### FUNCTIONS NEWS
    #########################

        public function getUmedidas($filter = NULL) {

            $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
            $order = ( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

            $where = '';
            if (isset($filter->descripcion) && $filter->descripcion != '')
                $where .= " AND um.UNDMED_Descripcion LIKE '%$filter->descripcion%'";

            $sql = "SELECT um.* FROM cji_unidadmedida um WHERE um.UNDMED_FlagEstado LIKE '1' $where $order $limit";

            $query = $this->db->query($sql);
            if ($query->num_rows > 0)
                return $query->result();
            else
                return array();
        }

        public function getUmedida($codigo) {

            $sql = "SELECT um.* FROM cji_unidadmedida um WHERE um.UNDMED_Codigo = $codigo";
            $query = $this->db->query($sql);

            if ($query->num_rows > 0)
                return $query->result();
            else
                return array();
        }

        public function insertar_unidad($filter){
            $this->db->insert("cji_unidadmedida", (array) $filter);
            return $this->db->insert_id();
        }

        public function actualizar_unidad($um, $filter){
            $this->db->where('UNDMED_Codigo',$um);
            return $this->db->update('cji_unidadmedida', $filter);
        }

        public function deshabilitar_unidad($um, $filter){
            $this->db->where('UNDMED_Codigo',$um);
            $query = $this->db->update('cji_unidadmedida', $filter);
            return $query;
        }

    #########################
    ###### FUNCTIONS OLDS
    #########################
    
    public function seleccionar(){
        $arreglo = array(''=>':: Seleccione ::');
        foreach($this->listar() as $indice=>$valor)
        {
            $indice1   = $valor->UNDMED_Codigo;
            $valor1    = $valor->UNDMED_Descripcion;
            $arreglo[$indice1] = $valor1;
        }
        return $arreglo;
    }
    public function listar($number_items='',$offset='')
    {
        $query = $this->db->order_by('UNDMED_Descripcion')->where('UNDMED_FlagEstado','1')->get('cji_unidadmedida',$number_items,$offset);
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
    public function obtener($unidad)
    {
        $query = $this->db->where("UNDMED_Codigo",$unidad)->get("cji_unidadmedida");
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function getById($id)
    {
        $data = $this->db->where("UNDMED_Codigo",$id)->get("cji_unidadmedida")->result();

        return $data[0];
    }
    public function insertar(stdClass $filter = null)
    {
        $this->db->insert("cji_unidadmedida",(array)$filter);
    }
    public function modificar($id,$filter)
    {
        $this->db->where("UNDMED_Codigo",$id);
        $this->db->update("cji_unidadmedida",(array)$filter);
    }
    public function eliminar($id)
    {
        $this->db->delete('cji_unidadmedida',array('UNDMED_Codigo' => $id));
    }
    public function buscar($filter,$number_items='',$offset='')
    {
        $this->db->where("UNDMED_FlagEstado",1);
        if(isset($filter->UNDMED_Descripcion) && $filter->UNDMED_Descripcion!='')
            $this->db->like('UNDMED_Descripcion',$filter->UNDMED_Descripcion,'right');
        if(isset($filter->UNDMED_Simbolo) && $filter->UNDMED_Simbolo!='')
            $this->db->like('UNDMED_Simbolo',$filter->UNDMED_Simbolo,'right');
        $query = $this->db->get('cji_unidadmedida',$number_items,$offset);
        if($query->num_rows>0){
            return $query->result();
        }
    }
}
?>