<?php
namespace Kair;

abstract class Base {
	protected $data = array();
	public $parent = null;

	function __construct($parent = null) {
		$this->parent = $parent;
	}

	function parse($term, $line, $column) {
		$this->data[] = $term;
		return $this;
	}
	function __toString() {
		return $this->before() . implode('', $this->getData()). $this->after();
	}
	function before() {
		return '';
	}
	function getData() {
		return $this->data;
	}
	function after() {
		return '';
	}

	function replaceVariables($data, $reserved) {
		foreach ($data as $key => $value) {
			if (is_string($value) && !in_array($value, $reserved)) {
				$next = isset($data[$key + 1]) ? $data[$key + 1] : '';
				if (strpos($next, '(') === false && preg_match('/^_*[a-z]/', $value)) {
					$data[$key] = preg_replace('/\b\w+\b/', '$\0', $value);
				}
			}
		}
		return $data;
	}
	
}