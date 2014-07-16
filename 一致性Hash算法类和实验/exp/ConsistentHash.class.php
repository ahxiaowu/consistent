<?php
/**
 * 一致性hash的php实现
 */

class ConsistentHash {

	private $_nodes = array();
	private $_multi = 64;         # 虚拟节点数量
	private $_postion = array();  # 虚拟节点位置
	
	/**
	 * 把字符串转成32位无符号整数
	 * @param  String $str 字符串
	 * @return int
	 */
	public function hashCode($str){
		# 把字符串转成32位无符号整数
		return sprintf('%u',crc32($str));
	}

	/**
	 * ★★★ 查找节点 ★★★
	 * @param  String $key 节点名
	 */
	public function lookup($key){
		$point = $this->hashCode($key);

		# 先取圆球上最小的一个节点当作结果
		$node = current($this->_postion);
		foreach($this->_postion as $k=>$v){
			if($point <= $k){
				$node = $v;
				break;
			}
		}
		return $node;
	}

	/**
	 * 添加一个节点 
	 * @param String $node 节点
	 */
	public function addNode($node){
		for($i=0;$i<$this->_multi;$i++){
			$virtNodeName = $node.'-'.$i;
			$this->_postion[$this->hashCode($virtNodeName)] = $node;
		}
		$this->_sortVirtNode();
	}

	/**
	 * 循环所有的虚拟节点
	 * @param  String $node 节点名
	 */
	public function delNode($node){
		foreach($this->_postion as $k=>$v){
			if($v == $node){
				unset($this->_postion[$k]);
			}
		}
	}

	/**
	 * 格式化打印出来节点
 	 */
	public function printPostion(){
		echo '<pre>';
		print_r($this->_postion);
		echo '</pre>';
	}

	/**
	 * 虚拟节点排序
	 */
	private function _sortVirtNode(){
		ksort($this->_postion,SORT_REGULAR);
	}
}
?>