<?php
namespace Turin;

class Funktion extends Base {
	
	function parse($term) {
		switch ($term) {
			case '}':
				return $this->close();
		}
		return parent::parse($term);
	}
	
	function before() {
		return 'function';
	}
	
	function after() {
		return '}';
	}
}