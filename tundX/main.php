<?php
	//et pääseks ligi sessioonile ja funktsioonidele
	require("functions.php");
	
	//kui pole sisseloginud, liigume login lehele
	if(!isset($_SESSION["userId"])){
		header("Location: login.php");
		exit();
	}
	
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
		exit();
	}
	$picDir = "../../pics/";
	$picFiles = [];
	$picFileTypes = ["jpg", "jpeg", "png", "gif"];
	
	$dirToRead = "../../pics/";
	
	$picFileTypes = ["jpg", "jpeg", "png", "gif"]; //pildifailide filter
	$picFiles = [];
	$allFiles = array_slice(scandir($dirToRead),2);//loeb kataloogi, aga eemaldab massiivi esimesed liikmed . ja ..
	
	foreach ($allFiles as $file){
		$fileType = pathinfo($file, PATHINFO_EXTENSION);
		if (in_array($fileType, $picFileTypes) == true){
			array_push($picFiles, $file);
		}
	}//foreach lõppeb
	
	//var_dump($allFiles);
	//$picFiles = array_slice($allFiles, 2);
	//var_dump($picFiles);
	$picFileCount = count($picFiles);
	$picNumber = mt_rand(0, $picFileCount - 1);
	$picFile = $picFiles[$picNumber];
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>
		<?php echo $_SESSION["firstname"] ." " .$_SESSION["lastname"]; ?>
		 veebiprogemise asjad
	</title>
</head>
<body>
	<h1><?php echo $_SESSION["firstname"] ." " .$_SESSION["lastname"]; ?></h1>
	<p>See veebileht on loodud õppetöö raames ning ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p><a href="?logout=1">Logi välja</a></p>
	<p><a href="usersinfo.php">Kasutajate info</a></p>
	<p><a href="usersideas.php">Head mõtted</a></p>
	<p><a href="photoupload.php">Fotode üleslaadimine.</a></p>
	<img src="<?php echo $picDir .$picFile; ?>" alt="Tallinna ülikool"> <!--pildi suuruse määramiseks: style="width:500px;height:600px;" -->
</body>
</html>