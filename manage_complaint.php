<?php
ob_start();
	include('admin_dashboard_menu.php');
	include('connectivity.php');

	$comp_id = $_SESSION['complaint_id'];
	$title = null;
	$description = null;
	$cat_id = null;
	$cat_nm =null;
	$subcat_id = null;
	$subcat_nm = null;
	$comptype_id = null;
	$comptype_nm = null;
	$date = null;
	$status = null;
	$emp_id = null;
	$emp_name = null;
	$emp_email = null;
	$dept_id = null;
	$dept_name = null; 
	$response = null;

	$sql1 = "SELECT * FROM complaint WHERE complaint.comp_id='".$comp_id."'";

	$result1 = mysqli_query($conn,$sql1);
	$count1 = mysqli_num_rows($result1);
	if($count1>0)
	{
		while($row1 = mysqli_fetch_array($result1))
		{
			$title = $row1['complaint_title'];
			$description = $row1['description'];
			$cat_id = $row1['cat_id'];
			$subcat_id = $row1['sub_cat_id'];
			$comptype_id = $row1['comp_type_id'];
			$date = $row1['date'];
			$status = $row1['status'];
			$emp_id = $row1['emp_id'];
			$response = $row1['response'];

			if($row1["screenshot"]==null)
			{
				$screenshot = "";
			}
			else
			{
				$screenshot =  "img/complaint_screenshots/".$row1["screenshot"];	
			}

		}

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

		if($response==null && $emp_id!=null)
		{
			$sql5 = "SELECT * FROM employee WHERE emp_id ='".$emp_id."'";
			$result5 = mysqli_query($conn,$sql5);
			$count5 = mysqli_num_rows($result5);
			if($count5>0)
			{
				while($row5 = mysqli_fetch_array($result5))
				{
					$emp_name = $row5['emp_name'];
					$emp_email = $row5['emp_email'];
					$dept_id = $row5['dept_id'];

					$sql5a = "SELECT * FROM department WHERE dept_id ='".$dept_id."'";
					$result5a = mysqli_query($conn,$sql5a);
					$count5a = mysqli_num_rows($result5a);
					if($count5a>0)
					{
						while($row5a = mysqli_fetch_array($result5a))
						{
							$dept_name = $row5a['dept_name'];
						}
					}
				}
			}
		}
	}
	else
	{
		echo '<script type="text/javascript">alert("Error fetching form. ".mysqli_error($conn))</script>';
	}

?>

<html>
	<head>
		<title>CMS | View & Manage Complaints</title>
		<link rel="stylesheet" type="text/css" href="css/ticket.css">
	</head>
	<body>
		<form action="" method="POST" enctype="multipart/form-data">
			<br><h1 style="float:left;font-size:40px;text-decoration:underline;color:#003366;margin:2px 5px 5px 15px;">View & Manage Selected Complaint</h1><br>
			<table width=80% class="tickettab">
				<tr>
					<th colspan="2">Complaint Form</th>
				</tr>
				
				<tr>
					<td style="text-align:right;" class="lb">Category for Products or Services</td>
					<td class="ct">&nbsp;&nbsp;
						<input style="background-color:white;border-color:black;border-width:1px;color:black;" type="text" name="ctitle" value="<?php echo $cat_nm; ?>"  class="textbox" id="title" disabled>
					</td>				
				</tr>
				<tr>
					<td style="text-align:right;" class="lb">Subcategory for Products or Services</td>
					<td class="ct">&nbsp;&nbsp;
						<input style="background-color:white;border-color:black;border-width:1px;color:black;" type="text" name="ctitle" value="<?php echo $subcat_nm; ?>"  class="textbox" id="title" disabled>							
					</td>
				</tr>
				<tr>
					<td style="text-align:right;" class="lb">Complaint Type</td>
					<td class="ct">&nbsp;&nbsp;
						<input style="background-color:white;border-color:black;border-width:1px;color:black;" type="text" name="ctitle" value="<?php echo $comptype_nm; ?>"  class="textbox" id="title" disabled>
					</td>
				</tr>	
				<tr>
					<td style="text-align:right;" class="lb">Title</td>
					<td class="ct">&nbsp;&nbsp;
						<input style="background-color:white;border-color:black;border-width:1px;color:black;" type="text" name="ctitle" value="<?php echo $title; ?>"  class="textbox" id="title" disabled>
					</td>
				</tr>
				<tr>
					<td style="text-align:right;" class="lb">Description</td>
					<td class="ct">&nbsp;&nbsp;
						<textarea  style="font-size: 15px;" name="description" cols="50" rows="10" id="desc" readonly><?php echo $description; ?></textarea>
					</td>
				</tr>
				<tr>
					<td style="text-align:right;" class="lb">Screenshot of the Issue</td>
					<td class="ct">&nbsp;&nbsp;
							<?php 
								if($screenshot=="")
								{
									echo '<input style="background-color:white;border-color:black;border-width:1px;color:grey;" type="text" name="ctitle" value="No Image Uploaded"  class="textbox" id="title" disabled>';
								}
								else
								{
									echo '<img src="'.$screenshot.'"alt="screenshot of complaint" style="width:400px;height:400px;display:block;float:left;margin:10px 10px 10px 10px;border:2px solid #1a4775;">';	
								} 
							?>
					</td>
				</tr>
				<tr>
					<td style="text-align:right;" class="lb">Date & Time of Complaint Submission</td>
					<td class="ct">&nbsp;&nbsp;
						<input style="background-color:white;border-color:black;border-width:1px;color:black;" type="text" name="ctitle" value="<?php echo $date; ?>"  class="textbox" id="title" disabled>
					</td>
				<tr>
					<td style="text-align:right;" class="lb">Status of Complaint</td>
					<td class="ct">&nbsp;&nbsp;
						<input style="background-color:white;border-color:black;border-width:1px;color:black;" type="text" name="ctitle" value="<?php echo $status; ?>"  class="textbox" id="title" disabled>
					</td>
				</tr>
				
							<?php 
								if($emp_id=="")
								{
									echo '<tr>';
									echo '<td style="text-align:right;" class="lb">Complaint Assigned To</td>
									<td class="ct">&nbsp;&nbsp;';
									echo '<input style="background-color:white;border-color:black;border-width:1px;color:grey;" type="text" name="ctitle" value="Comlaint is not assigned"  class="textbox" id="title" disabled>';
									echo '</td>';
									echo '</tr>';
								}
								else
								{
									echo '<tr>';
									echo '<td style="text-align:right;" class="lb">Complaint Assigned To:-</td><td></td>';
									echo '<tr>';
									echo '<td style="text-align:right;" class="lb">Department</td>
									<td class="ct">&nbsp;&nbsp;';
									echo '<input style="background-color:white;border-color:black;border-width:1px;color:black;" type="text" name="ctitle" value="'.$dept_name.'"  class="textbox" id="title" disabled>';
									echo '</td>';
									echo '</tr>';
									echo '</tr><tr>';
									echo '<td style="text-align:right;" class="lb">Employee Name</td>
									<td class="ct">&nbsp;&nbsp;';
									echo '<input style="background-color:white;border-color:black;border-width:1px;color:black;" type="text" name="ctitle" value="'.$emp_name.'"  class="textbox" id="title" disabled>';
									echo '</td>';
									echo '</tr>';
									echo '<tr>';
									echo '<td style="text-align:right;" class="lb">Employee Email ID</td>
									<td class="ct">&nbsp;&nbsp;';
									echo '<input style="background-color:white;border-color:black;border-width:1px;color:black;" type="text" name="ctitle" value="'.$emp_email.'"  class="textbox" id="title" disabled>';
									echo '</td>';
									echo '</tr>';
								} 
								if($response=="")
								{
									echo '<tr>';
									echo '<td style="text-align:right;" class="lb">Response</td>
									<td class="ct">&nbsp;&nbsp;';
									echo '<textarea  style="font-size:15px;color:grey;" name="description" cols="50" rows="10" id="desc" readonly>No response.</textarea>';
									echo '</td>';
									echo '</tr>';
								}
								else
								{
									echo '<tr>';
									echo '<td style="text-align:right;" class="lb">Response</td>
									<td class="ct">&nbsp;&nbsp;';
									echo '<textarea  style="font-size: 15px;color:black;" name="description" cols="50" rows="10" id="desc" readonly>'.$response.'</textarea>';
									echo '</td>';
									echo '</tr>';
								}
							?>
					
				<tr>
					<td colspan="2"><input type="submit" name="assign" id="assign" value="Assign" class="button" style="margin:0px 0px 0px 350px;">
						<input type="submit" name="respond" id="respond" value="Respond" class="button" style="margin:0px 0px 0px 0px;">
					</td>
				</tr>
			</table>			
		</form>
	</body>
</html>
<?php
	if(isset($_POST['assign']) && $status!="Responded")
	{
		if($status=="Assigned")
		{
			echo '<script type="text/javascript">alert("You have already assigned this complaint to a department/employee.");</script>';
		}
		else
			header("Location:assign_complaint.php");
	}
	else if(isset($_POST['assign']) && $status=="Responded")
	{
		echo '<script type="text/javascript">alert("You have already responded to this complaint, so you cannot assign this complaint to a department/employee.");</script>';
	}
	
	if(isset($_POST['respond']) && $status!="Assigned")
	{
		if($status=="Responded")
		{
			echo '<script type="text/javascript">alert("You have already responded to this complaint.");</script>';
		}
		else
			header("Location:respond_complaint.php");
	}
	else if(isset($_POST['respond']) && $status=="Assigned")
	{
		echo '<script type="text/javascript">alert("You have already assigned this complaint to a department/employee, so you cannot respond.");</script>';
	}
	ob_end_flush();
?>