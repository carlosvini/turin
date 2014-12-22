<?php
require 'vendor/autoload.php';

$parser = new \Turin\Parser('examples/lady.turin');

//file_put_contents('examples/simple.php', $parser->toPhp());

highlight_string($parser->toPhp());
