<?php

require "db.php";

$name = $_POST['uname'];
$pass = $_POST['pass'];

$sql = "SELECT * FROM REG WHERE uname = '$name' AND pass = '$pass'";
//$gettype = mysql_query("SELECT type FROM REG WHERE uname = '$name'");

$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_row($res);
$type = $row[3];

if(mysqli_num_rows($res) > 0 && $type == "fac")
{
	header("location: upload.html");
}
if(mysqli_num_rows($res) > 0 && $type == "student")
{
	header("location: download1.php");
}
else
{
	echo "Invalid data";
}
?>