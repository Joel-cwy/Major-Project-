<?php
session_start();
if (!isset($_SESSION['UsernameUser'])){
  header("Location: loginPage.php");
}
$passed_array = unserialize($_POST['ipAddress']);

$apiKey = '74cgCTwtkm8VqzRUMlmoBMTd6789MdKf';
$minify = "TRUE";

foreach($passed_array as $value){
  $ip = $value;
  $url = 'https://api.shodan.io/shodan/host/'
          ."{$ip}?key={$apiKey}";

  $result = file_get_contents($url);
  $decoded = json_decode($result, TRUE);
  echo "<pre>";
  print_r($decoded);
  echo "</pre>";
  echo "<br>";
}
?>
