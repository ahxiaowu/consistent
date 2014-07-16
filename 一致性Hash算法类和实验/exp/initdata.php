<?php
/**
 * 为各memcached节点,各充入1000条数据
 * 步骤: 引入配置文件,循环各节点,连接填入数据
 * 
 */
set_time_limit(0);
require './config.php';
require './ConsistentHash.class.php';
require './ModHash.class.php';

// 创建memcache的操作类
$mem = new memcache();

// 实例化分布式算法类
$dist = new $_dist();


// 循环的添加服务器
foreach($_memServer as $k=>$v){
	$dist->addNode($k);
}


for($i=0;$i<=10000;$i++){
	$key = 'key'.sprintf('%04d',$i);
	$val = 'value'.$i;
	$server = $dist->lookup($key);
	$mem->connect($_memServer[$server]['host'],$_memServer[$server]['port'],2);
	$mem->add($key,$val,0,0);

	$mem->close();
	usleep(3000);
}

echo 'full OK';





















/*
不用了 这段代码
// 实例化分布式算法类
foreach($_memServer as $key=>$server){
	$mem->connect($server['host'],$server['port'],2);
	for($i=1;$i<=1000;$i++){
		$mem->add('key'.$i,'value'.$i,0,0);
	}
	echo $key.' OK<hr/>';
}
*/



?>