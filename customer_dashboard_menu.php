<?php
	include('connectivity.php');
?>

<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/customer_dashboard.css">
		<script type="text/javascript">
			function imgError(image) 
			{
				image.onerror = "";
				image.src = "profile/default.jpg";
				return true;
			}
		</script>
		<style>
			.menu 
			{
			  position: fixed; 
			  top: 70px;
			  width: 100%;
			  height: 80px;
			  background-color: #d4dad4;
			  border-width: 2px;
			  padding: 20px 10px 2px 15px;
			}
			
		</style>
	</head>
	<body class="bg">
		
		<table width=100%>
			<tr>
				<td colspan=2 width=100% style="top:0;border-bottom:1px solid #000066;position:fixed;background-color:#c3c7c3;"><img src="css/img/heading.png" alt="logo" style="width:5%;display:inline;float:right;margin:3px 90px 5px 100px;border:2px solid #1a4775;">
										 <h1 style="font-size:20px;color:#003366;float:right;margin:20px 5px 0px 400px;border-bottom:2px solid #000066;">A Complaint Management Software</h1>
				</td>
			</tr>
		</table>
		<table width=100% style="margin:180px 5px 5px 5px;">	
			<tr>
				<td>
					<?php 
						session_start();
						$sql1 = "SELECT first_name, middle_name, last_name, profile, email, user_name FROM users WHERE user_name='".$_SESSION['uname']."'";
						$result1 = mysqli_query($conn,$sql1);
						$row1 = mysqli_fetch_array($result1);
						echo '<div id="profilediv">';
						echo '<img src="profile/'.$row1['profile'].'"alt="profile pic" onerror="imgError(this);" style="width:80px;height:80px;display:block;float:left;margin:5px 30px 10px 40px;border:2px solid #1a4775;">';
						echo '<p style="font-weight:bolder;font-size:20px;color:#003366;float:left;margin:40px 0px 0px 0px;">'.$row1['first_name'].' '.$row1['middle_name'].' '.$row1['last_name'].'</p>';
						echo '<p style="font-size:20px;color:#003366;float:left;margin:40px 0px 0px 50px;">'.$row1['email'].'</p>';
						echo '<p style="font-size:20px;color:#003366;float:left;margin:40px 0px 0px 100px;">'.$row1['user_name'].'</p>';
						echo '</div>';
					?>
				</td>
			</tr>
		</table>
			<hr>
			<div class="menu">
				<td colspan=4 width=40%><a href="customer_dashboard.php">Dashboard</a>
				<a href="register_ticket.php">Register Complaint</a>
				<a href="change_password.php">Change Password</a>
				<a href="logout.php">Logout</a></td>
			</div>
	</body>
</html>