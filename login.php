<?php
	include('connectivity.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>CMS | Login Page</title>
		<link rel="stylesheet" type="text/css" href="css/login_page.css">
		<script>
			function showpassword()
			{
				var pass = document.getElementById("pass");
				var chckbox = document.getElementById("chckbox");
				if(chckbox.checked == true)
				{
					pass.type= "text";
					//pass.setAttribute("type", "text");
				}
				else
				{
					pass.type= "password";
					//pass.setAttribute("type", "password");
				}
			}
		</script>
	</head>
	<body class="bg">
		<form action="" method="POST">
			
				<div class="logcontent">
					<img src="css/img/heading.png" alt="logo" style="width:150px;display:block;float:left;margin:35px 10px 10px 80px;opacity:100%;border:2px solid #1a4775;"><br/>
					<h1>Login</h1>
					<div class="textbox">
						<input type="text" name="username" placeholder="User Name" id="usernm" value="<?php if(isset($_POST['username'])) echo $_POST['username'];?>" required><br/>
					</div>
					<div class="textbox">
						<input type="password" name="userpass" placeholder="Password" id="pass" required><br/><span id="passcheck" style="float:left;font-size:12px;color:red;"></span>
					</div>
					<br>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" value="showpass" id="chckbox" onClick="showpassword();">Show Password
					<br/><span id="error" style="float:left;font-size:12px;color:red;margin:0 0 0 25px;"></span>
					<br/><input type="submit" name="submit" value="LOGIN" class="button"><br/>
					<h4>Dont have an account? <a href="register.php">SIGN UP</a></h4>
				</div>

		</form>
	</body>
<html>

<?php
	
	if(isset($_POST['submit']))
	{
		$usernm = $_POST['username'];
		$userpass = $_POST['userpass'];
		$db_userid = null;
		$db_usernm = null;
		$db_userpass = null;
		$db_usertype = null;
		
		$sql = "SELECT user_id,user_name, password, user_type FROM users WHERE user_name='".$usernm."'";
		$result = mysqli_query($conn,$sql);
		$count = mysqli_num_rows($result);
		if($count>0)
		{
			while($row = mysqli_fetch_array($result))
			{
				$db_usernm = $row["user_name"];
				$db_userpass = $row["password"];
				$db_usertype = $row["user_type"];

				$db_userid = $row["user_id"];
			}
			if(strcmp($usernm,$db_usernm)==0 && strcmp($userpass,$db_userpass)==0)
			{
				session_start();
				
				$_SESSION['uid'] = $db_userid;

				$_SESSION['uname'] = $db_usernm;
				$_SESSION['utype'] = $db_usertype;
				
				if($_SESSION['utype'] == 'admin')
				{
					header("location:admin_dashboard.php");
				}
				else if($_SESSION['utype'] == 'customer')
				{
					header("location:customer_dashboard.php");
				}
			}
			else 
				if(strcmp($usernm,$db_usernm)==0 && strcmp($userpass,$db_userpass)!==0)
				{
					echo '<script type="text/javascript">document.getElementById("passcheck").innerHTML="Incorrect password" </script>';
				}
		}
		else 
		{
			echo '<script type="text/javascript">document.getElementById("error").innerHTML="Incorrect User Name & Password" </script>';
		}
	}
	mysqli_close($conn);
?>