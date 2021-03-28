<?php
	session_start();
	if($_SESSION['utype']=="admin")
	{
		header("Location:change_password_admin.php");
	}
	else if($_SESSION['utype']=="customer")
	{
		header("Location:change_password_customer.php");
	}
?>