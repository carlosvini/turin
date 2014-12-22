<?php
namespace Turin;

abstract class Base {
	protected $children = array();
	protected $parser;
	protected $line;
	protected $column;
	public $parent;

	function __construct(Parser $parser, Base $parent = null) {
		$this->parent = $parent;
		// debug
		$this->parser = $parser;
		// copy because parser is a reference
		$this->line = $parser->getLine(); 
		$this->column = $parser->getColumn();
	}
	
	function make($class) {
		$class = '\Turin\\' . $class;
		return new $class($this->parser, $this);
	}

	function addChild($class) {
		$child = $this->make($class);
		$this->children[] = $child;
		return $child;
	}

	function beforeParse($term) {
		if ($term === "'") {
			return $this->make('StringSingle');
		} elseif ($term === '"') {
			return $this->make('StringDouble');
		} elseif ($term === "<<<'") {
			return $this->make('Nowdoc');
		} elseif ($term === "#") {
			return $this->make('CommentHash');
		} elseif ($term === "//") {
			return $this->make('Comment');
		} elseif ($term === "/*") {
			return $this->make('CommentBlock');
		}
		return $term;
	}

	function parse($term) {		
		if ($term === '?>' || $term === File::EOF) {
			$scope = $this;
			while (!$scope instanceof Tag) {
				$scope = $scope->close();
			}
			return $scope->parse($term);
		}

		$this->children[] = $term;
		if ($term instanceof Base) {
			return $term;
		}
		
		return $this;
	}
	function render() {
		return $this->before() . 
			($this->parser->debug() ? '<' . basename(get_class($this)) . '>' : '') . 
			$this->renderChildren() . 
			($this->parser->debug() ? '</' . basename(get_class($this)) . '>' : '') .
			$this->after();
	}

	function renderChildren() {
		$rendered = '';
		foreach ($this->children as $child) {
			$rendered .= ($child instanceof Base) ? $child->render() : $child;
		}
		return $rendered;
	}

	function before() {
		return '';
	}
	function getChildren() {
		return $this->children;
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
				if (is_string($next) && strpos($next, '(') === false && preg_match('/^_*[a-z]/', $value)) {
					$data[$key] = preg_replace('/\b\w+\b/', '$\0', $value);
				}
			}
		}
		return $data;
	}
	function close() {
		return $this->parent;
	}
}