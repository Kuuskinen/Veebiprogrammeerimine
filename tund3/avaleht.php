<?php
    //muutujad
	$myName= "Meelis";
	$myFamilyName= "Lutsar";
	
	$picDir = "../../pics/";
	$picFiles = [];
	$picFileTypes = ["jpg", "jpeg", "png", "gif"]; // <---sobivad vormingud
	
	$allFiles = array_slice(scandir($picDir), 2);
	foreach ($allFiles as $file){
		$fileType = pathinfo($file, PATHINFO_EXTENSION);
		if (in_array($fileType, $picFileTypes) == true){// in_array — Checks if a value exists in an array
			array_push($picFiles, $file);//array_push — Push one or more elements onto the end of array
		}
	}//foreach lõppeb
	
	//var_dump($allFiles); <---
	//$picFiles = array_slice($allFiles, 2);
	//var_dump($picFiles);
	$picFileCount = count($picFiles); //loendab directorys olevad failid
	$picNumber = mt_rand(0, $picFileCount - 1); //mt_rand annab suvalise väärtuse //rida võtab suvalise pildi
	$picFile = $picFiles[$picNumber]; //kuvab vastava pildi
	 
?>	

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title>Meelis Lutsar</title>
</head>
<body>
   <h1><?php echo $myName ." " .$myFamilyName; ?>, veebiprogrammeerimine</h1>
   <img src="<?php echo $picDir .$picFile; ?>" alt="Tallinna Ülikool">

</body>
</html>