<?php
	require_once("../scripts/base_connexion.php");
					require_once("../scripts/traitement.php");
					require_once("../scripts/requetes.php");
	$utilisateur = array(
						':username' => "aziz",
						':password' => "passer",
						':id_admin' => 4
	);							
	$res = modifieUser($utilisateur, $base);
?>
