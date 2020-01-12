 <!DOCTYPE html>
<html lang="fr">

<head >
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
	<!-- L'en-tête  -->
    <header>
        Trouver votre diplome !
    </header>
    <nav>
        <ul>
            <li>
                <a href="#home">Home</a>
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
         
            <a href="#" id="liencachee"> recherche avanc&eacute;e</a> <!--L'id lien cachée va nous permettre de pouvoir créer un texte qui cache/montre le texte grâce à un script-->
            <div id = "jsrecherche"> <!--L'id jsrecherche va nous permettre de pouvoir créer un texte qui cache/montre le texte grâce à un script-->
                <div id="formulaireRechercheA">
					
                    Département
                    <select name="departement" size="1">
                        <option>- - -</option>

                        <?php
    $url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=0&sort=-rentree_lib&facet=dep_etab_lib&refine.rentree_lib=2017-18";
    $string = file_get_contents($url); //On obtient le contenu du fichier grâce à l'url
    $json = json_decode($string,true); //En utlisant la fonction json_decode() nous obtenons un tableau
    $facets = $json["facet_groups"][0]["facets"]; // Navigation dans le tableau
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
            <li><a href="#tabs-1">Carte des Universités</a></li>
        </ul>
        <div id="tabs-1">
            <div id="mapid">
            </div>
        </div>
    </div>
    <script><!--Script permettant d'afficher la carte MapBox -->
        var mymap = L.map('mapid').setView([46.227638,2.213749], 6);
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
        }).addTo(mymap);
    </script>
    <script><!--Script permettant de cacher tout ce qui est contenu dans la div jsrecherche en cliquant sur un lien -->
    $("#jsrecherche").hide();
    $("#liencachee").click(function() {
        $("#jsrecherche").toggle();
    });
</script>
    <div id ="footer">Mu Davy</div>
</body>

</html>

