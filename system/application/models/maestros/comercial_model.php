<?php
class Comercial_model extends Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
         $this->somevar ['usuario']    = $this->session->userdata('usuario');
        $this->somevar['hoy']              = mdate("%Y-%m-%d %h:%i:%s",time());
	}
	public function listar_comerciales($number_items='',$offset=''){
		$where = array("SECCOMC_FlagEstado"=>"1");
		$this->db->order_by('SECCOMP_Codigo','DESC');
		$query = $this->db->order_by('SECCOMC_Descripcion')->where_not_in('SECCOMP_Codigo','0')->where($where)->get('cji_sectorcomercial',$number_items,$offset);
		if($query->num_rows()>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
	public function obtener_comercial($comercial)
	{
		$query = $this->db->where('SECCOMP_Codigo',$comercial)->get('cji_sectorcomercial');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
	public function insertar_comercial($descripcion){
		$fecha=date('Y-m-d');
        $compania = $this->somevar['compania'];
		$nombre = strtoupper($descripcion);
		$data = array("SECCOMC_Descripcion"=>$nombre,
                               'SECCOMC_FechaRegistro'=>$fecha,'SECCOMC_FlagEstado'=>'1' );
		$this->db->insert("cji_sectorcomercial",$data);
	}
	public function modificar_comercial($comercial,$nombre)
	{
		$nombre = strtoupper($nombre);
		$data  = array("SECCOMC_Descripcion"=>$nombre);
		$this->db->where("SECCOMP_Codigo",$comercial);
		$this->db->update('cji_sectorcomercial',$data);
	}
	public function eliminar_comercial($comercial){
		$data  = array("SECCOMC_FlagEstado"=>'0');
		$this->db->where("SECCOMP_Codigo",$comercial);
		$this->db->update('cji_sectorcomercial',$data);
	}
	public function buscar_comerciales($filter,$number_items='',$offset='')
	{
      
            if(isset($filter->nombre_comercial) && $filter->nombre_comercial!='')
                $this->db->like('SECCOMC_Descripcion',$filter->nombre_comercial,'both');
            $this->db->where_not_in('SECCOMP_Codigo','0');
            $query = $this->db->get('cji_sectorcomercial',$number_items,$offset);
            
            if($query->num_rows>0){
                foreach($query->result() as $fila){
                        $data[] = $fila;
                }
                return $data;
            }
	}
}
?>