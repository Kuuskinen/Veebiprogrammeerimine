<?php
    $database = "if17_lutsmeel";
	require("../../../config.php");
	
	function getSingleIdea($editid){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT idea, ideacolor FROM vpuserideas WHERE id =?");
		echo $mysqli->error; // kui baasipäringuga tekib viga VEAKONTROLL
		$stmt->bind_param("i", $editid); //Kuna päringus on tundmatu // see paneb muutujad andmebaasi käsku // peab deklareerima andmetüüpi
		$stmt->bind_result($idea, $color); //vastuvõtmisel pole vaja deklareerida andmetüüpi // paneb muutujatesse väärtused
		$stmt->execute();
		$ideaObject = new Stdclass(); //Stdclass --- standardklass (väga anonüümne ja universaalne)
		if($stmt->fetch()){
			$ideaObject->text = $idea;
			$ideaObject->color = $color;
		} else {
            //sellist mõtet ei olnud
			$stmt->close();
			$mysqli->close();
			//echo "jama";
		    header("Location:usersideas.php");
            exit(); //et lehel rohkem midagi ei tehtaks			
		}			
	
		$stmt->close();
		$mysqli->close();
		return $ideaObject;
	}	
	
	function updateIdea($id, $idea, $color){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE vpuserideas SET idea=?, ideacolor=? WHERE id=?");
		echo $mysqli->error;
		$stmt->bind_param("ssi", $idea, $color, $id); //bind_resulti pole vaja, sest andmed ei tule tagasi! OLULINE!
		$stmt->execute();
		//echo $stmt->error;
		$stmt->close();
		$mysqli->close();
	}
	
	function deleteIdea($id){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE vpuserideas SET deleted = NOW() WHERE id=?");
		echo $mysqli->error;
		$stmt->bind_param("i", $id);
		$stmt->execute();
		
		$stmt->close();
		$mysqli->close();
	}
	
	//https://www.w3schools.com/php/php_file_upload.asp
?>