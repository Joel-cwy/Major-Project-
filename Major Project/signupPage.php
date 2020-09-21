<?php
?>
<!DOCTYPE html >
<html>
<head>
  <title>Signup Page</title>
	<style type="text/css">
	body,html {
	   margin: 0;
	   padding: 0;
	   height: 100%;
	   }
   .container {
     width:500px;
     border:3px solid black;
     display: block;
     margin-left: auto;
     margin-right: auto;
     margin-top: 15px;
   }
   .button{
     width:75px;
     height:30px;
     display: block;
     margin-left: 90px;
     margin-top: 10px;
   }
   .input {
     width: 250px;
   }
	</style>
</head>
<body>
<div class ="Logo">
  <img src="box.PNG" style="width:150px; height:150px; display: block; margin-left:auto; margin-right:auto; padding: 15px 0 0 0">
</div>
<div class="container" style="height:300px;">
			<form action="signup.process.php" method="post" style="margin-left:125px; margin-top:15px;">
        	<input type="text" name="userId" required placeholder="Username" style="width: 250px; margin-top:10px">
        	<input type="text" name="userEmail" required placeholder="E-mail" style="width:250px; margin-top:10px">
          <input type="password" name="userPasswd" required placeholder="Password" style="width:250px; margin-top:10px">
          <input type="password" name="password_retype" required placeholder="Retype Password" style="width:250px; margin-top:10px">
    			<button class="button" type="submit" name="signup-button">Sign Up</button>
    			<p>Already have an account?<a style="text-decoration: none" href="loginPage.php"> Login here</a></p>
      </form>
</div>
</body>
</html>
