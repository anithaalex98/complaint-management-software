<?php
ob_start();
	include('admin_dashboard_menu.php');
	include('connectivity.php');

	$sr_no = 1;
	$user_name = null;
	$first_name = null;
	$middle_name = null;
	$last_name = null;
	$name = null;
	$email = null;
	$gender = null;
?>

<html>
	<head>
		<title>CMS | View Users</title>
		<link rel="stylesheet" type="text/css" href="css/c_dashboard.css">
	</head>
	<body>
		<form action="" method="POST">
			<br><h1 style="float:left;font-size:40px;text-decoration:underline;color:#003366;margin:2px 5px 5px 15px;">Dashboard</h1><br>
			<table width=90% class="complist">
				<tr>
					<th colspan="5">User List</th>
				</tr>
				<tr>
					<th  class="lb">Sr. No.</th>
					<th  class="lb">User Name</th>
					<th  class="lb">Name</th>
					<th  class="lb">Email</th>
					<th  class="lb">Gender</th>
				</tr>
					<?php

						$sql = "SELECT * FROM users WHERE user_type='customer' order by user_id desc";

						$result = mysqli_query($conn,$sql);
						$count = mysqli_num_rows($result);
						if($count>0)
						{
							while($row = mysqli_fetch_array($result))
							{
								$user_name = $row['user_name'];
								$first_name = $row['first_name'];
								$middle_name = $row['middle_name'];
								$last_name = $row['last_name'];
								$email = $row['email'];
								$gender = $row['gender'];

								$name = $first_name." ".$middle_name." ".$last_name;

								echo '<tr>';
								echo '<td><span>'.$sr_no.'</span></td>';
								echo '<td><span>'.$user_name.'</span></td>';
								echo '<td><span>'.$first_name.'</span></td>';
								echo '<td><span>'.$email.'</span></td>';
								echo '<td><span>'.$gender.'</span></td>';
								echo '</tr>';								

								$sr_no=$sr_no+1;
							}	
						}
						else
						{
							echo '<script type="text/javascript">alert("Could not load data. ".mysqli_error($conn))</script>';
						}	
					?>
			</table>	
		</form>
	</body>
</html>
<?php
	ob_end_flush();
?>