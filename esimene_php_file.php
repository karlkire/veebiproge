
<?php
	// Hello, It´s a test muutujad.
	$myName = "Karl";
	$myFamilyName = "Raid";
	// hindan päeva osa <> >= <= 00 !=)
	$hourNow = date("H");
	$partofDay="";
	if ($hourNow <8);  {
			$partofDay="varajane hommi";
			
	}
	if($hourNow>=8 and $hourNow <16){
		$partofDay="koolipäev";
		
	}
	if($hourNow >16){
		$partofDay="vaba";
	}
	
	//echo $partofDay
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
	<p> For study see veebileht loodudõppeks ei avald tõsiselt võetavat sisu </p>

	<?php
			echo "<p>algas PHP õppimine.</P>";
			echo"<p> Täna on ";
			echo date("d:m:Y") .", kell oli avamise hetkel " .date("H:i:s");
			echo ", hetkel on " .$partofDay;
			echo ".</p>";
			
		?>
</body>
		
</html>