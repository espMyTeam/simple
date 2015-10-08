<header>
	<div id="div_avant_menu">
		<div id="div_logo">
			<p>Application d'administration de la plateforme Alientech</p>
		</div>
		<div id="div_deconnecte">
			<form method="post" action="deconnexion.php">
				<label id="lab_user_connecte"><?php echo $_SESSION['pseudo'];?></label><input type="submit" value="Se deconnecter" style="text-align:center;" />
			</form>
		</div>
		
	</div>
	<div id="div_menu">
	<?php
		include("menu.php");
	?>
	</div>
	
</header>
