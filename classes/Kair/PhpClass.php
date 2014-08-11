<?php
namespace Kair;

class PhpClass extends Base {
	protected $name_found = false;
	protected $extends_found = false;
	protected $parent_found = false;
	protected $eol_found = false;

	function parse($term) {
		if (!$this->data) {
			$declaration = new PhpClassDeclaration($this);
			$declaration->parse($term);
			$this->data[] = $declaration;
			return $declaration;
		}
		if (in_array($term, array('public', 'protected', 'private', 'var'))) {
			$statement = new PhpStatement($this);
			$statement->parse($term);
			$this->data[] = $statement;
			return $statement;
		}
		
		/*
		if (!$this->name_found) {
			if (trim($term)) {
				if (!preg_match('/^\w+$/', $term)) {
					throw new Exception('Expected class name, but got this instead: ' . $term);
				}
				$this->name_found = true;
				$this->data[] = $term;
				return $this;
			}
		} else {
			if (!$this->extends_found) {
				if ($term == '<') {
					$this->extends_found = true;
					$this->data[] = 'extends';
					return $this;
				}
			} else {
				if (!$this->eol_found) {
					if (!strstr($term, PHP_EOL)) {
						throw new Exception('Expected new line, but got this instead: ' . $term);
					}
					$this->eol_found = true;
					$this->data[] = ' {' . $term;
					return $this;
				}
			}
		}
		*/
		switch ($term) {
			case 'def':
				$function = new PhpFunction($this);
				$this->data[] = $function;
				return $function;
			case 'end':
				return $this->parent;
		}
		return parent::parse($term);
	}

	function before() {
		return 'class';
	}
	function after() {
		return '}';
	}
}