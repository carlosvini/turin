<?php
namespace Turin;

abstract class Base {
	protected $data = array();
	protected $line;
	protected $column;
	public $parent;

	function __construct($parent = null) {
		$this->parent = $parent;
		$this->line = $GLOBALS['line'];
		$this->column = $GLOBALS['column'];
	}

	function preParse($term) {
		if ($term === "'") {
			return new SingleString($this);
		} elseif ($term === '"') {
			return new DoubleString($this);
		} elseif ($term === "<<<'") {
			return new Nowdoc($this);
		} elseif ($term === "#") {
			return new CommentHash($this);	
		} elseif ($term === "//") {
			return new Comment($this);
		} elseif ($term === "/*") {
			return new CommentBlock($this);
		}
		return $term;
	}

	function parse($term) {
		$this->data[] = $term;
		if ($term instanceof Base) {
			return $term;
		}
		return $this;
	}
	function __toString() {
		return $this->before() . '(' . basename(get_called_class()) . ')' .
			implode('', $this->getData()) . '(/' . basename(get_called_class()) . ')' .
			$this->after();
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
	function getLine() {
		return $this->line;
	}
	function getColumn() {
		return $this->column;
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