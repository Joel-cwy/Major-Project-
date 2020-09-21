<?php
 session_start();
 if (!isset($_SESSION['UsernameUser'])){
   header("Location: loginPage.php");
 }
?>
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

<form method="post" action="dnslookup.php">
  <label for="dnslookup">Name of Website</label>
  <input type="text" id="domain" name="domain"/><br>
  <input type="submit" id="button" name="submit" value="continue"/>
</form>


</html>
