<?php
//read-feed-simpleXML.php
//our simplest example of consuming an RSS feed

  //$request = "https://news.google.com/news/rss/?ned=us&hl=en";
  //$request = "https://news.google.com/news/rss/headlines/section/topic/SPORTS?ned=us&hl=en";
  //$request = "https://news.google.com/news/rss/search/section/q/seahawks/seahawks?hl=en&ned=us";
  $request = "https://news.google.com/news/rss/search/section/q/ice%20cream/ice%20cream?hl=en&ned=us";
  $response = file_get_contents($request);
  $xml = simplexml_load_string($response);
  print '<h1>' . $xml->channel->title . '</h1>';
  foreach($xml->channel->item as $story)
  {
	  
    echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
    echo '<p>' . $story->description . '</p><br /><br />';
	 
	echo '<pre>';
	var_dump($story);
	echo '</pre>';
	
  }
?>