<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**

 * CodeIgniter

 *

 * An open source application development framework for PHP 4.3.2 or newer

 *

 * @package		CodeIgniter

 * @author		ExpressionEngine Dev Team

 * @copyright	Copyright (c) 2008 - 2010, EllisLab, Inc.

 * @license		http://codeigniter.com/user_guide/license.html

 * @link		http://codeigniter.com

 * @since		Version 1.0

 * @filesource

 */



// ------------------------------------------------------------------------



/**

 * CodeIgniter Application Controller Class

 *

 * This class object is the super class that every library in

 * CodeIgniter will be assigned to.

 *

 * @package		CodeIgniter

 * @subpackage	Libraries

 * @category	Libraries

 * @author		ExpressionEngine Dev Team

 * @link		http://codeigniter.com/user_guide/general/controllers.html

 */

class Controller extends CI_Base {



	var $_ci_scaffolding	= FALSE;

	var $_ci_scaff_table	= FALSE;

	

	/**

	 * Constructor

	 *

	 * Calls the initialize() function

	 */

	function Controller()

	{	

		parent::CI_Base();

		$this->_ci_initialize();

		log_message('debug', "Controller Class Initialized");

                

                $this->load->library('html');
                
                
                ob_start();
        	$this->firephp->setEnabled(false);
        	$this->firephp->info("FirePHP is TRABAJANDO EN TODOS LOS CONTROLADORES DESASCATIVAR EN LIBRERIAS/CONTROLER!");

	}

        

        public function OPTION_generador($lista, $campo_indices, $campo_values,$indDefault='', $seleleccione=array('','Seleccione'), $separador=' '){

            if(!is_array($campo_values))
                $campo_values=array($campo_values);
            if(!is_array($campo_indices))
                $campo_indices=array($campo_indices);



                $arreglo = array();

                if(count($lista)>0){
                        foreach($lista as $indice=>$valor){
                                
                                $id=''; //$id   = $valor->{$campo_indice};
                                $numcampos=count($campo_indices);
                                $i=1;
                                foreach($campo_indices as $campo_indice){
                                    if($i!=$numcampos)
                                        $id.=$valor->{$campo_indice}.'-';
                                    else
                                        $id.=$valor->{$campo_indice};
                                    $i++;
                                }
                                
                                
                                
                                $value='';
                                $numcampos=count($campo_values);
                                $i=1;
                                foreach($campo_values as $campo_value){
                                    if($i!=$numcampos)
                                        $value.= $valor->{$campo_value}.$separador;
                                    else
                                        $value.= $valor->{$campo_value};
                                    $i++;
                                }



                                $arreglo[$id] = $value;

                        }

                }

                $resultado = $this->html->optionHTML($arreglo,$indDefault,$seleleccione);

                return $resultado;

        }

	// --------------------------------------------------------------------



	/**

	 * Initialize

	 *

	 * Assigns all the bases classes loaded by the front controller to

	 * variables in this class.  Also calls the autoload routine.

	 *

	 * @access	private

	 * @return	void

	 */

	function _ci_initialize()

	{

		// Assign all the class objects that were instantiated by the

		// front controller to local class variables so that CI can be

		// run as one big super object.

		$classes = array(

							'config'	=> 'Config',

							'input'		=> 'Input',

							'benchmark'	=> 'Benchmark',

							'uri'		=> 'URI',

							'output'	=> 'Output',

							'lang'		=> 'Language',

							'router'	=> 'Router'

							);

		

		foreach ($classes as $var => $class)

		{

			$this->$var =& load_class($class);

		}



		// In PHP 5 the Loader class is run as a discreet

		// class.  In PHP 4 it extends the Controller

		if (floor(phpversion()) >= 5)

		{

			$this->load =& load_class('Loader');

			$this->load->_ci_autoloader();

		}

		else

		{

			$this->_ci_autoloader();

			

			// sync up the objects since PHP4 was working from a copy

			foreach (array_keys(get_object_vars($this)) as $attribute)

			{

				if (is_object($this->$attribute))

				{

					$this->load->$attribute =& $this->$attribute;

				}

			}

		}

	}

	

	// --------------------------------------------------------------------

	

	/**

	 * Run Scaffolding

	 *

	 * @access	private

	 * @return	void

	 */	

	function _ci_scaffolding()

	{

		if ($this->_ci_scaffolding === FALSE OR $this->_ci_scaff_table === FALSE)

		{

			show_404('Scaffolding unavailable');

		}

		

		$method = ( ! in_array($this->uri->segment(3), array('add', 'insert', 'edit', 'update', 'view', 'delete', 'do_delete'), TRUE)) ? 'view' : $this->uri->segment(3);

		

		require_once(BASEPATH.'scaffolding/Scaffolding'.EXT);

		$scaff = new Scaffolding($this->_ci_scaff_table);

		$scaff->$method();

	}





}

// END _Controller class



/* End of file Controller.php */

/* Location: ./system/libraries/Controller.php */