<?php
namespace Kair;

class PhpFunction extends Base {
	function parse($term) {
		switch ($term) {
			case 'end':
				return $this->parent;
		}
		return parent::parse($term);
	}

	function before() {
		return 'function';
	}
	function after() {
		return '}';
	}
}