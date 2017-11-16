<?php

	class Photoupload {
		/*private $testPrivate;
		public $testPublic;*/
		private $tempFile;
		private $imageFileType;
		private $myTempImage;
		private $myImage;
		
		
		
		
		function __construct($tempFile, $imageFileType){//parameetrid mängude puhul mis ta teeb kiirus relv.            
		
		//temp file põiame kinni need
		
		
			/*$this->testPrivate = $x;                   //muutuja kuuluvus tuleb ära üelda
			$this->testPublic = "Täitsa avalik asi!";
			echo $this->testPrivate;*/
//hakkame tegema nagu peaks olema
			$this->tempFile = $tempFile;
			$this->imageFileType= $imageFileType;
		
		
		
		}
		
		public function savePhoto($directory, $fileName){
			$target_file=$directory .$fileName;
			if($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
				if(imagejpeg($this->myImage, $target_file, 90)){
					$notice= "Fail laeti üles! ";
				} else {
					$notice= "Vabandust, üleslaadimisel tekkis tõrge! ";
				}
			}
			
			
		
			if($this->imageFileType == "png"){
				if(imagepng($this->myImage, $target_file, 5)){
					$notice= "Fail laeti üles";
				} else {
					$notice= "Vabandust, üleslaadimisel tekkis tõrge! ";
				}
			}
			if($this->imageFileType == "gif"){
				if(imagegif($this->myImage, $target_file)){
					$notice= "Fail laeti üles";
				} else {
					$notice= "Vabandust, üleslaadimisel tekkis tõrge! ";
				}
				return $notice;
			}
		}
			public function saveOriginal($directory, $fileName){
				$target_dir = $directory .$fileName;
				if (move_uploaded_file($this->tempFile, $target_File)) {
					$notice= " originaal laeti üles! ";
				} else {
					$notice= "Vabandust, üleslaadimisel tekkis tõrge! ";
				}
				return $notice;
			}
	
			private function createImage(){
				if($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
					$this->myTempImage = imagecreatefromjpeg($this->tempFile);
				}
				if($this->imageFileType == "png"){
					$this->myTempImage = imagecreatefrompng($this->tempFile);
				}
				if($this->imageFileType == "gif"){
					$this->myTempImage = imagecreatefromgif($this->tempFile);
				}
			}
		
		
		public function rezisePhoto($maxWidth, $maxHeight){
			$this->createImage();
			
			//suuruse muutumine
			//teeme kindlaks suuruse
			$imageWidth = imagesx($this->myTempImage);
			$imageHeight = imagesy($this->myTempImage);
				//arvutan suuruse suhte
			if($imageWidth > $imageHeight){
				$sizeRatio = $imageWidth / $maxWidth;
			} else {
				$sizeRatio = $imageHeight / $maxHeight;
				}
				//tekitame uue, sobiva suurusega pikslikogumi
			$this->myImage = $this->resizeImage($this->myTempImage, $imageWidth, $imageHeight, round($imageWidth / $sizeRatio), round($imageHeight / $sizeRatio));
			}
		private function resizeImage($image, $origW, $origH, $w, $h){
			$newImage = imagecreatetruecolor($w, $h);
			imagesavealpha($newImage, true);   //et oleks läbipaistev
			$transColor = imagecolorallocatealpha($newImage, 0,0,0,127);                //127 läpipaistev 0, 0, 0, must
			imagefill($newImage, 0, 0, $transColor);
			//kuhu, kust, kuhu koordinaatidele x ja y, kust koordinaatidelt x ja y, kui laialt uude kohta, kui kõrgelt uude kohta, kui laialt võtta, kui kõrgelt võtta
			imagecopyresampled($newImage, $image, 0, 0, 0, 0, $w, $h, $origW, $origH);
			return $newImage;
		}		
		public function addWatermark($watermark, $marginHor, $marginVer){
			//lisan vesimärgi
			$stamp = imagecreatefrompng($watermark);
			$stampWidth = imagesx($stamp);
			$stampHeight = imagesy($stamp);
			$stampX = imagesx($this->myImage) - $stampWidth - $marginHor;  //hor kaugus äärest ver ka
			$stampY = imagesy($this->myImage) - $stampHeight - $marginVer;
			imagecopy($this->myImage, $stamp, $stampX, $stampY, 0, 0, $stampWidth, $stampHeight);
		}
		public function addTextWatermark($text){
			$textColor = imagecolorallocatealpha($this->myImage, 255,255,255,60);//alpha 0 - 127
					//mis pildile, suurus, nurk vastupäeva, x, y, värv, font, tekst
			imagettftext($this->myImage, 20, -45, 10, 25, $textColor, "../../graphics/ARIAL.TTF", $text);
			
		}
			
			
		public function clearImages(){
			imagedestroy($this->myTempImage);
			imagedestroy($this->myImage);
		}
	}//class lõppeb kõik peab siin sees
		//property ---muutuja classis private, public protected selle classi piires
		//method--- funktsioon classis    
		//kobjektid saavad väärtuse == konstrukteerimine

?>

