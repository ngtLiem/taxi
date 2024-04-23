<!-- <?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "qltx";
// $conn = new mysqli($servername, $username, $password, $dbname);
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// } 
// session_start();

// require '../functions.php';

?> -->
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
  session_start();
	// include 'functions.php';

?>


