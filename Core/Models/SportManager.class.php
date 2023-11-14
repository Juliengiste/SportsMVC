<?php
/*******************************
Version : 1.0.0.0
Revised : vendredi 4 mai 2018, 10:23:58 (UTC+0200)
 *******************************/
namespace Core\Models;

use PDO;
use \Core\Models\Sport;

class SportManager extends Manager {
	protected $table = "sport";
	protected $pk = "idsport";

	/**
	 * Login de l’utilisateur
	 * @param login
	 * @param pwd
	 * @return Boolean
	 */

	public function newSport() {
		//fais appel à la fonction __construct de la classe Contracts
		return new Sport();
	}

	public function addSport($data, $lieuxSelectionnes){
	    $q = $this->db->prepare('INSERT INTO `' . $this->table . '` (nom_sport, description) VALUES (:nom_sport, :description);');
	    $q->bindValue(':nom_sport', $data->nom_sport(), PDO::PARAM_STR);
	    $q->bindValue(':description', $data->description(), PDO::PARAM_STR);
	    $q->execute();

	    // Récupérer l'ID du sport nouvellement ajouté
	    $newSportId = $this->db->lastInsertId();
		//var_dump($lieuxSelectionnes);
	    // Associer les lieux au nouveau sport
	    foreach ($lieuxSelectionnes as $lieuId) {
	        $this->associateSportWithLieu($newSportId, $lieuId);
	    }
	}


	public function updateSport($data){
	    // Vérifier s'il existe des liaisons dans lieu_sport pour ce sport
	    $q = $this->db->prepare('SELECT COUNT(*) as count FROM lieu_sport WHERE idsport = :id');
	    $q->bindValue(':id', $data->idsport(), PDO::PARAM_INT);
	    $q->execute();
	    $result = $q->fetch(PDO::FETCH_ASSOC);

	    if ($result['count'] > 0) {
	        if (isset($_POST['lieux']) && is_array($_POST['lieux'])) {
	            foreach ($_POST['lieux'] as $idLieu) {
	                $this->associateSportWithLieu($data->idsport(), $idLieu);
	            }
	        }
	    }

	    $q = $this->db->prepare('UPDATE '.$this->table.' SET nom_sport = :nom_sport, description = :description WHERE idsport = :id');
	    $q->bindValue(':nom_sport', $data->nom_sport(), PDO::PARAM_STR);
	    $q->bindValue(':description', $data->description(), PDO::PARAM_STR);
	    $q->bindValue(':id', $data->idsport(), PDO::PARAM_INT);
	    $q->execute();

	    $z = $this->db->prepare('SELECT * FROM '.$this->table.' WHERE idsport = :id');
	    $z->bindValue(':id', $data->idsport(), PDO::PARAM_INT);
	    $z->execute();
	    $donnees = $z->fetch(PDO::FETCH_ASSOC);

	    return new Sport($donnees);
	}

	public function deleteSport($id) {
    	 // Vérifier s'il existe des liaisons dans lieu_sport pour ce sport
	    $q = $this->db->prepare('SELECT COUNT(*) as count FROM lieu_sport WHERE idsport = :id');
	    $q->bindValue(':id', $id, PDO::PARAM_INT);
	    $q->execute();
	    $result = $q->fetch(PDO::FETCH_ASSOC);

	    if ($result['count'] > 0) {
	        // Supprimer les liaisons dans lieu_sport pour l'idsport spécifique
	        $deleteLieuSport = $this->db->prepare('DELETE FROM lieu_sport WHERE idsport = :id');
	        $deleteLieuSport->bindValue(':id', $id, PDO::PARAM_INT);
	        $deleteLieuSport->execute();
	    }

	    // Ensuite, supprimer le sport
	    $this->delete($id, $this->table);
	}

	public function associateSportWithLieu($idSport, $idLieu) {
		$q = $this->db->prepare('SELECT * FROM lieu_sport WHERE idsport = :idSport AND idlieu = :idLieu');
	    $q->bindValue(':idSport', $idSport, PDO::PARAM_INT);
	    $q->bindValue(':idLieu', $idLieu, PDO::PARAM_INT);
	    $q->execute();
	    $result = $q->fetch(PDO::FETCH_ASSOC);

	    if (!$result) {
	        $q = $this->db->prepare('INSERT INTO lieu_sport (idsport, idlieu) VALUES (:idSport, :idLieu);');
	        $q->bindValue(':idSport', $idSport, PDO::PARAM_INT);
	        $q->bindValue(':idLieu', $idLieu, PDO::PARAM_INT);
	        $q->execute();
	    } else {
	    
		}
	}

	public function associateLieuWithSport($idLieu, $idSport) {
		$q = $this->db->prepare('SELECT * FROM lieu_sport WHERE idlieu = :idLieu AND idsport = :idSport');
		$q->bindValue(':idLieu', $idLieu, PDO::PARAM_INT);
	    $q->bindValue(':idSport', $idSport, PDO::PARAM_INT);
	    $q->execute();
	    $result = $q->fetch(PDO::FETCH_ASSOC);

	    if (!$result) {
	        $q = $this->db->prepare('INSERT INTO lieu_sport (idlieu, idsport) VALUES (:idLieu, :idSport);');
	       	$q->bindValue(':idLieu', $idLieu, PDO::PARAM_INT);
	   		$q->bindValue(':idSport', $idSport, PDO::PARAM_INT);
	        $q->execute();
	    } else {
	    
		}
	}

	public function getLieuDetails($idlieu) {
    $q = $this->db->prepare('SELECT * FROM lieu WHERE idlieu = :idlieu');
    $q->bindValue(':idlieu', $idlieu, PDO::PARAM_INT);
    $q->execute();

    $lieuData = $q->fetch(PDO::FETCH_ASSOC);
    
	    // Si des données sont trouvées, instanciez un objet Lieu
	    if ($lieuData) {
	        $lieu = new Lieu();
	        $lieu->setIdlieu($lieuData['idlieu']); // Assurez-vous de récupérer l'ID du lieu
	        $lieu->setNom_lieu($lieuData['nom_lieu']);
	        $lieu->setAdresse($lieuData['adresse']);
	        $lieu->setCp($lieuData['cp']);
	        $lieu->setVille($lieuData['ville']);
	        // Assurez-vous de définir d'autres propriétés de Lieu de manière similaire

	        return $lieu;
	    }

	    return null; // Renvoyer null si aucun lieu n'est trouvé
	}

	public function getSportAssociatedLieus($sportId) {
	    // Faites une requête pour récupérer les lieux associés à un sport spécifique
	    $q = $this->db->prepare('SELECT * FROM lieu_sport WHERE idsport = :sportId');
	    $q->bindValue(':sportId', $sportId, PDO::PARAM_INT);
	    $q->execute();

	    $lieus = [];
	    while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
	        $lieus[] = $row['idlieu']; // Récupérez les IDs des lieux liés au sport
	    }

	    // Vous pouvez maintenant utiliser ces IDs pour récupérer les détails des lieux
	    $associatedLieus = [];
	    foreach ($lieus as $lieuId) {
	        $associatedLieus[] = $this->getLieuDetails($lieuId);
	    }

	    return $associatedLieus;
	}

	 public function deleteSportLocationLink($sportId, $locationId) {
        // Utilisez ici votre logique pour supprimer les liens entre le sport et les lieux associés
        // Étant donné que vous utilisez PDO, vous devrez exécuter une requête SQL DELETE pour supprimer les enregistrements associés
        $query = $this->db->prepare('DELETE FROM lieu_sport WHERE idsport = :sportId AND idlieu = :locationId');
        $query->bindParam(':sportId', $sportId);
        $query->bindParam(':locationId', $locationId);
        $query->execute();
    }

    public function deleteSportLieuOnlyLinks($idLieu) {
    $query = $this->db->prepare('DELETE FROM lieu_sport WHERE idlieu = :idLieu');
    $query->bindParam(':idLieu', $idLieu, PDO::PARAM_INT);
    $query->execute();
}
}