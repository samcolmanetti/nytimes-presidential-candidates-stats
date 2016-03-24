# NY Times President Candidate Mentions
This application searches through every article posted in 2015 and records the number of times a presidential candidate's name was mentioned. The results are recorded in a .csv file where you can see a candidate's popularity by month. 

I made this as a school project to show one of the many applications of regular expressions. 

## Run instructions

Simply execute the run.php file. 

`` php run.php ``

Make sure the file has execute permissions

`` chmod 0600 run.php ``

## High level overview of process

1.) Download the article index files (if not already downloaded)
2.) Parse each index file and filter out the articles related to politics(articles with politcs, government, or opinion in the URL) 
3.) Download all articles to the /articles folder
4.) Go through each article and tally up the number of times a presidential candidate's name was mentioned
5.) Output to csv file

## Next Steps

1.) Improve the regular expression that looks for candidates names
  - Right now it searches through the entire html file and names in metadata are picked up
    - Need to search through paragraph tags only
  - The regex for names is simply a candidates first name followed by their last name
    - This does not pick up instances when a candidate is referred to by just their last name or when they have a title (i.e. "Mr.Trump" will not get picked up)
    
2.) Fix bug regarding the month of november
  - For some reason the number of mentions drops dramatically for the entire month of november for all candidates

3.) Adjust algorithm to support other years

