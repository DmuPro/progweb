<?php
require_once("etablissement.php");
class api{
    private $url;
    private $filter = false;
    private $json;
    public function __construct($urlparameters){
        $this -> url = $urlparameters;
    }
    
    public function jsonOpenFacet($url,$index){
        $string = file_get_contents($url);
        $json = json_decode($string,true);
        $facets = $json["facet_groups"][$index]["facets"];
        return $facets;
    }
    public function printurl(){
        echo $this->url;
    }
    
    public function decode($url){
        $string = file_get_contents($url);
        $json = json_decode($string,true);
        return $json;
    }
    
    public function getResult($array){
        if ($array != null){
        echo "<table>";
        echo "<tr><th>Résultats des recherches</th></tr>";
            foreach($array as $record){
                echo "<tr><td>";
                echo $record->getName();
                echo "</td></tr>";
            }
        echo "</table>";
        }
        else{
            echo "<h3>Aucun résultat</h3>";
            }
        return $array;
    }
    
    
    public function filter(){
        return $this->filter;
    }
    
    public function createMarker(){
        
    }
    
    public function compareStr($string,$value){
        if ($string == "" || empty($string)){
            return true;
        }
        return strpos($string,$value) !== false;
    }
    
    public function initializeEtablissement($result,$dept,$discipline,$diplome){
        $array = [];
        $recherche = strtolower($result);
        if ($dept != "- - -"){ //concatène le lien pour rechercher selon le département
            $this->url = $this->url."&refine.dep_etab_lib=".$dept;
            $this->filter = true;
        }
        if ($discipline != "- - -"){
            $this->url = $this->url."&refine.diplome_lib=".$discipline;
            $this->filter = true;
        }
        if ($diplome != "- - -"){
            $this->url = $this->url."&refine.sect_disciplinaire_lib=".$diplome;
            $this->filter = true;
        }
        $string = file_get_contents($this->url);
        $json = json_decode($string,true);
        $records = $json["facet_groups"];
        foreach ($records as $record){
            if ($record['name'] == "etablissement_lib"){
                $records = $record['facets'];
            }
        }
        $string = file_get_contents($this->url);
        $json = json_decode($string,true);
        $records = $json["facet_groups"];
        foreach ($records as $record){
            if ($record['name'] == "etablissement_lib"){
                $records = $record['facets'];
            }
        }
        foreach($records as $record){
        if (strpos(strtolower($record['path']),$recherche)!== false || ($this->filter == true && $this->compareStr($recherche,$record['path']))){
            $etablissement = strtolower($record['path']); //Fait la comparaison des string en miniscule pour éviter la casse
            $etab = new Etablissement();
            $etab->setName($record['path']);
            array_push($array,$etab);
            }
        }
        return $array;
    }
    
    public function initializeEtablissementDetails($array){
        foreach ($array as $etab){
            $newurl = $this->url."&etablissement_lib=".$etab->getName();
            $json = $this->decode($newurl);
            $records = $json['records'];
            foreach($records as $record){
                $etab->setDiscipline($record['fields']['sect_disciplinaire_lib']);
                $etab->setDepartement($record['fields']['dep_etab_lib']);
            }
            
        }
    }
    
    public function initializeEtablissementCord($url,$array){
        var_dump($array);
        foreach($array as $record){
            $newurl = $url."&uo_lib=".$etab->getName();
            $json = $this->decode($newurl);
            $records2 = $json["records"];
            foreach($records2 as $record2){
                    $tab = $record2['fields']['coordonnees'];
                    $record->setCord($tab[0],$tab[1]);
                    echo "var marker = L.marker([".$tab[0].",".$tab[1]."]).addTo(mymap);";
                    echo "marker.bindPopup(\"<b>".$record2['fields']['uo_lib']."</b></br>"."<a href=\\\"".$record2['fields']['url']."\\\">Lien vers le site de l'établissement</a>"."\").openPopup();";
		 }
         echo $record->getCord();
	 }
        echo $url;
    }
}
