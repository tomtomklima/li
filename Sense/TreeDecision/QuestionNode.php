<?php

namespace li\Sense\TreeDecision;

class QuestionNode {
	private $data;
	private $neededEntityToDecide;
	private $freshAnswerKey;
	private $freshAnswerValue;
	private $question;
	private $finalResponse;
	private $supportedEntity;
	private $nextNodes;
	
	public function __construct(array $knownEntities,
								string $freshAnswerKey,
								string $freshAnswerValue,
								NodeDataJson $nodeData) {
		$this->data = $knownEntities;
		$this->question = $nodeData->question;
		$this->neededEntityToDecide = $nodeData->neededDecisionEntity;
		$this->supportedEntity = $nodeData->supportedEntity;
		$this->nextNodes = $nodeData->nextNodes;
		$this->finalResponse = $nodeData->finalResponse;
		
		$this->freshAnswerKey = $freshAnswerKey;
		$this->freshAnswerValue = $freshAnswerValue;
	}
	
	public function hasAllInformation(): bool {
		if (!is_null($this->neededEntityToDecide) && key_exists($this->neededEntityToDecide, $this->data)) {
			return !empty($this->data[$this->neededEntityToDecide]);
		} else {
			return false;
		}
	}
	
	public function hasFinalResponse(): bool {
		return !empty($this->finalResponse);
	}
	
	public function getFinalResponse(): string {
		return $this->finalResponse;
	}
	
	public function isFreshAnswerValid(string $freshAnswerKey): bool {
		return ($this->supportedEntity != "") && ($this->supportedEntity == $freshAnswerKey);
	}
	
	public function getNewEntity($freshAnswerValue): array {
		return [$this->neededEntityToDecide => $freshAnswerValue];
	}
	
	public function getNextNodeId($freshAnswerValue): int {
		try {
			return $this->nextNodes[$freshAnswerValue];
		} catch (\Exception $e) {
			throw new \Exception('Missing information for node with value "'.$freshAnswerValue.'"');
		}
	}
	
	public function getQuestionsAboutMissingEntity(): string {
		return $this->question;
	}
}