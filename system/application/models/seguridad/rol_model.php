<?php

class Rol_model extends Model{

	private $empresa;
	private $compania;
	private $usuario;
	private $hoy;

	public function __construct(){
		parent::__construct();
		$this->load->helper('date');
		$this->load->model('seguridad/permiso_model');
		$this->load->model('seguridad/menu_model');
		$this->compania = $this->session->userdata('empresa');
		$this->compania = $this->session->userdata('compania');
		$this->usuario = $this->session->userdata('usuario');
		$this->hoy = mdate("%Y-%m-%d %h:%i:%s",time());
	}

	#######################
	##### FUNCTIONS NEWS
	#######################

		public function getRoles($filter = NULL) {

	        $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
	        $order = ( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

	        $where = '';
	        if (isset($filter->nombre) && $filter->nombre != '')
	            $where .= " AND r.ROL_Descripcion LIKE '%$filter->nombre%'";

	        $sql = "SELECT * FROM cji_rol r WHERE r.ROL_FlagEstado LIKE '1' AND ROL_Descripcion NOT LIKE '%SISTEMAS%' $where $order $limit";

	        $query = $this->db->query($sql);
	        if ($query->num_rows > 0)
	            return $query->result();
	        else
	        	return array();
	    }

	    public function registrar_rol($filter){
	        $this->db->insert("cji_rol", (array) $filter);
	        return $this->db->insert_id();
	    }

	    public function actualizar_rol($rol, $filter){
	        $this->db->where('ROL_Codigo',$rol);
	        return $this->db->update('cji_rol', $filter);
	    }

	#######################
	##### FUNCTIONS OLDS
	#######################

	public function listar_roles( $compartirRol = false ){
		$empresa = $_SESSION['empresa'];
		$where = "";

		$companias = ($compartirRol == false) ? $this->listar_companias_empresa($empresa) : $this->listar_companias_empresa($empresa, true);
		if ( $companias != NULL ){
			$where .= " AND  (";
			$size = count($companias) - 1;
			foreach ($companias as $i => $value) {
				$where .= ( $i < $size ) ? " COMPP_Codigo = '$value->COMPP_Codigo' OR " : " COMPP_Codigo = '$value->COMPP_Codigo' ";
			}
			$where .= ")";
		}

		$sql = "SELECT * FROM cji_rol WHERE ROL_FlagEstado = '1' AND ROL_Descripcion NOT LIKE '%SISTEMAS%' $where ORDER BY 'ROL_Descripcion'";
		$query = $this->db->query($sql);

		if($query->num_rows()>0){
			return $query->result();
		}
	}

	public function listar_companias_empresa($empresa, $compartir = false) {
		$where = ($compartir == false) ? array('COMPC_FlagEstado' => '1', 'EMPRP_Codigo' => $empresa) : array('COMPC_FlagEstado' => '1', 'EMPRP_Codigo <=' => 100);
		$query = $this->db->where($where)->from('cji_compania')->get();
		if ($query->num_rows > 0) {
			foreach ($query->result() as $fila) {
				$data[] = $fila;
			}
			return $data;
		}
		else
			return NULL;
	}

	public function obtener_rol($rol){
		$query = $this->db->where('ROL_Codigo',$rol)->get('cji_rol');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}

	public function obtener_rol_permiso(){
		$where = array('MENU_Codigo_Padre'=>0,'MENU_FlagEstado'=>'1');
		$qu = $this->db->from('cji_menu')
		->where($where)
		->get();
		$rows = $qu->result();
		foreach($rows as $row){
			$where1 = array('MENU_Codigo_Padre'=>$row->MENU_Codigo,'MENU_FlagEstado'=>'1');
			$qur = $this->db->from('cji_menu')
			->where($where1 )
			->get();
			$row->submenus = $qur->result();
		}
		return $rows;
	}

	public function insertar(stdClass $filter,$checkO){
		$this->db->insert("cji_rol",(array)$filter);
		$rol=$this->db->insert_id();

		if(is_array($checkO)){
			foreach($checkO as $indice=>$valor){
				if($valor!=''){
					$filter=new stdClass();
					$filter->ROL_Codigo=$rol;
					$filter->MENU_Codigo=$valor;
					$filter->COMPP_Codigo=$this->compania;
					$this->permiso_model->insertar($filter);

					$temp=$this->menu_model->obtener_datosMenu($valor);
					$menu=$temp[0];
					$menu_padre=$menu->MENU_Codigo_Padre;

					if($menu_padre!=0){
						$temp=$this->permiso_model->busca_permiso($rol,$menu_padre);
						if(count($temp)==0){
							$filter=new stdClass();
							$filter->ROL_Codigo=$rol;
							$filter->MENU_Codigo=$menu_padre;
							$filter->COMPP_Codigo=$this->compania;
							$this->permiso_model->insertar($filter);
						}
					}
				}
			}
		}
	}

	public function modificar($rol,$filter,$checkO){
		$this->db->where("ROL_Codigo",$rol);
		$this->db->update("cji_rol",(array)$filter);
     	//Modificacion de permisos
		$this->permiso_model->eliminar_varios($rol);

		if(is_array($checkO)){
			foreach($checkO as $indice=>$valor){
				if($valor!=''){
					$filter=new stdClass();
					$filter->ROL_Codigo=$rol;
					$filter->MENU_Codigo=$valor;
					$filter->COMPP_Codigo=$this->compania;
					$this->permiso_model->insertar($filter);
					$temp=$this->menu_model->obtener_datosMenu($valor);
					$menu=$temp[0];
					$menu_padre=$menu->MENU_Codigo_Padre;

					if($menu_padre!=0){

						$temp=$this->permiso_model->busca_permiso($rol,$menu_padre);
						if(count($temp)==0){
							$filter=new stdClass();
							$filter->ROL_Codigo=$rol;
							$filter->MENU_Codigo=$menu_padre;
							$filter->COMPP_Codigo=$this->compania;
							$this->permiso_model->insertar($filter);
						}
					}
				}
			}
		}
	}

	public function eliminar($id){
      	//eliminado de la tabla permiso
		$this->db->delete('cji_permiso',array('ROL_Codigo' => $id));
      	// eliminado de la   tabla rol
		$this->db->where("ROL_Codigo",$id);
		$this->db->delete('cji_rol',array('ROL_Codigo' => $id));
	}

	public function buscar_roles($filter,$number_items='',$offset=''){
		$this->db->where('COMPP_Codigo',$this->compania);      
		$this->db->where_not_in('ROL_Codigo','0');
		if(isset($filter->nombres) && $filter->nombres!="")
			$this->db->like('ROL_Descripcion',$filter->nombres,'both');
		$query = $this->db->get('cji_rol',$number_items,$offset);
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
}
?>