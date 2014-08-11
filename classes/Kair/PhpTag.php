<?php
namespace Kair;

class PhpTag extends Base {

	function parse($term, $line, $column) {
		switch ($term) {
			case '<%=':
				$term = '<?php echo';
				break;
			case '<%':
				$term = '<?php';
				break;
			case '%>':
				$this->data[] = '?>';
				return $this->parent;
			case 'class':
				$class = new PhpClass($this);
				$this->data[] = $class;
				return $class;
			case File::EOF:
				return $this->parent;
		}
		return parent::parse($term, $line, $column);
	}
}