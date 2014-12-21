<?php
namespace Turin;

class PhpFunction extends Base {
	private $close = false;
	function parse($term, $line, $column) {
		if ($this->close) {
			if ($term != '(') {
				return $this->parent->parse($term, $line, $column);
			}
			$this->data[] = 'end'; // end() as a function
			$this->close = false;
		}

		switch ($term) {
			case 'end':
				$this->close = true;
				return $this;
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