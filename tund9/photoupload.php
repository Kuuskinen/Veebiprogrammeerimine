<?php
	require("functions.php");
	$notice = "";
	
	$target_file = "";
	
	//kui pole sisseloginud, siis sisselogimise lehele
	if(!isset($_SESSION["userId"])){
		header("Location: login.php");
		exit();
	}
	
	//kui logib välja
	if (isset($_GET["logout"])){
		//lõpetame sessiooni
		session_destroy();
		header("Location: login.php");
	}
	
	// algab foto laadimise osa
	$target_dir = "../../pics/"; // <---- kuhu fail üles laetakse!
	$target_file = "";
	$uploadOk = 1;
	$maxWidth = 600;
	$maxHeight = 400;
	$marginHor = 10;
	$marginVer = 10;


	//kas vajutati laadimise nuppu
	if(isset($_POST["submit"])) {
	
		//kas fail on valitud, failinimi olemas
		if(!empty($_FILES["fileToUpload"]["name"])){
			
			//fikseerin failinime
			$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION)); //strtolower <--- teeb väiketähtedeks
			// $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$target_file = $target_dir .pathinfo(basename($_FILES["fileToUpload"]["name"]))["filename"] ."_" .(microtime(1) * 10000). /*et saada lahti komadest*/"." .$imageFileType;
			
			// $target_dir . pathinfo(basename($_FILES["fileToUpload"]["name"]))["filename"] mina.jpg-st annab see koodijupp "mina"
			
			// Kontrollib kas failitüüp on pilt või mitte
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				$notice = "Fail on pilt - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				$notice = "Fail ei ole pilt.";
				$uploadOk = 0;
			}
			// Kontrolli kas fail on juba olemas
			if (file_exists($target_file)) {
				$notice = "Fail on juba olemas.";
				$uploadOk = 0;
			}
			// Kontrolli faili suurust
			if ($_FILES["fileToUpload"]["size"] > 50000000) {
				$notice = "Viga! Fail on liiga suur.";
				$uploadOk = 0;
			}
			// Luba ainult kindlad failiformaadid
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				$notice = "Viga! Lubatud on ainult jpg, jpeg, png & gif failid.";
				$uploadOk = 0;
			}
			// Kontrolli kas $uploadOK seati vea tõttu nulliks 
			if ($uploadOk == 0) {
				$notice = "Viga. Sinu faili ei laetud üles.";
				if($uploadOk == 0){
					echo $notice;
				}
			// Kui kõik on OK, try to upload file
			} else {
				/*if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"]<--ajutine fail!, $target_file)) {
					$notice = "Fail ". basename( $_FILES["fileToUpload"]["name"]). " on üleslaetud.";
				} else {
					$notice = "Üleslaadimisel tekkis viga";
				}*/
			
		        //sõltuvalt failitüübist loon pildiobjekti (see peaks olema hiiglaslik) | standard pole jpg vaid jpeg | temporary pilt on globaalne muutuja  
                if($imageFileType == "jpg" or $imageFileType =="jpeg"){
                    $myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
                }
				if($imageFileType =="png"){
                    $myTempImage = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
				}
				if($imageFileType =="gif"){
                    $myTempImage = imagecreatefromgif($_FILES["fileToUpload"]["tmp_name"]);
				}
				
				//suuruse muutmine
				//teeme kindlaks praeguse suuruse
				$imageWidth = imagesx($myTempImage);
				$imageHeight = imagesy($myTempImage);
				//arvutan suuruse suhte
				if($imageWidth > $imageHeight){ // <--- LANDSCAPE PILT!
			        $sizeRatio = $imageWidth / $maxWidth;
				} else {
					$sizeRatio = $imageHeight / $maxHeight;
				}
                //Tekitan uue, sobiva suurusega pikslikogumi
                $myImage = resizeImage($myTempImage, $imageWidth, $imageHeight, round($imageWidth / $sizeRatio), round($imageHeight / $sizeRatio)); 
			
			    //Lisan vesimärgi (õp. stamp = minu watermark!)
				$watermark = imagecreatefrompng("../../graphics/hmv_logo.png");
				$watermarkWidth = imagesx($watermark);
				$watermarkHeight = imagesy($watermark);
				$watermarkX = imagesx($myImage) - $watermarkWidth - $marginHor;
				$watermarkY = imagesy($myImage) - $watermarkHeight - $marginVer;
				imagecopy($myImage, $watermark, $watermarkX, $watermarkY, 0, 0, $watermarkWidth, $watermarkHeight);

		        //lisan ka teksti vesimärgina
                $textToImage = "Heade mõtete veeb";				
			    //määrata värv
				$textColor = imagecolorallocatealpha($myImage, 255, 255, 255, 60); //alpha on 0 kuni 127
				// mis pildile, suurus, nurk (vastupäeva), koordinaadid x ja y, mis font 
				imagettftext($myImage, 20, -45, 10, 25, $textColor, "../../graphics/ARIAL.TTF", $textToImage);
				
                //Salvestame pildi
				if($imageFileType == "jpg" or $imageFileType =="jpeg"){
					if(imagejpeg($myImage, $target_file, 90)){//$myImage <--- ainus parameeter, mis tuleb kindlasti anda
						$notice = "Fail ". basename( $_FILES["fileToUpload"]["name"]). " on üleslaetud.";
					} else {
						$notice = "Üleslaadimisel tekkis viga";
					}
				}
				if($imageFileType =="png"){
					if(imagepng($myImage, $target_file, 5)){
						$notice = "Fail ". basename( $_FILES["fileToUpload"]["name"]). " on üleslaetud.";
					} else {
						$notice = "Üleslaadimisel tekkis viga";
					}
				}
				if($imageFileType =="gif"){
					if(imagepng($myImage, $target_file)){
						$notice = "Fail ". basename( $_FILES["fileToUpload"]["name"]). " on üleslaetud.";
					} else {
						$notice = "Üleslaadimisel tekkis viga";
					}
				}

			} //saab salvestada lõppeb 
	
		} else {
			$notice = "Fail on valimata. Vali palun pildifail.";
		}
	}//if submit lõppeb
 
 function resizeImage($image, $origW, $origH, $w, $h){ //saatsime myTempImage'i
     $newImage = imagecreatetruecolor($w, $h);
	 //kuhu, kust, kuhu koordinaatidele x ja y, kust koordinaatidelt x ja y, kui laialt uude kohta, kui kõrgelt uude kohta, kui laialt võtta, kui kõrgelt võtta
	 imagecopyresampled($newImage, $image, 0, 0, 0, 0, $w, $h, $origW, $origH);
	 return $newImage;
 } 
                        
?>

<!DOCTYPE html>
<html>
<body>
<p><a href="?logout=1">Logi välja</a>!</p>
<p><a href="main.php">Pealeht</a></p>
<form action="photoupload.php" method="post" enctype="multipart/form-data">
    Vali pilt, mida soovid üles laadida:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Postita" name="submit">
</form>

<span><?php echo $notice; ?></span>
<hr>

</body>
</html> <!-- PHP.net on PHP osas parem kui W3Schools! -->