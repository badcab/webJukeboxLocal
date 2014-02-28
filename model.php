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

	public function get($id = NULL, $table = NULL, $pk = NULL){
		$id = ($id) ? $id : $this->id;
		$table = ($table) ? $table : $this->table;
		$pk = ($pk) ? $pk : $this->pk;
		try {
			$select = $this->db->select()->from($table)->where("{$pk} = ?", $id);
			return $select->query()->fetch(Zend_Db::FETCH_ASSOC);
		} catch (Exception $e) { 
			return FALSE;
		}
	}

	public function _delete($id = NULL, $table = NULL, $pk = NULL){ //add option to pass in pk
		$id = ($id) ? $id : $this->id;
		$table = ($table) ? $table : $this->table;
		$pk = ($pk) ? $pk : $this->pk;
		try {
			$this->db->delete($table,array("{$pk} = ?" => $id));
			return TRUE;
		} catch (Exception $e) { 
			return FALSE;
		}
	}

	public function _save($data, $table = NULL, $pk = NULL){ //add option to pass in pk
		$table = ($table) ? $table : $this->table;
		$pk = ($pk) ? $pk : $this->pk;
		try {
			if(isset($data[$this->pk]) && $data[$this->pk]){
				$this->db->update($table,$data,array("{$pk} = ?" => $data[$this->pk]));
				return $data[$this->pk];
			} else {
				$this->db->insert($table, $data);
				return $this->db->lastInsertId();
			}
		} catch (Exception $e) { 
			return FALSE;
		}
	}

	public function getAll(array $filter = array(), $table = NULL){
		$table = ($table) ? $table : $this->table; 
		try {
			$select = $this->db->select()->from($table);
			if(count($filter)){
				foreach ($filter as $key => $value) {
					$select->where("{$key} = ?", $value);
				}
			}
			return $select->query()->fetchAll(Zend_Db::FETCH_ASSOC);
		} catch (Exception $e) { 
			return FALSE;
		}
	}
}

class Song extends Base {
	function __construct($id = NULL){
		$table = 'songs';
		$pk = 'id';
		parent::__construct($table, $pk, $id);
	}

	public function scanMusicDir(){
		require_once('getid3/getid3.php');
		$getID3 = new getID3();
		$this->clearSongs();
		$music_root = scandir(MUSIC_DIRECTORY);
		$dir = array();
		foreach($music_root as $file){
			if(is_dir(MUSIC_DIRECTORY . '/' . $file) && substr($file, 0, 1) != '.'){
				foreach(scandir(MUSIC_DIRECTORY . '/' . $file) as $music){
					if(is_file(MUSIC_DIRECTORY . '/' . $file . '/' . $music) && $audio_tag = $getID3->analyze(MUSIC_DIRECTORY . '/' . $file . '/' . $music)){
						$file_path = MUSIC_DIRECTORY . '/' . $file . '/' . $music;
						if(isset($audio_tag['tags']['id3v1'])){
							$dir[] = array(
								'file_path' => $file_path,
								'name' => $audio_tag['tags']['id3v1']['title'][0],
								'artist' => $audio_tag['tags']['id3v1']['artist'][0],
								'category' => $file,
							);
						} elseif(isset($audio_tag['tags']['quicktime'])) {
							$dir[] = array(
								'file_path' => $file_path,
								'name' => $audio_tag['tags']['quicktime']['title'][0],
								'artist' => $audio_tag['tags']['quicktime']['artist'][0],
								'category' => $file,
							);
						} elseif (isset($audio_tag['tags']['id3v2'])) {
							$dir[] = array(
								'file_path' => $file_path,
								'name' => $audio_tag['tags']['id3v2']['title'][0],
								'artist' => $audio_tag['tags']['id3v2']['artist'][0],
								'category' => $file,
							);
						}
					}
				}
			}
		}
		foreach ($dir as $song) {
			$this->_save($song);
		}
	}

	private function clearSongs(){
		try {
			$this->db->_delete($this->table,"{$this->pk} != 0");
			return TRUE;
		} catch (Exception $e) {
			$this->debug($e->getMessage(),'base delete');
			return FALSE;
		}
	}
}

class Player extends Base {
	function __construct(){ 
		parent::__construct(NULL);
	}
	
	public function loadSession($play_cap = 1){
		$result = $this->db->select()->from('songs')
			->where('has_player < ?', $play_cap)
			//also not in queue or in or in head
		->query()->fetchAll(Zend_Db::FETCH_ASSOC);
		
		$return = array();
		foreach($result as $r){
			$return[$r['category']][] = $r['id'];
		}
		
		return $return; 
	}
	
	public function playNext($song_bank){
		//get the path to the next song in the queue
		//remove that song from the queue
		//select next winning song and add it to the queue
		//select 3 songs randomly and add to vote stack (use $song_bank)
		//return song path to play
	}
	
	private function selectWinner(){}
	
	private function selectHeat($song_bank){}
}

class Vote extends Base {
	function __construct(){ 
		parent::__construct(NULL);
	}
	
	public function cast($song_id, $heat_id){
		//incrament the associated song id vote total by one
	}
	
	public function poll($heat_id){
		//return the current vote counts for a $heat
	}
}
?>
