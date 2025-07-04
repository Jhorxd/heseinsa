<?php
if (!defined( 'BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Auth
{
	private $ci;

	function __construct()
	{
		$this->ci = &get_instance();
		!$this->ci->load->library('session') ? $this->ci->load->library('session') : FALSE;
		!$this->ci->load->helper('url') ? $this->ci->load->helper('url') : FALSE;
	}

	public function check_login()
	{
		if($this->ci->router->class != "index" && $this->ci->session->userdata('user') == FALSE) {
			redirect(base_url());
		}
	}
}