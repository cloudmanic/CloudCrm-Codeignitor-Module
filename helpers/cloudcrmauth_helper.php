<?php
//
// Make sure this user has permission to be here.
//
if ( ! function_exists('cloudcrmauth'))
{
	function cloudcrmauth()
	{
		$CI =& get_instance();
		$authed = FALSE;
		$users = $CI->config->item('ccrmUsers');
		foreach($CI->config->item('ccrmUsers') AS $key => $row)
			if(($_SERVER['HTTP_HOST'] == $row['domain']) && ($CI->data['me']['UsersEmail'] == $row['email']))
				$authed = TRUE;
		if(! $authed) exit();
	}
}
?>