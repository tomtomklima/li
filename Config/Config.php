<?php

namespace li\Config;

class Config {
	private $settings;
	
	public function __construct($file = 'settings.ini') {
		$this->settings = parse_ini_file($file);
	}
	
	public function __get($varName) {
		return $this->settings[$varName];
	}
}