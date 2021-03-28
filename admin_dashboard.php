<?php
ob_start();
	include('admin_dashboard_menu.php');
	include('connectivity.php');

	$comp_id = null;
	$user_id = null;
	$user_name = null;
	$title = null;
	$cat_id = null;
	$cat_nm =null;
	$subcat_id = null;
	$subcat_nm = null;
	$comptype_id = null;
	$comptype_nm = null;
	$date = null;
	$status = null;
?>

<html>
	<head>
		<title>CMS | Admin Dashboard</title>
		<link rel="stylesheet" type="text/css" href="css/c_dashboard.css">
	</head>
	<body>
		<form action="" method="POST">
			<br><h1 style="float:left;font-size:40px;text-decoration:underline;color:#003366;margin:2px 5px 5px 15px;">Dashboard</h1><br><br><br><br>

			<span style="font-size:20px;text-decoration:underline;color:#003366;margin:2px 2px 2px 20px;">Pending</span> - <span style="background-color:#e86969;width:20px;border-style:ridge;border-color:black;border-width:1px;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
			<span style="font-size:20px;text-decoration:underline;color:#003366;margin:2px 2px 2px 20px;">Viewed</span> - <span style="background-color:#f1eb75;width:20px;border-style:ridge;border-color:black;border-width:1px;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
			<span style="font-size:20px;text-decoration:underline;color:#003366;margin:2px 2px 2px 20px;">Assigned</span> - <span style="background-color:#f1944a;width:20px;border-style:ridge;border-color:black;border-width:1px;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
			<span style="font-size:20px;text-decoration:underline;color:#003366;margin:2px 2px 2px 20px;">Responded</span> - <span style="background-color:#8be68b;width:20px;border-style:ridge;border-color:black;border-width:1px;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
			<table width=90% class="complist">
				<tr>
					<th colspan="8">Complaint List</th>
				</tr>
				<tr>
					<th  class="lb">Select to view</th>
					<th  class="lb">Title</th>
					<th  class="lb">Category</th>
					<th  class="lb">Subcategory</th>
					<th  class="lb">Complaint Type</th>
					<th  class="lb">Date & Time of Submission</th>
					<th  class="lb">User Name</th>
					<th  class="lb">Status of Complaint</th>
				</tr>
					<?php

						$sql1 = "SELECT * FROM complaint order by date desc";

						$result1 = mysqli_query($conn,$sql1);
						$count1 = mysqli_num_rows($result1);
						if($count1>0)
						{
							while($row1 = mysqli_fetch_array($result1))
							{
								$comp_id = $row1['comp_id'];
								$user_id = $row1['user_id'];
								$title = $row1['complaint_title'];
								$cat_id = $row1['cat_id'];
								$subcat_id = $row1['sub_cat_id'];
								$comptype_id = $row1['comp_type_id'];
								$date = $row1['date'];
								$status = $row1['status'];

								$sql2 = "SELECT category.cat_name FROM category,complaint WHERE category.cat_id=complaint.cat_id AND complaint.comp_id ='".$comp_id."'";
								$result2 = mysqli_query($conn,$sql2);
								$count2 = mysqli_num_rows($result2);
								if($count2>0)
								{
									while($row2 = mysqli_fetch_array($result2))
									{
										$cat_nm = $row2['cat_name'];
									}
								}

								$sql3 = "SELECT sub_category.sub_cat_name FROM sub_category,complaint WHERE sub_category.sub_cat_id='".$subcat_id."' AND complaint.comp_id ='".$comp_id."' AND complaint.sub_cat_id IS NOT NULL";
								if($subcat_id=="")
								{
									$subcat_nm = "No Value";
								}
								else
								{
									$result3 = mysqli_query($conn,$sql3);
									$count3 = mysqli_num_rows($result3);
									if($count3>0)
									{
										while($row3 = mysqli_fetch_array($result3))
										{
											$subcat_nm = $row3['sub_cat_name'];
										}
									}
								}

								$sql4 = "SELECT complaint_type.comp_type_title FROM complaint_type,complaint WHERE complaint_type.comp_type_id=complaint.comp_type_id AND complaint.comp_id ='".$comp_id."'";
								$result4 = mysqli_query($conn,$sql4);
								$count4 = mysqli_num_rows($result4);
								if($count4>0)
								{
									while($row4 = mysqli_fetch_array($result4))
									{
										$comptype_nm = $row4['comp_type_title'];
									}
								}

								$sql5 = "SELECT user_name FROM users WHERE user_id ='".$user_id."'";
								$result5 = mysqli_query($conn,$sql5);
								$count5 = mysqli_num_rows($result5);
								if($count5>0)
								{
									while($row5 = mysqli_fetch_array($result5))
									{
										$user_name = $row5['user_name'];
									}
								}

								echo '<tr>';
								echo '<td><input type="radio" id="complaint" name="complaint" value='.$comp_id.'></td>';
								echo '<td><span id="ctitle">'.$title.'</span></td>';
								echo '<td><span id="ccat">'.$cat_nm.'</span></td>';
								echo '<td><span id="csubcat">'.$subcat_nm.'</span></td>';
								echo '<td><span id="ctype">'.$comptype_nm.'</span></td>';
								echo '<td><span id="cdate">'.$date.'</span></td>';
								echo '<td><span id="cdate">'.$user_name.'</span></td>';
								if($status=="Viewed")
								{
									echo '<td style="background-color:#f1eb75;"><span id="cstatus">'.$status.'</span></td>';
								}
								else if($status=="Assigned")
								{
									echo '<td style="background-color:#f1944a;"><span id="cstatus">'.$status.'</span></td>';
								}
								else if($status=="Responded")
								{
									echo '<td style="background-color:#8be68b;"><span id="cstatus">'.$status.'</span></td>';
								}
								else
								{
									echo '<td style="background-color:#e86969;"><span id="cstatus" >Pending</span></td>';
								}
								echo '</tr>';
							}	
						}
						else
						{
							echo '<script type="text/javascript">alert("Could not load data. ".mysqli_error($conn))</script>';
						}	
					?>				
						<tr>
							<td colspan="8">
								<input type="submit" name="view" id="view" value="View" class="button">
							</td>
						</tr>
			</table>	
		</form>
	</body>
</html>

<?php
	if(isset($_POST['view']))
	{
		if(isset($_POST['complaint']))
		{
			$_SESSION['complaint_id'] = $_POST['complaint'];
			$sql7 = "SELECT status FROM complaint WHERE comp_id='".$_SESSION['complaint_id']."'";
			$result7 = mysqli_query($conn,$sql7);
			$count7 = mysqli_num_rows($result7);
			if($count7>0)
			{
				while ($row7 = mysqli_fetch_array($result7)) 
				{
					$status = $row7['status'];
				}
			}
			if(isset($_POST['view']))
			{
				if($status=="Submitted")
				{
					$sql6 = "UPDATE complaint SET status ='Viewed' WHERE comp_id='".$_SESSION['complaint_id']."'";
					$result6 = mysqli_query($conn,$sql6);	
				}
				header("Location:manage_complaint.php");
			}
		}
		else
		{
			echo '<script type="text/javascript">alert("Select a Complaint first.")</script>';
		}
	}
ob_end_flush();
?>