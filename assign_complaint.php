<?php
	include('admin_dashboard_menu.php');
	include('connectivity.php');

	$dept_id = null;
	$dept_name = null;
	$emp_id = null;
	$emp_name = null;
?>

<html>
	<head>
		<title>CMS | Assign Complaint</title>
		<link rel="stylesheet" type="text/css" href="css/ticket.css">
		<script type="text/javascript">
			function checksub()
			{	
					var x = document.getElementById("subcat").disabled = true;
					//var y = document.getElementById("subcatd").disabled = true;
			}
		</script>
	</head>
<body>
	<form action="" method="POST">	
		<table table width=80% class="tickettab">
			<tr>
				<th colspan="2">Assign Complaint</th>
			</tr>
			<tr>
					<td class="lb" style="text-align:right;">Select Department<span style="color:red;">*</span></td>
					<td class="ct">&nbsp;&nbsp;<select name="dept" id="cat" onChange="checksub();">
						<?php 
							
							$sql2a = "SELECT * FROM department";
							$result2a = mysqli_query($conn,$sql2a);
							$count2a = mysqli_num_rows($result2a);
							if($count2a>0)
							{
								while($row2a = mysqli_fetch_array($result2a))
								{
									$dept_id = $row2a['dept_id'];
									$dept_name = $row2a['dept_name'];
									echo '<option value="'.$dept_id.'">'.$dept_name.'</option>';
								}
							}
							else
							{
								echo '<option value="default" selected>No Value</option>';
								echo '<script type="text/javascript">alert("Failed to update complaint status. ".mysqli_error($conn))</script>';
							}
						?>
						</select>
						<input type="submit" value="Go" name="Go" class="buttona"> <span style="color:red;">*Select Department and Click here</span>
					</td>
					<script type="text/javascript">
						document.getElementById('cat').value = "<?php echo $_POST['dept'];?>";
					</script>					
				</tr>
					<?php
						if(isset($_POST['Go']) || isset($_POST['submit']))
						{

					?>
				<tr>
					<td class="lb" style="text-align:right;">Select Employee to Assign Complaint<span style="color:red;">*</span></td>
					
					<td class="ct">&nbsp;&nbsp;
					<?php 
							
							
								$dept_id = $_POST['dept'];

								$sql3a = "SELECT emp_id, emp_name FROM employee WHERE dept_id='".$dept_id."'";
								$result3a = mysqli_query($conn,$sql3a);
								$count3a = mysqli_num_rows($result3a);
								if($count3a>0)
								{
									echo '<select name="emp" id="subcat" required>';

									while($row3a = mysqli_fetch_array($result3a))
									{
										
										$emp_id = $row3a['emp_id'];
										$emp_name = $row3a['emp_name'];
										echo '<option value="'.$emp_id.'">'.$emp_name.'</option>';
														
									}
									echo "</select>";
								}
								else
								{
									echo '<select name="subcat" id="subcat">';
									echo '<option value="empty" selected>No Value</option>';
									echo '</select>';
									echo '<script type="text/javascript">alert("Failed to update complaint status. ".mysqli_error($conn))</script>';
								}
							
								
					?>	
					</td>
					<script type="text/javascript">
						document.getElementById('subcat').value = "<?php echo $_POST['emp'];?>";
					</script>
				</tr>
				<tr>
					<td colspan="2" class="buttons">
						<input type="submit" name="submit" value="Submit" class="button">
					</td>
				</tr>
				<?php
					}
				?>
		</table>
	</form>
</body>
</html>

<?php
	if(isset($_POST['submit']))
	{
		if(isset($_POST['emp']))
		{
			$sql6a = "UPDATE complaint SET emp_id ='".$_POST['emp']."' WHERE comp_id='".$_SESSION['complaint_id']."'";
			$result6a = mysqli_query($conn,$sql6a);
			if($result6a)
			{
				$sql6b = "UPDATE complaint SET status ='Assigned' WHERE comp_id='".$_SESSION['complaint_id']."'";
				$result6b = mysqli_query($conn,$sql6b);
				if($result6b)
				{
					header("Location:admin_dashboard.php");
				}
			}
			else
			{
				echo '<script type="text/javascript">alert("Failed to submit.Select Department and Employee details properly.")</script>';
			}
		}
		else
		{
			echo '<script type="text/javascript">alert("Failed to submit.Select Department and Employee details properly.")</script>';
		}
	}
?>