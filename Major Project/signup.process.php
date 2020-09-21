<?php
//checks if the button from sign up was clicked
//if the code is not set, users could access the url directly
if(isset($_POST['signup-button'])){
  require 'dBConnect.process.php';

  $username = $_POST['userId'];
  $email = $_POST['userEmail'];
  $password = $_POST['userPasswd'];
  $retype_password = $_POST['password_retype'];
  $randomInt = "LPAD(FLOOR(RAND() * 999999999), 9, '0')";

    //Checks if the text or password fields are empty
    //If empty and error message will be displayed on the url
    if (empty($username) || empty($email) || empty($password) || empty($retype_password)){
      header("Location: signupPage.php?Error=emptyormissingfields");
      exit();
    }
    //Checks if username contains alphanumeric characters
    elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)){
      header("Location: signupPage.php?Error=invalidemail");
      exit();
    }
    //Checks if the original password matches the retyped password
    elseif ($password !== $retype_password){
      header("Location: signupPage.php?Error=wrongretypedpassword");
      exit();
    }
  //Checks if website is able to connect to the sql database
    else {
      $sql = "SELECT UsernameUser FROM userinfo WHERE UsernameUser=?";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: signupPage.php?Error=sqlerror");
        exit();
      }
  //Checks if the username has already been taken
    else {
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $checkUsername = mysqli_stmt_num_rows($stmt);
        if ($checkUsername > 0){
          header("Location: signupPage.php?Error=usernametaken");
          exit();
        }
        // Adds in the user information once all checks above have been made
        else {
          $sql = "INSERT INTO userinfo (idUser, UsernameUser, EmailUser, PasswdUser) VALUES ($randomInt,?,?,?)";
          $stmt = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: signupPage.php?Error=sqlerror");
            exit();
        }
        else{
          $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
          mysqli_stmt_bind_param($stmt, "sss", $username, $email, $passwordHashed);
          mysqli_stmt_execute($stmt);
          header("Location: signupPage.php?Sucesss");
          exit();
        }
      }
    }
  }
    //Closes the connection to the sql database
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
//if user access website through the url without clicking on the button
else {
  header("Location: signupPage.php");
  exit();
}
?>
