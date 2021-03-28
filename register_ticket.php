<?php
	include('customer_dashboard_menu.php');
	include('connectivity.php');
	
	$cat_id = null;
	$sub_cat_id = null;
?>

<html>
	<head>
		<title>CMS | Lodge Complaint</title>
		<link rel="stylesheet" type="text/css" href="css/ticket.css">
		<script type="text/javascript">
			function checkcomp()
			{	
				var title = document.getElementById("title").value;
				var desc = document.getElementById("desc").value;

				if(title.length>20)
				{
					document.getElementById("statusval").style.color = "red";
					document.getElementById("statusval").innerHTML = "Title is too long.";
					return false;
				}
				else
				{
					return true;
				}
			}

			function checksub()
			{	
					var x = document.getElementById("subcat").disabled = true;
					//var y = document.getElementById("subcatd").disabled = true;
			}
		</script>
	</head>
	<body>
		<form action="" method="POST" enctype="multipart/form-data">
			<br><h1 style="float:left;font-size:40px;text-decoration:underline;color:#003366;margin:2px 5px 5px 15px;">Lodge New Complaint</h1><br>
			<table width=80% class="tickettab">
				<tr>
					<th colspan="2">Complaint Form</th>
				</tr>
				
				<tr>
					<td class="lb">Category for Products or Services<span style="color:red;">*</span></td>
					<td class="ct"><select name="cat" id="cat" onChange="checksub();">
						<?php 
							
							$sql2 = "SELECT cat_id, cat_name FROM category";
							$result2 = mysqli_query($conn,$sql2);
							$count2 = mysqli_num_rows($result2);
							if($count2>0)
							{
								while($row2 = mysqli_fetch_array($result2))
								{
									$cat_id = $row2['cat_id'];
									echo '<option value="'.$cat_id.'">'.$row2['cat_name'].'</option>';
								}
							}
							else
							{
								echo '<option value="default" selected>No Value</option>';
							}
						?>
						</select>
						<input type="submit" value="Go" name="Go_Category" class="buttona"> <span style="color:red;">*Select Category and Click here</span>
					</td>
					<script type="text/javascript">
						document.getElementById('cat').value = "<?php echo $_POST['cat'];?>";
					</script>					
				</tr>
				
				<tr>
					<?php
							if(isset($_POST['Go_Category']) || isset($_POST['submit']))
							{

					?>
					<td class="lb">Subcategory for Products or Services<span style="color:red;">*</span></td>
					
					<td class="ct">
					<?php 
							
							
								$cat_id = $_POST['cat'];

								$sql3 = "SELECT sub_cat_id, sub_cat_name FROM category, sub_category WHERE sub_category.cat_id='".$cat_id."' AND category.cat_id=sub_category.cat_id";
								$result3 = mysqli_query($conn,$sql3);
								$count3 = mysqli_num_rows($result3);
								if($count3>0)
								{
									echo '<select name="subcat" id="subcat" required>';

									while($row3 = mysqli_fetch_array($result3))
									{
										
										$sub_cat_id = $row3['sub_cat_id'];
										echo '<option value="'.$sub_cat_id.'">'.$row3['sub_cat_name'].'</option>';
														
									}
									echo "</select>";
								}
								else
								{
									echo '<select name="subcat" id="subcat">';
									echo '<option value="empty" selected>No Value</option>';
									echo '</select>';
								}
								
					?>	
					</td>
					<script type="text/javascript">
						document.getElementById('subcat').value = "<?php echo $_POST['subcat'];?>";
					</script>
				</tr>
				<tr><td><br><td></tr>
				<tr>
					<td class="lb">Complaint Type<span style="color:red;">*</span></td>
					<td class="ct"><select name="ctype" id="ctype">
						<?php 
							
							$sql4 = "SELECT comp_type_id, comp_type_title FROM complaint_type";
							$result4 = mysqli_query($conn,$sql4);
							$count4 = mysqli_num_rows($result4);
							if($count4>0)
							{
								while($row4 = mysqli_fetch_array($result4))
								{
									echo '<option value="'.$row4['comp_type_id'].'">'.$row4['comp_type_title'].'</option>';
								}
							}
							else
							{
								echo '<option value="default" selected>No Value</option>';
							}
						?>
						</select>
					</td>
					<script type="text/javascript">
						document.getElementById('ctype').value = "<?php echo $_POST['ctype'];?>";
					</script>
				</tr>	
				<tr>
					<td class="lb">Title<span style="color:red;">*</span></td>
					<td class="ct">
						<input type="text" name="ctitle" value="<?php if(isset($_POST['ctitle'])) echo $_POST['ctitle']; ?>" placeholder="Title that describes your case" class="textbox" id="title" required>
					</td>
				</tr>
				<tr>
					<td class="lb">Description<span style="color:red;">*</span></td>
					<td class="ct">
						<textarea  style="font-size: 15px;" name="description" cols="50" rows="10" placeholder="Describe your case and try to include as much information as you can" id="desc" required><?php if(isset($_POST['description'])) echo $_POST['description']; ?></textarea>
					</td>
				</tr>
				<tr>
					<td class="lb">Screenshot of the Issue(if any)</td>
					<td class="ct">
						<input type="file" accept="image/jpg, image/jpeg, image/png" name="screenshot" id="screenshot">
					</td>
				</tr>
				<tr>
					<td colspan="2" class="buttons">
						<input type="submit" name="submit" value="Submit Complaint" class="button" onClick="return checkcomp();">
					</td>
				</tr>
				<?php
				}
					?>
			</table>

			<div class="cstatus">
				<label style="font-weight:bold;">Status of Complaint</label> <br>
				<span style="text-decoration:underline;" id="statusval"></span>
				<span style="text-decoration:underline;color:red;" id="statuserr"></span>
				<span style="text-decoration:underline;color:#ffa600;" id="statusw"></span>
			</div>
			
		</form>
	</body>
</html>

<?php
	echo '<script type="text/javascript">document.getElementById("statusval").style.color = "#4784c1"</script>';
		echo '<script type="text/javascript">document.getElementById("statusval").innerHTML="Please fill the form first."</script>';

	if(isset($_POST['submit']))
	{
		$cat_id = $_POST['cat'];
		$comp_type = $_POST['ctype'];
		$uid = $_SESSION['uid'];
		$ctitle = $_POST['ctitle'];
		$description = $_POST['description'];
		$screenshot = null;
		$sql5 = null;
		
			move_uploaded_file($_FILES['screenshot']['tmp_name'],"img/complaint_screenshots/".$_FILES['screenshot']['name']);
			$screenshot = $_FILES['screenshot']['name'];
		
		echo '<script type="text/javascript">document.getElementById("statusval").style.color = "#ffa600"</script>';
		echo '<script type="text/javascript">document.getElementById("statusval").innerHTML="Waiting"</script>';

		if(isset($_POST['subcat']) && $_POST['subcat']!="empty")
		{
			$sub_cat_id = $_POST['subcat'];
			$sql5 = "INSERT INTO complaint(user_id, cat_id, sub_cat_id, comp_type_id, complaint_title, description, screenshot, status) VALUES('".$uid."','".$cat_id."','".$sub_cat_id."','".$comp_type."','".$ctitle."','".$description."','".$screenshot."','Submitted')";
		}

		else if($_POST['subcat']=="empty")
		{
			$sql5 = "INSERT INTO complaint(user_id, cat_id, sub_cat_id, comp_type_id, complaint_title, description, screenshot, status) VALUES('".$uid."','".$cat_id."',NULL,'".$comp_type."','".$ctitle."','".$description."','".$screenshot."','Submitted')";
		}
		
		$result5 = mysqli_query($conn,$sql5);
		if($result5)
			{
				echo '<script type="text/javascript">document.getElementById("statusval").style.color = "green"</script>';
				echo '<script type="text/javascript">document.getElementById("statusval").innerHTML="Submitted"</script>';
			}
			else 
			{
				echo '<script type="text/javascript">document.getElementById("statusval").style.color = "red"</script>';
				echo '<script type="text/javascript">document.getElementById("statusval").innerHTML="Failed to Submit'.mysqli_error($conn).'"</script>';
			}
	}

?>