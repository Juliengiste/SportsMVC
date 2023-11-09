<?php
namespace Core\Models;

use Core\Classes\Utils;

class Sport extends Metier {
	protected $idsport;
	protected $nom_sport;
	protected $description;
	protected $allowed_properties = ['idsport','nom_sport','description'];
	
	public function setIdsport($param){
		$this->idsport=$param;
	}
	public function setNom_sport($param){
		$this->nom_sport=$param;
	}
	public function setDescription($param){
		$this->description=$param;
	}

	public function idsport(){return $this->idsport;}
	public function nom_sport(){return $this->nom_sport;}
	public function description(){return $this->description;}
}