<?php
class Etablissement{
    private $name;
    private $dep;
    private $discipline;
    private $cord;
    private $link;
    
    function __construct() {
        $discipline = array();
        $cord = new SplFixedArray(2);
    }
    public function setName($name){
        $this->name = $name;
    }
    
    public function setDepartement($dep){
        $this->dep = $dep;
    }
    
    public function setDiscipline($discipline){
        $this->discipline[] = $discipline;
    }
    
    public function setCord($cord1,$cord2){
        $this->cord[0] = $cord1;
        $this->cord[1] = $cord2;
        echo $cord1;
    }
    
    public function setLink($link){
        $this->link = $link;
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function getDiscipline(){
        foreach($this->discipline as $discipline){
            echo $discipline;
        }
    }
    public function getDepartement(){
        return $this->dep;
    }
    
    public function getCord(){
        foreach($this->cord as $cord){
            echo $cord."<br>";
        }
    }
    
    
    
    
    
    
}
?>
