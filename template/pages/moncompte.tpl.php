<?php
/*******************************
Version : 1.0.0.0
Revised : jeudi 19 avril 2018, 16:49:24 (UTC+0200)
*******************************/
$pmanager = new Core\Models\PersonneManager($pdo);

if(isset($_SESSION[SHORTNAME.'_user'])) $me = $_SESSION[SHORTNAME.'_user'];

if(count($_POST) != 0 && (isset($_POST['id']))){
	$personne = $pmanager->newPersonne();
	$personne->setIdpersonne($_POST['id']);
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
	$personne->setRole($me->role());
	//$original = $_POST("origine");
	$me = $pmanager->updatePersonne($personne);
	//header($original);
	$_SESSION['st_user']=$me;

}
?>

	<div class="container mt-3" id="content">
		<div class="row vh-100">
			<div class="align-items-center col-12 col-sm-12 text-center">
				<div class="card text-center">
					<div class="card-header">Mon compte S.M.Sports</div>
					<div class="card-body">
						<form method="post">
							<input type="hidden" name="origine" value="<? echo $origine; ?>">
							<input type="hidden" name="id" value="<?=$me->idpersonne() ?>">
							<div class="form-row">
								<div class="form-group col-md-6">
									<label>Nom de famille</label> 								<input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom" value="<?=$me->nom()?>">
								</div>
								<div class="form-group col-md-6">
									<label>Prénom</label> 
									<input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre prénom" value="<?=$me->prenom()?>">
								</div>
								<div class="form-group col-md-3">
									<label>Genre (sexe)</label> 
									<select class="form-control" id="sexe" name="sexe">
									<option disabled>Choisissez votre sexe</option>
									<option value="femme" <?=($me->sexe()=="femme")?"selected":""?>>féminin</option>
									<option value="homme" <?=($me->sexe()=="homme")?"selected":""?>>masculin</option>
									</select>
								</div>
								<div class="form-group col-md-3">
									<label>Date de naissance</label> 
									<input type="date" class="form-control" id="birthday" name="birthday" placeholder="Votre date de naissance" value="<?=$me->birthday()?>">
								</div>
								<div class="form-group col-md-3">
									<label >Téléphone</label> 
									<input type="text" class="form-control" id="tel" name="tel" placeholder="Votre téléphone" value="<?=$me->tel()?>">
								</div>
								<div class="form-group col-md-3">
									<label >email</label> 
									<input type="email" class="form-control" id="email" name="email" placeholder="Votre email" value="<?=$me->email()?>">
								</div>
								
								<div class="form-group col-md-12">
									<label >Adresse</label> 
									<input type="text" class="form-control" id="adresse" name="adresse" placeholder="Votre adresse" value="<?=$me->adresse()?>">
								</div>
								<div class="form-group col-md-3">
									<label for="exampleInputEmail1">Code Postale</label> 
									<input type="text" class="form-control" id="cp" name="cp" placeholder="Votre code postal" value="<?=$me->cp()?>">
								</div>
								<div class="form-group col-md-3">
									<label for="exampleInputEmail1">Ville</label> 
									<input type="text" class="form-control" id="ville" name="ville" placeholder="Votre ville" value="<?=$me->ville()?>">
								</div>
								<div class="form-group col-md-6">
									<label >Mot de passe</label> 
									<input type="password" class="form-control" id="login_pwd" name="login_pwd" placeholder="Mot de passe" value="<?=$me->pwd()?>">
								</div>
							</div>
							<button type="submit" class="btn btn-primary">Enregistrer</button>
						</form>							
					</div>
				</div>
			</div>
		</div>
	</div>
