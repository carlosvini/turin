<?php
function __autoload($className) {
	require 'classes/' . str_replace('\\', '/', $className . '.php');
}

$parser = new \Turin\Parser('examples/simple.turin');

highlight_string($parser->toPhp());
