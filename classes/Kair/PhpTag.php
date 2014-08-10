<?php
namespace Kair;

class PhpTag extends Base {

	function parse($term) {
		switch ($term) {
			case 'class':
				$class = new PhpClass($this);
				$this->data[] = $class;
				return $class;
		}
		return parent::parse($term);
	}

	function before() {
		return '<?php';
	}
	function after() {
		return PHP_EOL . '?>';
	}
}