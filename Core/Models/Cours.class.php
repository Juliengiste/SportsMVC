<?php
namespace Core\Models;

use Core\Classes\Utils;

class Cours extends Metier {
	protected $idcours;	
	protected $nbplace;
	protected $type_sco_vac;
	protected $heure_debut;
	protected $duree;
	protected $date;
	protected $cadre;
	protected $sport;
	protected $allowed_properties = ['idcours','nbplace','type_sco_vac','heure_debut','duree','date','cadre','sport'];
	protected $table = "cours";
	
	public function setIdcours($param){
		$this->idcours=$param;
	}
	public function setNbplace($param){
		$this->nbplace=$param;
	}
	public function setType_sco_vac($param){
		$this->type_sco_vac=$param;
	}
	public function setHeure_debut($param){
		$this->heure_debut=$param;
	}
	public function setDuree($param){
		$this->duree=$param;
	}
	public function setDate($param){
		$this->date=$param;
	}
	public function setCadre($param){
		$this->cadre=$param;
	}
	public function setSport($param){
		$this->sport=$param;
	}

	public function idcours(){return $this->idcours;}
	public function nbplace(){return $this->nbplace;}
	public function type_sco_vac(){return $this->type_sco_vac;}
	public function heure_debut(){return $this->heure_debut;}
	public function duree(){return $this->duree;}
	public function date(){return $this->date;}
	public function cadre(){return $this->cadre;}
	public function sport(){return $this->sport;}

}