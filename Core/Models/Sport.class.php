<?php
namespace Core\Models;

use Core\Classes\Utils;

class Sport extends Metier {
	private $idlieu;
	protected $idsport;
	protected $nom_sport;
	protected $description;
	protected $allowed_properties = ['idlieu','idsport','nom_sport','description'];
	
	public function setIdsport($param){
		$this->idsport=$param;
	}
	public function setNom_sport($param){
		$this->nom_sport=$param;
	}
	public function setDescription($param){
		$this->description=$param;
	}

	 public function setIdLieu($idlieu) {
        $this->id_lieu = $idlieu;
    }

    public function getIdLieu(){return $this->idlieu;}
	public function idsport(){return $this->idsport;}
	public function nom_sport(){return $this->nom_sport;}
	public function description(){return $this->description;}
}