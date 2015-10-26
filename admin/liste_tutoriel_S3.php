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

				$tutoriels = selectionneTutoriels($base);

				echo "<div>
				<table border='2' style='width:100%; height:100%;'>
					<caption>Liste des tutoriels</caption>
					<thead>
						<tr>
							<th>Entete</th>
							<th>Contenu</th>
							<th>Service</th>
							<th>Date d'envoie</th>
							<th>Auteur</th>
						</tr>
					</thead>
					<tbody>
				";
				while($tutoriel=$tutoriels->fetch()) {
					?>
						<tr>
							<td><?php echo $tutoriel['tutoriel_entete'];?></td>
							<td><?php echo $tutoriel['tutoriel_contenu'];?></td>
							<td><?php echo $tutoriel['service_titre'];?></td>
							<td><?php echo $tutoriel['tutoriel_dateDenvoie'];?></td>
							<td><?php echo $tutoriel['tutoriel_auteur'];?></td>
							
							<form method="post" action="supprimer_tutoriel.php">
								<input type="hidden" name="id" value=<?php echo "" . $tutoriel['tutoriel_id'];?> />
								<td width="30px"><input type="submit" onclick="alert(Voulez-vous vraiment supprimer ce tutoriel);" class='bct' value="Supprimer" style="width:100%;"></td>
							</form>
							<form method="post" action="modifier_tutoriel.php">
								<input type="hidden" name="id" value=<?php echo "" . $tutoriel['tutoriel_id'];?> />
								<td width="30px"><input type="submit" class='bct' value="Modifier" style="width:100%;"></td>
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
