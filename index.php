<?php

namespace li;

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="styles.css"/>
	<meta charset="UTF-8">
	<title>chatbot</title>
	<link rel="stylesheet" href="speech-input/speech-input.css">
	<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css"
		  integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
</head>
<body>
<main class="main">
	<h1>Diagnosis chatbot</h1>
	<div class="history">
		<h3>🤖: Hello. How do you feel?</h3>
		<?php
		foreach ($_SESSION['chat'] as $sentence) {
			echo '<h3>'.htmlentities($sentence, ENT_QUOTES).'</h3>';
		} ?>
		<span id="form"></span>
	</div>
	<form action="process.php" class="pure-form pure-g">
		<div class="pure-u-1">
			<label class="pure-u-1"> 🙎:
				<input name="q" type="text" class="speech-input" data-patience="2"
					   data-instant-submit required="required">
			</label>
		</div>
		<br/>
		<div class="pure-u-1">
			<a href="clearSession.php" class="pure-button-red pure-button">Začít znovu</a>
			<input type="submit" class="pure-button pure-button-primary" value="Odeslat text ručně">
		</div>
	</form>
	<script src="speech-input/speech-input.js"></script>
</main>
</body>
</html>