<?php
namespace Turin;

class TagEcho extends Tag {
	function before() {
		return '<?=';
	}
}