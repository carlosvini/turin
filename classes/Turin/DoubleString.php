<?php
namespace Turin;

class DoubleString extends Base {
	private $escape = false;
	function parse($term) {
		if (!$this->escape) {
			if ($term === '"') {
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
		return '"';
	}

	function after() {
		return '"';
	}
}