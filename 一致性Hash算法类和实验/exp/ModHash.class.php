<?php
/**
 * 取模算法 Hash
 */

class ModHash {

	private $_nodes = array();  # 节点数组
	private $_cnt   = 0;		# 节点个数

	public function addNode($node){
		if(in_array($node, $this->_nodes)){
			 return true;
		}
		$this->_nodes[] = $node;
		$this->_cnt += 1;

		return true;
	}

	public function delNode($node){
		if(!in_array($node, $this->_nodes)){
			 return true;
		}

		$key = array_search($node, $this->_nodes);
		unset($this->_nodes[$key]);
		# 重新从0排数组的索引
		$this->_nodes = array_merge($this->_nodes);
		$this->_cnt -= 1;
		return true;
	}
	
	public function lookup($key){
		$node = $this->hashCode($key) % $this->_cnt;
		return $this->_nodes[$node];
	}

	public function hashCode($str){
		# 把字符串转成32位无符号整数
		return sprintf('%u',crc32($str));
	}
}

/*
header('Content-Type:text/html;charset=UTF-8');
$con = new ModHash();
$con->addNode('a');
$con->addNode('b');
$con->addNode('c');

echo '当前的键计算的hash落点是:';
echo $con->hashCode('name').'<hr />';
echo $con->lookup('name');
*/

?>