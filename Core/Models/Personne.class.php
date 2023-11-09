<?php
/*******************************
 * Version : 1.0.0.0
 * Revised : jeudi 26 octobre 2017, 15:23:58 (UTC+0200)
 *******************************/

namespace Core\Models;

use Core\Classes\Utils;

class Personne extends Metier {
	protected $idpersonne;
	protected $email;
	protected $pwd;
	protected $nom;
	protected $prenom;
	protected $sexe;
	protected $birthday;
	protected $tel;
	protected $adresse;
	protected $cp;
	protected $ville;
	protected $created_at;
	protected $updated_at;
	protected $role;
	protected $allowed_properties = ['idpersonne','email','pwd','nom','prenom','sexe','birthday','tel','adresse','cp','ville','created_at','updated_at' , 'role'];
	/*
	 * Check login
	 * @param none
	 * @return Boolean
	 */
	public function setIdpersonne($param){
		$this->idpersonne=$param;
	}
	public function setEmail($param){
		$this->email=$param;
	}
	public function setPwd($param){
		$this->pwd=$param;
	}
	public function setNom($param){
		$this->nom=$param;
	}
	public function setPrenom($param){
		$this->prenom=$param;
	}
	public function setSexe($param){
		$this->sexe=$param;
	}
	public function setBirthday($param){
		$this->birthday=$param;
	}
	public function setTel($param){
		$this->tel=$param;
	}
	public function setAdresse($param){
		$this->adresse=$param;
	}
	public function setCp($param){
		$this->cp=$param;
	}
	public function setVille($param){
		$this->ville=$param;
	}
	public function setCreated_at($param){
		$this->created_at=$param;
	}
	public function setUpdated_at($param){
		$this->updated_at=$param;
	}
	public function setRole($param){
		$this->role=$param;
	}

	public function idpersonne(){return $this->idpersonne;}
	public function email(){return $this->email;}
	public function pwd(){return $this->pwd;}
	public function nom(){return $this->nom;}
	public function prenom(){return $this->prenom;}
	public function sexe(){return $this->sexe;}
	public function birthday(){return $this->birthday;}
	public function tel(){return $this->tel;}
	public function adresse(){return $this->adresse;}
	public function cp(){return $this->cp;}
	public function ville(){return $this->ville;}
	public function created_at(){return $this->created_at;}
	public function updated_at(){return $this->updated_at;}
	public function role(){return $this->role;}

	public function isConnected($pmanager = false) {
		// La session est déjà ouverte
		if (isset($_SESSION[SHORTNAME.'_user'])) {
			// On demande la déconnexion
			if (isset($_GET['logout'])) {
				$_SESSION = array();
				if (ini_get("session.use_cookies")) {
					$params = session_get_cookie_params();
					setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
				}
				session_destroy();
				//on supprime le paramètres GET/retour accueil car si on se reconnecte on est déco direct
				header('Location:/');
				exit();
			} // on reste connecté
			else return true;
		} // POST des identifiants/pwd
		elseif (isset($_POST['login_login']) && (isset($_POST['login_pwd']))) {
			return $pmanager->login($_POST['login_login'], $_POST['login_pwd']);
		} // Affichage d'une page sans être connecté ni avoir envoyé d'identifiant (pas d'erreur mais demande de login)
		else {
			unset($_SESSION[SHORTNAME.'_user_error']);
			return false;
		}
	}
	
	public function __toString() {
		return 'Objet ' . __CLASS__;
	}
}