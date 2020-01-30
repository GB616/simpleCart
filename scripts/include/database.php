<?php	
$config = require_once 'config.php';

try{
	$db = new PDO("mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}", $config['user'], $config['password'], [PDO::ATTR_EMULATE_PREPARES => false, 
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
}
catch(PDOException $e){
	echo "Error while conneting with database: " .  $e;
	exit('Database error');
}