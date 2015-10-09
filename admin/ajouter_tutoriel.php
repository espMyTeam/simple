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
				if(isset($_POST['tutoriel_entete']) && $_POST['tutoriel_entete']!=="" 
					&& isset($_POST['tutoriel_contenu']) && $_POST['tutoriel_contenu']!==""
					&& isset($_POST['date']) && $_POST['date']!==""
					&& isset($_POST['heure']) && $_POST['heure']!==""
					&& isset($_POST['service_titre']) && $_POST['service_titre']!==""){
					require_once("../scripts/base_connexion.php");
					require_once("../scripts/traitement.php");
					require_once("../scripts/requetes.php");

					$dateDenvoie = $_POST['date'] . " " . $_POST['heure'] . ":00";
					$tuto = array(
						":tutoriel_entete" => $_POST['tutoriel_entete'],
						":tutoriel_contenu" => $_POST['tutoriel_contenu'],
						":tutoriel_dateDenvoie" => $dateDenvoie,
						":service_titre" => $_POST['service_titre'],
						":tutoriel_auteur" =>  $_SESSION['pseudo']
					);
					//insertion dans la base
					$res=newTutoriel($tuto,$base);

					if($res==-1){
						echo "<div>Impossible d'ajouter ce tutoriel!</div>";
					}elseif($res==0){
						echo "<div>le titre de e tutoriel existe deja. Veuillez changer le titre...</div>";
					}else{
						header("location: liste_tutoriel.php");
					}
				}
				else{
					?>
					<form method="post" action="ajouter_tutoriel.php">
						<table border="0">
						<caption>Nouveau tutoriel</caption>
						<tr>
							<td><label>Entete</label></td>
							<td><input type="text" name="tutoriel_entete" placeholder="entete tutoriel" /></td>
						</tr>
						<tr>
							<td><label>Tutoriel</label></td>
							<td><input type="textarea" name="tutoriel_contenu" style="width:100px;height:200px;" /></td>
						</tr>
						<tr>
							<td><label>Date d'envoie</label></td>
							<td><input type="date" name="date" /></td>
						</tr>
						<tr>
							<td><label>Heure d'envoie</label></td>
							<td><input type="time" name="heure"/></td>
						</tr>
						<tr>
							<td><label>Service</label></td>
							<td><select>
								<option></option>
							</select></td>
							<td><input type="text" name="service_titre"/></td>
						</tr>
						<tr>
							<td><input type="submit" value="Ajouter"/></td>
							<td><input type="button" value="Annuler" onclick="document.location.href='index.php'" /></td>
						</tr>
						</table>
					</form>
					<?php
				}
			?>
		</section>
		
		<?php
			}
			else
			{
				session_destroy();
				include("connexion.php");
			}
			include("template/footer.php");
		?>
	</body>
</html>
