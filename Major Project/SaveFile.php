<?php
if(isset($_POST['submit'])){
  $abosolutepath = 'C:\Users\Joel.cwy\Desktop\Results.txt';
  $myfile = fopen($abosolutepath, "w") or die("Unable to open file!");
  fwrite($myfile, $_POST["result"]);
  fclose($myfile);
}
?>
