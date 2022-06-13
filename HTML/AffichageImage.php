<!doctype html>
<html lang="fr">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
</head>
<body>
<style>
body {
  background-image: url('/assets/black.png');
  background-repeat: no-repeat;
  background-attachment: fixed;  
  background-size: cover;
}
</style>
<br>
<br>
<br>
<br>
<center>
<?php 

$host = '192.168.107.136';
$user = 'root';
$pwd = 'adminx';
$db = 'projet';

$mysqli = new mysqli($host, $user, $pwd, $db);

if (!$mysqli)
{
	echo "Erreur de connexion";
}

$result = $mysqli->query("SELECT * FROM tb_upload"); 

echo "<table border='1' width='0%' >"; 
    while($row = mysqli_fetch_array($result)) { 
        echo "<tr>";
        echo "<td><img src='/image/".$row['src']." 'width=\"280\" height=\"280\" margin:auto' /></td>";
        echo "</tr>"; 
    }
echo "</table>";
mysqli_close($con);

?>
</center>
</body>