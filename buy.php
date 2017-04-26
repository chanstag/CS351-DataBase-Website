<?php
session_start();	
require "vars.php";
$_SESSION['name'] = "chan";
echo"hello you can buy here";
if(isset($_SESSION['name'])){

echo"
<!DOCTYPE html>
<html>
	<head>
		<title> Login Page! </title>
			
		<link rel='stylesheet' href='main.css'>
		<script src='input.js'></script>
	</head> 
	
	<body>
		<h1> Welcome to 'It's Over Anakin'! </h1>
		
		<div id='cpus'>
			<form action='buy.php' method='post'>
				<h1> CPUs </h1>
			";
			
			
				
					// Create connection
					$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
					// Check connection
					if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
					} 

					$sql = "SELECT item.ItemNum, ItemName, Price, ClockSpeed FROM item, cpus WHERE item.ItemNum = cpus.ItemNum; ";
							
							
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						// output data of each row
						while($row = $result->fetch_assoc()) {
							echo"
							<input type='checkbox' name=".$row['ItemName']." value=".$row['ItemNum']."> ItemName: ".$row['ItemName']." Price: ".$row['Price']." ClockSpeed: ".$row['ClockSpeed']."<br>
							Number to Purchase: 							
							<input type='text' name='numpurchase'> <br>
							";
						}
					} else {
						echo "0 results";
					}
					$conn->close();
			echo"	

				<button type='button' onclick='loadDoc()'> Submit for Purchase </button>
			</form>
		
			<form action='buy.php' method='post'>
				<h1> GPUs </h1>
			";
			
			
				
					// Create connection
					$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
					// Check connection
					if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
					} 

					$sql = "SELECT item.ItemNum, ItemName, Price, RAM FROM item, gpus WHERE item.ItemNum = gpus.ItemNum; ";
							
							
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						// output data of each row
						while($row = $result->fetch_assoc()) {
							echo"
							<input type='checkbox' name=".$row['ItemName']." value=".$row['ItemNum']."> ItemName: ".$row['ItemName']." Price: ".$row['Price']." RAM: ".$row['RAM']."<br>
							Number to Purchase: 							
							<input type='text' name='numpurchase'> <br>
							";
						}
					} else {
						echo "0 results";
					}
					$conn->close();
			echo"	

				<button type='button' onclick='loadDoc()'> Submit for Purchase </button>
	</body>
	
</html>
";}
else{
	echo" 
	<!DOCTYPE html>
	<html>
	
	<body>
	<p>you are not logged in.</p>
	<a href='login.php'> back to Login page</a>
	</body>
	
	
	</html>
	"; 
}	
?>


