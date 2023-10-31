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
 #map{ /* la carte DOIT avoir une hauteur sinon elle n'apparaît pas */
                height:400px;
            }
</style>

<?
/*******************************
 * Version : 1.0.0.0
 * Revised : jeudi 19 avril 2018, 16:43:50 (UTC+0200)
 *******************************/

$me = $_SESSION[SHORTNAME.'_user'];

$id = \Core\Classes\Utils::secureGet('id');
$new = \Core\Classes\Utils::secureGet('new');
$supp = \Core\Classes\Utils::secureGet('supp');
$lmanager = new Core\Models\AgendaManager($pdo);

// if (isset($supp)){
// 	$lmanager->supp($id, "lieu");
// 	$id = NULL;
// 	$supp = NULL;
// }

if ((count($_POST) != 0 )&&(($_POST["id"]=="NULL"))){
	$newlieu = $lmanager->new("lieu");
	$newlieu->setNom_lieu($_POST['nom_lieu']);
	$newlieu->setAdresse($_POST['adresse']);
	$newlieu->setVille($_POST['ville']);
	$newlieu->setCp($_POST['cp']);
	$newlieu->setLattitude((isset($_POST['lattitude']))?$_POST['lattitude']:"NULL");
	$newlieu->setLongitude((isset($_POST['longitude']))?$_POST['longitude']:"NULL");
	$affichernewLieu = $lmanager->addLieu($newlieu);
	$id = NULL;
	$new = NULL;
}

// if ((count($_POST) != 0)&&(($_POST["id"]!="NULL"))){
// 	$customer->setName($_POST['name']);
// 	$customer->setEmail($_POST['email']);
// 	$customer->setCompany($_POST['company']);
// 	$customer->setAddress1($_POST['address1']);
// 	$customer->setAddress2($_POST['address2']);
// 	$customer->setAddress3($_POST['address3']);
// 	$customer->setCountry($_POST['country']);
// 	$customer->setPhone($_POST['phone']);
// 	$cmanager->update($customer);
// 	$id = NULL;
// 	//alerte JS pour afficher après action
// 	echo "<script> window.alert('modification réussie');</script>";
// }

if(!isset($id)&&(!isset($new))){
	$sort = \Core\Classes\Utils::secureGet('sort',"nom_lieu");
	$tri = \Core\Classes\Utils::secureGet('tri',"asc");
	$invtri = ($tri=="asc")?"desc":"asc";
	$lieuList = $lmanager->getList($sort,$tri,"lieu");
	?>
	
	<div class="container">
		<h2>Gestion des lieux sportifs</h2>
		<a class="text-dark" href="lieu/?new=1"><button class="btn btn-primary"><i class="fas fa-plus-circle"></i> Ajout lieu</button></a>

		<table class="table table-striped table-sm">
			<thead>
				<tr>
					<th class="text-nowrap"><a class="text-dark" href="lieu?sort=nom_lieu&tri=<?=$invtri?>">Nom <?if($sort=="nom_lieu"){if($tri=="asc")echo'<i class="d-inline fas fa-sort-down"></i>';else echo'<i class="d-inline fas fa-sort-up"></i>';}?></a></th>
					<th class="text-nowrap"><a class="text-dark" href="lieu?sort=adresse&tri=<?=$invtri?>">adresse <?if($sort=="adresse"){if($tri=="asc")echo'<i class="d-inline fas fa-sort-down"></i>';else echo'<i class="d-inline fas fa-sort-up"></i>';}?></a></th><th class="text-nowrap"><a class="text-dark" href="lieu?sort=cp&tri=<?=$invtri?>">CP <?if($sort=="cp"){if($tri=="asc")echo'<i class="d-inline fas fa-sort-down"></i>';else echo'<i class="d-inline fas fa-sort-up"></i>';}?></a></th>
					<th class="text-nowrap"><a class="text-dark" href="lieu?sort=ville&tri=<?=$invtri?>">Ville <?if($sort=="ville"){if($tri=="asc")echo'<i class="d-inline fas fa-sort-down"></i>';else echo'<i class="d-inline fas fa-sort-up"></i>';}?></a></th>					 
					<th>Actions</a></th>
				</tr>
			</thead>
		
			<tbody>
				<? 
				if(is_array($lieuList)){
					foreach ($lieuList as $lieu) {
						?>
						<tr>
							<td class="align-middle"><?=mb_strtoupper($lieu->nom_lieu())?></td>
							<td class="align-middle"><?=$lieu->adresse()?></td>
							<td class="align-middle"><?=$lieu->cp()?></td>
							<td class="align-middle"><?=mb_strtoupper($lieu->ville())?></td>
							<td class="align-middle">
								<a href="lieu/?id=<?=$lieu->idlieu()?>">
									<button class="btn btn-warning" ><i class="fas fa-eye"></i></button>
								</a>
								<!-- <a href="lieu/?id=<?=$lieu->idlieu()?>&supp=1">
									<button class="btn btn-danger"><i class="fas fa-trash"></i></button>
								</a> -->
							</td>
						</tr>
						<?
					}
				}
				?>
			</tbody>
		</table>
	</div>

<?}
elseif (!isset($id)&&(isset($new))) {
	?>
	<div class="container justify-content-center" id="form">
		<form class="container justify-content-center" method="post">
			<h1 style="text-align: center">Les Lieux S.M.S.</h1>
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
			  		<input type="hidden" class="form-control" id="idlieu" name="id" value=NULL />
				    <div class="col-md-12 mb-3">
			    		<label for="nom_lieu">Nom du lieu utilisé par l'association:</label>
			    		<input type="text" class="form-control" id="nom_lieu" placeholder="Exemple: Gymanse de Saulieu" name="nom_lieu" required>
			    	</div>
		    		<div class="col-md-12 mb-3">
				    	<label for="adresse">Adresse du lieu</label>
				     	<input type="text" class="form-control" id="adresse" placeholder="Exemple: 15 rue Pierre de Coubertin" name="adresse" required>
		    		</div>
		    		<div class="col-md-8 mb-3">
				    	<label for="ville">Ville</label>
				     	<input type="text" class="form-control" id="ville" placeholder="Exemple: Saulieu" value="Saulieu" name="ville" required>
				    </div>
		    		<div class="col-md-4 mb-3">
		      			<label for="code_postale">Code Postale</label>
		      			<input type="text" class="form-control" id="code_postale" placeholder="Exemple: 21210" value="21210" name="cp" required>
		    		</div>
		    		<div class="col-md-4 mb-3">
		      			<label for="lattitude">Latitude</label>
		      			<input type="text" class="form-control" id="lattitude" placeholder="47.281566" name="lattitude">
		    		</div>
		    		<div class="col-md-4 mb-3">
		      			<label for="longitude">Longitude</label>
		      			<input type="text" class="form-control" id="longitude" placeholder="4.224807" name="longitude">
		    		</div>
		    		<div class="col-md-12 mb-3">
		  				<button class="btn btn-primary btn-lg btn-block" type="submit">Créer</button>
		  			</div>
		  		</div>
		  	</div>
		</form>	  	
	</div>
<?}
elseif (isset($id)&&(!isset($new))) {
	$lieu = $lmanager->get($id, "lieu");
?>
	<div class="container justify-content-center" id="form">
		<form class="container justify-content-center" method="post">
			<h1 style="text-align: center">Les Lieux S.M.S.</h1>
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
				<input type="hidden" id="lattitude" name="lattitude" value="<?=$lieu->lattitude()?>">
				<input type="hidden" id="longitude" name="longitude" value="<?=$lieu->longitude()?>">
			  	<div class="form-row mt-4">
				    <div class="col-md-12 mb-3">
			    		<label for="nom_lieu">Nom du lieu utilisé par l'association:</label>
			    		<input type="text" class="form-control" id="nom_lieu" value="<?=mb_strtoupper($lieu->nom_lieu())?>" disabled>
			    	</div>
		    		<div class="col-md-12 mb-3">
				    	<label for="description">Adresse du lieu:</label>
				     	<input type="text" class="form-control" id="description" value="<?=$lieu->adresse()?>" disabled>
		    		</div>
		    		<div class="col-md-8 mb-3">
				    	<label for="ville">Ville:</label>
				     	<input type="text" class="form-control" id="ville" value="<?=$lieu->cp()?>" disabled>
				    </div>
		    		<div class="col-md-4 mb-3">
		      			<label for="code_postale">Code Postale:</label>
		      			<input type="text" class="form-control" id="code_postale" value="<?=mb_strtoupper($lieu->ville())?>" disabled>
		    		</div>
		  		</div>
		  	</div>
		</form>	 
		<div id="map">
	    <!-- Ici s'affichera la carte --> 	
		</div>
	</div>
<?
}
?>

<!-- Fichiers Javascript OpenStreetMap-->
 <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
 <script type="text/javascript">
            // On initialise la latitude et la longitude (centre de la carte)
            var lat = document.getElementById("lattitude").value;
            var lon = document.getElementById("longitude").value;
            var macarte = null;
            // Fonction d'initialisation de la carte
            function initMap() {
                // Créer l'objet "macarte" et l'insèrer dans l'élément HTML qui a l'ID "map"
                macarte = L.map('map').setView([lat, lon], 11);
                // Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, openstreetmap.fr
                L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
                    // Il est toujours bien de laisser le lien vers la source des données
                    attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
                    minZoom: 16,
                    maxZoom: 20
                }).addTo(macarte);
            }
            window.onload = function(){
		// Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
		initMap(); 
            var marker = L.marker([lat, lon]).addTo(macarte);
            };
        </script>