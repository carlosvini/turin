<?php
namespace Kair;

class PhpComment extends Base {
	function parse($term, $line, $column) {
		if ($term == "\n") {
			return $this->parent->parse($term, $line, $column);
		}

		return parent::parse($term, $line, $column);
	}

	function before() {
		return '#';
	}
}