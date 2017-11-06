<?php

namespace li\Sense;

class IfDecision {
	private $conclusions = ['hearth-attack' => 'You probably have hearth attack. '];
	private $action = ['life-thread' => 'Life-threatening condition!'];
	
	private $temperature;
	private $painType;
	private $painLocation;
	
	public function __construct(array $conditions) {
		$this->temperature = $conditions['symptomes_temperature'] ?? null;
		$this->painType = $conditions['symptomes_painType'] ?? null;
		$this->painLocation = $conditions['symptomes_painLocation'] ?? null;
	}
	
	public function getAnswerBasedOnConditions() {
		// hearth attack
		if ($this->painType == 'stinging' && $this->painLocation == 'chest') {
			return $this->conclusions['hearth-attack'].' '.$this->action['life-thread'];
		}
		
		// we don't know with all the informations!
		if (isset($this->temperature, $this->painType, $this->painLocation)) {
			return 'Sorry, we can\'t recognize your problem. It the problems persist, please visit your physician. ';
		}
		
		// we don't know, get more information
		return $this->getMissingInformation();
	}
	
	private function getMissingInformation() {
		if (isset($this->temperature, $this->painType, $this->painLocation)) {
			throw new \Exception('We have all conditions we could have. ');
		}
		
		if (!isset($this->painType) && !isset($this->painLocation) && !isset($this->temperature)) {
			return 'Welcome, what are your symptoms?';
		}
		
		if (!isset($this->painType)) {
			return 'Please, describe how is your pain feels like.';
		}
		
		if (!isset($this->painLocation)) {
			return 'Where is your pain?';
		}
		
		if (!isset($this->temperature)) {
			return 'Please measure yourself and tell us, how high temperature you have.';
		}
		
		throw new \Exception('wierd combination of conditions');
	}
}