<?php
if(isset($_POST['login-submit'])){
  require 'dBConnect.process.php';

  $username = $_POST['userId'];
  $password = $_POST['userPasswd'];

  if(empty($username) || empty($password)){
    header("Location: loginPage.php?Error=emptyormissingfields");
    exit();
  }
  else{
    $sql = "SELECT * FROM userinfo WHERE UsernameUser=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: loginPage.php?Error=sqlerror");
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($row = mysqli_fetch_assoc($result)){
        $passwdCheck = password_verify($password, $row['PasswdUser']);
        if ($passwdCheck == FALSE){
          header("Location: loginPage.php?Error=wrongpassword");
          exit();
        }
        else if($passwdCheck == TRUE){
          session_start();
          $_SESSION['UsernameUser'] = $row['UsernameUser'];
          header("Location: majorProjectHomepage.php");
          exit();
        }
      }
      else{
        header("Location: loginPage.php?Error=nouser");
        exit();
      }
    }
  }
}
else {
  header("Location: loginPage.php");
  exit();
}

?>
