<?php
  $servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "qltx";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	mysqli_set_charset($conn, 'UTF8');

	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}

?>
<?php
session_start();

?>

