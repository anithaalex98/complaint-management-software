<?php
	include('admin_dashboard_menu.php');
	include('connectivity.php');

	$response = null;
	$status = null;
?>

<html>
	<head>
		<title>CMS | Repspond To Complaint</title>
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
					<th colspan="2">Respond</th>
				</tr>				
				<tr>
					<td class="lb" style="text-align:right;">Type your response -</td>
					
					<td class="ct">&nbsp;&nbsp;
						<textarea  style="font-size: 15px;" name="response" cols="50" rows="10" id="desc" required=""><?php if(isset($_POST['response'])) echo $_POST['response']; ?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="buttons">
						<input type="submit" name="submit" value="Submit" class="button">
					</td>
				</tr>
		</table>
	</form>
</body>
</html>

<?php
	if(isset($_POST['submit']))
	{
		if(isset($_POST['response']))
		{
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

			if($status=="Responded")
			{
				echo '<script type="text/javascript">alert("Response for this complaint is already submitted. Please, return to the Dashboard.")</script>';
			}
			else
			{	
				$response = $_POST['response'];
				$sql = "UPDATE complaint SET response ='".$response."', status='Responded' WHERE comp_id='".$_SESSION['complaint_id']."'";
				$result = mysqli_query($conn,$sql);
				if($result)
				{
					echo '<script type="text/javascript">alert("Submitted Response Successfully!.")</script>';
				}
				else
				{
					echo '<script type="text/javascript">alert("Failed to submit.")</script>';
				}
			}
		}	
	}
?>