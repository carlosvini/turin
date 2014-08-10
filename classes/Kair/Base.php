<?php
namespace Kair;

abstract class Base {
	protected $data = array();
	protected $parent = null;

	function __construct($parent = null) {
		$this->parent = $parent;
	}

	function parse($term) {
		$this->data[] = $term;
		return $this;
	}
	function __toString() {
		return $this->before() . implode('', $this->data). $this->after();
	}
	function before() {
		return '';
	}
	function after() {
		return '';
	}
}