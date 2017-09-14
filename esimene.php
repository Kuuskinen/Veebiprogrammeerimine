<?php
    //muutujad
	$myName= "Meelis";
	$myFamilyName= "Lutsar";
	
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
	echo $partOfDay;
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
echo ".</p>";
?>

</body>
</html>