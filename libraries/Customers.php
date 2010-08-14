<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customers {
	function Customers()
	{
		$this->CI =& get_instance();
		$this->CI->load->dbutil();
		$this->dbprefix = 'skyledger_';
	}
	
	//
	// This will migrate all the databases.
	//
	function migrate()
	{
		$this->_loop_dbs('_migrate');		
	}
	
	//
	// Get all customers.
	//
	function get()
	{
		$this->_loop_dbs('_get');
		return $this->customers;
	}
	
	// --------- Private Helper Functions ----------- //
	
	//
	// This function will set the account owners.
	//
	function _get()
	{
		foreach($this->db->get('Config')->result_array() AS $key => $row)
			$config[$row['ConfigName']] = $row['ConfigData'];
			
		if(! isset($config['accountowner']))
			$this->_migrate();
		
		// Add account start
		if(! isset($config['accountstart'])) {
			$data['ConfigName'] = 'accountstart';
			$data['ConfigData'] = date('Y-n-j G:i:s');
			$this->db->insert('Config', $data);
			$config['accountstart'] = $data['ConfigData'];
		}

		// Add Click Track
		if(! isset($config['clicktrack'])) {
			$data['ConfigName'] = 'clicktrack';
			$data['ConfigData'] = '';
			$this->db->insert('Config', $data);
			$config['clicktrack'] = '';
		}
		
		if(! $owner = $this->CI->users_model->get_by_id($config['accountowner'])) {
			$this->_migrate();
			$owner = $this->CI->users_model->get_by_id($config['accountowner']);
		}
			
		$owner['Config'] = $config;
		
		// Get page view count
		$owner['PageTrackerCount'] = $this->db->count_all('PageTracker');
		$this->customers[] = $owner;
	}
	
	//
	// This function will migrate all db's
	//
	function _migrate()
	{
		file_get_contents("https://$this->url.skyledger.com");
	}
	
	//
	// Private Function to loop through the different databases.
	//
	function _loop_dbs($method)
	{
		$this->databases = $this->CI->dbutil->list_databases(); 
			
		foreach($this->databases AS $key => $row)
		{
			if(substr($row, 0, 10) !== $this->dbprefix) continue;
			if($row == $this->dbprefix . 'blog') continue;
			if($row == $this->dbprefix . 'www') continue;	
			$this->url = str_ireplace($this->dbprefix, '', $row);		
			$db['hostname'] = $this->CI->db->hostname;
			$db['username'] = $this->CI->db->username;
			$db['password'] = $this->CI->db->password;
			$db['database'] = $row;
			$db['dbdriver'] = "mysql";
			$db['dbprefix'] = "";
			$db['pconnect'] = TRUE;
			$db['db_debug'] = TRUE;
			$db['cache_on'] = FALSE;
			$db['cachedir'] = "";
			$db['char_set'] = "utf8";
			$db['dbcollat'] = "utf8_general_ci";
			//echo $row . "<br />";
			$this->db = $this->CI->load->database($db, TRUE, TRUE);
			
			// Run Method
			$this->$method();
		}
	}
}
?>
