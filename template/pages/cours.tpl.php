 <style type="text/css">
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap");

*, ::after, ::before {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
  font-size: 62.5%;
}

a {
  text-decoration: none;
}

ul {
  list-style-type: none;
}

img {
  margin: 0;
  padding: 0;
}

body {
  font-family: 'Poppins', sans-serif;
  width: 100vw;
  height: 100vh;
  background-color: #ffb703;
  background-image: linear-gradient(to right, rgba(255, 81, 47, 0.7) 0%, rgba(221, 36, 118, 0.9) 51%, rgba(255, 81, 47, 0.7) 100%);
  font-size: 1.6rem;
  display: flex;
  justify-content: center;
  align-items: center;
}

h3 {
  text-align: center;
  color: #333;
  text-transform: uppercase;
  font-size: 2rem;
  margin: 1rem 0;
}

p {
  text-align: center;
}

.container {
  position: relative;
  width: 35rem;
  height: 60rem;
  background-color: #fff;
  border-radius: 1rem;
  overflow: hidden;
  background: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  margin-top: 25%;
}

.container form .sport {
  width: 100%;
  padding: 1rem .5rem;
  margin: .5rem 0;
  border: 0;
  border-bottom: 1px solid #777;
  outline: none;
  background: transparent;
}

.container form {
  width: 28rem;
  position: absolute;
  font-size: 1.6rem;
  top: 10rem;
  left: 4rem;
  transition: all 0.5s ease-in-out;
}

.container form input {
  width: 100%;
  padding: 1rem .5rem;
  margin: .5rem 0;
  border: 0;
  border-bottom: 1px solid #777;
  outline: none;
  background: transparent;
}

.container form input::placeholder {
  font-size: 1.6rem;
  color: #555;
}

.container form .btn-box {
  width: 100%;
  margin: 3rem auto;
  text-align: center;
}

.container form .bouton {
  width: 11rem;
  height: 3.5rem;
  margin: 0 1rem;
  font-size: 1.6rem;
  background-image: linear-gradient(to right, #FF512F 0%, #DD2476 51%, #FF512F 100%);
  font-family: inherit;
  border: 0;
  border-radius: 2rem;
  outline: none;
 /* cursor: pointer;*/
  color: #fff;
  transition: 0.5s;
  background-size: 200% auto;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
}


.container form .sport:hover {
  /*background-position: right center;
   change the direction of the change here */
  color: #fb2703;
  text-decoration: none;
}

.container form .bouton:hover {
  background-position: right center;
  /* change the direction of the change here */
  color: #fff;
  text-decoration: none;
}

#form-1 {
  height: 4rem;
}

#form-2 {
  left: 45rem;
}

#form-3 {
  left: 45rem;
}

#form-4 {
  left: 45rem;
}

.step-row {
  width: 35rem;
  height: 4rem;
  margin: 0 auto;
  display: flex;
  align-items: center;
  box-shadow: 0 -1px 5px -1px #000;
  position: relative;
  left: -1.5rem;

}

#progress {
    position: absolute;
    height: 100%;
    width: 7.5rem;
    background-image: linear-gradient(to right, #FF512F 0%, #DD2476 51%, #FF512F 100%);
    transition: all 0.8s ease-in-out;
    
}

.step-col {
    width: 33.3%;
    text-align: center;
    color: #333;
    position: relative;
}

#progress::after {
    position: absolute;
    content: '';
    height: 0;
    width: 0;
    border-top: 2rem solid transparent;
    border-bottom: 2rem solid transparent;
    border-left: 2rem solid #FF512F;
    top: 0;
    right: -2rem;
}

.child-div{
    position: relative;
    margin-left: -30px;
    margin-right: -30px;
}
</style>
<?
$id = Core\Classes\Utils::secureGet('id');
$new = Core\Classes\Utils::secureGet('new');

if(isset($_SESSION[SHORTNAME.'_user'])) $me = $_SESSION[SHORTNAME.'_user'];
setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);

$smanager = new Core\Models\SportManager($pdo);
$listsport = $smanager->getList('nom_sport', 'asc', 'sport');

if((count($_POST) != 0 )&&($_POST["form_id"]=="NULL")){
// Formulaire rempli et envoyé au serveur
  var_dump($_POST);
}
if(isset($id)&&(!isset($new))){
// Affichage quand un cours est selectionné 
}
//elseif(!isset($id)&&(!isset($new))){
// Affichage quand aucun cours n'est selectionné (liste des cours)
//}
else{
// Affichage du formulaire pour la création d'un nouveau cours
?>

<div class="container">
  <form method="POST" action="" id="form-1">
      <h3>SPORTS</h3>
      <?
      foreach ($listsport as $sport) {
        echo('<button type="button" class="sport" value="'.$sport->idsport().'" onclick=form1toform2(this)>'.ucwords($sport->nom_sport()).'</button>');
      }
      ?>
  </form>
  <form method="POST" action="" id="form-2">
      <h3>Réservation</h3>
      <button type="button" class="sport" value="unit" onclick=form2toform3(this)>Unitaire</button>
      <button type="button" class="sport" value="multi" onclick=form2toform3(this)>Multiple</button>

      <div class="btn-box">
          <button type="button" class="bouton" onclick=form2toform1()>Back</button>
      </div>
  </form>

  <form method="POST" action="" id="form-3">
    <div class="child-div" id="creneau"></div>
    <br><br>
      <h3>Sélection du créneau</h3>
      <div id="date"><!--Remplissage de la div via JS--></div>
      <div id="heure">
        <label>Heure du cours</label>
        <input type="time" name="heure_debut" id="heure_debut">
        <div class="form-row">
          <label class="col-md-2">Durée</label>
          <input class="col-md-8" type="range" name="duree" id="duree" min="0" max="180" step="30" value="60" onchange="updateTextInput(this.value);">
          <input class="col-md-2" type="text" id="textInput" value="60" style="border-bottom: none;">
        </div>
      </div>

      <div class="btn-box">
          <button type="button" class="bouton" onclick=form3toform2()>Back</button>
          <button type="button" class="bouton" onclick=form3toform4()>Next</button>
      </div>
  </form>

  <form method="POST" action="" id="form-4">
      <h3>On récapitule!</h3>
      <div id="resume"></div>
      <h3>Indiquez le nombre de participants maximum</h3>
      <input type="hidden" id="form_id" name="form_id" value=NULL>
      <input type="hidden" id="form_sport" name="form_sport">
      <input type="hidden" id="form_reservation" name="form_reservation">
      <div id="form_div_date">
      </div>
      <input type="hidden" id="form_heure_debut" name="form_heure_debut">
      <input type="hidden" id="form_duree" name="form_duree">
      <input type="number" id="form_nbplace" name="form_nbplace" placeholder="Entrez un nombre" required>

      <div class="btn-box">
          <button type="button" class="bouton" onclick=form4toform3()>Back</button>
          <button type="Submit" class="bouton">Submit</button>
      </div>
  </form>

  <div class="step-row">
      <div id="progress"></div>
      <div class="step-col">Step 1</div>
      <div class="step-col">Step 2</div>
      <div class="step-col">Step 3</div>
      <div class="step-col">Step 4</div>
  </div>
</div>
<?
}
?>

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

<script type="text/javascript">
console.log('hey console');

$(document).ready(function() {
  $('button.sport').on('click', function() {
    
    var form1 = $('#form-1');
    var form2 = $('#form-2');
    var form3 = $('#form-3');
    var form4 = $('#form-4');

    var progress = $('#progress');

    function getlistdispo(sport){
      switch (sport){
        <?
        $o=$pdo->prepare('SELECT * FROM `sport`;');
        $o->execute();
        while ($donnees = $o->fetch(PDO::FETCH_ASSOC)) {
          ?>
          case ('<?=$donnees['idsport'];?>'):
            <?
            $affichage='';
            $p=$pdo->prepare('SELECT * FROM `anneescolaire` WHERE `date_debut`< NOW() AND `date_fin`> NOW();');
            $p->execute();
            $data = $p->fetch(PDO::FETCH_ASSOC);
            $annee = $data['idanneescolaire'];
            $q=$pdo->prepare('SELECT * FROM `disponibilite` JOIN `autorise` ON `disponibilite`.`iddisponibilite`=`autorise`.`disponibilite_iddisponibilite` JOIN `lieu` ON `disponibilite`.`lieu` = `lieu`.`idlieu` WHERE `annee_scolaire`=:annee AND `sport_idsport`=:idsport AND `duree` IS NOT NULL;');
            $q->bindValue(":annee", $annee, PDO::PARAM_INT);
            $q->bindValue(":idsport", $donnees['idsport'], PDO::PARAM_INT);
            $q->execute();
            while ($dataq = $q->fetch(PDO::FETCH_ASSOC)) {
            $minute = $dataq['duree'];
            $affichage .='<div>Le '.ucwords($dataq['jour_semaine']).' de '.date("H:i",strtotime($dataq['heure_debut'])).' à '.date("H:i",strtotime($dataq['heure_debut']."+$minute minutes")).' au '.$dataq['nom_lieu'].'</div>';
            }
            ?>
            $('#creneau').html('<?=$affichage?>');
            <?
            ?>
          break;
        <?
        }
        ?>
      }
    }

    function affichageformdate(reservation){
      var formdate = $('#date');
      var div_date = $('#form_div_date');
      var ladate=new Date()
      switch (reservation){
        case ('unit'):
          formdate.html('<input type="date" name="date_cours" id="date_cours"></input>');
          div_date.html('<input type="hidden" name="form_date_cours" id="form_date_cours"></input>');
          var today = ladate.getFullYear()+"-"+("0"+(ladate.getMonth()+1)).slice(-2)+"-"+("0"+ladate.getDate()).slice(-2);
          $('#date_cours').val(today);
        break;
        case('multi'):
          formdate.html('<input type="date" name="date_debut" id="date_debut"></input><input type="date" name="date_fin" id="date_fin"></input><select class="form-control" id="js" name="js"><option disabled selected>Choisissez le jour</option><option value="lundi">Lundi</option><option value="mardi">Mardi</option><option value="mercredi">Mercredi</option><option value="jeudi">Jeudi</option><option value="vendredi">Vendredi</option><option value="samedi">Samedi</option><option value="dimanche">Dimanche</option></select>');
          div_date.html('<input type="hidden" name="form_date_debut" id="form_date_debut"></input><input type="hidden" name="form_date_fin" id="form_date_fin"></input><input type="hidden" name="form_jour_semaine" id="form_jour_semaine"></input>');
          var today = ladate.getFullYear()+"-"+("0"+(ladate.getMonth()+1)).slice(-2)+"-"+("0"+ladate.getDate()).slice(-2);
          $('#date_debut').val(today);
        break;
      }
    }

    function affichedate(date){
      return ("0"+date.getDate()).slice(-2)+"/"+("0"+(date.getMonth()+1)).slice(-2)+"/"+date.getFullYear();
    }

    function resume(){
      switch($('#form_sport').val()){
        <?
        foreach ($listsport as $sport) {
          ?>
          case('<?=$sport->idsport();?>'):
            var nomsport = "<?=$sport->nom_sport();?>";
          break;
        <?
        }
        ?>
      }

      var div = $('#resume');
      if($('#form_reservation').val()=="multi"){
        var datedeb = new Date($('#form_date_debut').val());
        var datefin = new Date($('#form_date_fin').val());
        alert(datedeb);
        var text = "<p>Du "+affichedate(datedeb)+" au "+affichedate(datefin)+", le "+$('#form_jour_semaine').val()+" cours de "+nomsport+" à "+$('#form_heure_debut').val()+" d'une durée de "+$('#form_duree').val()+" minutes</p>";
      }
      else{
        var datecours = new Date($('#form_date_cours').val());
        var text = "<p>Le "+affichedate(datecours)+" cours de "+nomsport+" à "+$('#form_heure_debut').val()+" d'une durée de "+$('#form_duree').val()+" minutes</p>";
      }
      div.html(text);
    }

    function form1toform2(sport){
      form1.css("left" ,  '-45rem');
      form2.css("left" , '4rem');
      progress.css("width" , '16.5rem');
      // récupérer la valeur de sport
      $('#form_sport').val(sport.value);
    }


    function form2toform1() {
        form1.css('left', '4rem');
        form2.css('left','45rem');
        progress.css('width', '7.5rem');
    }

    function form2toform3(reservation) {
        form2.css('left', '-45rem');
        form3.css('left', '4rem');
        progress.css('width', '25rem')
        // récupérer la valeur de reservation
        $('#form_reservation').val(reservation.value);
        getlistdispo($('#form_sport').val());
        affichageformdate($('#form_reservation').val());
    }

    function form3toform2() {
        form2.css('left', '4rem');
        form3.css('left', '45rem');
        progress.css('width', '16.5rem')

    }

    function form3toform4() {
        form3.css('left', '-45rem');
        form4.css('left', '4rem');
        progress.css('width', '36rem');
        if($('#form_reservation').val()=="multi"){
          $('#form_date_debut').val($('#date_debut').val());
          $('#form_date_fin').val($('#date_fin').val());
          $('#form_jour_semaine').val($('#js').val());
        }else{
          $('#form_date_cours').val($('#date_cours').val());
        }
        $('#form_heure_debut').val($('#heure_debut').val());
        $('#form_duree').val($('#duree').val());
        resume();
    }

    function form4toform3() {
        form3.css('left', '4rem');
        form4.css('left', '45rem');
        progress.css('width', '25rem')

    }

    function updateTextInput(val) {
      document.getElementById('textInput').value=val; 
    }

    // it's not fair to say that i completely made this codepen from myself, i learned  this form  tube tutorial video.
    // Linking down the channel name
     // https://youtube.com/c/EasyTutorialsVideo

     });
});
</script>