<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Waiters extends MX_Controller {

/*
| -----------------------------------------------------
| PRODUCT NAME: 	STOCK MANAGER ADVANCE 
| -----------------------------------------------------
| AUTHER:			MIAN SALEEM 
| -----------------------------------------------------
| EMAIL:			saleem@tecdiary.com 
| -----------------------------------------------------
| COPYRIGHTS:		RESERVED BY TECDIARY IT SOLUTIONS
| -----------------------------------------------------
| WEBSITE:			http://tecdiary.net
| -----------------------------------------------------
|
| MODULE: 			Waiters
| -----------------------------------------------------
| This is waiters module controller file.
| -----------------------------------------------------
*/

	 
	function __construct()
	{
		parent::__construct();
		
		// check if user logged in 
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
		
		$this->load->library('form_validation');
		$this->load->model('waiters_model');


	}
	
   function index()
   {
	  
	  $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	  $data['success_message'] = $this->session->flashdata('success_message');
	  
      $meta['page_title'] = $this->lang->line("waiters");
	  $data['page_title'] = $this->lang->line("waiters");
      $this->load->view('commons/header', $meta);
      $this->load->view('content', $data);
      $this->load->view('commons/footer');
   }
   
   function getdatatableajax()
   {
 
	   $this->load->library('datatables');
	   $this->datatables
			->select("id, nama, alamat, kontak")
			->from("waiters")
			
			->add_column("Actions", 
			"<center>			<a class=\"tip\" title='".$this->lang->line("edit_customer")."' href='index.php?module=waiters&amp;view=edit&amp;id=$1'><i class=\"icon-edit\"></i></a>
							    <a class=\"tip\" title='".$this->lang->line("delete_customer")."' href='index.php?module=waiters&amp;view=delete&amp;id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_customer') ."')\"><i class=\"icon-remove\"></i></a></center>", "id")
			->unset_column('id');
		
		
	   echo $this->datatables->generate();

   }
	
	function add()
	{
		$groups = array('owner', 'admin', 'salesman');
		if (!$this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=home', 'refresh');
		}	
		

		//validate form input
		$this->form_validation->set_rules('name', $this->lang->line("name"), 'required|xss_clean');
		$this->form_validation->set_rules('address', $this->lang->line("address"), 'required|xss_clean');
		$this->form_validation->set_rules('phone', $this->lang->line("phone"), 'required|xss_clean|min_length[9]|max_length[16]');


		
		if ($this->form_validation->run() == true)
		{

			$data = array('name' => $this->input->post('name'),
				'address' => $this->input->post('address'),
				'phone' => $this->input->post('phone')
			);
		}
		
		if ( $this->form_validation->run() == true && $this->waiters_model->addCustomer($data))
		{ //check to see if we are creating the customer
			//redirect them back to the admin page
			$this->session->set_flashdata('success_message', $this->lang->line("customer_added"));
			redirect("module=waiters", 'refresh');
		}
		else
		{ //display the create customer form
			//set the flash data error message if there is one
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

			$data['name'] = array('name' => 'name',
				'id' => 'name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('name'),
			);
			$data['address'] = array('name' => 'address',
				'id' => 'address',
				'type' => 'text',
				'value' => $this->form_validation->set_value('address'),
			);
			$data['phone'] = array('name' => 'phone',
				'id' => 'phone',
				'type' => 'text',
				'value' => $this->form_validation->set_value('phone'),
			);
			
			
		$meta['page_title'] = 'Tambah Waiters Baru';
		$data['page_title'] = 'Tambah Waiters Baru';
		$this->load->view('commons/header', $meta);
		$this->load->view('add', $data);
		$this->load->view('commons/footer');
		
		}
	}
	
	function edit($id = NULL)
	{
		if($this->input->get('id')) { $id = $this->input->get('id'); }
		$groups = array('owner', 'admin', 'salesman');
		if (!$this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=home', 'refresh');
		}
		

		//validate form input
		$this->form_validation->set_rules('name', $this->lang->line("name"), 'required|xss_clean');
		$this->form_validation->set_rules('address', $this->lang->line("address"), 'required|xss_clean');
		$this->form_validation->set_rules('phone', $this->lang->line("phone"), 'required|xss_clean|min_length[9]|max_length[16]');
		
		if ($this->form_validation->run() == true)
		{

			$data = array('name' => $this->input->post('name'),
				'address' => $this->input->post('address'),
				'phone' => $this->input->post('phone')
			);
		}
		
		if ( $this->form_validation->run() == true && $this->waiters_model->updateCustomer($id, $data))
		{ 
			$this->session->set_flashdata('success_message', $this->lang->line("customer_updated"));
			redirect("module=waiters", 'refresh');
		}
		else
		{ 
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

		$data['customer'] = $this->waiters_model->getCustomerByID($id);
		
		$meta['page_title'] = 'Update Waiters';
		$data['id'] = $id;
		$data['page_title'] ='Update Waiters';
		$this->load->view('commons/header', $meta);
		$this->load->view('edit', $data);
		$this->load->view('commons/footer');
		
		}
	}
	
	
	function add_by_csv()
	{
		
		$groups = array('owner', 'admin');
		if (!$this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=products', 'refresh');
		}
			
		$this->form_validation->set_rules('userfile', $this->lang->line("upload_file"), 'xss_clean');
		 
		if ($this->form_validation->run() == true)
		{
			
		if (DEMO) {
			$this->session->set_flashdata('message', $this->lang->line("disabled_in_demo"));
			redirect('module=home', 'refresh');
		}
		
		if ( isset($_FILES["userfile"])) /*if($_FILES['userfile']['size'] > 0)*/
		{
				
		$this->load->library('upload');
		
		$config['upload_path'] = 'assets/uploads/csv/'; 
		$config['allowed_types'] = 'csv'; 
		$config['max_size'] = '200';
		$config['overwrite'] = TRUE; 
		
			$this->upload->initialize($config);
			
			if( ! $this->upload->do_upload()){
			
				$error = $this->upload->display_errors();
				$this->session->set_flashdata('message', $error);
				redirect("module=suppliers&view=add_by_csv", 'refresh');
			} 
		
		$csv = $this->upload->file_name;
		
		$arrResult = array();
			$handle = fopen("assets/uploads/csv/".$csv, "r");
			if( $handle ) {
			while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$arrResult[] = $row;
			}
			fclose($handle);
			}
			$titles = array_shift($arrResult);
			
			$keys = array('name', 'email', 'phone', 'company', 'address', 'city', 'state', 'postal_code', 'country');
			
			$final = array();
					
					foreach ( $arrResult as $key => $value ) {
								$final[] = array_combine($keys, $value);
					}
			$rw = 2;
			foreach($final as $csv) {
				if($this->waiters_model->getCustomerByEmail($csv['email'])) {
						$this->session->set_flashdata('message', $this->lang->line("check_customer_email")." (".$csv['email']."). ".$this->lang->line("customer_already_exist")." ".$this->lang->line("line_no")." ".$rw);
						redirect("module=waiters&view=add_by_csv", 'refresh');
					}
				$rw++;
			}
		} 

		$final = $this->mres($final);
		//$data['final'] = $final;
		}
	
		if ( $this->form_validation->run() == true && $this->waiters_model->add_waiters($final))
		{ 
			$this->session->set_flashdata('success_message', $this->lang->line("waiters_added"));
			redirect('module=waiters', 'refresh');
		}
		else
		{  
		
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			
			$data['userfile'] = array('name' => 'userfile',
				'id' => 'userfile',
				'type' => 'text',
				'value' => $this->form_validation->set_value('userfile')
			);

		$meta['page_title'] = $this->lang->line("add_waiters_by_csv");
		$data['page_title'] = $this->lang->line("add_waiters_by_csv");
		$this->load->view('commons/header', $meta);
		$this->load->view('add_by_csv', $data);
		$this->load->view('commons/footer');
		
		}

	}
	
	function delete($id = NULL)
	{
		if (DEMO) {
			$this->session->set_flashdata('message', $this->lang->line("disabled_in_demo"));
			redirect('module=home', 'refresh');
		}
		
		if($this->input->get('id')) { $id = $this->input->get('id'); }
		if (!$this->ion_auth->in_group('owner'))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=home', 'refresh');
		}
		
		if ( $this->waiters_model->deleteCustomer($id) )
		{ 
			$this->session->set_flashdata('success_message', $this->lang->line("customer_deleted"));
			redirect("module=waiters", 'refresh');
		}
		
	}
	
	function mres($q) {
		if(is_array($q))
			foreach($q as $k => $v)
				$q[$k] = $this->mres($v); //recursive
		elseif(is_string($q))
			$q = mysql_real_escape_string($q);
		return $q;
	}
	
	function suggestions()
	{
		$term = $this->input->get('term',TRUE);
	
		if (strlen($term) < 2) break;
	
		$rows = $this->waiters_model->getCustomerNames($term);
	
		$json_array = array();
		foreach ($rows as $row)
			 array_push($json_array, $row->name);
	
		echo json_encode($json_array); 
	}
	
	
}