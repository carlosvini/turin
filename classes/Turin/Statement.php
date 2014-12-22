<?php
namespace Turin;

class Statement extends Base {
	private $open_comment = false;
	private $open_method = false;

	function parse($term) {
		if ($term === '.') {
			return $this->addChild('MethodCall');
		}
		if ($term instanceof Comment) {
			// whitespaces before comments have special rules 
			$this->open_comment = true;
		}
		if ($term === "\n") { //  $term === '? >' || $term === File::EOF
			$this->handleWhitespace();
			$this->children[] = $term;
			return $this->close();
		}
		return parent::parse($term);
	}

	protected function handleWhitespace() {
		if ($this->open_comment) {
			$comment = array_pop($this->children);
		}
		$whitespace = '';
		if (trim(end($this->children)) === '') {
			$whitespace = array_pop($this->children);
		}
		if ($this->children) {
			$this->children[] = ';';
		}
		if ($this->open_comment) {
			$this->open_comment = false;
			$this->children[] = $whitespace;
			$this->children[] = $comment;
		} else {
			$this->children[] = $whitespace;
		}
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
			'namespace'
		];
		$this->children = $this->replaceVariables($this->children, $reserved);
		return parent::renderChildren();
	}
}