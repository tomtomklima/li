<?php

namespace li;

use GuzzleHttp\Client;

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

$freshAnswerKey = $freshAnswerValue = '';
// clear ambiguous questions
foreach($freshAnswer ?? [] as $key => $value) {
	$freshAnswerKey = $key;
	$freshAnswerValue = $value;
	break;
}

$currentNode = $_SESSION['currentNode'] ?? 0;

$senseTree = new Sense\TreeDecision\Tree($currentNode, $freshAnswerKey, $freshAnswerValue, $_SESSION['data'] ?? []);

$_SESSION['chat'][] = '🤖: '.$senseTree->getResponse();

header('Location: index.php');