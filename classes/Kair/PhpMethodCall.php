<?php
namespace Kair;

class PhpMethodCall extends Base {

	function parse($term, $line, $column) {
    if ($term === ")") {
      $this->data[] = $term;
      return $this->parent;
    }
    if ($term === "\n") {
      $this->data[] = $term;
      return $this->parent;
    }
		if ($term === 'unless') {
      $this->data[] = $term;
      return $this->parent;
    }
		return parent::parse($term, $line, $column);
	}

  function before() {
    return '->';
  }
  function after() {
    //return '}}';
  }
}