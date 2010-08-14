<?php
/*
|--------------------------------------------------------------------------
| Approved Users / Config For CloudCrm
|--------------------------------------------------------------------------
|
|
*/
$url = str_ireplace('https://', '', base_url());
$url = str_ireplace('/', '', $url);
$url = explode('.', $url);

$config['ccrmdbprefix'] = $url[1] . '_';
$config['ccrmdomain'] = $url[1] . '.' . $url[2];
$config['ccrmtheme'] = 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.4/themes/smoothness/jquery-ui.css';
$config['ccrmignoreprefix'] = array('www', 'blog', 'company', 'beta', 'alpha', 'charlie');
$config['ccrmUsers'][]	= array('email' => 'spicer@elevationfit.com', 'domain' => 'spicer.' . $config['ccrmdomain']);
$config['ccrmUsers'][]	= array('email' => 'spicer@elevationfit.com', 'domain' => 'dev.' . $config['ccrmdomain']);
$config['ccrmUsers'][]	= array('email' => 'spicer@cloudmanic.com', 'domain' => 'spicer.' . $config['ccrmdomain']);
$config['ccrmUsers'][]	= array('email' => 'spicer@cloudmanic.com', 'domain' => 'dev.' . $config['ccrmdomain']);

// Handle older config schemas
if($config['ccrmdomain'] == 'elevationfit.com') 
	$config['ccrmconfigspacer'] = '_';
else
	$config['ccrmconfigspacer'] = '';
?>