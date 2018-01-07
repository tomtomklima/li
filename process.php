<?php

namespace li;

use GuzzleHttp\Client;
use function GuzzleHttp\default_ca_bundle;

require 'vendor/autoload.php';

// Exceptions handler
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$config = new Config\Config();

session_start();

$_SESSION['chat'][] = '🙎: '.$message = $_GET['q'];

if ($_GET['q'] === '') {
	header('Location: index.php');
	die();
}

$client = new Client([
	'base_uri' => 'https://api.wit.ai/message',
	'headers' => [
		'Authorization' => 'Bearer '.$config->witToken,
	],
	'query' => [
		'v' => 20171105,
		'q' => $message,
	]]);

$response = $client->get('');

$entities = json_decode($response->getBody()->getContents())->entities;

if (isset($entities->bye)) {
	header('Location: clearSession.php');
	die();
}

foreach ($entities as $entityName => $entityValues) {
	$_SESSION['data'][$entityName] = $entityValues[0]->value;
	$freshAnswer[$entityName] = $entityValues[0]->value;
}

// clear ambiguous questions
$freshAnswerKey = $freshAnswerValue = '';
foreach ($freshAnswer ?? [] as $key => $value) {
	$freshAnswerKey = $key;
	$freshAnswerValue = $value;
	break;
}


$currentNode = $_SESSION['currentNode'] ?? 0;

$answer = (new Sense\TreeDecision\Tree($currentNode,
	$freshAnswerKey,
	$freshAnswerValue,
	$_SESSION['data'] ?? [])
)->getResponse();

// repetition progtection
if (!isset($_SESSION['repetitionCounter'])) {
	$_SESSION['repetitionCounter'] = 0;
}

if (isset($_SESSION['lastAnswer']) && $_SESSION['lastAnswer'] == $answer) {
	$_SESSION['repetitionCounter']++;
	
	switch ($_SESSION['repetitionCounter']) {
		case 1:
			$answer = 'I didn\'t understand you, please rephrase your answer.';
			break;
		case 2:
			$answer = 'I didn\'t understand you again, please rephrase your answer one more time?';
			break;
		default:
			$answer = 'Sorry, I do not understand you at all. Calling human operator now.';
			break;
	}
} else {
	$_SESSION['repetitionCounter'] = 0;
	$_SESSION['lastAnswer'] = $answer;
}

$_SESSION['chat'][] = '🤖: '.$answer;

header('Location: index.php#form');