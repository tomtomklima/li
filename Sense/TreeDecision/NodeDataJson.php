<?php

namespace li\Sense\TreeDecision;


class NodeDataJson {
	public $question; // string
	public $neededDecisionEntity; // string
	public $nextNodes; // array [entityValue => nextNodeId]
	public $supportedEntity; // string entity, which witt is suppose to return based on answer to continue
	public $finalResponse; // final decision
	
	public function __construct($json) {
		
		$this->question = $json->question ?? null;
		$this->neededDecisionEntity = $json->neededDecisionEntity ?? null;
		$this->supportedEntity = $json->supportedEntity ?? null;
		$this->finalResponse = $json->finalResponse ?? null;
		
		foreach ($json->childs ?? [] as $child) {
			$nextNodes[$child->entityValue] = $child->nextNodeId;
		}
		$this->nextNodes = $nextNodes ?? [];
	}
}