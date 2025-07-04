<?php
class Almacen_Model extends Model{

    protected $_name = "cji_almacen";
    private $compania;

    public function  __construct(){
        parent::__construct();
        $this->compania = $this->session->userdata('compania');
    }

    #############################
    ####### FUNCTIONS NEWS
    #############################

        public function getAlmacens($filter = NULL) {

            $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
            $order = "ORDER BY ALMAP_Codigo ASC";//( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

            $where = '';
            if (isset($filter->descripcion) && $filter->descripcion != '')
                $where .= " AND a.ALMAC_Descripcion LIKE '%$filter->descripcion%'";

            if (isset($filter->tipo) && $filter->tipo != '')
                $where .= " AND a.TIPALM_Codigo = $filter->tipo";

            $sql = "SELECT a.*, ep.EESTABC_Descripcion, ta.TIPALM_Descripcion
                            FROM cji_almacen a
                            INNER JOIN cji_tipoalmacen ta ON ta.TIPALMP_Codigo = a.TIPALM_Codigo
                            INNER JOIN cji_emprestablecimiento ep ON ep.EESTABP_Codigo = a.EESTABP_Codigo
                            WHERE a.ALMAC_FlagEstado LIKE '1' AND a.COMPP_Codigo = $this->compania $where
                            $order $limit
                    ";

            $query = $this->db->query($sql);
            if ($query->num_rows > 0)
                return $query->result();
            else
                return array();
        }

        public function getAlmacen($codigo) {

            $sql = "SELECT a.*, ep.EESTABC_Descripcion, ta.TIPALM_Descripcion
                            FROM cji_almacen a
                            INNER JOIN cji_tipoalmacen ta ON ta.TIPALMP_Codigo = a.TIPALM_Codigo
                            INNER JOIN cji_emprestablecimiento ep ON ep.EESTABP_Codigo = a.EESTABP_Codigo
                            WHERE a.ALMAP_Codigo = $codigo
                            $order $limit
                    ";
            $query = $this->db->query($sql);

            if ($query->num_rows > 0)
                return $query->result();
            else
                return array();
        }

        public function insertar_almacen($filter){
            $this->db->insert("cji_almacen", (array) $filter);
            return $this->db->insert_id();
        }

        public function insertar_inventario($filter){
            $result = $this->db->insert("cji_inventario", (array) $filter);
            return $this->db->insert_id();
        }

        public function actualizar_almacen($almacen, $filter){
            $this->db->where('ALMAP_Codigo',$almacen);
            return $this->db->update('cji_almacen', $filter);
        }

        public function deshabilitar_almacen($almacen, $filter){
            $this->db->where('ALMAP_Codigo',$almacen);
            $query = $this->db->update('cji_almacen', $filter);
            return $query;
        }


    #############################
    ####### FUNCTIONS OLDS
    #############################
    
    public function update($id) {        
        $where = array("PROD_Codigo" => $id);
        $data = array("FAMI_Codigo" => 501);
        $this->db->where($where);
        $result = $this->db->update("cji_producto", $data);
        
        return $result;
    }
    
    public function seleccionar($compania=''){
        $listado = $this->listar($compania);

        if(count($listado) > 0){
            foreach($listado as $indice=>$valor){
                $indice1   = $valor->ALMAP_Codigo;
                $valor1    = $valor->EESTABC_Descripcion.' - '.$valor->ALMAC_Descripcion;
                $arreglo[$indice1] = $valor1;
            }
        }
        return $arreglo;
    }
        
    public function seleccionar_general($default=""){
        $nombre_defecto = $default==""?":: Seleccione ::":$default;
        $arreglo = array(''=>$nombre_defecto);
        foreach($this->listar_general() as $indice=>$valor)
        {
            $indice1   = $valor->ALMAP_Codigo;
            $valor1    = $valor->EESTABC_Descripcion.' - '.$valor->ALMAC_Descripcion;
            $arreglo[$indice1] = $valor1;
        }
        return $arreglo;
    }
	
    public function seleccionar_destino($compania='', $default=""){
        $nombre_defecto = $default==""?":: Seleccione ::":$default;
        $arreglo = array('0'=>$nombre_defecto);
        $listado    = $this->listar2($compania);
        if(count($listado)>0){
            foreach($listado as $indice=>$valor){
                $indice1   = $valor->ALMAP_Codigo;
                $valor1    = $valor->EESTABC_Descripcion.' - '.$valor->ALMAC_Descripcion;
                $arreglo[$indice1] = $valor1;
            }
        }
        return $arreglo;
    }

	public function listar2($empresa, $number_items='',$offset='' ){
        $this->db->select('*, cji_emprestablecimiento.EESTABC_Descripcion');
        $this->db->from('cji_almacen',$number_items,$offset);
        $this->db->join('cji_tipoalmacen','cji_tipoalmacen.TIPALMP_Codigo=cji_almacen.TIPALM_Codigo');
        $this->db->join('cji_emprestablecimiento','cji_emprestablecimiento.EESTABP_Codigo=cji_almacen.EESTABP_Codigo');
        $this->db->where('cji_almacen.ALMAC_FlagEstado',1);
        $this->db->where('cji_emprestablecimiento.EMPRP_Codigo',$empresa);
        $this->db->where_not_in('cji_almacen.ALMAP_Codigo','0');
        $this->db->order_by('cji_almacen.ALMAC_Descripcion');
        $query = $this->db->get();
        if($query->num_rows>0){
           return $query->result();
        }
    }

    public function seleccionar_destino_general(){
        $sql = "SELECT a.*, emp.EESTABC_Descripcion, e.EMPRC_RazonSocial, e.EMPRP_Codigo
                    FROM cji_almacen a
                    INNER JOIN cji_emprestablecimiento emp ON emp.EESTABP_Codigo = a.EESTABP_Codigo
                    INNER JOIN cji_empresa e ON e.EMPRP_Codigo = emp.EMPRP_Codigo
                    WHERE a.ALMAC_FlagEstado = 1 AND a.ALMAP_Codigo > 0 AND EXISTS(SELECT EESTABP_Codigo FROM cji_compania c WHERE c.EESTABP_Codigo = emp.EESTABP_Codigo )
                    ORDER BY e.EMPRC_RazonSocial DESC, a.ALMAC_Descripcion
                ";
        $query = $this->db->query($sql);
        if($query->num_rows>0){
           return $query->result();
        }
    }	 

    public function obtenerStockAlmacen($compania, $almacen, $producto){
        $query = $this->db->select('ALMPROD_Codigo, ALMPROD_STOCK, ALMPROD_CostoPromedio')
                        ->from('cji_almacenproducto')
                        ->where('COMPP_Codigo', $compania)
                        ->where('ALMAC_Codigo', $almacen)
                        ->where('PROD_Codigo', $producto)
                        ->get();
        if($query->num_rows > 0){
            return $query->row();
        }else{
            return NULL;
        }
    }

    public function listar($compania='', $number_items='',$offset='' ){
        $compania = ($compania != '') ? $compania : $this->compania;

        $this->db->select('*, cji_emprestablecimiento.EESTABC_Descripcion');
        $this->db->from('cji_almacen',$number_items,$offset);
        $this->db->join('cji_tipoalmacen','cji_tipoalmacen.TIPALMP_Codigo=cji_almacen.TIPALM_Codigo');
        $this->db->join('cji_emprestablecimiento','cji_emprestablecimiento.EESTABP_Codigo=cji_almacen.EESTABP_Codigo');
        $this->db->where('cji_almacen.ALMAC_FlagEstado',1);
        $this->db->where('cji_almacen.COMPP_Codigo ',$compania);
        $this->db->where_not_in('cji_almacen.ALMAP_Codigo','0');
        $this->db->order_by('cji_almacen.ALMAP_Codigo', 'DESC');
        $query = $this->db->get();
        if($query->num_rows>0){
           return $query->result();
        }
    }

    public function cargarAlmacenesPorCompania($compania){
        $this->db->select('*, cji_emprestablecimiento.EESTABC_Descripcion');
        $this->db->from('cji_almacen');
        $this->db->join('cji_tipoalmacen','cji_tipoalmacen.TIPALMP_Codigo=cji_almacen.TIPALM_Codigo');
        $this->db->join('cji_emprestablecimiento','cji_emprestablecimiento.EESTABP_Codigo=cji_almacen.EESTABP_Codigo');
        $this->db->where('cji_almacen.ALMAC_FlagEstado',1);
        $this->db->where('cji_almacen.COMPP_Codigo ',$compania);
        $this->db->where_not_in('cji_almacen.ALMAP_Codigo','0');
        $this->db->order_by('cji_almacen.ALMAC_Descripcion');
        $query = $this->db->get();
        if($query->num_rows>0){
            return $query->result();
        }else{
            return FALSE;
        }
    }

    public function listar_general($number_items='',$offset='') // Lista todos los almacenes de todas los establecimientos
    {
        $this->db->select('*, cji_emprestablecimiento.EESTABC_Descripcion');
        $this->db->from('cji_almacen',$number_items,$offset);
        $this->db->join('cji_tipoalmacen','cji_tipoalmacen.TIPALMP_Codigo=cji_almacen.TIPALM_Codigo');
        $this->db->join('cji_emprestablecimiento','cji_emprestablecimiento.EESTABP_Codigo=cji_almacen.EESTABP_Codigo');
        $this->db->where('cji_almacen.ALMAC_FlagEstado',1);
        $this->db->where_not_in('cji_almacen.ALMAP_Codigo','0');
        $this->db->order_by('cji_almacen.ALMAC_Descripcion');
        $query = $this->db->get();
        if($query->num_rows>0){
           return $query->result();
        }
    }
    public function buscar_x_establec($establec)
    {
        $where = array("EESTABP_Codigo"=>$establec, "ALMAC_FlagEstado"=>"1");
        $query = $this->db->order_by('ALMAC_Descripcion')->where($where)->get('cji_almacen');
        if($query->num_rows>0)
            return $query->result();
        else
            return array();
        
    }
    public function buscar_x_compania($compania){
        $where = array("COMPP_Codigo"=>$compania, "ALMAC_FlagEstado"=>"1");
        $query = $this->db->order_by('ALMAC_Descripcion')->where($where)->get('cji_almacen');
        if($query->num_rows>0)
            return $query->result();
        else
            return array();
        
    }
    
    public function obtener($id)
    {
        $where = array("ALMAP_Codigo"=>$id);
        $query = $this->db->order_by('ALMAC_Descripcion')->where($where)->get('cji_almacen',1);
        if($query->num_rows>0)
            return $query->result();
        else
            return array();
    }

    public function obtenerAlmacenCompania($compania){
        $compania = ($compania != '') ? $compania : $this->compania;

        $sql = "SELECT ALMAP_Codigo FROM cji_almacen WHERE COMPP_Codigo = $compania LIMIT 1";
        $query = $this->db->query($sql);
        
        if($query->num_rows > 0){
            foreach ($query->result() as $key => $val) {
                $data[] = $val;
            }
            return $data[0]->ALMAP_Codigo;
        }
        else
            return NULL;
    }

    public function insertar(stdClass $filter = null)
    {
        $this->db->insert("cji_almacen",(array)$filter);
    }
    public function modificar($id,$filter)
    {
        $this->db->where("ALMAP_Codigo",$id);
        $this->db->update("cji_almacen",(array)$filter);
    }
    public function eliminar($id)
    {
        $this->db->delete('cji_almacen',array('ALMAP_Codigo' => $id));
    }
	//--------------------------------
	 public function eliminar_x_establecimiento($establecimiento)
    {
        //$this->db->delete('cji_almacen',array('EESTABP_Codigo' => $establecimiento));
		$data = array('ALMAC_FlagEstado' => 0  );
		$this->db->where('EESTABP_Codigo', $establecimiento);
		$this->db->update('cji_almacen', $data); 
	}
	//-----------------------
    public function buscar($filter,$number_items='',$offset='')
    {
        $this->db->select('cji_almacen.*, e.EESTABC_Descripcion, t.TIPALM_Descripcion');
        $this->db->join('cji_tipoalmacen','cji_tipoalmacen.TIPALMP_Codigo=cji_almacen.TIPALM_Codigo');
        $this->db->where('cji_almacen.COMPP_Codigo',$this->compania);
        if(isset($filter->ALMAC_Descripcion) && $filter->ALMAC_Descripcion!="")
            $this->db->like('cji_almacen.ALMAC_Descripcion',$filter->ALMAC_Descripcion);
        if(isset($filter->TIPALM_Codigo) && $filter->TIPALM_Codigo!="")
            $this->db->like('cji_almacen.TIPALM_Codigo',$filter->TIPALM_Codigo);
        $query = $this->db->join('cji_emprestablecimiento e','e.EESTABP_Codigo=cji_almacen.EESTABP_Codigo')
                          ->join('cji_tipoalmacen t','t.TIPALMP_Codigo=cji_almacen.TIPALM_Codigo')
                          ->get('cji_almacen', $number_items='',$offset='');
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                    $data[] = $fila;
            }
            return $data;
        }
    }
    
      public function stock_general_por_almacenes($producto){
        $this->db->select("emp.EMPRC_RazonSocial, establ.EESTABC_Descripcion, alm.ALMAC_Descripcion, almpro.ALMPROD_Stock");
        $this->db->from("cji_empresa as emp");
        $this->db->join("cji_emprestablecimiento as establ", "establ.EMPRP_Codigo = emp.EMPRP_Codigo");
        $this->db->join("cji_almacen as alm", "alm.EESTABP_Codigo = establ.EESTABP_Codigo");
        $this->db->join("cji_almacenproducto as almpro", "almpro.ALMAC_Codigo = alm.ALMAP_Codigo");
        $this->db->join("cji_producto as prod", "prod.PROD_Codigo = almpro.PROD_Codigo");
        $this->db->where("prod.PROD_FlagEstado",1);
        $this->db->where("prod.PROD_FlagActivo",1);
        $this->db->where("emp.EMPRC_FlagEstado",1);
        $this->db->where("establ.EESTABC_FlagEstado",1);
        $this->db->where("alm.ALMAC_FlagEstado",1);
        $this->db->where("prod.PROD_Nombre like '%".$producto."%'");

        $response = $this->db->get();
        
        return $response->result();
        
    }
    
}
?>