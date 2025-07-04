<?php 
class Sesion extends Controller {
    public function __construct() {
        parent::Controller();
        $this->load->model('tesoreria/pago_model');
        $this->load->model('maestros/configuracion_model');
        $this->load->model('ventas/comprobante_model');
        $this->load->model('maestros/moneda_model');
        $this->load->model('maestros/formapago_model');
        $this->load->model('maestros/tipocambio_model');
        $this->load->model('compras/proveedor_model');
        $this->load->model('ventas/cliente_model');
        $this->load->model('maestros/compania_model');
        //producto busqueda:
        $this->load->model('almacen/producto_model');
        $this->load->model('almacen/almacenproducto_model');
        $this->load->model('almacen/almacen_model');

        $this->load->helper('form', 'url');
        $this->load->library('pagination');
        $this->load->library('form_validation');

        $this->somevar['compania'] = $this->session->userdata('compania');
        $this->somevar['empresa'] = $this->session->userdata('empresa');
        $this->somevar['user'] = $this->session->userdata('user');
        $this->somevar['rol'] = $this->session->userdata('rol');
    }

    //?Metodo del controlador para cargar(renderizar) la vista de reportes de sesion
    public function index(){
        $this->load->library('layout', 'layout');

        $sesiones=$this->usuario_model->listar_sesiones();

        $data['sesiones'] = $sesiones;

        $this->layout->view('reportes/sesion', $data);
    }
}