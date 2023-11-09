<?php
/*******************************
Version : 1.0.0.0
Revised : vendredi 4 mai 2018, 10:23:58 (UTC+0200)
 *******************************/
namespace Core\Models;

use PDO;
use \Core\Models\Sport;

class SportManager extends Manager {
	protected $table = "sport";
	protected $pk = "idsport";

	/**
	 * Login de l’utilisateur
	 * @param login
	 * @param pwd
	 * @return Boolean
	 */

	public function newSport() {
		//fais appel à la fonction __construct de la classe Contracts
		return new Sport();
	}

	public function addSport($data){
		$q=$this->db->prepare('INSERT INTO `'.$this->table.'` (nom_sport, description) VALUES (:nom_sport, :description);');
		$q->bindValue(':nom_sport', $data->nom_sport(), PDO::PARAM_STR);
		$q->bindValue(':description', $data->description(), PDO::PARAM_STR);
		$q->execute();
	}

	public function updateSport($data){
		$q=$this->db->prepare('UPDATE `'.$this->table.'` SET nom_sport=:nom_sport, description=:description WHERE `' . $this->pk . '`=:id;');
		$q->bindValue(':nom_sport', $data->nom_sport(), PDO::PARAM_STR);
		$q->bindValue(':description', $data->description(), PDO::PARAM_STR);
		$q->bindValue(':id', $data->idsport(), PDO::PARAM_INT);
		$q->execute();

		$z = $this->db->prepare('SELECT * FROM `' . $this->table . '` WHERE `' . $this->table . '`.`' . $this->pk . '`='.$data->idsport().';');
		$z->execute();
		$donnees = $z->fetch(PDO::FETCH_ASSOC);

		return new Sport($donnees);
	}

	public function deleteSport($id) {
    $this->delete($id, $this->table); // Call the protected delete method from the parent class
	}
}