<?php
namespace Kair;

class File extends Base {
	
	function parse($term) {
		if (strpos($term, '<%') !== false) {
			$terms = explode('<%', $term);
			
			$tag = '<%' . $terms[1];
			switch ($tag) {
				case '<%=':
				case '<%':
					if ($terms[0]) {
						parent::parse($terms[0]);
					}
					$global = new PhpTag($this);
					$global->parse($tag);
					$this->data[] = $global;
					return $global;
			}
		}
		
		return parent::parse($term);
	}
}