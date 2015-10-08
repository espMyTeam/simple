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

				$clients = selectionneClients($base);

				echo "
				<table border='2' style='width:auto;'>
					<caption>Liste des clients</caption>
					<thead>
						<tr>
							<th>UID</th>
							<th>N° Tel</th>
							<th>Date Inscription</th>
							<th>Extension Couverture</th>
							<th>UFR</th>
							<th>@ MAC</th>
						</tr>
					</thead>
					<tbody>
				";
				while($client=$clients->fetch()) {
					?>
						<tr>
							<td><?php echo $client['client_UID'];?></td>
							<td><?php echo $client['client_numTel'];?></td>
							<td><?php echo $client['client_dateInsc'];?></td>
							<td><?php echo $client['client_extCouv'];?></td>
							<td><?php echo $client['client_UFR'];?></td>
							<td><?php echo $client['client_adrMac'];?></td>
							<form method="post" action="modifier_client.php">
								<input type="hidden" name="client_id" value=<?php echo "" . $utilisateur['client_id'];?> />
								<td width="30px"><input type="submit" value="Modifier" style="width:100%;" class='bct'></td>
							</form>
							<form method="post" action="supprimer_client.php">
								<input type="hidden" name="client_id" value=<?php echo "" . $utilisateur['client_id'];?> />
								<td width="30px"><input type="submit" class='bct' value="Supprimer" style="width:100%;"></td>
							</form>
							
							
						</tr>
					<?php
				}
				echo "</tbody>
				</table>";
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
