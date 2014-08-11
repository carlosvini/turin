<?php
namespace Kair;

class PhpTag extends Base {

	function parse($term) {
		if (strpos($term, '%>') !== false) {
			$terms = explode('%>', $term);
			$tag = $terms[0] . '%>';
			if ($tag == '%>') {
				if ($terms[1]) {
					return $this->parent->parse($terms[1]);
				}
				return $this->parent;
			}
			
		}
		switch ($term) {
			case '<%=':
				$term = '<?php echo';
				break;
			case '<%':
				$term = '<?php';
				break;
			case 'class':
				$class = new PhpClass($this);
				$this->data[] = $class;
				return $class;
		}
		return parent::parse($term);
	}

	function after() {
		return '?>';
	}
}