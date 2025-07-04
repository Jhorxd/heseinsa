<?php
class Alumno_Model extends Model{

    protected $table;
    
    public function  __construct(){
        parent::__construct();
        $this->table = "alumnos";
    }

    #########################
    ###### FUNCTIONS NEWS
    #########################

        public function getAlumnos($filter = NULL) {

            $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
            $order = ( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "ORDER BY nivel ASC, ano ASC, seccion ASC, apellidos ASC, nombres ASC";

            $where = '';

            if (isset($filter->descripcion) && $filter->descripcion != '')
                $where .= " AND CONCAT_WS(' ', m.correo, m.nombres, m.apellidos) LIKE '%$filter->descripcion%'";

            if (isset($filter->nivel) && $filter->nivel != ''){
                switch ($filter->nivel) {
                     case 'INICIAL':
                        $nivel1 = "INICIAL";
                        $nivel2 = "INICIAL";
                     case 'PRIMARIA':
                        $nivel1 = "PRIMARIA";
                        $nivel2 = "GRADO";
                         break;
                     case 'SECUNDARIA':
                        $nivel1 = "SECUNDARIA";
                        $nivel2 = "ANO";
                         break;
                }

                $where .= " AND ( m.grupo LIKE '%$nivel1%' OR m.grupo LIKE '%$nivel2%' )";
            }

            if (isset($filter->seccion) && $filter->seccion != '')
                $where .= " AND SUBSTRING(m.grupo, LENGTH( SUBSTRING_INDEX( SUBSTRING_INDEX(m.grupo, '@', 1), '2020', 1) ), 1 ) LIKE '%$filter->seccion%'";

            if (isset($filter->curso) && $filter->curso != '')
                $where .= " AND LEFT(m.grupo,1) LIKE '%$filter->curso%'";

            if (isset($filter->grupo) && $filter->grupo != '')
                $where .= " AND m.grupo LIKE '%$filter->grupo%'";

            $sql = "SELECT m.*,
                            CASE
                                WHEN SUBSTRING_INDEX( SUBSTRING_INDEX(m.grupo, '@', 1), '2020', 1) LIKE '%inicial%' THEN 'INICIAL'
                                WHEN SUBSTRING_INDEX( SUBSTRING_INDEX(m.grupo, '@', 1), '2020', 1) LIKE '%primaria%' THEN 'PRIMARIA'
                                WHEN SUBSTRING_INDEX( SUBSTRING_INDEX(m.grupo, '@', 1), '2020', 1) LIKE '%secundaria%' THEN 'SECUNDARIA'
                                WHEN SUBSTRING_INDEX( SUBSTRING_INDEX(m.grupo, '@', 1), '2020', 1) LIKE '%grado%' THEN 'PRIMARIA'
                                WHEN SUBSTRING_INDEX( SUBSTRING_INDEX(m.grupo, '@', 1), '2020', 1) LIKE '%ano%' THEN 'SECUNDARIA'
                                ELSE ''
                            END as nivel,
                            SUBSTRING(m.grupo, LENGTH( SUBSTRING_INDEX( SUBSTRING_INDEX(m.grupo, '@', 1), '2020', 1) ), 1 ) as seccion,
                            LEFT(m.grupo, 1) as ano

                        FROM $this->table m WHERE m.alumno <> 0 $where $order $limit";

            $query = $this->db->query($sql);
            if ($query->num_rows > 0)
                return $query->result();
            else
                return array();
        }

        public function getGrupos() {            
            $sql = "SELECT m.grupo,
                            CASE
                                WHEN SUBSTRING_INDEX( SUBSTRING_INDEX(m.grupo, '@', 1), '2020', 1) LIKE '%inicial%' THEN 'INICIAL'
                                WHEN SUBSTRING_INDEX( SUBSTRING_INDEX(m.grupo, '@', 1), '2020', 1) LIKE '%primaria%' THEN 'PRIMARIA'
                                WHEN SUBSTRING_INDEX( SUBSTRING_INDEX(m.grupo, '@', 1), '2020', 1) LIKE '%secundaria%' THEN 'SECUNDARIA'
                                WHEN SUBSTRING_INDEX( SUBSTRING_INDEX(m.grupo, '@', 1), '2020', 1) LIKE '%grado%' THEN 'PRIMARIA'
                                WHEN SUBSTRING_INDEX( SUBSTRING_INDEX(m.grupo, '@', 1), '2020', 1) LIKE '%ano%' THEN 'SECUNDARIA'
                                ELSE ''
                            END as nivel,
                            SUBSTRING(m.grupo, LENGTH( SUBSTRING_INDEX( SUBSTRING_INDEX(m.grupo, '@', 1), '2020', 1) ), 1 ) as seccion,
                            LEFT(m.grupo, 1) as ano

                        FROM $this->table m WHERE m.alumno <> 0 AND m.grupo IS NOT NULL GROUP BY m.grupo ORDER BY nivel ASC, ano ASC, seccion ASC";

            $query = $this->db->query($sql);
            if ($query->num_rows > 0)
                return $query->result();
            else
                return array();
        }

        public function getGruposA($grupo = "") {

            $where = "";
            if ($grupo != "")
                $where .= "AND m.grupo LIKE '%$grupo%'";

            $sql = "SELECT m.grupo,
                            CASE
                                WHEN SUBSTRING_INDEX( SUBSTRING_INDEX(m.grupo, '@', 1), '2020', 1) LIKE '%inicial%' THEN 'INICIAL'
                                WHEN SUBSTRING_INDEX( SUBSTRING_INDEX(m.grupo, '@', 1), '2020', 1) LIKE '%primaria%' THEN 'PRIMARIA'
                                WHEN SUBSTRING_INDEX( SUBSTRING_INDEX(m.grupo, '@', 1), '2020', 1) LIKE '%secundaria%' THEN 'SECUNDARIA'
                                WHEN SUBSTRING_INDEX( SUBSTRING_INDEX(m.grupo, '@', 1), '2020', 1) LIKE '%grado%' THEN 'PRIMARIA'
                                WHEN SUBSTRING_INDEX( SUBSTRING_INDEX(m.grupo, '@', 1), '2020', 1) LIKE '%ano%' THEN 'SECUNDARIA'
                                ELSE ''
                            END as nivel,
                            SUBSTRING(m.grupo, LENGTH( SUBSTRING_INDEX( SUBSTRING_INDEX(m.grupo, '@', 1), '2020', 1) ), 1 ) as seccion,
                            LEFT(m.grupo, 1) as ano
                        FROM $this->table m WHERE m.grupo IS NOT NULL $where GROUP BY m.grupo ORDER BY nivel ASC, ano ASC, seccion ASC";

            $query = $this->db->query($sql);
            if ($query->num_rows > 0)
                return $query->result();
            else
                return array();
        }

        public function getAlumno($codigo) {

            $sql = "SELECT m.* FROM $this->table m WHERE m.alumno = $codigo";
            $query = $this->db->query($sql);

            if ($query->num_rows > 0)
                return $query->result();
            else
                return array();
        }

        public function insertar_alumno($filter){
            $this->db->insert($this->table, (array) $filter);
            return $this->db->insert_id();
        }

        public function actualizar_alumno($alumno, $filter){
            $this->db->where('alumno',$alumno);
            return $this->db->update($this->table, $filter);
        }

        public function deshabilitar_alumno($alumno){
            $sql = "DELETE FROM $this->table WHERE alumno = '$alumno'";
            $query = $this->db->query($sql);
            return $query;
        }
}
?>