<?php
namespace Kair;

class PhpFunction extends Base {
	function parse($term, $line, $column) {
		switch ($term) {
			case 'end':
				return $this->parent;
		}
		return parent::parse($term, $line, $column);
	}

	function before() {
		return 'function';
	}
	function after() {
		return '}';
	}
}