<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customers {
	function Customers()
	{
		$this->CI =& get_instance();
		$this->CI->load->dbutil();
		$this->dbprefix = $this->CI->config->item('ccrmdbprefix');
		$this->domain = $this->CI->config->item('ccrmdomain');
		$this->prefixignore = $this->CI->config->item('ccrmignoreprefix');
		$this->spacer = $this->CI->config->item('ccrmconfigspacer');
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
			$config[$row['Config' . $this->spacer . 'Name']] = $row['Config' . $this->spacer . 'Data'];
			
		if(! $this->db->table_exists('Users'))
			$this->_migrate();
		
		// Add account Owner
		if(! isset($config['accountowner'])) {
			$data['Config' . $this->spacer . 'Name'] = 'accountowner';
			$data['Config' . $this->spacer . 'Data'] = '1';
			$this->db->insert('Config', $data);
			$config['accountowner'] = $data['Config' . $this->spacer . 'Data'];
		}
		
		// Add account start
		if(! isset($config['accountstart'])) {
			$data['Config' . $this->spacer . 'Name'] = 'accountstart';
			$data['Config' . $this->spacer . 'Data'] = date('Y-n-j G:i:s');
			$this->db->insert('Config', $data);
			$config['accountstart'] = $data['Config' . $this->spacer . 'Data'];
		}

		// Add Click Track
		if(! isset($config['clicktrack'])) {
			$data['Config' . $this->spacer . 'Name'] = 'clicktrack';
			$data['Config' . $this->spacer . 'Data'] = '';
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
		file_get_contents("https://$this->url.$this->domain");
	}
	
	//
	// Private Function to loop through the different databases.
	//
	function _loop_dbs($method)
	{
		$this->databases = $this->CI->dbutil->list_databases(); 	
			
		foreach($this->databases AS $key => $row)
		{
			// Figure out what db's to ignore
			if(substr($row, 0, strlen($this->dbprefix)) !== $this->dbprefix) continue;
			if(isset($this->prefixignore) && is_array($this->prefixignore)) {
				foreach($this->prefixignore AS $key2 => $row2)
					if($row == $this->dbprefix . $row2) continue 2;				
			}
			
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
