<?php function jsonOpenFacets($url,$index){
    $string = file_get_contents($url);
    echo $string.$url;
    $json = json_decode($string,true);
    var_dump($json);
    $facets = $json["facet_groups"][$index]["facets"];
    return $facets;
}?>

