Mozilla Bangladesh
==================

This repository holds the source code of www.mozillabd.org. The theme was forked from Mozilla India's repo, which was originally based on Mozillla's Sandstone theme.

Contributing
============

HowTo
-----

Fork -> Hack ->  Send pull request0


Mozilla Bangladesh MLS Contributors
===================================
Here is two variations for the same funtionality. The mls.php and mls2.php does a very same work but in two slighly different ways. 
* mls.php need a acheduled cron, in this way users get the page fast loaded but the data are updated having a time interval
* mls2.php scrapes the data from main leaderboard every times a user loads the page, as it scrapes data from two different pages, it creates huge loadtime

This Mozilla Bangladesh MLS Contributors shows the poits earned by Mozilla Bangladesh MLS Contributors in one place. This script can be used for any community.

How The Script Works
--------------------
We have a survey campaign form for our local conributors which collects info about our local MLS contributors. The form response stored in a google doc (spreadsheet). It has a column having the nick of our contributors. So, names.php reads the data on the spreadsheet and store the nicks on names.json. This part of code is collected from another author. Here for security we have kept the key hidden. You can get the idea of this script or what is the key from the main author\s documentation here: https://github.com/VernierSoftwareTechnology/google-spreadsheet-to-php-array
A special thanks to them.

After that the scores.php file collect the data for those nicks from main leaderboard page and then again stores them in scores.json file. After that mls.php file shows those data.

mls2.php doesn't stores data in any JSON file and loads every time anu user requests the page.

