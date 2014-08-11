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

$scope = new Kair\File;

$matches = array();
preg_match_all('~(<%=|<%|%>|<<<\'|<<<|\n|[^\n\S]+|\w+|[^\w\s])~', $content, $matches);
$line = 0;
$char = 0;
foreach ($matches[0] as $match) {
  if ($match == "\n") {
    $line++;
    $column = 0;
  } else {
    $column += strlen($match);
  }
	$scope = $scope->parse($match, $line, $column);
}
$scope = $scope->parse(Kair\File::EOF, $line, $column);

if (!$scope instanceof Kair\File) {
  throw new Kair\Exception('Unclosed ' . get_class($scope));
}

highlight_string($scope);

// echo '<pre>';
// echo htmlspecialchars($scope);