<?php
namespace Turin;

class Tag extends Base {

	protected $after = '?>';

	function parse($term) {
		switch ($term) {
			case File::EOF:
				$this->after = '';
			case '?>':
				return $this->close();
			case 'class':
				return $this->addChild('Klass');
			default:
				if (!$term instanceof Base && trim($term)) {
					return $this->addChild('Statement')->parse($term);
				}
		}
		
		return parent::parse($term);
	}

	function before() {
		return '<?php';
	}

	function after() {
		return $this->after;
	}
}