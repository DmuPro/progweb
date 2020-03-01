<?php
require_once("etablissement.php");
class api{
    private $url;
    private $filter = false;
    private $json;
    public function __construct($urlparameters){
        $this -> url = $urlparameters;
    }
    
    function jsonOpenFacet($url,$index){
        $string = file_get_contents($url);
        $json = json_decode($string,true);
        $facets = $json["facet_groups"][$index]["facets"];
        return $facets;
    }
    function printurl(){
        echo $this->url;
        
    }
    
    function decode($url){
        $string = file_get_contents($url);
        $json = json_decode($string,true);
        return $json;
    }
    
    function getResult($array){
        if ($array != null){
	usort($array,function($first,$second){
   	 return $first->clic < $second->clic;
	});
        echo "<table>";
        echo "<tr><th>Résultats des recherches</th></tr>";
            foreach($array as $record){
		$schoolname = $record->getName();
		$poplink = "popup('".$record->getName()."','".$record->getDepartement()."','".$record->getLink()."','".$record->getName()."')";
                echo "<tr><td>";
		echo "Vues - ".$record->clic." ";         
                echo $schoolname;
		echo "</td><td>";
                echo "<a href = \"#\" onclick = \"".$poplink."\">";
                echo "En savoir plus sur l'établissement</a>"; 
                echo "</td></tr>";
            }
        echo "</table>";
        }
        else{
            echo "<h3>Aucun résultat</h3>";
            }
        return $array;
    }
    
    
    function filter(){
        return $this->filter;
    }
    
    function createMarker($array){
        foreach($array as $etab){
            if ($etab->getCord()!=null){
                $tab = $etab->getCord();
                echo "var marker = L.marker([".$tab[0].",".$tab[1]."]).addTo(mymap);";
                echo "marker.bindPopup(\"<b>".$etab->getName()."</b></br>"."<a href=\\\"".$etab->getLink()."\\\">Lien vers le site de l'établissement</a>"."\").openPopup();";      
            }
         }
    }
    
    function compareStr($string,$value){
        if ($string == "" || empty($string)){
            return true;
        }
        return strpos($string,$value) !== false;
    }
    
    function initializeEtablissement($result,$dept,$discipline,$diplome){
	require_once("connexion.php");
        $array = [];
        $recherche = strtolower($result);
        if ($dept != "- - -"){ //concatène le lien pour rechercher selon le département
            $this->url = $this->url."&refine.dep_etab_lib=".$dept;
            $this->filter = true;
        }
        if ($discipline != "- - -"){
            $this->url = $this->url."&refine.sect_disciplinaire_lib=".$discipline;
            $this->filter = true;
        }
        if ($diplome != "- - -"){
            $this->url = $this->url."&refine.diplome_lib=".$diplome;
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
		$req = "Select * FROM Clic WHERE `nomEtab` ='".$record['path']."'";
		$sql = $bdd->query($req);
		$data = $sql->fetch();
		if (!empty($data)){
			$etab->setClic($data['compteurEtab']);
		}
		
	array_push($array,$etab);
	}
    }
	  return $array;
}
    
    function initializeEtablissementDetails($array){
        foreach ($array as $etab){
            $newurl = $this->url."&refine.etablissement_lib=".$etab->getName();
            $json = $this->decode($newurl);
            $records = $json['records'];
            foreach($records as $record){
                $etab->setDiscipline($record['fields']['sect_disciplinaire_lib']);
                $etab->setDepartement($record['fields']['dep_etab_lib']);
            }
            
        }
    }
    
    function initializeEtablissementCord($url,$array){
        foreach($array as $record){
            $newurl = $url."&refine.uo_lib=".$record->getName();
            $json = $this->decode($newurl);
            $records2 = $json["records"];
            foreach($records2 as $record2){
                    $tab = $record2['fields']['coordonnees'];
                    $record->setCord($tab[0],$tab[1]);
                    $record->setLink($record2['fields']['url']);
		 }
	 }
     
     
    }
}

?>
<script>
function popup(nomEtab,depEtab,lien,discipline) {
  w=open("",'popup','width=400,height=200,toolbar=no,scrollbars=no,resizable=yes');
  w.document.write("<html><head><title>");
  w.document.write("Fiche de l'établissement");
  w.document.write("</title>");
  w.document.write("<link rel=\"stylesheet\" type=\"text/css\" href=\"CSS/MEF.css\"></head>");	
  w.document.write("<body><p>Nom établissement:"+nomEtab+"</p>");
  w.document.write("<p>Département de l'établissement:"+depEtab+"</p>");
  w.document.write("<form action = 'etablissementredirect.php' method = 'post'>");
  w.document.write("<input type = 'hidden' name = nomEtab value = '"+nomEtab+"'>");
  w.document.write("<p><input type = 'submit' name = 'submit' value = '"+lien+"' class = 'submitLink'></p>");
  w.document.write("</form>");
  w.document.write("</body></html>");
  w.focus();
  w.document.close();
}
</script>
