<?php
namespace Turin;

class PhpComment extends Base {

  function preParse($term, $line, $column) {
    // don't parse PHP code inside comments
    return $term;
  }

	function parse($term, $line, $column) {
		if ($term === "\n") {
			return $this->parent->parse($term, $line, $column);
		}

		return parent::parse($term, $line, $column);
	}

	function before() {
		return '#';
	}
}