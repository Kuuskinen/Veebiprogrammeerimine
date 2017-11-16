<?php
    class Photoupload {
		/*private $testPrivate;
		public $testPublic;*/ // <--- need on selle klassi omadused ja kuulutatakse alati välja klassi alguses
		private $tempFile;
		private $imageFileType;
		private $myTempImage;
		private $myImage;
		
		function __construct($tempFile, $imageFileType){ //pane tähele, et constructi ees on kaks alakriipsu
			/*$this->testPrivate = $x;
			$this->testPublic = "TÄITSA AVALIK ASI! ";
			echo $this->testPrivate;*/
			$this->tempFile = $tempFile;
			$this->imageFileType = $imageFileType;
		}
          
        private function createImage(){
			if($this->imageFileType == "jpg" or $this->imageFileType =="jpeg"){
                $this->myTempImage = imagecreatefromjpeg($this->tempFile);
            }
		    if($this->imageFileType =="png"){
                $this->myTempImage = imagecreatefrompng($this->tempFile);
			}
			if($this->imageFileType =="gif"){
                $this->myTempImage = imagecreatefromgif($this->tempFile);
			}                              
		}	
		public function resizePhoto($maxWidth, $maxHeight){
			$this->createImage();
			//suuruse muutmine
			//teeme kindlaks praeguse suuruse
			$imageWidth = imagesx($this->myTempImage);
			$imageHeight = imagesy($this->myTempImage);
			//arvutan suuruse suhte
			if($imageWidth > $imageHeight){ // <--- LANDSCAPE PILT!
			    $sizeRatio = $imageWidth / $maxWidth;
			} else {
				$sizeRatio = $imageHeight / $maxHeight;
			}
            //Tekitan uue, sobiva suurusega pikslikogumi
            $this->myImage = $this->resizeImage($this->myTempImage, $imageWidth, $imageHeight, round($imageWidth / $sizeRatio), round($imageHeight / $sizeRatio));
		}
		
		private function resizeImage($image, $origW, $origH, $w, $h){ //saatsime myTempImage'i//väljast ei kutsuta, kutsutakse faili sees ja seetõttu pole vaja välja näidata.
			$newImage = imagecreatetruecolor($w, $h);
			imagesavealpha($newImage, true); // <----- säilita läbipaistvus
			$transColor = imagecolorallocatealpha($newImage,0,0,0,127); // <----defineerime värvi
			imagefill($newImage, 0, 0, $transColor); // <---- kirjutame selle värviga üle
			//kuhu, kust, kuhu koordinaatidele x ja y, kust koordinaatidelt x ja y, kui laialt uude kohta, kui kõrgelt uude kohta, kui laialt võtta, kui kõrgelt võtta
			imagecopyresampled($newImage, $image, 0, 0, 0, 0, $w, $h, $origW, $origH);
			return $newImage;
		}
			
		public function addWatermark($WMARK, $marginHor, $marginVer){ //õp. Watermark on minu WMARK
			//Lisan vesimärgi (õp. stamp = minu watermark!)
			$watermark = imagecreatefrompng($WMARK);
			$watermarkWidth = imagesx($watermark);
			$watermarkHeight = imagesy($watermark);
			$watermarkX = imagesx($this->myImage) - $watermarkWidth - $marginHor;
			$watermarkY = imagesy($this->myImage) - $watermarkHeight - $marginVer;
			imagecopy($this->myImage, $watermark, $watermarkX, $watermarkY, 0, 0, $watermarkWidth, $watermarkHeight);
		}
		
		public function addTextWatermark($text){
			$textColor = imagecolorallocatealpha($this->myImage, 255, 255, 255, 60); //alpha on 0 kuni 127
			imagettftext($this->myImage, 20, -45, 10, 25, $textColor, "../../graphics/ARIAL.TTF", $text);
		}
		
		public function savePhoto($directory, $fileName){
			$target_file = $directory .$fileName;
			//salvestame pildi
			if($this->imageFileType == "jpg" or $this->imageFileType =="jpeg"){
				if(imagejpeg($this->myImage, $target_file, 90)){//$myImage <--- ainus parameeter, mis tuleb kindlasti anda
					$notice = "Fail on üleslaetud.";
				} else {
					$notice = "Üleslaadimisel tekkis viga";
				}
			}
			
			if($this->imageFileType =="png"){
				if(imagepng($this->myImage, $target_file, 5)){
					$notice = "Fail on üleslaetud.";
				} else {
					$notice = "Üleslaadimisel tekkis viga";
				}
			}
			if($this->imageFileType =="gif"){
				if(imagepng($this->myImage, $target_file)){
					$notice = "Fail on üleslaetud.";
				} else {
					$notice = "Üleslaadimisel tekkis viga";
				}
			}
			return $notice;
		}
		
       public function saveOriginal($directory, $fileName){
		   $target_dir = $directory .$filename;
		   if (move_uploaded_file($this->tempFile, $target_file)){ //läbis kontrolli ja move'is selle algsuuruses serveri kataloogi
					$notice = "Originaalfail on üleslaetud.";
				} else {
					$notice = "Originaalfaili üleslaadimisel tekkis viga";
				}
				return $notice;
	   }

      public function clearImages(){
		  imagedestroy($this->myTempImage);
          imagedestroy($this->myImage);
	  }	  
	} // class lõppeb

?>

<?php
//property - muutuja klassis. kolme tüüpi omadused: private, public, protected
//method - funktsioon klassis
//määrame pildile värvi, millega midagi tegema hakkame
?>