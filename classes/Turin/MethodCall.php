<?php
namespace Turin;

class MethodCall extends Base {

	function parse($term) {
    if ($term === ")") {
      $this->data[] = $term;
      return $this->parent;
    }
    if ($term === "\n") {
      $this->data[] = $term;
      return $this->parent;
    }
		return parent::parse($term);
	}

  function before() {
    return '->';
  }
  function after() {
    //return '}}';
  }
}