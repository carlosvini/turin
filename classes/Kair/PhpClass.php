<?php
namespace Kair;

class PhpClass extends Base {
	protected $name_found = false;
	protected $eol_found = false;

	function parse($term) {
		if (!$this->name_found && trim($term)) {
			if (!preg_match('/^\w+$/', $term)) {
				throw new Exception('Expected class name, but got this instead: ' . $term);
			}
			$this->name_found = true;
			$this->data[] = $term;
			return $this;
		}
		if (!$this->eol_found && $this->name_found) {
			if (!strstr($term, PHP_EOL)) {
				throw new Exception('Expected new line, but got this instead: ' . $term);
			}
			$this->eol_found = true;
			$this->data[] = ' {' . $term;
			return $this;
		}
		switch ($term) {
			case 'def':
				$function = new PhpFunction($this);
				$this->data[] = $function;
				return $function;
			case 'end':
				return $this->parent;
		}
		return parent::parse($term);
	}
	
	function before() {
		return 'class';
	}
	function after() {
		return '}';
	}
}