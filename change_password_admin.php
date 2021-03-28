<?php
	include('admin_dashboard_menu.php');
	include('connectivity.php');

	$user_id= $_SESSION['uid'];
	$curr_pass = null;
	$db_pass = null;
	$pass = null;
?>
<html>
	<head>
		<title>CMS | Change Password</title>
		<link rel="stylesheet" type="text/css" href="css/ticket.css">
		<script type="text/javascript" src="js/validate.js"></script>
		<meta charset="UTF-8">
	</head>	
	<body>
		<form action="" method="POST" enctype="multipart/form-data">
		<br><h1 style="float:left;font-size:40px;text-decoration:underline;color:#003366;margin:2px 5px 5px 15px;">Change Password</h1><br>			
			<table width=80% class="tickettab">
				<tr>
					<tr>
					<th colspan="2">Change Password</th>
				</tr>
				</tr>
				<tr>
					<td colspan=2><marquee scrollamount="3" style="font-size:15px;color:#1d75ce;float:left;margin:5px 2px 5px 2px;border-bottom:2px solid #000066;">Fields marked as (*) are compulsory. Please provide correct detials.</marquee></td>
				</tr>
				<tr>
					<td class="lb">
						<span style="font-size:18px;">Change Password:-</span>
					</td>
				</tr>
				<tr>
					<td class="lb" style="text-align:right;">
						<span style="font-size:15px;">Current Password</span><span style="color:red;">*</span>&nbsp;&nbsp;
					</td>
					<td class="ct">
						<input type="password" name="currpass" class="textbox" placeholder="Enter current Password" required>
					</td>
				</tr>
				<tr>
					<td class="lb" style="text-align:right;">
						<span style="font-size:15px;">New Password</span><span style="color:red;">*</span>&nbsp;&nbsp;
					</td>
					<td class="ct">
						<input type="password" name="userpass"  class="textbox" id="pass" placeholder="Enter a new Password" onchange="return validatepass();" required>
						<span id="passcheck" style="font-size:12px;color:red;"></span>
					</td>
				</tr>
				<tr>
					<td class="lb" style="text-align:right;">
						<span style="font-size:15px;">Confirm Password</span><span style="color:red;">*</span>&nbsp;&nbsp;
					</td>
					<td class="ct">
						<input type="password" name="usercpass" class="textbox" id="confirmpass" placeholder="Confirm new Password" onchange="return validatecpass();" required>
						<span id="cpasscheck" style="font-size:12px;color:red;"></span>
					</td>
				</tr>
				<tr>
					<td colspan=2 class="buttons"><input type="submit" name="changepass" value="Change Password" class="button"></td>
				</tr>
			</table>	
		</form>		
	</body>
<html>

<?php
	if(isset($_POST['changepass']))
	{
		if(isset($_POST['currpass']))
		{
			$curr_pass = $_POST['currpass'];

			$sql1 = "SELECT password FROM users WHERE user_id='".$user_id."'";
			$result1 = mysqli_query($conn,$sql1);
			$count = mysqli_num_rows($result1);
			if($count>0)
			{
				while($row1 = mysqli_fetch_array($result1))
				{
					$db_pass = $row1['password'];
				}
			}
			else
			{
				echo '<script type="text/javascript">alert("Failed to get current password from database. ".mysqli_error($conn))</script>';
			}
			
			if($curr_pass!=$db_pass)
			{
				echo '<script type="text/javascript">alert("Incorrect Current Password.")</script>';
			}	
			else
			{
				$pass = $_POST['userpass'];
				$sql1a = "UPDATE users SET password ='".$pass."' WHERE user_id='".$user_id."'";
				$result1a = mysqli_query($conn,$sql1a);
				if($result1a)
				{
					echo '<script type="text/javascript">alert("Password updated Sucessfully.")</script>';
				}
				else
				{
					echo '<script type="text/javascript">alert("Password could not be updated Sucessfully.")</script>';
				}
			}
		}
	}
?>