<?php
session_start();

//include a file that has variables we will use over again in the site.
require "vars.php";

//If we are sent both a username and password
if(isset($_POST['id']) && isset($_POST['name']))
{
	//Assign these values to variables to save typing
	$name = $_POST['name'];
	$id = $_POST['id'];
	echo $_POST['id'].','.$_POST['name'];	
	echo "creating connection"; 	
	// Create connection
	$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

	// Check connection
	if (!$conn->connect_error)
	{
		//If we can prepare a statement
		if($stmt = $conn->prepare("select CustomerNum, CustomerName from customer where CustomerNum= ? AND CustomerName= ?;"))
		{
			
			//Bind the two variables to the two question marks.  ss means the variables will be strings.
			$stmt->bind_param("is", $id, $name);
			
			//Salt the password
			//$password = $saltLeft.$password.$saltRight;
			//Hash the password
			//$password = hash('ripemd160', $password);
			
			//submit the statement to mysql
			$stmt->execute();

			//If there was a result
			if($stmt->bind_result($id, $name))
			{
				//if we can get the values from the result
				if($stmt->fetch())
				{
					//Set session variables for the username and user id.
					$_SESSION['id'] = $id;
					$_SESSION['name'] = $name;
					
					//echo success back out to the ajax call
					echo "success";
					header("location: /cs351/buy.php");
				}
					
				else //We couldn't fetch the result
				{
					echo "Bad database results.";
				}
			}
			else //We did not get an id back from the database
			{
				echo "Your username or password did not match our records.";
			}
		}
		else //We could not prepare the statement perhaps because of bad values
		{
			echo "Unable to create the query.";
		}
		
	} 
	else //The connection failed so we send back an error
	{
		echo "Database connection failed. Please try again in the future.";
	}
}
else //We did not get all the data we were expecting
{
	echo "You must provide both a username and password.";
}

echo"
<!DOCTYPE html>
<html>
	<head>
		<title> Login Page! </title>
		
		<script>
			function loadDoc() {
			  var xhttp = new XMLHttpRequest();
				var url = 'login.php';
				var param = 'id&name';
				xhttp.open('POST', url, true);

				//Send the proper header information along with the request
				xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			  xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
				
				 document.getElementById('input').innerHTML = this.responseText;
				}
			  };
			  //alert('hello');
			  //xhttp.open('GET','login.php', true);
			  xhttp.send(param);
			}
				
		</script> 

	</head> 
	
	<body>
		<div id='input'>
		<form action='login.php' method='post'>
		  ID:<br>
		  <input type='text' name='id'><br>
		  name:<br>
		  <input type='text' name='name'>
		  <input type='submit' value='Login'/>
		</form>
		</div>
	</body>
	
</html>

	
"
?>
