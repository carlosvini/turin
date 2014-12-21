<?php
namespace Turin;


class File extends Base {
	const EOF = 'EOF;';

	function preParse($term, $line, $column) {
		// don't parse PHP code outside PHP tags
    return $term;
  }

	function parse($term, $line, $column) {
		switch ($term) {
			case '<%=':
			case '<%':
				$phpTag = new PhpTag($this, $line, $column);
				return $this->data[] = $phpTag->parse($term, $line, $column);
			case self::EOF:
				return $this;
		}
		return parent::parse($term, $line, $column);
	}
}
