<?php
	$db_server = "localhost";
	$db_user = "root";
	$db_password = "";
	$db_name = "cms";
	
	$conn = mysqli_connect($db_server,$db_user,$db_password,$db_name);
	
	// Check connection
	if(!$conn)
	{
		die("Failed to connect to MySQL: ".mysqli_connect_error());
	}
?>