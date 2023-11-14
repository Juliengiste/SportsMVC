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
	protected $lstable = "lieu_sport";
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
		$q=$this->db->prepare('UPDATE `'.$this->table.'` SET nom_lieu=:nom_lieu, adresse=:adresse, cp=:cp, ville=:ville, lattitude=:lattitude, longitude=:longitude WHERE `' . $this->pk . '`=:id;');
		$q->bindValue(':nom_lieu', $data->nom_lieu(), PDO::PARAM_STR);
		$q->bindValue(':adresse', $data->adresse(), PDO::PARAM_STR);
		$q->bindValue(':cp', $data->cp(), PDO::PARAM_STR);
		$q->bindValue(':ville', $data->ville(), PDO::PARAM_STR);
		$q->bindValue(':lattitude', $data->lattitude(), PDO::PARAM_STR);
		$q->bindValue(':longitude', $data->longitude(), PDO::PARAM_STR);
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

	public function supp($id, $tab){
		$q=$this->db->prepare('DELETE `'.$this->table.'` SET idlieu=:idlieu, idsport=:idsport WHERE `' . $this->pk . '`=:id;');
		$this->delete($id, $tab);
	}

	public function exists($id, $table) {
	    $q = $this->db->prepare('SELECT COUNT(*) as count FROM ' . $table . ' WHERE ' . $this->pk . ' = :id');
	    $q->bindValue(':id', $id, PDO::PARAM_INT);
	    $q->execute();

	    $result = $q->fetch(PDO::FETCH_ASSOC);

	    return ($result['count'] > 0);
	}

	protected function deleteLS(int $id, $tab) {
	    // Assuming $id is the ID of the record you want to delete

	    // Step 1: Delete from associated tables with foreign key constraints (e.g., lieu_sport)
	    if ($tab == 'lieu') {
	        $this->db->query("DELETE FROM `lieu_sport` WHERE `idlieu`=" . $id . "AND `id_sport`=" . $idSport);
	    }

	    // Step 2: Delete from the main table
	    $this->metier = '\Core\Models\\' . ucfirst($tab);
	    $this->db->query("DELETE FROM `" . $tab . "` WHERE `id" . $tab . "`=" . $id);
	}
}