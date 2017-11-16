<?php
	require("functions.php"); //seal on näiteks sessiooni muutujad
	require("editideafunctions.php");
	$notice = "";                                                                                                                    //SEE ON ÕIGE
	
	//kas pole sisse loginud
	if(!isset($_SESSION["userId"])){
		header("Location: login.php");
		exit();
	}
	
	//väljalogimine
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
	if(isset($_POST["ideaButton"])){
	    updateIdea($_POST["id"], test_input($_POST["id"]), $_POST["ideaColor"]);
        //jään siiasamasse
        header("Location: ?id=" .$_POST["id"]);
        exit();	   
	}
	
	if(isset($_GET["delete"])){
		deleteIdea($_GET["id"]);
		header("Location: usersideas.php");
		exit();
	}
		//2mb on piltidel maksimum
	$idea = getSingleIdea($_GET["id"]); //see loeb midagi. idea ütleb, et ühe mõtte
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Meelise veebiprogrammeerimine</title>
</head>
<body>
	<h1>Head mõtted</h1>
	<p>See leht on loodud õppetöö raames ning ei sisalda mingit tõsiseltvõetavat sisu.</p>
	<p><a href="?logout=1">Logi välja</a></p> <!--See on GET-->
	<p><a href="usersideas.php">Tagasi mõtete lehele</a></p>
	<hr>
	<h2>Toimeta mõtet</h2>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	    <input name="id" type="hidden" value="<?php echo $_GET["id"]; ?>"><!--POSTiga läheb kaasa aga ei näidata-->
		<label>Hea mõte: </label>
		<textarea name="idea"><?php echo $idea->text;?></textarea> <!-- textarea korral igal juhul tekst-->
		<br>
		<label>Mõttega seonduv värv: </label>
		<input name="ideaColor" type="color" value="<?php echo $idea->color; ?>"> <!-- me tahame varem valitud värvi-->
		<br>
		<input name="ideaButton" type="submit" value="Salvesta muudetud mõte!">
		<span><?php echo $notice; ?></span>
		
	</form>
	<p><a href="?id=<?php echo $_GET['id']; ?>&delete=1">Kustuta</a> see mõte.</p> 
	<!-- <a href="?id=19&delete=1"> -->
	<hr>
	
</body>
</html>