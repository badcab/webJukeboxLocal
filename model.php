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

		$this->db->setFetchMode(Zend_Db::FETCH_ASSOC);
	}

	public function get($id = NULL, $table = NULL, $pk = NULL){
		$id = ($id) ? $id : $this->id;
		$table = ($table) ? $table : $this->table;
		$pk = ($pk) ? $pk : $this->pk;
		try {
			$select = $this->db->select()->from($table)->where("{$pk} = ?", $id);
			return $this->db->fetchRow($select);
		} catch (Exception $e) {
			return FALSE;
		}
	}

	public function _delete($id = NULL, $table = NULL, $pk = NULL){
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

	public function _save($data, $table = NULL, $pk = NULL){
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
			return $this->db->fetchAll($select);
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
		//the above two lines are showing as unidex notice
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
			$this->_delete($this->table,"{$this->pk} != 0");
			return TRUE;
		} catch (Exception $e) {
			return FALSE;
		}
	}

	public function resetPlayCount(){
		$this->db->update('songs',array('has_played' => 0),array('id != ?' => '0'));
	}
}

class Player extends Base {
	function __construct(){
		parent::__construct(NULL);
	}

	public function loadSession($play_cap = 1){
		$select = $this->db->select()->from('songs')
			->where('has_played < ?', $play_cap)
		;

		$result = $this->db->fetchAll($select);

		$return = array();
		foreach($result as $r){
			$return[$r['category']][] = $r;
		}

		return $return;
	}

	public function playNext($song_bank){
		$select = $this->db->select()->from('queue')
			->order('id')
			->limit(HEAT_SIZE)
		;
		$result = $this->db->fetchAll($select);
		$top_vote_song_id = 0;
		$top_vote_count = 0;
		foreach($result as $r){
			$this->_delete($r['id'], 'queue');
			if($r['votes'] > $top_vote_count){
				$top_vote_count = $r['votes'];
				$top_vote_song_id = $r['id'];
			}
		}

		$song = $this->get($top_vote_song_id, 'songs');
		$song['has_played']++;
		$this->_save($song,'songs');

		$i = 0;
		while($i < (int)HEAT_SIZE){
			$key = array_rand($song_bank);
			if($song_bank[$key]){
				shuffle($song_bank[$key]);
				foreach($song_bank[$key] as $sub_key => $item){
					if($i >= (int)HEAT_SIZE){
						break;
					}
					$this->_save(array(
						'song_id' => $item['id'],
						'btn_label' => $item['name'] . ' - ' . $item['artist'],
					), 'queue');
					unset($song_bank[$key][$sub_key]);
					$i++;
				}
			}
		}

		foreach($song_bank as $key => $sb){
			if(!$sb){
				unset($song_bank[$key]);
			}
		}

		return array('song_bank' => $song_bank, 'path' => $song['file_path']);
	}
}

class Vote extends Base {
	function __construct(){
		parent::__construct(NULL);
	}

	public function cast($song_id){
		$select = $this->db->select()->from('queue')
			->where('song_id = ?', $song_id)
		;

		$result = $this->db->fetchRow($select);
		$result['votes']++;
		$this->_save($result,'queue');
	}

	public function poll(){
		$select = $this->db->select()->from('queue')
			->order('id')
			->limit(HEAT_SIZE)
		;
		return $this->db->fetchAll($select);
	}
}

class Queue extends Base {
	function __construct(){
		$table = 'queue';
		$pk = 'id';
		parent::__construct($table);
	}

	public function clear(){
		$this->_delete($this->table,array("id != ?" => 0));
	}

}
?>
