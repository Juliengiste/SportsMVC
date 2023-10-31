<?php
use Core\Models\Liaison;
use Core\Classes\Utils;

$formation_l = new Liaison('formation', $formation->F_ID, $pdo);
//le nombre de pages est déterminé par le nombre d'actions
$actions = $AManager->getActionsFormation(array("AFormation_ID" => $formation->F_ID));

$objectifgeneral = $formation_l->getResult('formation__formacode', $formation->FObjectifGeneral_ID);

if ($objectifgeneral['FCCode'] != 97006) {
	//si ce n'est pas une certification
	//on récupère la sanction
	$sanction = $formation_l->getResult('formation__sanction', $formation->FSanction_ID);//= $reconnaissance v1
	
	//intitule forcémetn null
	$formation->FCertifIntitule_ID = null;
}
else {
	$sanction = false;
	//certification et intitule correspondant
	if (!is_null($formation->FCertifIntitule_ID) && $formation->FCertifIntitule_ID > 0) {
		$fullCertif = $formation_l->getFullCertif($formation->FCertifIntitule_ID);
	}
}
/*
* Génération des variables liées à la formation avant le foreach
*/

$structure = $STManager->get($formation->FSTAntenne_ID);
//var_dump($formation->toArray());
switch ($structure->RA_ID) {
	case 8:
		$image_fond = DR . "template/assets/img/pdf/PDF_TPC_Fond_GRETA_dijon_G71.jpg";
		break;
	case 93:
		$image_fond = DR . "template/assets/img/pdf/PDF_TPC_Fond_GRETA_dijon_G89.jpg";
		break;
	case 111:
		$image_fond = DR . "template/assets/img/pdf/PDF_TPC_Fond_GRETA_dijon_G58.jpg";
		break;
	case 264:
		$image_fond = DR . "template/assets/img/pdf/PDF_TPC_Fond_GRETA_dijon_G21.jpg";
		break;
	case 310:
		$image_fond = DR . "template/assets/img/pdf/PDF_TPC_Fond_GIP_dijon.jpg";
		break;
}

if ($structure->RA_ID == 310) {
	$eligibilite_cpf = DR . 'template/assets/img/pdf/logo_eligibilite_CPF_GIP.jpg';
	$fleche = DR . 'template/assets/img/pdf/PDF_TPC_Fleche_orange.jpg';
	$couleur_theme = array(243, 147, 20);
	$bleuFonce = array(38, 71, 150); //bleu roi
}
else {
	$eligibilite_cpf = DR . 'template/assets/img/pdf/logo_eligibilite_CPF_GRETA.jpg';
	$fleche = DR . 'template/assets/img/pdf/PDF_TPC_Fleche_verte.jpg';
	$couleur_theme = array(177, 199, 0);
	$bleuFonce = array(38,107,134); //bleu canard
}

if ($actions !== false) :
	
	foreach ($actions as $k => $action) :
		$action->toIso88591();
		$action->liaison = new Liaison('action', $action->A_ID, $pdo);
		
		$pdf->AddPage();
		//        $pdf->SetAutoPageBreak(0);
		$pdf->SetMargins(7, 0);
		
		$pdf->Image($image_fond, 0, 0, 210, 'JPG');
		if ($formation->FCPF == 'V') $pdf->Image($eligibilite_cpf, 185, 3, 20, 14, 'JPG');
		
		$pdf->SetFont('Arial', 'B', 14);
		$pdf->SetTextColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
		
		$pdf->SetY(19);
		$pdf->SetX($pdf->xFormation);
		
		$pdf->Multicell(130, 6, $formation->FIntitule, 0, "L", 0);
		$pdf->Ln(3);
		//$pdf->SetTextColor($MauveFonce1,$MauveFonce2,$MauveFonce3);
		
		$pdf->SetTextColor($pdf->grisFonce[0], $pdf->grisFonce[1], $pdf->grisFonce[2]);
		if ($formation->FIntituleComment != "") {
			$pdf->SetFont('Arial', '', 11);
			$pdf->SetX($pdf->xFormation);
			$pdf->Multicell(130, 4, trim($formation->FIntituleComment), 0, "L");
		}
		
		//Eligible VAE
		if (isset($fullCertif['CIVAE']) && $fullCertif['CIVAE'] == "V") {
			$pdf->SetFont('Arial', 'I', 8);
			$pdf->Ln(3);
			$pdf->SetX($pdf->xFormation);
			$pdf->MultiCell($pdf->largeurColG, 3, 'Certification accessible par la VAE', 0, 'L', 0);
			$pdf->SetTextColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
		}
		//recalage cursuer pdf
		//création action
		$pdf->Ln(1);
		$pdf->SetY($pdf->yAction);
		$pdf->SetX($pdf->margeG);
		
		$pdf->SetFillColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
		$pdf->SetTextColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
		$pdf->SetDrawColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
		
		if($action->ASTLieu_ID!=null) $structure_action = $STManager->get($action->ASTLieu_ID);
		else $structure_action = false;
		$enteteAction = '';
		if ($structure_action !== false) :
			$enteteAction .= utf8_decode($structure_action->STVille) . " ";
		endif;
		$enteteAction .= ($action->ACarif_ID != "" ? $action->ACarif_ID : '');
		if ($action->AIntitule != "") $enteteAction .= "\n" . $action->AIntitule;
		
		if ($enteteAction != "") {
			$pdf->SetFont('Arial', 'B', 9);
			$pdf->SetTextColor(255, 255, 255);
			$pdf->MultiCell($pdf->largeurColG, $pdf->hauteurTitreAction, $enteteAction, 0, 'C', true);
		}
		
		//Publics
		$publics = $action->liaison->getIDsFromLiaison('action__public_l', array('LPU_ID'));
		$publics = Utils::array_unique_r($publics, "LPU_ID"); //array_unique temporaire, prochain import pas de doublons normalement
		
		$public_pdf = "";
		$public_height = 0;
		foreach ($publics as $public) {
			$public = $action->liaison->getResult('action__public', $public['LPU_ID']);
			$public_pdf .= utf8_decode(ucfirst($public["PUNomAcc"])) . "\n";
		}
		if ($action->APublicComment != "") $public_pdf .= $action->APublicComment;
		
		//$public_height = $pdf->calcHauteurCell($public_pdf);
		$y = $pdf->getY() + $pdf->hauteurTitreAction;
		$pdf->setY($y);
		
		if ($public_pdf != "") {
			$pdf->SetFont('Arial', 'B', 9);
			$pdf->SetTextColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Image($fleche, $pdf->margeG, $y + 0.5, 2, 'JPG');
			$pdf->MultiCell($pdf->largeurColG, $pdf->hauteurTitreAction, '  Public(s) (H/F)', 0, 'L', 0);
			$pdf->SetFont('Arial', '', 8);
			$pdf->SetTextColor($pdf->grisFonce[0], $pdf->grisFonce[1], $pdf->grisFonce[2]);
			$pdf->SetDrawColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Line($pdf->margeG, $y + $pdf->hauteurTitreAction, $pdf->margeG + $pdf->largeurColG, $y + $pdf->hauteurTitreAction);
			
			$y = $pdf->getY() + $pdf->margeSousTitre;
			$pdf->setY($y);
			$pdf->MultiCell($pdf->largeurColG, $pdf->hauteurBaseLigne, $public_pdf, 0, 'L');
			
			$y = $pdf->getY() + $pdf->hauteurMarge;
			$pdf->setY($y);
		}
		
		//Dates
		$sessions = $SManager->getSessionsAction(array("SAction_ID" => $action->A_ID));
		
		$session_pdf = "";
		if ($sessions !== false) :
			$session_l = [];
			$cptr_session = 1;
			$nb_session = count($sessions);
			foreach ($sessions as $k => $session) :
				$session->liaison = new Liaison('session', $session->S_ID, $pdo);
				
				if ($session->SDateDeb != "" && $session->SDateFin != "") {
					
					if ($nb_session > 1) $session_pdf .= "Session " . $cptr_session . "\n";
					$session_pdf .= "Du " . Utils::formatDate($session->SDateDeb) . " au " . Utils::formatDate($session->SDateFin) . "\n";
				}
				if ($session->SDateComment != "") $session_pdf .= $session->SDateComment . "\n";
				
				$cptr_session++;
			
			endforeach; //sessions
		endif; //session !== false
		
		$session_pdf .= ES_STATUT[$action->AEntreeSortie];
		//$session_height = $pdf->calcHauteurCell($session_pdf);
		
		if ($session_pdf != "") {
			$pdf->SetFont('Arial', 'B', 9);
			$pdf->SetTextColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Image($fleche, $pdf->margeG, $y + 0.5, 2, 'JPG');
			$pdf->MultiCell($pdf->largeurColG, $pdf->hauteurTitreAction, '  Dates', 0, 'L', 0);
			$pdf->SetFont('Arial', '', 8);
			$pdf->SetTextColor($pdf->grisFonce[0], $pdf->grisFonce[1], $pdf->grisFonce[2]);
			$pdf->SetDrawColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Line($pdf->margeG, $y + $pdf->hauteurTitreAction, $pdf->margeG + $pdf->largeurColG, $y + $pdf->hauteurTitreAction);
			
			$y = $pdf->getY() + $pdf->margeSousTitre;
			$pdf->setY($y);
			$pdf->MultiCell($pdf->largeurColG, $pdf->hauteurBaseLigne, utf8_decode($session_pdf), 0, 'L');
			
			$y = $pdf->getY() + $pdf->hauteurMarge;
			$pdf->setY($y);
		}
		
		//Durées
		$duree_pdf = "";
		$duree_height = 0;
		//if ($action->ADureeCentre > 0)
		$duree_pdf .= utf8_decode('- Durée centre : ') . $action->ADureeCentre . ' h' . "\n";
		//if ($action->ADureeEntreprise > 0)
		$duree_pdf .= utf8_decode('- Durée entreprise : ') . $action->ADureeEntreprise . ' h' . "\n";
		//if ($action->ADureeCentre > 0 || $action->ADureeEntreprise > 0)
		$duree_pdf .= utf8_decode('- Durée totale : ') . ($action->ADureeCentre + $action->ADureeEntreprise) . ' h' . "\n";
		
		if ($action->ADureeComment != "")
			$duree_pdf .= trim($action->ADureeComment);
		
		//$duree_height = $pdf->calcHauteurCell($duree_pdf);
		
		if ($duree_pdf != "") {
			$pdf->SetFont('Arial', 'B', 9);
			$pdf->SetTextColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Image($fleche, $pdf->margeG, $y + 0.5, 2, 'JPG');
			$pdf->MultiCell($pdf->largeurColG, $pdf->hauteurTitreAction, utf8_decode('  Durée'), 0, 'L', 0);
			$pdf->SetFont('Arial', '', 8);
			$pdf->SetTextColor($pdf->grisFonce[0], $pdf->grisFonce[1], $pdf->grisFonce[2]);
			$pdf->SetDrawColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Line($pdf->margeG, $y + $pdf->hauteurTitreAction, $pdf->margeG + $pdf->largeurColG, $y + $pdf->hauteurTitreAction);
			
			$y = $pdf->getY() + $pdf->margeSousTitre;
			$pdf->setY($y);
			$pdf->MultiCell($pdf->largeurColG, $pdf->hauteurBaseLigne, $duree_pdf, 0, 'L');
			
			$y = $pdf->getY() + $pdf->hauteurMarge;
			$pdf->setY($y);
		}
		
		//Effectifs
		$effectif_pdf = ""; //$effectif_height = 0;
		if ($action->AEffectifMin > 0 || $action->AEffectifMax > 0) {
			if ($action->AEffectifMin > 0) $effectif_pdf .= '- Effectif minimum : ' . $action->AEffectifMin . "\n";
			if ($action->AEffectifMax > 0) $effectif_pdf .= '- Effectif maximum : ' . $action->AEffectifMax;
			$effectif_pdf .= "\n";
			//$effectif_height += $pdf->hauteurBaseLigne;
		}
		if ($action->AEffectifComment != "") {
			$effectif_pdf .= $action->AEffectifComment;
			//$effectif_height += (ceil(($pdf->GetStringWidth($action->AEffectifComment) / $pdf->largeurColG)) * $pdf->hauteurBaseLigne);
		}
		
		if ($effectif_pdf != "") {
			$pdf->SetFont('Arial', 'B', 9);
			$pdf->SetTextColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Image($fleche, $pdf->margeG, $y + 0.5, 2, 'JPG');
			$pdf->MultiCell($pdf->largeurColG, $pdf->hauteurTitreAction, utf8_decode('  Effectif'), 0, 'L', 0);
			$pdf->SetFont('Arial', '', 8);
			$pdf->SetTextColor($pdf->grisFonce[0], $pdf->grisFonce[1], $pdf->grisFonce[2]);
			$pdf->SetDrawColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Line($pdf->margeG, $y + $pdf->hauteurTitreAction, $pdf->margeG + $pdf->largeurColG, $y + $pdf->hauteurTitreAction);
			
			$y = $pdf->getY() + $pdf->margeSousTitre;
			$pdf->setY($y);
			$pdf->MultiCell($pdf->largeurColG, $pdf->hauteurBaseLigne, $effectif_pdf, 0, 'L');
			
			$y = $pdf->getY() + $pdf->hauteurMarge;
			$pdf->setY($y);
		}
		
		//modalité de formation = modalité d'enseignemnet
		$modEnseignement = $action->liaison->getResult('action__modaliteenseignement', $action->AModaliteEnseignement_ID);
		$modEns_pdf = "";
		$modEns_height = 0;
		if ($modEnseignement !== false) {
			$pdf->SetFont('Arial', 'B', 9);
			$pdf->SetTextColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Image($fleche, $pdf->margeG, $y + 0.5, 2, 'JPG');
			$pdf->MultiCell($pdf->largeurColG, $pdf->hauteurTitreAction, utf8_decode('  Modalité(s) d\'enseignement'), 0, 'L', 0);
			$pdf->SetFont('Arial', '', 8);
			$pdf->SetTextColor($pdf->grisFonce[0], $pdf->grisFonce[1], $pdf->grisFonce[2]);
			$pdf->SetDrawColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Line($pdf->margeG, $y + $pdf->hauteurTitreAction, $pdf->margeG + $pdf->largeurColG, $y + $pdf->hauteurTitreAction);
			
			$modEns_pdf = $modEnseignement['MEIntitule'];
			//$modEns_height = (ceil(($pdf->GetStringWidth($modEnseignement['MEIntitule']) / $pdf->largeurColG)) * $pdf->hauteurBaseLigne);
			
			$y = $pdf->getY() + $pdf->margeSousTitre;
			$pdf->setY($y);
			$pdf->MultiCell($pdf->largeurColG, $pdf->hauteurBaseLigne, utf8_decode($modEns_pdf), 0, 'L');
			
			$y = $pdf->getY() + $pdf->hauteurMarge;
			$pdf->setY($y);
		}
		
		//Tarifs // cout
		$tarifs = $action->liaison->getIDsFromLiaison('action__tarif_l');
		$tarif_pdf = "";
		if($action->APriseEnCharge==1) $tarif_pdf .= "Prise en charge possible en fonction de votre statut."."\n";
		if (count($tarifs) > 0) {
			foreach ($tarifs as $tarif) {
				$tarif_cat = $action->liaison->getResult('action__tarifcategorie', $tarif['LTarifcategorie_ID']);
				
				$tarif_pdf .= $tarif_cat['CTAIntitule'] . " : ";
				if ($tarif['LTarifHoraireTTC'] > 0) $tarif_pdf .= 'Coût horaire : ' . $tarif['LTarifHoraireTTC'] . ' ' . EURO . ' / h - ';
				if ($tarif['LTarifTotalTTC'] > 0) $tarif_pdf .= 'Coût total : ' . $tarif['LTarifTotalTTC'] . ' ' . EURO;
			}
		}
		else $tarif_pdf .= "Consulter l'organisme de formation";
		if ($action->ATarifComment != "") $tarif_pdf .= "\n".$action->ATarifComment;
		
		$pdf->SetFont('Arial', 'B', 9);
		$pdf->SetTextColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
		$pdf->Image($fleche, $pdf->margeG, $y + 0.5, 2, 'JPG');
		$pdf->MultiCell($pdf->largeurColG, $pdf->hauteurTitreAction, utf8_decode('  Coût de la formation'), 0, 'L', 0);
		$pdf->SetFont('Arial', '', 8);
		$pdf->SetTextColor($pdf->grisFonce[0], $pdf->grisFonce[1], $pdf->grisFonce[2]);
		$pdf->SetDrawColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
		$pdf->Line($pdf->margeG, $y + $pdf->hauteurTitreAction, $pdf->margeG + $pdf->largeurColG, $y + $pdf->hauteurTitreAction);
		
		$y = $pdf->getY() + $pdf->margeSousTitre;
		$pdf->setY($y);
		$pdf->MultiCell($pdf->largeurColG, $pdf->hauteurBaseLigne, utf8_decode($tarif_pdf), 0, 'L');
		
		//$tarif_height = $pdf->calcHauteurCell($tarif_pdf);
		$y = $pdf->getY() + $pdf->hauteurMarge;
		$pdf->setY($y);
		
		//lieu de la formation
		//structure déclaré en entete colonne gauche
		if ($structure_action !== false) {
			//récupère le RA
			$pdf->SetFont('Arial', 'B', 9);
			$pdf->SetTextColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Image($fleche, $pdf->margeG, $y + 0.5, 2, 'JPG');
			$pdf->MultiCell($pdf->largeurColG, $pdf->hauteurTitreAction, utf8_decode('  Lieu de la formation'), 0, 'L', 0);
			$pdf->SetFont('Arial', '', 8);
			$pdf->SetTextColor($pdf->grisFonce[0], $pdf->grisFonce[1], $pdf->grisFonce[2]);
			$pdf->SetDrawColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Line($pdf->margeG, $y + $pdf->hauteurTitreAction, $pdf->margeG + $pdf->largeurColG, $y + $pdf->hauteurTitreAction);
			
			$lieu = $structure_action->RANom . "\n" . $structure_action->STNom . "\n" . $structure_action->STAdresse . ' ' . $structure_action->STCP . ' ' . $structure_action->STVille . "\n";
			if ($action->ALieuComment != "") $lieu .= $action->ALieuComment;
			
			$y = $pdf->getY() + $pdf->margeSousTitre;
			$pdf->setY($y);
			$pdf->MultiCell($pdf->largeurColG, $pdf->hauteurBaseLigne, utf8_decode($lieu), 0, 'L');
			
			//$lieu_height = $pdf->calcHauteurCell($lieu);
			$y = $pdf->getY() + $pdf->hauteurMarge;
			$pdf->setY($y);
		}
		
		//Contacts
		$contacts_ID = $action->liaison->getIDsFromLiaison('action__contact_l', array('LP_ID'));
		
		if (count($contacts_ID) == 0)
			$contacts_ID = $formation_l->getIDsFromLiaison('formation__personne_l', array('LP_ID'));
		
		$contacts_ID = Utils::array_unique_r($contacts_ID, "LP_ID"); //suppression des doublons a voir lors prochain import
		
		$contact_pdf = "";
		$cptr_contact = 1;
		if (count($contacts_ID) > 0) {
			$titre_contact = "Votre interlocuteur";
			foreach ($contacts_ID as $contact_ID) {
				$contact_detail = $formation_l->getResult('personne', $contact_ID['LP_ID']);
				
				if (is_array($contact_detail) && !empty($contact_detail)) {
					//var_dump($contact_detail);
					$contact_pdf .= $contact_detail["PPrenom"] . ' ' . $contact_detail["PNom"] . "\n";
					if ($contact_detail['PFonction'] != "") $contact_pdf .= $contact_detail["PFonction"] . "\n";
					if ($contact_detail['PTel1'] != "") $contact_pdf .= 'Tél. : ' . $contact_detail["PTel1"] . "\n";
					if ($contact_detail['PTel2'] != "" && $contact_detail['PTel2Bloque'] == "F") $contact_pdf .=  'Tél. : ' . $contact_detail["PTel2"] . "\n";
					if ($contact_detail['PMel1'] != "") $contact_pdf .= $contact_detail["PMel1"] . "\n";
					
					if (count($contacts_ID) > 1 && $cptr_contact != count($contacts_ID)) {
						$contact_pdf .= "\n";
						$titre_contact = "Vos interlocuteurs";
					}
					$cptr_contact++;
				}
			}
		}
		if ($contact_pdf !== "") {
			//récupère le RA
			$pdf->SetFont('Arial', 'B', 9);
			$pdf->SetTextColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Image($fleche, $pdf->margeG, $y + 0.5, 2, 'JPG');
			$pdf->MultiCell($pdf->largeurColG, $pdf->hauteurTitreAction, utf8_decode('  ' . $titre_contact), 0, 'L', 0);
			$pdf->SetFont('Arial', '', 8);
			$pdf->SetTextColor($pdf->grisFonce[0], $pdf->grisFonce[1], $pdf->grisFonce[2]);
			$pdf->SetDrawColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Line($pdf->margeG, $y + $pdf->hauteurTitreAction, $pdf->margeG + $pdf->largeurColG, $y + $pdf->hauteurTitreAction);
			
			$y = $pdf->getY() + $pdf->margeSousTitre;
			$pdf->setY($y);
			$pdf->MultiCell($pdf->largeurColG, $pdf->hauteurBaseLigne, utf8_decode($contact_pdf), 0, 'L');
			
			//$contact_height = $pdf->calcHauteurCell($contact_pdf);
			$y = $pdf->getY() + $pdf->hauteurMarge;
			$pdf->setY($y);
		}
		
		//Organisme responsable
		$organisme_pdf = "";
		
		if ($structure !== false) {
			$organisme_pdf .= $structure->RANom . "\n";
			$organisme_pdf .= $structure->RAAdresse . " " . $structure->RACP . " " . $structure->RAVille . "\n";
			$organisme_pdf .= "Tél. : " . $structure->RATel . "\n";
			if ($structure->RAFax != "") $organisme_pdf .= "Fax : " . $structure->RAFax . "\n";
			if ($structure->RAMel != "") $organisme_pdf .= $structure->RAMel . "\n";
			$organisme_pdf .= "Siret : " . $structure->RASIRET . "\n";
			$organisme_pdf .= "N° d'activité : " . $structure->RANDE . "\n";
			$organisme_pdf .= $structure->RASite . "\n";
		}
		if ($organisme_pdf !== "") {
			//récupère le RA
			$pdf->SetFont('Arial', 'B', 9);
			$pdf->SetTextColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Image($fleche, $pdf->margeG, $y + 0.5, 2, 'JPG');
			$pdf->MultiCell($pdf->largeurColG, $pdf->hauteurTitreAction, utf8_decode('  Organisme responsable'), 0, 'L', 0);
			$pdf->SetFont('Arial', '', 8);
			$pdf->SetTextColor($pdf->grisFonce[0], $pdf->grisFonce[1], $pdf->grisFonce[2]);
			$pdf->SetDrawColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Line($pdf->margeG, $y + $pdf->hauteurTitreAction, $pdf->margeG + $pdf->largeurColG, $y + $pdf->hauteurTitreAction);
			
			$y = $pdf->getY() + $pdf->margeSousTitre;
			$pdf->setY($y);
			$pdf->MultiCell($pdf->largeurColG, $pdf->hauteurBaseLigne, utf8_decode($organisme_pdf), 0, 'L');
			
			//$organisme_height = $pdf->calcHauteurCell($organisme_pdf);
			$y = $pdf->getY() + $pdf->hauteurMarge;
			$pdf->setY($y);
		}
		
		//On passe sur la colonne de droite
		$y = $pdf->yFormation;
		$pdf->SetY($y);
		$pdf->SetX($pdf->xFormation);
		
		$obj_pdf = "";
		if (/*$objectifgeneral !== false || */
			$formation->FObjectif != "") :
			$pdf->SetFont('Arial', 'B', 10);
			$pdf->SetTextColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Image($fleche, $pdf->xFormation, $y + 1.5, 2, 'JPG');
			$pdf->MultiCell($pdf->largeurColD, $pdf->hauteurTitreFormation, utf8_decode('  OBJECTIF(S)'), 0, 'L', 0);
			$pdf->SetFont('Arial', '', 8);
			$pdf->SetTextColor($pdf->grisFonce[0], $pdf->grisFonce[1], $pdf->grisFonce[2]);
			$pdf->SetDrawColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Line($pdf->xFormation, $y + $pdf->hauteurTitreFormation, $pdf->xFormation + $pdf->largeurColD, $y + $pdf->hauteurTitreFormation);
			
			//$obj_pdf .= $objectifgeneral['FCNomMaj']."\n";
			if ($formation->FObjectif != '') $obj_pdf .= trim($formation->FObjectif);
			
			$y = $pdf->getY() + $pdf->margeSousTitreFormation;
			$pdf->setY($y);
			$pdf->SetX($pdf->xFormation);
			$pdf->MultiCell($pdf->largeurColD, $pdf->hauteurBaseLigne, $obj_pdf, 0, 'L');
			
			//$obj_height = $pdf->calcHauteurCell($obj_pdf, 'D');
			$y = $pdf->getY() + $pdf->hauteurMarge;
			$pdf->setY($y);
			$pdf->SetX($pdf->xFormation);
		endif; //objectifs
		
		//prerequis
		if ($action->APrerequisMaxi != "") {
			$pdf->SetFont('Arial', 'B', 10);
			$pdf->SetTextColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Image($fleche, $pdf->xFormation, $y + 1.5, 2, 'JPG');
			$pdf->MultiCell($pdf->largeurColD, $pdf->hauteurTitreFormation, utf8_decode('  PRÉREQUIS'), 0, 'L', 0);
			$pdf->SetFont('Arial', '', 8);
			$pdf->SetTextColor($pdf->grisFonce[0], $pdf->grisFonce[1], $pdf->grisFonce[2]);
			$pdf->SetDrawColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Line($pdf->xFormation, $y + $pdf->hauteurTitreFormation, $pdf->xFormation + $pdf->largeurColD, $y + $pdf->hauteurTitreFormation);
			
			$y = $pdf->getY() + $pdf->margeSousTitreFormation;
			$pdf->setY($y);
			$pdf->SetX($pdf->xFormation);
			$pdf->MultiCell($pdf->largeurColD, $pdf->hauteurBaseLigne, $action->APrerequisMaxi, 0, 'L');
			
			//$pre_height = $pdf->calcHauteurCell($action->APrerequisMaxi, 'D');
			$y = $pdf->getY() + $pdf->hauteurMarge;
			$pdf->setY($y);
			$pdf->SetX($pdf->xFormation);
		}
		
		//Contenu
		if ($formation->FContenu != "") {
			$pdf->SetFont('Arial', 'B', 10);
			$pdf->SetTextColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Image($fleche, $pdf->xFormation, $y + 1.5, 2, 'JPG');
			$pdf->MultiCell($pdf->largeurColD, $pdf->hauteurTitreFormation, utf8_decode('  CONTENU'), 0, 'L', 0);
			$pdf->SetFont('Arial', '', 8);
			$pdf->SetTextColor($pdf->grisFonce[0], $pdf->grisFonce[1], $pdf->grisFonce[2]);
			$pdf->SetDrawColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Line($pdf->xFormation, $y + $pdf->hauteurTitreFormation, $pdf->xFormation + $pdf->largeurColD, $y + $pdf->hauteurTitreFormation);
			
			$y = $pdf->getY() + $pdf->margeSousTitreFormation;
			$pdf->setY($y);
			$pdf->SetX($pdf->xFormation);
			$pdf->MultiCell($pdf->largeurColD, $pdf->hauteurBaseLigne, trim($formation->FContenu), 0, 'L');
			
			//$pre_height = $pdf->calcHauteurCell($formation->FContenu, 'D');
			$y = $pdf->getY() + $pdf->hauteurMarge;
			$pdf->setY($y);
			$pdf->SetX($pdf->xFormation);
		}
		
		//Modalités pédagogiques
		$modPeda_IDS = $action->liaison->getIDsFromLiaison('action__modalitepedagogique_l');
		
		$modPeg_pdf = "";
		if (count($modPeda_IDS) > 0) {
			
			foreach ($modPeda_IDS as $modPeda) {
				$modPeda = $action->liaison->getResult('action__modalitepedagogique', $modPeda['LMP_ID']);
				$modPeg_pdf .= utf8_decode($modPeda['MPIntitule'] . ', ');
			}
		}
		$modPeg_pdf = substr($modPeg_pdf, 0, -2);
		if ($action->AModalitePedagogiqueComment != "") $modPeg_pdf .= "\n" . $action->AModalitePedagogiqueComment;
		
		if ($modPeg_pdf != "") {
			$pdf->SetFont('Arial', 'B', 10);
			$pdf->SetTextColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Image($fleche, $pdf->xFormation, $y + 1.5, 2, 'JPG');
			$pdf->MultiCell($pdf->largeurColD, $pdf->hauteurTitreFormation, utf8_decode('  MOYEN(S) ET MODALITE(S) PÉDAGOGIQUE(S)'), 0, 'L', 0);
			$pdf->SetFont('Arial', '', 8);
			$pdf->SetTextColor($pdf->grisFonce[0], $pdf->grisFonce[1], $pdf->grisFonce[2]);
			$pdf->SetDrawColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Line($pdf->xFormation, $y + $pdf->hauteurTitreFormation, $pdf->xFormation + $pdf->largeurColD, $y + $pdf->hauteurTitreFormation);
			
			$y = $pdf->getY() + $pdf->margeSousTitreFormation;
			$pdf->setY($y);
			$pdf->SetX($pdf->xFormation);
			$pdf->MultiCell($pdf->largeurColD, $pdf->hauteurBaseLigne, trim($modPeg_pdf), 0, 'L');
			
			//$mod_height = $pdf->calcHauteurCell($modPeg_pdf, 'D');
			$y = $pdf->getY() + $pdf->hauteurMarge;
			$pdf->setY($y);
			$pdf->SetX($pdf->xFormation);
		}
		
		//Modalités d'admission
		$modAdm_pdf = "";
		$admission_IDS = $action->liaison->getIDsFromLiaison('action__admission_l');
		if (count($admission_IDS) > 0) {
			
			foreach ($admission_IDS as $admission) {
				$admission = $action->liaison->getResult('action__admission', $admission['LAD_ID']);
				$modAdm_pdf .= ucfirst($admission['ADIntitule']) . "\n";
			}
		}
		
		$modAdm_pdf = utf8_decode($modAdm_pdf);
		if ($action->AAdmissionComment != "") $modAdm_pdf .= "\n" . $action->AAdmissionComment;
		if ($modAdm_pdf != "") {
			$pdf->SetFont('Arial', 'B', 10);
			$pdf->SetTextColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Image($fleche, $pdf->xFormation, $y + 1.5, 2, 'JPG');
			$pdf->MultiCell($pdf->largeurColD, $pdf->hauteurTitreFormation, utf8_decode('  MODALITÉ(S) D\'ADMISSION ET DE RECRUTEMENT'), 0, 'L', 0);
			$pdf->SetFont('Arial', '', 8);
			$pdf->SetTextColor($pdf->grisFonce[0], $pdf->grisFonce[1], $pdf->grisFonce[2]);
			$pdf->SetDrawColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Line($pdf->xFormation, $y + $pdf->hauteurTitreFormation, $pdf->xFormation + $pdf->largeurColD, $y + $pdf->hauteurTitreFormation);
			
			$y = $pdf->getY() + $pdf->margeSousTitreFormation;
			$pdf->setY($y);
			$pdf->SetX($pdf->xFormation);
			$pdf->MultiCell($pdf->largeurColD, $pdf->hauteurBaseLigne, trim($modAdm_pdf), 0, 'L');
			
			//$mod_height = $pdf->calcHauteurCell($modAdm_pdf, 'D');
			$y = $pdf->getY() + $pdf->hauteurMarge;
			$pdf->setY($y);
			$pdf->SetX($pdf->xFormation);
		}
		
		//Reconnaissance des acquis
		$reco_pdf = "";
		if ($sanction !== false || isset($fullCertif)) {
			$reco_pdf .= (isset($sanction) && $sanction !== false) ? $sanction['SAIntitule'] : $fullCertif['CIIntitule'];
			
			if (isset($fullCertif) && $formation->FNivSortie_ID > 0) {
				//récupération des niveaux FR et EUR
				/*$levelFr = $formation->getNiveauLevel($fullCertif['CNIntitule']);
				if ($levelFr > 0) $reco_pdf .= " (Niveau Fr " . $levelFr . " - Niveau Eu " . $fullCertif["NEurope"] . ")";
				*/
				if ($fullCertif['NiveauFrance'] > 0) $reco_pdf .= " (Niveau Fr " . $fullCertif['NiveauFrance'] . " - Niveau Eu " . $fullCertif["NEurope"] . ")";
				else $reco_pdf .= " (Sans niveau spécifique)";
			}
			if (isset($fullCertif) && $fullCertif['C_ID'] == 5) $reco_pdf .= " - 120 ECTS";
		}
		$reco_pdf = utf8_decode($reco_pdf);
		//Commentaire reconnaissance
		if ($formation->FCommentaireReconnaissance != '') $reco_pdf .= "\n" . $formation->FCommentaireReconnaissance;
		
		if ($reco_pdf != "") {
			$pdf->SetFont('Arial', 'B', 10);
			$pdf->SetTextColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Image($fleche, $pdf->xFormation, $y + 1.5, 2, 'JPG');
			$pdf->MultiCell($pdf->largeurColD, $pdf->hauteurTitreFormation, '  EVALUATION ET RECONNAISSANCE(S) DES ACQUIS', 0, 'L', 0);
			$pdf->SetFont('Arial', '', 8);
			$pdf->SetTextColor($pdf->grisFonce[0], $pdf->grisFonce[1], $pdf->grisFonce[2]);
			$pdf->SetDrawColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Line($pdf->xFormation, $y + $pdf->hauteurTitreFormation, $pdf->xFormation + $pdf->largeurColD, $y + $pdf->hauteurTitreFormation);
			
			$y = $pdf->getY() + $pdf->margeSousTitreFormation;
			$pdf->setY($y);
			$pdf->SetX($pdf->xFormation);
			$pdf->MultiCell($pdf->largeurColD, $pdf->hauteurBaseLigne, $reco_pdf, 0, 'L');
			
			//$reco_height = $pdf->calcHauteurCell($reco_pdf, 'D');
			$y = $pdf->getY() + $pdf->hauteurMarge;
			$pdf->setY($y);
			$pdf->SetX($pdf->xFormation);
		}
		
		//Intervenant
		if ($formation->FIntervenant != "") {
			$pdf->SetFont('Arial', 'B', 10);
			$pdf->SetTextColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Image($fleche, $pdf->xFormation, $y + 1.5, 2, 'JPG');
			$pdf->MultiCell($pdf->largeurColD, $pdf->hauteurTitreFormation, utf8_decode('  INTERVENANT(E)(S)'), 0, 'L', 0);
			$pdf->SetFont('Arial', '', 8);
			$pdf->SetTextColor($pdf->grisFonce[0], $pdf->grisFonce[1], $pdf->grisFonce[2]);
			$pdf->SetDrawColor($bleuFonce[0], $bleuFonce[1], $bleuFonce[2]);
			$pdf->Line($pdf->xFormation, $y + $pdf->hauteurTitreFormation, $pdf->xFormation + $pdf->largeurColD, $y + $pdf->hauteurTitreFormation);
			
			$y = $pdf->getY() + $pdf->margeSousTitreFormation;
			$pdf->setY($y);
			$pdf->SetX($pdf->xFormation);
			$pdf->MultiCell($pdf->largeurColD, $pdf->hauteurBaseLigne, trim($formation->FIntervenant), 0, 'L');
			
			//$int_height = $pdf->calcHauteurCell($formation->FIntervenant, 'D');
			$y = $pdf->getY() + $pdf->hauteurMarge;
			$pdf->setY($y);
			$pdf->SetX($pdf->xFormation);
		}
		
		//Labels
		$labels_ID = $formation_l->getIDsFromLiaison('formation__label_l', array('LLA_ID'));
		$labels_pdf = "";
		$cptr_labels = 0;
		if (count($labels_ID) > 0) {
			foreach ($labels_ID as $label_ID) {
				$label_detail = $formation_l->getResult('formation__label', $label_ID['LLA_ID'], array('LASlug'));
				
				if (is_array($label_detail) && !empty($label_detail)) {
					$pdf->Image(DR . 'template/assets/img/labels/' . $label_detail['LASlug'] . '.png', $pdf->xFormation + ($cptr_labels * 25) + ($cptr_labels * 5), $y + 7, 25, 'PNG');
				}
				$cptr_labels++;
			}
		}
	
	endforeach; //actions

endif; //action !== false
