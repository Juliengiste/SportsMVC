<?php
namespace Core\Models;

use Core\Classes\Utils;

class Vacances extends Metier {
	protected $idvacances;
	protected $date_debut;
	protected $date_fin;
	protected $label;
	protected $anneescolaire;
	protected $allowed_properties = ['idvacances', 'date_debut', 'date_fin','label','anneescolaire'];
	
	public function setIdvacances($param){
		$this->idvacances=$param;
	}
	public function setDate_debut($param){
		$this->date_debut=$param;
	}
	public function setDate_fin($param){
		$this->date_fin=$param;
	}
	public function setLabel($param){
		$this->label=$param;
	}
	public function setAnneescolaire($param){
		$this->anneescolaire=$param;
	}

	public function idvacances(){return $this->idvacances;}
	public function date_debut(){return $this->date_debut;}
	public function date_fin(){return $this->date_fin;}
	public function label(){return $this->label;}
	public function anneescolaire(){return $this->anneescolaire;}
}