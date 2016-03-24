<?php

  require_once('Candidate.php');
  require_once('Article.php');
  require_once('functions.php');
  
  downloadArticleIndexes(); 
  
  $candidates = getCandidates(); 
  $articles = getArticles();
  
  echo "Number of articles: " . count($articles). "\n"; 
  
  
  foreach ($articles as $article) {
    echo "Processing data for $article->file_name\n";
    $html = getArticleContents($article->file_name); 
    
    foreach ($candidates as $candidate){
      if (preg_match_all("/$candidate->regex/siU", $html, $matches, PREG_SET_ORDER)) {
         echo count($matches) . " hits for $candidate->lastName\n";
         $candidate->increment($article->month, count($matches)); 
      }
    }
  }
  
  echo "Number of articles: " . count($articles). "\n"; 
  writeDataTable("stats2.csv", $candidates);
  
?>