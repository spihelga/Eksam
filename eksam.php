<?php
function connect_db(){
	global $connection;
	$host="localhost";
	$user="test";
	$pass="t3st3r123";
	$db="test";
	$connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa ühendust mootoriga- ".mysqli_error());
	mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));
}
connect_db();
?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="UTF-8">
	<title>VRI EKSAM 2017</title>
</head>

<body>
	<form action="eksam.php" method="post">
		<input type="text" name="t1" placeholder="Kommentaar"/>
		<input type="submit" value="Lisa kommentaar" name="submit"/> 
	</form>
</body>
</html>

<?php

if(isset($_POST['submit'])){	//Kui submit'i on vajutatud
        global $connection;	// Ühendus databasega
        $kirje = mysqli_real_escape_string($connection, $_POST['t1']);	//Küsib sisestatud teksti ja kontorollib, et poleks SQL käske
	$sql = "INSERT INTO spihelga_VRI (kirje) VALUES ('$kirje')";	//SQL rida, lisa kirje
                if ($_POST['t1']!="" && mysqli_query($connection, $sql)) {	//Kui tekstiväli pole tühi lisab andmebaasi
                        echo "Kirje sisestatud </br>";
                } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
                }
}
	$sql = "SELECT * FROM spihelga_VRI";	//Küsib andmebaasist kõik tabelis oleva info
	$result = mysqli_query($connection, $sql) or die ("$sql - " .mysqli_error($connection));	//Pöördub andmebaasi poole
	while($row = mysqli_fetch_assoc($result)) {
		echo $row['kirje']."<br/>";
		}
	$sql2 = "SELECT count(*) AS ridu FROM spihelga_VRI";
	$tulemus = mysqli_query($connection, $sql2) or die ("$sql2 - " .mysqli_error($connection));
	$r = mysqli_fetch_assoc($tulemus);
	echo "Kommentaare on kokku: ".$r['ridu'];
?>

