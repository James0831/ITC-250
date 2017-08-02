<?php
//feed.php
//our simplest example of consuming an RSS feed
class Feed
{
	 public $FeedID = 0;
	 public $Title = "";
	 public $Description = "";
	 public $isValid = FALSE;
	 	
	/**
	 * Constructor for Feed class. 
	 *
	 * @param integer $id The unique ID number of the Feed
	 * @return void 
	 * @todo none
	 */ 
	
    function __construct($id)
	{
		$this->FeedID = (int)$id;
		if($this->FeedID == 0){return FALSE;}
		
		#get Feed data from DB
		$sql = sprintf("SELECT SubCategory, Description FROM " . PREFIX . "SubCategories WHERE SubCategoryID =%d",$this->FeedID);
		
		#in mysqli, connection and query are reversed!  connection comes first
		$result = mysqli_query(\IDB::conn(),$sql) or die(trigger_error(mysqli_error(\IDB::conn()), E_USER_ERROR));

		if (mysqli_num_rows($result) > 0)
		{#Must be a valid Feed!
			$this->isValid = TRUE;
			while ($row = mysqli_fetch_assoc($result))
			{#dbOut() function is a 'wrapper' designed to strip slashes, etc. of data leaving db
			     $this->Title = dbOut($row['SubCategory']);
			     $this->Description = dbOut($row['Description']);
			}
		}
		@mysqli_free_result($result); #free resources
		
		if(!$this->isValid){return;}  #exit, as Feed is not valid
		
	}# end Feed() constructor
	
}# end Feed class

require '../inc_0700/config_inc.php'; 

if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails

} else {
	myRedirect(VIRTUAL_PATH . "p3/index.php");
}

//Creates Feed object
$myFeed = new Feed($myID);

if($myFeed->isValid) {
	$config->titleTag = "'" . $myFeed->Title . "' Feed!";
} else {
	$config->titleTag = smartTitle(); //use constant 
}

get_header();

if($myFeed->isValid) {
$category = $myFeed->Title;
$topic = str_replace(" ", "%20", $category);
	$request = "https://news.google.com/news/rss/search/section/q/$topic/$topic?hl=en&ned=us";
	$response = file_get_contents($request);
	$xml = simplexml_load_string($response);
	print '<h1>' . $xml->channel->title . '</h1>';
	foreach($xml->channel->item as $story)
	{
    	echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
    	echo '<p>' . $story->description . '</p><br /><br />';
    }
} else {
	echo "Sorry, no such feed!";	
}

get_footer();