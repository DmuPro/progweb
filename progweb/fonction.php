<?php function jsonOpenFacets($url,$index){
    $string = file_get_contents($url);
    $json = json_decode($string,true);

    $facets = $json["facet_groups"][$index]["facets"];
    return $facets;
}?>

