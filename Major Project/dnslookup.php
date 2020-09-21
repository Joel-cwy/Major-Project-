</html>
<!DOCTYPE html>
<html>
<head>
  <title>
    DNSLookup
  </title>
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

//error_reporting(E_ERROR | E_WARNING | E_PARSE);

$domain = $_POST['domain'];
$apiKey = 'at_mEjn8Kr5fU41mfrDsVHf4CVyobGkd&';
$type = '_all';
$outformat = 'JSON';

$url = 'https://www.whoisxmlapi.com/whoisserver/DNSService?'
     . "apiKey={$apiKey}&domainName={$domain}&type={$type}&outputFormat={$outformat}";


//$result type is String
$result = file_get_contents($url);

$encode = json_encode($result);
//$decoded type is array
$decoded = json_decode($result, TRUE);

//$data is accessing the multidimensional array within $decoded
$data = $decoded['DNSData'];
$ip_address_array = array();

$sessionName = $_SESSION['UsernameUser'];
$sql = "SELECT * FROM userinfo";
$checkConnection = mysqli_query($conn, $sql);
if(!$checkConnection) {
  header("Location: dnslookup.php?Error=sqlerror");
  exit();
} else {
  $updatesql = "UPDATE userinfo SET SrchHistory = '$encode' WHERE UsernameUser = '$sessionName'";
  if (mysqli_query($conn, $updatesql)){
    //Set counter for the loop to be used
    $counter = 0;

    //For DNS Type TXT
    echo "<table>";
    echo "DNS Type: TXT";
    echo "<tr>";
      echo "<td>No.</td>";
      echo "<td>TTL</td>";
      echo "<td>String</td>";
    echo "</tr>";
    for($i = 0; $i < count($data['dnsRecords']); $i++){
      $newData = $data['dnsRecords'];
      if($newData[$i]['dnsType'] == "TXT"){
        $stringsData = $newData[$i]['strings'];
        $counter++;
        echo "<tr>";
        echo "<td>".$counter; "</td>";
        echo "<td>".($newData[$i]['ttl']); "</td>";
        foreach($stringsData as $stringsData){
          echo "<td>";
          echo $stringsData;
          echo "</td>";
          }
        }
      }
    echo "</table>";
    echo "<br>";

    //For DNS Type MX
    echo "<table>";
    echo "DNS Type: MX";
    echo "<tr>";
      echo "<td>No.</td>";
      echo "<td>TTL</td>";
      echo "<td>Target</td>";
    echo "</tr>";
    for($i = 0; $i < count($data['dnsRecords']); $i++){
      $newData = $data['dnsRecords'];
      if($newData[$i]['dnsType'] == "MX"){
        $counter++;
        echo "<tr>";
        echo "<td>".$counter; "</td>";
        echo "<td>".($newData[$i]['ttl']); "</td>";
        echo "<td>".($newData[$i]['target']); "</td>";
        }
      }
    echo "</table>";
    echo "<br>";

    //For DNS Type NS
    echo "<table>";
    echo "DNS Type: NS";
    echo "<tr>";
      echo "<td>No.</td>";
      echo "<td>TTL</td>";
      echo "<td>Target</td>";
    echo "</tr>";
    for($i = 0; $i < count($data['dnsRecords']); $i++){
      $newData = $data['dnsRecords'];
      if($newData[$i]['dnsType'] == "NS"){
        $counter++;
        echo "<tr>";
        echo "<td>".$counter; "</td>";
        echo "<td>".($newData[$i]['ttl']); "</td>";
        echo "<td>".($newData[$i]['target']); "</td>";
        }
      }
    echo "</table>";
    echo "<br>";

    //For DNS Type A
    echo "<table>";
    echo "DNS Type: A";
    echo "<tr>";
      echo "<td>No.</td>";
      echo "<td>TTL</td>";
      echo "<td>IP Address</td>";
    echo "</tr>";
    for($i = 0; $i < count($data['dnsRecords']); $i++){
      $newData = $data['dnsRecords'];
      if($newData[$i]['dnsType'] == "A"){
        $counter++;
        echo "<tr>";
        echo "<td>".$counter; "</td>";
        echo "<td>".($newData[$i]['ttl']); "</td>";
        echo "<td>".($newData[$i]['address']); "</td>";
        array_push($ip_address_array, $newData[$i]['address']);
        }
      }
    echo "</table>";
    echo "<br>";

    //For DNS Type SOA
    echo "<table>";
    echo "DNS Type: SOA";
    echo "<tr>";
      echo "<td>No.</td>";
      echo "<td>TTL</td>";
      echo "<td>Admin</td>";
      echo "<td>Host</td>";
    echo "</tr>";
    for($i = 0; $i < count($data['dnsRecords']); $i++){
      $newData = $data['dnsRecords'];
      if($newData[$i]['dnsType'] == "SOA"){
        $counter++;
        echo "<tr>";
        echo "<td>".$counter; "</td>";
        echo "<td>".($newData[$i]['ttl']); "</td>";
        echo "<td>".($newData[$i]['admin']); "</td>";
        echo "<td>".($newData[$i]['host']); "</td>";
        }
      }
    echo "</table>";
    echo "<br>";
  }
}


//Checks if variable $result is not empty
/*if(!empty($result)){
  $sessionName = $_SESSION['UsernameUser'];
  print $sessionName;
  $sql = "SELECT * FROM userinfo WHERE UsernameUser = $sessionName;";
  $checkConnection = mysqli_query($conn, $sql);
  if(!$checkConnection) {
    header("Location: dnslookup.php?Error=sqlerror");
    exit();
  } else {
    print "hello world";
    $insertsql = "INSERT INTO userinfo (SrchHistory) VALUES ($result)";
  }
}*/

?>

<body>
<form method='post' action='shodan.php'>
  <input type='hidden' name='ipAddress' id='ipAddress' value="<?php echo htmlentities(serialize($ip_address_array)); ?>"/>
  <input type='submit' name='submit' value='Continue with Shodan API'/>
</form>
</body>
</html>
