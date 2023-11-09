<?php
/*******************************
 * Version : 1.0.0.0
 * Revised : vendredi 4 mai 2018, 10:23:58 (UTC+0200)
 *******************************/

namespace Core\Models;

use PDO;
use Core\Classes\Utils;

abstract class Manager {
	protected $db;
	protected $prefix;
	protected $table;
	protected $pk;
	protected $metier;
	
	protected $errorMessage;
	
	/* pagination */
	protected $max = 10;
	
	function max() { return $this->max; }
	
	public function __construct() {
		$this->db = \Core\Database\myPDO::getInstance();
		$this->metier = '\Core\Models\\' . ucfirst($this->table);
	}
	
	/**
	 * Récupérer une formation en fonction de son ID
	 * @param int $id
	 * @return Formation
	 */
	public function get($id = 0, $tab) {
		$this->metier = '\Core\Models\\' . ucfirst($tab);
		$q = $this->db->prepare('SELECT * FROM `' . $tab . '` WHERE `' . $tab . '`.`id' . $tab . '`=:id');
		$q->bindValue(':id', $id, PDO::PARAM_INT);
		$q->execute();
		//$q->debugDumpParams();
		$donnees = $q->fetch(PDO::FETCH_ASSOC);
		
		if ($donnees !== false) return new $this->metier($donnees);
		return false;
	}
	
	// Récupérer la liste des clients, avec tri
	public function getList($sort="name", $tri="asc", $tab) {
		$this->metier = '\Core\Models\\' . ucfirst($tab);
		$list = array();
		
		$q=$this->db->prepare('SELECT * FROM `'.$tab.'` ORDER BY '.$sort.' '.$tri);
		$q->execute();
		
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){
			$list[] = new $this->metier($donnees);
		}
		return $list;
	}
	
	protected function delete(int $id, $tab) {
		$this->metier = '\Core\Models\\' . ucfirst($tab);
		$this->db->query("DELETE FROM `" . $tab . "` WHERE `id" . $tab . "`=" . $id);
	}

	public function new($tab){
		$this->metier = '\Core\Models\\' . ucfirst($tab);
		return new $this->metier;
	}

}