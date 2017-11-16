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
		$this->neededEntityToDecide = $nodeData->neededDicisionEntity;
		$this->question = $nodeData->question;
		$this->supportedEntity = $nodeData->supportedEntity;
		$this->nextNodes = $nodeData->nextNodes;
		
		$this->freshAnswerKey = $freshAnswerKey;
		$this->freshAnswerValue = $freshAnswerValue;
	}
	
	public function hasAllInformation(): bool {
		foreach ($this->neededEntityToDecide as $entity) {
			if (!key_exists($entity, $this->data)) {
				return false;
			}
		}
		
		return true;
	}
	
	public function hasFinalQuestion(): bool {
		return !is_null($this->question);
	}
	
	public function getQuestionsAboutMissingEntity(): string {
		return $this->question;
	}
	
	public function hasFinalResponse(): bool {
		return !is_null($this->finalResponse);
	}
	
	public function getFinalResponse(): string {
		return $this->finalResponse;
	}
	
	public function isAnswerValid(string $freshAnswerKey): bool {
		return $this->supportedEntity == $freshAnswerKey;
	}
	
	public function getNewEntity($freshAnswerValue): array {
		return [$this->neededEntityToDecide => $freshAnswerValue];
	}
	
	public function getNextNodeId($freshAnswerValue): int {
		return $this->nextNodes[$freshAnswerValue];
	}
}