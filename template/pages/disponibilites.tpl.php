<style type="text/css">
	/* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 46px;
  height: 26px;
  float:right;
}

/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 20px;
  width: 20px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

.nomsport {
	position: relative;
	vertical-align: bottom;
}

input.default:checked + .slider {
  background-color: #444;
}
input.primary:checked + .slider {
  background-color: #2196F3;
}
input.success:checked + .slider {
  background-color: #8bc34a;
}
input.info:checked + .slider {
  background-color: #3de0f5;
}
input.warning:checked + .slider {
  background-color: #FFC107;
}
input.danger:checked + .slider {
  background-color: #f44336;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(20px);
  -ms-transform: translateX(20px);
  transform: translateX(20px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

<?php
$id = Core\Classes\Utils::secureGet('id');
$new = Core\Classes\Utils::secureGet('new');
$dmanager = new Core\Models\AgendaManager($pdo);
$smanager = new Core\Models\SportManager($pdo);
$listjour = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
$listsport = $smanager->getList('nom_sport', 'asc', 'sport');
/*******************************
Version : 1.0.0.0
Revised : jeudi 19 avril 2018, 16:49:24 (UTC+0200)
*******************************/
if(isset($_SESSION[SHORTNAME.'_user'])) $me = $_SESSION[SHORTNAME.'_user'];
setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);

if((count($_POST) != 0 )&&($_POST["id"]=="NULL")){
	$parent = false;
	$heure = strtotime($_POST['heure_debut']);
	$fin = strtotime($_POST["heure_fin"]);
	$duree = ($fin-$heure)/60;
	while ( $heure < $fin) {
		$newdispo = $dmanager->new("disponibilite");
		$newdispo->setJour_semaine($_POST['js']);
		$newdispo->setHeure_debut(date("H:i:s",$heure));
		$newdispo->setLieu($_POST['lieu']);
		$newdispo->setAnnee_scolaire($_POST['as']);
		$newdispo->setDispoparent(($parent)?$parentid:NULL);
		$newdispo->setDuree(($parent)?NULL:$duree);
		$affichernewDispo = $dmanager->addDisponibilite($newdispo);
		if (!$parent){
			$parent=true;
			$parentid=$affichernewDispo;
		}
		$heure = $heure+1800;		
	}
	foreach ($listsport as $sport) {
		if (isset($_POST[str_replace(" ", "", $sport->nom_sport())])){
			$dmanager->autorisesport($parentid, $sport->idsport());
		}
	}

	$new = NULL;
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'disponibilites';
	header("Location: http://$host$uri/$extra");
}

if(isset($id)&&(!isset($new))){
	$disponibilite = $dmanager->get($id, "disponibilite");
	$lieu = $dmanager->get($disponibilite->lieu(), "lieu");
?>

<div class="container justify-content-center" id="content">
	<h1 style="text-align: center">Votre Associations Multi Sports</h1>
	<div>
		<div class="row">
		    <!-- <div class="col-sm">
				<img src="template/assets/img/<?=$anneescolaire->label($id)?>-back.jpg" class="img-fluid max-width: 50%; and height: auto; img-thumbnail" alt="Responsive image">
			</div>
			<div class="col-sm">
				<img src="template/assets/img/<?=$anneescolaire->label($id)?>-back.jpg" class="img-fluid max-width: 50%; and height: auto; img-thumbnail" alt="Responsive image">
			</div>
			<div class="col-sm">
				<img src="template/assets/img/<?=$anneescolaire->label($id)?>-back.jpg" class="img-fluid max-width: 50%; and height: auto; img-thumbnail" alt="Responsive image">
			</div> -->
		</div>
		<div>
			<div class="card text-center">
				<div class="card-header">
				</div>
			  	<div class="card-body">
			    	<h2 style="text-align: center;"><i class="fas fa-star"></i><?=mb_strtoupper($disponibilite->jour_semaine())?></h2>
				    <h4>Début des Années scolaires: <?=date('h:m:s', strtotime($disponibilite->heure_debut()))?></h4>
				    <h4>Fin des Années scolaires: <?=$lieu->nom_lieu()?></h4>
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
	$anneelist = $dmanager->getList("label","asc","anneescolaire");
?>
<main>
	<div class="container">
		<h2>Liste des Années scolaires</h2>
		<a class="text-dark" href="disponibilites/?new=1">
			<button class="btn btn-primary"><i class="fas fa-plus-circle"></i> Ajout Disponibilités</button>
		</a>
		<br><br>
		<?
		foreach ($anneelist as $annee) {
		?>
		<div class="card text-center">
			<div class="card-header">
				<?=$annee->label()?>
			</div>
			<?
			foreach ($listjour as $jour) {
				$dispolist = $dmanager->getDispoJour($annee->idanneescolaire(), $jour);
				if (!empty($dispolist)){
				?>
				<div class="card-header">
					<?=$jour?>
				</div>
				<?
					foreach ($dispolist as $dispo) {
						$minute = $dispo->duree();
						$lieu = $dmanager->get($dispo->lieu(), "lieu");
						echo "<div class='row'><div class=\"card-body\"><h4>Heure de début</h4>
		  					".$dispo->heure_debut()."
			  			</div><div class=\"card-body\"><h4>Heure de fin</h4>
		  					".date("H:i:s",strtotime($dispo->heure_debut()."+$minute minutes"))."
			  			</div><div class=\"card-body\"><h4>Lieu</h4>
		  					".$lieu->nom_lieu()."
			  			</div></div>";
					}
				?>
				
				<?
				}
			}
			echo"</div><br><br>";
		}
		?>
	</div>
</main>
<?}
else{
	$anneescolist = $dmanager->getList("idanneescolaire", "asc", "anneescolaire");
	$lieulist = $dmanager->getList("idlieu", "asc", "lieu");
?>
<div class="container justify-content-center" id="form">
	<form class="container justify-content-center" method="post">
		<div class="form-row mt-4">
			<input type="hidden" class="form-control" id="idanneescolaire" name="id" value=NULL />
			<div class="form-row">
				<div class="form-group col-md-12">
					<h2>Les Disponibilités (hors période vacances)</h2>
					<br><br>
				</div>
				<div class="form-group col-md-4">
					<label>Année scolaire</label> 
					<select class="form-control" id="as" name="as">
						<option disabled selected>Choisissez l'année de référence</option>
						<?foreach ($anneescolist as $anneesco) {
							echo "<option value=".$anneesco->idanneescolaire().">".$anneesco->label()."</option>";
						}
						?>
					</select>
				</div>
				<div class="form-group col-md-4">
					<label>Lieu de la pratique</label> 
					<select class="form-control" id="lieu" name="lieu">
						<option disabled selected>Choisissez le lieu</option>
						<?foreach ($lieulist as $lieu) {
							echo "<option value=".$lieu->idlieu().">".$lieu->nom_lieu()."</option>";
						}
						?>
					</select>
				</div>
				<div class="form-group col-md-4">
					<label>Jour de la semaine</label> 								
					<select class="form-control" id="js" name="js">
						<option disabled selected>Choisissez le jour</option>
						<option value="lundi">Lundi</option>
						<option value="mardi">Mardi</option>
						<option value="mercredi">Mercredi</option>
						<option value="jeudi">Jeudi</option>
						<option value="vendredi">Vendredi</option>
						<option value="samedi">Samedi</option>
						<option value="dimanche">Dimanche</option>
					</select>
				</div>
				<div class="form-group col-md-6">
					<label>Heure de début</label> 
					<input type="time" class="form-control" id="heure_debut" name="heure_debut">
				</div>
				<div class="form-group col-md-6">
					<label>Heure de fin</label> 
					<input type="time" class="form-control" id="heure_fin" name="heure_fin">
				</div>
					<?
      foreach ($listsport as $sport) { 
      	?>      
      					<div class="form-group col-md-1">
      					</div>
						<div class="form-group col-md-2">
						<span class="nomsport">
	                    <?=ucwords($sport->nom_sport())?>
	                	</span>
	                    <label class="switch">
	          			<input type="checkbox" class="success" name="<?=str_replace(" ", "", $sport->nom_sport())?>">
	         			<span class="slider round"></span>
	        			</label>
	        		</div>
	        		<div class="form-group col-md-1">
      					</div>
        <?}?>
				<button type="submit" class="btn btn-primary col-md-12">Créer</button>
			</div>
		</div>
	</form>
</div>
<?}?>