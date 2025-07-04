<?php
require_once 'system/application/libraries/PHPExcel/IOFactory.php';

class Producto extends Controller
{

    private $url;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->helper('util');
        $this->load->helper('utf_helper');

        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('html');
        $this->load->library('table');
        $this->load->library('lib_props');

        $this->load->model('almacen/atributo_model');
        $this->load->model('almacen/almacen_model');
        $this->load->model('almacen/almacenproducto_model');

        $this->load->model('almacen/fabricante_model');
        $this->load->model('almacen/familia_model');
        $this->load->model('almacen/marca_model');

        $this->load->model('almacen/guiarem_model');
        $this->load->model('almacen/guiatrans_model');

        $this->load->model('almacen/producto_model');
        $this->load->model('almacen/productounidad_model');
        $this->load->model('almacen/productoprecio_model');
        $this->load->model('almacen/productopublicacion_model');
        $this->load->model('almacen/unidadmedida_model');

        $this->load->model('almacen/lote_model');
        $this->load->model('almacen/loteprorrateo_model');

        $this->load->model('almacen/serie_model');
        $this->load->model('almacen/seriemov_model');
        $this->load->model('almacen/seriedocumento_model');

        $this->load->model('almacen/plantilla_model');
        $this->load->model('almacen/tipoproducto_model');

        $this->load->model('compras/proveedor_model');

        $this->load->model('maestros/empresa_model');
        $this->load->model('maestros/moneda_model');
        $this->load->model('maestros/persona_model');
        $this->load->model('maestros/moneda_model');
        $this->load->model('maestros/companiaconfiguracion_model');
        $this->load->model('maestros/emprestablecimiento_model');
        $this->load->model('maestros/tipocambio_model');
        $this->load->model('maestros/categoriapublicacion_model');

        $this->load->model('ventas/tipocliente_model');
        $this->load->model('ventas/cliente_model');
        $this->load->model('seguridad/usuario_model');

        $this->somevar['user'] = $this->session->userdata('user');
        $this->somevar['compania'] = $this->session->userdata('compania');
        $this->somevar['establec'] = $this->session->userdata('establec');

        $this->url = base_url();
    }

    public function index()
    {

        $this->layout->view('seguridad/inicio');
    }


    public function productos($flagBS = 'B', $j = '0', $limpia = '')
    {

        $data['action'] = base_url() . "index.php/almacen/producto/buscar_productos/" . $flagBS;
        $conf['base_url'] = site_url('almacen/producto/productos/' . $flagBS);

        $data['registros'] = count($this->producto_model->getProductosDatatable());
        $conf['total_rows'] = $data['registros'];

        $data['titulo_tabla'] = "RELACIÓN DE " . ($flagBS == 'B' ? 'ARTICULO' : 'SERVICIO');
        $data['titulo_busqueda'] = "BUSCAR " . ($flagBS == 'B' ? 'ARTICULO' : 'SERVICIO');
        $data['flagBS'] = $flagBS;

        $data['familias'] = $this->producto_model->getFamilias($flagBS);
        $data['modelos'] = $this->producto_model->getModelos();

        $filterOrden = new stdClass();
        $filterOrden->dir = "ASC";

        $filterOrden->order = "FABRIC_Descripcion";
        $data['fabricantes'] = $this->fabricante_model->getFabricantes($filterOrden);

        $filterOrden->order = "MARCC_Descripcion";
        $data['marcas'] = $this->marca_model->getMarcas($filterOrden);

        $filterOrden->order = "UNDMED_Descripcion";
        $data['unidades'] = $this->unidadmedida_model->getUmedidas($filterOrden);
        $data['afectaciones'] = $this->producto_model->tipo_afectacion();

        $data["precio_monedas"] = $this->moneda_model->getMonedas();
        $data["precio_categorias"] = $this->tipocliente_model->getCategorias();

        $data['oculto'] = form_hidden(array('base_url' => base_url(), 'flagBS' => $flagBS));

        $data['categorias'] = $this->producto_model->getCategorias();
        $data['totalesCat'] = $this->producto_model->getTotalesCategoria();

        $tam = count($data['totalesCat']);
        $data['totalesCat'][$tam]->categoria = "PRECIO COSTO";
        $data['totalesCat'][$tam]->total = $this->producto_model->getTotalPrecioCosto();
        $data['totalesCat'][$tam]->moneda = "S/ ";

        #$pcostoTotal = $this->producto_model->obtenerPrecioCostoTotal();
        $tam++;
        $pcostoTotal = 0;
        $pcostoTotal += $this->producto_model->getTotalPrecioCosto();
        $data['totalesCat'][$tam]->categoria = "TOTAL INVERSIÓN";
        $data['totalesCat'][$tam]->total = $pcostoTotal;
        $data['totalesCat'][$tam]->moneda = "S/ ";
        $this->layout->view('almacen/producto_index', $data);
    }

    public function datatable_productos($flagBS = 'B')
    {

        $columnas = array(
            0 => "PROD_CodigoUsuario",
            1 => "PROD_Nombre",
            2 => "FAMI_Descripcion",
            3 => "MARCC_Descripcion",
            4 => "PROD_UltimoCosto",
            5 => "UNDMED_Simbolo",
            6 => ""
        );

        $filter = new stdClass();
        $filter->start = $this->input->post("start");
        $filter->length = $this->input->post("length");
        $filter->search = $this->input->post("search")["value"];

        $ordenar = $this->input->post("order")[0]["column"];
        if ($ordenar != "") {
            $filter->order = $columnas[$ordenar];
            $filter->dir = $this->input->post("order")[0]["dir"];
        }

        $item = ($this->input->post("start") != "") ? $this->input->post("start") : 0;

        $filter->searchCodigoUsuario = $this->input->post("txtCodigo");
        $filter->searchProducto = $this->input->post("txtNombre");
        $filter->searchFamilia = $this->input->post("txtFamilia");
        $filter->searchModelo = $this->input->post("txtModelo");
        $filter->searchMarca = $this->input->post("txtMarca");
        $filter->searchFlagBS = $flagBS;

        $listado = $this->producto_model->getProductosDatatable($filter);
        $lista = array();

        if (count($listado) > 0) {
            foreach ($listado as $indice => $valor) {
                $posPrecio = $valor->PROD_Codigo . $valor->PROD_CodigoUsuario;
                $divNPC = '<div style="text-align: left;">
                                <div class="costo"> <img src="' . base_url() . 'images/icono_nuevo.png" height="14px"/>
                                    <span class="editar_costo">
                                        <form action="' . base_url() . '" method="POST">
                                            <input type="number" class="cajaMedia" placeholder="Precio costo" id="' . $posPrecio . '" name="' . $posPrecio . '" step="0.01" min="0.01" value="' . $valor->PROD_UltimoCosto . '"/>
                                            <span onclick="insertar_costo(\'' . $valor->PROD_Codigo . '\',\'' . $posPrecio . '\')"> <img src="' . base_url() . 'images/botonaceptar.jpg" id="btnCosto' . $posPrecio . '" name="btnCosto' . $posPrecio . '"/> </span>
                                            <img src="' . base_url() . 'images/loading.gif?=' . IMG . '" style="width:24px; display:none" id="loading' . $posPrecio . '" name="loading' . $posPrecio . '">
                                        </form>
                                    </span>
                                </div>
                                <span style="color:red; font-weight: bold" id="span' . $posPrecio . '" name="span' . $posPrecio . '">' . number_format($valor->PROD_UltimoCosto, 2) . '</span>
                            </div>';
                $posDT = 0;
                $lista[$indice] = array(
                    $posDT++ => $valor->PROD_CodigoUsuario,
                    $posDT++ => $valor->PROD_Nombre,
                    $posDT++ => $valor->FAMI_Descripcion,
                    $posDT++ => $valor->MARCC_Descripcion,
                    $posDT++ => $valor->UNDMED_Simbolo,
                    $posDT++ => $divNPC
                );

                $categorias = $this->producto_model->getPrecios($valor->PROD_Codigo);
                $j = 6;

                foreach ($categorias as $i => $v) {
                    $lista[$indice][$j] = "<span title='$v->TIPCLIC_Descripcion'>" . $v->precio . "</span>";
                    $j++;
                }

                $lista[$indice][$j] = "<button type='button' onclick='getProducto($valor->PROD_Codigo)' class='btn btn-default' title='Editar'>
                                            <img src='" . $this->url . "images/modificar.png' class='image-size-1b'>
                                       </button>";

                //Adicionales para productos 
                /*
                if ($valor->PROD_FlagEstado==1) {
                      $eliminar = "<button type='button' onclick='eliminar_producto($valor->PROD_Codigo)' class='btn btn-default' title='Desactivar'><img src='".$this->url."images/eliminar.png' class='image-size-1b'></button>";
                 }else{
                     $eliminar = "<button type='button' onclick='habilitar_producto($valor->PROD_Codigo)' class='btn btn-default' title='Activar'><img src='".$this->url."images/active.png' class='image-size-1b'></button>";
                 }

                 $j++;
                 $lista[$indice][$j] = $eliminar;
                 
                 
                 #$barcode = " <a onclick='barcode($valor->PROD_Codigo)' style='cursor:pointer;'><img src='" . base_url() . "images/barcode.png' width='40' height='40' border='0' title='Codigo de Barras'></a>";
                 
                 $barcode  = "<a href='".base_url()."index.php/almacen/producto/ver_barcode/$valor->PROD_Codigo' data-fancybox data-type='iframe'><img src='".base_url()."images/barcode.png' width='16' height='16' border='0' title='Codigo Barras'></a>";
                 $j++;
                 $lista[$indice][$j] = $barcode;
                 */

            }
        }

        unset($filter->start);
        unset($filter->length);

        $json = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval(count($this->producto_model->getProductosDatatable())),
            "recordsFiltered" => intval(count($this->producto_model->getProductosDatatable($filter))),
            "data" => $lista
        );

        echo json_encode($json);
    }

    public function datatable_list_stock()
    {

        $columnas = array(
            0 => "PROD_CodigoUsuario",
            1 => "PROD_Nombre",
            2 => "ALMPROD_Stock",
            3 => "PROD_StockMinimo"
        );

        $filter = new stdClass();
        $filter->start = $this->input->post("start");
        $filter->length = $this->input->post("length");
        $filter->search = $this->input->post("search")["value"];

        $ordenar = $this->input->post("order")[0]["column"];
        if ($ordenar != "") {
            $filter->order = $columnas[$ordenar];
            $filter->dir = $this->input->post("order")[0]["dir"];
        }

        $listado = $this->producto_model->listar_producto_stockmin($filter);
        $lista = array();

        if (count($listado) > 0) {
            foreach ($listado as $indice => $valor) {
                $lista[] = array(
                    0 => $valor->PROD_CodigoUsuario,
                    1 => $valor->PROD_Nombre,
                    2 => $valor->ALMPROD_Stock,
                    3 => $valor->PROD_StockMinimo
                );
            }
        }

        unset($filter->start);
        unset($filter->length);

        $json = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval(count($this->producto_model->listar_producto_stockmin())),
            "recordsFiltered" => intval(count($this->producto_model->listar_producto_stockmin($filter))),
            "data" => $lista
        );

        echo json_encode($json);
    }

    public function getProductoInfo()
    {
        $producto = $this->input->post("producto");
        $productoResult = $this->producto_model->getProducto($producto);

        if ($productoResult != NULL) {
            $productoInfo = array();
            $unidades = array();
            $precios = array();
            foreach ($productoResult as $i => $val) {
                $productoInfo = array(
                    "producto" => $val->PROD_Codigo,
                    "codigo" => $val->PROD_CodigoUsuario,
                    "nombre" => $val->PROD_Nombre,
                    "descripcion" => $val->PROD_DescripcionBreve,

                    "nvo_codigo_externo" => $val->PROD_CodigoOriginal,
                    //"sunatCodigo" => $val->PROD_CodigoOriginal,
                    "sunatDescripcion" => $val->PRODS_Descripcion,
                    "afectacion" => $val->AFECT_Codigo,
                    "familia" => $val->FAMI_Codigo,
                    "fabricante" => $val->FABRIP_Codigo,
                    "marca" => $val->MARCP_Codigo,
                    "modelo" => $val->PROD_Modelo,
                    "nvo_preciocosto" => $val->PROD_UltimoCosto,
                    "stockMin" => $val->PROD_StockMinimo
                );

                $productoUnidad = $this->productounidad_model->getProductoUnidad($val->PROD_Codigo);

                if ($productoUnidad != NULL) {
                    foreach ($productoUnidad as $indice => $valor) {
                        $unidades[] = array(
                            "unidad" => $valor->UNDMED_Codigo
                        );
                    }
                }

                $productoPrecio = $this->productoprecio_model->getProductoPrecios($val->PROD_Codigo);

                if ($productoPrecio != NULL) {
                    foreach ($productoPrecio as $indice => $valor) {
                        $precios[] = array(
                            "categoria" => $valor->TIPCLIP_Codigo,
                            "moneda" => $valor->MONED_Codigo,
                            "unidad" => $valor->PRODUNIP_Codigo,
                            "precio" => $valor->PRODPREC_Precio
                        );
                    }
                }
            }

            $json = array("match" => true, "producto" => $productoInfo, "unidades" => $unidades, "precios" => $precios);
        } else
            $json = array("match" => false);

        echo json_encode($json);
    }

    public function existsCode()
    {
        $codigo = trim($this->input->post("codigo"));
        $producto = $this->input->post("producto");
        $productoResult = $this->producto_model->existsCode($codigo, $producto);

        if ($productoResult != NULL)
            $json = array("match" => true);
        else
            $json = array("match" => false);

        echo json_encode($json);
    }

    public function existsNombre()
    {
        $nombre = trim($this->input->post("nombre"));
        $producto = $this->input->post("producto");
        $productoResult = $this->producto_model->existsNombre($nombre, $producto);

        if ($productoResult != NULL)
            $json = array("match" => true);
        else
            $json = array("match" => false);

        echo json_encode($json);
    }

    public function guardar_registro()
    {
        $this->load->library('upload');

        parse_str($this->input->post('info'), $form_data);


        // if ($form_data['id'] != "") {
        $id = $form_data['id'];
        // } else {
        //     $id = $form_data['id_p'];
        // }

        $flagBS = $form_data['flagB_S'];
        $codigo = $form_data['nvo_codigo'];
        $nombre = $form_data['nvo_nombre'];
        $autocompleteCodigoSunat = $form_data['nvo_autocompleteCodigoSunat'];
        $tipoAfectacion = $form_data['nvo_tipoAfectacion'];
        $descripcion = $form_data['nvo_descripcion'];
        $familia = $form_data['nvo_familia'];
        $fabricante = $form_data['nvo_fabricante'];
        $marca = $form_data['nvo_marca'];
        $modelo = $form_data['nvo_modelo'];
        $stockMin = $form_data['nvo_stockMin'];
        $nvo_preciocosto = $form_data['nvo_preciocosto'];
        $nvo_codigo_externo = $form_data['nvo_codigo_externo'];
        $unidad = $form_data['nvo_unidad'];
        $pmoneda = $form_data['nvo_pmoneda'];
        $pcategoria = $form_data['nvo_pcategoria'];
        $precios = $form_data['precios'];

        # REGISTRO PRODUCTO
        $filter = new stdClass();
        $filter->PROD_CodigoOriginal = $nvo_codigo_externo;
        $filter->PROD_FlagBienServicio = $flagBS;
        $filter->PROD_CodigoInterno = trim($codigo);
        $filter->PROD_CodigoUsuario = trim($codigo);
        //$filter->PROD_CodigoOriginal   = $codigoSunat;
        $filter->PROD_Nombre = trim($nombre);
        $filter->PROD_NombreCorto = trim($nombre);
        $filter->PROD_DescripcionBreve = $descripcion;
        $filter->PROD_DescripcionBreve = $descripcion;
        $filter->PROD_Modelo = $modelo;
        $filter->PROD_StockMinimo = $stockMin;
        $filter->PROD_UltimoCosto = $nvo_preciocosto;
        $filter->PROD_GenericoIndividual = "G";
        $filter->PROD_FlagActivo = "1";
        $filter->PROD_FlagEstado = "1";

        $filter->AFECT_Codigo = $tipoAfectacion;
        $filter->FAMI_Codigo = $familia;
        $filter->FABRIP_Codigo = $fabricante;
        $filter->MARCP_Codigo = $marca;

        $filter->TIPPROD_Codigo = NULL;
        $filter->PROD_Comentario = NULL;
        $filter->PROD_Imagen = NULL;
        $filter->PROD_EspecificacionPDF = NULL;
        $filter->LINP_Codigo = NULL;
        $filter->PROD_Presentacion = "";
        $filter->PROD_PadreCodigo = NULL;
        $filter->PROD_PartidaArancelaria = NULL;
        $filter->PROD_FichaTecnica = $rutadb;

        if ($id != NULL && $id != "") {
            $filter->PROD_FechaModificacion = NULL;
            $update = $this->producto_model->modificarRegistro($id, $filter);
        } else {
            $filter->PROD_FechaRegistro = NULL;
            $update = $this->producto_model->insertarNvoRegistro($filter);
            $id = $update;
        }

        $upload_path = './uploads/fichas/';
        $file_name = $id . '.pdf';
        $file_path = $upload_path . $file_name;

        if (file_exists($file_path)) {
            unlink($file_path); // Eliminar el archivo existente
        }

        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'pdf|PDF';
        $config['max_size'] = 2048; // 2MB
        $config['file_name'] = $file_name; // Usar el ID con la extensión .pdf

        $this->upload->initialize($config);

        $rutadb = NULL;

        if ($this->upload->do_upload('ficha')) {
            $upload_data = $this->upload->data();
            $ficha_path = $upload_data['file_name'];
            $rutadb = 'uploads/fichas/' . $file_name;
        }
        // else {
        //     $error = $this->upload->display_errors();
        //     echo json_encode(['result' => 'error', 'message' => $error]);
        //     return;
        // }

        if ($id != NULL && $id != "") {
            # REGISTRO UNIDAD
            $size = count($unidad);
            if ($size > 0) {
                $this->productounidad_model->cleanRegistro($id);
                $this->productoprecio_model->cleanRegistro($id);

                for ($i = 0; $i < $size; $i++) {
                    $filterUnidad = new stdClass();
                    $filterUnidad->UNDMED_Codigo = $unidad[$i];
                    $filterUnidad->PROD_Codigo = $id;
                    $filterUnidad->PRODUNIC_Factor = "1";
                    $filterUnidad->PRODUNIC_flagPrincipal = "1";
                    $idUnidad = $this->productounidad_model->insertarNvoRegistro($filterUnidad);

                    # REGISTRO PRECIOS
                    $sizeP = count($precios);
                    for ($j = 0; $j < $sizeP; $j++) {
                        $filterPrecio = new stdClass();
                        $filterPrecio->PROD_Codigo = $id;
                        $filterPrecio->TIPCLIP_Codigo = $pcategoria[$j];
                        $filterPrecio->EESTABP_Codigo = "1";
                        $filterPrecio->MONED_Codigo = $pmoneda[$j];
                        $filterPrecio->PRODUNIP_Codigo = $unidad[$i];
                        $filterPrecio->PRODPREC_PorcGanancia = NULL;
                        $filterPrecio->PRODPREC_Precio = $precios[$j];
                        $filterPrecio->PRODPREC_FechaRegistro = date("Y-m-d H:i:s");
                        $filterPrecio->PRODPREC_FlagEstado = "1";

                        $this->productoprecio_model->insertarNvoRegistro($filterPrecio);
                    }
                }
            }
        }

        if ($update)
            $json = array("result" => "success");
        else
            $json = array("result" => "error");

        echo json_encode($json);
    }

    public function insertar_establecimiento()
    {
        $filter = new stdClass();
        $compania = 1;
        $almacen = $this->input->post("checkalmacen");
        foreach ($almacen as $valores) {
            $filter->PROD_Codigo = $valores;
            $filter->COMPP_Codigo = $compania;


            $this->producto_model->insertar_establecimiento($filter);
        }
        redirect('almacen/producto/productos');
    }

    public function insertar_establecimiento2()
    {
        $filter = new stdClass();
        $compania = 2;
        $almacen = $this->input->post("checkalmacen");
        foreach ($almacen as $valores) {
            $filter->PROD_Codigo = $valores;
            $filter->COMPP_Codigo = $compania;


            $this->producto_model->insertar_establecimiento($filter);
        }
        redirect('almacen/producto/productos');
    }

    public function insertar_establecimiento3()
    {
        $filter = new stdClass();
        $compania1 = 1;
        $compania = 2;
        $almacen = $this->input->post("checkalmacen");
        foreach ($almacen as $valores) {
            $filter->PROD_Codigo = $valores;
            $filter->COMPP_Codigo = $compania;


            $this->producto_model->insertar_establecimiento($filter);
        }

        foreach ($almacen as $valores) {
            $filter->PROD_Codigo = $valores;
            $filter->COMPP_Codigo = $compania1;


            $this->producto_model->insertar_establecimiento($filter);
        }


        redirect('almacen/producto/productos');
    }

    public function nuevo_producto($flagBS = 'B', $flagError = 0)
    {

        $this->load->model('almacen/fabricante_model');
        $this->load->model('almacen/linea_model');
        $this->load->model('almacen/marca_model');
        $accion = "";
        $modo = "insertar";
        $codigo = "";
        $data['flagBS'] = $flagBS;
        $data['modo'] = $modo;
        $data['cbo_tipoProducto'] = $this->seleccionar_tipos_producto($flagBS);
        $data['cbo_fabricante'] = form_dropdown('fabricante', $this->fabricante_model->seleccionar(), '', "id='fabricante' class='comboMedio'");
        $data['cbo_linea'] = form_dropdown('linea', $this->linea_model->seleccionar(), '', "id='linea' class='comboMedio'");
        $data['cbo_marca'] = form_dropdown('marca', $this->marca_model->seleccionar(), '', "id='marca' class='comboMedio'");
        $data['fila'] = $this->obtener_datosAtributos('1');
        $data['filaunidad'] = $this->obtener_datosUnidad();
        $data['url_action'] = base_url() . "index.php/almacen/producto/insertar_producto";
        $data['titulo'] = "REGISTRAR " . ($flagBS == 'B' ? 'ARTICULO' : 'SERVICIO');
        $data['unidad_medida'] = "";
        $data['proveedor'] = "";
        $data['stock_min'] = 0;
        $data['familia'] = "";
        $data['nombre_producto'] = "";
        $data['partida_arancelaria'] = "";
        $data['nombrecorto_producto'] = "";
        $data['imagen'] = "";
        $data['especificacionPDF'] = "";
        $data['modelo'] = "";
        $data['presentacion'] = "";
        $data['geneindi'] = "";
        $data['nombre_familia'] = "";
        $data['descripcion_breve'] = "";
        $data['comentario'] = "";
        $data['stock'] = "";
        $data['ruc'] = "";
        $data['nombres'] = "";
        $data['flagActivo'] = "1";
        $data['checked'] = "checked='checked'";
        $data['display'] = "";
        $data['readonly'] = "";
        $data['lista_proveedores'] = array();
        $data['producto'] = $codigo;
        $data['codigo_familia'] = $this->input->post('codigo_familia');
        $data['padre'] = "";
        $data['codpadre'] = "";
        $data['nompadre'] = "";
        $data['codigo_usuario'] = "";
        $data['cboTipoAfectacion'] = $this->lib_props->tipo_afectacion();

        ///stv
        $data['codigo_original'] = "";
        ///

        $data['flagError'] = $flagError;
        $atributos = array('width' => 500, 'height' => 400, 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');
        $atributos_prov = array('width' => 600, 'height' => 400, 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');
        $atributos_prod = array('width' => 700, 'height' => 450, 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');
        $atributos_string = "width=500,height=400,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0";
        $contenido = "<img height='16' width='16' src='" . base_url() . "images/ver.png' title='' border='0'>";
        $data['ver'] = anchor_popup('almacen/familia/nueva_familia', $contenido, $atributos);
        $data['verproveedor'] = anchor_popup('compras/proveedor/ventana_busqueda_proveedor', $contenido, $atributos_prov);
        $data['verproducto'] = anchor_popup('almacen/producto/ventana_busqueda_producto', $contenido, $atributos_prod);
        $data['verfamilia_js'] = "ondblclick='window.open(\"" . base_url() . "index.php/almacen/familia/nueva_familia\",\"_blank\",\"" . $atributos_string . "\");'";
        $data['onload'] = "onload=\"$('#nombre_producto').select();$('#nombre').focus();\"";
        $data['oculto'] = form_hidden(array('accion' => $accion, 'codigo' => $codigo, 'modo' => $modo, 'base_url' => base_url(), 'url_image' => URL_IMAGE, 'flagBS' => $flagBS));
        $data['codigo_producto'] = "";
        $data['tabla_precios'] = "";

        $this->layout->view("almacen/producto_nuevo", $data);
    }

    //$flag_nuevo = true => cuando inserto un proucto por un popup
    public function insertar_producto($flag_nuevo = false)
    {
        $nuevonombre_imagen = '';
        $config['upload_path'] = 'images/img_db/';
        $config['allowed_types'] = 'jpg|gif|png';
        $config['max_size'] = '5120';
        $config['max_width'] = '0';
        $config['max_height'] = '0';


        $nuevonombre_imagen = $this->input->post('imagen');
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('imagen')) {
            $error = '';
            $nuevonombre_imagen = "";
        } else {
            $data1 = $this->upload->data();
            $nuevonombre_imagen = $data1['file_name'];
            //  print_r($nuevonombre_imagen);
        }

        $nuevonombre_pdf = '';
        if (isset($_FILES['pdf']['name']) && $_FILES['pdf']['name'] != "") {
            $origen = $_FILES['pdf']['tmp_name'];
            $temp = explode('.', $_FILES['pdf']['name']);

            if (in_array($temp[1], array('pdf'))) {
                $nuevonombre_pdf = $temp[0] . '_' . date('Ymd_His') . '.' . $temp[1];
                $destino = "pdf/" . $nuevonombre_pdf;
                move_uploaded_file($origen, $destino);
            }
        }

        $familia = $this->input->post('familia');
        $codigo_familia = $this->input->post('codigo_familia');
        $nombre_producto = $this->input->post('nombre_producto');
        #$nombre_producto = str_replace("\"", " ", $nombre_producto);
        #$nombre_producto = str_replace("'", " ", $nombre_producto);
        $this->firephp->fb($nombre_producto, "nombre");
        $nombrecorto_producto = $this->input->post('nombre_producto');        //stv  $this->input->post('nombrecorto_producto');
        $descripcion_breve = $this->input->post('descripcion_producto');
        $proveedor = $this->input->post('proveedor');
        $tipo_producto = $this->input->post('tipo_producto');
        $unidad_medida = $this->input->post('unidad_medida');
        $atributo = $this->input->post('atributo');
        $nombre_atributo = $this->input->post('nombre_atributo');
        $comentario = $this->input->post('comentario');
        $imagen = $nuevonombre_imagen;
        $pdf = $nuevonombre_pdf;
        $modelo = $this->input->post('modelo');
        $presentacion = $this->input->post('presentacion');
        $geneindi = $this->input->post('geneindi');
        $estado = $this->input->post('estado');

        $factorprin = $this->input->post('factorprin');

        $factor = $this->input->post('factor');
        $flagPrincipal = $this->input->post('flagPrincipal');
        $fabricante = $this->input->post('fabricante');
        $linea = $this->input->post('linea');
        $stock_min = $this->input->post('stock_min');
        $marca = $this->input->post('marca');
        $padre = $this->input->post('padre');

        $codigo_usuario = $this->input->post('codigo_usuario');
        $codigo_original = $this->input->post('codigo_original');
        $tipoAfectacion = $this->input->post('afectacion');

        if ($codigo_usuario == "") {
            $datos_codusu = $this->producto_model->obtener_maxcodigousu();
            $codigousu = $datos_codusu[0]->PROD_CodigoUsuario;
            $codigousu += 1;
            $codigo_usuario = $codigousu;
        }

        $flagBS = $this->input->post('flagBS');

        $filter = new stdClass();
        $filter->codigo = $codigo_usuario;
        $filter->flagBS = $flagBS;
        $conteo = $this->producto_model->buscar_productos($filter);
        if ($flagBS) {
            $config['upload_path'] = './upload/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '100';
            $config['max_width'] = '1024';
            $config['max_height'] = '768';
            $this->load->library('upload', $config);
            /* Insertar producto */

            $codigo = $this->producto_model->insertar_producto_total($proveedor, $familia, $tipo_producto, $nombre_producto, $descripcion_breve, $comentario, $unidad_medida, $factor, $flagPrincipal, $atributo, $nombre_atributo, $codigo_familia, $fabricante, $linea, $marca, $imagen, $pdf, $modelo, $presentacion, $geneindi, $padre, $codigo_usuario, $nombrecorto_producto, $flagBS, $stock_min, $factorprin, $codigo_original, $tipoAfectacion, $this->input->post('partida-arancelaria'));
            // print_r($codigo);
            //echo '$codigo';
            $this->guardar_precios($codigo);
            if ($flag_nuevo == false)
                $this->editar_producto($codigo, true);
            else
                $this->editar_producto_popup($codigo, true);

        } else {
            $this->nuevo_producto($flagBS, 1);
        }
    }

    public function nvoCosto()
    {
        $exito = 0;
        $codigo = $this->input->post('codigo');
        $costo = $this->input->post('nvoCosto');
        if ($codigo != '')
            $exito = $this->producto_model->nvoCosto($codigo, $costo);

        if ($exito == 1)
            $json = array("result" => "success", "msg" => "PRECIO ACTUALIZADO");
        else
            $json = array("result" => "error", "msg" => "EL PRECIO NO PUDO SER ACTUALIZADO. INTENTELO NUEVAMENTE.");

        echo json_encode($json);
    }

    public function editar_producto_popup($codigo, $flagGuardado = false)
    {
        //$this->load->library('layout','layout');
        $this->load->model('almacen/fabricante_model');
        $this->load->model('almacen/linea_model');
        $this->load->model('almacen/marca_model');
        $this->load->model('almacen/productoproveedor_model');
        $accion = "";
        $modo = "modificar";
        $datos_producto = $this->producto_model->obtener_producto($codigo);
        $familia = $datos_producto[0]->FAMI_Codigo;
        $tipo_producto = $datos_producto[0]->TIPPROD_Codigo;
        $fabricante = $datos_producto[0]->FABRIP_Codigo;
        $linea = $datos_producto[0]->LINP_Codigo;
        $marca = $datos_producto[0]->MARCP_Codigo;
        $flagBS = $datos_producto[0]->PROD_FlagBienServicio;

        $data['flagBS'] = $flagBS;
        $data['modo'] = $modo;
        $data['familia'] = $datos_producto[0]->FAMI_Codigo;
        $data['nombre_producto'] = $datos_producto[0]->PROD_Nombre;
        $data['nombrecorto_producto'] = $datos_producto[0]->PROD_NombreCorto;
        $data['descripcion_breve'] = $datos_producto[0]->PROD_DescripcionBreve;
        $data['imagen'] = $datos_producto[0]->PROD_Imagen;
        $data['especificacionPDF'] = $datos_producto[0]->PROD_EspecificacionPDF;
        $data['modelo'] = $datos_producto[0]->PROD_Modelo;
        $data['presentacion'] = $datos_producto[0]->PROD_Presentacion;
        $data['geneindi'] = $datos_producto[0]->PROD_GenericoIndividual;
        $data['comentario'] = $datos_producto[0]->PROD_Comentario;
        $data['stock'] = $datos_producto[0]->PROD_Stock;
        $data['flagActivo'] = $datos_producto[0]->PROD_FlagActivo;
        $data['codigo_producto'] = $datos_producto[0]->PROD_CodigoInterno;
        $data['codigo_familia'] = '';
        $data['nombre_familia'] = '';
        if ($familia != '') {
            $data['codigo_familia'] = substr($datos_producto[0]->PROD_CodigoInterno, 0, strrpos($datos_producto[0]->PROD_CodigoInterno, '.') + 1);
            $data['nombre_familia'] = $this->familia_model->obtener_nomfamilia_total($familia);
        }
        $data['cbo_tipoProducto'] = $this->seleccionar_tipos_producto($datos_producto[0]->PROD_FlagBienServicio, $tipo_producto);
        $data['cbo_fabricante'] = form_dropdown('fabricante', $this->fabricante_model->seleccionar(), $fabricante, "id='fabricante' class='comboMedio'");
        $data['cbo_linea'] = form_dropdown('linea', $this->linea_model->seleccionar(), $linea, "id='linea' class='comboMedio'");
        $data['cbo_marca'] = form_dropdown('marca', $this->marca_model->seleccionar(), $marca, "id='marca' class='comboMedio'");
        $data['padre'] = "";
        $data['codpadre'] = "";
        $data['nompadre'] = "";
        $datos_producto_padre = array();
        if ($datos_producto[0]->PROD_PadreCodigo != '' && $datos_producto[0]->PROD_PadreCodigo != '0')
            $datos_producto_padre = $this->producto_model->obtener_producto($datos_producto[0]->PROD_PadreCodigo);
        if (!empty($datos_producto_padre)) {
            $data['padre'] = $datos_producto_padre[0]->PROD_Codigo;
            $data['codpadre'] = $datos_producto_padre[0]->PROD_CodigoInterno;
            $data['nompadre'] = $datos_producto_padre[0]->PROD_Nombre;
        }
        $data['codigo_usuario'] = $datos_producto[0]->PROD_CodigoUsuario;
        $data['fila'] = $this->obtener_datosAtributos($tipo_producto, $codigo);
        $data['filaunidad'] = $this->obtener_datosUnidad($codigo);
        $data['url_action'] = base_url() . "index.php/almacen/producto/modificar_producto";
        $data['oculto'] = form_hidden(array('accion' => $accion, 'codigo' => $codigo, 'modo' => $modo, 'base_url' => base_url(), 'flagBS' => $flagBS));
        $data['titulo'] = "EDITAR PRODUCTO :: " . $data['nombre_producto'];
        $data['producto'] = $codigo;
        $data['checked'] = $datos_producto[0]->PROD_FlagActivo == 1 ? "checked='checked'" : "";
        $data['display'] = "style='display:none;'";
        $data['readonly'] = "readonly='readonly'";
        $data['onload'] = "onload=\"$('#nombre_familia').select();$('#nombre_familia').focus();\"";
        $atributos = array('width' => 500, 'height' => 400, 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');
        $atributos_prov = array('width' => 600, 'height' => 400, 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');
        $atributos_prod = array('width' => 700, 'height' => 450, 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');
        $atributos_string = "width=500,height=400,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0";
        $contenido = "<img height='16' width='16' src='" . base_url() . "images/ver.png' title='Registrar Familia' border='0'>";
        $data['ver'] = anchor_popup('almacen/familia/nueva_familia', $contenido, $atributos);
        $data['verproveedor'] = anchor_popup('compras/proveedor/ventana_busqueda_proveedor', $contenido, $atributos_prov);
        $data['verproducto'] = anchor_popup('almacen/producto/ventana_busqueda_producto', $contenido, $atributos_prod);
        $data['verfamilia_js'] = "ondblclick='window.open(\"" . base_url() . "index.php/almacen/familia/nueva_familia\",\"_blank\",\"" . $atributos_string . "\");'";
        /* Producto proveedores */
        $lista_proveedores = array();
        $productoproveedores = $this->productoproveedor_model->listar_proveedores($codigo);
        if (is_array($productoproveedores) > 0) {
            foreach ($productoproveedores as $indice => $value) {
                $prodproveedor = $value->PRODPROVP_Codigo;
                $proveedor = $value->PROVP_Codigo;
                $datos_proveedor = $this->proveedor_model->obtener($proveedor);
                $lista = new stdClass();
                $lista->prodproveedor = $prodproveedor;
                $lista->proveedor = $datos_proveedor->proveedor;
                $lista->ruc = $datos_proveedor->ruc;
                $lista->nombre_proveedor = $datos_proveedor->nombre;
                $lista->direccion = $datos_proveedor->direccion;
                $lista->distrito = $datos_proveedor->distrito;
                $lista_proveedores[] = $lista;
            }
        }
        $data['lista_proveedores'] = $lista_proveedores;
        /* Producto precios */
        $data['tabla_precios'] = $this->obtener_tabla_precios($codigo);
        $data['flagGuardado'] = $flagGuardado;
        $this->load->view('almacen/producto_ventana_nuevo', $data);
    }

    public function editar_producto($codigo, $flagGuardado = false)
    {
        /* se importan los modelos*/

        $this->load->model('almacen/fabricante_model');
        $this->load->model('almacen/linea_model');
        $this->load->model('almacen/marca_model');
        $this->load->model('almacen/productoproveedor_model');
        /* fin se importan los modelos*/

        /* Se obtiene el prodicto de cji_producto */
        $datos_producto = $this->producto_model->obtener_producto($codigo);
        /* fin Se obtiene el producto de cji_producto */

        $accion = "";
        $fabricante = $datos_producto[0]->FABRIP_Codigo;
        $familia = $datos_producto[0]->FAMI_Codigo;
        $flagBS = $datos_producto[0]->PROD_FlagBienServicio;
        $linea = $datos_producto[0]->LINP_Codigo;
        $marca = $datos_producto[0]->MARCP_Codigo;
        $tipoAfectacion = $datos_producto[0]->AFECT_Codigo;
        $modo = "modificar";
        $stock_min = $datos_producto[0]->PROD_StockMinimo;
        $tipo_producto = $datos_producto[0]->TIPPROD_Codigo;

        $data['cboTipoAfectacion'] = $this->lib_props->tipo_afectacion($tipoAfectacion);
        $data['flagBS'] = $flagBS;
        $data['modo'] = $modo;
        $data['familia'] = $datos_producto[0]->FAMI_Codigo;
        $data['partida_arancelaria'] = $datos_producto[0]->PROD_PartidaArancelaria;
        $data['nombre_producto'] = $datos_producto[0]->PROD_Nombre;
        $data['nombrecorto_producto'] = $datos_producto[0]->PROD_NombreCorto;
        $data['descripcion_breve'] = $datos_producto[0]->PROD_DescripcionBreve;
        $data['imagen'] = $datos_producto[0]->PROD_Imagen;
        $data['especificacionPDF'] = $datos_producto[0]->PROD_EspecificacionPDF;
        $data['modelo'] = $datos_producto[0]->PROD_Modelo;
        $data['presentacion'] = $datos_producto[0]->PROD_Presentacion;
        $data['geneindi'] = $datos_producto[0]->PROD_GenericoIndividual;
        $data['comentario'] = $datos_producto[0]->PROD_Comentario;
        $data['stock'] = $datos_producto[0]->PROD_Stock;
        $data['flagActivo'] = $datos_producto[0]->PROD_FlagActivo;
        $data['codigo_producto'] = $datos_producto[0]->PROD_CodigoInterno;
        $data['codigo_familia'] = '';
        $data['nombre_familia'] = '';
        if ($familia != '') {
            $data['nombre_familia'] = $this->familia_model->obtener_nomfamilia_total($familia);
            $data['codigo_familia'] = substr($datos_producto[0]->PROD_CodigoInterno, 0, strrpos($datos_producto[0]->PROD_CodigoInterno, '.') + 1);
        }
        $data['cbo_tipoProducto'] = $this->seleccionar_tipos_producto($datos_producto[0]->PROD_FlagBienServicio, $tipo_producto);
        $data['cbo_fabricante'] = form_dropdown('fabricante', $this->fabricante_model->seleccionar(), $fabricante, "id='fabricante' class='comboMedio'");
        $data['cbo_linea'] = form_dropdown('linea', $this->linea_model->seleccionar(), $linea, "id='linea' class='comboMedio'");
        $data['cbo_marca'] = form_dropdown('marca', $this->marca_model->seleccionar(), $marca, "id='marca' class='comboMedio'");
        $data['padre'] = "";
        $data['codpadre'] = "";
        $data['nompadre'] = "";
        $datos_producto_padre = array();
        if ($datos_producto[0]->PROD_PadreCodigo != '' && $datos_producto[0]->PROD_PadreCodigo != '0')
            $datos_producto_padre = $this->producto_model->obtener_producto($datos_producto[0]->PROD_PadreCodigo);
        if (!empty($datos_producto_padre)) {
            $data['padre'] = $datos_producto_padre[0]->PROD_Codigo;
            $data['codpadre'] = $datos_producto_padre[0]->PROD_CodigoInterno;
            $data['nompadre'] = $datos_producto_padre[0]->PROD_Nombre;
        }
        $data['codigo_usuario'] = $datos_producto[0]->PROD_CodigoUsuario;

        ///stv
        $data['codigo_original'] = $datos_producto[0]->PROD_CodigoOriginal;
        ///

        $data['fila'] = $this->obtener_datosAtributos($tipo_producto, $codigo);
        $data['filaunidad'] = $this->obtener_datosUnidad($codigo);

        $data['stock_min'] = $stock_min;


        $data['url_action'] = base_url() . "index.php/almacen/producto/modificar_producto";


        $data['oculto'] = form_hidden(array('accion' => $accion, 'codigo' => $codigo, 'modo' => $modo, 'base_url' => base_url(), 'flagBS' => $flagBS));
        $data['titulo'] = "EDITAR PRODUCTO :: " . $data['nombre_producto'];
        $data['producto'] = $codigo;
        $data['checked'] = $datos_producto[0]->PROD_FlagActivo == 1 ? "checked='checked'" : "";
        $data['display'] = "style='display:none;'";
        $data['readonly'] = "readonly='readonly'";
        $data['onload'] = "onload=\"$('#nombre_familia').select();$('#nombre_familia').focus();\"";
        $atributos = array('width' => 500, 'height' => 400, 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');
        $atributos_prov = array('width' => 600, 'height' => 400, 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');
        $atributos_prod = array('width' => 700, 'height' => 450, 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');
        $atributos_string = "width=500,height=400,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0";
        $contenido = "<img height='16' width='16' src='" . base_url() . "images/ver.png' title='Registrar Familia' border='0'>";
        $data['ver'] = anchor_popup('almacen/familia/nueva_familia', $contenido, $atributos);
        $data['verproveedor'] = anchor_popup('compras/proveedor/ventana_busqueda_proveedor', $contenido, $atributos_prov);
        $data['verproducto'] = anchor_popup('almacen/producto/ventana_busqueda_producto', $contenido, $atributos_prod);
        $data['verfamilia_js'] = "ondblclick='window.open(\"" . base_url() . "index.php/almacen/familia/nueva_familia\",\"_blank\",\"" . $atributos_string . "\");'";
        /* Producto proveedores */
        $lista_proveedores = array();
        $productoproveedores = $this->productoproveedor_model->listar_proveedores($codigo);
        if (count($productoproveedores) > 0) {
            foreach ($productoproveedores as $indice => $value) {
                $prodproveedor = $value->PRODPROVP_Codigo;
                $proveedor = $value->PROVP_Codigo;
                $datos_proveedor = $this->proveedor_model->obtener($proveedor);
                $lista = new stdClass();
                $lista->prodproveedor = $prodproveedor;
                $lista->proveedor = $datos_proveedor->proveedor;
                $lista->ruc = $datos_proveedor->ruc;
                $lista->nombre_proveedor = $datos_proveedor->nombre;
                $lista->direccion = $datos_proveedor->direccion;
                $lista->distrito = $datos_proveedor->distrito;
                $lista_proveedores[] = $lista;
            }
        }
        $data['lista_proveedores'] = $lista_proveedores;
        /* Producto precios */
        $data['tabla_precios'] = $this->obtener_tabla_precios($codigo);
        $data['flagGuardado'] = $flagGuardado;
        $this->layout->view('almacen/producto_nuevo', $data);
    }

    function editar_producto2()
    {
        $total = (int) $this->input->post('pag') + 50;
        $flagBS = $this->input->post('flagBS');
        /*
          $tipo ="1";
          $opcion  = $this->input->post('cboTipoProducto');
          if($opcion!="0") $tipo="2"; */
        $producto = $this->input->post('producto');

        //$lista_productos = $this->producto_model->listar_productos($flagBS,$tipo,$opcion);
        $filter = new stdClass();
        $filter->flagBS = $flagBS;
        $filter->codigo = $this->input->post('cod');
        $filter->nombre = $this->input->post('nom');
        $filter->familia = $this->input->post('fam');
        $filter->marca = $this->input->post('mar');
        /* $filter->tipoProducto = $opcion;
          $filter->estadoProducto = $this->input->post('ep');
         */
        $lista_productos = $this->producto_model->buscar_productos($filter);

        //$lista_productos = $this->producto_model->listar_productos($flagBS,$tipo,$opcion,'1',$total,'');
        $resultado = $this->tabla_producto($lista_productos, $producto, $total);
        echo $resultado;
    }

    /* Complementarios */

    function tabla_producto($datos, $producto = '', $total)
    {
        //$data[0] = array('ITEM','COD. INTERNO','COD. USUARIO','DESCRIPCION','&nbsp;','&nbsp;','&nbsp;');
        $data[0] = array('ITEM', 'CODIGO', 'DESCRIPCION', 'FAMILIA', 'MODELO', 'MARCA', 'STOCK', 'PRECIO', 'SERIES', 'ESTADO', '&nbsp;', '&nbsp;', '&nbsp;', '&nbsp;', '&nbsp;');
        $item = 1;
        if (count($datos) > 0) {
            foreach ($datos as $valor) {
                if ($item > $total - 50 && $item < $total + 1) {
                    $codigo = $valor->PROD_Codigo;
                    $codigo_interno = $valor->PROD_CodigoInterno;
                    $descripcion = $valor->PROD_Nombre;
                    //$tipo_producto = $valor->TIPPROD_Codigo;
                    //$tipo_pro_desc = $valor->TIPPROD_Descripcion;
                    $familia = $valor->FAMI_Codigo;
                    $familia_desc = $valor->FAMI_Descripcion;
                    $modelo = $valor->PROD_Modelo;
                    $flagActivo = $valor->PROD_FlagActivo;
                    //$stock         = $valor->PROD_Stock;
                    $presentacion = $valor->PROD_Presentacion;

                    $marca = $valor->MARCP_Codigo;
                    $nombre_marca = '';
                    if ($marca != '0' && $marca != '') {
                        $datos_marca = $this->marca_model->obtener($marca);
                        $nombre_marca = count($datos_marca) > 0 ? $datos_marca[0]->MARCC_Descripcion : '';
                    }
                    /*
                      if($tipo_producto=="9") {$valeg="1"; $es_generico="checked='checked'";}
                      else {$valeg="0"; $es_generico="";}
                     */
                    //Precio en 
                    $precio = "";
                    $prodprecio = $this->productoprecio_model->obtenerprecioA($codigo, $this->somevar['compania']);
                    if (count($prodprecio) > 0)
                        $precio = $prodprecio[0]->PRODPREC_Precio;
                    //Stock en Almacen Principal
                    $stock = "";
                    $prodstock = $this->productoprecio_model->obtenerstockA($codigo, $this->somevar['compania']);
                    if (count($prodstock) > 0)
                        $stock = $prodstock[0]->PROD_Stock;


                    if ($codigo == $producto && $familia != '') {
                        $codigointerno = "<input type='text' style='background-color: #C6C6C6;' readonly='readonly' class='cajaMinima' name='codigointerno[" . $item . "]' id='codigointerno[" . $item . "]' value='" . $codigo_interno . "' maxlength='20'>";
                        $concepto = "<input type='hidden' name='producto[" . $item . "]' id='producto[" . $item . "]' value='" . $codigo . "'>";
                        $concepto .= "<input type='text' class='cajaMediana' name='descripcion[" . $item . "]' id='descripcion[" . $item . "]' value='" . $descripcion . "'>";

                        $presentacionp = "<input type='text' class='cajaMediana' name='productopresentacion[" . $item . "]' id='productopresentacion[" . $item . "]' value='" . $familia_desc . "'>";


                        $modelop = "<input type='text' style='background-color: #C6C6C6;' readonly='readonly' class='cajaPequena' name='productomodelo[" . $item . "]' id='productomodelo[" . $item . "]' value='" . $modelo . "' maxlength='20'>";
                        $marcap = "<input type='text' style='background-color: #C6C6C6;' readonly='readonly' class='cajaPequena' name='productomarca[" . $item . "]' id='productomarca[" . $item . "]' value='" . $nombre_marca . "' maxlength='20'>";

                        $productostock = "<input type='text' class='cajaMinima' name='productostock[" . $item . "]' id='productostock[" . $item . "]' value='" . $stock . "' maxlength='10'>";
                        $preciop = "<input type='text' class='cajaMinima' name='productoprecio[" . $item . "]' id='productoprecio[" . $item . "]' value='" . $precio . "' maxlength='10'>";
                        $seriep = "<img onclick='IngresarSerieProducto($item)' style='cursor:pointer;width:25px;' width='20' height='20' border='0' src='" . base_url() . "images/flag-green_icon.png'>";
                        $ingresar = "";
                        $editar = "<a href='javascript:;' onclick='modificar_producto2(" . $item . ")' target='_parent'><img src='" . base_url() . "images/save.gif' width='16' height='16' border='0' title='Modificar'></a>";
                        $eliminar = "";
                    } else {
                        $codigointerno = $codigo_interno;
                        $concepto = "<input type='hidden' name='producto[" . $item . "]' id='producto[" . $item . "]' value='" . $codigo . "'>";
                        $concepto .= $descripcion;
                        $presentacionp = $familia_desc;
                        $modelop = $modelo;
                        /* $esgenerico = "";
                          $nombregenerico = $modelo; */
                        $marcap = $nombre_marca;
                        $productostock = $stock;
                        $preciop = $precio;
                        $seriep = "";
                        $ingresar = ($flagActivo == '1' ? "<a href='javascript:;' onclick='desactivar_producto(" . $codigo . ")'><img src='" . base_url() . "images/active.png' alt='Activo' border='0' title='Activo' /></a>" : "<a href='javascript:;' onclick='activar_producto(" . $codigo . ")'><img src='" . base_url() . "images/inactive.png' alt='Inactivo' border='0' title='Inactivo' /></a>");
                        $editar = "<a href='javascript:;' onclick='editar_producto2(" . $item . ")'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                        $eliminar = "<a href='javascript:;' onclick='ver_producto(" . $codigo . ")'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Ver'></a>";
                    }
                    /*
                      if($codigo==$familia && $familia!=''){
                      $codigointerno     = "<input type='text' style='background-color: #E6E6E6' readonly='readonly' class='cajaMinima' name='codigointerno[".$item."]' id='codigointerno[".$item."]' value='".$valor->FAMI_CodigoInterno."' maxlength='3'>";
                      $codigousuario = "<input type='text' class='cajaPequena' name='codigousuario[".$item."]' id='codigousuario[".$item."]' value='".$valor->FAMI_CodigoUsuario."' maxlength='20'>";
                      $concepto      = "<input type='hidden' name='familia[".$item."]' id='familia[".$item."]' value='".$codigo."'>";
                      $concepto     .= "<input type='text' class='cajaGrande' name='descripcion[".$item."]' id='descripcion[".$item."]' value='".$valor->FAMI_Descripcion."'>";
                      }
                      else{
                      $codigointerno =$valor->FAMI_CodigoInterno;
                      $codigousuario = $valor->FAMI_CodigoUsuario;
                      $concepto  = "<input type='hidden' name='familia[".$item."]' id='familia[".$item."]' value='".$codigo."'>";
                      $concepto .= $valor2;
                      }
                      if($codigo==$familia && $familia!=''){
                      $ingresar    = "";
                      $editar      = "<a href='#' onclick='modificar_familia(".$item.")' target='_parent'><img src='".base_url()."images/save.gif' width='16' height='16' border='0' title='Modificar'></a>";
                      $eliminar    = "";
                      }
                      else{
                      $ingresar    = "<a href='#' onclick='abrir_familia(".$item.")' target='_parent'><img src='".base_url()."images/ingresar.png' width='16' height='16' border='0' title='Abrir'></a>";
                      $editar      = "<a href='#' onclick='editar_familia(".$item.")' target='_parent'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                      $eliminar    = "<a href='#' onclick='eliminar_familia(".$item.")' target='_parent'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                      } */
                    $data[$item] = array(
                        $item,
                        $codigointerno,
                        $concepto,
                        $presentacionp,
                        //      $esgenerico,
                        $modelo,
                        $marcap,
                        $productostock,
                        $preciop,
                        $seriep,
                        $ingresar,
                        $editar,
                        $eliminar,
                        '',
                        '',
                        ''
                    );
                }
                $item++;
            }
        }
        $tmpl = array(
            'table_open' => '<table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" id="tablaFamilia">',
            'heading_row_start' => '<tr class="cabeceraTabla">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th width="5%">',
            'heading_cell_end' => '</th>',
            'row_start' => '<tr class="itemParTabla">',
            'row_end' => '</tr>',
            'cell_start' => '<td class="aCentro" width="5%">',
            'cell_end' => '</td>',
            'row_alt_start' => '<tr class="itemImparTabla">',
            'row_alt_end' => '</tr>',
            'cell_alt_start' => '<td class="aCentro" width="8%">',
            'cell_alt_end' => '</td>',
            'table_close' => '</table>'
        );
        $this->table->set_template($tmpl);
        $resultado = $this->table->generate($data);
        $this->table->clear();
        return $resultado;
    }

    public function guardarseries()
    {
        $codigo_producto = $this->input->post('codigo');
        $serie_producto = $this->input->post('series');
        //$hdserie_producto = $this->input->post('hdseries');
        $array_series = explode(",", $serie_producto);

        $serie_almacen = $this->serie_model->obtenerSerieProducto($codigo_producto, $array_series);
        if ($serie_almacen == '') {

            foreach ($array_series as $key => $value) {
                $this->serie_model->registrar_series($codigo_producto, $value);
            }
        }
        /* else {
          if ($hdserie_producto != '-') {
          $array_hdseries = explode(",", $hdserie_producto);
          }
          for ($i=0;$i<count($array_series);$i++) {
          $this->serie_model->actualiza_series($codigo_producto, $array_series[$i],$array_hdseries[$i]);
          }
          } */
    }

    public function modificar_producto2()
    {
        //$this->load->library('layout','layout');
        //$j      = $this->input->post('hpagina');
        //$flagBS = $this->input->post('flagBS');

        $producto = $this->input->post('producto');
        $nombre_producto = $this->input->post('descripcion');
        //$tipo_producto = $this->input->post('tipoproducto');
        //$modelo = $this->input->post('nombregenerico');
        $codigo_interno = $this->input->post('codigointerno');
        $stock_producto = $this->input->post('productostock');
        $precio_producto = $this->input->post('productoprecio');
        $presentacion_producto = $this->input->post('productopresentacion');
        $marca_producto = $this->input->post('productomarca');


        $this->producto_model->modificar_producto2($producto, $nombre_producto, $codigo_interno, $stock_producto, $precio_producto, $presentacion_producto, $marca_producto);

        //$this->layout->view('almacen/buscar_productos/'.$j.'/'.$flagBS,$data);
    }

    public function modificar_producto($flag_editar = false)
    {
        $this->firephp->fb($_POST, "variables post");
        $nuevonombre_imagen = '';
        if (isset($_FILES['imagen']['name']) && $_FILES['imagen']['name'] != "") {
            $origen = $_FILES['imagen']['tmp_name'];
            $temp = explode('.', $_FILES['imagen']['name']);

            if (in_array($temp[1], array('jpg', 'jpeg', 'png', 'gif', 'bmp'))) {
                $nuevonombre_imagen = $temp[0] . '_' . date('Ymd_His') . '.' . $temp[1];
                $destino = "images/img_db/" . $nuevonombre_imagen;
                move_uploaded_file($origen, $destino);
            }
        }

        $nuevonombre_pdf = '';
        if (isset($_FILES['pdf']['name']) && $_FILES['pdf']['name'] != "") {
            $origen = $_FILES['pdf']['tmp_name'];
            $temp = explode('.', $_FILES['pdf']['name']);

            if (in_array($temp[1], array('pdf'))) {
                $nuevonombre_pdf = $temp[0] . '_' . date('Ymd_His') . '.' . $temp[1];
                $destino = "pdf/" . $nuevonombre_pdf;
                move_uploaded_file($origen, $destino);
            }
        }
        $codigo = $this->input->post('codigo');
        $familia = $this->input->post('familia');
        $codigo_familia = $this->input->post('codigo_familia');
        $nombre_producto = $this->input->post('nombre_producto');
        $nombre_producto = str_replace("\"", " ", $nombre_producto);
        $nombre_producto = str_replace("'", " ", $nombre_producto);
        $nombrecorto_producto = $this->input->post('nombrecorto_producto');
        $descripcion_breve = $this->input->post('descripcion_producto');
        $proveedor = $this->input->post('proveedor');
        $costo_promedio = $this->input->post('costo_promedio');
        $ultima_compra = $this->input->post('ultima_compra');
        $tipo_producto = $this->input->post('tipo_producto');
        $unidad_medida = $this->input->post('unidad_medida');
        $atributo = $this->input->post('atributo');
        $nombre_atributo = $this->input->post('nombre_atributo');
        $tipo_atributo = $this->input->post('tipo_atributo');
        $produnidad = $this->input->post('produnidad');
        $comentario = $this->input->post('comentario');
        $imagen = $nuevonombre_imagen;
        $pdf = $nuevonombre_pdf;
        $modelo = $this->input->post('modelo');
        $presentacion = $this->input->post('presentacion');
        $geneindi = $this->input->post('geneindi');
        $estado = $this->input->post('estado');
        $activo = $this->input->post('activo');
        $codigo_interno = $codigo_familia . $this->input->post('codigo_producto');
        $tipoAfectacion = $this->input->post('afectacion');

        ///stv
        $factorprin = $this->input->post('factorprin');
        ///////

        $factor = $this->input->post('factor');
        $flagPrincipal = $this->input->post('flagPrincipal');
        $fabricante = $this->input->post('fabricante');
        $marca = $this->input->post('marca');
        $linea = $this->input->post('linea');
        $padre = $this->input->post('padre');
        $codigo_usuario = $this->input->post('codigo_usuario');
        $codigo_original = $this->input->post('codigo_original');

        $stock_min = $this->input->post('stock_min');
        //$factorprin
        $this->producto_model->modificar_producto_total($codigo, $proveedor, $familia, $tipo_producto, $nombre_producto, $descripcion_breve, $comentario, $codigo_interno, $unidad_medida, $factor, $flagPrincipal, $atributo, $tipo_atributo, $nombre_atributo, $produnidad, $imagen, $activo, $fabricante, $linea, $marca, $pdf, $modelo, $presentacion, $geneindi, $padre, $codigo_usuario, $nombrecorto_producto, $stock_min, $factorprin, $codigo_original, $tipoAfectacion, $this->input->post('partida-arancelaria'));

        $this->guardar_precios($codigo);

        if ($flag_editar == false)
            $this->editar_producto($codigo, true);
        else
            $this->editar_producto_popup($codigo, true);
    }

    public function guardar_precios($producto)
    {
        $lista_monedas = $this->moneda_model->listar();
        $lista_producto_unidad = $this->producto_model->listar_producto_unidades($producto);
        $comp_confi = $this->companiaconfiguracion_model->obtener($this->somevar['compania']);
        $temp = $this->compania_model->obtener_compania($this->somevar['compania']);
        $empresa = $temp[0]->EMPRP_Codigo;

        $determinaprecio = '0';
        if (count($comp_confi) > 0)
            $determinaprecio = $comp_confi[0]->COMPCONFIC_DeterminaPrecio;


        $fechaModificacion = date('Y-m-d H:i:s');

        switch ($determinaprecio) {
            case '0':
                foreach ($lista_monedas as $reg_m) {
                    if (is_array($lista_producto_unidad)) {
                        foreach ($lista_producto_unidad as $reg_pu) {
                            $precio = str_replace(',', '', $this->input->post('precio_' . $reg_m->MONED_Codigo . '_' . $reg_pu->PRODUNIP_Codigo)); //Para suprimir la como separadora de millares
                            $filter = new stdClass();
                            $filter->PROD_Codigo = $producto;
                            $filter->MONED_Codigo = $reg_m->MONED_Codigo;
                            $filter->PRODUNIP_Codigo = $reg_pu->PRODUNIP_Codigo;
                            $filter->TIPCLIP_Codigo = 0;
                            $filter->EESTABP_Codigo = 0;
                            $temp = $this->productoprecio_model->buscar($filter);
                            $filter->PRODPREC_Precio = $precio;
                            if (count($temp) > 0) {
                                if ($precio != '') {
                                    $filter->PRODPREC_FechaModificacion = $fechaModificacion;
                                    $this->productoprecio_model->modificar($temp[0]->PRODPREP_Codigo, $filter);
                                } else {
                                    $this->productoprecio_model->eliminar($temp[0]->PRODPREP_Codigo);
                                }
                            } elseif ($precio != '') {
                                $this->productoprecio_model->insertar($filter);
                            }
                        }
                    }
                }
                break;
            case '1':
                $lista_tipoclientes = $this->tipocliente_model->listar();
                if ($lista_tipoclientes) {
                    foreach ($lista_tipoclientes as $reg_tc) {
                        foreach ($lista_monedas as $reg_m) {
                            if (is_array($lista_producto_unidad)) {
                                foreach ($lista_producto_unidad as $reg_pu) {
                                    $precio = str_replace(',', '', $this->input->post('precio_' . $reg_m->MONED_Codigo . '_' . $reg_pu->PRODUNIP_Codigo . '_' . $reg_tc->TIPCLIP_Codigo)); //Para suprimir la como separadora de millares
                                    $filter = new stdClass();
                                    $filter->PROD_Codigo = $producto;
                                    $filter->MONED_Codigo = $reg_m->MONED_Codigo;
                                    $filter->PRODUNIP_Codigo = $reg_pu->PRODUNIP_Codigo;
                                    $filter->TIPCLIP_Codigo = $reg_tc->TIPCLIP_Codigo;
                                    $filter->EESTABP_Codigo = $this->somevar['establec'];
                                    ;
                                    $temp = $this->productoprecio_model->buscar($filter);
                                    $filter->PRODPREC_Precio = $precio;

                                    if (count($temp) > 0) {
                                        if ($precio != '') {
                                            $filter->PRODPREC_FechaModificacion = $fechaModificacion;
                                            $this->productoprecio_model->modificar($temp[0]->PRODPREP_Codigo, $filter);
                                        } else {
                                            $this->productoprecio_model->eliminar($temp[0]->PRODPREP_Codigo);
                                        }
                                    } elseif ($precio != '') {
                                        $this->productoprecio_model->insertar($filter);
                                    }
                                }
                            }
                        }
                    }
                }
                break;
            case '2':

                $lista_establecimientos = $this->emprestablecimiento_model->listar($empresa);
                foreach ($lista_establecimientos as $reg_es) {
                    foreach ($lista_monedas as $reg_m) {
                        if (is_array($lista_producto_unidad)) {
                            foreach ($lista_producto_unidad as $reg_pu) {
                                $precio = str_replace(',', '', $this->input->post('precio_' . $reg_m->MONED_Codigo . '_' . $reg_pu->PRODUNIP_Codigo . '_' . $reg_es->EESTABP_Codigo)); //Para suprimir la como separadora de millares
                                $filter = new stdClass();
                                $filter->PROD_Codigo = $producto;
                                $filter->MONED_Codigo = $reg_m->MONED_Codigo;
                                $filter->PRODUNIP_Codigo = $reg_pu->PRODUNIP_Codigo;
                                $filter->TIPCLIP_Codigo = 0;
                                $filter->EESTABP_Codigo = $reg_es->EESTABP_Codigo;
                                $temp = $this->productoprecio_model->buscar($filter);
                                $filter->PRODPREC_Precio = $precio;
                                if (count($temp) > 0) {
                                    if ($precio != '') {
                                        $filter->PRODPREC_FechaModificacion = $fechaModificacion;
                                        $this->productoprecio_model->modificar($temp[0]->PRODPREP_Codigo, $filter);
                                    } else {
                                        $this->productoprecio_model->eliminar($temp[0]->PRODPREP_Codigo);
                                    }
                                } elseif ($precio != '') {
                                    $this->productoprecio_model->insertar($filter);
                                }
                                //$this->firephp->fb($filter,"Array para ingresar");
                            }
                        }
                    }
                }
                break;
            case '3':
                $lista_tipoclientes = $this->tipocliente_model->listar();
                $lista_establecimientos = $this->emprestablecimiento_model->listar($empresa);
                foreach ($lista_tipoclientes as $reg_tc) {
                    if (count($lista_establecimientos) > 0) {
                        foreach ($lista_establecimientos as $reg_es) {
                            foreach ($lista_monedas as $reg_m) {
                                if (is_array($lista_producto_unidad)) {
                                    foreach ($lista_producto_unidad as $reg_pu) {
                                        $precio = str_replace(',', '', $this->input->post('precio_' . $reg_m->MONED_Codigo . '_' . $reg_pu->PRODUNIP_Codigo . '_' . $reg_tc->TIPCLIP_Codigo . '_' . $reg_es->EESTABP_Codigo)); //Para suprimir la como separadora de millares
                                        $filter = new stdClass();
                                        $filter->PROD_Codigo = $producto;
                                        $filter->MONED_Codigo = $reg_m->MONED_Codigo;
                                        $filter->PRODUNIP_Codigo = $reg_pu->PRODUNIP_Codigo;
                                        $filter->TIPCLIP_Codigo = $reg_tc->TIPCLIP_Codigo;
                                        $filter->EESTABP_Codigo = $reg_es->EESTABP_Codigo;
                                        $temp = $this->productoprecio_model->buscar($filter);
                                        $filter->PRODPREC_Precio = $precio;
                                        if (count($temp) > 0) {
                                            if ($precio != '') {
                                                $filter->PRODPREC_FechaModificacion = $fechaModificacion;
                                                $this->productoprecio_model->modificar($temp[0]->PRODPREP_Codigo, $filter);
                                            } else {
                                                $this->productoprecio_model->eliminar($temp[0]->PRODPREP_Codigo);
                                            }
                                        } elseif ($precio != '') {
                                            $this->productoprecio_model->insertar($filter);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                break;
        }
    }

    public function ver_producto($codigo)
    {

        $accion = "";
        $modo = "ver";
        $datos_producto = $this->producto_model->obtener_producto($codigo);
        $data['titulo'] = "VER PRODUCTO";
        $data['oculto'] = form_hidden(array('accion' => $accion, 'codigo' => $codigo, 'modo' => $modo, 'base_url' => base_url()));
        $data['producto'] = $codigo;
        $familia = $datos_producto[0]->FAMI_Codigo;
        $fabricante = $datos_producto[0]->FABRIP_Codigo;
        $tipo_producto = $datos_producto[0]->TIPPROD_Codigo;
        $flagActivo = $datos_producto[0]->PROD_FlagActivo;
        $data['familia'] = $datos_producto[0]->FAMI_Codigo;
        $data['nombre_producto'] = $datos_producto[0]->PROD_Nombre;
        $data['descripcion_breve'] = $datos_producto[0]->PROD_DescripcionBreve;
        $data['comentario'] = $datos_producto[0]->PROD_Comentario;
        $data['stock'] = $datos_producto[0]->PROD_Stock;
        $datos_familia = $this->familia_model->obtener_familia($familia);
        $datos_tipoProducto = $this->tipoproducto_model->obtener_tipo_producto($tipo_producto);
        $datos_unidad_medida = $this->producto_model->listar_producto_unidades($codigo);
        $datos_fabricante = $this->fabricante_model->obtener($fabricante);
        $data['nombre_tipo_producto'] = "";
        if (count($datos_tipoProducto) > 0)
            $data['nombre_tipo_producto'] = $datos_tipoProducto[0]->TIPPROD_Descripcion;
        $data['nombre_fabricante'] = $datos_fabricante[0]->FABRIC_Descripcion;
        $filaunidad = '<table width="98%" border="0" align="left" cellpadding="5" cellspacing="0" class="fuente8" id="tblUnidadMedida">';
        foreach ($datos_unidad_medida as $indice => $valor) {
            $unidad = $valor->UNDMED_Codigo;
            $factor = $valor->PRODUNIC_Factor;
            $flagP = $valor->PRODUNIC_flagPrincipal;
            $datos_unidad = $this->unidadmedida_model->obtener($unidad);
            $nombre_unidad = $datos_unidad[0]->UNDMED_Descripcion;
            $filaunidad .= '<tr>';
            if ($indice == 0) {
                $filaunidad .= '<td width="16%">Unidad medida Principal (*)</td>';
            } else {
                $indice2 = $indice + 1;
                $filaunidad .= '<td width="16%">Unidad medida Aux. ' . $indice2 . '</td>';
            }
            $filaunidad .= '<td width="19%">' . $nombre_unidad . '</td>';
            $filaunidad .= '<td width="12%">&nbsp;</td>';
            $filaunidad .= '<td width="52%">&nbsp;</td>';
            $filaunidad .= '</tr>';
        }
        $filaunidad .= '</table>';
        $data['filaunidad'] = $filaunidad;
        $data['fila'] = $this->obtener_datosAtributos($tipo_producto, $codigo, 'ver');
        $data['estado'] = $flagActivo == 1 ? "ACTIVO" : "INACTIVO";
        $data['nombre_familia'] = $datos_familia[0]->FAMI_Descripcion;
        $this->layout->view('almacen/producto_ver', $data);
    }

    public function cambiarEstado()
    {
        $estado = $this->input->post('estado');
        $cod_producto = $this->input->post('cod_producto');
        if ($estado < 0 && $estado > 1) {
            $result = array(
                'cambio' => 'false'
            );
        } else {
            // CAmbio de estado
            if ($estado == 0) {
                $estado = 1;
            } else if ($estado == 1) {
                $estado = 0;
            }

            $data = array(
                'PROD_FlagActivo' => $estado,
                'PROD_FlagEstado' => $estado
            );

            $valor = $this->producto_model->cambiarEstado($data, $cod_producto);

            $result = array(
                'cambio' => $valor
            );

        }

        echo json_encode($result);
    }

    public function buscar($flagBS = 'B', $j = 0)
    {
        $busqueda_1 = $this->input->post('busqueda_1');
        $busqueda_2 = $this->input->post('busqueda_2');
        $codigo = $this->input->post('txtCodigo');
        $nombre = $this->input->post('txtNombre');
        $familia = $this->input->post('txtFamilia');
        $familiaid = $this->input->post('familiaid');
        $marca = $this->input->post('txtMarca');
        $publicacion = $this->input->post('cboPublicacion');
        $array_idfamilia = explode("-", $familiaid);
        $ultimo_hijo = "";

        $ultimo_hijo = $array_idfamilia[count($array_idfamilia) - 1];

        $hijos = "";
        if ($familiaid != '') {
            $hijos = $this->familia_model->busqueda_familia_hijos($familiaid);
            $fam = $familiaid;
            if ($hijos != '') {
                $fam .= "/" . $hijos;
            } else {
                //echo $fam;
            }
        } else {
            $fam = "";
        }
        $filter = new stdClass();
        $filter->flagBS = $flagBS;
        $filter->codigo = $codigo;
        $filter->nombre = $nombre;
        $filter->familia = $familia;
        $filter->idfamilia = $ultimo_hijo;
        $filter->marca = $marca;
        $filter->publicacion = $publicacion;

        $conf['per_page'] = 50;
        $offset = $j;
        $listado_productos = array();

        if ($busqueda_1 == 1) {
            $listado_productos = $this->producto_model->productos_activos($flagBS, $conf['per_page'], $offset, $filter);
            $conf['base_url'] = site_url('almacen/producto/productos/' . $flagBS);
        } else if ($busqueda_2 == 1) {
            $listado_productos = $this->producto_model->productos_no_activos($flagBS, $conf['per_page'], $offset, $filter);
            $conf['base_url'] = site_url('almacen/producto/buscar/' . $flagBS);
        } else {
            $listado_productos = $this->producto_model->productos_activos($flagBS, $conf['per_page'], $offset, $filter);
            $conf['base_url'] = site_url('almacen/producto/productos/' . $flagBS);
        }

        $data['registros'] = 0;

        if ($busqueda_1 == 1) {
            $data['registros'] = count($this->producto_model->productos_activos($flagBS));
        } else if ($busqueda_2 == 1) {
            $data['registros'] = count($this->producto_model->productos_no_activos($flagBS));
        } else {
            $data['registros'] = count($this->producto_model->productos_activos($flagBS));
        }

        $conf['total_rows'] = $data['registros'];
        $conf['num_links'] = 3;
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['uri_segment'] = 5;
        $item = $j + 1;
        $lista = array();
        if ($listado_productos != NULL) {
            foreach ($listado_productos as $indice => $valor) {
                $codigo = $valor->PROD_Codigo;
                $codigo_interno = $valor->PROD_CodigoUsuario;
                $descripcion = $valor->PROD_Nombre;
                $tipo_producto = $valor->TIPPROD_Codigo;
                $familia = $valor->FAMI_Codigo;
                $modelo = $valor->PROD_Modelo;
                $flagEstado = $valor->PROD_FlagEstado;
                $flagActivo = $valor->PROD_FlagActivo;
                $fabricante = $valor->FABRIP_Codigo;
                $pdfs = $valor->PROD_EspecificacionPDF;

                $nombre_familia = $familia != '' && $familia != '' ? $this->familia_model->obtener_nomfamilia_total($familia) : '';

                $datos_fabricante = $this->fabricante_model->obtener($fabricante);
                $nombre_fabricante = count($datos_fabricante) > 0 ? $datos_fabricante[0]->FABRIC_Descripcion : '';
                //***********************************
                $tempo = $this->producto_model->obtenerPreciosUnoDos($codigo);
                if ($tempo != null && count($tempo) > 0) {

                    $precio_venta = $tempo[0]->PRODPREC_Precio;

                    if (isset($tempo[1]) && $tempo[1] != null) {
                        $precio_costo = $tempo[1]->PRODPREC_Precio;
                    } else {
                        $precio_costo = 0;
                    }
                } else {
                    $precio_venta = 0;
                    $precio_costo = 0;
                }
                //$temp = $this->obtener_precios_producto($codigo);
                //$precio_venta = $temp['precio_venta'];
                //$precio_costo = $temp['precio_costo'];

                //************************************
                $marca = $valor->MARCP_Codigo;
                $nombre_marca = '';
                if ($marca != '0' && $marca != '') {
                    $datos_marca = $this->marca_model->obtener($marca);
                    $nombre_marca = count($datos_marca) > 0 ? $datos_marca[0]->MARCC_Descripcion : '';
                }
                $flagPublicado = count($this->productopublicacion_model->listar($codigo)) > 0 ? true : false;
                if ($flagActivo == '1') {
                    $estado = "<a href='#' onClick='cambiarEstado(1, " . $valor->PROD_Codigo . ")' ><img src='" . base_url() . "images/active.png' alt='Activo' title='Activo' /></a>";
                } else {
                    $estado = "<a href='#' onClick='cambiarEstado(0, " . $valor->PROD_Codigo . ")' ><img src='" . base_url() . "images/inactive.png' alt='Anulado' title='Anulado' /></a>";
                }


                $editar_configuracion = $this->companiaconfiguracion_model->inventario_inicial($this->somevar['compania']);
                /* if($editar_configuracion[0]->COMPCONFIC_InventarioInicial==1){
                  $editar2 = "<a href='javascript:;' onclick='editar_producto2(" . $item . ")'><img src='" . base_url() . "images/ver_detalle.png' width='16' height='16' border='0' title='Modificar2'></a>";
                  }else{ */
                $editar2 = "";
                /* } */
                //$editar2 = "<a href='javascript:;' onclick='editar_producto2(" . $item . ")'><img src='" . base_url() . "images/ver_detalle.png' width='16' height='16' border='0' title='Modificar2'></a>";
                $cajaCodigo = "<input type='hidden' name='producto[" . $item . "]' id='producto[" . $item . "]' value='" . $codigo . "'/>";
                $prod_company = $this->producto_model->validar_establecimiento($codigo);

                $editar = "<a href='javascript:;' onclick='editar_producto(" . $codigo . ")'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                if ($prod_company)
                    $checkenviar = '';
                else
                    $checkenviar = "<input type='checkbox' id='checkalmacen' name='checkalmacen[]' value='" . $codigo . "' />";

                // $publicar = "<a href='javascript:;' onclick='enviar(" . $codigo . ")'><img src='" . base_url() . "images/publicar.png' width='16' height='16' border='0' title='Publicar'></a>";
                $prorratear = "<a href='javascript:;' onclick='prorratear_producto(" . $codigo . ")'><img src='" . base_url() . "images/dolar.png' width='16' height='16' border='0' title='Prorratear'></a>";
                $ver = "<a href='javascript:;' onclick='ver_producto(" . $codigo . ")'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Ver'></a>";
                $pdf = "<a href='" . base_url() . "pdf/" . $pdfs . "' target='blank'> <img src='" . base_url() . "images/pdf.png' width='16' height='16' border='0' title='Descargar Ficha Técnica'></a>";
                $eliminar = "<a href='javascript:;' onclick='eliminar_producto(" . $codigo . ")'><img src='" . base_url() . "images/eliminar.png' width='16' height='16' border='0' title='Eliminar'></a>";
                $lista[] = array($item++, $codigo_interno, $descripcion, $nombre_familia, $modelo, $nombre_marca, $precio_venta, $precio_costo, $estado, $editar, $checkenviar, $prorratear, $eliminar, $flagPublicado, $codigo, $editar2, $cajaCodigo, $pdf);

            }
        }

        $data['lista'] = $lista;
        $data['flagBS'] = $flagBS;
        $data['titulo_tabla'] = "RELACI&Oacute;N de " . ($flagBS == 'B' ? 'ARTICULO' : 'SERVICIO');
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        ;
        $this->load->view('almacen/busqueda_producto_index', $data);
    }


    public function buscar_productos($flagBS = 'B', $j = '0', $flag_nuevo = false)
    {
        $filter = new stdClass();
        if (count($_POST) > 0) {
            $filter->codigo = $this->input->post('txtCodigo');
            $filter->nombre = $this->input->post('txtNombre');
            $filter->familia = $this->input->post('txtFamilia');
            $filter->marca = $this->input->post('txtMarca');
            $filter->modelo = $this->input->post('txtModelo');
            $filter->codigoInterno = $this->input->post('codigoInterno');
        }

        $codigo = $this->input->post('txtCodigo');
        $codigoInt = $this->input->post("codigoInterno");
        $nombre = $this->input->post('txtNombre');
        $familia = $this->input->post('txtFamilia');
        $familiaid = $this->input->post('familiaid');
        $marca = $this->input->post('txtMarca');
        $modelo = $this->input->post('txtModelo');
        $publicacion = $this->input->post('cboPublicacion');
        $array_idfamilia = explode("-", $familiaid);
        $ultimo_hijo = "";

        $ultimo_hijo = $array_idfamilia[count($array_idfamilia) - 1];

        $hijos = "";
        if ($familiaid != '') {
            //$fam        = $this->hijos($familiaid);
            $hijos = $this->familia_model->busqueda_familia_hijos($familiaid);
            $fam = $familiaid;
            //var_dump($hijos);
            if ($hijos != '') {
                $fam .= "/" . $hijos;
            } else {
                //echo $fam;
            }
        } else {
            $fam = "";
        }

        if (count($_POST) > 0) {
            $this->session->set_userdata(array('codigo' => $codigo, 'nombre' => $nombre, 'familia' => $familia, 'marca' => $marca, 'modelo' => $modelo, 'publicacion' => $publicacion, "codigoInterno" => $codigoInt));
        } else {
            $codigo = $this->session->userdata('codigo');
            $nombre = $this->session->userdata('nombre');
            $familia = $this->session->userdata('familia');
            $marca = $this->session->userdata('marca');
            $modelo = $this->session->userdata('modelo');
            $codigoInt = $this->session->userdata('codigoInterno');

            $publicacion = $this->session->userdata('publicacion');
        }

        $filter = new stdClass();
        $filter->flagBS = $flagBS;
        $filter->codigo = $codigo;
        $filter->nombre = $nombre;
        $filter->familia = $familia;
        $filter->idfamilia = $ultimo_hijo;
        $filter->marca = $marca;
        $filter->modelo = $modelo;
        $filter->codigoInterno = $codigoInt;
        $filter->publicacion = $publicacion;

        $data['fam'] = $fam;
        $data['codigo'] = $codigo;
        $data['nombre'] = $nombre;
        $data['familia'] = $familia;
        $data['familiaid'] = $familiaid;
        $data['marca'] = $marca;
        $data['modelo'] = $modelo;
        $data['publicacion'] = $publicacion;
        $data['codigoInterno'] = $codigoInt;

        $data['registros'] = count($this->producto_model->buscar_productos($filter));
        $data['action'] = base_url() . "index.php/almacen/producto/productos/" . $flagBS;
        $conf['base_url'] = site_url('almacen/producto/productos/' . $flagBS);
        $conf['per_page'] = 50;
        $conf['num_links'] = 3;
        $data["pageNum"] = $conf['per_page'];
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['total_rows'] = $data['registros'];
        $conf['uri_segment'] = 5;
        $offset = (int) $this->uri->segment(5);
        $listado_productos = $this->producto_model->buscar_productos($filter, $conf['per_page'], $offset);
        $item = $j + 1;
        $lista = array();
        /*if (count($listado_productos) > 0) {
            foreach ($listado_productos as $indice => $valor) {
                $codigo = $valor->PROD_Codigo;
                $codigo_interno = $valor->PROD_CodigoUsuario;
                $descripcion = $valor->PROD_Nombre;
                $tipo_producto = $valor->TIPPROD_Codigo;
                $familia = $valor->FAMI_Codigo;
                //$descfamilia_largo="";

                $modelo = $valor->PROD_Modelo;
                $flagEstado = $valor->PROD_FlagEstado;
                $flagActivo = $valor->PROD_FlagActivo;
                $fabricante = $valor->FABRIP_Codigo;
                $datos_familia = $this->familia_model->obtener_familia($familia);
                $datos_fabricante = $this->fabricante_model->obtener($fabricante);
                if ($familia != '')
                    $nombre_familia = $this->familia_model->obtener_nomfamilia_total($familia);
                else
                    $nombre_familia = "";

                $tempo = $this->producto_model->obtenerPreciosUnoDos($codigo);
                if (isset($tempo[0]) && $tempo[0]!=null) {

                    $precio_venta=$tempo[0]->PRODPREC_Precio;

                    if (isset($tempo[1]) && $tempo[1]!=null){
                        $precio_costo=$tempo[1]->PRODPREC_Precio;
                    }
                    else{
                    $precio_costo=0;
                    }
                }              
                else{
                    $precio_venta =  0;
                    $precio_costo =  0;
                }

                $nombre_fabricante = count($datos_fabricante) > 0 ? $datos_fabricante[0]->FABRIC_Descripcion : '';

                $marca = $valor->MARCP_Codigo;
                $nombre_marca = '';
                if ($marca != '0' && $marca != '') {
                    $datos_marca = $this->marca_model->obtener($marca);
                    if (count($datos_marca) > 0)
                        $nombre_marca = $datos_marca[0]->MARCC_Descripcion;
                }
                $flagPublicado = count($this->productopublicacion_model->listar($codigo)) > 0 ? true : false;

                $estado = ($flagActivo == '1' ? "<img src='" . base_url() . "images/active.png' alt='Activo' title='Activo' />" : "<img src='" . base_url() . "images/inactive.png' alt='Anulado' title='Anulado' />");

                $editar_configuracion = $this->companiaconfiguracion_model->inventario_inicial($this->somevar['compania']);

                $editar2 = "";

                $cajaCodigo = "<input type='hidden' name='producto[" . $item . "]' id='producto[" . $item . "]' value='" . $codigo . "'/>";
                //$editar2 = "<a href='javascript:;' onclick='editar_producto2(" . $item . ")'><img src='" . base_url() . "images/ver_detalle.png' width='16' height='16' border='0' title='Modificar2'></a>";
                //$editar         = "<a href='javascript:;' onclick='editar_producto(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                if ($flag_nuevo == false)
                    $editar = "<a href='" . base_url() . "index.php/almacen/producto/editar_producto/" . $codigo . "' ><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                else
                    $editar = "<a href='" . base_url() . "index.php/almacen/producto/editar_producto_popup/" . $codigo . "' ><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $publicar = "<a href='javascript:;' onclick='publicacion_web(" . $codigo . ")'><img src='" . base_url() . "images/publicar.png' width='16' height='16' border='0' title='Publicar'></a>";
                $prorratear = "<a href='javascript:;' onclick='prorratear_producto(" . $codigo . ")'><img src='" . base_url() . "images/dolar.png' width='16' height='16' border='0' title='Prorratear'></a>";
                //$ver            = "<a href='javascript:;' onclick='ver_producto(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                $eliminar = "<a href='javascript:;' onclick='eliminar_producto(" . $codigo . ")'><img src='" . base_url() . "images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $lista[] = array($item++, $codigo_interno, $descripcion, $nombre_familia, $modelo, $nombre_marca, $precio_venta, $precio_costo, $estado, $editar, $publicar, $prorratear, $eliminar, $flagPublicado, $codigo, $editar2, $cajaCodigo);
            }
        }*/

        if ($listado_productos != NULL) {
            foreach ($listado_productos as $indice => $valor) {
                $codigo = $valor->PROD_Codigo;
                $codigo_interno = $valor->PROD_CodigoUsuario;
                $descripcion = $valor->PROD_Nombre;
                $tipo_producto = $valor->TIPPROD_Codigo;
                $familia = $valor->FAMI_Codigo;
                $modelo = $valor->PROD_Modelo;
                $flagEstado = $valor->PROD_FlagEstado;
                $flagActivo = $valor->PROD_FlagActivo;
                $fabricante = $valor->FABRIP_Codigo;
                $pdfs = $valor->PROD_EspecificacionPDF;

                $nombre_familia = $familia != '' && $familia != '' ? $this->familia_model->obtener_nomfamilia_total($familia) : '';

                $datos_fabricante = $this->fabricante_model->obtener($fabricante);
                $nombre_fabricante = count($datos_fabricante) > 0 ? $datos_fabricante[0]->FABRIC_Descripcion : '';

                $tempo = $this->producto_model->obtenerPreciosUnoDos($codigo);

                if (isset($tempo[0]) && $tempo[0] != null)
                    $precio_venta = $tempo[0]->PRODPREC_Precio;
                else
                    $precio_venta = 0;

                $precio_costo = $this->producto_model->obtenerPrecioV($codigo);

                $marca = $valor->MARCP_Codigo;
                $nombre_marca = '';
                if ($marca != '0' && $marca != '') {
                    $datos_marca = $this->marca_model->obtener($marca);
                    $nombre_marca = count($datos_marca) > 0 ? $datos_marca[0]->MARCC_Descripcion : '';
                }
                $flagPublicado = count($this->productopublicacion_model->listar($codigo)) > 0 ? true : false;
                if ($flagActivo == '1') {
                    $estado = "<a href='#' onClick='cambiarEstado(1, " . $valor->PROD_Codigo . ")' ><img src='" . base_url() . "images/active.png' alt='Activo' title='Activo' /></a>";
                } else {
                    $estado = "<a href='#' onClick='cambiarEstado(0, " . $valor->PROD_Codigo . ")' ><img src='" . base_url() . "images/inactive.png' alt='Anulado' title='Anulado' /></a>";
                }

                $editar_configuracion = $this->companiaconfiguracion_model->inventario_inicial($this->somevar['compania']);
                $editar2 = "";
                $cajaCodigo = "<input type='hidden' name='producto[" . $item . "]' id='producto[" . $item . "]' value='" . $codigo . "'/>";
                $prod_company = $this->producto_model->validar_establecimiento($codigo);

                $editar = "<a href='javascript:;' onclick='editar_producto(" . $codigo . ")'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                if ($prod_company)
                    $checkenviar = '';
                else
                    $checkenviar = "<input type='checkbox' id='checkalmacen' name='checkalmacen[]' value='" . $codigo . "' />";

                $prorratear = "<a href='javascript:;' onclick='prorratear_producto(" . $codigo . ")'><img src='" . base_url() . "images/dolar.png' width='16' height='16' border='0' title='Prorratear'></a>";

                $ver = "<a href='javascript:;' onclick='ver_producto(" . $codigo . ")'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Ver'></a>";
                $pdf = "<a href='" . base_url() . "pdf/" . $pdfs . "' target='blank'> <img src='" . base_url() . "images/pdf.png' width='16' height='16' border='0' title='Descargar Ficha Técnica'></a>";
                $eliminar = "<a href='javascript:;' onclick='eliminar_producto(" . $codigo . ")'><img src='" . base_url() . "images/eliminar.png' width='16' height='16' border='0' title='Eliminar'></a>";
                $lista[] = array($item++, $codigo_interno, $descripcion, $nombre_familia, $modelo, $nombre_marca, $precio_venta, $precio_costo, $estado, $editar, $checkenviar, $prorratear, $eliminar, $flagPublicado, $codigo, $editar2, $cajaCodigo, $pdf);
            }
        }

        $data['titulo_tabla'] = "RESULTADO DE BÚSQUEDA DE " . ($flagBS == 'B' ? 'ARTICULOS' : 'SERVICIOS');
        $data['titulo_busqueda'] = "BUSCAR " . ($flagBS == 'B' ? 'ARTICULOS' : 'SERVICIOS');
        $data['flagBS'] = $flagBS;
        $data['lista'] = $lista;
        $data['oculto'] = form_hidden(array('base_url' => base_url(), 'flagBS' => $flagBS));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $data['instalacion'] = FORMATO_IMPRESION;
        $this->load->view('almacen/busqueda_producto_index', $data);
    }

    public function obtener_precios_producto($producto)
    {
        $lista_producto_unidad = $this->producto_model->listar_producto_unidades($producto);
        $precio_venta = 0;
        $precio_venta_actualizacion = '';
        if (count($lista_producto_unidad) > 0) {
            $produnid = $lista_producto_unidad[0]->PRODUNIP_Codigo;
            $filter = new stdClass();
            $filter->PROD_Codigo = $producto;
            $filter->MONED_Codigo = 1;
            $filter->PRODUNIP_Codigo = $produnid;
            $filter->TIPCLIP_Codigo = 0;
            $filter->EESTABP_Codigo = 0;
            $temp = $this->productoprecio_model->buscar($filter);
            if (count($temp) > 0) {
                $precio_venta_actualizacion = $temp[0]->PRODPREC_FechaModificacion;
                $precio_venta = $temp[0]->PRODPREC_Precio;
            }
        }
        $precio_costo = 0;
        $precio_costo_actualizacion = '';
        $precio_venta_actualizacion = '';
        if (FORMATO_IMPRESION == 4) {  // Sólo  ferremax guarda sus precios de costo en el atributo 14
            $datos_prodAtributo = $this->producto_model->obtener_producto_atributos($producto, 14);
            if (count($datos_prodAtributo) > 0) {
                $precio_costo_actualizacion = $datos_prodAtributo[0]->PRODATRIB_FechaModificacion;
                $precio_costo = $datos_prodAtributo[0]->PRODATRIB_String;
            }
        }
        return array('precio_venta' => $precio_venta, 'precio_venta_actualizacion' => $precio_venta_actualizacion, 'precio_costo' => $precio_costo, 'precio_costo_actualizacion' => $precio_costo_actualizacion);
    }

    public function obtener_nombre_producto($flagBS, $codigo_interno)
    {
        $datos_producto = $this->producto_model->obtener_producto_x_codigo($flagBS, $codigo_interno);
        $resultado = '[{"PROD_Codigo":"0","PROD_Nombre":"","PROD_Stock":"","UNDMED_Simbolo":"","FAMI_Descripcion":""}]';
        if (count($datos_producto) > 0) {
            $producto = $datos_producto[0]->PROD_Codigo;
            $familia = $datos_producto[0]->FAMI_Codigo;
            $tipo_producto = $datos_producto[0]->TIPPROD_Codigo;
            $descripcion = addslashes($datos_producto[0]->PROD_Nombre);
            $stock = $datos_producto[0]->PROD_Stock;
            $flagGenInd = $datos_producto[0]->PROD_GenericoIndividual;
            $datos_familia = $this->familia_model->obtener_familia($familia);
            $nombre_familia = addslashes($datos_familia[0]->FAMI_Descripcion);
            $resultado = '[{"PROD_Codigo":"' . $producto . '","PROD_Nombre":"' . $descripcion . '","PROD_Stock":"' . $stock . '","FAMI_Descripcion":"' . $nombre_familia . '", "flagGenInd":"' . $flagGenInd . '"}]';
        }
        echo $resultado;
    }

    public function obtener_producto_x_nombre($nombre_producto)
    {
        $datos_producto = $this->producto_model->obtener_producto_x_nombre($nombre_producto);
        echo count($datos_producto);
    }

    public function obtener_producto_x_codigo_usuario($codigo_usuario)
    {

        $datos_producto = $this->producto_model->obtener_producto_x_codigo_usuario($codigo_usuario);
        echo count($datos_producto);
    }

    public function obtener_producto_x_codigo_original($codigo_original)
    {

        $datos_producto = $this->producto_model->obtener_producto_x_codigo_original($codigo_original);
        echo count($datos_producto);
    }

    public function obtener_producto_x_modelo($modelo_producto, $producto = "")
    {
        $datos_producto = $this->producto_model->obtener_producto_x_modelo($modelo_producto, $producto);
        echo count($datos_producto);
    }

    public function eliminar_producto()
    {
        $producto = $this->input->post('producto');

        $this->producto_model->eliminar_producto_total($producto);
    }

    public function habilitar_producto()
    {
        $producto = $this->input->post('producto');
        $this->producto_model->habilitar_producto($producto);
    }

    public function eliminar_productoproveedor()
    {
        $this->load->model('almacen/productoproveedor_model');
        $id = $this->input->post('productoproveedor');
        $this->productoproveedor_model->eliminar($id);
    }

    public function ventana_busqueda_producto($flagBS = 'B', $j = '0', $limpia = '')
    {
        //buscar por session productos
        $data['flagBS'] = $flagBS;
        $data['codigo'] = '';
        $data['nombre'] = '';
        $data['familia'] = '';
        $data['marca'] = '';

        $filter = new stdClass();
        if (count($_POST) > 0) {
            $data['codigo'] = $this->input->post('txtCodigo');
            $data['nombre'] = $this->input->post('txtNombre');
            $data['familia'] = $this->input->post('txtFamilia');
            $data['marca'] = $this->input->post('txtMarca');
        }
        if ($limpia == '1') {
            $this->session->unset_userdata('codigo');
            $this->session->unset_userdata('nombre');
            $this->session->unset_userdata('familia');
            $this->session->unset_userdata('marca');
        }
        if (count($_POST) > 0) {
            $this->session->set_userdata(array('codigo' => $data['codigo'], 'nombre' => $data['nombre'], 'familia' => $data['familia'], 'marca' => $data['marca']));
        } else {
            $data['codigo'] = $this->session->userdata('codigo');
            $data['nombre'] = $this->session->userdata('nombre');
            $data['familia'] = $this->session->userdata('famlia');
            $data['marca'] = $this->session->userdata('marca');
        }
        $fil = new stdClass();
        $fil->nombre = $data['familia'];
        $lista_fam = $this->familia_model->buscar_familias1($fil);
        $familia_id = $lista_fam[0]->FAMI_Codigo;
        $filter = new stdClass();
        $filter->flagBS = $flagBS;
        $filter->codigo = $data['codigo'];
        $filter->nombre = $data['nombre'];
        $filter->familia = $data['familia'];
        $filter->marca = $data['marca'];
        $filter->idfamilia = $familia_id;

        $data['registros'] = count($this->producto_model->buscar_productos($filter));
        $conf['base_url'] = site_url('almacen/producto/ventana_busqueda_producto/');
        $conf['per_page'] = 50;
        $conf['num_links'] = 3;
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['total_rows'] = $data['registros'];
        $conf['uri_segment'] = 4;
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $listado_productos = $this->producto_model->buscar_productos($filter, $conf['per_page'], $j);
        $item = $j + 1;
        $lista = array();
        if (count($listado_productos) > 0) {
            foreach ($listado_productos as $indice => $valor) {
                $codigo = $valor->PROD_Codigo;
                $interno = $valor->PROD_CodigoInterno;
                $temp = $this->obtener_precios_producto($codigo);
                $precio_venta = $temp['precio_venta'];
                $precio_costo = $temp['precio_costo'];
                $interno_c = (($filter->codigo != '') ? '<span class="texto_busq">' . $filter->codigo . '</span>' : $interno);

                $nombre = $valor->PROD_Nombre;
                $nombre_c = (($filter->nombre != '') ? str_replace(strtoupper($filter->nombre), '<span class="texto_busq">' . strtoupper($filter->nombre) . '</span>', $nombre) : $nombre);

                $nombre_familia = '';
                if ($valor->FAMI_Codigo != '')
                    $nombre_familia = $this->familia_model->obtener_nomfamilia_total($valor->FAMI_Codigo);
                $nombre_familia_c = (($filter->familia != '') ? str_replace(strtoupper($filter->familia), '<span class="texto_busq">' . strtoupper($filter->familia) . '</span>', $nombre_familia) : $nombre_familia);



                $tipo_producto = $valor->TIPPROD_Codigo;
                $stock = $valor->PROD_Stock;
                $ultimo_costo = $valor->PROD_UltimoCosto;
                $modelo = $valor->PROD_Modelo;
                $flagGenInd = $valor->PROD_GenericoIndividual;
                $marca = $valor->MARCP_Codigo;
                $nombre_marca = '';
                //$editar         = "<a href='javascript:;' onclick='editar_producto(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Editar'></a>";
                $editar = "<a href='" . base_url() . "index.php/almacen/producto/editar_producto_popup/" . $codigo . "' id='editar_producto_popup' ><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                if ($marca != '0' && $marca != '') {
                    $datos_marca = $this->marca_model->obtener($marca);
                    if (count($datos_marca) > 0)
                        $nombre_marca = $datos_marca[0]->MARCC_Descripcion;
                }

                //$seleccionar  = "<a href='#' onclick='seleccionar_producto(".$codigo.",\"".$interno."\",\"".$nombre."\", \"".$stock."\", \"".$costo_promedio."\")'><img src='".base_url()."images/convertir.png'  border='0' title='Seleccionar'></a>";
                $seleccionar = '<a href="#" onclick="seleccionar_producto(' . $codigo . ',\'' . $interno . '\',\'' . $nombre . '\')"><img src="' . base_url() . 'images/convertir.png"  border="0" title="Seleccionar"></a>';
                $lista[] = array($item, $interno_c, $nombre_c, $nombre_familia_c, $modelo, $nombre_marca, $precio_venta, $precio_costo, $seleccionar, $editar);
                $item++;
            }
        }
        $data['flagBS'] = $flagBS;
        $data['lista'] = $lista;
        $this->load->view('almacen/producto_ventana_buqueda', $data);
    }

    public function ventana_busqueda_producto_kardex($flagBS = 'B', $buscar_producto = '', $j = '0')
    {

        $data['flagBS'] = $flagBS;
        $data['codigo'] = '';
        $data['nombre'] = '';
        $data['kardex'] = TRUE;
        $data['familia'] = '';
        $filter = new stdClass();
        if (count($_POST) > 0) {
            $data['codigo'] = $this->input->post('txtCodigo');
            $data['nombre'] = $this->input->post('txtNombre');
            $data['familia'] = $this->input->post('txtFamilia');
        }

        if (count($_POST) > 0) {
            $this->session->set_userdata(array('codigo' => $data['codigo'], 'nombre' => $data['nombre'], 'familia' => $data['familia']));
        } else {
            $data['codigo'] = $this->session->userdata('codigo');
            $data['nombre'] = $this->session->userdata('nombre');
            $data['familia'] = $this->session->userdata('famlia');
        }
        $fil = new stdClass();
        $fil->nombre = $data['familia'];
        $lista_fam = $this->familia_model->buscar_familias1($fil);
        $familia_id = $lista_fam[0]->FAMI_Codigo;
        $filter = new stdClass();
        $filter->flagBS = $flagBS;
        $filter->codigo = $data['codigo'];
        $filter->nombre = $buscar_producto;
        $filter->familia = $data['familia'];
        $filter->idfamilia = $familia_id;

        $data['registros'] = count($this->producto_model->buscar_productos($filter));
        $conf['base_url'] = site_url('almacen/producto/ventana_busqueda_producto_kardex/' . $flagBS . '/' . $buscar_producto);
        $conf['per_page'] = 50;
        $conf['num_links'] = 3;
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['total_rows'] = $data['registros'];
        $conf['uri_segment'] = 4;
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $listado_productos = $this->producto_model->buscar_productos($filter, $conf['per_page'], $j);
        $item = $j + 1;
        $lista = array();
        if (count($listado_productos) > 0) {
            foreach ($listado_productos as $indice => $valor) {
                $codigo = $valor->PROD_Codigo;
                $interno = $valor->PROD_CodigoInterno;
                $temp = $this->obtener_precios_producto($codigo);
                $precio_venta = $temp['precio_venta'];
                $precio_costo = $temp['precio_costo'];
                $interno_c = (($filter->codigo != '') ? '<span class="texto_busq">' . $filter->codigo . '</span>' : $interno);
                $nombre = $valor->PROD_Nombre;
                $nombre = str_replace("'", "&quot", $nombre);
                //$nombre="dsfsdf";

                $nombre_c = (($filter->nombre != '') ? str_replace(strtoupper($filter->nombre), '<span class="texto_busq">' . strtoupper($filter->nombre) . '</span>', $nombre) : $nombre);
                $nombre_familia = '';
                if ($valor->FAMI_Codigo != '')
                    $nombre_familia = $this->familia_model->obtener_nomfamilia_total($valor->FAMI_Codigo);
                $nombre_familia_c = (($filter->familia != '') ? str_replace(strtoupper($filter->familia), '<span class="texto_busq">' . strtoupper($filter->familia) . '</span>', $nombre_familia) : $nombre_familia);
                $tipo_producto = $valor->TIPPROD_Codigo;
                $stock = $valor->PROD_Stock;
                $ultimo_costo = $valor->PROD_UltimoCosto;
                $modelo = $valor->PROD_Modelo;
                $flagGenInd = $valor->PROD_GenericoIndividual;
                $marca = $valor->MARCP_Codigo;
                $cod_usuario = $valor->PROD_CodigoUsuario;
                $nombre_marca = '';
                //$editar         = "<a href='javascript:;' onclick='editar_producto(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Editar'></a>";
                $editar = "<a href='" . base_url() . "index.php/almacen/producto/editar_producto_popup/" . $codigo . "' id='editar_producto_popup' ><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                if ($marca != '0' && $marca != '') {
                    $datos_marca = $this->marca_model->obtener($marca);
                    if (count($datos_marca) > 0)
                        $nombre_marca = $datos_marca[0]->MARCC_Descripcion;
                }

                //$seleccionar  = "<a href='#' onclick='seleccionar_producto(".$codigo.",\"".$interno."\",\"".$nombre."\", \"".$stock."\", \"".$costo_promedio."\")'><img src='".base_url()."images/convertir.png'  border='0' title='Seleccionar'></a>";
                $seleccionar = '<a href="#" onclick="seleccionar_producto(' . $codigo . ',\'' . $cod_usuario . '\',\'' . $nombre . '\')"><img src="' . base_url() . 'images/convertir.png"  border="0" title="Seleccionar"></a>';
                $lista[] = array($item, $interno_c, $nombre_c, $nombre_familia_c, $modelo, $nombre_marca, $precio_venta, $precio_costo, $seleccionar, $editar);
                $item++;
            }
        }
        $data['flagBS'] = $flagBS;
        $data['lista'] = $lista;
        $this->load->view('almacen/producto_ventana_buqueda', $data);
    }

    public function ventana_selecciona_producto($tipo_oper = 'V', $flagBS = 'B', $buscar_producto = '', $almacen = 0, $j = '0')
    {
        $data['flagBS'] = $flagBS;
        $filter = new stdClass();
        $filter->flagBS = $flagBS;
        $filter->nombre = $buscar_producto;
        //------------------------------

        $data['registros'] = count($this->producto_model->buscar_productos1($filter));

        $data['action'] = base_url() . "index.php/almacen/producto/ventana_selecciona_producto/" . $tipo_oper . "/" . $flagBS . "/" . $buscar_producto . "/" . $almacen;
        $conf['base_url'] = site_url('almacen/producto/ventana_selecciona_producto/' . $tipo_oper . "/" . $flagBS . "/" . $buscar_producto . "/" . $almacen);
        $conf['total_rows'] = $data['registros'];
        $conf['per_page'] = 20;
        $conf['num_links'] = 3;
        $conf['next_link'] = "&gt;";
        $conf['prev_link'] = "&lt;";
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['uri_segment'] = 7;
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        //---------

        $listado_productos = $this->producto_model->buscar_productos1($filter, $conf['per_page'], $j);

        $item = $j + 1;
        $lista = array();
        //var_dump($listado_productos);
        if (count($listado_productos) > 0) {
            foreach ($listado_productos as $indice => $valor) {
                $codigo = $valor->PROD_Codigo;
                //$stock = $this->producto_model->obtener_stock($codigo, $this->somevar['establec']);  //$stock = $valor->PROD_Stock;

                $almacen_id = null;
                $datosAlmacenProducto = $this->almacenproducto_model->obtener($almacen_id, $codigo);
                $CodigoAlmacenProducto = 0;
                $pcosto = 0;



                $interno = $valor->PROD_CodigoUsuario;
                $nombre = $valor->PROD_Nombre;
                $nombre_c = (($filter->nombre != '') ? str_replace(strtoupper($filter->nombre), '<span class="texto_busq">' . strtoupper($filter->nombre) . '</span>', $nombre) : $nombre);

                $serie_c = '';
                if ($valor->FAMI_Codigo != '')
                    $nombre_familia = $this->familia_model->obtener_nomfamilia_total($valor->FAMI_Codigo);
                $tipo_producto = $valor->TIPPROD_Codigo;
                $ultimo_costo = $valor->PROD_UltimoCosto;
                $flagGenInd = $valor->PROD_GenericoIndividual;
                $marca = $valor->MARCP_Codigo;
                $nombre_marca = '';
                $editar = "<a href='" . base_url() . "index.php/almacen/producto/editar_producto_popup/" . $codigo . "' id='editar_producto_popup' ><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                if ($marca != '0' && $marca != '') {
                    $datos_marca = $this->marca_model->obtener($marca);
                    if (count($datos_marca) > 0)
                        $nombre_marca = $datos_marca[0]->MARCC_Descripcion;
                }

                $stock = 0;
                $CodigoAlmacenProducto = 0;
                if ($datosAlmacenProducto != null && count($datosAlmacenProducto) > 0) {
                    foreach ($datosAlmacenProducto as $key => $valorReal) {
                        $CodigoAlmacenProducto = $valorReal->ALMAC_Codigo;
                        if ($CodigoAlmacenProducto == $almacen) {
                            $stock = $valorReal->ALMPROD_Stock;
                            $seleccionar = '<a href="#" onclick="seleccionar_producto(' . $codigo . ',\'' . $interno . '\',\'' . $nombre_familia . '\', \'' . $stock . '\', \'' . $ultimo_costo . '\', \'' . $flagGenInd . '\', \'' . $CodigoAlmacenProducto . '\')"><img src="' . base_url() . 'images/convertir.png"  border="0" title="Seleccionar"></a>';

                            $lista[] = array($item, $interno, $nombre_c, $serie_c, $nombre_familia, $nombre_marca, $stock, $seleccionar);
                            $item++;
                        }
                    }
                } else {
                    $seleccionar = '<a href="#" onclick="seleccionar_producto(' . $codigo . ',\'' . $interno . '\',\'' . $nombre_familia . '\', \'' . $stock . '\', \'' . $ultimo_costo . '\', \'' . $flagGenInd . '\', \'' . $CodigoAlmacenProducto . '\')"><img src="' . base_url() . 'images/convertir.png"  border="0" title="Seleccionar"></a>';
                    $lista[] = array($item, $interno, $nombre_c, $serie_c, $nombre_familia, $nombre_marca, $stock, $seleccionar);
                    $item++;
                }

            }
        }

        $lista_almacen = $this->almacen_model->seleccionar();
        $data['listaAlmacen'] = $lista_almacen;
        $data['almacen'] = $almacen;


        $data['flagBS'] = $flagBS;
        $data['lista'] = $lista;
        $data['tipo_oper'] = $tipo_oper;
        $data['buscar_producto'] = $buscar_producto;
        $this->load->view('almacen/producto_ventana_selecciona', $data);
    }


    /**gcbq obtener la serie de producto por documento e id de documento**/
    public function obtenerSerieSession($codigoProducto, $codiigoTipoDocumento, $codigoDocumento)
    {
        if (
            $codigoProducto != null && $codigoProducto != 0
            && $codiigoTipoDocumento != null && $codiigoTipoDocumento != 0
            && $codigoDocumento != null && $codigoDocumento != 0
        ) {
            /**obtenemos serie de ese producto **/
            +
                $producto_id = $codigoProducto;
            $filterSerie = new stdClass();
            $filterSerie->PROD_Codigo = $producto_id;
            $filterSerie->SERIC_FlagEstado = '1';
            $filterSerie->DOCUP_Codigo = $codiigoTipoDocumento;
            $filterSerie->SERDOC_NumeroRef = $codigoDocumento;
            $listaSeriesProducto = $this->seriedocumento_model->buscar($filterSerie, null, null);
            if ($listaSeriesProducto != null && count($listaSeriesProducto) > 0) {
                $reg = array();
                $regBD = array();
                foreach ($listaSeriesProducto as $serieValor) {
                    /**lo ingresamos como se ssion ah 2 variables 1:session que se muestra , 2:sesion que queda intacta bd
                     * cuando se actualice la session  1 se compra con la session 2.**/
                    $filter = new stdClass();
                    $filter->serieNumero = $serieValor->SERIC_Numero;
                    $filter->serieCodigo = $serieValor->SERIP_Codigo;
                    $filter->serieDocumentoCodigo = $serieValor->SERDOC_Codigo;
                    $reg[] = $filter;


                    $filterBD = new stdClass();
                    $filterBD->SERIC_Numero = $serieValor->SERIC_Numero;
                    $filterBD->SERIP_Codigo = $serieValor->SERIP_Codigo;
                    $filterBD->SERDOC_Codigo = $serieValor->SERDOC_Codigo;
                    $regBD[] = $filterBD;
                }
                $_SESSION['serieReal'][$producto_id] = $reg;
                $_SESSION['serieRealBD'][$producto_id] = $regBD;
            }
        }
    }


    public function series_ingresadas_json($codigoProducto, $codiigoTipoDocumento, $codigoDocumento, $tipoOperacion)
    {

        /**tipo oeracion 0:inventario**/
        $result = array();
        if ($tipoOperacion == '0') {
            if (
                $codigoProducto != null && $codigoProducto != 0
                && $codiigoTipoDocumento != null && $codiigoTipoDocumento != 0
                && $codigoDocumento != null && $codigoDocumento != 0
            ) {
                /**obtenemos serie de ese producto **/
                +
                    $producto_id = $codigoProducto;
                $filterSerie = new stdClass();
                $filterSerie->PROD_Codigo = $producto_id;
                $filterSerie->SERIC_FlagEstado = '1';
                $filterSerie->DOCUP_Codigo = $codiigoTipoDocumento;
                $filterSerie->SERDOC_NumeroRef = $codigoDocumento;
                $listaSeriesProducto = $this->seriedocumento_model->buscar($filterSerie, null, null);
                if ($listaSeriesProducto != null && count($listaSeriesProducto) > 0) {
                    foreach ($listaSeriesProducto as $key => $serieValor) {
                        $filter = new stdClass();
                        $fecha = date('d/m/Y h:m:s', strtotime($serieValor->SERIC_FechaRegistro));
                        $result[] = array("i" => ($key + 1), "numero" => $serieValor->SERIC_Numero, "fecha" => $fecha);
                    }

                }
            }
        } else {
            /**realizar tipo de venta y compra**/
            if (
                $codigoProducto != null && $codigoProducto != 0
                && $codiigoTipoDocumento != null && $codiigoTipoDocumento != 0
                && $codigoDocumento != null && $codigoDocumento != 0
            ) {
                /**obtenemos serie de ese producto **/
                +
                    $producto_id = $codigoProducto;
                $filterSerie = new stdClass();
                $filterSerie->PROD_Codigo = $producto_id;
                $filterSerie->SERIC_FlagEstado = '1';

                $filterSerie->DOCUP_Codigo = $codiigoTipoDocumento;
                $filterSerie->SERDOC_NumeroRef = $codigoDocumento;

                $listaSeriesProducto = $this->seriedocumento_model->buscar($filterSerie, null, null);
                if ($listaSeriesProducto != null && count($listaSeriesProducto) > 0) {
                    foreach ($listaSeriesProducto as $key => $serieValor) {
                        $filter = new stdClass();
                        $fecha = date('d/m/Y h:m:s', strtotime($serieValor->SERIC_FechaRegistro));
                        $result[] = array("i" => ($key + 1), "numero" => $serieValor->SERIC_Numero, "fecha" => $fecha);
                    }

                }
            }
        }
        echo json_encode($result);
    }


    public function series_ingresadas_almacen_json($codigoProducto, $codigoAlmacen)
    {

        /**tipo oeracion 0:inventario**/
        $result = array();

        if ($codigoProducto != null && $codigoProducto != 0) {
            /**OBTENEMOS ALMACENPRODUCTO**/
            $datosalmacenProducto = $this->almacenproducto_model->obtener($codigoAlmacen, $codigoProducto);
            /**FIN DE OBTENER ALMACEN**/
            /**obtnemos las series de ese alamcenproducto**/

            if ($datosalmacenProducto != null && count($datosalmacenProducto) > 0) {
                foreach ($datosalmacenProducto as $valor) {
                    $codigoAlmacenProducto = $valor->ALMPROD_Codigo;
                    $nombreAlmacen = $valor->ALMAC_Descripcion;
                    $listaDetallesSeries = $this->almacenproductoserie_model->listar($codigoAlmacenProducto);
                    /**fin de obtener las series**/
                    $i = 0;
                    if ($listaDetallesSeries != null && count($listaDetallesSeries) > 0) {
                        foreach ($listaDetallesSeries as $key => $serieValor) {
                            /**listamos los que no han sido movidos por venta(disparador)**/
                            if ($serieValor->ALMPRODSERC_FlagEstado == 1) {

                                $fecha = date('d/m/Y h:m:s', strtotime($serieValor->ALMPRODSERC_FechaRegistro));
                                $result[] = array("i" => ($i + 1), "numero" => $serieValor->SERIC_Numero, "almacen" => $nombreAlmacen, "fecha" => $fecha);
                                $i = $i + 1;
                            }
                        }
                    }
                }
            }
        }
        echo json_encode($result);
    }


    public function series_ingresadas_comprobante_producto_almacen_json($documento, $codigoDocumento, $codigoProducto, $codigoAlmacen)
    {

        /**tipo oeracion 0:inventario**/
        $result = array();

        if ($codigoProducto != null && $codigoProducto != 0) {
            /**obtenemos serie de ese producto **/
            +
                $producto_id = $codigoProducto;
            $filterSerie = new stdClass();
            $filterSerie->PROD_Codigo = $producto_id;
            $filterSerie->SERIC_FlagEstado = '1';

            $filterSerie->DOCUP_Codigo = $documento;
            $filterSerie->SERDOC_NumeroRef = $codigoDocumento;

            $listaSeriesProducto = $this->seriedocumento_model->buscar($filterSerie, null, null);
            if ($listaSeriesProducto != null && count($listaSeriesProducto) > 0) {
                foreach ($listaSeriesProducto as $key => $serieValor) {
                    $filter = new stdClass();
                    $fecha = date('d/m/Y h:m:s', strtotime($serieValor->SERIC_FechaRegistro));
                    $result[] = array("i" => ($key + 1), "numero" => $serieValor->SERIC_Numero, "fecha" => $fecha);
                }

            }

        }
        echo json_encode($result);
    }


    /**gcbq ventana_nueva_serie muestra venta de ingreso de Series
     * @param string $codigo
     * @param number $stock
     * @param unknown $item
     * @param string $series**/
    public function ventana_nueva_serie($codigo = '', $stock = 0, $item, $series = "")
    {
        $buscar_producto = $this->producto_model->obtener_producto($codigo);
        $lista = array();

        if (count($buscar_producto) > 0) {
            foreach ($buscar_producto as $key => $value) {
                $nombreproducto = $value->PROD_Nombre;
            }
        }

        $series = "";
        $hdseries = "";
        $array_series = "";
        //$array_hdseries = "";
        $seriesprod = $this->producto_model->obtenerSerieProducto($codigo);
        if (count($seriesprod) > 0) {
            $k = 0;
            foreach ($seriesprod as $key => $value2) {
                if ($k > 0) {
                    $series .= ',';
                    //$hdseries.=',';
                }
                $series .= $value2->SERIC_Numero;
                //$hdseries.=$value2->SERIP_Codigo;
                $k++;
            }
            $array_series = explode(",", $series);
            //$array_hdseries = explode(",", $hdseries);
        }

        $input_series = "";
        if ($array_series != '') {
            for ($i = 1; $i <= $stock; $i++) {
                //$input_series.="<tr  class='itemParTabla'><td align='center'>" . $i . "</td><td align='center'><input type='hidden' value='" . $array_hdseries[$i - 1] . "'  name='hdserie$i' id='hdserie$i' /><input value='" . $array_series[$i - 1] . "' name='serie$i' id='serie$i'  class='cajaGeneral'/></td></tr>";
                $input_series .= "<tr  class='itemParTabla'><td align='center'>" . $i . "</td><td align='center'><input value='" . $array_series[$i - 1] . "' name='serie$i' id='serie$i'  class='cajaGeneral'/></td></tr>";
            }
        } else {
            for ($i = 1; $i <= $stock; $i++) {
                $input_series .= "<tr  class='itemParTabla'><td align='center'>" . $i . "</td><td align='center'><input value='' name='serie$i' id='serie$i'  class='cajaGeneral'/></td></tr>";
            }
        }

        $lista[] = array($nombreproducto, $input_series, $stock, $item, $codigo);
        $data['lista'] = $lista;
        //echo $codigo." ".$stock;
        $this->load->view('almacen/ventana_producto_serie4', $data);
    }

    public function ventana_busqueda_producto_x_almacen($almacen_id)
    {
        $listado_productos = $this->almacenproducto_model->listar($almacen_id);
        $item = 1;
        $lista = array();
        if (count($listado_productos) > 0) {
            foreach ($listado_productos as $indice => $valor) {
                $codigo = $valor->PROD_Codigo;
                $stock = $valor->ALMPROD_Stock;
                $interno = $valor->PROD_CodigoInterno;
                $nomnbre = $valor->PROD_Nombre;
                $costo_promedio = $valor->ALMPROD_CostoPromedio;
                $familia = $this->familia_model->obtener_familia($valor->FAMI_Codigo);
                $nombre_familia = $familia[0]->FAMI_Descripcion;
                $tipo_producto = $valor->TIPPROD_Codigo;
                $stock = $valor->ALMPROD_Stock;
                $costo_promedio = $valor->ALMPROD_CostoPromedio;
                $flagGenInd = $valor->PROD_GenericoIndividual;
                $seleccionar = "<a href='#' onclick='seleccionar_producto(" . $codigo . ")' target='_parent'><img src='" . base_url() . "images/convertir.png' width='16' height='16' border='0' title='Modificar'></a>";
                $lista[] = array($item, $interno, $nomnbre, $nombre_familia, $seleccionar, $codigo, $stock, $costo_promedio, $flagGenInd);
                $item++;
            }
        }
        $data['lista'] = $lista;
        $this->load->view('almacen/producto_ventana_buqueda_x_almacen', $data);
    }

    public function ventana_producto_serie0($producto_id, $almacen_id = '0', $compania = '0', $serie = '')
    {
        $this->load->model('almacen/almacenproductoserie_model');
        $this->load->model('almacen/serie_model');

        $datos_producto = $this->producto_model->obtener_producto($producto_id);
        $lista = array();
        $i = 1;
        $compania = $compania != '0' ? $compania : $this->somevar['compania'];
        $lista_almacen = $almacen_id != '0' ? $this->almacen_model->obtener($almacen_id) : $this->almacen_model->buscar_x_compania($compania);

        foreach ($lista_almacen as $almacen) {
            $productoalmacen = $this->almacenproducto_model->obtener($almacen->ALMAP_Codigo, $producto_id);

            $almacenproducto_id = $productoalmacen[0]->ALMPROD_Codigo;


            if ($serie == '')
                $almacenproductoserie = $almacenproducto_id != '' ? $this->almacenproductoserie_model->listar($almacenproducto_id) : array();
            else
                $almacenproductoserie = $almacenproducto_id != '' ? $this->almacenproductoserie_model->listar_x_serie($almacenproducto_id, $serie) : array();

            foreach ($almacenproductoserie as $indice => $value) {
                $series = $this->serie_model->obtener2($value->SERIP_Codigo);
                $serie_nro = str_replace(strtoupper($serie), '<span class="texto_busq">' . strtoupper($serie) . '</span>', $series->SERIC_Numero);
                $mov = "<a href='javascript:;' onclick='ver_movimientos(" . $value->SERIP_Codigo . ")'><img src='" . base_url() . "images/mov.png' width='18' border='0' title='Ver movimientos'></a>";
                $lista[] = array($i++, $almacen->ALMAC_Descripcion, $datos_producto[0]->PROD_Nombre, $serie_nro, $mov);
            }
        }

        $data['serie'] = $serie;
        $data['lista'] = $lista;
        $data['oculto'] = form_hidden(array("base_url" => base_url(), "producto_id" => $producto_id, "almacen_id" => $almacen_id, "compania" => $compania));
        $this->load->view('almacen/ventana_producto_serie3', $data);
    }


    /**gcbq metodo para compras y ventas***/
    public function ventana_producto_serie($producto_id, $cantidad, $edit, $tipoOperacion, $almacen, $isSeleccionarAlmacen = 0)
    {
        $this->session->set_userdata($cantidad);
        $serial = array();
        if ($edit == 0) {
            $_SESSION['edit'] = 0;
            $serie_value = $this->session->userdata('serie');
            if ($serie_value != null && count($serie_value) > 0 && $serie_value != "") {
                foreach ($serie_value as $alm => $arralmacenSerie) {
                    if ($alm == $almacen) {
                        foreach ($arralmacenSerie as $ind1 => $arrserie) {
                            if ($ind1 == $producto_id) {
                                $serial = $arrserie;
                                break;
                            }
                        }
                        break;
                    }
                }
            }
        }
        if ($edit == 1) {
            $_SESSION['edit'] = 1;
            $serie_value2 = $this->session->userdata('serieReal');
            if ($serie_value2 != null && count($serie_value2) > 0 && $serie_value2 != "") {
                foreach ($serie_value2 as $alm2 => $arralmacenSerie2) {
                    if ($alm2 == $almacen) {
                        foreach ($arralmacenSerie2 as $ind2 => $arrserie2) {
                            if ($ind2 == $producto_id) {
                                $serial = $arrserie2;
                                break;
                            }
                        }
                        break;
                    }
                }
            }
        }
        $datos_producto = $this->producto_model->obtener_producto($producto_id);
        $numero_serie = array();
        if ($serial != null && count($serial) > 0) {
            foreach ($serial as $i => $serie) {
                $filter = new stdClass();
                $filter->serieNumero = $serie->serieNumero;
                $filter->serieCodigo = $serie->serieCodigo;
                $filter->serieDocumentoCodigo = $serie->serieDocumentoCodigo;
                $numero_serie[] = $filter;

            }
        }

        /**verificacmos si es tipo venta**/
        $data['tipo_oper'] = $tipoOperacion;
        $data['almacen'] = $almacen;
        /**fin de verificacion**/

        /**verificamos que $isSeleccionarAlmacen :1**/
        $data['isSeleccionarAlmacen'] = $isSeleccionarAlmacen;
        if ($isSeleccionarAlmacen == 1) {
            /**obtener almacenes con respecto a ese producto**/
            $almacen_id == null;
            $datosAlmacenProducto = $this->almacenproducto_model->obtener($almacen_id, $producto_id);
            if ($datosAlmacenProducto != null && count($datosAlmacenProducto) > 0) {
                $result = array();
                foreach ($datosAlmacenProducto as $indice => $valor) {
                    $codigoAlmacenProducto = $valor->ALMPROD_Codigo;
                    $codigoAlmacen = $valor->ALMAP_Codigo;
                    $nombreAlmacen = $valor->ALMAC_Descripcion;
                    $stock = $valor->ALMPROD_Stock;
                    $objeto = new stdClass();
                    $objeto->codigoAlmacen = $codigoAlmacen;
                    $objeto->nombreAlmacen = $nombreAlmacen;
                    $objeto->stock = $stock;
                    $result[] = $objeto;
                }
                $data['almacenesProducto'] = $result;
            }

        }
        /**fin de verificacion**/

        $data['numero_serie'] = $numero_serie;
        $data['nombre_producto'] = $datos_producto[0]->PROD_Nombre;
        $data['actionForm'] = base_url() . "index.php/almacen/producto/ventana_producto_serie_grabar";
        //$data['form_open'] = form_open(base_url() . "index.php/almacen/producto/ventana_producto_serie_grabar", array("name" => "frmProductoSerie", "id" => "frmProductoSerie"));
        $data['form_hidden'] = form_hidden(array("base_url" => base_url(), "producto_id" => $producto_id, "cantidad" => $cantidad));
        $data['candidadTotalIngresar'] = $cantidad;
        //$data['form_close'] = form_close();
        $this->load->view('almacen/ventana_producto_serie', $data);
    }
    public function cargarExcelSeries()
    {
        $nameEXCEL = $_FILES['archivo']['name'];
        $tmpEXCEL = $_FILES['archivo']['tmp_name'];
        $extEXCEL = pathinfo($nameEXCEL);
        $urlnueva = "images/plantillas/temporal/serie.xls";
        if (is_uploaded_file($tmpEXCEL)) {
            copy($tmpEXCEL, $urlnueva);
            echo "se actualizo excel<br>";
        }

    }
    public function mostrarDatosExcelSerie($cantidad)
    {
        $objPHPExcel = PHPExcel_IOFactory::load('images/plantillas/temporal/serie.xls');
        $objHoja = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true, true, true, true);
        //echo 'La celda A es: ' . $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, 1)->getFormattedValue()."<br>"; 

        foreach ($objHoja as $iIndice => $objCelda) {
            if ($iIndice <= $cantidad) {
                $tabla = '<tr class="itemParTabla"> ';
                $tabla .= '<td align="center" width="30">' . $iIndice . '</td>';
                $tabla .= '<td align="left"><input type="text" onblur="verificarCampoAgregado(' . $iIndice . ')" name="serie[' . $iIndice . ']" id="serie[' . $iIndice . ']" value="' . $objCelda['A'] . '" class="cajaMedia"/></td>';
                $tabla .= '<td align="center" width="30"><a href="javascript:;" class="remove" id="' . $iIndice . '" ><img src="' . base_url() . 'images/icono_desaprobar.png" width="16" height="16" border="0" title="Retirar de la Lista"/></a><input type="hidden" value="n" name="accion[' . $iIndice . ']" id="accion[' . $iIndice . ']" /></td>';
                $tabla .= '</tr>';
                echo $tabla;

                $ordenAdj = $objCelda['A'];
            } else {
                //echo "se finaliza la informacion";
                break;
            }
        }
    }
    public function validarserie($serie, $codigoSerie = 0)
    {
        $total = $this->serie_model->validarserie($serie, $codigoSerie);
        if (count($total) > 0) {
            echo 0;
        } else {
            echo 1;
        }
    }

    public function ventana_producto_serie2($producto_id, $cantidad, $almacen_id, $edit)
    {
        $this->load->model('almacen/serie_model');
        $serie_value = $this->session->userdata('serie');
        $series_sesion = array();
        if (count($serie_value) > 0 && $serie_value != "") {
            foreach ($serie_value as $ind1 => $arrserie) {
                if ($ind1 == $producto_id) {
                    $series_sesion = $arrserie;
                    break;
                }
            }
        }
        $almacenproducto = $this->almacenproducto_model->obtener($almacen_id, $producto_id);
        $almacenproducto_id = $almacenproducto[0]->ALMPROD_Codigo;
        $datos = $almacenproducto_id != '' ? $this->almacenproductoserie_model->listar($almacenproducto_id) : array();
        $datos_producto = $this->producto_model->obtener_producto($producto_id);
        /* Determinar las no disponibles */

        /* Determino los series que estan disponibles */
        $series_disponib = array();
        $series_selec = array();
        foreach ($datos as $serie) {
            $encontrado = false;
            foreach ($series_sesion as $serie_sesion) {
                if ($serie_sesion == $serie->SERIP_Codigo)
                    $encontrado = true;
            }
            if ($encontrado == false)
                $series_disponib[] = $serie;
            else
                $series_selec[] = $serie;
        }
        $data['series_disponib'] = $series_disponib;

        /////------------------------------------------------------------------------
        if ($tipo == '' and $guia != "") {

            $numero_serie = array();
            $datos_serie = $this->seriemov_model->buscar_x_guiasap($guia, $producto_id);
            //------------------------------------------------------------------------------------------
            $data['series_selec'] = $datos_serie;
        }


        if ($guiain != "" and $tipo == 1) {
            $numero_serie = array();
            $datos_serie = $this->seriemov_model->buscar_x_guiainp($guiain, $producto_id);
            //------------------------------------------------------------------------------------------
            $data['series_selec'] = $datos_serie;
        }
        if ($guiain == "" and $guia == '') {
            $data['series_selec'] = $series_selec;
        }

        $data['nombre_producto'] = $datos_producto[0]->PROD_Nombre;
        $data['form_open'] = form_open(base_url() . "index.php/almacen/producto/ventana_producto_serie_grabar", array("name" => "frmProductoSerie", "id" => "frmProductoSerie"));
        $data['form_hidden'] = form_hidden(array("producto_id" => $producto_id, "base_url" => base_url(), "cantidad" => $cantidad));
        $data['form_close'] = form_close();
        $this->load->view('almacen/ventana_producto_serie2', $data);
    }

    /**SERIES NO SELECCIONADAS JSON**/
    public function listaSeriesNoseleccionadasJson($codigoAlmacen, $codigoProducto, $numeroSerie = '')
    {
        /**obtenemos las serie del producto y del almacen que se encuentren habilitados**/


        /**obtenemos alacenproductocodigo***/
        $datoAP = $this->almacenproducto_model->obtener($codigoAlmacen, $codigoProducto);
        $codigoAlmacenProducto = $datoAP[0]->ALMPROD_Codigo;
        /***buscamos de almacenproductoSerie**/
        $datosSeriesHabilitados = $this->almacenproductoserie_model->buscarNoseleccionados($codigoAlmacenProducto, $numeroSerie);
        $resultado = array();
        //if($datosSeriesHabilitados!=null && count($datosSeriesHabilitados)>0){
        $resultado = json_encode($datosSeriesHabilitados);
        //}
        echo $resultado;

    }


    /**GUARDAMOS  LA SERIE POR BD 1:SELECCIONADO 0:DESELECCIONAR **/
    public function seleccionarSerieBD($codigoProducto, $numeroSerie, $codigoSerie, $estadoSeleccionado, $almacen)
    {
        $this->almacenproductoserie_model->seleccionarSerieBD($codigoSerie, $estadoSeleccionado);
        $editar = $this->session->userdata('edit');
        if ($estadoSeleccionado == 0) {
            /**lo sacamos de la session**/
            if ($editar == 0)
                $serie_value = $this->session->userdata('serie');
            else
                $serie_value = $this->session->userdata('serieReal');

            if ($serie_value != null && count($serie_value) > 0 && $serie_value != "") {
                foreach ($serie_value as $alm => $arrAlmacen) {
                    if ($alm == $almacen) {
                        foreach ($arrAlmacen as $ind1 => $arrserie) {
                            if ($ind1 == $codigoProducto) {
                                if ($arrserie != null && count($arrserie) > 0) {
                                    foreach ($arrserie as $key => $value) {
                                        $serieCodigoSession = $value->serieCodigo;
                                        if ($serieCodigoSession == $codigoSerie) {
                                            if ($editar == 0)
                                                unset($_SESSION['serie'][$almacen][$codigoProducto][$key]);
                                            else
                                                unset($_SESSION['serieReal'][$almacen][$codigoProducto][$key]);

                                            break;
                                        }
                                    }
                                }
                                break;
                            }
                        }
                        break;
                    }
                }
            }

        } else {

            /**obtenenmos la session anterior y lo a?dimos**/
            $data = array();
            if ($editar == 0)
                $serie_value = $this->session->userdata('serie');
            else
                $serie_value = $this->session->userdata('serieReal');

            if ($serie_value != null && count($serie_value) > 0 && $serie_value != "") {
                foreach ($serie_value as $alm => $arrAlmacen) {
                    if ($alm == $almacen) {
                        foreach ($arrAlmacen as $ind1 => $arrserie) {
                            if ($ind1 == $codigoProducto) {
                                if ($arrserie != null && count($arrserie) > 0) {
                                    $data = $arrserie;
                                }
                                break;
                            }
                        }
                        break;
                    }
                }
            }
            /**fin de a?dir session anteriori**/
            $filter = new stdClass();
            $filter->serieNumero = $numeroSerie;
            $filter->serieCodigo = $codigoSerie;
            $data[] = $filter;
            if ($editar == 0)
                $_SESSION['serie'][$almacen][$codigoProducto] = $data;
            else
                $_SESSION['serieReal'][$almacen][$codigoProducto] = $data;


        }

        print_r($this->session->userdata('serie'));
        print_r($this->session->userdata('serieReal'));
        echo $producto_id . ' - ' . $numeroPosicion;

    }



    public function ventana_producto_series2($producto_id, $cantidad, $almacen_id, $guia = '', $guiain = '', $tipo = '')
    {
        $this->load->model('almacen/serie_model');
        $serie_value = $this->session->userdata('serie');
        $series_sesion = array();
        if (count($serie_value) > 0 && $serie_value != "") {
            foreach ($serie_value as $ind1 => $arrserie) {
                if ($ind1 == $producto_id) {
                    $series_sesion = $arrserie;
                    break;
                }
            }
        }
        $almacenproducto = $this->almacenproducto_model->obtener($almacen_id, $producto_id);
        $almacenproducto_id = $almacenproducto[0]->ALMPROD_Codigo;
        $datos = $almacenproducto_id != '' ? $this->almacenproductoserie_model->listar($almacenproducto_id) : array();
        $datos_producto = $this->producto_model->obtener_producto($producto_id);
        /* Determinar las no disponibles */
        //como hago eso?


        /* Determino los series que estan disponibles */
        $series_disponib = array();
        $series_selec = array();
        foreach ($datos as $serie) {
            $encontrado = false;
            foreach ($series_sesion as $serie_sesion) {
                if ($serie_sesion == $serie->SERIP_Codigo)
                    $encontrado = true;
            }
            if ($encontrado == false)
                $series_disponib[] = $serie;
            else
                $series_selec[] = $serie;
        }

        $data['series_disponib'] = $series_disponib;

        /////------------------------------------------------------------------------
        if ($tipo == '' and $guia != "") {

            $numero_serie = array();
            $datos_serie = $this->seriemov_model->buscar_x_guiasap($guia, $producto_id);
            //------------------------------------------------------------------------------------------
            $data['series_selec'] = $datos_serie;
        }


        if ($guiain != "" and $tipo == 1) {
            $numero_serie = array();
            $datos_serie = $this->seriemov_model->buscar_x_guiainp($guiain, $producto_id);
            //------------------------------------------------------------------------------------------
            $data['series_selec'] = $datos_serie;
        }
        if ($guiain == "" and $guia == '') {
            $data['series_selec'] = $series_selec;
        }

        $data['nombre_producto'] = $datos_producto[0]->PROD_Nombre;
        $data['form_open'] = form_open(base_url() . "index.php/almacen/producto/ventana_producto_serie_grabar", array("name" => "frmProductoSerie", "id" => "frmProductoSerie"));
        $data['form_hidden'] = form_hidden(array("producto_id" => $producto_id, "base_url" => base_url(), "cantidad" => $cantidad));
        $data['form_close'] = form_close();
        $this->load->view('almacen/ventana_producto_series2', $data);
    }

    public function ventana_producto_serie_grabar()
    {

        $edit = $this->session->userdata('edit');
        $ser = $this->input->post('serie');
        $serieCodigo = $this->input->post('serieCodigo');
        $serieDocumentoCodigo = $this->input->post('serieDocumentoCodigo');
        $accion = $this->input->post('accion');
        $producto_id = $this->input->post('producto_id');
        $almacen = $this->input->post('almacen');
        if ($edit == 0)
            unset($_SESSION['serie'][$almacen][$producto_id]);
        else
            unset($_SESSION['serieReal'][$almacen][$producto_id]);

        $data = array();
        if ($ser != null && count($ser) > 0) {
            foreach ($ser as $key => $value) {
                if ($accion[$key] == 'n') {
                    $filter = new stdClass();
                    $filter->serieNumero = $value;
                    $filter->serieCodigo = $serieCodigo[$key];
                    $filter->serieDocumentoCodigo = $serieDocumentoCodigo[$key];
                    $data[] = $filter;
                }
            }
        }
        if ($edit == 0)
            $_SESSION['serie'][$almacen][$producto_id] = $data;
        else
            $_SESSION['serieReal'][$almacen][$producto_id] = $data;


        echo "1";
    }

    /**gcbq  agregagamos la funcion que ingresa los producto en seccion real**/
    public function agregarSeriesProductoSessionReal($producto_id, $almacen)
    {
        $serie_value = $this->session->userdata('serie');
        unset($_SESSION['serieReal'][$almacen][$producto_id]);
        $data = array();

        foreach ($serie_value as $alm => $arrAlmacen) {
            if ($alm == $almacen) {
                foreach ($arrAlmacen as $ind1 => $arrserie) {
                    if ($ind1 == $producto_id) {
                        $_SESSION['serieReal'][$almacen][$producto_id] = $arrserie;
                        break;
                    }
                }
            }
        }

        unset($_SESSION['serie'][$almacen][$producto_id]);
        print_r($this->session->userdata('serieReal'));
        print_r($this->session->userdata('edit'));

        echo $producto_id;
    }


    public function publicar_producto()
    {

        $datos_categ = $this->categoriapublicacion_model->seleccionar();

        $data['cboPrecio2'] = form_dropdown("precio2", array("" => "::Seleccione::", "1" => "PRECIO 1", "2" => "PRECIO 2", "3" => "PRECIO 3", "4" => "PRECIO 4", "5" => "PRECIO 5"), '', " class='comboMedio' id='precio2'");
        $data['cboCateg'] = form_dropdown("categoria", $datos_categ, '', " class='comboGrande' id='categoria'");
        $data['producto'] = $this->input->post("producto");
        $data['form_open'] = form_open(base_url() . "index.php/almacen/producto/publicar_producto_grabar", array("name" => "producto", "id" => "producto"));
        $data['form_hidden'] = form_hidden(array("base_url" => base_url()));
        $data['form_close'] = form_close();
        $this->layout->view('almacen/ventana_producto_publicar', $data);
    }

    public function despublicar_producto()
    {
        $cod = $this->input->post('cod');
        $this->productopublicacion_model->despublicar_producto($cod);
    }

    public function valida_publicacion_web($codigo)
    {

        $datos_producto_impacto = $this->producto_model->obtener_producto_impacto($codigo);

        if (count($datos_producto_impacto) > 0) {
            $this->editar_publicacion_web($codigo);
        } else {
            $this->registra_publicacion_web($codigo);
            //$this->productos();
        }
    }

    public function registra_publicacion_web($codigo)
    {

        $accion = "";
        $modo = "registrar";
        $data['form_open'] = form_open(base_url() . 'index.php/almacen/producto/registrar_publicacion_web', array("name" => "frmPublicacionWeb", "id" => "frmPublicacionWeb", "enctype" => "multipart/form-data"));
        $data['form_close'] = form_close();
        $oculto = form_hidden(array('accion' => $accion, 'codigo' => $codigo, 'modo' => $modo, 'base_url' => base_url()));
        $data['titulo'] = "REGISTRO PUBLICACION WEB";
        $data['formulario'] = "frmPublicacionWeb";
        $data['producto'] = $codigo;
        $data['oculto'] = $oculto;
        $data['imagen'] = "";
        $data['imagen_1'] = "";
        $data['imagen_2'] = "";
        $this->layout->view('almacen/registra_publicacion_web', $data);
    }

    public function registrar_publicacion_web()
    {

        $nuevonombre_imagen = '';

        if (isset($_FILES['imagen']['name']) && $_FILES['imagen']['name'] != "") {
            $origen = $_FILES['imagen']['tmp_name'];
            $temp = explode('.', $_FILES['imagen']['name']);
            $nuevonombre_imagen = $temp[0] . '_' . date('Ymd_His') . '.' . $temp[1];
            $destino = "images/img_db/" . $nuevonombre_imagen;
            move_uploaded_file($origen, $destino);
        }

        $nuevonombre_imagen_1 = '';

        if (isset($_FILES['imagen_1']['name']) && $_FILES['imagen_1']['name'] != "") {
            $origen = $_FILES['imagen_1']['tmp_name'];
            $temp = explode('.', $_FILES['imagen_1']['name']);
            $nuevonombre_imagen_1 = $temp[0] . '_' . date('Ymd_His') . '.' . $temp[1];
            $destino = "images/img_db/" . $nuevonombre_imagen_1;
            move_uploaded_file($origen, $destino);
        }


        $nuevonombre_imagen_2 = '';

        if (isset($_FILES['imagen_2']['name']) && $_FILES['imagen_2']['name'] != "") {
            $origen = $_FILES['imagen_2']['tmp_name'];
            $temp = explode('.', $_FILES['imagen_2']['name']);
            $nuevonombre_imagen_2 = $temp[0] . '_' . date('Ymd_His') . '.' . $temp[1];
            $destino = "images/img_db/" . $nuevonombre_imagen_2;
            move_uploaded_file($origen, $destino);
        }

        $producto = $this->input->post('codigo');

        $imppub_descripcion = $this->input->post('imppub_descripcion');

        //$sec_codigo_1       = $this->input->post('sec_codigo_1');

        $sec_codigo_1 = 1;
        $sec_descripcion_1 = $this->input->post('sec_descripcion_1');
        $col1_fil1_1 = $this->input->post('col1_fil1_1');
        $col1_fil2_1 = $this->input->post('col1_fil2_1');
        $col1_fil3_1 = $this->input->post('col1_fil3_1');
        $col1_fil4_1 = $this->input->post('col1_fil4_1');
        $col1_fil5_1 = $this->input->post('col1_fil5_1');
        $col2_fil1_1 = $this->input->post('col2_fil1_1');
        $col2_fil2_1 = $this->input->post('col2_fil2_1');
        $col2_fil3_1 = $this->input->post('col2_fil3_1');
        $col2_fil4_1 = $this->input->post('col2_fil4_1');
        $col2_fil5_1 = $this->input->post('col2_fil5_1');
        //$imagen             = $this->input->post('imagen') ;

        $filter1 = new stdClass();
        //$imppub_codigo1 = null;
        //$imppub_codigo1->IMPPUB_Codigo =$imppub_codigo_1;

        $filter1->PROD_Codigo = $producto;
        $filter1->IMPPUB_Descripcion = $imppub_descripcion;
        $filter1->SEC_Codigo = $sec_codigo_1;
        $filter1->SEC_Descripcion = $sec_descripcion_1;
        $filter1->COL1_FIL1 = $col1_fil1_1;
        $filter1->COL1_FIL2 = $col1_fil2_1;
        $filter1->COL1_FIL3 = $col1_fil3_1;
        $filter1->COL1_FIL4 = $col1_fil4_1;
        $filter1->COL1_FIL5 = $col1_fil5_1;
        $filter1->COL2_FIL1 = $col2_fil1_1;
        $filter1->COL2_FIL2 = $col2_fil2_1;
        $filter1->COL2_FIL3 = $col2_fil3_1;
        $filter1->COL2_FIL4 = $col2_fil4_1;
        $filter1->COL2_FIL5 = $col2_fil5_1;
        $filter1->IMAGEN_1 = $nuevonombre_imagen;
        $filter1->IMAGEN_2 = $nuevonombre_imagen_1;
        $filter1->IMAGEN_3 = $nuevonombre_imagen_2;

        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '100';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';

        $this->load->library('upload', $config);

        $this->producto_model->registrar_publicacion_web($filter1);


        $sec_codigo_2 = 2;
        $sec_descripcion_2 = $this->input->post('sec_descripcion_2');
        $col1_fil1_2 = $this->input->post('col1_fil1_2');
        $col1_fil2_2 = $this->input->post('col1_fil2_2');
        $col1_fil3_2 = $this->input->post('col1_fil3_2');
        $col1_fil4_2 = $this->input->post('col1_fil4_2');
        $col1_fil5_2 = $this->input->post('col1_fil5_2');
        $col2_fil1_2 = $this->input->post('col2_fil1_2');
        $col2_fil2_2 = $this->input->post('col2_fil2_2');
        $col2_fil3_2 = $this->input->post('col2_fil3_2');
        $col2_fil4_2 = $this->input->post('col2_fil4_2');
        $col2_fil5_2 = $this->input->post('col2_fil5_2');

        $filter2 = new stdClass();
        //$imppub_codigo2 = null;
        //$imppub_codigo2->IMPPUB_Codigo =$imppub_codigo_2;

        $filter2->PROD_Codigo = $producto;
        $filter2->IMPPUB_Descripcion = $imppub_descripcion;
        $filter2->SEC_Codigo = $sec_codigo_2;
        $filter2->SEC_Descripcion = $sec_descripcion_2;
        $filter2->COL1_FIL1 = $col1_fil1_2;
        $filter2->COL1_FIL2 = $col1_fil2_2;
        $filter2->COL1_FIL3 = $col1_fil3_2;
        $filter2->COL1_FIL4 = $col1_fil4_2;
        $filter2->COL1_FIL5 = $col1_fil5_2;
        $filter2->COL2_FIL1 = $col2_fil1_2;
        $filter2->COL2_FIL2 = $col2_fil2_2;
        $filter2->COL2_FIL3 = $col2_fil3_2;
        $filter2->COL2_FIL4 = $col2_fil4_2;
        $filter2->COL2_FIL5 = $col2_fil5_2;
        //$filter2->IMAGEN_1  = $imagen;
        $this->producto_model->registrar_publicacion_web($filter2);

        //$sec_codigo_3       = $this->input->post('sec_codigo_3'); 

        $sec_codigo_3 = 3;
        $sec_descripcion_3 = $this->input->post('sec_descripcion_3');
        $col1_fil1_3 = $this->input->post('col1_fil1_3');
        $col1_fil2_3 = $this->input->post('col1_fil2_3');
        $col1_fil3_3 = $this->input->post('col1_fil3_3');
        $col1_fil4_3 = $this->input->post('col1_fil4_3');
        $col1_fil5_3 = $this->input->post('col1_fil5_3');
        $col2_fil1_3 = $this->input->post('col2_fil1_3');
        $col2_fil2_3 = $this->input->post('col2_fil2_3');
        $col2_fil3_3 = $this->input->post('col2_fil3_3');
        $col2_fil4_3 = $this->input->post('col2_fil4_3');
        $col2_fil5_3 = $this->input->post('col2_fil5_3');

        $filter3 = new stdClass();
        //$imppub_codigo3 = null;
        //$imppub_codigo3->IMPPUB_Codigo =$imppub_codigo_3;

        $filter3->PROD_Codigo = $producto;
        $filter3->IMPPUB_Descripcion = $imppub_descripcion;
        $filter3->SEC_Codigo = $sec_codigo_3;
        $filter3->SEC_Descripcion = $sec_descripcion_3;
        $filter3->COL1_FIL1 = $col1_fil1_3;
        $filter3->COL1_FIL2 = $col1_fil2_3;
        $filter3->COL1_FIL3 = $col1_fil3_3;
        $filter3->COL1_FIL4 = $col1_fil4_3;
        $filter3->COL1_FIL5 = $col1_fil5_3;
        $filter3->COL2_FIL1 = $col2_fil1_3;
        $filter3->COL2_FIL2 = $col2_fil2_3;
        $filter3->COL2_FIL3 = $col2_fil3_3;
        $filter3->COL2_FIL4 = $col2_fil4_3;
        $filter3->COL2_FIL5 = $col2_fil5_3;
        //$filter3->IMAGEN_1  = $imagen;
        $this->producto_model->registrar_publicacion_web($filter3);

        //$sec_codigo_4       = $this->input->post('sec_codigo_4'); 

        $sec_codigo_4 = 4;
        $sec_descripcion_4 = $this->input->post('sec_descripcion_4');
        $col1_fil1_4 = $this->input->post('col1_fil1_4');
        $col1_fil2_4 = $this->input->post('col1_fil2_4');
        $col1_fil3_4 = $this->input->post('col1_fil3_4');
        $col1_fil4_4 = $this->input->post('col1_fil4_4');
        $col1_fil5_4 = $this->input->post('col1_fil5_4');
        $col2_fil1_4 = $this->input->post('col2_fil1_4');
        $col2_fil2_4 = $this->input->post('col2_fil2_4');
        $col2_fil3_4 = $this->input->post('col2_fil3_4');
        $col2_fil4_4 = $this->input->post('col2_fil4_4');
        $col2_fil5_4 = $this->input->post('col2_fil5_4');

        $filter4 = new stdClass();
        //$imppub_codigo4 = null;
        //$imppub_codigo4->IMPPUB_Codigo =$imppub_codigo_4;

        $filter4->PROD_Codigo = $producto;
        $filter4->IMPPUB_Descripcion = $imppub_descripcion;
        $filter4->SEC_Codigo = $sec_codigo_4;
        $filter4->SEC_Descripcion = $sec_descripcion_4;
        $filter4->COL1_FIL1 = $col1_fil1_4;
        $filter4->COL1_FIL2 = $col1_fil2_4;
        $filter4->COL1_FIL3 = $col1_fil3_4;
        $filter4->COL1_FIL4 = $col1_fil4_4;
        $filter4->COL1_FIL5 = $col1_fil5_4;
        $filter4->COL2_FIL1 = $col2_fil1_4;
        $filter4->COL2_FIL2 = $col2_fil2_4;
        $filter4->COL2_FIL3 = $col2_fil3_4;
        $filter4->COL2_FIL4 = $col2_fil4_4;
        $filter4->COL2_FIL5 = $col2_fil5_4;
        //$filter4->IMAGEN_1  = $imagen;
        $this->producto_model->registrar_publicacion_web($filter4);

        //$sec_codigo_5       = $this->input->post('sec_codigo_5'); 

        $sec_codigo_5 = 5;
        $sec_descripcion_5 = $this->input->post('sec_descripcion_5');
        $col1_fil1_5 = $this->input->post('col1_fil1_5');
        $col1_fil2_5 = $this->input->post('col1_fil2_5');
        $col1_fil3_5 = $this->input->post('col1_fil3_5');
        $col1_fil4_5 = $this->input->post('col1_fil4_5');
        $col1_fil5_5 = $this->input->post('col1_fil5_5');
        $col2_fil1_5 = $this->input->post('col2_fil1_5');
        $col2_fil2_5 = $this->input->post('col2_fil2_5');
        $col2_fil3_5 = $this->input->post('col2_fil3_5');
        $col2_fil4_5 = $this->input->post('col2_fil4_5');
        $col2_fil5_5 = $this->input->post('col2_fil5_5');

        $filter5 = new stdClass();
        //$imppub_codigo5 = null;
        //$imppub_codigo5->IMPPUB_Codigo =$imppub_codigo_5;

        $filter5->PROD_Codigo = $producto;
        $filter5->IMPPUB_Descripcion = $imppub_descripcion;
        $filter5->SEC_Codigo = $sec_codigo_5;
        $filter5->SEC_Descripcion = $sec_descripcion_5;
        $filter5->COL1_FIL1 = $col1_fil1_5;
        $filter5->COL1_FIL2 = $col1_fil2_5;
        $filter5->COL1_FIL3 = $col1_fil3_5;
        $filter5->COL1_FIL4 = $col1_fil4_5;
        $filter5->COL1_FIL5 = $col1_fil5_5;
        $filter5->COL2_FIL1 = $col2_fil1_5;
        $filter5->COL2_FIL2 = $col2_fil2_5;
        $filter5->COL2_FIL3 = $col2_fil3_5;
        $filter5->COL2_FIL4 = $col2_fil4_5;
        $filter5->COL2_FIL5 = $col2_fil5_5;
        //$filter5->IMAGEN_1  = $imagen;
        $this->producto_model->registrar_publicacion_web($filter5);

        $this->productos();
    }

    public function editar_publicacion_web($codigo)
    {

        $datos_producto_impacto = $this->producto_model->obtener_producto_impacto($codigo);
        $data['imppub_descripcion'] = $datos_producto_impacto[0]->IMPPUB_Descripcion;

        //Sección 1
        $data['imppub_codigo_1'] = $datos_producto_impacto[0]->IMPPUB_Codigo;
        $data['imagen'] = $datos_producto_impacto[0]->IMAGEN_1;
        $data['imagen_1'] = $datos_producto_impacto[0]->IMAGEN_2;
        $data['imagen_2'] = $datos_producto_impacto[0]->IMAGEN_3;
        $data['sec_descripcion_1'] = $datos_producto_impacto[0]->SEC_Descripcion;
        $data['col1_fil1_1'] = $datos_producto_impacto[0]->COL1_FIL1;
        $data['col1_fil2_1'] = $datos_producto_impacto[0]->COL1_FIL2;
        $data['col1_fil3_1'] = $datos_producto_impacto[0]->COL1_FIL3;
        $data['col1_fil4_1'] = $datos_producto_impacto[0]->COL1_FIL4;
        $data['col1_fil5_1'] = $datos_producto_impacto[0]->COL1_FIL5;
        $data['col2_fil1_1'] = $datos_producto_impacto[0]->COL2_FIL1;
        $data['col2_fil2_1'] = $datos_producto_impacto[0]->COL2_FIL2;
        $data['col2_fil3_1'] = $datos_producto_impacto[0]->COL2_FIL3;
        $data['col2_fil4_1'] = $datos_producto_impacto[0]->COL2_FIL4;
        $data['col2_fil5_1'] = $datos_producto_impacto[0]->COL2_FIL5;

        //Sección 2
        $data['imppub_codigo_2'] = $datos_producto_impacto[1]->IMPPUB_Codigo;
        //$data['sec_codigo_2']      = $datos_producto_impacto[1]->SEC_Codigo;
        $data['sec_descripcion_2'] = $datos_producto_impacto[1]->SEC_Descripcion;
        $data['col1_fil1_2'] = $datos_producto_impacto[1]->COL1_FIL1;
        $data['col1_fil2_2'] = $datos_producto_impacto[1]->COL1_FIL2;
        $data['col1_fil3_2'] = $datos_producto_impacto[1]->COL1_FIL3;
        $data['col1_fil4_2'] = $datos_producto_impacto[1]->COL1_FIL4;
        $data['col1_fil5_2'] = $datos_producto_impacto[1]->COL1_FIL5;
        $data['col2_fil1_2'] = $datos_producto_impacto[1]->COL2_FIL1;
        $data['col2_fil2_2'] = $datos_producto_impacto[1]->COL2_FIL2;
        $data['col2_fil3_2'] = $datos_producto_impacto[1]->COL2_FIL3;
        $data['col2_fil4_2'] = $datos_producto_impacto[1]->COL2_FIL4;
        $data['col2_fil5_2'] = $datos_producto_impacto[1]->COL2_FIL5;

        //Sección 3
        $data['imppub_codigo_3'] = $datos_producto_impacto[2]->IMPPUB_Codigo;
        //$data['sec_codigo_3']      = $datos_producto_impacto[2]->SEC_Codigo;
        $data['sec_descripcion_3'] = $datos_producto_impacto[2]->SEC_Descripcion;
        $data['col1_fil1_3'] = $datos_producto_impacto[2]->COL1_FIL1;
        $data['col1_fil2_3'] = $datos_producto_impacto[2]->COL1_FIL2;
        $data['col1_fil3_3'] = $datos_producto_impacto[2]->COL1_FIL3;
        $data['col1_fil4_3'] = $datos_producto_impacto[2]->COL1_FIL4;
        $data['col1_fil5_3'] = $datos_producto_impacto[2]->COL1_FIL5;
        $data['col2_fil1_3'] = $datos_producto_impacto[2]->COL2_FIL1;
        $data['col2_fil2_3'] = $datos_producto_impacto[2]->COL2_FIL2;
        $data['col2_fil3_3'] = $datos_producto_impacto[2]->COL2_FIL3;
        $data['col2_fil4_3'] = $datos_producto_impacto[2]->COL2_FIL4;
        $data['col2_fil5_3'] = $datos_producto_impacto[2]->COL2_FIL5;

        //Sección 4
        $data['imppub_codigo_4'] = $datos_producto_impacto[3]->IMPPUB_Codigo;
        //$data['sec_codigo_4']      = $datos_producto_impacto[3]->SEC_Codigo;
        $data['sec_descripcion_4'] = $datos_producto_impacto[3]->SEC_Descripcion;
        $data['col1_fil1_4'] = $datos_producto_impacto[3]->COL1_FIL1;
        $data['col1_fil2_4'] = $datos_producto_impacto[3]->COL1_FIL2;
        $data['col1_fil3_4'] = $datos_producto_impacto[3]->COL1_FIL3;
        $data['col1_fil4_4'] = $datos_producto_impacto[3]->COL1_FIL4;
        $data['col1_fil5_4'] = $datos_producto_impacto[3]->COL1_FIL5;
        $data['col2_fil1_4'] = $datos_producto_impacto[3]->COL2_FIL1;
        $data['col2_fil2_4'] = $datos_producto_impacto[3]->COL2_FIL2;
        $data['col2_fil3_4'] = $datos_producto_impacto[3]->COL2_FIL3;
        $data['col2_fil4_4'] = $datos_producto_impacto[3]->COL2_FIL4;
        $data['col2_fil5_4'] = $datos_producto_impacto[3]->COL2_FIL5;

        //Sección 5
        $data['imppub_codigo_5'] = $datos_producto_impacto[4]->IMPPUB_Codigo;
        //$data['sec_codigo_5']      = $datos_producto_impacto[4]->SEC_Codigo;
        $data['sec_descripcion_5'] = $datos_producto_impacto[4]->SEC_Descripcion;
        $data['col1_fil1_5'] = $datos_producto_impacto[4]->COL1_FIL1;
        $data['col1_fil2_5'] = $datos_producto_impacto[4]->COL1_FIL2;
        $data['col1_fil3_5'] = $datos_producto_impacto[4]->COL1_FIL3;
        $data['col1_fil4_5'] = $datos_producto_impacto[4]->COL1_FIL4;
        $data['col1_fil5_5'] = $datos_producto_impacto[4]->COL1_FIL5;
        $data['col2_fil1_5'] = $datos_producto_impacto[4]->COL2_FIL1;
        $data['col2_fil2_5'] = $datos_producto_impacto[4]->COL2_FIL2;
        $data['col2_fil3_5'] = $datos_producto_impacto[4]->COL2_FIL3;
        $data['col2_fil4_5'] = $datos_producto_impacto[4]->COL2_FIL4;
        $data['col2_fil5_5'] = $datos_producto_impacto[4]->COL2_FIL5;

        //Fin de IMPACTO_PUBLICACION

        $accion = "";
        $modo = "modificar";
        $data['form_open'] = form_open(base_url() . 'index.php/almacen/producto/modificar_publicacion_web', array("name" => "frmPublicacionWeb", "id" => "frmPublicacionWeb", "enctype" => "multipart/form-data"));
        $data['form_close'] = form_close();
        $oculto = form_hidden(array('accion' => $accion, 'codigo' => $codigo, 'modo' => $modo, 'base_url' => base_url()));
        $data['titulo'] = "EDICION DE PUBLICACION WEB";
        $data['formulario'] = "frmPublicacionWeb";
        $data['producto'] = $codigo;
        $data['oculto'] = $oculto;
        //$data['imagen']     = $datos_producto_impacto[0]->IMAGEN_1;
        $this->layout->view('almacen/edita_publicacion_web', $data);
    }

    public function subir_documento()
    {
        $data['documento'] = "";
        $data['form_open'] = form_open(base_url() . "index.php/almacen/producto/subir_documento_grabar", array("name" => "frmdocumento", "id" => "frmdocumento", "enctype" => "multipart/form-data"));
        $data['documento'] = form_upload("documento", " class='comboGrande' id='documento'");
        $data['form_hidden'] = form_hidden(array("base_url" => base_url()));
        $data['form_close'] = form_close();
        $this->load->view('almacen/ventana_subir_documento', $data);
    }

    public function comprobar_string($cadena)
    {
        //compruebo que los caracteres sean los permitidos
        $permitidos = array(".html", ".jsp", ".xhtml", ".xml", ".php", ".asp", ".exe", ".sql");
        foreach ($permitidos as $valor) {
            $resultado = strpos($cadena, $valor);
            if ($resultado !== FALSE) {
                return "novalido";
            }
        }
        return $cadena;
    }

    public function subir_documento_grabar()
    {
        $dco = $_FILES['documento']['name'];

        $config['upload_path'] = 'documentos/';
        $config['allowed_types'] = 'doc|docx|xlsx|xls|pdf';

        //
        $config['encrypt_name'] = 'false';
        //
        $config['max_size'] = '5120';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $this->load->library('upload', $config);
        $nombrevalidado = $this->comprobar_string($dco);

        if ($nombrevalidado !== "novalido") {
            if (!$this->upload->do_upload('documento')) {
                $error = array('error' => $this->upload->display_errors());
                //print_r($error);
                $mensaje['mensaje'] = "El formato del archivo no es el permitido";
                $this->load->view('almacen/ventana_mensaje', $mensaje);
            } else {

                $data1 = $this->upload->data();
                $nombre = $data1['file_name'];

                $filter = new stdClass();
                $filter->IMPDOC_Nombre = $nombre;
                $this->producto_model->insertar_carga($filter);
                $mensaje['mensaje'] = "ARCHIVO IMPORTADO CORRECTAMENTE";
                $this->load->view('almacen/ventana_mensaje', $mensaje);
            }
        } else {

            $error = array('error' => $this->upload->display_errors());
            //print_r($error);
            $mensaje['mensaje'] = "El formato del archivo no es el permitido";
            $this->load->view('almacen/ventana_mensaje', $mensaje);
        }
    }

    public function modificar_publicacion_web()
    {

        $nuevonombre_imagen = '';

        if (isset($_FILES['imagen']['name']) && $_FILES['imagen']['name'] != "") {
            $origen = $_FILES['imagen']['tmp_name'];
            $temp = explode('.', $_FILES['imagen']['name']);

            if (in_array($temp[1], array('jpg', 'jpeg', 'png', 'gif', 'bmp'))) {
                $nuevonombre_imagen = $temp[0] . '_' . date('Ymd_His') . '.' . $temp[1];
                $destino = "images/img_db/" . $nuevonombre_imagen;
                move_uploaded_file($origen, $destino);
            }
        }

        $nuevonombre_imagen_1 = '';

        if (isset($_FILES['imagen_1']['name']) && $_FILES['imagen_1']['name'] != "") {
            $origen = $_FILES['imagen_1']['tmp_name'];
            $temp = explode('.', $_FILES['imagen_1']['name']);

            if (in_array($temp[1], array('jpg', 'jpeg', 'png', 'gif', 'bmp'))) {
                $nuevonombre_imagen_1 = $temp[0] . '_' . date('Ymd_His') . '.' . $temp[1];
                $destino = "images/img_db/" . $nuevonombre_imagen_1;
                move_uploaded_file($origen, $destino);
            }
        }
        $nuevonombre_imagen_2 = '';

        if (isset($_FILES['imagen_2']['name']) && $_FILES['imagen_2']['name'] != "") {
            $origen = $_FILES['imagen_2']['tmp_name'];
            $temp = explode('.', $_FILES['imagen_2']['name']);

            if (in_array($temp[1], array('jpg', 'jpeg', 'png', 'gif', 'bmp'))) {
                $nuevonombre_imagen_2 = $temp[0] . '_' . date('Ymd_His') . '.' . $temp[1];
                $destino = "images/img_db/" . $nuevonombre_imagen_2;
                move_uploaded_file($origen, $destino);
            }
        }


        $producto = $this->input->post('codigo');

        $imppub_descripcion = $this->input->post('imppub_descripcion');

        //$sec_codigo_1       = $this->input->post('sec_codigo_1');

        $imppub_codigo_1 = $this->input->post('imppub_codigo_1');
        $sec_codigo_1 = 1;
        $sec_descripcion_1 = $this->input->post('sec_descripcion_1');
        $col1_fil1_1 = $this->input->post('col1_fil1_1');
        $col1_fil2_1 = $this->input->post('col1_fil2_1');
        $col1_fil3_1 = $this->input->post('col1_fil3_1');
        $col1_fil4_1 = $this->input->post('col1_fil4_1');
        $col1_fil5_1 = $this->input->post('col1_fil5_1');
        $col2_fil1_1 = $this->input->post('col2_fil1_1');
        $col2_fil2_1 = $this->input->post('col2_fil2_1');
        $col2_fil3_1 = $this->input->post('col2_fil3_1');
        $col2_fil4_1 = $this->input->post('col2_fil4_1');
        $col2_fil5_1 = $this->input->post('col2_fil5_1');

        $filter1 = new stdClass();
        //$imppub_codigo1 = null;
        //$imppub_codigo1->IMPPUB_Codigo =$imppub_codigo_1;
        $filter1->PROD_Codigo = $producto;
        $filter1->IMPPUB_Descripcion = $imppub_descripcion;
        $filter1->SEC_Codigo = $sec_codigo_1;
        $filter1->SEC_Descripcion = $sec_descripcion_1;
        $filter1->COL1_FIL1 = $col1_fil1_1;
        $filter1->COL1_FIL2 = $col1_fil2_1;
        $filter1->COL1_FIL3 = $col1_fil3_1;
        $filter1->COL1_FIL4 = $col1_fil4_1;
        $filter1->COL1_FIL5 = $col1_fil5_1;
        $filter1->COL2_FIL1 = $col2_fil1_1;
        $filter1->COL2_FIL2 = $col2_fil2_1;
        $filter1->COL2_FIL3 = $col2_fil3_1;
        $filter1->COL2_FIL4 = $col2_fil4_1;
        $filter1->COL2_FIL5 = $col2_fil5_1;

        $filter1->IMAGEN_1 = $nuevonombre_imagen;
        if ($nuevonombre_imagen == '')
            unset($filter1->IMAGEN_1);
        $filter1->IMAGEN_2 = $nuevonombre_imagen_1;
        if ($nuevonombre_imagen_1 == '')
            unset($filter1->IMAGEN_2);
        $filter1->IMAGEN_3 = $nuevonombre_imagen_2;
        if ($nuevonombre_imagen_2 == '')
            unset($filter1->IMAGEN_3);

        $this->producto_model->modificar_publicacion_web($imppub_codigo_1, $filter1);

        //$sec_codigo_2       = $this->input->post('sec_codigo_2');

        $imppub_codigo_2 = $this->input->post('imppub_codigo_2');
        $sec_codigo_2 = 2;
        $sec_descripcion_2 = $this->input->post('sec_descripcion_2');
        $col1_fil1_2 = $this->input->post('col1_fil1_2');
        $col1_fil2_2 = $this->input->post('col1_fil2_2');
        $col1_fil3_2 = $this->input->post('col1_fil3_2');
        $col1_fil4_2 = $this->input->post('col1_fil4_2');
        $col1_fil5_2 = $this->input->post('col1_fil5_2');
        $col2_fil1_2 = $this->input->post('col2_fil1_2');
        $col2_fil2_2 = $this->input->post('col2_fil2_2');
        $col2_fil3_2 = $this->input->post('col2_fil3_2');
        $col2_fil4_2 = $this->input->post('col2_fil4_2');
        $col2_fil5_2 = $this->input->post('col2_fil5_2');

        $filter2 = new stdClass();
        //$imppub_codigo2 = null;
        //$imppub_codigo2->IMPPUB_Codigo =$imppub_codigo_2;
        $filter2->PROD_Codigo = $producto;
        $filter2->IMPPUB_Descripcion = $imppub_descripcion;
        $filter2->SEC_Codigo = $sec_codigo_2;
        $filter2->SEC_Descripcion = $sec_descripcion_2;
        $filter2->COL1_FIL1 = $col1_fil1_2;
        $filter2->COL1_FIL2 = $col1_fil2_2;
        $filter2->COL1_FIL3 = $col1_fil3_2;
        $filter2->COL1_FIL4 = $col1_fil4_2;
        $filter2->COL1_FIL5 = $col1_fil5_2;
        $filter2->COL2_FIL1 = $col2_fil1_2;
        $filter2->COL2_FIL2 = $col2_fil2_2;
        $filter2->COL2_FIL3 = $col2_fil3_2;
        $filter2->COL2_FIL4 = $col2_fil4_2;
        $filter2->COL2_FIL5 = $col2_fil5_2;

        $this->producto_model->modificar_publicacion_web($imppub_codigo_2, $filter2);

        //$sec_codigo_3       = $this->input->post('sec_codigo_3');

        $imppub_codigo_3 = $this->input->post('imppub_codigo_3');
        $sec_codigo_3 = 3;
        $sec_descripcion_3 = $this->input->post('sec_descripcion_3');
        $col1_fil1_3 = $this->input->post('col1_fil1_3');
        $col1_fil2_3 = $this->input->post('col1_fil2_3');
        $col1_fil3_3 = $this->input->post('col1_fil3_3');
        $col1_fil4_3 = $this->input->post('col1_fil4_3');
        $col1_fil5_3 = $this->input->post('col1_fil5_3');
        $col2_fil1_3 = $this->input->post('col2_fil1_3');
        $col2_fil2_3 = $this->input->post('col2_fil2_3');
        $col2_fil3_3 = $this->input->post('col2_fil3_3');
        $col2_fil4_3 = $this->input->post('col2_fil4_3');
        $col2_fil5_3 = $this->input->post('col2_fil5_3');

        $filter3 = new stdClass();
        //$imppub_codigo3 = null;
        //$imppub_codigo3->IMPPUB_Codigo =$imppub_codigo_3;
        $filter3->PROD_Codigo = $producto;
        $filter3->IMPPUB_Descripcion = $imppub_descripcion;
        $filter3->SEC_Codigo = $sec_codigo_3;
        $filter3->SEC_Descripcion = $sec_descripcion_3;
        $filter3->COL1_FIL1 = $col1_fil1_3;
        $filter3->COL1_FIL2 = $col1_fil2_3;
        $filter3->COL1_FIL3 = $col1_fil3_3;
        $filter3->COL1_FIL4 = $col1_fil4_3;
        $filter3->COL1_FIL5 = $col1_fil5_3;
        $filter3->COL2_FIL1 = $col2_fil1_3;
        $filter3->COL2_FIL2 = $col2_fil2_3;
        $filter3->COL2_FIL3 = $col2_fil3_3;
        $filter3->COL2_FIL4 = $col2_fil4_3;
        $filter3->COL2_FIL5 = $col2_fil5_3;

        $this->producto_model->modificar_publicacion_web($imppub_codigo_3, $filter3);

        //$sec_codigo_4       = $this->input->post('sec_codigo_4');

        $imppub_codigo_4 = $this->input->post('imppub_codigo_4');
        $sec_codigo_4 = 4;
        $sec_descripcion_4 = $this->input->post('sec_descripcion_4');
        $col1_fil1_4 = $this->input->post('col1_fil1_4');
        $col1_fil2_4 = $this->input->post('col1_fil2_4');
        $col1_fil3_4 = $this->input->post('col1_fil3_4');
        $col1_fil4_4 = $this->input->post('col1_fil4_4');
        $col1_fil5_4 = $this->input->post('col1_fil5_4');
        $col2_fil1_4 = $this->input->post('col2_fil1_4');
        $col2_fil2_4 = $this->input->post('col2_fil2_4');
        $col2_fil3_4 = $this->input->post('col2_fil3_4');
        $col2_fil4_4 = $this->input->post('col2_fil4_4');
        $col2_fil5_4 = $this->input->post('col2_fil5_4');

        $filter4 = new stdClass();
        //$imppub_codigo4 = null;
        //$imppub_codigo4->IMPPUB_Codigo =$imppub_codigo_4;
        $filter4->PROD_Codigo = $producto;
        $filter4->IMPPUB_Descripcion = $imppub_descripcion;
        $filter4->SEC_Codigo = $sec_codigo_4;
        $filter4->SEC_Descripcion = $sec_descripcion_4;
        $filter4->COL1_FIL1 = $col1_fil1_4;
        $filter4->COL1_FIL2 = $col1_fil2_4;
        $filter4->COL1_FIL3 = $col1_fil3_4;
        $filter4->COL1_FIL4 = $col1_fil4_4;
        $filter4->COL1_FIL5 = $col1_fil5_4;
        $filter4->COL2_FIL1 = $col2_fil1_4;
        $filter4->COL2_FIL2 = $col2_fil2_4;
        $filter4->COL2_FIL3 = $col2_fil3_4;
        $filter4->COL2_FIL4 = $col2_fil4_4;
        $filter4->COL2_FIL5 = $col2_fil5_4;

        $this->producto_model->modificar_publicacion_web($imppub_codigo_4, $filter4);

        //$sec_codigo_5       = $this->input->post('sec_codigo_5');

        $imppub_codigo_5 = $this->input->post('imppub_codigo_5');
        $sec_codigo_5 = 5;
        $sec_descripcion_5 = $this->input->post('sec_descripcion_5');
        $col1_fil1_5 = $this->input->post('col1_fil1_5');
        $col1_fil2_5 = $this->input->post('col1_fil2_5');
        $col1_fil3_5 = $this->input->post('col1_fil3_5');
        $col1_fil4_5 = $this->input->post('col1_fil4_5');
        $col1_fil5_5 = $this->input->post('col1_fil5_5');
        $col2_fil1_5 = $this->input->post('col2_fil1_5');
        $col2_fil2_5 = $this->input->post('col2_fil2_5');
        $col2_fil3_5 = $this->input->post('col2_fil3_5');
        $col2_fil4_5 = $this->input->post('col2_fil4_5');
        $col2_fil5_5 = $this->input->post('col2_fil5_5');

        $filter5 = new stdClass();
        //$imppub_codigo5 = null;
        //$imppub_codigo5->IMPPUB_Codigo =$imppub_codigo_5;
        $filter5->PROD_Codigo = $producto;
        $filter5->IMPPUB_Descripcion = $imppub_descripcion;
        $filter5->SEC_Codigo = $sec_codigo_5;
        $filter5->SEC_Descripcion = $sec_descripcion_5;
        $filter5->COL1_FIL1 = $col1_fil1_5;
        $filter5->COL1_FIL2 = $col1_fil2_5;
        $filter5->COL1_FIL3 = $col1_fil3_5;
        $filter5->COL1_FIL4 = $col1_fil4_5;
        $filter5->COL1_FIL5 = $col1_fil5_5;
        $filter5->COL2_FIL1 = $col2_fil1_5;
        $filter5->COL2_FIL2 = $col2_fil2_5;
        $filter5->COL2_FIL3 = $col2_fil3_5;
        $filter5->COL2_FIL4 = $col2_fil4_5;
        $filter5->COL2_FIL5 = $col2_fil5_5;

        $this->producto_model->modificar_publicacion_web($imppub_codigo_5, $filter5);

        $this->productos();
    }

    public function publicar_producto_grabar()
    {
        if ($this->input->post('precio2') == '' || $this->input->post('precio2') == '0')
            exit('{"result":"error", "campo":"precio2"}');
        if ($this->input->post('categoria') == '' || $this->input->post('categoria') == '0')
            exit('{"result":"error", "campo":"categoria"}');
        $producto = $this->input->post("producto");

        foreach ($producto as $productos) {
            $filter = new stdClass();
            $filter->PROD_Codigo = $productos;
            $filter->COMPP_Codigo = $this->somevar['compania'];
            $filter->CATE_Codigo = $this->input->post('precio2');
            $filter->CATPUBP_Codigo = $this->input->post('categoria');
            $this->productopublicacion_model->insertar($filter);
        }

        $this->productos();
    }

    public function ventana_nuevo_producto($flagBS = 'B')
    {
        $this->load->model('almacen/fabricante_model');
        $this->load->model('almacen/linea_model');
        $this->load->model('almacen/marca_model');
        $accion = "";
        $modo = "insertar";
        $codigo = "";
        $data['modo'] = $modo;
        $data['flagBS'] = $flagBS;
        $data['cbo_tipoProducto'] = $this->seleccionar_tipos_producto($flagBS);
        $data['cbo_fabricante'] = form_dropdown('fabricante', $this->fabricante_model->seleccionar(), '', "id='fabricante' class='comboMedio'");
        $data['cbo_linea'] = form_dropdown('linea', $this->linea_model->seleccionar(), '', "id='linea' class='comboMedio'");
        $data['cbo_marca'] = form_dropdown('marca', $this->marca_model->seleccionar(), '', "id='marca' class='comboMedio'");
        $data['fila'] = $this->obtener_datosAtributos('1');
        $data['filaunidad'] = $this->obtener_datosUnidad();
        $data['url_action'] = base_url() . "index.php/almacen/producto/insertar_producto";
        $data['titulo'] = "REGISTRAR " . ($flagBS == 'B' ? 'ARTICULO' : 'SERVICIO');
        $data['unidad_medida'] = "";
        $data['proveedor'] = "";
        $data['familia'] = "";
        $data['nombre_producto'] = "";
        $data['nombrecorto_producto'] = "";
        $data['imagen'] = "";
        $data['especificacionPDF'] = "";
        $data['modelo'] = "";
        $data['presentacion'] = "";
        $data['geneindi'] = "";
        $data['nombre_familia'] = "";
        //$data['descripcion_breve'] = "";
        //$data['comentario']        = "";
        $data['stock'] = "";
        $data['ruc'] = "";
        $data['nombres'] = "";
        $data['flagActivo'] = "1";
        $data['checked'] = "checked='checked'";
        $data['display'] = "";
        $data['readonly'] = "";
        $data['lista_proveedores'] = array();
        $data['producto'] = $codigo;
        $data['codigo_familia'] = $this->input->post('codigo_familia');
        $data['padre'] = "";
        $data['codpadre'] = "";
        $data['nompadre'] = "";
        $data['codigo_usuario'] = "";
        $atributos = array('width' => 500, 'height' => 400, 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');
        $atributos_prov = array('width' => 600, 'height' => 400, 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');
        $atributos_prod = array('width' => 700, 'height' => 450, 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');
        $atributos_string = "width=500,height=400,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0";
        $contenido = "<img height='16' width='16' src='" . base_url() . "images/ver.png' title='' border='0'>";
        $data['ver'] = anchor_popup('almacen/familia/nueva_familia', $contenido, $atributos);
        $data['verproveedor'] = anchor_popup('compras/proveedor/ventana_busqueda_proveedor', $contenido, $atributos_prov);
        $data['verproducto'] = anchor_popup('almacen/producto/ventana_busqueda_producto', $contenido, $atributos_prod);
        $data['verfamilia_js'] = "ondblclick='window.open(\"" . base_url() . "index.php/almacen/familia/nueva_familia\",\"_blank\",\"" . $atributos_string . "\");'";
        $data['onload'] = "onload=\"$('#nombre_producto').select();$('#nombre').focus();\"";
        $data['oculto'] = form_hidden(array('accion' => $accion, 'codigo' => $codigo, 'modo' => $modo, 'base_url' => base_url(), 'url_image' => URL_IMAGE, 'flagBS' => $flagBS));
        $data['codigo_producto'] = "";
        $data['tabla_precios'] = "";
        $this->load->view('almacen/producto_ventana_nuevo', $data);
    }

    public function obtener_datosAtributos($tipo_producto, $producto = '', $modo = 'editar')
    {
        $datos_plantilla = $this->plantilla_model->obtener_plantilla($tipo_producto); //Tipo producto
        $fila = "<table class='fuente8' width='98%' cellspacing='0' cellpadding='6' border='0'>";
        $item = 1;
        if (count($datos_plantilla) > 0) {
            foreach ($datos_plantilla as $valor) {
                $atributo = $valor->ATRIB_Codigo;
                $datos_atributo = $this->atributo_model->obtener_atributo($atributo);
                $nombre_atributo = $datos_atributo[0]->ATRIB_Descripcion;
                $nombre_atributo_min = strtolower($nombre_atributo);
                $tipo_atributo = $datos_atributo[0]->ATRIB_TipoAtributo;

                $fechaTexto = '';
                if ($producto != '') {
                    $datos_prodAtributo = $this->producto_model->obtener_producto_atributos($producto, $atributo);
                    if (count($datos_prodAtributo) > 0) {
                        switch ($tipo_atributo) {
                            case 1:
                                $valor = $datos_prodAtributo[0]->PRODATRIB_Numerico;
                                $onkeypress = "onkeypress='return numbersonly(this,event);'";
                                break;
                            case 2:
                                $valor = $datos_prodAtributo[0]->PRODATRIB_Date;
                                $onkeypress = "onkeypress=''";
                                break;
                            case 3:
                                $valor = $datos_prodAtributo[0]->PRODATRIB_String;
                                $onkeypress = "onkeypress='return textoonly(this,event);'";
                                break;
                        }

                        $fechaTexto = ($atributo == 14 and FORMATO_IMPRESION == 4 and $datos_prodAtributo[0]->PRODATRIB_FechaModificacion != '') ? '<i>al ' . $datos_prodAtributo[0]->PRODATRIB_FechaModificacion . '</i>' : '';
                    } else {
                        switch ($tipo_atributo) {
                            case 1:
                                $valor = "";
                                $onkeypress = "onkeypress='return numbersonly(this,event);'";
                                break;
                            case 2:
                                $valor = "";
                                $onkeypress = "onkeypress=''";
                                break;
                            case 3:
                                $valor = "";
                                $onkeypress = "onkeypress='return textoonly(this,event);'";
                                break;
                        }
                    }
                } else {
                    switch ($tipo_atributo) {
                        case 1:
                            $valor = "";
                            $onkeypress = "onkeypress='return numbersonly(this,event);'";
                            break;
                        case 2:
                            $valor = "";
                            $onkeypress = "onkeypress=''";
                            break;
                        case 3:
                            $valor = "";
                            $onkeypress = "onkeypress='return textoonly(this,event);'";
                            break;
                    }
                }


                if (($item % 2) != 0) {
                    $fila .= "<tr>";
                }
                $fila .= "<td width='16%' align='left'>" . $nombre_atributo . "</td>";
                $fila .= "<td width='84%' align='left'>";
                $fila .= "<input type='hidden' name='atributo[" . $item . "]' id='atributo[" . $item . "]' class='cajaMedia' value='" . $atributo . "'>";
                $fila .= "<input type='hidden' name='tipo_atributo[" . $item . "]' id='tipo_atributo[" . $item . "]' class='cajaMedia' value='" . $tipo_atributo . "'>";
                if ($modo == "ver") {
                    $fila .= $valor;
                } elseif ($modo == 'editar') {
                    //$fila              .= "<input type='text' ".$onkeypress." name='nombre_atributo[".$item."]' id='nombre_atributo[".$item."]' maxlength='250' class='cajaMedia' value='".$valor."'>";                                      
                    $fila .= "<input type='text' name='nombre_atributo[" . $item . "]' id='nombre_atributo[" . $item . "]' maxlength='250' class='cajaMedia' value='" . $valor . "'> $fechaTexto";
                }
                $fila .= "</td>";
                if (($item % 2) == 0) {
                    $fila .= "</tr>";
                }
                $item++;
            }
        }
        $fila .= "</table>";
        return $fila;
    }


    public function obtener_datosUnidad($producto = '')
    {
        $lista_producto_unidad = $this->producto_model->listar_producto_unidades($producto);
        $fila = '<table width="98%" border="0" align="left" cellpadding="5" cellspacing="0" class="fuente8" id="tblUnidadMedida">';
        if ($producto != '' && is_array($lista_producto_unidad)) {
            foreach ($lista_producto_unidad as $i => $valor) {
                $produnidad = $valor->PRODUNIP_Codigo;
                $umedida = $valor->UNDMED_Codigo;
                $factor = $valor->PRODUNIC_Factor;
                $flagP = $valor->PRODUNIC_flagPrincipal;
                $cbo_undMedida = $this->seleccionar_unidad_medida($umedida);
                $fila .= '<tr>';
                if ($flagP == '1') {
                    $fila .= '<td width="16%">Unidad medida Principal (*)</td>';
                    $fila .= '<td width="19%">';
                    $fila .= '<input type="hidden" class="cajaMinima" name="produnidad[' . $i . ']" id="produnidad[' . $i . ']" value="' . $produnidad . '">';
                    $fila .= '<select name="unidad_medida[' . $i . ']" id="unidad_medida[' . $i . ']" class="comboMedio">' . $cbo_undMedida . '</select>&nbsp;</td>';
                    $fila .= '<td width="12%">';
                    $fila .= '<p><a href="javascript:;" onClick="agregar_unidad_producto();"><img height="16" width="16" src="' . base_url() . 'images/add.png" border="0" title="Agregar Unidad Medidad"></a></p>';
                    ///aumentado stv
//                    if($i==0){
//                    $fila .= 'Cant. Unidad Medida <input type="text" class="cajaPequena2" onkeypress="return numbersonly(this,event,\'.\');" maxlength="5" name="factorprin" id="factorprin" value="' . $factor . '">';
//                    }
                    /////////    
                    $fila .= '</td>';
                    $fila .= '<td width="52%"><input type="hidden" class="cajaPequena2" name="flagPrincipal[' . $i . ']" id="flagPrincipal[' . $i . ']" value="1"></td>';
                } else {
                    $fila .= '<td width="16%">Unidad medida Aux. ' . $i . '</td>';
                    $fila .= '<td width="19%">';
                    $fila .= '<input type="hidden" class="cajaMinima" name="produnidad[' . $i . ']" id="produnidad[' . $i . ']" value="' . $produnidad . '">';
                    $fila .= '<select name="unidad_medida[' . $i . ']" id="unidad_medida[' . $i . ']" class="comboMedio">' . $cbo_undMedida . '</select>&nbsp;</td>';
                    $fila .= '<td width="10%">F.C.<input type="text" class="cajaPequena2" onkeypress="return numbersonly(this,event,\'.\');" maxlength="5" name="factor[' . $i . ']" id="factor[' . $i . ']" value="' . $factor . '"></td>';
                    $fila .= '<td width="54%"><input type="hidden" class="cajaPequena2" name="flagPrincipal[' . $i . ']" id="flagPrincipal[' . $i . ']" value="' . $flagP . '"></td>';
                }
                $fila .= '</tr>';
            }
        } else {
            $i = 0;
            $umedida = 0;
            $factor = 1;
            $flagP = 1;
            $cbo_undMedida = $this->seleccionar_unidad_medida($umedida);
            $fila .= '<tr>';
            $fila .= '<td width="16%">Unidad medida Principal (*)</td>';
            $fila .= '<td width="19%">';
            $fila .= '<input type="hidden" class="cajaMinima" name="produnidad[' . $i . ']" id="produnidad[' . $i . ']" value="">';
            $fila .= '<select name="unidad_medida[' . $i . ']" id="unidad_medida[' . $i . ']" class="comboMedio">' . $cbo_undMedida . '</select>&nbsp;</td>';
            $fila .= '<td width="12%">';
            $fila .= '<p><a href="javascript:;" onClick="agregar_unidad_producto();"><img height="16" width="16" src="' . base_url() . 'images/add.png" border="0" title="Agregar Unidad Medidad"></a></p></td>';
            $fila .= '<td width="52%"><input type="hidden" class="cajaPequena2" name="flagPrincipal[' . $i . ']" id="flagPrincipal[' . $i . ']" value="1">';

            $fila .= '</td>';

            $fila .= '</tr>';
        }
        $fila .= '</table>';
        return $fila;
    }

    public function mostrar_atributos($tipo_producto)
    {
        $datos_atributos = $this->obtener_datosAtributos($tipo_producto);
        echo $datos_atributos;
    }

    /* Combos */

    public function seleccionar_tipos_producto($flagBS = 'B', $indDefault = '')
    {
        $array_tipoProd = $this->tipoproducto_model->listar_tipos_producto($flagBS);
        $arreglo = array();
        if (count($array_tipoProd) > 0) {
            foreach ($array_tipoProd as $indice => $valor) {
                $indice1 = $valor->TIPPROD_Codigo;
                $valor1 = $valor->TIPPROD_Descripcion;
                $arreglo[$indice1] = $valor1;
            }
        }
        $resultado = $this->html->optionHTML($arreglo, $indDefault, array('', '::Seleccione::'));
        return $resultado;
    }

    public function seleccionar_unidad_medida($indDefault = '')
    {
        if (intval($indDefault) == 0)
            $indDefault = 1;
        $array_undMedida = $this->unidadmedida_model->listar();
        $arreglo = array();
        if (count($array_undMedida) > 0) {
            foreach ($array_undMedida as $indice => $valor) {
                $indice1 = $valor->UNDMED_Codigo;
                $valor1 = $valor->UNDMED_Descripcion;
                $arreglo[$indice1] = $valor1;
            }
        }
        $resultado = $this->html->optionHTML($arreglo, $indDefault, array('', '::Seleccione::'));
        return $resultado;
    }

    public function seleccionar_familia($codanterior, $indDefault = '')
    {
        $array_familia = $this->familia_model->listar_familias($codanterior);
        $arreglo = array();
        if (count($array_familia) > 0) {
            foreach ($array_familia as $indice => $valor) {
                $indice1 = $valor->FAMI_Codigo;
                $valor1 = $valor->FAMI_Descripcion;
                $arreglo[$indice1] = $valor1;
            }
        }
        $resultado = $this->html->optionHTML($arreglo, $indDefault, array('', '::Seleccione::'));
        return $resultado;
    }

    public function listar_unidad_medida()
    {
        $listado_unidad_medida = $this->unidadmedida_model->listar();
        $resultado = json_encode($listado_unidad_medida);
        echo $resultado;
    }

    public function listar_unidad_medida_producto($producto)
    {
        $listado_unidad_medida_producto = $this->producto_model->listar_producto_unidades($producto);
        $datos_producto = $this->producto_model->obtener_producto($producto);
        $nombre_producto = $datos_producto[0]->PROD_Nombre;
        $nombrecorto_producto = $datos_producto[0]->PROD_NombreCorto;
        $marca = $datos_producto[0]->MARCP_Codigo;
        $PROD_CodigoUsuario = $datos_producto[0]->PROD_CodigoUsuario;
        $nombre_marca = '';
        if ($marca != '' && $marca != '0') {
            $datos_marca = $this->marca_model->obtener($marca);
            if (count($datos_marca) > 0)
                $nombre_marca = $datos_marca[0]->MARCC_Descripcion;
        }
        $modelo = $datos_producto[0]->PROD_Modelo;
        $presentacion = $datos_producto[0]->PROD_Presentacion;

        $listado_array = array();
        if (is_array($listado_unidad_medida_producto)) {
            foreach ($listado_unidad_medida_producto as $valor) {
                $unidad_medida = $valor->UNDMED_Codigo;
                $datos_unidad_medida = $this->unidadmedida_model->obtener($unidad_medida);
                $descripcion = $datos_unidad_medida[0]->UNDMED_Descripcion;
                $simbolo = $datos_unidad_medida[0]->UNDMED_Simbolo;
                $objeto = new stdClass();
                $objeto->UNDMED_Codigo = $unidad_medida;
                $objeto->UNDMED_Descripcion = $descripcion;
                $objeto->UNDMED_Simbolo = $simbolo;
                $objeto->PROD_Nombre = str_replace('"', "''", $nombre_producto);
                $objeto->PROD_NombreCorto = str_replace('"', "''", $nombrecorto_producto);
                $objeto->PROD_CodigoUsuario = $PROD_CodigoUsuario;
                if (FORMATO_IMPRESION == 4 || FORMATO_IMPRESION == 3)  //Esta comparación debe salir cuando, se pueda configurar que se enexará al nombre de los productos en los prepsupuestos y todos los documentos
                    $objeto->MARCC_Descripcion = '';
                else
                    $objeto->MARCC_Descripcion = $nombre_marca;
                if (FORMATO_IMPRESION == 3)
                    $objeto->PROD_Modelo = '';
                else
                    $objeto->PROD_Modelo = $modelo;
                $objeto->PROD_Presentacion = $presentacion;
                $listado_array[] = $objeto;
            }
        } else {
            $unidad_medida = '';
            $descripcion = '';
            $simbolo = '';
            $objeto = new stdClass();
            $objeto->UNDMED_Codigo = $unidad_medida;
            $objeto->UNDMED_Descripcion = $descripcion;
            $objeto->UNDMED_Simbolo = $simbolo;
            $objeto->PROD_Nombre = str_replace('"', "''", $nombre_producto);
            $objeto->PROD_NombreCorto = str_replace('"', "''", $nombrecorto_producto);

            if (FORMATO_IMPRESION == 4 || FORMATO_IMPRESION == 3)  //Esta comparación debe salir cuando, se pueda configurar que se enexará al nombre de los productos en los prepsupuestos y todos los documentos
                $objeto->MARCC_Descripcion = '';
            else
                $objeto->MARCC_Descripcion = $nombre_marca;
            if (FORMATO_IMPRESION == 3)
                $objeto->PROD_Modelo = '';
            else
                $objeto->PROD_Modelo = $modelo;
            $objeto->PROD_Presentacion = $presentacion;
            $listado_array[] = $objeto;
        }
        $resultado = json_encode($listado_array);
        echo $resultado;
    }

    public function listar_precios_x_producto_unidad($producto, $unidad, $moneda)
    {
        $producto_precio = $this->productoprecio_model->listar_precios_x_producto_unidad($producto, $unidad, $moneda);
        //print_r($producto_precio);
        //var_dump($producto_precio);
        $establecimiento = $this->session->userdata("establec");
        //var_dump($establecimiento);
        $resultado = "";
        $lista = array();
        if (is_array($producto_precio) && count($producto_precio > 0)) {
            $i = 1;
            foreach ($producto_precio as $value) {
                $filter = new stdClass();
                $filter->posicion_precio = $i;
                $filter->codigo = $value->PRODPREP_Codigo;
                $filter->moneda = $value->MONED_Simbolo;
                $filter->precio = $value->PRODPREC_Precio;
                $filter->establecimiento = "";
                if ($value->EESTABP_Codigo == $establecimiento) {
                    $filter->posicion = true;

                }
                $lista[] = $filter;
                $i++;
            }
        }
        //var_dump($lista);
        $resultado = json_encode($lista);
        echo $resultado;
    }

    public function listar_precio_for_compra($producto, $unidad, $moneda)
    {
        $this->load->model("compras/ocompra_model");
        $last_price = $this->ocompra_model->get_last_price_by_id_product($producto);
        $precio = 0;
        if (count($last_price) > 0) {
            $precio = $last_price[0]->OCOMDEC_Pu;
        }

        echo json_encode(array(
            "precio" => $precio
        ));
    }

    public function listar_lotes_producto($producto)
    {
        $lista_lotes = $this->lote_model->listar($producto);
        $lista = array();
        foreach ($lista_lotes as $indice => $value) {
            $resultado = new stdClass();

            $fecha = mysql_to_human(substr($value->GUIAINC_Fecha, 0, 10));
            $lista_guiarem = $this->guiarem_model->buscar_x_guiain($value->GUIAINP_Codigo);
            $almacen = count($lista_guiarem) > 0 ? $lista_guiarem[0]->ALMAC_Descripcion : '';
            $datos_proveedor = $this->proveedor_model->obtener($value->PROVP_Codigo);
            $ruc = $value->PROVP_Codigo != '' ? $datos_proveedor->ruc : '';
            $nombre = $value->PROVP_Codigo != '' ? $datos_proveedor->nombre : '';
            $cantidad = $value->LOTC_Cantidad;
            $moneda = count($lista_guiarem) > 0 ? $lista_guiarem[0]->MONED_Simbolo : '';
            $costo = $value->LOTC_Costo;


            $resultado->fecha = $fecha;
            $resultado->almacen = $almacen;
            $resultado->ruc = $ruc;
            $resultado->nombre = $nombre;
            $resultado->cantidad = $cantidad;
            $resultado->moneda = $moneda;
            $resultado->costo = $costo;
            $lista[] = $resultado;
        }
        $data['lista_lotes'] = $lista;
        $this->load->view('almacen/producto_lotes', $data);
    }

    public function listar_ocompras_x_producto($producto)
    {
        $this->load->model("compras/ocompra_model");
        $this->load->model("maestros/formapago_model");
        $lista_ocompras = $this->ocompra_model->listar_ocompras_x_producto($producto);
        $lista = array();
        if (count($lista_ocompras) > 0) {
            foreach ($lista_ocompras as $indice => $value) {
                $resultado = new stdClass();
                $proveedor = $value->PROVP_Codigo;
                $formapago = $value->FORPAP_Codigo;
                $datos_proveedor = $this->proveedor_model->obtener($proveedor);
                $datos_formapago = $this->formapago_model->obtener($formapago);
                $descripcion = "NO TIENE";
                if (count($datos_formapago) > 0) {
                    $descripcion = $datos_formapago[0]->FORPAC_Descripcion;
                }
                $nombre_proveedor = $datos_proveedor->nombre;
                $nombre_formapago = $descripcion;
                $fecha = $value->OCOMC_FechaRegistro;
                $arrfecha = explode(" ", $fecha);
                $resultado->fecha = $arrfecha[0];
                $resultado->numero = $value->OCOMC_Numero;
                $resultado->nombre_proveedor = $nombre_proveedor;
                $resultado->cantidad = $value->OCOMDEC_Cantidad;
                $resultado->precio = $value->OCOMDEC_Pu;
                $resultado->igv = $value->OCOMDEC_Igv;
                $resultado->importe = $value->OCOMDEC_Total;
                $resultado->nombre_formapago = $nombre_formapago;
                $lista[] = $resultado;
            }
        }
        $data['lista_ocompras'] = $lista;
        $this->load->view('almacen/producto_ocompra', $data);
    }

    public function obtener_producto_unidad($producto)
    {
        $datos_producto = $this->producto_model->obtener_producto($producto);
        $nombre_producto = $datos_producto[0]->PROD_Nombre;
        $listado_unidad_medida_producto = $this->producto_model->listar_producto_unidades($producto);
        $listado_array = array();
        foreach ($listado_unidad_medida_producto as $valor) {
            $unidad_medida = $valor->UNDMED_Codigo;
            $datos_unidad_medida = $this->unidadmedida_model->obtener($unidad_medida);
            $descripcion = $datos_unidad_medida[0]->UNDMED_Descripcion;
            $simbolo = $datos_unidad_medida[0]->UNDMED_Simbolo;
            $objeto = new stdClass();
            $objeto->UNDMED_Codigo = $unidad_medida;
            $objeto->UNDMED_Descripcion = $descripcion;
            $objeto->UNDMED_Simbolo = $simbolo;
            $listado_array[] = $objeto;
        }
        $resultado = array(
            'nombre_producto' => $nombre_producto,
            'listado_unidades' => $listado_array
        );
        echo json_encode($resultado);
    }

    public function obtener_tabla_precios($producto = '')
    {
        //listas de los tipos de moneda registrados soles o dolares
        $lista_monedas = $this->moneda_model->listar();
        //fin listas de los tipos de moneda registrados soles o dolares

        //unidades de medida que posee el producto
        $lista_producto_unidad = $this->producto_model->listar_producto_unidades($producto);
        //$this->firephp->fb($lista_producto_unidad,"producto unidad");
        //fin unidades de medida que posee el producto

        $comp_confi = $this->companiaconfiguracion_model->obtener($this->somevar['compania']);

        //datos de la compania
        $temp = $this->compania_model->obtener_compania($this->somevar['compania']);
        //fin datos de la compania

        $empresa = $temp[0]->EMPRP_Codigo;

        $determinaprecio = '0';

        /*determina como se menejaran los prcios de la empresa */
        if (count($comp_confi) > 0)
            $determinaprecio = $comp_confi[0]->COMPCONFIC_DeterminaPrecio;
        /* fin determina como se menejaran los prcios de la empresa */

        /*Cabecera de la tabla*/
        $tabla = '
            <div style="text-align:left; padding-left:10px; font-weight: bold">
                LOS PRECIOS ' . 1 . ' DEBEN TENER INCLUIDO EL I.G.V.
            </div>
                <table id="tblPrecios" width="98%" class="fuente8" width="98%" cellspacing="0" cellpadding="3" border="1">
                    <tr align="center" bgcolor="#BBBB20" height="10px;">
                        <td width="20" rowspan="2">Nro</td>
                        <td width="250" rowspan="2">Categoría de Cliente</td>                  
                        <td rowspan="2">Tienda</td>
                        <td width="120" rowspan="2">Unidad de Medida</td>
                        <td width="' . (75 * count($lista_monedas)) . '" colspan="' . count($lista_monedas) . '">Precios</td>
                        <td width="40" rowspan="2">Limpiar</td>
                    </tr>
                    <tr align="center" bgcolor="#BBBB20" height="10px;">';
        foreach ($lista_monedas as $reg)
            $tabla .= '<td width="75">' . $reg->MONED_Descripcion . ' (' . $reg->MONED_Simbolo . ')</td>';
        $tabla .= '</tr>';
        /* fin Cabecera de la tabla*/

        $sec = 0;
        switch ($determinaprecio) {
            case '0':
                $tabla .= '<tr bgcolor="#ffffff">';
                $tabla .= '<td align="center">1</td>';
                $tabla .= '<td>&nbsp;</td>';
                $tabla .= '<td>&nbsp;</td>';
                $tabla .= '<td>' . $this->obtener_tabla_equivalencias($producto) . '</td>';
                foreach ($lista_monedas as $reg_m) {
                    $tabla .= '<td align="center" valign="top">';
                    if (is_array($lista_producto_unidad)) {
                        foreach ($lista_producto_unidad as $reg_pu) {
                            $precio = '';
                            /*Esto es para mostrar el precio si es que el articulo tiene precio en este registro*/
                            if ($producto != '') {
                                $filter = new stdClass();
                                $filter->PROD_Codigo = $producto;
                                $filter->MONED_Codigo = $reg_m->MONED_Codigo;
                                $filter->PRODUNIP_Codigo = $reg_pu->PRODUNIP_Codigo;
                                $filter->TIPCLIP_Codigo = 0;
                                $filter->EESTABP_Codigo = 0;
                                $temp = $this->productoprecio_model->buscar($filter);
                                if (count($temp) > 0)
                                    $precio = number_format($temp[0]->PRODPREC_Precio, 2);
                            }
                            /*fin Esto es para mostrar el precio si es que el articulo tiene precio en este registro*/
                            /*Obtener el campo de texto parar ingresar el precio*/
                            $tabla .= '<input type="text" value="' . $precio . '"
                                                    name="precio_' . $reg_m->MONED_Codigo . '_' . $reg_pu->PRODUNIP_Codigo . '" 
                                                    id="precio_' . $reg_m->MONED_Codigo . '_' . $reg_pu->PRODUNIP_Codigo . '" 
                                                    class="cajaPequena"  />';
                            /* fin Obtener el campo de texto parar ingresar el precio*/
                        }
                    }
                    $tabla . '</td>';
                }
                $tabla .= '<td align="center"><a href="javascript:;" class="limpiarPrecios"><img src="' . base_url() . 'images/icono_limpiar.png" width="24px" border="0"></a></td>';
                $tabla .= '</tr>';
                break;
            case '1'://depende del tipo de cliente
                $lista_tipoclientes = $this->tipocliente_model->listar();
                if (count($lista_tipoclientes) > 0) {
                    foreach ($lista_tipoclientes as $reg_tc) {
                        $sec++;
                        $tabla .= '<tr bgcolor="#ffffff">';
                        $tabla .= '<td align="center">' . $sec . '</td>';
                        $tabla .= '<td>' . $reg_tc->TIPCLIC_Descripcion . '</td>';//imprime tipo de cliente
                        $tabla .= '<td>&nbsp;</td>';
                        $tabla .= '<td>' . $this->obtener_tabla_equivalencias($producto) . '</td>';
                        foreach ($lista_monedas as $reg_m) {
                            $tabla .= '<td align="center" valign="top">';

                            if (is_array($lista_producto_unidad)) {
                                foreach ($lista_producto_unidad as $reg_pu) {
                                    $precio = '';
                                    if ($producto != '') {
                                        $filter = new stdClass();
                                        $filter->PROD_Codigo = $producto;
                                        $filter->MONED_Codigo = $reg_m->MONED_Codigo;
                                        $filter->PRODUNIP_Codigo = $reg_pu->PRODUNIP_Codigo;
                                        $filter->TIPCLIP_Codigo = $reg_tc->TIPCLIP_Codigo;
                                        $filter->EESTABP_Codigo = $this->somevar['establec'];
                                        $temp = $this->productoprecio_model->buscar($filter);
                                        if (count($temp) > 0)
                                            $precio = number_format($temp[0]->PRODPREC_Precio, 2);
                                    }
                                    $tabla .= '<input type="text" value="' . $precio . '"
                                                            name="precio_' . $reg_m->MONED_Codigo . '_' . $reg_pu->PRODUNIP_Codigo . '_' . $reg_tc->TIPCLIP_Codigo . '" 
                                                            id="precio_' . $reg_m->MONED_Codigo . '_' . $reg_pu->PRODUNIP_Codigo . '_' . $reg_tc->TIPCLIP_Codigo . '" 
                                                            class="cajaPequena" />';
                                }
                            }
                            $tabla . '</td>';
                        }
                        $tabla .= '<td align="center"><a href="javascript:;" class=""><img src="' . base_url() . 'images/icono_limpiar.png" width="24px" border="0"></a></td>';

                        $tabla .= '</tr>';
                    }
                }
                break;
            case '2':
                $lista_establecimientos = $this->emprestablecimiento_model->listar($empresa);
                if (count($lista_establecimientos) > 0) {
                    foreach ($lista_establecimientos as $reg_es) {
                        $sec++;
                        $tabla .= '<tr bgcolor="#ffffff">';
                        $tabla .= '  <td align="center">' . $sec . '</td>';
                        $tabla .= '  <td>&nbsp;</td>';
                        $tabla .= '  <td>' . $reg_es->EESTABC_Descripcion . '</td>';
                        $tabla .= '<td>' . $this->obtener_tabla_equivalencias($producto) . '</td>';
                        foreach ($lista_monedas as $reg_m) {
                            $tabla .= '<td align="center" valign="top">';
                            if (is_array($lista_producto_unidad)) {
                                foreach ($lista_producto_unidad as $reg_pu) {
                                    $precio = '';
                                    if ($producto != '') {
                                        $filter = new stdClass();
                                        $filter->PROD_Codigo = $producto;
                                        $filter->MONED_Codigo = $reg_m->MONED_Codigo;
                                        $filter->PRODUNIP_Codigo = $reg_pu->PRODUNIP_Codigo;
                                        $filter->TIPCLIP_Codigo = 0;
                                        $filter->EESTABP_Codigo = $reg_es->EESTABP_Codigo;
                                        $temp = $this->productoprecio_model->buscar($filter);
                                        if (count($temp) > 0)
                                            $precio = number_format($temp[0]->PRODPREC_Precio, 2);
                                    }
                                    $tabla .= '
                                <input type="text" value="' . $precio . '" 
                                name="precio_' . $reg_m->MONED_Codigo . '_' . $reg_pu->PRODUNIP_Codigo . '_' . $reg_es->EESTABP_Codigo . '" 
                                id="precio_' . $reg_m->MONED_Codigo . '_' . $reg_pu->PRODUNIP_Codigo . '_' . $reg_es->EESTABP_Codigo . '" 
                                class="cajaPequena" />';
                                }
                            }
                            $tabla . '</td>';
                        }
                        $tabla .= '<td align="center"><a href="javascript:;" class="limpiarPrecios"><img src="' . base_url() . 'images/icono_limpiar.png" width="24px" border="0"></a></td>';
                        $tabla .= '</tr>';
                    }
                }
                break;
            case '3':
                $lista_tipoclientes = $this->tipocliente_model->listar();
                $lista_establecimientos = $this->emprestablecimiento_model->listar($empresa);
                foreach ($lista_tipoclientes as $reg_tc) {
                    $tabla .= '<tr>';
                    $tabla .= '<td align="center">&nbsp;</td>';
                    $tabla .= '<td>' . $reg_tc->TIPCLIC_Descripcion . '</td>';
                    $tabla .= '<td>&nbsp;</td>';
                    $tabla .= '<td>&nbsp;</td>';
                    foreach ($lista_monedas as $reg_m)
                        $tabla .= '<td>&nbsp;</td>';
                    $tabla .= '<td>&nbsp;</td>';
                    $tabla .= '</tr>';
                    if (count($lista_establecimientos) > 0) {
                        foreach ($lista_establecimientos as $reg_es) {
                            $sec++;
                            $tabla .= '<tr bgcolor="#ffffff">';
                            $tabla .= '<td align="center">' . $sec . '</td>';
                            $tabla .= '<td>&nbsp;</td>';
                            $tabla .= '<td>' . $reg_es->EESTABC_Descripcion . '</td>';
                            $tabla .= '<td>' . $this->obtener_tabla_equivalencias($producto) . '</td>';
                            foreach ($lista_monedas as $reg_m) {
                                $tabla .= '<td align="center" valign="top">';
                                if (is_array($lista_producto_unidad)) {
                                    foreach ($lista_producto_unidad as $reg_pu) {
                                        $precio = '';
                                        if ($producto != '') {
                                            $filter = new stdClass();
                                            $filter->PROD_Codigo = $producto;
                                            $filter->MONED_Codigo = $reg_m->MONED_Codigo;
                                            $filter->PRODUNIP_Codigo = $reg_pu->PRODUNIP_Codigo;
                                            $filter->TIPCLIP_Codigo = $reg_tc->TIPCLIP_Codigo;
                                            $filter->EESTABP_Codigo = $reg_es->EESTABP_Codigo;
                                            $temp = $this->productoprecio_model->buscar($filter);
                                            if (count($temp) > 0)
                                                $precio = number_format($temp[0]->PRODPREC_Precio, 2);
                                        }
                                        $tabla .= '<input type="text" value="' . $precio . '" name="precio_' . $reg_m->MONED_Codigo . '_' . $reg_pu->PRODUNIP_Codigo . '_' . $reg_tc->TIPCLIP_Codigo . '_' . $reg_es->EESTABP_Codigo . '" id="precio_' . $reg_m->MONED_Codigo . '_' . $reg_pu->PRODUNIP_Codigo . '_' . $reg_tc->TIPCLIP_Codigo . '_' . $reg_es->EESTABP_Codigo . '" class="cajaPequena" />';
                                    }
                                }
                                $tabla . '</td>';
                            }
                            $tabla .= '<td align="center"><a href="javascript:;" class="limpiarPrecios"><img src="' . base_url() . 'images/icono_limpiar.png" width="24px" border="0"></a></td>';
                            $tabla .= '</tr>';
                        }
                    }
                }
                break;
        }

        $tabla .= '</table>';

        return $tabla;
    }

    public function obtener_tabla_equivalencias($producto)
    {
        $lista_producto_unidad = $this->producto_model->listar_producto_unidades($producto);

        $tabla = '<table border="0" cellpadding="0" cellspacing="0">';
        if (is_array($lista_producto_unidad)) {
            foreach ($lista_producto_unidad as $reg) {
                $datos_unidad_medida = $this->unidadmedida_model->obtener($reg->UNDMED_Codigo);
                $descripcion = $datos_unidad_medida[0]->UNDMED_Descripcion;
                $simbolo = $datos_unidad_medida[0]->UNDMED_Simbolo;
                $tabla .= '<tr>';
                if ($reg->PRODUNIC_flagPrincipal == '1')
                    $tabla .= '<td height="25"><b>' . $descripcion . ' (' . $simbolo . ')</b></td>';
                else
                    $tabla .= '<td height="25">' . $descripcion . ' (' . $simbolo . ')</td>';
                $tabla .= '</tr>';
            }
        }
        $tabla .= '</table>';
        return $tabla;
    }

    public function productos_precios($j = '0')
    {


        $flagBS = 'B';
        $codigo = count($_POST) > 0 ? $this->input->post('txtCodigo') : '';
        $nombre = count($_POST) > 0 ? $this->input->post('txtNombre') : '';
        $familia = count($_POST) > 0 ? $this->input->post('txtFamilia') : '';
        $marca = count($_POST) > 0 ? $this->input->post('txtMarca') : '';
        $fechaIni = count($_POST) > 0 ? $this->input->post('txtFechaIni') : '';
        $cantMin = count($_POST) > 0 ? $this->input->post('txtCantMin') : '';

        $filter = new stdClass();
        $filter->flagBS = $flagBS;
        $filter->codigo = $codigo;
        $filter->nombre = $nombre;
        $filter->familia = $familia;
        $filter->marca = $marca;

        $data['codigo'] = $codigo;
        $data['nombre'] = $nombre;
        $data['familia'] = $familia;
        $data['marca'] = $marca;
        $data['fechaIni'] = $fechaIni;
        $data['cantMin'] = $cantMin;

        $listado_productos = array();
        if (count($_POST) > 0) {
            if ($fechaIni == '' && $cantMin == '')
                $listado_productos = $this->producto_model->buscar_productos($filter);
            else
                $listado_productos = $this->lote_model->listar_lotes_recientes_ultimos(human_to_mysql($fechaIni), $cantMin);
            $data['registros'] = count($listado_productos);
        }

        $lista = array();
        $lista_tipoclientes = $this->tipocliente_model->listar();
        $item = 1;
        if (count($listado_productos) > 0) {
            foreach ($listado_productos as $indice => $producto) {
                $codigo = $producto->PROD_Codigo;
                $codigo_interno_c = (($filter->codigo != '') ? '<span class="texto_busq">' . $producto->PROD_CodigoInterno . '</span>' : $producto->PROD_CodigoInterno);
                $descripcion_c = (($filter->nombre != '') ? str_replace(strtoupper($filter->nombre), '<span class="texto_busq">' . strtoupper($filter->nombre) . '</span>', $producto->PROD_Nombre) : $producto->PROD_Nombre);

                $stock = $this->producto_model->obtener_stock($producto->PROD_Codigo);
                $ultimo_costo = $producto->PROD_UltimoCosto;
                $lista_lote = $this->lote_model->listar_lotes_recientes($producto->PROD_Codigo, 30, 5);
                if ($stock == 0 || count($lista_lote) == 0)
                    continue;

                $lista_precio = array();
                $lista_poscganacia = array();
                if (count($lista_tipoclientes) > 0) {
                    foreach ($lista_tipoclientes as $key => $tipocliente) {
                        $lista_producto_unidad = $this->producto_model->listar_producto_unidades($codigo, 7);
                        $filter->PROD_Codigo = $codigo;
                        $filter->MONED_Codigo = 2;
                        //$filter->PRODUNIP_Codigo = $lista_producto_unidad[0]->PRODUNIP_Codigo;
                        $filter->TIPCLIP_Codigo = $tipocliente->TIPCLIP_Codigo;
                        $filter->EESTABP_Codigo = 0;
                        $temp = $this->productoprecio_model->buscar($filter);
                        $lista_poscganacia[$key] = count($temp) > 0 ? $temp[0]->PRODPREC_PorcGanancia : '';
                        $lista_precio[$key] = count($temp) > 0 ? $temp[0]->PRODPREC_Precio : '';
                    }
                }

                $lista[] = array($item++, $codigo_interno_c, $descripcion_c, $stock, $ultimo_costo, $lista_poscganacia, $lista_precio, $codigo);
            }
        }

        $data['action'] = base_url() . "index.php/almacen/producto/productos_precios";
        $data['titulo_tabla'] = "RESULTADO DE BÚSQUEDA DE ARTICULOS";
        $data['titulo_busqueda'] = "BUSCAR ARTICULOS";
        $data['lista'] = $lista;
        $data['lista_tipoclientes'] = $lista_tipoclientes;
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->layout->view('almacen/productoprecio_index', $data);
    }

    public function productos_precios_grabar()
    {
        $productos = $this->input->post('producto');
        $lista_tipoclientes = $this->tipocliente_model->listar();
        foreach ($productos as $indice => $producto) {
            foreach ($lista_tipoclientes as $key => $tipocliente) {
                $lista_producto_unidad = $this->producto_model->listar_producto_unidades($producto, 7);
                $precio = str_replace(',', '', $this->input->post('PREC_' . $producto . '_' . $key));
                $porc = $this->input->post('PORC_' . $producto . '_' . $key);
                $filter = new stdClass();
                $filter->PROD_Codigo = $producto;
                $filter->MONED_Codigo = 2;
                $filter->PRODUNIP_Codigo = $lista_producto_unidad[0]->PRODUNIP_Codigo;
                $filter->TIPCLIP_Codigo = $tipocliente->TIPCLIP_Codigo;
                $filter->EESTABP_Codigo = 0;
                $temp = $this->productoprecio_model->buscar($filter);
                $filter->PRODPREC_Precio = $precio;
                $filter->PRODPREC_PorcGanancia = $porc != '' ? $porc : NULL;
                if (count($temp) > 0) {
                    if ($precio != '') {
                        $filter->PRODPREC_FechaModificacion = date('Y-m-d H:i:s');
                        $this->productoprecio_model->modificar($temp[0]->PRODPREP_Codigo, $filter);
                    } else {
                        $this->productoprecio_model->eliminar($temp[0]->PRODPREP_Codigo);
                    }
                } elseif ($precio != '') {

                    $this->productoprecio_model->insertar($filter);
                }
            }
        }

        exit('{"result":"ok"}');
    }

    public function JSON_precio_producto($producto, $moneda, $cliente, $unidad, $igv = '')
    {
        $tipo_cliente = '0';
        if ($cliente != '0') {
            $cliente = $this->cliente_model->obtener_datosCliente($cliente);
            if ($cliente)
                $tipo_cliente = $cliente[0]->TIPCLIP_Codigo;
            else
                $tipo_cliente = "";
        }

        $usuario = $this->usuario_model->obtener($this->somevar['user']);
        if ($usuario)
            $establec_usua = "";
        else
            $establec_usua = "";
        $comp_confi = $this->companiaconfiguracion_model->obtener($this->somevar['compania']);
        $determinaprecio = '0';
        if (count($comp_confi) > 0)
            $determinaprecio = $comp_confi[0]->COMPCONFIC_DeterminaPrecio;

        $filter = new stdClass();
        $filter->UNDMED_Codigo = $unidad;
        $filter->PROD_Codigo = $producto;
        $productounidad = $this->productounidad_model->buscar($filter);

        if (count($productounidad) > 0) {
            $filter = new stdClass();
            $filter->PROD_Codigo = $producto;
            $filter->MONED_Codigo = $moneda;
            $filter->PRODUNIP_Codigo = $productounidad[0]->PRODUNIP_Codigo;
            switch ($determinaprecio) {
                case '0':
                    $filter->TIPCLIP_Codigo = 0;
                    $filter->EESTABP_Codigo = 0;
                    break;
                case '1':
                    $filter->TIPCLIP_Codigo = $tipo_cliente;
                    $filter->EESTABP_Codigo = 0;
                    break;
                case '2':
                    $filter->TIPCLIP_Codigo = 0;
                    $filter->EESTABP_Codigo = $establec_usua;
                    break;
                case '3':
                    $filter->TIPCLIP_Codigo = $tipo_cliente;
                    $filter->EESTABP_Codigo = $establec_usua;
                    break;
            }
            $productoprecio = $this->productoprecio_model->buscar($filter);


            if (count($productoprecio) == 0) {
                $precio = '';
                $lista_monedas = $this->moneda_model->listar();
                foreach ($lista_monedas as $valor) { //Sólo comvierte bién de soles a dolares y viceversa, hay que mojorarlo
                    if ($valor->MONED_Codigo == $moneda)
                        continue;
                    $filter2 = new stdClass();
                    $filter2->TIPCAMC_Fecha = date('Y-m-d', time());
                    $filter2->TIPCAMC_MonedaDestino = ($valor->MONED_Codigo != 1 ? $valor->MONED_Codigo : $moneda);  //Para averiguar el factor de conversión del día se tiene que establecer la moneda a convertir pero diferente a la del nuevo sol
                    $temp = $this->tipocambio_model->buscar($filter2);
                    if (count($temp) > 0)
                        $fact_conv = $temp[0]->TIPCAMC_FactorConversion;
                    else
                        continue;
                    $filter->MONED_Codigo = $valor->MONED_Codigo;
                    $productoprecio2 = $this->productoprecio_model->buscar($filter);
                    if (count($productoprecio2) > 0) {
                        $precio = $productoprecio2[0]->PRODPREC_Precio;
                        break;
                    }
                }
                if ($precio != '') {
                    $precio = ($valor->MONED_Codigo != 1 ? $precio * $fact_conv : $precio / $fact_conv);
                    if ($igv != '' && $igv != '0') {
                        $precio_igv = $precio * $igv / 100;
                        $precio += $precio_igv;
                    }
                    $productoprecio[0]->PRODPREC_Precio = round($precio, 2);
                }
            } else {
                $precio = $productoprecio[0]->PRODPREC_Precio;
                if ($igv != '' && $igv != '0') {
                    $precio_igv = $precio * $igv / 100;
                    $precio += $precio_igv;
                }
                $productoprecio[0]->PRODPREC_Precio = round($precio, 2);
            }
        }

        echo json_encode($productoprecio);
    }

    public function JSON_movimientos_serie($serie)
    {
        $lusta_mov = $this->seriemov_model->listar($serie);
        $lista = array();
        foreach ($lusta_mov as $indice => $mov) {
            $nombre = '';
            $numdoc = '';
            if ($mov->SERMOVP_TipoMov == '1') {
                $lista_guiarem = $this->guiarem_model->buscar_x_guiain($mov->GUIAINP_Codigo);
                $lista_guiatrans = count($lista_guiarem) == 0 ? $this->guiatrans_model->buscar_x_guiain($mov->GUIAINP_Codigo) : array();
                $fecha = mysql_to_human(count($lista_guiarem) > 0 ? $lista_guiarem[0]->GUIAREMC_Fecha : $lista_guiatrans[0]->GTRANC_Fecha);
                $tipo = 'INGRESO';
                $motivo = count($lista_guiarem) > 0 ? 'COMPRA' : 'INGRESO POR TRANS.';
                if (count($lista_guiarem) > 0) {
                    $datos_proveedor = $this->proveedor_model->obtener($lista_guiarem[0]->PROVP_Codigo);
                    if ($datos_proveedor) {
                        $nombre = $datos_proveedor->nombre;
                        $numdoc = $datos_proveedor->ruc;
                    }
                }
            } else {
                $lista_guiarem = $this->guiarem_model->buscar_x_guiasa($mov->GUIASAP_Codigo);
                $lista_guiatrans = count($lista_guiarem) == 0 ? $this->guiatrans_model->buscar_x_guiasa($mov->GUIASAP_Codigo) : array();
                $fecha = mysql_to_human(count($lista_guiarem) > 0 ? $lista_guiarem[0]->GUIAREMC_Fecha : $lista_guiatrans[0]->GTRANC_Fecha);
                $tipo = 'SALIDA';
                $motivo = count($lista_guiarem) > 0 ? 'VENTA' : 'SALIDA POR TRANS.';
                if (count($lista_guiarem) > 0) {
                    $datos_cliente = $this->cliente_model->obtener($lista_guiarem[0]->CLIP_Codigo);
                    if ($datos_cliente) {
                        $nombre = $datos_cliente->nombre;
                        $numdoc = $datos_cliente->ruc;
                    }
                }
            }

            $lista[] = array('item' => $indice + 1, 'fecha' => $fecha, 'tipo' => $tipo, 'motivo' => $motivo, 'nombre' => $nombre, 'numdoc' => $numdoc);
        }
        echo json_encode($lista);
    }

    public function prorratear_producto($producto)
    {

        $proveedor = $this->input->post('proveedor');
        $ruc_proveedor = $this->input->post('ruc_proveedor');
        $nombre_proveedor = $this->input->post('nombre_proveedor');
        $fechaIni = $this->input->post('fechaIni') != '' ? $this->input->post('fechaIni') : '01/' . date('m/Y');
        $fechaFin = $this->input->post('fechaFin') != '' ? $this->input->post('fechaFin') : date('d/m/Y');
        $datos_producto = $this->producto_model->obtener_producto($producto);


        $lista_lotes = $this->lote_model->buscar($producto, $proveedor, human_to_mysql($fechaIni), human_to_mysql($fechaFin));

        $lista = array();
        foreach ($lista_lotes as $indice => $value) {
            $resultado = new stdClass();

            $fecha = mysql_to_human(substr($value->GUIAINC_Fecha, 0, 10));
            $lista_guiarem = $this->guiarem_model->buscar_x_guiain($value->GUIAINP_Codigo);
            $datos_proveedor = $this->proveedor_model->obtener($value->PROVP_Codigo);
            $ruc = $value->PROVP_Codigo != '' ? $datos_proveedor->ruc : '';
            $nombre = $value->PROVP_Codigo != '' ? $datos_proveedor->nombre : '';
            $cantidad = $value->LOTC_Cantidad;
            $moneda = count($lista_guiarem) > 0 ? $lista_guiarem[0]->MONED_Simbolo : '';
            $costo = $moneda . ' ' . number_format($value->LOTC_Costo, 2);

            $lista_lotesprorrateo = $this->loteprorrateo_model->listar($value->LOTP_Codigo);

            $fecha_pro = count($lista_lotesprorrateo) > 0 ? mysql_to_human($lista_lotesprorrateo[0]->LOTPROC_Fecha) : '';
            $tipo_pro = count($lista_lotesprorrateo) > 0 ? $lista_lotesprorrateo[0]->LOTPROC_TipoDesc . ($lista_lotesprorrateo[0]->LOTPROC_FlagRecepProdu == '0' ? ' <label class="etiqueta_error">(MERC. NO RECEP)</label>' : '') : '';
            $cantidad_adi = count($lista_lotesprorrateo) > 0 ? $lista_lotesprorrateo[0]->LOTPROC_CantidadAdi : '';
            $valor_pro = count($lista_lotesprorrateo) > 0 ? $lista_lotesprorrateo[0]->LOTPROC_Valor : '';
            $nuevopc_pro = count($lista_lotesprorrateo) > 0 ? $moneda . ' ' . number_format($lista_lotesprorrateo[0]->LOTPROC_CostoNuevo, 2) : '';
            $prorratear = "<a href='javascript:;' onclick='prorratear_producto(" . $value->LOTP_Codigo . ")'><img src='" . base_url() . "images/dolar.png' width='16' height='16' border='0' title='Prorratear'></a>";
            // $prorratear     = "<a href='javascript:;' onclick='prorratear_producto(".$codigo.")'><img src='".base_url()."images/dolar.png' width='16' height='16' border='0' title='Prorratear'></a>";

            $lista[] = array($fecha, $ruc, $nombre, $cantidad, $costo, $fecha_pro, $tipo_pro, $cantidad_adi, $valor_pro, $nuevopc_pro, $prorratear);
        }
        $data['registros'] = count($lista);
        $data['action'] = base_url() . "index.php/almacen/producto/prorratear_producto/" . $producto;
        $data['titulo_tabla'] = "RELACI&Oacute;N de COMPRAS";
        $data['titulo_busqueda'] = "BUSCAR COMPRAS DE " . $datos_producto[0]->PROD_Nombre;
        $data['proveedor'] = $proveedor;
        $data['ruc_proveedor'] = $ruc_proveedor;
        $data['nombre_proveedor'] = $nombre_proveedor;
        $data['fechaIni'] = $fechaIni;
        $data['fechaFin'] = $fechaFin;
        $data['lista'] = $lista;
        $data['oculto'] = form_hidden(array('base_url' => base_url(), 'producto' => $producto));

        $this->layout->view('almacen/productoprorrateo_index', $data);
    }

    public function autocompletado_producto_x_nombre()
    {
        $keyword = $this->input->post('term');
        $flag = $this->input->post('flag');
        $compania = $this->input->post('compania');
        $almacen = $this->input->post('almacen');
        $cargarProductos = $this->producto_model->cargarProductos_autocompletado($keyword, $flag, $compania, $almacen);
        $result = array();
        if ($cargarProductos != NULL) {
            foreach ($cargarProductos as $productos => $value) {
                $codProUsuario = $value->PROD_CodigoUsuario;
                $nombPro = $value->PROD_Nombre;
                $codPro = $value->PROD_Codigo;
                $stock = $value->ALMPROD_Stock;
                $costoPro = $value->ALMPROD_CostoPromedio;
                $result[] = array("value" => $codProUsuario . "  - " . $nombPro, "codigo" => $codPro, "codinterno" => $codProUsuario, "pcosto" => $costoPro, "stock" => $stock, "flagGenInd" => $value->PROD_GenericoIndividual);
            }
        }
        echo json_encode($result);
    }

    public function autocompletado_producto_x_codigo()
    {
        $keyword = $this->input->post('term');
        $f = $this->input->post('flag');
        $com = $this->input->post('compania');
        $query = $this->producto_model->buscar_x_codigo($keyword, $f, $com);
        $result = array();
        if ($query != NULL) {

            foreach ($query as $producto => $value) {
                $result[] = array("value" => $value->PROD_CodigoUsuario . "  - " . $value->PROD_Nombre, "codigo" => $value->PROD_Codigo, "codinterno" => $value->PROD_CodigoUsuario);
            }

        }

        echo json_encode($result);

    }


    public function autocomplete($f, $com, $almacen)
    {
        $keyword = $this->input->post('term');
        $result = array();
        if ($keyword != null && count(trim($keyword)) > 0) {
            $compania = $this->somevar['compania'];
            $datosProducto = $this->producto_model->buscar_por_nombre($keyword, $f, $com);
            if ($datosProducto != null && count($datosProducto) > 0) {
                foreach ($datosProducto as $indice => $valor) {
                    $cod_prod = $valor->PROD_Codigo;
                    $stock = 0;
                    $almacen_id = null;
                    $datosAlmacenProducto = $this->almacenproducto_model->obtener($almacen_id, $cod_prod);
                    $CodigoAlmacenProducto = 0;
                    $pcosto = 0;
                    if ($datosAlmacenProducto != null && count($datosAlmacenProducto) > 0) {
                        foreach ($datosAlmacenProducto as $key => $valorReal) {
                            $CodigoAlmacenProducto = $valorReal->ALMAC_Codigo;
                            if (
                                $almacen != null && $almacen != 0
                                && trim($almacen) != ""
                            ) {
                                if ($CodigoAlmacenProducto == $almacen) {
                                    $stock = $valorReal->ALMPROD_Stock;
                                    $result[] = array("value" => $valor->PROD_CodigoUsuario . "  - " . $valor->PROD_Nombre . "  " . $stock, "codigo" => $valor->PROD_Codigo, "codinterno" => $valor->PROD_CodigoUsuario, "flagGenInd" => $valor->PROD_GenericoIndividual, "pcosto" => $pcosto, "stock" => $stock, "almacenProducto" => $CodigoAlmacenProducto);
                                }
                            } else {
                                $stock = $valorReal->ALMPROD_Stock;
                                $result[] = array("value" => $valor->PROD_CodigoUsuario . "  - " . $valor->PROD_Nombre . "  " . $stock, "codigo" => $valor->PROD_Codigo, "codinterno" => $valor->PROD_CodigoUsuario, "flagGenInd" => $valor->PROD_GenericoIndividual, "pcosto" => $pcosto, "stock" => $stock, "almacenProducto" => $CodigoAlmacenProducto);

                            }

                        }
                    } else {
                        $result[] = array("value" => $valor->PROD_CodigoUsuario . "  - " . $valor->PROD_Nombre . "  " . $stock, "codigo" => $valor->PROD_Codigo, "codinterno" => $valor->PROD_CodigoUsuario, "flagGenInd" => $valor->PROD_GenericoIndividual, "pcosto" => $pcosto, "stock" => $stock, "almacenProducto" => $CodigoAlmacenProducto, "PROD_FlagBienServicio" => $valor->PROD_FlagBienServicio);
                    }
                }
            }


        }
        echo json_encode($result);
    }

    public function autocompleteIdSunat()
    {

        $keyword = $this->input->post('term');
        $datosArticulo = $this->producto_model->buscar_codigo_sunat($keyword);
        $result = array();

        if ($datosArticulo != NULL) {
            foreach ($datosArticulo as $key => $valor) {
                $id = $valor->PRODS_Id;
                $idSunat = $valor->PRODS_Codigo;
                $descripcion = $valor->PRODS_Descripcion;
                $result[] = array("codigo" => $id, "idsunat" => $idSunat, "descripcion" => $descripcion);
            }
        }
        echo json_encode($result);
    }

    public function registro_productos_pdf($flagbs, $codigo, $nombre, $familia, $marca)
    {

        $this->load->library('cezpdf');
        $this->load->helper('pdf_helper');
        //prep_pdf();
        $this->cezpdf = new Cezpdf('a4');
        $datacreator = array(
            'Title' => 'Estadillo de ',
            'Name' => 'Estadillo de ',
            'Author' => 'Vicente Producciones',
            'Subject' => 'PDF con Tablas',
            'Creator' => 'info@vicenteproducciones.com',
            'Producer' => 'http://www.vicenteproducciones.com'
        );

        $this->cezpdf->addInfo($datacreator);
        $this->cezpdf->selectFont(APPPATH . 'libraries/fonts/Helvetica.afm');
        $delta = 20;



        //        $this->cezpdf->ezText('', '', array("leading" => 100));
        $this->cezpdf->ezText('<b>LISTADO DE ARTICULOS</b>', 14, array("leading" => 0, 'left' => 185));
        $this->cezpdf->ezText('', '', array("leading" => 10));


        /* Datos del cliente */


        //        /* Listado de detalles */

        $db_data = array();

        /*
        $codigo = '001';
        $nombre = 'Celular Inteligente SamSumg Flip 4';
        $familia = 'PEGABLE';
        $marca = 'SAMSUMG';
        */
        $listado_productos = $this->producto_model->listar_productos_pdf($flagbs, $codigo, $nombre, $familia, $marca);
        var_dump('verificando datos', $listado_productos);


        if (count($listado_productos) > 0) {
            foreach ($listado_productos as $indice => $valor) {
                $codigo = $valor->PROD_CodigoUsuario;
                $nombre = $valor->PROD_Nombre;
                $familia = $valor->FAMI_Descripcion;
                $marca = $valor->MARCC_Descripcion;

                $db_data[] = array(
                    'cols1' => $indice + 1,
                    'cols2' => $codigo,
                    'cols3' => $nombre,
                    'cols4' => $familia,
                    'cols5' => $marca
                );
            }
        }

        if ($flagbs == 'B'):
            $col_names = array(
                'cols1' => '<b>ITEM</b>',
                'cols2' => '<b>CODIGO U.</b>',
                'cols3' => '<b>DESCRIPCION</b>',
                'cols4' => '<b>FAMILIA</b>',
                'cols5' => '<b>MARCA</b>'
            );
        elseif ($flagbs == 'S'):
            $col_names = array(
                'cols1' => '<b>ITEM</b>',
                'cols2' => '<b>CODIGO U.</b>',
                'cols3' => '<b>DESCRIPCION</b>',
                'cols4' => '<b>FAMILIA</b>',
            );
        endif;



        $this->cezpdf->ezTable($db_data, $col_names, '', array(
            'width' => 725,
            'showLines' => 1,
            'shaded' => 1,
            'showHeadings' => 1,
            'xPos' => 'center',
            'fontSize' => 8,
            'cols' => array(
                'cols1' => array('width' => 50, 'justification' => 'center'),
                'cols2' => array('width' => 60, 'justification' => 'center'),
                'cols3' => array('width' => 200, 'justification' => 'left'),
                'cols4' => array('width' => 80, 'justification' => 'center'),
                'cols5' => array('width' => 80, 'justification' => 'center')
            )
        ));


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => $codificacion . '.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        ob_end_clean();

        $this->cezpdf->ezStream($cabecera);



    }

    ////

    public function registro_familia_pdf($flagbs = 'B', $codigo, $nombre)
    {

        $this->load->library('cezpdf');
        $this->load->helper('pdf_helper');
        //prep_pdf();
        $this->cezpdf = new Cezpdf('a4');
        $datacreator = array(
            'Title' => 'Estadillo de ',
            'Name' => 'Estadillo de ',
            'Author' => 'Vicente Producciones',
            'Subject' => 'PDF con Tablas',
            'Creator' => 'info@vicenteproducciones.com',
            'Producer' => 'http://www.vicenteproducciones.com'
        );

        $this->cezpdf->addInfo($datacreator);
        $this->cezpdf->selectFont(APPPATH . 'libraries/fonts/Helvetica.afm');
        $delta = 20;


        //        $this->cezpdf->ezText('', '', array("leading" => 100));
        $this->cezpdf->ezText('<b>LISTADO FAMILIA DE ARTICULOS</b>', 14, array("leading" => 0, 'left' => 185));
        $this->cezpdf->ezText('', '', array("leading" => 10));


        /* Datos del cliente */


        //        /* Listado de detalles */

        $db_data = array();


        $codfamih = $this->producto_model->listar_familia_pdf($flagbs, $codigo, $nombre);
        //$lista = array();
        if ($nombre) {
            if (count($codfamih) > 0) {
                foreach ($codfamih as $indice => $valor) {
                    $codigo = $valor->FAMI_Codigo;
                    $codigo_interno = $valor->FAMI_CodigoInterno;
                    $descripcion = $valor->FAMI_Descripcion;


                    $db_data[] = array(
                        'cols1' => $indice + 1,
                        'cols2' => $codigo_interno,
                        'cols3' => $descripcion
                    );
                }
            }
        } else {
            if (count($listado_productos) > 0) {
                foreach ($listado_productos as $indice => $valor) {
                    $codigo = $valor->FAMI_Codigo;
                    $codigo_interno = $valor->FAMI_CodigoInterno;
                    $descripcion = $valor->FAMI_Descripcion;


                    $db_data[] = array(
                        'cols1' => $indice + 1,
                        'cols2' => $codigo_interno,
                        'cols3' => $descripcion
                    );
                }
            }

        }


        $col_names = array(
            'cols1' => '<b>ITEM</b>',
            'cols2' => '<b>CODIGO</b>',
            'cols3' => '<b>DESCRIPCION</b>'
        );

        $this->cezpdf->ezTable($db_data, $col_names, '', array(
            'width' => 525,
            'showLines' => 1,
            'shaded' => 1,
            'showHeadings' => 1,
            'xPos' => 'center',
            'fontSize' => 8,
            'cols' => array(
                'cols1' => array('width' => 30, 'justification' => 'center'),
                'cols2' => array('width' => 70, 'justification' => 'center'),
                'cols3' => array('width' => 245, 'justification' => 'left')
            )
        ));


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => $codificacion . '.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        ob_end_clean();

        $this->cezpdf->ezStream($cabecera);
    }

    /*
    public function JSON_busca_producto_xdoc($nombre, $flagBS)
    {
        $datos_persona = $this->Global_model->get_where('cji_producto', array('PROD_FlagBienServicio' => $flagBS, 'PROD_Nombre' => $nombre), 1);  //Esta funcion me devuelde el registro de la empresa
        // $datos_persona =$this->producto_model->buscar_productoingresar($flagBS,$nombre);
        $resultado = '[]';

        if ($datos_persona) {


            $resultado = '[{"nombre_producto":"' . $datos_persona->PROD_Nombre . '"}]';
        }
        echo $resultado;
        // echo json_encode($resultado);
    }
    */


    /**verificamos si el producto se encuentra en un almacen es decir inventariado **/
    public function verificarInventariado($codigoProducto)
    {
        if ($codigoProducto != 0) {
            $this->load->model('almacen/inventario_model');
            /***verificamos si el producto se encuentra inventariado**/
            $datosInventarioProducto = $this->inventario_model->verificarProductoInventarios($codigoProducto);
            if ($datosInventarioProducto != null && count($datosInventarioProducto) > 0) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }




    public function buscarAlmacenProducto($codigoProducto)
    {
        $resultado = array();
        $almacen_id = null;
        $datosAlmacenProducto = $this->almacenproducto_model->obtener($almacen_id, $codigoProducto);
        if ($datosAlmacenProducto != null && count($datosAlmacenProducto) > 0) {
            foreach ($datosAlmacenProducto as $indice => $valor) {
                $codigoAlmacenProducto = $valor->ALMPROD_Codigo;
                $codigoAlmacen = $valor->ALMAP_Codigo;
                $nombreAlmacen = $valor->ALMAC_Descripcion;
                $stock = $valor->ALMPROD_Stock;
                $resultado[] = array("codigo" => $codigoAlmacen, "nombreAlmacen" => $nombreAlmacen, "stock" => $stock);
            }
        }
        echo json_encode($resultado);
    }

    /**verificamos si el producto se encuentra en un almacen es decir inventariado **/
    public function verificarInventariadoAlmacen($codigoProducto, $almacen)
    {
        if ($codigoProducto != 0) {
            $this->load->model('almacen/inventario_model');
            /***verificamos si el producto se encuentra inventariado**/
            $datosInventarioProducto = $this->inventario_model->verificarProductoInventarioAlmacen($codigoProducto, $almacen);
            if ($datosInventarioProducto != null && count($datosInventarioProducto) > 0) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    public function verificarStockAlert()
    {
        $dataStockMinimo = $this->producto_model->stockMin(true);
        $result = array();
        if ($dataStockMinimo != NULL) {
            foreach ($dataStockMinimo as $key => $value) {
                if ($value->COMPP_Codigo == $this->somevar['compania']) {
                    $result[] = array(
                        "codigoProducto" => $value->PROD_CodigoUsuario,
                        "nombreProducto" => $value->PROD_Nombre,
                        "stockActual" => $value->ALMPROD_Stock,
                        "stockMinimo" => $value->PROD_StockMinimo,
                        "pendienteOC" => $value->pendienteOC,
                        "pendienteGuia" => $value->pendienteGuia,
                        "pendienteComprobante" => $value->pendienteComprobante
                    );
                }
            }
            echo json_encode($result);
        } else {
            echo json_encode('');
        }
    }

    #############################################################################
    # Funcion usada para buscar productos con pistola lectora de codigo de barras
    # Author: Luis Valdes 11/11/2020
    # 
    #############################################################################

    public function seleccionar_producto_con_enter()
    {
        $tipo_oper = $this->input->post('tipo_oper');
        $flagBS = $this->input->post('flagbs');
        $cod_producto = $this->input->post('codigo_interno');
        $almacen = $this->input->post('almacen');
        $TipCli = $this->input->post('TipCli');
        $moneda = $this->input->post('moneda');

        $filter = new stdClass();
        $filter->PROD_FlagBienServicio = $flagBS;
        $filter->tipo_oper = $tipo_oper;
        $filter->cod_producto = $cod_producto;

        $producto = $this->producto_model->search_barcode($filter);

        $result = array();

        if ($producto != NULL) {

            $cod_prod = $producto[0]->PROD_Codigo;
            $codigointerno = $producto[0]->PROD_CodigoUsuario;
            $afectacion = $producto[0]->AFECT_Codigo;
            $descripcionProducto = $producto[0]->PROD_Nombre;

            $datosAlmacenProducto = $this->almacenproducto_model->obtener($almacen, $cod_prod);
            $datosUnidadProducto = $this->productounidad_model->obtenerprincipal($cod_prod);

            if (count($datosUnidadProducto) > 0) {
                $codunidad = $datosUnidadProducto->UNDMED_Codigo;
            } else {
                $codunidad = 1;
            }

            $TipCli = ($TipCli == "") ? 0 : $TipCli;
            $PrecioXcliente = $this->producto_model->seleccionar_precio_cliente($cod_prod, $TipCli, $moneda);
            $pventa = $PrecioXcliente[0]->PRODPREC_Precio;

            if ($datosAlmacenProducto != NULL && count($datosAlmacenProducto) > 0) {
                foreach ($datosAlmacenProducto as $key => $valorReal) {

                    $CodigoAlmacenProducto = $valorReal->ALMAC_Codigo;

                    if ($almacen != NULL && $almacen != 0 && trim($almacen) != "") {

                        if ($CodigoAlmacenProducto == $almacen) {
                            $stock = $valorReal->ALMPROD_Stock;
                            $lote = $this->lote_model->detalles($cod_prod, $almacen, $tipo_oper);

                            $result[] = array("valor" => '1', "value" => $descripcionProducto, "label" => $producto[0]->PROD_CodigoUsuario . "-" . $descripcionProducto, "codigo" => $cod_prod, "codinterno" => $producto[0]->PROD_CodigoUsuario, "flagGenInd" => $producto[0]->PROD_GenericoIndividual, "pcosto" => $pcosto, "pventa" => $pventa, "stock" => $stock, "almacenProducto" => $CodigoAlmacenProducto, "codunidad" => $codunidad, 'descripcion' => $producto[0]->PROD_DescripcionBreve, 'tipo_afectacion' => $producto[0]->AFECT_Codigo, "marca" => "", "lote" => $lote);
                        }
                    } else {

                        $stock = $valorReal->ALMPROD_Stock;
                        $result[] = array("valor" => '1', "value" => $descripcionProducto, "label" => $producto[0]->PROD_CodigoUsuario . "-" . $descripcionProducto, "codigo" => $producto[0]->PROD_Codigo, "codinterno" => $producto[0]->PROD_CodigoUsuario, "flagGenInd" => $producto[0]->PROD_GenericoIndividual, "pcosto" => $pcosto, "pventa" => $pventa, "stock" => $stock, "almacenProducto" => $CodigoAlmacenProducto, "codunidad" => $codunidad, 'descripcion' => $producto[0]->PROD_DescripcionBreve, 'tipo_afectacion' => $producto[0]->AFECT_Codigo, "marca" => "");
                    }

                }
            } else {

                $stock = 0;
                $result[] = array("valor" => '1', "value" => $descripcionProducto, "label" => $producto[0]->PROD_CodigoUsuario . "-" . $descripcionProducto, "codigo" => $producto[0]->PROD_Codigo, "codinterno" => $producto[0]->PROD_CodigoUsuario, "flagGenInd" => $producto[0]->PROD_GenericoIndividual, "pcosto" => $pcosto, "pventa" => $pventa, "stock" => $stock, "almacenProducto" => $CodigoAlmacenProducto, "codunidad" => $codunidad, 'descripcion' => $producto[0]->PROD_DescripcionBreve, 'tipo_afectacion' => $producto[0]->AFECT_Codigo, "marca" => "");
            }




        } else {

            $result[] = array("valor" => '2');
        }

        echo json_encode($result);
    }

    public function ver_productobarra($codigo)
    {
        //$this->load->library('layout', 'layout');
        $accion = "";
        $modo = "ver";
        $datos_producto = $this->producto_model->obtener_producto($codigo);
        $data['titulo'] = "VER CODIGOS DE BARRA DEL PRODUCTO";
        $data['oculto'] = form_hidden(array('accion' => $accion, 'codigo' => $codigo, 'modo' => $modo, 'base_url' => base_url()));
        $data['producto'] = $codigo;
        $data['cod_producto'] = $datos_producto[0]->PROD_CodigoUsuario;
        //$data['talla'] = $datos_producto[0]->PROD_Talla;
        $talla = $datos_producto[0]->PROD_Talla;
        $data['talla'] = ($talla == "" || $talla == null) ? "" : 'Talla ' . $talla;
        //$data['numero'] = $datos_producto[0]->PROD_Numero;
        $numero = $datos_producto[0]->PROD_Numero;
        $data['numero'] = ($numero == "" || $talla == null) ? "" : '#' . $numero;
        $familia = $datos_producto[0]->FAMI_Codigo;
        $fabricante = $datos_producto[0]->FABRIP_Codigo;
        $tipo_producto = $datos_producto[0]->TIPPROD_Codigo;
        $flagActivo = $datos_producto[0]->PROD_FlagActivo;
        $data['familia'] = $datos_producto[0]->FAMI_Codigo;
        //$nombre_producto = str_replace("/", "<br>/", $datos_producto[0]->PROD_Nombre);
        $textoArticulo = $datos_producto[0]->PROD_Nombre;

        $longitud = strlen($textoArticulo);
        $corte = ($longitud <= 20) ? 15 : 30;
        $punto_corte = strpos($textoArticulo, " T ", $corte);
        if ($punto_corte) {
            $nuevoTexto = substr($textoArticulo, 0, $punto_corte);
        } else {
            $nuevoTexto = $textoArticulo;
        }

        $data['nombre_producto'] = $nuevoTexto;
        $data['descripcion_breve'] = $datos_producto[0]->PROD_DescripcionBreve;
        $data['comentario'] = $datos_producto[0]->PROD_Comentario;
        $data['stock'] = $datos_producto[0]->PROD_Stock;
        $datos_familia = $this->familia_model->obtener_familia($familia);
        $datos_tipoProducto = $this->tipoproducto_model->obtener_tipo_producto($tipo_producto);
        $datos_unidad_medida = $this->producto_model->listar_producto_unidades($codigo);
        $data['nombre_tipo_producto'] = "";
        if (count($datos_tipoProducto) > 0)
            $data['nombre_tipo_producto'] = $datos_tipoProducto[0]->TIPPROD_Descripcion;
        if ($fabricante != NULL) {
            $datos_fabricante = $this->fabricante_model->obtener($fabricante);
            $data['nombre_fabricante'] = $datos_fabricante[0]->FABRIC_Descripcion;
        } else {
            $data['nombre_fabricante'] = "No ha ingresado";
        }
        $filaunidad = '<table width="98%" border="0" align="left" cellpadding="5" cellspacing="0" class="fuente8" id="tblUnidadMedida">';
        foreach ($datos_unidad_medida as $indice => $valor) {
            $unidad = $valor->UNDMED_Codigo;
            $factor = $valor->PRODUNIC_Factor;
            $flagP = $valor->PRODUNIC_flagPrincipal;
            $datos_unidad = $this->unidadmedida_model->obtener($unidad);
            $nombre_unidad = $datos_unidad[0]->UNDMED_Descripcion;
            $filaunidad .= '<tr>';
            if ($indice == 0) {
                $filaunidad .= '<td width="16%">Unidad medida Principal (*)</td>';
            } else {
                $indice2 = $indice + 1;
                $filaunidad .= '<td width="16%">Unidad medida Aux. ' . $indice2 . '</td>';
            }
            $filaunidad .= '<td width="19%">' . $nombre_unidad . '</td>';
            $filaunidad .= '<td width="12%">&nbsp;</td>';
            $filaunidad .= '<td width="52%">&nbsp;</td>';
            $filaunidad .= '</tr>';
        }

        $filaunidad .= '</table>';
        $data['filaunidad'] = $filaunidad;
        $data['fila'] = $this->obtener_datosAtributos($tipo_producto, $codigo, 'ver');
        $data['estado'] = $flagActivo == 1 ? "ACTIVO" : "INACTIVO";
        $data['nombre_familia'] = $datos_familia[0]->FAMI_Descripcion;
        $this->load->view('almacen/productobarra_ver', $data);
    }

    public function listaprecios($flagBS = 'B', $j = '0', $limpia = '')
    {
        $this->load->library('layout', 'layout');
        $data['action'] = base_url() . "index.php/almacen/producto/buscar_productos/" . $flagBS;
        $conf['base_url'] = site_url('almacen/producto/productos/' . $flagBS);

        $data['registros'] = count($this->producto_model->getProductosDatatable());
        $conf['total_rows'] = $data['registros'];

        $data['titulo_tabla'] = "RELACIÓN DE " . ($flagBS == 'B' ? 'ARTICULO' : 'SERVICIO');
        $data['titulo_busqueda'] = "BUSCAR " . ($flagBS == 'B' ? 'ARTICULO' : 'SERVICIO');
        $data['flagBS'] = $flagBS;

        $data['familias'] = $this->producto_model->getFamilias($flagBS);
        $data['modelos'] = $this->producto_model->getModelos();

        $filterOrden = new stdClass();
        $filterOrden->dir = "ASC";

        $filterOrden->order = "FABRIC_Descripcion";
        $data['fabricantes'] = $this->fabricante_model->getFabricantes($filterOrden);

        $filterOrden->order = "MARCC_Descripcion";
        $data['marcas'] = $this->marca_model->getMarcas($filterOrden);

        $filterOrden->order = "UNDMED_Descripcion";
        $data['unidades'] = $this->unidadmedida_model->getUmedidas($filterOrden);
        $data['afectaciones'] = $this->producto_model->tipo_afectacion();

        $data["precio_monedas"] = $this->moneda_model->getMonedas();
        $data["precio_categorias"] = $this->tipocliente_model->getCategorias();

        $data['oculto'] = form_hidden(array('base_url' => base_url(), 'flagBS' => $flagBS));

        $data['categorias'] = $this->producto_model->getCategorias();
        $data['totalesCat'] = $this->producto_model->getTotalesCategoria();
        $data['esta'] = $this->session->userdata('establec');

        $tam = count($data['totalesCat']);
        $data['totalesCat'][$tam]->categoria = "PRECIO COSTO";
        $data['totalesCat'][$tam]->total = $this->producto_model->getTotalPrecioCosto();
        $data['totalesCat'][$tam]->moneda = "S/ ";

        #$pcostoTotal = $this->producto_model->obtenerPrecioCostoTotal();
        $tam++;
        $pcostoTotal = 0;
        $pcostoTotal += $this->producto_model->getTotalPrecioCosto();
        $data['totalesCat'][$tam]->categoria = "TOTAL INVERSIÓN";
        $data['totalesCat'][$tam]->total = $pcostoTotal;
        $data['totalesCat'][$tam]->moneda = "S/ ";
        $this->layout->view('almacen/listaprecios_index', $data);
    }
    public function datatable_productos_lista_precios($flagBS = 'B')
    {

        $columnas = array(
            0 => "PROD_CodigoUsuario",
            1 => "PROD_Nombre",
            2 => "FAMI_Descripcion",
            3 => "MARCC_Descripcion",
            4 => "PROD_UltimoCosto",
            5 => "UNDMED_Simbolo",
            6 => ""
        );

        $filter = new stdClass();
        $filter->start = $this->input->post("start");
        $filter->length = $this->input->post("length");
        $filter->search = $this->input->post("search")["value"];

        $ordenar = $this->input->post("order")[0]["column"];
        if ($ordenar != "") {
            $filter->order = $columnas[$ordenar];
            $filter->dir = $this->input->post("order")[0]["dir"];
        }

        $item = ($this->input->post("start") != "") ? $this->input->post("start") : 0;

        $filter->codigo = $this->input->post("txtCodigo");
        $filter->producto = $this->input->post("txtNombre");
        $filter->familia = $this->input->post("txtFamilia");
        $filter->modelo = $this->input->post("txtModelo");
        $filter->marca = $this->input->post("txtMarca");
        $filter->flagBS = $flagBS;

        $listado = $this->producto_model->getProductosDatatable($filter);
        $lista = array();

        if (count($listado) > 0) {
            foreach ($listado as $indice => $valor) {
                $posPrecio = $valor->PROD_Codigo;
                $divNPC = '<div style="text-align: left;">
                                <div class="costo"> <img src="' . base_url() . 'images/icono_nuevo.png" height="14px"/>
                                    <span class="editar_costo">
                                        <form action="' . base_url() . '" method="POST">
                                            <input type="number" class="cajaMedia" placeholder="Precio costo" id="' . $posPrecio . '" name="' . $posPrecio . '" step="0.01" min="0.01" value="' . $valor->PROD_UltimoCosto . '"/>
                                            <span onclick="insertar_costo(\'' . $valor->PROD_Codigo . '\',\'' . $posPrecio . '\')"> <img src="' . base_url() . 'images/botonaceptar.jpg" id="btnCosto' . $posPrecio . '" name="btnCosto' . $posPrecio . '"/> </span>
                                            <img src="' . base_url() . 'images/loading.gif?=' . IMG . '" style="width:24px; display:none" id="loading' . $posPrecio . '" name="loading' . $posPrecio . '">
                                        </form>
                                    </span>
                                </div>
                                <span style="color:red; font-weight: bold" data-bat="' . number_format($valor->PROD_UltimoCosto, 2) . '" id="span' . $posPrecio . '" name="span' . $posPrecio . '">' . number_format($valor->PROD_UltimoCosto, 2) . '</span>
                            </div>';
                $barcode = " <a onclick='barcode($valor->PROD_Codigo)' style='cursor:pointer;'><img src='" . base_url() . "images/barcode.png' width='40' height='40' border='0' title='Codigo de Barras'></a>";
                if ($valor->PROD_FlagActivo == 1) {
                    $eliminar = "<button type='button' onclick='eliminar_producto($valor->PROD_Codigo)' class='btn btn-default' title='Desactivar'><img src='" . $this->url . "images/eliminar.png' class='image-size-1b'></button>";
                    # code...
                } else {
                    $eliminar = "<button type='button' onclick='habilitar_producto($valor->PROD_Codigo)' class='btn btn-default' title='Activar'><img src='" . $this->url . "images/active.png' class='image-size-1b'></button>";

                }



                $lista[$indice] = array(
                    0 => $valor->PROD_CodigoUsuario,
                    1 => $valor->PROD_Nombre,
                    2 => $divNPC
                );

                $categorias = $this->producto_model->getPrecios_n($valor->PROD_Codigo);
                $j = 3;
                $env = 1000;

                foreach ($categorias as $i => $v) {
                    $dt = explode("-", $v->precio);
                    $dt2 = explode("-", $v->porcen);
                    $pro = $valor->PROD_Codigo;

                    if ($dt2[0] == 'null' or $dt2[0] == "") {
                        $porcen = '0.00';
                    } else {
                        $porcen = $dt2[0];
                    }

                    $validator = $pro . $j;

                    $lista[$indice][$j] = "<input style='background-color: #c7c6c6;' class='porcen" . $validator . " cajaPequena' data-prod='" . $pro . "' data-env='" . $pro . $env . "' data-check='1' data-porcen='" . $porcen . "' data-type='" . $v->TIPCLIP_Codigo . "' style='width : 60px;' type='number' value='" . $porcen . "' onchange='calcular(1," . $pro . $j . ")'>";
                    $j++;
                    $lista[$indice][$j] = "<input class='precio" . $validator . " cajaPequena' data-env='" . $pro . $env . "' data-id-parent='" . $validator . "' data-precio='" . $dt[0] . "' style='width : 80px;' type='number' title='$v->TIPCLIC_Descripcion' value='" . $dt[0] . "' onchange='calcular(2," . $validator . ")'>";
                    $j++;

                }



                /*$lista[$indice][$j] = $barcode;
                $j++;*/
                $lista[$indice][$j] = '<img src="' . base_url() . '/images/icono_aprobar.png" data-contador="0" width="30px;" style="opacity:0.2" id="' . $pro . $env . '">';



            }
        }

        unset($filter->start);
        unset($filter->length);

        $json = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval(count($this->producto_model->getProductosDatatable())),
            "recordsFiltered" => intval(count($this->producto_model->getProductosDatatable($filter))),
            "data" => $lista
        );

        echo json_encode($json);
    }

    public function cambiarPrecioProducto()
    {
        $d = array();
        $data = json_decode($_POST['array'], true);



        for ($i = 0; $i < 3; $i++) {
            $porcentaje = $data[$i][0];
            $porcentaje_viejo = $data[$i][1];
            $tipo_precio = $data[$i][2];
            $precio = $data[$i][3];
            $precio_viejo = $data[$i][4];
            $esta = $data[$i][5];
            $prod = $data[$i][6];

            $data2 = array(
                'PRODPREC_PorcGanancia' => $porcentaje,
                'PRODPREC_Precio' => $precio
            );
            $valor = $this->producto_model->cambiarPrecioProducto($data2, $prod, $tipo_precio, 1, $esta);
            array_push($d, $data2);
        }
        //print_r($d);
    }

    public function cambiarPrecioProducto_masivo()
    {
        $d = array();
        $data = json_decode($_POST['array'], true);

        $count = count($data);


        for ($i = 0; $i < $count; $i++) {
            $porcentaje = $data[$i][1];
            $porcentaje_viejo = $data[$i][2];
            $tipo_precio = $data[$i][3];
            $precio = $data[$i][4];
            $precio_viejo = $data[$i][5];
            $esta = $data[$i][6];
            $prod = $data[$i][7];

            $data2 = array(
                'PRODPREC_PorcGanancia' => $porcentaje,
                'PRODPREC_Precio' => $precio
            );
            $valor = $this->producto_model->cambiarPrecioProducto($data2, $prod, $tipo_precio, 1, $esta);
            array_push($d, $data2);
        }
        //print_r($d);
    }

    public function ver_barcode($codigo)
    {
        $this->lib_props->BarCode($codigo);
    }


    ############################################################
#Funcion para buscar precios de productos
#ubicacion: Sup Layout
#
############################################################
    public function buscar_precio_lectora_nombre()
    {
        $tipo_oper = $this->input->post('tipo_oper');
        $tipo_doc = $this->input->post('tipo_docu');
        $flagBS = $this->input->post('flagbs');
        $cod_producto = trim($this->input->post('codigo_interno'));
        $almacen = '';
        // $TipCli    = $this->input->post('TipCli');
        $compania = $this->input->post('compania');
        $search = $this->input->post('search');

        $filter = new stdClass();
        $filter->start = $this->input->post("start");
        $filter->length = $this->input->post("length");
        $filter->search = $this->input->post("search")["value"];
        $filter->PROD_FlagBienServicio = $flagBS;
        $filter->tipo_oper = $tipo_oper;
        $filter->cod_producto = $cod_producto;
        $filter->nombreProducto = trim($search);
        $rowComp = [];
        $rowCli = [];

        // $ordenar = $this->input->post("order")[0]["column"];
        // if ($ordenar != ""){
        //     $filter->order = $columnas[$ordenar];
        //     $filter->dir = $this->input->post("order")[0]["dir"];
        // }

        if (empty($cod_producto) and empty($search)) {
            $json = array(
                "draw" => intval($this->input->post('draw')),
                "recordsTotal" => intval(0),
                "recordsFiltered" => intval(0),
                "data" => []
            );
            echo json_encode($json);
            die;
        }

        $listado = [];
        $lista = [];
        $producto = $this->producto_model->search_barcodeDataTable($filter);

        /*if ($producto == NULL and $tipo_oper == 'V')
        {
            // Buscar en table seriemov si existe en compras y si esta activa
            $prodSerie = $this->seriemov_model->getListForCPB(0, 0, 0, 'C', false, $cod_producto, false);
            if (isset($prodSerie->PROD_Codigo))
            {
                $rowProd = $this->producto_model->getProducto($prodSerie->PROD_Codigo);
                if (isset($rowProd[0]->PROD_CodigoInterno))
                {
                    $filter->cod_producto = $rowProd[0]->PROD_CodigoInterno;
                    $producto = $this->producto_model->search_barcode($filter);
                }
            }
        }*/

        if ($producto != NULL) {
            foreach ($producto as $key => $pro) {
                $cod_prod = $pro->PROD_Codigo;
                $codigointerno = $pro->PROD_CodigoUsuario;
                $afectacion = $pro->AFECT_Codigo;
                $descripcionProducto = $pro->PROD_Nombre;

                $datosAlmacenProducto = $this->almacen_model->buscar_x_compania($compania);
                // $prodSerie = $this->serie_model->getlist($almacen, $pro->PROD_Codigo, 1, false, 0, [1], 'V');
                $stockGen = 0;
                if ($datosAlmacenProducto != NULL && count($datosAlmacenProducto) > 0) {
                    foreach ($datosAlmacenProducto as $key => $almacen) {
                        $stock = $this->almacenproducto_model->obtener($almacen->ALMAP_Codigo, $cod_prod);
                        $stockGen += $stock[0]->ALMPROD_Stock;
                    }
                }

                $listado[] = array(
                    "valor" => '1',
                    "value" => $descripcionProducto,
                    "label" => $descripcionProducto,
                    "codigo" => $cod_prod,
                    "codinterno" => $pro->PROD_CodigoUsuario,
                    "flagGenInd" => $pro->PROD_GenericoIndividual,
                    "pcosto" => 0,
                    "stock" => $stockGen,
                    'descripcion' => $pro->PROD_DescripcionBreve,
                    'unidadMedida' => $pro->unidadMedida,
                    'tipo_afectacion' => $pro->AFECT_Codigo,
                    "marca" => "",
                    'rowComp' => isset($rowComp[0]) ? $rowComp[0] : [],
                    'rowCli' => isset($rowCli[0]) ? $rowCli[0] : [],
                    "precioMinimoSoles" => $pro->PROD_PrecioMaximoSoles,
                    "precioMinimoDolar" => $pro->PROD_PrecioMaximoDolar
                );
            }
        }

        foreach ($listado as $indice => $valor) {
            $posDT = 0;
            $lista[$indice] = array(
                $posDT++ => $valor['codinterno'], //0
                $posDT++ => $valor['value'], //1
                $posDT++ => "<div class='text-center'>" . $valor['unidadMedida'] . "</div>", //2
                $posDT++ => "<div class='text-center'>" . $valor['stock'] . "</div>", //3
            );

            $categorias = $this->producto_model->getPrecios($valor['codigo']);
            $j = 3;

            foreach ($categorias as $i => $v) {
                $j++;
                $lista[$indice][$j] = "<div class='text-center'><span title='$v->TIPCLIC_Descripcion'>" . $v->precio . "</span></div>";
            }

            /*$j++;
            $lista[$indice][$j] = '<div class="text-center">US$ '.number_format($valor['precioMinimoDolar'], 2).' </div>';*/
        }

        unset($filter->start);
        unset($filter->length);

        $json = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval(count($listado)),
            "recordsFiltered" => intval(count($listado)),
            "data" => $lista
        );

        echo json_encode($json);
        die;
    }




}
?>