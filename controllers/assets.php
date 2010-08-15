<?php 
class Assets extends Controller {
	function Assets() {
		parent::Controller();
		$this->cloudauth->sessioninit();
		cloudcrmauth();
		$this->data['page_title'] = 'Home | Dashboard';
		$this->data['nav'] = array('active', '', '', '', '', '', '', '');
		$this->load->library('Customers');
		
		// Auth For Site Center
		$this->authed = FALSE;
		$this->config->load('cloudcrm');
		$users = $this->config->item('ccrmUsers');
		foreach($this->config->item('ccrmUsers') AS $key => $row)
			if(($_SERVER['HTTP_HOST'] == $row['domain']) && ($this->data['me']['UsersEmail'] == $row['email']))
				$this->authed = TRUE;
		if(! $this->authed) exit();
	}
	
	//
	// Css assets
	//
	function css()
	{
		header('content-type: text/css');
		$this->load->view('cloudcrm-assets/dataTables_table_jui.css');
		$this->load->view('cloudcrm-assets/cloudcrm.css');
	}
	
	//
	// Javascript assets
	//
	function javascript()
	{
		header('content-type: text/javascript');
		$this->load->view('cloudcrm-assets/cloudcrm.js');
		$this->load->view('cloudcrm-assets/jquery.dataTables.min.js');
	}
}
?>