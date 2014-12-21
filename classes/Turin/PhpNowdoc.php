<?php
namespace Turin;

class PhpNowdoc extends Base {
	protected $name;

	function preParse($term, $line, $column) {
    // don't parse PHP code inside strings
    return $term;
  }

	function parse($term, $line, $column) {
		if (!$this->name) {
			$this->name = $term;
		} elseif ($term == $this->name && end($this->data) === "\n") {
			return $this->parent;
		}
		return parent::parse($term, $line, $column);
	}

	function before() {
		return "<<<'";
	}

	function after() {
		return $this->name;
	}
}