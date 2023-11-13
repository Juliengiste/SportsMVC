<style type="text/css">
	.form-row1 {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  display: flex;
  justify-content: center;
  align-items: center;
  -moz-box-shadow: 10px 10px 5px #656565;
  -webkit-box-shadow: 10px 10px 5px #656565; 
  -o-box-shadow: 10px 10px 5px #656565;
  box-shadow: 10px 10px 5px #656565;
  filter:progid:DXImageTransform.Microsoft.Shadow(color='#6565', Direction=135, Strength=5); 
}

</style>
<?php

/*******************************
Version : 1.0.0.0
Revised : jeudi 19 avril 2018, 16:49:24 (UTC+0200)
*******************************/

$id = \Core\Classes\Utils::secureGet('id');
$new = \Core\Classes\Utils::secureGet('new');
$supp = \Core\Classes\Utils::secureGet('supp');
$update = \Core\Classes\Utils::secureGet('update');
$smanager = new Core\Models\SportManager($pdo);
$lmanager = new Core\Models\LieuManager($pdo);

if(isset($_SESSION[SHORTNAME.'_user'])) $me = $_SESSION[SHORTNAME.'_user'];

if (isset($supp)){
	$smanager->deleteSport($id);
	$id = NULL;
	$supp = NULL;
}

if (isset($update)){
	var_dump($_POST);
	// Vérifie d'abord si l'ID est présent dans la requête
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        // Récupérez l'objet Sport à partir de l'ID
        $sport = $smanager->get($id, "sport");
        //$lieu = $lmanager->get($id, "lieu_sport");
        // Vérifie si l'objet Sport a été récupéré avec succès
        if ($sport) {
            // Effectuez la mise à jour avec les données du formulaire
            $sport->setNom_sport($_POST['nom_sport']);
            $sport->setDescription($_POST['description']);
            $smanager->updateSport($sport);
            
        } else {
            // Gérez le cas où l'ID ne correspond à aucun sport existant
        }
    } else {
        // Gérez le cas où l'ID n'est pas présent dans la requête
    }
}

// Ajouter un sport
if ((count($_POST) != 0) && ($_POST["id"] == "NULL")) {
    $newsport = $smanager->new("sport");
    $newsport->setNom_sport($_POST['nom_sport']);
    $newsport->setDescription($_POST['description']);

    // Récupérer les lieux sélectionnés
    $lieuxSelectionnes = isset($_POST['lieux']) ? $_POST['lieux'] : [];
	
    // Utilisation de la méthode modifiée pour ajouter le sport avec les lieux associés
    $smanager->addSport($newsport, $lieuxSelectionnes);
    // Redirection vers la page sport
    header("Location: /sports");
    exit();
}

// Afficher un sport
if(isset($id)&&(!isset($supp))&&(!isset($update))){
	$sportList = $smanager->get($id, "sport");
	$lieuList = $lmanager->getAllLieus($id, "lieu");
	$sport = $sportList;
	$lieu = $lieuList;
	$sportId = $id; 
	$sport = $smanager->get($sportId, "sport"); // Récupérer les détails du sport
	$lieuxAssocies = $smanager->getSportAssociatedLieus($sportId);// Récupérer les lieux associés à ce sport

?>
<div class="container justify-content-center" id="content">
	<h1 style="text-align: center">Votre Association Multi Sports</h1>

	<!-- Structure pour afficher le sport -->
	<div class="card text-center">
		<!-- Titre du sport -->
		<div class="card-body">
			<h2 style="text-align: center;">
				<i class="fas fa-star"></i><?= strtoupper($sport->nom_sport()) ?>
			</h2>
			<!-- Affichage des détails du sport -->
			<p>Détails du sport : <?= $sport->description() ?></p>
		</div>
	</div>

	<!-- Structure pour afficher les lieux associés -->
	<div class="card text-center">
		<div class="card-body">
			<h4>Lieux associés au sport : </h4>
			<?php
			foreach ($lieuxAssocies as $lieu) {
				// Affichage de chaque lieu associé
				echo '<div>';
				echo '<h5>' . $lieu->getNomLieu() . '</h5>';
				// Afficher les détails du lieu
				echo '<p>' . $lieu->getAdresse() . '</p>';
				echo '<p>' . $lieu->getCp() . ' ' . $lieu->getVille() . '</p>';
				echo '</div>';
			}
			?>
		</div>
	</div>
</div>

<?}
elseif(!isset($id)&&(!isset($new))){
	$sort = \Core\Classes\Utils::secureGet('sort',"nom_sport");
	$tri = \Core\Classes\Utils::secureGet('tri',"asc");
	$invtri = ($tri=="asc")?"desc":"asc";
	$sportList = $smanager->getList($sort,$tri,"sport");

?>
	<main>
	<div class="container">
		<h2>Liste des sports SMS</h2>
		<a class="text-dark" href="sports/?new=1">
			<button class="btn btn-primary"><i class="fas fa-plus-circle"></i> Ajout sport</button>
		</a>
		<br><br>
		<table class="table table-striped table-sm">
			<thead>
				<tr>
					<th class="text-nowrap"><a class="text-dark" href="?sort=nom_sport&tri=<?=$invtri?>">Nom <?if($sort=="nom_sport"){if($tri=="asc")echo'<i class="d-inline fas fa-sort-down"></i>';else echo'<i class="d-inline fas fa-sort-up"></i>';}?></a></th>
					<th class="text-nowrap"><a class="text-dark" href="?sort=description&tri=<?=$invtri?>">description <?if($sort=="description"){if($tri=="asc")echo'<i class="d-inline fas fa-sort-down"></i>';else echo'<i class="d-inline fas fa-sort-up"></i>';}?></a></th>
					<th class="text-nowrap"><a class="text-dark" href="?sort=nom_lieu&tri=<?=$invtri?>">Lieux <?if($sort=="nom_lieu"){if($tri=="asc")echo'<i class="d-inline fas fa-sort-down"></i>';else echo'<i class="d-inline fas fa-sort-up"></i>';}?></a></th>			 
					<th>Actions</a></th>
				</tr>
			</thead>
			<tbody>
				<? 
				if(is_array($sportList)){
					foreach ($sportList as $sport) {	
						?>
						<tr>
							<td class="align-middle"><?=strtoupper($sport->nom_sport())?></td>
							<td class="align-middle"><?=$sport->description()?></td>
							 <td class="align-middle">
			                    <?php
			                    // Récupérer les lieux associés au sport
			                    $lieuxAssocies = $smanager->getSportAssociatedLieus($sport->idsport());

			                    // Afficher les lieux associés
			                    foreach ($lieuxAssocies as $lieu) {
			                        echo $lieu->nom_lieu() . '<br>'; // Assurez-vous d'appeler la méthode correcte pour obtenir le nom du lieu
			                        // Affichez d'autres détails si nécessaire
			                    }
			                    ?>
			                </td>
							<td class="align-middle">
							<a href="sports/<?=$sport->idsport()?>" class="btn btn-warning">
							    <i class="fas fa-eye"></i>
							</a>

							<a href="sports/?id=<?=$sport->idsport()?>&update=1" class="btn btn-primary">
							    <i class="fas fa-edit"></i>
							</a>

							<a href="sports/?id=<?=$sport->idsport()?>&supp=1" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer?')">
							    <i class="fas fa-trash"></i>
							</a>


							</td>
						</td>
						</tr>
						<?
					}
				}
				?>
			</tbody>
		</table>
	</div>
</main>
<?}?>



<?
if (!isset($id)&&(isset($new))) {
	?>
	<div class="container justify-content-center" id="form">
		<form class="container justify-content-center" method="post">
			<h1 style="text-align: center">Les Sports S.M.S.</h1>
			<div class="row">
			    <div class="col-md-4">
			    	<img src="template/assets/img/salle_back.jpg" class="img-fluid max-width: 50%; and height: auto; img-thumbnail" alt="Responsive image">
				</div>
				<div class="col-sm">
					<img src="template/assets/img/salle_back.jpg" class="img-fluid max-width: 50%; and height: auto; img-thumbnail" alt="Responsive image">
				</div>
				<div class="col-md-4">
					<img src="template/assets/img/salle_back.jpg" class="img-fluid max-width: 50%; and height: auto; img-thumbnail" alt="Responsive image">
				</div>
			</div>
			<div class="form-row1">
			  	<div class="form-row mt-4">
			  		<input type="hidden" class="form-control" id="idsport" name="id" value=NULL />
				    <div class="col-md-12 mb-3">
			    		<label for="nom_lieu">Nom du sport à ajouter à l'association:</label>
			    		<input type="text" class="form-control" id="nom_sport" placeholder="Exemple: Balle aux prisionniers" name="nom_sport" required>
			    	</div>
		    		<div class="col-md-12 mb-3">
				    	<label for="adresse">Descriptif du sport</label>
				     	<input type="text" class="form-control" id="description" placeholder="Exemple: Balle aux prisionniers pratiqué par des loisirs" name="description" required>
		    		</div>
		    		<div class="col-md-12 mb-3">
					    <label for="adresse">Lieux du sport</label>
					    <!-- Récupérer les lieux depuis la base de données -->
					    <?php
					    $lieuManager = new Core\Models\LieuManager($pdo);
					    $lieus = $lieuManager->getAllLieus($id);

					    // Afficher chaque lieu comme une case à cocher

					    foreach ($lieus as $lieu) {
					        echo '<div class="form-check">';
						    echo '<input class="form-check-input" type="checkbox" value="' . $lieu->idlieu() . '" id="lieu_' . $lieu->idlieu() . '" name="lieux[]" >';
						    echo '<label class="form-check-label" for="lieu_' . $lieu->idlieu() . '">' . $lieu->nom_lieu() . '</label>';
						    echo '</div>';
					    }
					    ?>
					</div>
		    		<div class="col-md-12 mb-3">
		  				<button class="btn btn-primary btn-lg btn-block" type="submit">Créer</button>
		  			</div>
		  		</div>
		  	</div>
		</form>	  	
	</div>
<?}
if (isset($id) && !isset($supp) && isset($update)) {
    $sportManager = new Core\Models\SportManager($pdo);
    $sport = $sportManager->get($id, "sport");

    // ... (récupération des lieux si nécessaire)
    ?>
    <div class="container justify-content-center" id="form">
        <form class="container justify-content-center" method="post">
            <h1 style="text-align: center">Les Sports S.M.S.</h1>
            <div class="row">
                <!-- ... (images) -->
            </div>
            <div class="form-row1">
                <div class="form-row mt-4">
                    <input type="hidden" class="form-control" id="idsport" name="id" value="<?= $sport->idsport() ?>" />
                    <div class="col-md-12 mb-3">
                        <label for="nom_lieu">Nom du sport à ajouter à l'association:</label>
                        <input type="text" class="form-control" id="nom_sport" placeholder="Exemple: Balle aux prisionniers" name="nom_sport" required value="<?= $sport->nom_sport() ?>">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="adresse">Descriptif du sport</label>
                        <input type="text" class="form-control" id="description" placeholder="Exemple: Balle aux prisionniers pratiqué par des loisirs" name="description" required value="<?= $sport->description() ?>">
                    <div class="col-md-12 mb-3">
					    <label for="adresse">Lieux du sport</label>
					    <?php
					    $lieuManager = new Core\Models\LieuManager($pdo);
					    $allLieus = $lieuManager->getAllLieus();
					   // var_dump($allLieus);
					    $associatedLieus = $smanager->getSportAssociatedLieus($sport->idsport());
					    foreach ($allLieus as $lieu) {
						    $isChecked = false;	//var_dump($lieu);

						    foreach ($associatedLieus as $associatedLieu) {
						    	//var_dump($lieu);
						        if ($lieu->idlieu() === $associatedLieu->getIdlieu()) {
						            $isChecked = true;
						            break;
						        }
						    //var_dump($associatedLieu);}
						    }
						    echo '<div class="form-check">';
						    echo '<input class="form-check-input" type="checkbox" value="' . $lieu->idlieu() . '" id="lieu_' . $lieu->idlieu() . '" name="lieux[]" ' . ($isChecked ? 'checked' : '') . '>';
						    echo '<label class="form-check-label" for="lieu_' . $lieu->idLieu() . '">' . $lieu->nom_lieu() . '</label>';
						    echo '</div>';
						}
					    ?>
					</div>

                    <div class="col-md-12 mb-3">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Modifier</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php
}

/*if(isset($id)&&(!isset($supp))&&(isset($update))){
	?>
	<div class="container justify-content-center" id="form">
		<form class="container justify-content-center" method="post">
			<h1 style="text-align: center">Les Sports S.M.S.</h1>
			<div class="row">
			    <div class="col-md-4">
			    	<img src="template/assets/img/salle_back.jpg" class="img-fluid max-width: 50%; and height: auto; img-thumbnail" alt="Responsive image">
				</div>
				<div class="col-sm">
					<img src="template/assets/img/salle_back.jpg" class="img-fluid max-width: 50%; and height: auto; img-thumbnail" alt="Responsive image">
				</div>
				<div class="col-md-4">
					<img src="template/assets/img/salle_back.jpg" class="img-fluid max-width: 50%; and height: auto; img-thumbnail" alt="Responsive image">
				</div>
			</div>
			<div class="form-row1">
			  	<div class="form-row mt-4">
			  		<input type="hidden" class="form-control" id="idsport" name="id" value=NULL />
				    <div class="col-md-12 mb-3">
			    		<label for="nom_lieu">Nom du sport à ajouter à l'association:</label>
			    		<input type="text" class="form-control" id="nom_sport" placeholder="Exemple: Balle aux prisionniers" name="nom_sport" required>
			    	</div>
		    		<div class="col-md-12 mb-3">
				    	<label for="adresse">Descriptif du sport</label>
				     	<input type="text" class="form-control" id="description" placeholder="Exemple: Balle aux prisionniers pratiqué par des loisirs" name="description" required>
		    		</div>
		    		<div class="col-md-12 mb-3">
					    <label for="adresse">Lieux du sport</label>
					    <!-- Récupérer les lieux depuis la base de données -->
					    <?php
					    $lieuManager = new Core\Models\LieuManager($pdo);
					    $lieus = $lieuManager->getAllLieus($id);

					    // Afficher chaque lieu comme une case à cocher

					    foreach ($lieus as $lieu) {
					        echo '<div class="form-check">';
						    echo '<input class="form-check-input" type="checkbox" value="' . $lieu->idlieu() . '" id="lieu_' . $lieu->idlieu() . '" name="lieux[]" >';
						    echo '<label class="form-check-label" for="lieu_' . $lieu->idlieu() . '">' . $lieu->nom_lieu() . '</label>';
						    echo '</div>';
					    }
					    ?>
					</div>
		    		<div class="col-md-12 mb-3">
		  				<button class="btn btn-primary btn-lg btn-block" type="submit">Créer</button>
		  			</div>
		  		</div>
		  	</div>
		</form>	  	
	</div>

*/
?>

