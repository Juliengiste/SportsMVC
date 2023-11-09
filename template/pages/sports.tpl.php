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
$supp = \Core\Classes\Utils::secureGet('supp');
$smanager = new Core\Models\SportManager($pdo);
$lmanager = new Core\Models\LieuManager($pdo);

if (isset($supp)){
	$smanager->deleteSport($id);
	$id = NULL;
	$supp = NULL;
}

if ((count($_POST) != 0 )&&(($_POST["id"]=="NULL"))){
	$newsport = $smanager->new("sport");
	$newsport->setNom_sport($_POST['nom_sport']);
	$newsport->setDescription($_POST['description']);
	$affichernewSport = $smanager->addSport($newsport);
	$id = NULL;
	$new = NULL;
}

/*******************************
Version : 1.0.0.0
Revised : jeudi 19 avril 2018, 16:49:24 (UTC+0200)
*******************************/
if(isset($_SESSION[SHORTNAME.'_user'])) $me = $_SESSION[SHORTNAME.'_user'];

if(isset($id)&&(!isset($supp))){
	$sportList = $smanager->get($id, "sport");
	$sport = $sportList;
	if($sport->nom_sport($id)=="volley"){
		$id=3;
		$lieuList = $lmanager->get($id, "lieu");
		$lieu = $lieuList; 
	}
	else {
		$lieuList = $lmanager->get($id, "lieu");
		$lieu = $lieuList;
	}
	
?>

<div class="container justify-content-center" id="content">
	<h1 style="text-align: center">Votre Associations Multi Sports</h1>
	<div>
		<div class="row">
		    <div class="col-sm">
				<img src="template/assets/img/<?=$sport->nom_sport($id)?>-back.jpg" class="img-fluid max-width: 50%; and height: auto; img-thumbnail" alt="Responsive image">
			</div>
			<div class="col-sm">
				<img src="template/assets/img/<?=$sport->nom_sport($id)?>-back.jpg" class="img-fluid max-width: 50%; and height: auto; img-thumbnail" alt="Responsive image">
			</div>
			<div class="col-sm">
				<img src="template/assets/img/<?=$sport->nom_sport($id)?>-back.jpg" class="img-fluid max-width: 50%; and height: auto; img-thumbnail" alt="Responsive image">
			</div>
		</div>
		<div>
			<div class="card text-center">
				<div class="card-header">
				</div>
			  	<div class="card-body">
			    	<h2 style="text-align: center;"><i class="fas fa-star"></i><?=strtoupper($sport->nom_sport($id))?></h2>
				    <h4>Le lieu: <?=$lieu->nom_lieu()?></h4>
				    <p class="card-text"><?=$lieu->adresse()?><br><?=$lieu->cp()?><?=$lieu->ville()?></p>
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
							<a href="sports/<?=$sport->idsport()?>">
								<button class="btn btn-warning" href="sport/<?echo'$sport->id()'?>"><i class="fas fa-eye"></i></button>
							</a>
							
							<a class="text-dark" onclick="alert('Etes-vous sûr de vouloir supprimer?')" href="sports/?id=<?=$sport->idsport()?>&supp=1 "><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>
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
		  				<button class="btn btn-primary btn-lg btn-block" type="submit">Créer</button>
		  			</div>
		  		</div>
		  	</div>
		</form>	  	
	</div>
<?}?>

