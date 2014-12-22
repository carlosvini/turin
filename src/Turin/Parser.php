<?php
namespace Turin;

class Parser {
	protected $file;
	protected $line;
	protected $column;
	protected $content;
	protected $debug = false;

	public function __construct($content, $isFile = true) {
		if ($isFile) {
			$this->file = $content;
			$this->content = file_get_contents($this->file);
		} else {
			$this->content = $content;
		}
	}

	public function debug() {
		return $this->debug;
	}

	public function getTokens() {
		$tokensRegex = array_map('preg_quote', [
			'<?=',	// echo php
			'<?',	// open php
			'?>', 	// close php
			"<<<'", // nowdoc open
			'<<<',	// heredoc open
		  	'//', 	// php comment
		  	'/*', 	// php comment block
		  	'*/' 	// php comment block end
		]);

		$tokensRegex = array_merge($tokensRegex, [
			'\n',
			'[^\n\S]+', // whitespaces, except \n
			'\w+', 		// keywords, variables
			'[^\w\s]' 	// special chars: !, =, <
		]);

		$matches = [];
		preg_match_all('~' . implode('|', $tokensRegex) . '~', $this->content, $matches);
		$tokens = $matches[0];
		$tokens[] = File::EOF;
		return $tokens;
	}

	public function toPhp() {
		$tokens = $this->getTokens();

		// Line and column used for debug only
		$this->line = 0;
		$this->column = 0;

		$scope = new File($this);
		foreach ($tokens as $token) {
			if ($token === "\n") {
			    //echo 'Line ' . $line . ' ==> ' . get_class($scope) . ': ' . nl2br($scope) . '<br>';
			  	$this->line++;
		 		$this->column = 0;
			} else {
		  		$this->column += strlen($token);
			}
		  	$token = $scope->beforeParse($token);
			$scope = $scope->parse($token);
		}

		if (!$scope instanceof File) {
		  	throw new Exception(
		  		'Unclosed ' . get_class($scope) . 
		  		', on file ' . $this->file . ', at line ' . $scope->getLine() . 
		  		', column ' . $scope->getColumn()
		  	);
		}
		
		return $scope->render();
	}

	function getLine() {
		return $this->line;
	}
	function getColumn() {
		return $this->column;
	}
	function getFile() {
		return $this->file;
	}

}