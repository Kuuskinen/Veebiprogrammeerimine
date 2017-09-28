<?php
    //muutujad
	$myName= "Meelis";
	$myFamilyName= "Lutsar";
	$monthNamesEt = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober",
	"november", "detsember"];
	$monthNow = $monthNamesEt[date("n")-1]
	
	//hindan päeva osa | (võrdlemine  < >)
	$hourNow = date("H");
	$partOfDay = "";
	if ($hourNow < 8){
		   $partOfDay = "varajane hommik";
	}
	if ($hourNow >= 8 and $hourNow < 16){
		$partOfDay = "koolipäev";
	}
	if($hourNow > 16){
		$partOfDay = "vaba aeg";
	}
	//echo $partOfDay;
	
	//vanusega tegelemine
	//var_dump($_POST);
	//echo $_POST("birthyear")
    $myBirthYear;
	$ageNotice = "";
	if ( isset($_POST["birthYear"]) and $_POST["birthYear"] != 0){
		$myBirthYear = $_POST["birthYear"];
	    $myAge = date("Y") - $_POST["birthYear"];
        $ageNotice = "<p>Te olete umbkaudu " .$myAge ." aastat vana.</p>";
        
		$ageNotice .= "<p>Te olete elanud järgnevatel aastatel:</p><ol>";
        for ($i = $myBirthYear; $i <= date("Y"); $i ++){
            $ageNotice .= "<li>" .$i ."</li>";     		
	}	
	$ageNotice .= "</ol>";
	
	}
	/*for ($i = 0; $i < 5; $i ++){
	    echo "ha";	
	}*/	
	
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title>Meelis Lutsar</title>
</head>
<body>
   <h1><?php echo $myName ." " .$myFamilyName; ?>, veebiprogrammeerimine</h1>
   <p>See veebileht on loodud õppetöö raames ja ei sisalda mingit tõsiselt võetavat sisu.<p>
See tekst on lisatud koduse töö raames, pärast korduvaid katseid selleni jõuda. Ma loodan, et see tekst püsib siin 
neljapäevani.<br>

<p>Pluuto avastas 1930. aastal  Clyde Tombaugh  ja alates avastamisest kuni 2006. aastani nimetati teda planeediks<br> 
ning loeti Päikesesüsteemi üheksandaks planeediks. Pluuto planeedistaatus seati kahtluse alla<br>
1992. aastal, kui Kuiperi vööst leiti mitu Pluutoga sarnast objekti. 2005. aastal avastati Kuiperi vööst<br>
kääbusplaneet  Eris, mis on Pluutost 27% suurem. 24. augustil  2006 otsustas  Rahvusvaheline<br>
Astronoomiaunioon  võtta Pluutolt planeedi staatuse ja kvalifitseeris Pluuto ümber kääbusplaneediks.<p>
<?php
echo "<p>Algas PHP õppimine<p>";
echo "<p>Täna on ";
echo date("d.m.Y") .", kell oli lehe avamise hetkel " .date("H:i:s");
echo ", hetkel on " .$partOfDay .".</p>";
?>
<h2>Natuke vanusest</h2>
<----Sissemagamise järgne kood---->
<form method="POST">
    <label>Teie sünniaasta: </label>
	<input name="birthYear" id="birthYear" type="number" value="<?php echo $myBirthYear; ?> min="1900" max="2017">
	<input name="submitBirthYear" type="submit" value="Kinnita">
	</form>
	<?php
	    if ($ageNotice != ""){
			echo $ageNotice;
		}
	?>
</body>
</html>