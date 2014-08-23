<?php
namespace Kair;

class PhpClassDeclaration extends Base {
	private $open_comment = false;

	function parse($term, $line, $column) {
		if ($term === "\n") {
			/*
			0 => $space1
			1 => $name
			2 => $space2
			3 => $extends
			4 => $space3
			*/
			
			if (trim($this->data[0]) !== '') {
				throw new Exception('Expected whitespace, but got this instead: ' . $this->data[0]);
			}
			if (!preg_match('/^\w+$/', $this->data[1])) {
				throw new Exception('Expected class name, but got this instead: ' . $this->data[1]);
			}
			if (isset($this->data[3])) {
				if (trim($this->data[2]) !== '') {
					throw new Exception('Expected whitespace, but got this instead: ' . $this->data[2]);
				}
				if ($this->data[3] !== '<')  {
					throw new Exception('Expected <, but got this instead: ' . $this->data[3]);
				}
				$this->data[3] = 'extends';
				if (trim($this->data[4])) {
					throw new Exception('Expected whitespace, but got this instead: ' . $this->data[4]);
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
				$this->data[] = $whitespace;
				$this->data[] = $comment;
			}
			$this->data[] = $term;
			return $this->parent;
		}
		if ($term instanceof PhpComment) {
			$this->open_comment = true;
		}

		return parent::parse($term, $line, $column);
	}
}