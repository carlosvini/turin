<?php
namespace Turin;


class File extends Base {
	const EOF = 'EOF;';
	
	function beforeParse($term) {
		// don't parse PHP code outside PHP tags
	    return $term;
	  }

	function parse($term) {
		switch ($term) {
			case '<?=':
				return $this->addChild('TagEcho');
			case '<?':
				return $this->addChild('Tag');
			case self::EOF:
				return $this;
		}
		return parent::parse($term);
	}
}
