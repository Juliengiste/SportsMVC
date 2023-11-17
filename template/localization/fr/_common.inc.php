<?
/*******************************
Version : 1.0.0.0
Revised : samedi 16 septembre 2017, 00:26:22 (UTC+0200)
*******************************/

/**
*
* common [French]
*
*/

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	// META
	'META_TITR_ACCUEIL'			=> 'LudiQ ... développement par Julien Maignaut',
	'META_DESC_ACCUEIL'			=> 'Site web test pour portfolio',
	'META_TITR_CONTACT'			=> 'Une question, un conseil, contactez nous !',
	'META_DESC_CONTACT'			=> 'Notre équipe se tient à votre disposition à tout moment, pour vous renseigner ou vous conseiller. Contactez-nous sans attendre !',

	'NBREF' 				=> '230 000',

	// MENU PRINCIPAL
	'MNU_GROUPE'			=> 'Nos prestations',
	'MNU_FILIALES'			=> 'Nos agences',
	'MNU_ENGAGEMENTS'		=> 'Groupe IDLP',
	'MNU_PARTENARIATS'		=> 'Nos partenariats',
	'MNU_CONTACT'			=> 'Contact',
	'MNU_TROUVER'			=> 'Nous trouver',

	// MENU PRINCIPAL (LINK)
	'MLK_GROUPE'			=> 'nos-prestations',
	'MLK_FILIALES'			=> 'nos-agences',
	'MLK_ENGAGEMENTS'		=> 'groupe-idlp',
	'MLK_PARTENARIATS'		=> 'nos-partenariats',
	'MLK_CONTACT'			=> 'contact',
	'MLK_ACHETER' 			=> 'http://81.80.210.49/ccdisp.htm?WSYD_EVENT=CCCNXS00&CWCAPP=CWEB#ancre',
	'MLK_TROUVER' 			=> 'contact',

	// SOUS-MENU GROUPE
	'MNG_00' 				=> '&gt;&gt; Les activités',
	'MNG_01'				=> '&gt; Stocker',
	'MNG_02'				=> '&gt; Distribuer',
	'MNG_03'				=> '&gt; Réparer',
	'MNG_04'				=> '&gt; Fabriquer',
	'MNG_05'				=> '&gt; Former',
	'MNG_06'				=> '&gt; Nous trouver',

	'MNG_10' 				=> '&gt;&gt; Les spécialités',
	'MNG_11'				=> '&gt; Centres spécialisés VL',
	'MNG_12'				=> '&gt; Centres spécialisés PL',
	'MNG_13'				=> '&gt; Magasins spécialisés peinture',
	'MNG_14'				=> '&gt; Sites spécialisés Taximètre',
	'MNG_15'				=> '&gt; Pôles équipement d’atelier',
	'MNG_16'				=> '&gt; Laboratoires certifiés',

	// SOUS-MENU GROUPE (LINK)
	'MGL_01'				=> 'stocker',
	'MGL_02'				=> 'distribuer',
	'MGL_03'				=> 'reparer',
	'MGL_04'				=> 'fabriquer',
	'MGL_05'				=> 'former',
	'MGL_06'				=> 'contact',

	'MGL_11'				=> 'centres-vl',
	'MGL_12'				=> 'centres-pl',
	'MGL_13'				=> 'peinture',
	'MGL_14'				=> 'taximetre',
	'MGL_15'				=> 'equipement',
	'MGL_16'				=> 'laboratoires',

	// SOUS-MENU FILIALES
	'MNF_01' 				=> '&gt; Agences',
	'MNF_02' 				=> '&gt; Les moyens humains et technique',
	'MNF_03' 				=> '&gt; Actualités',

	// SOUS-MENU FILIALES (LINK)
	'MFL_01' 				=> 'agences',
	'MFL_02' 				=> 'les-moyens',
	'MFL_03' 				=> 'actualites',

	// SOUS-MENU ENGAGEMENT
	'MNE_01' 				=> '&gt; Historique',
	'MNE_02' 				=> '&gt; Le réseau',
	'MNE_03' 				=> '&gt; Charte qualité',
	'MNE_04' 				=> '&gt; Normes ISO 9001',

	'MNE_11' 				=> '&gt; Nos offres d’emplois',
	'MNE_12' 				=> '&gt; Nous rejoindre',

	// SOUS-MENU ENGAGEMENT (LINK)
	'MEL_01' 				=> 'https://www.idlpgroupe.fr/histoire',
	'MEL_02' 				=> 'https://www.idlpgroupe.fr/presence',
	'MEL_03' 				=> 'https://www.idlpgroupe.fr/charte',
	'MEL_04' 				=> 'normes',

	'MEL_11' 				=> 'https://www.idlpgroupe.fr/offre-d-emploi',
	'MEL_12' 				=> 'https://www.idlpgroupe.fr/candidatures',

	// SOUS-MENU PARTENARIATS
	'MNP_01' 				=> '&gt; Équipementiers',
	'MNP_02' 				=> '&gt; Bosch Car Service',

	'MNP_11' 				=> '&gt; Technicar Services',
	'MNP_12' 				=> '&gt; Diéséliste de France',

	'MNP_21' 				=> '&gt; Alternative Autoparts',
	'MNP_22' 				=> '&gt; Éco révision',

	// SOUS-MENU PARTENARIATS (LINK)
	'MPL_01' 				=> 'equipementiers',
	'MPL_02' 				=> 'bosch-car-service',

	'MPL_11' 				=> 'technicar-services',
	'MPL_12' 				=> 'dieseliste-de-france',

	'MPL_21' 				=> 'alternative-autoparts',
	'MPL_22' 				=> 'eco-revision',

	// FOOTER
	'MFO_PLAN'				=> 'Plan du site',
	'MFO_ACHETER'			=> 'Acheter en ligne',
	'MFO_EGALITE'			=> 'Index égalité Femmes-Hommes',
	'MFO_MENTIONS'			=> 'Mentions légales',
	'MFO_COPY'				=> '© Groupe IDLP 2017',

	'MLK_PLAN'				=> 'plan-du-site',
	'MLK_ACHETER'			=> 'http://81.80.210.49/ccdisp.htm?WSYD_EVENT=CCCNXS00&CWCAPP=CWEB#ancre',
	'MLK_EGALITE'			=> 'index-egalite-femmes-hommes',
	'MLK_MENTIONS'			=> 'mentions-legales',

	// 404
	'DIAPO'					=> 'Erreur 404',
	'E404'					=> 'Erreur 404',
	'I404'					=> 'Illustration pour l’erreur 404, page non trouvée',
	'PAGE_NOT_FOUND'		=> 'Page non trouvée',
	'PAGE_NOT_FOUND_LONG'	=> 'Cette page ne semble pas exister pour l’instant. Heureusement, il y en a plein d’autres ! Utilisez le menu afin de poursuivre votre navigation.',
	
));
?>