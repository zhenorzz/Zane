<?php
namespace zane;
/**
*模板生成
*/
class Mongodb implements interfaces\Nosql
{
	private $manager; 
	private $db;
	private $table;
	private $where;
	private $order;
	public function __construct($db = null)
	{
		$this->manager = new \MongoDB\Driver\Manager("mongodb://localhost:27017");
		if (isset($db)) {
			$this->db = $db;
		}
	}
	public function db($db)
	{
		$this->db = $db;
	}

	public function table($table)
	{
		$this->table = $table;
		return $this;
	}

	public function where($where)
	{
		$this->where = $where;
		return $this;
	}

	public function order($order)
	{
		$this->order = $order;
		return $this;
	}

	public function select() 
	{
		$query = new \MongoDB\Driver\Query($this->where, $this->order);
		$cursor = $this->manager->executeQuery($this->db.'.'.$this->table, $query);
		return $cursor;
	}
	public function add(array $data)
	{
		$bulk = new \MongoDB\Driver\BulkWrite;
		$bulk->insert($data);
		$writeResult = $this->manager->executeBulkWrite($this->db.'.'.$this->table, $bulk);
		return $writeResult->getInsertedCount();
	}

	public function save(array $data,array $options=null)
	{
		$bulk = new \MongoDB\Driver\BulkWrite;
		$bulk->update($this->where,$data,["multi"=>false,"upsert" => false]);
		$result = $this->manager->executeBulkWrite($this->db.'.'.$this->table, $bulk);
		return $result->getMatchedCount();
	}

	public function delete()
	{
		# code...
	}
}