<?php

session_start();

require "vars.php";
$_POST['name'] = 'chan1';
$_POST['id'] = 232;

if(isset($_POST['name']) && isset($_POST['id']))
{
	
	$CustomerName = $_POST["name"];
	$CustomerNum = $_POST["id"];
	echo" $CustomerName , $CustomerNum";
	$street = "none"; 
	$city = "none"; 
	$state = "no"; 
	$PostalCode = 10;
	$Balance = 100.00;

	// Create connection
	$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

	// If there's no connection error
	if (!$conn->connect_error)
	{
		
		echo "no connection error";
		//If we can prepare the mysql statement
		if($stmt = $conn->prepare("INSERT INTO customer VALUES (?, ?, ?, ?, ?, ?, ?)"))
		{	
			echo "connection prepared";		
			//Bind the variables
			$stmt->bind_param("issssid", $CustomerNum, $CustomerName, $street, $city, $state, $PostalCode, $Balance);

			//Salt the password
			//$password = $saltLeft.$password.$saltRight;
			//Hash the password
			//$password = hash('ripemd160', $password);
			
			//If the statement succeeds, lets go ahead and start a session instead of making them login, and echo success to the ajax call
			if($stmt->execute())
			{
				$_SESSION['id'] = $CustomerNum;
				$_SESSION['name'] = $CustomerName;
				header("location: /cs351/buy.php");
				//echo "success";
			}
			else
			{
				echo "User creation failed (Bad Query)";
			}
		}
		else //We couldn't prepare the statement
		{
			echo "Unable to create the query.";
		}
	} 
	else //The connection failed so we send back an error
	{
		echo "Database connection failed. Please try again in the future.";
	}
}
else //We were not sent all the the variables
{
	echo "You did not provide all the necessary data.";
}

echo"
<!DOCTYPE html>
<html>
	<head>
		<title> Register Page! </title>
		
		<script>
			function loadDoc() {
			  var xhttp = new XMLHttpRequest();
			  xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
				 document.getElementById('input').innerHTML = this.responseText;
				}
			  };
			  xhttp.open('GET', 'register.php', true);
			  xhttp.send();
			}
				
		</script> 
	</head> 
	
	<body>
		<div id='input'>
		<form action='register.php' method='post'>
		  name:<br>
		  <input type='text' name='name'> 
		<br>
		  id:<br> 
		  <input type='text' name='id'>
		  
		  <button type='button' onclick='loadDoc()'></button>
		</form>
		</div>
	</body>
	
</html>

	
"

?>
