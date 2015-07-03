<!doctype html>
<html class="windows no-js" lang="en-US" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MLS BD - Leaderboard</title>
        <link rel="stylesheet" media="screen,projection,tv" href="css/styles.css" />
        <link href="css/jquery.bxslider.css" rel="stylesheet" />
        <!--[if lte IE 8]>
        <script src="js/libs/html5shiv.js"></script>
        <![endif]-->
        <link rel="shortcut icon" href="img/favicon.ico">
        <meta name="description" content="Mozilla Bangladesh is part of the global community of Mozilla Foundation, founded to manifest the state of Mozilla community in Bangladesh. মোজিলা বাংলাদেশ হল মোজিলা ফাউন্ডেশনের গ্লোবাল কমিউনিটির একটি অংশ, যা বাংলাদেশের মোজিলা কমিউনিটিকে একত্রিত করেছে।">        
        <meta name="keywords" content="mozilla, mozillabd, firefox, bangladesh, open source, community, l10n, open, foss, floss, software, mozillabangladesh, mozbd, মোজিলা, বাংলাদেশ, ফায়ারফক্স, ওপেনসোর্স, কমিউনিটি">
        <meta property="og:site_name" content="Mozilla Bangladesh">
        <meta property="og:url" content="http://mozillabd.org/">
        <meta property="og:title" content="Mozilla Bangladesh Location Service Contributors">
        <meta property="og:type" content="website">

        <link rel="canonical" href="http://mozillabd.org/">
        <link rel="shortlink" href="http://mozillabd.org/">

        <script src="js/libs/jquery-2.0.3.min.js"></script>
        <script src="js/libs/modernizr.custom.26887.js"></script>
        <script src="js/base/site.js"></script>
        <script src="js/libs/jquery.bxslider.min.js"></script>
        <script src="js/base/site.js"></script>
        <script>
         $(document).ready(function () {
             $('.bxslider').bxSlider({maxSlides:1, auto: true});
         });
        </script>
    </head>

    <body id="home" class="html-ltr stone">
        <div id="strings"   data-close='Close'
             data-share='Share'
             ></div>
        <div id="outer-wrapper" class="mls">
            <div id="wrapper">

                <header id="masthead">
                    <a href="http://www.mozilla.org/" id="tabzilla">Mozilla</a>

                    <nav id="nav-main" role="navigation">
                        <span class="toggle" role="button" aria-controls="nav-main-menu" tabindex="0">Menu</span>
                        <ul id="nav-main-menu">
                            <li class="first"><a href="http://www.mozilla.org/about/">About</a></li>
                            <li><a href="http://www.mozilla.org/mission/">Mission</a></li>
                            <li><a href="http://mozillabd.org/blog/category/events/">Events</a></li>
							<li><a href="http://mozillabd.org/blog/category/events/">Event Blogs</a></li>
							<li><a href="http://mozillabd.org/mls/">MLS BD</a></li>
                            <li class="last"><a href="http://mozillabd.org/blog/">Blog</a></li>
                        </ul>
                    </nav>
                </header>

                <hgroup id="main-feature" class="small">
                    <h1><img src="img/home/title-wordmark.png" alt="Mozilla" height="30" width="110"> Bangladesh</h1>
                </hgroup>

                <div id="main-content">
					<h2>MLS Leaderboard - Bangladesh</h2>
				
					 <p>
						This leaderboard shows the contributions of individual community
						members of Mozilla Bangladesh, who are using one of the
						<a target="_blank" href="https://location.services.mozilla.com/apps">client applications</a> 
						and contribute back data to us - we call this activity stumbling. Joining this 
						competition is optional and you can contribute data anonymously. You only show
						up on the leaderboard if you have collected at least ten reports.
					</p>
					<p>
						We have tried to include all the Mozilla Bangladesh MLS contributors 
						in the following list. If you think your name should also be in this list, 
						please participate in the <a target="_blank" href="http://blog.mozillabd.org/2015/03/survey-mls-contributor-bangladesh-2/">"Survey 
						for MLS contributor in Bangladesh"</a> to get your name listed here. 
						Happy Contributing.
					</p>
					<br/>
					<section id="mls-users-left">
						<table class="table">
							<thead>
								<tr>
									<th>SL.</th>
									<th>Rank</th>
									<th>User</th>
									<th class="text-right">Points</th>
								</tr>
							</thead>
							<tbody>
								<?php
									// initialize Google Sheet URL
									$key = '***************************';
									$url = 'http://spreadsheets.google.com/feeds/cells/' . $key . '/1/public/values';
									// initialize curl
									$curl = curl_init();
									// set curl options
									curl_setopt($curl, CURLOPT_URL, $url);
									curl_setopt($curl, CURLOPT_HEADER, 0);
									curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
									// get the spreadsheet using curl
									$google_sheet = curl_exec($curl);
									// close the curl connection
									curl_close($curl);
									// import the xml file into a SimpleXML object
									$feed = new SimpleXMLElement($google_sheet);
									// get every entry (cell) from the xml object
									// extract the column and row from the cell's title
									// e.g. A1 becomes [1][A]
									$array = array();
									foreach ($feed->entry as $entry) {
										$location = (string) $entry->title;
										preg_match('/(?P<column>[A-Z]+)(?P<row>[0-9]+)/', $location, $matches);
										$array[$matches['row']][$matches['column']] = (string) $entry->content;
									}
									for($i = 2, $j = 0; $i < count($array); $i++){
											//avoiding null inputs
											if(trim($array[$i]['U']) != null){
												//creating the nick list
												$names[$j] = trim($array[$i]['U']);
												$j++;
											}
									}
									//implementing DOMXPath
									$html = file_get_contents('https://location.services.mozilla.com/leaders');
									$pokemon_doc = new DOMDocument();
									libxml_use_internal_errors(TRUE);
									if(!empty($html)){
										$pokemon_doc->loadHTML($html);
										libxml_clear_errors();
										$pokemon_xpath = new DOMXPath($pokemon_doc);
										for($i = 0; $i < count($names); $i++){
											$pokemon_row = $pokemon_xpath->query('//tr[td/a[@id="' . $names[$i] . '"]]');
											if($pokemon_row->length > 0){
												// Get each tr
												foreach($pokemon_row as $row){
													// Get each td in the tr group
													$tds = $row->childNodes;
													$j = 0;
													foreach($tds as $td){
														// Filter out empty nodes
														if(trim($td->nodeValue, " \n\r\t\0\xC2\xA0") !== "") {
															$contributors[$i][$j] = $td->nodeValue;
															$j++;
														}
													}
												}
											}
										}
									}
									//sorting based on the points
									usort($contributors, function($a, $b) {
										return $a[0] - $b[0];
									});
									//checking whether the total number contributors is odd or even.
									//if odd left side will contain one set of extra data than the right one
									$x = count($contributors);
									$y = 0;
									if ($x % 2 == 0) {
										$y = ($x / 2);
									} else if ($x % 2 == 1) {
										$x--;
										$y = (($x / 2) + 1);
									}
									//printing left side
									for($i = 0; $i < $y; $i++){
										echo '<tr><td>' . ($i+1) . '.</td><td>' . $contributors[$i][0] . '</td><td><a id="' . trim($contributors[$i][1]) . '" href="#' . trim($contributors[$i][1]) . '">' . trim($contributors[$i][1]) . '</a></td><td class="text-right">' . $contributors[$i][2] . '</td></tr>';
									}
								?>
							</tbody>
						</table>
					</section>
					<section id="mls-users-right">
						<table class="table">
							<thead>
								<tr>
									<th>SL.</th>
									<th>Rank</th>
									<th>User</th>
									<th class="text-right">Points</th>
								</tr>
							</thead>
							<tbody>
								<?php
									//printing right side
									for($i = $y; $i < count($contributors); $i++){
										echo '<tr><td>' . ($i+1) . '.</td><td>' . $contributors[$i][0] . '</td><td><a id="' . trim($contributors[$i][1]) . '" href="#' . trim($contributors[$i][1]) . '">' . trim($contributors[$i][1]) . '</a></td><td class="text-right">' . $contributors[$i][2] . '</td></tr>';
									}
								?>
							</tbody>
						</table>
					</section>
					<div style="clear:both;"></div>
                </div>


            </div><!-- close #wrapper -->

            <footer id="colophon" class="">
                <div class="row">

                    <div class="footer-logo">
                        <!-- <a href="/"><img src="img/sandstone/footer-mozilla.png" alt="mozilla"> <span class="footer-logo-india">India</span></a> -->
                        <p>Have feedback? <a href="https://github.com/mozillabd/homepage/issues">File a bug</a>.
                    </div>

                    <div class="footer-license">
                        <p>
                        </p>
                    </div>
                    <ul class="footer-nav">
                        <li><a href="http://www.mozilla.org/about/">About</a></li>
                        <li><a href="http://www.mozilla.org/mission/">Mission</a></li>
                        <li><a href="http://mozillabd.org/blog">Blog</a></li>
                    </ul>
                    <ul class="footer-nav">
                        <li><a href="https://twitter.com/MozillaBD">Twitter</a></li>
                        <li><a href="https://www.facebook.com/groups/MozillaBD/">Facebook</a></li>
			<li><a href="https://plus.google.com/115718360403139005127/">Google+</a></li>
                    </ul>

                </div>
            </footer>

        </div><!-- close #outer-wrapper -->

        <!--[if IE 9]>
        <script src="js/libs/matchMedia.js"></script>
        <![endif]-->


        <script src="js/base/nav-main-resp.js"></script>
        <script src="js/mozorg-resp-min.js"></script>
        <script src="js/tabzilla/tabzilla.js"></script>
        <script src="js/mozbd/feedreader.js"></script>
    </body>
</html>
