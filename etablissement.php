<?php
class Etablissement{
    private $name;
    private $dep;
    private $discipline;
    private $cord;
    private $link;
    
    public function setName($name){
        $this->name = $name;
    }
    
    public function setDepartement($dep){
        $this->dep = $dep;
    }
    
    public function setDiscipline($discipline){
        $this->discipline = $discipline;
    }
    
    public function setCord($cord){
        $this->cord = $cord;
    }
    
    public function setLink($link){
        $this->link = $link;
    }
}
?>
