<?php

    $baseUrl = "http://spiderbites.nytimes.com/free_2015/"; 
    $parts = array (6,6,6,6,6,6,6,6,7,7,2,6); 
    
    echo "********************** Starting Download **********************\n"; 
    for ($month = 1; $month <= 12; $month++) {
        $monthStr = str_pad($month, 2, "0", STR_PAD_LEFT);
        for ($part = 0; $part < $parts[$month-1]; $part++){
            $article = "articles_2015_" . $monthStr . "_0000" . $part . ".html"; 
            if (!file_exists("./article_index/$article")){
                copy ($baseUrl . $article, "./article_index/$article");
                echo "Article: $article downloaded successfully...\n";
            } else {
                echo "Article: $article already downloaded...\n";
            }
            
        }
    }
    echo "********************** Download Complete **********************\n"; 
    
?>