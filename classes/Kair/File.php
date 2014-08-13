<?php
namespace Kair;


class File extends Base {
	const EOF = 'EOF;';

	function parse($term, $line, $column) {
		switch ($term) {
			case '<%=':
			case '<%':
				$global = new PhpTag($this, $line, $column);
				$global->parse($term, $line, $column);
				$this->data[] = $global;
				return $global;
			case self::EOF:
				return $this;
		}

		return parent::parse($term, $line, $column);
	}
}
