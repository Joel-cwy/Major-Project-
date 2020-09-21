<?php

$nameServer = "localhost";
$dBuser = "root";
$dBpasswd = "";
$dBname = "major_project";

$conn = mysqli_connect($nameServer, $dBuser, $dBpasswd, $dBname);

//If the connection to the server fails display error message
if (!$conn) {
  die("Connection failed: ".mysqli_connect_error());
}

?>
