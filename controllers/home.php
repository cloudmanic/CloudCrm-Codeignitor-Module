<?php 
class Home extends Controller {
	function Home() {
		parent::Controller();
		$this->cloudauth->sessioninit();
		$this->config->load('cloudcrm');
		$this->load->library('Customers');
		$this->data['page_title'] = 'Home | Dashboard';
		$this->data['nav'] = array('active', '', '', '', '', '', '', '');
		
		// Auth For Site Center
		$this->authed = FALSE;
		$users = $this->config->item('ccrmUsers');
		foreach($this->config->item('ccrmUsers') AS $key => $row)
			if(($_SERVER['HTTP_HOST'] == $row['domain']) && ($this->data['me']['UsersEmail'] == $row['email']))
				$this->authed = TRUE;
		if(! $this->authed) exit();
	}
	
	//
	// Index
	//
	function index()
	{
		$this->data['customers'] = $this->customers->get();
		foreach($this->data['customers'] AS $key => $row)
			$this->data['datecustomers'][date('Y-n-j', strtotime($row['Config']['accountstart']))][] = $row;
		
		if(isset($this->data['datecustomers'][date('Y-n-j')]))
			$this->data['todaycount'] = count($this->data['datecustomers'][date('Y-n-j')]);
		else
			$this->data['todaycount'] = 0;

		$this->load->view('cloudcrm-template/app-header', $this->data);		
		$this->load->view('cloudcrm-home/home', $this->data);
		$this->load->view('cloudcrm-template/app-footer', $this->data);
	}
}
?>