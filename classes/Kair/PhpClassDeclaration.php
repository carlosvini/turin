<?php
namespace Kair;

class PhpClassDeclaration extends Base {
	private $open_comment = false;

	function parse($term, $line, $column) {
		if ($term == "\n") {
			list($space1, $name, $space2, $extends, $space3) = $this->data;
			
			if (trim($space1) !== '') {
				throw new Exception('Expected whitespace, but got this instead: ' . $space1);
			}
			if (!preg_match('/^\w+$/', $name)) {
				throw new Exception('Expected class name, but got this instead: ' . $name);
			}
			if ($extends) {
				if (trim($space2) !== '') {
					throw new Exception('Expected whitespace, but got this instead: ' . $space2);
				}
				if ($extends != '<')  {
					throw new Exception('Expected <, but got this instead: ' . $extends);
				}
				$this->data[3] = 'extends';
				if (trim($space3)) {
					throw new Exception('Expected whitespace, but got this instead: ' . $space3);
				}
				$parent = '';
				for ($i = 5; $i < count($this->data); $i++) {
					if (!is_string($this->data[$i]) || !trim($this->data[$i])) {
						break;
					}
					$parent .= $this->data[$i];
				}
				if (!preg_match('/^[\w:]+$/', $parent) || preg_match('/(^|[^:]):[^:]/', $parent)) {
					throw new Exception('Expected parent class name, but got this instead: ' . $parent);
				}
				array_splice($this->data, 5, $i - 5, str_replace('::', '\\', $parent));
			}
			if ($this->open_comment) {
					$comment = array_pop($this->data);
				}
				$whitespace = '';
				if (trim(end($this->data)) === '') {
					$whitespace = array_pop($this->data);
				}
				$this->data[] = ' {';
				if ($this->open_comment) {
					$this->open_comment = false;
					$this->data[] = $whitespace . $comment;
				}
			$this->data[] = $term;
			return $this->parent;
		}
		if ($term == "#") {
			$this->open_comment = true;
			return $this->data[] = new PhpComment($this, $line, $column);	
		}

		return parent::parse($term, $line, $column);
	}
}