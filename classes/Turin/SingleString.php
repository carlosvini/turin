<?php
namespace Turin;

class SingleString extends Base {
	private $escape = false;

	function preParse($term) {
    // don't parse PHP code inside strings
    return $term;
  }

	function parse($term) {
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
		return parent::parse($term);
	}

	function before() {
		return "'";
	}

	function after() {
		return "'";
	}
}