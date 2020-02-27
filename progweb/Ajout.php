<html>
	<head>
		<title>
		Ajout
		</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./AdminCSS.css">
	</head>
	<body>
<?php require_once("Authentification.php");?>
<?php 
if (isset($_POST['ajouterPersonnel'])){
	echo "Veuillez affilez le personnnel à un secteur/hôpital.";
	echo "<form id = \"personnel\" method = \"post\" action = \"WebPageDataAdmin.php\">
<table>
	<tr><td>
	Sexe</td><td><select size = \"1\" name = \"sexe\">
	</select>
	</td></tr>
	<tr><td>
	Nom</td><td> <input type = \"text\" name = \"nom\" readonly value = \"".$_POST['nom']."\">
	</td></tr>
	<tr><td>
	Prénom</td><td> <input type = \"text\" name = \"prenom\" readonly value = \"".$_POST['prenom']."\">
	</td></tr>
	<tr><td>
	NumTel</td><td> <input type = \"text\" name = \"numTel\" readonly value = \"".$_POST['numtel']."\">
	</td></tr>
	<tr><td>
	Email</td><td> <input type = \"text\" name = \"email\" readonly value = \"".$_POST['email']."\">
	</td></tr>
	<tr><td>
	Date d'ajout</td><td> <input type = \"text\" name = \"date\" readonly value = \"".$_POST['date']."\">
	</td></tr>
	<tr><td>
	Fonction</td><td> <input name = \"fonction\" readonly id = \""."#text"."\" value = \"".$_POST['fonction']."\" value = \"".$_POST['fonction']."\">
	</td></tr>
	<tr><td>
	Date naissance</td><td> <input type = \"text \" name = \"date_naissance\" readonly>
	</td></tr>
	<tr><td>
	Adresse</td><td> <input type = \"text\" name = \"adresse\" readonly>
	</td></tr>
	<tr><td>";
	if ($_POST['fonction'] == "medecin"){
	}
	else if ($_POST['fonction'] == "personnel_labo"){
	echo "Section d'affectation</td><td> <select size = \"1\" name = \"section_affectation\" readonly value = \"".$_POST['section_affectation']."\">";
	$req = "Select idService,nomService from Service";
	$sql = $bdd->query($req);
	while ($data = $sql->fetch()){
		echo "<option value = \"".$data["nomService"]."\">.".$data['nomService'].".</option>";
	}
	echo "</select>
	</td></tr><td>";
	}
	else if ($_POST['fonction'] == "secrétaire"){
			echo "Section d'affectation</td><td> <select size = \"1\" name = \"section_affectation\" readonly value = \"".$_POST['section_affectation']."\">
		<?php?>
		</select>
		</td></tr><td>";
	}
	
	else if ($_POST['fonction'] == "infirmier"){
			echo "Section d'affectation</td><td> <select size = \"1\" name = \"section_affectation\" readonly value = \"".$_POST['section_affectation']."\">
		<?php?>
		</select>
		</td></tr><td>";
	}
	
	echo "<td></td><input type = \"submit\" value = \"ajouter\" name = \"ajouterPersonnel\" readonly>
	</td>
	</tr>
</table>";
}?>

<script>
  $("#text").focus(function(){
  $(this).blur(); 
  });
</script>
</body>
</html>
