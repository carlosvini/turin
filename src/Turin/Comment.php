<?php
namespace Turin;

class Comment extends Base {

	function beforeParse($term) {
		// don't parse PHP code inside comments
		return $term;
	}

	function parse($term) {
		if ($term === "\n") { 
			return $this->close()->parse($term);
		}

		return parent::parse($term);
	}
  
	function before() {
		return '//';
	}
}