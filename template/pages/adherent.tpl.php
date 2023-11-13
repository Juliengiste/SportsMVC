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
$id = \Core\Classes\Utils::secureGet('id');
$new = \Core\Classes\Utils::secureGet('new');
$supp = \Core\Classes\Utils::secureGet('new');
$smanager = new Core\Models\PersonneManager($pdo);
$lmanager = new Core\Models\LieuManager($pdo);



/*******************************
Version : 1.0.0.0
Revised : jeudi 19 avril 2018, 16:49:24 (UTC+0200)
*******************************/
if(isset($_SESSION[SHORTNAME.'_user'])) $me = $_SESSION[SHORTNAME.'_user'];

if(isset($id)){
	$nomList = $smanager->get($id, "personne");
	$nom = $nomList;

	if($nom->nom($id)==" "){
		$id=1;
		$lieuList = $lmanager->get($id, "lieu");
		$lieu = $lieuList; 
	}
	else {
		var_dump($nom);
		$lieuList = $lmanager->get($id, "lieu");
		$lieu = $lieuList;
	}
	
?>

<div class="container justify-content-center" id="content">
	<h1 style="text-align: center">Votre Associations Multi Sports</h1>
	<div>
		<div class="row">
		    <div class="col-sm">
				<img src="template/assets/img/<?=$nomList->nom($idpersonne)?>-back.jpg" class="img-fluid max-width: 50%; and height: auto; img-thumbnail" alt="Responsive image">
			</div>
			<div class="col-sm">
				<img src="template/assets/img/<?=$nomList->nom($idpersonne)?>-back.jpg" class="img-fluid max-width: 50%; and height: auto; img-thumbnail" alt="Responsive image">
			</div>
			<div class="col-sm">
				<img src="template/assets/img/<?=$nomList->nom($idpersonne)?>-back.jpg" class="img-fluid max-width: 50%; and height: auto; img-thumbnail" alt="Responsive image">
			</div>
		</div>
		<div>
			<div class="card text-center">
				<div class="card-header">
				</div>
			  	<div class="card-body">
			    	<h2 style="text-align: center;"><i class="fas fa-star"></i><?=ucfirst($nomList->prenom())?> <?=strtoupper($nomList->nom($id))?></h2>
				    <h4>Adresse: </h4>
				    <p class="card-text"><?=$nomList->adresse()?><br><?=$nomList->cp()?><?=$nomList->ville()?></p>
					<h4>Les horaires</h4>
					<p class="card-text">Les séances sont prévues tous les mercredis à partir de 19h mais n'hésitez pas à consulter le planning pour connaître les disponibilités</p>
					<h4>Règlement</h4>
					<p class="card-text">Les chaussures d'intérieures sont obligatoires pour pratiquer le badminton. Le matériel est prêté par l'association lors de votre venue.</p>
					<h4>Contacts</h4>
				    <p class="card-text">Responsable de la section: Hélène Jaligny</p>
				    <a href="#" class="btn btn-primary">VOIR LE PLANNING</a>
			  	</div>
			 	<div class="card-footer text-muted">
			    	<p>Pensez à vous inscrire pour participer aux séances</p>
				</div>
			</div>
		</div>
	</div>
</div>
<?}
elseif(!isset($id)&&(!isset($new))){
	$sort = \Core\Classes\Utils::secureGet('sort',"nom");
	$tri = \Core\Classes\Utils::secureGet('tri',"asc");
	$invtri = ($tri=="asc")?"desc":"asc";
	$nomList = $smanager->getList($sort,$tri,"personne");
?>
	<main>
	<div class="container">
		<h2>Liste des adhérents SMS</h2>
		<a class="text-dark" href="adherent/?new=1">
			<button class="btn btn-primary"><i class="fas fa-plus-circle"></i> Ajout Adhérent</button>
		</a>
		<br><br>
		<table class="table table-striped table-sm">
			<thead>
				<tr>
					<th class="text-nowrap"><a class="text-dark" href="adherent/?sort=nom&tri=<?=$invtri?>">Nom <?if($sort=="nom"){if($tri=="asc")echo'<i class="d-inline fas fa-sort-down"></i>';else echo'<i class="d-inline fas fa-sort-up"></i>';}?></a></th>
					<th class="text-nowrap"><a class="text-dark" href="adherent/?sort=prenom&tri=<?=$invtri?>">prénom <?if($sort=="prenom"){if($tri=="asc")echo'<i class="d-inline fas fa-sort-down"></i>';else echo'<i class="d-inline fas fa-sort-up"></i>';}?></a></th>
					<th class="text-nowrap"><a class="text-dark" href="adherent/?sort=tel&tri=<?=$invtri?>">Télephone <?if($sort=="tel"){if($tri=="asc")echo'<i class="d-inline fas fa-sort-down"></i>';else echo'<i class="d-inline fas fa-sort-up"></i>';}?></a></th>			 
					<th>Actions</a></th>
				</tr>
			</thead>
			<tbody>
				<? $nameList = $smanager->getList($sort,$tri,"personne");
				if (is_array($nameList)) {
    				foreach ($nameList as $nom) {
						?>
						<tr>
							<td class="align-middle"><?=strtoupper($nom->nom())?></td>
							<td class="align-middle"><?=ucfirst($nom->prenom())?></td>
							<td class="align-middle"><?=$nom->tel()?></td>
							<td class="align-middle">
							<a href="adherent/<?=$nom->idpersonne()?>">
								<button class="btn btn-warning" href="adherent/<?echo'$nom->idpersonne()'?>"><i class="fas fa-eye"></i></button>
							</a>
								<button class="btn btn-danger"><i class="fas fa-trash"></i></button> 
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
