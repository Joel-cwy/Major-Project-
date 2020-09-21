<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="webpageCss.css">
</head>

<nav>
  <ul>
    <li><a href = 'majorProjectHomepage.php'><img src='box.PNG'></li>
    <li><a href = '#'>Download API</a></li>
    <li><a href = 'displayInformation.php'>Search History</a></li>
    <form action="logout.process.php" method="post">
      <li><a href = 'loginPage.php'>Log Out</a></li>
    </form>
  </ul>
</nav>


<?php
require 'dBConnect.process.php';
session_start();
if (!isset($_SESSION['UsernameUser'])){
  header("Location: loginPage.php");
}

$sessionName = $_SESSION['UsernameUser'];

$sql = "SELECT SrchHistory FROM userinfo WHERE UsernameUser = '$sessionName';";
$result = mysqli_query($conn, $sql);
if(!$result) {
  header("Location: displayInformation.php?Error=sqlerror");
  exit();
} else {
  $row = mysqli_fetch_assoc($result);
  $result = $row['SrchHistory'];
  $encode = json_encode($result);
  $decode = json_decode($encode, TRUE);
  echo "<pre>";
  print $decode;
  echo "</pre>";
}
mysqli_close($conn);
?>

</html>
