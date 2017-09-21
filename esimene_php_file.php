
<?php
	// Hello, It´s a test muutujad.
	$myName = "Karl";
	$myFamilyName = "Raid";
	$monthNamesEt = ["jaanuar", "veebruar","m�rts", "april", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	//var_dump ($monthNamesEt);
	$monthNow = $monthNamesEt[date("n") - 1];
	


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
	//vanusega tegu
	//var_dump ($?POST);
	//echo $_POST["birthYear"]
	$myBirthYear;
	
	$ageNotice= "";
	if ( isset($_POST["birthYear"]) ) {
		$myBirthYear= $_POST ["birthYear"]; 
		$myAge = date("Y") - $_POST["birthYear"];
		$ageNotice = " <p>Te olete umbkaudu " .$myAge ." aastat vana. </p>";
		
		$ageNotice .= "<p> olete elanud aastatel:</p> <ul>";
		for ($i = $myBirthYear; $i <= date("Y"); $i ++) {
			$ageNotice .="<li>" .$i ."</li>";
			
		}
		$ageNotice .="</ul>";
	}
	/*for ($i= 0 ; $i < 5; $i ++){		//�hekaupa suureneb 5 korda teeb l�bi, kui midagi vaja teha siis loogelised suulud
		echo "ha";
	}*/
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
			echo date("d: ").$monthNow .date(" Y") .", kell oli avamise hetkel " .date("H:i:s");
			echo ", hetkel on " .$partofDay;
			echo ".</p>";
			
		?>
		<h2> Natuke vanusest </h2>
		<form method="post">
			<label>Teie Sünniaasta: </lable>
			<input name="birthYear" id="birthYear" type="number" value="<?php echo $myBirthYear; ?>" min="1900" max="2017">
			<input name="submitBirthYear" type="submit" value="Sisesta">
		
			
		
			
		</form>
		<?php
			if ($ageNotice !="") {
				echo $ageNotice;
			}
		?>
</body>
		
</html>