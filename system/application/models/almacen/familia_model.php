<?php
class Familia_model extends model{
    var $somevar;
	
	function __construct(){
            parent::__construct();
            $this->load->database();
            $this->somevar ['compania'] = $this->session->userdata('compania');
			$this->load->model('maestros/companiaconfiguracion_model');
	}

	public function getFamilias($filter = NULL) {

		$limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
		$order = ( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

		$where = '';
		if (isset($filter->nombre) && $filter->nombre != '')
			$where .= " AND c.FAMI_Descripcion LIKE '%$filter->nombre%'";

		$sql = "SELECT * FROM cji_familia c WHERE c.FAMI_FlagEstado LIKE '1' AND c.FAMI_FlagBienServicio= '$filter->flagBS' $where $order $limit";

		$query = $this->db->query($sql);
		if ($query->num_rows > 0) {
			return $query->result();
		}
		return array();
	}

	public function getFamilia($codigo) {

		$sql = "SELECT * FROM cji_familia c WHERE c.FAMI_Codigo = $codigo";
		$query = $this->db->query($sql);

		if ($query->num_rows > 0) {
			return $query->result();
		}
		return array();
	}

	public function insertar($filter){
        $this->db->insert("cji_familia", (array) $filter);
        return $this->db->insert_id();
    }

    public function actualizar($alergia, $filter){
        $this->db->where('FAMI_Codigo',$alergia);
        return $this->db->update('cji_familia', $filter);
    }

    


/****************************************************************************************/
	function listar_familias($flagBS, $codanterior='0'){
		
        $compania = $this->somevar['compania'];
		$names = $this->companiaconfiguracion_model->listar('4');
			if(COMPARTIR_FAMCOMPANIA==1){
		    	$where = array('FAMI_FlagEstado' => '1','FAMI_Codigo2' =>$codanterior, 'FAMI_FlagBienServicio'=>$flagBS);
                $query = $this->db->select('cji_familia.*')
                        ->from('cji_familiacompania')
                        ->join('cji_familia','cji_familia.FAMI_Codigo=cji_familiacompania.FAMI_Codigo')
                        ->where_not_in('cji_familiacompania.FAMI_Codigo','0')
                       
                        ->where($where)
                        ->order_by('FAMI_Descripcion')
                        ->get();
		}else{
			$where = array('FAMI_FlagEstado' => '1','FAMI_Codigo2' =>$codanterior, 'FAMI_FlagBienServicio'=>$flagBS);
		 
                $query = $this->db->select('cji_familia.*')
                        ->from('cji_familiacompania')	
                        ->join('cji_familia','cji_familia.FAMI_Codigo=cji_familiacompania.FAMI_Codigo')
                        ->where_not_in('cji_familiacompania.FAMI_Codigo','0')
                         ->where_in('cji_familiacompania.COMPP_Codigo',$compania)
                        ->where($where)
                        ->order_by('FAMI_Descripcion')
                        ->get(); 
		};
	 
		//}
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}		
	}
	
	
    function buscar_familias($codanterior, $filter){
		$where = array('FAMI_FlagEstado' => '1','FAMI_Codigo2' =>$codanterior);
		$names = $this->companiaconfiguracion_model->listar('4');
		$arr=array();
		$this->db->order_by('FAMI_Descripcion')->where_not_in('FAMI_Codigo','0')->where($where);
          
		if(isset($filter->codigo) && $filter->codigo!="")
			$this->db->where('FAMI_CodigoInterno', $filter->codigo);
		if(isset($filter->nombre) && $filter->nombre!="")
			$this->db->like('FAMI_Descripcion', $filter->nombre, 'both');
                $this->db->where('FAMI_FlagBienServicio', $filter->flagBS);
		   
                $query=$this->db->get('cji_familia');
		
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}		
	}
    function buscar_familias1($filter){
		$this->db->order_by('FAMI_Descripcion')->where_not_in('FAMI_Codigo','0');
          
		if(isset($filter->codigo) && $filter->codigo!="")
			$this->db->where('FAMI_CodigoInterno', $filter->codigo);
		if(isset($filter->nombre) && $filter->nombre!="")
			$this->db->like('FAMI_Descripcion', $filter->nombre, 'both');
		   
                $query=$this->db->get('cji_familia');
		
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}		
	}
        
 	//obtener    
	function obtener_familia($familia){
		$this->db->select("*");
		$this->db->where('FAMI_Codigo',$familia);
		$query = $this->db->get('cji_familia');
		if($query->num_rows>0){
                        foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;		
		}
	}
        
    function obtener_nomfamilia_total($familia){
		$nombre_familia='';
                $padre = $familia;
                do{
                    $datos_familia = $this->obtener_familia($padre);
                    if($datos_familia){
                        $nombre_familia = $datos_familia[0]->FAMI_Descripcion.' - '.$nombre_familia;
                        $padre          = $datos_familia[0]->FAMI_Codigo2;
                    }else
                        $padre=0;
                }while($padre!=0);
                
                return substr($nombre_familia,0,strlen($nombre_familia)-3);
	}
        
	function obtener_familia_max($flagBS='B', $codanterior='0')
	{
        $where = array('FAMI_FlagBienServicio'=>$flagBS, 'FAMI_FlagEstado' => '1','FAMI_Codigo2' => $codanterior);
		$this->db->select_max('FAMI_CodigoInterno');
		$query = $this->db->where($where)->get('cji_familia');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}		
	}
	
	function insertar_familia($flagBS,$descripcion,$codrelacion,$codigointerno, $codigousuario=''){
		$compania = $this->somevar['compania'];
		$data = array(
		"FAMI_FlagBienServicio"  => $flagBS,
		"FAMI_Descripcion"       => strtoupper($descripcion),
		"FAMI_Codigo2"           => $codrelacion,
		"FAMI_CodigoInterno"     => $codigointerno,
		"FAMI_CodigoUsuario"     => strtoupper($codigousuario)
		);
		$this->db->insert("cji_familia",$data);	
		$familia = $this->db->insert_id();

		$this->insertar_familia_compania($familia);

		return $familia;
	}
	
	public function insertar_familia_compania($familia){
		$data = array(
		"FAMI_Codigo"        => $familia,
		"COMPP_Codigo"       => $this->somevar['compania'],
		);
		$this->db->insert("cji_familiacompania",$data);
	}

	function modificar_familia($familia,$descripcion, $codigousuario){
		$data = array(
                             "FAMI_Descripcion"       => strtoupper($descripcion),
                             "FAMI_CodigoUsuario"     => strtoupper($codigousuario)
                             );
		$this->db->where('FAMI_Codigo',$familia);
		$this->db->update("cji_familia",$data);				 
	}

	function modificar_familia_numeracion($familia,$numero){
		$data = array("FAMI_Numeracion"       => $numero);
		$this->db->where('FAMI_Codigo',$familia);
		$this->db->update("cji_familia",$data);	
	}

	function eliminar_familia($familia){
		/*$data  = array("FAMI_FlagEstado" => '0');
		$where = array("FAMI_Codigo"     => $familia);
		$this->db->where($where);
		$this->db->update('cji_familia',$data);*/
                
                $where = array("FAMI_Codigo" => $familia, "COMPP_Codigo"=>$this->somevar['compania']);
                $this->db->delete('cji_familiacompania',$where);
	}

	function busqueda_familia(){
	
	}

	function obtener_familiacompania($famila,$compania){
	
		$where = array("FAMI_Codigo" => $famila, "COMPP_Codigo" => $compania);
        $query = $this->db->where($where)->get('cji_familiacompania');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
	}
	
	function insertar_familiacompania($famila,$compania){
	 	$data = array(
            "FAMI_Codigo" => $famila,
            "COMPP_Codigo" => $compania,
        );
        $this->db->insert("cji_familiacompania", $data);
	}
	
    public function busqueda_familia_hijos($cod){
    	$result = "";
    	$sql = "SELECT FAMI_Descripcion, FAMI_Codigo FROM cji_familia WHERE FAMI_Codigo2 = $cod";
    	$query 	= $this->db->query($sql);

    	if( $query->num_rows > 0 ){
    		foreach ($query->result() as $indice => $row) {
    	        $result .= $row->FAMI_Codigo.'/'.$this->busqueda_familia_hijos( $row->FAMI_Codigo );
    		}
    	}
    	return $result;
	}
	
	public function verificarFamiliaDetalle($ordAdj){

		$sql="select * from cji_familia where UPPER(FAMI_Descripcion) = '$ordAdj' ";
		$query = $this->db->query($sql);
		if ($query->num_rows > 0) {
			foreach ($query->result() as $fila) {
				$data[] = $fila;
			}
			return $data;
		}
		else
			return array();
	
	}
	
}
?>