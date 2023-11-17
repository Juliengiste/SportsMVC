<?php
/*******************************
Version : 1.0.0.0
Revised : jeudi 19 avril 2018, 16:49:24 (UTC+0200)
*******************************/
if(isset($_SESSION[SHORTNAME.'_user'])) $me = $_SESSION[SHORTNAME.'_user'];

$sort = \Core\Classes\Utils::secureGet('sort',"sport");
$tri = \Core\Classes\Utils::secureGet('tri',"asc");
$invtri = ($tri=="asc")?"desc":"asc";
$cmanager = new Core\Models\CoursManager($pdo);
$ascomanager = new Core\Models\VacancesManager($pdo);
$anneescolist = "anneescolaire";
$cours = "cours";
$cours = $cmanager->getList($sort="sport", $tri="asc", $cours);
$anneescolist = $ascomanager->getList($anneesco="date_debut", $tri="asc", $anneescolist);



/*******************************
Code pour ajouter des cours sur un an
*******************************/
 // var_dump($_POST);
// Ajouter les cours
if ((count($_POST) != 0)) {
    // $newsport = $smanager->new("sport");
    // $newsport->setNom_sport($_POST['nom_sport']);
    // $newsport->setDescription($_POST['description']);
    var_dump($_POST);
    $dateDebutAnnee = $_POST['datedebut'];
    $dateFinAnnee = $_POST['datefin'];

    echo("<br>".$dateDebutAnnee);
    // Récupérer les lieux sélectionnés
    // $lieuxSelectionnes = isset($_POST['lieux']) ? $_POST['lieux'] : [];
	
    // // Utilisation de la méthode modifiée pour ajouter le sport avec les lieux associés
    // $smanager->addSport($newsport, $lieuxSelectionnes);
    // Redirection vers la page sport
    // header("Location: /sports");
    exit();
}



//var_dump($_SESSION);

var_dump($anneescolist);
foreach ($cours as $cour) {
    //$key = "sport";
    echo "<br>";
    echo("id> ". $cour->idcours());
    echo "<--->";
    echo("sport> ".$cour->sport());
    echo "<br>";
    echo("nbplaces> ".$cour->nbplace());
    echo "<br>";
    
}

foreach ($anneescolist as $annesco) {
    //$key = "sport";
    echo "<br>";
    echo("début >". $annesco->date_debut());
    echo "---";
    echo("fin >".$annesco->date_fin());
    echo "<br>";
}

// $dateDebutAnnee = 
// $dateFinAnnee =
?>

<section class="container">
    <div class="container">
        <form action="<?php  ?>" method="post">
                            <div class="col-md-12 mb-3">
                                <label for="year">Année concernée</label>
                                <!-- Récupérer les années depuis la base de données -->
                                <?php
                                // Afficher chaque année comme une case à cocher

                                foreach ($anneescolist as $annesco) {
                                    echo '<div class="form-check">';
                                    echo '<input class="form-check-input" type="radio" value="' . $annesco->idanneescolaire() . '" id="annesco_' . $annesco->idanneescolaire() . '" name="idanneescolaire" >';
                                    echo '<input class="form-check-input" type="hidden" value="' . $annesco->date_debut() . '" id="datedebut' . '" name="datedebut" >';
                                    echo '<input class="form-check-input" type="hidden" value="' . $annesco->date_fin() . '" id="datefin' . '" name="datefin" >';
                                    echo '<label class="form-check-label" for="anneescolaire_' . $annesco->label() . '">' . $annesco->label() . '</label>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                            <div class="form-group">
                            
                            </div>
                            <button type="submit" class="btn btn-primary">Envoyer</button>
                        </form>                         
        
    </div>