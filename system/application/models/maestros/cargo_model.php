<?php
class Cargo_model extends Model{

	private $compania;
	private $usuario;
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('date');
        
        $this->compania = $this->session->userdata('compania');
        $this->usuario = $this->session->userdata('usuario');
	}

	###########################
	##### FUNCTIONS OLDS
	###########################

		public function listar_cargos($number_items='',$offset=''){
	        $compania = $this->compania;
	        $where = array("COMPP_Codigo"=>$compania,"CARGC_FlagEstado"=>"1");
			$query = $this->db->order_by('CARGC_Descripcion')->where_not_in('CARGP_Codigo','0')->where($where)->get('cji_cargo',$number_items,$offset);
			if($query->num_rows>0){
				foreach($query->result() as $fila){
					$data[] = $fila;
				}
				return $data;
			}
		}

		public function obtener_cargo($cargo){
			$query = $this->db->where('CARGP_Codigo',$cargo)->get('cji_cargo');
			if($query->num_rows>0){
				foreach($query->result() as $fila){
					$data[] = $fila;
				}
				return $data;
			}
		}

		public function insertar_cargo($descripcion){
	        $compania = $this->compania;
			$nombre = strtoupper($descripcion);
			$data = array(
	                                "CARGC_Descripcion"=>$nombre,
	                                "COMPP_Codigo"=>$compania
	                                );
			$this->db->insert("cji_cargo",$data);
		}

		public function modificar_cargo($cargo,$nombre){
			$nombre = strtoupper($nombre);
			$data  = array("CARGC_Descripcion"=>$nombre);
			$this->db->where("CARGP_Codigo",$cargo);
			$this->db->update('cji_cargo',$data);
		}

		public function eliminar_cargo($cargo){
			$where = array("CARGP_Codigo"=>$cargo);
			$this->db->delete('cji_cargo',$where);
		}

		public function buscar_cargos($filter,$number_items='',$offset=''){
	            $this->db->where('COMPP_Codigo',$this->compania);
	            if(isset($filter->nombre_cargo) && $filter->nombre_cargo!='')
	                $this->db->like('CARGC_Descripcion',$filter->nombre_cargo,'both');
	            $this->db->where_not_in('CARGP_Codigo','0');
	            $query = $this->db->get('cji_cargo',$number_items,$offset);
	            
	            if($query->num_rows>0){
	                foreach($query->result() as $fila){
	                        $data[] = $fila;
	                }
	                return $data;
	            }
		}

	###########################
	##### FUNCTIONS NEWS
	###########################

		public function getCargos($filter = NULL) {

	        $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
	        $order = ( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

	        $where = '';
	        if (isset($filter->nombre) && $filter->nombre != '')
	            $where .= " AND c.CARGC_Nombre LIKE '%$filter->nombre%'";

	        $sql = "SELECT * FROM cji_cargo c WHERE c.CARGC_FlagEstado LIKE '1' $where $order $limit";

	        $query = $this->db->query($sql);
	        if ($query->num_rows > 0) {
	            return $query->result();
	        }
	        return array();
	    }

	    public function getCargo($codigo) {

	        $sql = "SELECT * FROM cji_cargo c WHERE c.CARGP_Codigo = $codigo";
	        $query = $this->db->query($sql);

	        if ($query->num_rows > 0) {
	            return $query->result();
	        }
	        return array();
	    }

	    public function insertar($filter){
	        $this->db->insert("cji_cargo", (array) $filter);
	        return $this->db->insert_id();
	    }

	    public function actualizar($alergia, $filter){
	        $this->db->where('CARGP_Codigo',$alergia);
	        return $this->db->update('cji_cargo', $filter);
	    }
}
?>