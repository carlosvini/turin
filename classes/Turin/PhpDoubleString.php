<?php
namespace Turin;

class PhpDoubleString extends Base {
	private $escape = false;
	function parse($term, $line, $column) {
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
		return parent::parse($term, $line, $column);
	}

	function before() {
		return '"';
	}

	function after() {
		return '"';
	}
}