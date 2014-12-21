<?php
function __autoload($className) {
	require 'classes/' . str_replace('\\', '/', $className . '.php');
}

function showNewLine($array) {
	if (is_string($array)) {
		return str_replace("\n", '\n', $array);
	} elseif (is_array($array)) {
		foreach ($array as $key => $value) {
	  		$array[$key] = showNewLine($value);
		}
	}
  return $array;
}
function kd() {
  echo '<pre>';
	var_dump(showNewLine(func_get_args()));die;
}

$content = file_get_contents('examples/simple.turin');
$content = $content . PHP_EOL;

$tokensRegex = array(
	'<\?=', //echo php
	'<\?', // open php
	'\?>', // close php
	'<<<\'', // nowdoc open
	'<<<',	// nowdoc end
  	'\/\/', // php comment
  	'\/\*', // php comment block
  	'\*\/', // php comment block end
	'\n',
	'[^\n\S]+', // whitespaces, except \n
	'\w+', // keywords, variables
	'[^\w\s]' // special chars: !, =, <
);
$matches = array();
preg_match_all('~' . implode('|', $tokensRegex) . '~', $content, $matches);
$tokens = $matches[0];
$tokens[] = Turin\File::EOF;

// Line and column used for DEBUG only
$line = 0;
$column = 0;
$scope = new Turin\File(null);
foreach ($tokens as $token) {
	if ($token === "\n") {
    //echo 'Line ' . $line . ' ==> ' . get_class($scope) . ': ' . nl2br($scope) . '<br>';
  	$line++;
 		$column = 0;
	} else {
  	$column += strlen($token);
	}
  $token = $scope->preParse($token);
	$scope = $scope->parse($token);
}

if (!$scope instanceof Turin\File) {
  	throw new Turin\Exception('Unclosed ' . get_class($scope) . ', on line ' . $scope->getLine() . ', column ' . $scope->getColumn());
}

highlight_string($scope);

// echo '<pre>';
// echo htmlspecialchars($scope);