<?php
/**
 * 模拟减少一台服务器,并请求
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

// 模拟少一台服务器
$dist->delNode('D');

for($i=1;$i<100000;$i++){
	$num = $i/10000;
	$key = 'key'.sprintf('%04d',$num);
	$val = 'value'.$i;
	$server = $dist->lookup($key);
	$mem->connect($_memServer[$server]['host'],$_memServer[$server]['port'],2);
	if(!$mem->get($key)){ # 要是节点,无此缓存则添加
		$mem->add($key,$val,0,0);
	}
	$mem->close();
	usleep(3000);
}


?>