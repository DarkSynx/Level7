<?php

	define('PATH_ROOT', dirname(__FILE__) . '/');
	var_dump(PATH_ROOT);
	
	require PATH_ROOT . 'l7.class.php';
	require PATH_ROOT . 'syntaxe.class.php';
	require PATH_ROOT . 'syntaxing.interface.php';
	require PATH_ROOT . 'gestionglobal.class.php';
	
		$array_file_list = new FilesystemIterator( PATH_ROOT . 'syntaxe/', FilesystemIterator::SKIP_DOTS );
		$inc = 0;
		$ncount = iterator_count($array_file_list);
		
		foreach ($array_file_list as $path => $entry) {
			echo '-> ' . $inc++ . '/' . $ncount . chr(32) . $entry->getFilename() . PHP_EOL;
			require $path;
		}			
	
		
?>