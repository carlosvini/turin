<?php
namespace Kair;

class PhpClassDeclaration extends Base {
	
	function parse($term, $line, $column) {
		if ($term == "\n") {
			list($space1, $name, $space2, $extends, $space3) = $this->data;
			
			if (trim($space1)) {
				throw new Exception('Expected whitespace, but got this instead: ' . $space1);
			}
			if (!preg_match('/^\w+$/', $name)) {
				throw new Exception('Expected class name, but got this instead: ' . $name);
			}
			if ($extends) {
				if (trim($space2)) {
					throw new Exception('Expected whitespace, but got this instead: ' . $space2);
				}
				if ($extends != '<')  {
					throw new Exception('Expected <, but got this instead: ' . $extends);
				}
				$this->data[3] = 'extends';
				if (trim($space3)) {
					throw new Exception('Expected whitespace, but got this instead: ' . $space3);
				}
				$parent = rtrim(implode('', (array_slice($this->data, 5))));
				
				if (!preg_match('/^[\w:]+$/', $parent) || preg_match('/(^|[^:]):[^:]/', $parent)) {
					throw new Exception('Expected parent class name, but got this instead: ' . $parent);
				}
				$this->data = array_slice($this->data, 0, 5);
				$this->data[] = str_replace('::', '\\', $parent);
			}
			$this->data[] = ' {';
			$this->data[] = $term;
			return $this->parent;
		}

		return parent::parse($term, $line, $column);
	}
}