<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	function login()
	{
		$this->load->model('user_model');
		$this->form_validation->set_rules('userEmail', 'email', 'trim|required|valid_email|callback__check_login');
		$this->form_validation->set_rules('userPassword', 'password', 'trim|required');
		
		//if($this->form_validation->run())
		//{
			// the form has successfully validated
			if($this->user_model->Login(array('userEmail' => $this->input->post('userEmail'), 'userPassword' => $this->input->post('userPassword'))))
			{
				redirect('user/index');
			} //redirect('welcome/login');
		//}
		
		$this->load->view('template/template_head');
		$this->load->view($this->uri->segment(1).'/'.$this->uri->segment(1).'_login_form');
		$this->load->view('template/template_foot');
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect($this->uri->segment(1).'/index');
	}
	
	function index()
	{
		$this->load->view('template/template_head');
		$this->load->view($this->uri->segment(1).'/'.$this->uri->segment(1).'_index');
		$this->load->view('template/template_foot');
	}

	function builder()
	{
		if( isset($_POST['model']) ){
			
			// Build the database table
			$this->load->dbforge();
			$modelname = $_POST['model'].'_model';
			$this->load->model($modelname);
			$fields = array();
			
			// Set up the id & timestamp fields
			$fields[$this->$modelname->_pk()] = array('type'=>'int','unsigned' => TRUE,'auto_increment' => TRUE);
			$fields = array_merge( $fields, $this->$modelname->_fields() );
			$fields[$this->$modelname->_ds()] = array('type'=>'timestamp');
			$this->dbforge->add_field($fields);
			
			$this->dbforge->add_key($this->$modelname->_pk(), TRUE);
			
			$this->dbforge->create_table($this->$modelname->_table(), TRUE);
			
			// Set up the controller
			$this->load->helper('file');
			$controller = read_file('./reactor_templates/flashdata.php');
			$controller = str_replace("FlashData", ucfirst($_POST['model']), $controller);
			$controller = str_replace("flashdata_model", $modelname, $controller);
			if ( ! write_file('./application/controllers/'.$_POST['model'].'.php', $controller))
				$this->session->set_flashdata('flashError', 'Unable to write controller file. Check directory permissions.<br/>');
			else
			     $this->session->set_flashdata('flashConfirm', 'Controller written!<br/>');
			
			// Set up the views
			mkdir('./application/views/'.$_POST['model'], 0777);
			
			$view = read_file('./reactor_templates/flashdata_index.php');
			if ( ! write_file('./application/views/'.$_POST['model'].'/'.$_POST['model'].'_index.php', $view))
				$this->session->set_flashdata('flashError', 'Unable to write view file. Check directory permissions.<br/>');
			else
			     $this->session->set_flashdata('flashConfirm', 'Index view written!<br/>');
			$view = read_file('./reactor_templates/flashdata_add_form.php');
			if ( ! write_file('./application/views/'.$_POST['model'].'/'.$_POST['model'].'_add_form.php', $view))
				$this->session->set_flashdata('flashError', 'Unable to write view file. Check directory permissions.<br/>');
			else
			     $this->session->set_flashdata('flashConfirm', 'Add view written!<br/>');
			$view = read_file('./reactor_templates/flashdata_edit_form.php');
			if ( ! write_file('./application/views/'.$_POST['model'].'/'.$_POST['model'].'_edit_form.php', $view))
				$this->session->set_flashdata('flashError', 'Unable to write view file. Check directory permissions.<br/>');
			else
			     $this->session->set_flashdata('flashConfirm', 'Edit view written!<br/>');
			
			// Update the CMS template
			$template = read_file('./application/views/template/template_head.php');
			$navMarker = '<!-- Add nav elements here -->';
			$navElement = '<li><a href="<?= base_url() ?>'.$_POST['model'].'" class="'.$_POST['model'].'">'.ucfirst($_POST['model']).'</a></li>';
			$template = str_replace($navMarker, $navMarker.$navElement, $template);
			if ( ! write_file('./application/views/template/template_head.php', $template))
				$this->session->set_flashdata('flashError', 'Unable to write site nav file. Check directory permissions.<br/>');
			else
			     $this->session->set_flashdata('flashConfirm', 'Template view written!<br/>');
			
		}
		
		$loneModels = array();
		
		$this->load->helper('directory');
		$models = directory_map('./application/models');
		$controllers = directory_map('./application/controllers');
		
		foreach( $models as $model ){
			$name = explode("_",$model);
			if(isset($name[1]))
				if( $name[1] == "model.php")
					if( !is_file('./application/controllers/'.$name[0].'.php') )
						$loneModels[$name[0]] = $name[0];
		}
		$data['loneModels'] = $loneModels;
		
		$this->load->view('template/template_head');
		$this->load->view($this->uri->segment(1).'/'.$this->uri->segment(1).'_builder', $data);
		$this->load->view('template/template_foot');
	}
	
	function _check_login($userEmail)
	{
		$this->load->model('user_model');
		if($this->input->post('userPassword'))
		{
			$user = $this->user_model->GetUsers(array('userEmail' => $userEmail, 'userPassword' => md5($this->input->post('userPassword'))));
			if($user) return true;
		}
		
		$this->form_validation->set_message('_check_login', 'Your username / password combination is invalid.');
		return false;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */