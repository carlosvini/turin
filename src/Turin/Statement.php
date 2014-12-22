<?php
namespace Turin;

class Statement extends Base {
	private $open_method = false;

	function parse($term) {
		if ($term === '.') {
			return $this->addChild('MethodCall');
		}
		if ($term === "\n") {
			return $this->close()->parse($term);
		}
		return parent::parse($term);
	}

	public function close() {
		$whitespace = '';
		/* 
		if ($term instanceof Comment) {
			$term->setParent($this->parent);
			return $this->close()->parse($term);
		}
		*/
		$last = end($this->children);
		if (is_string($last) && trim($last) === '') {
			$whitespace = array_pop($this->children);
		}
		$this->children[] = ';';
		$this->children[] = $whitespace;
		return parent::close();
	}

	public function renderChildren() {
		$reserved = [
			'public',
			'private',
			'protected',
			'var',
			'false',
			'null',
			'true',
			'static',
			'namespace',
			'if',
			'new'
		];
		$this->children = $this->replaceVariables($this->children, $reserved);
		return parent::renderChildren();
	}
}