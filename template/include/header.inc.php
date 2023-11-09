
<?php

/*******************************
 * Version : 1.0.0.0
 * Revised : jeudi 19 avril 2018, 16:39:46 (UTC+0200)
 *******************************/

// if(isset($_SESSION[SHORTNAME.'_user'])) $me = $_SESSION[SHORTNAME.'_user'];
if(!isset($me)){
?>
<header class="container-fluid header" id="myHeader">
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top row">
	  <!-- Brand -->
	  <a class="logo navbar-brand col" href="/">
	  	<img class="rounded-circle" style="width:60px;" src="template/assets/img/logo sms.png" alt="SMSports">
	  </a>
	  <!-- Links -->
	  <ul class="navbar-nav col justify-content-center">
	  	<li class="nav-item">
	      <a class="nav-link " href="#">Actualités</a>
	    </li>
	    <li class="nav-item dropdown">
	      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
	        Nos Sports
	      </a>
	      <div class="dropdown-menu">
	        <a class="dropdown-item" href="#">Badminton</a>
	        <a class="dropdown-item" href="#">Tennis de table</a>
	        <a class="dropdown-item" href="#">Volley</a>
	      </div>
	    </li>
	    <li class="nav-item dropdown">
	      <a class="nav-link dropdown-toggle" href="#" id="navbardrop1" data-toggle="dropdown">
	        Participer
	      </a>
	      <div class="dropdown-menu">
	        <a class="dropdown-item" href="#">Adhérent Bénévole</a>
	        <a class="dropdown-item" href="#">Les membres du bureau</a>
	      </div>
	    </li>
	    <li class="nav-item dropdown">
	      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
	        Calendriers
	      </a>
	      <div class="dropdown-menu">
	        <a class="dropdown-item" href="#">Badminton</a>
	        <a class="dropdown-item" href="#">Tennis de table</a>
	        <a class="dropdown-item" href="#">Volley</a>
	      </div>
	    </li>
	    <li class="nav-item">
	      <a class="nav-link " href="#" id="navbardrop">Partenaires</a>
	    </li>
	   </ul>
	   <ul class="navbar-nav col justify-content-end">
			<span class="navbar-text">
	    		<a href="inscription">
	    			<button class="btn mr-3 btn-danger">S'inscrire</button>
	    		</a>
			</span>
			<span class="navbar-text">
	    		<a href="login">
	    			<button class="btn mr-3 btn-danger">Se connecter</button>
	    		</a>
			</span>
	   </ul>
	</nav>
</header>

<?
}
?>
