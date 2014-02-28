<?php
//use zend put it all in this file since it will be small there is not much need to seperate it out
class Base {
	protected $table;
	protected $pk;
	protected $id;
	protected $db;

	function __construct($table, $pk = NULL, $id = NULL){
		$this->table = $table;
		$this->pk = $pk ? $pk : 'id';
		$this->id = $id;

		try {
			$this->db = Zend_Db::factory('Pdo_Mysql', array(
				'host'     => DB_HOST,
				'username' => DB_USER,
				'password' => DB_PASSWORD,
				'dbname'   => DB_NAME
			));
		} catch (Exception $e) {
			die($e->getMessage() . ' base construct');
		}
	}

	public function get($id = NULL){
		$id = ($id) ? $id : $this->id;
		try {
			$select = $this->db->select()->from($this->table)->where("{$this->pk} = ?", $id);
			return $select->query()->fetch(Zend_Db::FETCH_ASSOC);
		} catch (Exception $e) {
			$this->debug($e->getMessage(),'base get');
			return FALSE;
		}
	}

	public function delete($id = NULL){
		$id = ($id) ? $id : $this->id;
		try {
			$this->db->delete($this->table,array("{$this->pk} = ?" => $id));
			return TRUE;
		} catch (Exception $e) {
			$this->debug($e->getMessage(),'base delete');
			return FALSE;
		}
	}

	public function save($data){
		try {
			if(isset($data[$this->pk]) && $data[$this->pk]){
				$this->db->update($this->table,$data,array("{$this->pk} = ?" => $data[$this->pk]));
				return $data[$this->pk];
			} else {
				$this->db->insert($this->table, $data);
				return $this->db->lastInsertId();
			}
		} catch (Exception $e) {
			$this->debug($e->getMessage(),'base save');
			return FALSE;
		}
	}

	public function getAll(array $filter = array()){
		try {
			$select = $this->db->select()->from($this->table);
			if(count($filter)){
				foreach ($filter as $key => $value) {
					$select->where("{$key} = ?", $value);
				}
			}
			return $select->query()->fetchAll(Zend_Db::FETCH_ASSOC);
		} catch (Exception $e) {
			$this->debug($e->getMessage(),'base getAll');
			return FALSE;
		}
	}
}

class Song{}

class Player{}

class Vote{}
?>
