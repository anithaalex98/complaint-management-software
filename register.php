<?php
	include('connectivity.php');
?>
<html>
	<head>
		<title>CMS | Registration Page</title>
		<link rel="stylesheet" type="text/css" href="css/register_page.css">
		<script type="text/javascript" src="js/validate.js"></script>
		<meta charset="UTF-8">
	</head>	
	<body>
		<form action="" method="POST" enctype="multipart/form-data">			
			<table width=60% height=100%>
				<tr>
					<th colspan=3><img src="css/img/heading.png" alt="logo" style="width:20%;display:inline;float:left;margin:0 20px 10px 12px;border:2px solid #1a4775;">&nbsp;&nbsp;&nbsp;
					<h3 style="font-size:40px;color:#003366;float:left;margin:50px 0px 10px 10px;border-bottom:2px solid #000066;">Register Here</h3></th>
				</tr>
				<tr>
					<td colspan=3><marquee scrollamount="3" style="font-size:15px;color:#1d75ce;float:left;margin:5px 2px 5px 2px;border-bottom:2px solid #000066;">Fields marked as (*) are compulsory. Please provide correct detials.</marquee></td>
				</tr>
				<tr>
					<td colspan=3>Name <span style="color:red;">*</span>
					&nbsp;&nbsp;<input type="text" name="userfnm" class="textbox" placeholder="First name" value="<?php if(isset($_POST['userfnm'])) echo $_POST['userfnm'];?>" required>
					&nbsp;&nbsp;<input type="text" name="usermnm" class="textbox" placeholder="Middle name" value="<?php if(isset($_POST['usermnm'])) echo $_POST['usermnm'];?>">
					&nbsp;&nbsp;<input type="text" name="userlnm" class="textbox" placeholder="Last name" value="<?php if(isset($_POST['userlnm'])) echo $_POST['userlnm'];?>" required></td>
				</tr>
				
				<tr>
					<td colspan=3>Email ID <span style="color:red;">*</span>&nbsp;&nbsp;<input type="email" name="useremail" class="textbox" id="email" placeholder="ex:myname@example.com" onchange="return validateemail();" value="<?php if(isset($_POST['useremail'])) echo $_POST['useremail'];?>" required>&nbsp;&nbsp;<span id="emailcheck" style="font-size:12px;color:red;"></span></td>
				</tr>
				<tr>
					<td colspan=3>User Name <span style="color:red;">*</span> &nbsp;&nbsp;<input type="text" name="usernm" class="textbox" placeholder="ex:myname_123" value="<?php if(isset($_POST['usernm'])) echo $_POST['usernm'];?>" required>&nbsp;&nbsp;<span id="usernmcheck" style="font-size:12px;color:red;"></span></td>
				</tr>
				<tr>
					<td>Password <span style="color:red;">*</span> &nbsp;&nbsp;<input type="password" name="userpass" class="textbox" id="pass" placeholder="Enter Password" onchange="return validatepass();" required><br/><br/><span id="passcheck" style="font-size:12px;color:red;"></span></td>
					<td>Confirm Password <span style="color:red;">*</span> &nbsp;&nbsp;<input type="password" name="usercpass" class="textbox" id="confirmpass" placeholder="Confirm Password" onchange="return validatecpass();" required><br/><br/><span id="cpasscheck" style="font-size:12px;color:red;"></span></td>
				</tr>
				
				<tr>
					<td colspan=3>Gender:&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="gender" value="male" checked>Male&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="gender" value="female">Female&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="gender" value="other">Other</td>
				</tr>
				<tr>
					<td colspan=3>Upload Picture &nbsp;&nbsp;<input type="file" accept="image/jpg, image/jpeg, image/png" name="profilepic" id="profilepic"></td>
				</tr>
				<tr>
					<td colspan=3><input type="submit" name="submit" value="SIGN UP" class="button"><input type="reset" value="RESET" class="button"></td>
				</tr>
				<tr>
					<td colspan=3><div class="tologin">
				<h4>Already have an account? <a href="login.php">Sign in</a></h4></td>
			</div></td></tr>
			</table>	
		</form>		
	</body>
<html>

<?php
	
	if(isset($_POST['submit']))
	{
		$firstnm = $_POST['userfnm'];
		if(isset($_POST['usermnm'])){$middlenm = $_POST['usermnm'];}
		else {$middlenm = null;}
		$lastnm = $_POST['userlnm'];
		$usernm = $_POST['usernm'];
		$userpass = $_POST['userpass'];
		$email = $_POST['useremail'];
		$gender = $_POST['gender'];
		$db_usernm = null;
		$db_useremail = null;
		
		$sql1 = "SELECT user_name, email FROM users WHERE user_name='".$usernm."' OR email='".$email."'";
		$result1 = mysqli_query($conn,$sql1);
		$count = mysqli_num_rows($result1);
		if($count>0)
		{
			while($row1 = mysqli_fetch_array($result1))
			{
				$db_usernm = $row1["user_name"];
				$db_useremail = $row1["email"];
			
				if(strcmp($email,$db_useremail)==0)
				{
					echo '<script type="text/javascript">document.getElementById("emailcheck").innerHTML="This Email ID is already in use."</script>';
				}
				else if(strcmp($usernm,$db_usernm)==0)
				{
					echo '<script type="text/javascript">document.getElementById("usernmcheck").innerHTML="This Username is already in use, please try another username."</script>';
				}
			}
		}
		else
		{
			move_uploaded_file($_FILES['profilepic']['tmp_name'],"profile/".$_FILES['profilepic']['name']);
			$profile = $_FILES['profilepic']['name'];
			$sql2="INSERT INTO users(first_name, middle_name, last_name, email, user_name, password, gender, profile) VALUES ('".$firstnm."','".$middlenm."','".$lastnm."','".$email."','".$usernm."','".$userpass."','".$gender."','".$profile."')";
			$result2 = mysqli_query($conn,$sql2);
			if($result2)
			{
				echo '<script type="text/javascript">alert("Registered successfully. Click on Sign IN to Login to your account.")</script>';
			}
			else 
			{
				echo '<script type="text/javascript">alert("Registration not successfull. ".mysqli_error($conn))</script>';
			}
		}
	}
	mysqli_close($conn);
?>