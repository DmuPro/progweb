<!DOCTYPE html>
<html lang="fr">
<?php require_once("etablissement.php");?>
<?php include("api.php");?>
<?php 
$api = new api("https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&facet=etablissement_lib&apikey=4b0b2503c3079e2d20a289f53ddbc2a50657de858963f0efff07d195");
$api2 = new api("https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-etablissements-enseignement-superieur&rows=323&sort=uo_lib&apikey=4b0b2503c3079e2d20a289f53ddbc2a50657de858963f0efff07d195");
$array_etab = $api->initializeEtablissement($_POST['recherche'],$_POST['departement'],$_POST['discipline'],$_POST['diplome']);
$newarray = $api->initializeEtablissementDetails($array_etab);
$newarray = $api->initializeEtablissementCord("https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-etablissements-enseignement-superieur&rows=323&sort=uo_lib&apikey=4b0b2503c3079e2d20a289f53ddbc2a50657de858963f0efff07d195",$newarray);
?>


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
<?php include("filtre.php");?>
      <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Vos recherches</a></li>
            <li><a href="#tabs-2">Carte des Universités</a></li>
        </ul>
        	<div id = "tabs-1">
    <?php
    $array = $api->getResult($array_etab);
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
     $secondURL = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-etablissements-enseignement-superieur&rows=323&sort=uo_lib&apikey=4b0b2503c3079e2d20a289f53ddbc2a50657de858963f0efff07d195";
     $string2 = file_get_contents($secondURL);
     $json2 = json_decode($string2,true);
     $records2 = $json2["records"];
     foreach($array as $record){ 
		 foreach($records2 as $record2){
			 $etablissement2 = strtolower($record2['fields']['uo_lib']);
			 if (strtolower($record) == $etablissement2){
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
