<?php
function __autoload($className) {
	require 'classes/' . str_replace('\\', '/', $className . '.php');
}

function kd() {
	var_dump(func_get_args());die;
}

$content = file_get_contents('classe.kair');
$content = '<%' . PHP_EOL . $content . PHP_EOL;

$scope = new Kair\File;

$matches = array();
preg_match_all('~(\s+|\w+|[^\w\s]+)~', $content, $matches);
foreach ($matches[0] as $match) {
	$scope = $scope->parse($match);
}
if ($scope instanceof Kair\PhpTag) {
	$scope = $scope->parent;
}

highlight_string($scope);

// echo '<pre>';
// echo htmlspecialchars($scope);