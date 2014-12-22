<?php
namespace Turin;

class Nowdoc extends Base {
	protected $name;
	
	function beforeParse($term) {
		// don't parse PHP code inside strings
		return $term;
	}
	
	function parse($term) {
		if (!$this->name) {
			$this->name = $term;
		} elseif ($term === $this->name && end($this->children) === "\n") {
			// needs to be in the start of line
			return $this->close();
		}
		return parent::parse($term);
	}
	
	function before() {
		return "<<<'";
	}

	function after() {
		return $this->name;
	}
}