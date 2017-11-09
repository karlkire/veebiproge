<?php
	require("functions.php");
	$notice = "";
	$allIdeas = "";
	//kodutöö radio nupp pildilaadimisel lisanduks kas avalik pilt, teha andme tabel, id, userid , (privat 1everybody, 2users, 3for me)
	
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
	
	//Algab foto laadimise osa
	$target_dir = "../../pics/";
	$target_file = "";  //$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); //oli
	$uploadOk = 1;
	$maxWith=600;
	$maxHeight=400;
	$marginHor=10;
	$marginVer=10;
	//$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);   //siit ära see
	
		//Kas laadimis nuppu vajutatud
		if(isset($_POST["submit"])){
			//kas file valitud, filinimi olemas
			if(!empty($_FILES["fileToUpload"]["name"])){
			
			
				//fikseerin failinimi
				$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION)); //selleks siis ja muuta kuna fili nime teha unikaalseks, lisada timestamp 
				//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);       //basename   mina.jpg-----extention  --filinimi
				$target_file=$target_dir .pathinfo(basename($_FILES["fileToUpload"]["name"]))["filename"] ."_" .(microtime(1) *10000). "." .$imageFileType;
				//kas on pildi filetüüp
				$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				if($check !== false) {
					$notice .= "Fail on pilt - " . $check["mime"] . ". ";
					$uploadOk = 1;
				} else {
					$notice .= "See pole pildifail. ";
					$uploadOk = 0;
				}
				if (file_exists($target_file)) {
				$notice .= "Kahjuks on selle nimega pilt juba olemas. ";
				$uploadOk = 0;
			}
				//Piirame faili suuruse
				if ($_FILES["fileToUpload"]["size"] > 1000000) {
					$notice .= "Pilt on liiga suur! ";
					$uploadOk = 0;
				}
				
				//Piirame failitüüpe
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
					$notice .= "Vabandust, vaid jpg, jpeg, png ja gif failid on lubatud! ";
					$uploadOk = 0;
				}
				
				//Kas saab laadida?
				if ($uploadOk == 0) {
					$notice .= "Vabandust, pilti ei laetud üles! ";
				//Kui saab üles laadida
				} else {		
					/*if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {   //kui soovin originaali siis move kommenteerida välja seda vaja peale seda teha
						$notice .= "Fail ". basename( $_FILES["fileToUpload"]["name"]). " laeti üles! ";
					} else {
						$notice .= "Vabandust, üleslaadimisel tekkis tõrge! ";
						}*/
						
						// sõltuvalt faili tüübist loon pildiobjekti
					if($imageFileType == "jpg" or $imageFyletype == "jpeg"){
						$myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
					}
					if($imageFileType == "png"){
						$myTempImage = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
					}
					if($imageFileType == "gif"){
						$myTempImage = imagecreatefromgif($_FILES["fileToUpload"]["tmp_name"]);
						}
						//suuruse muutumine teeme kindlaks suuruse muutumine kontrollime suurust ka
						$imageWidth = imagesx ($myTempImage);
						$imageHeight = imagesy ($myTempImage);
						//arvutan suuruse suhte
						if($imageWidth > $imageHeight){
						$sizeRatio = $imageWidth/$maxWidth;
							
						}else{$sizeRatio = $imageHeight/$maxHeight;
						
						}
						//tekitame uues sobiva suurusega pikslikogumi
						$myImage = resizeImage($myTempImage, $imageWidth, $imageHeight, round($imageWidth / $sizeRatio), round($imageHeight/$sizeRatio));
						
						//lisan vesimärgi
						$stamp = imagecreatefrompng($target_dir = "../../graphics/hmv_logo.png");
						$stampWtdth = imagesx($stamp);
						$stampHeight = imagesy($stamp);
						$stampX = imagesx($myImage) - $stampWidth - $marginHor;
						$stampY = imagesy($myImage) - $stampWidth - $marginVer;
						imageCopy($myImage, $stamp, $stampX, $stampY, 0, 0, $stampWtdth, $stampHeight);
						
						//lisan ka teksti vesimärgile
						$textToImage = "Heade mõtete veeb";
						//värv
						$textColor = imagecolorallocatealpha($myImage, 155, 155, 155, 60);               //alpha (0-127) lisab lõppu läbipaistvust
						imagettftext($myImage, 20, -45, 10, 25, $textColor, "../../graphics/ARIAL.TTF", $textToImage);// mis suureuses x nurk  vastu päeva. kordinaadid x ja y,värv  mis font panna lõppu "../../graphics/...."
						
						
						//salvesta piltid
						if($imageFileType == "jpg" or $imageFileType == "jpeg"){
							if(imagejpeg($myImage, $target_file, 90)){//myImage originaal mõõtmega
								$notice .= "Fail ". basename( $_FILES["fileToUpload"]["name"]). " laeti üles! ";
							} else {
								$notice .= "Vabandust, üleslaadimisel tekkis tõrge! ";
							}
						}
						
						if($imageFileType == "png"){
							if(imagejpeg($myImage, $target_file, 5)){//myImage originaal mõõtmega
								$notice .= "Fail ". basename( $_FILES["fileToUpload"]["name"]). " laeti üles! ";
							} else {
								$notice .= "Vabandust, üleslaadimisel tekkis tõrge! ";
							}
						}
							
							
							
						if($imageFileType == "gif"){
							if(imagejpeg($myImage, $target_file)){//myImage originaal mõõtmega
								$notice .= "Fail ". basename( $_FILES["fileToUpload"]["name"]). " laeti üles! ";
							} else {
								$notice .= "Vabandust, üleslaadimisel tekkis tõrge! ";
							}
						}
						
					}//kas saab laadida

					
							
					
					// vabastan mälu 
					imagedestroy($myTempImage);
					imagedestroy($myImage);
					imagedestroy($stamp);
					
					// saab salvestada lõppeb
			
		
			}else{
			$notice="Palun valida pildifail!!!"; 
			
			
			
			
			}


			
	}//if submit lõppeb
		
	function resizeImage($image, $origW, $origH, $w, $h){
		$newImage= imagecreatetruecolor($w, $h);
		//kuhu kust kordinaatidele x ja y, kust kordinaadidelt x ja y, kui kõrgelt uude kohta. kui laialt võtta kui kõrgelt
		imagecopyresampled($newImage, $image, 0, 0, 0, 0, $w, $h, $origW, $origH);
		return $newImage;
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>
		veebiprogemise asjad
	</title>
</head>
<body>
	<h1>Hope</h1>
	<p>See veebileht on loodud veebiprogrammeerimise kursusel ning ei sisalda mingisugust tõsiseltvõetavat sisu.</p>
	<p><a href="?logout=1">Logi välja</a>!</p>
	<p><a href="main.php">Pealeht</a></p>
	<hr>
	<h2>Foto üleslaadimine</h2>
	<form action="photoupload.php" method="post" enctype="multipart/form-data">
		<label>Valige pildifail:</label>
		<input type="file" name="fileToUpload" id="fileToUpload">
		<input type="submit" value="Lae üles" name="submit">
	</form>
	
	<span><?php echo $notice; ?></span>
	<hr>
</body>
</html>