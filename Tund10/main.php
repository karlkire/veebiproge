
<?php
	//et pääseks ligi sessioonile ja funktsioonidele
	
	require("functions.php");
	//kui pole logind saadab login lehele
	if(!isset($_SESSION["userId"])){
		header("Location: login.php");
		exit();
		
		}
		
		
	if(isset($_GET["logout"])){ 
		
		session_destroy();                                              //unustatakse kõik kasutajaga
		
		header("Location: login.php");
		exit();
	
	
	}
	
	
	
	// Hello, It´s a test muutujad.
	$myName = "Karl";
	$myFamilyName = "Raid";
	
	
	$picDir = "../../pics/";
	$picFiles = [];
	$picFileTypes = ["jpg", "jpeg", "png", "gif"];
	
	$allFiles = array_slice (scandir($picDir), 2);
	foreach ($allFiles as $file){
		$fileType = pathinfo ($file,  PATHINFO_EXTENSION);
		if (in_array($fileType, $picFileTypes) ==true){
			array_push($picFiles, $file);           // kui soonelised suled lõppevadsiis ; 
			
			
			
		}
		
		
		
	}
	
	
	
	
	//Var_dump($allFiles);
	//$picFiles = array_slice($allFiles, 2);
	//var_dump($picFiles);
	$picFileCount = count ($picFiles);
	$picNumber = mt_rand(0, $picFileCount - 1);                                     // rand ja mt rand   juhuslikus veel parem kiirem ja parem -1 soovitav ja lisa see
	$picFile = $picFiles[$picNumber];
	
	

	?>	



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>
		 KarErik veebi programeerimine 
	</title>





</head>
<body>
	<h1> 
		<?php echo $myName ." " .$myFamilyName; ?>"pildid, head ja body vaja mingeid asju lisada" 
	</h1>
	<p><a href="?logout=1"> Logi Välja</a></p>                                                            <!-- get meetodil -->
	<img src="<?php echo $picDir .$picFile; ?>" alt="foto">     
	
</body>
		
</html>