<?php
namespace Turin;

class Heredoc extends Nowdoc {	
	function before() {
		return "<<<";
	}
}