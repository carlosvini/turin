<?php
namespace Turin;

class Tag extends Base {

	function parse($term) {
		switch ($term) {
			case '<?':
				$term = '<?php';
				break;
			case '?>':
				$this->data[] = '?>';
				return $this->parent;
			case 'class':
				return $this->data[] = new Klass($this);
			case File::EOF:
				return $this->parent;
			default:
				if (!$term instanceof Base && trim($term)) {
					$statement = new Statement($this);
					return $this->data[] = $statement->parse($term);
				}
		}
		
		return parent::parse($term);
	}
}