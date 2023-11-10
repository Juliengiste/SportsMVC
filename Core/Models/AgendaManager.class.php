<?php
/*******************************
Version : 1.0.0.0
Revised : vendredi 4 mai 2018, 10:23:58 (UTC+0200)
 *******************************/
namespace Core\Models;

use PDO;
use Lieu;
use Disponibilite;
use Anneescolaire;
use Vacances;

class AgendaManager extends Manager {
	protected $table_l = "lieu";
	protected $table_d = "disponibilite";
	protected $table_a= "anneescolaire";
	protected $table_v = "vacances";
	protected $pk_l = "idlieu";
	protected $pk_d = "iddisponibilite";
	protected $pk_a = "idanneescolaire";
	protected $pk_v = "idvacances";


	/**
	 * Login de l’utilisateur
	 * @param login
	 * @param pwd
	 * @return Boolean
	 */

	public function supp($id, $tab){
		$this->delete($id, $tab);
	}

	public function addLieu($data){
		$q=$this->db->prepare('INSERT INTO `'.$this->table_l.'` (nom_lieu, adresse, cp, ville) VALUES (:nom_lieu, :adresse, :cp, :ville);');
		$q->bindValue(':nom_lieu', $data->nom_lieu(), PDO::PARAM_STR);
		$q->bindValue(':adresse', $data->adresse(), PDO::PARAM_STR);
		$q->bindValue(':cp', $data->cp(), PDO::PARAM_INT);
		$q->bindValue(':ville', $data->ville(), PDO::PARAM_STR);
		$q->execute();
	}

	public function updateLieu($data){
		$q=$this->db->prepare('UPDATE `'.$this->table_l.'` SET nom_lieu=:nom_lieu, adresse=:adresse, cp=:cp, ville=:ville WHERE `' . $this->pk_l . '`=:id;');
		$q->bindValue(':nom_lieu', $data->nom_lieu(), PDO::PARAM_STR);
		$q->bindValue(':adresse', $data->adresse(), PDO::PARAM_STR);
		$q->bindValue(':cp', $data->cp(), PDO::PARAM_INT);
		$q->bindValue(':ville', $data->ville(), PDO::PARAM_STR);
		$q->bindValue(':id', $data->idlieu(), PDO::PARAM_INT);
		$q->execute();

		$z = $this->db->prepare('SELECT * FROM `' . $this->table_l . '` WHERE `' . $this->table_l . '`.`' . $this->pk_l . '`='.$data->idlieu().';');
		$z->execute();
		$donnees = $z->fetch(PDO::FETCH_ASSOC);

		return new Lieu($donnees);
	}

	public function addVacances($data){
		$q=$this->db->prepare('INSERT INTO `'.$this->table_v.'` (date_debut, date_fin, label, anneescolaire) VALUES (:deb, :fin, :label, :anneescolaire);');
		$q->bindValue(':deb', $data->date_debut(), PDO::PARAM_STR);
		$q->bindValue(':fin', $data->date_fin(), PDO::PARAM_STR);
		$q->bindValue(':label', $data->label(), PDO::PARAM_STR);
		$q->bindValue(':anneescolaire', $data->anneescolaire(), PDO::PARAM_INT);
		var_dump($data->anneescolaire());
		$q->execute();
	}

	public function updateVacances($data){
		$q=$this->db->prepare('UPDATE `'.$this->table_v.'` SET date_debut=:deb, date_fin=:fin, label=:label, anneescolaire=:anneescolaire WHERE `' . $this->pk_v . '`=:id;');
		$q->bindValue(':deb', $data->date_debut(), PDO::PARAM_STR);
		$q->bindValue(':fin', $data->date_fin(), PDO::PARAM_STR);
		$q->bindValue(':label', $data->label(), PDO::PARAM_STR);
		$q->bindValue(':anneescolaire', $data->anneescolaire(), PDO::PARAM_INT);
		$q->bindValue(':id', $data->idvacances(), PDO::PARAM_INT);
		$q->execute();

		$z = $this->db->prepare('SELECT * FROM `' . $this->table_v . '` WHERE `' . $this->table_v . '`.`' . $this->pk_v . '`='.$data->idvacances().';');
		$z->execute();
		$donnees = $z->fetch(PDO::FETCH_ASSOC);

		return new Vacances($donnees);
	}	

	public function getListVac($as) {
		$list = array();
		$z = $this->db->prepare('SELECT * FROM `' . $this->table_v . '` WHERE `' . $this->table_v . '`.`anneescolaire` = '.$as.' ORDER BY `date_debut`;');
		$z->execute();
		
		while ($donnees = $z->fetch(PDO::FETCH_ASSOC)){
			$list[] = new $this->metier($donnees);
		}
		return $list;
	}

	public function addAnnee_scolaire($data){
		$q=$this->db->prepare('INSERT INTO `'.$this->table_a.'` (date_debut, date_fin, label) VALUES (:deb, :fin, :label);');
		$q->bindValue(':deb', $data->date_debut(), PDO::PARAM_STR);
		$q->bindValue(':fin', $data->date_fin(), PDO::PARAM_STR);
		$q->bindValue(':label', $data->label(), PDO::PARAM_STR);
		$q->execute();
	}

	public function updateAnnee_scolaire($data){
		$q=$this->db->prepare('UPDATE `'.$this->table_a.'` SET date_debut=:deb, date_fin=:fin, label=:label WHERE `' . $this->pk_a . '`=:id;');
		$q->bindValue(':deb', $data->date_debut(), PDO::PARAM_STR);
		$q->bindValue(':fin', $data->date_fin(), PDO::PARAM_STR);
		$q->bindValue(':label', $data->label(), PDO::PARAM_STR);
		$q->bindValue(':id', $data->idanneescolaire(), PDO::PARAM_INT);
		$q->execute();

		$z = $this->db->prepare('SELECT * FROM `' . $this->table_a . '` WHERE `' . $this->table_a . '`.`' . $this->pk_a . '`='.$data->idannee_scolaire().';');
		$z->execute();
		$donnees = $z->fetch(PDO::FETCH_ASSOC);

		return new Anneescolaire($donnees);
	}

	public function addDisponibilite($data){
		$q=$this->db->prepare('INSERT INTO `'.$this->table_d.'` (jour_semaine, heure_debut, lieu, annee_scolaire, duree, dispoparent) VALUES (:j_s, :h_d, :lieu, :anneescolaire, :duree, :dispoparent);');
		$q->bindValue(':j_s', $data->jour_semaine(), PDO::PARAM_STR);
		$q->bindValue(':h_d', date('H:i:s', strtotime($data->heure_debut())), PDO::PARAM_STR);
		$q->bindValue(':lieu', $data->lieu(), PDO::PARAM_INT);
		$q->bindValue(':anneescolaire', $data->annee_scolaire(), PDO::PARAM_INT);
		$q->bindValue(':duree', $data->duree(), PDO::PARAM_INT);
		$q->bindValue(':dispoparent', $data->dispoparent(), PDO::PARAM_INT);
		$q->execute();

		return $this->db->lastInsertId();
	}

	public function autorisesport($dispo, $sport){
		$q=$this->db->prepare('INSERT INTO `autorise` (disponibilte_iddisponibilte, sport_idsport) VALUES (:d, :s);');
		$q->bindValue(':d', $dispo, PDO::PARAM_INT);
		$q->bindValue(':s', $sport, PDO::PARAM_INT);
		$q->execute();
	}

	public function updateDisponibilite($data){
		$q=$this->db->prepare('UPDATE `'.$this->table_d.'` SET jour_semaine=:j_s, heure_debut=:h_d, lieu=:lieu, anneescolaire=:anneescolaire, duree=:duree, dispoparent=:dispoparent WHERE `' . $this->pk_d . '`=:id;');
		$q->bindValue(':j_s', $data->djour_semaine(), PDO::PARAM_STR);
		$q->bindValue(':h_d', $data->heure_debut(), PDO::PARAM_STR);
		$q->bindValue(':lieu', $data->lieu(), PDO::PARAM_INT);
		$q->bindValue(':anneescolaire', $data->anneescolaire(), PDO::PARAM_INT);
		$q->bindValue(':duree', $data->duree(), PDO::PARAM_INT);
		$q->bindValue(':dispoparent', $data->dispoparent(), PDO::PARAM_INT);
		$q->bindValue(':id', $data->iddisponibilite(), PDO::PARAM_INT);
		$q->execute();

		$z = $this->db->prepare('SELECT * FROM `' . $this->table_d . '` WHERE `' . $this->table_d . '`.`' . $this->pk_d . '`='.$data->iddisponibilite().';');
		$z->execute();
		$donnees = $z->fetch(PDO::FETCH_ASSOC);

		return new Disponibilite($donnees);
	}

	public function getDispoJour($as, $jour){
		$list = array();
		$this->metier = '\Core\Models\Disponibilite';
		$q=$this->db->prepare('SELECT * FROM `' . $this->table_d . '` WHERE `' . $this->table_d . '`.`annee_scolaire`='.$as.' AND `'.$this->table_d.'`.`jour_semaine`="'.$jour.'" AND `duree` IS NOT NULL ORDER BY `lieu` ASC;');
		$q->execute();
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){
			$list[] = new $this->metier($donnees);
		}
		return $list;
	}

	public function getAsencours(){
		$q=$this->db->prepare('SELECT * FROM `' . $this->table_a . '` WHERE `' . $this->table_a . '`.`date_debut`< NOW() AND `'.$this->table_a.'`.`date_fin`> NOW();');
		$q->execute();
		$donnees = $q->fetch(PDO::FETCH_ASSOC);

		return new Anneescolaire($donnees);
	}
}
	