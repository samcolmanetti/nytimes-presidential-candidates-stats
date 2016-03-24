<?php 

function downloadArticleIndexes (){
    $baseUrl = "http://spiderbites.nytimes.com/free_2015/"; 
    $parts = array (6,6,6,6,6,6,6,6,7,7,2,6); 
    
    echo "********************** Starting Download of Indexes **********************\n"; 
    for ($month = 1; $month <= 12; $month++) {
        $monthStr = str_pad($month, 2, "0", STR_PAD_LEFT);
        for ($part = 0; $part < $parts[$month-1]; $part++){
            $article = "articles_2015_" . $monthStr . "_0000" . $part . ".html"; 
            if (!file_exists("./article_index/$article")){
                copy ($baseUrl . $article, "./article_index/$article");
                echo "Article: $article downloaded successfully...\n";
            } else {
               // echo "Article: $article already downloaded...\n";
            }
            
        }
    }

    echo "**********************    Index Download Complete ************************\n";
}

function getCandidates () {
    $file_contents = file ("./candidates.txt"); 
    $candidates = array(); 

    foreach ($file_contents as $line){
        array_push($candidates, new Candidate($line));
    }
    
    return $candidates; 
}

function getArticleMonth ($file_name) {
    $regex = "articles_\d+_(\d{2})_\d+";
    if (preg_match_all("/$regex/siU", $file_name, $matches, PREG_SET_ORDER)){
        return intval($matches[0][1]); 
    } else {
        return -1; 
    }
}

function getArticles() {
    $regexp = "<a\s[^>]*href=(\"??)(http:\/\/www\.nytimes\.com\/[\w\d\/-]*(politics|government|opinion)[^\" >]*?)\\1[^>]*>(.*)<\/a>";
    
    $allFiles = scandir("./article_index");
    $files = array_diff($allFiles, array('.', '..'));
    $articles  = array(); 
    
    echo "\n********************** Starting Download of Articles **********************\n";
    
    foreach ($files as $file) {
        $file_contents = file_get_contents("./article_index/" . $file); 
        $month = getArticleMonth($file); 
        
        if(preg_match_all("/$regexp/siU", $file_contents, $matches, PREG_SET_ORDER)) {
          foreach($matches as $match) {
              $url = $match[2]; 
              $file_name = pathinfo($url)['filename'] . ".html";
              
              /*
              if (!file_exists("./articles/$file_name")) {
                  //copy ($url, "./articles/$file_name");
                  $data = downloadNYTArticle($url); 
                  file_put_contents ("./articles/$file_name", $data); 
                  echo "Article: $file_name downloaded successfully...\n";
                 // echo '<br/>';
              } else {
                  //echo "Article: $file_name already downloaded...\n";  
              } */ 
              
              
             array_push($articles, new Article($file_name, $month)); 
          }
        }
    }
    echo "**********************   Articles Download Complete ***********************\n";
    
    return $articles; 
}

function downloadNYTArticle ($url) {
    $_curl = curl_init();
    curl_setopt($_curl, CURLOPT_SSL_VERIFYHOST, 1);
    curl_setopt($_curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($_curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($_curl, CURLOPT_COOKIEFILE, './cookies/cookie');
    curl_setopt($_curl, CURLOPT_COOKIEJAR, './cookies/cookie');
    curl_setopt($_curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; InfoPath.1)');
    curl_setopt($_curl, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($_curl, CURLOPT_URL, $url);
    $rtn = curl_exec( $_curl );
    
    return $rtn; 
}

function getArticleContents ($file_name){
    if (file_exists("./articles/$file_name")) {
        return file_get_contents("./articles/$file_name");    
    } else {
        return null; 
    }
}

function writeDataTable ($path, $candidates) {
    $file = ",January,February,March,April,May,June,July,August,September,October,November,December,Total\n";
    
    foreach ($candidates as $c){
        $file .= "$c->firstName $c->lastName,";
        
        for ($i = 1; $i <= 12; $i++){
            $file .= $c->hits[$i] . ","; 
        }
        
        $file .= $c->getTotalHits() . "\n"; 
    }
    
    file_put_contents($path, $file); 
}

?>