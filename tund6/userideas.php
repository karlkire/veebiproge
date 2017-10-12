<?php
	require("functions.php");
	$notice = "";
	//kas pole sisse loginud
	if(!isset($_SESSION["userId"])){
		header("Location: login.php");
		exit();
	}
	
	
	//kas pole sisse loginud
	if(!isset($_SESSION["userId"])){
		header("Location: login.php");
		exit();
		
	}	
	//väljalogimine
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
	if(isset($_POST["ideaButton"])){
		
		if (isset($_POST["idea"]) and !empty($_POST["idea"])){
			
			//echo $_POST["ideaColor"];
			$notice = saveIdea($_POST["idea"], $_POST["ideaColor"]);
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Õppus veebiprogrammeerimises</title>
</head>
<body>
	<h1>Head mõtted</h1>
	<p>See leht on loodud õppetöö raames ning ei sisalda mingit tõsiseltvõetavat sisu.</p>
	<p><a href="?logout=1">Logi välja!</a></p>
	<p><a href="main.php">Pealeht</a></p>
	<hr>
	<h2>lisa oma mõte</h2>
	
	<form method="POST" action="<?php echo htmlspecialchars ($_SERVER["PHP_SELF"]);?>">
		<label>hea mõte: </label>
		<input name="idea" type="color"
		<br>
		<label> Mõttetega seonduv värv</label>
		<input name="ideaColor" text="">  
		<br>
		<input name="ideaButton" type="submit" value="Salvesta mõte!">
		<span><?php echo $notice; ?></span>
	
	
	</form>	
	<hr>
	
	<div syle="with: 40%">
		<?php echo listIdeas();?>
	</div>
	
	
</body>
</html>