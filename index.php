<?php

session_start();

$name = isset($_SESSION['name']) ? $_SESSION['name'] : '<i>unknown</i>';
$age = isset($_SESSION['age']) ? $_SESSION['age'] : '<i>unknown</i>';
$date = isset($_SESSION['date']) ? $_SESSION['date'] : '<i>unknown</i>';
$problem = isset($_SESSION['problem']) ? $_SESSION['problem'] : '<i>unknown</i>';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '<i>unknown</i>';

if (!isset($_SESSION['answer'])) {
	$_SESSION['answer'] = 'Hello stranger! Please start by introduce yourself!';
}

if (!isset($_SESSION['last'])) {
	$_SESSION['last'] = '<i>You said nothing yet. </i>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>chatbot</title>
	<link rel="stylesheet" href="speech-input/speech-input.css">
</head>
<body>
<h1>Reservation to a doctor</h1>
<ul>
	<li>Name of pacient: <b><?= $name ?></b></li>
	<!-- <li>Age of pacient: <b><?= $age ?></b></li> -->
	<li>Date of reservation: <b><?= $date ?></b></li>
	<li>Description of a problem: <b><?= $problem ?></b></li>
	<li>Patient's email: <b><?= $email ?></b></li>
</ul>

<h2><?= $_SESSION['answer']; ?></h2>
<form action="process.php">
	<label>
		Say your order to a bot: <input name="q" type="text" class="speech-input" data-patience="2"
										data-instant-submit>
		<= click on a mic, your reservation will be autosend
	</label>
	<input type="submit" hidden="hidden">
</form>
Your last message was: <i><?= $_SESSION['last'] ?></i>
<br/>
<br/>

You may start over by saying Bye! or by click on this button:
<a href="clearSession.php">
	<button>Start again!</button>
</a>

<script src="speech-input/speech-input.js"></script>
</body>
</html>