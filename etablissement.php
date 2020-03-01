<?php
class Etablissement{
    private $name;
    private $dep;
    private $discipline;
    private $cord;
    private $link;
    public $clic;
    
    function __construct() {
        $discipline = array();
        $cord = new SplFixedArray(2);
	$this->clic = 0;
    }
    public function setName($name){
        $this->name = $name;
    }
    
    public function setDepartement($dep){
        if (!empty($dep) || $dep != ""){
        $this->dep = $dep;
        }
    }
    public function setClic($clic){
	$this->clic = $clic;
}

    
    public function setDiscipline($discipline){
        $this->discipline[] = $discipline;
    }
    
    public function setCord($cord1,$cord2){
        $this->cord[0] = $cord1;
        $this->cord[1] = $cord2;
    }
    
    public function setLink($link){
        if (!empty($link)||$link != ""){
            $this->link = $link;
        }
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function getDiscipline(){
return $this->discipline;
    }
    public function getDepartement(){
        return $this->dep;
    }
    
    public function getCord(){
        return $this->cord;
    }
    public function getLink(){
        return $this->link;
    }
    
    
    
    
    
    
}
?>
