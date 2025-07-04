<?php
class Formapago_Model extends Model{

    protected $_name = "cji_formapago";
    
    public function  __construct(){
        parent::__construct();
    }

    #########################
    ###### FUNCTIONS NEWS
    #########################

        public function getFpagos($filter = NULL) {

            $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
            $order = ( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

            $where = '';
            if (isset($filter->descripcion) && $filter->descripcion != '')
                $where .= " AND f.FORPAC_Descripcion LIKE '%$filter->descripcion%'";

            $sql = "SELECT f.* FROM cji_formapago f WHERE f.FORPAC_FlagEstado LIKE '1' $where $order $limit";

            $query = $this->db->query($sql);
            if ($query->num_rows > 0)
                return $query->result();
            else
                return array();
        }

        public function getFpago($codigo) {

            $sql = "SELECT f.* FROM cji_formapago f WHERE f.FORPAP_Codigo = $codigo $order $limit";
            $query = $this->db->query($sql);

            if ($query->num_rows > 0)
                return $query->result();
            else
                return array();
        }

        public function insertar_fpago($filter){
            $this->db->insert("cji_formapago", (array) $filter);
            return $this->db->insert_id();
        }

        public function actualizar_fpago($fpago, $filter){
            $this->db->where('FORPAP_Codigo',$fpago);
            return $this->db->update('cji_formapago', $filter);
        }

        public function deshabilitar_fpago($fpago, $filter){
            $this->db->where('FORPAP_Codigo',$fpago);
            $query = $this->db->update('cji_formapago', $filter);
            return $query;
        }

    #########################
    ###### FUNCTIONS OLDS
    #########################
    
    public function seleccionar()
    {
        $arreglo = array(''=>':: Seleccione ::');
        foreach($this->listar() as $indice=>$valor)
        {
            $indice1   = $valor->FORPAP_Codigo;
            $valor1    = $valor->FORPAC_Descripcion;
            $arreglo[$indice1] = $valor1;
        }
        return $arreglo;
    }
     public function listar($number_items='',$offset='')
     {
        $where = array("FORPAC_FlagEstado"=>1);
        $query = $this->db->order_by('FORPAC_Descripcion')->where($where)->where_not_in('FORPAP_Codigo','0')->get('cji_formapago',$number_items,$offset);
        if($query->num_rows>0){
                return $query->result();
        }
     }
     
      public function listar_punto_venta()
     {
        $sql = "SELECT * FROM cji_formapago WHERE FORPAC_FlagEstado = 1 and FORPAP_Codigo not in (0,4,5,8) ORDER BY FORPAP_Codigo desc;";
        $query = $this->db->query($sql); 
        
        if($query->num_rows>0){
                return $query->result();
        }
        return array();
     }
     
     public function obtener($id)
     {
        $where = array("FORPAP_Codigo"=>$id);
        $query = $this->db->order_by('FORPAC_Descripcion')->where($where)->get('cji_formapago',1);
        if($query->num_rows>0){
          return $query->result();
        }
     }
     public function obtener2($id)
     {
        $where = array("FORPAP_Codigo"=>$id);
        $query = $this->db->order_by('FORPAC_Descripcion')->where($where)->get('cji_formapago',1);
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                    $data[] = $fila;
            }
            return $data;
        }
     }
    public function insertar(stdClass $filter = null)
    {
        $this->db->insert("cji_formapago",(array)$filter);
    }
    public function modificar($id,$filter)
    {
        $this->db->where("FORPAP_Codigo",$id);
        $this->db->update("cji_formapago",(array)$filter);
    }
    public function eliminar($id)
    {
        $this->db->delete('cji_formapago', array('FORPAP_Codigo' => $id));
    }
    public function buscar($filter,$number_items='',$offset='')
    {
        $this->db->where("FORPAC_FlagEstado",1);
        if(isset($filter->FORPAC_Descripcion) && $filter->FORPAC_Descripcion!='')
            $this->db->like('FORPAC_Descripcion',$filter->FORPAC_Descripcion,'right');
        $query = $this->db->get('cji_formapago',$number_items,$offset);
        if($query->num_rows>0){
                return $query->result();
        }
    }
}
?>