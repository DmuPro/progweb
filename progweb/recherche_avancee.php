 <!DOCTYPE html>
<html lang="fr">

<head>
    <title>
        Page d'accueil
    </title>
    <link rel="stylesheet" type="text/css" href="CSS/MEF.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#tabs").tabs();
        });
    </script>

    <meta charset="utf-8" />
</head>

<body>
    <header>
        Trouvez votre diplome !
    </header>
    <nav>
        <ul>
            <li>
                <a href="index.php">Home</a>
            </li>
        </ul>
    </nav>
   <div id="recherche">
        <p>
            Recherche
        </p>
        <form action="recherche_avancee.php" method = "post" >
            <input type="text" placeholder="..." size="40" id="recherchetext" name = "recherche"/>
            <input type="submit" value="recherche">
            <br/>
            <a href="#" id="liencachee"> recherche avanc&eacute;e</a>
            <div id = "jsrecherche">
                <div id="formulaireRechercheA">
					
                    Département
                    <select name="departement" size="1">
                        <option>- - -</option>

                        <?php
    $url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=0&sort=-rentree_lib&facet=dep_etab_lib&refine.rentree_lib=2017-18";
    $string = file_get_contents($url);
    $json = json_decode($string,true); 
    $facets = $json["facet_groups"][0]["facets"]; 
    foreach ($facets as $facet) {
        echo "<option value = \"".$facet['path']."\">".$facet['path']."</option>";
    }
    ?>

                    </select>

                    Diplome
                    <select name="diplome" size="1">
                        <option>- - -</option>
                        <?php
    $url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=0&sort=-rentree_lib&facet=diplome_lib&refine.rentree_lib=2017-18";
    $string = file_get_contents($url);
    $json = json_decode($string,true);
    $facets = $json["facet_groups"][0]["facets"];
    foreach ($facets as $facet) {
        echo "<option value = \"".$facet['path']."\">".$facet['path']."</option>";
    }
    ?>
                    </select>
                    Discipline
                    <select name="discipline" size="1">
                        <option>- - -</option>
                                              <?php
    $url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=0&facet=sect_disciplinaire_lib";
    $string = file_get_contents($url);
    $json = json_decode($string,true);
    $facets = $json["facet_groups"][0]["facets"];
    foreach ($facets as $facet) {
        echo "<option value = \"".$facet['path']."\">".$facet['path']."</option>";
    }
    ?>
                    </select>
                </div>
                <div id="boutonFormulaire">
                    <input type="reset">
                </div>
                </div>
            </form>
    </div>
      <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Vos recherches</a></li>
            <li><a href="#tabs-2">Carte des Universités</a></li>
        </ul>
        	<div id = "tabs-1">
    <?php 
    $recherche = strtolower($_POST['recherche']);
    $url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&facet=etablissement_lib";
    $url = $url."&refine.etablissement_lib=".$_POST['recherche'];
    if (isset($_POST['departement']) && ($_POST['departement'] != "- - -")){ //concatène le lien pour rechercher selon le département
		$url = $url."&refine.dep_etab_lib=".$_POST['departement'];
	}
	if (isset($_POST['diplome']) && ($_POST['diplome'] != "- - -")){
		$url = $url."&refine.diplome_lib=".$_POST['diplome'];
	}
	if (isset($_POST['discipline']) && ($_POST['discipline'] != "- - -")){
		$url = $url."&refine.sect_disciplinaire_lib=".$_POST['discipline'];
	}
    $string = file_get_contents($url);
    $json = json_decode($string,true);
    $records = $json["facet_groups"];
    foreach ($records as $record){
		if ($record['name'] == "etablissement_lib"){
			$records = $record['facets'];
		}
	}
    if ($records != NULL){
    echo "<table>";
    echo "<tr><th>Résultats des recherches</th></tr>";
    foreach($records as $record){
        $etablissement = strtolower($record['path']); //Fait la comparaison des string en miniscule pour éviter la casse
        echo "<tr><td>";
        echo $record['path'];
        echo "</td></tr>";
        }
    echo "</table>";
    }
    else{
        echo "<h3>Aucun résultat</h3>";
    }
      ?>
    </div>
        <div id="tabs-2">
            <div id="mapid">
            </div>
        </div>
      </div>
    <script>
        var mymap = L.map('mapid').setView([46.227638,2.213749], 6);
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
        }).addTo(mymap);
     <?php 
     $secondURL = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-etablissements-enseignement-superieur&rows=323&sort=uo_lib";
     $string2 = file_get_contents($secondURL);
     $json2 = json_decode($string2,true);
     $records2 = $json2["records"];
     foreach($records as $record){ 
		 foreach($records2 as $record2){
			 $etablissement2 = strtolower($record2['fields']['uo_lib']);
             exit(strtolower($record['path']) ."==".$etablissement2 ." && ". (strpos($etablissement2,$recherche)) . "--" . $recherche);
			 if (strtolower($record['path']) == $etablissement2 && (strpos($etablissement2,$recherche) !== false)){
				 $tab = $record2['fields']['coordonnees'];
				 echo "var marker = L.marker([".$tab[0].",".$tab[1]."]).addTo(mymap);";
				 echo "marker.bindPopup(\"<b>".$record2['fields']['uo_lib']."</b></br>"."<a href=\\\"".$record2['fields']['url']."\\\">Lien vers le site de l'établissement</a>"."\").openPopup();"; 
			 }
		 }
	 }
     
     
     ?>
    </script>
        

        <div id ="footer">Mu Davy</div>
</body>
</html>
