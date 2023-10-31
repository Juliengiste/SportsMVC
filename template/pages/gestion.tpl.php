<?
/*******************************
 * Version : 1.0.0.0
 * Revised : jeudi 19 avril 2018, 16:43:50 (UTC+0200)
 *******************************/

$me = $_SESSION[SHORTNAME.'_user'];
$pmanager = new Core\Models\PersonneManager($pdo);
$sort = \Core\Classes\Utils::secureGet('sort',"nom");
$tri = \Core\Classes\Utils::secureGet('tri',"asc");
$invtri = ($tri=="asc")?"desc":"asc";
$personnelist = $pmanager->getList($sort,$tri,"personne");
?>
	
<div class="container">
	<h2>Gestion des roles</h2>
	
	<table class="table table-striped table-sm">
		<thead>
			<tr>
				<th class="text-nowrap"><a class="text-dark" href="gestion?sort=nom&tri=<?=$invtri?>">Nom <?if($sort=="nom"){if($tri=="asc")echo'<i class="d-inline fas fa-sort-down"></i>';else echo'<i class="d-inline fas fa-sort-up"></i>';}?></a></th>
				<th class="text-nowrap"><a class="text-dark" href="gestion?sort=prenom&tri=<?=$invtri?>">prénom <?if($sort=="prenom"){if($tri=="asc")echo'<i class="d-inline fas fa-sort-down"></i>';else echo'<i class="d-inline fas fa-sort-up"></i>';}?></a></th>
				<th class="text-nowrap"><a class="text-dark" href="gestion?sort=birthday&tri=<?=$invtri?>">Date de naissance <?if($sort=="birthday"){if($tri=="asc")echo'<i class="d-inline fas fa-sort-down"></i>';else echo'<i class="d-inline fas fa-sort-up"></i>';}?></a></th>
				<th class="text-nowrap"><a class="text-dark" href="gestion?sort=ville&tri=<?=$invtri?>">Role <?if($sort=="ville"){if($tri=="asc")echo'<i class="d-inline fas fa-sort-down"></i>';else echo'<i class="d-inline fas fa-sort-up"></i>';}?></a></th>					 
			</tr>
		</thead>
	
		<tbody>
			<?
				foreach ($personnelist as $personne) {
					?>
					<tr>
						<td class="align-middle"><?=mb_strtoupper($personne->nom())?></td>
						<td class="align-middle"><?=$personne->prenom()?></td>
						<td class="align-middle"><?=$personne->birthday()?></td>
						<td class="row align-middle">
							<!-- Group of default radios - option 1 -->
							<div class="custom-control custom-radio col-sm-4" >
							  <input type="radio" class="custom-control-input" id="idrole1" name="idrole" onchange="updateRole(<?=$personne->idpersonne()?>,1)" <?=($personne->role()==1)?"checked":""?>>
							  <label class="custom-control-label" for="idrole1">Administrateur</label>
							</div>

							<!-- Group of default radios - option 2 -->
							<div class="custom-control custom-radio col-sm-4">
							  <input type="radio" class="custom-control-input" id="idrole2" name="idrole" onchange="updateRole(<?=$personne->idpersonne()?>,2)" <?=($personne->role()==2)?"checked":""?>>
							  <label class="custom-control-label" for="idrole2">Cadre</label>
							</div>

							<!-- Group of default radios - option 3 -->
							<div class="custom-control custom-radio col-sm-4">
							  <input type="radio" class="custom-control-input" id="idrole3" name="idrole" onchange="updateRole(<?=$personne->idpersonne()?>,3)" <?=($personne->role()==3)?"checked":""?>>
							  <label class="custom-control-label" for="idrole3">Utilisateur</label>
							</div>
						</td>
					</tr>
					<?
				}
			?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	function updateRole(idpersonne, idrole){
		$.ajax({
	        url : 'requete',
	        type : 'POST',
	        dataType : 'html', // On désire recevoir du HTML
	        data:{'idpersonne':idpersonne, 'idrole':idrole},
	        success : function(){ 
       		},
       		error : function(resultat, statut, erreur){
       			console.log(statut);
       			console.log(resultat);
       			console.log(erreur);
       		},
			complete : function(resultat, statut){
				console.log(statut);
       			console.log(resultat);
       		}
   		});
	}

</script>