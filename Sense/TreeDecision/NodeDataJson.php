<?php

namespace li\Sense\TreeDecision;


class NodeDataJson {
	public $question; // string
	public $neededDicisionEntity; // string
	public $nextNodes; // array [entityValue => nextNodeId]
	public $supportedEntity; // string entity, which witt is suppose to return based on answer to continue
	
	public function __construct($json) {
		
		$nodesData = json_decode($json);
		
		$this->question = $nodesData->question;
		$this->neededDicisionEntity = $nodesData->neededEntity;
		
		$nextNodes = [];
		foreach ($nodesData->childs as $child) {
			$nextNodes[$child->entityValue] = $child->nextNodeId;
		}
		$this->nextNodes = $nextNodes;
		$this->supportedEntity = $nodesData->supportedEntity;
	}
}