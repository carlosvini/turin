<?php
require 'vendor/autoload.php';

$parser = new \Turin\Parser('examples/simple2.turin');

//file_put_contents('examples/simple.php', $parser->toPhp());

highlight_string($parser->toPhp());
