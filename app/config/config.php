<?php
	
	////// CONSTANTS //////
	
	//db 
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_NAME', 'qcu_eservice');
	define('DB_CHARSET', 'utf8mb4');

	//paths
	define('APPROOT', dirname(dirname(__FILE__)));
	define('WEBROOT', dirname(dirname(dirname(__FILE__))));
	define('PORT', $_SERVER['SERVER_PORT']);
	define('URLROOT', 'http://localhost:'.PORT.'/qcu-ocad');
	
	//site
	define('SITENAME', 'QCU OCAD');

?>