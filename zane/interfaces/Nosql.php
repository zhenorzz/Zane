<?php
namespace zane\interfaces;
interface Nosql  
{  
	public function db($db);

	public function table($table);

	public function where($where);

	public function order($order);

	public function select();

	public function add(array $data);

	public function save(array $data,array $options=null);

	public function delete(array $options);
}  
