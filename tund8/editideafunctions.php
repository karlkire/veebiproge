<?php
	$database = "if17_karl";
	require("../../../config.php");
	function getSingleIdea($editid){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT idea, ideacolor FROM userideas WHERE id=?");
		echo$mysqli->error;
		$stmt->bind_param("i", $editid);		//päringu tegu saatmiseks. Saatmisel vaja mis tüüpi kas i, s(string) või muu, tagasisaamisel pole
		$stmt->bind_result($idea, $color); 
		$stmt->	execute();	
		$ideaObject = new Stdclass(); // saab reaomadusi and 
		if($stmt->fetch()){
			$ideaObject->text = $idea;
			$ideaObject->color= $color;
	
		}else{
			//sellist ideed pole kas sesiooni muutuja läheb kokku
			$stmt->close();
			$mysqli->close();
			
			header("Location:userideas.php");
			exit();

		}
                                               
		$stmt->close();
		$mysqli->close();
		return  $ideaObject;                                    //saab ühe muutuja returniga .masiiviga saab tehe selle?.Objektorjentiiritus. Objekt võib ka olla muutuja.
	}

	function updateIdea($id, $idea, $color){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE userideas SET idea=?, ideacolor=? WHERE id=?");
		echo $mysqli->error;
		$stmt->bind_param("ssi", $idea, $color, $id);  //peab minema kokku 43-mega
		$stmt->execute();
		
		$stmt->close();
		$mysqli->close();
	}
	
	
	function deleteIdea($id){
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

	$stmt = $mysqli->prepare("UPDATE userideas SET deleted = NOW() WHERE id=?");
	echo $mysqli->error;
	$stmt->bind_param("i", $id);
	$stmt->execute();
	
	$stmt->close();
	$mysqli->close();
	}
?>
