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
		<section style="height:100%;">
			<?php
				require_once("../scripts/base_connexion.php");
				require_once("../scripts/traitement.php");
				require_once("../scripts/requetes.php");

				$smss = selectionneSMSs($base);

				echo "<div>
				<table border='2' style='width:100%; height:100%;'>
					<caption>Liste des messages</caption>
					<thead>
						<tr>
							<th>Expediteur</th>
							<th>Destinataire</th>
							<th>Objet</th>
							<th>Message</th>
							<th>Date du sms</th>
						</tr>
					</thead>
					<tbody>
				";
				while($sms=$smss->fetch()) {
					?>
						<tr>
							<td><?php echo $sms['expediteur'];?></td>
							<td><?php echo $sms['destinataire'];?></td>
							<td><?php echo $sms['objet'];?></td>
							<td><?php echo $sms['contenu'];?></td>
							<td><?php echo $sms['date_sms'];?></td>
							
							<form method="post" action="supprimer_sms.php">
								<input type="hidden" name="id" value=<?php echo "" . $sms['id'];?> />
								<td width="30px"><input type="submit" onclick="alert(Voulez-vous vraiment supprimer ce sms);" class='bct' value="Supprimer" style="width:100%;"></td>
							</form>
							
							
						</tr>
					<?php
				}
				echo "</tbody>
				</table>
				</div>";
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
