<?php
namespace Core\Models;

use Core\Classes\Utils;

class Lieu extends Metier {
	protected $idlieu;
	protected $nom_lieu;
	protected $adresse;
	protected $cp;
	protected $ville;
	protected $lattitude;
	protected $longitude;
	protected $allowed_properties = ['idlieu', 'nom_lieu', 'adresse','cp','ville' ,'lattitude','longitude'];

	public function setIdlieu($param){
		$this->idlieu=$param;
	}
	public function setNom_lieu($param){
		$this->nom_lieu=$param;
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
	public function setLattitude($param){
		$this->lattitude=$param;
	}
	public function setLongitude($param){
		$this->longitude=$param;
	}

	public function getIdlieu(){
    	return $this->idlieu;
	}

	public function idlieu(){return $this->idlieu;}
	public function nom_lieu(){return $this->nom_lieu;}
	public function adresse(){return $this->adresse;}
	public function cp(){return $this->cp;}
	public function ville(){return $this->ville;}
	public function lattitude(){return $this->lattitude;}
	public function longitude(){return $this->longitude;}
}