<?php
/*******************************
Version : 1.0.0.0
Revised : vendredi 4 mai 2018, 10:23:58 (UTC+0200)
 *******************************/
namespace Core\Models;

use PDO;
use \Core\Models\Postes;

class AgendaManager extends Manager {
	protected $table = "postes";
	protected $pk = "idposte";

	/**
	 * Login de l’utilisateur
	 * @param login
	 * @param pwd
	 * @return Boolean
	 */

	public function newPostes() {
		//fais appel à la fonction __construct de la classe Contracts
		return new Postes();
	}

	public function addPostes($data){
		$q=$this->db->prepare('INSERT INTO `'.$this->table.'` (nom_poste) VALUES (:nom_poste);');
		$q->bindValue(':nom_poste', $data->nom_poste(), PDO::PARAM_STR);
		$q->execute();
	}

	public function updatePostes($data){
		$q=$this->db->prepare('UPDATE `'.$this->table.'` SET nom_poste=:nom_poste WHERE `' . $this->pk . '`=:id;');
		$q->bindValue(':nom_poste', $data->nom_poste(), PDO::PARAM_STR);
		$q->bindValue(':id', $data->idposte(), PDO::PARAM_INT);
		$q->execute();

		$z = $this->db->prepare('SELECT * FROM `' . $this->table . '` WHERE `' . $this->table . '`.`' . $this->pk . '`='.$data->idposte().';');
		$z->execute();
		$donnees = $z->fetch(PDO::FETCH_ASSOC);

		return new Postes($donnees);
	}
}