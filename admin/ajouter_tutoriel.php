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
				if(isset($_POST['username']) && isset($_POST['password']) && $_POST['username']!=="" && $_POST['password']!==""){
					require_once("../scripts/base_connexion.php");
					require_once("../scripts/traitement.php");
					require_once("../scripts/requetes.php");

					//insertion dans la base
					$res=newTutoriel($_POST[''],$_POST['password'],$base);

					if($res==-1){
						echo "<div>Impossible d'ajouter cet utilisateur!</div>";
					}elseif($res==0){
						echo "<div>Cet utilisateur existe déjà...</div>";
					}else{
						echo "<div>Opération d'ajout de l'utilisateur réussie:<br/>
							<label>Nom d'utilisateur</label> " . $_POST['username'] . "<br/>
							<label>Mot de passe</label>" . $_POST['password'] . "<br/>
						</div>";
					}
				}
				else{
					?>
					<form method="post" action="ajouter_tutoriel.php">
						<table border="0">
						<caption>Nouveau tutoriel</caption>
						<tr>
							<td><label>Entete</label></td>
							<td><input type="text" name="tutoriel_entete" placeholder="entete tutoriel" required/></td>
						</tr>
						<tr>
							<td><label>Tutoriel</label></td>
							<td><input type="textarea" name="tutoriel_contenu" style="width:100px;height:200px;" required/></td>
						</tr>
						<tr>
							<td><label>Date d'envoie</label></td>
							<td><input type="date" name="date" autocomplete="off" required/></td>
						</tr>
						<tr>
							<td><label>Heure d'envoie</label></td>
							<td><input type="time" name="date" autocomplete="off" required/></td>
						</tr>
						<tr>
							<td><label>Service</label></td>
							<td><select>
								<option></option>
							</select></td>
							<td><input type="text" name="service_titre" required/></td>
						</tr>
						<tr>
							<td><input type="submit" value="Ajouter"/></td>
							<td><input type="button" value="Annuler" onclick="document.location.href='index.php.php'" /></td>
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
