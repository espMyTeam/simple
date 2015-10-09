<!DOCTYPE html>
<html>
	<head>
		<title>Administration AlienTech</title>
		<link rel="stylesheet" type="text/css" href="static/style/base.css">
		<?php
			include("template/meta.php");
		?>
	</head>
	<body>
		
		<!-- contenu de la page -->
		<?php
			session_start();
			if(isset($_SESSION['pseudo']) && isset($_SESSION['pass']))
			{
				include("template/header.php");

		?>
		<section>
			<?php
				require_once("../scripts/base_connexion.php");
				require_once("../scripts/traitement.php");
				require_once("../scripts/requetes.php");

				if(isset($_POST['client']) && $_POST['client']!==""){

					//selectionner le client
					$res=selectionneClient($_POST['client'],$base);
					print_r($res);
		
					?>
					<form method="post" action="modifier_client.php">
						<table>
						<tr>
							<td><label>UID</label></td>
							<td><input type="text" name="client_UID" <?php echo "value='" . $res['client_UID'] . "'";?> /></td>
						</tr>
						<tr>
							<td><label>N° telephone</label></td>
							<td><input type="text" name="client_numTel" <?php echo "value='" . $res['client_numTel'] . "'";?> /></td>
						</tr>
						<tr>
							<td><label>Date inscription</label></td>
							<td><input type="text" name="client_dateInsc" <?php echo "value='" . $res['client_dateInsc'] . "'";?> readonly/></td>
						<tr>
							<td><label>Extesion Couverture</label></td>
							<td><input type="text" name="client_extCouv" <?php echo "value='" . $res['client_extCouv'] . "'";?> /></td>
						</tr>
						<tr>
							<td><label>UFR</label></td>
							<td><input type="text" name="client_UFR" <?php echo "value='" . $res['client_UFR'] . "'";?> /></td>
						</tr>
						<tr>
							<td><label>adresse MAC</label></td>
							<td><input type="text" name="client_adrMac" <?php echo "value='" . $res['client_adrMac'] . "'";?> /></td>
						</tr>
						<tr>
							<td><input type="submit" value="Sauvegarder"/></td>
							<td><input type="button" value="Annuler" onclick="document.location.href='liste_client.php'" /></td>
						</tr>

						</table>
						<input type="hidden" name="client_id" <?php echo "value='" . $res['client_id'] . "'";?> />
					</form>
					<?php

					
					
				}
				elseif(isset($_POST['client_id']) && $_POST['client_id']!=="" && 
					isset($_POST['client_UID']) && $_POST['client_UID']!=="" && 
					isset($_POST['client_UFR']) &&  
					isset($_POST['client_numTel']) && $_POST['client_numTel']!=="" && 
					isset($_POST['client_dateInsc']) && $_POST['client_dateInsc']!=="" && 
					isset($_POST['client_adrMac']) &&  
					isset($_POST['client_extCouv'])){
					//modifier l'enregsitrement dans la base
					
					$client= array(
						':client_UFR' => $_POST['client_UFR'],
						':client_dateInsc' => $_POST['client_dateInsc'],
						':client_adrMac' => $_POST['client_adrMac'],
						':client_UID' => $_POST['client_UID'],
						':client_numTel' => $_POST['client_numTel'],
						':client_extCouv' => $_POST['client_extCouv'],
						':client_id' => $_POST['client_id']
					);
					
					

					$res = modifieClient($client, $base);
					header("location: liste_client.php");

				}
				else{
					
					header("location: index.php");
				}
			?>
		</section>
		
		<?php
			}
			else
			{
				session_destroy();
				header("location: index.php");
			}
			include("template/footer.php");
		?>
	</body>
</html>
