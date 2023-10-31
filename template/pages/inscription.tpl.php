<?php
/*******************************
Version : 1.0.0.0
Revised : jeudi 19 avril 2018, 16:49:24 (UTC+0200)
*******************************/
$pmanager = new Core\Models\PersonneManager($pdo);

if(isset($_SESSION[SHORTNAME.'_user'])) $me = $_SESSION[SHORTNAME.'_user'];

if(count($_POST) != 0){
	$personne = $pmanager->newPersonne();
	$personne->setNom($_POST['nom']);
	$personne->setPrenom($_POST['prenom']);
	$personne->setSexe($_POST['sexe']);
	$personne->setBirthday($_POST['birthday']);
	$personne->setTel($_POST['tel']);
	$personne->setEmail($_POST['email']);
	$personne->setPwd(hash('sha512',$_POST['login_pwd']));
	$personne->setAdresse($_POST['adresse']);
	$personne->setCp($_POST['cp']);
	$personne->setVille($_POST['ville']);
	$personne->setRole(3);
	//$original = $_POST("origine");
	$pmanager->addPersonne($personne);
	//header($original);
}
if(isset($me)){
	header("Location: http://".URL);
}
else{
?>
<main class="bgaccueil vh-100 mt-4">
	<div class="container">
		<div class="row vh-100">
			<div class="d-flex align-items-center col-12 col-sm-12 text-center">
				<div class="card text-left">
					<div class="card-header">SMS</div>
					<div class="card-body">
						<form method="post">
							<input type="hidden" name="origine" value="<?php echo $origine; ?>">
							<div class="form-group">
								<!-- <label for="exampleInputPassword1">Mot de passe</label> -->
								<input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom">
							</div>
							<div class="form-group">
								<!-- <label for="exampleInputPassword1">Mot de passe</label> -->
								<input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre prénom">
							</div>
							<div class="form-group">
								<!-- <label for="exampleInputPassword1">Mot de passe</label> -->
								<select class="form-control" id="sexe" name="sexe">
								<option disabled selected>Choisissez votre sexe</option>
								<option value="femme">féminin</option>
								<option value="homme">masculin</option>
								</select>
							</div>
							<div class="form-group">
								<!-- <label for="exampleInputPassword1">Mot de passe</label> -->
								<input type="date" class="form-control" id="birthday" name="birthday" placeholder="Votre date de naissance">
							</div>
							<div class="form-group">
								<!-- <label for="exampleInputEmail1">Identifiant</label> -->
								<input type="text" class="form-control" id="tel" name="tel"placeholder="Votre téléphone">
							</div>
							<div class="form-group">
								<!-- <label for="exampleInputEmail1">Identifiant</label> -->
								<input type="email" class="form-control" id="email" name="email"placeholder="Votre email">
							</div>
							<div class="form-group">
								<!-- <label for="exampleInputPassword1">Mot de passe</label> -->
								<input type="password" class="form-control" id="login_pwd" name="login_pwd" placeholder="Mot de passe">
							</div>
							<div class="form-group">
								<!-- <label for="exampleInputEmail1">Identifiant</label> -->
								<input type="text" class="form-control" id="adresse" name="adresse"placeholder="Votre adresse">
							</div>
							<div class="form-group">
								<!-- <label for="exampleInputEmail1">Identifiant</label> -->
								<input type="text" class="form-control" id="cp" name="cp"placeholder="Votre code postal">
							</div>
							<div class="form-group">
								<!-- <label for="exampleInputEmail1">Identifiant</label> -->
								<input type="text" class="form-control" id="ville" name="ville"placeholder="Votre ville">
							</div>
							
							<div class="form-row mb-3">
								<div class="col-auto">
									<? Core\Classes\Captcha::displayCaptcha() ?>
								</div>
								<div class="col">
									<input type="text" class="form-control" id="login_captcha" placeholder="Recopier le code">
								</div>
							</div>
							<button type="submit" class="btn btn-primary">Envoyer</button>
						</form>							
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<?}?>