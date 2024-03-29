<?php
class CodeGolf{
	private $save = false;
	// constuct get access to $argv from global scope
	public function __construct(&$argv){
		// read the input
		$inp = $argv[1];
		// get rid of pgp.pgp and shift the array keys to be in the right place
		$argv[0] = $inp;
		unset($argv[0]);
		foreach ($argv as $key => $val){
			if(substr($val, 0, 2) == "--"){
				switch($val){
					case "--save":
					$this->save = true;
					break;
				}
				unset($argv[$key]);
			}
		}
		$argv = array_values($argv);
		// check if it's a file
		if(file_exists($inp)){
			// yes load the file
			$this->loadFile($inp, $argv[2]);
		}else{
			// no then it must be raw pgp try and run it
			$this->run($inp);
		}
	}

	private function loadFile(string $filepath){
		// call run with the file contents
		$this->run(file_get_contents($filepath));
	}

	private function run(string $inp){
		// enable access to $argv
		global $argv;
		// replace short hand pgp with php code
		$replace = array(
			// basic control stuct commands
			"fn(" => "function(",
			"f(" => "for(",
			"w(" => "while(",
			"p(" => "print(",
			// file handling
			"fo(" => "fopen(",
			"fe(" => "feof(",
			"fE(" => "!feof(",
			"fr(" => "fread(",
			"fw(" => "fwrite(",
			"fc(" => "fclose(",
			// string handling
			"sr(" => "str_replace(",
			"sR(" => "str_ireplace(",
			"ss(" => "str_split(",
			"sS(" => "str_shuffle(",
			"sb(" => "substr(",
			"se(" => "str_ends_with(",
			"sc(" => "str_contains(",
			"sl(" => "strlen(",
			"h(" => "hash(",
			
			// array handling
			"am(" => "array_merge(",
			"ak(" => "array_keys(",
			"av(" => "array_values(",
			"aS(" => "arsort(",
			"as(" => "asort(",
			"ar(" => "array_reverse(",
			"ae(" => "end(",
			"an(" => "next(",
			"e(" => "explode(",
			"i(" => "implode(",
			"c(" => "count(",
		);
		$inp = str_replace(array_keys($replace), array_values($replace), $inp);
		if($this->save){
			$fh = fopen("w", "pgpOutput.php");
			fwrite($fh, $inp);
			fclose($fh);
		}
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
