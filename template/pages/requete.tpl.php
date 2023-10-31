<?
use \Core\Database\myPDO;
$pdo=\Core\Database\myPDO::getInstance();


$idpersonne=$_POST['idpersonne'];
$idrole=$_POST['idrole'];
$q=$pdo->prepare('UPDATE `personne` SET `role`=:role WHERE `idpersonne`=:id;');
$q->bindValue(":role", $idrole, PDO::PARAM_INT);
$q->bindValue(":id", $idpersonne, PDO::PARAM_INT);
$q->execute();
?>