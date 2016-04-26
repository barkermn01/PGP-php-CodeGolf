<?php
class CodeGolf{
	public function __construct(&$argv){
		$filePath = $argv[1];
		unset($argv[1]);
		$argv = array_values($argv);
		if(file_exists($filepath)){
			$this->loadFile($filePath);
		}else{
			run($filePath);
		}
	}

	private function loadFile($filepath){
		$this->run(file_get_contents($filepath));
	}

	private function run($inp){
		$replace = array(
				"func(" => "function(",
				"f(" => "for(",
				"w(" => "while(",
				"fe(" => "fe(",
				"st(" => "str_replace(",
				"e " => "echo ",
				"sr(" => "str_replace(",
				"p(" => "print(",
		);
		$inp = str_replace(array_keys($replace), array_values($replace), $inp);
		$ret = eval($inp);
		echo $ret;
	}
}
new CodeGolf($argv);
echo "\r\n";
