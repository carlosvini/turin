<?php
namespace Kair;

class PhpStatement extends Base {
	
	function parse($term) {
		if (strstr($term, PHP_EOL)) {
			$this->data[] = ';';
			$this->data[] = $term;
			return $this->parent;
		}
		return parent::parse($term);
	}

	public function getData() {
		$reserved = array(
			'public',
			'private',
			'protected',
			'var',
			'false',
			'null',
			'true'
		);
		$this->data = $this->replaceVariables($this->data, $reserved);
		return $this->data;
	}
}