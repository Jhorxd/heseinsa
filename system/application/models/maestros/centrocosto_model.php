<?php
class Centrocosto_model extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
         $this->somevar ['usuario']    = $this->session->userdata('usuario');
        $this->somevar['hoy']              = mdate("%Y-%m-%d %h:%i:%s",time());
	}
    public function listar_centros_costo(){
         $compania = $this->somevar['compania'];
         $where       = array("COMPP_Codigo"=>$compania,"CENCOSC_FlagEstado"=>"1");
          $query = $this->db->order_by('CENCOSC_Descripcion')->where($where)->get('cji_centrocosto');
          if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
    }	
    public function obtener_centro_costo($ccosto)
	{
		$query = $this->db->where('CENCOSP_Codigo',$ccosto)->get('cji_centrocosto');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
    }
    public function insertar_centro_costo($descripcion){
         $compania = $this->somevar['compania'];
		$data = array(
					"CENCOSC_Descripcion" => $descripcion,
                    "COMPP_Codigo"              => $compania
					);
		$this->db->insert("cji_centrocosto",$data);
    }
    public function modificar_centro_costo($ccosto,$descripcion){
         $data     = array("CENCOSC_Descripcion"=>$descripcion);
         $where = array("CENCOSP_Codigo"=>$ccosto);
		$this->db->where($where);
		$this->db->update('cji_centrocosto',$data);
    }
    public function eliminar_centro_costo($ccosto){
		$data      = array("CENCOSC_FlagEstado"=>'0');
		$where = array("CENCOSP_Codigo"=>$ccosto);
		$this->db->where($where);
		$this->db->update('cji_centrocosto',$data);
    }	
}
?>