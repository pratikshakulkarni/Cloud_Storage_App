<?php 
require "db.php";
$name = $_POST['name'];
$uname = $_POST['uname'];
$pass = $_POST['pass'];
$type = $_POST['type'];
$sql = "INSERT INTO REG(name, uname, pass, type) VALUES ('$name', '$uname', '$pass', '$type')";
$res = mysqli_query($conn, $sql);
if($res)
{
	header("location: index.html");
}
else
{
	echo "SOmething went wrong";
}
 ?>