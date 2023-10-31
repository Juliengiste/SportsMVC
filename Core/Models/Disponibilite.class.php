<?php
namespace Core\Models;

use Core\Classes\Utils;

class Disponibilite extends Metier {
	protected $iddisponibilite;
	protected $jour_semaine;
	protected $heure_debut;
	protected $lieu;
	protected $annee_scolaire;
	protected $duree;
	protected $dispoparent;
	protected $allowed_properties = ['iddisponibilite', 'jour_semaine', 'heure_debut','lieu','annee_scolaire', 'duree', 'dispoparent'];
	
	public function setIddisponibilite($param){
		$this->iddisponibilite=$param;
	}
	public function setJour_semaine($param){
		$this->jour_semaine=$param;
	}
	public function setHeure_debut($param){
		$this->heure_debut=$param;
	}
	public function setLieu($param){
		$this->lieu=$param;
	}
	public function setAnnee_scolaire($param){
		$this->annee_scolaire=$param;
	}
	public function setDuree($param){
		$this->duree=$param;
	}
	public function setDispoparent($param){
		$this->dispoparent=$param;
	}

	public function iddisponibilite(){return $this->iddisponibilite;}
	public function jour_semaine(){return $this->jour_semaine;}
	public function heure_debut(){return $this->heure_debut;}
	public function lieu(){return $this->lieu;}
	public function annee_scolaire(){return $this->annee_scolaire;}
	public function duree(){return $this->duree;}
	public function dispoparent(){return $this->dispoparent;}
}