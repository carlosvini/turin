<?php
namespace Turin;

class Nowdoc extends Base {
	protected $name;

	function preParse($term) {
		// don't parse PHP code inside strings
		return $term;
	}

	function parse($term) {
		if (!$this->name) {
			$this->name = $term;
		} elseif ($term == $this->name && end($this->data) === "\n") {
			return $this->parent;
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