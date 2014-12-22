<?php
namespace Turin;

class MethodCall extends Base {
    
	function parse($term) {
        if ($term === ")") {
            $this->children[] = $term;
            return $this->close();
        }
        if ($term === "\n") {
            $this->children[] = $term;
            return $this->close();
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