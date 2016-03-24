<?php

class Article {
    public $file_name; 
    public $month; 
    
    public function __construct($file_name, $month) {
        $this->file_name = $file_name; 
        $this->month = $month; 
    }
}
    
?>