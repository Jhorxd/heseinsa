<?php

class Tipocliente extends controller{

    private $empresa;
    private $compania;
    private $url;

    public function __construct(){
        parent::__construct();
        $this->load->model('ventas/tipocliente_model');
        
        $this->somevar['compania'] = $this->session->userdata('compania');

        $this->empresa = $this->session->userdata('empresa');
        $this->compania = $this->session->userdata('compania');
        $this->url = base_url();
    }

    #######################
    ##### FUNCTIONS NEWS
    #######################

        public function index() {
            $data['titulo'] = "CATEGORIA DE CLIENTE";
            $data['base_url'] = $this->url;
            $this->layout->view('ventas/tipocliente_index', $data);
        }

        public function datatable_categoria(){

            $columnas = array(
                                0 => "",
                                1 => "TIPCLIC_Descripcion"
                            );
            
            $filter = new stdClass();
            $filter->start = $this->input->post("start");
            $filter->length = $this->input->post("length");
            $filter->search = $this->input->post("search")["value"];

            $ordenar = $this->input->post("order")[0]["column"];
            if ($ordenar != ""){
                $filter->order = $columnas[$ordenar];
                $filter->dir = $this->input->post("order")[0]["dir"];
            }

            $item = ($this->input->post("start") != "") ? $this->input->post("start") : 0;

            $filter->descripcion = $this->input->post('descripcion');

            $categoriaInfo = $this->tipocliente_model->getCategorias($filter);
            $lista = array();
            
            if (count($categoriaInfo) > 0) {
                foreach ($categoriaInfo as $indice => $valor) {
                    $btn_modal = "<button type='button' onclick='editar($valor->TIPCLIP_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/modificar.png' class='image-size-1b'>
                                </button>";

                    $btn_eliminar = "<button type='button' onclick='deshabilitar($valor->TIPCLIP_Codigo)' class='btn btn-default'>
                                    <img src='".$this->url."/images/documento-delete.png' class='image-size-1b'>
                                </button>";

                    $lista[] = array(
                                        0 => $indice + 1,
                                        1 => $valor->TIPCLIC_Descripcion,
                                        2 => $btn_modal,
                                        3 => $btn_eliminar
                                    );
                }
            }

            unset($filter->start);
            unset($filter->length);

            $json = array(
                                "draw"            => intval( $this->input->post('draw') ),
                                "recordsTotal"    => count($this->tipocliente_model->getCategorias()),
                                "recordsFiltered" => intval( count($this->tipocliente_model->getCategorias($filter)) ),
                                "data"            => $lista
                        );

            echo json_encode($json);
        }

        public function getCategoria(){

            $categoria = $this->input->post("categoria");

            $categoriaInfo = $this->tipocliente_model->getCategoria($categoria);
            $lista = array();
            
            if ( $categoriaInfo != NULL ){
                foreach ($categoriaInfo as $indice => $val) {
                    $lista = array(
                                        "categoria" => $val->TIPCLIP_Codigo,
                                        "descripcion" => $val->TIPCLIC_Descripcion
                                    );
                }

                $json = array("match" => true, "info" => $lista);
            }
            else
                $json = array("match" => false, "info" => "");

            echo json_encode($json);
        }

        public function guardar_registro(){

            $categoria = $this->input->post("categoria");
            $descripcion = $this->input->post("descripcion_categoria");
            
            $filter = new stdClass();
            $filter->TIPCLIC_Descripcion = strtoupper($descripcion);
            $filter->TIPCLIC_FlagEstado = "1";

            if ($categoria != ""){
                $filter->TIPCLIP_Codigo = $categoria;
                $filter->TIPCLIC_FechaModificacion = date("Y-m-d H:i:s");
                $result = $this->tipocliente_model->actualizar_categoria($categoria, $filter);
            }
            else{
                $filter->COMPP_Codigo = $this->compania;
                $filter->TIPCLIC_FechaRegistro = date("Y-m-d H:i:s");
                $result = $this->tipocliente_model->insertar_categoria($filter);
            }

            if ($result)
                $json = array("result" => "success");
            else
                $json = array("result" => "error");
            
            echo json_encode($json);
        }

        public function deshabilitar_categoria(){

            $categoria = $this->input->post("categoria");

            $filter = new stdClass();
            $filter->TIPCLIC_FlagEstado  = "0";

            if ($categoria != ""){
                $filter->TIPCLIC_FechaModificacion = date("Y-m-d H:i:s");
                $result = $this->tipocliente_model->deshabilitar_categoria($categoria, $filter);
            }

            if ($result)
                $json = array("result" => "success");
            else
                $json = array("result" => "error");
            
            echo json_encode($json);
        }
}
?>