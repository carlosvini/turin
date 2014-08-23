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
				return $this->data[] = new PhpClass($this, $line, $column);
			case File::EOF:
				return $this->parent;
			default:
				if (!$term instanceof Base && trim($term)) {
					$statement = new PhpStatement($this, $line, $column);
					return $this->data[] = $statement->parse($term, $line, $column);
				}
		}
		
		return parent::parse($term, $line, $column);
	}
}