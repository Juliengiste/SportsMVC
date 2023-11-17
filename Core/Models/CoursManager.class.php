<?php
/*******************************
Version : 1.0.0.0
Revised : vendredi 4 mai 2018, 10:23:58 (UTC+0200)
 *******************************/
namespace Core\Models;

use PDO;
use \Core\Models\Cours;

class CoursManager extends Manager {
	protected $table_c = "cours";
	protected $table_a = "annulation";
	protected $table_o = "occupation";
	protected $table_p = "participation";
	protected $pk_c = "idcours";
	protected $pk_a = "idannulation";

	/**
	 * Login de l’utilisateur
	 * @param login
	 * @param pwd
	 * @return Boolean
	 */
	public function login($login, $pwd) {
		$q=$this->db->prepare('SELECT * FROM `'.$this->table.'` WHERE `login`=:login AND `pwd`=:pwd');
		$q->bindValue(':login', $login, PDO::PARAM_STR);
		$q->bindValue(':pwd', hash('sha512', $pwd), PDO::PARAM_STR);

		$q->execute();

		$donnees=$q->fetch(PDO::FETCH_ASSOC);

		if($donnees!==false) {
			unset($_SESSION[SHORTNAME.'_user_error']);
			$_SESSION[SHORTNAME.'_user']=new \Core\Models\Personne($donnees);
			return true;
		}
		// tentative d'identification incorrecte
		else {
			// message d’erreur
			$_SESSION[SHORTNAME.'_user_error']="Identification incorrecte !";
			return false;
		}
	}

	public function newCours() {
		//fais appel à la fonction __construct de la classe Cours
		return new Cours();
	}

	public function addCours($data){
		$q=$this->db->prepare('INSERT INTO `'.$this->table_c.'` (nbplace, heure_debut, duree, sport) VALUES (:nbplace, :heure_debut, :duree, :sport);');
		$q->bindValue(':nbplace', $data->nbplace(), PDO::PARAM_INT);
		//$q->bindValue(':type_sco_vac', $data->type_sco_vac(), PDO::PARAM_STR);
		$q->bindValue(':heure_debut', $data->heure_debut(), PDO::PARAM_STR);
		$q->bindValue(':duree', $data->duree(), PDO::PARAM_INT);
		//$q->bindValue(':date', $data->date(), PDO::PARAM_STR);
		//$q->bindValue(':cadre', $data->cadre(), PDO::PARAM_INT);
		$q->bindValue(':sport', $data->sport(), PDO::PARAM_INT);
		$q->execute();
	}

	/*public function addCours($data){
		$q=$this->db->prepare('INSERT INTO `'.$this->table_c.'` (nbplace, type_sco_vac, heure_debut, duree, date, cadre, sport) VALUES (:nbplace, :type_sco_vac, :heure_debut, :duree, :date, :cadre, :sport);');
		$q->bindValue(':nbplace', $data->nbplace(), PDO::PARAM_INT);
		$q->bindValue(':type_sco_vac', $data->type_sco_vac(), PDO::PARAM_STR);
		$q->bindValue(':heure_debut', $data->heure_debut(), PDO::PARAM_STR);
		$q->bindValue(':duree', $data->duree(), PDO::PARAM_INT);
		$q->bindValue(':date', $data->date(), PDO::PARAM_STR);
		$q->bindValue(':cadre', $data->cadre(), PDO::PARAM_INT);
		$q->bindValue(':sport', $data->sport(), PDO::PARAM_INT);
		$q->execute();
	}*/

	public function updateCours($data){
		$q=$this->db->prepare('UPDATE `'.$this->table_c.'` SET nbplace=:nbplace, type_sco_vac=:type_sco_vac, heure_debut=:heure_debut, duree=:duree, date=:date, cadre=:cadre, sport=:sport  WHERE `' . $this->pk_c . '`=:id;');
		$q->bindValue(':nbplace', $data->nbplace(), PDO::PARAM_STR);
		$q->bindValue(':type_sco_vac', $data->type_sco_vac(), PDO::PARAM_STR);
		$q->bindValue(':heure_debut', $data->heure_debut(), PDO::PARAM_STR);
		$q->bindValue(':duree', $data->duree(), PDO::PARAM_INT);
		$q->bindValue(':date', $data->date(), PDO::PARAM_STR);
		$q->bindValue(':cadre', $data->cadre(), PDO::PARAM_INT);
		$q->bindValue(':sport', $data->sport(), PDO::PARAM_INT);
		$q->bindValue(':id', $data->idsport(), PDO::PARAM_INT);
		$q->execute();

		$z = $this->db->prepare('SELECT * FROM `' . $this->table_c . '` WHERE `' . $this->table_c . '`.`' . $this->pk_c . '`='.$data->idsport().';');
		$z->execute();
		$donnees = $z->fetch(PDO::FETCH_ASSOC);

		return new Cours($donnees);
	}

	public function addAnnulation($id, $raison){
		$q=$this->db->prepare('INSERT INTO `'.$this->table_a.'` (raison, cours) VALUES (:raison, :cours);');
		$q->bindValue(':raison', $raison, PDO::PARAM_INT);
		$q->bindValue(':cours', $id, PDO::PARAM_INT);
		$q->execute();
	}

	public function addOccupation($id, $dispo){
		$q=$this->db->prepare('INSERT INTO `'.$this->table_o.'` (disponibilite, cours_idcours) VALUES (:disponibilite, :cours_idcours);');
		$q->bindValue(':disponibilite', $dispo, PDO::PARAM_INT);
		$q->bindValue(':cours_idcours', $id, PDO::PARAM_INT);
		$q->execute();
	}

	public function addParticipation($id, $personne){
		$q=$this->db->prepare('INSERT INTO `'.$this->table_p.'` (cours_idcours, personne_idpersonne) VALUES (:cours_idcours, :personne_idpersonne);');
		$q->bindValue(':cours_idcours', $id, PDO::PARAM_INT);
		$q->bindValue(':personne_idpersonne', $personne, PDO::PARAM_INT);
		$q->execute();
	}

	public function addCoursForYear($pdo, $anneeScolaire, $lieuId)
	{
	    // Obtenez les dates de début et de fin de l'année scolaire
	    // (vous devez définir votre propre logique pour cela)
	    // $dateDebutAnnee = "2023-09-01";
	    // $dateFinAnnee = "2024-06-30";

	    // Boucle sur les semaines
	    $currentDate = $dateDebutAnnee;
	    while ($currentDate <= $dateFinAnnee) {
	        $jourSemaine = date('N', strtotime($currentDate)); // 1 (pour lundi) à 7 (pour dimanche)

	        // Vérifiez les disponibilités pour ce jour de la semaine et ce lieu
	        $disponibilites = getDisponibilitesForDay($pdo, $jourSemaine, $lieuId, $anneeScolaire);

	        // Vérifiez les vacances
	        if (!isDateInVacances($pdo, $currentDate, $anneeScolaire)) {
	            // Ajoutez le cours si tout est correct
	            addCours($pdo, $jourSemaine, $lieuId, $anneeScolaire);
	        }

	        // Passez à la semaine suivante
	        $currentDate = date('Y-m-d', strtotime($currentDate . ' +7 days'));
	    }
	}

	public function getDisponibilitesForDay($pdo, $jourSemaine, $lieuId, $anneeScolaire){
		// Convertissez le jour de la semaine de chaîne à numéro (1 à 7)
	    $jourSemaine = getDayOfWeekNumber($jourSemaineStr);
	    // Implémentez la logique pour récupérer les disponibilités en fonction du jour de la semaine, du lieu et de l'année scolaire
	    // ...

	    // Retournez les disponibilités (c'est un exemple, vous devrez adapter cela à votre structure de base de données)
	    return $disponibilites;
	}

	public function isDateInVacances($pdo, $date, $anneeScolaire){
	    // Implémentez la logique pour vérifier si la date est pendant les vacances en fonction de l'année scolaire
	    // ...

	    // Retournez true si la date est dans les vacances, sinon false
	    return false;
	}

	public function getDayOfWeekNumber($dayOfWeekStr){
	    // Convertit le jour de la semaine de chaîne à numéro (1 à 7)
	    $joursSemaine = [
	        'lundi' => 1,
	        'mardi' => 2,
	        'mercredi' => 3,
	        'jeudi' => 4,
	        'vendredi' => 5,
	        'samedi' => 6,
	        'dimanche' => 7,
	    ];

	    // Assurez-vous que la chaîne est en minuscules pour la correspondance insensible à la casse
	    $dayOfWeekStr = strtolower($dayOfWeekStr);

	    // Retourne le numéro du jour de la semaine
	    return $joursSemaine[$dayOfWeekStr];
	}
}