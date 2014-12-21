<?php
namespace Turin;

class PhpStatement extends Base {
	private $open_comment = false;
	private $open_method = false;

	function parse($term, $line, $column) {
		if ($term === '.') {
			return $this->data[] = new PhpMethodCall($this, $line, $column);
		}
		if ($term instanceof PhpComment) {
			// whitespaces before comments have special rules 
			$this->open_comment = true;
		}
		if ($term === "\n") {
			if ($this->open_comment) {
				$comment = array_pop($this->data);
			}
			$whitespace = '';
			if (trim(end($this->data)) === '') {
				$whitespace = array_pop($this->data);
			}
			if ($this->data) {
				$this->data[] = ';';
			}
			if ($this->open_comment) {
				$this->open_comment = false;
				$this->data[] = $whitespace;
				$this->data[] = $comment;
			}
			$this->data[] = $term;
			return $this->parent;
		}
		return parent::parse($term, $line, $column);
	}

	public function getData() {
		$reserved = array(
			'public',
			'private',
			'protected',
			'var',
			'false',
			'null',
			'true',
			'static',
			'namespace'
		);
		$this->data = $this->replaceVariables($this->data, $reserved);
		return $this->data;
	}
}