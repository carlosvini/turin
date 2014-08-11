<?php
namespace Kair;

class PhpNowdoc extends Base {
	protected $name;

	function parse($term) {
		if (!$this->name) {
			$this->name = $term;
		} elseif ($term == $this->name && substr(end($this->data), -1) === "\n") {
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