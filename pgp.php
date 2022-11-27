<?php
class CodeGolf{
	// constuct get access to $argv from global scope
	public function __construct(&$argv){
		// read the input
		$inp = $argv[1];
		// get rid of pgp.pgp and shift the array keys to be in the right place
		$argv[0] = $inp;
		unset($argv[0]);
		$argv = array_values($argv);
		// check if it's a file
		if(file_exists($inp)){
			// yes load the file
			$this->loadFile($inp);
		}else{
			// no then it must be raw pgp try and run it
			$this->run($inp);
		}
	}

	private function loadFile($filepath){
		// call run with the file contents
		$this->run(file_get_contents($filepath));
	}

	private function run($inp){
		// enable access to $argv
		global $argv;
		// replace short hand pgp with php code
		$replace = array(
			"fn(" => "function(",
			"f(" => "for(",
			"w(" => "while(",
			"fe(" => "fe(",
			"sr(" => "str_replace(",
			"sR(" => "str_ireplace(",
			"ss(" => "str_split(",
			"sS(" => "str_shuffle(",
			"se(" => "str_ends_with(",
			"sc(" => "str_contains(",
			"h(" => "hash(",
			"p(" => "print(",
			"am(" => "array_merge(",
			"ak(" => "array_keys(",
			"av(" => "array_values(",
			"ars(" => "arsort(",
			"as(" => "asort(",
			"e(" => "end(",
			"n(" => "next(",
		);
		$inp = str_replace(array_keys($replace), array_values($replace), $inp);
		// run the code if it returns caputre it
		$ret = eval($inp);
		// echo out the return
		echo $ret;
	}
}
// start the CodeGolf
new CodeGolf($argv);
// make sure we keep newline at end of output for console
echo "\r\n";
