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
				$class = new PhpClass($this, $line, $column);
				$this->data[] = $class;
				return $class;
			case File::EOF:
				return $this->parent;
			default:
				$statement = new PhpStatement($this, $line, $column);
				return $this->data[] = $statement->parse($term, $line, $column);
		}
		return parent::parse($term, $line, $column);
	}
}