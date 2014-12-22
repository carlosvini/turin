<?php
namespace Turin;

class CommentBlock extends Base {
	function beforeParse($term) {
		// don't parse PHP code inside comments
		return $term;
	}

	function parse($term) {
		if ($term === '*/') {
			return $this->close();
		}

		return parent::parse($term);
	}
  
	function before() {
		return '/*';
	}
	function after() {
		return '*/';
	}
}