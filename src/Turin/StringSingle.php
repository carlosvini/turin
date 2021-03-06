<?php
namespace Turin;

class StringSingle extends Base {
	protected $escape = false;
	const ENCLOSING = "'";

	function beforeParse($term) {
		// don't parse PHP code inside strings
		return $term;
	}

	function parse($term) {
		if ($this->escape) {
			// escape lasts 1 time
			$this->escape = false;
		} elseif ($term === '\\') {
			// next term will be ignored
			$this->escape = true;
		} elseif ($term === static::ENCLOSING) {
			return $this->close();
		}
		return parent::parse($term);
	}

	function before() {
		return static::ENCLOSING;
	}

	function after() {
		return static::ENCLOSING;
	}
}