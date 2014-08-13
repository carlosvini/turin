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

$content = file_get_contents('classe.kair');
$content = '<%' . PHP_EOL . $content . PHP_EOL;

$tokensRegex = array(
	'<%=', 
	'<%',
	'%>',
	'<<<\'',
	'<<<',
	'\n',
	'[^\n\S]+', // whitespaces, except \n
	'\w+', // keywords, variables
	'[^\w\s]' // special chars: !, =, <
);
$matches = array();
preg_match_all('~' . implode('|', $tokensRegex) . '~', $content, $matches);
$tokens = $matches[0];
$tokens[] = Kair\File::EOF;

// Line and column used for DEBUG only
$line = 0;
$column = 0;
$scope = new Kair\File(null, $line, $column);
foreach ($tokens as $token) {
  	if ($token == "\n") {
    	$line++;
   		$column = 0;
  	} else {
    	$column += strlen($token);
  	}

	$scope = $scope->parse($token, $line, $column);
}

if (!$scope instanceof Kair\File) {
  	throw new Kair\Exception('Unclosed ' . get_class($scope) . ', on line ' . $scope->getLine() . ', column ' . $scope->getColumn());
}

highlight_string($scope);

// echo '<pre>';
// echo htmlspecialchars($scope);