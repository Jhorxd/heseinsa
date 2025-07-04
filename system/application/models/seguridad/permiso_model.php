<?php

class Permiso_model extends Model {

    private $empresa;
    private $compania;
    private $rol;

    public function __construct() {
        parent::__construct();
        $this->load->helper('date');
        $this->empresa = $this->session->userdata('empresa');
        $this->compania = $this->session->userdata('compania');
        $this->rol = $this->session->userdata('rol');
    }

    #####################
    #### FUNCTIONS NEWS
    #####################

        public function getModulos(){
            $sql = "SELECT * FROM cji_menu m WHERE m.MENU_Codigo_Padre = 0 AND m.MENU_FlagEstado LIKE '1' AND EXISTS(SELECT p.MENU_Codigo FROM cji_permiso p WHERE p.MENU_Codigo = m.MENU_Codigo AND p.ROL_Codigo = $this->rol)";
            $query = $this->db->query($sql);

            if ($query->num_rows > 0)
                return $query->result();
            else
                return NULL;
        }

        public function getPermisos($modulo){
            $sql = "SELECT p.*, m.MENU_Titulo, m.MENU_Descripcion
                        FROM cji_permiso p
                        INNER JOIN cji_menu m ON m.MENU_Codigo = p.MENU_Codigo
                        WHERE p.ROL_Codigo = $this->rol AND m.MENU_Codigo_Padre = $modulo
                    ";
            $query = $this->db->query($sql);

            if ($query->num_rows > 0)
                return $query->result();
            else
                return NULL;
        }

        public function getPermisosRol($rol){
            $sql = "SELECT p.*, m.MENU_Titulo, m.MENU_Descripcion, r.ROL_Descripcion
                        FROM cji_permiso p
                        INNER JOIN cji_menu m ON m.MENU_Codigo = p.MENU_Codigo
                        INNER JOIN cji_rol r ON r.ROL_Codigo = p.ROL_Codigo
                        WHERE p.ROL_Codigo = $rol
                    ";
            $query = $this->db->query($sql);

            if ($query->num_rows > 0)
                return $query->result();
            else
                return NULL;
        }

        public function registrar_permiso($filter){
            $this->db->insert("cji_permiso", (array) $filter);
            return $this->db->insert_id();
        }

        public function delete_menu_permiso($id){
            $sql = "DELETE FROM cji_permiso WHERE MENU_Codigo = $id";
            $this->db->query($sql);
        }

        public function clean_permisos($id){
            $sql = "DELETE FROM cji_permiso WHERE ROL_Codigo = $id";
            $this->db->query($sql);
        }

    #####################
    #### FUNCTIONS OLDS
    #####################

    public function busca_permiso($rol, $menu) {
        $query = $this->db->where('ROL_Codigo', $rol)->where('MENU_Codigo', $menu)->get('cji_permiso');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        else
            return array();
    }

    public function insertar(stdClass $filter = null) {
        $this->db->insert("cji_permiso", (array) $filter);
    }

    public function eliminar_varios($rol) {
        $this->db->delete('cji_permiso', array('ROL_Codigo' => $rol));
    }

    public function obtener_rol_compania($compania, $user) {
        $query = $this->db->where('cji_usuario_compania.COMPP_Codigo', $compania)
                ->where('cji_usuario_compania.USUA_Codigo', $user)
                ->from('cji_usuario_compania')
                ->select('cji_usuario_compania.ROL_Codigo,cji_rol.ROL_Descripcion')
                ->join('cji_rol','cji_usuario_compania.ROL_Codigo=cji_rol.ROL_Codigo')
                ->get();
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        else
            return array();
    }

    public function obtener_permisosMenu($perfil_id) {
        $CI = get_instance();
        $qu = $CI->db->from('cji_menu')
                ->join('cji_permiso', 'cji_permiso.MENU_Codigo  = cji_menu.MENU_Codigo ', 'inner')
                ->where('cji_permiso.ROL_Codigo', $perfil_id)
                ->where('MENU_Codigo_Padre', 0)
                ->where('cji_menu.MENU_FlagEstado', 1)
                ->get();
        $rows = $qu->result();

        foreach ($rows as $row) {
            $qur = $CI->db->from('cji_menu')
                    ->join('cji_permiso', 'cji_permiso.MENU_Codigo  = cji_menu.MENU_Codigo ', 'inner')
                    ->where('cji_permiso.ROL_Codigo ', $perfil_id)
                    ->where('MENU_Codigo_Padre', $row->MENU_Codigo)
                    ->order_by('MENU_OrderBy','ASC')
                    ->get();
            $row->submenus = $qur->result();
        }
        return $rows;
    }

    public function menuAccesoRapido($permiso){
        $sql = "SELECT m.MENU_Codigo, m.MENU_Descripcion, m.MENU_Titulo, m.MENU_Url, m.MENU_Icon, m.MENU_AccesoRapido, m.MENU_OrderBy
                    FROM cji_menu m
                    INNER JOIN cji_permiso p ON p.MENU_Codigo = m.MENU_Codigo
                    WHERE p.ROL_Codigo = $permiso AND m.MENU_Codigo_Padre > 0 AND m.MENU_FlagEstado = 1 AND p.PERM_FlagEstado = 1
                    ORDER BY m.MENU_Titulo DESC
                ";
        $query = $this->db->query($sql);
        $data = array();

        if ($query->num_rows > 0){
            foreach ($query->result() as $value) {
                $data[] = $value;
            }
        }
        return $data;
    }
}

?>