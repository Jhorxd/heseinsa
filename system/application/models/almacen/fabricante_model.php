<?php
class Fabricante_Model extends Model{

    protected $_name = "cji_fabricante";
    public function  __construct(){
        parent::__construct();
    }

    #########################
    ###### FUNCTIONS NEWS
    #########################

        public function getFabricantes($filter = NULL) {

            $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
            $order = ( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

            $where = '';
            if (isset($filter->descripcion) && $filter->descripcion != '')
                $where .= " AND f.FABRIC_Descripcion LIKE '%$filter->descripcion%'";

            $sql = "SELECT f.* FROM cji_fabricante f WHERE f.FABRIC_FlagEstado LIKE '1' $where $order $limit";

            $query = $this->db->query($sql);
            if ($query->num_rows > 0)
                return $query->result();
            else
                return array();
        }

        public function getFabricante($codigo) {

            $sql = "SELECT f.* FROM cji_fabricante f WHERE f.FABRIP_Codigo = $codigo $order $limit";
            $query = $this->db->query($sql);

            if ($query->num_rows > 0)
                return $query->result();
            else
                return array();
        }

        public function insertar_fabricante($filter){
            $this->db->insert("cji_fabricante", (array) $filter);
            return $this->db->insert_id();
        }

        public function actualizar_fabricante($fabricante, $filter){
            $this->db->where('FABRIP_Codigo',$fabricante);
            return $this->db->update('cji_fabricante', $filter);
        }

        public function deshabilitar_fabricante($fabricante, $filter){
            $this->db->where('FABRIP_Codigo',$fabricante);
            $query = $this->db->update('cji_fabricante', $filter);
            return $query;
        }

    #########################
    ###### FUNCTIONS OLDS
    #########################

    public function seleccionar(){
        $arreglo = array('0'=>':: Seleccione ::');
        if(count($this->listar())>0){
            foreach($this->listar() as $indice=>$valor)
            {
                $indice1   = $valor->FABRIP_Codigo;
                $valor1    = $valor->FABRIC_Descripcion;
                $arreglo[$indice1] = $valor1;
            }
        }
        return $arreglo;
    }
     public function listar($number_items='',$offset='')
     {
        $where = array("FABRIC_FlagEstado"=>1,'FABRIP_Codigo !='=>0);
        $query = $this->db->order_by('FABRIC_Descripcion')->where($where)->get('cji_fabricante',$number_items,$offset);
        if($query->num_rows>0){
                return $query->result();
        }
     }	 
     public function obtener($id)
     {
        $where = array("FABRIP_Codigo"=>$id);
        $query = $this->db->order_by('FABRIC_Descripcion')->where($where)->get('cji_fabricante',1);
        if($query->num_rows>0){
          return $query->result();
        }
     }
    public function insertar(stdClass $filter = null)
    {
        $this->db->insert("cji_fabricante",(array)$filter);
    }
    public function modificar($id,$filter)
    {
        $this->db->where("FABRIP_Codigo",$id);
        $this->db->update("cji_fabricante",(array)$filter);
    }
    public function eliminar($id)
    {
        $this->db->delete('cji_fabricante', array('FABRIP_Codigo' => $id));
    }
    public function buscar($filter,$number_items='',$offset='')
    {
        $where = array("FABRIC_FlagEstado"=>1,'FABRIP_Codigo !='=>0);
        $this->db->where($where);
        if(isset($filter->FABRIC_Descripcion) && $filter->FABRIC_Descripcion!='')
            $this->db->like('FABRIC_Descripcion',$filter->FABRIC_Descripcion,'right');
        $query = $this->db->get('cji_fabricante',$number_items,$offset);
        if($query->num_rows>0){
            return $query->result();
        }
    }
}
?>