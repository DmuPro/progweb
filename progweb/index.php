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
 <?php include("filtre.php");?>
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

