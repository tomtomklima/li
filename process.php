<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;

session_start();
$message = $_GET['q'];

$client = new Client([
	'base_uri' => 'https://api.wit.ai/message',
	'headers' => [
		'Authorization' => 'Bearer O6CZUAESH7OJLD43VFZ7NEWTCAMPVOLH',
	],
	'query' => [
		'v' => 20171020,
		'q' => $message,
	]]);

$response = $client->get('');

$contents = json_decode($response->getBody()->getContents());

$entities = $contents->entities;

if (isset($entities->bye)) {
	header('Location: clearSession.php');
	die();
}

if (isset($entities->datetime)) {
	$_SESSION['date'] = date('d. m Y', strtotime($entities->datetime[0]->value));
} else {
	$_SESSION['answer'] = 'Please, say desired date for therapist check. ';
}

if (isset($entities->email)) {
	$_SESSION['email'] = $entities->email[0]->value;
} else {
	$_SESSION['answer'] = 'Please, say desired date for therapist check. ';
}

if (isset($entities->illness)) {
	$_SESSION['problem'] = $entities->illness[0]->value;
}

if (isset($entities->contact)) {
	$_SESSION['name'] = $entities->contact[0]->value;
}

if (isset($_SESSION['name'], $_SESSION['problem'], $_SESSION['email'], $_SESSION['date'])) {
	$_SESSION['answer'] = 'Thanks for your input! Now you may erase all your information by saying Bye!';
}

$_SESSION['last'] = $contents->_text;

// bot answer

if (!isset($_SESSION['email'])) {
	$_SESSION['answer'] = 'Get us your email for futher contact. ';
}

if (!isset($_SESSION['date'])) {
	$_SESSION['answer'] = 'Pick the date for examination. ';
}

if (!isset($_SESSION['problem'])) {
	$_SESSION['answer'] = 'Describe your problem or illness please. ';
}

if (!isset($_SESSION['name'])) {
	$_SESSION['answer'] = 'Please, say desired date for therapist check. ';
}

header('Location: index.php');