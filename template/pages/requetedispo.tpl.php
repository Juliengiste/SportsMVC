<?
use \Core\Database\myPDO;
$pdo=\Core\Database\myPDO::getInstance();


$idsport=$_POST['idsport'];
$p=$pdo->prepare('SELECT * FROM `anneescolaire` WHERE `date_debut`< NOW() AND `date_fin`> NOW();');
$p->execute();
$donnees = $p->fetch(PDO::FETCH_ASSOC);
$annee = $donnees['idannee_scolaire'];
$q=$pdo->prepare('SELECT * FROM `disponibilite` JOIN `autorise` ON `disponibilite`.`iddisponibilite`=`autorise`.`disponibilite_iddisponibilite` WHERE `annee_scolaire`=:annee AND `sport_idsport`=:idsport;');
$q->bindValue(":annee", $annee, PDO::PARAM_INT);
$q->bindValue(":idsport", $idsport, PDO::PARAM_INT);
$q->execute();
?>