<?php
    //muutujad
	$MLnadalapaev = "";
	$MLnadalapaevNAME = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"]; 
	$MLnadalapaevError = "";
	$notice = "";
	
//kas klõpsati kinnitamise nuppu
	if(isset($_POST["confirmButton"])){
	
	//kas on nädalapäev sisestatud
	if (isset ($_POST["MLnadalapaev"])){
		if (empty ($_POST["MLnadalapaev"])){
			$MLnadalapaevError =" Nädalapäev on puudu!";
		} else {
			$MLnadalapaev = $_POST["MLnadalapaev"];
		}
	}
		
		/*if(!empty($MLnadalapaev and !empty("MLnadalapaev"))){ 
			$notice = MELU($MLnadalapaev, $_POST["MLnadalapaev"]);
	}*/ //See ei toimi
	
	}	
?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Kontrolltöö</title>
</head>
<body>
	<h1>Nädalapäevade valik</h1>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label>Nädalapäev: </label>
		<input name="MLnadalapaev" type="text" value="<?php echo $MLnadalapaev; ?>"><span><?php echo $MLnadalapaevError; ?></span>
		<br><br>
		<input name="confirmButton" type="submit" value="Kinnita"><span><?php echo $notice; ?></span>
	</form>
		
</body>
</html>