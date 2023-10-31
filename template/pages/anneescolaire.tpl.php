<?php
$id = Core\Classes\Utils::secureGet('id');
$new = Core\Classes\Utils::secureGet('new');
$asmanager = new Core\Models\AgendaManager($pdo);
/*******************************
Version : 1.0.0.0
Revised : jeudi 19 avril 2018, 16:49:24 (UTC+0200)
*******************************/
if(isset($_SESSION[SHORTNAME.'_user'])) $me = $_SESSION[SHORTNAME.'_user'];
setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);

if((count($_POST) != 0 )&&($_POST["id"]=="NULL")){
	$newvac = $asmanager->new("anneescolaire");
	$newvac->setLabel($_POST['label']);
	$newvac->setDate_debut($_POST['date_debut']);
	$newvac->setDate_fin($_POST['date_fin']);
	$affichernewVac = $asmanager->addAnneescolaire($newvac);
	$id = NULL;
	$new = NULL;
	//header($original);
}

if(isset($id)&&(!isset($new))){
	$anneescolaire = $asmanager->get($id, "anneescolaire");
?>

<div class="container justify-content-center" id="content">
	<h1 style="text-align: center">Votre Associations Multi Sports <?=$anneescolaire->label()?></h1>
	<div>
		<div class="row">
		    <div class="col-sm">
				<img src="template/assets/img/<?=$anneescolaire->label($id)?>-back.jpg" class="img-fluid max-width: 50%; and height: auto; img-thumbnail" alt="Responsive image">
			</div>
			<div class="col-sm">
				<img src="template/assets/img/<?=$anneescolaire->label($id)?>-back.jpg" class="img-fluid max-width: 50%; and height: auto; img-thumbnail" alt="Responsive image">
			</div>
			<div class="col-sm">
				<img src="template/assets/img/<?=$anneescolaire->label($id)?>-back.jpg" class="img-fluid max-width: 50%; and height: auto; img-thumbnail" alt="Responsive image">
			</div>
		</div>
		<div>
			<div class="card text-center">
				<div class="card-header">
				</div>
			  	<div class="card-body">
			    	<h2 style="text-align: center;"><i class="fas fa-star"></i><?=mb_strtoupper($anneescolaire->label($id))?></h2>
				    <h4>Début des Années scolaires: <?=date('j F Y', strtotime($anneescolaire->date_debut()))?></h4>
				    <h4>Fin des Années scolaires: <?=date('j F Y', strtotime($anneescolaire->date_fin()))?></h4>
			  	</div>
			  	<div class="card-body">
			  		<? $vacanceslist = $asmanager->getListVac($anneescolaire->idanneescolaire());
			  			foreach ($vacanceslist as $vacances) {
			  				?>
					  		<h2 style="text-align: center;"><i class="fas fa-star"></i><?=mb_strtoupper($vacances->label($id))?></h2>
						    <h4>Début des Années scolaires: <?=date('j F Y', strtotime($vacances->date_debut()))?></h4>
						    <h4>Fin des Années scolaires: <?=date('j F Y', strtotime($vacances->date_fin()))?></h4>	
			  				<?
			  			}
			  		?>
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
	$sort = \Core\Classes\Utils::secureGet('sort',"label");
	$tri = \Core\Classes\Utils::secureGet('tri',"asc");
	$invtri = ($tri=="asc")?"desc":"asc";
	$anneList = $asmanager->getList($sort,$tri,"anneescolaire");
	
?>
<main>
	<div class="container">
		<h2>Liste des Années scolaires</h2>
		<a class="text-dark" href="anneescolaire/?new=1">
			<button class="btn btn-primary"><i class="fas fa-plus-circle"></i> Ajout Années scolaires</button>
		</a>
		<br><br>
		<table class="table table-striped table-sm">
			<thead>
				<tr>
					<th class="text-nowrap"><a class="text-dark" href="?sort=label&tri=<?=$invtri?>">Nom <?if($sort=="label"){if($tri=="asc")echo'<i class="d-inline fas fa-sort-down"></i>';else echo'<i class="d-inline fas fa-sort-up"></i>';}?></a></th>
					<th class="text-nowrap"><a class="text-dark" href="?sort=date_debut&tri=<?=$invtri?>">Début <?if($sort=="date_debut"){if($tri=="asc")echo'<i class="d-inline fas fa-sort-down"></i>';else echo'<i class="d-inline fas fa-sort-up"></i>';}?></a></th>
					<th class="text-nowrap"><a class="text-dark" href="?sort=date_debut&tri=<?=$invtri?>">Fin <?if($sort=="date_debut"){if($tri=="asc")echo'<i class="d-inline fas fa-sort-down"></i>';else echo'<i class="d-inline fas fa-sort-up"></i>';}?></a></th>			 
					<th>Actions</a></th>
				</tr>
			</thead>
			<tbody>
				<? 						
				foreach ($anneList as $anneescolaire) {
					$anne = $asmanager->get($anneescolaire->idanneescolaire(),"anneescolaire");
					?>
					<tr>
						<td class="align-middle"><?=mb_strtoupper($anneescolaire->label())?></td>
						<td class="align-middle"><?=date("d-m-Y", strtotime($anneescolaire->date_debut()))?></td>
						<td class="align-middle"><?=date("d-m-Y", strtotime($anneescolaire->date_fin()))?></td>
						<td class="align-middle">
						<a href="anneescolaire/<?=$anneescolaire->idanneescolaire()?>">
							<button class="btn btn-warning" href="anneescolaire/<?echo'$anneescolaire->idvac()'?>"><i class="fas fa-eye"></i></button>
						</a>
							<!-- <button class="btn btn-danger"><i class="fas fa-trash"></i></button> -->
						</td>
					</tr>
					<?
				}
				?>
			</tbody>
		</table>
	</div>
</main>
<?}
else{
	$sort = \Core\Classes\Utils::secureGet('sort',"label");
	$tri = \Core\Classes\Utils::secureGet('tri',"asc");
	$invtri = ($tri=="asc")?"desc":"asc";
	$anneescolist = $vmanager->getList($sort,$tri, "anneescolaire");
	?>
<div class="container justify-content-center" id="form">
	<form class="container justify-content-center" method="post">
		<div class="form-row mt-4">
			<input type="hidden" class="form-control" id="idanneescolaire" name="id" value=NULL />
			<div class="form-row">
			<h2>Les Années scolaires</h2>
			<br><br>
				<div class="form-group col-md-12">
					<label>Nom de l'Année scolaire</label> 								
					<input type="text" class="form-control" id="label" name="label" placeholder="Exemple: Vacances de Noël">
				</div>
				<div class="form-group col-md-6">
					<label>Date de début</label> 
					<input type="date" class="form-control" id="date_debut" name="date_debut">
				</div>
				<div class="form-group col-md-6">
					<label>Date de fin</label> 
					<input type="date" class="form-control" id="date_fin" name="date_fin">
				</div>
				<button type="submit" class="btn btn-primary">Créer</button>
			</div>
		</div>
	</form>
</div>
<?}?>