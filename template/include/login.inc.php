<?php
/*******************************
Version : 1.0.0.0
Revised : jeudi 19 avril 2018, 16:49:24 (UTC+0200)
*******************************/
?>
<main class="bgaccueil vh-100">
	<div class="container">
		<div class="row vh-100">
			<div class="d-flex align-items-center col-12 col-sm-6 offset-sm-6 text-center">
				<?php
				if(isset($_SESSION[SHORTNAME.'_user_error'])){?>
				<div class="alert alert-danger"><?php echo $_SESSION[SHORTNAME.'_user_error']; ?></div>
				<?}?>
				<div class="card text-left">
					<div class="card-header">Sédélocienne MultiSport</div>
					<div class="card-body">
						<form action="<?php echo $origine; ?>" method="post">
							<div class="form-group">
								<!-- <label for="exampleInputEmail1">Identifiant</label> -->
								<input type="text" class="form-control" id="login_login" name="login_login"placeholder="Identifiant">
							</div>
							<div class="form-group">
								<!-- <label for="exampleInputPassword1">Mot de passe</label> -->
								<input type="password" class="form-control" id="login_pwd" name="login_pwd" placeholder="Mot de passe">
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