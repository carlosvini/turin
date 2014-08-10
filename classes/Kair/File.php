<?php
namespace Kair;

class File extends Base {
	
	function parse($term) {
		switch ($term) {
			case '<%':
				$global = new PhpTag($this);
				$this->data[] = $global;
				return $global;
		}
		return parent::parse($term);
	}
}