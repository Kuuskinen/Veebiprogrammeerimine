<?php
$database = "if17_lutsmeel";
//alustame sessiooni
session_start(); //sessiooni alustamine

//sisselogimise funktsioon
function signIn($email, $password){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); //andmebaasi ühendus 
	$stmt = $mysqli->prepare("SELECT id, firstname, lastname, email, password FROM vpusers WHERE email = ?");//mida baasist tahame
	$stmt->bind_param("s", $email);
	$stmt->bind_result($id, $firstnameFromDb, $lastnameFromDb, $emailFromDb, $passwordFromDb);
	$stmt->execute();
	
	//kontrollin kasutajat
	if($stmt->fetch()){
		$hash = hash("sha512", $password);
		if($hash == $passwordFromDb){
		    $notice = "Kõik OK! Logisimegi sisse";
			
			//salvestame sessioonimuutujaid
			$_SESSION["userId"] = $id;
			$_SESSION["firstname"] = $firstnameFromDb; //KODUS LISATUD!
			$_SESSION["lastname"] = $lastnameFromDb; //KODUS LISATUD!
            $_SESSION["userEmail"] = $emailFromDb;			
			
			//liigume pealehele
			header("Location: main.php");
			exit();
	} else {
		$notice = "Vale salasõna";
	}
	} else {
		$notice = "Sellist kasutajat (" .$email .") ei ole";
	}
	return $notice;
}

// uue kasutaja andmebaasi lisamine
function signUP($signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword){
	//loome andmebaasiühenduse
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//valmistame ette käsu andmebaasiserverile
		$stmt = $mysqli->prepare("INSERT INTO vpusers (firstname, lastname, birthday, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		//s - string
		//i - integer
		//d - decimal
		$stmt->bind_param("sssiss", $signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword);
		//$stmt->execute();
		if ($stmt->execute()){
			echo "\n Õnnestus!";
		} else {
			echo "\n Tekkis viga : " .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
}
//sisestuse kontrollimine 
	function test_input($data){
		$data = trim($data); //eemaldab lõpust tühiku, tab vms.
		$data = stripslashes($data); //eemaldab "\"
		$data = htmlspecialchars($data);//eemaldab keelatud märgid 
	    return $data;
	}
	
	/*$x = 8;
	$y = 5;
	echo "Esimene summa on: " .($x + $y);
	addValues();
	
	function addValues(){
		echo "Teine summa on: " .($$GLOBALS["x"] + $GLOBALS["y"]);
		$a = 4;
		$b = 1; 
		echo "Kolmas summa on: " .($a + $b);
		return $a .$b;
	}
	
	echo "Neljas summa on: " .($a + $b)
	*/
?>