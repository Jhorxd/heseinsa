<?php
class Linea_Model extends Model{

    protected $_name = "cji_linea";
    
    public function  __construct(){
        parent::__construct();
    }

    #########################
    ###### FUNCTIONS NEWS
    #########################

        public function getLineas($filter = NULL) {

            $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
            $order = ( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

            $where = '';
            if (isset($filter->descripcion) && $filter->descripcion != '')
                $where .= " AND l.LINC_Descripcion LIKE '%$filter->descripcion%'";

            $sql = "SELECT l.* FROM cji_linea l WHERE l.LINC_FlagEstado LIKE '1' $where $order $limit";

            $query = $this->db->query($sql);
            if ($query->num_rows > 0)
                return $query->result();
            else
                return array();
        }

        public function getLinea($codigo) {

            $sql = "SELECT l.* FROM cji_linea l WHERE l.LINP_Codigo = $codigo $order $limit";
            $query = $this->db->query($sql);

            if ($query->num_rows > 0)
                return $query->result();
            else
                return array();
        }

        public function insertar_linea($filter){
            $this->db->insert("cji_linea", (array) $filter);
            return $this->db->insert_id();
        }

        public function actualizar_linea($linea, $filter){
            $this->db->where('LINP_Codigo',$linea);
            return $this->db->update('cji_linea', $filter);
        }

        public function deshabilitar_linea($linea, $filter){
            $this->db->where('LINP_Codigo',$linea);
            $query = $this->db->update('cji_linea', $filter);
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
                $indice1   = $valor->LINP_Codigo;
                $valor1    = $valor->LINC_Descripcion;
                $arreglo[$indice1] = $valor1;
            }
        }
        return $arreglo;
    }
     public function listar($number_items='',$offset='')
     {
        $where = array("LINC_FlagEstado"=>1,"LINP_Codigo !="=>0);
        $query = $this->db->order_by('LINC_Descripcion')->where($where)->get($this->_name,$number_items,$offset);
        if($query->num_rows>0){
                return $query->result();
        }
     }	 
     public function obtener($id)
     {
        $where = array("LINP_Codigo"=>$id);
        $query = $this->db->order_by('LINC_Descripcion')->where($where)->get($this->_name,1);
        if($query->num_rows>0){
          return $query->result();
        }
     }
    public function insertar(stdClass $filter = null)
    {
        $this->db->insert($this->_name,(array)$filter);
    }
    public function modificar($id,$filter)
    {
        $this->db->where("LINP_Codigo",$id);
        $this->db->update($this->_name,(array)$filter);
    }
    public function eliminar($id)
    {
        $this->db->delete($this->_name, array('LINP_Codigo' => $id));
    }
    public function buscar($filter,$number_items='',$offset='')
    {
        $where = array("LINC_FlagEstado"=>1,"LINP_Codigo !="=>0);
        $this->db->where($where);
        if(isset($filter->LINC_Descripcion) && $filter->LINC_Descripcion!='')
            $this->db->like('LINC_Descripcion',$filter->LINC_Descripcion,'right');
        $query = $this->db->get($this->_name,$number_items,$offset);
        if($query->num_rows>0){
                return $query->result();
        }
    }
}
?>