<?php

namespace li\Sense\TreeDecision;


class Tree {
	private $node;
	private $knownData;
	private $freshAnswerKey;
	private $freshAnswerValue;
	private $nodeData;
	
	public function __construct(int $currentNode, string $freshAnswerKey, string $freshAnswerValue, array $knownData) {
		$this->knownData = $knownData;
		$this->freshAnswerKey = $freshAnswerKey;
		$this->freshAnswerValue = $freshAnswerValue;
		
		$json = json_decode(file_get_contents(__DIR__.'/nodesData.json'));
		$this->nodeData = new NodeDataJson($json->$currentNode);
		
		$this->node = new QuestionNode($knownData, $freshAnswerKey, $freshAnswerValue, $this->nodeData);
	}
	
	public function getResponse() {
		if ($this->node->hasFinalResponse()) {
			return $this->node->getFinalResponse();
		}
		
		if ($this->node->isFreshAnswerValid($this->freshAnswerKey)) {
			$newEntity = $this->node->getNewEntity($this->freshAnswerValue);
			$this->saveEntityIntoKnownBase($newEntity);
			$this->node = new QuestionNode($this->knownData, $this->freshAnswerKey, $this->freshAnswerValue, $this->nodeData);
		}
		
		if ($this->node->hasAllInformation()) {
			$nextNodeId = $this->node->getNextNodeId($this->freshAnswerValue);
			$this->updateCurrentNode($nextNodeId);
			$newTree = new Tree($nextNodeId, "", "", $this->knownData);
			return $newTree->getResponse();
		}
		
		return $this->node->getQuestionsAboutMissingEntity();
	}
	
	private function updateCurrentNode($newCurrentNode) {
		$_SESSION['currentNode'] = $newCurrentNode;
	}
	
	private function saveEntityIntoKnownBase($entity) {
		$_SESSION['data'] = $entity;
	}
}