<?php
$id = Core\Classes\Utils::secureGet('id');
$new = Core\Classes\Utils::secureGet('new');
$supp = \Core\Classes\Utils::secureGet('supp');
$vmanager = new Core\Models\AgendaManager($pdo);
$vacancesManager = new Core\Models\VacancesManager($pdo);

//$listVac = $vacancesManager->getList('idvac', 'asc', 'sport');
/*******************************
Version : 1.0.0.0
Revised : jeudi 19 avril 2018, 16:49:24 (UTC+0200)
*******************************/
if(isset($_SESSION[SHORTNAME.'_user'])) $me = $_SESSION[SHORTNAME.'_user'];
setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);

if((count($_POST) != 0 )&&($_POST["id"]=="NULL")){
	$newvac = $vmanager->new("vacances");
	$newvac->setLabel($_POST['label']);
	$newvac->setDate_debut($_POST['date_debut']);
	$newvac->setDate_fin($_POST['date_fin']);
	$newvac->setAnneescolaire($_POST['idanneescolaire']);
	$affichernewVac = $vmanager->addVacances($newvac);
	$id = NULL;
	$new = NULL;
	//header($original);
}

if (isset($supp)){
	$entryIdToDelete = $id; 
	// L'ID de l'entrée à supprimer
    $vacancesManager->deleteVacances($entryIdToDelete);
    // Réinitialiser les variables après la suppression
    $id = NULL;
    $supp = NULL;	
}

if(isset($id)&&(!isset($new))&&(!isset($supp))){
	$vacances = $vmanager->get($id, "vacances");
	$annee = $vmanager->get($vacances->anneescolaire(), "anneescolaire");
?>

<div class="container justify-content-center" id="content">
	<h1 style="text-align: center">Les <?=($vacances->label($id))?> de l'année <?=$annee->label()?></h1>
	<div>
		<div class="row">
		    <div class="col-sm">
				<img src="template/assets/img/<?=$vacances->label()?>-back.jpg" class="img-fluid max-width: 50%; and height: auto; img-thumbnail" alt="Responsive image">
			</div>
			<div class="col-sm">
				<img src="template/assets/img/<?=$vacances->label()?>-back.jpg" class="img-fluid max-width: 50%; and height: auto; img-thumbnail" alt="Responsive image">
			</div>
			<div class="col-sm">
				<img src="template/assets/img/<?=$vacances->label()?>-back.jpg" class="img-fluid max-width: 50%; and height: auto; img-thumbnail" alt="Responsive image">
			</div>
		</div>
		<div>
			<div class="card text-center">
				<div class="card-header">
				</div>
			  	<div class="card-body">
			    	<h2 style="text-align: center;"><i class="fas fa-star"></i><?=mb_strtoupper($vacances->label())?></h2>
				    <h4>Début des vacances: <?=date('j F Y', strtotime($vacances->date_debut()))?></h4>
				    <h4>Fin des vacances: <?=date('j F Y', strtotime($vacances->date_fin()))?></h4>
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
	$vacanceList = $vmanager->getList($sort,$tri,"vacances");	
?>
<main>
	<div class="container">
		<h2>Liste des vacances</h2>
		<a class="text-dark" href="vacances/?new=1">
			<button class="btn btn-primary"><i class="fas fa-plus-circle"></i> Ajout vacances</button>
		</a>
		<br><br>
		<table class="table table-striped table-sm">
			<thead>
				<tr>
					<th class="text-nowrap"><a class="text-dark" href="vacances/?sort=label&tri=<?=$invtri?>">Nom <?if($sort=="label"){if($tri=="asc")echo'<i class="d-inline fas fa-sort-down"></i>';else echo'<i class="d-inline fas fa-sort-up"></i>';}?></a></th>
					<th class="text-nowrap"><a class="text-dark" href="vacances/?sort=anneescolaire&tri=<?=$invtri?>">Saison <?if($sort=="anneescolaire"){if($tri=="asc")echo'<i class="d-inline fas fa-sort-down"></i>';else echo'<i class="d-inline fas fa-sort-up"></i>';}?></a></th>	
					<th class="text-nowrap"><a class="text-dark" href="vacances/?sort=date_debut&tri=<?=$invtri?>">Début <?if($sort=="date_debut"){if($tri=="asc")echo'<i class="d-inline fas fa-sort-down"></i>';else echo'<i class="d-inline fas fa-sort-up"></i>';}?></a></th>
					<th class="text-nowrap"><a class="text-dark" href="vacances/?sort=date_debut&tri=<?=$invtri?>">Fin <?if($sort=="date_debut"){if($tri=="asc")echo'<i class="d-inline fas fa-sort-down"></i>';else echo'<i class="d-inline fas fa-sort-up"></i>';}?></a></th>			 
					<th>Actions</a></th>
				</tr>
			</thead>
			<tbody>
				<? 
				if(is_array($vacanceList)){
						
					foreach ($vacanceList as $vacances) {
						$anne = $vmanager->get($vacances->anneescolaire(),"anneescolaire");
						?>
						<tr>
							<td class="align-middle"><?=mb_strtoupper($vacances->label())?></td>
							<td class="align-middle"><?echo $anne->label($vacances->anneescolaire())?></td>
							<td class="align-middle"><?=date("d-m-Y", strtotime($vacances->date_debut()))?></td>
							<td class="align-middle"><?=date("d-m-Y", strtotime($vacances->date_fin()))?></td>
							<td class="align-middle">
							<a href="vacances/<?=$vacances->idvacances()?>">
								<button class="btn btn-warning" href="vacances/<?echo'$vacances->idvacances()'?>"><i class="fas fa-eye"></i></button>
							</a>
								<a class="text-dark" onclick="alert('Etes-vous sûr de vouloir supprimer?')" href="vacances/?id=<?=$vacances->idvacances();?>&supp=1 "><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>
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
<?}
else{
	$anneescolist = $vmanager->getList("idanneescolaire", "asc", "anneescolaire");
	?>
<div class="container justify-content-center" id="form">
	<form class="container justify-content-center" method="post">
		<div class="form-row mt-4">
			<input type="hidden" class="form-control" id="idvac" name="id" value=NULL />
			<div class="form-row">
			<h2>Les vacances</h2>
			<br><br>
				<div class="form-group col-md-12">
					<label>Nom des vacances</label> 								
					<input type="text" class="form-control" id="label" name="label" placeholder="Exemple: Vacances de Noël">
				</div>
				<div class="form-group col-md-6">
					<label>Date de début</label> 
					<input type="date" class="form-control" id="date_debut" name="date_debut">
				</div>
				<div class="form-group col-md-6">
					<label>Date de fin</label> 
					<input type="date" class="form-control" id="date_fin" name="date_fin">
					<select class="form-control" id="idanneescolaire" name="idanneescolaire">
						<option disabled selected>Choisissez l'année de référence</option>
						<?foreach ($anneescolist as $anneesco) {
							echo "<option value=".$anneesco->idanneescolaire().">".$anneesco->label()."</option>";
						}
						?>
					</select>
				</div>
				<button type="submit" class="btn btn-primary">Créer</button>
			</div>
		</div>
	</form>
</div>
<?}?>