<?php
    require ("functions.php"); //sessiooni alustamine ja funktsioonile ligipääs

    $MLnädalapäev = "";
	$MLnädalapäevError = "";
	$notice = "";

	if(isset($_POST["confirmButton"])){
	
	if (isset ($_POST["MLnädalapäev"])){
		if (empty($_POST["MLnädalapäev"])){
			$MLnädalapäev ="See väli on kohustuslik";
		} else {
			$MLnädalapäev = test_input($_POST["MLnädalapäev"]);
		}
	}	
?> 

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>
		Kontrolltöö
	</title>
</head>
<body>
	<h1>Nädalapäevade lehekülg</h1>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label>Nädalapäeva valik</label>
		<input name="MLnädalapäev" placeholder="Vali nädalapäev:" type="text">
		<span><?php echo $MLnädalapäevError; ?></span>
		<br><br>
		<input name="confirmButton" type="submit" value="Kinnita"><span><?php echo $notice; ?></span>
	</form>
</body>
</html>