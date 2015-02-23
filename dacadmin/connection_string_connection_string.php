<?php



// Database login vars
//private $dbHostname = '173.254.88.36';
 $dbHostname = 'localhost';
 $dbDatabase = 'feucvt_bed_aes';
//private $dbUsername = 'czardoxc_x3pops';
 $dbUsername = 'root';
//private $dbPassword = 'BulkanNga112427';
 $dbPassword = 'dacamon';
	
	
	try
	{
		$dbh = new PDO("mysql:host=$dbHostname;dbname=$dbDatabase", $dbUsername, $dbPassword);

		

	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}




?>