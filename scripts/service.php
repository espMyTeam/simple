<?php

/*
* fonction: inscription
*
*/
function inscription($tab, $numero, $base){

	//inserer l'evenement dans la base
		$sms= array(
			":objet" => "inscription à ALIENTECH",
			":expediteur" => "inconnue:$numero",
			":destinataire" => "serveur",
			":contenu" => implode(" ", $tab),
			":date_sms" => Date("Y-m-d H-i-s")
		);
		newSMS($sms,$base);

	if(count($tab)==2)
	{
		$fillial = $tab[1];

		//inserer un nouveau client
		$id = newClient($numero, $base);

		//definir de l'uid
		$uid = newUID($id, $fillial, $base);

		//inserer dans la base
		modifieChampClient("client_UID", $uid, $id, $base);

		//envoyer la reponse
		$msg = "Bonjour, ALIENTECH vous remercie de votre intérêt pour ses services. Votre UID est" . $uid . ". Pour finaliser votre inscription au service S1, merci d’envoyer S1 INSCR " . $uid . " au 24248. Cout du SMS 490 F.";

		//inserer l'evenement dans la base
		$sms= array(
			":objet" => "confirmation inscription",
			":expediteur" => "serveur",
			":destinataire" => "$uid:$numero",
			":contenu" => $msg,
			":date_sms" => Date("Y-m-d H-i-s")
		);
		newSMS($sms,$base);

		//envoyer le msg au client
		envoieMsg($msg);
		 
	}

}

/*
* fonction: confirmation
*
*/

function inscriptionService($numero, $uid, $service, $base){
		
		$client = selectionneClient($uid, $base);
		
		$service = selectionneService($service, $base);

		//champ <a paiement >=OUI, <mensualite>=1
		//insertion dans la base
		$tab = array(
			"service_titre" => $service["service_titre"],
			"client_UID" => $client["client_UID"],
			"date_insc" => Date("Y-m-d H-i-s"),
			"mensualite" => 1
		);

		$service_id = newInscription($tab, $base);

		//sms de confirmation
		$msg = "Inscription au service " . $service["service_titre"] . " réussie. Pour payer votre mensualité, veuillez envoyer ". $service["service_titre"] . " MENS " . $uid . " au 24248. Cout du SMS 490 F.";
		
		//inserer l'evenement dans la base
		$sms= array(
			":objet" => "confirmation inscription",
			":expediteur" => "serveur",
			":destinataire" => "$uid:$numero",
			":contenu" => $msg,
			":date_sms" => Date("Y-m-d H-i-s")
		);
		newSMS($sms,$base);

		//envoyer le msg au client
		envoieMsg($msg);	
}	

/*
*
*
*
*/
function mensualite($numero, $uid, $service, $base){
	$inscription = selectionneInscription($uid, $service, $base);
	$mensualite = $inscription['mensualite'];
	$uid = $inscription['client_UID'];
	$code = $inscription['code_paiement'];


	//verifier si la mensualite est 0 ou 1
	if($mensualite==1){
		$msg = "Paiement non-autorisé : mensualité en cours de validité.";

	}elseif($mensualite==0){
		//sms de confirmation
		$msg = "Paiement autorisé, veuillez envoyer $service PM $code $uid au 24248 pour effectuer le paiement";
	}

	//inserer l'evenement dans la base
	$sms= array(
		":objet" => "confirmation mensualite",
			":expediteur" => "serveur",
			":destinataire" => "$uid:$numero",
			":contenu" => $msg,
			":date_sms" => Date("Y-m-d H-i-s")
		);
		newSMS($sms,$base);


		//envoyer le msg au client
		envoieMsg($msg);
}
/*
*
*
*/

function paiement($num, $uid, $service, $code, $base){
	$inscription = selectionneInscription($uid, $service, $base);
	$mensualite = $inscription['mensualite'];
	$uid = $inscription['client_UID'];
	$code_paiement = $inscription['code_paiement'];
	
	if($code_paiement===$code){

		//mettre la mensualite à 1
		modifieChampInscription("mensualite", 1, $inscription["inscription_id"], $base);

		//mettre à jour l'historique
		$mens = array(
			":inscription_id" => $inscription['inscription_id'],
			":mois" => getMois(),
			":annee" => Date("Y"),
			":date_paiement" => Date("Y-m-d H-i-s")
		);
		newMensualite($mens, $base);

		//sms de confirmation de paiment
		$msg = "Paiment réaliser avec succes. Merci pour votre fidelité à ALIENTECH";
		
		//inserer l'evenement dans la base
		$sms= array(
			":objet" => "confirmation inscription",
			":expediteur" => "serveur",
			":destinataire" => "$uid($num)",
			":contenu" => $msg,
			":date_sms" => Date("Y-m-d H-i-s")
		);
		newSMS($sms,$base);


		//envoyer le msg au client
		envoieMsg($msg);
	}
}

function plateformeSMS($tab, $num, $base){
	//inserer l'evenement dans la base
	$sms=array(
			":objet" => "",
			":expediteur" => "$num",
			":destinataire" => "serveur",
			":contenu" => implode(" ", $tab),
			":date_sms" => Date("Y-m-d H-i-s")
		);

	if($tab[1]==="SL" || $tab[1]==="DK" || $tab[1]==="TH" || $tab[1]==="DI" || $tab[1]==="ZI"){
		if(count($tab)==2)
		{
			$client = valideNumero($num, $base);
			

			if($client===-1){
				inscription($tab, $num, $base);
			}
			else{
					$msg = "Bjr,vous êtes deja inscrits à ALIENTECH. Si vous souhaitez 
					vous inscrire à un service, envoyer S1, S2, S3, ou S4 au 24248";
					envoieMsg($msg);
			}
		}
	}
	elseif($tab[1]==="INSCR"){
		if(count($tab)==3)
		{
			$uid = $tab[2];

			//insertion dans la base
			$sms[':objet']="inscription au service $tab[0]";
			$sms[':expediteur'] = "$uid:$num";
			//print_r($sms);
			newSMS($sms, $base);

			inscriptionService($num, $uid, $tab[0], $base);
		}
	}
	elseif($tab[1]==="MENS"){
		if(count($tab)==3){
			$uid = $tab[2];

			//insertion dans la base
			$sms[':objet']="mensualité service $tab[0]";
			$sms[':expediteur'] = "$uid:$num";
			newSMS($sms, $base);

			mensualite($num,$uid,$tab[0],$base);

		}
	}elseif($tab[1]==="PM"){
		if(count($tab)==4){
			$code = $tab[2];
			$uid = $tab[3];

			//insertion dans la base
			$sms[':objet']="paiement service $tab[0]";
			$sms[':expediteur'] = "$uid:$num";
			newSMS($sms, $base);

			paiement($num, $uid, $tab[0], $code, $base);
		}
	}
	else{
		//insertion dans la base
		$sms[':objet']="erreur";
		$sms[':expediteur'] = "inconnue:$num";
		newSMS($sms, $base);
	}
}

/******************** les differents services sms *********************/

/*
* fonction: 
*
*/
function serviceS1($tab, $num, $base){

	plateformeSMS($tab,$num,$base);
}

/*
*
*
*/
function serviceS2($tab, $num, $base){
	plateformeSMS($tab,$num,$base);
}

/*
*
*
*/
function serviceS3($tab, $num, $base){
	plateformeSMS($tab,$num,$base);
}

/*
*
*
*/
function serviceS4($tab, $num, $base){
	plateformeSMS($tab,$num,$base);	
}

?>