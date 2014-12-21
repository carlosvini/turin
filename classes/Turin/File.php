<?php
namespace Turin;


class File extends Base {
	const EOF = 'EOF;';

	function preParse($term) {
		// don't parse PHP code outside PHP tags
    return $term;
  }

	function parse($term) {
		switch ($term) {
			case '<?=':
			case '<?':
				$phpTag = new Tag($this);
				return $this->data[] = $phpTag->parse($term);
			case self::EOF:
				return $this;
		}
		return parent::parse($term);
	}
}
