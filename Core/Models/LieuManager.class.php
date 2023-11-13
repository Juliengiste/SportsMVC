<?php
/*******************************
Version : 1.0.0.0
Revised : vendredi 4 mai 2018, 10:23:58 (UTC+0200)
 *******************************/
namespace Core\Models;

use PDO;
use \Core\Models\Lieu;

class LieuManager extends Manager {
	protected $table = "lieu";
	protected $pk = "idlieu";

	/**
	 * Login de l’utilisateur
	 * @param login
	 * @param pwd
	 * @return Boolean
	 */

	public function newLieu() {
		//fais appel à la fonction __construct de la classe Contracts
		return new Lieu();
	}

	public function addLieu($data){
		$q=$this->db->prepare('INSERT INTO `'.$this->table.'` (nom_lieu, adresse, cp, ville) VALUES (:nom_lieu, :adresse, :cp, :ville);');
		$q->bindValue(':nom_lieu', $data->nom_lieu(), PDO::PARAM_STR);
		$q->bindValue(':adresse', $data->adresse(), PDO::PARAM_STR);
		$q->bindValue(':cp', $data->cp(), PDO::PARAM_STR);
		$q->bindValue(':ville', $data->ville(), PDO::PARAM_STR);
		$q->execute();
	}

	public function updateLieu($data){
		$q=$this->db->prepare('UPDATE `'.$this->table.'` SET nom_lieu=:nom_lieu, adresse=:adresse, cp=:cp, ville=:ville WHERE `' . $this->pk . '`=:id;');
		$q->bindValue(':nom_lieu', $data->nom_lieu(), PDO::PARAM_STR);
		$q->bindValue(':adresse', $data->adresse(), PDO::PARAM_STR);
		$q->bindValue(':cp', $data->cp(), PDO::PARAM_STR);
		$q->bindValue(':ville', $data->ville(), PDO::PARAM_STR);
		//$q->bindValue(':description', $data->description(), PDO::PARAM_STR);
		$q->bindValue(':id', $data->idlieu(), PDO::PARAM_INT);
		$q->execute();

		$z = $this->db->prepare('SELECT * FROM `' . $this->table . '` WHERE `' . $this->table . '`.`' . $this->pk . '`='.$data->idlieu().';');
		$z->execute();
		$donnees = $z->fetch(PDO::FETCH_ASSOC);

		return new Lieu($donnees);
	}

	public function getAllLieus() {
	    $q = $this->db->query('SELECT * FROM lieu');
	    $lieus = $q->fetchAll(PDO::FETCH_ASSOC);
	    $lieuObjects = [];

	    foreach ($lieus as $lieuData) {
	        $lieu = new Lieu();
	        $lieu->setIdlieu($lieuData['idlieu']);
	        //var_dump($lieu);
	        $lieu->setNom_lieu($lieuData['nom_lieu']);
	        // ... Définir d'autres attributs pour Lieu

	        $lieuObjects[] = $lieu;
	        //var_dump($lieuObjects);
	    }

	    return $lieuObjects;
	}
}