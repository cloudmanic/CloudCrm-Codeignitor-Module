<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta name="robots" content="noindex,nofollow" />
	<title>CloudCrm - <?=$this->config->item('displayname')?></title>
	<link href="<?=base_url()?>assets/css/smoothness/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />
	<link href="<?=site_url('/cloudcrm/assets/css')?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.3/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?=site_url('/cloudcrm/assets/javascript')?>"></script>
</head>
<body>
	<div id="body-wrapper">
		<div id="header">
			<h1><?=$this->config->item('displayname')?></h1>
			<div id="user-nav">
				Hi, <?=$me['UsersFirstName']?> 
				
				<?php /*
				|
				<?=anchor('', 'My Profile')?> |
				<?=anchor('/system/auth/logout', 'Logout')?>
				*/ ?>
			</div>
			<br style="clear: both;" />
			
			<div id="header-div"></div>
		</div>
		
		<?php /*
		<div class="column-200-float top-bump">
		  <?=ui_widget_start()?>
		  	<?=ui_widget_header('Getting Started')?>
		  	<?=ui_widget_container_start()?>
		  		<ul>
		  			<li><?=anchor('/cloudcrm/home', 'Dashboard')?></li>
		  		</ul>
		  	<?=ui_widget_container_end()?>
		  <?=ui_widget_end()?>
		</div>
		 */ ?>