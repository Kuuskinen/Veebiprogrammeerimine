<?php
    //et pääseks ligi sessioonile ja funktsioonidele
	require("functions.php");
	
	//kui pole sisseloginud, liigume login lehele
	if(!isset($_SESSION["userId"])){
		header("Location: login.php");
		exit();
	}

	$stmt = $mysqli->prepare("SELECT id, firstname, lastname, gender, email FROM vpusers");
	 while($stmt->fetch()){
          echo($firstname . $lastname . $email . $gender . $email);//KODUS LISATUD!
        }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>
		Meelis Lutsar veebiprogrammeerimine
	</title>
</head>
<body>
	<h1><?php echo $myName ." " .$myFamilyName; ?>, veebiprogrammeerimine</h1>
	<p>See veebileht on loodud õppetöö raames ning ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<table border="1" style="border: 1px solid black; border-collapse: collapse">
	<tr>
		<th>Eesnimi</th><th>perekonnanimi</th><th>sugu</th><th>email</th>
	</tr>
	<tr>
		<td>Juku</td><td>Porgand</td><td>juku.porgand@aed.ee</td>
	</tr>
	<tr>
		<td>Mari</td><td>Karus</td><td>mari.karus@aed.ee</td>
	</tr>
</body>
</html>