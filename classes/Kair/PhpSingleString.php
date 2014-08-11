<?php
namespace Kair;

class PhpSingleString extends Base {
	
	function parse($term) {
		if ($term == "'") {
			return $this->parent;
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