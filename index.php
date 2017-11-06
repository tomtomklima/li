<?php

namespace li;

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>chatbot</title>
	<link rel="stylesheet" href="speech-input/speech-input.css">
</head>
<body>
<h1>Diagnosis chatbot</h1>

<h3>🤖: Welcome, what are your symptoms?</h3>
<?php
foreach ($_SESSION['chat'] as $sentence) {
	echo '<h3>'.htmlentities($sentence, ENT_QUOTES).'</h3>';
} ?>
<form action="process.php">
	<label>
		<input name="q" type="text" class="speech-input" data-patience="2"
			   data-instant-submit required="required">
	</label>
	<input type="submit" hidden="hidden">
</form>
<br/>
<br/>

<p>You may start over by saying Bye! or by click on this button:
	<a href="clearSession.php">
		<button>Start again!</button>
	</a></p>

<p>What do we know yet: </p>
<?php htmlentities(var_dump($_SESSION), ENT_QUOTES); ?>

<script src="speech-input/speech-input.js"></script>
</body>
</html>