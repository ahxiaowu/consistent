<?php
/**
 * 统计各节点的平均命中率
 */
require './config.php';
$mem = new memcache();

$gets = 0;
$hits = 0;
$rate = 1;

foreach($_memServer as $key=>$server){
	$mem->connect($server['host'],$server['port'],2);
	$res = $mem->getStats();
	$gets += $res['cmd_get'];
	$hits += $res['get_hits'];
}

if($gets > 0){
	$rate = $hits/$gets;
}

echo $rate;

/*
	echo $key.' : Status:<br/><pre>';
	print_r($mem->getStats());
	echo '</pre><hr />';
 */
?>