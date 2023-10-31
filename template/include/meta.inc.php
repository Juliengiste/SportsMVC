<?php
/*******************************
 * Version : 1.0.0.0
 * Revised : jeudi 19 avril 2018, 16:55:38 (UTC+0200)
 *******************************/
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<base href="<?php echo PROTOCOLE . "://" . URL . "/" ?>">
	<!-- API Carte Open-->
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin="" />

	<!-- googleAPI-->
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>

	<link href="template/assets/img/favicon.ico" type="image/x-icon" rel="icon">
	<link href="template/assets/img/favicon.ico" type="image/x-icon" rel="shortcut icon">
	
	<?php // Bootstrap core CSS ?>
	<link href="template/assets/lib/bootstrap-4.5.3/css/bootstrap.min.css" rel="stylesheet">
	
	<?php //  Custom styles for this template ?>
	<link href="template/assets/css/_common.css" rel="stylesheet">
	<link href="template/assets/css/ioscheckbox.css" rel="stylesheet">
	
	<?php //  font awesome ?>
	<link href="template/assets/lib/fontawesome-5.15.2/css/all.css" rel="stylesheet">
	
	<?php // inclusion automatique (pour toutes les pages sauf l'accueil...
	if (!isset($_GET["page"])) $_GET["page"] = "accueil";
	else {
		// ...du css et du js de la page courante,
		if (isset($_GET["detail"])) {
			if (is_file(DR . "template/assets/css/" . $_GET["detail"] . ".css")) { ?>
				<link href="template/assets/css/<?php echo $_GET["detail"] ?>.css" rel="stylesheet"><?php
			}
			if (is_file(DR . "template/assets/js/" . $_GET["detail"] . ".js")) { ?>
				<script src="template/assets/js/<?php echo $_GET["detail"] ?>.js" defer></script><?php
			}
			elseif (is_file(DR . "template/assets/js/" . $_GET["page"]."_".$_GET["sspage"] . ".js")) { ?>
				<script src="template/assets/js/<?php echo $_GET["page"]."_".$_GET["sspage"] ?>.js" defer></script><?php
			}
		}
		elseif (isset($_GET["sspage"])) {
			if (is_file(DR . "template/assets/css/" . $_GET["sspage"] . ".css")) { ?>
				<link href="template/assets/css/<?php echo $_GET["sspage"] ?>.css" rel="stylesheet"><?php
			}
			if (is_file(DR . "template/assets/js/" . $_GET["sspage"] . ".js")) { ?>
				<script src="template/assets/js/<?php echo $_GET["sspage"] ?>.js" defer></script><?php
			}
		}
		else {
			if (is_file(DR . "template/assets/css/" . $_GET["page"] . ".css")) { ?>
				<link href="template/assets/css/<?php echo $_GET["page"] ?>.css" rel="stylesheet"><?php
			}
			if (is_file(DR . "template/assets/js/" . $_GET["page"] . ".js")) { ?>
				<script src="template/assets/js/<?php echo $_GET["page"] ?>.js" defer></script><?php
			}
		}
	}
	
	// Titre, description, keywords
	if (isset($_GET["detail"])) $ret = $_GET["detail"];
	elseif (isset($_GET["sspage"])) $ret = $_GET["sspage"];
	elseif (isset($_GET["page"])) $ret = $_GET["page"];
	$npage=(isset($_GET["sspage"])?"META_TITR_".strtoupper($_GET["page"].'-'.$_GET["sspage"]):"META_TITR_".strtoupper($_GET["page"]));

	if (isset($ret) && array_key_exists($npage, $lang)) { ?>
		<title><?php echo $lang[$npage]?></title>
		<meta name="description" content="<?php echo $lang["META_DESC_".strtoupper($_GET["sspage"]?$_GET["page"].'-'.$_GET["sspage"]:$_GET["page"])]?>">
	 	<?/*<meta name="keywords" lang="<?=$_SESSION[SHORTNAME."lg_app"];?>" content="<?=$lang["META_KEYW_".strtoupper($get["sspage"]?$get["page"].'-'.$get["sspage"]:$get["page"])]?>">*/?>
		<meta name="author" content="<?php echo NAME ?>">
		<meta name="robots" content="noindex, nofollow">
	<?php
	}
	// ...et les spécificités à chaque page
	if (isset($_GET["page"]) && ($_GET["page"] == "contact" || $_GET['page'] == "info" || $_GET['page'] == "cours")) {
		// Component Chosen : pour avoir de jolis select avec saisi
		?>
		<link href="template/assets/css/component-chosen.min.css" rel="stylesheet">
		<script src="template/assets/js/chosen.jquery.min.js" defer></script>
	<?php } ?>
</head>

<body>