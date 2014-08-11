<?php
namespace Kair;

class PhpClass extends Base {

	function parse($term, $line, $column) {
		if (!$this->data) {
			$declaration = new PhpClassDeclaration($this);
			$declaration->parse($term, $line, $column);
			$this->data[] = $declaration;
			return $declaration;
		}
		if (in_array($term, array('public', 'protected', 'private', 'var'))) {
			$statement = new PhpStatement($this);
			$statement->parse($term, $line, $column);
			$this->data[] = $statement;
			return $statement;
		}

		switch ($term) {
			case 'def':
				$function = new PhpFunction($this);
				$this->data[] = $function;
				return $function;
			case 'end':
				return $this->parent;
		}
		return parent::parse($term, $line, $column);
	}

	function before() {
		return 'class';
	}
	function after() {
		return '}';
	}
}