#! /usr/bin/php
<?php
	require_once("base_connexion.php");
	require_once("/home/abdoulaye/workspace/projets/buntutekki/scripts/requetes.php");
	
	function updateMensualite(){
		
		$dat = Date("d H-i-s");
		$action = selectionAction(1);

		//si le delai de mise de jour
		if($dat===$action['action_date']){
			
			//recuperer tous les inscriptions
			$inscription = selectionneInscriptions($base);

			while($donnees = $inscription->fetch()) {

				//imettre le champ mensulite a 0
				modifieChampInscription("mensualite", 0, $donnees["inscription_id"], $base);
			}

		}
	}

	function envoieTutoriel(){
		$date_envoie = selectionneTutorielToSend();
	}

	//une boucle 
	while(true){
		
		updateMensualite();
	}

?>
