<?php
/*
* module: requete
* description: interrogation de la $base de donnees
*/



/*
* 
*
*/

function newClient($num, $base)
{
	$req = "INSERT INTO client(client_numTel, client_dateInsc) VALUES(:client_numTel, :client_dateInsc)";
	$res=1;
	$dat = Date("Y-m-d H-i-s");

	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
				":client_numTel" => $num,
				":client_dateInsc" => $dat
			));

	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
		$res=-1;
	}


	if($res==1)
	{	
		return $base->lastInsertId();
	}
	else
	{
		return -1;
	}
}

/*
* fonction: insereClient
*/


function insereClient($tab, $base){
	$req = "INSERT INTO client(client_UID,client_numTel,client_dateInsc,client_paiement,
		client_mensualite,client_extCouv,client__UFR,client_adrMac,client_histoMensualite) 
VALUES(:client_UID,:client_numTel,:client_dateInsc,:client_paiement,:client_mensualite,
	:client_extCouv,:client__UFR,:client_adrMac,:client_histoMensualite)";
	$res=1;
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute($tab);
	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
		$res=-1;
	}


	if($res===1)
	{	
		return $base->lastInsertId();
	}
	else
	{
		return -1;
	}
	
}

/*
* fonction: selectionne
*
*/
function selectionneClient($uid, $base){
	$req = "SELECT * FROM client WHERE client_UID=:uid";
	$res=[];
	
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
				":uid" => $uid
			));
		$res=$envoie->fetch();
		
	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}

	return $res;
}

/*
* fonction: selectionne le client avec le numero de telephone
*
*/
function selectionneClientByTel($num, $base){
	$req = "SELECT * FROM client WHERE client_numTel=:num";
	$res=[];
	
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
				":num" => $num
			));
		$res=$envoie->fetch();
	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}

	return $res;
}

/*
*
* description:  selectionne tous les clients
*/
function selectionneClients($base, $mois=""){
	if($mois===""){
		$req = "SELECT * FROM client";
		$res=[];
	
		try
		{
			$envoie=$base->prepare($req);
			$envoie->execute(array());
			//$res=$envoie->fetch();
			$res = $envoie;

		}catch(Exception $e){
			//echo "erreur : " . $e->getMessage();
		}

		return $res;
	}
	else{
		$req = "SELECT * FROM client WHERE client_dateInsc=:client_dateInsc";
		$res=[];
	
		try
		{
			$envoie=$base->prepare($req);
			$envoie->execute(array(
				":client_dateInsc" => 2
			));
			//$res=$envoie->fetch();
			$res = $envoie;

		}catch(Exception $e){
			//echo "erreur : " . $e->getMessage();

		}

		return $res;
	}
	
}

/*
*
* description: selectionne tous les clients inscrits dans un service de ALIENTECH
*/
function selectionneClientsInscrits($base){
	$req = "SELECT client.client_UID,client_numTel,service_titre,date_insc,mensualite,code_paiement FROM client, inscription WHERE client.client_UID=inscription.client_UID";
	$res=[];
	
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
				":uid" => $uid
			));
	//	$res=$envoie->fetch();
		$res = $envoie;
	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}

	return $res;
}

/*
*
* description: selectionne tous les clients inscrits au service specifié de ALIENTECH
*/
function selectionneClientsService($service,$base){
	$req = "SELECT client.client_UID,client_numTel,date_insc,mensualite,code_paiement FROM client, inscription WHERE client.client_UID=inscription.client_UID 
	AND service_titre=:service_titre";
	$res=[];
	
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
			":service_titre" => $service
		));
		//$res=$envoie->fetch();
		$res = $envoie;

	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}

	return $res;
}

/*
* fonction: modifie
* parametres: int array tab 
*/
function modifieClient($valeur, $base){
	$req = "UPDATE client SET client_UID=:client_UID,client_numTel=:client_numTel,
	client_datInsc=:client_dateInsc,client_extCouv=:client_extCouv,
	client_UFR=:client_UFR,client_adrMac=:client_adrMac WHERE client_id=:client_id";

	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute($valeur);

	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}
}

function modifieChampClient($champ, $valeur, $id, $base)
{
	$req = "UPDATE client SET $champ=:champ WHERE client_id=:client_id";
	//echo $req;

	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
			"champ" => $valeur,
			"client_id" => $id
		));
	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}
}


function getIndexDernierClient($base){
	$base->lastInsertId();
}

function supprimeClient($id, $base){

}


/************ requetes services ************/
function newService($tab, $base){
	$req = "INSERT INTO service(service_titre,service_nom,service_description) 
VALUES(:service_titre, :service_nom, :service_description)";
	$res=1;
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute($tab);
	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
		$res=-1;
	}


	if($res===1)
	{	
		return $base->lastInsertId();
	}
	else
	{
		return -1;
	}
}

/*
* fonction: selectionne
*
*/
function selectionneService($titre, $base){
	$req = "SELECT * FROM service WHERE service_titre=:titre";
	$res=[];
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
				":titre" => $titre
			));
		$res=$envoie->fetch();

	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}
		return $res;
}

function modifieChampService($champ, $valeur, $id, $base)
{
	$req = "UPDATE service SET $champ=:champ WHERE service_titre=:service_titre";

	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
			"champ" => $valeur,
			"service_titre" => $id
		));

	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}
}


/***************** les inscriptions ************/
function newInscription($tab, $base){
	$req = "INSERT INTO inscription(client_UID,service_titre,date_insc,mensualite) 
VALUES(:client_UID,:service_titre,:date_insc,:mensualite)";
	$res=1;
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute($tab);
	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
		$res=-1;
	}


	if($res===1)
	{	
		return $base->lastInsertId();
	}
	else
	{
		return -1;
	}
}

/*
* fonction: selectionne
*
*/
function selectionneInscription($uid, $service, $base){
	$req = "SELECT * FROM inscription WHERE service_titre=:titre AND client_UID=:uid";
	$res=[];
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
				":titre" => $service,
				":uid" => $uid
			));

		$res=$envoie->fetch();

	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}
		return $res;
}

/*
* 
* description: selectionne tous les enregistrements de mensualite à 1
*/

function selectionneInscriptions($base){
	$req = "SELECT * FROM inscription WHERE mensualite=:mensualite";
	$res=[];
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
				"mensualite" => 1
			));

		$res=$envoie;

	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}
		return $res;
}


function modifieChampInscription($champ, $valeur, $id, $base)
{
	$req = "UPDATE inscription SET $champ=:champ WHERE inscription_id=:id";

	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
			"champ" => $valeur,
			"id" => $id
		));

	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}
}

/***************** les journaux sms ************/
function newSMS($tab, $base){
	$req = "INSERT INTO journal_sms(objet,expediteur,destinataire,contenu,date_sms) 
VALUES(:objet,:expediteur,:destinataire,:contenu,:date_sms)";
	$res=1;
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute($tab);
	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
		$res=-1;
	}


	if($res===1)
	{	
		return $base->lastInsertId();
	}
	else
	{
		return -1;
	}
}

function selectionneSMS($id, $base){
	$req = "SELECT * FROM journal_sms WHERE id=:id";
	$res=[];
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
				":id" => $id
			));

		$res=$envoie->fetch();

	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}
		return $res;
}

/*
*
* description: selectionner tous les sms
*/
function selectionneSMSs($base){
	$req = "SELECT * FROM journal_sms";
	$res=[];
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array());

		$res=$envoie;

	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}
		return $res;
}

/*
*
* description: supprime un sms du journal
*/
function supprimeSMS($id, $base){
	$req = "DELETE FROM journal_sms WHERE id=:id";

	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
			"id" => $id
		));

	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}
}

/***************** historique mensualite ************/
function newMensualite($tab, $base){
	$req = "INSERT INTO historique_paiement(inscription_id,mois,annee,date_paiement) 
VALUES(:inscription_id,:mois,:annee,:date_paiement)";

	$res=1;
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute($tab);
	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
		$res=-1;
	}


	if($res===1)
	{	
		return $base->lastInsertId();
	}
	else
	{
		return -1;
	}
}

function selectionneMensualite($id, $base){
	$req = "SELECT * FROM historique_paiement WHERE id=:id";
	$res=[];
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
				":id" => $id
			));

		$res=$envoie->fetch();

	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}
		return $res;
}

function modifieChampMensualite($champ, $valeur, $id, $base)
{
	$req = "UPDATE historique_paiement SET $champ=:champ WHERE id=:id";

	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
			"champ" => $valeur,
			"id" => $id
		));

	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}
}

/**************** utilisateur **************/
/*
*
*/
function newUser($username, $password, $base){
	$req = "INSERT INTO admin(username, password) VALUES(:username,:password)";

	$res=1;
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
			":username" => $username,
			":password" => $password
		));
	}catch(Exception $e){
	//	echo "erreur : " . $e->getMessage();
		$res=-1;
	}


	if($res===1)
	{	
		return $base->lastInsertId();
	}
	else
	{
		return -1;
	}
}

/*
*
*
*/
function selectionneUserById($id, $base){

	$req = "SELECT * FROM admin WHERE id_admin=:id";
	$res=[];
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
				":id" => $id
			));

		$res=$envoie->fetch();

	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}
		return $res;
}

/*
*
*
*/
function selectionneUser($username, $password, $base){

	$req = "SELECT * FROM admin WHERE username=:username AND password=:password";
	$res=[];
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
				":username" => $username,
				":password" => $password
			));

		$res=$envoie->fetch();

	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}
		return $res;
}

/*
*
* description: selectionner tous les utilisateurs
*/
function selectionneUsers($base){

	$req = "SELECT * FROM admin";
	$res=[];
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array());

		$res=$envoie;

	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}
		return $res;
}
/*
* fonction: modifie un enregsitrement dans la table admin
* parametres: tableau des valeurs 
*/
function modifieUser($valeur, $base){
	$req = "UPDATE admin SET username=:username, password=:password WHERE id_admin=:id_admin";

	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute($valeur);
	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}
	return $envoie;
}

function modifieChampUser($champ, $valeur, $id, $base)
{
	$req = "UPDATE admin SET $champ=:champ WHERE id=:id";

	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
			"champ" => $valeur,
			"id" => $id
		));

	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}
}
/*
*
*
*/
function supprimeUser($id, $base){
	$req = "DELETE FROM admin WHERE id_admin=:id";

	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
			"id" => $id
		));

	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}
}

/**************** tutoriels **************/
/*
*
*/
function newTutoriel($entete, $contenu, $service, $base){
	$req = "INSERT INTO tutoriel(tutoriel_entete,tutoriel_contenu,service_titre) 
	VALUES(:tutoriel_entet,:tutoriel_contenu,:service_titre)";

	$res=1;
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
			"tutoriel_entete" => $entete,
			"tutoriel_contenu" => $contenu,
			"service_titre" => $service
		));
	}catch(Exception $e){
	//	echo "erreur : " . $e->getMessage();
		$res=-1;
	}


	if($res===1)
	{	
		return $base->lastInsertId();
	}
	else
	{
		return -1;
	}
}

/*
*
*
*/
function selectionneTutoriel($id, $base){

	$req = "SELECT * FROM tutoriel WHERE ";
	$res=[];
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
				":username" => $username,
				":password" => $password
			));

		$res=$envoie->fetch();

	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}
		return $res;
}

/************** actions automatiques ******/
function newAction(){

}

function selectionAction($id){
	$req = "SELECT * FROM action_automatique WHERE action_id=:id";
	$res=[];
	
	try
	{
		$envoie=$base->prepare($req);
		$envoie->execute(array(
				":id" => $id
			));
		
		$res=$envoie->fetch();

	}catch(Exception $e){
		//echo "erreur : " . $e->getMessage();
	}

	return $res;
}

function modifieAction($id){

}
function supprimeAction($id){

}

?>