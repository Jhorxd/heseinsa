<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * redux_auth
	 *
	 * @author Mathew Davies <leveldesign.info@gmail.com>
	 * @copyright Copyright (c) 1 June 2008, Mathew Davies
	 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
	 * @version 1.4
	 * @since 1.0
	**/
	class redux_auth extends redux_auth_db
	{
		/**
		 * __construct
		 *
		 * @access public
		 * @param void
		 * @return void
		**/
		function __construct()
		{
			$this->ci =& get_instance();
	
			$this->ci->config->load('redux_auth');
			$auth = $this->ci->config->item('auth');
			
			foreach($auth as $key => $value)
			{
				$this->$key = $value;
			}
			
			$this->ci->email->initialize($this->mail);
		}

		/**
		 * register
		 *
		 * @access public
		 * @param string $username Username
		 * @param string $password Password
		 * @param string $email Valid email address
		 * @param string $question Secret question
		 * @param string $answer Answer to secret question
		 * @return mixed
		**/
		public function register ($username, $password, $email, $question, $answer)
		{
			# Hash secret answer
			$answer = sha1($this->salt.$answer); 
			
			# Insert question and answer into the questions table
			$this->ci->db->insert($this->questions_table, array('question' => $question, 'answer' => $answer)); 
			
			# Retrieve the question_id
			$question_id = $this->ci->db->insert_id();
			
			# Generate dynamic salt
			$hash = sha1(microtime()); 
			
			# Insert the salt into database
			$this->ci->db->set('hash', $hash); 
			
			# Hash password
			$password_enc = sha1($this->salt.$hash.$password);
			
			$data = array
			(
				'username' 	=> $username,
				'password' 	=> $password_enc,
				'email'    	=> $email,
				'group_id'	=> $this->default_group,
				'question_id' => $question_id
			);
	
			$this->ci->db->set($data);
			
			/**
			 * Optional Columns Start
			**/
			if (!empty($this->optional_columns))
			{
				foreach($this->optional_columns as $key)
				{
					if (!$this->ci->input->post($key))
					{
						$optional[$key] = null;
					}
					else
					{
						$optional[$key] = $this->ci->input->post($key);
					}
				}
	
				$this->ci->db->set($optional);
			}
			/**
			 * Optional Columns Finish
			**/
	
			if (!$this->email_activation)
			{
				# Insert information into the users table
				$this->ci->db->insert($this->users_table);
	
				# Automatic login
				$this->login($email, $password);
				
				return 'REGISTRATION_SUCCESS';
			}
	
			else
			{
				# Generate activation code
				$key = sha1(microtime());
	
				$this->ci->db->set('activation_code', $key);
				$this->ci->db->insert($this->users_table);
				
				$message = str_replace('{activation_code}', $key, $this->email_activation_message); 
	
				$this->ci->email->from($this->mail_from_email, $this->mail_from_name);
				$this->ci->email->to($email);
				$this->ci->email->subject($this->email_activation_subject);
				$this->ci->email->message($message);
				$this->ci->email->send();
				
				return 'REGISTRATION_SUCCESS_EMAIL';
			}	
	
			return false;
		}
		
		/**
		 * login
		 *
		 * @access public
		 * @param string $email Vaild email address
		 * @param string $password Password
		 * @return mixed
		**/
		public function login ($email, $password)
		{			
			# Grab hash, password, id, activation_code and banned_id from database.
			$result = $this->_login($this->users_table, $this->banned_table, $email); 
	
			if ($result)
			{
	
				if(!empty($result->activation_code))
				{
					$this->ci->session->set_flashdata('login', 'Your Account is Not Activated.');
					return 'NOT_ACTIVATED';
				}
				elseif(!empty($result->banned_id))
				{
					$this->ci->session->set_flashdata('login', 'Your Account has been banned for the following reason : '.$result->reason);
					return 'BANNED';
				}
				else
				{
					$password = sha1($this->salt.$result->hash.$password);
	
					if ($password === $result->password)
					{
						$this->ci->session->set_userdata(array('id'=> $result->id));
	
						return true;
					}
				}
			}
			
			return false;
		}
		
		/**
		 * logged_in
		 *
		 * @access public
		 * @param void
		 * @return bool
		**/
		public function logged_in ()
		{
			return $var = ($this->ci->session->userdata('id')) ? true : false; 
		}

		/**
		 * logout
		 *
		 * @access public
		 * @param void
		 * @return void
		**/
		public function logout ()
		{
			$this->ci->session->unset_userdata('id');
			$this->ci->session->sess_destroy();
		}

		/**
		 * activate
		 *
		 * @access public
		 * @param string $activation_code
		 * @return bool
		**/
		public function activate ($activation_code)
		{
			$activate = $this->_activate($this->users_table, $activation_code);
		
			return $var = ($activate) ? true : false;
		}
		
		/**
		 * change_password
		 *
		 * @access public
		 * @param
		 * @return
		**/
		public function change_password($old_password, $new_password)
		{
			
	 	}
		
	 	/**
	 	 * forgotten_begin
	 	 *
	 	 * @access public
	 	 * @param string $email Valid email address
	 	 * @return bool
	 	**/
		public function forgotten_begin ($email)
		{
			if($this->_check_forgotten_code($this->users_table, $email))
			{
				# Verification code
				$key = sha1(microtime()); 
				
				# Inserts verification code into the users table
				$this->_insert_forgotten_code($this->users_table, $key, $email); 
	
				# Replace {key} with verification code
				$message = str_replace('{key}', $key, $this->forgotten_password_message);
				
				$this->ci->email->from($this->mail_from_email, $this->mail_from_name);
				$this->ci->email->to($email);
				$this->ci->email->subject($this->forgotten_password_subject);	
				$this->ci->email->message($message);
				$this->ci->email->send();
				
				return true;
			}
			else
			{
				return false;
			}
	
			
		}
		
		/**
		 * forgotten_process
		 *
		 * @access public
		 * @param string $key
		 * @return void
		**/
		public function forgotten_process($key)
		{
			# Select question_id and question
			$question = $this->_select_question($this->users_table, $this->questions_table, $key);
				
			if ($question != false) {
				$data = array
				(
					'question_id' => $question->question_id
				);
				
				$this->ci->session->set_userdata($data);
					
				# Remove the forgotten code from the users table
				$this->_remove_forgotten_code($this->users_table, $key); 
				
				# Return the question to be used in a template
				return $question->question;
			}
			else {
				return false;
			}
			
		}	
		
		/**
		 * forgotten_end
		 *
		 * @access public
		 * @param string $answer Secret question answer
		 * @return bool
		**/
		public function forgotten_end ($answer)
		{
			# Retrieve question_id
			$question_id = $this->ci->session->userdata('question_id'); 
			
			# Destroy question_id
			$this->ci->session->unset_userdata('question_id'); 
			
			# Retrieve questions answer
			$dbanswer = $this->_select_answer($this->users_table, $this->questions_table, $question_id); 
	
			if($dbanswer->answer === sha1($this->salt.$answer))
			{
				# New password
				$password = substr(sha1(microtime()), 0, 10); 
				
				# Insert new password
				$this->_insert_new_password($this->users_table, $password, $question_id); 
	
				# Replace {password} with new password
				$message = str_replace('{password}', $password, $this->new_password_message); 
				
				$this->ci->email->from($this->mail_from_email, $this->mail_from_name); 
				$this->ci->email->to($dbanswer->email);
				$this->ci->email->subject($this->new_password_subject);
				$this->ci->email->message($message);
				$this->ci->email->send();
	
				return true;
			}
	
			return false;
		}
		
		/**
		 * get_group
		 *
		 * @access public
		 * @param string $id Users id
		 * @return string
		**/
		public function get_group($id){return $this->_get_group($this->groups_table, $this->users_table, $id);}
		
		/**
		 * check_username
		 *
		 * @access public
		 * @param string $username Username
		 * @return bool
		**/
		public function check_username($username){return $this->_check_username($this->users_table, $username);}
		
		/**
		 * check_email
		 *
		 * @access public
		 * @param string $email Valid email address
		 * @return bool
		**/
		public function check_email($email){return $this->_check_email($this->users_table, $email);}
	
	}
	
	/**
	 * redux_auth_db
	 *
	 * @author Mathew Davies <leveldesign.info@gmail.com>
	 * @copyright Copyright (c) 1 June 2008, Mathew Davies
	 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
	 * @version 1.4
	 * @since 1.0
	**/
	class redux_auth_db
	{
		
		/**
		 * _activate
		 *
		 * @access protected
		 * @param string $users_tbl Users table
		 * @param string $code Email activation code
		 * @return bool
		**/
		protected function _activate ($users_tbl, $code)
		{
			$this->ci->db->where($users_tbl.'.activation_code', $code)->update($users_tbl, array($users_tbl.'.activation_code' => 0));
		
			return $var = ($this->ci->db->affected_rows() > 0) ? true : false;
		}

		/**
		 * _insert_new_password
		 *
		 * @access protected
		 * @param string $users_tbl Users table
		 * @param string $password New password
		 * @param integer $question_id Question id
		 * @return bool
		**/
		protected function _insert_new_password($users_tbl, $password, $question_id)
		{
			# New hash
			$hash = sha1(microtime()); 

			# New hashed password
			$password = sha1($this->salt.$hash.$password); 

			$data = array(
	           $users_tbl.'.forgotten_password_code' => '0',
	           $users_tbl.'.password' => $password,
	           $users_tbl.'.hash' => $hash
	        );
	
			$this->ci->db->where($users_tbl.'.question_id', $question_id)->update($users_tbl, $data); 
			
			return $var = ($this->ci->db->affected_rows() > 0) ? true : false;
		}

		/**
		 * _insert_forgotten_code
		 *
		 * @access protected
		 * @param string $users_tbl Users table
		 * @param string $key Email verification code
		 * @param string $email Users email address
		 * @return bool
		**/
		protected function _insert_forgotten_code($users_tbl, $key, $email)
		{
			$this->ci->db->where($users_tbl.'.email', $email)->update($users_tbl, array('forgotten_password_code' => $key)); 
			
			return $var = ($this->ci->db->affected_rows() > 0) ? true : false;
		}

		/**
		 * _check_forgotten_code
		 *
		 * @access protected
		 * @param string $users_tbl Users table
		 * @param string $email Valid email address
		 * @return bool
		**/
		protected function _check_forgotten_code($users_tbl, $email)
		{
		 	$i = $this->ci->db->select($users_tbl.'.forgotten_password_code')->from($users_tbl)->where($users_tbl.'.email', $email)->get();
		 	
		 	return $var = ($i->num_rows() > 0) ? true : false;
		}

		/**
		 * _remove_forgotten_code
		 *
		 * @access protected
		 * @param string $users_tbl Users table
		 * @param string $key Email verification code
		 * @return bool
		**/
		protected function _remove_forgotten_code($users_tbl, $key)
		{
		 	$this->ci->db->where($users_tbl.'.forgotten_password_code', $key)->update($users_tbl, array($users_tbl.'.forgotten_password_code' => 0));
		
			return $var = ($this->ci->db->affected_rows() > 0) ? true : false;
		}
		
		/**
		 * _check_username
		 *
		 * @access protected
		 * @param string $users_tbl Users table
		 * @param string $username Username
		 * @return bool
		**/
		protected function _check_username ($users_tbl, $username)
		{
			$i = $this->ci->db->select($users_tbl.'.username')->from($users_tbl)->where($users_tbl.'.username', $username)->get();
			
			return $var = ($i->num_rows() > 0) ? true : false;
		}
		
		/**
		 * _check_email
		 *
		 * @access protected
		 * @param string $users_tbl Users table
		 * @param string $email Valid email address
		 * @return bool
		**/
		protected function _check_email ($users_tbl, $email)
		{
			$i = $this->ci->db->select($users_tbl.'.email')->from($users_tbl)->where($users_tbl.'.email', $email)->get();
			
			return $var = ($i->num_rows() > 0) ? true : false;
		}
		
		/**
		 * _get_group
		 *
		 * @access protected
		 * @param string $groups_tbl Groups table
		 * @param string $users_tbl Users table
		 * @param integer $id Group id
		 * @return string
		**/
		protected function _get_group ($groups_tbl, $users_tbl, $id)
		{
			$i = $this->ci->db->select($groups_tbl.'.title')
			->from($groups_tbl)
			->join($users_tbl, $groups_tbl.'.id = '.$users_tbl.'.group_id', 'left')
			->where($users_tbl.'.id', $id)
			->limit(1)
			->get();
	
			return $var = ($i->num_rows() > 0) ? $i->row()->title : false;
		}
		
		/**
		 * _select_question
		 *
		 * @access protected
		 * @param string $users_tbl Users table
		 * @param string $questions_tbl Questions table
		 * @param string $forgotten_password_code Forgotten password code
		 * @return mixed
		**/
		protected function _select_question ($users_tbl, $questions_tbl, $forgotten_password_code)
		{
			$i = $this->ci->db->select($users_tbl.'.question_id, '.
									   $questions_tbl.'.question')
			->from($users_tbl)
			->join($questions_tbl, $users_tbl.'.question_id = '.$questions_tbl.'.id', 'left')
			->where($users_tbl.'.forgotten_password_code', $forgotten_password_code)
			->limit(1)
			->get();
			
			return $var = ($i->num_rows() > 0) ? $i->row() : false;
		}
		
		/**
		 * _select_answer
		 *
		 * @access protected
		 * @param string $questions_tbl Questions table
		 * @param integer $id Questions id
		 * @return mixed
		**/
		protected function _select_answer ($users_tbl, $questions_tbl, $id)
		{
			$i = $this->ci->db->select($users_tbl.'.email,'.$questions_tbl.'.answer')
			->from($users_tbl)
			->join($questions_tbl, $users_tbl.'.question_id = '.$questions_tbl.'.id', 'left')
			->where($users_tbl.'.id', $id)
			->limit(1)
			->get();
			
			return $var = ($i->num_rows() > 0) ? $i->row() : false;
		}
		
		/**
		 * _login
		 *
		 * @access protected
		 * @param string $users_tbl Users table
		 * @param string $banned_tbl Banned table
		 * @param string $email Valid email address
		 * @return mixed
		**/
		protected function _login ($users_tbl, $banned_tbl, $email)
		{
			$i = $this->ci->db->select($users_tbl.'.password, '.
									   $users_tbl.'.hash, '.
									   $users_tbl.'.id, '.
									   $users_tbl.'.activation_code, '.
									   $banned_tbl.'.reason')	
			->from($users_tbl)
			->join($banned_tbl, $users_tbl.'.banned_id = '.$banned_tbl.'.id', 'left')
			->where($users_tbl.'.email', $email)
			->limit(1)
			->get();
	
			return $var = ($i->num_rows() > 0) ? $i->row() : false;
		}
	}