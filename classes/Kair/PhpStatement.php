<?php
namespace Kair;

class PhpStatement extends Base {
	private $open_comment = false;

	function parse($term, $line, $column) {
		if ($term == "'") {
			return $this->data[] = new PhpSingleString($this);
		}
		if ($term == '"') {
			return $this->data[] = new PhpDoubleString($this);
		}
		if ($term == "<<<'") {
			return $this->data[] = new PhpNowdoc($this);
		}
		if ($term == "#") {
			$this->open_comment = true;
			return $this->data[] = new PhpComment($this);	
		}
		if ($term == "\n") {
			if ($this->open_comment) {
				$comment = array_pop($this->data);
			}
			$whitespace = '';
			if (trim(end($this->data)) === '') {
				$whitespace = array_pop($this->data);
			}
			$this->data[] = ';';
			if ($this->open_comment) {
				$this->open_comment = false;
				$this->data[] = $whitespace . $comment;
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
			'static'
		);
		$this->data = $this->replaceVariables($this->data, $reserved);
		return $this->data;
	}
}