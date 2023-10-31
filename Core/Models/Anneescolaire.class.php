<?php
namespace Core\Models;

use Core\Classes\Utils;

class Anneescolaire extends Metier {
	protected $idanneescolaire;
	protected $date_debut;
	protected $date_fin;
	protected $label;
	protected $allowed_properties = ['idanneescolaire', 'date_debut', 'date_fin','label'];
	
	public function setIdanneescolaire($param){
		$this->idanneescolaire=$param;
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

	public function idanneescolaire(){return $this->idanneescolaire;}
	public function date_debut(){return $this->date_debut;}
	public function date_fin(){return $this->date_fin;}
	public function label(){return $this->label;}
}