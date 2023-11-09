<?php
/*******************************
Version : 1.0.0.0
Revised : vendredi 4 mai 2018, 10:23:58 (UTC+0200)
 *******************************/
namespace Core\Models;

use PDO;
use \Core\Models\Personne;

class PersonneManager extends Manager {
	protected $table = "personne";
	protected $pk = "idpersonne";

	/**
	 * Login de l’utilisateur
	 * @param login
	 * @param pwd
	 * @return Boolean
	 */

	public function __construct() {
    // Retrieve the database configuration from config.inc.php
     $dbuser = 'modele'; // Replace with your actual DBUSER
    $dbpass = 'Mi8OBuAkW0TqFcKr'; // Replace with your actual DBPASS

    try {
        $this->db = new PDO("mysql:host=localhost;dbname=sms", $dbuser, $dbpass);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Handle database connection error
        die("Database connection failed: " . $e->getMessage());
    }
}

	public function newPersonne() {
		//fais appel à la fonction __construct de la classe Contracts
		return new Personne();
	}

	public function login($login, $pwd) {
		$q=$this->db->prepare('SELECT * FROM `'.$this->table.'` WHERE `email`=:email AND `pwd`=:pwd');
		$q->bindValue(':email', $login, PDO::PARAM_STR);
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

	public function addPersonne($data){
		$q=$this->db->prepare('INSERT INTO `'.$this->table.'` (nom, prenom, sexe, birthday, tel, email, pwd, adresse, cp, ville, role) VALUES (:nom, :prenom, :sexe, :birthday, :tel, :email, :pwd, :adresse, :cp, :ville, :role);');
		$q->bindValue(':nom', $data->nom(), PDO::PARAM_STR);
		$q->bindValue(':prenom', $data->prenom(), PDO::PARAM_STR);
		$q->bindValue(':sexe', $data->sexe(), PDO::PARAM_STR);
		$q->bindValue(':birthday', $data->birthday(), PDO::PARAM_STR);
		$q->bindValue(':tel', $data->tel(), PDO::PARAM_STR);
		$q->bindValue(':email', $data->email(), PDO::PARAM_STR);
		$q->bindValue(':pwd', $data->pwd(), PDO::PARAM_STR);
		$q->bindValue(':adresse', $data->adresse(), PDO::PARAM_STR);
		$q->bindValue(':cp', $data->cp(), PDO::PARAM_INT);
		$q->bindValue(':ville', $data->ville(), PDO::PARAM_STR);
		$q->bindValue(':role', $data->role(), PDO::PARAM_INT);
		$q->execute();
	}

	public function updatePersonne($data){
		$q=$this->db->prepare('UPDATE `'.$this->table.'` SET nom=:nom, prenom=:prenom, sexe=:sexe, birthday=:birthday, tel=:tel, email=:email, pwd=:pwd, adresse=:adresse, cp=:cp, ville=:ville, role=:role WHERE `' . $this->pk . '`=:id;');
		$q->bindValue(':nom', $data->nom(), PDO::PARAM_STR);
		$q->bindValue(':prenom', $data->prenom(), PDO::PARAM_STR);
		$q->bindValue(':sexe', $data->sexe(), PDO::PARAM_STR);
		$q->bindValue(':birthday', $data->birthday(), PDO::PARAM_STR);
		$q->bindValue(':tel', $data->tel(), PDO::PARAM_STR);
		$q->bindValue(':email', $data->email(), PDO::PARAM_STR);
		$q->bindValue(':pwd', $data->pwd(), PDO::PARAM_STR);
		$q->bindValue(':adresse', $data->adresse(), PDO::PARAM_STR);
		$q->bindValue(':cp', $data->cp(), PDO::PARAM_INT);
		$q->bindValue(':ville', $data->ville(), PDO::PARAM_STR);
		$q->bindValue(':role', $data->role(), PDO::PARAM_INT);
		$q->bindValue(':id', $data->idpersonne(), PDO::PARAM_INT);
		$q->execute();

		$z = $this->db->prepare('SELECT * FROM `' . $this->table . '` WHERE `' . $this->table . '`.`' . $this->pk . '`='.$data->idpersonne().';');
		$z->execute();
		$donnees = $z->fetch(PDO::FETCH_ASSOC);

		return new Personne($donnees);
	}
}