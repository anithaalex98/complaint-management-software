function validatepass()
{	
	var pass = document.getElementById("pass").value;
	
	if(pass.length<6)
	{
		document.getElementById("passcheck").innerHTML = "Password must be at least 6 characters long.";
		return false;
	}
	else
	{
		document.getElementById("passcheck").innerHTML = "";
		return true;
	}
}

function validatecpass()
{	
	var pass = document.getElementById("pass").value;
	var cpass = document.getElementById("confirmpass").value;
	
	if(pass != cpass)
	{
		document.getElementById("cpasscheck").innerHTML = "Password and Confirm Password must be same.";
		return false;
	}
	else
	{
		document.getElementById("cpasscheck").innerHTML = "";
		return true;
	}
}

function validateemail()
{
	var email_id = document.getElementById("email").value;
	var pattern= /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	
	if(email_id.match(pattern))
	{
		document.getElementById("emailcheck").innerHTML = "";
		return true;
	}
	else
	{
		document.getElementById("emailcheck").innerHTML = "Invalid Email ID.";
		return false;
	}
}
