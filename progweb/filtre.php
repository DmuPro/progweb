  <?php include("fonction.php");?>
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
    $url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=0&sort=-rentree_lib&facet=dep_etab_lib&refine.rentree_lib=2017-18&apikey=4b0b2503c3079e2d20a289f53ddbc2a50657de858963f0efff07d195";
    $facets = jsonOpenFacets($url,0);
    foreach ($facets as $facet) {
        echo "<option value = \"".$facet['path']."\">".$facet['path']."</option>";
    }
    ?>

                    </select>

                    Diplome
                    <select name="diplome" size="1">
                        <option>- - -</option>
                        <?php
    $url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=0&sort=-rentree_lib&facet=diplome_lib&refine.rentree_lib=2017-18&apikey=4b0b2503c3079e2d20a289f53ddbc2a50657de858963f0efff07d195";
    $facets = jsonOpenFacets($url,0);
    foreach ($facets as $facet) {
        echo "<option value = \"".$facet['path']."\">".$facet['path']."</option>";
    }
    ?>
                    </select>
                    Discipline
                    <select name="discipline" size="1">
                        <option>- - -</option>
                                              <?php
    $url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=0&facet=sect_disciplinaire_lib&apikey=4b0b2503c3079e2d20a289f53ddbc2a50657de858963f0efff07d195";
    $string = file_get_contents($url);
    $json = json_decode($string,true);
    $facets = $json["facet_groups"][0]["facets"];
    foreach ($facets as $facet) {
        echo "<option value = \"".$facet['path']."\">".$facet['path']."</option>";
    }
    if ($facets == NULL){
        echo "<script>
    alert(\"ERREUR API\");
    </script>";
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
