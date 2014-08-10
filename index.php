<?php

$content = file_get_contents('classe.kair');
$content = '<%' . PHP_EOL . $content;

$matches = array();
$length = strlen($content);

function __autoload($className) {
	require 'classes/' . str_replace('\\', '/', $className . '.php');
}

function kd() {
	var_dump(func_get_args());die;
}

$scope = new Kair\File;
preg_match_all('~(\s+|\w+|[^\w\s]+)~', $content, $matches);
foreach ($matches[0] as $match) {
	$scope = $scope->parse($match);
}

highlight_string($scope);

