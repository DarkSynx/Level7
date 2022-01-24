<?php 


	$data1 = file_get_contents('test_code.l7');
	$data2 = file_get_contents('test_code2.l7');

	include dirname(__FILE__) . '/l7/init.php';

	use l7\l7 as codeL7;

	$time_start = microtime_float();
	$l7 = new codeL7( $array_file_list );
	$l7->start($data1);
	$rt = $l7->getdata();
	$time_end = microtime_float();
	$time1 = $time_end - $time_start;


	
	echo PHP_EOL . PHP_EOL . '------------------------------' . PHP_EOL ;	
	echo $rt ;
	echo PHP_EOL . PHP_EOL . '------------------------------' . PHP_EOL ;
	echo "temps d'execussion t1: $time1 secondes\n";
	
	$time_start = microtime_float();
	$rt = $l7->start($data2);
	$time_end = microtime_float();
	$time1 = $time_end - $time_start;


	echo PHP_EOL . '------------------------------' . PHP_EOL . PHP_EOL;
	echo "temps d'execussion t2: $time1 secondes\n";
	

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

?>