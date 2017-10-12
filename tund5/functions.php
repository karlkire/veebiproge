<?php
	$database = "if17_karl";    //globaalseks muutujaks teha kõik et andmed kätte saada.
	
	//alustame sessiooni et aja jooksul välja logiks
	
	
	session_start();
	//sisselogimise funktisoon
	function signIn($email, $password){
		$notice= "";           	//lokaalne muutuja kas parool õige
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);                //kui vaja midagi korraga teha on ka võimalik
		$stmt = $mysqli->prepare("SELECT id, email, password FROM karl WHERE email = ?");                 //select et andmed kätte saada.
		$stmt->bind_param("s",$email);
		$stmt->bind_result($id, $emailFomDb, $passwordFromDb);                                   //kui sealt tuleb result
		$stmt->execute();
		
		
		//kontrollime kasutajat siis if
	if($stmt->fetch()){
		//$notice = "kõik korras sisse logitud";
		$hash = hash("sha512", $password);
		if($hash == $passwordFromDb){
			$notice = "kõik korras sisse logitud"; 
			
			
			//salvestame sessiooni muutujad
			
			
			$_SESSION["userid"] = $id;
			$_SESSION["userEmail"] = $emailFromDb;
			//liigu pealehele
			header("Location: main.php");
			exit();
			
			
			
		}else{
			$notice = " vale parool!";
			
		}
		
		
		
	} else {
		$notice = "sellist kasjutajat pole (" .$email .") ei ole";
	}		//võtab andmed
		
		return $notice;
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//uue kasutaja andmebaasi lisamine
	function signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword){
		//loome andmebaasiühenduse
		
		$mysqli = new mysqli($GLOBAL["serverHost"], $GLOBAL["serverUsername"], $GLOBAL["serverPassword"], $GLOBAL["database"]);
		//valmistame ette käsu andmebaasiserverile
		$stmt = $mysqli->prepare("INSERT INTO vplif17_karl (firstname, lastname, birthday, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		//s - string
		//i - integer
		//d - decimal
		$stmt->bind_param("sssiss",$signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword );
		//$stmt->execute();
		if ($stmt->execute()){
			echo "\n Õnnestus!";
		} else {
			echo "\n Tekkis viga : " .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
		//no work yet kõike ei saa kätte 
		
		
	}
//sisestuse kontrollima
	function test_input($data){
			$data = trim($data);//eemaldab lõpust tühiku, tab vms
			$data = stripslashes($data);//eemaldab/
			$data = htmlspecialchars($data);//eemaldab keelatud märgid
			return $data;
	}
	/*$x=8;
	$y=5;
	echo "esimene summa on: " .($x+$y);
	addValues();

	function addValues(){
		
		
		echo "Teine summa on: " .($GLOBALS["x"] + GLOBALS["$y"]);  //et korra kasutatakse 

		echo"kolmas summa:" .($a+$b);
		//return $a .$b; //saab lokaalsed muutujad välja saata
	}
	echo"Neljas summa on; " .($a+$b);
//functions.php peab olema ühel lehel login*/



?>