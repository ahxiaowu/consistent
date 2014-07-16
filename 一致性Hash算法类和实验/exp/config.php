<?php
$_memServer = array(
	'A' => array('host'=>'127.0.0.1','port'=>'11211'),
	'B' => array('host'=>'127.0.0.1','port'=>'11212'),
	'C' => array('host'=>'127.0.0.1','port'=>'11213'),
	'D' => array('host'=>'127.0.0.1','port'=>'11214'),
	'E' => array('host'=>'127.0.0.1','port'=>'11215')
);

# 分布式策略 ModHash:求余 ConsistentHash:一致性hash
$_dist = 'ConsistentHash';  # ConsistentHash

?>