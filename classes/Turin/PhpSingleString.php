<?php
namespace Turin;

class PhpSingleString extends Base {
	private $escape = false;

	function preParse($term, $line, $column) {
    // don't parse PHP code inside strings
    return $term;
  }

	function parse($term, $line, $column) {
		if (!$this->escape) {
			if ($term === "'") {
				return $this->parent;
			}
			if ($term === '\\') {
				$this->escape = true;
			}
		} else {
			$this->escape = false;
		}
		return parent::parse($term, $line, $column);
	}

	function before() {
		return "'";
	}

	function after() {
		return "'";
	}
}