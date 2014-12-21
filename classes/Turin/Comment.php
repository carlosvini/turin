<?php
namespace Turin;

class Comment extends Base {

	function preParse($term) {
		// don't parse PHP code inside comments
		return $term;
	}

	function parse($term) {
		if ($term === "\n") {
			return $this->parent->parse($term);
		}

		return parent::parse($term);
	}
  
	function before() {
		return '//';
	}
}