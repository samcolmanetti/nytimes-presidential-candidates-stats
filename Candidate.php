<?php

class Candidate {
    
    public $firstName; 
    public $lastName; 
    public $party; 
    public $hits;
    public $regex; 
    
    public function __construct($line) {
        $regex = "(\w+)\s+([\w\']+)\s+\((R|D)\)";
        
        if(preg_match_all("/$regex/siU", $line, $matches, PREG_SET_ORDER)) {
            foreach($matches as $match){
                $this->firstName = $match[1];  
                $this->lastName = $match[2]; 
                $this->party = $match[3]; 
            }
        }
        
        $this->regex = "$this->firstName\s$this->lastName"; 
        
        //$hits = array("01"=>0, "02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,
        //        "08"=>0,"09"=>0,"10"=>0,"11"=>0,"12"=>0,);
        $this->hits = array(0,0,0,0,0,0,0,0,0,0,0,0); 
    }
    
    public function getTotalHits (){
        $sum = 0; 
        
        foreach ($this->hits as $count){
            $sum += $count; 
        }
        
        return $sum; 
    }
    
    public function increment ($month, $count){
        if (isset($this->hits[$month])){
            $this->hits[$month] += $count;    
        } else {
            $this->hits[$month] = $count; 
        }
    }
    
}

?>