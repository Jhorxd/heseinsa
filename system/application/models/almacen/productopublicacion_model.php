<?php
class Productopublicacion_Model extends Model
{
    protected $_name = "cji_productopublicacion";
     public function  __construct()
     {
        parent::__construct();
        $this->load->database();
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['usuario']  = $this->session->userdata('user');
     }
  
    public function listar($producto)
    {
        $where = array("PROD_Codigo"=>$producto, 'COMPP_Codigo'=>$this->somevar['compania'], 'PRODPUBC_FlagEstado'=>'1');
        $query = $this->db->where($where)->get('cji_productopublicacion');
        if($query->num_rows>0){
            return $query->result();
        }
        else
            return array();
    }
    
    
     public function despublicar_producto($cod)
    {
        $where = array("PROD_Codigo"=>$cod);
        $this->db->delete('cji_productopublicacion',$where);
      
    }
    
    
    public function insertar(stdClass $filter = null)
    {
        $this->db->insert("cji_productopublicacion",(array)$filter);
    }
  
}
?>