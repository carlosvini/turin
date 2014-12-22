<?php
namespace Turin;

class StringDouble extends Base {
	private $escape = false;

	function parse($term) {
		if ($this->escape) {
			// escape lasts 1 time
			$this->escape = false;
		} elseif ($term === '\\') {
			// next term will be ignored
			$this->escape = true;
		} elseif ($term === '"') {
			return $this->close();
		}
		return parent::parse($term);
	}

	function before() {
		return '"';
	}

	function after() {
		return '"';
	}
}