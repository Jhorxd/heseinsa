<?php
class Menu_model extends Model{

	public function __construct(){
		parent::__construct();
	}

	###########################
    ###### FUNCTIONS OLDS
    ###########################

		public function getMenus($filter = NULL) {

	        $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
	        $order = ( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

	        $where = '';
	        if (isset($filter->modulo) && $filter->modulo != '')
	            $where .= " AND m.MENU_Codigo_Padre = $filter->modulo";

	        if (isset($filter->menu) && $filter->menu != '')
	            $where .= " AND m.MENU_Descripcion LIKE '%$filter->menu%'";

	        $sql = "SELECT m.*,
	                        CASE m.MENU_AccesoRapido
	                            WHEN '0' THEN 'NO'
	                            WHEN '1' THEN 'SI'
	                            ELSE '---'
	                        END as acceso,
	                        CASE m.MENU_FlagEstado
	                            WHEN 0 THEN 'DESHABILITADO'
	                            WHEN 1 THEN 'ACTIVO'
	                            ELSE '---'
	                        END as estado,
	                        (SELECT sm.MENU_Descripcion FROM cji_menu sm WHERE sm.MENU_Codigo = m.MENU_Codigo_Padre) as modulo
	                    FROM cji_menu m
	                    WHERE m.MENU_FlagEstado IS NOT NULL $where $order $limit
	                ";

	        $query = $this->db->query($sql);
	        if ($query->num_rows > 0) {
	            return $query->result();
	        }
	        return array();
	    }

		public function getMenu($codigo) {

	        $sql = "SELECT m.*,
	                        CASE m.MENU_AccesoRapido
	                            WHEN '0' THEN 'NO'
	                            WHEN '1' THEN 'SI'
	                            ELSE '---'
	                        END as acceso,
	                        CASE m.MENU_FlagEstado
	                            WHEN 0 THEN 'DESHABILITADO'
	                            WHEN 1 THEN 'HABILITADO'
	                            ELSE '---'
	                        END as estado,
	                        (SELECT sm.MENU_Descripcion FROM cji_menu sm WHERE sm.MENU_Codigo = m.MENU_Codigo_Padre) as modulo
	                    FROM cji_menu m
	                    WHERE m.MENU_Codigo = $codigo
	                ";
	        $query = $this->db->query($sql);

	        if ($query->num_rows > 0) {
	            return $query->result();
	        }
	        return array();
	    }

		public function getModulos() {

	        $sql = "SELECT m.*,
	                        CASE m.MENU_AccesoRapido
	                            WHEN 0 THEN 'INACTIVO'
	                            WHEN 1 THEN 'ACTIVO'
	                            ELSE '---'
	                        END as acceso,
	                        CASE m.MENU_FlagEstado
	                            WHEN 0 THEN 'DESHABILITADO'
	                            WHEN 1 THEN 'HABILITADO'
	                            ELSE '---'
	                        END as estado
	                    FROM cji_menu m
	                    WHERE m.MENU_Codigo_Padre = 0;
	                ";
	        $query = $this->db->query($sql);

	        if ($query->num_rows > 0)
	            return $query->result();
	        else
	        	return array();
	    }

	    public function insertar($filter){
	        $this->db->insert("cji_menu", (array) $filter);
	        return $this->db->insert_id();
	    }

	    public function actualizar($menu, $filter){
	        $this->db->where('MENU_Codigo',$menu);
	        return $this->db->update('cji_menu', $filter);
	    }

    ###########################
    ###### FUNCTIONS OLDS
    ###########################

		public function obtener_datosMenu($menu){
			$query = $this->db->where('MENU_Codigo',$menu)->get('cji_menu');
			if($query->num_rows>0){
				foreach($query->result() as $fila){
					$data[] = $fila;
				}
				return $data;		
			}			
		}
		
		public function obtener_x_url($url){
			$query = $this->db->where('MENU_Url',$url)->get('cji_menu');
			if($query->num_rows>0){
				foreach($query->result() as $fila){
					$data[] = $fila;
				}
				return $data;		
			}
		}
}
?>