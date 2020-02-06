<?php
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
    
    public function decode(){
        $string = file_get_contents($this->url);
        $json = json_decode($string,true);
        return $json;
    }
    
    public function getResult($result,$dept,$discipline,$diplome){
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
        echo $this->url;
        var_dump($json);
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
            if (strpos(strtolower($record['path']),$recherche)!== false || (filter == true && strpos(strtolower($record['path']),$recherche))){
                
            $etablissement = strtolower($record['path']); //Fait la comparaison des string en miniscule pour éviter la casse
            echo "<tr><td>";
            echo $record['path'];
            array_push($array,$record['path']);
            echo "</td></tr>";
        }
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
    
    
}
