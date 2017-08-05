<?php
//SubCategory.php
namespace MyClasses;

/**
 * SubCategory Class retrieves data info for an individual Category
 * 
 * The constructor an instance of the SubCategory class and creates a related method to create news feed pages based on each SubCategory object
 * 
 * A SubCategory object (an instance of the SubCategory class) can be created in this manner:
 *
 * <code>
 * $mySubCategory = new MyClasses\SubCategory(1);
 * </code>
 *
 * In which one is the number of a valid SubCategory in the database. 
 *
 * The forward slash in front of IDB picks up the global namespace, which is required 
 * now that we're here inside the MyClasses namespace: \IDB::conn()
 *
 * The showFeed() method of the SubCategory object created will create a news feed based on the object
 *
 * @see Category
 * @todo none
 */
 
class SubCategory
{
	public $SubCategoryID = 0;
	public $Title = "";
	public $Description = "";
	public $isValid = FALSE;
	 	
	/**
	 * Constructor for Category class. 
	 *
	 * @param integer $id The unique ID number of the Category
	 * @return void 
	 * @todo none
	 */ 
    
    function __construct($id)
	{
		//Creates SubCategoryID property
		$this->SubCategoryID = (int)$id;
		
		//sql statement stored in var
		$sql = sprintf("SELECT SubCategory, Description FROM " . PREFIX . "SubCategories WHERE SubCategoryID = %d", $this->SubCategoryID);
		
		//records stored in var
		$result = mysqli_query(\IDB::conn(),$sql) or die(trigger_error(mysqli_error(\IDB::conn()), E_USER_ERROR));

		//if records exist, create Title and Description properties
		if (mysqli_num_rows($result) > 0){
			$this->isValid = TRUE;
			while ($row = mysqli_fetch_assoc($result)){
			     $this->Title = dbOut($row['SubCategory']);
			     $this->Description = dbOut($row['Description']);
			} #end while
		} #end if

		//clear results
		@mysqli_free_result($result);
				
	} #end SubCategory constructor

	//function to create news feed based off of Title property
	function showFeed()
	{
		//Process Title property to generate url
		$category = $this->Title;
		$topic = str_replace(" ", "%20", $category);
		$request = "https://news.google.com/news/rss/search/section/q/$topic/$topic?hl=en&ned=us";
		$response = file_get_contents($request);
		$xml = simplexml_load_string($response);

		//Creates heading based off of title
		print '<h1>' . $xml->channel->title . '</h1>';

		//Loop through stories and print data
		foreach($xml->channel->item as $story) {
	    	echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
	    	echo '<p>' . $story->description . '</p><br /><br />';
	    } #end foreach
	} # end showFeed()
}# end SubCategory class